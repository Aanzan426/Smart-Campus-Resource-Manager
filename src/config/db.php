<?php
	$pdo = new PDO('mysql:host=localhost;dbname=introdb;charset=utf8','introdb_user','mypassword1!');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
