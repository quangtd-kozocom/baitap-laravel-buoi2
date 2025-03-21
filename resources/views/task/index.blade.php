@extends('layout.main')

@section('title', 'Task Dashboard')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Task Dashboard</h1>
        <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
            Create New Task
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tasks I Created -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Tasks I Created</h2>

            <div class="mb-4">
                <a href="{{ route('tasks.my-tasks') }}" class="text-blue-500 hover:underline">View All My Tasks</a>
            </div>

            @if(! empty($myTasks))
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Title</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-left">Due Date</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                        @foreach($myTasks->take(5) as $task)
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
                                    {{ $task->due_date->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">You haven't created any tasks yet.</p>
            @endif
        </div>

        <!-- Tasks Assigned to Me -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Tasks Assigned to Me</h2>

            <div class="mb-4">
                <a href="{{ route('tasks.assigned-tasks') }}" class="text-blue-500 hover:underline">View All Assigned Tasks</a>
            </div>

            @if(! empty($myAssignedTasks))
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Title</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-left">Due Date</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                        @foreach($myAssignedTasks->take(5) as $task)
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
                                    {{ $task->due_date->format('M d, Y') }}
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
    </div>
@endsection
