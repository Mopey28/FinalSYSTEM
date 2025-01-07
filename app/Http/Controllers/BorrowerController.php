<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Book;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    // Display the borrowers page
    public function index()
    {
        // Fetch only borrowers with no return_date (active borrows)
        $borrowers = Borrower::with('book')->whereNull('return_date')->get();
        return view('CET.inventory.book.borrowers-book', compact('borrowers'));
    }

    public function history()
    {
        // Fetch all returned books
        $history = Borrower::with('book')->whereNotNull('return_date')->get();
        return view('CET.inventory.book.borrowers-history', compact('history'));
    }

    // Store a borrower (borrow a book)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50',
            'borrow_date' => 'required|date',
        ]);

        // Find the book
        $book = Book::find($validated['book_id']);

        // Check if the student has already borrowed the maximum number of books
        $borrowedCount = Borrower::where('student_id', $validated['student_id'])
                               ->whereNull('return_date')
                               ->count();

        if ($borrowedCount >= 2) {
            return redirect()->back()->with('error', 'This student has already borrowed the maximum number of books.');
        }

        // Check if the book has quantity
        if ($book->quantity > 0) {
            // Borrow the book
            Borrower::create($validated);

            // Update the book quantity
            $book->quantity -= 1;
            $book->save();

            return redirect()->route('CET.inventory.borrowers.index')->with('success', 'Book borrowed successfully!');
        } else {
            return redirect()->back()->with('error', 'Book is not available for borrowing.');
        }
    }

    // Mark a book as returned and set the return date
    public function setReturn(Request $request, $id)
    {
        $request->validate([
            'return_date' => 'required|date',
        ]);

        $borrower = Borrower::findOrFail($id);

        // Check if the borrower already has a return date
        if ($borrower->return_date) {
            return redirect()->back()->with('error', 'This book has already been returned.');
        }

        // Set the return date
        $borrower->return_date = $request->return_date;
        $borrower->save();

        // Update the book quantity
        $book = $borrower->book;
        $book->quantity += 1;
        $book->save();

        return redirect()->route('CET.inventory.borrowers.index')->with('success', 'Return date set successfully!');
    }
}
