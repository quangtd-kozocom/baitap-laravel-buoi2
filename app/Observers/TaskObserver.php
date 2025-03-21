<?php

namespace App\Observers;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Notifications\Tasks\TaskAssignedNotification;
use App\Notifications\Tasks\TaskCompletedNotification;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Notification;

class TaskObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Task $task): void
    {
        Notification::send($task->assignedUser()->get(), new TaskAssignedNotification($task));
    }

    public function updated(Task $task): void
    {
        if ($task->status !== TaskStatus::Completed) return;

        Notification::send($task->owner()->get(), new TaskCompletedNotification($task));
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
