<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="shortcut icon" href="<?php echo e(URL::asset('front')); ?>/assets/images/fav.png">
    <title>HOME</title>
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/vendor.bundle.css">
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/styles3.css">
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/jjc.css">
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/home.css">
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/theme-java.css" id="layoutstyle">
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/slider.css" id="layoutstyle">
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css'>
    <script src="<?php echo e(URL::asset('front')); ?>/assets/js/jiocharts.js"></script>
    <link rel="stylesheet" href="<?php echo e(URL::asset('front')); ?>/assets/css/toastr-2.1.3.css">
    <style type="text/css">
        .error {
            color: #a94442;


        }
    </style>

</head>

<body class="theme-dark no-bg" data-spy="scroll" data-target="#mainnav" data-offset="80">

<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
<header class="site-header is-sticky" id="intro">
    <div class="navbar navbar-expand-lg is-transparent" id="mainnav">
        <nav class="container">
            <a class="navbar-brand animated" data-animate="fadeInDown" data-delay=".65" href="<?php echo e(url('/')); ?>">
                <img class="logo logo-light" alt="logo" src="<?php echo e(URL::asset('front')); ?>/assets/images/j-logo.png" srcset="https://jcash.jiojio.io/front/assets/images/j-logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle"><span class="navbar-toggler-icon"><span class="ti ti-align-justify"></span></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarToggle">
                <ul class="navbar-nav animated remove-animation" data-animate="fadeInDown" data-delay=".9">
                    <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/')); ?>">HOME</a></li>
                    <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/aboutus')); ?>">ABOUT JCASH</a></li>
                    <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/register')); ?>">CREATE ACCOUNT</a></li>
                    <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/contact_us')); ?>">SUPPORT</a></li>
                    <li class="lipdt"><a class="btn-n" href="<?php echo e(url('/login')); ?>">SIGN IN</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<section class="top-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mbool">
                &nbsp;
            </div>

            <div class="col-lg-5 main-bx">
                <div class="countdown-box animated fadeInUp" data-animate="fadeInUp" data-delay=".3" style="visibility: visible; animation-delay: 0.3s;">
                    <img class="flag-t" src="<?php echo e(URL::asset('front')); ?>/assets/images/sig.png" alt="">
                    <h3 class="dif1">Presale Ending in</h3>
                    <div class="token-countdown text-center d-flex align-content-stretch" data-date="2018/05/18 11:00:00">
                        <div class="col"><span id="days" class="countdown-time countdown-time-first"></span><span class="countdown-text">Days</span></div>
                        <div class="col"><span id="hours" class="countdown-time"></span><span class="countdown-text">Hours</span></div>
                        <div class="col"><span id="minutes" class="countdown-time">36</span><span class="countdown-text">Minutes</span></div>
                        <div class="col"><span id="seconds" class="countdown-time countdown-time-last">09</span><span class="countdown-text">Seconds</span></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="login-container container-fluid" id="apps">
    <div class="container lg-wpr">
        <div class="row">
            <div class="col-md-8">
                <div class="underxxt">
                    <h2>Welcome to JCash</h2>
                    <p class="text-white text-center">JCASH: Based in Singapore: ICO manager, promoter and creator. Responsible for fundraising, marketing, and token issuance once ICO is completed. This entity will develop the mobile application and advertising exchange platform. </p>
                    <p class="text-white text-center">JiojioMe Network: Based in Singapore, actively working on developing the network and distribution globally for any JiojioMe user. The JiojioMe Network already has more than 40,000 users from the Beta Launch in Singapore (Dec 31 2017) and more than 500 merchants and retailers in Singapore.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="login-wpr pull-right clearfix">
                    <div class="login-top">
                        <h2 class="reg-heading">Login</h2>
                        <p class="reg-sub-heading"></p>
                    </div>

                    <div class="login-form">
                        <form id="login_form" action="<?php echo e(url('/login')); ?>" method="post" name="login-form">
                            <?php echo e(csrf_field()); ?>

                            <input type="text" name="login_mail" placeholder="Email id" class="form-control form-control1">
                            <input type="password" name="password" placeholder="Password" class="form-control form-control1">

                            <div class="form-group">
                            <span id="capimg" style="margin-bottom: 20px; display: inline-block;"><?php echo captcha_img(); ?>

                            </span>
                                <a href="javascript:;" onclick="change_captcha()" class="m_tl">
                                    <i class="fa fa-refresh fa-3x"></i></a>

                                <input type="text" class="form-control input-lg" name="captcha" placeholder="Captcha code">
                            </div>

                            <a href="<?php echo e(url('/forgotpass')); ?>" class="forgot"> Forgot Password ? </a>
                            <input type="submit" name="Submit" value="Login" class="submit-btn">
                            <p class="not-member">Don't have an Account? <a href="<?php echo e(url('/register')); ?>">Create Now!</a> </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="login-container1 container-fluid">
    <div class="container lg-wpr1">
        <div class="row">
            <div class="col-md-12">
                <div class="underxxt">
                    <h2 class="clor">How to Start?</h2>
                    <p class="text-white text-center">Its very simple</p>
                    <p class="text-white text-center">Register, Verify Your Email, Mobile Number and Start Trading.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="login-container2">
    <div class="lg-wpr section-overlay bg-opacity-9">
        <div class="container">
            <div class="row">
                <div class="underxxt1">
                    <h3>With blockchain technology continuing to innovate, JCash supports established and emerging Digital currencies like Bitcoin-BTC, Ethereum-ETH.</h3>
                </div>
                <div class="margn"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/BTC.png" alt=""></div>
                <div class="margn"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/ETH.png" alt=""></div>
            </div>
        </div>

    </div>
