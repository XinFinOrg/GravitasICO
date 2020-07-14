<!DOCTYPE html>
<html lang="en">
<?php echo $__env->make("panel.layout.header", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<body>
<div>
   <?php echo $__env->make("panel.layout.header_bar", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!--END TOPBAR-->
    <div id="wrapper"><!--BEGIN SIDEBAR MENU-->
        <?php echo $__env->make("panel.layout.sidebar", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!--END SIDEBAR MENU-->
       
      <!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <?php echo $__env->yieldContent("content"); ?>
            <!--END CONTENT--><!--BEGIN FOOTER-->
            <?php echo $__env->make('panel.layout.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!--END FOOTER--></div>
        <!--END PAGE WRAPPER--></div>
</div>
 <?php echo $__env->make('panel.layout.footer_script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

 <?php echo $__env->yieldContent("script"); ?>
<!--LOADING SCRIPTS FOR PAGE-->






</body>
</html>