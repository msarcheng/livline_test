<?php

namespace App\Http\Services;

use App\Http\Services\TaskInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class TaskService implements TaskInterface
{

    public function __construct(private Task $task)
    {
        //
    }

    /**
     * Show all tasks or with search
     *
     * @param array $tasks
     *
     * @return array
     */
    public function index(array $tasks): array
    {
        $limit = $tasks['limit'];
        $search = '%' . $tasks['search'] . '%';

        return $this->task::where('title', 'LIKE', $search)
            ->whereNull('deleted_at')
            ->paginate($limit)->toArray();
    }

    /**
     * Show specific Task
     *
     * @param int $task_id
     *
     * @return array
     */
    public function show(int $task_id): array
    {
        try {
            $task = $this->task::findOrFail($task_id);
            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description
            ];
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => "Model Not Found: {$task_id}"
            ];
        }
    }

    public function store(array $tasks): array
    {
        $task_title = $tasks['title'];
        try {
            $checkTaskTitleIfExists = $this->task::where('title', $task_title)
                ->withTrashed()
                ->exists();

            if ($checkTaskTitleIfExists) {
                throw new ConflictHttpException();
            }

            $getSavedTask = $this->task->create($tasks);

            return [
                'id' => $getSavedTask->id,
                'title' => $getSavedTask->title,
                'description' => $getSavedTask->description
            ];
        } catch (ConflictHttpException $ex) {
            return [
                'error' => "Cannot duplicate titles"
            ];
        }
    }

    public function update(array $tasks): array
    {
        try {
            $check_task = $this->task->findOrFail($tasks['id']);
            $checkTaskTitleIfExists = $this->task::where('title', $tasks['title'])
                ->withTrashed()
                ->exists();

            if ($checkTaskTitleIfExists) {
                throw new ConflictHttpException();
            }

            $check_task->update($tasks);

            return [
                'id' => $check_task->id,
                'title' => $check_task->title,
                'description' => $check_task->description
            ];
        } catch (ConflictHttpException $ex) {
            return [
                'duplicate' => "Cannot duplicate titles."
            ];
        } catch (ModelNotFoundException $ex) {
            return [
                'not_found' => "Model Not Found: {$tasks['id']}."
            ];
        }
    }

    public function destroy(int $task_id): bool|array
    {
        try {
            $task = $this->task->findOrFail($task_id);

            $task->delete();

            return true;

        } catch (ModelNotFoundException $ex) {
            return [
                'not_found' => "Task Not Found: {$task_id}"
            ];
        }
    }
}
