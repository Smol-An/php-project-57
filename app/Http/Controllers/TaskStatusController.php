<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Task $task)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Task $task)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task, TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task, TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task, TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, TaskStatus $taskStatus)
    {
        //
    }
}
