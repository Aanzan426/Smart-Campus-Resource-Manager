<?php
	$stored_password = password_hash('password', PASSWORD_DEFAULT);
	echo $stored_password;
?>