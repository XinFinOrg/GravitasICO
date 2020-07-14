<?php if($paginator->lastPage() > 1): ?>
    <ul class="pagination pagination-sm man">
    <!-- <li class="<?php echo e(($paginator->currentPage() == 1) ? ' disabled' : ''); ?>">
        <a href="<?php echo e($paginator->url(1)); ?>">First</a>
    </li> -->
        <li class="<?php echo e(($paginator->currentPage() == 1) ? ' disabled' : ''); ?>">
            <a href="<?php echo e($paginator->appends(array('min' => Request::get('min'),
    'max'=> Request::get('max'),'currency' => Request::get('currency'),'status' => Request::get('status'),'search' => Request::get('search')))->url($paginator->currentPage()-1)); ?>">«</a>
        </li>
        <?php

        $total = $paginator->currentPage() + 7;
        ?>
        <?php for($i = 1; $i <= $paginator->lastPage(); $i++): ?>
            <?php
            $start = $paginator->currentPage();
            $status = "";
            if ($start <= $i && $i <= $paginator->lastPage()) {
                $status = "block";
            } else {
                $status = "hidden";
                if ($i >= ($paginator->lastPage() - 3) && ($paginator->lastPage() - 3) < $start) {

                    $status = "block";
                } elseif (($start - 3) <= $i && ($start + 3) >= $i)
                {
                    $status = "block";
                }

            }

            ?>
            <li class="<?php echo e(($paginator->currentPage() == $i) ? ' active' : ''); ?> <?php echo e($status); ?>"  >
                <a href="<?php echo e($paginator->appends(array('min' => Request::get('min'),
    'max'=> Request::get('max'),'currency' => Request::get('currency'),'status' => Request::get('status'),'search' => Request::get('search')))->url($i)); ?>"><?php echo e($i); ?></a>
            </li>

        <?php endfor; ?>
        <li class="<?php echo e(($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : ''); ?>">
            <a href="<?php echo e($paginator->appends(array('min' => Request::get('min'),
    'max'=> Request::get('max'),'currency' => Request::get('currency'),'status' => Request::get('status'),'search' => Request::get('search')))->url($paginator->currentPage()+1)); ?> ">»</a>
        </li>
    <!--  <li class="<?php echo e(($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : ''); ?>">
        <a href="<?php echo e($paginator->url($paginator->lastPage())); ?>" >Last</a>
    </li> -->
    </ul>
<?php endif; ?>