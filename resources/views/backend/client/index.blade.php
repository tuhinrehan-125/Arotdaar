@extends('layouts.main', ['activePage' => 'client', 'titlePage' => __('Clients')])

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


</head>

<style>
    .secondNav {
        margin-top: 26px;
    }

    .categoryPage {
        height: 701px;
    }
</style>


@section('content')



@php
$lastid = null;
$rowclass = 'table-info';
@endphp

<section class="dashboard-counts section-padding secondNav">
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Clients</li>
                <li class=" offset-9"> <button class=" btn btn-sm btn-success create-client" data-toggle="modal" data-target="#categoryModal">Create</button></li>
            </ul>
        </div>
    </div>

    <div class="col-lg-12 stretch-card categoryPage">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h4>Clients Table</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>Client Name</th>
                                <th>Address</th>
                                <th>Mobile No</th>
                                <th> Company Name</th>
                                <th> NID No</th>
                                <th>Commission Rate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($client as $key)

                            @php
                            if ($lastid !== $key->id){
                            $lastid = $key->id;
                            if ($rowclass == 'table-info')
                            $rowclass = 'table-warning';
                            elseif($rowclass == 'table-warning')
                            $rowclass = 'table-danger';
                            elseif($rowclass == 'table-danger')
                            $rowclass = 'table-success';
                            elseif($rowclass == 'table-success')
                            $rowclass = 'table-primary';
                            elseif($rowclass == 'table-primary')
                            $rowclass = 'table-active';
                            else
                            $rowclass = 'table-info';
                            }
                            @endphp

                            <tr class="{{$rowclass}}">
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$key->name ?? ''}}</td>
                                <td>{{$key->address ?? ''}}</td>
                                <td>{{$key->mobile_no ?? ''}}</td>
                                <td>{{$key->company_name ?? ''}}</td>
                                <td>{{$key->nid_no ?? ''}}</td>
                                <td>{{$key->commission_rate ?? ''}}</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><button class="btn btn-sm btn-primary edit" data-id="{{$key->id ?? ''}}" data-name="{{$key->name ?? ''}}" data-address="{{$key->address ?? ''}}" data-mobile_no="{{$key->mobile_no ?? ''}}" data-company_name="{{$key->company_name ?? ''}}" data-nid_no="{{$key->nid_no ?? ''}}" data-commission_rate="{{$key->commission_rate ?? ''}}"><i class="fa fa-edit"></i>Edit</button></td>
                                            <td><a class="btn btn-sm btn-danger delete" onclick="return confirm('do you want to delete')" href="{{route('client.delete',$key->id)}}"><i class="fa fa-trash"></i>Delete</a></td>

                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="container-fluid categoryPage">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <h4>Clients Table</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped category-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Client Name</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th> Company Name</th>
                                        <th> NID No</th>
                                        <th>Commission Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client as $key)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$key->name ?? ''}}</td>
                                        <td>{{$key->address ?? ''}}</td>
                                        <td>{{$key->mobile_no ?? ''}}</td>
                                        <td>{{$key->company_name ?? ''}}</td>
                                        <td>{{$key->nid_no ?? ''}}</td>
                                        <td>{{$key->commission_rate ?? ''}}</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><button class="btn btn-sm btn-primary edit" data-id="{{$key->id ?? ''}}" data-name="{{$key->name ?? ''}}" data-address="{{$key->address ?? ''}}" data-mobile_no="{{$key->mobile_no ?? ''}}" data-company_name="{{$key->company_name ?? ''}}" data-nid_no="{{$key->nid_no ?? ''}}" data-commission_rate="{{$key->commission_rate ?? ''}}"><i class="fa fa-edit"></i>Edit</button></td>
                                                    <td><a class="btn btn-sm btn-danger delete" onclick="return confirm('do you want to delete')" href="{{route('client.delete',$key->id)}}"><i class="fa fa-trash"></i>Delete</a></td>

                                                </tr>
                                            </table>
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
    </div> -->
</section>

<!--Sub Category Modal -->
<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="edit-modal-title" id="">Edit Category Table</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- From here -->
                <form id="client-form" method="post">
                    @csrf
                    <!-- {{ method_field('PUT') }} -->
                    <input type="hidden" id="client-id" name="id" value="">
                    <div class="form-group">
                        <label>Client Name</label>
                        <input type="text" id="name" name="name" placeholder="Client Name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" id="address" name="address" placeholder="Address Name" class="form-control @error('address') is-invalid @enderror">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Mobile No</label>
                        <input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile Number" class="form-control @error('mobile_no') is-invalid @enderror">
                        @error('mobile_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" id="company_name" name="company_name" placeholder="Company Name" class="form-control @error('company_name') is-invalid @enderror">
                        @error('company_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>NID No</label>
                        <input type="text" id="nid_no" name="nid_no" placeholder="NID Number" class="form-control @error('nid_no') is-invalid @enderror">
                        @error('nid_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Commission Rate</label>
                        <input type="text" id="commission_rate" name="commission_rate" placeholder="Commission Rate" class="form-control @error('commission_rate') is-invalid @enderror">
                        @error('commission_rate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <!-- End here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if(Session::has('success'))

<script>
    toastr.success("{!! Session::get('success') !!}");
</script>
@elseif(Session::has('update'))
<script>
    toastr.success("{!! Session::get('update') !!}");
</script>
@elseif(Session::has('delete'))
<script>
    toastr.success("{!! Session::get('delete') !!}");
</script>
@endif

<script>
    $(document).ready(function() {

        $('.create-client').click(function(e) {
            $("#clientModal").modal('show')
            $("#client-form").attr('action', "{{route('client.store')}}")
            $('.modal-title').html('Create Clients')
            FormResetData();
        })

        $('.edit').click(function(e) {
            FormResetData();
            $("#clientModal").modal('show')
            $("#client-id").val($(this).data('id'))
            $("#name").val($(this).data('name'))
            $("#address").val($(this).data('address'))
            $("#mobile_no").val($(this).data('mobile_no'))
            $("#company_name").val($(this).data('company_name'))
            $("#nid_no").val($(this).data('nid_no'))
            $("#commission_rate").val($(this).data('commission_rate'))

            $('.modal-title').html('Update Sub Category')
            $("#client-form").attr('action', "{{route('client.update')}}")

        })

        function FormResetData() {
            $("#sub-category-id").val('');
            $("#name").val('');
            $("#description").val('');
            $('#categoryId').val('').prop('selected', true);
        }
    })
</script>

@endsection