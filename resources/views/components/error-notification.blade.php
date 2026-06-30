<!-- Global Error Notification Component -->
<div x-data="errorHandler()"
     @error-notification.window="showError($event.detail)"
     @success-notification.window="showSuccess($event.detail)"
     @warning-notification.window="showWarning($event.detail)"
     @info-notification.window="showInfo($event.detail)"
     class="fixed top-4 right-4 z-[9999] max-w-md">
    <!-- Error Toast Messages -->
    <template x-for="error in errors" :key="error.id">
        <div x-show="error.show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-2"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform translate-x-2"
             class="mb-3 p-4 rounded-lg shadow-lg border-l-4 flex items-start gap-3"
             :class="getErrorClass(error.type)">

            <!-- Icon -->
            <div class="flex-shrink-0 pt-0.5">
                <i class="fas text-lg" :class="getErrorIcon(error.type)"></i>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold mb-1" x-text="error.title"></h3>
                <p class="text-sm opacity-90 break-words" x-text="error.message"></p>

                <!-- Detailed Errors (if any) -->
                <div x-show="error.details && error.details.length > 0" class="mt-2 text-xs space-y-1">
                    <template x-for="detail in error.details" :key="detail">
                        <div class="flex items-start gap-2">
                            <span class="text-current opacity-60">•</span>
                            <span class="opacity-75" x-text="detail"></span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Close Button -->
            <button @click="removeError(error.id)" class="flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
    </template>
</div>

