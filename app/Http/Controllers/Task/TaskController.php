<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $myTasks = auth()
            ->user()
            ->myTasks()
            ->latest()
            ->paginate(5);

        $myAssignedTasks = auth()
            ->user()
            ->assignedTasks()
            ->latest()
            ->paginate(5);

        return view('task.index', compact('myTasks', 'myAssignedTasks'));
    }

    public function create(): View
    {
        $users = User::all();

        return view('task.create', compact('users'));
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return to_route('tasks.my-tasks');
    }

    public function show(Task $task): View
    {
        $task->load(['owner', 'assignedUser']);

        return view('task.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $users = User::all();

        return view('task.edit', compact('task', 'users'));
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update([
            ...$request->validated(),
            'owner_id' => $task->owner_id
        ]);

        return to_route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return to_route('tasks.my-tasks');
    }

    public function myTasks(): View
    {
        $myTasks = auth()
            ->user()
            ->myTasks()
            ->with('assignedUser')
            ->paginate(10);

        return view('task.my-tasks', compact('myTasks'));
    }

    public function assignTasks(): View
    {
        $myAssignedTasks = auth()
            ->user()
            ->assignedTasks()
            ->with('owner')
            ->paginate(10);

        return view('task.assigned-tasks', compact('myAssignedTasks'));
    }
}
