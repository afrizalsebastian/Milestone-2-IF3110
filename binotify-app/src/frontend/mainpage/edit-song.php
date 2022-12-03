<?php
require_once '../../server/config.php';
$songId = (int)$_POST['songId'];

if($_POST['judulBaru'] != ''){
    $newTitle = $_POST['judulBaru'];
    $query = "UPDATE binotify.songs SET judul = :judul WHERE (song_id = :song_id)";
    $value = array(':judul'=>$newTitle, ':song_id'=>$songId);

    $result = $pdo->prepare($query);
    $result->execute($value);
}

if($_POST['dateBaru'] != ''){
    $newTanggalTerbit = $_POST['dateBaru'];
    $query = "UPDATE binotify.songs SET tanggal_terbit = :tanggal_terbit WHERE (song_id = :song_id)";
    $value = array(':tanggal_terbit'=>$newTanggalTerbit, ':song_id'=>$songId);

    $result = $pdo->prepare($query);
    $result->execute($value);
}

if($_POST['genreBaru'] != ''){
    $newGenre = $_POST['genreBaru'];
    $query = "UPDATE binotify.songs SET genre = :genre WHERE (song_id = :song_id)";
    $value = array(':genre'=>$newGenre, ':song_id'=>$songId);

    $result = $pdo->prepare($query);
    $result->execute($value);
}


if($_FILES["ImageSongBaru"]['name'] != ''){
        $img_target_dir = "../../assets/img_song/";
        $img_target_file = $img_target_dir . basename($_FILES['ImageSongBaru']['name']);
        $fileUploadOk = 1;
        $imageFileType = strtolower(pathinfo($img_target_file,PATHINFO_EXTENSION));

        if(file_exists($img_target_file)){
            $fileUploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $fileUploadOk = 0;
        }

        if($fileUploadOk != 0){
            $query = "UPDATE binotify.songs SET image_path = :newImg WHERE (song_id = :song_id)";
            $value = array(':newImg'=>$img_target_file, ':song_id'=>$songId);

            $result = $pdo->prepare($query);
            $result->execute($value);
            move_uploaded_file($_FILES['ImageSongBaru']['tmp_name'],$img_target_file);
        }
}

if($_FILES['songBaru']['name'] !=''){
    $ausio_target_dir = "../../assets/song/";
    $audio_target_file = $audio_target_dir . basename($_FILES['songBaru']['name']);
    $fileUploadOk = 1;
    $audioFileType = strtolower(pathinfo($audio_target_file,PATHINFO_EXTENSION));

    if(file_exists($audio_target_file)){
        $fileUploadOk = 0;
    }

    if($audioFileType != "mp3" && $imageFileType != "ogg" ) {
        $fileUploadOk = 0;
    }

    if($fileUploadOk != 0){
        $query = "UPDATE binotify.songs SET audio_path = :newAudio WHERE (song_id = :song_id)";
        $value = array(':newAudio'=>$audio_target_file, ':song_id'=>$songId);

        $result = $pdo->prepare($query);
        $result->execute($value);
        move_uploaded_file($_FILES['songBaru']['tmp_name'],$audio_target_file);
    }
}

header("location:detail-lagu.php?id=". (string)$songId);