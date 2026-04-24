@extends('layouts.app')

@section('title', 'Order Book - Book Sale Platform')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Order Your Book</h1>

        <form x-data="orderForm()" @submit.prevent="submitOrder" class="space-y-6">
            <!-- Honeypot field -->
            <input type="text" name="contact_time" x-model="form.contact_time" class="hidden" tabindex="-1" autocomplete="off">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px; color: #1d1d1f;">Full Name *</label>
                    <input type="text"
                           x-model="form.name"
                           required
                           style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px; border: 1px solid #d2d2d7; border-radius: 8px; padding: 12px 16px; background-color: #ffffff; color: #1d1d1f; outline: none;"
                           class="w-full focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <div x-show="errors.name" class="text-red-500 text-sm mt-1" x-text="errors.name"></div>
                </div>

                <div>
                    <label for="phone" class="block mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px; color: #1d1d1f;">Phone Number *</label>
                    <input type="tel"
                           x-model="form.phone"
                           required
                           style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px; border: 1px solid #d2d2d7; border-radius: 8px; padding: 12px 16px; background-color: #ffffff; color: #1d1d1f; outline: none;"
                           class="w-full focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <div x-show="errors.phone" class="text-red-500 text-sm mt-1" x-text="errors.phone"></div>
                </div>
            </div>

            <div>
                <label for="email" class="block mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px; color: #1d1d1f;">Email Address</label>
                <input type="email"
                       x-model="form.email"
                       style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px; border: 1px solid #d2d2d7; border-radius: 8px; padding: 12px 16px; background-color: #ffffff; color: #1d1d1f; outline: none;"
                       class="w-full focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                <div x-show="errors.email" class="text-red-500 text-sm mt-1" x-text="errors.email"></div>
            </div>

            <div>
                <label for="address" class="block mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px; color: #1d1d1f;">Delivery Address *</label>
                <textarea x-model="form.address"
                          required
                          rows="3"
                          placeholder="Enter your full delivery address for book shipping"
                          style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px; border: 1px solid #d2d2d7; border-radius: 8px; padding: 12px 16px; background-color: #ffffff; color: #1d1d1f; outline: none;"
                          class="w-full focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></textarea>
                <div x-show="errors.address" class="text-red-500 text-sm mt-1" x-text="errors.address"></div>
            </div>

            <div>
                <label for="note" class="block mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px; color: #1d1d1f;">Additional Notes</label>
                <textarea x-model="form.note"
                          rows="3"
                          style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 17px; font-weight: 400; line-height: 1.47; letter-spacing: -0.374px; border: 1px solid #d2d2d7; border-radius: 8px; padding: 12px 16px; background-color: #ffffff; color: #1d1d1f; outline: none;"
                          class="w-full focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></textarea>
                <div x-show="errors.note" class="text-red-500 text-sm mt-1" x-text="errors.note"></div>
            </div>

            <div>
                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                    Payment Proof Image * (Max 5MB)
                </label>
                <input type="file"
                       id="payment_proof"
                       name="payment_proof"
                       x-model="form.payment_proof"
                       @change="handleFileSelect($event)"
                       accept="image/*"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div x-show="errors.payment_proof" class="text-red-500 text-sm mt-1" x-text="errors.payment_proof"></div>
                <div x-show="selectedFile" class="text-sm text-gray-600 mt-1">
                    Selected: <span x-text="selectedFile"></span>
                </div>
            </div>


            <div class="flex items-center justify-between">
                <button type="submit"
                        :disabled="submitting"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                    <span x-show="!submitting">Submit Order</span>
                    <span x-show="submitting">Processing...</span>
                </button>

                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Success Modal -->
<div x-data="{ show: false, orderData: null }"
     x-show="show"
     @order-success.window="show = true; orderData = $event.detail"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full" @click.away="show = false">
        <h2 class="text-xl font-bold text-green-600 mb-4">Order Submitted Successfully!</h2>
        <div class="space-y-3">
            <p>Your order has been received and is pending verification.</p>
            <div class="bg-gray-50 p-3 rounded">
                <p class="text-sm text-gray-600">Receipt Code:</p>
                <p class="font-mono font-bold text-lg" x-text="orderData?.receipt_code"></p>
            </div>
            <div class="space-y-2">
                <a :href="orderData?.magic_link"
                   class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    View Order Status
                </a>
                <button @click="show = false"
                        class="block w-full px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function orderForm() {
    return {
        form: {
            name: '',
            phone: '',
            email: '',
            address: '',
            note: '',
            payment_proof: '',
            contact_time: '' // Honeypot
        },
        errors: {},
        submitting: false,
        selectedFile: null,

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.selectedFile = file.name;
                this.form.payment_proof = file;
            } else {
                this.selectedFile = null;
                this.form.payment_proof = '';
            }
        },

        async submitOrder() {
            this.submitting = true;
            this.errors = {};

            const formData = new FormData();
            Object.keys(this.form).forEach(key => {
                if (this.form[key] !== null && this.form[key] !== '') {
                    formData.append(key, this.form[key]);
                }
            });

            try {
                const response = await fetch('/orders', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return;
                    }
                    
                    window.dispatchEvent(new CustomEvent('order-success', { detail: data }));
                    this.form = {
                        name: '',
                        phone: '',
                        email: '',
                        note: '',
                        payment_proof: '',
                        contact_time: ''
                    };
                    this.selectedFile = null;
                    document.getElementById('payment_proof').value = '';
                } else {
                    if (data.errors) {
                        this.errors = data.errors;
                    } else {
                        this.errors.general = data.error || 'Submission failed';
                    }
                }
            } catch (error) {
                this.errors.general = 'Network error. Please try again.';
            } finally {
                this.submitting = false;
            }
        }
    }
}
</script>
@endsection
