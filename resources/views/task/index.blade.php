@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('task.index.header') }}
        </h1>

        <div class="w-full flex items-center">
            @auth
                <div class="ml-auto">
                    <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                        {{ __('task.index.create') }}
                    </a>
                </div>
            @endauth
        </div>

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>{{ __('task.index.id') }}</th>
                    <th>{{ __('task.index.status_id') }}</th>
                    <th>{{ __('task.index.name') }}</th>
                    <th>{{ __('task.index.created_by') }}</th>
                    <th>{{ __('task.index.assigned_to') }}</th>
                    <th>{{ __('task.index.created_at') }}</th>
                    @auth
                        <th>{{ __('task.index.actions') }}</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr class="border-b border-dashed text-left">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $task->name }}
                            </a>
                        </td>
                        <td>{{ $task->createdBy->name }}</td>
                        <td>{{ $task->assignedTo->name ?? '' }}</td>
                        <td>{{ $task->created_at->format('d.m.Y') }}</td>
                        @auth
                            <td>
                                @can('delete', $task)
                                    <a href="{{ route('tasks.destroy', $task->id) }}"
                                        data-confirm="{{ __('task.index.delete_confirm') }}"
                                        data-method="DELETE"
                                        class="text-red-600 hover:text-red-900">
                                        {{ __('task.index.delete') }}             
                                    </a>
                                @endcan
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ __('task.index.edit') }}
                                </a>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
