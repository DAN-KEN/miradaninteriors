<?php
include("../admin/includes/config.php");
include("includes/auth.php");

define("TITLE","Member Dashboard");
define("PAGE_TITLE","Dashboard");
define("BREADCRUMB","dashboard");
define("ICON","dashboard");


#activate admin
if(isset($_GET['do']) && $_GET['do'] == "actv-admin"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $query = mysqli_query($dbConn, "UPDATE admin SET status='Active', dUpdated=NOW() WHERE id=$id");
    if($query){
        $sMsg = "Admin '$nm' activated successfully";
    }
    else{
        $eMsg = "Admin could not be activated";
    }
}

#activate role
if(isset($_GET['do']) && $_GET['do'] == "actv-role"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $query = mysqli_query($dbConn, "UPDATE roles SET status='Active', dUpdated=NOW() WHERE id=$id");
    if($query){
        $sMsg = "role '$nm' activated successfully";
    }
    else{
        $eMsg = "Role could not be activated";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("includes/head.php"); ?>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include("includes/header.php"); ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php include("includes/aside.php"); ?>
    <!-- End Sidebar-->

    <main id="main" class="main">
        <!-- Page Title -->
        <?php include("includes/page-title.php"); ?>
        <!-- End Page Title -->
        <?php include("../admin/includes/alerts.php"); ?>

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-md-8">
                    <div class="row">

                        <!-- Summary Card -->
                        <div class="col-md-4">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Users <span>| Admin</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
                                            $cntRows = mysqli_query($dbConn, "SELECT * FROM admin");
                                            $cntRowsAct = mysqli_query($dbConn, "SELECT * FROM admin WHERE status='Active'");
                                            $cntRowsInact = mysqli_query($dbConn, "SELECT * FROM admin WHERE status<>'Active'");
                                            ?>
                                            <h6><?php echo mysqli_num_rows($cntRows); ?></h6>
                                            <span class="text-success small pt-1 fw-bold"><?php echo mysqli_num_rows($cntRowsAct); ?></span> <span class="text-muted small pt-2 ps-1">active</span>
                                            <br>
                                            <span class="text-success small pt-1 fw-bold"><?php echo mysqli_num_rows($cntRowsInact); ?></span> <span class="text-muted small pt-2 ps-1">inactive</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Summary Card -->

                        <!-- Summary Card -->
                        <div class="col-md-4">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Roles</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa fa-id-card"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
                                            $cntRows = mysqli_query($dbConn, "SELECT * FROM roles");
                                            $cntRowsAct = mysqli_query($dbConn, "SELECT * FROM roles WHERE status='Active'");
                                            $cntRowsInact = mysqli_query($dbConn, "SELECT * FROM roles WHERE status<>'Active'");
                                            ?>
                                            <h6><?php echo mysqli_num_rows($cntRows); ?></h6>
                                            <span class="text-success small pt-1 fw-bold"><?php echo mysqli_num_rows($cntRowsAct); ?></span> <span class="text-muted small pt-2 ps-1">active</span>
                                            <br>
                                            <span class="text-success small pt-1 fw-bold"><?php echo mysqli_num_rows($cntRowsInact); ?></span> <span class="text-muted small pt-2 ps-1">inactive</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Summary Card -->

                        <!-- Summary Card -->
                        <div class="col-md-4">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Activities</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                        <div class="ps-3">
                                            <?php
                                            $cntRows = mysqli_query($dbConn, "SELECT * FROM action_logs WHERE type='public' AND (msg LIKE '%$curMbrUsername%' OR msg LIKE '%$curMemberID%')");
                                            $cntRowsAct = mysqli_query($dbConn, "SELECT * FROM action_logs WHERE type='public' AND (msg LIKE '%$curMbrUsername%' OR msg LIKE '%$curMemberID%')");
                                            $cntRowsInact = mysqli_query($dbConn, "SELECT * FROM action_logs WHERE type='public' AND (msg LIKE '%$curMbrUsername%' OR msg LIKE '%$curMemberID%')");
                                            ?>
                                            <h6><?php echo mysqli_num_rows($cntRows); ?></h6>
                                            <span class="text-success small pt-1 fw-bold"><?php echo mysqli_num_rows($cntRowsAct); ?></span> <span class="text-muted small pt-2 ps-1">today</span>
                                            <br>
                                            <span class="text-success small pt-1 fw-bold"><?php echo mysqli_num_rows($cntRowsInact); ?></span> <span class="text-muted small pt-2 ps-1">past</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Summary Card -->

                    </div>

                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Pending Items</h4>

                                <!-- Pills Tabs -->
                                <ul class="nav nav-pills mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="<?php echo $adminURL; ?>home?shw-pend=admin" class="nav-link <?php if(isset($_GET['shw-pend']) && $_GET['shw-pend'] == "admin"){ echo "active"; } ?>">Admin</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="<?php echo $adminURL; ?>home?shw-pend=roles" class="nav-link <?php if(isset($_GET['shw-pend']) && $_GET['shw-pend'] == "roles"){ echo "active"; } ?>">Roles</a>
                                    </li>
                                </ul>
                                <div class="tab-content pt-2">
                                    <div class="tab-pane fade show <?php if(isset($_GET['shw-pend']) && $_GET['shw-pend'] == "admin"){ echo "active"; } ?>">
                                        <div class="table-responsive x-scroll">
                                            <table class="table datatable">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Action</th>
                                                        <th>ID</th>
                                                        <th>Username</th>
                                                        <th>Role</th>
                                                        <th>Image</th>
                                                        <th>Date Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $No=1;
                                                    $query = mysqli_query($dbConn, "SELECT admin.id, admin.adminID, admin.username, admin.image, admin.dCreated, roles.name AS role FROM admin LEFT JOIN roles ON admin.role=roles.id WHERE admin.status='Pending'");
                                                    while($row=mysqli_fetch_array($query)){
                                                        $aId = $row['id'];
                                                        $ID = $row['adminID'];
                                                        $username = $row['username'];
                                                        $image = $row['image'];
                                                        $role = $row['role'];
                                                        $dCreated = date("M jS, Y h:ia", strtotime($row['dCreated']));
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $No++; ?></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="<?php echo $adminURL; ?>home?do=actv-admin&shw-pend=admin&nm=<?php echo $username; ?>&id=<?php echo $aId; ?>" class="btn btn-outline-primary btn-sm" title="Activate"><i class="fa fa-check"></i></a>
                                                            </div>
                                                        </td>
                                                        <td><a href=""><?php echo $ID; ?></a></td>
                                                        <td><?php echo $username; ?></td>
                                                        <td><?php echo $role; ?></td>
                                                        <td>
                                                            <img src="<?php echo $uploadsURL; ?>images/users/admin/<?php echo $image; ?>" width="40" height="40" alt="" class="rounded-circle">
                                                        </td>
                                                        <td><?php echo $dCreated; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show <?php if(isset($_GET['shw-pend']) && $_GET['shw-pend'] == "roles"){ echo "active"; } ?>">
                                        <div class="table-responsive x-scroll">
                                            <table class="table datatable">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <td>S/N</td>
                                                        <td>Action</td>
                                                        <td>Name</td>
                                                        <td>Date Created</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $No=1;
                                                    $query = mysqli_query($dbConn, "SELECT * FROM roles WHERE status<>'Active'");
                                                    while($row=mysqli_fetch_array($query)){
                                                        $rId = $row['id'];
                                                        $name = $row['name'];
                                                        $dCreated = date("M jS, Y h:ia", strtotime($row['dCreated']));
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $No++; ?></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="<?php echo $adminURL; ?>home?do=actv-role&shw-pend=roles&nm=<?php echo $name; ?>&id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm" title="Activate"><i class="fa fa-check"></i></a>
                                                            </div>
                                                        </td>
                                                        <td><?php echo $name; ?></td>
                                                        <td><?php echo $dCreated; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div><!-- End Pills Tabs -->
                            </div>
                        </div>
                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-md-4">

                    <!-- Recent Activity -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activities</h5>

                            <div class="activity">
                                <?php
                                $query = mysqli_query($dbConn, "SELECT * FROM action_logs WHERE type='public' AND (msg LIKE '%$curMbrUsername%' OR msg LIKE '%$curMemberID%') ORDER BY dCreated DESC LIMIT 20");
                                $rowNum = mysqli_num_rows($query);
                                if($rowNum > 0){
                                while($row = mysqli_fetch_array($query)){
                                    $msg = $row['msg'];
                                    $type = $row['type'];
                                    $dCreated = strtotime($row['dCreated']);
                                    $timeAgo = getTimeAgo($dCreated);
                                    if($type == "mgmt"){
                                        $textColor = "success";
                                    }
                                    elseif($type == "auth"){
                                        $textColor = "info";
                                    }

                                ?>
                                <div class="activity-item d-flex">
                                    <div class="activite-label"><?php echo $timeAgo; ?></div>
                                    <i class='bi bi-circle-fill activity-badge text-<?php echo $textColor; ?> align-self-start'></i>
                                    <div class="activity-content">
                                        <?php echo $msg; ?>
                                    </div>
                                </div>
                                <!-- End activity item-->
                                <?php }} else{ ?>
                                <p class="text-info text-uppercase text-center"><strong>No activity yet</strong></p>

                                <?php } ?>

                            </div>

                        </div>
                    </div><!-- End Recent Activity -->

                </div><!-- End Right side columns -->

            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include("includes/footer.php"); ?>
    <!-- End Footer -->

    <!-- Vendor JS Files -->
    <?php include("includes/scripts.php"); ?>


</body>

</html>
