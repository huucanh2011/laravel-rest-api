<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait UserActionTracking
{
    use SoftDeletes;

    public static function bootUserActionTracking()
    {
        static::creating(function ($model) {
            if (! $model->isDirty('created_by')) {
                $model->created_by = auth()->user()->email;
            }
        });

        static::updating(function ($model) {
            if (! $model->isDirty('update_by')) {
                $model->update_by = auth()->user()->email;
            }
        });

        static::deleting(function ($model) {
            if (! $model->isDirty('deleted_by')) {
                $model->deleted_by = auth()->user()->email;
                $model->save();
            }
        });
    }
}
