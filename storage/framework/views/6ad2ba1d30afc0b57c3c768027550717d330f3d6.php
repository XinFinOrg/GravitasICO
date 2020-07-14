<?php $__env->startSection('content'); ?>

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
                        <div class="section-title"> ICO Purchase</div>
                        <hr />
                    </div>
                </div>

               
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--<div class="timeddss">
                                            <ul>
                                                <li>1 BTC = 17404.500  CMB </li>
                                            </ul>
                                        </div>-->

                        <div class="card currency-card-rounded">
                         <div class="card-body rounded bitcoin">
                            <div class="currency-card-icon pull-right">
                                <i class="fa fa-user-circle-o"><img src="<?php echo e(URL::asset('front')); ?>/assets/img/btc1.png"></i>
                            </div>
                            <h2>
                                <span>1 BTC = </span> <?php echo e(number_format($data['BTC_jcash'],3,'.','')); ?> GIFT
                            </h2>
                         </div>

                         </div>
                    </div>

                        <div class="col-md-6">
                                        <!--<div class="timeddss">
                                            <ul>
                                                <li>1 ETH = 533.994  CMB</li>
                                            </ul>
                                        </div>-->
                        <div class="card currency-card-rounded">
                            <div class="card-body rounded bitcoin">
                            <div class="currency-card-icon pull-right">
                                <i class="fa"><img src="<?php echo e(URL::asset('front')); ?>/assets/img/eth.png"></i>
                            </div>
                            <h2>
                                <span>1 ETH = </span> <?php echo e(number_format($data['ETH_jcash'],3,'.','')); ?> GIFT
                            </h2>
                            </div>
                        </div>
                        </div>


                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet light">
                            <div class="portlet-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="timeddss1">
                                            <h2>CURRENT BONUS : <?php echo e($data['Bonus']); ?>%</h2>
                                        </div>
                                    </div>

                                </div>





                <div class="row align-items-center large_space">
                   <div class="col-lg-6 col-md-12">
                    <div class="card mb-4 mycard">
                        <div class="card-header">MINIMUM CONTRIBUTION : 500 USD</div>
                        <div class="col-md-12 pt-4">
                            <h4>Buy GIFT with</h4>
                        </div>
                        <div class="card-wrap">
                            <ul role="tablist" id="pills-tab" class="nav nav_tab">
                                <li class="nav-item"><a href="#1b" data-toggle="tab" class="nav-link active show">ETH</a></li>
                                <li class="nav-item"><a href="#2b" data-toggle="tab" class="nav-link">BTC</a></li>
                                <li class="nav-item"><a href="#3b" data-toggle="tab" class="nav-link">FIAT</a></li>
                            </ul>
                            <div class="tab-content card-body">
                                <div class="tab-content clearfix">
                                                    <div class="tab-pane active" id="1b">
                                                        <form id="eth_form" action="<?php echo e(url('/ico_buy')); ?>" method="post">
                                                            <?php echo e(csrf_field()); ?>

                                                            <div class="col-md-12">
                                                                <div class="form-group leftsd">
                                                                    <label>ETH</label>
                                                                    <input id="second_currency" name="second_currency" value="ETH" style="display: none">
                                                                    <input id="first_currency" name="first_currency" value="CMB" style="display: none">
                                                                    <input id="ETH_second_currency_price"  name="second_currency_price"  value="<?php echo e($data['minETH']); ?>" onKeyUp="convert_price(this.value,'ETH')" placeholder="Amount" class="form-control input-lg">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="timeddss2">
                                                                    <ul>
                                                                        <input id="ETH_first_currency_price" name="first_currency_price"  style="display: none">
                                                                        <li>GIFT TOTAL <p id="ejcash_total" >25000.00</p></li>
                                                                        <li>BONUS <p id="ejcash_bonus" >25000.00</p></li>
                                                                    </ul>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="contennt1">
                                                                    <h2><p></p>
                                                                        <p><input id="checkBox" type="checkbox" onChange="activateButton(this,'ETH')"> I have read and agree with the<a href="<?php echo e(URL::asset('front')); ?>/assets2/pdf/creatanium_website_terms.pdf"> Terms & Condition</a> </p>

                                                                        <p><button id="eth_button" type="submit" name="submit" value="Contribute" class="submit-btn" disabled="true">CONTRIBUTE</button></p>
                                                                    </h2></div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="2b">
                                                        <form id="btc_form" action="<?php echo e(url('/ico_buy')); ?>" method="post">
                                                            <?php echo e(csrf_field()); ?>

                                                            <div class="col-md-12">
                                                                <div class="form-group leftsd">
                                                                    <input id="second_currency" name="second_currency" value="BTC" style="display: none">
                                                                    <input id="first_currency" name="first_currency" value="CMB" style="display: none">
                                                                    <label>BTC</label>
                                                                    <input id="BTC_second_currency_price"  name="second_currency_price" value="<?php echo e($data['minBTC']); ?>" onKeyUp="convert_price(this.value,'BTC')" placeholder="Amount" class="form-control input-lg">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="timeddss2">
                                                                    <ul>
                                                                        <input id="BTC_first_currency_price" name="first_currency_price"  style="display: none">
                                                                        <li>GIFT TOTAL <p id="bjcash_total" >25000.00</p></li>
                                                                        <li>BONUS <p id="bjcash_bonus" >25000.00</p></li>
                                                                    </ul>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="contennt1">
                                                                    <h2><p></p>
                                                                        <p><input id="checkBox" type="checkbox"  onchange="activateButton(this,'BTC')"> I have read and agree with the <a href="#">Terms & Condition</a></p>

                                                                        <p><button id="btc_button" type="submit" name="Submit" value="Contribute" class="submit-btn" disabled="true" >CONTRIBUTE</button></p>
                                                                    </h2></div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="3b">
                                                        <form id="fiat_form" action="#" method="post">
                                                            <?php echo e(csrf_field()); ?>

                                                            <div class="col-md-12">
                                                                <div class="form-group leftsd">
                                                                    <input id="second_currency" name="second_currency" value="FIAT" style="display: none">
                                                                    <input id="first_currency" name="first_currency" value="CMB" style="display: none">
                                                                    <label>FIAT</label>
                                                                    <input id="FIAT_second_currency_price"  name="second_currency_price" value="500" onKeyUp="convert_price(this.value,'FIAT')" placeholder="Amount" class="form-control input-lg">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="timeddss2">
                                                                    <ul>
                                                                        <input id="FIAT_first_currency_price" name="first_currency_price"  style="display: none">
                                                                        <li>GIFT TOTAL <p id="fjcash_total" >25000.00</p></li>
                                                                        <li>BONUS <p id="fjcash_bonus" >25000.00</p></li>
                                                                    </ul>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="contennt1">
                                                                    <h2><p></p>
                                                                        <p><input id="checkBox" type="checkbox"  onchange="activateButton(this,'FIAT')"> I have read and agree with the <a href="#">Terms & Condition</a></p>

                                                                        <p><button type="button" id="fiat_button" data-toggle="modal" data-target="#fiatModal" class="submit-btn" disabled="true" >CONTRIBUTE</button></p>
                                                                    </h2></div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5> GIFT </h5>
                                <p> 1 GIFT = 0.02 USD </p>
                                <div class="line"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5> GIFT SOLD </h5>
                                <p><span><img src="<?php echo e(URL::asset('front')); ?>/assets/img/jsd.png" class="igm" alt=""> 2,000,000,000 / <img src="<?php echo e(URL::asset('front')); ?>/assets/img/jsd.png" class="igm" alt=""><?php echo e($data['JCASH'] + 53449675.06 + 9872409); ?></span></p>
                                <div class="line"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5> Sale Start </h5>
                                <p> August 1, 2018</p>
                                <div class="line"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5 class="m-0">Sale End</h5>
                                <p>August 30, 2018</p>
                                <div class="line"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5 class="m-0">Payment Accepted</h5>
                                <p> BTC / ETH </p>
                                <div class="line"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5 class="m-0">Not Able to Buy Coin</h5>
                                <p><a href="<?php echo e(url('/contact_us')); ?>">click here</a></p>
                                <div class="line"></div>
                            </div>
                            </div>
                         </div>
                        </div>
                      </div>


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
    <!-- Modal -->
    <div id="fiatModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">FIAT Deposit</h4>
                </div>
                <div class="modal-body">
                    <p>You have to deposit respective FIAT amount to the below mentioned Account by IMPS <br>
                        Once you have successfully deposited amount to the below mentioned account,<br>
                        you will have to Email us to support@plmp-fintech.com.sg with all your transaction details along with your Creatanium Account details such
                        as transaction id which you will get from your transaction history.<br><br>
                        <strong>NAME :</strong> PLMP FINTECH PTE LTD<br>
                        <strong>ADDRESS : </strong>23, SERANGOON NORTH AVE 5, #05-01, SINGAPORE S554530<br>
                        <strong>ACCOUNT NUMBER :</strong><br>
                        5 80 017436 09 (SGD)<br>
                        5 75 017437 09 (USD)<br>
                        <strong>SWIFT CODE :</strong> RHBBSGSG<br>
                        <strong>BANK NAME :</strong> RHB BANK BERHAD<br>
                        <strong>BANK CODE :</strong> 7366<br>
                        <strong>BRANCH CODE :</strong> 005
                    </p>


                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('xscript'); ?>
    <link rel="stylesheet"
          href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <script type="text/javascript"
            src="https://code.jquery.com/jquery.min.js"></script>
    <script
            src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    <script type="text/javascript">
        window.setInterval(function ()
        {
            get_usd_price();
        }, 300000);

        var minETH =0;
        var minBTC =0;
        var minFIAT = 500;
        var balBtc =0;
        var balEth =0;
        minETH = <?php echo e($data['minETH']); ?>;
        minBTC = <?php echo e($data['minBTC']); ?>;
        balBtc = <?php echo e($data['BTC']); ?>;
        balEth =  <?php echo e($data['ETH']); ?>;

        $.validator.addMethod('minval', function (value, element) {
            return this.optional(element) || (value <= balBtc);
        }, "Please enter a correct number");

        $.validator.addMethod('minval1', function (value, element) {
            return this.optional(element) || (value <= balEth);
        }, "Please enter a correct number");

        $.validator.addMethod('adecimal', function (value, element) {
            return this.optional(element) || (value > 0);
        }, "Please enter a correct number");

        $("#btc_form").validate(
            {
                rules:
                    {
                        second_currency_price:{required:true,number: true,minval: true,min:minBTC,adecimal: true},
                        jcash_id:{required:true,regex:'^[0-9a-zA-Z]+$'},

                    },
                messages:
                    {

                        second_currency_price:{required:'Amount is required',number:'Enter valid number',minval: 'Insufficient Balance',min: 'Minimum Amount is '+minBTC,adecimal:'Only decimals allowed'},
                        jcash_id: { required:'JCash Id is required',regex:'Enter valid JCashId'},

                    }
            });

        $("#eth_form").validate(
            {
                rules:
                    {
                        second_currency_price:{required:true,number: true,minval1: true,min:minETH, adecimal: true,},
                        jcash_id:{required:true,regex:'^[0-9a-zA-Z]+$'},
                    },
                messages:
                    {
                        second_currency_price:{required:'Amount is required',number:'Enter valid number',minval1: 'Insufficient Balance',min: 'Minimum Amount is '+minETH,adecimal:'Only decimals allowed'},
                        jcash_id: { required:'JCash Id is required',regex:'Enter valid JCashId'},
                    }
            });

        $("#fiat_form").validate(
            {
                rules:
                    {
                        second_currency_price:{required:true,number: true,min:minFIAT, adecimal: true,},
                        jcash_id:{required:true,regex:'^[0-9a-zA-Z]+$'},
                    },
                messages:
                    {
                        second_currency_price:{required:'Amount is required',number:'Enter valid number',min: 'Minimum Amount is '+minFIAT,adecimal:'Only decimals allowed'},
                        jcash_id: { required:'JCash Id is required',regex:'Enter valid JCashId'},
                    }
            });

        function activateButton(element,currency) {

            if (element.checked) {
                if(currency =='ETH')
                {
                    document.getElementById("eth_button").disabled = false;
                }
                else if(currency =='BTC')
                {
                    document.getElementById("btc_button").disabled = false;
                }
                else
                {
                    document.getElementById("fiat_button").disabled = false;
                }

            }
            else {

                if(currency =='ETH')
                {
                    document.getElementById("eth_button").disabled = true;
                }
                else if(currency =='BTC')
                {
                    document.getElementById("btc_button").disabled = true;
                }
                else
                {
                    document.getElementById("fiat_button").disabled = true;
                }

            }
        }

        $(document).ready(function () {

            get_usd_price();
        });
        var eth_usd;
        var btc_usd;
        var jcash_usd;
        var CAP;
        var Bonus;
        var eth_price = $('#ETH_second_currency_price').val();
        var btc_price = $('#BTC_second_currency_price').val();
        var fiat_price = $('#FIAT_second_currency_price').val();
        function get_usd_price()
        {
            console.log('er');
            $.ajax({
                url:'<?php echo e(url('/ajax')); ?>/get_usd_price',
                type:'get',
                success:function(data)
                {

                    var result = JSON.parse(data);
                    console.log(result);
                    eth_usd = result.ETH;
                    btc_usd = result.BTC;
                    jcash_usd = result.JCASH;
                    CAP = result.CAP;
                    Bonus = result.Bonus;
                    minETH = result.minETH;
                    minBTC = result.minBTC;

                    convert_price(eth_price,'ETH');
                    convert_price(btc_price,'BTC');
                    convert_price(fiat_price,'FIAT');

                }
            });
        }

        function convert_price(price,currency)
        {
            console.log(price);
            var cnv;
            if(currency === 'ETH')
            {

                cnv = eth_usd;
            }
            else if(currency === 'BTC')
            {
                cnv = btc_usd;
            }

            var ourcnv=jcash_usd;

            var inusd=cnv*price;
            if(currency === 'FIAT')
            {
                inusd = price;
            }
            var jcash=(inusd/ourcnv)+(inusd/ourcnv*Bonus);
            var jcashbonus=(inusd/ourcnv*Bonus);


            if(currency === 'ETH')
            {
                $('#ejcash_total').html(jcash.toFixed(2));
                $('#ejcash_bonus').html(jcashbonus.toFixed(2));
                $('#ETH_first_currency_price').val(jcash.toFixed(2));
            }
            else if(currency === 'BTC')
            {
                $('#bjcash_total').html(jcash.toFixed(2));
                $('#bjcash_bonus').html(jcashbonus.toFixed(2));
                $('#BTC_first_currency_price').val(jcash.toFixed(2));
            }

            else if(currency === 'FIAT')
            {
                $('#fjcash_total').html(jcash.toFixed(2));
                $('#fjcash_bonus').html(jcashbonus.toFixed(2));
                $('#FIAT_first_currency_price').val(jcash.toFixed(2));
            }

        }

    </script>

    <script>
        function buyFiat()
        {

        }
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>