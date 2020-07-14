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

                    <li class="animated" data-animate="fadeInUp" data-delay=".5"><a href="https://www.jiojio.io/about-jiojiome.html" target="_blank">
                            <div class="cards"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/jio-icon2.png" alt="" class="imgf"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/jio-icon2-h.png" alt="" class="img-top"></div></a></li>

                    <li class="animated" data-animate="fadeInUp" data-delay=".5"><a href="https://t.me/jiojiome" target="_blank"><em class="fa fa-paper-plane"></em></a></li>

                </ul>
            </div>



            <div class="col-sm-6">
                <div class="text-right centttr">
                    <a href="https://itunes.apple.com/in/app/jiojiome/id1255725245?mt=8" target="_blank"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/ipn1.png" alt=""></a>
                    &nbsp; <a href="https://play.google.com/store/apps/details?id=com.jiojiome&amp;hl=en" target="_blank"><img src="<?php echo e(URL::asset('front')); ?>/assets/images/gpl1.png" alt=""></a>
                </div>
            </div>


        </div>
        <div class="gaps size-1x"></div>


        <div class="row">
            <?php if(Session::has('alphauserid')): ?>
            <div class="col-md-8 mobile-left">
                <ul class="footer-links animated fadeInUp" data-animate="fadeInUp" data-delay="1" style="visibility: visible; animation-delay: 1s;">
                    <li><a  href="<?php echo e(url('/dashboard')); ?>">DASHBOARD</a></li>
                    <li><a href="<?php echo e(url('/kyc')); ?>">KYC</a></li>
                    <li><a href="<?php echo e(url('/ico')); ?>">ICO</a></li>
                    <li><a href="<?php echo e(url('/contact_us')); ?>">SUPPORT</a></li>
                </ul>
            </div>
            <?php else: ?>
                <div class="col-md-8 mobile-left">
                    <ul class="footer-links animated fadeInUp" data-animate="fadeInUp" data-delay="1" style="visibility: visible; animation-delay: 1s;">
                        <li><a href="#">HOME</a></li>
                        <li><a href="<?php echo e(url('/login')); ?>">SIGN IN</a></li>
                        <li><a href="<?php echo e(url('/register')); ?>">CREATE ACCOUNT</a></li>
                        <li><a href="<?php echo e(url('/contact_us')); ?>">SUPPORT</a></li>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="col-md-4 text-right">
     <span class="copyright-text animated fadeInUp" data-animate="fadeInUp" data-delay="1" style="visibility: visible; animation-delay: 1s;">
    © 2018 <span class="colord">Jio Technologies Limited.</span>  All Copyright Reserved.</span>
            </div>
        </div>
    </div>
</div>