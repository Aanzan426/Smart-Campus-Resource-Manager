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
		<title> Department Management - Admin Access </title>
		<link rel = "stylesheet" href = "/assets/css/style.css">
	</head>
	<body>
		<header class="app-header">
  			<div class="container bar">
    				<div class="brand">
      					<div class="brand-badge"></div>
      					<div class="brand-text">
        					<strong>Smart Campus Resource Manager - Department View</strong>
        					<span>Admin Console</span>
      					</div>
    				</div>

				<nav class = "nav">
					<a href = "admin_dashboard.php"> Back to Dashboard </a>
				</nav>
			</div>
		</header>
		<main>
			<?php include __DIR__.'/../../src/modules/view_departments.php'; ?>
		</main>
		<?php include __DIR__.'/../../templates/footer.php'; ?>
