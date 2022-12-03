<?php
session_start();
include "../template/side-navbaruserAuth.php";
include "../template/side-navbaruserNonAuth.php";
include "../template/side-navbaradmin.php";
include "../template/top-navbarNonAuth.php";
include "../template/top-navbarAuth.php";

require_once '../../server/config.php';
require '../../server/users.php';

$queryData = '';
if(isset($_GET['pageFrom'])){
    $pageFrom = $_GET['pageFrom'];
    if ($pageFrom == 'search'){
        if(isset($_SESSION['search'])){
            $cari = $_SESSION['search'];
        }else{
            $cari= '';
        }
        $queryData = "SELECT * FROM songs WHERE judul LIKE '%$cari%'";
        $filterGenre = 'allGenre';
        if (isset($_GET['filterGenre'])){
            $filterGenre = $_GET['filterGenre'];
        }
        if($filterGenre != 'allGenre'){
            $queryData .= " AND genre LIKE '%$filterGenre%'";
        }
    
        if(isset($_GET['idAlbum'])){
            $queryData .= " AND album LIKE '%$%'";
    
        }
    
        //KHUSUS ORDER
        if (isset($_GET['sortTitle'])){
            $sort = $_GET['sortTitle'];
            if ($sort == "ASC"){
                $queryData .= " ORDER BY judul ASC";
            }else if ($sort == "DESC"){
                $queryData .= " ORDER BY judul DESC";
            }
        }
        if (isset($_GET['sortPenyanyi'])){
            $sort = $_GET['sortPenyanyi'];
            if(!strpos($queryData, ' ORDER BY')){
                if ($sort == "ASC"){
                    $queryData .= " ORDER BY penyanyi ASC";
                }else if ($sort == "DESC"){
                    $queryData .= " ORDER BY penyanyi DESC";
                }
            }else{
                if ($sort == "ASC"){
                    $queryData .= ", penyanyi ASC";
                }else if ($sort == "DESC"){
                    $queryData .= " , penyanyi DESC";
                }
            }
        }
        if (isset($_GET['sortYear'])){
            $sort = $_GET['sortYear'];
            if(!strpos($queryData, ' ORDER BY')){
                if ($sort == "ASC"){
                    $queryData .= " ORDER BY tanggal_terbit ASC";
                }else if ($sort == "DESC"){
                    $queryData .= " ORDER BY tanggal_terbit DESC";
                }
            }else{
                if ($sort == "ASC"){
                    $queryData .= ", tanggal_terbit ASC";
                }else if ($sort == "DESC"){
                    $queryData .= " , tanggal_terbit DESC";
                }
            }
        }
    } elseif ($pageFrom == 'detail_album') {
        if (isset($_GET['idAlbum'])) {
            $queryData.= "SELECT * FROM songs WHERE album_id = {$_GET['idAlbum']}";
        }
    } else {
        $queryData = 'SELECT * FROM songs';
    }
}else{
    $queryData = 'SELECT * FROM songs';
}



$song_pdo1 = $pdo->query("SELECT * FROM songs WHERE song_id = {$_GET['id']}");
$song_pdo1->execute();

$song = $song_pdo1->fetch();


$song_pdo2 = $pdo->query($queryData);
$song_pdo2->execute();

$song_data = $song_pdo2->fetchAll(); 
// var_dump($song_data);
/**
 * index to 
 */

$user = new Users();
$index = 0;
$found = false;
while($index < count($song_data) && !$found){
    if($song_data[$index]['song_id'] == $_GET['id']) {
        $found = true;
    } else {
        ++$index;
    };
}

function prevSong($currentIndex) {
    if($currentIndex > 0 ) {
        return $currentIndex --;
    }
}

function nextSong() {
    if($index < $count($song_data) ) {
        return $index;
    }
}

