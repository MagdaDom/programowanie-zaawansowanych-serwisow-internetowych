<?php

namespace App\Services;

use App\Models\InternalEvent;
use Carbon\Exceptions\InvalidTimeZoneException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class InternalEventService
{
    public function getAll() {
        return InternalEvent::all();
    }

    public function getNewestEvents() : Collection
    {
        return InternalEvent::where('IsActive', "=", true)->get();
    }

    public function addToDB(Request $request) {
        $model = new InternalEvent();
        $model->Title = $request->input("Title");
        $model->Link = $request->input("Link");
        $model->MetaTags = $request->input("MetaTags");
        $model->Notes = $request->input("Notes");
        $model->MetaDescription = $request->input("MetaDescription");
        $model->ContentHTML = $request->input("ContentHTML");
        $model->ShortDescription = $request->input("ShortDescription");
        $model->EventDateTime = $request->input("EventDateTime");
        $model->PublishDateTime = $request->input("PublishDateTime");

        $model->IsPublic = $request->has("IsPublic") ? 1 : 0;
        $model->IsCancelled  = $request->has("IsCancelled") ? 1 : 0;
        $model->IsActive = 1;

        $model->save();
    }
}
