<?php
$dbname = 'binotify';
$hostname = 'database';
$username = 'root';
$password = 'rootpass';
//admin1 = adminpass
// Connect on DB

//Jika docker 
//hostname = 'database'
//password = 'rootpass'
try {
    $pdo = new PDO("mysql:dbname=$dbname;host=$hostname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}