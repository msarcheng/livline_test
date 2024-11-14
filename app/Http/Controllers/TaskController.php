<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Services\TaskInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaskController extends BaseController
{
    public function __construct(private TaskInterface $taskInterface)
    {
        //
    }

    /**
     * Index() - List all tasks
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

            return $this->sendResponse(Response::HTTP_OK, $tasks);

        } catch (Exception $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Show specific task.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $task_request = $request->only(["id"]);

            $validator = Validator::make($task_request, [
                "id" => 'required|integer'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validated = $validator->safe()->only(['id']);

            $task = $this->taskInterface->show($validated['id']);

            $http_code = array_key_exists('id', $task)
                ? Response::HTTP_OK
                : Response::HTTP_NOT_FOUND;

            return $this->sendResponse(
                $http_code,
                $task,

            );

        } catch (ValidationException $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );

        } catch (Exception $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Create new Task and avoid duplication of titles
     *
     * @param \App\Http\Requests\TaskRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse
    {
        try {
            $task_request = $request->validated();

            $task =$this->taskInterface->store($task_request);

            $http_code = array_key_exists('id', $task)
                ? Response::HTTP_CREATED
                : Response::HTTP_CONFLICT;

            return $this->sendResponse(
                $http_code,
                $task,

            );


        } catch (ValidationException $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );

        } catch (Exception $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update task but avoid duplication and check if exists
     *
     * @param \App\Http\Requests\TaskRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskRequest $request): JsonResponse
    {
        try {
            $task_request = $request->validated();
            $task =$this->taskInterface->update($task_request);

            $http_code = array_key_exists('id', $task)
                ? Response::HTTP_OK
                : (array_key_exists('duplicate', $task)
                    ? Response::HTTP_CONFLICT
                    : Response::HTTP_NOT_FOUND);

            return $this->sendResponse(
                $http_code,
                $task,

            );

        } catch (ValidationException $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );

        } catch (Exception $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Delete Task
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $task_request = $request->only(["id"]);

            $validator = Validator::make($task_request, [
                "id" => 'required|integer'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $validated = $validator->safe()->only(['id']);

            $task = $this->taskInterface->destroy($validated['id']);

            $http_code = array_key_exists('not_found', [$task])
                ? Response::HTTP_NOT_FOUND
                : Response::HTTP_NO_CONTENT;

            return $this->sendResponse($http_code);

        } catch (ValidationException $ex) {
            return $this->sendError(
                $ex->getMessage(),
                Response::HTTP_BAD_REQUEST
            );

        } catch (Exception $ex) {
            return $this->sendError(
                "Internal Server Error",
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}
