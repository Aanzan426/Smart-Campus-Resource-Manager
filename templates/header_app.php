<?php
	session_start();
	if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
  		header("Location: /admin/admin_login.php");
  		exit;
	}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "UTF-8">
		<title> Smart Campus Resource Manager - Admin Access </title>
		<link rel = "stylesheet" href = "/assets/css/style.css">
	</head>
	<body>
		<header class="app-header">
  			<div class="container bar">
    				<div class="brand">
      					<div class="brand-badge"></div>
      					<div class="brand-text">
        					<strong>Smart Campus Resource Manager</strong>
        					<span>Admin Console</span>
      					</div>
    				</div>

    				<nav class="nav">
     					<a href="admin_dashboard.php" class="active">Dashboard</a>
      					<a href="admin_users.php">Users</a>
      					<a href="admin_resources.php">Resources</a>
      					<a href="admin_bookings.php">Bookings</a>
					<a href="admin_depts.php">Check Department Status</a>
      					<a href="logout.php">Logout</a>
   				</nav>

   				<div class="user-pill">
      					<span class="dot"></span>
      					<span>Logged in: Admin</span>
    				</div>
  			</div>
		</header>

		
					