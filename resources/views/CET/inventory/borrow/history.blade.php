@extends('CET.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Borrowers History</h1>
                </div>
                <div class="col-sm-6 d-flex justify-content-end align-items-center">
                    <a href="{{ route('CET.inventory.borrow.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Borrowed Equipments
                    </a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Equipment Description</th>
                                        <th>Student ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Borrow Date</th>
                                        <th>Return Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrows as $borrow)
                                    <tr>
                                        <td>{{ $borrow->equipment->description ?? 'No Description' }}</td>
                                        <td>{{ $borrow->student_id }}</td>
                                        <td>{{ $borrow->first_name }}</td>
                                        <td>{{ $borrow->middle_name }}</td>
                                        <td>{{ $borrow->last_name }}</td>
                                        <td>{{ $borrow->borrow_date }}</td>
                                        <td>{{ $borrow->return_date }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div>
@endsection
