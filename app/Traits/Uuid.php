<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id = Str::uuid();
            } catch (\Exception $ex) {
                abort(500, $ex->getMessage());
            }
        });
    }

}
