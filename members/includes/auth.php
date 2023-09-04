<?php
session_start();
if(!isset($_SESSION['ck_Member']) || $_SESSION['ck_Member'] == ""){
    $_SESSION['authMsg'] = "You must login to continue";
    header("Location: login");
    exit();
}
else{
    $curMemberID = $_SESSION['ck_Member'];

    $fetchMemberData = mysqli_query($dbConn, "SELECT * FROM members WHERE memberID='$curMemberID'");
    if(mysqli_num_rows($fetchMemberData) < 1){
        $_SESSION['authMsg'] = "Invalid user encountered";
        header("Location: login");
        exit();
    }
    else{
        $memberData = mysqli_fetch_array($fetchMemberData);
        $curMbrUsername = $memberData['username'];
        $curMbrEmail = $memberData['email'];
        $curMbrImage = $memberData['image'];
        $curMbrDCreated = $memberData['dCreated'];
        $curMbrDUpdated = $memberData['dUpdated'];
        $curMbrDCreated2 = date("M jS, Y h:ia", strtotime($memberData['dCreated']));
        $curMbrDUpdated2 = date("M jS, Y h:ia", strtotime($memberData['dUpdated']));
        $curMbrStatus = $memberData['status'];
        $curMbrPwd = $memberData['password'];
        $curMbrId = $memberData['id'];
        $curMbrAbout = $memberData['about'];
        $curMbrFName = $memberData['fName'];
        $curMbrMName = $memberData['mName'];
        $curMbrLName = $memberData['lName'];
        $curMbrPhone = $memberData['phone'];
        $curMbrAddress = $memberData['address'];
        $curMbrCountry = $memberData['country'];
    }

}

?>
