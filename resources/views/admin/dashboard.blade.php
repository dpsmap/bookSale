@extends('layouts.app')

@section('title', 'Admin Dashboard - Book Sale Platform')

@section('content')
<div x-data="adminDashboard()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
        <div class="space-x-4">
            <a href="{{ route('admin.settings') }}" class="text-blue-600 hover:text-blue-800">
                Settings
            </a>
            <button @click="logout()" class="text-red-600 hover:text-red-800">
                Logout
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6" style="border-radius: 16px;">
            <h3 class="text-sm font-medium text-gray-600 mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px;">Total Orders</h3>
            <p class="text-3xl font-semibold text-black" style="font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-weight: 600; letter-spacing: -0.144px; line-height: 1.08;">{{ $orders->total() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6" style="border-radius: 16px;">
            <h3 class="text-sm font-medium text-gray-600 mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px;">Pending</h3>
            <p class="text-3xl font-semibold" style="font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-weight: 600; letter-spacing: -0.144px; line-height: 1.08; color: #1d1d1f;">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6" style="border-radius: 16px;">
            <h3 class="text-sm font-medium text-gray-600 mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px;">Verified</h3>
            <p class="text-3xl font-semibold" style="font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-weight: 600; letter-spacing: -0.144px; line-height: 1.08; color: #1d1d1f;">{{ \App\Models\Order::where('status', 'verified')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6" style="border-radius: 16px;">
            <h3 class="text-sm font-medium text-gray-600 mb-2" style="font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; font-weight: 600; line-height: 1.29; letter-spacing: -0.224px;">Unread</h3>
            <p class="text-3xl font-semibold text-black" style="font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-weight: 600; letter-spacing: -0.144px; line-height: 1.08;">{{ $unreadCount }}</p>
        </div>
    </div>

        <!-- Filters -->
        {{-- <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select x-model="filters.status" @change="loadOrders"
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="verified">Verified</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text"
                           x-model="filters.search"
                           @keyup.enter="loadOrders"
                           placeholder="Name, phone, email, or code..."
                           class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button @click="loadOrders"
                        :disabled="loading"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:bg-gray-400">
                    <span x-show="!loading">Search</span>
                    <span x-show="loading">Loading...</span>
                </button>
            </div>
        </div> --}}

        <!-- Orders Table with DataTables -->
        <div class="bg-white rounded-lg shadow overflow-hidden p-4">
            <table id="ordersTable" class="display hover:stripe" style="width:100%">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th> --}}
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr data-order-id="{{ $order->id }}" class="{{ !$order->is_read_by_admin ? 'bg-blue-50' : '' }}">
                        <td>
                            <div class="text-sm font-medium text-gray-900">{{ $order->id }}</div>
                        </td>
                        <td>
                            <div class="text-sm font-medium text-gray-900">{{ $order->receipt_code }}</div>
                            <div class="text-sm text-gray-500">{{ $order->phone }}</div>
                            @if($order->email)
                            <div class="text-sm text-gray-500">{{ $order->email }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="text-sm text-gray-900">{{ $order->name }}</div>
                            @if($order->note)
                            <div class="text-sm text-gray-500">{{ $order->note }}</div>
                            @endif
                        </td>
                        <td>
                            <select class="status-select px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    data-order-id="{{ $order->id }}">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified" {{ $order->status == 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="rejected" {{ $order->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </td>
                        <td>
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                <br>
                                {{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}
                            </div>
                        </td>
                        <td>
                            <div class="text-sm font-medium space-x-2">
                                @if(!$order->is_read_by_admin)
                                <button class="mark-read-btn text-blue-600 hover:text-blue-900" data-order-id="{{ $order->id }}">
                                    Mark Read
                                </button>
                                @endif
                                <button class="view-order-btn text-green-600 hover:text-green-900" data-receipt-code="{{ $order->receipt_code }}">
                                    View
                                </button>
                                <button class="delete-order-btn text-red-600 hover:text-red-900" data-order-id="{{ $order->id }}">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* DataTables Enhanced Styling */
#ordersTable {
    border-collapse: separate;
    border-spacing: 0;
}

#ordersTable thead th {
    border-bottom: 2px solid #e5e7eb !important;
    background-color: #f9fafb !important;
    font-weight: 600;
    color: #374151 !important;
}

#ordersTable tbody tr {
    transition: all 0.2s ease-in-out;
}

#ordersTable tbody tr:hover {
    background-color: #f3f4f6 !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

#ordersTable tbody tr:nth-child(even) {
    background-color: #fafafa;
}

#ordersTable tbody tr:nth-child(even):hover {
    background-color: #f3f4f6 !important;
}

#ordersTable tbody td {
    border-bottom: 1px solid #f3f4f6 !important;
    padding: 12px 16px !important;
    vertical-align: middle;
}

#ordersTable .dataTables_info {
    color: #6b7280 !important;
    font-size: 0.875rem;
}

.dataTables_wrapper .dataTables_filter {
    margin-bottom: 1rem;
}

.dataTables_wrapper .dataTables_length {
    margin-bottom: 1rem;
}

.dataTables_wrapper .dataTables_paginate {
    margin-top: 1rem;
}

/* Enhanced pagination */
.dataTables_paginate .paginate_button {
    border-radius: 0.375rem !important;
    transition: all 0.2s ease-in-out !important;
}

.dataTables_paginate .paginate_button:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
    border-color: #3b82f6 !important;
}

