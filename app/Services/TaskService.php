<?php

namespace App\Services;

use App\Models\Task;
use App\DTO\TaskDTO;

class TaskService
{
    public function getAll()
    {
        return Task::all();
    }

    public function create(TaskDTO $dto)
    {
        return Task::create((array) $dto);
    }

    public function find($id)
    {
        return Task::findOrFail($id);
    }

    public function update(Task $model, TaskDTO $dto)
    {
        $model->update((array) $dto);
        return $model;
    }

    public function delete(Task $model)
    {
        return $model->delete();
    }
}