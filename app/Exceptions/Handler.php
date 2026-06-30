<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Handle API requests with JSON responses
        if ($request->expectsJson()) {
            return $this->renderJsonResponse($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Render exception as JSON response
     */
    private function renderJsonResponse($request, Throwable $e): JsonResponse
    {
        // Handle Validation Exceptions (422)
        if ($e instanceof ValidationException) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'type' => 'validation',
                'errors' => $e->errors(),
                'status_code' => 422,
            ], 422);
        }

        // Handle Authentication Exceptions (401)
        if ($e instanceof AuthenticationException) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'type' => 'unauthorized',
                'status_code' => 401,
            ], 401);
        }

        // Handle HTTP Exceptions (400, 403, 404, etc.)
        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
            $message = $e->getMessage() ?: $this->getHttpExceptionMessage($statusCode);

            return response()->json([
                'status' => false,
                'message' => $message,
                'type' => $this->getErrorType($statusCode),
                'status_code' => $statusCode,
            ], $statusCode);
        }

        // Handle custom app exceptions
        if ($e instanceof AppException) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'type' => $e->getType(),
                'status_code' => $e->getStatusCode(),
            ], $e->getStatusCode());
        }

        // Handle generic exceptions (500)
        $statusCode = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500;
        $message = config('app.debug')
            ? $e->getMessage()
            : 'An error occurred while processing your request. Please try again.';

        return response()->json([
            'status' => false,
            'message' => $message,
            'type' => 'error',
            'status_code' => $statusCode,
        ], $statusCode);
    }

    /**
     * Get HTTP exception message based on status code
     */
    private function getHttpExceptionMessage(int $statusCode): string
    {
        return match ($statusCode) {
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            422 => 'Unprocessable Entity',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            default => 'An error occurred',
        };
    }

    /**
     * Get error type based on status code
     */
    private function getErrorType(int $statusCode): string
    {
        return match ($statusCode) {
            401 => 'unauthorized',
            403 => 'forbidden',
            404 => 'notfound',
            422 => 'validation',
            429 => 'ratelimit',
            500, 501, 502, 503, 504 => 'critical',
            default => 'error',
        };
    }
}
