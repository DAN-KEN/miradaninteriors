<?php
include("../../admin/includes/config.php");

define("TITLE","Template");
define("PAGE_TITLE","Template");
define("BREADCRUMB","temp");
define("ICON","file");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../includes/head.php"); ?>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include("../includes/header.php"); ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php include("../includes/aside.php"); ?>
    <!-- End Sidebar-->

    <main id="main" class="main">
        <!-- Page Title -->
        <?php include("../includes/page-title.php"); ?>
        <!-- End Page Title -->

        <?php include("../../admin/includes/alerts.php"); ?>

        <section class="section dashboard">
            <div class="bg-white p-4 mb-5">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        New
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link</a>
                    </div>
                </div>
                <div class="btn-group float-end">
                    <a href="<?php echo $adminURL; ?>template" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Item</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Add New</h5>

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>
                                <li><a class="dropdown-item" href="#">Item</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Manage</h5>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include("../includes/footer.php"); ?>
    <!-- End Footer -->

    <!-- Vendor JS Files -->
    <?php include("../includes/scripts.php"); ?>

</body>

</html>
