<?php

namespace App\Http\Services;

use App\Http\Services\TaskInterface;
use App\Models\Task;

class TaskService implements TaskInterface {

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
        $search = '%'.$tasks['search'].'%';

        return $this->task::where('title', 'LIKE', $search)
            ->whereNull('deleted_at')
            ->paginate($limit)->toArray();
    }

    public function show(int $task_id): array
    {
        return [];
    }

    public function store(array $tasks): array
    {
        return [];
    }

    public function update(array $tasks): array
    {
        return [];
    }

    public function destroy(int $task_id): array
    {
        return [];
    }
}
