<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/dash.css">
    <style type="text/css">
        .button.disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }


    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div style="width:95%; margin:0 auto;">
        <div class="col-xs-12 center-xs">
            <div>
                <br>
            </div>
            <ul class="progress">
                <li class="stage-1 progress__circle"></li>
                <li class="progress__bar progress--done actcc1">
                    <div class="mat-progress-bar-background mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-buffer mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-primary mat-progress-bar-fill mat-progress-bar-element" style="transform: scaleX(0);"></div>
                    <div class="mat-progress-bar-secondary mat-progress-bar-fill mat-progress-bar-element"></div>
                    <div class="overlay">
                        <span class="actccsp font-sss">+100% bonus<span class="actccst">*</span></span>
                        <small class="actccsm">1 – 24,000,000</small>
                    </div>
                </li>


                <li class="stage-space"></li>
                <li class="stage-2 progress__circle"></li>
                <li class="progress__bar progress--done">
                    <div class="mat-progress-bar-background mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-buffer mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-primary mat-progress-bar-fill mat-progress-bar-element" style="transform: scaleX(0);"></div>
                    <div class="mat-progress-bar-secondary mat-progress-bar-fill mat-progress-bar-element"></div>
                    <div class="overlay">
                        <span>+50% bonus<span class="smalls">*</span></span>
                        <small class="cdmd1">24,000,001 – 72,000,000</small>
                        <small class="cdmd">Purchase From 24,000,001 JCASH – 72,000,000 JCASH</small>
                    </div>
                </li>
                <li class="stage-3 progress__circle"></li>
                <li class="progress__bar">
                    <div class="mat-progress-bar-background mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-buffer mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-primary mat-progress-bar-fill mat-progress-bar-element" style="transform: scaleX(0);"></div>
                    <div class="mat-progress-bar-secondary mat-progress-bar-fill mat-progress-bar-element"></div>
                    <div class="overlay">
                        <span>+25% bonus<span class="smalls">*</span></span>
                        <small class="cdmd1">72,000,001 – 120,000,000</small>
                        <small class="cdmd">Purchase From 72,000,001 JCASH – 120,000,000 JCASH</small>
                    </div>
                </li>
                <li class="stage-4 progress__circle"></li>
                <li class="progress__bar">
                    <div class="mat-progress-bar-background mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-buffer mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-primary mat-progress-bar-fill mat-progress-bar-element" style="transform: scaleX(0);"></div>
                    <div class="mat-progress-bar-secondary mat-progress-bar-fill mat-progress-bar-element"></div>
                    <div class="overlay">
                        <span>+20% bonus<span class="smalls">*</span></span>
                        <small class="cdmd1">120,000,001 – 156,000,000</small>
                        <small class="cdmd">Purchase From 120,000,001 JCASH – 156,000,000 JCASH</small>
                    </div>
                </li>
                <li class="stage-5 progress__circle"></li>
                <li class="progress__bar">
                    <div class="mat-progress-bar-background mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-buffer mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-primary mat-progress-bar-fill mat-progress-bar-element" style="transform: scaleX(0);"></div>
                    <div class="mat-progress-bar-secondary mat-progress-bar-fill mat-progress-bar-element"></div>
                    <div class="overlay">
                        <span>+15% bonus<span class="smalls">*</span></span>
                        <small class="cdmd1">156,000,001 – 192,000,000</small>
                        <small class="cdmd">Purchase From 156,000,001 JCASH – 192,000,000 JCASH</small>
                    </div>
                </li>
                <li class="stage-6 progress__circle"></li>
                <li class="progress__bar">
                    <div class="mat-progress-bar-background mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-buffer mat-progress-bar-element"></div>
                    <div class="mat-progress-bar-primary mat-progress-bar-fill mat-progress-bar-element" style="transform: scaleX(0);"></div>
                    <div class="mat-progress-bar-secondary mat-progress-bar-fill mat-progress-bar-element"></div>
                    <div class="overlay">
                        <span>+10% bonus<span class="smalls">*</span></span>
                        <small class="cdmd1">192,000,001 – 224,000,000</small>
                        <small class="cdmd">Purchase From 192,000,001 JCASH – 224,000,000 JCASH</small>
                    </div>
                </li>
                <li class="stage-6 progress__circle discv"></li>
            </ul>

            <p class="text-right" style="margin:0;">*Minimum Purchase 25,000 JCASH</p>

        </div>
    </div>
    <section class="login-container container-fluid">
        <div class="container lg-wpr">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="timeddss">
                                <ul>
                                    <li>1 BTC = <?php echo e($data['BTC_jcash']); ?> JCASH </li>
                                    <li>1 ETH = <?php echo e($data['ETH_jcash']); ?> JCASH</li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="timeddss">
                                <div class="countdown-box animated fadeInUp" data-animate="fadeInUp" data-delay=".3" style="visibility: visible; animation-delay: 0.3s;">
                                    <img class="flag-t" src="<?php echo e(URL::asset('front')); ?>/assets/images/sig.png" alt="">
                                    <h3 class="dif1">Presale Ending in</h3>
                                    <div class="token-countdown text-center d-flex align-content-stretch" data-date="2018/05/18 11:00:00">
                                        <div class="col">
                                            <span id="days" class="countdown-time countdown-time-first">00</span>
                                            <span class="countdown-text">Days</span></div><div class="col">
                                            <span id="hours" class="countdown-time">22</span>
                                            <span class="countdown-text">Hours</span>
                                        </div><div class="col"><span id="minutes" class="countdown-time">36</span>
                                            <span class="countdown-text">Minutes</span>
                                        </div>
                                        <div class="col">
                                            <span id="seconds" class="countdown-time countdown-time-last">09</span>
                                            <span class="countdown-text">Seconds</span>
                                        </div>
                                    </div><!-- <a href="#" class="btn btn-alt btn-sm">Join &amp; BUY TOKEN NOW</a> --></div>
                            </div>
                        </div>


                    </div>





                    <div class="row">
                        <div class="col-md-7">
                            <div class="row event-info">
                                <div class="col-sm-6 main-bx">
                                    <div class="event-single-info animated mbre fadeInUp" data-animate="fadeInUp" data-delay="0" style="visibility: visible;">
                                        <h5 class="m-0">JCASH</h5>
                                        <p>1 JCash = 0.20 USD</p>
                                    </div>
                                </div>

                                <div class="col-sm-6 main-bx">
                                    <div class="mbre1">
                                        <div class="event-single-info animated fadeInUp" data-animate="fadeInUp" data-delay=".1" style="visibility: visible; animation-delay: 0.1s;">
                                            <h5 class="m-0">JCASH SOLD</h5>
                                            <p><img src="<?php echo e(URL::asset('front')); ?>/assets/images/jsd.png" class="igm" alt=""> <?php echo e($data['JCASH']); ?> / <img src="<?php echo e(URL::asset('front')); ?>/assets/images/jsd.png" class="igm" alt=""> 224,000,000</p>
                                        </div>

                                        <div class="event-single-info animated mobioo fadeInUp" data-animate="fadeInUp" data-delay=".3" style="visibility: visible; animation-delay: 0.3s;">
                                            <h5 class="m-0">JCASH (Reward Pool)</h5>
                                            <p><img src="<?php echo e(URL::asset('front')); ?>/assets/images/jsd.png" class="igm" alt="">  <?php echo e($data['JCASH_Reward']); ?> / <img src="<?php echo e(URL::asset('front')); ?>/assets/images/jsd.png" class="igm" alt=""> 935,800,000</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 main-bx">
                                    <div class="event-single-info animated mobilss fadeInUp" data-animate="fadeInUp" data-delay=".2" style="visibility: visible; animation-delay: 0.2s;">
                                        <h5 class="m-0">Presale Start</h5>
                                        <p>	May 18, 2018 ,11:00 AM</p>
                                    </div>
                                </div>

                                <div class="col-sm-6 mobilss">
                                    <div class="event-single-info animated fadeInUp" data-animate="fadeInUp" data-delay=".3" style="visibility: visible; animation-delay: 0.3s;">
                                        <h5 class="m-0">JCASH (Reward Pool)</h5>
                                        <p><img src="<?php echo e(URL::asset('front')); ?>/assets/images/jsd.png" class="igm" alt=""> <?php echo e($data['JCASH_Reward']); ?> / <img src="<?php echo e(URL::asset('front')); ?>/assets/images/jsd.png" class="igm" alt=""> 935,800,000</p>
                                    </div>
                                </div>

                                <div class="col-sm-6 mobilss">
                                    <div class="event-single-info animated fadeInUp" data-animate="fadeInUp" data-delay=".4" style="visibility: visible; animation-delay: 0.4s;">
                                        <h5 class="m-0">Presale End</h5>
                                        <p>Jul 10, 2018 ,11:00 AM</p>
                                    </div>
                                </div>

                                <div class="col-sm-6 mobilss">
                                    <div class="event-single-info animated fadeInUp" data-animate="fadeInUp" data-delay=".5" style="visibility: visible; animation-delay: 0.5s;">
                                        <h5 class="m-0">Payment Accepted</h5>
                                        <p>BTC / ETH / FIAT</p>
                                    </div>
                                </div>



                                <div class="clearfix"></div>
                                <div class="col-sm-12 mobilss">
                                    <div class="timeddss1">
                                        <h2>CURRENT BONUS : <?php echo e($data['Bonus']); ?>%</h2>
                                        <p>* Minimum purchase of 25,000 JCASH to be eligible for bonus</p>
                                        <p>* Purchases of more than 1,000,00 JCASH will have their tokens locked up for</p><p> &nbsp;&nbsp; 3 months.</p>
                                        <p>* Exchange rates are taken from Bitfinex and are refreshed every 10 minutes.</p>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-5">
                            <div class="login-wpr pull-right clearfix">
                                <div class="login-top"><h2 align="left" class="reg-heading">Minimum Contribution : 200 USD</h2>
                                    <p align="left" class="reg-sub-heading">Buy JCASH with</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="nav nav-pills">
                                            <li class="active"><a href="#1b" data-toggle="tab" class="active btn btn-block">ETH</a></li>
                                            <li><a href="#2b" data-toggle="tab" class="btn btn-block">BTC</a></li>
                                            <li style=" margin-right: 0;"><a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-block" style="color:#000;">FIAT</a></li>
                                        </ul>
                                    </div>
                                    <div class="tab-content clearfix">
                                        <div class="tab-pane active" id="1b">
                                            <form id="eth_form" action="<?php echo e(url('/ico_buy')); ?>" method="post">
                                                <?php echo e(csrf_field()); ?>

                                            <div class="col-md-12">
                                                <div class="form-group leftsd">
                                                    <label>ETH</label>
                                                    <input id="second_currency" name="second_currency" value="ETH" style="display: none">
                                                    <input id="first_currency" name="first_currency" value="JCASH" style="display: none">
                                                    <input id="ETH_second_currency_price"  name="second_currency_price"  value="<?php echo e($data['minETH']); ?>" onkeyup="convert_price(this.value,'ETH')" placeholder="Amount" class="form-control input-lg">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="timeddss2">
                                                    <ul>
                                                        <input id="ETH_first_currency_price" name="first_currency_price"  style="display: none">
                                                        <li>JCASH TOTAL <p id="ejcash_total" >25000.00</p></li>
                                                        <li>BONUS <p id="ejcash_bonus" >25000.00</p></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>

                                                <div class="col-md-12">
                                                    <div class="form-group leftsd">
                                                        <input id="jcash_id" type="text" name="jcash_id" placeholder="JCash Id(Download JiojioMe app to find your id )" class="form-control input-lg">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="contennt1">
                                                        <h2><a href="https://www.youtube.com/watch?v=ju2TslF9HrU&feature=youtu.be" target="_blank">How do i get my JCASH ID?</a><p></p>
                                                            <p><input id="checkBox" type="checkbox" onchange="activateButton(this,'ETH')">I have read and agree with the<a href="<?php echo e(url('/terms')); ?>"> Terms & Condition</a> </p>

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
                                                    <input id="first_currency" name="first_currency" value="JCASH" style="display: none">
                                                    <label>BTC</label>
                                                    <input id="BTC_second_currency_price"  name="second_currency_price" value="<?php echo e($data['minBTC']); ?>" onkeyup="convert_price(this.value,'BTC')" placeholder="Amount" class="form-control input-lg">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="timeddss2">
                                                    <ul>
                                                        <input id="BTC_first_currency_price" name="first_currency_price"  style="display: none">
                                                        <li>JCASH TOTAL <p id="bjcash_total" >25000.00</p></li>
                                                        <li>BONUS <p id="bjcash_bonus" >25000.00</p></li>
                                                    </ul>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                                <div class="col-md-12">
                                                    <div class="form-group leftsd">
                                                        <input id="jcash_id" type="text" name="jcash_id" placeholder="JCash Id(Download JiojioMe app to find your id )" class="form-control input-lg">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="contennt1">
                                                        <h2><a href="https://www.youtube.com/watch?v=ju2TslF9HrU&feature=youtu.be" target="_blank">How do i get my JCASH ID?</a><p></p>
                                                            <p><input id="checkBox" type="checkbox"  onchange="activateButton(this,'BTC')"> I have read and agree with the <a href="<?php echo e(url('/terms')); ?>">Terms & Condition</a></p>

                                                            <p><button id="btc_button" type="submit" name="Submit" value="Contribute" class="submit-btn" disabled="true" >CONTRIBUTE</button></p>
                                                        </h2></div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>






                                </div>
                            </div>
                        </div>

                    </div>





                </div>
            </div>




    </section>


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute;">FIAT</h4>
                </div>
                <div align="center" class="modal-body">
                    <p align="left"><strong>Email us:</strong> <a href="mailto:info@jiojioMe">info@jiojio.me</a></p>
                    <p align="left"><strong>Contact us :</strong> (+65) 86669177</p>
                    <p align="left"><strong>Telegram us :</strong> <a href="http://www.t.me/tanlester">www.t.me/tanlester</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('xscript'); ?>
    <script src="<?php echo e(URL::asset('front')); ?>/assets/js/prefixfree.min.js"></script>




    <script type="text/javascript">
        window.setInterval(function ()
        {
            get_usd_price();
        }, 300000);

        var minETH =0;
        var minBTC =0;
         minETH = <?php echo e($data['minETH']); ?>;
         minBTC = <?php echo e($data['minBTC']); ?>;

        $.validator.addMethod('minval', function (value, element) {
            return this.optional(element) || (value > minBTC);
        }, "Please enter a correct number");

        $.validator.addMethod('adecimal', function (value, element) {
            return this.optional(element) || (value > 0);
        }, "Please enter a correct number");

        $("#btc_form").validate(
            {
                rules:
                    {
                        second_currency_price:{required:true,number: true,minval: true,adecimal: true},
                        jcash_id:{required:true,regex:'^[0-9a-zA-Z]+$'},

                    },
                messages:
                    {

                        second_currency_price:{required:'Amount is required',number:'Enter valid number',minval: 'Minimum Amount is '+minBTC,adecimal:'Only decimals allowed'},
                        jcash_id: { required:'JCash Id is required',regex:'Enter valid JCashId'},

                    }
            });

        $("#eth_form").validate(
            {
                rules:
                    {
                        second_currency_price:{required:true,number: true,min: minETH, adecimal: true,},
                        jcash_id:{required:true,regex:'^[0-9a-zA-Z]+$'},
                    },
                messages:
                    {
                        second_currency_price:{required:'Amount is required',number:'Enter valid number',minval: 'Minimum Amount is '+minETH,adecimal:'Only decimals allowed'},
                        jcash_id: { required:'JCash Id is required',regex:'Enter valid JCashId'},
                    }
            });

        function activateButton(element,currency) {

            if (element.checked) {
                if(currency =='ETH')
                {
                    document.getElementById("eth_button").disabled = false;
                }
                else
                    {
                        document.getElementById("btc_button").disabled = false;
                    }

            }
            else {

                if(currency =='ETH')
                {
                    document.getElementById("eth_button").disabled = true;
                }
                else
                {
                    document.getElementById("btc_button").disabled = true;
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
        function get_usd_price()
        {
            console.log('er');
            $.ajax({
                url:'https://jcash.jiojio.io/ajax/get_usd_price',
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
            else
                {
                    cnv = btc_usd;
                }
            console.log(cnv);
            var ourcnv=jcash_usd;

            var inusd=cnv*price;
            if((inusd/ourcnv)>=25000){
                var jcash=inusd/ourcnv;
                var jcashbonus=inusd/ourcnv;
            }else{
                var jcash=inusd/ourcnv;
                var jcashbonus=0;
            }

            if(currency === 'ETH')
            {
                $('#ejcash_total').html(jcash);
                $('#ejcash_bonus').html(jcashbonus);
                $('#ETH_first_currency_price').val(jcash);
            }
            else
            {
                $('#bjcash_total').html(jcash);
                $('#bjcash_bonus').html(jcashbonus);
                $('#BTC_first_currency_price').val(jcash);
            }

        }

    </script>

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("Jul 10, 2018 15:37:25").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("days").innerHTML = days;
            document.getElementById("hours").innerHTML = hours;
            document.getElementById("minutes").innerHTML = minutes;
            document.getElementById("seconds").innerHTML = seconds;


            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.jcash_front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>