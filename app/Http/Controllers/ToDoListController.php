<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toDoLists = Auth::user()->toDoLists;

        foreach($toDoLists as $toDoList){
            $toDoList->updateStatus();
        }
        $toDoLists = Auth::user()->toDoLists()->paginate(20);

        return view('todolist.index',compact('toDoLists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todolist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $toDoListData = $this->validateRequest($request);

        $toDoListData['todolist']['user_id'] = auth()->id();
        $toDoList = ToDoList::create($toDoListData['todolist']);

        if($request->tasks) {
            $toDoList->tasks()->createMany($toDoListData['tasks']);
        }


        return redirect('todolist/'.$toDoList->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function show(ToDoList $todolist)
    {
        return view('todolist.show',compact('todolist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function edit(ToDoList $todolist)
    {
        return view('todolist.edit',compact('todolist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDoList $todolist)
    {

        $data = $this->validateRequest($request);
        $todolist->update($data['todolist']);

        //dd($data['tasks']);
        foreach($data['tasks'] as $task){
            if(isset($task['id'])){
                $taskToUpdate = Task::find($task['id']);
                $taskToUpdate->update($task);
            }else{
                $todolist->tasks()->create($task);
            }
        }
        return redirect('todolist/'.$todolist->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDoList $todolist)
    {
        $todolist->tasks()->delete();
        $todolist->delete();
        return redirect('todolist');
    }

    private function validateRequest()
    {
        return request()->validate([
            'todolist.name'=>'required | min:3',
            'tasks.*.name'=>'required | min:3',
            'tasks.*.deadline'=>'nullable | date',
            'tasks.*.status'=>'nullable',
            'tasks.*.id'=>'nullable | numeric'
        ]);
    }
}
