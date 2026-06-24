<?php

namespace App\Http\Controllers;

use App\Services\AttachmentService;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    private AttachmentService $serwis;

    public function __construct()
    {
        $this->serwis = new AttachmentService();
    }

    public function index()
    {
        return view('attachments.index', [
            'models' => $this->serwis->getAll(),
            'title' => 'Attachments'
        ]);
    }

    public function create()
    {
        return view('attachments.create', [
            'model' => $this->serwis->createModel(),
            'title' => 'Attachments'
        ]);
    }

    public function addToDB(Request $request)
    {
        $this->serwis->addToDB($request);
        return redirect('/attachments');
    }

    public function edit($id)
    {
        return view('attachments.edit', [
            'model' => $this->serwis->getById($id),
            'title' => 'Attachments'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->serwis->update($request, $id);
        return redirect('/attachments');
    }

    public function delete($id)
    {
        $this->serwis->delete($id);
        return redirect('/attachments');
    }
}