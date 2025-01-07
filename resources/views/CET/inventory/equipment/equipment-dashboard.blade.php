@extends('CET.layouts.header')

@section('content')
<div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Equipments</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <!-- Action Buttons -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEquipmentModal">
                        <i class="fas fa-plus"></i> Add Equipment
                    </button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importEquipmentModal">
                        <i class="fas fa-file-upload"></i> Import Equipment
                    </button>
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
                            <!-- Equipments Table -->
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Brand/Model</th>
                                        <th>Engine/Serial No.</th>
                                        <th>Inventory Tag No.</th>
                                        <th>Purchased by</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipment as $item)
                                    <tr>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->brand_model }}</td>
                                        <td>{{ $item->engine_serial_no }}</td>
                                        <td>{{ $item->inventory_tag_no }}</td>
                                        <td>{{ $item->purchased_by }}</td>
                                        <td>{{ $item->remarks }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#editEquipmentModal{{ $item->id }}" title="Edit Equipment">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('CET.inventory.equipment.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mr-2" onclick="return confirm('Are you sure you want to delete this equipment?');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editEquipmentModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editEquipmentModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editEquipmentModalLabel{{ $item->id }}">Edit Equipment</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('CET.inventory.equipment.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea name="description" class="form-control" id="description">{{ $item->description }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="quantity">Quantity</label>
                                                            <input type="number" name="quantity" class="form-control" id="quantity" value="{{ $item->quantity }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="brand_model">Brand/Model</label>
                                                            <input type="text" name="brand_model" class="form-control" id="brand_model" value="{{ $item->brand_model }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="engine_serial_no">Engine/Serial No.</label>
                                                            <input type="text" name="engine_serial_no" class="form-control" id="engine_serial_no" value="{{ $item->engine_serial_no }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inventory_tag_no">Inventory Tag No.</label>
                                                            <input type="text" name="inventory_tag_no" class="form-control" id="inventory_tag_no" value="{{ $item->inventory_tag_no }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="purchased_by">Purchased by</label>
                                                            <input type="text" name="purchased_by" class="form-control" id="purchased_by" value="{{ $item->purchased_by }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="remarks">Remarks</label>
                                                            <textarea name="remarks" class="form-control" id="remarks">{{ $item->remarks }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update Equipment</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEquipmentModalLabel">Add Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('CET.inventory.equipment.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" class="form-control" id="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="brand_model">Brand/Model</label>
                        <input type="text" name="brand_model" class="form-control" id="brand_model">
                    </div>
                    <div class="form-group">
                        <label for="engine_serial_no">Engine/Serial No.</label>
                        <input type="text" name="engine_serial_no" class="form-control" id="engine_serial_no">
                    </div>
                    <div class="form-group">
                        <label for="inventory_tag_no">Inventory Tag No.</label>
                        <input type="text" name="inventory_tag_no" class="form-control" id="inventory_tag_no">
                    </div>
                    <div class="form-group">
                        <label for="purchased_by">Purchased by</label>
                        <input type="text" name="purchased_by" class="form-control" id="purchased_by" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" class="form-control" id="remarks"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Equipment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Import Equipment Modal -->
<div class="modal fade" id="importEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="importEquipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importEquipmentModalLabel">Import Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('CET.inventory.equipment.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Upload CSV File</label>
                        <input type="file" name="file" class="form-control" id="file" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Import Equipment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
