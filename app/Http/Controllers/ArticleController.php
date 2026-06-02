<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('published_at', 'desc')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|in:artikel,khotbah,dokumentasi',
            'image_path' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['published_at'] = now();

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel/Khotbah berhasil diterbitkan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|in:artikel,khotbah,dokumentasi',
            'image_path' => 'nullable|string',
        ]);

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel/Khotbah berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel/Khotbah berhasil dihapus.');
    }
}
