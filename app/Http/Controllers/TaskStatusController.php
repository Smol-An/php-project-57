<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskStatuses = TaskStatus::paginate();
        return view('task_status.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task_status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses',
            ], [
                'name.required' => __('task_status.validation.required'),
                'name.unique' => __('task_status.validation.unique'),
            ]);

        $taskStatus = new TaskStatus($data);
        $taskStatus->save();

        flash(__('task_status.flash.store'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('task_status.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses,name,' . $taskStatus->id,
        ], [
            'name.required' => __('task_status.validation.required'),
            'name.unique' => __('task_status.validation.unique'),
        ]);

        $taskStatus->fill($data);
        $taskStatus->save();

        flash(__('task_status.flash.update'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('task_status.flash.delete_error'))->error();
            return back();
        }

        $taskStatus->delete();

        flash(__('task_status.flash.delete'))->success();
        return redirect()->route('task_statuses.index');
    }
}
