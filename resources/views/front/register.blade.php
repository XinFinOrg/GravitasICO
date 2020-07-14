<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gravitas</title>
    <meta content="ICOToken page" name="description" />
    <meta content="Gravitas" name="author" />
    <link rel="shortcut icon" href="{{URL::asset('front')}}/assets/img/favicon.ico" type="image/x-icon" />

    <!--<base href="/" />-->
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">-->


    <link href="{{URL::asset('front')}}/assets/bower_components/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="{{URL::asset('front')}}/assets/bower_components/simple-line-icons/css/simple-line-icons.min.css" rel="stylesheet">
    <link href="{{URL::asset('front')}}/assets/bower_components/metronic/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{URL::asset('front')}}/assets/bower_components/metronic/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" />
    <link href="{{URL::asset('front')}}/assets/bower_components/metronic/global/css/components.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{URL::asset('front')}}/assets/bower_components/metronic/global/css/plugins.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/toastr-2.1.3.css">

    <!--<link href="{{URL::asset('front')}}/assets/bower_components/owl.carousel/{{URL::asset('front')}}/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{URL::asset('front')}}/assets/bower_components/owl.carousel/{{URL::asset('front')}}/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="{{URL::asset('front')}}/assets/bower_components/angular-toastr/dist/angular-toastr.css" rel="stylesheet" />-->
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{URL::asset('front')}}/assets/bower_components/metronic/pages/css/login-2.css" rel="stylesheet" type="text/css" />
    <!--<link href="{{URL::asset('front')}}/assets/bower_components/metronic/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('front')}}/assets/bower_components/metronic/layouts/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{URL::asset('front')}}/assets/bower_components/metronic/layouts/layout2/css/custom.css" rel="stylesheet" type="text/css" />-->
    <!-- END THEME LAYOUT STYLES -->
    <!--<link rel="shortcut icon" href="favicon.ico" />-->
    <link href="{{URL::asset('front')}}/assets/css/site.css" rel="stylesheet" />
    <link href="{{URL::asset('front')}}/assets/css/ccy.css" rel="stylesheet" />
    <link href="{{URL::asset('front')}}/assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{URL::asset('front')}}/assets/css/toastr-2.1.3.css">
    <style type="text/css">
        .error {
            color: #a94442;


        }
    </style>

</head>
<!-- END HEAD -->

<body>

