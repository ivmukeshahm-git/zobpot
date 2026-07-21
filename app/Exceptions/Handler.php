<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * For API calls, return exception message as JSON so it appears in the API response.
     *
     * This helps during debugging (e.g. DB connection errors like SQLSTATE[HY000] [2002]).
     */
    public function render($request, Throwable $e)
    {
        if ($request instanceof Request) {
            $isApiRequest = $request->is('api/*') || $request->expectsJson();
            if ($isApiRequest) {
                $payload = [
                    'status' => 0,
                    'error' => [
                        'type' => get_class($e),
                        'message' => $e->getMessage(),
                    ],
                ];

                // Only include trace when debugging is enabled
                if ((bool) config('app.debug', false)) {
                    $payload['error']['trace'] = collect($e->getTrace())->take(20)->toArray();
                }

                return response()->json($payload, 500);
            }
        }

        return parent::render($request, $e);
    }
}
