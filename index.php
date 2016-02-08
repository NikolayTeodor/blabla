<?php

$connection = mysql_connect("localhost", "root", "") or die("Could not connect to the database");
mysql_select_db("bean_db", $connection) or die("Could not connect to the database");

error_reporting(0);

if ($_POST['login']){
if ($_POST['username'] && $_POST['password']){
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string(hash("sha512", $_POST['password']));
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `Username`='$username'"));
	if ($user == '0'){
		die("That username doesn't exist! Try making <i>$username</i> today! <a href='index.php'> &larr; Back</a>");
	}
	if ($user['Password'] == $password){
		die("Incorrect password! <a href='index.php'>&larr; Back</a>");
	}
	$salt = hash("sha512", rand() . rand() . rand());
	setcookie("c_user", hash("sha512", $username), time() + 24 * 60 * 60, "/");
	setcookie("c_salt", $salt, tile() + 24 * 60 * 60, "/");
	$userID = $user['ID'];
	mysql_query("UPDATE `users` SET `Salt`='$salt' WHERE `ID`='$userID'");
	die("You are now logged in as $username!");
}
}

echo "

	<body style='font-family:verdana, sans-serif;'>
	<div style='width: 80%; padding: 5px 15px 5px; border: 1px solid #e3e3e3; background-color: #fff; color: #000;'>
	<h1>Login</h1>
	<br />
	<form action='' method='post'>
	<table>
		<tr>
			<td>
				<b>Username:</b>
			</td>
			<td>
				<input type='text' name='username' style='padding:4px;'
			</td>
		</tr>
		<tr>
			<td>
				<b>Password:</b>
			</td>
			<td>
				<input type='password' name='password' style='padding:4px;'/>
			</td>
		</tr>
		<tr>
			<td>
				<input type='submit' value='Login' name='login'/>
			</td>
		</tr>
	</table>
	</form>
	<br />
	<h6>
	No account? <a href='register.php'>Register!</a>
	</h6>
	</div>
	";
