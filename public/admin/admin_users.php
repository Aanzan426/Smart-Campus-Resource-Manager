<?php
	session_start();
	include __DIR__.'/../../src/config/db.php';
	include __DIR__.'/../../src/auth/staff_auth.php';
	include __DIR__.'/../../src/auth/student_auth.php';
	if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
  		header("Location: /admin/admin_login.php");
  		exit;
	}
?>
<!DOCTYPE html>
<html lang = "en">
	<head>
		<meta charset = "UTF-8">
		<title> User Management - Admin Access </title>
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
                			<a href="#create_staff_entry">Create Staff</a>
               				<a href="#create_student_entry">Create Student</a>
                			<a href="#view_users">View Users</a>
                			<a href="admin_dashboard.php">Dashboard</a>
            			</nav>
	
            			<div class="user-pill">
                			<span class="dot"></span>
                			<span>Logged in: Admin</span>
            			</div>
	
        		</div>
    		</header>
		<main>
			<h1 class="page-title">User Management</h1>
        		<p class="page-subtitle">
           			 Create staff/student entries and view records from the database.
        		</p>
			
			<!-- Card: Create Staff -->
        		<section class="card" id="create_staff_entry">
            			<div class="card-header">
                			<div>
                    				<h2 class="card-title">Create Staff Entry</h2>
                    				<p class="card-desc">Register staff with department and staff number.</p>
                			</div>
            			</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "staff_create">
					
					<label> Staff Name: </label>
					<input type = "text" name = "staff_name">

					<label> Email_ID: </label>
					<input type = "email" name = "staff_email">

					<label> Phone: </label>
					<input type = "number" name = "staff_phone">

					<label> Department: </label>
					<input type = "text" name = "staff_dept">

					<label> Staff Number: </label>  <?php // Replacement for Roll Number for Staff; ?>
					<input type = "text" name = "staff_number">
	
					<label> Code: </label>
					<input type = "text" name = "staff_code">

					<label> Password: </label>
					<input type = "password" name = "staff_password">

					<input type="submit" class="btn btn-primary" value="Create Staff">
				</form>
			<section>

			<!-- Card: Create Student -->
        		<section class="card" id="create_student_entry">
            			<div class="card-header">
                			<div>
                    				<h2 class="card-title">Create Student Entry</h2>
                    				<p class="card-desc">Register staff with department and student number.</p>
                			</div>
            			</div>

				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "student_create">
					
					<label> Student Name: </label>
					<input type = "text" name = "student_name">

					<label> Email_ID: </label>
					<input type = "email" name = "student_email">

					<label> Phone: </label>
					<input type = "number" name = "student_phone">

					<label> Department: </label>
					<input type = "text" name = "student_dept">

					<label> Roll Number: </label>  <?php // Replacement for Roll Number for Staff; ?>
					<input type = "text" name = "student_number">
	
					<label> Code: </label>
					<input type = "text" name = "student_code">

					<label> Password: </label>
					<input type = "password" name = "student_password">

					<input type="submit" class="btn btn-primary" value="Create Student">
				</form>
			</section>

			<!-- Card: View Users -->
        		<section class="card" id="view_users">
         			<div class="card-header">
          		        	<div>
            		         	   <h2 class="card-title">View Users</h2>
          		         	   <p class="card-desc">Choose user type to fetch from database.</p>
                			</div>
				</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "view_users">
					<select name =  "user_data_to_view" required>
						<option value = ""> Select </option>
						<option value = "staff"> Staff </option>
						<option value = "student"> Student </option> 
					</select>
					<button type="submit" class="btn">View</button>
				</form>
				<?php 
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						$action = $_POST['action'] ?? '';
						$type = $_POST['user_data_to_view'] ?? '';
						if($action === 'view_users'){
							if($type === 'staff'){
								echo $view_staff;
							}else {
								echo $view_student;
							}
						}
					}
				?>	 
			</section>

			<!-- Card: Activate/Deactivate Users -->
			<section class = "card" id = "activate/deactivate users">
				<div class = "class-header">
					<div>
						<h2 class = "card-title"> Activate/Deactivate User Accounts</h2>
						<p class = "card-desc"> Choose user type to fetch from database.</p>
					</div>
				</div>
				<form action = "" method = "post">
					<input type = "hidden" name = "action" value = "activation_and_deactivation">
					<select name = "user_to_activate_or_deactivate" id = "" required>
						<option value = ""> Select User</option>
						<option value = "staff"> Staff </option>
						<option value = "student"> Student </option>
					</select>
				
					<select name = "activate_or_deactivate" id = "ops" required>
						<option value = ""> Select Operation</option>
						<option value = "activate"> Activate </option>
						<option value = "deactivate"> Deactivate </option>
					</select>
				
					<label for = "code"> User Code: </label>
					<input type = "text" id = "code" name = "user_code">
					
					<button type = "submit" class = "btn"> Confirm</button>
				</form>
				
				<?php
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						$action = $_POST['action'] ?? '';  

						if ($action === 'activation_and_deactivation') {
							echo $comment;
						}
					}
				?>
			</section>
		</main>
		<?php include __DIR__.'/../../templates/footer.php'; ?>
			

				
					  
				