@extends('CET.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Borrowed Equipments</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <!-- Action Buttons -->
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createBorrowModal">
                        <i class="fas fa-book-reader"></i> Borrow Equipment
                    </button>
                    <a href="{{ route('CET.inventory.borrow.history') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-history"></i> Borrower History
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrows as $borrow)
                                    @if (!$borrow->return_date)
                                    <tr>
                                        <td>{{ $borrow->equipment->description ?? 'No Description' }}</td>
                                        <td>{{ $borrow->student_id }}</td>
                                        <td>{{ $borrow->first_name }}</td>
                                        <td>{{ $borrow->middle_name }}</td>
                                        <td>{{ $borrow->last_name }}</td>
                                        <td>{{ $borrow->borrow_date }}</td>
                                        <td class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#editBorrowModal{{ $borrow->id }}" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('CET.inventory.borrow.return', $borrow->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm mr-2">
                                                    <i class="fas fa-box"></i> Return
                                                </button>
                                            </form>
                                            <form action="{{ route('CET.inventory.borrow.destroy', $borrow->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this borrow record?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editBorrowModal{{ $borrow->id }}" tabindex="-1" role="dialog" aria-labelledby="editBorrowModalLabel{{ $borrow->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editBorrowModalLabel{{ $borrow->id }}">Edit Borrow Record</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('CET.inventory.borrow.update', $borrow->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="equipment_id">Equipment</label>
                                                            <select name="equipment_id" class="form-control" id="equipment_id" required>
                                                                @foreach($equipment as $item)
                                                                    <option value="{{ $item->id }}" {{ $borrow->equipment_id == $item->id ? 'selected' : '' }}>{{ $item->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="student_id">Student ID</label>
                                                            <input type="text" name="student_id" class="form-control" id="student_id" value="{{ $borrow->student_id }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input type="text" name="first_name" class="form-control" id="first_name" value="{{ $borrow->first_name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="middle_name">Middle Name</label>
                                                            <input type="text" name="middle_name" class="form-control" id="middle_name" value="{{ $borrow->middle_name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="last_name">Last Name</label>
                                                            <input type="text" name="last_name" class="form-control" id="last_name" value="{{ $borrow->last_name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="borrow_date">Borrow Date</label>
                                                            <input type="date" name="borrow_date" class="form-control" id="borrow_date" value="{{ $borrow->borrow_date }}" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Borrow Record</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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

<!-- Create Borrow Modal -->
<div class="modal fade" id="createBorrowModal" tabindex="-1" role="dialog" aria-labelledby="createBorrowModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('CET.inventory.borrow.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createBorrowModalLabel">Borrow Equipment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="equipment_id">Equipment</label>
                        <select name="equipment_id" class="form-control" id="equipment_id" required>
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input type="text" name="student_id" class="form-control" id="student_id" required>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control" id="middle_name">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="borrow_date">Borrow Date</label>
                        <input type="date" name="borrow_date" class="form-control" id="borrow_date" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Borrow Equipment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
