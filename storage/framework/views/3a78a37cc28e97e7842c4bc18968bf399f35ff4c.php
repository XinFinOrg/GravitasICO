<?php $__env->startSection('content'); ?>
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="col-md-12">
                <h1 align="center">KYC Verification</h1>
                <div class="boxwit">
                    <form id="kyc" method="post" action="<?php echo e(url('/kyc')); ?>" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <div class="notepsc">
                            <p><strong>Note:</strong></p>
                            <p>Please make sure you use your real identity to do this verification. We will protect your personal information. </p>
                            <p> you can use any one of the below metioned document for kyc verification:
                            <p> 1.Passport </p>
                            <p> 2.Driver's License </p>
                            <p> 3.National ID Card </p>
                            <p> Please make sure that the name is as per passport or the document you are submitting.</p>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input id="first_name" type="text" name="first_name" value="" placeholder="First Name" class="form-control input-lg">
                                </div>

                                <div class="form-group">
                                    <input id="last_name" type="text" name="last_name" value="" placeholder="Last Name" class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!-- <label><strong>Country:&nbsp; &nbsp;&nbsp; </strong></label> -->
                                    <select name="country_id" id="country_id" class="form-control " onchange="set_country()">
                                        <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($val->id); ?>" <?php if($val->id==old('country_id')): ?> selected
                                                    <?php endif; ?> data-id="<?php echo e(strtolower($val->iso)); ?>"><?php echo e($val->nicename); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-12 ">
                                <label><strong>Identity Card Front Side:</strong></label><br>
                                <input type="file" accept="image/*" name="f_side" id="f_side">
                                <br>
                                <span>Please make sure that the photo is complete and clearly visible, in JPG format.
										</span>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <canvas id="cf_side" class="boxsixe" style="border:1px solid #d3d3d3;background:#ffffff;">
                                        </canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <span style="padding-toptop: 250px">example</span>
                                        <img width="350" height="250" style="border:1px solid #d3d3d3;" src="<?php echo e(URL::asset('front')); ?>/assets/images/idcard-f.jpg">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12 ">
                                <label><strong>Identity Card Back Side:</strong></label><br>
                                <input type="file" accept="image/*" name="b_side" id="b_side">
                                <br>
                                <span>Please make sure that the photo is complete and clearly visible, in JPG format. Id card must be in the valid period</span>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <canvas id="cb_side" class="boxsixe" style="border:1px solid #d3d3d3;background:#ffffff;">
                                        </canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <span style="padding-toptop: 250px">example</span>
                                        <img width="350" height="250" style="border:1px solid #d3d3d3;" src="<?php echo e(URL::asset('front')); ?>/assets/images/idcard-b.jpg">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-md-12 ">
                                <label><strong>Selfie With Photo ID And Note:</strong></label><br>
                                <input type="file" accept="image/*" name="h_side" id="h_side">
                                <br>
                                <span>Please provide a photo of you holding your Identity Card front side. In the same picture, make a reference to JCash and today's date displayed. Make sure your face is clearly visible and that all passport details are clearly readable.</span>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <canvas id="ch_side" class="boxsixe" style="border:1px solid #d3d3d3;background:#ffffff;">
                                        </canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <span style="padding-toptop: 250px">example</span>
                                        <img width="350" height="250" style="border:1px solid #d3d3d3;" src="<?php echo e(URL::asset('front')); ?>/assets/images/idcard-h.jpg">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="submit-btn">Submit</button>
                                <br>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('xscript'); ?>
