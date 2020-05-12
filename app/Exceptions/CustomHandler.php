<?php

namespace App\Exceptions;
use App\Traits\ResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CustomHandler extends Handler
{
    use ResponseTrait;

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->responseMethodNotAllow();
        } elseif ($exception instanceof NotFoundHttpException) {
            return $this->responseNotFound();
        } elseif ($exception instanceof AuthenticationException) {
            return $this->responseUnAuthenticate();
        } elseif ($exception instanceof AuthorizationException) {
            return $this->responseUnAuthorize();
        } elseif ($exception instanceof ValidationException || $exception instanceof HttpResponseException) {
            return $this->responseValidationFailed($exception->errors());
        } elseif ($exception instanceof TokenExpiredException ) {
            return $this->responseWithJWTTokenExpiredException();
        } elseif ($exception instanceof TokenInvalidException) {
            return $this->responseWithJWTTokenInvalidException();
        } elseif ($exception instanceof JWTException) {
            return $this->responseWithJWTException();
        } else {
            var_dump($exception->getMessage());
            Log::error('Internal server ' . $exception->getMessage());
            return $this->responseWithAnonymousException();
        }
    }
}
