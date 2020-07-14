<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/register.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="login-container container-fluid">
        <div class="container lg-wpr">
            <div class="row align-items-center">

                <div class="col-md-6 offset-md-3">
                    <div class="login-wpr pull-right clearfix">
                        <div class="login-top">
                            <h2 class="reg-heading">Create Account</h2>
                            <p class="reg-sub-heading"></p>
                        </div>

                        <div  class="login-form">
                            <form id="register_form" action="<?php echo e(url('/register')); ?>" method="post" name="reg_form">
                                <?php echo e(csrf_field()); ?>

                                <div class="row">

                                    <div class="col-md-6 col-sm-6 col-xs-12 cls_resp50">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-lg" name="first_name" placeholder="First name" value="" id="first_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 cls_resp50">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-lg" name="last_name" placeholder="Last name" value="" id="last_name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 cls_resp50">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-lg" name="email_id" placeholder="Email address" id="email_id" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 cls_resp50">

                                        <div class="form-group">
                                            <select name="country_id" id="country_id" class="form-control input-lg"
                                                    onchange="set_country()">
                                                <option value="">Select Country</option>
                                                <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($val->id); ?>" <?php if($val->id==old('country_id')): ?> selected
                                                            <?php endif; ?> data-id="<?php echo e(strtolower($val->iso)); ?>"><?php echo e($val->nicename); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <input type="hidden" name="isdcode" id="isdcode" value="0">

                                        </div>


                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 cls_resp50">

                                        <div class="form-group">
                                            <input type="password" class="form-control input-lg" name="password" placeholder="Password" id="password">
                                        </div>

                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 cls_resp50">
                                        <div class="form-group">
                                            <input type="password" class="form-control input-lg" name="password_confirmation" placeholder="Confirm password">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="col-xs-2">
                                            <div class="form-group">
                                                <label>Contact No.</label>
                                                <select name="isdcode" id="isdcode" class="form-control">
                                                    <option value="">ISD</option>
                                                    <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($val->phonecode); ?>"<?php if($val->id==old('country_id')): ?> selected
                                                                <?php endif; ?> data-id="<?php echo e(strtolower($val->iso)); ?>">+<?php echo e($val->phonecode); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="form-group">
                                                <label> &nbsp;</label>
                                                <input type="text" class="form-control" id="phone_no" placeholder="Mobile no without ISD code." name="phone_no" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.key === "Backspace"'>
                                                <p id="phone_error" class="error" hidden>The number already exists.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 otp">
                                        <div class="form-group">
                                            <label for="otp">OTP</label>
                                            <input type="text" class="form-control" id="otp" placeholder="Enter OTP" name="otp">
                                            <span class="send-otp"><a href="#" onclick="sendotp()" >Send OTP</a></span>
                                            <p id="otp_error" class="red" hidden>Enter a valid OTP.</p>
                                            <p id="otp_success" class="green" hidden>OTP verified successfully.</p>
                                            <div id="countdown" style="display: none">
                                                <span style="float:left"> OTP sent to your mobile number. Resend Link:&nbsp;</span>
                                                <div id="minutes" style="float:left;color: red">00</div>
                                                <div style="float:left">:</div>
                                                <div id="seconds" style="float:left;color: red">00</div>
                                            </div>
                                            
                                            <div id="aftercount" style="display:none">OTP via call:&nbsp;<a href="#" onclick="otp_call()" style="color: lightblue">Click Here</a></div>
                                            <div id="aftercount_msg" style="display:none">*If you do not recieve OTP within 15 minutes please contact support</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-xs-12">
                                    <span>By registering, you agree to <a href="<?php echo e(url('/terms')); ?>">Term of Services</a> and  <a href="<?php echo e(url('/privacy')); ?>">Privacy Policy.</a></span>
                                    <hr>
                                </div>
                                <div class="col-sm-12 col-xs-12 ">
                                    <!-- <input type="submit" id="ec_register" class="btn btn-primary pull-left reg_btn" name="ec_register" value="Register" /> -->
                                    <div id="reg_but">
                                        <button type="submit" onclick="sendotp(1)" class="submit-btn pull-left" name="ec_register" id="ec_register"><i class="fa fa-check"></i> &nbsp; Register
                                        </button>
                                    </div>

                                    <span class="pull-left log_tx" style="margin-left:20px;"> Already have an Account? <a href="<?php echo e(url('/login')); ?>">Login</a><br>
              Forgot your Password? <a href="<?php echo e(url('/forgotpass')); ?>">Reset</a>
               </span>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('xscript'); ?>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function sendotp(choice) {
            var countryData = $("#country_selector").countrySelect("getSelectedCountryData");
            var isd = countryData.isd;
            $("#isdcode").val(isd);
            var isdcode = $("#isdcode").val();


        }
    </script>

    <script type="text/javascript">
        function otp_sent()
        {
            var isdcode = $("#isdcode").val();
            var mobile=$("#phone_no").val();
            var email=$('#email_id').val();
            $.ajax({
                url:'<?php echo e(url("ajax/checkphone")); ?>',
                method:'post',
                data:{'mobile_no':mobile},
                success:function(data)
                {
                    obj = JSON.parse(data);
                    if(obj.message=='1')
                    {
                        $('#countdown').hide();
                        $('#aftercount').hide();
                        $('#aftercount_msg').hide();
                        $('#phone_error').show().delay(5000).fadeOut();
                    }
                    else {
                        $.ajax({
                            url:'<?php echo e(url("ajax/registerotp")); ?>',
                            method:'post',
                            data:{'isdcode':isdcode,'phone':mobile,'reg_email':email, 'type': 'Register'},
                            success:function(output)
                            {
                                obj = JSON.parse(output);
                                if(obj.status=='1')
                                {
                                    $('#countdown').show();
                                    linkactivate();
                                    // $('#otp_msg1').delay(30000).fadeIn();
                                }
                                else
                                {
                                    $("#otp_msg").html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+obj.sms+'</div>')
                                }
                            }
                        });
                    }
                }
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>

    <script type="text/javascript">

        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Number Not valid."
        );

        $("#register_form").validate({
            rules:
                {
                    first_name: {required:true, minlength:2, regex:"^[A-Za-z]*$"},
                    last_name: {required:true, minlength:2, regex:"^[A-Za-z]*$"},
                    phone_no: { number: true,regex:"^[1-9][0-9]*$"},
                    jcash_id:{required:true,regex:"^[0-9a-zA-Z]+$"},
                    email_id: {required: true, email: true},
                    password: {
                        required: true,
                        noSpace: true,
                        pwcheckallowedchars: true,
                        pwcheckspechars: true,
                        pwcheckuppercase: true,
                    },
                    password_confirmation: {required: true, equalTo: '#password',},

                },
            messages:
                {
                    first_name:{required:'First name is required',minlength:'First name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    last_name:{required:'Last name is required',minlength:'Last name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                    jcash_id: { required:'JCash Id is required',regex:'Enter valid JCashId'},
                    phone_no: { number: 'Digit only allowed',regex:'Number not valid should not start with zero'},
                    email_id: {required: 'Email id is required', email: 'Enter valid email id'},
                    password: {required: 'Password is required',},
                    password_confirmation: {
                        required: 'Password Confirmation is required',
                        equalTo: 'Password does not match',
                    },

                }
        });
        jQuery.validator.addMethod("noSpace", function (value, element) {
            return value.indexOf(" ") < 0 && value != "";
        }, "No space please and don't leave it empty");

        jQuery.validator.addMethod("pwcheckallowedchars", function (value) {
            return /^[a-zA-Z0-9!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]+$/.test(value) // has only allowed chars letter
        }, "The password contains non-admitted characters");

        jQuery.validator.addMethod("pwcheckspechars", function (value) {
            return /[!@#$%^&*()_=\[\]{};':"\\|,.<>\/?+-]/.test(value)
        }, "The password must contain at least one special character");

        jQuery.validator.addMethod("pwcheckuppercase", function (value) {
            return /[A-Z]/.test(value) // has an uppercase letter
        }, "The password must contain at least one uppercase letter");


    </script>

    <script type="text/javascript">


        function set_country() {
            var code = $('#country_id option:selected').attr('data-id');
            $("#country_selector").countrySelect("selectCountry", code);
        }
    </script>




    <script type="text/javascript">
        var user_id = '<?php echo e($user_id); ?>';
        $("#otp_form").validate(
            {
                rules:
                    {
                        verify_code: {required: true, number: true,},
                    },
                messages:
                    {
                        verify_code: {required: 'Verification code is required', number: 'Digit only allowed',},
                    },
                submitHandler: function (form) {
                    var otpser = $("#otp_form").serialize();
                    var mob = $('#phone_no').val();

                    $.ajax({
                        type: 'post',
                        url: '<?php echo e(url("ajax/verify_otp")); ?>',
                        data: otpser + '&mobile=' + mob + '&user_id='+user_id,
                        success: function (data) {

                            otpobj = JSON.parse(data);
                            if (otpobj.status == '1') {
                                $("#susotp").html('<a href="#" class="btn btn-info btn-sm">Verified</a>');
                                $("#phone_no").attr('readonly', 'readonly');
                                $("#ptostatus").val(otpobj.key);
                                $("#otp_message").html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + otpobj.message + '</div>');
                                $("#modal-otp").modal('hide');

                            }
                            else {
                                $("#otp_but").html('Failed');
                                $("#ptostatus").val('');
                                $("#otp_message").html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + otpobj.message + '</div>');
                            }
                        }
                    })
                }
            });
    </script>

    <script src="<?php echo e(URL::asset('front')); ?>/build/js/countrySelect.js"></script>
    <script>
        $("#country_selector").countrySelect({
            preferredCountries: ['jp','in', 'gb', 'us']
        });

    </script>
    <style>
        .alert-static {
            padding: 20px;
            background-color: lightskyblue;
            color: white;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.jcash_front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>