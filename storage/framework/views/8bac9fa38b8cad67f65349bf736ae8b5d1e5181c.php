

<script src="<?php echo e(URL::asset('front')); ?>/assets/js/jquery.bundle2.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/new-script.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/index.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/jquery-ss.min.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/accodian2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/toastr-2.1.3.js"></script>



<script type="text/javascript">

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    <?php if(count($errors)>0): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $er): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    toastr.error("<?php echo e($er); ?>");
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <?php if(Session::has('info')): ?>//this line works as expected
    toastr.info("<?php echo e(Session::get('info')); ?>");
    <?php elseif(Session::has('error')): ?>
    console.log('error');
    toastr.error("<?php echo e(Session::get('error')); ?>");
    console.log("errr");
    <?php elseif(Session::has('warning')): ?>
    toastr.warning("<?php echo e(Session::get('warning')); ?>");
    <?php elseif(Session::has('success')): ?>
    toastr.success("<?php echo e(Session::get('success')); ?>");
    <?php endif; ?>
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

<script src="<?php echo e(URL::asset('front')); ?>/assets/js/particles-jjc2.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/particles-jjc1-ne.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/particles-jjcs1.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/fallingsnow.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/prefixfree.min.js"></script>

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
