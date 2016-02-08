<?php

$connection = mysql_connect("localhost", "root", "") or die("Could not connect to the database");
mysql_select_db("bean_db", $connection) or die("Could not connect to the database");

error_reporting(0);

if ($_POST['register']){
	if ($_POST['username'] && $_POST['password']){
		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string(hash("sha512", $_POST['password']));
		$name = '';
		if ($_POST['name']){
			$name = mysql_real_escape_string(strip_tags($_POST['name']));
		}
		$check = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `Username`='$username'"));
		if ($check!= '0'){
			die("That username already exist! Try <i>$username" . rand(1, 50) . "</i>instead! <a href='register.php'> &larr; Back</a>");
		}
		if (!ctype_alnum($username)){
			die("Username contains special characters! Only numbers and letters are permitted! <a href='register.php'>&larr; Back</a>");
		}
		if(strlen($username) >20){
			die("Username is too long! It must contain less than 20 characters! <a href='register.php'> &larr; Back");
		}
		$salt = hash("sha512", rand() . rand() . rand());
		mysql_query("INSERT INTO `users`(`Username`, `Password`, `Name`, `Salt`) VALUES ('$username', '$password', '$name', '$salt'");
		setcookie("c_user", hash("sha512", $username), time() + 24 * 60 * 60, "/");
		setcookie("c_salt", $salt, time() + 24 * 60 * 60, "/");
		die("Your account has been created and now you are logged in!");
	}
}

echo "

	<body style='font-family:verdana, sans-serif;'>
	<div style='width: 80%; padding: 5px 15px 5px; border: 1px solid #e3e3e3; background-color: #fff; color: #000;'>
	<h1>Register</h1>
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
				<b>Name:</b>
			</td>
			<td>
				<input type='text' name='name' style='padding:4px;'
			</td>
		</tr>
		<tr>
			<td>
				<input type='submit' value='Register' name='register'/>
			</td>
		</tr>
	</table>
	</form>
	<br />
	</div>		


";
