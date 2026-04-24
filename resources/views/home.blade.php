@extends('layouts.app')

@section('title', 'Book Sale Platform')

@section('content')
<div class="min-h-screen" style="background-color: #f5f5f7;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold mb-6" style="font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 56px; font-weight: 600; line-height: 1.07; letter-spacing: -0.28px; color: #000000;">
                Welcome to EiBook Sale Platform
            </h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px; color: #6e6e73;">
                Purchase and download digital books securely. Get instant access to your purchases with our streamlined platform.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('order.create') }}" class="inline-flex items-center px-8 py-3 text-base font-medium rounded-lg text-white transition-colors" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #0071e3; border-radius: 56px; font-size: 17px; font-weight: 600; line-height: 1.24; letter-spacing: -0.374px;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Order
                </a>
                <a href="{{ route('order.check') }}" class="inline-flex items-center px-8 py-3 text-base font-medium rounded-lg transition-colors" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #ffffff; border: 2px solid #d2d2d7; border-radius: 56px; color: #1d1d1f; font-size: 17px; font-weight: 600; line-height: 1.24; letter-spacing: -0.374px;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Check Order Status
                </a>
            </div>
        </div>

          <!-- Promotion Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 mb-12 shadow-lg">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold mb-4" style="color: #1d1d1f; font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    🎉 အထူးပရိုမိုးရှင်း
                </h2>
                <p class="text-lg" style="color: #6e6e73; font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    မေလ ၁၅ရက်အထိ ကြိုတင်မှာယူပရိုမိုးရှင်း
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-xl font-semibold mb-3" style="color: #0071e3;">
                        ရန်ကုန်​မြေပုံအုပ်
                    </h3>
                    <p class="text-2xl font-bold mb-2" style="color: #1d1d1f;">
                        တစ်အုပ်ချင်း ၃၅,၀၀၀ ကျပ်
                    </p>
                    <p class="text-gray-600">
                        ရန်ကုန်မြို့တော်ဝင်မြေပုံအုပ်ကို တစ်အုပ်ချင်းဈေးနှုန်းဖြင့် ရယူနိုင်ပါသည်
                    </p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-xl font-semibold mb-3" style="color: #0071e3;">
                        မန္တလေးစာအုပ်
                    </h3>
                    <p class="text-2xl font-bold mb-2" style="color: #1d1d1f;">
                        တစ်အုပ်ချင်း ၃၅,၀၀၀ ကျပ်
                    </p>
                    <p class="text-gray-600">
                        မန္တလေးမြို့တော်ဝင်စာအုပ်ကို တစ်အုပ်ချင်းဈေးနှုန်းဖြင့် ရယူနိုင်ပါသည်
                    </p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-400 to-orange-400 rounded-xl p-6 text-center text-white">
                <h3 class="text-2xl font-bold mb-2">
                    🔥 အထူးပရိုမိုးရှင်းဈေး
                </h3>
                <p class="text-3xl font-bold mb-3">
                    ၂အုပ်တွဲယူမယ်ဆိုရင် ၄၀,၀၀၀ ကျပ်သာ!
                </p>
                <p class="text-lg mb-4">
                    မေလ ၁၅ရက်နေ့အထိ ပရိုမိုးရှင်းပေးနေပါသည်
                </p>
                <a href="{{ route('order.create') }}" class="inline-block px-8 py-4 bg-white text-orange-500 font-bold rounded-full hover:bg-gray-100 transition-colors text-lg">
                    အခုပဲ မှာယူရန် →
                </a>
            </div>
        </div>

         {{-- <div x-data="bookStatus()" x-init="loadStatus()">
            <div x-show="loading" class="text-gray-500">
                Loading...
            </div>

            <div x-show="!loading" class="space-y-6">
                <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
                    <h2 class="text-lg font-semibold mb-4">Book Status</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Orders Open:</span>
                            <span x-text="orderOpen ? 'Yes' : 'No'"
                                  :class="orderOpen ? 'text-green-600' : 'text-red-600'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Book Published:</span>
                            <span x-text="bookPublished ? 'Yes' : 'No'"
                                  :class="bookPublished ? 'text-green-600' : 'text-red-600'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>PDF Available:</span>
                            <span x-text="pdfAvailable ? 'Yes' : 'No'"
                                  :class="pdfAvailable ? 'text-green-600' : 'text-gray-600'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>EPUB Available:</span>
                            <span x-text="epubAvailable ? 'Yes' : 'No'"
                                  :class="epubAvailable ? 'text-green-600' : 'text-gray-600'"></span>
                        </div>
                    </div>
                </div>

                <div class="space-x-4">
                    <a href="{{ route('order.create') }}"
                       :class="orderOpen ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed'"
                       class="inline-block px-6 py-3 text-white font-semibold rounded-lg transition-colors"
                       :disabled="!orderOpen">
                        Order Now
                    </a>
                    <a href="{{ route('order.check') }}"
                       class="inline-block px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors">
                        Check Order Status
                    </a>
                </div>
            </div>
        </div> --}}
        <br>




    </div>
</div>

<script>
function bookStatus() {
    return {
        loading: true,
        orderOpen: false,
        bookPublished: false,
        pdfAvailable: false,
        epubAvailable: false,

        async loadStatus() {
            try {
                const response = await fetch('/api/settings/book-status');
                const data = await response.json();
                this.orderOpen = data.orderOpen;
                this.bookPublished = data.bookPublished;
                this.pdfAvailable = data.pdfAvailable;
                this.epubAvailable = data.epubAvailable;
            } catch (error) {
                console.error('Failed to load book status:', error);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
