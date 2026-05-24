<?php

namespace App\Http\Controllers;

use App\Models\InternalEvent;
use Illuminate\Http\Request;

class InternalEventController extends Controller
{
    public function index()
    {
        $internalEvents = InternalEvent::where('IsActive', 1)->orderByDesc('Id')->get();
        return view('internalevents.index', compact('internalEvents'));
    }

    public function create()
    {
        return view('internalevents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Title' => 'required|string|max:64',
            'Link' => 'required|string|max:64',
            'IsPublic' => 'required|boolean',
            'IsCancelled' => 'required|boolean',
            'EventDateTime' => 'required|date',
            'PublishDateTime' => 'required|date',
            'ShortDescription' => 'required|string|max:128',
            'ContentHTML' => 'required|string',
            'MetaDescription' => 'nullable|string',
            'MetaTags' => 'nullable|string',
            'Notes' => 'nullable|string',
        ]);

        $data['IsActive'] = 1;
        $data['CreationDateTime'] = now();
        $data['EditDateTime'] = now();

        InternalEvent::create($data);

        return redirect()->route('internalevents.index');
    }

    public function edit(InternalEvent $internalevent)
    {
        return view('internalevents.edit', ['internalEvent' => $internalevent]);
    }

    public function update(Request $request, InternalEvent $internalevent)
    {
        $data = $request->validate([
            'Title' => 'required|string|max:64',
            'Link' => 'required|string|max:64',
            'IsPublic' => 'required|boolean',
            'IsCancelled' => 'required|boolean',
            'EventDateTime' => 'required|date',
            'PublishDateTime' => 'required|date',
            'ShortDescription' => 'required|string|max:128',
            'ContentHTML' => 'required|string',
            'MetaDescription' => 'nullable|string',
            'MetaTags' => 'nullable|string',
            'Notes' => 'nullable|string',
        ]);

        $data['EditDateTime'] = now();

        $internalevent->update($data);

        return redirect()->route('internalevents.index');
    }

    public function destroy(InternalEvent $internalevent)
    {
        $internalevent->IsActive = 0;
        $internalevent->EditDateTime = now();
        $internalevent->save();

        return redirect()->route('internalevents.index');
    }
}
