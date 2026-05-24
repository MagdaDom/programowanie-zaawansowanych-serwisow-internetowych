<?php

namespace App\Http\Controllers;

use App\Models\InternalEvent;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('internalEvent')->orderByDesc('Id')->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $internalEvents = InternalEvent::orderBy('Title')->get();
        return view('tasks.create', compact('internalEvents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'Title' => 'required|string|max:64',
            'IsDone' => 'required|boolean',
            'StartDateTime' => 'required|date',
            'Description' => 'required|string',
            'Deadline' => 'required|date',
            'InternalEventId' => 'required|exists:internalevents,Id',
            'Notes' => 'nullable|string',
            'IsActive' => 'required|boolean',
        ]);

        $data['CreationDateTime'] = now();
        $data['EditDateTime'] = now();

        Task::create($data);

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task) //edit(string $id)
    {
        $internalEvents = InternalEvent::orderBy('Title')->get();
        return view('tasks.edit', compact('task', 'internalEvents'));
    }

    /**
     * Update the specified resource in storage.
     */
    //public function update(Request $request, string $id)
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'Title' => 'required|string|max:64',
            'IsDone' => 'required|boolean',
            'StartDateTime' => 'required|date',
            'Description' => 'required|string',
            'Deadline' => 'required|date',
            'InternalEventId' => 'required|exists:internalevents,Id',
            'Notes' => 'nullable|string',
            'IsActive' => 'required|boolean',
        ]);

        $data['EditDateTime'] = now();

        $task->update($data);

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(string $id)
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
