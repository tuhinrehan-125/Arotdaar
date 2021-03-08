@extends('layouts.main', ['activePage' => 'category', 'titlePage' => __('Category')])

@section('content')

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


</head>

<style>
    .secondNav {
        margin-top: 25px;
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
                <li class="breadcrumb-item active">Category</li>
                <li class=" offset-9"> <button class=" btn btn-sm btn-success create-category" data-toggle="modal" data-target="#categoryModal">Create</button></li>
            </ul>
        </div>
    </div>


    <div class="container-fluid categoryPage">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <h4>Category Table</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped category-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th> Name</th>
                                        <th> Description</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category as $key)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$key->name ?? ''}}</td>
                                        <td>{{$key->description ?? ''}}</td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><button class="btn btn-sm btn-primary edit" data-id="{{$key->id ?? ''}}" data-name="{{$key->name ?? ''}}" data-description="{{$key->description ?? ''}}"><i class="fa fa-edit edit"></i>Edit</button></td>
                                                    <td><a class="btn btn-sm btn-danger delete" onclick="return confirm('do you want to delete')" href="{{route('category.delete',$key->id)}}"><i class="fa fa-trash"></i>Delete</a></td>

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

<!--Create Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Create Category</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- From here -->
                <form id="category-form">
                    @csrf
                    <!-- <input type="hidden" id="category-id" name="id" value="PUT"> -->
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" id="name" name="name" placeholder="Category Name" class="form-control ">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" placeholder="Category description" class="form-control ">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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

<!--Edit Category Modal -->
<div class="modal fade" id="categoryEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <form id="categoryEditForm" method="POST">
                    @csrf
                    <input type="hidden" id="category-id" name="id">

                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" id="name2" class="form-control ">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description2" class="form-control ">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
    $("#category-form").submit(function(e) {
        e.preventDefault();

        let name = $("#name").val();
        let description = $("#description").val();

        let _token = $("input[name=_token]").val();

        $.ajax({
            url: "{{route('category.store')}}",
            type: "POST",
            data: {
                name: name,
                description: description,
                _token: _token
            },
            success: function(response) {
                if (response) {
                    $("#category-table tbody").prepend('<tr> <td>' + response.name + '</td> <td>' + response.description + '</td></tr>');
                    $("#category-form")[0].reset();
                    $("#categoryModal").modal('hide');
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('.edit').click(function(e) {
            FormResetData();
            $("#categoryEditModal").modal('show')
            $("#category-id").val($(this).data('id'))
            $("#name2").val($(this).data('name'))
            $("#description2").val($(this).data('description'))
            $('.edit-modal-title').html('Update Category')

            $("#categoryEditForm").attr('action', "{{route('category.update')}}")

        })

        function FormResetData() {
            $("#name").val('');
            $("#description").val('');
        }
    })
</script>

@endsection