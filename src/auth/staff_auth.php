<?php
	try{
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			if(($_POST['action'] ?? '') === 'staff_create'){
				$staff_name = trim($_POST['staff_name'] ?? '');
				$staff_email = trim($_POST['staff_email'] ?? '');
				$staff_phone = trim($_POST['staff_phone'] ?? '');
				$staff_dept = trim($_POST['staff_dept'] ?? '');
				$staff_number = trim($_POST['staff_number'] ?? '');
				$staff_code = trim($_POST['staff_code'] ?? '');
				$staff_password = trim($_POST['staff_password'] ?? '');

				$staff_password_safe = password_hash($staff_password, PASSWORD_DEFAULT);

				$sql_staff_create = 'INSERT INTO `users` (`name`, `email`, `phone`, `dept`, `roll_number`, `user_code`, `role`, `password`) VALUES (:staff_name, :staff_email, :staff_phone, :staff_dept, :staff_number, :staff_code, "staff", :staff_password_safe)';
				$stmt = $pdo->prepare($sql_staff_create);
				$stmt->execute([
					':staff_name' => $staff_name,
					':staff_email' => $staff_email,
					':staff_phone' => $staff_phone,
					':staff_dept' => $staff_dept,
					':staff_number' => $staff_number,
					':staff_code' => $staff_code,
					':staff_password_safe' => $staff_password_safe
				]);
				$output = 'Staff data entered successfully';
			}
			if(($_POST['user_data_to_view'] ?? '') === 'staff'){
				$sql_data_retrieval_staff = 'SELECT `user_id`, `name`, `email`, `phone`, `dept`, `roll_number`, `user_code`, `role`, `is_active`, `created_at`, `updated_at`, `last_login_at`, `last_logout_at` FROM `users` WHERE `role` = :role';
				$result = $pdo->prepare($sql_data_retrieval_staff);
				$result->execute([
					':role' => "staff",		
				]);
				
				$view_staff = "<h3>Staff Table:</h3>";
            			$view_staff .= "<table border='1' cellpadding='6'>";
            			$view_staff .= "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Department</th><th>Staff Number</th><th>Code</th><th>Role</th><th>Active</th><th>Created At</th><th>Updated At</th><th>Last Login At</th><th>Last Logout At</th></tr>";

           			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                			$view_staff .= "<tr>";
                			$view_staff .= "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                			$view_staff .= "<td>" . htmlspecialchars($row['name']) . "</td>";
                			$view_staff .= "<td>" . htmlspecialchars($row['email']) . "</td>";
                			$view_staff .= "<td>" . htmlspecialchars($row['phone']) . "</td>";
                			$view_staff .= "<td>" . htmlspecialchars($row['dept']) . "</td>";
					$view_staff .= "<td>" . htmlspecialchars($row['roll_number']) . "</td>";
                			$view_staff .= "<td>" . htmlspecialchars($row['user_code']) . "</td>";
                			$view_staff .= "<td>" . htmlspecialchars($row['role']) . "</td>";
					$view_staff .= "<td>" . htmlspecialchars($row['is_active'] == 1 ? "Active" : "Deactive") . "</td>";
                			$view_staff .= "<td>" . ($row['created_at']) . "</td>";
                			$view_staff .= "<td>" . ($row['updated_at']) . "</td>";
					$view_staff .= "<td>" . ($row['last_login_at']) . "</td>";
                			$view_staff .= "<td>" . ($row['last_logout_at']) . "</td>";
                           		$view_staff .= "</tr>";
           			}
				$view_staff .= "</tables>";
			}
			if (($_POST['action'] ?? '') === 'activation_and_deactivation') {
				$user_code = trim($_POST['user_code'] ?? '');
				$role = $_POST['user_to_activate_or_deactivate'] ?? '';
    				$operation = $_POST['activate_or_deactivate'] ?? '';
			
				
				if ($user_code === '') {
       					$comment = "User code cannot be empty.";
    				} elseif ($role !== 'staff' && $role !== 'student') {
        				$comment = "Invalid user type selected.";
   				} elseif ($operation !== 'activate' && $operation !== 'deactivate') {
        				$comment = "Invalid operation selected.";
    				} else {
					$newActiveValue = ($operation === 'activate') ? 1 : 0;

        				$retrieve = 'SELECT `is_active` FROM `users` WHERE `role` = :role AND `user_code` = :user_code';
       					$stmt = $pdo->prepare($retrieve);
        				$stmt->execute([
            					':role' => $role,
            					':user_code' => $user_code
        				]);

        				$row = $stmt->fetch(PDO::FETCH_ASSOC);

        				if (!$row) {
            					$comment = "No $role user found with code: \"$user_code\"";
        				} else {

            					if ((int)$row['is_active'] === $newActiveValue) {
                					if ($newActiveValue === 1) {
                    						$comment = ucfirst($role) . " user \"$user_code\" is already active.";
                					} else {
                    						$comment = ucfirst($role) . " user \"$user_code\" is already deactivated.";
                					}
            					} else {
                					$sql = 'UPDATE `users`
                        					SET `is_active` = :active
                        					WHERE `role` = :role AND `user_code` = :user_code';

                					$stmt = $pdo->prepare($sql);
                					$stmt->execute([
                    						':active' => $newActiveValue,
                    						':role' => $role,
                    						':user_code' => $user_code
                					]);

                					if ($newActiveValue === 1) {
                    						$comment = ucfirst($role) . " user \"$user_code\" has now been activated.";
                					} else {
                    						$comment = ucfirst($role) . " user \"$user_code\" has now been deactivated.";
                					}
            					}
					}
				}
			}
		}
	} catch (PDOException $e){
			$output = 'Error:'.$e;
	}
	include __DIR__.'/../../templates/output.html.php';
?>
