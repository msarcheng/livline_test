<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param array $result
     * @param int $http_status
     *
     * @return JsonResponse
     */
    public function sendResponse(int $http_status = 200, array $result = []): JsonResponse
    {
        $response = [
            'status_code' => $http_status,
            'data' => $result
        ];

        return response()->json($response);
    }

    /**
     * return error response.
     *
     * @param string $message
     * @param int $http_status
     * @param array $errorMessages
     *
     * @return JsonResponse
     */
    public function sendError(
        string $message,
        int $http_status = 404,
        array $errorMessages = []
    ): JsonResponse {

        $response = [
            'status_code' => $http_status,
            'message' => $message
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $http_status);
    }
}
