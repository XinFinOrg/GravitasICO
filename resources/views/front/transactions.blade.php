@extends('front.layout.front')

@section('content')

    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
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
               @if(!$results)
                <div class="alert alert-info" >
                    You do not have any transaction.
                </div>
                @else

                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet light ">
                            <div class="caption text-center">
                                    <span class="caption-subject font-dark bold uppercase">
                                        Transaction History
                                    </span>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th> Date </th>
                                            <th> Cryptocurrency  </th>
                                            <th class="text-right"> GIFT </th>
                                            <th class="text-right"> Bonus </th>
                                            <th class="text-right"> Total GIFT </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($results as $result)

                                        <tr>
                                            <td class=""> {{$result->updated_at}}</td>
                                            <!--<td class="text-success"> 0,001207104 <img class="ccy ccy-btc"></td>-->
                                            <td class="text-success"> {{$result->Amount}} 
                                            @if($result->SecondCurrency == 'BTC') <strong>BTC</strong>
                                            @elseif($result->SecondCurrency == 'USDT') <strong>USDT</strong>
                                            @else<strong>ETH</strong>@endif
                                            </td>
                                            <td class="text-danger text-right">  {{$result->firstAmount}} </td>
                                            <td class="text-danger text-right"> {{$result->Discount}}</td>
                                            <td class="text-success text-right"> {{$result->Total}} </td>
                                        </tr>
                                        @endforeach
                                        {{--<tr>--}}
                                            {{--<td class=""> 15 May 2018, 14:07 </td>--}}
                                            {{--<td class="text-success"> 0,002207104 <i class="fab fa-ethereum"> Ethereum</i></td>--}}
                                            {{--<td class="text-danger text-right"> 134.13 </td>--}}
                                            {{--<td class="text-danger text-right"> (20%) 26 </td>--}}
                                            {{--<td class="text-success text-right"> 160.13 </td>--}}
                                        {{--</tr>--}}
                                        {{--<tr>--}}
                                            {{--<td class=""> 10 May 2018, 10:10 </td>--}}
                                            {{--<td class="text-success"> 0,004201221 <i class="ccy ccy-litecoin"> Litecoin </i></td>--}}
                                            {{--<td class="text-danger text-right"> 94.72 </td>--}}
                                            {{--<td class="text-danger text-right"> (30%) 27 </td>--}}
                                            {{--<td class="text-success text-right"> 121.72 </td>--}}
                                        {{--</tr>--}}
                                        {{--<tr>--}}
                                            {{--<td class=""> 01 May 2018, 04:44 </td>--}}
                                            {{--<td class="text-success"> 0,005587533 <i class="ccy ccy-ripple"> Ripple </i></td>--}}
                                            {{--<td class="text-danger text-right"> 244.77 </td>--}}
                                            {{--<td class="text-danger text-right"> (50%) 122 </td>--}}
                                            {{--<td class="text-success text-right"> 366.77 </td>--}}
                                        {{--</tr>--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /PAGE CONTENT AAA-->
                @endif
            </div>
            <!-- END CONTENT BODY -->
        </div>
    <!-- END SIDEBAR -->
@endsection