<?php
include("../includes/config.php");
include("../includes/auth.php");

define("TITLE","Users");
define("PAGE_TITLE","Manage Users");
define("BREADCRUMB","users");
define("ICON","users");

$pageURL = $adminURL."users?vw=users";

$cardNewTitle = $cardManageTitle = "";
if((isset($_GET['prf']) && $_GET['prf'] == "new-user") || (isset($_GET['vw']) && $_GET['vw'] == "users")){
    $cardNewTitle = "New User";
    $cardManageTitle = "Manage Users";
    if(isset($_GET['do']) && $_GET['do'] == "edit-user"){
        $cardNewTitle = "Edit User";
    }
    if(isset($_GET['do']) && $_GET['do'] == "add-user-image"){
        $cardNewTitle = "Upload Picture";
    }
}
elseif((isset($_GET['prf']) && $_GET['prf'] == "new-member") || (isset($_GET['vw']) && $_GET['vw'] == "members")){
    $cardNewTitle = "New Member";
    $cardManageTitle = "Manage Members";
    if(isset($_GET['do']) && $_GET['do'] == "edit-member"){
        $cardNewTitle = "Edit Member";
    }
    if(isset($_GET['do']) && $_GET['do'] == "add-member-image"){
        $cardNewTitle = "Upload Picture";
    }
}
elseif((isset($_GET['prf']) && $_GET['prf'] == "new-role") || (isset($_GET['vw']) && $_GET['vw'] == "roles")){
    $cardNewTitle = "New Role";
    $cardManageTitle = "Manage Roles";
    if(isset($_GET['do']) && $_GET['do'] == "edit-role"){
        $cardNewTitle = "Edit Role";
    }
}

#USER
#add user
if(isset($_POST['addUser'])){
    $username = strtolower(trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['username']))));
    $email = strtolower(trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['email']))));
    $password1 = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['password1'])));
    $password2 = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['password2'])));
    $role = trim(intval($_POST['role']));

    if(empty($username)){ array_push($errors, $usernameError = "Username is required"); }
    if(empty($email)){ array_push($errors, $emailError = "Email is required"); }
    if(empty($password1)){ array_push($errors, $password1Error = "Password is required"); }
    if(empty($password2)){ array_push($errors, $password2Error = "Password confirmation is required"); }
    if($role == 0){ array_push($errors, $roleError = "Role is required"); }

    if($password1 != $password2){ array_push($errors, $pwdMatchError = ""); $eMsg = "The two passwords do not match"; }

    #prevent duplicate entry
    $checkAdminUname = mysqli_query($dbConn, "SELECT * FROM admin WHERE username='$username'");
    $checkAdminEmail = mysqli_query($dbConn, "SELECT * FROM admin WHERE email='$email'");
    if(mysqli_num_rows($checkAdminUname) > 0){
        array_push($errors, $adminUnameError = ""); $eMsg = "Admin with username '$username' already exists";
    }
    if(mysqli_num_rows($checkAdminEmail) > 0){
        array_push($errors, $adminEmailError = ""); $eMsg .= "<br>Admin with email '$email' already exists";
    }

    if(count($errors) == 0){
        $ID = "CKA_".rand(0000,9999);
        $cryptPwd = md5($password2);
        $query = mysqli_query($dbConn, "INSERT INTO admin(adminID,username,email,role,password,dCreated) VALUES('$ID','$username','$email',$role,'$cryptPwd', NOW())");
        if($query){
            $sMsg = "Admin with username: '$username' and email: '$email' saved successfully";
        }
        else{
            $eMsg = "Something went wrong ".mysqli_error($dbConn);
        }
    }
}

