@extends('layouts.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<html>
<style>
    /* div [class*="col-"] {
        text-align: center;
        padding: 20px;
        font-size: 28px;
        background: radial-gradient(ellipse at center, #ff6600 0%, #ce3400 100%);
        border: 3px solid #fff;
        color: #000;
    } */

    .col1 {
        background-image: linear-gradient(to right, #f83600 0%, #f9d423 100%);
        color: white;
    }

    .col2 {
        background-image: linear-gradient(180deg, #2af598 0%, #009efd 100%);
        color: white;
    }

    .col3 {
        background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .col4 {
        background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .col5 {
        background-image: linear-gradient(to right, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .col6 {
        background-image: linear-gradient(to right, #00dbde 0%, #fc00ff 100%);
        color: white;
    }

    h3 .card-body h4 {
        margin-top: 0px;

    }

    .NogodDiv {
        margin-top: 30px;
    }

    .commissionDiv {
        margin-top: 10px;
    }

    .popularFish {
        margin-top: 17px;
    }
</style>

<div class="content">

    <!-- Showing first division -->
    <div class="container-fluid">
        <h4>আজকের সর্বশেষ তথ্য </h4>
        <div class="row justify-content-center">
            <div class="col-sm-2">
                <div class="card  col1">
                    <div class="card-body">
                        <h2 class="card-title">1</h2>
                        <h4>সর্বমোট আয় </h4>
                        <h3>৩২,৮৭,৬৫৮/=</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card   col2">
                    <div class="card-body">
                        <h2 class="card-title">2</h2>
                        <h4>লাভ / মুনাফা </h4>
                        <h3>১০২,৬৫৮/=</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card  col3">
                    <div class="card-body">
                        <h2 class="card-title">3</h2>
                        <h4> খরচ </h4>
                        <h3>৮৭,৬৫৮/=</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card  col4">
                    <div class="card-body">
                        <h2 class="card-title">4</h2>
                        <h4>সর্বমোট ক্লায়েন্ট</h4>
                        <h3>৩২</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card  col5">
                    <div class="card-body">
                        <h2 class="card-title">5</h2>
                        <h4>সর্বমোট ক্রেতা / কাস্টমার </h4>
                        <h3>৮৭</h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="card  col6">
                    <div class="card-body">
                        <h2 class="card-title">5</h2>
                        <h4>Think About It </h4>
                        <h3>no entry</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12">

                <head>
                    <script>
                        window.onload = function() {
                            var chart = new CanvasJS.Chart("chartContainer", {
                                animationEnabled: true,
                                title: {
                                    text: "সর্বশেষ লেনদেন এর তথ্য "
                                },
                                axisY: {
                                    title: "",
                                    valueFormatString: "#1756,,.",
                                    suffix: "/=",
                                    prefix: "৳"
                                },
                                data: [{
                                    type: "splineArea",
                                    color: "rgba(54,158,173,.7)",
                                    markerSize: 5,
                                    xValueFormatString: "YYYY",
                                    yValueFormatString: "$#,##0.##",
                                    dataPoints: [{
                                            x: new Date(2000, 0),
                                            y: 3289000
                                        },
                                        {
                                            x: new Date(2001, 0),
                                            y: 3830000
                                        },
                                        {
                                            x: new Date(2002, 0),
                                            y: 2009000
                                        },
                                        {
                                            x: new Date(2003, 0),
                                            y: 2840000
                                        },
                                        {
                                            x: new Date(2004, 0),
                                            y: 2396000
                                        },
                                        {
                                            x: new Date(2005, 0),
                                            y: 1613000
                                        },
                                        {
                                            x: new Date(2006, 0),
                                            y: 2821000
                                        },
                                        {
                                            x: new Date(2007, 0),
                                            y: 2000000
                                        },
                                        {
                                            x: new Date(2008, 0),
                                            y: 1397000
                                        },
                                        {
                                            x: new Date(2009, 0),
                                            y: 2506000
                                        },
                                        {
                                            x: new Date(2010, 0),
                                            y: 2798000
                                        },
                                        {
                                            x: new Date(2011, 0),
                                            y: 3386000
                                        },
                                        {
                                            x: new Date(2012, 0),
                                            y: 6704000
                                        },
                                        {
                                            x: new Date(2013, 0),
                                            y: 6026000
                                        },
                                        {
                                            x: new Date(2014, 0),
                                            y: 2394000
                                        },
                                        {
                                            x: new Date(2015, 0),
                                            y: 1872000
                                        },
                                        {
                                            x: new Date(2016, 0),
                                            y: 2140000
                                        }
                                    ]
                                }]
                            });
                            chart.render();
                        }
                    </script>
                </head>

                <body>
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                </body>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="card card-chart">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-sm-6 text-left">
                                        <h3 class="card-category">সর্বশেষ লেনদেন এর তথ্য </h3>
                                       </div>
                                    <div class="col-sm-6">
                                        <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                            <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                                <input type="radio" name="options" checked>
                                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Accounts</span>
                                                <span class="d-block d-sm-none">
                                                    <i class="tim-icons icon-single-02"></i>
                                                </span>
                                            </label>
                                            <label class="btn btn-sm btn-primary btn-simple" id="1">
                                                <input type="radio" class="d-none d-sm-none" name="options">
                                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Purchases</span>
                                                <span class="d-block d-sm-none">
                                                    <i class="tim-icons icon-gift-2"></i>
                                                </span>
                                            </label>
                                            <label class="btn btn-sm btn-primary btn-simple" id="2">
                                                <input type="radio" class="d-none" name="options">
                                                <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Sessions</span>
                                                <span class="d-block d-sm-none">
                                                    <i class="tim-icons icon-tap-02"></i>
                                                </span>
                                            </label>

                                        </div>

                                    </div>
                                    <div>

                                        <h2>Here will be the area chart</h2>

                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="chartBig1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="row NogodDiv">
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-warning">
                                <h4 class="card-title">নগদ পেমেন্ট:</h4>
                                <p class="card-category">List of cash payments</p>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-hover">
                                    <thead class="text-warning">
                                        <th>পেমেন্টের পদ্ধতি </th>
                                        <th>মাধ্যমের নাম</th>
                                        <th>টাকা</th>
                                        <th>তারিখ </th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Bank</td>
                                            <td>Dhaka Bank Ltd</td>
                                            <td> ২৩,৯৮৫/=</td>
                                            <td>14/12/2020</td>
                                        </tr>
                                        <tr>
                                            <td>Bank</td>
                                            <td>Jamuna Bank Ltd</td>
                                            <td> ২৩,৯৮৫/=</td>
                                            <td>14/12/2020</td>
                                        </tr>
                                        <tr>
                                            <td>Bank</td>
                                            <td>City Bank Ltd</td>
                                            <td> ২৩,৯৮৫/=</td>
                                            <td>14/12/2020</td>
                                        </tr>
                                        <tr>
                                            <td>Bank</td>
                                            <td>DBBL</td>
                                            <td> ২৩,৯৮৫/=</td>
                                            <td>14/12/2020</td>
                                        </tr>
                                        <tr>
                                            <td>Bank</td>
                                            <td>SIBL</td>
                                            <td> ২৩,৯৮৫/=</td>
                                            <td>14/12/2020</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 commissionDiv ">
                        <div id="piechart"></div>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            // Load google charts
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawChart);

                            // Draw the chart and set the chart values
                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Task', 'Hours per Day'],
                                    ['Work', 5],
                                    ['Eat', 6],
                                    ['TV', 4]
                                ]);

                                // Optional; add a title and set the width and height of the chart
                                var options = {
                                    'title': 'কমিশন সমূহ ',
                                    'width': 508,
                                    'height': 420
                                };

                                // Display the chart inside the <div> element with id="piechart"
                                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                chart.draw(data, options);
                            }
                        </script>

                        <!-- <body>
                            <div id="chartContainer" style="height: 430px; width: 100%;">
                            </div>
                        </body> -->
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-primary">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <span class="nav-tabs-title">Tasks:</span>
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#profile" data-toggle="tab">
                                                <i class="material-icons">bug_report</i> Bugs
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#messages" data-toggle="tab">
                                                <i class="material-icons">code</i> Website
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#settings" data-toggle="tab">
                                                <i class="material-icons">cloud</i> Server
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="" checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                                </td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="" checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Create 4 Invisible User Experiences you Never Knew About</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="messages">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="" checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                                </td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="settings">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="">
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="" checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                                </td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="" checked>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                <td class="td-actions text-right">
                                                    <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-header card-header-danger">
                        <h4 class="card-title">রেগুলার কাস্টমার </h4>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th></th>
                                <th>বিক্রেতার নাম </th>
                                <th class="text-right">লেনদেন এর পরিমান</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th> <img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>মোঃ আরিফ</td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                                <tr>
                                    <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>মোঃ তুহিন</td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                                <tr>
                                    <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>মোঃ রেহান </td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                                <tr>
                                    <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>মোঃ লিটন </td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                                <tr>
                                    <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>মোঃ প্রমিসুর </td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                                <tr>
                                    <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>মোঃ সিফাত </td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                                <tr>
                                    <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>মোঃ সারোয়ার</td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                                <tr>
                                    <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>মোঃ শফিক </td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                                <tr>
                                    <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                    <td>রঞ্জিত মল্লিক </td>
                                    <td class="text-right">২৩,৯৮৫/=</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card ">
                    <div class="popularFish">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">পপুলার মাছ সমূহ </h4>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th></th>
                                    <th>মাছের নাম</th>
                                    <th class="text-right">শতকরা বেশী বিক্রয়</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th> <img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td> কাতাল মাছ</td>
                                        <td class="text-right">৯৮%</td>

                                    </tr>
                                    <tr>
                                        <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td> রুই মাছ </td>
                                        <td class="text-right">৯৮%</td>
                                    </tr>
                                    <tr>
                                        <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td> মাগুর মাছ </td>
                                        <td class="text-right">৯৭%</td>
                                    </tr>
                                    <tr>
                                        <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td>টেংরা মাছ </td>
                                        <td class="text-right">৯৭%</td>
                                    </tr>
                                    <tr>
                                        <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td>ইলিশ মাছ </td>
                                        <td class="text-right">৯৬%</td>
                                    </tr>
                                    <tr>
                                        <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td>তেলাপিয়া মাছ </td>
                                        <td class="text-right">৯৬%</td>
                                    </tr>
                                    <tr>
                                        <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td>লইট্যা মাছ </td>
                                        <td class="text-right">৯৫%</td>
                                    </tr>
                                    <tr>
                                        <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td>চিংড়ি মাছ </td>
                                        <td class="text-right">৯৫%</td>
                                    </tr>
                                    <tr>
                                        <th><img src="../../assets/images/profile.jpg" alt="image"></th>
                                        <td>মৃগেল মাছ </td>
                                        <td class="text-right">৯৪%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</html>
@endsection