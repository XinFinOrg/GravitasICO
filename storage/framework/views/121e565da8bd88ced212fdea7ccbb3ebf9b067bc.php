<!DOCTYPE html>
<html lang="en">
<?php echo $__env->make('front.layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body id="page-top" class="index">
<?php echo $__env->yieldContent('css'); ?>
<!-- Navigation -->
<?php echo $__env->make('front.layout.head_barerror', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="clearfix"> </div>
<!-- BEGIN CONTAINER -->
<div class="page-container">


<!-- /.navbar -->
<div class="page-content-wrapper">

<!-- latest exchanges -->
<?php echo $__env->yieldContent('content'); ?>
<!-- / latest exchanges -->
</div>
<!-- footer -->
<?php echo $__env->make('front.layout.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- / footer -->
<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
<?php echo $__env->make('front.layout.footer_script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!--selectpicker ends-->
<?php echo $__env->yieldContent('xscript'); ?>
</body>
</html>