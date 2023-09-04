<?php
#development environment URLs
$appURL = "http://localhost/ciw/miradan-interiors/";
$adminURL = "http://localhost/ciw/miradan-interiors/admin/";
$membersURL = "http://localhost/ciw/miradan-interiors/members/";
$uploadsURL = "http://localhost/ciw/miradan-interiors/admin/uploads/";


#database connection string
$dbConn = mysqli_connect("localhost","root","","couz_konnect");

$errors = [];


function logActivity($msg,$type="mgmt"){
    global $dbConn;
    $query = mysqli_query($dbConn, "INSERT INTO action_logs(msg,type,dCreated) VALUES('$msg','$type',NOW())");
    if($query){
        return "success";
    }
    else{
        return "error ".mysqli_error($dbConn);
    }
}

function getTimeAgo($logTime){
    $timeDiff = time() - $logTime;
    if($timeDiff < 1){
        return "-1 sec ago";
    }

    $standardTimes = array(
        12 * 30 * 24 * 60 * 60 => 'yr',
        30 * 24 * 60 * 60      => 'mth',
         7 * 24 * 60 * 60      => 'wk',
        24 * 60 * 60           => 'day',
        60 * 60                => 'hr',
        60                     => 'min',
        1                      => 'sec',
    );

    foreach($standardTimes as $secs => $str){
        $timeVal = $timeDiff/$secs;
        if($timeVal >= 1){
            $roundedTime = round($timeVal);
            return $roundedTime." ".$str.($roundedTime > 1 ? 's' : '')." ago";
        }
    }
}

?>
