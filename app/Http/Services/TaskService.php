<?php

namespace App\Http\Services;

use App\Http\Services\TaskInterface;

class TaskService implements TaskInterface {

    public function index(array $tasks): array
    {
        return [];
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
