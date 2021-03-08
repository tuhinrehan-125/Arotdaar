@extends('layouts.main', ['activePage' => 'add-product', 'titlePage' => __('Add-Product')])

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

    .productCreate {
        height: 722px;
    }
</style>


<section class="dashboard-counts section-padding secondNav">
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Products</li>
                <li class="breadcrumb-item active">Add Product</li>
            </ul>
        </div>
    </div>


    <div class="container-fluid productCreate">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <h4> Create Product Form</h4>
                    </div>
                    <div class="card-body">
                        <form id="expense-form" action="{{route('product.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <h7> Category Name</h7>
                                        <select name="category_id" id="categoryId" class="categoryId form-control ">
                                            <option value="">Select Category</option>
                                            @foreach($category as $data)
                                            <option value="{{ $data->id ?? ''}}">{{$data->name ?? ''}}</option>
                                            @endforeach
                                        </select>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <h7>Sub Category </h7>
                                        <select name="subcategory_id" id="subCategoryId" class="subCategoryId form-control ">
                                            <option value="">Select Sub-Category</option>
                                            @foreach($subcategory as $data)
                                            <option value="{{ $data->id ?? ''}}">{{$data->name ?? ''}}</option>
                                            @endforeach
                                        </select>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="new-item-add">
                                    <div class="row">
                                        <div class="col-md-5 col-md-5">
                                            <div class="form-group">
                                                <h7>Product Name</h7>
                                                <input type="text" name="name" id="name" placeholder="Enter Product Name" class="expense form-control ">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-md-5">
                                            <div class="form-group">
                                                <h7>Product Details</h7>
                                                <input type="text" name="details" id="details" placeholder="Enter Product Details" class="expense form-control ">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <h7> Unit Type</h7>
                                                <select name="unit_id" id="unitId" class="unitId form-control ">
                                                    <!-- <option value="">Select Unit Type</option> -->
                                                    @foreach($unit as $data)
                                                    <option value="{{ $data->id ?? ''}}">{{$data->name ?? ''}}</option>
                                                    @endforeach
                                                </select>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-md-5">
                                            <div class="form-group">
                                                <h7>Unit</h7>
                                                <input type="text" name="unit" id="unit" placeholder="Enter Unit" class="expense form-control ">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-md-5">
                                            <div class="form-group">
                                                <h7>Price</h7>
                                                <input type="text" name="price" id="price" placeholder="Enter The Price" class="amount form-control ">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@if(Session::has('success'))

<script>
    toastr.success("{!! Session::get('success') !!}");
</script>

@endif


@endsection