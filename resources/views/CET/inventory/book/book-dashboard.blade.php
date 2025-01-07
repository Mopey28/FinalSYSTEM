@extends('CET.layouts.header')

@section('content')
<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Books</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <!-- Action Buttons -->
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createBookModal">
                        <i class="fas fa-plus"></i> Add Book
                    </button>
                    <button class="btn btn-success" data-toggle="modal" data-target="#importCSVModal">
                        <i class="fas fa-file-upload"></i> Import CSV
                    </button>
                    <a href="{{ route('CET.inventory.borrowers.index') }}" class="btn btn-info">
                        <i class="fas fa-users"></i> Borrowers
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <!-- Books Table -->
                            <table class="table table-bordered" id="booksTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Genre</th>
                                        <th>Published Year</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($books as $book)
                                        <tr data-id="{{ $book->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>{{ $book->genre }}</td>
                                            <td>{{ $book->published_year }}</td>
                                            <td>{{ $book->quantity }}</td>
                                            <td>{{ ucfirst($book->status) }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editBookModal-{{ $book->id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <form action="{{ route('CET.inventory.book.destroy', $book->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?');">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>

                                                <!-- Borrow Button -->
                                                @if ($book->quantity > 0)
                                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#borrowBookModal-{{ $book->id }}">
                                                        <i class="fas fa-book-reader"></i> Borrow
                                                    </button>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        <i class="fas fa-book-reader"></i> Borrowed
                                                    </button>
                                                @endif
                                            </td>

                                        <!-- Edit Book Modal -->
                                        <div class="modal fade" id="editBookModal-{{ $book->id }}" tabindex="-1" aria-labelledby="editBookModalLabel-{{ $book->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('CET.inventory.book.update', $book->id) }}" method="POST" id="editBookForm-{{ $book->id }}" data-id="{{ $book->id }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editBookModalLabel-{{ $book->id }}">Edit Book</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="title">Title</label>
                                                                <input type="text" name="title" id="title" class="form-control" value="{{ $book->title }}" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="author">Author</label>
                                                                <input type="text" name="author" id="author" class="form-control" value="{{ $book->author }}" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="genre">Genre</label>
                                                                <input type="text" name="genre" id="genre" class="form-control" value="{{ $book->genre }}" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="published_year">Published Year</label>
                                                                <input type="number" name="published_year" id="published_year" class="form-control" value="{{ $book->published_year }}" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="quantity">Quantity</label>
                                                                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $book->quantity }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Book</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Borrow Book Modal -->
                                        <div class="modal fade" id="borrowBookModal-{{ $book->id }}" tabindex="-1" aria-labelledby="borrowBookModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('CET.inventory.borrowers.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="borrowBookModalLabel">Borrow Book</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="student_id">Student ID</label>
                                                                <input type="text" name="student_id" id="student_id" class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="first_name">First Name</label>
                                                                <input type="text" name="first_name" id="first_name" class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="middle_name">Middle Name</label>
                                                                <input type="text" name="middle_name" id="middle_name" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="last_name">Last Name</label>
                                                                <input type="text" name="last_name" id="last_name" class="form-control" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="borrow_date">Borrow Date</label>
                                                                <input type="date" name="borrow_date" id="borrow_date" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Confirm Borrow</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <tr>
                                            <td colspan="8">No books found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Create Book Modal -->
                            <div class="modal fade" id="createBookModal" tabindex="-1" aria-labelledby="createBookModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="createBookForm" action="{{ route('CET.inventory.book.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="createBookModalLabel">Create Book</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" class="form-control" required />
                                                </div>
                                                <div class="form-group">
                                                    <label for="author">Author</label>
                                                    <input type="text" name="author" id="author" class="form-control" required />
                                                </div>
                                                <div class="form-group">
                                                    <label for="genre">Genre</label>
                                                    <input type="text" name="genre" id="genre" class="form-control" required />
                                                </div>
                                                <div class="form-group">
                                                    <label for="published_year">Published Year</label>
                                                    <input type="number" name="published_year" id="published_year" class="form-control" required />
                                                </div>
                                                <div class="form-group">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="number" name="quantity" id="quantity" class="form-control" required />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add Book</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Import CSV Modal -->
                            <div class="modal fade" id="importCSVModal" tabindex="-1" aria-labelledby="importCSVModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="importCSVForm" action="{{ route('CET.inventory.book.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="importCSVModalLabel">Import Books from CSV</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="csv_file">Upload CSV File</label>
                                                    <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Import</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
// AJAX form submission for creating a book
document.getElementById('createBookForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('{{ route("CET.inventory.book.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close the modal
            $('#createBookModal').modal('hide');

            // Add the new book to the table
            const table = document.querySelector('#booksTable tbody');
            const newRow = `
                <tr data-id="${data.book.id}">
                    <td>${data.book.id}</td>
                    <td>${data.book.title}</td>
                    <td>${data.book.author}</td>
                    <td>${data.book.genre}</td>
                    <td>${data.book.published_year}</td>
                    <td>${data.book.quantity}</td>
                    <td>${data.book.status}</td>
                    <td>
                        <!-- Add Edit and Delete buttons here if needed -->
                    </td>
                </tr>`;
            table.insertAdjacentHTML('beforeend', newRow);
            // Optionally, reset the form
            document.getElementById('createBookForm').reset();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// AJAX form submission for editing a book
document.querySelectorAll('form[id^=editBookForm]').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const bookId = this.getAttribute('data-id');

        fetch(`{{ url('CET/Inventory/Book/Update') }}/${bookId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close the modal
                $(`#editBookModal-${bookId}`).modal('hide');

                // Update the table row with new data
                const row = document.querySelector(`#booksTable tbody tr[data-id="${bookId}"]`);
                row.querySelector('td:nth-child(2)').innerText = data.book.title;
                row.querySelector('td:nth-child(3)').innerText = data.book.author;
                row.querySelector('td:nth-child(4)').innerText = data.book.genre;
                row.querySelector('td:nth-child(5)').innerText = data.book.published_year;
                row.querySelector('td:nth-child(6)').innerText = data.book.quantity;
                row.querySelector('td:nth-child(7)').innerText = data.book.status;

                alert('Book updated successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

// Handle CSV import form submission
document.getElementById('importCSVForm').addEventListener('submit', function (e) {
    const fileInput = document.getElementById('csv_file');
    if (!fileInput.value) {
        e.preventDefault();
        alert('Please select a CSV file to upload.');
    }
});
</script>
@endsection
