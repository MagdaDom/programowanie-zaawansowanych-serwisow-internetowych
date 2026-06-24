<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private TaskService $serwis;

    public function __construct()
    {
        $this->serwis = new TaskService();
    }

    public function index()
    {
        return view('tasks.index', [
            'models' => $this->serwis->getAll(),
            'title' => 'Tasks'
        ]);
    }

    public function create()
    {
        return view('tasks.create', [
            'model' => $this->serwis->createModel(),
            'internalEvents' => $this->serwis->getInternalEvents(),
            'title' => 'Tasks'
        ]);
    }

    public function addToDB(Request $request)
    {
        $this->serwis->addToDB($request);

        return redirect('/tasks');
    }

    public function edit($id)
    {
        return view('tasks.edit', [
            'model' => $this->serwis->getById($id),
            'internalEvents' => $this->serwis->getInternalEvents(),
            'title' => 'Tasks'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->serwis->update($request, $id);

        return redirect('/tasks');
    }

    public function delete($id)
    {
        $this->serwis->delete($id);

        return redirect('/tasks');
    }
}