<?php
require('../includes/db.php');

$hwid = $_GET['hwid'];
$ownerID = $_GET['owner'];
$attempt = $_GET['attempt'];

$stmt = $pdo->prepare("SELECT dkey FROM clients WHERE hwid=:hwid AND ownerID=:owner AND decrypted=0");
$stmt->execute(['hwid' => $hwid, 'owner' => $ownerID]);
$dkeya = $stmt->fetch();
$dkey = $dkeya[0];

$edkey = hash('sha512', $dkey);
$eattempt = hash('sha512', $attempt);

$gay = ($edkey == $eattempt);

if($gay == 1) {
	$stmt = $pdo->prepare("UPDATE clients SET decrypted=1 WHERE hwid=:hwid AND ownerID=:owner AND decrypted=0");
	$stmt->execute(['hwid' => $hwid, 'owner' => $ownerID]);
	die("1");
}

?>