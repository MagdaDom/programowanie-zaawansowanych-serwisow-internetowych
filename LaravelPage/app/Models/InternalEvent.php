<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalEvent extends Model
{
    protected $table = 'internalevents';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany(Task::class, 'InternalEventId', 'Id');
    }
}
