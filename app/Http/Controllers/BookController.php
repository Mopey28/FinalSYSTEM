<?php

namespace App\Http\Controllers;

use App\Models\Book; // Import the Book model
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Display the dashboard with a list of books
    public function book()
    {
        $books = Book::all();
        return view('CET.Inventory.book.book-dashboard', compact('books'));
    }

    // Show the form to create a new book
    public function create()
    {
        return view('CET.Inventory.book.create-book');
    }

    // Store a new book in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'published_year' => 'required|integer',
            'quantity' => 'required|integer|min:0', // Ensure quantity is not negative
        ]);

        // Automatically set the status to 'available'
        $validated['status'] = 'available';

        // Create the new book record
        $book = Book::create($validated);

        // Redirect back to the books dashboard with a success message
        return redirect()->route('CET.inventory.book.book-dashboard')
                        ->with('success', 'Book added successfully!');
    }

    // Show the form to edit an existing book
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('CET.Inventory.book.edit-book', compact('book'));
    }

    // Update the book details in the database
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'published_year' => 'required|integer',
            'quantity' => 'required|integer|min:0', // Ensure quantity is not negative
        ]);

        $book = Book::findOrFail($id);
        $book->update($validated);

        return redirect()->route('CET.inventory.book.book-dashboard')->with('success', 'Book updated successfully.');
    }

    // Delete a book from the database
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('CET.inventory.book.book-dashboard')->with('success', 'Book deleted successfully.');
    }

    // Import books from a CSV file
    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        // Load and parse the CSV file
        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        // Ensure the file contains at least one row of data
        if (count($data) < 1) {
            return redirect()->back()->with('error', 'The CSV file is empty.');
        }

        // Loop through each row and create a book
        foreach ($data as $index => $row) {
            // Skip the header row
            if ($index === 0) continue;

            // Ensure the row has the expected columns
            if (count($row) >= 5) {
                Book::create([
                    'title' => $row[0],
                    'author' => $row[1],
                    'genre' => $row[2],
                    'published_year' => $row[3],
                    'quantity' => max(0, intval($row[4])), // Ensure quantity is not negative
                    'status' => 'available', // Automatically set the status to 'available'
                ]);
            }
        }

        // Redirect back to the books dashboard with a success message
        return redirect()->route('CET.inventory.book.book-dashboard')->with('success', 'Books imported successfully!');
    }
}
