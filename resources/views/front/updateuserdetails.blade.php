<?php
/**
 * Created by PhpStorm.
 * User: rahulraj
 * Date: 12/1/18
 * Time: 2:54 PM
 */

@extends('front.layout.front')
@section('content')

    <!-- Profile, Edit Profile & Change Password -->
    <section class="mt60" style="min-height:740px;">
        <div class="container">
            <div class="row">

                <!-- left navigation -->
            @include('front.sidebar')
            <!-- / left navigation -->

                <!--  right panel - profile, edit profile & change password data -->
                <div class="col-md-9">
                    @include('front.alert')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel-body noPadd">
                                <ul class="nav nav-tabs profile-tabs">
                                    <li><a data-toggle="tab" href="#edit-mobile" aria-expanded="true">Change Mobile Number</a></li>
                                    <li><a data-toggle="tab" href="#edit-email" aria-expanded="false">Change Email Id</a></li>

                                    <!--  <li><a data-toggle="tab" href="#kycdocuments" aria-expanded="false">KYC</a></li> -->
                                </ul>

                                <div class="tab-content m-0">


                                    <!-- Edit Profile -->
                                    <div id="edit-mobile" class="tab-pane">
                                        <div class="user-profile-content">
                                            <form role="form" id="update_mobile">
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-lg" name="old_mobile" id="old_mobile" placeholder="Your Old Mobile Number">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-lg" name="new_mobile" id="new_mobile" placeholder="Your New Mobile Number">
                                                </div>
                                                @if($result->mobile_status!=1)

                                                    <div class="form-group input-group">
                                                        <input id="telephone" type="text" name="telephone" placeholder="Contact Number" class="form-control input-lg" maxlength="10" value="{{owndecrypt($result->mobile_no)}}" oninput="change_mobile(this.value);" />
                                                        <span class="input-group-addon" id="upt_mob">
                                                    @if($result->mobile_status==1)
                                                                <a id="otp_but" class="btn btn-info btn-sm" disabled>Verified</a>
                                                            @else
                                                                <a id="otp_but" class="btn btn-info btn-sm" onclick="sendotp()">Send OTP</a>
                                                            @endif
                 </span>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="telephone" value="{{owndecrypt($result->mobile_no)}}">
                                                @endif

                                                <div id="otp_msg">

                                                </div>



                                                <button class="btn btn-primary" onclick="sendotp()">Verify Number</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- / Edit Profile -->


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / right panel - profile, edit profile & change password data -->
            </div>
        </div>
    </section>
    <!-- / Profile, Edit Profile & Change Password -->


    <!-- Small modal -->
    <div id="modal-otp" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                    <h4 id="modal-login-label" class="modal-title">Mobile Number Verification </h4></div>
                <div id="otp_message"></div>
                <div class="modal-body">
                    <div class="form">
                        <form class="form-horizontal" id="otp_form" method="post" action="#">
                            <div class="form-group"><label  class="control-label col-md-3">Enter Verification code</label>

                                <div class="col-md-9"><input id="verify_code" class="form-control" name="verify_code" type="text"></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('xscript')

    <script type="text/javascript">


        function verifyNumber()
        {
            var mobile=$("#old_mobile").val();
            var isd='{{$result->mob_isd}}';
            $.ajax({
                url:'{{url("ajax/verifynumber")}}',
                method:'post',
                data:{'isdcode':isd,'phone':mobile},
                success:function(output)
                {
                    obj = JSON.parse(output);
                    if(obj.status=='1')
                    {
                        $("#modal-otp").modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                    }
                    else
                    {
                        $("#otp_msg").html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+obj.sms+'</div>')
                    }
                }
            });
        }

        function sendotp()
        {
            var mobile=$("#old_mobile").val()
            var verifymobile = ;
            var isd='{{$result->mob_isd}}';
            $.ajax({
                url:'{{url("ajax/verifyotp")}}',
                method:'post',
                data:{'isdcode':isd,'phone':mobile},
                success:function(output)
                {
                    obj = JSON.parse(output);
                    if(obj.status=='1')
                    {
                        $("#modal-otp").modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                    }
                    else
                    {
                        $("#otp_msg").html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+obj.sms+'</div>')
                    }
                }
            });
        }
    </script>


@endsection

