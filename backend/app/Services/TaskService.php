<?php

namespace App\Services;

use App\Constants\CacheKey;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\ApiResponse\ApiResponse;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected TaskRepository $taskRepo) {}

    public function index()
    {
        $page = request('page', 1);

        try {
            // $tasks = Cache::remember(CacheKey::TASK_LIST. $page, 300, function () {
            //     return $this->taskRepo->all(paginate:true, with: ['user']);
            // });

            $tasks = $this->taskRepo->search();

            $results = new PaginateResource($tasks , TaskResource::class);

            return ApiResponse::success($results);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();
            $task = $this->taskRepo->create($data);
            DB::commit();
            return ApiResponse::success(new TaskResource($task), 'Success', 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function update(array $data, string $task_id)
    {
        try {
            DB::beginTransaction();
            $task = $this->taskRepo->update($task_id,$data);
            DB::commit();
            return ApiResponse::success(new TaskResource($task));
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }
}
