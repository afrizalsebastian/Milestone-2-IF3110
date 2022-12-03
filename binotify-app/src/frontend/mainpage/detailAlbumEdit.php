<?php
require_once '../../server/config.php';
$idAlbum = (int)$_POST['albumid'];
if($_POST['newAlbTit'] != ''){
    $newTitle = $_POST['newAlbTit'];
    $query = "UPDATE binotify.album SET judul = :judul WHERE (album_id = :album_id)";
    $value = array(':judul'=>$newTitle, ':album_id'=>$idAlbum);

    $result = $pdo->prepare($query);
    $result->execute($value);
}

if($_POST['newRelDate'] != ''){
    $newDate = $_POST['newRelDate'];
    $query = "UPDATE binotify.album SET tanggal_terbit = :newDate WHERE (album_id = :album_id)";
    $value = array(':newDate'=>$newDate, ':album_id'=>$idAlbum);

    $result = $pdo->prepare($query);
    $result->execute($value);
}

if($_FILES['newAlbCover']['name'] !=''){
        $img_target_dir = "../../assets/img_album/";
        $img_target_file = $img_target_dir . basename($_FILES['newAlbCover']['name']);
        $fileUploadOk = 1;
        $imageFileType = strtolower(pathinfo($img_target_file,PATHINFO_EXTENSION));

        if(file_exists($img_target_file)){
            $fileUploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $fileUploadOk = 0;
        }

        if($fileUploadOk != 0){
            $query = "UPDATE binotify.album SET image_path = :newImg WHERE (album_id = :album_id)";
            $value = array(':newImg'=>$img_target_file, ':album_id'=>$idAlbum);

            $result = $pdo->prepare($query);
            $result->execute($value);
            move_uploaded_file($_FILES['newAlbCover']['tmp_name'],$img_target_file);
        }
}

header("location:detail-album.php?idAlbum=". (string)$idAlbum);