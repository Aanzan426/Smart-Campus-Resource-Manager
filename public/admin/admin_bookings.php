<?php
	include __DIR__.'/../../src/config/db.php';
	include __DIR__.'/../../src/auth/admin_auth.php';
	if (!isset($_SESSION['admin']) || $_SESSION['admin'] != true){
		header("Location: /admin/admin_login.php");
		exit;
	}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "UTF-8">
		<title> Booking Management - Admin Access </title>
		<link rel = "stylesheet" href = "/assets/css/style.css">
	</head>
	<body>
		<header class="app-header">
        		<div class="container bar">

            			<div class="brand">
                			<div class="brand-badge"></div>
                			<div class="brand-text">
                    				<strong>Smart Campus Booking Manager</strong>
                    				<span>Admin Console</span>
                			</div>
            			</div>

            			<nav class="nav">
                			<a href="#view_bookings">View Bookings</a>
                			<a href="#search_bookings">Search Bookings</a>
					<a href="#create_bookings">Create Booking</a>
					<a href="#cancel_bookings">Cancel Bookings</a>
                			<a href="admin_dashboard.php">Dashboard</a>
            			</nav>
	
            			<div class="user-pill">
                			<span class="dot"></span>
                			<span>Logged in: Admin</span>
            			</div>
	
        		</div>
    		</header>
		<main>
			<section class = "card" id = "view_bookings">
				<div class = "card-header">
					<div>
						<h2 class = "card-title"> View Bookings </h2>
						<p class = "card-desc"> Viewing the bookings created by users and staff. </p>
					</div>
				</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "bookings_view">
					<label> View Bookings: </label>
					<input type = "submit" class = "btn btn-primary" value = "View All Bookings">
				</form>
				<?php
					if($_SERVER['REQUEST_METHOD'] === 'POST'){
						$action = $_POST['action'] ?? '';
						if($action === 'bookings_view'){
							echo $comment;
						}
					}
				?>
			</section>
			<section class = "card" id = "search_bookings">
				<div class = "card-header">
					<div>
						<h2 class = "card-title"> Search Bookings </h2>
						<p class = "card-desc"> Search the bookings created by users and staff. </p>
					</div>
				</div>
				<form method="post">
    					<label>Booking Table View Parameters</label><br><br>

    						<label><input type="checkbox" name="select_parameters[]" value="booking_status"> Status</label><br>
    						<label><input type="checkbox" name="select_parameters[]" value="booking_date_range"> Date Range</label><br>
    						<label><input type="checkbox" name="select_parameters[]" value="booking_resources"> Resource Code</label><br>
    						<label><input type="checkbox" name="select_parameters[]" value="booking_users"> User Code</label><br>
    						<label><input type="checkbox" name="select_parameters[]" value="booking_code"> Booking Code</label><br><br>

   					<input type="submit" class="btn btn-primary" value="Confirm">
				</form>
				<?php
					$selected = ($_POST['select_parameters'] ?? []);
					if (!empty($selected)){
				?>
					<form method = "post">
						<input type = "hidden" name = "action" value = "data_search">
						<?php if(in_array('booking_status', $selected)){ ?>
							<label> Status: </label>
							<select name = "data_status">
								<option value = "" disabled> Select One </option>
								<option value = "data_status_confirmed"> Confirmed </option>
								<option value = "data_status_cancelled"> Cancelled </option>
								<option value = "data_status_both"> Not Sure </option>
							</select>
						<?php } ?>
						<?php if(in_array('booking_date_range', $selected)){ ?>
							<label placeholder = "YYYY-MM-DD"> Booking Range (Start Date): </label>
							<input type = "datetime-local" name = "data_range_start">
							<label placeholder = "YYYY-MM-DD"> Booking Range (End Date): </label>
							<input type = "datetime-local" name = "data_range_end">
						<?php } ?>
						<?php if(in_array('booking_resources', $selected)){ ?>
							<label> Resource Code: </label>
							<input type = "text" name = "data_resource_code">
						<?php } ?>
						<?php if(in_array('booking_users', $selected)){ ?>
							<label> User Code: </label>
							<input type = "text" name = "data_user_code">
						<?php } ?>
						<?php if(in_array('booking_code', $selected)){ ?>
							<label> Booking Code: </label>
							<input type = "text" name = "data_booking_code">
						<?php } ?>
						<input type = "submit" class = "btn btn-primary" value = "Confirm Details">
					</form>
				<?php } ?>
				<?php
					if($_SERVER['REQUEST_METHOD'] === 'POST'){
						$action = $_POST['action'] ?? '';
						if ($action === 'data_search'){
							echo $comment;
						}
					}
				?>
			</section>
			<section class = "card" id = "create_bookings">
				<div class = "card-header">
					<div>
						<h2 class = "card-title"> Book Resource(s) </h2>
						<p class = "card-desc"> Create a resource booking (priority procedure used => First Come First Serve) </p>
					</div>
				</div>
				<form action = "#create_bookings"method = "post">
					<input type = "hidden" name = "action" value = "booking_creation">
	
					<label> User Code: </label>
					<input type = "text" name = "booker_auth">

					<label> User Password: </label>
					<input type = "text" name = "booker_auth_pass">

					<input type = "submit" class = "btn btn-primary" value = "Authenticate">
				</form>
				<?php
					if(($_POST['action'] ?? '') === 'booking_creation'){
						echo $comment;
					}
					if(($_POST['stage'] ?? '') === 'choose_resource'){
						echo $comment;
					}
				?>	 				
			</section>
			<section class = "card" id = "cancel_bookings">
				<div class = "card-header">
					<div>
						<h2 class = "card-title"> Cancel Booking(s) </h2>
						<p class = "card-desc"> ... </p>
					</div>
				</div>
				<form action = "#cancel_bookings" method = "post">
					<input type = "hidden" name = "action" value = "booking_cancellation">
 					
					<label> User Code: </label>
					<input type = "text" name = "booker_auth">

					<label> User Password: </label>
					<input type = "text" name = "booker_auth_pass">

					<input type = "submit" class = "btn btn-primary" value = "Confirm Cancellation">
				</form>
				<?php
					if(($_POST['action'] ?? '') === 'booking_cancellation'){
						echo $comment;
					}
					if(($_POST['stage'] ?? '') === 'cancel_booking_confirm'){
						echo $comment;
					}
				?>
			</section>