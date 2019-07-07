<?php
require('db.php');
$authcode = $_COOKIE['authcode'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE authcode=:authcode");
$stmt->execute(['authcode' => $authcode]); 
$username1 = $stmt->fetch();

$username = $username1["username"];
$userID = $username1["id"];

if(empty($username)) {
	die("<b>ANTIDOS:</b> Please login to use these pages.");
}