<?php
include("../../admin/includes/config.php");
include("../includes/auth.php");

define("TITLE","Profile | ".strtoupper($curMbrUsername));
define("PAGE_TITLE","$curMemberID | ".strtoupper($curMbrUsername));
define("BREADCRUMB","profile");
define("ICON","id-card");

#update profile
if(isset($_POST['updateProfile'])){
    $fName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['fName'])));
    $mName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['mName'])));
    $lName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['lName'])));
    $about = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['about'])));
    $country = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['country'])));
    $address = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['address'])));
    $phone = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['phone'])));

    if(count($errors) == 0){
        $query = mysqli_query($dbConn, "UPDATE members SET fName='$fName', mName='$mName', lName='$lName', about='$about',country='$country', address='$address', phone='$phone', dUpdated=NOW() WHERE id=$curMbrId");
        if($query){
            $sMsg = "Profile update was successful";
            $msg = "$curMbrUsername updated their profile";
            $log = logActivity($msg,$type='public');
            if($log == 'success'){
                $sMsg .= "<br>action has been logged";
            }
            else{
                $sMsg = $msg;
                $eMsg = $log;
            }
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

    if(!empty($oldPwd) && md5($oldPwd) != $curMbrPwd){ array_push($errors, $pwdChkError = ""); $eMsg = "Incorrect old password provided"; }

    if(!empty($newPwd2) && md5($newPwd2) == $curMbrPwd){ array_push($errors, $pwdModError = ""); $eMsg = "The new password is same as the current password. Please modify to continue"; }

    if(count($errors) == 0){
        $cryptPwd = md5($newPwd2);
        $query = mysqli_query($dbConn, "UPDATE members SET password='$cryptPwd', dUpdated=NOW() WHERE id=$curMbrId");
        if($query){
            $sMsg = "Your password change request was completed successfully";
            $msg = "$curMbrUsername changed their paassword";
            $log = logActivity($msg,$type='public');
            if($log == 'success'){
                $sMsg .= "<br>action has been logged";
            }
            else{
                $sMsg = $msg;
                $eMsg = $log;
            }
            $url = $membersURL."logout";
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
        $nwImgName = $curMbrUsername.$ext;
        $query = mysqli_query($dbConn, "UPDATE members SET image='$nwImgName', dUpdated=NOW() WHERE id=$curMbrId");
        if($query){
            if(file_exists("../../admin/uploads/images/users/members/$nwImgName")) unlink("../../admin/uploads/images/users/members/$nwImgName");
            if(move_uploaded_file($_FILES['image']['tmp_name'], "../../admin/uploads/images/users/members/".$nwImgName)){
                $sMsg = "Your image has been updated";
                $msg = "$curMbrUsername updated their display image";
                $log = logActivity($msg,$type='public');
                if($log == 'success'){
                    $sMsg .= "<br>action has been logged";
                }
                else{
                    $sMsg = $msg;
                    $eMsg = $log;
                }
                $url = $membersURL."profile?shw=overview";
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

        <?php include("../../admin/includes/alerts.php"); ?>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <img src="<?php echo $uploadsURL; ?>images/users/members/<?php echo $curMbrImage; ?>" alt="Profile" class="rounded-circle" width="200" height="120">
                            <h2><?php echo "$curMbrLName $curMbrFName $curMbrMName"; ?></h2>

                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <a href="<?php echo $membersURL; ?>profile?shw=overview" class="nav-link <?php if(isset($_GET['shw']) && $_GET['shw'] == "overview"){ echo "active"; } ?>">Overview</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $membersURL; ?>profile?shw=edit-profile" class="nav-link <?php if(isset($_GET['shw']) && $_GET['shw'] == "edit-profile"){ echo "active"; } ?>">Edit Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $membersURL; ?>profile?shw=change-pwd" class="nav-link <?php if(isset($_GET['shw']) && $_GET['shw'] == "change-pwd"){ echo "active"; } ?>">Change Password</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $membersURL; ?>profile?shw=change-image" class="nav-link <?php if(isset($_GET['shw']) && $_GET['shw'] == "change-image"){ echo "active"; } ?>">Change Profile Image</a>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show profile-overview <?php if(isset($_GET['shw']) && $_GET['shw'] == "overview"){ echo "active"; } ?>">
                                    <h5 class="card-title">About</h5>
                                    <p class="small fst-italic text-justify"><?php echo $curMbrAbout; ?></p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">ID</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curMemberID; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Username</div>
                                        <div class="col-lg-9 col-md-8"><?php echo ucwords($curMbrUsername); ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8"><?php echo "$curMbrLName $curMbrFName $curMbrMName"; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Country</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curMbrCountry; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Address</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curMbrAddress; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curMbrPhone; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $curMbrEmail; ?></div>
                                    </div>

                                </div>

                                <div class="tab-pane fade show profile-edit <?php if(isset($_GET['shw']) && $_GET['shw'] == "edit-profile"){ echo "active"; } ?>">

                                    <!-- Profile Edit Form -->
                                    <form action="" method="post">
                                        <div class="row text-end">
                                            <p class="small">Updated on <span class="text-primary"><?php echo $curMbrDUpdated2; ?></span></p>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                            <div class="col-md-5 col-lg-9">
                                                <img src="<?php echo $uploadsURL; ?>images/users/members/<?php echo $curMbrImage; ?>" class="rounded" width="200" height="120" alt="Profile">
                                                <div class="pt-2">
                                                    <a href="<?php echo $membersURL; ?>profile?shw=change-image" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                    <a href="<?php echo $membersURL; ?>profile?do=rmv-image" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fName" type="text" class="form-control" id="fName" value="<?php if(isset($_POST['fName'])){ echo $_POST['fName']; }else{ echo $curMbrFName; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="mName" class="col-md-4 col-lg-3 col-form-label">Middle Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="mName" type="text" class="form-control" id="mName" value="<?php if(isset($_POST['mName'])){ echo $_POST['mName']; }else{ echo $curMbrMName; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="lName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="lName" type="text" class="form-control" id="lName" value="<?php if(isset($_POST['lName'])){ echo $_POST['lName']; }else{ echo $curMbrLName; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="about" class="form-control" id="about" style="height: 100px"><?php if(isset($_POST['about'])){ echo $_POST['about']; }else{ echo $curMbrAbout; } ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="country" id="" class="form-select">
                                                    <option value="">--please select--</option>
                                                    <option <?php if(isset($_POST['country']) && ($_POST['country'] == "Nigeria") || $curMbrCountry == "Nigeria"){ echo "selected"; } ?> value="Nigeria">NIgeria</option>
                                                    <option <?php if(isset($_POST['country']) && ($_POST['country'] == "Norway") || $curMbrCountry == "Norway"){ echo "selected"; } ?> value="Norway">Norway</option>
                                                    <option <?php if(isset($_POST['country']) && ($_POST['country'] == "Libya") || $curMbrCountry == "Libya"){ echo "selected"; } ?> value="Libya">Libya</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address" type="text" class="form-control" id="Address" value="<?php if(isset($_POST['address'])){ echo $_POST['address']; }else{ echo $curMbrAddress; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="text" class="form-control" id="Phone" value="<?php if(isset($_POST['phone'])){ echo $_POST['phone']; }else{ echo $curMbrPhone; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }else{ echo $curMbrEmail; } ?>" readonly>
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
                                                                    <img class="imageThumb rounded-circle" src="<?php echo $uploadsURL; ?>images/users/members/<?php echo $curMbrImage; ?>" style="width:180px;height:180px;" alt="User Profile Picture">
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
