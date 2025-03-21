@extends('layout.main')

@section('title', 'Tasks Assigned to Me')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Tasks Assigned to Me</h1>
        <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
            Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        @if(! empty($myAssignedTasks))
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Title</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Created By</th>
                        <th class="py-3 px-6 text-left">Due Date</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                    @foreach($myAssignedTasks as $task)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left">
                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-500 hover:underline">
                                    {{ $task->title }}
                                </a>
                            </td>
                            <td class="py-3 px-6 text-left">
                                    <span class="px-2 py-1 rounded-full text-xs
                                        @if($task->status->value === 'completed') bg-green-100 text-green-800
                                        @elseif($task->status->value === 'in-progress') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $task->status->value }}
                                    </span>
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $task->owner->name }}
                            </td>
                            <td class="py-3 px-6 text-left">
                                {{ $task->due_date->format('M d, Y') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('tasks.show', $task) }}" class="text-blue-500 hover:text-blue-700 mx-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="title" value="{{ $task->title }}">
                                        <input type="hidden" name="description" value="{{ $task->description }}">
                                        <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                                        <input type="hidden" name="due_date" value="{{ $task->due_date->format('Y-m-d') }}">
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="text-green-500 hover:text-green-700 mx-2" onclick="return confirm('Mark this task as completed?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">You don't have any tasks assigned to you.</p>
        @endif
    </div>
@endsection
