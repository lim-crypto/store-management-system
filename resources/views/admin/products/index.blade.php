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
          <h1 class="m-0">Products</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <a href="{{route('products.create')}}" class="btn btn-sm mb-3 btn-primary "> <i class="fas fa-plus-circle"></i> Add Product</a>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="products-table" class="table table-sm table-hover table-head-fixed">
                <thead>
                  <tr>
                    <th>category</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>created at</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td>{{ $product->category->name }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $product->name }}</td>
                    <td>{{$product->description}}</td>
                    <td> &#8369; {{$product->price}}</td>
                    <td>
                      <img class="img-fluid" src="/storage/images/products/{{$product->image}}" alt="{{ $product->name }}" style="height:100px; object-fit:cover;">
                    </td>
                    <td>{{ $product->created_at->diffForHumans() }}</td>
                    <td>
                      <a title="View" class="btn btn-info btn-sm" href="{{route('product', $product->id)}}"><i class="fas fa-eye"></i></a>
                      <a title="Edit" class="btn btn-secondary btn-sm" href="{{route('products.edit', $product->id)}}"><i class="fas fa-edit"></i></a>
                      <button title="Delete" type="button" class="btn btn-danger btn-sm deleteModal" data-toggle="modal" data-target="#deleteModal" data-name="{{$product->name}}" data-link="{{route('products.destroy', $product->id)}}">
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
<!-- DataTables & Plugins -->
<script src="{{asset('Adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('Adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<script>
  $(function() {
    $("#products-table").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
    });
  });
  // delete
  $('.deleteModal').click(function() {
    const name = $(this).attr('data-name');
    const link = $(this).attr('data-link');
    $('#deleteModalText').text(`Are you sure you want to delete ${name}?`);
    $('#delete-form').attr('action', link);
  });
</script>
@endsection