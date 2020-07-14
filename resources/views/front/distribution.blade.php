

@extends('front.layout.front')

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <!--<div class="page-bar">
<ul class="page-breadcrumb">
    <li>
        <a href="index.html">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Dashboard</span>
    </li>
</ul>
<div class="page-toolbar">
    <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
        <i class="icon-calendar"></i>&nbsp;
        <span class="thin uppercase hidden-xs"></span>&nbsp;
        <i class="fa fa-angle-down"></i>
    </div>
</div>
</div>-->
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->
            <!-- PAGE CONTENT AAA-->
            <!-- BEGIN PAGE TITLE-->
            <!--<h1 class="page-title">
Admin Dashboard 2
<small>statistics, charts, recent events and reports</small>
</h1>-->
            <!-- END PAGE TITLE-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title"> Token Sale Distribution </div>
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th> Tokens issued </th>
                                <th> Tokens for sale </th>
                                <th> Token exchange rate </th>
                                <!-- <th> Token Sold </th> -->
                                <th> Hard Cap </th>
                                <th> Soft Cap </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td> 2,500,000,000 GIFT </td>
                                <td> 200,000,000 GIFT </td>
                                <td> 0.02 $ </td>
                                <!-- <td> {{number_format($total,0,'.',',')}} GIFT</td> -->
                                <td> 5,000,000 USD</td>
                                <td> 500,000 USD</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-6 col-xs-12 col-sm-12 col-md-offset-3">
                    <div class="portlet light ">
                        <div class="">
                            <div class="caption">
                                <span class="caption-subject bold font-dark">Bonus for Early Backers</span>
                            </div>
                        </div>
                        <br />
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="text-success">
                                            Private Sale
                                        </td>
                                        <td class="text-primary">
                                            May 17 2018 </td><td>to</td><td class="text-info"> June 09 2018
                                        </td>
                                        <td class="text-danger text-right"> 50% </td>
                                    </tr>
                                    <tr>
                                        <td class="text-success">
                                            Pre-Sale 1
                                        </td><td class="text-primary">
                                            June 10 2018 </td><td>to</td><td class="text-info"> June 30 2018
                                        </td>
                                        <td class="text-danger text-right"> 30% </td>
                                    </tr>
                                    <tr>
                                        <td class="text-success">
                                            Pre- Sale 2
                                        </td><td class="text-primary">
                                            July 01 2018 </td><td>to</td><td class="text-info"> July 14 2018
                                        </td>
                                        <td class="text-danger text-right"> 20% </td>
                                    </tr>
                                    <tr>
                                        <td class="text-success">
                                            Pre- Sale 3
                                        </td><td class="text-primary">
                                            July 15 2018 </td><td>to</td><td class="text-info"> July 31 2018
                                        </td>
                                        <td class="text-danger text-right"> 10% </td>
                                    </tr>
                                    <tr>
                                        <td class="text-success">
                                            Sales
                                        </td><td class="text-primary">
                                            Aug 01 2018 </td><td>to </td><td class="text-info">Aug 30 2018
                                        </td>
                                        <td class="text-danger text-right"> 0% </td>
                                    </tr>
                                    </tbody>
                                    <!--<tbody>
                        <tr>
                            <td class="text-success"> $1000 - 10,000 </td>
                            <td class="text-danger"> 5% </td>
                        </tr>
                        <tr>
                            <td class="text-success"> $10,000 - 50,000 </td>
                            <td class="text-danger"> 10% </td>
                        </tr>
                        <tr>
                            <td class="text-success"> $10,000 - 50,000 </td>
                            <td class="text-danger"> 10% </td>
                        </tr>
                        <tr>
                            <td class="text-success"> $10,000 - 50,000 </td>
                            <td class="text-danger"> 10% </td>
                        </tr>
                    </tbody>-->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="col-lg-8 col-xs-12 col-sm-12">--}}
                {{--<div class="portlet light ">--}}
                {{--<div class="caption text-center">--}}
                {{--<span class="caption-subject font-dark bold uppercase">--}}
                {{--Pre-ICO Round 1: June 17, 2018 – July 18, 2018--}}
                {{--</span>--}}
                {{--<div>--}}
                {{--Tokens for sale:	2,000,000,000 ICOTOKEN (20%), Min contribution amount:	100$--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="portlet-body">--}}
                {{--<div class="table-responsive">--}}
                {{--<table class="table">--}}
                {{--<thead>--}}
                {{--<tr>--}}
                {{--<th> Bonus </th>--}}
                {{--<th> Dates </th>--}}
                {{--<th class="text-right"> % </th>--}}
                {{--<th class="text-right"> Token Price </th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--<tr>--}}
                {{--<td class="text-success"> 1st day </td>--}}
                {{--<td class="text-danger"> April 15, 2018 </td>--}}
                {{--<td class="text-danger text-right"> 50% </td>--}}
                {{--<td class="text-success text-right"> 0.008$ </td>--}}
                {{--</tr>--}}

                {{--<tr>--}}
                {{--<td class="text-success"> 1st week </td>--}}
                {{--<td class="text-danger"> April 16 - 22, 2018 </td>--}}
                {{--<td class="text-danger text-right"> 40% </td>--}}
                {{--<td class="text-success text-right"> 0.0085$ </td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                {{--<td class="text-success"> 2nd week </td>--}}
                {{--<td class="text-danger"> April 23 - 29, 2018 </td>--}}
                {{--<td class="text-danger text-right"> 30% </td>--}}
                {{--<td class="text-success text-right"> 0.009$ </td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                {{--<td class="text-success"> 2nd week </td>--}}
                {{--<td class="text-danger"> April 30 - May 6, 2018 </td>--}}
                {{--<td class="text-danger text-right"> 20% </td>--}}
                {{--<td class="text-success text-right"> 0.0095$ </td>--}}
                {{--</tr>--}}
                {{--</tbody>--}}
                {{--</table>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div> -->

            <!-- /PAGE CONTENT AAA-->

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler">
        <i class="icon-login"></i>
    </a>
@endsection