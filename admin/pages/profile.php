<?php
include("../includes/config.php");
include("../includes/auth.php");

define("TITLE","Profile | ".strtoupper($curAdUsername));
define("PAGE_TITLE","$curAdminID | ".strtoupper($curAdUsername)." ($curAdRole)");
define("BREADCRUMB","profile");
define("ICON","id-card");

#update profile
if(isset($_POST['updateProfile'])){
    $fName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['fName'])));
    $mName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['mName'])));
    $lName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['lName'])));
    $about = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['about'])));
    $company = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['company'])));
    $job = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['job'])));
    $country = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['country'])));
    $country = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['country'])));
    $address = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['address'])));
    $phone = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['phone'])));
    $twurl = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['twurl'])));
    $fburl = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['fburl'])));
    $igurl = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['igurl'])));
    $lkurl = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['lkurl'])));

    if(count($errors) == 0){
        $query = mysqli_query($dbConn, "UPDATE admin SET fName='$fName', mName='$mName', lName='$lName', about='$about', job='$job', company='$company', country='$country', address='$address', phone='$phone', twurl='$twurl', fburl='$fburl', igurl='$igurl', lkurl='$lkurl', dUpdated=NOW() WHERE id=$curAdId");
        if($query){
            $sMsg = "Profile update was successful";
        }
        else{
            $eMsg = "Something went wrong ".mysqli_error($dbConn);
        }
    }
}

#change password
if(isset($_POST['changePwd'])){
    $oldPwd = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['oldPwd'])));
    $newPwd1 = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['newPwd1'])));
    $newPwd2 = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['newPwd2'])));

    if(empty($oldPwd)){ array_push($errors, $oldPwdError = "Old password is required"); }
    if(empty($newPwd1)){ array_push($errors, $newPwd1Error = "New password is required"); }
    if(empty($newPwd2)){ array_push($errors, $newPwd2Error = "New password confirmation is required"); }

    if($newPwd1 != $newPwd2){ array_push($errors, $pwdMatchError = ""); $eMsg = "The two passwords do not match"; }

    if(!empty($oldPwd) && md5($oldPwd) != $curAdPwd){ array_push($errors, $pwdChkError = ""); $eMsg = "Incorrect old password provided"; }

    if(!empty($newPwd2) && md5($newPwd2) == $curAdPwd){ array_push($errors, $pwdModError = ""); $eMsg = "The new password is same as the current password. Please modify to continue"; }

    if(count($errors) == 0){
        $cryptPwd = md5($newPwd2);
        $query = mysqli_query($dbConn, "UPDATE admin SET password='$cryptPwd', dUpdated=NOW() WHERE id=$curAdId");
        if($query){
            $sMsg = "Your password change request was completed successfully";
            $url = $adminURL."logout";
            header("Refresh: 10; url=$url");
        }
        else{
            $eMsg = "Something went wrong ".mysqli_error($dbConn);
        }
    }
}

