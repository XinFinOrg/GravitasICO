 <nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;" data-position="right" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    <li class="user-panel">
                        <div class="thumb"><img src="https://cdn4.iconfinder.com/data/icons/general24/png/128/administrator.png" alt="" class="img-circle"/></div>
                        <div class="info"><p>{{get_adminprofile('XDC_username')}}</p>
                            <ul class="list-inline list-unstyled">
                                <li><a href="{{url('admin/profile')}}" data-hover="tooltip" title="Profile"><i class="fa fa-user"></i></a></li>

                                <li><a href="{{url('admin/site_settings')}}" data-hover="tooltip" title="Setting" ><i class="fa fa-cog"></i></a></li>
                                <li><a href="{{url('admin/logout')}}" data-hover="tooltip" title="Logout"><i class="fa fa-sign-out"></i></a></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </li>

                    <li class="{{admin_class('home').admin_class('')}}"><a href="{{url('admin/home')}}"><i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Dashboard</span></a></li>


                    @if(Session::get('alpha_id') == 1)
                        <?php
                        if (admin_class('users') != '' || admin_class('userbalance') != "" || admin_class('kyc_users') != "") {
                            $class = "active";
                            $in = 'in';
                            $style = "auto";
                        } else {
                            $class = "";
                            $in = '';
                            $style = "0 px";
                        }

                        ?>

                        <li class="<?php echo $class; ?>"><a href="#"><i class="fa fa-user fa-fw"><div class="icon-bg bg-pink"></div>
                                </i><span class="menu-title">Manage Users</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse <?php echo $in; ?>" style="height: <?php echo $style; ?>;">
                                <li ><a href="{{ url('admin/users') }}" @if(admin_class('users')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">User List</span></a></li>

                                <li ><a href="{{ url('admin/userbalance') }}" @if(admin_class('userbalance')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">User Balance</span></a></li>
                                <li ><a href="{{ url('admin/kyc_users') }}" @if(admin_class('kyc_users')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">KYC verfication</span></a></li>

                            </ul>


                        </li>


                        <?php
                        if (admin_class('deposit_history') != "" || admin_class('withdraw_history') != "" || admin_class('ico_history')!= "") {
                            $class = "active";
                            $in = 'in';
                            $style = "auto";
                        } else {
                            $class = "";
                            $in = '';
                            $style = "0 px";
                        }

                        ?>

                        <li class="<?php echo $class; ?>"><a href="#"><i class="fa fa-exchange fa-fw"><div class="icon-bg bg-pink"></div>
                                </i><span class="menu-title">Transactions</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse <?php echo $in; ?>" style="height: <?php echo $style; ?>;">
                            <!--  <li ><a href="{{ url('admin/transactions') }}" @if(admin_class('transactions')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">Exchange Transactions</span></a></li> -->
                                <li ><a href="{{ url('admin/deposit_history') }}" @if(admin_class('deposit_history')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">Deposit Transactions</span></a></li>

                                <li ><a href="{{ url('admin/updated_history') }}" @if(admin_class('updated_history')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">Updated Transactions</span></a></li>
                                <li ><a href="{{ url('admin/withdraw_history') }}" @if(admin_class('withdraw_history')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">Withdraw Transactions</span></a></li>
                                <li ><a href="{{ url('admin/ico_history') }}" @if(admin_class('ico_history')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">ICO Transaction</span></a></li>



                            </ul>


                        </li>

                        <li class="{{admin_class('user_activity')}}"><a href="{{url('admin/user_activity')}}"><i class="fa fa-user fa-fw">
                                    <div class="icon-bg bg-orange"></div>
                                </i><span class="menu-title">User Activity</span></a></li>


                        <li class="{{admin_class('mail_template')}}"><a href="{{url('admin/mail_template')}}"><i class="fa fa-envelope fa-fw">
                                    <div class="icon-bg bg-orange"></div>
                                </i><span class="menu-title">Manage Email Template</span></a></li>


                        {{--<li class="{{admin_class('contact_query')}}"><a href="{{url('admin/contact_query')}}"><i class="fa fa-phone fa-fw">--}}
                                    {{--<div class="icon-bg bg-orange"></div>--}}
                                {{--</i><span class="menu-title">Manage Enquiry</span></a></li>--}}

                        {{--<li class="{{admin_class('whitelists')}}"><a href="{{url('admin/whitelists')}}"><i class="fa fa-ban fa-fw">--}}
                                    {{--<div class="icon-bg bg-orange"></div>--}}
                                {{--</i><span class="menu-title">Manage IP Whitelists</span></a></li>--}}

                        {{--<li class="{{admin_class('meta_content')}}"><a href="{{url('admin/meta_content')}}"><i class="fa fa-file-text fa-fw">--}}
                                    {{--<div class="icon-bg bg-orange"></div>--}}
                                {{--</i><span class="menu-title">Manage Meta content</span></a></li>--}}
                    @elseif(Session::get('alpha_id') == 2)
                        <?php
                        if (admin_class('users') != '' || admin_class('userbalance') != "" || admin_class('kyc_users') != "") {
                            $class = "active";
                            $in = 'in';
                            $style = "auto";
                        } else {
                            $class = "";
                            $in = '';
                            $style = "0 px";
                        }

                        ?>

                        <li class="<?php echo $class; ?>"><a href="#"><i class="fa fa-user fa-fw"><div class="icon-bg bg-pink"></div>
                                </i><span class="menu-title">Manage KYC</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse <?php echo $in; ?>" style="height: <?php echo $style; ?>;">
                                <li ><a href="{{ url('admin/kyc_users') }}" @if(admin_class('kyc_users')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">KYC verfication</span></a></li>
                            </ul>


                        </li>


                    @else
                        <?php
                        if (admin_class('deposit_history') != "" || admin_class('withdraw_history') != "" || admin_class('ico_history')!= "") {
                            $class = "active";
                            $in = 'in';
                            $style = "auto";
                        } else {
                            $class = "";
                            $in = '';
                            $style = "0 px";
                        }

                        ?>

                        <li class="<?php echo $class; ?>"><a href="#"><i class="fa fa-exchange fa-fw"><div class="icon-bg bg-pink"></div>
                                </i><span class="menu-title">Transactions</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse <?php echo $in; ?>" style="height: <?php echo $style; ?>;">
                            <!--  <li ><a href="{{ url('admin/transactions') }}" @if(admin_class('transactions')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">Exchange Transactions</span></a></li> -->
                                <li ><a href="{{ url('admin/deposit_history') }}" @if(admin_class('deposit_history')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">Deposit Transactions</span></a></li>

                                <li ><a href="{{ url('admin/updated_history') }}" @if(admin_class('updated_history')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">Updated Transactions</span></a></li>
                                <li ><a href="{{ url('admin/withdraw_history') }}" @if(admin_class('withdraw_history')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">Withdraw Transactions</span></a></li>
                                <li ><a href="{{ url('admin/ico_history') }}" @if(admin_class('ico_history')!='')style='color:#dc6767' @endif ><i class="fa fa-align-left"></i><span class="submenu-title">ICO Transaction</span></a></li>



                            </ul>


                        </li>
                    @endif


                </ul>
            </div>
        </nav>