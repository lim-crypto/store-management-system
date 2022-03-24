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
                    <h1>Services</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-5 col-8 p-4" data-aos="fade-left">
                    <a href="{{route('services.create')}}">
                        <div class="card custom-border h-100">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <i class="fas fa-plus fa-5x text-success"></i>
                            </div>
                        </div>
                    </a>
                </div>
                @foreach ( $services as $service)
                <div class="col-lg-3 col-md-5 col-8 p-4" data-aos="fade-left">
                    <div class="card custom-border h-100">
                        <img src="{{asset('storage/images/service/'.$service->image)}}" class="card-img-top" height="250px" style="object-fit:cover;" alt="">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-paw"></i>
                                {{$service->service}}
                            </h5>
                            <p class="card-text text-truncate ">{{$service->description}}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{route('services.edit', $service->id)}}" class="btn  btn-outline-secondary btn-sm">
                                    Edit
                                </a>
                                <a href="#" class="btn btn-outline-danger btn-sm deleteModal " data-toggle="modal" data-target="#deleteModal" data-name="{{$service->service}}" data-link="{{route('services.destroy', $service->id)}}">
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
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
@endsection
@section('script')
<!-- DataTables  & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- jquery validation -->
<script src="{{ asset('Adminlte/plugins/jquery-validation/jquery-validation.js') }}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>

<!-- Page specific script -->
<script>
    $(function() {
        $("#table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        });
    });
    // delete
    $('.deleteModal').click(function() {
        const name = $(this).attr('data-name');
        const link = $(this).attr('data-link');
        console.log(name);
        console.log(link);
        $('#deleteModalText').text(`Are you sure you want to delete ${name}?`);
        $('#delete-form').attr('action', link);
    });
</script>
@endsection