#add image
if(isset($_POST['addImage'])){
    $id = $_GET['id'];
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
        $nm = $_GET['nm'];
        $nwImgName = $nm.$ext;
        $query = mysqli_query($dbConn, "UPDATE admin SET image='$nwImgName', dUpdated=NOW() WHERE id=$id");
        if($query){
            if(file_exists("../uploads/images/users/admin/$nwImgName")) unlink("../uploads/images/users/admin/$nwImgName");
            if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/images/users/admin/".$nwImgName)){
                $sMsg = "Image added successfully for admin '$nm'";
            }
        }
        else{
            $eMsg = "Image could not be added";
        }
    }
}

#activate user
if(isset($_GET['do']) && $_GET['do'] == "actv-user"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $query = mysqli_query($dbConn, "UPDATE admin SET status='Active', dUpdated=NOW() WHERE id=$id");
    if($query){
        $sMsg = "Admin '$nm' activated successfully";
    }
    else{
        $eMsg = "Role could not be activated";
    }
}

#deactivate user
if(isset($_GET['do']) && $_GET['do'] == "dactv-user"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $query = mysqli_query($dbConn, "UPDATE admin SET status='Inactive', dUpdated=NOW() WHERE id=$id");
    if($query){
        $sMsg = "Admin '$nm' deactivated successfully";
    }
    else{
        $eMsg = "Role could not be deactivated";
    }
}

#delete user
if(isset($_GET['do']) && $_GET['do'] == "del-user"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $delMsg = "Are you sure you wanna delete the admin '$nm'";
    $delItem = true;
    if(isset($_POST['deleteItem'])){
        $delItem = false;
        $query = mysqli_query($dbConn,"DELETE FROM admin WHERE id=$id");
        if($query){
            $sMsg = "Admin '$nm' deleted successfully";
            header("Refresh: 5; url = $pageURL");
        }
        else{
            $eMsg = "Admin could not be deleted";
        }
    }
}

#MEMBER
#add member
if(isset($_POST['addMember'])){
    $username = strtolower(trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['username']))));
    $email = strtolower(trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['email']))));
    $fName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['fName'])));
    $lName = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['lName'])));
    $phone = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['phone'])));
    $password1 = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['password1'])));
    $password2 = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['password2'])));

    if(empty($username)){ array_push($errors, $usernameError = "Username is required"); }
    if(empty($email)){ array_push($errors, $emailError = "Email is required"); }
    if(empty($fName)){ array_push($errors, $fNameError = "First name is required"); }
    if(empty($lName)){ array_push($errors, $lNameError = "Last name is required"); }
    if(empty($phone)){ array_push($errors, $phoneError = "Phone is required"); }
    if(empty($password1)){ array_push($errors, $password1Error = "Password is required"); }
    if(empty($password2)){ array_push($errors, $password2Error = "Password confirmation is required"); }

    if($password1 != $password2){ array_push($errors, $pwdMatchError = ""); $eMsg = "The two passwords do not match"; }

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
        $ID = "CKA_".rand(0000,9999);
        $cryptPwd = md5($password2);
        $query = mysqli_query($dbConn, "INSERT INTO members(memberID,username,fName,lName,email,phone,password,dCreated) VALUES('$ID','$username','$fName','$lName','$email','$phone','$cryptPwd', NOW())");
        if($query){
            $sMsg = "Member with username: '$username' and email: '$email' saved successfully";
        }
        else{
            $eMsg = "Something went wrong ".mysqli_error($dbConn);
        }
    }
}

#add image
if(isset($_POST['addMbrImage'])){
    $id = $_GET['id'];
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
        $nm = $_GET['nm'];
        $nwImgName = $nm.$ext;
        $query = mysqli_query($dbConn, "UPDATE admin SET image='$nwImgName', dUpdated=NOW() WHERE id=$id");
        if($query){
            if(file_exists("../uploads/images/users/admin/$nwImgName")) unlink("../uploads/images/users/admin/$nwImgName");
            if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/images/users/admin/".$nwImgName)){
                $sMsg = "Image added successfully for admin '$nm'";
            }
        }
        else{
            $eMsg = "Image could not be added";
        }
    }
}

