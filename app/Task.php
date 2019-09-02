<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;

    protected $guarded = [];
    protected $touches = ['project'];
    protected $casts = [
        'completed' => 'boolean'
    ];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return '/tasks/' . $this->id;
    }

    public function complete()
    {
        $this->update(['completed' => true]);
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
    }

    protected function recordableEventDescription($event)
    {
        return $event == 'updated' ? ($this->completed ? 'completed' : 'incompleted') . '_task' : "{$event}_task";
    }

    protected function recordableEventIgnore($event)
    {
        return $event == 'updated' && $this->isClean('completed');
    }

}
