<?php $__env->startSection('content'); ?>
    <!-- BEGIN CONTENT -->
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
            <div class="main-content" ui-view="">
                <!-- BEGIN PAGE TITLE-->
                <!--<h1 class="page-title">
                    Admin Dashboard 2
                    <small>statistics, charts, recent events and reports</small>
                </h1>-->
                <!-- END PAGE TITLE-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title"> Gravitas Platform Crowdsale</div>
                        <hr />
                    </div>
                </div>
                <div class="row md-3">
                    <!-- <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th> Token name </th>
                                    <th> Symbol </th>
                                    <th> Total issued </th>
                                    <th> Total for sale </th>
                                    <th> GIFT token price </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> Gravitas </td>
                                    <td> GIFT </td>
                                    <td> 2,500,000,000 GIFT </td>
                                    <td> 200,000,000 GIFT </td>
                                    <td> 0.02 $ </td>
                                </tr>
                                </tbody>
                            </table>
                        </div> -->

                        <div class="col-md-3 col-sm-6">
						<div class="card currency-card-rounded">
							<div class="card-body rounded bitcoin gradient-green">
								<div class="currency-card-icon mt-45 pull-right">
									<i class="fa fa-user-circle-o"><img src="<?php echo e(URL::asset('front')); ?>/assets/img/gravitas.png"></i>
								</div>
								<h5>Token name</h5>
								<h3>Gravitas</h3>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="card currency-card-rounded">
							<div class="card-body rounded bitcoin gradient-blue">
								<div class="currency-card-icon mt-45 pull-right">
									<i class="fa fa-user-circle-o"><img src="<?php echo e(URL::asset('front')); ?>/assets/img/gravitas.png"></i>
								</div>
								<h5>Symbol</h5>
								<h3>GIFT</h3>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="card currency-card-rounded">
							<div class="card-body rounded bitcoin gradient-orange">
								<div class="currency-card-icon mt-45 pull-right">
									<i class="fa fa-user-circle-o"><img src="<?php echo e(URL::asset('front')); ?>/assets/img/total-issued.png"></i>
								</div>
								<h5>Total issued</h5>
								<h3>2,500,000,000 GIFT</h3>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-6">
						<div class="card currency-card-rounded">
							<div class="card-body rounded bitcoin gradient-pink">
								<div class="currency-card-icon mt-45 pull-right">
									<i class="fa fa-user-circle-o"><img src="<?php echo e(URL::asset('front')); ?>/assets/img/total-sale.png"></i>
								</div>
								<h5>Total for sale</h5>
								<h3>200,000,000 GIFT</h3>
							</div>
						</div>
					</div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject bold uppercase font-dark">Contribute</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <p>Enter the number of Gravitas (GIFT) tokens you want to buy, choose a cryptocurrency, and see how much you would have to contribute. Alternatively, click on the arrow, enter the amount of cryptocurrency you'd like to spend, and see how many GIFT you'll receive.</p>
                                <p>The current bonus is automatically added to the selected number of tokens you choose to buy.</p>
                                <p>The final number of purchased tokens is calculated at the moment of the transaction, so the total purchase price in USD may change due to exchange rate fluctuations.</p>
                                <p>The exchange rate is updated every 5 minutes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-d-3 col-xs-12 col-sm-12">
                        <div class="portlet light ">
                            <div class="portlet-title ">
                                <div class="text-center">
                                    <span class="caption-subject font-dark bold uppercase">CURRENT GIFT TOKEN PRICE</span>
                                </div>
                            </div>
                            <div class="portlet-body text-center">
                                <p>
                                    0.02 USD
                                </p>
                                
                                    
                                
                                
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /PAGE CONTENT AAA-->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler">
        <i class="icon-login"></i>
    </a>

    <!-- END QUICK SIDEBAR -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('xscript'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    



    
    
    
    
    
    
    
    

    
    
    
    <script>
        function change_captcha()
        {
            $("#capimg").html('Loading....');
            $.post('<?php echo e(url("ajax/refresh_capcha")); ?>',function(data,result)
            {
                $("#capimg").html(data);
            });
        }


    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>

    <script type="text/javascript">
        $("#login_form").validate({
            rules:
                {
                    login_mail:{required:true,email:true,},
                    password:{required:true,},
                    captcha:{required:true,},
                },
            messages:
                {
                    login_mail:{required:'Email is required',email:'Enter valid email address',},
                    password:{required:'Password is required',},
                    captcha:{required:'Captha is required',},
                },
        });
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>