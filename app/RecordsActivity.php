<?php

# RecordsActivity.php

namespace App;

use App\Events\ActivityLogged;
use ReflectionClass;

trait RecordsActivity
{
    /**
     * Register the necessary event listeners.
     *
     * @return void
     */
    
    public $oldAttributes = [];

    protected static function bootRecordsActivity()
    {
        foreach (self::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
            
            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
            
            static::deleting(function ($model) {
                $model->activity()->delete();
            });
        }
    }

    /**
     * Record activity for the model.
     *
     * @param  string $event
     * @return void
     */
    public function recordActivity($event)
    {
        $activity=Activity::create([
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
            'name' => $this->getActivityName($this, $event),
            'link' => $this->getActivityLink($this, $event),
            'title' => $this->getActivityTitle($this, $event),
            'changes' => $this->activityChanges(),
            'user_id' =>auth()->id()
        ]);

        event(new ActivityLogged($activity));
    }

    /**
     * Prepare the appropriate activity name.
     *
     * @param  mixed  $model
     * @param  string $action
     * @return string
     */
    protected function getActivityName($model, $action)
    {
        $name = strtolower((new ReflectionClass($model))->getShortName());

        return "{$action}_{$name}";
    }
    
      protected function getActivityLink($model, $action)
    {
        $name = strtolower((new ReflectionClass($model))->getShortName());

        return "{$action}_{$name}_link";
    }
    
       protected function getActivityTitle($model, $action)
    {
        $name = strtolower((new ReflectionClass($model))->getShortName());

        return "{$action}_{$name}_title";
    }

    /**
     * Get the model events to record activity for.
     *
     * @return array
     */
    protected static function getModelEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }

        return [
            'created','updated'
        ];
    }
    
     public function activity()
    {

        return $this->morphMany('App\Activity', 'subject')->latest();
    }
    
        /**
     * Fetch the changes to the model.
     *
     * @return array|null
     */
    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_except(
                    array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'
                ),
                'after' => array_except(
                    $this->getChanges(), 'updated_at'
                )
            ];
        }
    }
}