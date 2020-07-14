<?php $__env->startSection("content"); ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Email Template</div>
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

                        <div id="tableactionTabContent" class="tab-content">
                             <div id="table-table-tab" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="table-container">

                                            <table class="table table-hover table-striped table-bordered table-advanced tablesorter" id="myTable">
                                                <thead>
                                               <tr>
                                            <th>#</th>
                                            <th>Template</th>
                                           <th>Subject</th>
                                            <th>Updated at</th>

                                            <th>Actions</th>


                                        </tr>
                                                <tbody>

                                                <?php if($result): ?>
                                                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                <td><?php echo e($key+1); ?></td>
                                                <td><?php echo e($val->name); ?></td>
                                                <td><?php echo e($val->subject); ?></td>
                                                <td><?php echo e($val->updated_at); ?></td>
                                                <td>
                                                <a href="<?php echo e(url('admin/update_template/'.$val->id)); ?>" title="edit"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>

                                                </tbody>
                                                </thead></table>

                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>