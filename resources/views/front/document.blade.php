
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
        <div class="docs">

            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title"> Documents </div>
                    <hr />
                </div>
            </div>



            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                            <span class="caption-subject font-dark bold uppercase">
                                            White Paper
                                            </span>
                                <span class="caption-helper"> | Download your files here </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green-meadow" href="#" target="_blank">
                                        <div class="visual">
                                            <i class="far fa-handshake"></i>
                                        </div>
                                        <div class="details" style="padding-left:40px;">
                                            <div class="number"> 
                                                <span data-counter="counterup" data-value="1349"></span>
                                            </div>
                                            <div class="desc file-desc">White Paper EN</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green-meadow" href="#" target="_blank">
                                        <div class="visual">
                                            <i class="far fa-file-alt"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number"> 
                                                <span data-counter="counterup" data-value="1349"></span>
                                            </div>
                                            <div class="desc file-desc">White Paper CN</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                            <span class="caption-subject font-dark bold uppercase">
                                            Pitch Deck
                                            </span>
                                <span class="caption-helper"> | Download your files here </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat dashboard-stat-v2 green-meadow" href="#" target="_blank">
                                        <div class="visual">
                                            <i class="far fa-handshake"></i>
                                        </div>
                                        <div class="details" style="padding-left:40px;">
                                            <div class="number"> 
                                                <span data-counter="counterup" data-value="1349"></span>
                                            </div>
                                            <div class="desc file-desc">Pitch Deck EN</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <!-- <a class="dashboard-stat dashboard-stat-v2 green-meadow" href="{{URL::asset('front')}}/assets/pdf/foodcode-pitch-deck-chinese.pdf" target="_blank"> -->
                                    <a class="dashboard-stat dashboard-stat-v2 green-meadow" href="#" target="_blank">
                                        <div class="visual">
                                            <i class="far fa-file-alt"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number"> 
                                                <span data-counter="counterup" data-value="1349"></span>
                                            </div>
                                            <div class="desc file-desc">Pitch Deck CN</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



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

@section('xscript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    {{--<script type="text/javascript">--}}
    {{--$(window).on('load',function(){--}}



    {{--$("#myModal").modal({--}}
    {{--show: true,--}}
    {{--backdrop: 'true'--}}
    {{--});--}}
    {{--});--}}
    {{--$(document).keydown(function(e) {--}}
    {{--if (e.keyCode == 27) {--}}
    {{--$("#myModal").modal('hide');--}}

    {{--}--}}
    {{--});--}}
    {{--</script>--}}
    <script>
        function change_captcha()
        {
            $("#capimg").html('Loading....');
            $.post('{{url("ajax/refresh_capcha")}}',function(data,result)
            {
                $("#capimg").html(data);
            });
        }


    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>

@endsection
