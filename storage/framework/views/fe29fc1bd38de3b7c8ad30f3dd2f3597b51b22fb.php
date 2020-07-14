<?php $__env->startSection("content"); ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Users</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('prashaasak/home')); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li class="active">Users</li>
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
           <input type="text" id="min" name="min" value="<?php echo e(app('request')->input('min')); ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <lable>End date</lable>
           <input type="text" id="max" name="max" value="<?php echo e(app('request')->input('max')); ?>" class="form-control">
        </div>
        <div class="col-md-3">
            <lable>Search</lable>
           <input type="text" id="search_id" name="search" value="<?php echo e(app('request')->input('search')); ?>" class="form-control">
        </div>
                                        
                                            
                                            
                                                
                                                
                                                        
                                                    
                                                
                                                
                                                        
                                                    
                                                
                                            
                                        
                                        <div class="col-md-3">
                                            <label>Paging</label>
                                            <select class="form-control" name="paging">
                                                <option value="25">25</option>
                                                <option value="50"
                                                        <?php if(app('request')->input('paging')=='50'): ?> selected <?php endif; ?>>
                                                    50
                                                </option>
                                                <option value="100"
                                                        <?php if(app('request')->input('paging')=='100'): ?> selected <?php endif; ?>>
                                                    100
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <lable>Email</lable>
                                            <input type="text" id="email_id" name="email" value="<?php echo e(app('request')->input('email')); ?>" class="form-control">
                                            <button style="margin-top: 17px;" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </div>

                                        <div class="col-md-3">
                                            <button style="margin-top: 17px;" class="btn btn-default"><i class="fa fa-search"></i></button>
                                            <a style="margin-top: 17px;" class="btn btn-default"  href="<?php echo e(url('/user_export')); ?>"><i class="fa fa-download">CSV</i></a>
                                        </div>


         <?php echo e(csrf_field()); ?>

        </form>
                                    </div>

                                        <div class="table-container">

                                            <table class="table table-hover table-striped table-bordered table-advanced tablesorter" id="myTable">
                                                <thead>
                                               <tr>
                                            <th>#Id</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Country</th>
                                            <th>KYC Status</th>
                                            <th>Status</th>
                                            <th>Updated date</th>
                                            <th>Action</th>

                                        </tr>
                                                <tbody>
                                            <?php if($result): ?>
                                            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <tr>
                                               <td><?php echo e($val->id); ?></td>
                                               <td>
                                                   <?php echo e($val->enjoyer_name); ?></td>
                                               <td><?php echo e(get_usermail($val->id)); ?></td>
                                               <td><?php echo e($val->country); ?></td>
                                               <td>
                                                 <?php if($val->document_status==0 ||$val->document_status==3): ?>
                                                 <p class="label label-warning">Pending</p>
                                                 <?php elseif($val->document_status==1): ?>
                                                 <p class="label label-success">Verified</p>
                                                 <?php else: ?>
                                                 <p class="label label-danger">Rejected</p>
                                                 <?php endif; ?>
                                               </td>
                                               <td>
                                                 <?php if($val->status==1): ?>
                                                 <p class="label label-success">Active</p>
                                                 <?php else: ?>
                                                 <p class="label label-danger">Deactive</p>
                                                 <?php endif; ?>
                                               </td>
                                               <td><?php echo e($val->created_at); ?></td>
                                               <td>
                                               <a href="<?php echo e(url('prashaasak/status_users/'.$val->id)); ?>" title="status"><i class="fa fa-cog"></i></a>
                                                 <a href="<?php echo e(url('prashaasak/view_users/'.$val->id)); ?>" title="view"><i class="fa fa-eye"></i></a>
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
        "ordering": true,
        "info":     false,
        "searching": false,
    });
});
</script>

<script type="text/javascript">
function user_verified(user_id)
{
    $.get("<?php echo e(url('ajax/user_verification')); ?>/"+user_id, function (data) {
        if(data == 1)
        {
            document.location.reload();
        }
    });
}
</script>

<link rel="stylesheet" href="<?php echo e(URL::asset('datepicker/jquery-ui.css')); ?>">
  <!-- <script src="<?php echo e(URL::asset('datepicker/jquery-1.12.4.js')); ?>"></script> -->
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