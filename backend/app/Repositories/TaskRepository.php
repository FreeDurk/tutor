<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function search()
    {
        $query = request('q', null);
        $prio = request('priority', 1);
        $status = request('status', 1);

        $results = $this->model->search($query)->paginate(10);
        return $results;
    }
}
