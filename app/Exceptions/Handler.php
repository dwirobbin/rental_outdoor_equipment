<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        // \Illuminate\Auth\AuthenticationException::class,
        // \Illuminate\Auth\Access\AuthorizationException::class,
        // \Symfony\Component\HttpKernel\Exception\HttpException::class,
        // \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        // \Illuminate\Session\TokenMismatchException::class,
        // \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */

    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $httpExceptionInterface
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpExceptionInterface $httpExceptionInterface)
    {
        $status = $httpExceptionInterface->getStatusCode();
        if (view()->exists($this->getViewName($status))) {
            return response()->view(
                $this->getViewName($status),
                [
                    'exception' => $httpExceptionInterface
                ],
                $status,
                $httpExceptionInterface->getHeaders()
            );
        } else {
            return $this->convertExceptionToResponse($httpExceptionInterface);
        }
    }

    /**
     * Get view name
     *
     * @param integer $status
     * @return string
     */
    protected function getViewName(int $status)
    {
        if (request()->is('admin-area/*') || request()->is('customer-area/*')) {
            return "errors.backend.{$status}";
        }

        return "errors.frontend.{$status}";
    }
}
