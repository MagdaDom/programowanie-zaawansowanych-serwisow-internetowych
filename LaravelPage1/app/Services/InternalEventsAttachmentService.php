<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\InternalEventsAttachment;
use Illuminate\Http\Request;

class InternalEventsAttachmentService
{
    public function getAttachments()
    {
        return Attachment::where('IsActive', 1)->get();
    }

    public function addToDB(Request $request, int $internalEventId)
    {
        $request->validate([
            "AttachmentId" => ["required"]
        ]);

        $model = new InternalEventsAttachment();

        $model->Title = "Attachment";
        $model->InternalEventId = $internalEventId;
        $model->AttachmentId = $request->input("AttachmentId");
        $model->IsPinned = 0;
        $model->IsActive = 1;

        $model->save();
    }
}