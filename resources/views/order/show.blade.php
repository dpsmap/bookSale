@extends('layouts.app')

@section('title', 'Order Status - Book Sale Platform')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Order Status</h1>
        
        <div class="space-y-6">
            <!-- Order Information -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Order Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Receipt Code</p>
                        <p class="font-mono font-bold text-lg">{{ $order->receipt_code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'verified') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-semibold">{{ $order->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-semibold">{{ $order->phone }}</p>
                    </div>
                    @if($order->email)
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold">{{ $order->email }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-600">Order Date</p>
                        <p class="font-semibold">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
                
                @if($order->note)
                <div class="mt-4">
                    <p class="text-sm text-gray-600">Additional Notes</p>
                    <p class="mt-1">{{ $order->note }}</p>
                </div>
                @endif
            </div>
            
            <!-- Status Messages -->
            <div class="border-b pb-6">
                <h2 class="text-lg font-semibold mb-4">Status Information</h2>
                @if($order->isPending())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800">
                            <strong>Pending Verification:</strong> Your payment proof is being reviewed by our team.
                            You will be able to download the book once your order is verified.
                        </p>
                    </div>
                @elseif($order->isVerified())
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-green-800">
                            <strong>Order Verified:</strong> Your payment has been confirmed. 
                            You can now download your book below.
                        </p>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-800">
                            <strong>Order Rejected:</strong> Your payment proof could not be verified.
                            Please contact support if you believe this is an error.
                        </p>
                    </div>
                @endif
            </div>
            
            <!-- Downloads Section -->
            <div>
                <h2 class="text-lg font-semibold mb-4">Downloads</h2>
                
                @if(!$order->canDownload() || !$settings->isBookPublished())
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-gray-600">
                            Downloads are not available yet. 
                            @if(!$order->canDownload())
                                Your order must be verified first.
                            @endif
                            @if(!$settings->isBookPublished())
                                The book has not been published yet.
                            @endif
                        </p>
                    </div>
                @else
                    <div class="space-y-3">
                        @if($settings->hasPdfFile())
                        <a href="{{ route('order.download', [$order->receipt_code, 'pdf']) }}" 
                           class="flex items-center justify-between w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download PDF
                            </span>
                            <span class="text-sm">{{ $settings->pdf_filename ?? 'book.pdf' }}</span>
                        </a>
                        @endif
                        
                        @if($settings->hasEpubFile())
                        <a href="{{ route('order.download', [$order->receipt_code, 'epub']) }}" 
                           class="flex items-center justify-between w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download EPUB
                            </span>
                            <span class="text-sm">{{ $settings->epub_filename ?? 'book.epub' }}</span>
                        </a>
                        @endif
                        
                        <p class="text-sm text-gray-500 text-center">
                            Download count: {{ $order->download_count }}
                        </p>
                    </div>
                @endif
            </div>
            
            <!-- Actions -->
            <div class="flex justify-between items-center pt-4 border-t">
                <div class="text-sm text-gray-600">
                    Magic Link: <span class="font-mono text-xs">{{ route('order.magic', ['token' => $order->magic_token]) }}</span>
                </div>
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
