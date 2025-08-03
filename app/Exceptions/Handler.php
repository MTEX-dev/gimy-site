<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException; // <--- Add this line!
use Illuminate\Support\Str; // <--- Add this line for snake_case if not already globally available

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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        // Add this missing method
        if (method_exists($this, 'shouldViewCustomError')) {
            if ($e instanceof HttpException) {
                $statusCode = $e->getStatusCode();
                $errorLangKey = (string) $statusCode;

                if (!__('errors.' . $errorLangKey . '.title') || !__('errors.' . $errorLangKey . '.description')) {
                    $errorLangKey = 'fallback';
                }

                return response()->view('pages.error', [
                    'error' => $statusCode,
                ], $statusCode);
            }

            if ($this->shouldViewCustomError($e)) {
                $errorType = class_basename($e);
                // Use the Str::snake method from the Illuminate\Support\Str facade
                $errorLangKey = Str::snake($errorType);

                if (!__('errors.' . $errorLangKey . '.title') || !__('errors.' . $errorLangKey . '.description')) {
                    $errorLangKey = 'fallback';
                }

                return response()->view('pages.error', [
                    'error' => $errorType,
                ], 500);
            }
        }


        return parent::render($request, $e);
    }

    /**
     * Determine if a custom error view should be displayed for the given exception.
     *
     * @param  \Throwable  $e
     * @return bool
     */
    protected function shouldViewCustomError(Throwable $e): bool
    {
        return true;
    }
}