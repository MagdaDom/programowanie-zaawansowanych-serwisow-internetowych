<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function home()
    {
        $events = Event::where('event_date', '>=', now())
            ->where(function ($query) {
                $query->whereNull('publish_from')
                    ->orWhere('publish_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('publish_until')
                    ->orWhere('publish_until', '>=', now());
            })
            ->orderBy('event_date')
            ->take(3)
            ->get();

        return view('home', compact('events'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $upcomingEvents = (clone $query)
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->get();

        $pastEvents = (clone $query)
            ->where('event_date', '<', now())
            ->orderByDesc('event_date')
            ->get();

        return view('events.index', compact('upcomingEvents', 'pastEvents'));
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
            'short_description' => 'nullable|max:500',
            'html_content' => 'required|min:10',
            'image_path' => 'nullable|max:255',
            'event_date' => 'required|date',
            'publish_from' => 'nullable|date',
            'publish_until' => 'nullable|date|after_or_equal:publish_from',
            'requires_registration' => 'nullable|boolean',
            'max_participants' => 'nullable|integer|min:1|required_if:requires_registration,1',
            'recurrence' => 'required|in:none,weekly,monthly,yearly',
        ]);

        $validated['requires_registration'] = $request->boolean('requires_registration');
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
            'short_description' => 'nullable|max:500',
            'html_content' => 'required|min:10',
            'image_path' => 'nullable|max:255',
            'event_date' => 'required|date',
            'publish_from' => 'nullable|date',
            'publish_until' => 'nullable|date|after_or_equal:publish_from',
            'requires_registration' => 'nullable|boolean',
            'max_participants' => 'nullable|integer|min:1|required_if:requires_registration,1',
            'recurrence' => 'required|in:none,weekly,monthly,yearly',
        ]);

        $validated['requires_registration'] = $request->boolean('requires_registration');

        if (!$validated['requires_registration']) {
            $validated['max_participants'] = null;
        }

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
        if (!$event->requires_registration) {
            return back()->with('error', 'To wydarzenie nie wymaga zapisów.');
        }

        if ($event->event_date < now()) {
            return back()->with('error', 'Nie można zapisać się na wydarzenie historyczne.');
        }

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
