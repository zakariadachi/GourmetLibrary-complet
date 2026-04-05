<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $term = '%' . addcslashes($search, '%_\\') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                  ->orWhere('author', 'like', $term)
                  ->orWhereHas('category', fn($q) => $q->where('name', 'like', $term));
            });
        }

        $sort = in_array($request->sort, ['popular', 'latest']) ? $request->sort : null;
        if ($sort === 'popular') {
            $query->orderByDesc('borrows_count');
        } elseif ($sort === 'latest') {
            $query->latest();
        }

        return response()->json($query->get());
    }

    public function byCategory(Category $category, Request $request)
    {
        $query = $category->books()->with('category');

        $sort = in_array($request->sort, ['popular', 'latest']) ? $request->sort : null;
        if ($sort === 'popular') {
            $query->orderByDesc('borrows_count');
        } elseif ($sort === 'latest') {
            $query->latest();
        }

        return response()->json($query->get());
    }

    public function show(Category $category, Book $book)
    {
        $book->incrementViews();
        return response()->json($book->load('category', 'copies'));
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        return response()->json(Book::create($data), 201);
    }

    public function update(UpdateBookRequest $request, Category $category, Book $book)
    {
        $data = $request->validated();
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        $book->update($data);
        return response()->json($book);
    }

    public function destroy(Category $category, Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Livre supprimé avec succès.']);
    }
}
