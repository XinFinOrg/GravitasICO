@extends("panel.layout.admin_layout")
@section("content")
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Profit</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('admin/home')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li class="active">Profit</li>
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
           <input type="text" id="min" name="min" value="{{ app('request')->input('min') }}" class="form-control" required="required">
        </div>
        <div class="col-md-3">
            <lable>End date</lable>
           <input type="text" id="max" name="max" value="{{ app('request')->input('max') }}" class="form-control" required="required">
        </div>
        <div class="col-md-3">
            <button style="margin-top: 17px;" class="btn btn-default"><i class="fa fa-search"></i></button>
        </div>
         {{csrf_field()}}
        </form>
                                    </div>

                                        <div class="table-container">

                                            <table class="table table-hover table-striped table-bordered table-advanced tablesorter" id="myTable">
                                                <thead>
                                               <tr>
                                            <th>#</th>
                                            <th>User ID</th>
                                            <th>Username</th>
                                            <th>Profit</th>

                                            <th>Pair / Currency</th>



                                            <th>Type</th>
                                            <th>Date time</th>




                                        </tr>
                                                <tbody>
                                               @if($result)
                                               @foreach($result as $key=>$val)
                                               <tr>
                                               <td>{{$key+1}}</td>
                                               <td>{{$val->userId}}</td>
                                               <td>{{get_user_details($val->userId,'enjoyer_name')}}</td>
                                               <td>{{$val->theftAmount}} {{$val->theftCurrency}}</td>

                                               <td>XDC-{{$val->theftCurrency}}</td>

                                               <td>{{$val->type}}</td>
                                               <td>{{$val->updated_at}}</td>
                                               </tr>
                                               @endforeach
                                               @endif

                                                </tbody>
                                                </thead></table>

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
<!-- <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function(){
    $('#myTable').DataTable({
         "paging":   false,
        "ordering": false,
        "info":     false,
        /* dom: 'Bfrtip',
        buttons: [
        {
            extend: 'excel',
            text:'Export to Excel',
            filename:'Profit-<?php echo date('d-m-Y'); ?>',
             exportOptions: {
                    columns: [0,1,2,3,4,5],
                }
        }
        ]*/

    });

});
</script>
<link rel="stylesheet" href="{{URL::asset('datepicker/jquery-ui.css')}}">
  <script src="{{URL::asset('datepicker/jquery-ui.js')}}"></script>
  <script>
  $(function() {

     $( "#max,#min" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd',
      onSelect: function( selectedDate ) {
            if(this.id == 'min'){
              var dateMin = $('#min').datepicker("getDate");
              var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 1);
              $('#max').datepicker("option","minDate",rMin);
            }

        }


    });



  } );
  </script>
@endsection