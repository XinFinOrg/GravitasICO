<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div id="sidebar" class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul id="nav" class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <!--<li class="sidebar-search-wrapper">-->
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
            <!--<form class="sidebar-search  " action="page_general_search_3.html" method="POST">
<a href="javascript:;" class="remove">
<i class="icon-close"></i>
</a>
<div class="input-group">
<input type="text" class="form-control" placeholder="Search...">
<span class="input-group-btn">
    <a href="javascript:;" class="btn submit">
        <i class="icon-magnifier"></i>
    </a>
</span>
</div>
</form>-->
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
            <!--</li>-->

            <li class="nav-item start open">
                <a href="<?php echo e(url('/dashboard')); ?>" class="nav-link nav-toggle">
                    <i class="fas fa-home"></i>
                    <span class="title">Dashboard </span>
                    <!--<span class="selected"></span>
<span class="arrow open"></span>-->
                </a>
                <!--<ul class="sub-menu">
<li class="nav-item start ">
    <a href="index.html" class="nav-link ">
        <i class="icon-bar-chart"></i>
        <span class="title">Dashboard </span>
    </a>
</li>
</ul>-->
            </li>
            <li class="nav-item start open">
                <a href="<?php echo e(url('/ico')); ?>" class="nav-link nav-toggle">
                    <i class="far fa-window-maximize"></i>
                    <span class="title">GIFT ICO</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item start open" ui-sref="main.distribution">
                <a href="<?php echo e(url('/distribution')); ?>" class="nav-link nav-toggle">
                    <i class="far fa-dot-circle"></i>
                    <span class="title">Distribution</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item start open">
                <a href="<?php echo e(url('/transactions')); ?>" class="nav-link nav-toggle">
                    <i class="fa fa-history"></i>
                    <span class="title">Transaction History</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item start open" >
                <a href="<?php echo e(url('/documents')); ?>" class="nav-link nav-toggle">
                    <i class="far fa-file-alt"></i>
                    <span class="title">Documents</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item start open" >
                <a href="<?php echo e(url('/wallets')); ?>" class="nav-link nav-toggle">
                    <i class="far fa-chart-bar"></i>
                    <span class="title">Wallets</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="nav-item start open">
                <a href="<?php echo e(url('/kyc')); ?>" class="nav-link nav-toggle">
                    <i class="far fa-snowflake"></i>
                    <span class="title">KYC</span>
                    <span class="selected"></span>
                </a>
            </li>
            <!-- config -->
            <li class="nav-item start open hidden-md hidden-lg">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="far fa-user"></i>
                    <span class="title">User Account</span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link ">
                            <i class="fa fa-cogs"></i>
                            <span class="title">Account Settings </span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link ">
                            <i class="fa fa-lock"></i>
                            <span class="title">Security </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item start open hidden-md hidden-lg">
                <a href="<?php echo e(url('/logout')); ?>" class="nav-link nav-toggle">
                    <i class="icon-logout"></i>
                    <span class="title">Logout</span>
                    <span class="selected"></span>
                </a>
            </li>
            <!-- /config -->
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
