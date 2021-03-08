@extends('layouts.main', ['activePage' => 'sub-category', 'titlePage' => __('Sub Category')])

@section('content')

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


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
                <li class="breadcrumb-item active">Sub-Category</li>
                <li class=" offset-9"> <button class=" btn btn-sm btn-success create-category" data-toggle="modal" data-target="#categoryModal">Create</button></li>
            </ul>
        </div>
    </div>


    <div class="container-fluid categoryPage">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <h4>Sub Category Table</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped category-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Sub-Category Name</th>
                                        <th>Category id</th>
                                        <th>Category Name</th>
                                        <th> Description</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($SubCategory as $key)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$key->name ?? ''}}</td>
                                        <td>{{$key->category_id ?? ''}}</td>
                                        <td>{{$key->Category->name ?? ''}}</td>
                                        <td>{{$key->description ?? ''}}</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><button class="btn btn-sm btn-primary edit" data-id="{{$key->id ?? ''}}" data-name="{{$key->name ?? ''}}" data-description="{{$key->description ?? ''}}" data-catg_id="{{$key->category_id ?? ''}}"><i class="fa fa-edit"></i>Edit</button></td>
                                                    <td><a class="btn btn-sm btn-danger delete" onclick="return confirm('do you want to delete')" href="{{route('subcategory.delete',$key->id)}}"><i class="fa fa-trash"></i>Delete</a></td>

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
<div class="modal fade" id="subCategoryEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <form id="category-form" method="post">
                    @csrf
                    <input type="hidden" id="sub-category-id" name="id" value="">
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
                        <label>Sub Category Name</label>
                        <input type="text" id="name" name="name" placeholder="Sub Category Name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sub Category Description</label>
                        <input type="text" id="description" name="description" placeholder="Sub Category description" class="form-control @error('description') is-invalid @enderror">
                        @error('description')
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

<script>
    $(document).ready(function() {

        $('.create-category').click(function(e) {
            $("#subCategoryEditModal").modal('show')
            $("#category-form").attr('action', "{{route('subcategory.store')}}")
            $('.modal-title').html('Create Sub Category')
            FormResetData();
        })

        $('.edit').click(function(e) {
            FormResetData();
            $("#subCategoryEditModal").modal('show')
            $("#sub-category-id").val($(this).data('id'))
            $("#name").val($(this).data('name'))
            $("#description").val($(this).data('description'))
            var catego = $(this).data('catg_id')

            $('#categoryId').val(catego).prop('selected', true);

            $('.modal-title').html('Update Sub Category')
            $("#category-form").attr('action', "{{route('subcategory.update')}}")

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