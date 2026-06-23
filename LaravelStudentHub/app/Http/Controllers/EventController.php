<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function home()
    {
        $events = Event::orderBy('start_date')->take(3)->get();
        return view('home', compact('events'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        $events = $query->orderBy('start_date')->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|min:3|max:255',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $validated['user_id'] = Auth::id();

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Wydarzenie zostało dodane.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'required|min:3|max:255',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Wydarzenie zostało zaktualizowane.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Wydarzenie zostało usunięte.');
    }

    public function register(Event $event)
    {
        if ($event->max_participants && $event->participants()->count() >= $event->max_participants) {
            return back()->with('error', 'Brak wolnych miejsc.');
        }

        if ($event->participants()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Jesteś już zapisany/a na to wydarzenie.');
        }

        $event->participants()->attach(Auth::id());

        return back()->with('success', 'Zapisano na wydarzenie.');
    }
}
