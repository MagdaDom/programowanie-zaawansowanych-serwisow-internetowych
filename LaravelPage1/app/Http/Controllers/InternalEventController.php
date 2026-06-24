<?php

namespace App\Http\Controllers;

use App\Services\InternalEventService;
use App\Services\InternalEventsAttachmentService;
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

        $this->serwis -> addToDB($request);

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

    public function addToDB(Request $request) {
        $this->serwis->addToDB($request);
        return redirect("InternalEvents");
    }

    public function delete($id)
    {
        $this->serwis->delete($id);
        return redirect('/internal-events');
    }

    public function addAttachment($id)
    {
        $service = new InternalEventsAttachmentService();

        return view(
            'internalEvents.addAttachment',
            [
                'attachments' => $service->getAttachments(),
                'internalEventId' => $id,
                'title' => 'Internal events'
            ]
        );
    }

    public function addAttachmentToDB(Request $request, $id)
    {
        $service = new InternalEventsAttachmentService();

        $service->addToDB($request, $id);

        return redirect('/internal-events/edit/' . $id);
    }
}


