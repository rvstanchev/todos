@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="card-header"><span class="font-weight-bold">ToDo List:</span> {{$todolist->name}}</div>
                    <div class="card-body">
                        <p><span class="font-weight-bold">List Status: </span>
                            @if($todolist->status=="inactive")
                            <span class="text-danger">inactive</span>
                            @else
                            {{$todolist->status}}
                            @endif
                        </p>
                        <p><span class="font-weight-bold">Tasks:</span> </p>
                        <ol>
                        @forelse($todolist->tasks as $task)
                            <li>
                                <strong>{{$task->name}}</strong>:
                                @if($task->deadline)
                                    @if($task->deadline < date('Y-m-d'))
                                        inactive (deadline has passed)
                                    @else
                                        valid through {{ \Carbon\Carbon::parse($task->deadline)->format('d-m-Y') }}
                                    @endif
                                @else
                                    no deadline set
                                @endif
                                 |
                                @if($task->status == 'inactive')
                                    <span class="text-danger">{{$task->status}}</span>
                                @else
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input task-status" type="radio" name="task{{$task->id}}Status" id="task{{$task->id}}StatusCompleted" value="completed"
                                               {{$task->status == 'completed' ? 'checked' : ''}} data-id="{{$task->id}}"
                                               {{$task->status == 'disabled' ? 'disabled' : ''}} >
                                        <label class="form-check-label" for="task{{$task->id}}StatusCompleted">
                                            Completed
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input task-status" type="radio" name="task{{$task->id}}Status" id="task{{$task->id}}StatusActive" value="active"
                                            {{$task->status == 'active' ? 'checked' : ''}} data-id="{{$task->id}}"
                                            {{$task->status == 'disabled' ? 'disabled' : ''}} >
                                        <label class="form-check-label" for="task{{$task->id}}StatusActive">
                                            In Progress
                                        </label>
                                    </div>
                                @endif
                                <small id="response{{$task->id}}" class="ml-2"></small>
                            </li>
                        @empty
                            This ToDo List has no tasks!
                        @endforelse
                        </ol>
                        <div class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('todolist.index') }}" class="btn btn-primary mr-1"><< Go back</a>
                                @if($todolist->status != 'inactive')
                                    <a href="{{ route('todolist.edit',['todolist'=>$todolist->id]) }}" class="btn btn-primary mr-1">Edit this list</a>
                                @endif

                                <form method="post" action="{{ route('todolist.destroy',['todolist'=>$todolist->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete this list</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="resp"></div>


            </div>
        </div>
    </div>
@endsection
