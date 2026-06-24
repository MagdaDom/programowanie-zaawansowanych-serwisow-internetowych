<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalEventsAttachment extends Model
{
    protected $table = "InternalEventsAttachments";
    protected $primaryKey = "Id";

    const CREATED_AT = "CreationDateTime";
    const UPDATED_AT = "EditDateTime";

    public function InternalEvent()
    {
        return $this->belongsTo(InternalEvent::class, "InternalEventId");
    }

    public function Attachment()
    {
        return $this->belongsTo(Attachment::class, "AttachmentId");
    }
}