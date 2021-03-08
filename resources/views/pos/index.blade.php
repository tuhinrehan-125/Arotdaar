@extends('layouts.main', ['activePage' => 'pos', 'titlePage' => __('Dashboard')])

@section('content')
<html>

<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<style>
    .col1 {
        background-color: gray;
        color: white;
        height: 110px;
        width: 120px;
    }

    .col2 {
        background-color: gray;
        color: white;
        height: 110px;
        width: 120px;
    }

    .col3 {
        background-color: gray;
        color: white;
        height: 110px;
        width: 120px;
    }

    .col4 {
        background-color: gray;
        color: white;
        height: 110px;
        width: 120px;
    }

    .col5 {
        background-color: gray;
        color: white;
        height: 110px;
        width: 120px;
    }

    .col6 {
        background-color: gray;
        color: white;
        height: 110px;
        width: 120px;
    }

    .row1 {
        margin-top: -20px;
        margin-bottom: 0;
        margin-left: -10px;
        margin-right: 0px;
    }

    .row2 {
        margin-top: -50px;
        margin-bottom: 0;
        margin-left: -10px;
        margin-right: 0px;
    }

    .row3 {
        margin-top: -50px;
        margin-bottom: 0;
        margin-left: -10px;
        margin-right: 0px;
    }

    .fishList {
        margin-top: 5px;
        height: 402px;
    }

    .fishList2 {
        margin-top: 35px;
        height: 402px;
    }

    /* For customer select */
    .customerSelect {
        width: 300px;
        height: 50px;
        line-height: 30px;
        font-size: 26px;
        border: 2px solid#CCC;
        padding-left: 5px
    }

    .customerPlus {
        margin-top: -10px;
        height: 49px;
    }


    /* for live search */
    * {
        font-family: Tahoma, Geneva, sans-serif
    }

    div#all {
        width: 350px;
        position: relative;

    }

    input#q {
        width: 300px;
        height: 30px;
        line-height: 30px;
        font-size: 26px;
        border: 2px solid#CCC;
        padding-left: 5px
    }

    span#tip {
        font-size: 12px;
        line-height: 30px;
        margin-left: 15px;
        color: #F30;
        font-weight: bold;
        margin-bottom: 0px
    }

    ul#results li {
        color: #666;
        line-height: 1.7em
    }

    .productSearchAll {
        margin-left: 25px;
        margin-bottom: 0em;
    }

    .productSearch {
        height: 45px;
        width: 500px;
    }

    .productSearchButton {
        height: 45px;
    }

    /* end of live search */
</style>

