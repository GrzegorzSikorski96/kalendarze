<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    protected $message = '';
    protected $data = [];
    protected $response_code;
    protected $status;

    /**
     * @param $message
     * @return ApiResponse
     */
    public function setMessage($message): ApiResponse
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param $status
     * @return ApiResponse
     */
    public function setStatus($status): ApiResponse
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param $data
     * @return ApiResponse
     */
    public function setData($data): ApiResponse
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $code
     * @return ApiResponse
     */
    public function setResponseCode($code): ApiResponse
    {
        $this->response_code = $code;

        return $this;
    }

    /**
     * @return JsonResponse
     */
    public function success(): JsonResponse
    {
        $this->response_code = 200;
        $this->status = true;

        return $this->getResponse();
    }

    public function internalServerError(): JsonResponse
    {
        $this->message = 'Internal server error';
        $this->response_code = 500;
        $this->status = false;

        return $this->getResponse();
    }

    /**
     * @return JsonResponse
     */
    public function notFound(): JsonResponse
    {
        $this->message = 'Not found';
        $this->response_code = 404;
        $this->status = false;

        return $this->getResponse();
    }

    /**
     * @return JsonResponse
     */
    public function unauthorized(): JsonResponse
    {
        $this->message = 'Unauthorized';
        $this->response_code = 401;
        $this->status = false;

        return $this->getResponse();
    }

    /**
     * @return JsonResponse
     */
    public function badRequest(): JsonResponse
    {
        $this->message = 'Bad request';
        $this->response_code = 400;
        $this->status = false;

        return $this->getResponse();
    }

    /**
     * @return JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        if (auth()->check()) {
            return $this->respondWithToken(auth()->refresh());
        } else {
            return $this->respondWithoutToken();
        }
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    private function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'auth' => true,
            'success' => $this->status,
            'message' => $this->message,
            'token' => $token,
            'data' => $this->data,
        ], $this->response_code);
    }

    /**
     * @return JsonResponse
     */
    private function respondWithoutToken(): JsonResponse
    {
        return response()->json([
            'auth' => false,
            'success' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
        ], $this->response_code);
    }
}