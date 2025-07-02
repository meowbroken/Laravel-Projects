<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Review;

class LibrettoController extends Controller
{
    // Fetch all authors
    public function authors()
    {
        return Author::all();
    }

    // Fetch all books
    public function books()
    {
        return Book::all();
    }

    // Fetch all genres
    public function genres()
    {
        return Genre::all();
    }

    // Fetch all reviews
    public function reviews()
    {
        return Review::all();
    }

    // Store a new author
    public function storeAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return Author::create($request->all());
    }

    // Store a new book
    public function storeBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        return Book::create($request->all());
    }

    // Store a new genre
    public function storeGenre(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return Genre::create($request->all());
    }

    // Store a new review
    public function storeReview(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'book_id' => 'required|exists:books,id',
        ]);

        return Review::create($request->all());
    }
}