<script>
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Number Not valid."
    );
    $.validator.addMethod('filesize', function (value, element, arg) {
        console.log(element.files[0].size);
        console.log(arg);
        return this.optional(element) || (element.files[0].size <= arg)
    }, 'File size must be less than {0}');

    $("#kyc").validate({
        rules:
            {
                first_name: { required: true,minlength:2, regex:"^[A-Za-z]*$"},
                last_name: { required: true,minlength:2, regex:"^[A-Za-z]*$"},
                country_id: { required: true},
                f_side: {required: true,filesize:3145728},
                b_side: {required: true,filesize:3145728},
                h_side: {required: true,filesize:3145728},
            },
        messages:
            {
                first_name: { required: 'First Name  is required',minlength:'First name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                last_name: { required: 'Last Name  is required',minlength:'Last name should contain atleast two alphabets',regex:'Only alphabets allowed'},
                country_id: { required: 'Country  is required'},
                f_side: { required: 'Front Side  is required',filesize:"Maximum size is 3mb"},
                b_side: { required: 'Back Side  is required',filesize:"Maximum size is 3mb"},
                h_side: { required: 'Selfie with ID is required',filesize:"Maximum size is 3mb"},

            }
    });
</script>

<script>
    function el(id){return document.getElementById(id);} // Get elem by ID

    var canvas1  = el("cf_side");
    var context1 = canvas1.getContext("2d");
    function readImage1() {
        if ( this.files && this.files[0] ) {
            var FR= new FileReader();
            FR.onload = function(e) {
                var img = new Image();

                img.addEventListener("load", function() {
                    var x = 0;
                    var y = 0;
                    var width = 350;
                    var height = 250;

                    context1.drawImage(img,x,y,width,height);
                });
                img.src = e.target.result;
            };
            FR.readAsDataURL( this.files[0] );
        }
    }

    el("f_side").addEventListener("change", readImage1, false);
</script>

<script>
    function el(id){return document.getElementById(id);} // Get elem by ID

    var canvas2  = el("cb_side");
    var context2 = canvas2.getContext("2d");
    function readImage2() {
        if ( this.files && this.files[0] ) {
            var FR= new FileReader();
            FR.onload = function(e) {
                var img = new Image();

                img.addEventListener("load", function() {
                    var x = 0;
                    var y = 0;
                    var width = 350;
                    var height = 250;

                    context2.drawImage(img,x,y,width,height);
                });
                img.src = e.target.result;
            };
            FR.readAsDataURL( this.files[0] );
        }
    }

    el("b_side").addEventListener("change", readImage2, false);
</script>

<script>
    function el(id){return document.getElementById(id);} // Get elem by ID

    var canvas3  = el("ch_side");
    var context3 = canvas3.getContext("2d");
    function readImage3() {
        if ( this.files && this.files[0] ) {
            var FR= new FileReader();
            FR.onload = function(e) {
                var img = new Image();

                img.addEventListener("load", function()
                {
                    var x = 0;
                    var y = 0;
                    var width = 350;
                    var height = 250;
                    context3.drawImage(img,x,y,width,height);
                });
                img.src = e.target.result;
            };
            FR.readAsDataURL( this.files[0] );
        }
    }

    el("h_side").addEventListener("change", readImage3, false);
</script>



<script type="text/javascript">

    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function() {      // When arrow is clicked
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 500);
    });

</script>

<script type="text/javascript">

    // Form validation code will come here.
    function forgotPassword()
    {}


    // if( document.forgot_form.email.value == "" )
    // {
    //    alert( "Please provide your Email!" );
    //    document.forgot_form.email.focus() ;
    //    return false;
    // }

    //   var emailID = document.forgot_form.email.value;
    //   atpos = emailID.indexOf("@");
    //   dotpos = emailID.lastIndexOf(".");

    //   if (atpos < 1 || ( dotpos - atpos < 2 ))
    //   {
    //       var text = "Please enter correct email ID";
    //       document.getElementById('r_text').innerHTML = text;
    //       // alert("Please enter correct email ID")
    //       document.forgot_form.email.focus() ;
    //       return false;
    //    }
    //   return( true );

    // }
    //-->
</script>

<script>


    // Radialize the colors
    Highcharts.setOptions({
        colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.1).get('rgb')] // darken
                ]
            };
        })
    });

    // Build the chart
    Highcharts.chart('chart1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: 'Token',
            data: [
                { name: 'ICO Sale', y: 11.2 },
                { name: 'Ambassadors', y: 1 },
                { name: 'Team', y: 9 },
                { name: 'Jio Technologies Limited', y: 9 },
                { name: 'Reserved', y: 17.01 },
                { name: 'Advisors', y: 1 },
                { name: 'Seed', y: 5 },
                { name: 'Reward Pool, Proof of Activity & Bonus Pool', y: 46.79 }
            ]
        }]
    });
    // Build the chart
    Highcharts.chart('chart2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                }
            }
        },
        series: [{
            name: 'Funds',
            data: [
                { name: 'Legal, Taxes & Administrative', y: 5 },
                { name: 'Expansion Of Operation Team', y: 10 },
                { name: 'Marketing', y: 25 },
                { name: 'Tech Research & Development', y: 25 },
                { name: 'Business & Service Integration', y: 35 }
            ]
        }]
    });
</script>


<script type="text/javascript">
    function display_model(idd)
    {
        var id = idd;


        $.ajax({
            cache: false,
            type: 'POST',
            url: 'https://www.jiojio.io/getdeatil.php',
            data: {'id':id},
            success: function(data) {
                var objJSON = JSON.parse(data);
                var msg=objJSON.search_result.msg;
                var detail=objJSON.search_result.details;

                $('#title').html(msg);
                $('#detail').html(detail);
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layout.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>