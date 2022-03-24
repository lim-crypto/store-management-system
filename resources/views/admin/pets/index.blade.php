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
                    <h1 class="m-0">Pets</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-success btn-sm mb-3" href="{{route('pets.create')}}">Add Pet</a>
            <div class="float-right  d-flex">
                <h4 class="text-muted">Filter : &nbsp; </h4>
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                        Status
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('getPetsByStatus','available')}}">available</a>
                        <a class="dropdown-item" href="{{route('getPetsByStatus','not available')}}">not available</a>
                        <a class="dropdown-item" href="{{route('getPetsByStatus','reserved')}}">reserved</a>
                        <a class="dropdown-item" href="{{route('getPetsByStatus','adopted')}}">adopted</a>
                        <a class="dropdown-item" href="{{route('getPetsByStatus','for breed')}}">For breed</a>
                        <a class="dropdown-item" href="{{route('pets.index')}}">All</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle mx-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                        Type
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        @foreach(App\Model\Type::all() as $type )
                        <a class="dropdown-item" href="{{route('getPetsByType',$type->slug)}}">
                            {{$type->name}}
                        </a>
                        @endforeach
                        <a class="dropdown-item" href="{{route('pets.index')}}">All</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                        Breed
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        @foreach(App\Model\Breed::all() as $breed )
                        <a class="dropdown-item" href="{{route('getPetsByBreed',$breed->slug)}}">
                            {{$breed->name}}
                        </a>
                        @endforeach
                        <a class="dropdown-item" href="{{route('pets.index')}}">All</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="table" class="table table-hover table-striped">
                        <thead>
                            <tr">
                                <th>No.</th>
                                <th>Pet name</th>
                                <th>Pet type</th>
                                <th>Pet breed</th>
                                <th>Birthday</th>
                                <th>Status</th>
                                <th>Action</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach ($pets as $pet)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$pet->name}}</td>
                                <td>{{$pet->type->name}} </td>
                                <td>{{$pet->breed->name}}</td>
                                <td>{{ date('F d, Y', strtotime($pet->birthday))   }}</td>
                                <td>
                                    @if ($pet->status == 'available')
                                    <span class="badge badge-success">{{$pet->status}}</span>
                                    @elseif ($pet->status == 'not available')
                                    <span class="badge badge-danger">{{$pet->status}}</span>
                                    @elseif ($pet->status == 'reserved')
                                    <span class="badge badge-warning">{{$pet->status}}</span>
                                    @elseif ($pet->status == 'adopted')
                                    <span class="badge badge-secondary">{{$pet->status}}</span>
                                    @elseif ($pet->status == 'for breed')
                                    <span class="badge badge-info">{{$pet->status}}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('petDetails',$pet->slug)}}" class="btn btn-info  btn-sm" title="view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{route('pets.edit',$pet->slug)}}" class="btn btn-primary  btn-sm" title="edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm deleteModal" title="delete" data-toggle="modal" data-target="#deleteModal" data-name="{{$pet->name}}" data-link="{{route('pets.destroy',$pet->slug)}}" @if ( $pet->status == 'reserved' || $pet->status == 'adopted' || $pet->reservation != null ) disabled @endif>
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
    $(function() {
        $("#table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        });
    });
</script>
@endsection