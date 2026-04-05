<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;

class StatController extends Controller
{
    public function index()
    {
        return response()->json([
            'most_viewed_books' => Book::orderByDesc('views_count')
                ->limit(5)
                ->get(['id', 'title', 'author', 'views_count']),

            'most_borrowed_books' => Book::orderByDesc('borrows_count')
                ->limit(5)
                ->get(['id', 'title', 'author', 'borrows_count']),

            'collection_state' => [
                'total_copies' => BookCopy::count(),
                'available_copies' => BookCopy::where('is_available', true)->count(),
                'damaged_copies' => BookCopy::whereIn('condition', ['poor', 'damaged'])->count(),
            ],

            'top_categories' => Category::withCount('books')
                ->orderByDesc('books_count')
                ->limit(5)
                ->get(['id', 'name', 'books_count']),
        ]);
    }
}
