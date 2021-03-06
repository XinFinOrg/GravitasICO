
@extends("panel.layout.admin_layout")
@section("content")
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Users</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('admin/home')}}">Home</a>&nbsp;&nbsp;<i
                        class="fa fa-angle-right"></i>&nbsp;&nbsp;
            </li>

            <li class="active">Users</li>
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

                                <form class="form-horizontal">
                                    <h3>User Details: </h3>
                                    <div class="panel-body pan">
                                        <div class="form-body pal">


                                            <div class="row">


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputFirstName"
                                                                                   class="col-md-2 control-label"><strong>Email:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static">{{ get_usermail($id) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputFirstName"
                                                                                   class="col-md-2 control-label"><strong>User
                                                                Name:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                {{$result->enjoyer_name}}
                                                            </p></div>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputFirstName"
                                                                                   class="col-md-2 control-label"><strong>First
                                                                Name:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static">{{$result->first_name}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Last
                                                                Name:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static">{{$result->last_name}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Created
                                                                date:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static">{{$result->created_at}}</p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Status:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                @if($result->status==1)
                                                                    Active
                                                                @else
                                                                    Deactive
                                                                @endif
                                                            </p></div>
                                                    </div>
                                                </div>


                                                <!-- <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Image:</strong></label>

                                                        <div class="col-md-10">
                                                            <img src="{{URL::asset('uploads/users/profileimg')}}/{{$result->profile_image}}"
                                                                 style="width: 150px;height: 150px;"/>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>IP
                                                                Address:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static">{{$result->ip}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--<div class="col-md-12">--}}
                                                    {{--<div class="form-group"><label for="inputLastName"--}}
                                                                                   {{--class="col-md-2 control-label"><strong>Country:</strong></label>--}}

                                                        {{--<div class="col-md-10"><p--}}
                                                                    {{--class="form-control-static">{{get_country_name($result->country)}}</p>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                               

                                                <h3>KYC Status: </h3>
                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>KYC
                                                                status:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                            @if($result->document_status==0 || $result->document_status==3)
                                                                <p class="label label-warning">Pending</p>
                                                            @elseif($result->document_status==1)
                                                                <p class="label label-success">Verified</p>
                                                            @else
                                                                <p class="label label-danger">Rejected</p>
                                                                @endif
                                                                </p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <h3>User Balance: </h3>



                                               <!-- ETH -->
                                                    <div class="col-md-6">
                                                        <div class="form-group"><label for="inputLastName"
                                                                                       class="col-md-2 control-label"><strong>ETH:</strong></label>

                                                            <div class="col-md-10"><p class="form-control-static">
                                                                    {{get_userbalance($id,'ETH')}}
                                                                </p></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Verified ETH:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                {{$ETH_Bal}}
                                                            </p></div>
                                                    </div>
                                                    </div>

                                                
                                                <!-- GIFT -->
                                                <div class="col-md-6">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>GIFT:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                {{get_userbalance($id,'GIFT')}}
                                                            </p></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Verified GIFT:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                {{$GIFT_Bal}}
                                                            </p>
                                                            </div>
                                                    </div>
                                                </div>
                                                </div>


                                                <h3>User Addresses: </h3>                                            

                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>ETH:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                {{$result->ETH_addr}}<br>
                                                            </p></div>
                                                    </div>
                                                </div>

                                                
                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>GIFT:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                {{$result->GIFT_addr}}
                                                            </p></div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection

