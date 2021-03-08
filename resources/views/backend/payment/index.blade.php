@extends('layouts.main', ['activePage' => 'payment', 'titlePage' => __('Payment')])

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        .secondNav {
            margin-top: 26px;
        }

        .categoryPage {
            height: 701px;
        }
    </style>


</head>


@section('content')


<section class="dashboard-counts section-padding secondNav">
    <div class="breadcrumb-holder">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Payments</li>
            </ul>
        </div>
    </div>

    <!-- Start here -->

    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <i class="fa fa-table"></i>
                    Payments
                    <a href="{{route('payment.create')}}" class="text-white offset-10" style="height:20px;">
                        <span style="height:20px; font-size: 150%;" class="fa fa-plus">Add Payment</span>
                    </a>
                </div>

                <div class="container-fluid categoryPage">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Payments Table</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped category-table" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Client id</th>
                                                    <th>Client Name</th>
                                                    <th>Select Mode</th>
                                                    <th>Payment Amount</th>
                                                    <th>Adjust Advance</th>
                                                    <th> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($payment as $key)
                                                <tr>
                                                    <th scope="row">{{$loop->iteration}}</th>
                                                    <td>{{$key->client_id ?? ''}}</td>
                                                    <td>{{$key->client->name ?? ''}}</td>
                                                    <td>{{$key->select_mode ?? ''}}</td>
                                                    <td>{{$key->payment_amount ?? ''}}</td>
                                                    <td>{{$key->adjust_advance ?? ''}}</td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><button class="btn btn-sm btn-primary edit" data-id="{{$key->id ?? ''}}" data-client_id="{{$key->client->id ?? ''}}" data-select_mode="{{$key->select_mode ?? ''}}" data-payment_amount="{{$key->payment_amount ?? ''}}" data-adjust_advance="{{$key->adjust_advance ?? ''}}"><i class="fa fa-edit"></i>Edit</button></td>
                                                                <td><a class="btn btn-sm btn-danger delete" onclick="return confirm('do you want to delete')" href="{{route('payment.delete',$key->id)}}"><i class="fa fa-trash"></i>Delete</a></td>

                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                        <div class="d-flex justify-content-center">
                                            {!! $payment->links() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!--Sub Category Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <form id="payment-form" method="post">
                    @csrf
                    <input type="hidden" id="payment-id" name="id" value="">
                    <div class="form-group">
                        <label> Client Name</label>
                        <select name="clientId" id="clientId" class="clientId form-control ">
                            <option value="">Select</option>
                            @foreach($client as $key)
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
                        <label>Select Mode</label>
                        <input type="text" id="selectMode" name="selectMode" placeholder="Selected Mode" class="form-control @error('selectMode') is-invalid @enderror">
                        @error('selectMode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Payment Amount</label>
                        <input type="text" id="paymentAmount" name="paymentAmount" placeholder="Payment amount" class="form-control @error('paymentAmount') is-invalid @enderror">
                        @error('paymentAmount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Adjust Advance</label>
                        <input type="text" id="adjustAdvance" name="adjustAdvance" placeholder="Adjust Advance" class="form-control @error('adjustAdvance') is-invalid @enderror">
                        @error('adjustAdvance')
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

        $('.create-payment').click(function(e) {
            $("#paymentModal").modal('show')

            $('.modal-title').html('Create Client')
            FormResetData();
        })

        $('.edit').click(function(e) {
            FormResetData();
            $("#paymentModal").modal('show')
            $("#payment-id").val($(this).data('id'))
            $("#name").val($(this).data('client_name'))
            $("#selectMode").val($(this).data('select_mode'))
            $("#paymentAmount").val($(this).data('payment_amount'))
            $("#adjustAdvance").val($(this).data('adjust_advance'))

            var client = $(this).data('client_id')

            $('#clientId').val(client).prop('selected', true);

            $('.modal-title').html('Update Payment')
            $("#payment-form").attr('action', "{{route('payment.update')}}")

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

<!-- for datatable -->
@push('scripts')
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable ').DataTable({
            "order": [
                [1, "desc"]
            ]
        });
    });
</script>
@endpush