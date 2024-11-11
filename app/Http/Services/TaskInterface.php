<?php

namespace App\Http\Services;

interface TaskInterface
{
    public function index(array $tasks): array;
    public function show(int $task_id): array;
    public function store(array $tasks): array;
    public function update(array $tasks): array;
    public function destroy(int $task_id): array;
}
