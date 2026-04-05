<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookCopyRequest;
use App\Http\Requests\UpdateBookCopyRequest;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Http\Request;

class BookCopyController extends Controller
{
    public function index(Request $request, Book $book)
    {
        $query = $book->copies();

        $allowedConditions = ['excellent', 'good', 'fair', 'poor', 'damaged'];

        if ($request->filled('condition')) {
            $condition = $request->input('condition');
            if (in_array($condition, $allowedConditions, true)) {
                $query->where('condition', $condition);
            }
        }

        if ($request->input('filter') === 'damaged') {
            $query->whereIn('condition', ['poor', 'damaged']);
        }

        return response()->json($query->get());
    }

    public function show(Book $book, BookCopy $copy)
    {
        return response()->json($copy->load('book'));
    }

    public function store(StoreBookCopyRequest $request, Book $book)
    {
        $copy = $book->copies()->create($request->validated());
        return response()->json($copy, 201);
    }

    public function update(UpdateBookCopyRequest $request, Book $book, BookCopy $copy)
    {
        $copy->update($request->validated());
        return response()->json($copy);
    }

    public function destroy(Book $book, BookCopy $copy)
    {
        $copy->delete();
        return response()->json(['message' => 'Exemplaire supprimé avec succès.']);
    }
}
