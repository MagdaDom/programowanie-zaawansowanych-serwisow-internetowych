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
        $model->IsPublic = $request->has("IsPublic");

        $model->save();
    }
}
