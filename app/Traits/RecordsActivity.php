<?php

namespace App\Traits;

use App\Models\Activity;

trait RecordsActivity{

    /**
     * The project's old attributes
     *
     * @var array
     */
    public $old_attributes = [];

    /**
     * Boot the trait.
     */
    public static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function($model) use ($event){
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function($model){
                    $model->old_attributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * Fetch the model event that should trigger activity
     * 
     * @return array
     */
    protected static function recordableEvents()
    {
        if(isset(static::$recordable_events)){
            return static::$recordable_events;
        }
            
        return ['created', 'updated'];
    }

    /**
     * Get the description of the activiy
     *
     * @param string $description
     * @return string
     */
    public function activityDescription($description)
    {
        return $description = "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * The acvitity feed for the project
     *
     * @return \Illuminate\Database\Eloquent\Relationships\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * Record activity for a project
     *
     * @param string $description
     * @return void
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->owner->id,                                                                              
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' 
            ? $this->id 
            : $this->project_id
        ]);
    }

    /**
     * Fetch changes to the model
     *
     * @return array|null
     */
    public function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_except(array_diff($this->old_attributes, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(), 'updated_at'),
            ];
        }
    }

    
}