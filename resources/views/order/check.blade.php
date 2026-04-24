@extends('layouts.app')

@section('title', 'Check Order - Book Sale Platform')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Check Order Status</h1>
        
        <div x-data="orderCheck()">
            <form @submit.prevent="checkOrder" class="space-y-4">
                <div>
                    <label for="receiptCode" class="block text-sm font-medium text-gray-700 mb-2">
                        Enter Your Receipt Code
                    </label>
                    <input type="text" 
                           id="receiptCode" 
                           x-model="receiptCode"
                           placeholder="XXXX-XXXX"
                           maxlength="9"
                           @input="formatReceiptCode"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-center text-lg">
                    <p class="text-xs text-gray-500 mt-1">Enter the 8-character code from your order confirmation</p>
                </div>
                
                <button type="submit" 
                        :disabled="checking"
                        class="w-full px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                    <span x-show="!checking">Check Status</span>
                    <span x-show="checking">Checking...</span>
                </button>
            </form>
            
            <div x-show="error" x-transition class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-800" x-text="error"></p>
            </div>
            
            <div x-show="orderUrl" x-transition class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800 mb-2">Order found!</p>
                <a :href="orderUrl" 
                   class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    View Order Status
                </a>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Recent Orders</h3>
            <div x-data="recentOrders()" x-init="loadRecentOrders()">
                <div x-show="loading" class="text-gray-500 text-sm">Loading...</div>
                <div x-show="!loading && recentOrders.length === 0" class="text-gray-500 text-sm">
                    No recent orders found.
                </div>
                <div x-show="!loading && recentOrders.length > 0" class="space-y-2">
                    <template x-for="order in recentOrders" :key="order">
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                            <span class="font-mono text-sm" x-text="order"></span>
                            <a :href="`/order/${order}`" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                View
                            </a>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">
                Back to Home
            </a>
        </div>
    </div>
</div>

<script>
function orderCheck() {
    return {
        receiptCode: '',
        checking: false,
        error: null,
        orderUrl: null,
        
        formatReceiptCode() {
            let value = this.receiptCode.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (value.length >= 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 8);
            }
            this.receiptCode = value;
        },
        
        async checkOrder() {
            if (this.receiptCode.length !== 9) {
                this.error = 'Please enter a valid receipt code (XXXX-XXXX)';
                return;
            }
            
            this.checking = true;
            this.error = null;
            this.orderUrl = null;
            
            try {
                const response = await fetch(`/order/${this.receiptCode}`);
                
                if (response.ok) {
                    this.orderUrl = `/order/${this.receiptCode}`;
                    this.saveToRecent(this.receiptCode);
                } else if (response.status === 404) {
                    this.error = 'Order not found. Please check your receipt code.';
                } else {
                    this.error = 'An error occurred. Please try again.';
                }
            } catch (error) {
                this.error = 'Network error. Please try again.';
            } finally {
                this.checking = false;
            }
        },
        
        saveToRecent(code) {
            let recent = JSON.parse(localStorage.getItem('recentOrders') || '[]');
            recent = recent.filter(c => c !== code);
            recent.unshift(code);
            recent = recent.slice(0, 5); // Keep only 5 most recent
            localStorage.setItem('recentOrders', JSON.stringify(recent));
        }
    }
}

function recentOrders() {
    return {
        loading: false,
        recentOrders: [],
        
        loadRecentOrders() {
            this.recentOrders = JSON.parse(localStorage.getItem('recentOrders') || '[]');
        }
    }
}
</script>
@endsection
