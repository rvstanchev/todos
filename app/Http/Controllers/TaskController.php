<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\ToDoList;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    public function listTasks()
    {
        $activeTasks = Task::active()->get();
        $inactiveTasks = Task::inactive()->get();
        $completedTasks = Task::completed()->get();
    }

    public function taskChangeStatus(Request $request)
    {
        $data = $request->validate([
           'taskStatus'=>'required | in:active,completed',
           'taskId'=>'numeric'
        ]);

        $task = Task::find($request->taskId);
        $task->status = $request->taskStatus;
        $task->save();
        
        $task->toDoList->updateStatus();

        return response()->json([
            'success'=>'status: '.$data['taskStatus'].' with id: '.$data['taskId'],
            'error' => 'Something went wrong, try again.'
        ]);
    }
    
    public function taskDestroy(Request $request)
    {
        $data = $request->validate([
           'taskId'=>'numeric'
        ]);

        $task = Task::find($request->taskId);
        $task->delete();
    }
}
