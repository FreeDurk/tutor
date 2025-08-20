<?php

namespace App\Http\Controllers;

use App\Http\ApiResponse\ApiResponse;
use App\Http\Requests\TaskDtoRequest;
use App\Http\Requests\TaskUpdateDtoRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
       
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->taskService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskDtoRequest $request)
    {
        return $this->taskService->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return ApiResponse::success(new TaskResource($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateDtoRequest $request, string $task)
    {
        return $this->taskService->update($request->validated(), $task);
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
