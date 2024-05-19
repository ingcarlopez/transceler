<?php

namespace App\Traits;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = auth()->user()?->id ?? 1;
            }
            if (!$model->isDirty('created_at')) {
                $model->created_at = now()->toDateTimeString();
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()?->id ?? 1;
            }
            if (!$model->isDirty('updated_at')) {
                $model->updated_at = now()->toDateTimeString();
            }
        });
    }
}
