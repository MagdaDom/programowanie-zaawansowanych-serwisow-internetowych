<?php

namespace App\Services;

use App\Models\InternalEvent;
use Carbon\Exceptions\InvalidTimeZoneException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class InternalEventService
{
    public function get() {
        return InternalEvent::all();
    }

    public function getAll() {
        return InternalEvent::all();
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            "Title" => ["required", "max:256"],
            "Link" => ["required", "max:128"],
            "ContentHTML" => ["required"],
            "EventDateTime" => ["required", "date"],
            "PublishDateTime" => ["required", "date"],
            "MetaTags" => ["required", "max:128"],
            "Notes" => ["required", "max:128"],
            "MetaDescription" => ["required", "max:128"],
            "ShortDescription" => ["required", "max:128"],
            //"IsCancelled" => ["required"],
            //"IsPublic" => ["required"],
        ]);

        $model = InternalEvent::findOrFail($id);

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
        $model->IsCancelled = $request->has("IsCancelled") ? 1 : 0;

        $model->save();
    }

    public function getById(int $id) : InternalEvent
    {
        return InternalEvent::find($id);
    }

    public function createModel() {
        $model = new InternalEvent();
        $model->EventDateTime = date("Y-m-d");
        $model->PublishDateTime = date("Y-m-d");
        return $model;
    }

    public function addToDB(Request $request) {

        $request->validate([
            "Title" => ["required", "max:256"],
            "Link" => ["required", "max:128"],
            "Description" => ["required", "max:128"],
            "EventDateTime" => ["required", "datetime"],
            "PublishDateTime" => ["required", "datetime"],
            "IsActive" => ["required", "boolean"],
            "MetaTags" => ["required", "max:128"],
            "Notes" => ["required", "max:128"],
            "MetaDescription" => ["required", "max:128"],
            "ContentHTML" => ["required", "max:128"],
            "ShortDescription" => ["required", "max:128"],
        ]); //podajemy tutaj reguły walidacji pól
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
