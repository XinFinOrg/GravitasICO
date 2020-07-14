<?php $__env->startSection('content'); ?>

    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN PAGE BAR -->
                <!--<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="index.html">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Dashboard</span>
        </li>
    </ul>
    <div class="page-toolbar">
        <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
            <i class="icon-calendar"></i>&nbsp;
            <span class="thin uppercase hidden-xs"></span>&nbsp;
            <i class="fa fa-angle-down"></i>
        </div>
    </div>
</div>-->
                <!-- END PAGE BAR -->
                <!-- END PAGE HEADER-->
                <!-- PAGE CONTENT AAA-->
               <?php if(!$results): ?>
                <div class="alert alert-info" >
                    You do not have any transaction.
                </div>
                <?php else: ?>

                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet light ">
                            <div class="caption text-center">
                                    <span class="caption-subject font-dark bold uppercase">
                                        Transaction History
                                    </span>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th> Date </th>
                                            <th> Cryptocurrency  </th>
                                            <th class="text-right"> GIFT </th>
                                            <th class="text-right"> Bonus </th>
                                            <th class="text-right"> Total GIFT </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr>
                                            <td class=""> <?php echo e($result->updated_at); ?></td>
                                            <!--<td class="text-success"> 0,001207104 <img class="ccy ccy-btc"></td>-->
                                            <td class="text-success"> <?php echo e($result->Amount); ?> <?php if($result->SecondCurrency == 'BTC'): ?><i class="fab fa-bitcoin"> Bitcoin</i><?php else: ?><i class="fab fa-ethereum"> Ethereum</i><?php endif; ?></td>
                                            <td class="text-danger text-right">  <?php echo e($result->firstAmount); ?> </td>
                                            <td class="text-danger text-right"> <?php echo e($result->Discount); ?></td>
                                            <td class="text-success text-right"> <?php echo e($result->Total); ?> </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                            
                                            
                                            
                                            
                                            
                                        
                                        
                                            
                                            
                                            
                                            
                                            
                                        
                                        
                                            
                                            
                                            
                                            
                                            
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /PAGE CONTENT AAA-->
                <?php endif; ?>
            </div>
            <!-- END CONTENT BODY -->
        </div>
    <!-- END SIDEBAR -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>