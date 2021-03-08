@extends('layouts.main', ['activePage' => 'product-edit', 'titlePage' => __('Edit-Product')])

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


<section class="dashboard-counts section-padding secondNav">
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Products</li>
                <li class="breadcrumb-item active">Product List</li>
                <li class=" offset-9"> <a href="{{ route('addproduct.index') }}" class=" btn btn-sm btn-success create-category">Create</a></li>
            </ul>
        </div>
    </div>


    <div class="container-fluid categoryPage">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Lists</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped category-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Sub-Category</th>
                                        <th> Description</th>
                                        <th>Unit Type</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product as $key)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$key->name ?? ''}}</td>
                                        <td>{{$key->Category->name ?? ''}}</td>
                                        <td>{{$key->SubCategory->name ?? ''}}</td>
                                        <td>{{$key->details ?? ''}}</td>
                                        <td>{{$key->Unit->name ?? ''}}</td>
                                        <td>{{$key->unit ?? ''}}</td>
                                        <td>{{$key->price ?? ''}}</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><button class="btn btn-sm btn-primary edit" data-id="{{$key->id ?? ''}}" data-name="{{$key->name ?? ''}}" data-catg_id="{{$key->Category->id ?? ''}}" data-sub_catg_id="{{$key->SubCategory->id ?? ''}}" data-description="{{$key->details ?? ''}}" data-unit_id="{{$key->Unit->id ?? ''}}" data-unit="{{$key->unit ?? ''}}" data-price="{{$key->price ?? ''}}"><i class="fa fa-edit"></i>Edit</button></td>
                                                    <td><a class="btn btn-sm btn-danger delete" onclick="return confirm('do you want to delete')" href="{{route('product.delete',$key->id)}}"><i class="fa fa-trash"></i>Delete</a></td>

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
    </div>
</section>

<!--Sub Category Modal -->
<div class="modal fade" id="productEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="edit-modal-title" id="">Edit Product List</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- From here -->
                <form id="category-form" method="post">
                    @csrf
                    <input type="hidden" id="product-id" name="id" value="">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" id="name" name="name" placeholder="Product Name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label> Category Name</label>
                        <select name="category_id" id="categoryId" class="categoryId form-control ">
                            <option value="">Select</option>
                            @foreach($category as $key)
                            <option value="{{ $key->id ?? ''}}">{{$key->name ?? ''}}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label> Sub-Category Name</label>
                        <select name="subcategory_id" id="subcategoryId" class="subcategoryId form-control ">
                            <option value="">Select</option>
                            @foreach($subcategory as $key)
                            <option value="{{ $key->id ?? ''}}">{{$key->name ?? ''}}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" id="description" name="description" placeholder="Sub Category description" class="form-control @error('description') is-invalid @enderror">
                    </div>

                    <div class="form-group">
                        <label> Unit Type</label>
                        <select name="unit_id" id="unitId" class="unitId form-control ">
                            <option value="">Select</option>
                            @foreach($unit as $key)
                            <option value="{{ $key->id ?? ''}}">{{$key->name ?? ''}}</option>
                            @endforeach
                        </select>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" id="unit" name="unit" placeholder="Enter Unit" class="form-control @error('unit') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" id="price" name="price" placeholder="Enter Price" class="form-control @error('price') is-invalid @enderror">
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
@if(Session::has('update'))

<script>
    toastr.success("{!! Session::get('update') !!}");
</script>

@endif

<script>
    $(document).ready(function() {

        $('.edit').click(function(e) {
            FormResetData();
            $("#productEditModal").modal('show')
            $("#product-id").val($(this).data('id'))
            $("#name").val($(this).data('name'))
            $("#description").val($(this).data('description'))
            $("#unit").val($(this).data('unit'))
            $("#price").val($(this).data('price'))

            // var product = $(this).data('id')
            var categ = $(this).data('catg_id')
            var sub_categ = $(this).data('sub_catg_id')
            var unit = $(this).data('unit_id')

            // $('#name').val(product).prop('selected', true);
            $('#categoryId').val(categ).prop('selected', true);
            $('#subcategoryId').val(sub_categ).prop('selected', true);
            $('#unitId').val(unit).prop('selected', true);

            $('.modal-title').html('Update Product List')

            $("#category-form").attr('action', "{{route('product.update')}}")

        })

        function FormResetData() {
            $("#sub-category-id").val('');
            $("#name").val('');
            $("#description").val('');
            // $('#name').val('').prop('selected', true);
            $('#categoryId').val('').prop('selected', true);
            $('#subcategoryId').val('').prop('selected', true);
            $('#unitId').val('').prop('selected', true);
        }
    })
</script>

@endsection