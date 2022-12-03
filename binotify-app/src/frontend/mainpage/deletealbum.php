<?php

require_once '../../server/config.php';

if(!empty($_POST['aid'])){
    $aid = $_POST['aid'];
    $query = "DELETE FROM binotify.album WHERE (album_id = :album_id)";
    $value = array(':album_id' => $aid);

    $res = $pdo->prepare($query);
    $res->execute($value);
    header("location:daftar-album.php");
}