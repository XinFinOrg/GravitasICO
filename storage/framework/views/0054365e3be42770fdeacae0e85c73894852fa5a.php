<?php $__env->startSection("content"); ?>
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"><?php echo e($Header); ?></div>
            <input type="hidden" id ="url" value="<?php echo e(url('admin/')); ?>">
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo e(url('admin/home')); ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

            <?php if($Header == 'Users Wallet Balance'): ?>
            <li class="active">User Balance</li>
                <?php elseif($Header == 'Users Opening Balance'): ?>
                <li class="active">Opening Balance</li>
                <?php else: ?>
                <li class="active">Closing Balance</li>
            <?php endif; ?>

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
                                    <form id="form_filters" method="get">

                                        <div class="col-md-3">
                                            <lable>User Id</lable>
                                            <input type="text" id="user_search_id" name="user_search_id" value="<?php echo e(app('request')->input('user_id')); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <lable>Search</lable>
                                            <input type="text" id="search_id" name="search" value="<?php echo e(app('request')->input('search')); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <lable>Email</lable>
                                            <input type="text" id="email_id" name="email" value="<?php echo e(app('request')->input('email')); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <a style="margin-top: 17px;" class="btn btn-default" href="<?php echo e(url('/admin/userbalance/')); ?>"><i
                                                        class="fa fa-refresh" ></i></a>&nbsp;
                                            <button style="margin-top: 17px;" class="btn btn-default"><i
                                                        class="fa fa-search"></i></button>
                                        </div>
                                        <?php echo e(csrf_field()); ?>

                                    </form>
                                </div>

                                <div class="table-container">

                                    <table class="table table-hover table-striped table-bordered table-advanced tablesorter" id="myTable">
                                        <thead>
                                        <tr>
                                            <th><a href="#" id="bal_tooltip" data-html="true" data-toggle="tooltip">#</a></th>
                                            <th>Username</th>
                                            <th>UserID</th>
                                            <th>BTC<a href="<?php echo e(url('/admin/userbalance?currency=BTC')); ?>"><i class="fa fa-fw fa-sort pull-right"></i></a></th>
                                            <th>ETH<a href="<?php echo e(url('/admin/userbalance?currency=ETH')); ?>"><i class="fa fa-fw fa-sort pull-right"></i></a></th>
                                            <th>USDT<a href="<?php echo e(url('/admin/userbalance?currency=USDT')); ?>"><i class="fa fa-fw fa-sort pull-right"></i></a></th>
                                            <th>GIFT<a href="<?php echo e(url('/admin/userbalance?currency=GIFT')); ?>"><i class="fa fa-fw fa-sort pull-right"></i></a></th>
                                            <?php if($Header == 'User Wallet Balance'): ?>
                                            <th>Edit</th>
                                                <?php else: ?>
                                                <th>Date Time</th>
                                                <?php endif; ?>


                                        </tr>
                                        <tbody>
                                        <?php if($result): ?>
                                            <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td>
                                                            <?php echo e($val->enjoyer_name); ?></td>
                                                    <td><?php echo e($val->user_id); ?></td>
                                                    <td><?php echo e($val->BTC); ?></td>
                                                    <td><?php echo e($val->ETH); ?></td>
                                                    <td><?php echo e($val->USDT); ?></td>
                                                    <td><?php echo e($val->GIFT); ?></td>
                                                    <?php if($Header == 'User Wallet Balance'): ?>
                                                    <td><a onclick="update_userbal('<?php echo e($val->user_id); ?>','<?php echo e($val->enjoyer_name); ?>','<?php echo e($val->BTC); ?>','<?php echo e($val->ETH); ?>','<?php echo e($val->USDT); ?>','<?php echo e($val->GIFT); ?>')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>

                                                    <?php else: ?>
                                                        <td><?php echo e($val->created_at); ?></td>
                                                    <?php endif; ?>
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


    <!-- Modal -->
    <div id="update_user" class="modal danger fade"  role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id ="header"><strong>Edit Balance</strong></h4>
                </div>
                <div class="modal-body">
                    <form id="userbalupdate" method="post" action="<?php echo e(url('/admin/update_user_balance')); ?>">
                        <div class="row">
                            <input type="hidden" class="form-control" name="user_id" id="user_id">
                            <input type="hidden" class="form-control" name="user_name" id="user_name">
                            <div class="form-group col-md-6">
                                <label >BTC Amount</label>
                                <input type="text" class="form-control" name="btc" id="btc" >
                            </div>
                            <div class="form-group col-md-6">
                                <label>ETH Amount</label>
                                <input type="text" class="form-control" name="eth" id="eth" >
                            </div>
                            <div class="form-group col-md-6">
                                <label>USDT Amount</label>
                                <input type="text" class="form-control" name="usdt" id="usdt" >
                            </div>

                            <div class="form-group col-md-6">
                                <label>GIFT Amount</label>
                                <input type="text" class="form-control" name="icotoken" id="icotoken">
                            </div>
                        </div>
                        <div class="form-group col-md-6 pull-right">

                            <button type="button" class="btn btn-blue pull-right" data-dismiss="modal" style="margin: 5px">Close</button>&nbsp;
                            <button type="submit" class="btn btn-danger pull-right" style="margin: 5px;">Submit</button>&nbsp;&nbsp;

                        </div><br><br>
                        <?php echo e(csrf_field()); ?>

                    </form>
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
            var url = document.getElementById('url').value;
            var anchor = document.getElementById('bal_tooltip');
            $.getJSON(url+"/total_userbalance",function(result){
                anchor.title = 'Total BTC: '+result.BTC+

                    ' Admin BTC: '+result.Admin_BTC+'\nTotal ETH: '+result.ETH+
                    ' Admin ETH: '+result.Admin_ETH+'\nTotal GIFT: '+result.GIFT+
                    ' Admin USDT: '+result.Admin_USDT+'\nTotal GIFT: '+result.GIFT+
                    ' Admin GIFT: '+result.Admin_GIFT;
            });
            var myTable = $('#myTable').DataTable({
                "paging":   false,
                "ordering": false,
                "info":     false,
                "searching": false
            });

        });

        function update_userbal(user_id,name,btc,eth,usdt,icotoken)
        {
            var User_id = document.getElementById('user_id');
            var User_name = document.getElementById('user_name');
            User_name.value = name;
            User_id.value = user_id;
            var Btc = document.getElementById('btc');
            var Eth = document.getElementById('eth');
            var Usdt = document.getElementById('usdt');
            var Xdce = document.getElementById('icotoken');
            var header = document.getElementById('header');
            header.innerHTML = "Edit "+name+" Balance";
            Btc.placeholder = btc;
            Btc.value = btc;
            Xdce.placeholder = icotoken;
            Xdce.value = icotoken;
            Eth.placeholder = eth;
            Eth.value = eth;
            Usdt.placeholder = usdt;
            Usdt.value = usdt;
            $('#update_user').modal('show');


        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("panel.layout.admin_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>