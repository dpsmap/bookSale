@extends('layouts.app')

@section('title', 'Admin Settings - Book Sale Platform')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
        <div class="space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                Dashboard
            </a>
            <button @click="logout" class="text-red-600 hover:text-red-800">
                Logout
            </button>
        </div>
    </div>
    
    <div x-data="settingsForm()" x-init="loadSettings()">
        <form @submit.prevent="saveSettings" class="space-y-6">
            <!-- General Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">General Settings</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="order_open" 
                               x-model="settings.order_open"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="order_open" class="ml-2 block text-sm text-gray-900">
                            Allow New Orders
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="book_published" 
                               x-model="settings.book_published"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="book_published" class="ml-2 block text-sm text-gray-900">
                            Book Published (enables downloads for verified orders)
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- PDF Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">PDF File Settings</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="pdf_file_key" class="block text-sm font-medium text-gray-700 mb-2">
                            PDF File Key (Private Storage Path)
                        </label>
                        <input type="text" 
                               id="pdf_file_key" 
                               x-model="settings.pdf_file_key"
                               placeholder="books/my-book.pdf"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">
                            Path to PDF file in private storage (relative to storage/app/private/)
                        </p>
                    </div>
                    
                    <div>
                        <label for="pdf_filename" class="block text-sm font-medium text-gray-700 mb-2">
                            PDF Display Filename
                        </label>
                        <input type="text" 
                               id="pdf_filename" 
                               x-model="settings.pdf_filename"
                               placeholder="My-Book.pdf"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">
                            Filename that users will see when downloading
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- EPUB Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">EPUB File Settings</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="epub_file_key" class="block text-sm font-medium text-gray-700 mb-2">
                            EPUB File Key (Private Storage Path)
                        </label>
                        <input type="text" 
                               id="epub_file_key" 
                               x-model="settings.epub_file_key"
                               placeholder="books/my-book.epub"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">
                            Path to EPUB file in private storage (relative to storage/app/private/)
                        </p>
                    </div>
                    
                    <div>
                        <label for="epub_filename" class="block text-sm font-medium text-gray-700 mb-2">
                            EPUB Display Filename
                        </label>
                        <input type="text" 
                               id="epub_filename" 
                               x-model="settings.epub_filename"
                               placeholder="My-Book.epub"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">
                            Filename that users will see when downloading
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- File Upload Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">File Upload Instructions</h3>
                <div class="text-sm text-blue-700 space-y-2">
                    <p>• Upload book files to: <code class="bg-blue-100 px-1 rounded">storage/app/private/</code></p>
                    <p>• Use relative paths in the file key fields (e.g., "books/my-book.pdf")</p>
                    <p>• Never use absolute paths or "../" in file keys</p>
                    <p>• Files in private storage are not publicly accessible</p>
                    <p>• Downloads are only available for verified orders when book is published</p>
                </div>
            </div>
            
            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" 
                        :disabled="saving"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                    <span x-show="!saving">Save Settings</span>
                    <span x-show="saving">Saving...</span>
                </button>
            </div>
        </form>
        
        <!-- Success/Error Messages -->
        <div x-show="message" x-transition class="mt-4">
            <div :class="messageType === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800'" 
                 class="border rounded-lg p-4">
                <p x-text="message"></p>
            </div>
        </div>
    </div>
</div>

<script>
function settingsForm() {
    return {
        settings: {
            order_open: false,
            book_published: false,
            pdf_file_key: '',
            epub_file_key: '',
            pdf_filename: '',
            epub_filename: ''
        },
        saving: false,
        message: null,
        messageType: 'success',
        
        async loadSettings() {
            try {
                const response = await fetch('/api/settings/book-status');
                const data = await response.json();
                
                // Load detailed settings from admin endpoint
                const settingsResponse = await fetch('/admin/settings', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('adminToken')}`
                    }
                });
                
                if (settingsResponse.ok) {
                    const settingsData = await settingsResponse.text();
                    // Extract settings from the HTML view (simplified approach)
                    // In production, you'd want a dedicated API endpoint
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(settingsData, 'text/html');
                    
                    // For now, we'll use the public status data
                    this.settings.order_open = data.orderOpen;
                    this.settings.book_published = data.bookPublished;
                }
            } catch (error) {
                console.error('Failed to load settings:', error);
                this.showMessage('Failed to load settings', 'error');
            }
        },
        
        async saveSettings() {
            this.saving = true;
            this.message = null;
            
            try {
                const response = await fetch('/api/admin/settings', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('adminToken')}`
                    },
                    body: JSON.stringify(this.settings)
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    this.showMessage('Settings saved successfully!', 'success');
                } else {
                    this.showMessage(data.error || 'Failed to save settings', 'error');
                }
            } catch (error) {
                console.error('Failed to save settings:', error);
                this.showMessage('Network error. Please try again.', 'error');
            } finally {
                this.saving = false;
            }
        },
        
        showMessage(msg, type = 'success') {
            this.message = msg;
            this.messageType = type;
            setTimeout(() => {
                this.message = null;
            }, 5000);
        },
        
        async logout() {
            try {
                await fetch('/api/admin/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('adminToken')}`
                    }
                });
            } catch (error) {
                console.error('Logout error:', error);
            }
            
            localStorage.removeItem('adminToken');
            window.location.href = '/admin/login';
        }
    }
}
</script>
@endsection
