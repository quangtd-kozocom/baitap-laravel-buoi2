@extends('layout.main')

@section('title', $task->title)

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Task Details</h1>
        <div>
            <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md mr-2">
                Back to Tasks
            </a>
            @if(auth()->id() === $task->owner_id)
                <a href="{{ route('tasks.edit', $task) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Edit Task
                </a>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $task->title }}</h2>
            <div class="flex items-center mb-4">
                <span class="px-3 py-1 rounded-full text-sm
                    @if($task->status->value === 'completed') bg-green-100 text-green-800
                    @elseif($task->status->value === 'in-progress') bg-blue-100 text-blue-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst($task->status->value) }}
                </span>
                <span class="ml-4 text-gray-500">Due: {{ $task->due_date->format('F j, Y') }}</span>
            </div>
            <div class="prose max-w-none">
                <p>{{ $task->description }}</p>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Task Information</h3>
                    <ul class="space-y-2">
                        <li class="flex">
                            <span class="font-medium w-32">Created by:</span>
                            <span>{{ $task->owner->name }}</span>
                        </li>
                        <li class="flex">
                            <span class="font-medium w-32">Assigned to:</span>
                            <span>{{ $task->assignedUser ? $task->assignedUser->name : 'Unassigned' }}</span>
                        </li>
                        <li class="flex">
                            <span class="font-medium w-32">Created at:</span>
                            <span>{{ $task->created_at->format('F j, Y g:i A') }}</span>
                        </li>
                        <li class="flex">
                            <span class="font-medium w-32">Last updated:</span>
                            <span>{{ $task->updated_at->format('F j, Y g:i A') }}</span>
                        </li>
                    </ul>
                </div>

                @if(auth()->id() === $task->assigned_to)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Update Status</h3>
                        <form action="{{ route('tasks.update', $task) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input hidden type="text" name="title" value="{{ $task->title }}">
                            <input hidden type="text" name="description" value="{{ $task->description }}">
                            <input hidden type="text" name="assigned_to" value="{{ $task->assigned_to }}">
                            <input hidden type="date" name="due_date" value="{{ $task->due_date->format('Y-m-d') }}">

                            <div class="mb-4">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Change Status</label>
                                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="pending" {{ $task->status->value == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in-progress" {{ $task->status->value == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                                Update Status
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        @if(auth()->id() === $task->owner_id)
            <div class="mt-8 border-t border-gray-200 pt-4">
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
                        Delete Task
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection
