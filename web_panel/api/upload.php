<?php
require('../includes/db.php');

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$hwid = $_GET['hwid'];
$ownerID = $_GET['owner'];

//check if slot taken
$stmt = $pdo->prepare("SELECT id FROM clients WHERE hwid=:hwid AND ownerID=:owner AND decrypted=0");
$stmt->execute(['hwid' => $hwid, 'owner' => $ownerID]);
$usstat = $stmt->fetch();

if(!empty($usstat)) {
    die("Oopsy! You can't get your key twice!");
} else {
	$dkey = generateRandomString(32);
    $sql = "INSERT INTO clients (hwid, dkey, ownerID) VALUES (?,?,?)";
    $pdo->prepare($sql)->execute([$hwid, $dkey, $ownerID]);
	die($dkey);
}

?>