<div class="content">

    <!-- Showing first division -->
    <div class="container-fluid">


        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <!-- <select class="selectpicker" data-live-search="true">
                    <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                    <option data-tokens="mustard">Burger, Shake and a Smile</option>
                    <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                     </select> -->
                        <div id="all">
                            <form class="form-inline mr-auto productSearchAll">
                                <input class="form-control mr-sm-2 productSearch" id="results" type="text" placeholder="পণ্য সার্চ করুন" aria-label="Search">
                                <ul id="results"></ul>
                                <button class="w3-button  w3-teal productSearchButton" type="submit">Search</button>
                            </form>
                            <!-- <input id="q" />
                            <ul id="results">
                            </ul> -->
                        </div>
                        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
                        <script type="text/javascript" src="http://rails-oceania.googlecode.com/svn/lachiecox/qs_score/trunk/qs_score.js"></script>
                        <script>
                            //  A placeholder for the real code 
                        </script>
                        <script>
                            var items = ["Agavi", "AIDA Web", "Akelos", "Apache Click", "Apache Cocoon", "Apache Struts", "Apache Wicket", "AppFuse", "Aranea", "ASP.NET MVC", "Axiom Stack", "BFC", "CakePHP", "DooPHP", "Camping", "Catalyst", "CherryPy", "CodeIgniter", "ColdSpring", "Csla", "CppCMS", "CubicWeb", "Django", "Drupal", "DotNetNuke", "eZ Components", "Flex", "FUSE", "Fusebox", "Google Web Toolkit", "Grok", "Grails", "Hamlets", "Helix", "Horde", "Interchange", "ItsNat", "IT Mill Toolkit", "JavaServer Faces", "JBoss Seam", "Kepler", "Kohana", "KumbiaPHP", "Lift", "LISA", "ManyDesigns Portofino", "Mason", "Maypole", "Mach-II", "Merb", "Midgard", "Model-Glue", "MonoRail", "Morfik", "Nitro", "onTap", "OpenACS", "OpenLaszlo", "OpenXava", "Orbit", "Orinoco", "PEAR", "PHP For Applications", "PHP Work", "Pyjamas", "Pylons", "Qcodo", "RIFE", "Ruby on Rails", "Samstyle", "Seaside", "Shale", "SilverStripe (Sapphire)", "Simplicity", "Sinatra", "SmartClient", "Sofia", "SPIP", "Spring", "Stripes", "Symfony", "Tapestry", "ThinWire", "Tigermouse", "Vaadin", "TurboGears", "Wavemaker", "web2py", "WebObjects", "WebWork", "Wigbi", "Yii", "Zend", "ZK", "Zoop", "Zope 2", "Zope 3", "ztemplates"];
                        </script>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <select class="mdb-select md-form customerSelect" searchable="Search here..">
                            <option value="" disabled selected>কাস্টমার নির্বাচন করুন </option>
                            <option value="1">মোঃ রফিক</option>
                            <option value="2">মোঃ শফিক</option>
                            <option value="3">মোঃ আরিফ</option>
                            <option value="3">মোঃ তুহিন</option>
                            <option value="3"> সিফাত রহমান</option>
                            <option value="3">সারোয়ার আহমেদ </option>
                            <option value="3">মাহফুজুর রহমান </option>
                            <option value="3">রায়হান চৌধুরী </option>
                        </select>
                        <button class="w3-button w3-xlarge w3-teal customerPlus">+</button>
                        <script>
                            // Material Select Initialization
                            $(document).ready(function() {
                                $('.mdb-select').materialSelect();
                            });
                        </script>
                    </div>

                </div>


                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>আইটেম নাম </th>
                                <th>দাম </th>
                                <th>পরিমান </th>
                                <th>টাকা </th>
                                <th>ধরণ </th>
                                <th>কাস্টমার নাম </th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>কাটাল (বড় )</td>
                                    <td>৬,৮৫০</td>
                                    <td>৪০ কেজি</td>
                                    <td>১৮,৫৬০</td>
                                    <td>
                                        <select class="selectpicker">
                                            <option>ক্যাশ</option>
                                            <option>বাঁকি</option>
                                            <option>অগ্রিম</option>
                                        </select>
                                    </td>
                                    <td>মোঃ শফিক</td>
                                    <td>
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>Edit</button>
                                        </li>
                                    </td>
                                </tr>
                                <tr>
                                    <td>কাটাল (ছোট )</td>
                                    <td>৬,৮৫০</td>
                                    <td> ৪০ কেজি</td>
                                    <td>১৮,৫৬০</td>
                                    <td>
                                        <select class="selectpicker">
                                            <option>ক্যাশ</option>
                                            <option>বাঁকি</option>
                                            <option>অগ্রিম</option>
                                        </select>
                                    </td>
                                    <td>মোঃ রফিক</td>
                                    <td>
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>Edit</button>
                                        </li>
                                    </td>
                                </tr>
                                <tr>
                                    <td>রুই</td>
                                    <td>৬,৮৫০</td>
                                    <td>৪০ কেজি</td>
                                    <td>১৮,৫৬০</td>
                                    <td>
                                        <select class="selectpicker">
                                            <option>ক্যাশ</option>
                                            <option>বাঁকি</option>
                                            <option>অগ্রিম</option>
                                        </select>
                                    </td>
                                    <td>মোঃ শফিক</td>
                                    <td>
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>Edit</button>
                                        </li>
                                    </td>
                                </tr>
                                <tr>
                                    <td>মৃগেল </td>
                                    <td>৬,৮৫০</td>
                                    <td>৪০ কেজি</td>
                                    <td>১৮,৫৬০</td>
                                    <td>
                                        <select class="selectpicker">
                                            <option>ক্যাশ</option>
                                            <option>বাঁকি</option>
                                            <option>অগ্রিম</option>
                                        </select>
                                    </td>
                                    <td>মোঃ রফিক</td>
                                    <td>
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>Edit</button>
                                        </li>
                                    </td>
                                </tr>
                                <tr>
                                    <td>মাগুর</td>
                                    <td>৬,৮৫০</td>
                                    <td>৪০ কেজি</td>
                                    <td>১৮,৫৬০</td>
                                    <td>
                                        <select class="selectpicker">
                                            <option>ক্যাশ</option>
                                            <option>বাঁকি</option>
                                            <option>অগ্রিম</option>
                                        </select>
                                    </td>
                                    <td>মোঃ শফিক</td>
                                    <td>
                                        <li class="list-inline-item">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i>Edit</button>
                                        </li>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-hover">

                            <tbody>
                                <tr>
                                    <td class="text-right">সর্বমোট টাকা</td>
                                    <td class="text-center"> = </td>
                                    <td class="text-left">৮,৫৬০</td>

                                </tr>
                                <tr>
                                    <td class="text-right">কমিশন </td>
                                    <td class="text-center">=</td>
                                    <td class="text-left">১৮,৫৬০</td>

                                </tr>
                                <tr>
                                    <td class="text-right">দাদন </td>
                                    <td class="text-center">=</td>
                                    <td class="text-left">১২,৫৬০</td>

                                </tr>

                                <tr>
                                    <td class="text-right">টোটাল </td>
                                    <td class="text-center">=</td>
                                    <td class="text-left">১২২,৫৬০</td>
                                </tr>

                                <tr>
                                    <td class="text-right"> </td>
                                    <td class="text-center"></td>
                                    <td class="text-left"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card fishList">
                    <div class="card-header card-header-danger">
                        <h6 class="card-title">দেশি মাছ </h6>
                    </div>
                    <div class="row row1">
                        <div class="col-sm-2">
                            <div class="card  col1">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card   col2">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col3">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col4">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col5">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col6">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  row2">
                        <div class="col-sm-2">
                            <div class="card  col1">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card   col2">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col3">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col4">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col5">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col6">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row  row3">
                        <div class="col-sm-2">
                            <div class="card  col1">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card   col2">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col3">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col4">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col5">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card  col6">
                                <div class="card-body">
                                    <p>no entry</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card fishList2">
                    <div class="popularFish">
                        <div class="card-header card-header-danger">
                            <h6 class="card-title">নদী বা সামুদ্রিক মাছ </h6>
                        </div>
                        <div class="row justify-content-center row1">
                            <div class="col-sm-2">
                                <div class="card  col1">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card   col2">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col3">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col4">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col5">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col6">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center row2">
                            <div class="col-sm-2">
                                <div class="card  col1">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card   col2">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col3">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col4">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col5">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col6">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center row3">
                            <div class="col-sm-2">
                                <div class="card  col1">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card   col2">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col3">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col4">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col5">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card  col6">
                                    <div class="card-body">
                                        <p>no entry</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</html>
@endsection