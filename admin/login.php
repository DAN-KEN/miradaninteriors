<?php
session_start();
include("includes/config.php");

define("TITLE","Login");

if(isset($_POST['login'])){
    $username = strtolower(trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['username']))));
    $password = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['password'])));

    if(empty($username)){array_push($errors, $usernameError = "Please enter your ID / username / email");}
    if(empty($password)){array_push($errors, $passwordError = "Please enter your password");}
    $cryptPwd = md5($password);
    #verify user credentials
    if(count($errors) == 0){
        $chkUser = mysqli_query($dbConn, "SELECT * FROM admin WHERE (adminID='$username' OR username='$username' OR email='$username') AND password='$cryptPwd'");
        if(mysqli_num_rows($chkUser) == 1){
            $adminData = mysqli_fetch_array($chkUser);
            $ID = $adminData['adminID'];
            $status = $adminData['status'];
            $role = $adminData['role'];
            if($status == "Active"){
                $chkRole = mysqli_query($dbConn, "SELECT status FROM roles WHERE id=$role");
                $roleData = mysqli_fetch_array($chkRole);
                $rlStatus = $roleData['status'];
                if($rlStatus == "Active"){
                    $_SESSION['ck_Admin'] = $ID;
                    $_SESSION['authMsg'] = "Welcome back. Pick from where you left";
                    header("location: home?shw-pend=admin");
                }
                else{
                    $iMsg = "Your account group has been deactivated. Contact site administrator";
                }
            }
            else{
                $iMsg = "Your account is currently inactive. Contact site administrator";
            }

        }
        else{
            $eMsg = "No such account here. Try again";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("includes/head.php"); ?>
</head>

<body>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto"><img src="assets/img/my-logo.png" alt="">
                                    <span class="d-none d-lg-block">Couz Konnect</span>
                                </a>
                                <?php include("includes/alerts.php"); ?>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <form class="row g-3" action="" method="post">

                                        <div class="col-12">
                                            <label for="" class="form-label">Username</label>
                                            <div class="input-group">
                                                <input type="text" name="username" class="form-control" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>" placeholder="Username / Email / ID">
                                            </div>
                                            <span class="text-danger"><?php if(isset($usernameError)){echo $usernameError;} ?></span>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control" value="<?php if(isset($_POST['password'])){echo $_POST['password'];} ?>">
                                            </div>
                                            <span class="text-danger"><?php if(isset($passwordError)){echo $passwordError;} ?></span>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-warning w-100" name="login" type="submit">Login</button>
                                        </div>
                                        <!--
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                                        </div>
-->
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
        </div>
    </main><!-- End #main -->



    <!-- Vendor JS Files -->
    <?php include("includes/scripts.php"); ?>

</body>

</html>
