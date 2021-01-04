@csrf
<div class="card mb-3">
    <div class="card-header">Create New ToDo</div>
    <div class="card-body">
        <div class="form-group">
            <label for="name">ToDo List Name</label>
            <input type="text" value="{{$todolist->name??old('todolist.name')}}" class="form-control" name="todolist[name]" aria-describedby="nameHelp" placeholder="Enter name for the list" required>
            <small id="toDoListNameHelp" class="form-text text-muted">Provide some meaningful name.</small>
            @error('todolist.name')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
</div>

<div class="card mb-3 pb-3">
    <div class="card-header">Tasks</div>
    <small id="tasksHelp" class="form-text text-muted">Create tasks for this ToDo List.</small>
    <div class="card-body">
        <fieldset>
            <div class="form-group" id="fieldWrapper">
                <div class="mt-4">
                @if(old('tasks'))
                    @foreach( old('tasks') as $i => $field)
                        <label for="task{{$i}}Name">Task {{$i}} Name</label>
                        <input type="text" value="{{old('tasks.'.$i.'.name')}}"
                               class="form-control" name="tasks[ {{$i}}][name]" aria-describedby="task{{$i}}nameHelp" placeholder="Enter name for this task" required>
                        <small id="task1Help" class="form-text text-muted">Provide some meaningful name.</small>
                        @error('tasks.'.$i.'.name')
                        <small class="text-danger">{{$message}}</small><br />
                        @enderror

                        <label for="task{{$i}}Deadline">Task  {{$i}} Deadline</label>
                        <div class="input-group date" >
                            <input type="text" name="tasks[{{$i}}][deadline]" id="deadline{{$i}}" value="{{old('tasks.'.$i.'.deadline')}}" class="form-control" placeholder="Pick a deadline" autocomplete="off"/>
                        </div>
                        <small id="tasks{{$i}}DeadlineHelp" class="form-text text-muted">After this date the task will be inactive!</small>

                        @error('tasks.'.$i.'.deadline')
                        <small class="text-danger">{{$message}}</small><br />
                        @enderror

                        <div class="form-check form-check-inline">
                            <input class="form-check-input task-status" type="radio" name="tasks[{{$i}}][status]" id="status{{$i}}" id="enabled" value="active"
                                   {{old('tasks.'.$i.'.status') != 'disabled' ? 'checked' : ''}}>
                            <label class="form-check-label" for="enabled">
                                Active
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input task-status" type="radio" name="tasks[{{$i}}][status]" id="status{{$i}}" id="disabled" value="disabled"
                                   {{old('tasks.'.$i.'.status') == 'disabled' ? 'checked' : ''}}>
                            <label class="form-check-label" for="disabled">
                                Enabled
                            </label>
                        </div>
                            @error('tasks.'.$loop->iteration.'.status')
                            <small class="text-danger">{{$message}}</small><br />
                            @enderror
                        <br />
                        <p class="text-right">
                            <a href="javascript:void(0);" class="removeTaskButton btn btn-danger">Remove task</a>
                            <input type="hidden" class="taskId" value="{{ old('tasks.'.$i.'.id') }}" />
                        </p>
                    @endforeach
                @endif
                </div>
                @isset($todolist->tasks)
                    @foreach($todolist->tasks as $task)
                        <div class="mt-4">
                            <input type="hidden" readonly name="tasks[{{$loop->iteration}}][id]" value="{{$task->id}}" />
                            <label for="task{{$loop->iteration}}Name">Task {{$loop->iteration}} Name</label>
                            <input type="text" value="{{$task->name}}"
                                   class="form-control" name="tasks[{{$loop->iteration}}][name]" aria-describedby="task{{$loop->iteration}}nameHelp" placeholder="Enter name for this task" required>
                            <small id="task1Help" class="form-text text-muted">Provide some meaningful name.</small>
                            @error('tasks.'.$loop->iteration.'.name')
                            <small class="text-danger">{{$message}}</small><br />
                            @enderror

                            <label for="task{{$loop->iteration}}Deadline">Task {{$loop->iteration}} Deadline</label>
                            <div class="input-group date" >
                                <input type="text" name="tasks[{{$loop->iteration}}][deadline]" id="deadline{{$loop->iteration}}" value="{{$task->deadline}}" class="form-control" placeholder="Pick a deadline" autocomplete="off"/>
                            </div>
                            <small id="tasks{{$loop->iteration}}DeadlineHelp" class="form-text text-muted">After this date the task will be inactive!</small>

                            @if($task->deadline)
                                <script>
                                    new Pikaday({
                                        field: document.getElementById('deadline'+{{$loop->iteration}}),
                                        toString(date, format) {
                                            const day = date.getDate();
                                            const month = date.getMonth() + 1;
                                            const year = date.getFullYear();
                                            return `${year}-${month}-${day}`;
                                        },
                                        minDate: moment().toDate()
                                    }).setDate('{{$task->deadline}}')
                                </script>
                            @endif

                            @error('tasks.'.$loop->iteration.'.deadline')
                            <small class="text-danger">{{$message}}</small><br />
                            @enderror

                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tasks[{{$loop->iteration}}][status]" value="active"
                                   {{$task->status != 'disabled' ? 'checked' : ''}}>
                            <label class="form-check-label" for="exampleRadios1">
                                Active
                            </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tasks[{{$loop->iteration}}][status]" value="disabled"
                                       {{$task->status == 'disabled' ? 'checked' : ''}}>
                                <label class="form-check-label" for="exampleRadios1">
                                    Disabled
                                </label>
                            </div>
                            @error('tasks.'.$loop->iteration.'.status')
                            <small class="text-danger">{{$message}}</small><br />
                            @enderror
                            <br />
                            <p class="text-right">
                                <a href="javascript:void(0);" class="removeTaskButton destroyTaskButton btn btn-danger">Remove task</a>
                                <input type="hidden" name="tasks[{{$loop->iteration}}][id]" class="taskId" value="{{ $task->id }}" />
                            </p>
                        </div>
                    @endforeach
                @endisset
            </div>
        </fieldset>
    </div>
</div>
<div class="text-center">
    <a href="javascript:void(0);" onclick="addNewTask({{ isset($todolist) ? count($todolist->tasks) : '' }})" id="addTask" class="btn btn-primary" title="Add field">Add a task</a>
</div>
