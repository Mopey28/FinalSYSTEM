@extends('CET.layouts.header')

@section('content')
<div class="content">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Borrowers History</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('CET.inventory.borrowers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Borrowers
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($history as $record)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $record->book->title }}</td>
                                            <td>{{ $record->first_name }}</td>
                                            <td>{{ $record->middle_name }}</td>
                                            <td>{{ $record->last_name }}</td>
                                            <td>{{ $record->student_id }}</td>
                                            <td>{{ $record->borrow_date }}</td>
                                            <td>{{ $record->return_date }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No history found.</td>
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
