<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/forgot.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="login-container container-fluid">
        <div class="container lg-wpr">
            <div class="row align-items-center">

                <div class="col-md-4 offset-md-4">
                    <div class="login-wpr pull-right clearfix">
                        <div class="login-top">
                            <h2 class="reg-heading">Forgot password</h2>
                            <p class="reg-sub-heading"></p>
                        </div>

                        <div  class="login-form">
                            <form action="<?php echo e(url('/resetpassword/'.$code)); ?>" id="forgotreset" method="POST">
                                <?php echo e(csrf_field()); ?>

                                <input type="password" class="form-control form-control1 " name="password" id="password" placeholder="New password">
                                <input type="password" class="form-control form-control1" name="password_confirmation" placeholder="Confirm New password">
                                <input type="submit" name="Submit" value="Submit" class="submit-btn pull-left">
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
        $("#forgotreset").validate({
            rules:
                {
                    password:{ required:true,minlength:6,noSpace:true,pwcheckallowedchars:true,pwcheckspechars:true,pwcheckuppercase:true },
                    password_confirmation: { required:true,equalTo:'#password' },
                },
            messages:
                {
                    password:{ required:'password is required', minlength:'Minimum six characters is required' },
                    password_confirmation: { required:'Confirm password is required', equalTo:'Password doesnt match' }
                },
        });

        jQuery.validator.addMethod("noSpace", function(value, element) {
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.jcash_front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>