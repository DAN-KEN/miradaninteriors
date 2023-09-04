<?php
session_start();
include("../admin/includes/config.php");

define("TITLE","Member Register");

#Register Member
if(isset($_POST['register'])){
    $username = strtolower(trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['username']))));
    $fName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['fName'])));
    $lName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['lName'])));
    $email = strtolower(trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['email']))));
    $password = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['password'])));
    $password2 = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['password2'])));

    if(empty($username)){ array_push($errors, $usernameError = "Username is required"); }
    if(empty($fName)){ array_push($errors, $fNameError = "First name is required"); }
    if(empty($lName)){ array_push($errors, $lNameError = "Last name is required"); }
    if(empty($email)){ array_push($errors, $emailError = "Email is required"); }
    if(empty($password)){ array_push($errors, $passwordError = "Password is required"); }
    if(empty($password2)){ array_push($errors, $password2Error = "Password confirmation is required"); }

    if($password != $password2){ array_push($errors, $pwdMatchError = ""); $eMsg = "The two passwords do not match"; }

    #prevent duplicate entry
    $checkMemberUname = mysqli_query($dbConn, "SELECT * FROM members WHERE username='$username'");
    $checkMemberEmail = mysqli_query($dbConn, "SELECT * FROM members WHERE email='$email'");
    if(mysqli_num_rows($checkMemberUname) > 0){
        array_push($errors, $memberUnameError = ""); $eMsg = "Member with username '$username' already exists";
    }
    if(mysqli_num_rows($checkMemberEmail) > 0){
        array_push($errors, $memberEmailError = ""); $eMsg .= "<br>Member with email '$email' already exists";
    }

    if(count($errors) == 0){
        $ID = "CKM_".rand(0000,9999);
        $cryptPwd = md5($password2);
        $query = mysqli_query($dbConn, "INSERT INTO members(memberID,username,fName,lName,email,password,dCreated) VALUES('$ID','$username','$fName','$lName','$email','$cryptPwd', NOW())");
        if($query){
            $sMsg = "Your account was created successfully";
            $msg = "$username registered as a member";
            $log = logActivity($msg,$type='public');
            if($log == 'success'){
                $sMsg .= "<br>action has been logged";
            }
            else{
                $sMsg = $msg;
                $eMsg = $log;
            }
            $accountSuccess = true;
        }
        else{
            $eMsg = "Something went wrong ".mysqli_error($dbConn);
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
                                <?php include("../admin/includes/alerts.php"); ?>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                        <p class="text-center small">The fields marked with (<span class="text-danger">*</span>) must be filled appropriately.</p>
                                    </div>

                                    <form class="row g-3" action="" method="post">

                                        <div class="col-12">
                                            <label for="" class="form-label">Username</label>
                                            <div class="input-group">
                                                <input type="text" name="username" class="form-control" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>">
                                            </div>
                                            <span class="text-danger"><?php if(isset($usernameError)){echo $usernameError;} ?></span>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="form-label">First Name</label>
                                            <div class="input-group">
                                                <input type="text" name="fName" class="form-control" value="<?php if(isset($_POST['fName'])){echo $_POST['fName'];} ?>">
                                            </div>
                                            <span class="text-danger"><?php if(isset($fNameError)){echo $fNameError;} ?></span>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="form-label">Last Name</label>
                                            <div class="input-group">
                                                <input type="text" name="lName" class="form-control" value="<?php if(isset($_POST['lName'])){echo $_POST['lName'];} ?>">
                                            </div>
                                            <span class="text-danger"><?php if(isset($lNameError)){echo $lNameError;} ?></span>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="form-label">Email Address</label>
                                            <div class="input-group">
                                                <input type="email" name="email" class="form-control" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                                            </div>
                                            <span class="text-danger"><?php if(isset($emailError)){echo $emailError;} ?></span>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" class="form-control" value="<?php if(isset($_POST['password'])){echo $_POST['password'];} ?>">
                                            </div>
                                            <span class="text-danger"><?php if(isset($passwordError)){echo $passwordError;} ?></span>
                                        </div>

                                        <div class="col-12">
                                            <label for="" class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password2" class="form-control" value="<?php if(isset($_POST['password2'])){echo $_POST['password2'];} ?>">
                                            </div>
                                            <span class="text-danger"><?php if(isset($password2Error)){echo $password2Error;} ?></span>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">I am human</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-warning w-100" name="register" type="submit">Continue</button>
                                        </div>

                                        <div class="col-12">
                                            <p class="small mb-0">Already a member? <a href="<?php $membersURL; ?>login">Sign in</a></p>
                                        </div>
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