<!-- BEGIN LOGO -->
<div class="logo">
    <a href="http://Gravitas.io/">
        <img src="{{URL::asset('front')}}/assets/img/logo-big-light.png" alt="" />

    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" style="display:unset" id="register_form" action="{{url('/register')}}" method="post" name="reg_form">
        {{csrf_field()}}
        <fieldset>
            <h3 class="font-green">Sign Up</h3>
            <p class="hint"> Enter your personal details below: </p><br>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <input class="form-control" name="email_id" id="email_id" type="email" required placeholder="Email" />
                <!--<span class="help-block" ng-show="submitted && form.email.$error.required">Required</span>
                <span class="help-block" ng-show="submitted && emailIsTaken">Email is already registered. </span>-->
            </div>

            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">First Name</label>
                <input class="form-control" required name="first_name" id="first_name" type="text" placeholder="First Name" />
                <!--<span class="help-block" ng-show="submitted && form.firstname.$error.required">Required</span>-->
            </div>

            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Last Name</label>
                <input class="form-control" required name="last_name" id="last_name" type="text" placeholder="Last Name"/>
                <!--<span class="help-block" ng-show="submitted && form.lastname.$error.required">Required</span>-->
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control" required name="password" type="password" autocomplete="off" id="password" placeholder="Password" />
                <!--<span class="help-block" ng-show="submitted && form.password.$error.required">Required</span>-->
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                <input class="form-control" required name="password_confirmation" type="password" autocomplete="off" placeholder="Re-type Your Password"/>
                <!--<span class="help-block" ng-show="submitted && form.repassword.$error.required">Required</span>-->
            </div>

            <!--<div class="form-group margin-top-20 margin-bottom-20" ng-class="{true: 'has-error'}[submitted && tnc!=true]">
            </div>-->
            {{--<div class="login-options">--}}

                {{--<div class="form-group">--}}
                    {{--<label class="mt-checkbox mt-checkbox-outline">--}}
                        {{--<input type="checkbox" name="uploadkyc" ng-model="uploadKycNow" /> Upload my KYC--}}
                        {{--<span></span>--}}
                    {{--</label>--}}
                    {{--<div>--}}
                        {{--<div class="input-group">--}}
                            {{--<input class="form-control" disabled ng-model="kycidFile.name" name="uploadid" type="text" autocomplete="off" placeholder="Upload ID" />--}}
                            {{--<span class="input-group-btn">--}}
                                    {{--<button type="button" class="btn blue btn-browse"--}}
                                            {{--ngf-select ng-model="kycidFile" name="kycidFile"--}}
                                            {{--accept="image/*" ngf-max-size="2MB" ng-required="uploadKycNow"--}}
                                            {{--ngf-model-invalid="errorKycidFile">--}}
                                        {{--Browse--}}
                                    {{--</button>--}}
                                {{--</span>--}}
                        {{--</div>--}}
                    {{--<!--<span class="help-block" ng-show="submitted && form.kycidFile.$error.required">Required</span>--}}
                            {{--<span class="help-block" ng-show="submitted && form.kycidFile.$error.maxSize">--}}
                                {{--File too large--}}
                            {{--</span>-->--}}
                    {{--</div>--}}
                    {{--<!--<img ng-show="form.kycidFile.$valid" ngf-thumbnail="picFile" class="thumb">-->--}}
                {{--</div>--}}
                {{--<div class="form-group" ng-show="uploadKycNow">--}}
                    {{--<div ng-class="{true: 'has-error'}[submitted && form.kycporFile.$invalid]">--}}
                        {{--<div class="input-group">--}}
                            {{--<input class="form-control" disabled ng-model="kycporFile.name" name="uploadpor" type="text" autocomplete="off" placeholder="Upload Proof of Residence" />--}}
                            {{--<span class="input-group-btn">--}}
                                    {{--<button type="button" class="btn blue btn-browse"--}}
                                            {{--ngf-select ng-model="kycporFile" name="kycporFile"--}}
                                            {{--accept="image/*" ngf-max-size="2MB" ng-required="uploadKycNow"--}}
                                            {{--ngf-model-invalid="errorKycPorFile">--}}
                                        {{--Browse--}}
                                    {{--</button>--}}
                                {{--</span>--}}
                        {{--</div>--}}
                    {{--<!--<span class="help-block" ng-show="submitted && form.kycporFile.$error.required">Required</span>--}}
                            {{--<span class="help-block" ng-show="submitted && form.kycporFile.$error.maxSize">--}}
                                {{--File too large--}}
                            {{--</span>-->--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group margin-top-20 margin-bottom-20">--}}
                    {{--<label class="mt-checkbox mt-checkbox-outline">--}}
                        {{--<input type="checkbox" name="tnc" ng-model="tnc" required /> I agree to the--}}
                        {{--<a href="javascript:;">Terms of Service </a> &--}}
                        {{--<a href="javascript:;">Privacy Policy </a>--}}
                        {{--<span></span>--}}
                    {{--</label>--}}
                    {{--<!--<span class="help-block" ng-show="submitted && form.repassword.$error.required">Required</span>-->--}}
                    {{--<!--<div id="register_tnc_error" class="help-block" ng-show="submitted && tnc != true"> Required</div>-->--}}
                {{--</div>--}}
                {{--<div class="form-row">--}}
                    {{--<div class="g-recaptcha">--}}
                        {{--<div class="recaptcha "--}}
                             {{--vc-recaptcha key="'6LdsrFoUAAAAAPYh5dR9R9IAqdGnkY9rkCGQshu3'"--}}
                             {{--on-create="setWidgetId(widgetId)"--}}
                             {{--on-success="setResponse(response)"--}}
                             {{--on-expire="cbExpiration()"--}}
                             {{--theme="dark"--}}
                             {{--size="normal">--}}
                        {{--</div>--}}
                        {{--<!--<span class="help-block" ng-show="submitted && recaptchaFailed">Required</span>-->--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="create-account">
                <button type="submit" id="register-submit-btn" class="btn green pull-right">Sign Up</button>
                <a class="" href="{{url('/login')}}"> < Go to Login</a> <!--ui-sref="auth.login"-->
            </div>
        </fieldset>
    </form>


    <!-- END REGISTRATION FORM -->
</div>
<div class="copyright">
    &copy; 2020 Gravitas. All Rights Reserved.
</div>
</div>








<!--<div id="root-view" ui-view="root"></div>-->
<!--[if lt IE 9]>
<script src="{{URL::asset('front')}}/assets/global/plugins/respond.min.js"></script>
<script src="{{URL::asset('front')}}/assets/global/plugins/excanvas.min.js"></script>
<script src="{{URL::asset('front')}}/assets/global/plugins/ie8.fix.min.js"></script>

<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{URL::asset('front')}}/assets/bower_components/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
<script src="{{URL::asset('front')}}/assets/js/toastr-2.1.3.js"></script>
<!--<script src="{{URL::asset('front')}}/assets/bower_components/metronic/global/plugins/jquery.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>-->
<!--<script src="{{URL::asset('front')}}/assets/bower_components/angular/angular.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/angular-animate/angular-animate.min.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/angular-resource/angular-resource.js"></script>-->
<!-- END CORE PLUGINS -->
<!-- Vendor -->
<!-- for no html5 browsers support -->
<!--<script src="{{URL::asset('front')}}/assets/bower_components/ng-file-upload/ng-file-upload-shim.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/ng-file-upload/ng-file-upload.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/moment-with-locales.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/ngstorage/ngStorage.min.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/angular-fcsa-number/src/fcsaNumber.min.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/angular-toastr/dist/angular-toastr.tpls.min.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>-->
<script src="{{URL::asset('front')}}/assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!--aaa<script src="{{URL::asset('front')}}/assets/bower_components/metronic/global/plugins/bootstrap/js/bootstrap.js"></script>-->
<!--<script src="{{URL::asset('front')}}/assets/bower_components/common/common.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/jquery.validation/jquery.validation.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/jquery.gmap/jquery.gmap.min.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/oclazyload/dist/ocLazyLoad.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>-->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{URL::asset('front')}}/assets/bower_components/metronic/global/scripts/app.js"></script>
<!--<script src="{{URL::asset('front')}}/assets/bower_components/metronic/layouts/layout2/scripts/layout.js"></script>-->
<script src="{{URL::asset('front')}}/assets/bower_components/metronic/layouts/layout/scripts/layout.js"></script>
<!--aaa<script src="{{URL::asset('front')}}/assets/bower_components/metronic/layouts/layout2/scripts/demo.js"></script>-->
<script src="{{URL::asset('front')}}/assets/bower_components/metronic/layouts/global/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/metronic/layouts/global/scripts/quick-nav.js" type="text/javascript"></script>
<!--
    <script src="{{URL::asset('front')}}/assets/bower_components/metronic/pages/scripts/dashboard.js"></script>
    -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- App JS - Start -->
<!--<script src="app/app.js"></script>
<script src="app/app.config.js"></script>
<script src="app/app.router.js"></script>
<script src="app/app.main.js"></script>

<script src="app/common/auth/authorization.js"></script>
<script src="app/common/auth/principalService.js"></script>-->
<!-- App JS - End -->
<!-- angular framework -->
<!--<script src="{{URL::asset('front')}}/assets/bower_components/angular-recaptcha/release/angular-recaptcha.js"></script>
<script src="{{URL::asset('front')}}/assets/bower_components/moment-fromNow.js"></script>
<script src="app/common/interceptor/authInterceptorService.js"></script>
<script src="app/common/interceptor/httpInterceptorService.js"></script>
<script src="app/common/interceptor/dateDeserialiserInterceptorService.js"></script>
<script src="app/common/auth/authService.js"></script>

<script src="app/common/account/accountService.js"></script>
<script src="app/common/account/accountController.js"></script>-->
<!--aaa<script src="app/common/account/memberService.js"></script>-->
<!-- / angular framework -->
<!-- END THEME LAYOUT SCRIPTS -->
<script type="text/javascript">

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    @if(count($errors)>0)
    @foreach($errors->all() as $er)
    toastr.error("{{$er}}");
    @endforeach
    @endif
    @if(Session::has('info'))//this line works as expected
    toastr.info("{{ Session::get('info') }}");
    @elseif(Session::has('error'))
    console.log('error');
    toastr.error("{{Session::get('error')}}");
    console.log("errr");
    @elseif(Session::has('warning'))
    toastr.warning("{{Session::get('warning')}}");
    @elseif(Session::has('success'))
    toastr.success("{{Session::get('success')}}");
    @endif


    function change_captcha()
    {
        $("#capimg").html('Loading....');
        $.post('https://ICOToken.jiojio.io/ajax/refresh_capcha',function(data,result)
        {
            $("#capimg").html(data);
        });
    }


</script>
<script src="{{URL::asset('front')}}/assets/js/countrySelect.js"></script>
<script>
    $("#country_id").countrySelect({
        preferredCountries: ['jp','in', 'gb', 'us']
    });
</script>
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
                first_name: {required:true, minlength:2, regex:"^(?!.*\\s{3,})(?!^ )[A-Za-z\\s]{1,50}$"},
                last_name: {required:true, minlength:2, regex:"^(?!.*\\s{3,})(?!^ )[A-Za-z\\s]{1,50}$"},
                phone_no: { number: true,regex:"^[1-9][0-9]*$"},
                icotoken_id:{required:true,regex:"^[0-9a-zA-Z]+$"},
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
                first_name:{required:'First name is required',minlength:'First name should contain atleast two alphabets',regex:'Only alphabets allowed and it should not contain more than one space.'},
                last_name:{required:'Last name is required',minlength:'Last name should contain atleast two alphabets',regex:'Only alphabets allowed and it should not contain more than one space.'},
                icotoken_id: { required:'ICOToken Id is required',regex:'Enter valid ICOTokenId'},
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
    $('body').addClass('login');
    $('#root-view').addClass('auth-layout');
</script>

<style type="text/css">
    .login-box-body {
        position: relative;
    }
</style>
<script>
    $('body').addClass('page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white');
    $('#root-view').addClass('page-wrapper');
    $(function () {
        //$.getScript('{{URL::asset('front')}}/assets/bower_components/metronic/global/scripts/app.js').then(function () {
        //$.getScript('{{URL::asset('front')}}/assets/bower_components/metronic/pages/scripts/dashboard.js');
        //$.getScript('{{URL::asset('front')}}/assets/bower_components/metronic/layouts/layout/scripts/layout.js');
        //$.getScript('{{URL::asset('front')}}/assets/bower_components/metronic/layouts/layout/scripts/demo.js');
        //$.getScript('{{URL::asset('front')}}/assets/bower_components/metronic/layouts/global/scripts/quick-sidebar.js');
        //$.getScript('{{URL::asset('front')}}/assets/bower_components/metronic/layouts/global/scripts/quick-nav.js');
        //})

    });
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>