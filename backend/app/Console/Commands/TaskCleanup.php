<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Repositories\TaskRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TaskCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove task older than 30 days';

    public function __construct(protected TaskRepository $taskRepo){
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->subDays(30);

        $tasks = $this->taskRepo->all(
            where:[['created_at' , '<=' , $date]]
        );

        Log::info("Deleting Old Tasks...");
        Log::info("Date: ". Carbon::now());

        if($tasks->isEmpty()) {
            Log::info("No Tasks to delete...");
            return;
        }

        Log::info("Tasks IDs: ". $tasks->pluck('id'));

        Task::whereIn('id' , $tasks->pluck('id'))->delete();

        Log::info("Completed...");

    }
}
