<?php

namespace App\Http\Controllers;

use App\Services\InternalEventService;
use Illuminate\Http\Request;

class InternalEventController extends Controller
{
    public function index() {
        $serwis = new InternalEventService();

        $results = $serwis->getAll();

        return view('internalEvents.index', ["models" => $results]);
    }

    public function create() {
        return view('internalEvents.create');
    }

    public function store(Request $request) {
        $serwis = new InternalEventService();

        $serwis -> addToDb($request);

        return redirect("/internal-events");
    }
}