if(!isset($_SESSION['username'])){ //Session 
    $auth = FALSE;
    $isAdmin = 0;
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/binotify-icon.ico" type="image/x-icon">
    <!-- Style -->
    <link rel="stylesheet" href="../css/detail-lagu.css">
    <link rel="stylesheet" href="../css/side-navbar.css">
    <link rel="stylesheet" href="../css/top-navbar.css">
    <!-- Icon -->
    <script src="https://kit.fontawesome.com/a77fc736a8.js" crossorigin="anonymous"></script>
    <title>Home</title>
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
        <div class="jumbotron">
            <?php
            $path_lagu = $song_data[($index > 0 ? ($index):0)]['image_path'];
            $judul = $song_data[($index > 0 ? ($index):0)]['judul'];
            $penyanyi = $song_data[($index > 0 ? ($index):0)]['penyanyi'];
            $tanggal = $song_data[($index > 0 ? ($index):0)]['tanggal_terbit'];
            $genre = $song_data[($index > 0 ? ($index):0)]['genre'];
            $path_audio = $song_data[($index > 0 ? ($index):0)]['audio_path'];
            $menit = floor($song_data[($index > 0 ? ($index):0)]["duration"]/60);
            $detik = $song_data[($index > 0 ? ($index):0)]["duration"] - $menit*60;
            $albumId = $song_data[($index > 0 ? ($index):0)]['album_id'];
            $songId = $song_data[($index > 0 ? ($index):0)]['song_id'];
            if ($menit < 10){
                if ($detik <10){
                    $durasi = "0{$menit}:0{$detik}";
                }else{
                    $durasi = "0{$menit}:{$detik}";
                }
            }else{
                if ($detik <10){
                    $durasi = "{$menit}:0{$detik}";
                }else{
                    $durasi = "{$menit}:{$detik}";
                }
            }
            ?>
            <div class="detail">
                <div class="album-cover">
                    <div class="disk" style="background-image:url('<?=$path_lagu?>');"></div>
                </div>
                <div class="album-cover">
                    <div class="judul-penyanyi">
                        <div class="album-title"><?=$judul?></div>
                        <div class="senTitle"><?=$penyanyi?></div>
                    </div>
                    <br>
                    <div class="detail-tambahan">
                        <h2>Terbit : <?=$tanggal?></h1>
                        <h2>Genre : <?=$genre?></h1>
                        <?php if($albumId) :?>
                            <a href="detail-album.php?idAlbum=<?=$albumId?>">
                                VIEW ALBUM
                            </a>
                        <?php endif;?>
                        <?php if($auth && $isAdmin):?>
                        <div class="controls-admin">
                            <div>
                                <form action="delete-song.php" method="post">
                                    <input type="hidden" name="aid" value="<?php echo $songId?>">
                                    <button type="submit" class="delete-lagu"><i class="fa-solid fa-trash"></i>   Delete Song</button>
                                </form>
                            </div>
                            <div>
                                <form action="edit-song.php" method="post" enctype="multipart/form-data">
                                    <section class="modal">
                                        <div class="modal-content">
                                            <a class="close-modal">&times;</a>
                                            <h3>Change Detail Song</h3>
                                            <br>
                                            <div>
                                                <label for="judulBaru">Song Title :</label>
                                            </div>
                                            <div>
                                                <input type="text" class="element-edit" name="judulBaru" value="<?=$judul?>">
                                            </div>
                                            <div>
                                                <label for="dateBaru">Release date :</label>
                                            </div>
                                            <div>
                                                <input type="date" class="element-edit date-edit" name="dateBaru">
                                            </div>
                                            <div>
                                                <label for="genreBaru">Genre :</label>
                                            </div>
                                            <div>
                                                <input type="text" class="element-edit" name="genreBaru" value="<?=$genre?>">
                                            </div>
                                            <div>
                                                <label for="ImageSongBaru">Song Cover :</label>
                                            </div>
                                            <div>
                                                <input type="file" name="ImageSongBaru">
                                            </div>
                                            <div>
                                                <label for="songBaru">Song Audio :</label>
                                            </div>
                                            <div>
                                                <input type="file" name="songBaru">
                                            </div>
                                            <div>
                                                <input type="hidden" name="songId" value="<?php echo $songId?>">
                                                <button type="submit" class="edit-submit">Submit</button>
                                            </div>
                                        </div>
                                    </section>
                                </form>
                                <button class="edit-lagu"><i class="fa-solid fa-pen"></i>   Edit Song</button>
                            </div>         
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom">
            <input  type="range" name="range" id="progressBar" min="0" max="100" value="0">
            <div class="durasi"><?=$durasi?></div>
            <div class="durasi0">00:00</div>
            <div class="controls">
                <?php
                    $modifiedURIPrevSong = str_replace('id='.$_GET['id'], 'id='.$song_data[($index > 0 ? ($index-1):0)]['song_id'], $_SERVER['REQUEST_URI']);
                ?>
                <a href="<?= $modifiedURIPrevSong ?>"><i class="fa fa-solid fa-backward" id="prevSong"></i></a>
                <i class="fa fa-regular fa-circle-play" id="masterPlay"></i>
                <?php
                    $modifiedURINextSong = str_replace('id='.$_GET['id'], 'id='.$song_data[($index < count($song_data)-1 ? ($index+1):(count($song_data)-1))]['song_id'], $_SERVER['REQUEST_URI']);
                ?>
                <a href="<?= $modifiedURINextSong ?>"><i class="fa fa-solid fa-forward"></i></a>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    let prevSong = document.getElementById('prevSong');
    let masterPlay = document.getElementById('masterPlay');
    let audio1 = new Audio('<?=$path_audio?>');
    let progresBar = document.getElementById('progressBar');
    let progres = 0;
    let songIndex =  document.getElementById('songId');
    const disk = document.querySelector('.disk');
    const currentTime = document.querySelector('.durasi0');
    const bukaModal = document.querySelector('.edit-lagu');
    const modal = document.querySelector('.modal');
    const closeModal = document.querySelector('.close-modal');

    <?php if($isAdmin):?>
        bukaModal.addEventListener('click' ,()=>{
            console.log('open');
            modal.style.display = 'block';
        })

        closeModal.addEventListener('click' ,()=>{
            console.log('close');
            modal.style.display = 'none';
        })
    <?php endif;?>
    console.log("script jalan")
    const formatTime = (time) =>{
        let minute = Math.floor(time/60);
        if (minute<10){
            minute = `0${minute}`;
        }
        let second = Math.floor(time%60);
        if(second<10){
            second = `0${second}`;
        }
        return`${minute}:${second}`; 
    }


    masterPlay.addEventListener('click' ,()=>{
        if(audio1.paused || audio1.currentTime<=0){
            console.log('play');
            audio1.play();
            masterPlay.classList.remove('fa-circle-play');
            masterPlay.classList.add('fa-circle-pause');
            masterPlay.classList.add(audio1.currentTime);
            disk.classList.toggle('play');
            
        }
        else{
            audio1.pause();
            masterPlay.classList.remove('fa-circle-pause');
            masterPlay.classList.add('fa-circle-play');
            disk.classList.toggle('play');
        }
        
    })

    audio1.addEventListener('timeupdate', ()=>{
        progres = parseInt((audio1.currentTime/audio1.duration)*100);
        progresBar.value = progres;
        time = formatTime(audio1.currentTime);
        currentTime.innerHTML = time;
        console.log(audio1.currentTime,audio1.duration)
        if (audio1.currentTime==audio1.duration){
            progresBar.value = 0;
            currentTime.innerHTML = '00:00';
            audio1.pause();
            masterPlay.classList.remove('fa-circle-pause');
            masterPlay.classList.add('fa-circle-play');
            disk.classList.toggle('play');
        }
        
    })
    progresBar.addEventListener('change',()=>{
        audio1.currentTime = progressBar.value*audio1.duration/100;
        console.log(audio1.currentTime);
    })
</script>
