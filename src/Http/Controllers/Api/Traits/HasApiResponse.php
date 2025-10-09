<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Api\Traits;

use Illuminate\Http\Response;

trait HasApiResponse
{
    /**
     * @param array $data
     * @param int $responseCode
     * @param $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function success(array $data = [], int $responseCode = Response::HTTP_OK, array $headers = [])
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'errors' => null,
        ], $responseCode, $headers);
    }

    /**
     * @param string|null $errorMessage
     * @param int $responseCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(
        string $errorMessage = null,
        int $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $headers = []
    ) {
        return response()->json([
            'status' => 'error',
            'data' => null,
            'errors' => [
                'message' => $errorMessage,
                'code' => $responseCode,
            ],
        ], $responseCode, $headers);
    }
}
