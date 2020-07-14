<?php $__env->startSection("content"); ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">My Profile</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('prashaasak/home')); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="hidden"><a href="#">Profile</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Profile</li>
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
                                        <form action="<?php echo e(url('prashaasak/profile')); ?>" method="post" class="form-horizontal">
                                        <h3>Account Setting</h3>
                                        <?php echo e(csrf_field()); ?>

                                            <div class="form-group"><label class="col-sm-3 control-label">Email *</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                 <div class="col-xs-9"><input type="email" placeholder="email@yourcompany.com" class="form-control" name="admin_email" value="<?php echo e(get_adminprofile('email_id')); ?>" /></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Username *</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="username" name="admin_username" value="<?php echo e(get_adminprofile('XDC_username')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>


                                             <div class="form-group"><label class="col-sm-3 control-label">Phone</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="9876543210" name="" value="<?php echo e(owndecrypt(get_adminprofile('phone'))); ?>" class="form-control" disabled="disabled" /></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group"><label class="col-sm-3 control-label">Country</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="India" name="admin_country" value="<?php echo e(get_adminprofile('country')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <hr/>

                                            <h3>Change password</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">Current Password</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="password" placeholder="Current Password" name="curr_pass" class="form-control" /></div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">New Password</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="password" placeholder="New Password" name="password" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">Confirm New Password</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-4"><input type="password" placeholder="Confirm New Password" name="password_confirmation" class="form-control"/></div>
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
<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>