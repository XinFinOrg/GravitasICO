<?php $__env->startSection("content"); ?>
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Dashboard</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('admin/home')); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Dashboard</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
    <div class="page-content">
        <div id="tab-general">
            <div id="sum_box" class="row mbl">
                <div class="col-sm-6 col-md-3">
                    <div class="panel profit db mbm" onclick="window.location.href='<?php echo e(url('admin/users')); ?>'" style="cursor: pointer;">
                        <div class="panel-body"><p class="icon"><i class="icon fa fa-group"></i></p><h4 class="value"><span data-counter="" data-start="10" data-end="50" data-step="1" data-duration="0"><?php echo e(dashboard_usercount()); ?></span></h4>

                            <p class="description">Registered Users</p>


                        </div>
                    </div>
                </div>

                
                    
                        

                            


                        
                    
                
                
                    
                        

                            


                        
                    
                
                <div class="col-sm-6 col-md-3">
                    <div class="panel visit db mbm" onclick="window.location.href='<?php echo e(url('admin/kyc_users')); ?>'" style="cursor: pointer;">
                        <div class="panel-body"><p class="icon"><i class="icon fa fa-group"></i></p><h4 class="value"><span><?php echo e(dashbard_totalkyc()); ?></span></h4>

                            <p class="description">KYC verification</p>


                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <br>
                
                <!-- <div class="col-sm-4 col-md-4">
                    <div class="panel db mbm" style="cursor: pointer;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center"><i class="fa font50"><img src="<?php echo e(URL::asset('front')); ?>/assets/icons/BTC.png" class="stat-icon" style="width: 50px;height: 50px;"></i></div>
                                    <div style="text-align: center"><p><h2><?php echo e($btc_bal); ?></h2></p>
                                        <p class="description "><strong>Admin BTC Balance</strong></p></div>
                                </div>
                            </div> -->

                            
                                
                                    
                                
                                
                                    
                                
                            

<!-- 

                        </div>
                    </div>
                </div> -->

                
                <!-- <div class="col-sm-4 col-md-4">
                    <div class="panel db mbm" style="cursor: pointer;">
                        <div class="panel-body" onclick="window.open('https://etherscan.io/address/<?php echo e(decrypt(get_config('eth_address'))); ?>','_newtab');">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center"><i class="fa font50"><img src="<?php echo e(URL::asset('front')); ?>/assets/icons/ETH.png" class="stat-icon" style="width: 50px;height: 50px;"></i></div>
                                    <div style="text-align: center"><p><h2><?php echo e($eth_bal); ?></h2></p>
                                        <p class="description "><strong>Admin ETH Balance</strong></p></div>
                                </div>
                            </div> -->

                            
                                
                                    
                                
                                
                                    
                                

                            


<!-- 
                        </div>
                    </div>
                </div> -->

                
                <!-- <div class="col-sm-4 col-md-4">
                    <div class="panel db mbm" style="cursor: pointer;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="text-align: center"><i class="fa font50"><img src="<?php echo e(URL::asset('front')); ?>/assets/icons/USDT.png" class="stat-icon" style="width: 50px;height: 50px;"></i></div>
                                    <div style="text-align: center"><p><h2>0</h2></p>
                                        <p class="description "><strong>Admin USDT Balance</strong></p></div>
                                </div>
                            </div> -->

                            <!-- 
                                
                                    
                                
                                
                                    
                                

                             -->



                        <!-- </div>
                    </div> -->
                </div>


            <div class="table-container">

                <div>
                    <h2>&nbsp;&nbsp;Latest 25 ICO Trades:</h2>
                    <br>
                </div>
                <table class="table table-hover table-striped table-bordered table-advanced tablesorter"
                       id="myTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>FirstCurrency</th>
                        <th>SecondCurrency</th>
                        <th>Amount</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Created time</th>


                    </tr>
                    <tbody>
                    <?php if($result): ?>
                        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?></td>
                                <td><?php echo e($val->user_id); ?></td>
                                <td><?php echo e(get_user_details($val->user_id,'enjoyer_name')); ?></td>
                                <td><?php echo e($val->FirstCurrency); ?></td>
                                <td><?php echo e($val->SecondCurrency); ?></td>
                                <td><?php echo e($val->Amount); ?></td>
                                <td><?php echo e(round($val->Price)); ?></td>
                                <td><?php echo e(round($val->Total)); ?></td>
                                <td><?php echo e($val->Status); ?></td>
                                <td><?php echo e($val->created_at); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                    </thead>

                </table>

            </div>



        </div>



    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <?php echo $__env->make('panel.layout.dashboard_script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#myTable').DataTable({
                "searching": false,
                "paging": false,
                "ordering": false,
                "info": false
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>