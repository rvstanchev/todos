<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $activeTasks = Task::where('status','active');
    }

    public function scopeInactive($query)
    {
        return $inactiveTasks = Task::where('status','inactive');
    }

    public function scopeCompleted($query)
    {
        return $completedTasks = Task::where('status','completed');
    }

    public function toDoList()
    {
        return $this->belongsTo(ToDoList::class);
    }
}
