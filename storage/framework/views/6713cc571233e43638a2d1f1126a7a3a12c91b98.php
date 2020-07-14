<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/trans.css">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <section class="login-container container-fluid">
        <div class="container lg-wpr">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h2>Transaction List</h2>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr style="background:#eed00b;">
                                    <th>Sr.No</th>
                                    <th>Transaction Id</th>
                                    <th>Contribution Method</th>
                                    <th>Amout Contributed</th>
                                    <th>Is Bonus ?</th>
                                    <th>JCASH Sale</th>
                                    <th>JCASH Reward</th>
                                    <th>Total JCASH</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>

                                    <td><?php echo e($key+1); ?></td>
                                    <td><?php echo e($data->transaction_id); ?></td>
                                    <td><?php echo e($data->SecondCurrency); ?></td>
                                    <td><?php echo e(number_format($data->Amount,2,'.','')); ?></td>
                                    <?php if($data->Discount > 0): ?>
                                    <td>Yes</td>
                                    <?php else: ?>
                                        <td>No</td>
                                    <?php endif; ?>
                                    <td><?php echo e(number_format($data->firstAmount,2,'.','')); ?></td>
                                    <td><?php echo e(number_format($data->Discount,2,'.','')); ?></td>
                                    <td><?php echo e(number_format($data->Total,2,'.','')); ?></td>
                                    <td><?php echo e($data->Status); ?></td>
                                    <td><?php echo e(date('d-m-Y', strtotime($data->updated_at))); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('xscript'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.jcash_front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>