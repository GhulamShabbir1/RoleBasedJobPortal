/**
 * API Error Handler with Axios Interceptors
 * Handles all API errors and displays them through the error notification component
 */

import axios from 'https://cdn.jsdelivr.net/npm/axios@1.6.2/+esm';

// Create axios instance with default config
const apiClient = axios.create({
    timeout: 30000,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

// Response Interceptor - Handle all API responses
apiClient.interceptors.response.use(
    response => {
        // Success response - return as is
        return response;
    },
    error => {
        // Handle error response
        const errorResponse = error.response;
        const errorData = {
            status: false,
            message: 'An error occurred',
            type: 'error',
            status_code: error.code || 500,
            details: []
        };

        if (errorResponse) {
            // Server responded with error status
            const { status, data } = errorResponse;

            errorData.status_code = status;
            errorData.message = data?.message || data?.msg || 'An error occurred';
            errorData.type = data?.type || getErrorTypeFromStatus(status);

            // Handle validation errors (422)
            if (status === 422 && data?.errors) {
                errorData.details = Object.entries(data.errors).map(([field, messages]) => {
                    const msgs = Array.isArray(messages) ? messages : [messages];
                    return msgs.map(msg => `${field}: ${msg}`);
                }).flat();
                errorData.title = 'Validation Failed';
            }

            // Handle custom field errors
            if (data?.fieldErrors) {
                errorData.details = Object.entries(data.fieldErrors).map(([field, message]) => {
                    return `${field}: ${message}`;
                });
            }

            // Handle structured error details
            if (data?.details && Array.isArray(data.details)) {
                errorData.details = data.details;
            }

        } else if (error.request) {
            // Request made but no response
            errorData.status_code = 0;
            errorData.type = 'network';
            errorData.message = 'Unable to connect to server. Check your internet connection.';
        } else {
            // Error in request setup
            errorData.message = error.message || 'An error occurred';
            errorData.type = 'error';
        }

        // Dispatch error to global notification handler
        dispatchError(errorData);

        return Promise.reject(error);
    }
);

/**
 * Get error type from HTTP status code
 */
function getErrorTypeFromStatus(status) {
    switch (status) {
        case 400: return 'validation';
        case 401: return 'unauthorized';
        case 403: return 'forbidden';
        case 404: return 'notfound';
        case 422: return 'validation';
        case 429: return 'ratelimit';
        case 500:
        case 501:
        case 502:
        case 503:
        case 504: return 'critical';
        default: return 'error';
    }
}

/**
 * Dispatch error event to Alpine.js component
 */
function dispatchError(errorData) {
    // Create and dispatch custom event
    const event = new CustomEvent('error-notification', {
        detail: {
            status: errorData.status_code,
            type: errorData.type,
            title: errorData.title || getErrorTitle(errorData.type),
            message: errorData.message,
            details: errorData.details || [],
            timestamp: new Date().toISOString()
        }
    });

    window.dispatchEvent(event);

    // Also log to console in development
    if (true) { // Change to check for dev mode
        console.error('[API Error]', errorData);
    }
}

/**
 * Get error title from error type
 */
function getErrorTitle(type) {
    const titles = {
        'error': 'Error',
        'unauthorized': 'Access Denied',
        'forbidden': 'Forbidden',
        'notfound': 'Not Found',
        'validation': 'Validation Failed',
        'network': 'Network Error',
        'ratelimit': 'Rate Limited',
        'critical': 'Server Error'
    };
    return titles[type] || 'Error';
}

/**
 * Helper function to make API calls
 */
async function apiCall(method, url, data = null, config = {}) {
    try {
        const response = await apiClient({
            method,
            url,
            data,
            ...config
        });
        return response.data;
    } catch (error) {
        throw error;
    }
}

/**
 * Export helpers
 */
window.apiClient = apiClient;
window.apiCall = apiCall;
window.dispatchError = dispatchError;

export { apiCall, apiClient, dispatchError };

