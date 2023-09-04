<?php
session_start();
if(!isset($_SESSION['ck_Admin']) || $_SESSION['ck_Admin'] == ""){
    $_SESSION['authMsg'] = "You must login to continue";
    header("Location: login");
    exit();
}
else{
    $curAdminID = $_SESSION['ck_Admin'];

    $fetchAdminData = mysqli_query($dbConn, "SELECT admin.id, admin.username, admin.email, admin.image, admin.password, admin.dCreated, admin.dUpdated, admin.status, admin.about, admin.fName, admin.mName, admin.lName, admin.phone, admin.company, admin.job, admin.address, admin.country, admin.twurl, admin.fburl, admin.igurl, admin.lkurl, roles.name AS adminRole FROM admin LEFT JOIN roles ON admin.role=roles.id WHERE admin.adminID='$curAdminID'");
    if(mysqli_num_rows($fetchAdminData) < 1){
        $_SESSION['authMsg'] = "Invalid user encountered";
        header("Location: login");
        exit();
    }
    else{
        $adminData = mysqli_fetch_array($fetchAdminData);
        $curAdUsername = $adminData['username'];
        $curAdEmail = $adminData['email'];
        $curAdImage = $adminData['image'];
        $curAdDCreated = $adminData['dCreated'];
        $curAdDUpdated = $adminData['dUpdated'];
        $curAdDCreated2 = date("M jS, Y h:ia", strtotime($adminData['dCreated']));
        $curAdDUpdated2 = date("M jS, Y h:ia", strtotime($adminData['dUpdated']));
        $curAdRole = $adminData['adminRole'];
        $curAdStatus = $adminData['status'];
        $curAdPwd = $adminData['password'];
        $curAdId = $adminData['id'];
        $curAdAbout = $adminData['about'];
        $curAdFName = $adminData['fName'];
        $curAdMName = $adminData['mName'];
        $curAdLName = $adminData['lName'];
        $curAdPhone = $adminData['phone'];
        $curAdCompany = $adminData['company'];
        $curAdJob = $adminData['job'];
        $curAdAddress = $adminData['address'];
        $curAdCountry = $adminData['country'];
        $curAdTWUrl = $adminData['twurl'];
        $curAdFBUrl = $adminData['fburl'];
        $curAdIGUrl = $adminData['igurl'];
        $curAdLKUrl = $adminData['lkurl'];
    }

}

?>