#activate member
if(isset($_GET['do']) && $_GET['do'] == "actv-member"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $query = mysqli_query($dbConn, "UPDATE members SET status='Active', dUpdated=NOW() WHERE id=$id");
    if($query){
        $sMsg = "Member '$nm' activated successfully";
    }
    else{
        $eMsg = "Member could not be activated";
    }
}

#deactivate member
if(isset($_GET['do']) && $_GET['do'] == "dactv-member"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $query = mysqli_query($dbConn, "UPDATE members SET status='Inactive', dUpdated=NOW() WHERE id=$id");
    if($query){
        $sMsg = "Member '$nm' deactivated successfully";
    }
    else{
        $eMsg = "Member could not be deactivated";
    }
}

#delete member
if(isset($_GET['do']) && $_GET['do'] == "del-member"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $delMsg = "Are you sure you wanna delete the member '$nm'";
    $delItem = true;
    if(isset($_POST['deleteItem'])){
        $delItem = false;
        $query = mysqli_query($dbConn,"DELETE FROM members WHERE id=$id");
        if($query){
            $sMsg = "Member '$nm' deleted successfully";
            header("Refresh: 5; url = $pageURL");
        }
        else{
            $eMsg = "Member could not be deleted";
        }
    }
}


#ROLE
#add role logic
if(isset($_POST['addRole'])){
    $name = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['roleName'])));

    if(empty($name)){ array_push($errors, $roleNameError = "Role name is required"); }

    #prevent duplicate entry
    $checkRole = mysqli_query($dbConn, "SELECT * FROM roles WHERE name='$name'");
    if(mysqli_num_rows($checkRole) > 0){
        array_push($errors, $roleExistsError = ""); $eMsg = "Role '$name' already exists";
    }

    if(count($errors) == 0){
        $query = mysqli_query($dbConn, "INSERT INTO roles(name, dCreated) VALUES('$name', NOW())");
        if($query){
            $sMsg = "Role '$name' saved successfully";
        }
        else{
            $eMsg = "Something went wrong ".mysqli_error($dbConn);
        }
    }
}

#update role logic
if(isset($_POST['updateRole'])){
    $rId = $_GET['id'];
    $name = trim(stripslashes(mysqli_real_escape_string($dbConn, $_POST['roleName'])));

    if(empty($name)){ array_push($errors, $roleNameError = "Role name is required"); }

    #prevent duplicate entry or same value update
    $dbRole = mysqli_query($dbConn, "SELECT * FROM roles WHERE id=$rId");
    $rData = mysqli_fetch_array($dbRole);
    $rName = $rData['name'];
    if($rName == $name){
        array_push($errors, $roleExistsError = "")
        ; $eMsg = "Modification required";
    }
    else{
        $checkRole = mysqli_query($dbConn, "SELECT * FROM roles WHERE name='$name'");
        if(mysqli_num_rows($checkRole) > 0){
            array_push($errors, $roleExistsError = ""); $eMsg = "Role '$name' already exists";
        }
    }

    if(count($errors) == 0){
        $query = mysqli_query($dbConn, "UPDATE roles SET name='$name', dUpdated=NOW() WHERE id=$rId");
        if($query){
            $sMsg = "Role '$rName' updated successfully to '$name'";
        }
        else{
            $eMsg = "Something went wrong ".mysqli_error($dbConn);
        }
    }
}

#activate role
if(isset($_GET['do']) && $_GET['do'] == "actv-role"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $query = mysqli_query($dbConn, "UPDATE roles SET status='Active', dUpdated=NOW() WHERE id=$id");
    if($query){
        $sMsg = "role '$nm' activated successfully by $curAdminID";
        $msg = "$curAdminID activated role ($nm)";
        $log = logActivity($msg);
        if($log == 'success'){
            $sMsg .= "<br>action has been logged";
        }
        else{
            $sMsg = $msg;
            $eMsg = $log;
        }
    }
    else{
        $eMsg = "Role could not be activated";
    }
}

