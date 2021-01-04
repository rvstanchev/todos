<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use Carbon\Carbon;

class ToDoList extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function updateStatus()
    {
        $today = Carbon::now();
        $this->tasks()->where('deadline','<',$today)->update(array('status'=>'inactive'));
        
        if(count($this->tasks) == count($this->tasks()->inactive()->get())){
            $this->update(array('status'=>'inactive'));
        }elseif(count($this->tasks) == count($this->tasks()->completed()->get())){
            $this->update(array('status'=>'completed'));
        }else{
            $this->update(array('status'=>'active'));
        }
        
    }
}
