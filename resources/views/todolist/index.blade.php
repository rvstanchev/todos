@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="card-header">Saved ToDos</div>
                        <div class="card-body">
                            <ol>
                                @forelse($toDoLists as $todolist )
                                    <li><a href="{{ route('todolist.show', ['todolist'=>$todolist]) }}">{{$todolist->name}}</a> ({{$todolist->status}}, {{count($todolist->tasks)}} task\s)</li>
                                @empty
                                    No ToDos saved!
                                @endforelse
                            </ol>
                            <div class="text-center">
                                {{$toDoLists->links()}}<br />
                                <a href="{{ route('todolist.create') }}" class="btn btn-primary">Create New ToDo</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
