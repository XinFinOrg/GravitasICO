<?php $__env->startSection("content"); ?>
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Site Configuration</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('admin/home')); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="hidden"><a href="#">Profile</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Site settings</li>
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
                                        <form action="<?php echo e(url('admin/site_settings')); ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <h3>Site Settings</h3>
                                        <?php echo e(csrf_field()); ?>

                                            <div class="form-group"><label class="col-sm-3 control-label">Site Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                 <div class="col-xs-9"><input type="text"  class="form-control" name="site_name" value="<?php echo e(get_config('site_name')); ?>" /></div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">Site Logo</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                 <div class="col-xs-9"><input type="file"  class="" name="site_logo"  /></div>
                                                 <img src="<?php echo e(url('uploads/logo')); ?>/<?php echo e(get_config('site_logo')); ?>" style="width: 150px;" />
                                                    </div>
                                                </div>
                                            </div>



                                             <div class="form-group"><label class="col-sm-3 control-label">Contact Mail</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" name="contact_mail" value="<?php echo e(get_config('contact_mail')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">Address</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9">
                                                            <textarea class="form-control" name="address"><?php echo e(get_config('address')); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                             <div class="form-group"><label class="col-sm-3 control-label">City</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6"><input type="text" name="city" value="<?php echo e(get_config('city')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">Provience</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6"><input type="text" name="provience" value="<?php echo e(get_config('provience')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">Country</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6"><input type="text" name="country" value="<?php echo e(get_config('country')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group"><label class="col-sm-3 control-label">Contact No</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6"><input type="text" name="contact_no" value="<?php echo e(get_config('contact_no')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>





                                            <hr/>

                                            <h3>Social Links</h3>

                                             <div class="form-group"><label class="col-sm-3 control-label">Facebook Url</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6"><input type="url" name="facebook_url" value="<?php echo e(get_config('facebook_url')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="form-group"><label class="col-sm-3 control-label">Twitter Url</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6"><input type="url" name="twitter_url" value="<?php echo e(get_config('twitter_url')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">Google Url</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6"><input type="url" name="google_url" value="<?php echo e(get_config('google_url')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">LinkedIn Url</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-6"><input type="url" name="linkedin_url" value="<?php echo e(get_config('linkedin_url')); ?>" class="form-control"/></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <hr/>

                                            
                                            <h3>Analytics script</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">Google Analytics Script</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9">
                                                            <textarea class="form-control" name="google_analytics"><?php echo e(get_config('google_analytics')); ?></textarea>
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
<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>