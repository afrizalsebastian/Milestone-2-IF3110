<?php

require_once '../../server/config.php';

if(!empty($_POST['sid'])){
    $sid = $_POST['sid'];
    $query = "UPDATE binotify.songs SET album_id = NULL WHERE (song_id = :song_id)";
    $value = array(':song_id' => $sid);

    $res = $pdo->prepare($query);
    $res->execute($value);
}