/* Status select enhancement */
.status-select {
    transition: all 0.2s ease-in-out;
}

.status-select:hover {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Action buttons */
.mark-read-btn, .view-order-btn, .delete-order-btn {
    transition: all 0.2s ease-in-out;
    padding: 4px 8px;
    border-radius: 4px;
}

.mark-read-btn:hover, .view-order-btn:hover, .delete-order-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Unread order highlight */
.bg-blue-50 {
    background-color: #eff6ff !important;
    border-left: 4px solid #3b82f6;
}

/* Search and length controls styling */
.dataTables_filter input:focus,
.dataTables_length select:focus {
    outline: none;
    ring: 2px;
    ring-color: #3b82f6;
    border-color: #3b82f6;
}
</style>

<script>
// Initialize DataTables
$(document).ready(function() {
    var table = $('#ordersTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[3, 'desc']], // Sort by date column by default
        dom: '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
        language: {
            search: "Search orders:",
            lengthMenu: "Show _MENU_ orders per page",
            info: "Showing _START_ to _END_ of _TOTAL_ orders",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        initComplete: function() {
            // Style the search input
            $('.dataTables_filter input').addClass('px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500');
            $('.dataTables_filter input').attr('placeholder', 'Search orders...');

            // Style the length select
            $('.dataTables_length select').addClass('px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500');

            // Style the pagination buttons
            $('.dataTables_paginate .paginate_button').addClass('px-3 py-2 mx-1 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500');
            $('.dataTables_paginate .paginate_button.current').addClass('bg-blue-600 text-white border-blue-600 hover:bg-blue-700');
            $('.dataTables_paginate .paginate_button.disabled').addClass('opacity-50 cursor-not-allowed');

            // Style the info display
            $('.dataTables_info').addClass('text-sm text-gray-600');
        }
    });

    // Status change handler
    $(document).on('change', '.status-select', function() {
        var orderId = $(this).data('order-id');
        var newStatus = $(this).val();
        updateOrderStatus(orderId, newStatus);
    });

    // Mark as read handler
    $(document).on('click', '.mark-read-btn', function() {
        var orderId = $(this).data('order-id');
        markOrderAsRead(orderId);
    });

    // View order handler
    $(document).on('click', '.view-order-btn', function() {
        var receiptCode = $(this).data('receipt-code');
        window.open('/order/' + receiptCode, '_blank');
    });

    // Delete order handler
    $(document).on('click', '.delete-order-btn', function() {
        var orderId = $(this).data('order-id');
        if (confirm('Are you sure you want to delete this order?')) {
            deleteOrder(orderId);
        }
    });
});

// API functions
function updateOrderStatus(orderId, newStatus) {
    console.log('Updating status for order:', orderId, 'to:', newStatus);

    fetch(`/api/admin/orders/${orderId}`, {
        method: 'PATCH',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (response.ok) {
            location.reload(); // Reload to see updated stats
        } else {
            response.text().then(text => {
                console.error('Error response:', text);
                alert('Failed to update status: ' + text);
            });
        }
    })
    .catch(error => {
        console.error('Error updating status:', error);
        alert('Failed to update status: ' + error.message);
    });
}

function markOrderAsRead(orderId) {
    fetch(`/api/admin/orders/${orderId}/read`, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            location.reload(); // Reload to see updated stats
        } else {
            alert('Failed to mark as read');
        }
    })
    .catch(error => {
        console.error('Error marking as read:', error);
        alert('Failed to mark as read');
    });
}

function deleteOrder(orderId) {
    fetch(`/api/admin/orders/${orderId}`, {
        method: 'DELETE',
        credentials: 'same-origin',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            location.reload(); // Reload to see updated table
        } else {
            alert('Failed to delete order');
        }
    })
    .catch(error => {
        console.error('Error deleting order:', error);
        alert('Failed to delete order');
    });
}

// Alpine.js for stats and filters
function adminDashboard() {
    return {
        loading: false,
        stats: {
            total_orders: {{ $orders->total() }},
            pending_orders: {{ $orders->where('status', 'pending')->count() }},
            verified_orders: {{ $orders->where('status', 'verified')->count() }},
            rejected_orders: {{ $orders->where('status', 'rejected')->count() }},
            unread_orders: {{ $orders->where('is_read_by_admin', false)->count() }}
        },

        init() {
            this.loadStats();
        },

        async loadStats() {
            try {
                const response = await fetch('/api/admin/stats', {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    this.stats = await response.json();
                }
            } catch (error) {
                console.error('Failed to load stats:', error);
            }
        },

        async logout() {
            try {
                await fetch('/api/admin/logout', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            } catch (error) {
                console.error('Logout error:', error);
            }

            window.location.href = '/admin/login';
        }
    }
}
</script>
@endsection
