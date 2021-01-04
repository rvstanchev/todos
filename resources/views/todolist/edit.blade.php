@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form action="{{ route('todolist.update',['todolist'=>$todolist]) }}" method="post">
                    @method('PATCH')
                    @include('todolist.form')
                    <div class='text-center mt-5'>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
