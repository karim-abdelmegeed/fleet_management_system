<?php

namespace App\Exceptions;

use App\Helper\ResponseApi;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    private $responseApi;

    public function __construct(ResponseApi $responseApi, Container $container)
    {
        $this->responseApi = $responseApi;
        parent::__construct($container);
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['status' => false, 'message' => 'Unauthenticated to perform this Action'], 401);
        }

        return redirect()->guest('login');
    }
}
