<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "Tasks";
    protected $primaryKey = "Id";

    const CREATED_AT = "CreationDateTime";
    const UPDATED_AT = "EditDateTime";

    public function InternalEvent()
    {
        return $this->belongsTo(InternalEvent::class, "InternalEventId");
    }
}