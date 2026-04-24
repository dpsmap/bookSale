<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function bookStatus()
    {
        $settings = Setting::getSettings();

        return response()->json([
            'orderOpen' => $settings->isOrderOpen(),
            'bookPublished' => $settings->isBookPublished(),
            'pdfAvailable' => $settings->hasPdfFile(),
            'epubAvailable' => $settings->hasEpubFile(),
        ]);
    }

    public function index(Request $request)
    {
        if (!$request->session()->get('admin_authenticated')) {
            return redirect()->route('admin.login');
        }

        $settings = Setting::getSettings();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::getSettings();

        $validator = Validator::make($request->all(), [
            'order_open' => 'boolean',
            'book_published' => 'boolean',
            'pdf_file_key' => 'nullable|string|max:255',
            'epub_file_key' => 'nullable|string|max:255',
            'pdf_filename' => 'nullable|string|max:255',
            'epub_filename' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Validate file keys format (prevent directory traversal)
        if ($request->filled('pdf_file_key')) {
            $pdfKey = $request->pdf_file_key;
            if (str_contains($pdfKey, '..') || str_starts_with($pdfKey, '/')) {
                return response()->json(['error' => 'Invalid PDF file key format'], 422);
            }
        }

        if ($request->filled('epub_file_key')) {
            $epubKey = $request->epub_file_key;
            if (str_contains($epubKey, '..') || str_starts_with($epubKey, '/')) {
                return response()->json(['error' => 'Invalid EPUB file key format'], 422);
            }
        }

        $settings->update([
            'order_open' => $request->has('order_open'),
            'book_published' => $request->has('book_published'),
            'pdf_file_key' => $request->pdf_file_key,
            'epub_file_key' => $request->epub_file_key,
            'pdf_filename' => $request->pdf_filename,
            'epub_filename' => $request->epub_filename,
        ]);

        return response()->json([
            'success' => true,
            'settings' => $settings,
            'message' => 'Settings updated successfully'
        ]);
    }
}
