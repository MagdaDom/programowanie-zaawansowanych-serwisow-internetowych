<?php

namespace App\Http\Controllers;

use App\Services\InternalEventService;
use Illuminate\Http\Request;
use App\Models\InternalEvent;

class InternalEventController extends Controller
{
    private InternalEventService $serwis;

    public function __construct() {
        $this->serwis = new InternalEventService();
    }

    public function index() {
        //$serwis = new InternalEventService();

        $results = $this->serwis->getAll();

        return view('internalEvents.index', ["models" => $results]);
    }

    public function create() {
        return view('internalEvents.create');
    }

    public function store(Request $request) {
        //$serwis = new InternalEventService();

        $this->serwis -> addToDb($request);

        return redirect("/internal-events");
    }

    public function edit($id) {
        //$serwis = new InternalEventService();

        return view('internalEvents.edit', ["model" => $this->serwis->getById($id)]);
    }

    public function editView($id) {
        $model = $this->serwis->getById($id);
        return view('InternalEvents.edit', ['model' => $model, 'title'=>'Internal events']);
    }

    public function update(Request $request, $id) {
        $this->serwis->update($request, $id);
        return redirect("/internal-events");
    }

    public function createView() {
        $model = $this->serwis->createModel();
        return view('InternalEvents.create', ['title'=>'Internal events', 'model' => $model]);
    }

    public function addToDb(Request $request) {
        $this->serwis->addToDb($request);
        return redirect("InternalEvents");
    }
}


