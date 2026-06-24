<?php

namespace App\Services;

use App\Models\Task;
use App\Models\InternalEvent;
use Illuminate\Http\Request;

class TaskService
{
    public function getAll()
    {
        return Task::where('IsActive', 1)->get();
    }

    public function getById(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function getInternalEvents()
    {
        return InternalEvent::where('IsActive', 1)->get();
    }

    public function createModel()
    {
        return new Task();
    }

    public function addToDB(Request $request)
    {
        $request->validate([
            "Title" => ["required", "max:64"],
            "StartDateTime" => ["required", "date"],
            "Description" => ["required"],
            "Deadline" => ["required", "date"],
            "InternalEventId" => ["required"],
            "Notes" => ["nullable"],
        ]);

        $model = new Task();
        $model->Title = $request->input("Title");
        $model->IsDone = $request->has("IsDone") ? 1 : 0;
        $model->StartDateTime = $request->input("StartDateTime");
        $model->Description = $request->input("Description");
        $model->Deadline = $request->input("Deadline");
        $model->InternalEventId = $request->input("InternalEventId");
        $model->Notes = $request->input("Notes");
        $model->IsActive = 1;
        $model->save();
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            "Title" => ["required", "max:64"],
            "StartDateTime" => ["required", "date"],
            "Description" => ["required"],
            "Deadline" => ["required", "date"],
            "InternalEventId" => ["required"],
            "Notes" => ["nullable"],
        ]);

        $model = Task::findOrFail($id);
        $model->Title = $request->input("Title");
        $model->IsDone = $request->has("IsDone") ? 1 : 0;
        $model->StartDateTime = $request->input("StartDateTime");
        $model->Description = $request->input("Description");
        $model->Deadline = $request->input("Deadline");
        $model->InternalEventId = $request->input("InternalEventId");
        $model->Notes = $request->input("Notes");
        $model->save();
    }

    public function delete(int $id)
    {
        $model = Task::findOrFail($id);
        $model->IsActive = 0;
        $model->save();
    }
}