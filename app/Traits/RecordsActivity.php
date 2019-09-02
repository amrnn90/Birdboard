<?php

namespace App\Traits;

use App\Activity;
use App\Project;

trait RecordsActivity {

    static $recordableEvents = ['created', 'updated'];

    public static function bootRecordsActivity() 
    {
        foreach (static::$recordableEvents as $event) {
            static::$event(function($model) use ($event) {
                if (!$model->recordableEventIgnore($event)) {
                    $model->recordActivity($model->recordableEventDescription($event));
                }
            });
        }
    }

    public function recordActivity($type)
    {
        $activity = $this->activity()->make([
            'description' => $type,
            'project_id' => class_basename($this) == 'Project' ? $this->id : $this->project_id,
            'user_id' => auth()->id() ?? ($this->project ?? $this)->owner_id
        ]);

        if ($this->wasChanged()) {
            $activity->diff = $this->activityChanges();
        }

        $activity->save();
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function activityChanges()
    {
        return [
            'before' => array_except(array_diff($this->getOriginal(), $this->attributes), 'updated_at'),
            'after' => array_except($this->getChanges(), 'updated_at')
        ];
    }

    protected function recordableEventDescription($event) 
    {
        return "${event}_" . strtolower(class_basename($this));
    }

    protected function recordableEventIgnore($event) 
    {
        return false;
    }
}