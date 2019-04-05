<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
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
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (app()->environment('production') && app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        $e = $this->prepareException($exception);
        if ($e instanceof AuthenticationException)
        {
            if($request->expectsJson()){
                response()->json(['message' => 'Unauthenticated'], 401);
            }
            else{
                $guard = array_get($exception->guards(),0);
                switch ($guard){
                    case 'agent':
                        $login = 'agent.login';
                        break;
                     default:
                        $login = 'login';
                        break;
                }
            }
            return redirect()->guest(route($login));
        }


//        return redirect(url('http://amyalexpress.com/wrong.html'));
        return parent::render($request, $exception);
    }

}
