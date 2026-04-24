<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{
    private $adminTokens = [];

    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator);
        }

        $username = config('app.admin_username', 'admin');
        $password = config('app.admin_password', 'admin123');

        if ($request->username === $username && $request->password === $password) {
            $minutes = 120;
            $cookie = cookie('admin_authenticated', 'true', $minutes);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful'
                ])->cookie($cookie);
            }
            // dd('here');
            return redirect()->route('admin.dashboard')->cookie($cookie);
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function checkAuth(Request $request)
    {
        return $request->cookie('admin_authenticated') === 'true';
    }

    public function logout(Request $request)
    {
        $cookie = Cookie::forget('admin_authenticated');

        $token = $request->header('Authorization');
        if ($token && str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);
            $this->adminTokens = array_filter($this->adminTokens, fn($t) => $t !== $token);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Logged out successfully'])->withCookie($cookie);
        }

        return redirect()->route('admin.login')->withCookie($cookie);
    }

    public function dashboard(Request $request)
    {
        if ($request->cookie('admin_authenticated') !== 'true') {
            return redirect()->route('admin.login');
        }

        $orders = Order::orderBy('created_at', 'desc')->paginate(20);
        // dd($orders);
        $unreadCount = Order::where('is_read_by_admin', false)->count();

        return view('admin.dashboard', compact('orders', 'unreadCount'));
    }

    public function orders(Request $request)
    {
        if ($request->cookie('admin_authenticated') !== 'true') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = Order::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('receipt_code', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($orders);
    }

    public function updateOrder(Request $request, Order $order)
    {
        if ($request->cookie('admin_authenticated') !== 'true') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,verified,rejected',
            'is_read_by_admin' => 'boolean',
            'name' => 'string|max:255',
            'phone' => 'string|max:20',
            'email' => 'nullable|email|max:255',
            'note' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order->update($request->all());

        return response()->json([
            'success' => true,
            'order' => $order,
            'message' => 'Order updated successfully'
        ]);
    }

    public function markAsRead(Order $order)
    {
        $order->update(['is_read_by_admin' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Order marked as read'
        ]);
    }

    public function deleteOrder(Request $request, Order $order)
    {
        if ($request->cookie('admin_authenticated') !== 'true') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($order->payment_proof_path) {
            Storage::disk('public')->delete($order->payment_proof_path);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }

    public function stats(Request $request)
    {
        if ($request->cookie('admin_authenticated') !== 'true') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'verified_orders' => Order::where('status', 'verified')->count(),
            'rejected_orders' => Order::where('status', 'rejected')->count(),
            'unread_orders' => Order::where('is_read_by_admin', false)->count(),
        ];

        return response()->json($stats);
    }

    private function isValidToken(Request $request): bool
    {
        $token = $request->header('Authorization');
        if (!$token || !str_starts_with($token, 'Bearer ')) {
            return false;
        }

        $token = substr($token, 7);
        return in_array($token, $this->adminTokens);
    }
}
