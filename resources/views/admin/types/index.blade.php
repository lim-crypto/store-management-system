@extends('admin.layouts.app')
@section('main-content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Type of Pets</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-5 col-8 p-2" data-toggle="modal" data-target="#addModal">
                    <summary class="card custom-border h-100">
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <i class="fas fa-plus fa-5x text-success"></i>
                        </div>
                    </summary>
                </div>
                @foreach ( $types as $type)
                <div class="col-lg-3 col-md-5 col-8 p-2" data-aos="fade-left">
                    <div class="card custom-border h-100">
                        <img src="{{asset('storage/images/type/'.$type->image)}}" class="card-img-top" height="250px" style="object-fit:cover;" alt="{{$type->name}}">

                        <div class="card-body">
                            <h5 class="card-title">
                                {{$type->name}}
                            </h5>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary btn-sm editModal" data-toggle="modal" data-target="#editModal" data-name="{{$type->name}}" data-link="{{route('type.update', $type->slug)}}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm deleteModal" data-toggle="modal" data-target="#deleteModal" data-name="{{$type->name}}" data-link="{{route('type.destroy', $type->slug)}}" @if ( $type->breed->count() ) disabled @endif>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div id="getType"></div>
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
            <form id="add-form" action="{{route('type.store')}}" method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type"> Add Type of Pets</label><span class="text-danger">*</span>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="addType" placeholder="title" value="" required>
                        <span class="invalid-feedback" role="alert">
                            Type is required
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label> <span class="text-danger">*</span>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input  {{ $errors->has('image') ? ' is-invalid'  :''  }}" accept="image/*" required>
                            <label class="custom-file-label" for="gallery-photo-add">Choose Image</label>
                            <div class="invalid-feedback">
                                Please choose image
                            </div>
                        </div>
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
            <form id="edit-form" action="" method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type">Type of Pets</label>

                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="editType" placeholder="title" value="" required>
                        <span class="invalid-feedback" role="alert">
                            Type is required
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input  {{ $errors->has('image') ? ' is-invalid'  :''  }}" accept="image/*">
                            <label class="custom-file-label" for="gallery-photo-add">Choose Image</label>
                            <div class="invalid-feedback">
                                Please choose image
                            </div>
                        </div>
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
<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('Adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<!-- Page specific script -->
<script>
    $(function() {
        bsCustomFileInput.init();
    });
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
        $('#editType').val(name);
        $('#edit-form').attr('action', link);
    });
</script>
@endsection