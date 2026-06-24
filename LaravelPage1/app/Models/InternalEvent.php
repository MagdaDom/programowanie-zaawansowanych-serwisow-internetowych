<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalEvent extends Model
{
    protected $table = "InternalEvents";
    protected $primaryKey = "Id";

    const CREATED_AT = "CreationDateTime";
    const UPDATED_AT = "EditDateTime";

    public function InternalEventsAttachments()
    {
        return $this->hasMany(
            InternalEventsAttachment::class,
            "InternalEventId"
        );
    }
}