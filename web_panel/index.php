<?php
require('includes/db.php');

$authcode = $_COOKIE['authcode'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE authcode=:authcode");
$stmt->execute(['authcode' => $authcode]); 
$username1 = $stmt->fetch();

$username = $username1["username"];
$userID = $username1["id"];

if(!empty($username)) {
	header("Location: panel/");
	die();
}

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$user_ip = getUserIP();

//

if (!empty($_POST)) {
	$username = $_POST['username'];
	$password = hash('sha512', $_POST['password']);
	$rcc = hash('sha512', $_POST['rcc']);
	$ipv4 = hash('sha512', $user_ip);
	
	//check if user has same IP
	$stmt = $pdo->prepare("SELECT ipv4 FROM users WHERE ipv4=:ip");
	$stmt->execute(['ip' => $ipv4]); 
	$ipstat = $stmt->fetch();
	
	if(!empty($ipstat)) {
		die("<b>ANTISPAM:</b> A user with this IP has already signed up.");
	}
	
	//check if username taken
	$stmt = $pdo->prepare("SELECT username FROM users WHERE username=:username");
	$stmt->execute(['username' => $username]); 
	$usstat = $stmt->fetch();
	
	if(!empty($usstat)) {
		die("<b>ANTISPAM:</b> A user with this username has already signed up.");
	}
	
	$sql = "INSERT INTO users (username, password, rcc, ipv4) VALUES (?,?,?,?)";
	$pdo->prepare($sql)->execute([$username, $password, $rcc, $ipv4]);
	
	die("SUCCESS!!");
}
?>

<style>

div {
	margin-left: 10%;
	margin-right: 10%;
}
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=password], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.shiny
{
  color: #F5C21B;
  background: -webkit-gradient(linear, left top, left bottom, from(#F5C21B), to(#D17000));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
  font-family: "Source Sans Pro", sans-serif;
  font-size: 5em;
  font-weight: 900;
  position: relative;
  text-transform: uppercase;
}

.shiny::before
{
	background-position: -180px;
	-webkit-animation: flare 5s infinite;
  -webkit-animation-timing-function: linear;
  background-image: linear-gradient(65deg, transparent 20%, rgba(255, 255, 255, 0.2) 20%, rgba(255, 255, 255, 0.3) 27%, transparent 27%, transparent 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  content: "WELCOME";
  color: #FFF;
  display: block;
  padding-right: 140px;
  position: absolute;
}

.shiny::after
{
  content: "WELCOME";
  color: #FFF;
  display: block;
  position: absolute;
  text-shadow: 0 1px #6E4414, 0 2px #6E4414, 0 3px #6E4414, 0 4px #6E4414, 0 5px #6E4414, 0 6px #6E4414, 0 7px #6E4414, 0 8px #6E4414, 0 9px #6E4414, 0 10px #6E4414;
  top: 0;
  z-index: -1;
}

.inner-shiny::after, .inner-shiny::before
{
		-webkit-animation: sparkle 5s infinite;
  -webkit-animation-timing-function: linear;
	background: #FFF;
  border-radius: 100%;
  box-shadow: 0 0 5px #FFF, 0 0 10px #FFF, 0 0 15px #FFF, 0 0 20px #FFF, 0 0 25px #FFF, 0 0 30px #FFF, 0 0 35px #FFF;
  content: "";
  display: block;
  height: 10px;
  opacity: 0.7;
  position: absolute;
  width: 10px;
}

.inner-shiny::before
{
	-webkit-animation-delay: 0.2s;
  height: 7px;
  left: 0.12em;
  top: 0.8em;
  width: 7px;
}

.inner-shiny::after
{
  top: 0.32em;
  right: -5px;
}

@-webkit-keyframes flare
{
  0%   { background-position: -180px; }
  30%  { background-position: 500px; }
  100% { background-position: 500px; }
}

@-webkit-keyframes sparkle
{
  0%   { opacity: 0; }
  30%  { opacity: 0; }
  40%  { opacity: 0.8; }
  60%  { opacity: 0; }
  100% { opacity: 0; }
}

</style>
<center>
	<span class="shiny">
	  <span class="inner-shiny">WELCOME</span>
	</span>
</center>
<div>
  <form method="post" action="index.php">
    <label for="fname">Username</label>
    <input type="text" id="username" name="username">

    <label for="lname">Password</label>
    <input type="password" id="password" name="password">
	
    <label for="lname">Recovery Code</label>
    <input type="password" id="rcc" name="rcc">
  
    <input type="submit" value="REGISTER">
    Already have an account? <a href="login.php">login</a>!
  </form>
</div>

