<?php $__env->startSection("content"); ?>
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Users</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('prashaasak/home')); ?>">Home</a>&nbsp;&nbsp;<i
                        class="fa fa-angle-right"></i>&nbsp;&nbsp;
            </li>

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

                                <form class="form-horizontal">
                                    <h3>User Details: </h3>
                                    <div class="panel-body pan">
                                        <div class="form-body pal">


                                            <div class="row">


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputFirstName"
                                                                                   class="col-md-2 control-label"><strong>Email:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static"><?php echo e(get_usermail($id)); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputFirstName"
                                                                                   class="col-md-2 control-label"><strong>User
                                                                Name:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                <?php echo e($result->enjoyer_name); ?>

                                                            </p></div>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputFirstName"
                                                                                   class="col-md-2 control-label"><strong>First
                                                                Name:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static"><?php echo e($result->first_name); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Last
                                                                Name:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static"><?php echo e($result->last_name); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Created
                                                                date:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static"><?php echo e($result->created_at); ?></p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Status:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                <?php if($result->status==1): ?>
                                                                    Active
                                                                <?php else: ?>
                                                                    Deactive
                                                                <?php endif; ?>
                                                            </p></div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Image:</strong></label>

                                                        <div class="col-md-10">
                                                            <img src="<?php echo e(URL::asset('uploads/users/profileimg')); ?>/<?php echo e($result->profile_image); ?>"
                                                                 style="width: 150px;height: 150px;"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>IP
                                                                Address:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static"><?php echo e($result->ip); ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                    
                                                                                   

                                                        
                                                                    
                                                        
                                                    
                                                

                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Mobile:</strong></label>

                                                        <div class="col-md-10"><p
                                                                    class="form-control-static"><?php echo e(owndecrypt($result->mobile_no)); ?></p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <h3>KYC Status: </h3>
                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>KYC
                                                                status:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                            <?php if($result->document_status==0 || $result->document_status==3): ?>
                                                                <p class="label label-warning">Pending</p>
                                                            <?php elseif($result->document_status==1): ?>
                                                                <p class="label label-success">Verified</p>
                                                            <?php else: ?>
                                                                <p class="label label-danger">Rejected</p>
                                                                <?php endif; ?>
                                                                </p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <h3>User Balance: </h3>



                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="inputLastName"
                                                                   class="col-md-2 control-label"><strong>BTC:</strong>
                                                            </label>

                                                            <div class="col-md-10"><p class="form-control-static">
                                                                    <?php echo e(get_userbalance($id,'BTC')); ?>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="inputLastName"
                                                                   class="col-md-2 control-label"><strong> Verified BTC:</strong>
                                                            </label>

                                                            <div class="col-md-10"><p class="form-control-static">
                                                                    <?php echo e($BTC_Bal); ?>

                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group"><label for="inputLastName"
                                                                                       class="col-md-2 control-label"><strong>ETH:</strong></label>

                                                            <div class="col-md-10"><p class="form-control-static">
                                                                    <?php echo e(get_userbalance($id,'ETH')); ?>

                                                                </p></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Verified ETH:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                <?php echo e($ETH_Bal); ?>

                                                            </p></div>
                                                    </div>
                                                    </div>


                                                <div class="col-md-6">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>CMB:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                <?php echo e(get_userbalance($id,'CMB')); ?>

                                                            </p></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>Verified CMB:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                <?php echo e($icotoken_Bal); ?>

                                                            </p></div>
                                                    </div>
                                                </div>



                                                <h3>User Addresses: </h3>
                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>BTC:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                <?php echo e($result->BTC_addr); ?><br>
                                                                
                                                                    
                                                                
                                                            </p></div>
                                                    </div>
                                                </div>



                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>ETH:</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                <?php echo e($result->ETH_addr); ?><br>
                                                                <a href="<?php echo e(url('cron/eth_deposit_process_user/'.$id)); ?>" style="color: red;">
                                                                    Click here
                                                                </a>to manually deposit <strong>ETH</strong>.
                                                            </p></div>
                                                    </div>
                                                </div>



                                                <div class="col-md-12">
                                                    <div class="form-group"><label for="inputLastName"
                                                                                   class="col-md-2 control-label"><strong>CMB
                                                                :</strong></label>

                                                        <div class="col-md-10"><p class="form-control-static">
                                                                <?php echo e($result->CMB_addr); ?>

                                                            </p></div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>


<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>