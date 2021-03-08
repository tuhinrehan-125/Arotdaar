@extends('layouts.main', ['activePage' => 'customer', 'titlePage' => __('Customers')])

@section('content')

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

@php
$lastid = null;
$rowclass = 'table-danger';
@endphp

<section class="dashboard-counts section-padding secondNav">
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Customers</li>
                <li class=" offset-9"> <button class=" btn btn-sm btn-success create-customer">Create</button></li>
            </ul>
        </div>
    </div>

    <div class="col-lg-12 grid-margin stretch-card categoryPage">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h4>Customer Lists</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Customer Pic</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Mobile No.</th>
                                <th>Alt Mobile No.</th>
                                <th>Shop Name</th>
                                <th>Shop Address</th>
                                <th>NID No.</th>
                                <th>NID Picture</th>
                                <th>Introducer Name</th>
                                <th>Introducer Mobile No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($customer as $key)
                            @php
                            if ($lastid !== $key->id){
                            $lastid = $key->id;

                            if($rowclass == 'table-danger')
                            $rowclass = 'table-success';
                            else
                            $rowclass = 'table-danger';
                            }
                            @endphp
                            <tr class="{{$rowclass}}">

                                <td>
                                    <!-- {{$key->customer_pic}} -->
                                    <input type="hidden" value="{{$customerPic = $key->customer_pic }}">
                                    <img src="{{asset('$customerPic') ?? ''}}" alt="person" class="img-fluid rounded-circle mCS_img_loaded" height="50px" width="50px">
                                </td>

                                <td>{{$key->name ?? ''}}</td>
                                <td>{{$key->address ?? ''}}</td>
                                <td>{{$key->mobile_no ?? ''}}</td>
                                <td>{{$key->alt_mobile_no ?? ''}}</td>
                                <td>{{$key->shop_name ?? ''}}</td>
                                <td>{{$key->shop_address ?? ''}}</td>
                                <td>{{$key->nid_no ?? ''}}</td>

                                <!-- <td>{{$key->nid_image ?? ''}}</td> -->
                                <td>
                                    <input type="hidden" value="{{$nidPic = $key->nid_image }}">
                                    <img src="{{asset($nidPic) ?? ''}}" alt="person" class="img-fluid rounded-circle mCS_img_loaded" height="50px" width="50px">
                                </td>

                                <td>{{$key->introducer_name ?? ''}}</td>
                                <td>{{$key->intro_mobile_no ?? ''}}</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><button class="btn btn-sm btn-primary edit" data-id="{{$key->id ?? ''}}" data-customer_pic="{{$key->customer_pic ?? ''}}" data-name="{{$key->name ?? ''}}" data-address="{{$key->address ?? ''}}" data-mobile_no="{{$key->mobile_no ?? ''}}" data-alt_mobile_no="{{$key->alt_mobile_no ?? ''}}" data-shop_name="{{$key->shop_name ?? ''}}" data-shop_address="{{$key->shop_address ?? ''}}" data-nid_no="{{$key->nid_no ?? ''}}" data-nid_image="{{$key->nid_image ?? ''}}" data-introducer_name="{{$key->introducer_name ?? ''}}" data-intro_mobile_no="{{$key->intro_mobile_no ?? ''}}"><i class="fa fa-edit"></i>Edit</button></td>
                                            <td><a class="btn btn-sm btn-danger delete" onclick="return confirm('do you want to delete')" href="{{route('customer.delete',$key->id)}}"><i class=" fa fa-trash"></i>Delete</a></td>

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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Customer Lists</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped category-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Customer Picture</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Mobile No.</th>
                                        <th>Alt Mobile No.</th>
                                        <th>Shop Name</th>
                                        <th>Shop Address</th>
                                        <th>NID No.</th>
                                        <th>NID Picture</th>
                                        <th>Introducer Name</th>
                                        <th>Introducer Mobile No.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer as $key)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        
                                        <td>
                                            {{$key->customer_pic}}
                                            <input type="hidden" value="{{$customerPic = $key->customer_pic }}">
                                            <img src="{{asset('$customerPic') ?? ''}}" alt="person" class="img-fluid rounded-circle mCS_img_loaded" height="50px" width="50px">
                                        </td>

                                        <td>{{$key->name ?? ''}}</td>
                                        <td>{{$key->address ?? ''}}</td>
                                        <td>{{$key->mobile_no ?? ''}}</td>
                                        <td>{{$key->alt_mobile_no ?? ''}}</td>
                                        <td>{{$key->shop_name ?? ''}}</td>
                                        <td>{{$key->shop_address ?? ''}}</td>
                                        <td>{{$key->nid_no ?? ''}}</td>

                                        
                                        <td>
                                            <input type="hidden" value="{{$nidPic = $key->nid_image }}">
                                            <img src="{{asset($nidPic) ?? ''}}" alt="person" class="img-fluid rounded-circle mCS_img_loaded" height="50px" width="50px">
                                        </td>

                                        <td>{{$key->introducer_name ?? ''}}</td>
                                        <td>{{$key->intro_mobile_no ?? ''}}</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><button class="btn btn-sm btn-primary edit" data-id="{{$key->id ?? ''}}" data-customer_pic="{{$key->customer_pic ?? ''}}" data-name="{{$key->name ?? ''}}" data-address="{{$key->address ?? ''}}" data-mobile_no="{{$key->mobile_no ?? ''}}" data-alt_mobile_no="{{$key->alt_mobile_no ?? ''}}" data-shop_name="{{$key->shop_name ?? ''}}" data-shop_address="{{$key->shop_address ?? ''}}" data-nid_no="{{$key->nid_no ?? ''}}" data-nid_image="{{$key->nid_image ?? ''}}" data-introducer_name="{{$key->introducer_name ?? ''}}" data-intro_mobile_no="{{$key->intro_mobile_no ?? ''}}"><i class="fa fa-edit"></i>Edit</button></td>
                                                    <td><a class="btn btn-sm btn-danger delete" onclick="return confirm('do you want to delete')" href="{{route('customer.delete',$key->id)}}"><i class=" fa fa-trash"></i>Delete</a></td>

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
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id=""></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- From here -->
                <form id="customer-form" method="post" enctype="multipart/form-data">
                    <!-- {{ csrf_field() }}
                    {{ method_field('PUT') }} -->
                    <!-- <input type="hidden" name="_method" value="PUT"> -->
                    @csrf

                    <input type="hidden" id="customer_id" name="id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input type="text" id="name" name="name" placeholder="Customer Name" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer Address</label>
                                <input type="text" id="address" name="address" placeholder="Customer Address" class="form-control @error('address') is-invalid @enderror" required>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mobile No</label>
                                <input type="text" id="mobile_no" name="mobile_no" placeholder="Customer Mobile No" class="form-control @error('mobile_no') is-invalid @enderror" required>
                                @error('mobile_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Alternative Mobile No</label>
                                <input type="text" id="alt_mobile_no" name="alt_mobile_no" placeholder="Customer Alternative Mobile No" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Shop Name</label>
                                <input type="text" id="shop_name" name="shop_name" placeholder="Customer Shop Name" class="form-control">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Shop Address</label>
                                <input type="text" id="shop_address" name="shop_address" placeholder="Customer Shop Name" class="form-control">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NID No</label>
                                <input type="text" id="nid_no" name="nid_no" placeholder="Customer NID No" class="form-control @error('nid_no') is-invalid @enderror" required>
                                @error('nid_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <label>NID Image</label>
                                <input type="file" id="nid_image" name="nid_image" placeholder="Nid image" class="form-control @error('nid_image') is-invalid @enderror" required>
                                @error('nid_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Introducer Name</label>
                                <input type="text" id="introducer_name" name="introducer_name" placeholder="Introducer Name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Introducer Mobile No</label>
                                <input type="text" id="intro_mobile_no" name="intro_mobile_no" placeholder="Introducer Mobile No" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <label>Customer Photo</label>
                                <input type="file" id="customer_pic" name="customer_pic" placeholder="Customer Picture" class="form-control @error('customer_image') is-invalid @enderror" required>
                                @error('customer_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Submit</button>
                        </div>
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
@if(Session::has('update'))

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

        $('.create-customer').click(function(e) {
            $("#customerModal").modal('show')
            $("#customer-form").attr('action', "{{route('customer.store')}}")
            $('.modal-title').html('Create Customer')
            FormResetData();
        })
        $('.edit').click(function(e) {
            FormResetData();
            $("#customerModal").modal('show')

            $("#customer_id").val($(this).data('id'))

            $("#customer_pic").val($(this).data('customer_pic'))
            $("#name").val($(this).data('name'))
            $("#address").val($(this).data('address'))
            $("#mobile_no").val($(this).data('mobile_no'))
            $("#alt_mobile_no").val($(this).data('alt_mobile_no'))
            $("#shop_name").val($(this).data('shop_name'))
            $("#shop_address").val($(this).data('shop_address'))
            $("#nid_no").val($(this).data('nid_no'))
            $("#nid_image").val($(this).data('nid_image'))
            $("#introducer_name").val($(this).data('introducer_name'))
            $("#intro_mobile_no").val($(this).data('intro_mobile_no'))

            $('.modal-title').html('Update Customer')

            $("#project-form").attr('action', "{{route('customer.update')}}")

        })

        function FormResetData() {
            $("#employee_id").val('');
            $("#name").val('');
            $("#description").val('');
            $('#employeeDegId').val('').prop('selected', false);
            $("#phone").val('')
            $("#email").val('')
            $("#address").val('')
            $("#joining_date").val('')
            $("#image").val('')
        }
    })
</script>

@endsection