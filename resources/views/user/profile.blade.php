@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Profile</h3>
                </div>
                <form action="{{route('profile.update' , auth()->user()->id) }}" method="POST" class="needs-validation" novalidate="">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="firstname">First name</label>
                                    <input type="text" id="firstname" class="form-control" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="lastname">Last name</label>
                                    <input type="text" id="lastname" class="form-control" name="last_name" placeholder="Enter your last name" value="{{ old('last_name') ? old('last_name') : auth()->user()->last_name}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" class="form-control" placeholder="Enter your email" value="{{ old('email') ? old('email') : auth()->user()->email}}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tel">Contact number</label>
                                    <input type="number" id="tel" class="form-control" name="contact_number" placeholder="09xxxxxxxxx" min="09000000000" max="09999999999" value="{{ old('contact_number') ? old('contact_number') : auth()->user()->contact_number}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-outline-secondary" href="#" onclick="window.history.back()">Back</a>
                        <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Shipping Address</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#add">
                            <i class="fas fa-plus"></i> Add new address
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Address</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shippingAddresses as $shippingAddress)
                            <tr>
                                <td>{{$shippingAddress->completeAddress()}}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editModal" data-toggle="modal" data-target="#edit" data-shippingAddress="{{$shippingAddress}}" data-link="{{route('shippingAddresses.update',$shippingAddress->id)}}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm deleteModal" data-toggle="modal" data-target="#delete" data-shippingAddress="{{$shippingAddress->completeAddress()}}" data-link="{{route('shippingAddresses.destroy', $shippingAddress->id)}}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-danger">No shipping address added yet. Please add at least one</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal -->
<div class="modal fade" id="add" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add shipping address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <form action="{{route('shippingAddresses.store')}}" method="POST" class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <div class="card-body">
                        <!-- house number -->
                        <div class="form-group">
                            <label for="houseNumber">House number</label>
                            <input type="text" class="form-control" id="houseNumber" name="houseNumber">
                        </div>
                        <!-- street -->
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" id="street" name="street">
                        </div>
                        <!-- brgy -->
                        <div class="form-group">
                            <label for="brgy">Brgy</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="brgy" name="brgy" required>
                        </div>
                        <!-- city -->
                        <div class="form-group">
                            <label for="city">City</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <!-- province -->
                        <div class="form-group">
                            <label for="province">Province</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="province" name="province" required>
                        </div>
                        <!-- country -->
                        <div class="form-group">
                            <label for="country">Country</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Edit Modal -->
<div class="modal fade" id="edit" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Shipping Address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="needs-validation" novalidate="" action="" method="POST" id="edit-form">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="houseNumber2">House number</label>
                            <input type="text" class="form-control" id="houseNumber2" name="houseNumber">
                        </div>
                        <div class="form-group">
                            <label for="street2">Street</label>
                            <input type="text" class="form-control" id="street2" name="street">
                        </div>
                        <div class="form-group">
                            <label for="brgy2">Brgy</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="brgy2" name="brgy" required>
                        </div>
                        <div class="form-group">
                            <label for="city2">City</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="city2" name="city" required>
                        </div>
                        <div class="form-group">
                            <label for="province2">Province</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="province2" name="province" required>
                        </div>
                        <div class="form-group">
                            <label for="country2">Country</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="country2" name="country" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- delete modal -->
<div class="modal fade" id="delete" aria-modal="true" role="dialog">
    <div class="modal-dialog  modal-md">
        <div class="modal-content ">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">Delete?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete </p>
                <p id="deleteModalText"></p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <form id="delete-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection

@section('script')
<!-- form validation -->
<script src="{{ asset('js/form-validation.js') }}"></script>
<!-- disable button on submit  -->
<script src="{{asset('js/disableButtonOnSubmit.js')}}"></script>
<script>
    $(function() {
        // delete
        $('.deleteModal').click(function() {
            const shippingAddress = $(this).attr('data-shippingAddress');
            const link = $(this).attr('data-link');
            $('#deleteModalText').text(shippingAddress);
            $('#delete-form').attr('action', link);
        });
        // edit
        $('.editModal').click(function() {
            const link = $(this).attr('data-link');
            $('#edit-form').attr('action', link);
            let shippingAddress = $(this).attr('data-shippingAddress');
            shippingAddress = JSON.parse(shippingAddress);
            $('#houseNumber2').val(shippingAddress.houseNumber);
            $('#street2').val(shippingAddress.street);
            $('#brgy2').val(shippingAddress.brgy);
            $('#city2').val(shippingAddress.city);
            $('#province2').val(shippingAddress.province);
            $('#country2').val(shippingAddress.country);
        });
    });
</script>
@endsection