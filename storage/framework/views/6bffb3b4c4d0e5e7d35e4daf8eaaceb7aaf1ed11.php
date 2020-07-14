<?php $__env->startSection("content"); ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">KYC Status</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('admin/home')); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li class="active">KYC</li>
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

                                    <div class="row">
                                    <form id="form_filters" method="get">

                                    <div class="col-md-3">
            <lable>Start date</lable>
           <input type="text" id="min" name="min" value="<?php echo e(app('request')->input('min')); ?>" class="form-control" required="required">
        </div>
        <div class="col-md-3">
            <lable>End date</lable>
           <input type="text" id="max" name="max" value="<?php echo e(app('request')->input('max')); ?>" class="form-control" required="required">
        </div>
        <div class="col-md-3">
            <button style="margin-top: 17px;" class="btn btn-default"><i class="fa fa-search"></i></button>
        </div>
         <?php echo e(csrf_field()); ?>

        </form>
                                    </div>

                                        <div class="table-container">

                                            <table class="table table-hover table-striped table-bordered table-advanced tablesorter" id="myTable">
                                                <thead>
                                               <tr>
                                            <th>#</th>
                                            <th>User ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>KYC Status</th>

                                            <th>Date time</th>

                                            <th>Action</th>


                                        </tr>
                                                <tbody>
                                               <?php if($result): ?>
                                               <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <tr>
                                               <td><?php echo e($key+1); ?></td>
                                               <td><?php echo e($val->user_id); ?></td>
                                               <td><?php echo e($val->enjoyer_name); ?></td>
                                               <td><?php echo e(get_usermail($val->user_id)); ?></td>
                                               <td>
                                                    <?php if($val->document_status==0 || $val->document_status==3): ?>
                                                 <p class="label label-warning">Pending</p>
                                                 <?php elseif($val->document_status==1): ?>
                                                 <p class="label label-success">Verified</p>
                                                 <?php else: ?>
                                                 <p class="label label-danger">Rejected</p>
                                                 <?php endif; ?>
                                               </td>
                                               <td><?php echo e($val->updated_at); ?></td>
                                               <td>
                                        <a href="<?php echo e(url('admin/view_kyc/'.$val->id)); ?>" title="view"><i class="fa fa-eye"></i></a>
                                               </td>
                                               </tr>
                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                               <?php endif; ?>
                                                </tbody>
                                                </thead></table>

                                        </div>

                                         <div class="row">
                                                <div class="col-lg-6">

                                                </div>
                                                <div class="col-lg-6 text-right">
                                                    <div class="pagination-panel">
                                                      <?php echo $__env->make('panel.pagination', ['paginator' => $result], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                                    </div>
                                                </div>
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
    $('#myTable').DataTable({
          "paging":   false,
        "ordering": false,
        "info":     false
    });
});

</script>

<link rel="stylesheet" href="<?php echo e(URL::asset('datepicker/jquery-ui.css')); ?>">
  <script src="<?php echo e(URL::asset('datepicker/jquery-ui.js')); ?>"></script>
  <script>
  $(function() {

     $( "#max,#min" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd',
      onSelect: function( selectedDate ) {
            if(this.id == 'min'){
              var dateMin = $('#min').datepicker("getDate");
              var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 1);
              $('#max').datepicker("option","minDate",rMin);
            }

        }


    });



  } );
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>