{{-- <!-- Global Error Notification Component -->


<div x-data="errorHandler()" @error-notification.window="showError($event.detail)" @success-notification.window="showSuccess($event.detail)" @warning-notification.window="showWarning($event.detail)" @info-notification.window="showInfo($event.detail)" class="fixed top-4 right-4 z-[9999] max-w-md">
  <template x-for="error in errors" :key="error.id">
    <div x-show="error.show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform translate-x-2" class="mb-3 p-4 rounded-lg shadow-lg border-l-4 flex items-start gap-3" :class="getErrorClass(error.type)">
      <div class="flex-shrink-0 pt-0.5">
        <i class="fas text-lg" :class="getErrorIcon(error.type)"></i>
      </div>
      <div class="flex-1 min-w-0">
        <h3 class="font-semibold mb-1" x-text="error.title"></h3>
        <p class="text-sm opacity-90 break-words" x-text="error.message"></p>
        <div x-show="error.details && error.details.length > 0" class="mt-2 text-xs space-y-1">
          <template x-for="detail in error.details" :key="detail">
            <div class="flex items-start gap-2">
              <span class="text-current opacity-60">•</span>
              <span class="opacity-75" x-text="detail"></span>
            </div>
          </template>
        </div>
      </div>
      <button @click="removeError(error.id)" class="flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity">
        <i class="fas fa-times text-lg"></i>
      </button>
    </div>
  </template>
</div>
<script>
function errorHandler() {
  return {
    errors: [],
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
      error.id = this.errorIdCounter++;
      error.show = true;
      this.errors.push(error);

      if (error.type !== 'critical') {
        setTimeout(() => {
          this.removeError(error.id);
        }, error.duration || 5000);
      }

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

      if (typeof errorData === 'string') {
        error.message = errorData;
        return error;
      }

      if (typeof errorData === 'object') {
        error = { ...error, ...errorData };

        if (errorData.status === 422 && errorData.errors) {
          error.details = Object.entries(errorData.errors).map(([field, messages]) => {
            return Array.isArray(messages) ? messages.join(', ') : messages;
          });
          error.title = 'Validation Failed';
        }

        if (errorData.fieldErrors) {
          error.details = Object.entries(errorData.fieldErrors).map(([field, message]) => {
            return field + ': ' + message;
          });
        }

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
    }
  }
}
</script>

<style>
  [x-cloak] {
    display: none !important;
  }
</style> --}}
