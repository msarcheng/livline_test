<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Services\TaskInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends BaseController
{
    public function __construct(private TaskInterface $taskInterface)
    {
        //
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $requests = $request->validate([
                'limit' => 'integer|min:1|max:100',
                'search' => 'string|max:100|nullable'
            ]);

            $requests = [
                'limit' => $request->input('limit', 10),
                'search' => $request->input('search', '')
            ];

            $tasks = $this->taskInterface->index($requests);

            return $this->sendResponse($tasks);

        } catch (Exception $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show(Request $request): JsonResponse
    {
        return request()->json([]);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        return request()->json([]);
    }

    public function update(TaskRequest $request): JsonResponse
    {
        return request()->json([]);
    }

    public function destroy(Request $request): JsonResponse
    {
        return request()->json([]);
    }

}
