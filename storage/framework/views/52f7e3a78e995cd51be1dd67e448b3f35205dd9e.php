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


                        <div class="col-md-4">
                                        <!--<div class="timeddss">
                                            <ul>
                                                <li>1 ETH = 533.994  GIFT</li>
                                            </ul>
                                        </div>-->
                        <div class="card currency-card-rounded">
                            <div class="card-body rounded bitcoin">
                            <div class="currency-card-icon pull-right">
                                <i class="fa"><img src="<?php echo e(URL::asset('front')); ?>/assets/img/eth.png"></i>
                            </div>
                            <h2>
                                <span>1 ETH = </span> <?php echo e(number_format($data['ETH_icotoken'],3,'.','')); ?> GIFT
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
                        <div class="card-header">MINIMUM CONTRIBUTION : 100 USD</div>
                        <div class="col-md-12 pt-4">
                            <h4>Buy GIFT with</h4>
                        </div>
                        <div class="card-wrap">
                            <ul role="tablist" id="pills-tab" class="nav nav_tab">
                                <li class="nav-item"><a href="#1b" data-toggle="tab" class="nav-link active show">ETH</a></li>
                                
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
                                                                    <input id="first_currency" name="first_currency" value="GIFT" style="display: none">
                                                                    <input id="ETH_second_currency_price"  name="second_currency_price"  value="<?php echo e($data['minETH']); ?>" onKeyUp="convert_price(this.value,'ETH')" placeholder="Amount" class="form-control input-lg">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="timeddss2">
                                                                    <ul>
                                                                        <input id="ETH_first_currency_price" name="first_currency_price"  style="display: none">
                                                                        <li>GIFT TOTAL <p id="eicotoken_total" >25000.00</p></li>
                                                                        <li>BONUS <p id="eicotoken_bonus" >25000.00</p></li>
                                                                    </ul>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                    

                                                            <div class="col-md-12">
                                                                <div class="contennt1">
                                                                    <h2><p></p>
                                                                        <p><input id="checkBox" type="checkbox" onChange="activateButton(this,'ETH')"> I have read and agree with the<a href="#"> Terms & Condition</a> </p>

                                                                        <p><button id="eth_button" type="submit" name="submit" value="Contribute" class="submit-btn" disabled="true">CONTRIBUTE</button></p>
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
                                <h5 class="m-0">Payment Accepted</h5>
                                <p> ETH</p>
                                <div class="line"></div>
                            </div>
                        </div>

                        <!-- <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5> GIFT SOLD </h5>
                                <p><span><img src="<?php echo e(URL::asset('front')); ?>/assets/img/jsd.png" class="igm" alt=""> 2,000,000,000 / <img src="<?php echo e(URL::asset('front')); ?>/assets/img/jsd.png" class="igm" alt=""><?php echo e($data['GIFT']); ?></span></p>
                                <div class="line"></div>
                            </div>
                        </div> -->

                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5> Sale Start </h5>
                                <p> October 22, 2019</p>
                                <div class="line"></div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                            <div class="box_wrap bg-white text-center">
                                <h5 class="m-0">Sale End</h5>
                                <p>April 30, 2020</p>
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
        var minUSDT=0;
        // var minFIAT = 500;
        var balBtc =0;
        var balEth =0;
        var balUSDT=0;
        minETH = <?php echo e($data['minETH']); ?>;
        minBTC = <?php echo e($data['minBTC']); ?>;
        minUSDT = <?php echo e($data['minUSDT']); ?>;
        balBtc = <?php echo e($data['BTC']); ?>;
        balEth =  <?php echo e($data['ETH']); ?>;
        balUsdt =  <?php echo e($data['USDT']); ?>;

        $.validator.addMethod('minval', function (value, element) {
            return this.optional(element) || (value <= balBtc);
        }, "Please enter a correct number");

        $.validator.addMethod('minval1', function (value, element) {
            return this.optional(element) || (value <= balEth);
        }, "Please enter a correct number");
        $.validator.addMethod('minval2', function (value, element) {
            return this.optional(element) || (value <= balUsdt);
        }, "Please enter a correct number");

        $.validator.addMethod('adecimal', function (value, element) {
            return this.optional(element) || (value > 0);
        }, "Please enter a correct number");

        $("#btc_form").validate(
            {
                rules:
                    {
                        second_currency_price:{required:true,number: true,minval: true,min:minBTC,adecimal: true},
                        icotoken_id:{required:true,regex:'^[0-9a-zA-Z]+$'},

                    },
                messages:
                    {

                        second_currency_price:{required:'Amount is required',number:'Enter valid number',minval: 'Insufficient Balance',min: 'Minimum Amount is '+minBTC,adecimal:'Only decimals allowed'},
                        icotoken_id: { required:'FoodCode Id is required',regex:'Enter valid FoodCode Id'},

                    }
            });

        $("#eth_form").validate(
            {
                rules:
                    {
                        second_currency_price:{required:true,number: true,minval1: true,min:minETH, adecimal: true,},
                        icotoken_id:{required:true,regex:'^[0-9a-zA-Z]+$'},
                    },
                messages:
                    {
                        second_currency_price:{required:'Amount is required',number:'Enter valid number',minval1: 'Insufficient Balance',min: 'Minimum Amount is '+minETH,adecimal:'Only decimals allowed'},
                        icotoken_id: { required:'FoodCode Id is required',regex:'Enter valid FoodCode Id'},
                    }
            });


            $("#usdt_form").validate(
            {
                rules:
                    {
                        second_currency_price:{required:true,number: true,minval2: true,min:minUSDT, adecimal: true,},
                        icotoken_id:{required:true,regex:'^[0-9a-zA-Z]+$'},
                    },
                messages:
                    {
                        second_currency_price:{required:'Amount is required',number:'Enter valid number',minval2: 'Insufficient Balance',min: 'Minimum Amount is '+minUSDT,adecimal:'Only decimals allowed'},
                        icotoken_id: { required:'FoodCode Id is required',regex:'Enter valid FoodCode Id'},
                    }
            });


        // $("#fiat_form").validate(
        //     {
        //         rules:
        //             {
        //                 second_currency_price:{required:true,number: true,min:minFIAT, adecimal: true,},
        //                 icotoken_id:{required:true,regex:'^[0-9a-zA-Z]+$'},
        //             },
        //         messages:
        //             {
        //                 second_currency_price:{required:'Amount is required',number:'Enter valid number',min: 'Minimum Amount is '+minFIAT,adecimal:'Only decimals allowed'},
        //                 icotoken_id: { required:'ICOToken Id is required',regex:'Enter valid ICOTokenId'},
        //             }
        //     });

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
                else if(currency =='USDT')
                {
                    document.getElementById("usdt_button").disabled = false;
                }
                // else
                // {
                //     document.getElementById("fiat_button").disabled = false;
                // }

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
                else if(currency =='USDT')
                {
                    document.getElementById("usdt_button").disabled = true;
                }
                // else
                // {
                //     document.getElementById("fiat_button").disabled = true;
                // }

            }
        }

        $(document).ready(function () {

            get_usd_price();
        });
        var eth_usd;
        var btc_usd;
        var usdt_usd;
        var icotoken_usd;
        var CAP;
        var Bonus;
        var eth_price = $('#ETH_second_currency_price').val();
        var btc_price = $('#BTC_second_currency_price').val();
        var usdt_price = $('#USDT_second_currency_price').val();
        // var fiat_price = $('#FIAT_second_currency_price').val();
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
                    usdt_usd = result.USDT;
                    icotoken_usd = result.GIFT;
                    CAP = result.CAP;
                    Bonus = result.Bonus;
                    minETH = result.minETH;
                    minBTC = result.minBTC;
                    minUSDT=result.minUSDT;

                    convert_price(eth_price,'ETH');
                    convert_price(btc_price,'BTC');
                    convert_price(usdt_price,'USDT');
                    // convert_price(fiat_price,'FIAT');

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
            else if(currency === 'USDT')
            {
                cnv = usdt_usd;
            }

            var ourcnv=icotoken_usd;

            var inusd=cnv*price;
            if(currency === 'FIAT')
            {
                inusd = price;
            }
            var icotoken=(inusd/ourcnv)+(inusd/ourcnv*Bonus);
            var icotokenbonus=(inusd/ourcnv*Bonus);


            if(currency === 'ETH')
            {
                $('#eicotoken_total').html(icotoken.toFixed(2));
                $('#eicotoken_bonus').html(icotokenbonus.toFixed(2));
                $('#ETH_first_currency_price').val(icotoken.toFixed(2));
            }
            else if(currency === 'BTC')
            {
                $('#bicotoken_total').html(icotoken.toFixed(2));
                $('#bicotoken_bonus').html(icotokenbonus.toFixed(2));
                $('#BTC_first_currency_price').val(icotoken.toFixed(2));
            }
            else if(currency === 'USDT')
            {
                $('#uicotoken_total').html(icotoken.toFixed(2));
                $('#uicotoken_bonus').html(icotokenbonus.toFixed(2));
                $('#USDT_first_currency_price').val(icotoken.toFixed(2));
            }

            // else if(currency === 'FIAT')
            // {
            //     $('#ficotoken_total').html(icotoken.toFixed(2));
            //     $('#ficotoken_bonus').html(icotokenbonus.toFixed(2));
            //     $('#FIAT_first_currency_price').val(icotoken.toFixed(2));
            // }

        }

    </script>

    <script>
        function buyFiat()
        {

        }
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>