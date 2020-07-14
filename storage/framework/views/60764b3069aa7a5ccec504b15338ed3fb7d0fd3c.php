    <?php if(count($errors) > 0): ?> 
           <div class="alert alert-danger">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $er): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($er); ?><br/>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
         <?php if(Session::has('error')): ?>
    <div class="alert alert-danger">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo e(Session('error')); ?></div>
    <?php endif; ?>

     <?php if(Session::has('success')): ?>
    <div class="alert alert-success">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo e(Session('success')); ?></div>
    <?php endif; ?>