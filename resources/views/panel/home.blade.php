@extends("panel.layout.admin_layout")
@section("content")
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Dashboard</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('admin/home')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Dashboard</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
    <div class="page-content">
        <div id="tab-general">
            <div id="sum_box" class="row mbl">
                <div class="col-sm-6 col-md-3">
                    <div class="panel profit db mbm" onclick="window.location.href='{{url('admin/users')}}'" style="cursor: pointer;">
                        <div class="panel-body"><p class="icon"><i class="icon fa fa-group"></i></p><h4 class="value"><span data-counter="" data-start="10" data-end="50" data-step="1" data-duration="0">{{dashboard_usercount()}}</span></h4>

                            <p class="description">Registered Users</p>


                        </div>
                    </div>
                </div>

                {{--<div class="col-sm-6 col-md-3">--}}
                    {{--<div class="panel income db mbm" onclick="window.location.href='{{url('admin/trade_history')}}'" style="cursor: pointer;">--}}
                        {{--<div class="panel-body"><p class="icon"><i class="icon fa fa-exchange"></i></p><h4><span>{{dashboard_totaltrans()}}</span></h4>--}}

                            {{--<p class="description">Total Transactions</p>--}}


                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-6 col-md-3">--}}
                    {{--<div class="panel task db mbm" onclick="window.location.href='{{url('admin/profit')}}'" style="cursor: pointer;">--}}
                        {{--<div class="panel-body"><p class="icon"><i class="icon fa fa-signal"></i></p><h4 class="value"><span>{{number_format(dashbard_totalbtcprofit(),4,'.','')}}</span><span><i class="fa fa-btc"></i></span></h4>--}}

                            {{--<p class="description">Profit</p>--}}


                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="col-sm-6 col-md-3">
                    <div class="panel visit db mbm" onclick="window.location.href='{{url('admin/kyc_users')}}'" style="cursor: pointer;">
                        <div class="panel-body"><p class="icon"><i class="icon fa fa-group"></i></p><h4 class="value"><span>{{dashbard_totalkyc()}}</span></h4>

                            <p class="description">KYC verification</p>


                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <br>
                {{--BTC Admin--}}
                <!-- <div class="col-sm-4 col-md-4">
                    <div class="panel db mbm" style="cursor: pointer;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center"><i class="fa font50"><img src="{{URL::asset('front')}}/assets/icons/BTC.png" class="stat-icon" style="width: 50px;height: 50px;"></i></div>
                                    <div style="text-align: center"><p><h2>{{$btc_bal}}</h2></p>
                                        <p class="description "><strong>Admin BTC Balance</strong></p></div>
                                </div>
                            </div> -->

                            {{--<div class="row">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label><strong>Users:</strong></label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-8">--}}
                                    {{--<label>{{$user_btc}}</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}

<!-- 

                        </div>
                    </div>
                </div> -->

                {{--ETH Admin--}}
                <!-- <div class="col-sm-4 col-md-4">
                    <div class="panel db mbm" style="cursor: pointer;">
                        <div class="panel-body" onclick="window.open('https://etherscan.io/address/{{decrypt(get_config('eth_address'))}}','_newtab');">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center"><i class="fa font50"><img src="{{URL::asset('front')}}/assets/icons/ETH.png" class="stat-icon" style="width: 50px;height: 50px;"></i></div>
                                    <div style="text-align: center"><p><h2>{{$eth_bal}}</h2></p>
                                        <p class="description "><strong>Admin ETH Balance</strong></p></div>
                                </div>
                            </div> -->

                            {{--<div class="row">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label><strong>Users:</strong></label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-8">--}}
                                    {{--<label>{{$user_eth}}</label>--}}
                                {{--</div>--}}

                            {{--</div>--}}


<!-- 
                        </div>
                    </div>
                </div> -->

                {{--USDT Admin--}}
                <!-- <div class="col-sm-4 col-md-4">
                    <div class="panel db mbm" style="cursor: pointer;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center"><i class="fa font50"><img src="{{URL::asset('front')}}/assets/icons/USDT.png" class="stat-icon" style="width: 50px;height: 50px;"></i></div>
                                    <div style="text-align: center"><p><h2>0</h2></p>
                                        <p class="description "><strong>Admin USDT Balance</strong></p></div>
                                </div>
                            </div> -->

                            <!-- {{--<div class="row">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label><strong>Users:</strong></label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-8">--}}
                                    {{--<label>{{$user_usdt}}</label>--}}
                                {{--</div>--}}

                            {{--</div>--}} -->



                        <!-- </div>
                    </div> -->
                </div>


            <div class="table-container">

                <div>
                    <h2>&nbsp;&nbsp;Latest 25 ICO Trades:</h2>
                    <br>
                </div>
                <table class="table table-hover table-striped table-bordered table-advanced tablesorter"
                       id="myTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>FirstCurrency</th>
                        <th>SecondCurrency</th>
                        <th>Amount</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Created time</th>


                    </tr>
                    <tbody>
                    @if($result)
                        @foreach($result as $key=>$val)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$val->user_id}}</td>
                                <td>{{get_user_details($val->user_id,'enjoyer_name')}}</td>
                                <td>{{$val->FirstCurrency}}</td>
                                <td>{{$val->SecondCurrency}}</td>
                                <td>{{$val->Amount}}</td>
                                <td>{{round($val->Price)}}</td>
                                <td>{{round($val->Total)}}</td>
                                <td>{{$val->Status}}</td>
                                <td>{{$val->created_at}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    </thead>

                </table>

            </div>



        </div>



    </div>
@endsection
@section('script')
    @include('panel.layout.dashboard_script')
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable').DataTable({
                "searching": false,
                "paging": false,
                "ordering": false,
                "info": false
            });
        });
    </script>
@endsection