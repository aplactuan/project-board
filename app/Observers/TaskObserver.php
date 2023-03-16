<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->project->recordActivity('task_created');
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        $task->completed
            ? $task->project->recordActivity('task_completed')
            : $task->project->recordActivity('task_uncompleted');
    }

    /**
     * Handele the Task "deleted" event.
     *
     * @param Task $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $task->project->recordActivity('task_deleted');
    }
}
