@extends("panel.layout.admin_layout")
@section("content")
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Trade History</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('admin/home')}}">Home</a>&nbsp;&nbsp;<i
                        class="fa fa-angle-right"></i>&nbsp;&nbsp;
            </li>

            <li class="active">Trade History</li>
        </ol>
        <div class="clearfix"></div>
    </div>


    <div class="page-content">
        <div class="row">
            <div class="col-md-12">

                @include('panel.alert')

                <div id="tableactionTabContent" class="tab-content">
                    <div id="table-table-tab" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-lg-12">


                                <div class="row">
                                    <form id="form_filters" method="get">

                                        <div class="col-md-3">
                                            <lable>Start date</lable>
                                            <input type="text" id="min" name="min"
                                                   value="{{ app('request')->input('min') }}" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <lable>End date</lable>
                                            <input type="text" id="max" name="max"
                                                   value="{{ app('request')->input('max') }}" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <lable>Search</lable>
                                            <input type="text" id="search_id" name="search"
                                                   value="{{ app('request')->input('search') }}" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <lable>Status</lable>
                                            <select class="form-control" name="status">
                                                <option value="all">All</option>
                                                <option value="active"
                                                        @if(app('request')->input('status')=='active') selected @endif>
                                                    Pending
                                                </option>
                                                <option value="partially"
                                                        @if(app('request')->input('status')=='partially') selected @endif>
                                                    Partially
                                                </option>
                                                <option value="completed"
                                                        @if(app('request')->input('status')=='completed') selected @endif>
                                                    Completed
                                                </option>
                                                <option value="cancelled"
                                                        @if(app('request')->input('status')=='cancelled') selected @endif>
                                                    Cancelled
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <lable>Pair</lable>
                                            <select class="form-control" name="pair">
                                                <option value="all">All</option>
                                                <option value="XDC-ETH"
                                                        @if(app('request')->input('pair')=='XDC-ETH') selected @endif>
                                                    XDC-ETH
                                                </option>
                                                <option value="XDC-BTC"
                                                        @if(app('request')->input('pair')=='XDC-BTC') selected @endif>
                                                    XDC-BTC
                                                </option>
                                                <option value="XDC-BCH"
                                                        @if(app('request')->input('pair')=='XDC-BCH') selected @endif>
                                                    XDC-BCH
                                                </option>
                                                <option value="XDC-XRP"
                                                        @if(app('request')->input('pair')=='XDC-XRP') selected @endif>
                                                    XDC-XRP
                                                </option>
                                                <option value="XDC-XDCE"
                                                        @if(app('request')->input('pair')=='XDC-XDCE') selected @endif>
                                                    XDC-XDCE
                                                </option>

                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <a style="margin-top: 17px;" class="btn btn-default" href="{{url('/admin/trade_history/')}}"><i
                                                        class="fa fa-refresh" ></i></a>&nbsp;
                                            <button style="margin-top: 17px;" class="btn btn-default"><i
                                                        class="fa fa-search"></i></button>
                                        </div>
                                        {{csrf_field()}}
                                    </form>
                                </div>


                                <div class="table-container">

                                    <table class="table table-hover table-striped table-bordered table-advanced tablesorter"
                                           id="myTable">
                                        <thead>
                                        <tr>

                                            <th>User ID</th>
                                            <th>Username</th>
                                            <th>Amount</th>
                                            <th>Price</th>
                                            <th>Fee</th>
                                            <th>Total</th>
                                            <th>Type</th>
                                            <th>First Currency</th>
                                            <th>Second Currency</th>
                                            <th>Status</th>
                                            <th>Updated time</th>


                                        </tr>
                                        <tbody>
                                        @if($result)
                                            @foreach($result as $key=>$val)
                                                @if($val->duplicate == 1)
                                                <tr bgcolor="red">

                                                    <td>{{$val->user_id}}</td>
                                                    <td>{{get_user_details($val->user_id,'enjoyer_name')}}</td>
                                                    <td>{{$val->Amount}}</td>
                                                    <td>{{$val->Price}}</td>
                                                    <td>{{$val->Fee}}</td>
                                                    <td>{{$val->Total}}</td>
                                                    <td>{{$val->Type}}</td>
                                                    <td>{{$val->firstCurrency}}</td>
                                                    <td>{{$val->secondCurrency}}</td>
                                                    <td>{{$val->status}}</td>
                                                    <td>{{$val->updated_at}}</td>
                                                </tr>
                                                @else
                                                    <tr >

                                                        <td>{{$val->user_id}}</td>
                                                        <td>{{get_user_details($val->user_id,'enjoyer_name')}}</td>
                                                        <td>{{$val->Amount}}</td>
                                                        <td>{{$val->Price}}</td>
                                                        <td>{{$val->Fee}}</td>
                                                        <td>{{$val->Total}}</td>
                                                        <td>{{$val->Type}}</td>
                                                        <td>{{$val->firstCurrency}}</td>
                                                        <td>{{$val->secondCurrency}}</td>
                                                        <td>{{$val->status}}</td>
                                                        <td>{{$val->updated_at}}</td>
                                                    </tr>
                                                    @endif
                                            @endforeach
                                        @endif
                                        </tbody>
                                        </thead>

                                    </table>

                                </div>

                                <div class="row">
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <div class="pagination-panel">
                                            @include('panel.pagination', ['paginator' => $result])

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



@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable').DataTable({
                "searching": false,
                "paging": false,
                "ordering": true,
                "info": false
            });
        });
    </script>


    <link rel="stylesheet" href="{{URL::asset('datepicker/jquery-ui.css')}}">
    <script src="{{URL::asset('datepicker/jquery-ui.js')}}"></script>
    <script>
        $(function () {

            $("#max,#min").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                onSelect: function (selectedDate) {
                    if (this.id == 'min') {
                        var dateMin = $('#min').datepicker("getDate");
                        var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(), dateMin.getDate() + 1);
                        $('#max').datepicker("option", "minDate", rMin);
                    }

                }


            });


        });
    </script>

@endsection