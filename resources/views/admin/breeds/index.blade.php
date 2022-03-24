@extends('admin.layouts.app')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('Adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('main-content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Breed of Pets</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <button type="button" class="btn btn-success btn-sm  mb-3 addModal" data-toggle="modal" data-target="#addModal">
                <i class="fas fa-plus"></i> Add Breed
            </button>
            <div class="card">
                <div class="card-body">
                    <table id="table" class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Type</th>
                                <th>Breed</th>
                                <th>Created At</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $breeds as $breed)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{ $breed->type->name}}</td>
                                <td>{{ $breed->name}}</td>
                                <td>{{ $breed->created_at->diffForHumans()}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary  btn-sm editModal" data-toggle="modal" data-target="#editModal" data-name="{{$breed->name}}" data-type-id="{{$breed->type_id}}" data-link="{{route('breed.update', $breed->slug)}}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger   btn-sm deleteModal" data-toggle="modal" data-target="#deleteModal" data-name="{{$breed->name}}" data-link="{{route('breed.destroy', $breed->slug)}}" @if ( $breed->pets->count() ) disabled @endif >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- add modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editeModalLabel">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-form" action="{{route('breed.store')}}" method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type">Type</label><span class="text-danger">*</span>
                        <select class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}" name="type_id" id="addType" required>
                            <option value="" selected disabled>Select Type</option>
                            @foreach ($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback" role="alert">
                            Type is required
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="type">Breed</label><span class="text-danger">*</span>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="addType" placeholder="Pet Breed" value="" required>
                        <span class="invalid-feedback" role="alert">
                            Breed is required
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="deleteModalText">Are you sure you want to delete this?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <form id="delete-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editeModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-form" action="" method="POST" class="needs-validation" novalidate="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type">Type</label><span class="text-danger">*</span>
                        <select name="type_id" id="editType" class="form-control {{ $errors->has('type_id') ? ' is-invalid' : '' }}" required>
                            <option value="" disabled selected>Select type</option>
                            @foreach($types as $type)
                            <option value="{{$type->id}}" @if(old('type_id')==$type->id) selected @endif >{{$type->name}}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback">
                            Type is required
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="type">Breed</label><span class="text-danger">*</span>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="editBreed" placeholder="title" value="" required>
                        <span class="invalid-feedback">
                            Breed is required
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- DataTables  & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<!-- Page specific script -->
<script>
    // delete
    $('.deleteModal').click(function() {
        const name = $(this).attr('data-name');
        const link = $(this).attr('data-link');
        $('#deleteModalText').text(`Are you sure you want to delete ${name}?`);
        $('#delete-form').attr('action', link);
    });
    // edit
    $('.editModal').click(function() {
        const name = $(this).attr('data-name');
        const link = $(this).attr('data-link');
        const type = $(this).attr('data-type-id');
        $('#editBreed').val(name);
        $('#editType').val(type);

        $('#edit-form').attr('action', link);
    });
    $(function() {
        $("#table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        });
    });
</script>
@endsection