<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="app">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FoodCode</title>
    <meta content="CREATANIUM page" name="description" />
    <meta content="PLMP" name="author" />
    <link rel="shortcut icon" href="<?php echo e(URL::asset('front')); ?>/assets/img/favicon.ico" type="image/x-icon" />
    <!--<base href="/" />-->
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">-->


    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/font-awesome/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/simple-line-icons/css/simple-line-icons.min.css" rel="stylesheet">
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/css/components.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/css/plugins.css" rel="stylesheet" type="text/css" />

    <!--<link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/owl.carousel/<?php echo e(URL::asset('front')); ?>/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/owl.carousel/<?php echo e(URL::asset('front')); ?>/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-toastr/dist/angular-toastr.css" rel="stylesheet" />-->
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/pages/css/login-2.css" rel="stylesheet" type="text/css" />
    <!--<link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout2/css/custom.css" rel="stylesheet" type="text/css" />-->
    <!-- END THEME LAYOUT STYLES -->
    <!--<link rel="shortcut icon" href="favicon.ico" />-->
    <link href="<?php echo e(URL::asset('front')); ?>/assets/css/site.css" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('front')); ?>/assets/css/ccy.css" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('front')); ?>/assets/css/styles.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/toastr-2.1.3.css">
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
    <a href="http://foodcode.io/">
        <img src="<?php echo e(URL::asset('front')); ?>/assets/img/logo-big-light.png" alt="" />


    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <form id="forgot_form" class="login-form" action="<?php echo e(url('/forgotpass')); ?>" method="post">
        <?php echo e(csrf_field()); ?>

        <fieldset >
            <!--<div class="" ng-if="successForgot">
                <div class="alert alert-info">
                    <strong>Success!</strong>
                    A code to reset your password and your registration information has just been sent to your e-mail address.
                    Please check your e-mail.
                </div>
            </div>-->

            <div class="form-title">
                <span class="form-title">Account Recovery.</span><br>
                <span class="hint">Please enter your e-mail address.</span>
            </div>

            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input required  class="form-control form-control-solid placeholder-no-fix" type="email" placeholder="Email" name="forgot_mail" />
                <!--<span class="help-block" ng-show="submitted && form.email.$error.required">Required</span>
                <span class="help-block" ng-show="submitted && emailNotFound">e-mail not found.</span>-->
            </div>
            <div class="form-actions text-center">
                <button type="submit"  class="btn green">Forgot Password</button>
            </div>
            <div class="login-options">
                <a class="" href="<?php echo e(url('/login')); ?>"> Login</a> <!--ui-sref="auth.login"-->
                <a href="<?php echo e(url('/register')); ?>" class="pull-right" id="register-btn"> Sign Up</a> <!--ui-sref="auth.register"-->
            </div>
        </fieldset>
    </form>
</div>
<div class="copyright">
    &copy; 2019 FoodCode. All Rights Reserved.
</div>








<!--<div id="root-view" ui-view="root"></div>-->
<!--[if lt IE 9]>
<script src="<?php echo e(URL::asset('front')); ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/global/plugins/excanvas.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/jquery/jquery.min.js"></script>
<!--<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/plugins/jquery.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>-->
<!--<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular/angular.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-animate/angular-animate.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-resource/angular-resource.js"></script>-->
<!-- END CORE PLUGINS -->
<!-- Vendor -->
<!-- for no html5 browsers support -->
<!--<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/ng-file-upload/ng-file-upload-shim.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/ng-file-upload/ng-file-upload.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/moment-with-locales.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/ngstorage/ngStorage.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-fcsa-number/src/fcsaNumber.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-toastr/dist/angular-toastr.tpls.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>-->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!--aaa<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/plugins/bootstrap/js/bootstrap.js"></script>-->
<!--<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/common/common.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/jquery.validation/jquery.validation.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/jquery.gmap/jquery.gmap.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/oclazyload/dist/ocLazyLoad.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>-->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/scripts/app.js"></script>
<!--<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout2/scripts/layout.js"></script>-->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout/scripts/layout.js"></script>
<!--aaa<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout2/scripts/demo.js"></script>-->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/global/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/global/scripts/quick-nav.js" type="text/javascript"></script>
<!--
    <script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/pages/scripts/dashboard.js"></script>
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
<!--<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/angular-recaptcha/release/angular-recaptcha.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/moment-fromNow.js"></script>
<script src="app/common/interceptor/authInterceptorService.js"></script>
<script src="app/common/interceptor/httpInterceptorService.js"></script>
<script src="app/common/interceptor/dateDeserialiserInterceptorService.js"></script>
<script src="app/common/auth/authService.js"></script>

<script src="app/common/account/accountService.js"></script>
<script src="app/common/account/accountController.js"></script>-->
<!--aaa<script src="app/common/account/memberService.js"></script>-->
<!-- / angular framework -->
<!-- END THEME LAYOUT SCRIPTS -->

<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/toastr-2.1.3.js"></script>
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
    <?php if(count($errors)>0): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $er): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    toastr.error("<?php echo e($er); ?>");
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <?php if(Session::has('info')): ?>//this line works as expected
    toastr.info("<?php echo e(Session::get('info')); ?>");
    <?php elseif(Session::has('error')): ?>
    console.log('error');
    toastr.error("<?php echo e(Session::get('error')); ?>");
    console.log("errr");
    <?php elseif(Session::has('warning')): ?>
    toastr.warning("<?php echo e(Session::get('warning')); ?>");
    <?php elseif(Session::has('success')): ?>
    toastr.success("<?php echo e(Session::get('success')); ?>");
    <?php endif; ?>


    function change_captcha()
    {
        $("#capimg").html('Loading....');
        $.post('https://jcash.jiojio.io/ajax/refresh_capcha',function(data,result)
        {
            $("#capimg").html(data);
        });
    }


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
        //$.getScript('<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/scripts/app.js').then(function () {
        //$.getScript('<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/pages/scripts/dashboard.js');
        //$.getScript('<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout/scripts/layout.js');
        //$.getScript('<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout/scripts/demo.js');
        //$.getScript('<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/global/scripts/quick-sidebar.js');
        //$.getScript('<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/global/scripts/quick-nav.js');
        //})

    });
</script>
</body>
</html>