<!-- Modal for Detailed Errors -->
<div x-show="showDetailModal" @click.away="showDetailModal = false"
     x-transition class="fixed inset-0 bg-black/50 flex items-center justify-center z-[10000] p-4"
     style="display: none;">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="sticky top-0 bg-gradient-to-r from-red-50 to-orange-50 border-b border-gray-200 p-6 flex items-start justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                    Error Details
                </h2>
                <p class="text-gray-600 mt-1" x-text="detailError?.title"></p>
            </div>
            <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-4">
            <!-- Error Message -->
            <div>
                <h3 class="font-semibold text-gray-900 mb-2">Error Message</h3>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-gray-700 font-mono text-sm break-words">
                    <span x-text="detailError?.message"></span>
                </div>
            </div>

            <!-- Status Code & Type -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Status</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <span class="font-mono text-blue-900" x-text="detailError?.status || 'Unknown'"></span>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Type</h3>
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                        <span class="font-mono text-purple-900" x-text="detailError?.type || 'Error'"></span>
                    </div>
                </div>
            </div>

            <!-- Validation Errors -->
            <div x-show="detailError?.details && detailError.details.length > 0">
                <h3 class="font-semibold text-gray-900 mb-2">Details</h3>
                <div class="space-y-2">
                    <template x-for="detail in detailError?.details" :key="detail">
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 flex items-start gap-3">
                            <i class="fas fa-circle-exclamation text-orange-600 flex-shrink-0 mt-0.5"></i>
                            <span class="text-gray-700 text-sm" x-text="detail"></span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Stack Trace (if available) -->
            <div x-show="detailError?.stackTrace">
                <h3 class="font-semibold text-gray-900 mb-2">Technical Details</h3>
                <details class="border border-gray-300 rounded-lg">
                    <summary class="px-4 py-3 bg-gray-50 cursor-pointer font-medium hover:bg-gray-100 transition">
                        <i class="fas fa-code mr-2"></i>Stack Trace
                    </summary>
                    <div class="p-4 bg-gray-900 text-gray-100 font-mono text-xs overflow-x-auto">
                        <pre x-text="detailError?.stackTrace"></pre>
                    </div>
                </details>
            </div>

            <!-- Timestamp -->
            <div class="text-xs text-gray-500 pt-4 border-t border-gray-200">
                <span x-text="'Timestamp: ' + (detailError?.timestamp || new Date().toISOString())"></span>
            </div>
        </div>

        <!-- Footer -->
        <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 p-6 flex gap-3 justify-end">
            <button @click="copyErrorToClipboard()" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition flex items-center gap-2">
                <i class="fas fa-copy"></i>
                Copy Error
            </button>
            <button @click="showDetailModal = false" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function errorHandler() {
    return {
        errors: [],
        showDetailModal: false,
        detailError: null,
        errorIdCounter: 0,

        showError(errorData) {
            this.addNotification(this.parseError(errorData));
        },

        showSuccess(data) {
            this.addNotification({
                type: 'success',
                title: data.title || 'Success',
                message: data.message || 'Operation completed successfully',
                details: data.details || [],
                status: 200,
                duration: 4000,
                timestamp: new Date().toISOString()
            });
        },

        showWarning(data) {
            this.addNotification({
                type: 'warning',
                title: data.title || 'Warning',
                message: data.message || 'Please note',
                details: data.details || [],
                status: null,
                duration: 5000,
                timestamp: new Date().toISOString()
            });
        },

        showInfo(data) {
            this.addNotification({
                type: 'info',
                title: data.title || 'Information',
                message: data.message || 'FYI',
                details: data.details || [],
                status: null,
                duration: 4000,
                timestamp: new Date().toISOString()
            });
        },

        addNotification(error) {
            // Add to errors array
            error.id = this.errorIdCounter++;
            error.show = true;
            this.errors.push(error);

            // Auto-remove after timeout (unless it's critical)
            if (error.type !== 'critical') {
                setTimeout(() => {
                    this.removeError(error.id);
                }, error.duration || 5000);
            }

            // Log to console in development
            console.log('[Notification]', error);
        },

        parseError(errorData) {
            let error = {
                type: 'error',
                title: 'An Error Occurred',
                message: 'Something went wrong. Please try again.',
                details: [],
                status: null,
                duration: 5000,
                timestamp: new Date().toISOString()
            };

            // If errorData is a string
            if (typeof errorData === 'string') {
                error.message = errorData;
                return error;
            }

            // If errorData is an object
            if (typeof errorData === 'object') {
                error = { ...error, ...errorData };

                // Parse validation errors (422)
                if (errorData.status === 422 && errorData.errors) {
                    error.details = Object.entries(errorData.errors).map(([field, messages]) => {
                        return Array.isArray(messages) ? messages.join(', ') : messages;
                    });
                    error.title = 'Validation Failed';
                }

                // Parse field-specific errors
                if (errorData.fieldErrors) {
                    error.details = Object.entries(errorData.fieldErrors).map(([field, message]) => {
                        return `${field}: ${message}`;
                    });
                }

                // Determine error type and duration
                switch (errorData.status) {
                    case 401:
                    case 403:
                        error.type = 'unauthorized';
                        error.title = 'Access Denied';
                        error.duration = 6000;
                        break;
                    case 404:
                        error.type = 'notfound';
                        error.title = 'Not Found';
                        error.duration = 4000;
                        break;
                    case 422:
                        error.type = 'validation';
                        error.duration = 7000;
                        break;
                    case 500:
                    case 503:
                        error.type = 'critical';
                        error.title = 'Server Error';
                        error.duration = 10000;
                        break;
                    case 0:
                    case 'network':
                        error.type = 'network';
                        error.title = 'Network Error';
                        error.message = 'Unable to connect to server. Check your internet connection.';
                        error.duration = 8000;
                        break;
                    default:
                        error.type = 'error';
                        error.duration = 5000;
                }
            }

            return error;
        },

        getErrorClass(type) {
            const classes = {
                'error': 'bg-red-50 border-red-400 text-red-800',
                'unauthorized': 'bg-orange-50 border-orange-400 text-orange-800',
                'notfound': 'bg-yellow-50 border-yellow-400 text-yellow-800',
                'validation': 'bg-blue-50 border-blue-400 text-blue-800',
                'critical': 'bg-red-100 border-red-500 text-red-900',
                'network': 'bg-purple-50 border-purple-400 text-purple-800',
                'success': 'bg-green-50 border-green-400 text-green-800',
                'warning': 'bg-yellow-50 border-yellow-400 text-yellow-800',
                'info': 'bg-blue-50 border-blue-400 text-blue-800'
            };
            return classes[type] || classes['error'];
        },

        getErrorIcon(type) {
            const icons = {
                'error': 'fa-circle-xmark',
                'unauthorized': 'fa-lock',
                'notfound': 'fa-circle-question',
                'validation': 'fa-triangle-exclamation',
                'critical': 'fa-triangle-exclamation',
                'network': 'fa-wifi-slash',
                'success': 'fa-check-circle',
                'warning': 'fa-exclamation-circle',
                'info': 'fa-info-circle'
            };
            return icons[type] || icons['error'];
        },

        removeError(id) {
            const index = this.errors.findIndex(e => e.id === id);
            if (index > -1) {
                this.errors.splice(index, 1);
            }
        },

        showErrorDetail(error) {
            this.detailError = error;
            this.showDetailModal = true;
        },

        copyErrorToClipboard() {
            if (!this.detailError) return;

            const errorText = `
Error Report:
Title: ${this.detailError.title}
Type: ${this.detailError.type}
Status: ${this.detailError.status}
Message: ${this.detailError.message}
Details: ${this.detailError.details?.join('\n') || 'None'}
Timestamp: ${this.detailError.timestamp}
            `.trim();

            navigator.clipboard.writeText(errorText).then(() => {
                alert('Error details copied to clipboard');
            });
        }
    }
}
</script>

<style>
    /* Ensure error notification is always on top */
    [x-cloak] {
        display: none !important;
    }
</style>
