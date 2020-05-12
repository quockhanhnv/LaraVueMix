<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    public function responseSuccess(string $message = 'Get API successfully', $data = null): JsonResponse
    {
        return $this->response(Response::HTTP_OK, Response::HTTP_OK, $message, $data);
    }

    public function responseNotFound(string $message = 'Data not found for this route'): JsonResponse
    {
        return $this->response(Response::HTTP_NOT_FOUND, Response::HTTP_NOT_FOUND, $message);
    }

    public function responseUnAuthenticate(): JsonResponse
    {
        return $this->response(Response::HTTP_UNAUTHORIZED, Response::HTTP_UNAUTHORIZED, 'Unauthenticated', [], []);
    }

    public function responseUnAuthorize(): JsonResponse
    {
        return $this->response(Response::HTTP_UNAUTHORIZED, Response::HTTP_UNAUTHORIZED, 'Unauthorized', [], []);
    }

    public function responseValidationFailed(array $errors): JsonResponse
    {
        return $this->response(Response::HTTP_UNPROCESSABLE_ENTITY, Response::HTTP_UNPROCESSABLE_ENTITY,
            'Validation failed', [], $errors);
    }

    public function responseWithJWTToken(string $token): JsonResponse  // response token when login successfully
    {
        return $this->responseSuccess('Login successfully', ['token' => $token]);
    }

    public function responseWithJWTException($message = 'JWT exception from ResponseTrait.php')
    {
        return $this->response(Response::HTTP_BAD_REQUEST, Response::HTTP_BAD_REQUEST, $message);
    }

    public function responseWithJWTTokenInvalidException($message = 'TokenInvalidException from ResponseTrait.php')
    {
        return $this->response(Response::HTTP_BAD_REQUEST, Response::HTTP_BAD_REQUEST, $message);
    }

    public function responseWithJWTTokenExpiredException($message = 'TokenExpiredException from ResponseTrait.php')
    {
        return $this->response(Response::HTTP_BAD_REQUEST, Response::HTTP_BAD_REQUEST, $message);
    }

    public function responseWithJWTTokenBlacklist($message = 'Token is in black list')
    {
        return $this->response(Response::HTTP_BAD_REQUEST, Response::HTTP_BAD_REQUEST, $message);
    }

    public function responseMethodNotAllow(): JsonResponse
    {
        return $this->response(Response::HTTP_METHOD_NOT_ALLOWED, Response::HTTP_METHOD_NOT_ALLOWED, 'Method not allow for this route');
    }

    private function responseWithAnonymousException(): JsonResponse
    {
        return $this->response(Response::HTTP_BAD_GATEWAY, Response::HTTP_BAD_GATEWAY, 'Internal server');
    }

    public function response(int $code, int $statusCode = Response::HTTP_OK, string $message = '',  $data = null, $errors = null)
    {
        $response = [
          'code' => $code,
          'message' => $message
        ];

        if(!empty($data)) {
            $response['data'] = $data;
        }
        if(!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
