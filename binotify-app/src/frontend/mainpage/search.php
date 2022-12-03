<?php
session_start();
include "../template/side-navbaruserAuth.php";
include "../template/side-navbaruserNonAuth.php";
include "../template/side-navbaradmin.php";
include "../template/top-navbarNonAuth.php";
include "../template/top-navbarAuth.php";

require_once '../../server/config.php';
require '../../server/users.php';

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

    if ($sortType == 'sortTitle'){
        if (isset($_GET['sortTitle'])) {
            $sort = $_GET['sortTitle'];
            $addedQuery = str_replace('sortTitle='.$sort, 'sortTitle='.$newValue, $addedQuery);
        } else{
            if($isExistQueryParam){
                $addedQuery .= '&sortTitle='.$newValue;
            }else {
                $addedQuery .= 'sortTitle='.$newValue;
            }
        }
    }

    if ($sortType == 'sortYear'){
        if (isset($_GET['sortYear'])) {
            $sort = $_GET['sortYear'];
            $addedQuery = str_replace('sortYear='.$sort, 'sortYear='.$newValue, $addedQuery);
        } else{
            if($isExistQueryParam){
                $addedQuery .= '&sortYear='.$newValue;
            }else {
                $addedQuery .= 'sortYear='.$newValue;
            }
        }
    }
    if ($sortType == 'sortPenyanyi'){
        if (isset($_GET['sortPenyanyi'])) {
            $sort = $_GET['sortPenyanyi'];
            $addedQuery = str_replace('sortPenyanyi='.$sort, 'sortPenyanyi='.$newValue, $addedQuery);
        } else{
            if($isExistQueryParam){
                $addedQuery .= '&sortPenyanyi='.$newValue;
            }else {
                $addedQuery .= 'sortPenyanyi='.$newValue;
            }
        }
    }

    if ($sortType == 'filterGenre'){
        if (isset($_GET['filterGenre'])) {
            $sort = $_GET['filterGenre'];
            $addedQuery = str_replace('filterGenre='.$sort, 'filterGenre='.$newValue, $addedQuery);
        } else{
            if($isExistQueryParam){
                $addedQuery .= '&filterGenre='.$newValue;
            }else {
                $addedQuery .= 'filterGenre='.$newValue;
            }
        }
    }

    if ($sortType == 'halaman'){
        if (isset($_GET['halaman'])) {
            $sort = $_GET['halaman'];
            $addedQuery = str_replace('halaman='.$sort, 'halaman='.$newValue, $addedQuery);
        } else{
            if($isExistQueryParam){
                $addedQuery .= '&halaman='.$newValue;
            }else {
                $addedQuery .= 'halaman='.$newValue;
            }
        }
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

if (isset($_POST['searchButton'])){
    $cari = $_POST['search'];
    $_SESSION['search'] = $cari;
}else{
    if (isset($_SESSION['search'])){
        $cari = $_SESSION['search'];
    }else{
        $cari = '';
    }
}

if (isset($_GET['halaman'])){
    $halamanAktif = $_GET['halaman'];
}else{
    $halamanAktif = 1;
}

$filterGenre = 'allGenre';
if (isset($_GET['filterGenre'])){
    $filterGenre = $_GET['filterGenre'];
}
$queryData = "SELECT * FROM songs WHERE judul LIKE '%$cari%'";

if($filterGenre != 'allGenre'){
    $queryData .= " AND genre LIKE '%$filterGenre%'";
}

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

$getDataQuery = $pdo->query($queryData);
$getDataQuery->execute();
$countRowTotalData = $getDataQuery->rowCount();

$jumlahData = 10;
$dataAwal = ($halamanAktif * $jumlahData) - $jumlahData;

$jumlahPagination = ceil($countRowTotalData/ 10);
$jumlahLink = 3;
if ($halamanAktif < ($jumlahPagination - $jumlahLink)){
    $start_number = $halamanAktif - $jumlahLink;
}else{
    $start_number = 1;
}
if ($halamanAktif < ($jumlahPagination-$jumlahLink)){
    $end_number = $halamanAktif + $jumlahLink;
}else{
    $end_number = $jumlahPagination;
}

$ambilData_perhalaman = $pdo->query($queryData." LIMIT $dataAwal,$jumlahData");
$ambilData_perhalaman->execute();
$fetchedData_perhalaman = $ambilData_perhalaman->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../../assets/binotify-icon.ico" type="image/x-icon">
    <!-- Style -->
    <link rel="stylesheet" href="../css/search.css">
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
        <div class="containerSortFilter">
            <div class="itemSortFilter">
                <?php
                    $newValue = '';
                    if (isset($_GET['sortTitle'])){
                        $sort = $_GET['sortTitle'];
                        if ($sort == "ASC"){
                            $newValue = 'DESC';
                        }else if ($sort == "DESC"){
                            $newValue = 'ASC';
                        }
                    }else{
                        $newValue = 'ASC';
                    }
                    $newURL = addQueryParam($_SERVER['REQUEST_URI'], 'sortTitle', $newValue);
                    echo "<a href=\"{$newURL}\" class=\"btnSortByTitle\" style=\"cursor:pointer;\">Sort By Title</a>";
                ?>
            </div>
            <div class="itemSortFilter">
                <?php
                    $newValue = '';
                    if (isset($_GET['sortPenyanyi'])){
                        $sort = $_GET['sortPenyanyi'];
                        if ($sort == "ASC"){
                            $newValue = 'DESC';
                        }else if ($sort == "DESC"){
                            $newValue = 'ASC';
                        }
                    }else{
                        $newValue = 'ASC';
                    }
                    $newURL = addQueryParam($_SERVER['REQUEST_URI'], 'sortPenyanyi', $newValue);
                    echo "<a href=\"{$newURL}\" class=\"btnSortByPenyanyi\" style=\"cursor:pointer;\">Sort By Penyanyi</a>";
                ?>
            </div>
            <div class="itemSortFilter">
                <?php
                    $newValue = '';
                    if (isset($_GET['sortYear'])){
                        $sort = $_GET['sortYear'];
                        if ($sort == "ASC"){
                            $newValue = 'DESC';
                        }else if ($sort == "DESC"){
                            $newValue = 'ASC';
                        }
                    }else{
                        $newValue = 'ASC';
                    }
                    $newURL = addQueryParam($_SERVER['REQUEST_URI'], 'sortYear', $newValue);
                    echo "<a href=\"{$newURL}\" class=\"btnSortByYear\" style=\"cursor:pointer;\">Sort By Year</a>";
                ?>
            </div>
            <div class="itemSortFilter" >
                <form id="formFilter" action="<?=$_SERVER['REQUEST_URI'] ?>" method="GET">
                    <select name="filterGenre" id="filterGenre" style="cursor:pointer;">
                        <?php
                            $ambilGenre = $pdo->prepare("SELECT distinct genre FROM songs"); //tambahin where judul like '%$cari%'
                            $ambilGenre->execute();
                            $fetchedGenre = $ambilGenre->fetchAll();
                            if ($filterGenre == 'allGenre')
                                    echo "<option selected value=\"allGenre\">All Genre</option>";
                            else
                                echo "<option value=\"allGenre\">All Genre</option>";
                            foreach($fetchedGenre as $row){
                                if ($row['genre'] == $filterGenre)
                                    echo "<option selected value=\"{$row["genre"]}\">{$row["genre"]}</option>";
                                else
                                    echo "<option value=\"{$row["genre"]}\">{$row["genre"]}</option>";
                            }
                        ?>
                    </select>
                </form>
            </div>
        </div>
        <h1>Song</h1>
        <div class="containerHeader">
            <div class="itemHeader1">#</div>
            <div class="itemHeader2">TITLE</div>
            <div class="itemHeader3">ALBUM</div>
            <div class="itemHeader4">DURATION</div>
        </div>
        <?php
            $i = $dataAwal + 1;
            foreach($fetchedData_perhalaman as $row){
                $additionParam = addQueryParam($_SERVER['REQUEST_URI'], 'id', $row['song_id']);
                $url = strtok($_SERVER["REQUEST_URI"], '?');
                $url .= $additionParam;
                $additionParam = addQueryParam($url, 'pageFrom', 'search');
                echo "<a href=\"detail-lagu.php{$additionParam}\">";

                if ($row["album_id"] != NULL){
                    $ambilAlbum = $pdo->prepare("SELECT judul FROM album WHERE album_id = {$row["album_id"]}"); //tambahin where judul like '%$cari%'
                    $ambilAlbum->execute();
                    $fetchAlbum = $ambilAlbum->fetch();
                    $judulAlbum = $fetchAlbum["judul"];
                }else{
                    $judulAlbum = "-";
                }

                $menit = floor($row["duration"]/60);
                $detik = $row["duration"] - $menit*60;
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
                echo"
                <div class=\"containerItem\">
                    <div class=\"no\">
                    $i
                    </div>
                    <div class=\"cover\">
                        <img class= 'song_img' src=\"{$row["image_path"]}\" width=\"100px\" class=\"cover-album\">
                    </div>
                    <div class=\"title\">
                        {$row["judul"]}
                    </div>
                    <div class=\"singer\">
                        {$row["penyanyi"]}
                    </div>
                    <div class=\"album\">
                        {$judulAlbum}
                    </div>
                    <div class=\"duration\">
                        {$durasi}
                    </div>
                </div>
                ";
                $i = $i + 1;
            }
        ?>
        <div class="pagination">
            <?php 
                if ($halamanAktif > 1){
                    $prevPage = $halamanAktif - 1;
                    $newURL = addQueryParam($_SERVER['REQUEST_URI'], 'halaman', $prevPage);
                    echo "<a href=\"{$newURL}\" class = \"fa-solid fa-angle-left\"> </a>";

                    // echo "<a href=\"?halaman={$prevPage}\" class = \"fa-solid fa-angle-left\"> </a>";
                }
                for ($j = $start_number; $j <= $end_number; $j++){
                    if ($halamanAktif == $j){
                        $newURL = addQueryParam($_SERVER['REQUEST_URI'], 'halaman', $j);
                        echo "<a href=\"{$newURL}\" style=\"font-weight:bold;\">{$j}</a>";
                    }else{
                        $newURL = addQueryParam($_SERVER['REQUEST_URI'], 'halaman', $j);
                        echo "<a href=\"{$newURL}\">{$j}</a>";
                    }
                }
                if($halamanAktif < $jumlahPagination){
                    $nextPage = $halamanAktif + 1;
                    $newURL = addQueryParam($_SERVER['REQUEST_URI'], 'halaman', $nextPage);
                    echo "<a href=\"{$newURL}\" class = \"fa-solid fa-angle-right\"> </a>";
                };
            ?>
        </div>
    </div>
    <script>
        const selectGenre = document.getElementById('filterGenre')
        const formFilter = document.getElementById('formFilter')
        selectGenre.addEventListener('change', (e) => {
            if (formFilter.action.includes('?')) {
                formFilter.action = `${formFilter.action}&filterGenre=${filterGenre.value}`
            }else {
                formFilter.action = `${formFilter.action}?filterGenre=${filterGenre.value}`
            }
            formFilter.submit()
        })
    </script>
</body>
</html>
