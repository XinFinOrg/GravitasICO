<?php $__env->startSection("content"); ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">User KYC Details</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('prashaasak/home')); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li class="active">KYC Details</li>
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

                                     <form class="form-horizontal" method="post" action="<?php echo e(url('prashaasak/view_kyc/'.$id)); ?>" >
                                    <?php echo e(csrf_field()); ?>

                                         <h3>KYC Details: </h3>
                                      <div class="panel-body pan">
                                      <div class="form-body pal">


                              <div class="row">

                               <div class="col-md-12">
                                <div class="form-group"><label for="inputFirstName" class="col-md-2 control-label"><strong>User ID:</strong></label>

                                    <div class="col-md-10"><p class="form-control-static"><?php echo e($result->user_id); ?></p></div>
                                </div>
                            </div>  <br>


                            <div class="col-md-12">
                                <div class="form-group"><label for="inputFirstName" class="col-md-2 control-label"><strong>Email:</strong></label>

                                    <div class="col-md-10"><p class="form-control-static"><?php echo e(get_usermail($result->user_id)); ?></p></div>
                                </div>
                            </div>  <br>


                            <div class="col-md-12">
                                <div class="form-group"><label for="inputFirstName" class="col-md-2 control-label"><strong>User Name:</strong></label>

                                    <div class="col-md-10"><p class="form-control-static">
                                      <?php echo e($result->enjoyer_name); ?>

                                    </p></div>
                                </div>
                            </div> <br>



                            <div class="col-md-12">
                                <div class="form-group"><label for="inputFirstName" class="col-md-2 control-label"><strong>First Name:</strong></label>

                                    <div class="col-md-10"><p class="form-control-static"><?php echo e($result->first_name); ?></p></div>
                                </div>
                            </div> <br>



                            <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Last Name:</strong></label>

                                    <div class="col-md-10"><p class="form-control-static"><?php echo e($result->last_name); ?></p></div>
                                </div>
                            </div> <br>

                                  <div class="col-md-12">
                                      <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Country:</strong></label>

                                          <div class="col-md-10"><p class="form-control-static"><?php echo e(get_country_name($result->country_code)); ?></p></div>
                                      </div>
                                  </div> <br>

                                  <div class="col-md-12">
                                      <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>ISD Code:</strong></label>

                                          <div class="col-md-10"><p class="form-control-static"><?php echo e($result->mob_isd); ?></p></div>
                                      </div>
                                  </div> <br>

                                  <div class="col-md-12">
                                      <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Mobile No:</strong></label>

                                          <div class="col-md-10"><p class="form-control-static"><?php echo e(owndecrypt($result->mobile_no)); ?></p></div>
                                      </div>
                                  </div> <br>

                             <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Updated date:</strong></label>

                                    <div class="col-md-10"><p class="form-control-static"><?php echo e($result->updated_at); ?></p></div>
                                </div>
                            </div>




                             <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>User Status:</strong></label>

                                    <div class="col-md-10"><p class="form-control-static">
                                       <?php if($result->status==1): ?>
                                                 Active
                                                 <?php else: ?>
                                                 Deactive
                                                 <?php endif; ?>
                                    </p></div>
                                </div>
                            </div>




                             <h3>KYC Status: </h3>
                           <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>KYC status:</strong></label>

                                    <div class="col-md-10"><p class="form-control-static">
                                         <?php if($result->document_status==0 ||  $result->document_status==3 ): ?>
                                                 <p class="label label-warning">Pending</p>
                                                 <?php elseif($result->document_status==1): ?>
                                                 <p class="label label-success">Verified</p>
                                                 <?php else: ?>
                                                 <p class="label label-danger">Rejected</p>
                                                 <?php endif; ?>
                                    </p></div>
                                </div>
                            </div>



                             <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Proof 1:</strong></label>

                                    <div class="col-md-6"><p class="form-control-static">
                                      <img src="<?php echo e(URL::asset('uploads/users/documents')); ?>/<?php echo e($result->proof1); ?>" style="width: 150px;height: 100px;">
                                    </p>
                                    </div>
                                    <div class="col-md-4">
                                    <input type="checkbox" name="proof1_status" <?php if($result->proof1_status==1): ?> Checked <?php endif; ?> >
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Proof 2:</strong></label>

                                    <div class="col-md-6"><p class="form-control-static">
                                      <img src="<?php echo e(URL::asset('uploads/users/documents')); ?>/<?php echo e($result->proof2); ?>" style="width: 150px;height: 100px;">
                                    </p>
                                    </div>
                                    <div class="col-md-4">
                                    <input type="checkbox" name="proof2_status" <?php if($result->proof2_status==1): ?> Checked <?php endif; ?> >
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Proof 3:</strong></label>

                                    <div class="col-md-6"><p class="form-control-static">
                                      <img src="<?php echo e(URL::asset('uploads/users/documents')); ?>/<?php echo e($result->proof3); ?>" style="width: 150px;height: 100px;">
                                    </p>
                                    </div>
                                    <div class="col-md-4">
                                   <input type="checkbox" name="proof3_status" <?php if($result->proof3_status==1): ?> Checked <?php endif; ?> >
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Over All Status:</strong></label>

                                    <div class="col-md-6"><p class="form-control-static">
                                    <select class="form-control" name="kycstatus" onchange="kycscr(this.value)">
                                        <option value="0" <?php if($result->document_status==0 || $result->document_status==3): ?>selected <?php endif; ?>>Pending</option>
                                        <option value="1" <?php if($result->document_status==1): ?>selected <?php endif; ?> >Approve</option>
                                        <option value="2" <?php if($result->document_status==2): ?>selected <?php endif; ?>>Reject</option>
                                    </select>
                                    </p></div>
                                </div>
                            </div>

                            <div id="kyc_reason" style="display: none;">
                             <div class="col-md-12">
                                <div class="form-group"><label for="inputLastName" class="col-md-2 control-label"><strong>Reason:</strong></label>

                                    <div class="col-md-6"><p class="form-control-static">
                                   <textarea class="form-control" name="kycreason"></textarea>
                                    </p></div>
                                </div>
                            </div>

                            </div>


                        <small>Note: If you have approve please select proof checkbox</small>








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
<script type="text/javascript">
    function kycscr(id)
    {
        if(id==2)
        {
            $("#kyc_reason").show();
        }
        else
        {
             $("#kyc_reason").hide();
        }
    }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>