@extends("panel.layout.admin_layout")
@section("content")
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Market Price</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('admin/home')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li class="active">Market Price</li>
                </ol>
                <div class="clearfix"></div>
            </div>


            <div class="page-content">
  <div class="row">
                    <div class="col-md-12">

                     @include('panel.alert')

                        <div class="row mtl">

                            <div class="col-md-12">

                                <div id="generalTabContent" class="tab-content">

                                    <div id="tab-edit" class="tab-pane fade in active">
                                        <form action="{{url('admin/market_price')}}" method="post" class="form-horizontal">
                                        <h3>Market Price -XDC</h3>
                                        {{ csrf_field() }}

                                         <div class="form-group"><label class="col-sm-3 control-label">1 XDC <i class="fa fa-random"></i></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                <div class="col-xs-6 input-group">

                                                <input type="text" value="{{$result->BTC}}" name="xdc_btc" class="form-control" id="xdc_btc"  />
                                                <span class="input-group-addon">BTC</span>
                                                </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">1 XDC <i class="fa fa-random"></i></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6 input-group">

                                                            <input type="text" value="{{$result->BCH}}" name="xdc_bch" class="form-control" id="xdc_bch"  />
                                                            <span class="input-group-addon">BCH</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                             <div class="form-group"><label class="col-sm-3 control-label">1 XDC <i class="fa fa-random"></i></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                <div class="col-xs-6 input-group"><input type="text" value="{{$result->ETH}}" name="xdc_eth" class="form-control" id="xdc_eth"  />
                                                    <span class="input-group-addon">ETH</span>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">1 XDC <i class="fa fa-random"></i></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                <div class="col-xs-6 input-group"><input type="text" value="{{$result->XRP}}" name="xdc_xrp" class="form-control" id="xdc_xrp"  />
                                                     <span class="input-group-addon">XRP</span>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">1 XDC <i class="fa fa-random"></i></label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                <div class="col-xs-6 input-group"><input type="text" value="{{$result->USD}}" name="xdc_usd" class="form-control" id="xdc_usd"  />
                                                     <span class="input-group-addon">USD</span>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>








                                            <hr/>
                                            <button type="submit" class="btn btn-green btn-block">Update</button>
                                        </form>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



@endsection

@section('script')
<script>
$("#xdc_btc").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#xdc_eth").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#xdc_xrp").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#xdc_usd").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});
</script>
@endsection