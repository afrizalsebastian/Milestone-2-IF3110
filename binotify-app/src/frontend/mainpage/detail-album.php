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
        $success = $user->cookieLogin($username, $password);      
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


$idAlbum = (int)$_GET['idAlbum'];


// Dapatkan Semua Album
$queryAlbum = "SELECT * FROM binotify.album where (album_id = :album_id)";
$valueAlbum = array(':album_id' => $idAlbum);
$resAlbum = $pdo->prepare($queryAlbum);
$resAlbum->execute($valueAlbum);

$rowAlbum = $resAlbum->fetch();

//Dapatkan Music
$queryMusic = "SELECT * FROM binotify.songs where (album_id = :album_id)";
$valueMusic = array(':album_id' => $idAlbum);
$resMusic = $pdo->prepare($queryMusic);
$resMusic->execute($valueMusic);

$rowMusic = $resMusic->fetchAll();
$countMusic = count($rowMusic);

$numbering = 1;

function addQueryParam($url, $sortType, $newValue){
    if(!strpos($url, '?'))
        $addedQuery = '';
    else
        $addedQuery = substr($url, strpos($url, '?'));
    
    $isExistQueryParam = TRUE;
    if (!strpos($url, '?')){
        $addedQuery .= '?';
        $isExistQueryParam = FALSE;
    }
    if ($sortType == 'id'){
        if (isset($_GET['id'])) {
            $sort = $_GET['id'];
            $addedQuery = str_replace('id='.$sort, 'id='.$newValue, $addedQuery);
        } else{
            if($isExistQueryParam){
                $addedQuery .= '&id='.$newValue;
            }else {
                $addedQuery .= 'id='.$newValue;
            }
        }
    }
    if ($sortType == 'pageFrom'){
        if (isset($_GET['pageFrom'])) {
            $sort = $_GET['pageFrom'];
            $addedQuery = str_replace('pageFrom='.$sort, 'pageFrom='.$newValue, $addedQuery);
        } else{
            if($isExistQueryParam){
                $addedQuery .= '&pageFrom='.$newValue;
            }else {
                $addedQuery .= 'pageFrom='.$newValue;
            }
        }
    }
    return $addedQuery;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/binotify-icon.ico" type="image/x-icon">
    <!-- Style -->
    <link rel="stylesheet" href="../css/detail-album.css">
    <link rel="stylesheet" href="../css/side-navbar.css">
    <link rel="stylesheet" href="../css/top-navbar.css">
    <!-- Icon -->
    <script src="https://kit.fontawesome.com/a77fc736a8.js" crossorigin="anonymous"></script>
    <title>Detail Album</title>
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

    <div class="main-container">
        <div class="<?php if($isAdmin):?>
            <?php echo "jumbotron-admin"?>
            <?else:?>
                <?php echo"jumbotron"?>
                <?php endif;?>">
            <div class="album-cover">
                <img src="<?php echo $rowAlbum['image_path']?>" alt="">
            </div>
            <div class="sen-album">ALBUM</div>
            <div class="album-title"><?php echo $rowAlbum['judul']?></div>
            <div class="det-album"><?php echo $rowAlbum['penyanyi']?>, Tahun Terbit = <?php echo $rowAlbum['tanggal_terbit']?>, <?php echo $countMusic?> Lagu, Durasi = <?php echo floor($rowAlbum['total_duration']/60)?>:<?php echo $rowAlbum['total_duration']%60?></div>

            <?php if($isAdmin):?>
                <form action="detailAlbumEdit.php" class="edit-detail-album" method="post" enctype="multipart/form-data">
                    <h3>Change Detail Album</h3>
                    <input type="text" class="element-edit" name="newAlbTit" placeholder="New Album Title">
                    <label for="newRelDate">New Realese Date :</label>
                    <input type="date" class="element-edit date-edit" name="newRelDate">
                    <label for="newAlbCover">New Album Cover :</label>
                    <input type="file" name="newAlbCover">
                    <input type="hidden" name="albumid" value="<?php echo $idAlbum?>">
                    <button type="submit" class="edit-submit">Submit</button>
                </form>
            <?php endif;?>
        </div>
        <div class="table-name">
            <div class="tab-name-1">#</div>
            <div class="tab-name-2">JUDUL</div>
            <div class="tab-name-3"><i class="fa-solid fa-clock"></i></div>
        </div>
        <div class="all-song-container">
            <?php foreach($rowMusic as $music):
                $additionParam = addQueryParam($_SERVER['REQUEST_URI'], 'id', $music['song_id']);
                $url = strtok($_SERVER["REQUEST_URI"], '?');
                $url .= $additionParam;
                $additionParam = addQueryParam($url, 'pageFrom', 'detail_album');
                echo "<a href=\"detail-lagu.php{$additionParam}\">";
            ?>
                <div id="sid<?php echo $music['song_id']?> "class="song-container">
                    <div class="number  <?php if($isAdmin):?>
                                        <?php echo "delete" ?>
                                        <?php endif;?>" onclick="deleteSong(<?php echo $music['song_id']?>)">
                        <?php echo $numbering?>
                    </div>
                    <div class="song-title"><?php echo $music['judul']?></div>
                    <div class="singer"><?php echo $music['penyanyi']?></div>
                    <div class="duration"><?php echo floor($music['duration']/60)?>:<?php echo $music['duration']%60?></div>
                </div>
            <?php $numbering += 1?>
            <?php endforeach;?>
        </div>
        <form action="deletealbum.php" method="post">
            <input type="hidden" name="aid" value="<?php echo $idAlbum?>">
            <button type="submit" class="delete-album"><i class="fa-solid fa-trash"></i>   Delete Album</button>
        </form>
    </div>
    <script>
        function deleteSong(sid){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    location.reload();
                }
            }
            xhttp.open("POST", "songInAlbumEdit.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("sid="+sid);
        }
    </script>
</body>
</html>
