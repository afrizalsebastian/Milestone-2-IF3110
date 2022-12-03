<?php

require_once '../../server/config.php';

if(!empty($_POST['aid'])){
    $aid = $_POST['aid'];
    $query = "DELETE FROM binotify.songs WHERE (song_id = :song_id)";
    $value = array(':song_id' => $aid);

    $res = $pdo->prepare($query);
    $res->execute($value);
    header("location:index.php");
}
