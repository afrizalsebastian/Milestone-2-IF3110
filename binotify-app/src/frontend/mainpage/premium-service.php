<?php
session_start();
include "../template/side-navbaruserAuth.php";
include "../template/side-navbaruserNonAuth.php";
include "../template/side-navbaradmin.php";
include "../template/top-navbarNonAuth.php";
include "../template/top-navbarAuth.php";

require_once '../../server/config.php';
require '../../server/users.php';

$user = new Users();
$isAdmin = 0;

if(!isset($_SESSION['username'])){ //Session
    $auth = FALSE;
}else{
    $auth = TRUE;
    $isAdmin = $_SESSION['isAdmin'];
}

if(isset($_COOKIE['cookie_username'])){ //Cookie
    $username = $_COOKIE['cookie_username'];
    $password = $_COOKIE['cookie_password'];
    try{
        $success = $user->login($username, $password);      
    }catch(Exception $e){
        echo "Query Error";
    }
    if($success){
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user->getUserId();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['isAdmin'] = $user->getIsAdmin();
    }
    $auth = TRUE;
    $isAdmin = $_SESSION['isAdmin'];
}

$ch = curl_init();
$restUrl = "http://localhost:4000/api/singer";

curl_setopt($ch, CURLOPT_URL, $restUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($ch);
var_dump(json_decode($resp));
die;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../../assets/binotify-icon.ico" type="image/x-icon">
    <!-- Style -->
    <link rel="stylesheet" href="../css/premium-service.css">
    <link rel="stylesheet" href="../css/side-navbar.css">
    <link rel="stylesheet" href="../css/top-navbar.css">
    <!-- Icon -->
    <script src="https://kit.fontawesome.com/a77fc736a8.js" crossorigin="anonymous"></script>
    <title>Search</title>
</head>
<body>
    <?php 
        if($auth){
            topNavbarAuth($_SESSION['username']);
        }else{
            topNavbarNonAuth();
        }
    ?>
    <?php
        if($isAdmin == 1){
            sideNavbarAdmin();
        }else{
            if($auth){
                sideNavbarUserAuth();
            }else{
                sideNavbarUserNonAuth();
            }
        }
    ?>
    <div class="containerContent">
        <h1>Premium Singer List</h1>
        <div class="containerHeader">
            <div class="itemHeader1">#</div>
            <div class="itemHeader2">Penyanyi</div>
        </div>
        <div class="containerItem">
            <div class="no">
            1
            </div>
            <div class="title">
                Judul
            </div>
            <div class="duration">
                <button>Subcribe</button>
            </div>
        </div>
        
        <h1>Pending</h1>
        <div class="containerHeader">
            <div class="itemHeader1">#</div>
            <div class="itemHeader2">Penyanyi</div>
        </div>
        <div class="containerItem">
            <div class="no">
            1
            </div>
            <div class="title">
                Judul
            </div>
        </div>
        
        <h1>Subscribed</h1>
        <div class="containerHeader">
            <div class="itemHeader1">#</div>
            <div class="itemHeader2">Penyanyi</div>
        </div>
        <div class="containerItemSubs">
            <div class="no">
            1
            </div>
            <div class="title">
                Judul
            </div>

        </div>
    </div>
    
</body>
</html>
