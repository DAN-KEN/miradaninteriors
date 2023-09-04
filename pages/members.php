<?php

include("../admin/includes/config.php");

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include("../includes/head.php"); ?>


<body>

    <!-- Preloader Start -->
    <?php include("../includes/preloader.php"); ?>
    <!-- Preloader End -->

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Header Section Start -->
        <?php include("../includes/header.php"); ?>
        <!-- Header Section End -->

        <!-- Page Header Start -->
        <?php include("../includes/page-header.php"); ?>
        <!-- Page Header End -->

        <!-- Page Wrapper Start -->
        <section class="page--wrapper pt--80 pb--20">
            <div class="container">
                <div class="row">
                    <!-- Main Content Start -->
                    <div class="main--content col-md-8 pb--60" data-trigger="stickyScroll">
                        <div class="main--content-inner">
                            <!-- Filter Nav Start -->
                            <div class="filter--nav pb--30 clearfix">
                                <div class="filter--link float--left">
                                    <h2 class="h4">All Members : 30,000</h2>
                                </div>

                                <div class="filter--options float--right">
                                    <label>
                                        <span class="fs--14 ff--primary fw--500 text-darker">Show By :</span>

                                        <select name="membersfilter" class="form-control form-sm" data-trigger="selectmenu">
                                            <option value="last-active" selected>Last Active</option>
                                            <option value="new-registered">New Registerd</option>
                                            <option value="alphabetical">Alphabetical</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <!-- Filter Nav End -->

                            <!-- Member Items Start -->
                            <div class="member--items">
                                <div class="row gutter--15 AdjustRow">
                                    <?php
                                    $query = mysqli_query($dbConn, "SELECT * FROM Members");
                                        while($row=mysqli_fetch_array($query)){
                                            $mId = $row['id'];
                                            $ID = $row['memberID'];
                                            $username = $row['username'];
                                            $fName = $row['fName'];
                                            $mName = $row['mName'];
                                            $mNameInit = strtoupper(substr($mName,0,1)).(empty($mName) ? '' : '.');
                                            $lName = $row['lName'];
                                            $phone = $row['phone'];
                                            $email = $row['email'];
                                            $image = $row['image'];
                                            $status = $row['status'];
                                            $dCreated = strtotime($row['dCreated']);
                                            $timeAgo = getTimeAgo($dCreated);
                                        ?>
                                    <div class="col-md-4 col-xs-6 col-xxs-12">
                                        <!-- Member Item Start -->
                                        <div class="member--item online">
                                            <div class="img img-circle">
                                                <a href="<?php echo $appURL; ?>member-profile" class="btn-link">
                                                    <img src="<?php echo $uploadsURL; ?>images/users/members/<?php echo $image; ?>" alt="">
                                                </a>
                                            </div>

                                            <div class="name">
                                                <h3 class="h6 fs--12">
                                                    <a href="<?php echo $appURL; ?>member-profile" class="btn-link"><?php echo "$fName $mNameInit $lName"; ?></a>
                                                </h3>
                                            </div>

                                            <div class="activity">
                                                <p><i class="fa mr--8 fa-clock-o"></i>Active <?php echo $timeAgo; ?> </p>
                                            </div>

                                            <div class="actions">
                                                <ul class="nav">
                                                    <li>
                                                        <a href="#" title="Send Message" class="btn-link" data-toggle="tooltip" data-placement="bottom">
                                                            <i class="fa fa-envelope-o"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" title="Add Friend" class="btn-link" data-toggle="tooltip" data-placement="bottom">
                                                            <i class="fa fa-user-plus"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" title="Media" class="btn-link" data-toggle="tooltip" data-placement="bottom">
                                                            <i class="fa fa-folder-o"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Member Item End -->
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- Member Items End -->

                            <!-- Page Count Start -->
                            <div class="page--count pt--30">
                                <label class="ff--primary fs--14 fw--500 text-darker">
                                    <span>Viewing</span>

                                    <a href="#" class="btn-link"><i class="fa fa-caret-left"></i></a>
                                    <input type="number" name="page-count" value="01" class="form-control form-sm">
                                    <a href="#" class="btn-link"><i class="fa fa-caret-right"></i></a>

                                    <span>of 2,500</span>
                                </label>
                            </div>
                            <!-- Page Count End -->
                        </div>
                    </div>
                    <!-- Main Content End -->

                    <!-- Main Sidebar Start -->
                    <?php include("../includes/sidebar.php"); ?>
                    <!-- Main Sidebar End -->
                </div>
            </div>
        </section>
        <!-- Page Wrapper End -->

        <!-- Footer Section Start -->
        <?php include("../includes/footer.php"); ?>
        <!-- Footer Section End -->
    </div>
    <!-- Wrapper End -->

    <!-- Back To Top Button Start -->
    <?php include("../includes/to-top.php"); ?>
    <!-- Back To Top Button End -->

    <?php include("../includes/scripts.php"); ?>

</body>


</html>
