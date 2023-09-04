<header class="header--section style--1">
    <!-- Header Topbar Start -->
    <div class="header--topbar bg-black">
        <div class="container">
            <!-- Header Topbar Links Start -->
            <ul class="header--topbar-links nav ff--primary float--left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span>En</span>
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="active"><a href="#">En</a></li>
                        <li><a href="#">Bn</a></li>
                        <li><a href="#">In</a></li>
                    </ul>
                </li>
            </ul>
            <!-- Header Topbar Links End -->

            <!-- Header Topbar Social Start -->
            <ul class="header--topbar-social nav float--left hidden-xs">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-rss"></i></a></li>
                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
            </ul>
            <!-- Header Topbar Social End -->

            <!-- Header Topbar Links Start -->
            <ul class="header--topbar-links nav ff--primary float--right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa mr--8 fa-user-o"></i>
                        <span>Go To</span>
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
<!--
                        <li class="active"><a href="<?php echo $adminURL; ?>home?shw-pend=admin" target="_blank">Admin</a></li>
                        <li><a href="<?php echo $membersURL; ?>home" target="_blank">Member</a></li>
-->
                        <li class="active"><a href="<?php echo $appURL; ?>home">Admin</a></li>
                        <li><a href="<?php echo $appURL; ?>home">Member</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa mr--8 fa-user-o"></i>
                        <span>login</span>
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
<!--
                        <li class="active"><a href="<?php echo $membersURL; ?>profile" target="_blank">Profile</a></li>
                        <li><a href="<?php echo $membersURL; ?>home" target="_blank">Dashboard</a></li>
                        <li><a href="<?php echo $membersURL; ?>logout">Logout</a></li> 
-->
                        <li class="active"><a href="<?php echo $appURL; ?>home">Profile</a></li>
                        <li><a href="<?php echo $appURL; ?>home">Dashboard</a></li>
                        <li><a href="<?php echo $appURL; ?>home">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <!-- Header Topbar Links End -->
        </div>
    </div>
    <!-- Header Topbar End -->

    <!-- Header Navbar Start -->
    <div class="header--navbar navbar bg-white" data-trigger="sticky">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle style--1 collapsed" data-toggle="collapse" data-target="#headerNav">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Header Navbar Logo Start -->
                <div class="header--navbar-logo navbar-brand">
                    <a href="<?php echo $appURL; ?>home">
                        <img src="<?php echo $appURL; ?>assets/img/mirandan.jpg" style="width:120px; height:80px;" class="normal" alt="">
                        
                    </a>
                </div>
                <!-- Header Navbar Logo End -->
            </div>

            <div id="headerNav" class="navbar-collapse collapse float--right">
                <!-- Header Nav Links Start -->
                <ul class="header--nav-links style--1 nav ff--primary">
                    <li class=""><a href="<?php echo $appURL; ?>home"><span>Home</span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span>Community</span>
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
<!--                            <li><a href="<?php echo $appURL; ?>all-members"><span>Members</span></a></li>-->
                            <li><a href="<?php echo $appURL; ?>home"><span>Members</span></a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo $appURL; ?>contact"><span>Contact</span></a></li>
                </ul>
                <!-- Header Nav Links End -->
            </div>
        </div>
    </div>
    <!-- Header Navbar End -->
</header>
