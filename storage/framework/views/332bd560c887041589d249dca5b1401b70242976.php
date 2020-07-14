<!DOCTYPE html>
<html lang="en">
<?php echo $__env->make('front.layout.jcash_header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body id="page-top" class="index">



<!-- Navigation -->
<?php echo $__env->make('front.layout.jcash_head_bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php echo $__env->yieldContent('css'); ?>
<!-- /.navbar -->

<!-- latest exchanges -->
<?php echo $__env->yieldContent('content'); ?>
<!-- / latest exchanges -->
<!-- footer -->
<?php echo $__env->make('front.layout.jcash_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- / footer -->
<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
<?php echo $__env->make('front.layout.jcash_footer_script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!--selectpicker ends-->
<?php echo $__env->yieldContent('xscript'); ?>
</body>
</html>
