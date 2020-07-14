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
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title"> Edit Profile </div>
                    <hr>
                </div>

                    <!-- {{--<div class="form-group">--}}
                        {{--<textarea class="form-control input-lg" name="address" placeholder="Address">{{$result->address}}</textarea>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="text" class="form-control input-lg" name="state" placeholder="State" value="{{$result->state}}">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="text" class="form-control input-lg" name="city" placeholder="City" value="{{$result->city}}">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="text" class="form-control input-lg" value="{{get_country_name($result->country)}}" disabled="disabled">--}}
                    {{--</div>--}}

                    {{--<button class="btn btn-primary" type="submit" onclick="savenumber()">Save</button>--}}
                {{--</form>--}} -->
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <form role="form" id="profile_update" action="{{url('profile')}}" method="post">
                            {{csrf_field()}}
                        <div class="row">


                            <div style="clear:both;">&nbsp;</div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="username" placeholder="User Name" value="{{$data['result']->enjoyer_name}}">
                                </div>
                                <input type="hidden" id="ptostatus" name="ptostatus">

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <input type="email" class="form-control input-lg" id="Email" disabled="disabled" value="{{get_usermail($data['result']->id)}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="first_name" placeholder="first Name" value="{{$data['result']->first_name}}">
                                </div>

                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="last_name" placeholder="Last Name" value="{{$data['result']->last_name}}">
                                </div>

                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="country_id" class="form-control input-lg custom-select"  id="country_id" class="form-control input-lg"
                                            onchange="set_country()">
                                        <option value="">Select Country</option>
                                        @foreach($data['country'] as $val)
                                            <option value="{{$val->id}}" @if($val->id==old('country_id')) selected
                                                    @endif data-id="{{strtolower($val->iso)}}">{{$val->nicename}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="telephone" placeholder="Mobile number" value="{{owndecrypt($data['result']->mobile_no)}}">
                                </div>

                            </div>

                            <div style="clear:both;">&nbsp;</div>

                            <div class="col-md-6">
                                <button type="submit" class="submit-btn">Submit</button>
                            </div>


                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- /PAGE CONTENT AAA-->

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- Profile, Edit Profile & Change Password -->


@endsection

@section('xscript')

    <script>
        function linkactivate()
        {
            try
            {
                var sTime = new Date().getTime();
                var countDown = 30;

                function UpdateTime() {
                    var cTime = new Date().getTime();
                    var diff = cTime - sTime;
                    var seconds = countDown - Math.floor(diff / 1000);
                    if (seconds >= 0) {
                        var minutes = Math.floor(seconds / 60);
                        seconds -= minutes * 60;
                        $("#minutes").text(minutes < 10 ? "0" + minutes : minutes);
                        $("#seconds").text(seconds < 10 ? "0" + seconds : seconds);
                    } else {
                        $("#countdown").hide();
                        $("#aftercount").show();
                        $('#aftercount_msg').show();
                        clearInterval(counter);
                    }
                }
                UpdateTime();
                var counter = setInterval(UpdateTime, 500);

            }
            catch(e)
            {
                console.log(e);
            }
        }

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>

    <script type="text/javascript">
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
  </script>

    <script>


        $("#change_pass").validate({
            rules:
                {
                    old_password:{required:true,remote:{url:"{{url('ajax/checkoldpass')}}",type:'post',data:{'_token':"{{ csrf_token() }}"}}},
                    password:{required:true,minlength:6},
                    password_confirmation:{required:true,equalTo:'#new_pass',},
                },
            messages:
                {
                    old_password:{required:'Old Password is required',remote:'Old password is wrong',},
                    password:{required:'Password is required',minlength:'minimum 6 characters is required'},
                    password_confirmation:{required:'Confirm password is required',equalTo:'password does not match',},

                },
        });
    </script>

    <script src="{{URL::asset('front')}}/build/js/countrySelect.js"></script>
    <script>
        function set_country() {
            var code = $('#isdcode ').attr('data-id');
            $("#country_selector").countrySelect("selectCountry", code);
        }
        $("#country_selector").countrySelect({
            preferredCountries: ['jp', 'in', 'gb', 'us']
        });

    </script>

    {{--<script>--}}
        {{--$(document).ready(function(){--}}
            {{--set_country();--}}
            {{--$(window).load(function(){--}}
                {{--if({{$flag}}==1)--}}
                {{--{--}}
                    {{--sendotp();--}}
                {{--}--}}
            {{--})--}}
        {{--});--}}
    {{--</script>--}}

    <script type="text/javascript">
        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Number Not valid."
        );
        $("#profile_update").validate({
            rules:
                {
                    username:{required:true,},
                    first_name:{required:true, minlength:2, regex:"^[A-Za-z]*$"},
                    last_name:{required:true, minlength:2, regex:"^[A-Za-z]*$"},
                    telephone:{required:true,number:true,},
                    address:{required:true,},
                    state:{required:true,},
                    city:{required:true,},
                },
            messages:
                {
                    username:{required:'Username is required',},
                    first_name:{required:'First name is required',minlength:'First name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    last_name:{required:'Last name is required',minlength:'Last name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    telephone:{required:'Mobile number is required',number:'Enter valid mobile number',},
                    address:{required:'Address is required',},
                    state:{required:'State is required',},
                    city:{required:'City is required',},
                },

        });
    </script>

    {{--<script>--}}
        {{--function verify_otp()--}}
        {{--{--}}
            {{--var code=$('#verify_code').val();--}}
            {{--var mobile=$('#telephone').val();--}}
            {{--var user_id={{$result->id}};--}}
            {{--$.ajax({--}}
                {{--url:'{{url("ajax/verify_otp")}}',--}}
                {{--method:'post',--}}
                {{--data:{'verify_code':code, 'mobile':mobile, 'user_id':user_id},--}}
                {{--success : function(data)--}}
                {{--{--}}
                    {{--location.reload();--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
    {{--</script>--}}

    <script>
        $("#telephone").keydown(function (evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 32 && (charCode < 46 || charCode > 57) && (charCode < 90 || charCode > 107) && (charCode < 109 || charCode > 111) && (charCode < 189 || charCode > 191))
                return false;
            return true;
        });

        function change_mobile(str)
        {
            $("#upt_mob").html('<a id="otp_but" class="btn btn-info btn-sm" onclick="sendotp()">Send OTP</a>');
        }

        {{--function sendotp()--}}
        {{--{--}}
            {{--var countryData = $("#country_selector").countrySelect("getSelectedCountryData");--}}
            {{--var isd = countryData.isd;--}}
            {{--$("#isdcode").val(isd);--}}
            {{--var isdcode = $("#isdcode").val();--}}
            {{--var mobile=$("#telephone").val();--}}
            {{--var email=$('#Email').val();--}}
            {{--var user_id = {{$result->id}};--}}
            {{--$.ajax({--}}
              {{--url:'{{url("ajax/checkphone")}}',--}}
              {{--method:'post',--}}
              {{--data:{'mobile_no':mobile,'user_id':user_id},--}}
              {{--success:function(data)--}}
              {{--{--}}
                {{--console.log(data);--}}
                {{--obj = JSON.parse(data);--}}
                {{--if(obj.message=='1')--}}
                {{--{--}}
                  {{--window.location.href = "{{url("/profile")}}";--}}
                {{--}--}}
                {{--else {--}}
                  {{--$.ajax({--}}
                      {{--url:'{{url("ajax/registerotp")}}',--}}
                      {{--method:'post',--}}
                      {{--data:{'isdcode':isdcode,'phone':mobile,'reg_email':email, 'type': 'Update'},--}}
                      {{--success:function(output)--}}
                      {{--{--}}
                          {{--obj = JSON.parse(output);--}}
                          {{--if(obj.status=='1')--}}
                          {{--{--}}
                              {{--$("#modal-otp").modal({--}}
                                  {{--backdrop: 'static',--}}
                                  {{--keyboard: false--}}
                              {{--});--}}
                              {{--linkactivate();--}}
                          {{--}--}}
                          {{--else--}}
                          {{--{--}}
                              {{--$("#otp_msg").html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+obj.sms+'</div>')--}}
                          {{--}--}}
                      {{--}--}}
                  {{--});--}}

                {{--}--}}
              {{--}--}}
            {{--});--}}
        {{--}--}}
    </script>

    <script>
        function savenumber()
        {
            var countryData = $("#country_selector").countrySelect("getSelectedCountryData");
            var isd = countryData.isd;
            $("#isdcode").val(isd);
            var isdcode = $("#isdcode").val();
        }
    </script>

    <script type="text/javascript">
        $("#otp_form").validate(
            {
                rules:
                    {
                        verify_code:{required:true,number:true,},
                    },
                messages:
                    {
                        verify_code:{required:'Verification code is required',number:'Digit only allowed',},
                    },
                submitHandler: function(form)
                {
                    var otpser=$("#otp_form").serialize();
                    var mob=$('#telephone').val();

                    $.ajax({
                        type:'post',
                        url:'{{url("ajax/verify_otp")}}',
                        data:otpser+'&mobile='+mob,
                        success:function(data)
                        {

                            otpobj = JSON.parse(data);
                            if(otpobj.status=='1')
                            {
                                $("#telephone").attr('readonly','readonly');
                                $("#otp_but").html('verified');
                                $("#modal-otp").modal('hide');
                                $("#ptostatus").val(otpobj.key);
                                $("#otp_message").html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+otpobj.message+'</div>');
                            }
                            else
                            {
                                $("#otp_but").html('Failed');
                                $("#ptostatus").val(otpobj.key);
                                $("#otp_message").html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+otpobj.message+'</div>');
                            }
                        }
                    })
                }
            });
    </script>

    <script type="text/javascript">
        $("#kycform").validate(
            {
                rules:
                    {
                        proof1:{required:true,},
                        proof2:{required:true,},
                        proof3:{required:true,},
                    },
                messages:
                    {
                        proof1:{required:'Pan Card is required',},
                        proof2:{required:'Adhaar Card is required',},
                        proof3:{required:'Address proof is required',},
                    }
            });
    </script>


@endsection
