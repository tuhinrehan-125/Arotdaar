@extends('layouts.main', ['activePage' => 'advance', 'titlePage' => __('Payment')])

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">



    <link href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">



    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">


    <style>
        .secondNav {
            margin-top: 26px;
        }

        .categoryPage {
            height: 1050px;
        }

        body,
        section {
            background-color: #F2EDF3;
            background: #F2EDF3;
        }

        label {
            color: #555;
            padding: 5px;
        }

        /* dynamic form */
        .wrapper {

            justify-content: center;
            flex-wrap: wrap;
            padding: 10px 0;
            margin: 0 auto;
        }

        .dynamoDrop {

            width: 100%;
            padding: 15px;
            font-size: 16px;
            font-weight: 700px;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 8px;
            border: 2px solid #3f51b5;
            box-shadow: 0 15px 15px #efefef;
            appearance: none;
        }

        .content {
            margin: 30px 0;
        }

        .content .data {
            padding: 25px;
            background-color: #fff;
            border: 2px solid #8bc34a;
            border-radius: 8px;
        }

        .content p span {
            float: right;
            font-weight: normal;
        }

        .data {
            display: none;
        }

        /* end here  */



        input[type=text],
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 3px solid #ccc;
            -webkit-transition: 0.5s;
            transition: 0.5s;
            outline: none;
        }

        input[type=text]:focus {
            border: 3px solid #555;
        }


        input[name=search] {
            width: 130px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: white;
            background-image: url('searchicon.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            padding: 12px 20px 12px 40px;
            transition: width 0.4s ease-in-out;
        }

        input[name=search]:focus {
            width: 100%;
        }
    </style>


</head>


@section('content')

<body>



    <section class="dashboard-counts section-padding secondNav">
        <div class="breadcrumb-holder">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Advance</li>
                    <li class="breadcrumb-item active">Create</li>
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
                        Advance Table
                        <a href="{{route('advance.index')}}" class="text-white offset-10" style="height:20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z" />
                            </svg>
                            <span style="height:20px; font-size: 150%;" class="">Back Page</span>
                        </a>
                    </div>

                    <div class="container-fluid categoryPage">
                        <div class="row justify-content-center">

                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center" style="height: 50px; ">
                                            <h4 class=" card-title">Advance Form</h4>
                                        </div>
                                        <div class="search">
                                            <form action="">
                                                <input type="text" name="search" placeholder="Search..">
                                            </form>
                                        </div>

                                        <div class="menu">
                                            <select name="" id="name" class="dynamoDrop">
                                                <option value="">Select Advance Method</option>
                                                <option value="cash">Cash</option>
                                                <option value="bank">Bank</option>
                                                <option value="bkash">bKash</option>

                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="text-center" style="height: 10px;">
                                            <h4 class=" card-title">Select Mode</h4>
                                        </div>

                                        <div class="row">

                                            <!-- Dynamic form create -->
                                            <div class="wrapper">
                                                <!-- <div class="menu">
                                                    <select name="" id="name" class="dynamoDrop">
                                                        <option value="">Select Mode</option>
                                                        <option value="cash">Cash</option>
                                                        <option value="bank">Bank</option>
                                                        <option value="bkash">bKash</option>

                                                    </select>
                                                </div> -->

                                                <div class="content">
                                                    <div id="cash" class="data">
                                                        <form action="{{route('advance.store')}}" id="cash-method-form" method="post">

                                                            @csrf
                                                            <input type="hidden" id="payment-id" name="cashId" value="">

                                                            <label for="notify" style="height: 40px; width:180px; background-color: #606060FF; font-size:20px; color:#D6ED17FF;">Payment By Cash:</label>

                                                            <div class="form-group row">
                                                                <label for="clientName" class="col-sm-3 col-form-label">Client Name</label>
                                                                <div class="col-sm-9">
                                                                    <select name="client_id" id="clientId" class="clientId">
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
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Amount</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" id="by_cash" name="by_cash" placeholder="Amount" class="@error('by_cash') is-invalid @enderror">
                                                                    @error('by_cash')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <button class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div id="bank" class="data">
                                                        <form action="{{route('advance.store')}}" id="bank-method-form" method="post">

                                                            @csrf
                                                            <input type="hidden" id="payment-id" name="bankId" value="">

                                                            <label for="notify" style="height: 40px; width:180px; background-color: #606060FF; font-size:20px; color:#D6ED17FF;">Payment By Bank:</label>

                                                            <div class="form-group row">
                                                                <label for="clientName" class="col-sm-3 col-form-label">Client Name</label>
                                                                <div class="col-sm-9">
                                                                    <select name="client_id" id="clientId" class="clientId">
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
                                                            </div>
                                                            <!-- <div class="form-group row">
                                                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Bank Name</label>
                                                                <div class="col-sm-9">
                                                                    <select name="bank_id" id="bankId" class="bankId ">
                                                                        <option value="">Select Bank</option>
                                                                        @foreach($bank as $key)
                                                                        <option value="{{ $key->id ?? ''}}">{{$key->name ?? ''}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div> -->
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Amount</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" id="by_bank" name="by_bank" placeholder="Enter The Amount" class="@error('by_bank') is-invalid @enderror">
                                                                    @error('by_bank')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <button class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div id="bkash" class="data">
                                                        <form action="{{route('advance.store')}}" id="bkash-method-form" method="post">

                                                            @csrf
                                                            <input type="hidden" id="payment-id" name="bkashId" value="">

                                                            <label for="notify" style="height: 40px; width:190px; background-color: #606060FF; font-size:20px; color:#D6ED17FF;">Payment By bKash:</label>

                                                            <div class="form-group row">
                                                                <label for="clientName" class="col-sm-3 col-form-label">Client Name</label>
                                                                <div class="col-sm-9">
                                                                    <select name="client_id" id="clientId" class="clientId">
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
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Amount</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" id="by_bKash" name="by_bKash" placeholder="Enter The Amount" class="@error('by_bKash') is-invalid @enderror">
                                                                    @error('by_bKash')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <button class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end here -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $("#name").on('change', function() {
            // alert($(this).val());

            $(".data").hide();
            $("#" + $(this).val()).fadeIn(700);

        }).change();

    });
</script>

@endsection