@extends("panel.layout.admin_layout")
@section("content")
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Trading Fee</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('admin/home')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li class="active">Fee</li>
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
                                        <form action="{{url('admin/trading_fee/'.$currency)}}" method="post" class="form-horizontal">
                                        <h3>Trading Fee ({{$currency}})</h3>
                                        {{ csrf_field() }}



                                          <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 20,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_20000" id="lessthan_20000" value="{{$result->lessthan_20000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                 <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 1,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_100000" id="lessthan_100000" value="{{$result->lessthan_100000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 2,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_200000" id="lessthan_200000" value="{{$result->lessthan_200000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 4,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_400000" id="lessthan_400000" value="{{$result->lessthan_400000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                 <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 6,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_600000" id="lessthan_600000" value="{{$result->lessthan_600000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 10,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_1000000" id="lessthan_1000000" value="{{$result->lessthan_1000000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                 <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 20,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_2000000" id="lessthan_2000000" value="{{$result->lessthan_2000000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                 <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 40,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_4000000" id="lessthan_4000000" value="{{$result->lessthan_4000000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                 <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(< 2,00,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="lessthan_20000000" id="lessthan_20000000" value="{{$result->lessthan_20000000}}"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                 <div class="form-group"><label class="col-sm-3 control-label">{{$currency}} Volume(> 2,00,00,000)</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-8">
                                <input type="text"  class="form-control"  name="greaterthan_20000000" id="greaterthan_20000000" value="{{$result->greaterthan_20000000}}"  />
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
$("#lessthan_20000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#lessthan_100000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#lessthan_200000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});


$("#lessthan_400000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#lessthan_600000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});


$("#lessthan_1000000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});


$("#lessthan_2000000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#lessthan_4000000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#lessthan_20000000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});

$("#greaterthan_20000000").keydown(function (evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
if (charCode > 31 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 106) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
return false;
return true;
});


</script>
@endsection