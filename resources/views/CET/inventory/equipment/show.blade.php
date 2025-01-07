@extends('CET.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Equipment Details</h1>
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
                            <div class="form-group">
                                <label for="name">Name</label>
                                <p>{{ $equipment->name }}</p>
                            </div>
                            <div class="form-group">
                                <label for="serial_number">Serial Number</label>
                                <p>{{ $equipment->serial_number }}</p>
                            </div>
                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <p>{{ $equipment->brand }}</p>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <p>{{ $equipment->category }}</p>
                            </div>
                            <div class="form-group">
                                <label for="condition">Condition</label>
                                <p>{{ $equipment->condition }}</p>
                            </div>
                            <div class="form-group">
                                <label for="location">Location</label>
                                <p>{{ $equipment->location }}</p>
                            </div>
                            <div class="form-group">
                                <label for="availability_status">Availability Status</label>
                                <p>{{ $equipment->availability_status }}</p>
                            </div>
                            <a href="{{ route('CET.inventory.equipment.edit', $equipment->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('CET.inventory.equipment.destroy', $equipment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div>
@endsection
