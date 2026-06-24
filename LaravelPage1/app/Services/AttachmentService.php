<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentService
{
    public function getAll()
    {
        return Attachment::where('IsActive', 1)->get();
    }

    public function getById(int $id): Attachment
    {
        return Attachment::findOrFail($id);
    }

    public function createModel()
    {
        return new Attachment();
    }

    public function addToDB(Request $request)
    {
        $request->validate([
            "Title" => ["required", "max:64"],
            "Link" => ["required", "max:64"],
            "ContentHTML" => ["required"],
            "Notes" => ["nullable"],
        ]);

        $model = new Attachment();
        $model->Title = $request->input("Title");
        $model->Link = $request->input("Link");
        $model->ContentHTML = $request->input("ContentHTML");
        $model->Notes = $request->input("Notes");
        $model->IsActive = 1;
        $model->save();
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            "Title" => ["required", "max:64"],
            "Link" => ["required", "max:64"],
            "ContentHTML" => ["required"],
            "Notes" => ["nullable"],
        ]);

        $model = Attachment::findOrFail($id);
        $model->Title = $request->input("Title");
        $model->Link = $request->input("Link");
        $model->ContentHTML = $request->input("ContentHTML");
        $model->Notes = $request->input("Notes");
        $model->save();
    }

    public function delete(int $id)
    {
        $model = Attachment::findOrFail($id);
        $model->IsActive = 0;
        $model->save();
    }
}