#deactivate role
if(isset($_GET['do']) && $_GET['do'] == "dactv-role"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $query = mysqli_query($dbConn, "UPDATE roles SET status='Inactive', dUpdated=NOW() WHERE id=$id");
    if($query){
        $sMsg = "role '$nm' deactivated successfully by $curAdminID";
        $msg = "$curAdminID deactivated role ($nm)";
        $log = logActivity($msg);
        if($log == 'success'){
            $sMsg .= "<br>action has been logged";
        }
        else{
            $sMsg = $msg;
            $eMsg = $log;
        }
    }
    else{
        $eMsg = "Role could not be deactivated";
    }
}

#delete role
if(isset($_GET['do']) && $_GET['do'] == "del-role"){
    $id = intval($_GET['id']);
    $nm = $_GET['nm'];
    $delMsg = "Are you sure you wanna delete the role '$nm'";
    $delItem = true;
    if(isset($_POST['deleteItem'])){
        $delItem = false;
        $query = mysqli_query($dbConn,"DELETE FROM roles WHERE id=$id");
        if($query){
            $sMsg = "Role '$nm' deleted successfully";
            header("Refresh: 5; url = $pageURL");
        }
        else{
            $eMsg = "Role could not be deleted";
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
        <section class="section dashboard">
            <div class="bg-white p-4 mb-5">
                <?php if($curAdRole == "Owner" || $curAdRole == "Super Admin" || $curAdRole == "Admin"): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        New
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo $adminURL; ?>users?sz=min&prf=new-user&vw=users">User</a>
                        <a class="dropdown-item" href="<?php echo $adminURL; ?>users?sz=min&prf=new-member&vw=members">Member</a>
                        <a class="dropdown-item" href="<?php echo $adminURL; ?>users?sz=min&prf=new-role&vw=roles">Role</a>
                    </div>
                </div>
                <?php endif ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        Manage
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo $adminURL; ?>users?vw=users">Users</a>
                        <a class="dropdown-item" href="<?php echo $adminURL; ?>users?vw=members">Members</a>
                        <a class="dropdown-item" href="<?php echo $adminURL; ?>users?vw=roles">Roles</a>
                    </div>
                </div>
                <div class="btn-group float-end">
                    <a href="<?php echo $adminURL; ?>template" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>
                </div>
            </div>


            <div class="row">
                <?php if(isset($_GET['sz']) && $_GET['sz'] == "min"): ?>
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
                            <h4 class="card-title"><?php echo $cardNewTitle; ?></h4>

                            <form action="" method="post" enctype="multipart/form-data">

                                <?php if(isset($_GET['prf']) && $_GET['prf'] == "new-user"): ?>
                                <div id="add-user" class="row">
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>">
                                            <label for="">Username</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($usernameError)){ echo $usernameError; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
                                            <label for="">Email</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($emailError)){ echo $emailError; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="role" aria-label="Floating label select example">
                                                <option value="">-- choose role --</option>
                                                <?php
                                                $query = mysqli_query($dbConn, "SELECT * FROM roles");
                                                while($row = mysqli_fetch_array($query)){
                                                    $id = $row['id']; $name = $row['name'];
                                                ?>
                                                <option <?php if(isset($_POST['role']) && $_POST['role'] == $id){ echo "selected"; } ?> value="<?php echo $id; ?>"><?php echo $name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="">Role</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($roleError)){ echo $roleError; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password1" placeholder="Password" value="<?php if(isset($_POST['password1'])){ echo $_POST['password1']; } ?>">
                                            <label for="password1">Password</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($password1Error)){ echo $password1Error; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password2" placeholder="Confirm Password" value="<?php if(isset($_POST['password2'])){ echo $_POST['password2']; } ?>">
                                            <label for="">Confirm Password</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($password2Error)){ echo $password2Error; } ?></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-success btn-sm" name="addUser">Add</button>
                                        <a href="<?php echo $adminURL; ?>users?vw=users" class="btn btn-danger btn-sm">Cancel</a>
                                    </div>
                                </div>
                                <?php endif ?>

                                <?php if(isset($_GET['prf']) && $_GET['prf'] == "new-member"): ?>
                                <div id="add-member" class="row">
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>">
                                            <label for="">Username</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($usernameError)){ echo $usernameError; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="fName" placeholder="First Name" value="<?php if(isset($_POST['fName'])){ echo $_POST['fName']; } ?>">
                                            <label for="">First Name</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($fNameError)){ echo $fNameError; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="lName" placeholder="Last Name" value="<?php if(isset($_POST['lName'])){ echo $_POST['lName']; } ?>">
                                            <label for="">Last Name</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($lNameError)){ echo $lNameError; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
                                            <label for="">Email</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($emailError)){ echo $emailError; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" name="phone" placeholder="Phone" value="<?php if(isset($_POST['phone'])){ echo $_POST['phone']; } ?>">
                                            <label for="">Phone</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($phoneError)){ echo $phoneError; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password1" placeholder="Password" value="<?php if(isset($_POST['password1'])){ echo $_POST['password1']; } ?>">
                                            <label for="password1">Password</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($password1Error)){ echo $password1Error; } ?></span>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password2" placeholder="Confirm Password" value="<?php if(isset($_POST['password2'])){ echo $_POST['password2']; } ?>">
                                            <label for="">Confirm Password</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($password2Error)){ echo $password2Error; } ?></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-success btn-sm" name="addMember">Add</button>
                                        <a href="<?php echo $adminURL; ?>users?vw=users" class="btn btn-danger btn-sm">Cancel</a>
                                    </div>
                                </div>
                                <?php endif ?>

                                <?php if(isset($_GET['do']) && $_GET['do'] == "add-user-image"): ?>
                                <div id="add-user-image" class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Image <small class="text-info">(png / jpg required and 2MB maximum)</small></label>
                                        <input type="file" class="form-control" name="image" onchange="displayImage(this)" value="<?php if(isset($_POST['image'])){ echo $_POST['image']; } ?>">
                                        <span class="text-danger"><?php if(isset($imageError)){ echo $imageError; } ?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="<?php echo $uploadsURL; ?>images/users/admin/default.png" width="80" height="80" alt="" class="rounded imgThumb mt-3">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-sm" name="addImage">Upload</button>
                                        <a href="<?php echo $adminURL; ?>users?vw=users" class="btn btn-danger btn-sm">Cancel</a>
                                    </div>
                                </div>
                                <?php endif ?>

                                <?php if(isset($_GET['prf']) && $_GET['prf'] == "new-role"): ?>
                                <div id="add-role" class="row">
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="roleName" value="<?php if(isset($_POST['roleName'])){ echo $_POST['roleName']; } ?>">
                                            <label for="">Role Name</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($roleNameError)){ echo $roleNameError; } ?></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-success btn-sm" name="addRole">Add</button>
                                        <a href="<?php echo $adminURL; ?>users?vw=roles" class="btn btn-danger btn-sm">Cancel</a>
                                    </div>
                                </div>
                                <?php endif ?>

                                <?php if(isset($_GET['do']) && $_GET['do'] == "edit-role"): ?>
                                <?php
                                $rId = $_GET['id'];
                                $query = mysqli_query($dbConn, "SELECT * FROM roles WHERE id=$rId");
                                $row = mysqli_fetch_array($query);
                                $id = $row['id']; $name = $row['name'];
                                ?>
                                <div id="edit-role" class="row">
                                    <div class="form-group col-md-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="roleName" value="<?php if(isset($_POST['roleName'])){ echo $_POST['roleName']; }else{ echo $name; } ?>">
                                            <label for="">Role Name</label>
                                        </div>
                                        <span class="text-danger"><?php if(isset($roleNameError)){ echo $roleNameError; } ?></span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-primary btn-sm" name="updateRole">Update</button>
                                        <a href="<?php echo $adminURL; ?>users?vw=users" class="btn btn-danger btn-sm">Cancel</a>
                                    </div>
                                </div>
                                <?php endif ?>

                            </form>

                        </div>
                    </div>
                </div>
                <?php endif ?>
                <div class="col-md-<?php if(isset($_GET['sz']) && $_GET['sz'] == "min"){ echo 8; }else{ echo 12; } ?>">
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
                            <h5 class="card-title"><?php echo $cardManageTitle; ?></h5>

                            <?php if(isset($_GET['vw']) && $_GET['vw'] == "users"): ?>
                            <div class="table-responsive x-scroll">
                                <table class="table datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>S/N</th>
                                            <?php if($curAdRole == "Owner" || $curAdRole == "Super Admin" || $curAdRole == "Admin"): ?>
                                            <th>Action</th>
                                            <?php endif ?>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Image</th>
                                            <th>Date Created</th>
                                            <th>Date Updated</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $No=1;
                                        if($curAdRole == "Owner"){
                                            $query = mysqli_query($dbConn, "SELECT admin.id, admin.adminID, admin.username, admin.email, admin.image, admin.dCreated, admin.dUpdated, admin.status, roles.name AS role FROM admin LEFT JOIN roles ON admin.role=roles.id WHERE roles.name<>'Owner'");
                                        }
                                        elseif($curAdRole == "Super Admin"){
                                            $query = mysqli_query($dbConn, "SELECT admin.id, admin.adminID, admin.username, admin.email, admin.image, admin.dCreated, admin.dUpdated, admin.status, roles.name AS role FROM admin LEFT JOIN roles ON admin.role=roles.id WHERE roles.name<>'Owner' AND roles.name<>'Super Admin'");
                                        }
                                        elseif($curAdRole == "Admin"){
                                            $query = mysqli_query($dbConn, "SELECT admin.id, admin.adminID, admin.username, admin.email, admin.image, admin.dCreated, admin.dUpdated, admin.status, roles.name AS role FROM admin LEFT JOIN roles ON admin.role=roles.id WHERE roles.name='User' AND admin.id<>$curAdId");
                                        }
                                        elseif($curAdRole == "User"){
                                            $query = mysqli_query($dbConn, "SELECT admin.id, admin.adminID, admin.username, admin.email, admin.image, admin.dCreated, admin.dUpdated, admin.status, roles.name AS role FROM admin LEFT JOIN roles ON admin.role=roles.id WHERE roles.name='User' AND admin.id<>$curAdId");
                                        }
                                        while($row=mysqli_fetch_array($query)){
                                            $aId = $row['id'];
                                            $ID = $row['adminID'];
                                            $username = $row['username'];
                                            $email = $row['email'];
                                            $image = $row['image'];
                                            $role = $row['role'];
                                            $dCreated = date("M jS, Y h:ia", strtotime($row['dCreated']));
                                            $nullDU = $row['dUpdated'];
                                            $dUpdated = date("M jS, Y h:ia", strtotime($row['dUpdated']));
                                            $status = $row['status'];
                                        ?>
                                        <tr>
                                            <td><?php echo $No++; ?></td>

                                            <?php if($curAdRole == "Owner" || $curAdRole == "Super Admin" || $curAdRole == "Admin"): ?>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?php echo $adminURL; ?>users?do=edit-role&vw=users&sz=min&id=<?php echo $aId; ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit" title="Edit"></i></a>
                                                    <a href="<?php echo $adminURL; ?>users?do=add-user-image&vw=users&sz=min&nm=<?php echo $username; ?>&id=<?php echo $aId; ?>" class="btn btn-outline-secondary btn-sm"><i class="fa fa-photo" title="Add Image"></i></a>
                                                    <?php if($status != "Active"): ?>

                                                    <?php if($curAdRole == "Owner" || $curAdRole == "Super Admin"): ?>
                                                    <a href="<?php echo $adminURL; ?>users?do=del-user&vw=users&nm=<?php echo $username; ?>&id=<?php echo $aId; ?>" class="btn btn-outline-danger btn-sm" title="Trash"><i class="fa fa-trash"></i></a>
                                                    <?php endif ?>

                                                    <a href="<?php echo $adminURL; ?>users?do=actv-user&vw=users&nm=<?php echo $username; ?>&id=<?php echo $aId; ?>" class="btn btn-outline-primary btn-sm" title="Activate"><i class="fa fa-check"></i></a>
                                                    <?php else: ?>
                                                    <a href="<?php echo $adminURL; ?>users?do=dactv-user&vw=users&nm=<?php echo $username; ?>&id=<?php echo $aId; ?>" class="btn btn-outline-secondary btn-sm" title="Deactivate"><i class="fa fa-times"></i></a>
                                                    <?php endif ?>
                                                </div>
                                            </td>
                                            <?php endif ?>

                                            <td><a href=""><?php echo $ID; ?></a></td>
                                            <td><?php echo $username; ?></td>
                                            <td><a href=""><?php echo $email; ?></a></td>
                                            <td><?php echo $role; ?></td>
                                            <td>
                                                <img src="<?php echo $uploadsURL; ?>images/users/admin/<?php echo $image; ?>" width="40" height="40" alt="" class="rounded-circle">
                                            </td>
                                            <td><?php echo $dCreated; ?></td>
                                            <td><?php if(empty($nullDU)){ echo $nullDU; }else{ echo $dUpdated; } ?></td>
                                            <td>
                                                <?php if($status != "Active"): ?>
                                                <span class="btn btn-sm btn-secondary">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                                <?php else: ?>
                                                <span class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i>
                                                </span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif ?>

                            <?php if(isset($_GET['vw']) && $_GET['vw'] == "members"): ?>
                            <div class="table-responsive x-scroll">
                                <table class="table datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>S/N</th>
                                            <?php if($curAdRole == "Owner" || $curAdRole == "Super Admin" || $curAdRole == "Admin"): ?>
                                            <th>Action</th>
                                            <?php endif ?>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Image</th>
                                            <th>Date Created</th>
                                            <th>Date Updated</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $No=1;
                                        $query = mysqli_query($dbConn, "SELECT * FROM Members");
                                        while($row=mysqli_fetch_array($query)){
                                            $mId = $row['id'];
                                            $ID = $row['memberID'];
                                            $username = $row['username'];
                                            $fName = $row['fName'];
                                            $mName = $row['mName'];
                                            $lName = $row['lName'];
                                            $phone = $row['phone'];
                                            $email = $row['email'];
                                            $image = $row['image'];
                                            $dCreated = date("M jS, Y h:ia", strtotime($row['dCreated']));
                                            $nullDU = $row['dUpdated'];
                                            $dUpdated = date("M jS, Y h:ia", strtotime($row['dUpdated']));
                                            $status = $row['status'];
                                        ?>
                                        <tr>
                                            <td><?php echo $No++; ?></td>

                                            <?php if($curAdRole == "Owner" || $curAdRole == "Super Admin" || $curAdRole == "Admin"): ?>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?php echo $adminURL; ?>users?do=add-member-image&vw=members&sz=min&nm=<?php echo $username; ?>&id=<?php echo $mId; ?>" class="btn btn-outline-secondary btn-sm"><i class="fa fa-photo" title="Add Image"></i></a>
                                                    <?php if($status != "Active"): ?>

                                                    <?php if($curAdRole == "Owner" || $curAdRole == "Super Admin"): ?>
                                                    <a href="<?php echo $adminURL; ?>users?do=del-member&vw=members&nm=<?php echo $username; ?>&id=<?php echo $mId; ?>" class="btn btn-outline-danger btn-sm" title="Trash"><i class="fa fa-trash"></i></a>
                                                    <?php endif ?>

                                                    <a href="<?php echo $adminURL; ?>users?do=actv-member&vw=members&nm=<?php echo $username; ?>&id=<?php echo $mId; ?>" class="btn btn-outline-primary btn-sm" title="Activate"><i class="fa fa-check"></i></a>
                                                    <?php else: ?>
                                                    <a href="<?php echo $adminURL; ?>users?do=dactv-member&vw=members&nm=<?php echo $username; ?>&id=<?php echo $mId; ?>" class="btn btn-outline-secondary btn-sm" title="Deactivate"><i class="fa fa-times"></i></a>
                                                    <?php endif ?>
                                                </div>
                                            </td>
                                            <?php endif ?>

                                            <td><a href=""><?php echo $ID; ?></a></td>
                                            <td><?php echo $username; ?></td>
                                            <td><?php echo "$fName $mName $lName"; ?></td>
                                            <td><a href=""><?php echo $email; ?></a></td>
                                            <td>
                                                <img src="<?php echo $uploadsURL; ?>images/users/members/<?php echo $image; ?>" width="40" height="40" alt="" class="rounded-circle">
                                            </td>
                                            <td><?php echo $dCreated; ?></td>
                                            <td><?php if(empty($nullDU)){ echo $nullDU; }else{ echo $dUpdated; } ?></td>
                                            <td>
                                                <?php if($status != "Active"): ?>
                                                <span class="btn btn-sm btn-secondary">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                                <?php else: ?>
                                                <span class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i>
                                                </span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif ?>

                            <?php if(isset($_GET['vw']) && $_GET['vw'] == "roles"): ?>
                            <div class="table-responsive x-scroll">
                                <table class="table datatable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <td>S/N</td>
                                            <td>Action</td>
                                            <td>Name</td>
                                            <td>Date Created</td>
                                            <td>Date Updated</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $No=1;
                                        $query = mysqli_query($dbConn, "SELECT * FROM roles");
                                        while($row=mysqli_fetch_array($query)){
                                            $rId = $row['id'];
                                            $name = $row['name'];
                                            $dCreated = date("M jS, Y h:ia", strtotime($row['dCreated']));
                                            $nullDU = $row['dUpdated'];
                                            $dUpdated = date("M jS, Y h:ia", strtotime($row['dUpdated']));
                                            $status = $row['status'];
                                        ?>
                                        <tr>
                                            <td><?php echo $No++; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?php echo $adminURL; ?>users?do=edit-role&vw=roles&sz=min&id=<?php echo $rId; ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit" title="Edit"></i></a>
                                                    <?php if($status != "Active"): ?>
                                                    <a href="<?php echo $adminURL; ?>users?do=del-role&vw=roles&nm=<?php echo $name; ?>&id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm" title="Trash"><i class="fa fa-trash"></i></a>
                                                    <a href="<?php echo $adminURL; ?>users?do=actv-role&vw=roles&nm=<?php echo $name; ?>&id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm" title="Activate"><i class="fa fa-check"></i></a>
                                                    <?php else: ?>
                                                    <a href="<?php echo $adminURL; ?>users?do=dactv-role&vw=roles&nm=<?php echo $name; ?>&id=<?php echo $row['id']; ?>" class="btn btn-outline-secondary btn-sm" title="Deactivate"><i class="fa fa-times"></i></a>
                                                    <?php endif ?>
                                                </div>
                                            </td>
                                            <td><?php echo $name; ?></td>
                                            <td><?php echo $dCreated; ?></td>
                                            <td><?php if(empty($nullDU)){ echo $nullDU; }else{ echo $dUpdated; } ?></td>
                                            <td>
                                                <?php if($status != "Active"): ?>
                                                <span class="btn btn-sm btn-secondary">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                                <?php else: ?>
                                                <span class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i>
                                                </span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif ?>
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
    <script type="text/javascript">
        // Live preview chosen image file
        function displayImage(e) {
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.imageThumb').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
            }
        }

    </script>
</body>

</html>
