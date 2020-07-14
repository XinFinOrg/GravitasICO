<?php $__env->startSection("content"); ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Update Template</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('admin/home')); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li class="active">Template</li>
                </ol>
                <div class="clearfix"></div>
            </div>


            <div class="page-content">
  <div class="row">
                    <div class="col-md-12">

                     <?php echo $__env->make('panel.alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <div class="row mtl">

                            <div class="col-md-12">

                                <div id="generalTabContent" class="tab-content">
                                    <div id="tab-edit" class="tab-pane fade in active">
                                        <form action="<?php echo e(url('admin/update_template/'.$id)); ?>" method="post" class="form-horizontal">
                                        <h3>Update Template</h3>
                                        <?php echo e(csrf_field()); ?>


                                         <div class="form-group"><label class="col-sm-3 control-label">Title </label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                <div class="col-xs-9"><input type="text" value="<?php echo e($result->name); ?>" class="form-control" readonly="readonly" /></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">Subject </label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                <div class="col-xs-9"><input type="text"  name="subject" value="<?php echo e($result->subject); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group"><label class="col-sm-3 control-label">Content </label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                <div class="col-xs-9">
                                                <textarea class="form-control" name="template" id="content"><?php echo e($result->template); ?></textarea>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>







                                            <hr/>
                                            <button type="submit" class="btn btn-green btn-block">Update</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript" src="<?php echo e(URL::asset('ckeditor/ckeditor.js')); ?>"></script>
<script type="text/javascript">

CKEDITOR.replace('content' ,
{
filebrowserBrowseUrl : '<?php echo e(URL::asset("ckfinder/ckfinder.html")); ?>',
filebrowserImageBrowseUrl : '<?php echo e(URL::asset("/")); ?>ckfinder/ckfinder.html?type=Images',
filebrowserFlashBrowseUrl : '<?php echo e(URL::asset("/")); ?>ckfinder/ckfinder.html?type=Flash',
filebrowserUploadUrl : '<?php echo e(URL::asset("/")); ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
filebrowserFlashUploadUrl : '<?php echo e(URL::asset("/")); ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>