#add image
if(isset($_POST['changeImage'])){
    $image = $_FILES['image']['name'];

    if(!empty($image)){
        $ext = substr($image, strlen($image)-4, strlen($image));
        $reqExts = ['.jpg','.JPG','.png','.PNG'];
        if(!in_array($ext, $reqExts)){
            array_push($errors, $imageError = "Invalid file format encountered. Kindly upload a valid file format");
        }
//        if($_FILES['image']['size'] > 2048){
//            array_push($errors, $imageError = "Your image size exceeded the maximum allowed value of 2MB");
//        }
    }
    else{
        array_push($errors, $imageError = "Please select an image to continue");
    }

    if(count($errors) == 0){
        $nwImgName = $curAdUsername.$ext;
        $query = mysqli_query($dbConn, "UPDATE admin SET image='$nwImgName', dUpdated=NOW() WHERE id=$curAdId");
        if($query){
            if(file_exists("../uploads/images/users/admin/$nwImgName")) unlink("../uploads/images/users/admin/$nwImgName");
            if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/images/users/admin/".$nwImgName)){
                $sMsg = "Your image has been updated";
                $url = $adminURL."profile?shw=overview";
                header("Refresh: 6; url=$url");
            }
        }
        else{
            $eMsg = "Image could not be added";
        }
    }
}
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

        <?php include("../includes/alerts.php"); ?>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <img src="<?php echo $uploadsURL; ?>images/users/admin/<?php echo $curAdImage; ?>" alt="Profile" class="rounded-circle" width="200" height="120">
                            <h2><?php echo "$curAdLName $curAdFName $curAdMName"; ?></h2>
                            <h3><?php echo $curAdJob; ?></h3>
                            <div class="social-links mt-2">
                                <a href="<?php echo $curAdTWUrl; ?>" class="twitter" target="_blank"><i class="bi bi-twitter"></i></a>
                                <a href="<?php echo $curAdFBUrl; ?>" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                                <a href="<?php echo $curAdIGUrl; ?>" class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                                <a href="<?php echo $curAdLKUrl; ?>" class="linkedin" target="_blank"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <a href="<?php echo $adminURL; ?>profile?shw=overview" class="nav-link <?php if(isset($_GET['shw']) && $_GET['shw'] == "overview"){ echo "active"; } ?>">Overview</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $adminURL; ?>profile?shw=edit-profile" class="nav-link <?php if(isset($_GET['shw']) && $_GET['shw'] == "edit-profile"){ echo "active"; } ?>">Edit Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $adminURL; ?>profile?shw=change-pwd" class="nav-link <?php if(isset($_GET['shw']) && $_GET['shw'] == "change-pwd"){ echo "active"; } ?>">Change Password</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $adminURL; ?>profile?shw=change-image" class="nav-link <?php if(isset($_GET['shw']) && $_GET['shw'] == "change-image"){ echo "active"; } ?>">Change Profile Image</a>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show profile-overview <?php if(isset($_GET['shw']) && $_GET['shw'] == "overview"){ echo "active"; } ?>">
                                    <h5 class="card-title">About</h5>
                                    <p class="small fst-italic text-justify"><?php echo $curAdAbout; ?></p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">ID</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curAdminID; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Username</div>
                                        <div class="col-lg-9 col-md-8"><?php echo ucwords($curAdUsername); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Role</div>
                                        <div class="col-lg-9 col-md-8"><?php echo ucwords($curAdRole); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8"><?php echo "$curAdLName $curAdFName $curAdMName"; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Company</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curAdCompany; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Job</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curAdJob; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Country</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curAdCountry; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curAdAddress; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curAdPhone; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curAdEmail; ?></div>
                                    </div>

                                </div>

                                <div class="tab-pane fade show profile-edit <?php if(isset($_GET['shw']) && $_GET['shw'] == "edit-profile"){ echo "active"; } ?>">

                                    <!-- Profile Edit Form -->
                                    <form action="" method="post">
                                        <div class="row text-end">
                                            <p class="small">Updated on <span class="text-primary"><?php echo $curAdDUpdated2; ?></span></p>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                            <div class="col-md-5 col-lg-9">
                                                <img src="<?php echo $uploadsURL; ?>images/users/admin/<?php echo $curAdImage; ?>" class="rounded" width="200" height="120" alt="Profile">
                                                <div class="pt-2">
                                                    <a href="<?php echo $adminURL; ?>profile?shw=change-image" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                    <a href="<?php echo $adminURL; ?>profile?do=rmv-image" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fName" type="text" class="form-control" id="fName" value="<?php if(isset($_POST['fName'])){ echo $_POST['fName']; }else{ echo $curAdFName; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="mName" class="col-md-4 col-lg-3 col-form-label">Middle Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="mName" type="text" class="form-control" id="mName" value="<?php if(isset($_POST['mName'])){ echo $_POST['mName']; }else{ echo $curAdMName; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="lName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="lName" type="text" class="form-control" id="lName" value="<?php if(isset($_POST['lName'])){ echo $_POST['lName']; }else{ echo $curAdLName; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="about" class="form-control" id="about" style="height: 100px"><?php if(isset($_POST['about'])){ echo $_POST['about']; }else{ echo $curAdAbout; } ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="company" type="text" class="form-control" id="company" value="<?php if(isset($_POST['company'])){ echo $_POST['company']; }else{ echo $curAdCompany; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Country" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="job" id="" class="form-select">
                                                    <option value="">--please select--</option>
                                                    <option <?php if(isset($_POST['job']) && ($_POST['job'] == "Web Developer") || $curAdJob == "Web Developer"){ echo "selected"; } ?> value="Web Developer">Web Developer</option>
                                                    <option <?php if(isset($_POST['job']) && ($_POST['job'] == "UI UX Designer") || $curAdJob == "UI UX Designer"){ echo "selected"; } ?> value="UI UX Designer">UI UX Designer</option>
                                                    <option <?php if(isset($_POST['job']) && ($_POST['job'] == "Analyst") || $curAdJob == "Analyst"){ echo "selected"; } ?> value="Analyst">Analyst</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="country" id="" class="form-select">
                                                    <option value="">--please select--</option>
                                                    <option <?php if(isset($_POST['country']) && ($_POST['country'] == "Nigeria") || $curAdCountry == "Nigeria"){ echo "selected"; } ?> value="Nigeria">NIgeria</option>
                                                    <option <?php if(isset($_POST['country']) && ($_POST['country'] == "Norway") || $curAdCountry == "Norway"){ echo "selected"; } ?> value="Norway">Norway</option>
                                                    <option <?php if(isset($_POST['country']) && ($_POST['country'] == "Libya") || $curAdCountry == "Libya"){ echo "selected"; } ?> value="Libya">Libya</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address" type="text" class="form-control" id="Address" value="<?php if(isset($_POST['address'])){ echo $_POST['address']; }else{ echo $curAdAddress; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="text" class="form-control" id="Phone" value="<?php if(isset($_POST['phone'])){ echo $_POST['phone']; }else{ echo $curAdPhone; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }else{ echo $curAdEmail; } ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="twurl" type="text" class="form-control" id="Twitter" placeholder="e.g. https://twitter.com/username" value="<?php if(isset($_POST['twurl'])){ echo $_POST['twurl']; }else{ echo $curAdTWUrl; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fburl" type="text" class="form-control" id="Facebook" placeholder="e.g. https://facebook.com/username" value="<?php if(isset($_POST['fburl'])){ echo $_POST['fburl']; }else{ echo $curAdFBUrl; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="igurl" type="text" class="form-control" id="Instagram" placeholder="e.g. https://insagram.com/username" value="<?php if(isset($_POST['igurl'])){ echo $_POST['igurl']; }else{ echo $curAdIGUrl; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="lkurl" type="text" class="form-control" id="Linkedin" placeholder="e.g. https://linkedin.com/username" value="<?php if(isset($_POST['lkurl'])){ echo $_POST['lkurl']; }else{ echo $curAdLKUrl; } ?>">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" name="updateProfile" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade show <?php if(isset($_GET['shw']) && $_GET['shw'] == "change-pwd"){ echo "active"; } ?>">
                                    <!-- Change Password Form -->
                                    <form action="" method="post">

                                        <div class="row mb-3 mt-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="oldPwd" type="password" class="form-control" value="<?php if(isset($_POST['oldPwd'])){echo $_POST['oldPwd'];} ?>">
                                                <span class="text-danger"><?php if(isset($oldPwdError)){ echo $oldPwdError; } ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newPwd1" type="password" class="form-control" value="<?php if(isset($_POST['newPwd1'])){echo $_POST['newPwd1'];} ?>">
                                                <span class="text-danger"><?php if(isset($newPwd1Error)){ echo $newPwd1Error; } ?></span>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Confirm New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newPwd2" type="password" class="form-control" value="<?php if(isset($_POST['newPwd2'])){echo $_POST['newPwd2'];} ?>">
                                                <span class="text-danger"><?php if(isset($newPwd2Error)){ echo $newPwd2Error; } ?></span>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary" name="changePwd">Change</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                                <div class="tab-pane fade show <?php if(isset($_GET['shw']) && $_GET['shw'] == "change-image"){ echo "active"; } ?>">
                                    <!-- Change Password Form -->
                                    <form action="" method="post" enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h2 class="card-title">Update Picture</h2>
                                                        <form action="" method="post" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="">Image File <small class="text-info">(png/PNG,jpg/JPG)</small></label>
                                                                    <input type="file" class="form-control" name="image" onchange="displayImage(this)">
                                                                    <span class="text-danger"><?php if(isset($imageErr)){ echo $imageErr; } ?></span>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="mt-2">
                                                                        <button type="submit" class="btn btn-primary" name="changeImage">Update</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h2 class="card-title">Current Picture</h2>

                                                        <div class="row">
                                                            <div class="col-md-12 text-center">
                                                                <div>
                                                                    <img class="imageThumb rounded-circle" src="<?php echo $uploadsURL; ?>images/users/admin/<?php echo $curAdImage; ?>" style="width:180px;height:180px;" alt="User Profile Picture">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

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
