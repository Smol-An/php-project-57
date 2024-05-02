<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->orderBy('id')
            ->paginate();

        $taskStatusesById = TaskStatus::pluck('name', 'id');
        $usersById = User::pluck('name', 'id');

        return view('task.index', compact('tasks', 'taskStatusesById', 'usersById', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('task.create', compact('taskStatuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:tasks',
            'description' => 'string|max:500|nullable',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable',
        ], [
            'name.required' => __('task.validation.required'),
            'name.unique' => __('task.validation.unique'),
            'status_id.required' => __('task.validation.required'),
        ]);

        $task = Auth::user()->createdTasks()->create($data);
        $task->save();

        $labels = Arr::whereNotNull($request->input('labels') ?? []);
        $task->labels()->attach($labels);

        flash(__('task.flash.store'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('task.edit', compact('task', 'taskStatuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:tasks,name,' . $task->id,
            'description' => 'string|max:500|nullable',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable',
        ], [
            'name.required' => __('task.validation.required'),
            'name.unique' => __('task.validation.unique'),
            'status_id.required' => __('task.validation.required'),
        ]);

        $task->fill($data);
        $task->save();

        $labels = Arr::whereNotNull($request->input('labels') ?? []);
        $task->labels()->sync($labels);

        flash(__('task.flash.update'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        flash(__('task.flash.delete'))->success();

        return redirect()->route('tasks.index');
    }
}
