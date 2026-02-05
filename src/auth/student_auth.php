<?php
	try{
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			if(($_POST['action'] ?? '') === 'student_create'){
				$student_name = trim($_POST['student_name'] ?? '');
				$student_email = trim($_POST['student_email'] ?? '');
				$student_phone = trim($_POST['student_phone'] ?? '');
				$student_dept = trim($_POST['student_dept'] ?? '');
				$student_number = trim($_POST['student_number'] ?? '');
				$student_code = trim($_POST['student_code'] ?? '');
				$student_password = trim($_POST['student_password'] ?? '');

				$student_password_safe = password_hash($student_password, PASSWORD_DEFAULT);

				$sql_staff_create = 'INSERT INTO `users` (`name`, `email`, `phone`, `dept`, `roll_number`, `user_code`, `role`, `password`) VALUES (:student_name, :student_email, :student_phone, :student_dept, :student_number, :student_code, "student", :student_password_safe)';
				$stmt = $pdo->prepare($sql_staff_create);
				$stmt->execute([
					':student_name' => $student_name,
					':student_email' => $student_email,
					':student_phone' => $student_phone,
					':student_dept' => $student_dept,
					':student_number' => $student_number,
					':student_code' => $student_code,
					':student_password_safe' => $student_password_safe
				]);
				$output = 'Student data entered successfully';
			}
			else if(($_POST['user_data_to_view'] ?? '') === 'student'){
				$sql_data_retrieval_student = 'SELECT `user_id`, `name`, `email`, `phone`, `dept`, `roll_number`, `user_code`, `role`, `created_at`, `updated_at`, `last_login_at`, `last_logout_at` FROM `users` WHERE `role`= :role';
				$result = $pdo->prepare($sql_data_retrieval_student);
				$result->execute([
					':role' => "student",
				]);
				
				$view_student = "<h3>Student Table:</h3>";
            			$view_student .= "<table border='1' cellpadding='6'>";
            			$view_student .= "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Department</th><th>Staff Number</th><th>Code</th><th>Role</th><th>Created At</th><th>Updated At</th><th>Last Login At</th><th>Last Logout At</th></tr>";

           			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                			$view_student .= "<tr>";
                			$view_student .= "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['name']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['email']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['phone']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['dept']) . "</td>";
					$view_student .= "<td>" . htmlspecialchars($row['roll_number']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['user_code']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['role']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
					$view_student .= "<td>" . htmlspecialchars($row['last_login_at']) . "</td>";
                			$view_student .= "<td>" . htmlspecialchars($row['last_logout_at']) . "</td>";
                           		$view_student .= "</tr>";
           			}
				$view_student .= "</table>";
			}

		}
	} catch (PDOException $e){
			$output = 'Error:'.$e;
	}
	include __DIR__.'/../../templates/output.html.php';
?>
