<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
<header class="site-header is-sticky" id="intro">
    <div class="navbar navbar-expand-lg is-transparent" id="mainnav">
        <nav class="container">
            <?php if(Session::has('alphauserid')): ?>
            <a class="navbar-brand animated" data-animate="fadeInDown" data-delay=".65" href="<?php echo e(url('/dashboard')); ?>">
                <img class="logo logo-dark" alt="logo" src="<?php echo e(URL::asset('front')); ?>/assets/images/j-logo.png" srcset="https://jcash.jiojio.io/front/assets/images/j-logo.png">
                <img class="logo logo-light" alt="logo" src="<?php echo e(URL::asset('front')); ?>/assets/images/j-logo.png" srcset="https://jcash.jiojio.io/front/assets/images/j-logo.png"></a>
            <?php else: ?>
                <a class="navbar-brand animated" data-animate="fadeInDown" data-delay=".65" href="<?php echo e(url('/')); ?>">
                    <img class="logo logo-dark" alt="logo" src="<?php echo e(URL::asset('front')); ?>/assets/images/j-logo.png" srcset="https://jcash.jiojio.io/front/assets/images/j-logo.png">
                    <img class="logo logo-light" alt="logo" src="<?php echo e(URL::asset('front')); ?>/assets/images/j-logo.png" srcset="https://jcash.jiojio.io/front/assets/images/j-logo.png"></a>
            <?php endif; ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle"><span class="navbar-toggler-icon"><span class="ti ti-align-justify"></span></span>
            </button>
            <?php if(Session::has('alphauserid')): ?>
                <div class="collapse navbar-collapse justify-content-end" id="navbarToggle">
                    <ul class="navbar-nav animated remove-animation" data-animate="fadeInDown" data-delay=".9">
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/dashboard')); ?>">DASHBOARD</a></li>
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/kyc')); ?>">KYC</a></li>
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/ico')); ?>">ICO</a></li>
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/transactions')); ?>">TRANSACTIONS</a></li>
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/contact_us')); ?>">SUPPORT</a></li>
                        <div class="dropdown">
                            <button class="dropbtn"><?php echo e(get_user_name()); ?> <i class="fa fa-angle-down"></i></button>
                            <div class="dropdown-content">
                                <ul>
                                    <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/logout')); ?>">LOGOUT</a></li>
                                </ul>
                            </div>
                        </div>
                    </ul>
                </div>
            <?php else: ?>
                <div class="collapse navbar-collapse justify-content-end" id="navbarToggle">
                    <ul class="navbar-nav animated remove-animation" data-animate="fadeInDown" data-delay=".9">
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/')); ?>">HOME</a></li>
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/aboutus')); ?>">ABOUT JCASH</a></li>
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/register')); ?>">CREATE ACCOUNT</a></li>
                        <li class="nav-item"><a class="nav-link menu-link" href="<?php echo e(url('/contact_us')); ?>">SUPPORT</a></li>
                        <li class="lipdt"><a class="btn-n" href="<?php echo e(url('/login')); ?>">SIGN IN</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </nav>
    </div>
</header>