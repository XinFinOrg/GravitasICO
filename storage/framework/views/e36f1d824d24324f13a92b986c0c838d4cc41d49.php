
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <!--<div style="color: white;display: inline-block;line-height: 50px;">CREATANIUM</div>-->
            <a href="<?php echo e(url('/ico')); ?>">
                <!--<img src="assets/bower_components/metronic/layouts/layout2/img/logo-default.png" alt="logo" class="logo-default" />-->
                <img src="<?php echo e(URL::asset('front')); ?>/assets/img/logo-menu-light.png" alt="logo" class="logo-default" />
            </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="page-top hidden-sm hidden-xs">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <!--<img class="img-circle" src="assets/bower_components/metronic/layouts/layout/img/avatar3_small.jpg" />-->
                            <!--<span class="username username-hide-on-mobile"> User Account </span>-->
                            <?php if(Session::has('alphauserid')): ?>
                            <span class="username"> Hello <?php echo e(get_user_name()); ?> </span>
                            <?php else: ?>
                                <span class="username"> Hello Guest</span>
                            <?php endif; ?>
                            <i class="far fa-user"></i>
                        </a>

                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!--<li class="dropdown dropdown-quick-sidebar-toggler">
                        <a href="http://creatanium.io" class="dropdown-toggle">
                            <i class="icon-logout"></i>
                        </a>
                    </li>-->
                    <li style="margin-top: 10px">
                        <a  href="<?php echo e(url('/logout')); ?>" ><i class="icon-logout"></i></a>
                    </li>
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER INNER -->
</div>