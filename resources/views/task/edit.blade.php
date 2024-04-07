@extends('layouts.app')

@section('content')
    <div class="grid col-span-full">
        <h1 class="mb-5">
            {{ __('task.edit.header') }}
        </h1>

        {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH', 'class' => 'w-50']) }}
            <div class="flex flex-col">
                <div>
                    {{ Form::label('name', __('task.edit.name')) }}
                </div>
                <div class="mt-2">
                    {{ Form::text('name', null, ['class' => 'rounded border-gray-300 w-1/3']) }}
                </div>
                @error('name')
                    <div class="text-rose-600">{{ $message }}</div>
                @enderror
                <div class="mt-2">
                    {{ Form::label('description', __('task.edit.description')) }}
                </div>
                <div class="mt-2">
                    {{ Form::textarea('description', null, ['class' => 'rounded border-gray-300 w-1/3 h-32', 'cols' => '50', 'rows' => '10']) }}
                </div>
                @error('description')
                    <div class="text-rose-600">{{ $message }}</div>
                @enderror
                <div class="mt-2">
                    {{ Form::label('status_id', __('task.edit.status_id')) }}
                </div>
                <div class="mt-2">
                    {{ Form::select('status_id', $taskStatuses, null, ['class' => 'rounded border-gray-300 w-1/3', 'placeholder' => '----------']) }}
                </div>
                @error('status_id')
                    <div class="text-rose-600">{{ $message }}</div>
                @enderror
                <div class="mt-2">
                    {{ Form::label('assigned_to_id', __('task.edit.assigned_to_id')) }}
                </div>
                <div class="mt-2">
                    {{ Form::select('assigned_to_id', $users, null, ['class' => 'rounded border-gray-300 w-1/3', 'placeholder' => '----------']) }}
                </div>
                <div class="mt-2">
                    {{ Form::label('labels', __('task.edit.labels')) }}
                </div>
                <div class="mt-2">
                    {{ Form::select('labels', $labels, null, ['class' => 'rounded border-gray-300 w-1/3 h-32', 'placeholder' => '', 'multiple' => 'multiple', 'name' => 'labels[]']) }}
                </div>
                <div class="mt-2">
                    {{ Form::submit(__('task.edit.button'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
@endsection