</section>

<div class="section footer-scetion footer-particle section-pad-sm section-bg-dark clearfix">

    <div class="container">
        <div class="row">
            <div class="col-sm-6 res-l-bttm">
                <ul class="social text-left centttr">
                    <li class="animated" data-animate="fadeInUp" data-delay=".1"><a href="https://www.facebook.com/jiojiome/" target="_blank"><em class="fa fa-facebook"></em></a></li>
                    <li class="animated" data-animate="fadeInUp" data-delay=".2">
                        <a href="https://twitter.com/hashtag/JiojioMe?src=hash" target="_blank"><em class="fa fa-twitter"></em></a></li>

                    <li class="animated" data-animate="fadeInUp" data-delay=".3">
                        <a href="https://www.youtube.com/channel/UCq7d8UQsLNQk5MZO3JFzhkg" target="_blank"><em class="fa fa-youtube-play"></em></a></li>

                    <li class="animated" data-animate="fadeInUp" data-delay=".4">
                        <a href="https://www.instagram.com/jiojiome/?hl=en" target="_blank"><em class="fa fa-instagram"></em></a></li>

                    <li class="animated" data-animate="fadeInUp" data-delay=".5">
                        <a href="https://www.jiojio.io/about-jiojiome.html" target="_blank">
                            <div class="cards"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/jio-icon2.png" alt="" class="imgf"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/jio-icon2-h.png" alt="" class="img-top"></div>
                        </a>
                    </li>

                    <li class="animated" data-animate="fadeInUp" data-delay=".5"><a href="https://t.me/jiojiome" target="_blank"><em class="fa fa-paper-plane"></em></a></li>

                </ul>
            </div>

            <div class="col-sm-6">
                <div class="text-right centttr">
                    <a href="https://itunes.apple.com/in/app/jiojiome/id1255725245?mt=8" target="_blank"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/ipn1.png" alt=""></a>
                    &nbsp;
                    <a href="https://play.google.com/store/apps/details?id=com.jiojiome&amp;hl=en" target="_blank"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/gpl1.png" alt=""></a>
                </div>
            </div>

        </div>
        <div class="gaps size-1x"></div>

        <div class="row">
            <div class="col-md-8 mobile-left">
                <ul class="footer-links animated fadeInUp" data-animate="fadeInUp" data-delay="1" style="visibility: visible; animation-delay: 1s;">
                    <li><a href="<?php echo e(url('/')); ?>">HOME</a></li>
                    <li><a href="<?php echo e(url('/aboutus')); ?>">ABOUT JCASH</a></li>
                    <li><a href="<?php echo e(URL('/register')); ?>">CREATE ACCOUNT</a></li>
                    <li><a href="<?php echo e(url('/contact_us')); ?>">SUPPORT</a></li>
                    <li><a href="<?php echo e(url('/login')); ?>">SIGN IN</a></li>
                </ul>
            </div>

            <div class="col-md-4 text-right">
                    <span class="copyright-text animated fadeInUp" data-animate="fadeInUp" data-delay="1" style="visibility: visible; animation-delay: 1s;">
    © 2018 <span class="colord">Jio Technologies Limited.</span> All Copyright Reserved.</span>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(URL::asset('front')); ?>/assets/js/jquery.bundle2.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/new-script.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/index.js"></script>
<script src='<?php echo e(URL::asset('front')); ?>/assets/js/jquery-ss.min.js'></script>


<script type="text/javascript">
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) { // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200); // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200); // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function() { // When arrow is clicked
        $('body,html').animate({
            scrollTop: 0 // Scroll to top of body
        }, 500);
    });
</script>
<script type="text/javascript">
    $("#login_form").validate(
        {
            rules:
                {
                    login_mail:{required:true,email:true},
                    password:{required:true},
                    captcha:{required:true}
                },
            messages:
                {
                    login_mail:{required:'Email is required',email:'Enter valid email address',},
                    password:{required:'Password is required',},
                    captcha:{required:'Captha is required',},
                }
        });
</script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/particles-jjc2.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/particles-jjc1-ne.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/particles-jjcs1.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/fallingsnow.js"></script>
<script src="<?php echo e(URL::asset('front')); ?>/assets/js/prefixfree.min.js"></script>
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


    function change_captcha()
    {
        $("#capimg").html('Loading....');
        $.post('https://jcash.jiojio.io/ajax/refresh_capcha',function(data,result)
        {
            $("#capimg").html(data);
        });
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

</body>

</html>



    
    

    









