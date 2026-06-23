<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $news = $query
            ->where(function ($query) {
                $query->whereNull('publish_from')
                      ->orWhere('publish_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('publish_until')
                      ->orWhere('publish_until', '>=', now());
            })
            ->orderByDesc('created_at')
            ->get();

        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'publish_from' => 'nullable|date',
            'publish_until' => 'nullable|date|after_or_equal:publish_from',
        ]);

        $validated['user_id'] = Auth::id();

        News::create($validated);

        return redirect()->route('news.index')
            ->with('success', 'Aktualność została dodana.');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'publish_from' => 'nullable|date',
            'publish_until' => 'nullable|date|after_or_equal:publish_from',
        ]);

        $news->update($validated);

        return redirect()->route('news.index')
            ->with('success', 'Aktualność została zaktualizowana.');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'Aktualność została usunięta.');
    }
}