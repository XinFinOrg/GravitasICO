
<script src="<?php echo e(URL::asset('front')); ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/global/plugins/excanvas.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/jquery/jquery.min.js"></script>
<!--<script src="assets/bower_components/metronic/global/plugins/jquery.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>-->
<!--<script src="assets/bower_components/angular/angular.js"></script>
<script src="assets/bower_components/angular-animate/angular-animate.min.js"></script>
<script src="assets/bower_components/angular-resource/angular-resource.js"></script>-->
<!-- END CORE PLUGINS -->
<!-- Vendor -->
<!-- for no html5 browsers support -->
<!--<script src="assets/bower_components/ng-file-upload/ng-file-upload-shim.js"></script>
<script src="assets/bower_components/ng-file-upload/ng-file-upload.js"></script>
<script src="assets/bower_components/moment-with-locales.js"></script>
<script src="assets/bower_components/ngstorage/ngStorage.min.js"></script>
<script src="assets/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
<script src="assets/bower_components/angular-fcsa-number/src/fcsaNumber.min.js"></script>
<script src="assets/bower_components/angular-toastr/dist/angular-toastr.tpls.min.js"></script>
<script src="assets/bower_components/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>
<script src="assets/bower_components/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
<script src="assets/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>-->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!--aaa<script src="assets/bower_components/metronic/global/plugins/bootstrap/js/bootstrap.js"></script>-->
<!--<script src="assets/bower_components/common/common.js"></script>
<script src="assets/bower_components/jquery.validation/jquery.validation.js"></script>
<script src="assets/bower_components/jquery.gmap/jquery.gmap.min.js"></script>
<script src="assets/bower_components/oclazyload/dist/ocLazyLoad.js"></script>
<script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/bower_components/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>-->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/global/scripts/app.js"></script>
<!--<script src="assets/bower_components/metronic/layouts/layout2/scripts/layout.js"></script>-->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/layout/scripts/layout.js"></script>
<!--aaa<script src="assets/bower_components/metronic/layouts/layout2/scripts/demo.js"></script>-->
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/global/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/bower_components/metronic/layouts/global/scripts/quick-nav.js" type="text/javascript"></script>


<!--
    <script src="assets/bower_components/metronic/pages/scripts/dashboard.js"></script>
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
<!--<script src="assets/bower_components/angular-recaptcha/release/angular-recaptcha.js"></script>
<script src="assets/bower_components/moment-fromNow.js"></script>
<script src="app/common/interceptor/authInterceptorService.js"></script>
<script src="app/common/interceptor/httpInterceptorService.js"></script>
<script src="app/common/interceptor/dateDeserialiserInterceptorService.js"></script>
<script src="app/common/auth/authService.js"></script>

<script src="app/common/account/accountService.js"></script>
<script src="app/common/account/accountController.js"></script>-->
<!--aaa<script src="app/common/account/memberService.js"></script>-->
<!-- / angular framework -->
<!-- END THEME LAYOUT SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/toastr-2.1.3.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



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
    <?php if(isset($errors)): ?>
    <?php if(count($errors)>0): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $er): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    toastr.error("<?php echo e($er); ?>");
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
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
</script>

<script>
    $(document).ready(function () {
        $('#clickmewow').click(function () {
            $('#radio1003').attr('checked', 'checked');
        });

        $(function(){
            var current =window.location.href;
            $('#nav li a').each(function(){
                var $this = $(this);
                // if the current path is like this link, make it active
                if($this.attr('href') == current){
                    $this.parents('li').addClass('active');
                }
            })
        })
    })
</script>
<script>
    $('body').addClass('page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white');
    $('#root-view').addClass('page-wrapper');
    $(function () {
        //$.getScript('assets/bower_components/metronic/global/scripts/app.js').then(function () {
        //$.getScript('assets/bower_components/metronic/pages/scripts/dashboard.js');
        //$.getScript('assets/bower_components/metronic/layouts/layout/scripts/layout.js');
        //$.getScript('assets/bower_components/metronic/layouts/layout/scripts/demo.js');
        //$.getScript('assets/bower_components/metronic/layouts/global/scripts/quick-sidebar.js');
        //$.getScript('assets/bower_components/metronic/layouts/global/scripts/quick-nav.js');
        //})

    });
</script>