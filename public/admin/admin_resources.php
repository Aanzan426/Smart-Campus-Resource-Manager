<?php
	include __DIR__.'/../../src/config/db.php';
	include __DIR__.'/../../src/auth/admin_auth.php';
	if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
  		header("Location: /admin/admin_login.php");
  		exit;
	}

?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "UTF-8">
		<title> Resource Management - Admin Access </title>
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
                			<a href="#create_resource_entry">Create Resource</a>
               				<a href="#view_resources">View Resources</a>
                			<a href="#update_resources">Update Resources</a>
					<a href="#activate_deactivate_resources">Activate/Deactivate Resources</a>
					<a href="#delete_resources">Delete Resources</a>
                			<a href="admin_dashboard.php">Dashboard</a>
            			</nav>
	
            			<div class="user-pill">
                			<span class="dot"></span>
                			<span>Logged in: Admin</span>
            			</div>
	
        		</div>
    		</header>
		<main>
			<h1 class="page-title">Resource Management</h1>
        		<p class="page-subtitle">
           			 Create,update,delete,view,disable/activate resource entries from the database.
        		</p>
			
			<section class="card" id="create_resource_entry">
            			<div class="card-header">
                			<div>
                    				<h2 class="card-title">Create Resource Entry</h2>
                    				<p class="card-desc">Register resource with details and resource data </p>
                			</div>
            			</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "resource_create">
					
					<label> Resource Name: </label>
					<input type = "text" name = "resource_name">

					<label> Resource Code: </label>
					<input type = "text" name = "resource_code">

					<label> Resource Type: </label>
					<select name = "resource_type">
						<option value = ""> Select One </option>
						<option value = "classroom"> Classroom </option>
						<option value = "lab"> Laboratory </option>
						<option value = "equipment"> Equipment </option>
						<option value = "seminar_hall"> Seminar Hall </option>
						<option value = "library"> Library </option>
						<option value = "board_room"> Board Room </option>
						<option value = "auditorium"> Auditorium </option>
						<option value = "gymnasium"> Gymnasium </option>
					</select>		
	
					<label> Capacity: </label>
					<input type = "number" name = "capacity">

					<label> Location: </label>
					<input type = "text" name = "location">
			
					<label> Description: </label>
					<input type = "text" name = "description">

					<label> Max Booking Duration (in minutes): </label>
					<input type = "number" name = "max_booking_minutes">

					<label> Daily Opening Time: </label>
					<input type = "text" name = "daily_open_time">

					<label> Daily Closing Time: </label>
					<input type = "text" name = "daily_closing_time">
				
					<input type = "submit" class = "btn btn-primary" value = "Create Resource">
				</form>
				<?php 
					if ($_SERVER['REQUEST_METHOD'] === 'POST'){
						$action = trim($_POST['action'] ?? '');
						if ($action === 'resource_create'){
							echo $comment;
						}
					}
				?>
			</section>
			<section class = "card" id = "view_resources">
				<div class = "card-header">
					<div>
						<h2 class = "card-title"> View Resources </h2>
						<p class = "card-desc"> View resources in tabular format </p>
					</div>
				</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "resource_view">
			
					<label> Resource Type: </label>
					<select name = "resource_type">
						<option value = ""> Select One </option>
						<option value = "all"> Entire Resource Table </option>
						<option value = "classroom"> Classrooms </option>
						<option value = "lab"> Laboratories </option>
						<option value = "equipment"> Equipments </option>
						<option value = "seminar_hall"> Seminar Halls </option>
						<option value = "library"> Libraries </option>
						<option value = "board_room"> Board Rooms </option>
						<option value = "auditorium"> Auditorium </option>
						<option value = "gymnasium"> Sport Complexes </option>
					</select>
					
					<input type = "submit" class = "btn btn-primary" value = "View Resources">
				</form>
				<?php
					if ($_SERVER['REQUEST_METHOD'] === 'POST'){
						$action = $_POST['action'] ?? '';
						if ($action === 'resource_view'){
							echo $comment;
						}
					}
				?>
			</section>
			<section class = "card" id = "update_resources">
				<div class = "card-header">
					<div>
						<h2 class="card-title"> Update Resources </h2>
						<p class = "card-desc"> Update present resources for modern additions and redundancy removal </p>
					</div>
				</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "resource_update">
					
					<label> Resource Code: </label>
					<input type = "text" name = "resource_code">

					<p> Pick Parameters to Update (leave the space blank to keep value unchanged): </p>
					<ol>
						<li> 
							<p> Basic Info: </p>
							<label> Resource Name: </label>
							<input type = "text" name = "resource_name">
					
							<label> Location: </label>
							<input type = "text" name = "location">

							<label> Description: </label>
							<input type = "text" name = "description">

							<label> Capacity: </label>
							<input type = "number" name = "capacity">
						</li>
						<li> 	
							<p> Booking Rules: </p>
							<label for = "max_booking_minutes"> Max Booking Time (in minutes): </label>
							<input type = "number" id = "max_booking_minutes" name = "max_booking_minutes">
	
							<label for = "daily_open_time"> Daily Open Time: </label>
							<input type = "text" id = "daily_open_time" name = "daily_open_time">

							<label for = "daily_closing_time"> Daily Closing Time: </label>
							<input type = "text" id = "daily_closing_time" name = "daily_closing_time">
						</li>
					</ol>
					<input type = "submit" class = "btn btn-primary" value = "Update Resources">
				</form> 
				<?php
					if ($_SERVER['REQUEST_METHOD'] === 'POST'){
						$action = $_POST['action'] ?? '';
						if ($action === 'resource_update'){
							echo $comment;
						}
					}
				?>
			</section>
			<section class = "card" id = "activate_deactivate_resources">
				<div class = "card-header">
					<div>
						<h2 class = "card-title"> Activate/Deactivate Resources </h2>
						<p class = "card-desc"> Activate or Deactivate resources according to the requirement. </p>
					</div>
				</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "resource_activation_and_deactivation">
					<select name = "activate_or_deactivate" id = "ops" required>
						<option value = ""> Select Operation</option>
						<option value = "activate"> Activate </option>
						<option value = "deactivate"> Deactivate </option>
					</select>
				
					<label for = "code"> Resources Code: </label>
					<input type = "text" id = "code" name = "resource_code" required>
					
					<input type = "submit" class = "btn btn-primary" value = "Confirm">
				</form>
				
				<?php
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						$action = $_POST['action'] ?? '';  

						if ($action === 'resource_activation_and_deactivation') {
							echo $comment;
						}
					}
				?>
			</section>

			<!-- Delete Resources -->
			<section class = "card" id = "delete_resources">
				<div class = "card-header">
					<div>
						<h2 class = "card-title"> Delete Resources </h2>
						<p class = "card-desc"> Delete resources that are no longer required. </p>
					</div>
				</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "resource_deletion">

					<label> Resource Code: </label>
					<input type = "text" name = "resource_code" required>
		
					<input type = "submit" class = "btn btn-primary" value = "Confirm Deletion">
				</form>
				<?php
					if ($_SERVER['REQUEST_METHOD'] === 'POST'){
						$action = $_POST['action'] ?? '';
						if ($action === 'resource_deletion'){
							echo $comment;
						}
					}
				?>
			</section>