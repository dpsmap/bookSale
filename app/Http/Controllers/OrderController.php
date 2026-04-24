<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Services\OrderService;
use App\Mail\OrderVoucherMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function create()
    {
        $settings = Setting::getSettings();

        if (!$settings->isOrderOpen()) {
            return redirect()->route('home')->with('error', 'Orders are currently closed.');
        }

        return view('order.create');
    }

    public function store(Request $request)
    {
        $settings = Setting::getSettings();

        if (!$settings->isOrderOpen()) {
            return response()->json(['error' => 'Orders are currently closed.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:1000',
            'note' => 'nullable|string|max:1000',
            'payment_proof' => 'required|file|image|max:5120', // 5MB max
            'contact_time' => 'nullable', // Honeypot field
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Honeypot check - if filled, return fake success
        if ($request->filled('contact_time')) {
            $fakeCode = 'FAKE-' . strtoupper(substr(md5(time()), 0, 4));
            return response()->json([
                'success' => true,
                'receipt_code' => $fakeCode,
                'magic_link' => route('order.magic', ['token' => 'fake-token']),
                'message' => 'Order submitted successfully!'
            ], 201);
        }


        // Handle file upload and duplicate check
        $file = $request->file('payment_proof');
        $fileHash = OrderService::calculateFileHash($file);

        if (OrderService::isDuplicateFileHash($fileHash)) {
            return response()->json(['error' => 'This payment proof has already been used.'], 422);
        }

        // Store the file
        $dateFolder = now()->format('Y-m-d');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs("payment_proofs/{$dateFolder}", $filename, 'public');

        // Create order
        $order = Order::create([
            'receipt_code' => OrderService::generateReceiptCode(),
            'magic_token' => OrderService::generateMagicToken(),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'note' => $request->note,
            'payment_proof_path' => $path,
            'payment_proof_hash' => $fileHash,
            'status' => 'pending',
        ]);

        // Send voucher email if email is provided
        if ($order->email) {
            try {
                Mail::to($order->email)->send(new OrderVoucherMail($order));
            } catch (\Exception $e) {
                // Log error but don't fail the order creation
                \Log::error('Failed to send voucher email: ' . $e->getMessage());
            }
        }

        session()->flash('success', 'Order submitted successfully! Your receipt code is: ' . $order->receipt_code);

        return response()->json([
            'success' => true,
            'receipt_code' => $order->receipt_code,
            'magic_link' => route('order.magic', ['token' => $order->magic_token]),
            'redirect_url' => route('home'),
            'message' => 'Order submitted successfully!'
        ]);
    }

    public function showByCode($receiptCode)
    {
        $order = Order::where('receipt_code', $receiptCode)->firstOrFail();
        $settings = Setting::getSettings();

        return view('order.show', compact('order', 'settings'));
    }

    public function showByMagicToken($token)
    {
        $order = Order::where('magic_token', $token)->firstOrFail();
        $settings = Setting::getSettings();

        return view('order.show', compact('order', 'settings'));
    }

    public function checkOrder()
    {
        return view('order.check');
    }

    public function download($receiptCode, $format)
    {
        $order = Order::where('receipt_code', $receiptCode)->firstOrFail();
        $settings = Setting::getSettings();

        // Check eligibility
        if (!$order->canDownload() || !$settings->isBookPublished()) {
            abort(403, 'Download not available.');
        }

        // Check format availability
        if ($format === 'pdf' && !$settings->hasPdfFile()) {
            abort(404, 'PDF file not available.');
        }

        if ($format === 'epub' && !$settings->hasEpubFile()) {
            abort(404, 'EPUB file not available.');
        }

        // Increment download count
        $order->increment('download_count');

        // For now, we'll assume files are in private storage
        // In production, implement signed URLs or streaming
        $fileKey = $format === 'pdf' ? $settings->pdf_file_key : $settings->epub_file_key;
        $filename = $format === 'pdf' ? $settings->pdf_filename : $settings->epub_filename;

        if (!Storage::disk('private')->exists($fileKey)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('private')->download($fileKey, $filename);
    }

    public function downloadByMagicToken($token, $format)
    {
        $order = Order::where('magic_token', $token)->firstOrFail();
        return $this->download($order->receipt_code, $format);
    }

    public function stats()
    {
        $totalOrders = Order::count();
        return response()->json(['count' => $totalOrders]);
    }
}
