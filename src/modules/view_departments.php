<?php
	include __DIR__.'/../config/db.php';
	$sql_department = 'SELECT * FROM `departments`';
	$result = $pdo->query($sql_department);
	
	echo "<h3 class='section-title'>Departmental Table</h3>";
	echo "<div class='table-wrap'>";
        echo "<table border='1' cellpadding='6'>";
        echo "<tr><th>ID</th><th>Department Name</th><th>Department Code</th><th>Active</th><th>Creation Date</th></tr>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['dept_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['dept_code']) . "</td>";
		echo "<td>" . htmlspecialchars($row['is_active'] == 1 ? "Active" : "Closed") . "</td>";
                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                echo "</tr>";
        }
	echo "</table>";
	echo "</div>";
?>