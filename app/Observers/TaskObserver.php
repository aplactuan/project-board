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
        $task->recordTaskActivity('task-created');
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
            ? $task->recordTaskActivity('task-completed')
            : $task->recordTaskActivity('task-uncompleted');
    }

    /**
     * Handele the Task "deleted" event.
     *
     * @param Task $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $task->project->recordActivity('task-deleted');
    }
}
