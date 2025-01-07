@extends('CET.layouts.header')

@section('content')
<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Borrowers</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('CET.inventory.book.book-dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Books
                    </a>
                    <a href="{{ route('CET.inventory.borrowers.history') }}" class="btn btn-primary">
                        Borrowers History
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Book Title</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Student ID</th>
                                        <th>Borrow Date</th>
                                        <th>Return Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($borrowers as $borrower)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $borrower->book->title }}</td>
                                            <td>{{ $borrower->first_name }}</td>
                                            <td>{{ $borrower->middle_name }}</td>
                                            <td>{{ $borrower->last_name }}</td>
                                            <td>{{ $borrower->student_id }}</td>
                                            <td>{{ $borrower->borrow_date }}</td>
                                            <td>{{ $borrower->return_date }}</td>
                                            <td>
                                                @if (!$borrower->return_date)
                                                    <button
                                                        class="btn btn-success btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#setReturnModal-{{ $borrower->id }}">
                                                        Set Return
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Set Return Modal -->
                                        <div class="modal fade" id="setReturnModal-{{ $borrower->id }}" tabindex="-1" role="dialog" aria-labelledby="setReturnModalLabel-{{ $borrower->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('CET.inventory.borrowers.return', $borrower->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="setReturnModalLabel-{{ $borrower->id }}">Set Return Date</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="return_date-{{ $borrower->id }}">Return Date</label>
                                                                <input
                                                                    type="date"
                                                                    name="return_date"
                                                                    id="return_date-{{ $borrower->id }}"
                                                                    class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Set Return</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="9">No borrowers found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
