<?php
	session_start();
	try{
		require __DIR__.'/../config/db.php';
		include __DIR__.'/../helpers/cleanup_bookings.php';
		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			if(($_POST['action'] ?? '') === 'admin'){
				$username = trim($_POST['username'] ?? '');
				$password = trim($_POST['password'] ?? '');
		
				$sql_retrieve = 'SELECT `name`,`password` FROM `users` WHERE `user_code` = :user_code';
				$result = $pdo->prepare($sql_retrieve);
				$result->execute([ ':user_code' => "adm-426-titan"]);
			
				$row = $result->fetch(PDO::FETCH_ASSOC);
		
				if ($username == $row['name'] && password_verify($password, $row['password'])){
					$_SESSION['admin'] = true;
			
					header("Location: /admin/admin_dashboard.php");
    					exit;
				}else {
					header("Location: /admin/admin_login.php");
    					exit;
				}
			}
			if (($_POST['action'] ?? '') === 'resource_create'){
				$resource_name = trim($_POST['resource_name'] ?? '');
				$resource_code = trim($_POST['resource_code'] ?? '');
				$resource_type = trim($_POST['resource_type'] ?? '');
				$capacity = trim($_POST['capacity'] ?? '');
				$location = trim($_POST['location'] ?? '');
				$description = trim($_POST['description'] ?? '');
				$max_booking_minutes = trim($_POST['max_booking_minutes'] ?? '');
				$daily_open_time = trim($_POST['daily_open_time'] ?? '');
				$daily_closing_time = trim($_POST['daily_closing_time'] ?? '');

				$sql = 'INSERT INTO `resources` (`resource_name`,`resource_code`,`resource_type`,`capacity`,`location`,`description`,`max_booking_minutes`,`daily_open_time`,`daily_closing_time`)
					VALUES (:resource_name, :resource_code, :resource_type, :capacity, :location, :description, :max_booking_minutes, :daily_open_time, :daily_closing_time)';
				$stmt = $pdo->prepare($sql);
				$stmt->execute ([
					':resource_name' => $resource_name,
					':resource_code' => $resource_code,
					':resource_type' => $resource_type,
					':capacity' => $capacity,
					':location' => $location,
					':description' => $description,
					':max_booking_minutes' => $max_booking_minutes,
					':daily_open_time' => $daily_open_time,
					':daily_closing_time' => $daily_closing_time
				]);
				$comment = "Resource entry: " . $resource_code . ", has been created";
			}
			if (($_POST['action'] ?? '') === 'resource_view'){
				$resource_type = trim($_POST['resource_type'] ?? '');
		
				if($resource_type === 'all'){
					$sql = 'SELECT `resource_id`,`resource_name`,`resource_code`,`resource_type`,`capacity`,`location`,`max_booking_minutes`,`is_active`,`daily_open_time`,`daily_closing_time`,`created_at` FROM `resources`';
					$result = $pdo->prepare($sql);
					$result->execute([]);
				}else{
					$sql = 'SELECT `resource_id`,`resource_name`,`resource_code`,`resource_type`,`capacity`,`location`,`max_booking_minutes`,`is_active`,`daily_open_time`,`daily_closing_time`,`created_at` FROM `resources` WHERE `resource_type` = :resource_type';
					$result = $pdo->prepare($sql);
					$result->execute([
						':resource_type' => $resource_type
					]);
				}
				$comment = "<h3 class='section-title'>Resource Table</h3>";
				$comment .= "<table border='1' cellpadding='6'>";
        			$comment .= "<tr><th>ID</th><th>Resource Name</th><th>Resource Code</th><th>Resource Type</th><th>Capacity</th><th>Location</th><th>Maximum Booking Time</th><th>Status</th><th>Daily Opening Time</th><th>Daily Closing Time</th><th>Establishment</th></tr>";
        			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
               				$comment .= "<tr>";
                			$comment .= "<td>" . htmlspecialchars($row['resource_id']) . "</td>";
                			$comment .= "<td>" . htmlspecialchars($row['resource_name']) . "</td>";
                			$comment .= "<td>" . htmlspecialchars($row['resource_code']) . "</td>";
					$comment .= "<td>" . htmlspecialchars($row['resource_type']) . "</td>";
                			$comment .= "<td>" . htmlspecialchars($row['capacity']) . "</td>";
                			$comment .= "<td>" . htmlspecialchars($row['location']) . "</td>";
					$comment .= "<td>" . htmlspecialchars($row['max_booking_minutes']) . "</td>";
                			$comment .= "<td>" . htmlspecialchars($row['is_active'] == 1 ? "Active" : "Closed") . "</td>";
                			$comment .= "<td>" . htmlspecialchars($row['daily_open_time']) . "</td>";
					$comment .= "<td>" . htmlspecialchars($row['daily_closing_time']) . "</td>";
                			$comment .= "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                			$comment .= "</tr>";
        			}
				$comment .= "</table>";
			}
			if (($_POST['action'] ?? '') === 'resource_update'){
				$resource_code = trim($_POST['resource_code'] ?? '');
			
				if ($resource_code === ''){
					$comment = "Error: Resource Code is required to update a resource.";
            				return;
				}else {
					$resource_name = trim($_POST['resource_name'] ?? '');
					$capacity = trim($_POST['capacity'] ?? '');
					$location = trim($_POST['location'] ?? '');
					$description = trim($_POST['description'] ?? '');
					$max_booking_minutes = trim($_POST['max_booking_minutes'] ?? '');
					$daily_open_time = trim($_POST['daily_open_time'] ?? '');
					$daily_closing_time = trim($_POST['daily_closing_time'] ?? '');
		
					$fields = [];
					$params = [':resource_code' => $resource_code];

					if($resource_name != ''){
						$fields[] = "`resource_name` = :resource_name";
						$params[':resource_name'] = $resource_name;
					}
					if ($location != ''){
						$fields[] = "`location` = :location";
						$params[':location'] = $location;
					}
					if ($capacity != ''){
						$caps = (int)$capacity;
						if ($caps < 0){
							$comment = "Error: Capacity is required to be above 0.";
            						return;
						}
						$fields[] = "`capacity` = :capacity";
						$params[':capacity'] = $caps;
					}
					if($description != ''){
						$fields[] = "`description` = :description";
						$params[':description'] = $description;
					}
					if ($max_booking_minutes != ''){
						$max_booking_minutes = (int)$max_booking_minutes;
						if ($max_booking_minutes < 0){
							$comment = "Error: Capacity is required to be above 0.";
            						return;
						}
						$fields[] = "`max_booking_minutes` = :max_booking_minutes";
						$params[':max_booking_minutes'] = $max_booking_minutes;
					}
					if($daily_open_time != ''){
						$fields[] = "`daily_open_time` = :daily_open_time";
						$params[':daily_open_time'] = $daily_open_time;
					}
					if($daily_closing_time != ''){
						$fields[] = "`daily_closing_time` = :daily_closing_time";
						$params[':daily_closing_time'] = $daily_closing_time;
					}
					if (count($fields) === 0) {
            					$comment = "No fields provided. Nothing was updated.";
            					return;
        				}
					
					$fields[] = "`updated_at` = CURRENT_TIMESTAMP";
					
					$sql = 'UPDATE `resources` SET '. implode(",", $fields) . ' WHERE `resource_code` = :resource_code';
					$stmt = $pdo->prepare($sql);
					$stmt->execute($params);
					
					if ($stmt->rowCount() > 0) {
                				$comment = "Resource updated successfully for code: {$resource_code}";
            				} else {
                				$comment = "No update applied. Check resource code or values may be unchanged.";
            				}
				}
			}
			if (($_POST['action'] ?? '') === 'resource_activation_and_deactivation'){
				$activate_or_deactivate = trim($_POST['activate_or_deactivate'] ?? '');
				$resource_code = trim($_POST['resource_code'] ?? '');

				if ($resource_code === '') {
       					$comment = "User code cannot be empty.";
    				} else {
					$newActiveValue = ($activate_or_deactivate === 'activate') ? 1 : 0;

        				$retrieve = 'SELECT `is_active` FROM `resources` WHERE `resource_code` = :resource_code';
       					$stmt = $pdo->prepare($retrieve);
        				$stmt->execute([
            					':resource_code' => $resource_code
        				]);

        				$row = $stmt->fetch(PDO::FETCH_ASSOC);

        				if (!$row) {
            					$comment = "No resource found with code: \"$resource_code\"";
        				} else {

            					if ((int)$row['is_active'] === $newActiveValue) {
                					if ($newActiveValue === 1) {
                    						$comment = "Resource \"$resource_code\" is already active.";
                					} else {
                    						$comment = "Resource \"$resource_code\" is already deactivated.";
                					}
            					} else {
                					$sql = 'UPDATE `resources`
                        					SET `is_active` = :active
                        					WHERE `resource_code` = :resource_code';

                					$stmt = $pdo->prepare($sql);
                					$stmt->execute([
                    						':active' => $newActiveValue,
                    						':resource_code' => $resource_code
                					]);

                					if ($newActiveValue === 1) {
                    						$comment = "Resource \"$resource_code\" has now been activated.";
                					} else {
                    						$comment = "Resource \"$resource_code\" has now been deactivated.";
                					}
            					}
					}
				}
			}
			if (($_POST['action'] ?? '') === 'resource_deletion'){
				$resource_code = trim($_POST['resource_code'] ?? '');
				
				if ($resource_code === ''){
					$comment = "Resource doesnt exist. Try again.";
					return;
				} else{
					$sql = 'DELETE FROM `resources` WHERE `resource_code` = :resource_code';
					$stmt = $pdo->prepare($sql);
					$stmt->execute([
						':resource_code' => $resource_code
					]);
					$comment = "Resource deleted";
				}
			}
			if (($_POST['action'] ?? '') === 'bookings_view'){
				$sql = "
        				SELECT
            					b.id,
            					b.booking_code,
            					b.start_time,
            					b.end_time,
            					b.status,
          					u.user_code,
            					u.name AS user_name,
            					r.resource_code,
            					r.resource_name
        				FROM bookings b
        				INNER JOIN users u ON b.user_id = u.user_id
        				INNER JOIN resources r ON b.resource_id = r.resource_id
    					";

    				$sql .= " ORDER BY b.start_time DESC";

    				$stmt = $pdo->prepare($sql);
    				$stmt->execute([]);

    				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    				if (count($rows) > 0) {
        				$comment = "<h3 class='section-title'>Booking Search Results</h3>";
        				$comment .= "<div class='table-wrap'>";
        				$comment .= "<table border='1' cellpadding='6'>";
        				$comment .= "<tr>
                        			<th>ID</th>
                        			<th>Booking Code</th>
                        			<th>User</th>
                        			<th>Resource</th>
                        			<th>Start</th>
                        			<th>End</th>
                        			<th>Status</th>
                    				</tr>";

        				foreach ($rows as $row) {
            					$comment .= "<tr>";
            					$comment .= "<td>" . htmlspecialchars($row['id']) . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['booking_code']) . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['user_name'] . " (" . $row['user_code'] . ")") . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['resource_name'] . " (" . $row['resource_code'] . ")") . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['start_time']) . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['end_time']) . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['status']) . "</td>";
            					$comment .= "</tr>";
        				}

        				$comment .= "</table>";
        				$comment .= "</div>";
    				} else {
        				$comment = "No bookings found for the given filters.";
    				}
			}
			if (($_POST['action'] ?? '') === 'data_search') {

    				$data_status = trim($_POST['data_status'] ?? '');
    				$data_range_start = trim($_POST['data_range_start'] ?? '');
    				$data_range_end = trim($_POST['data_range_end'] ?? '');
    				$data_resource_code = trim($_POST['data_resource_code'] ?? '');
    				$data_user_code = trim($_POST['data_user_code'] ?? '');
    				$data_booking_code = trim($_POST['data_booking_code'] ?? '');

    				$fields = [];
    				$params = [];

    				if ($data_status !== '') {
        				$fields[] = "b.status = :status";
        				$params[':status'] = $data_status;
    				}

    				if ($data_range_start !== '') {
        				$data_range_start = str_replace("T", " ", $data_range_start);
        				$fields[] = "b.start_time >= :start_time";
        				$params[':start_time'] = $data_range_start;
    				}

    				if ($data_range_end !== '') {
        				$data_range_end = str_replace("T", " ", $data_range_end);
        				$fields[] = "b.end_time <= :end_time";
        				$params[':end_time'] = $data_range_end;
    				}

    				if ($data_resource_code !== '') {
        				$sql_lookup = "SELECT resource_id FROM resources WHERE resource_code = :resource_code LIMIT 1";
        				$stmt_lookup = $pdo->prepare($sql_lookup);
        				$stmt_lookup->execute([
            					':resource_code' => $data_resource_code
        				]);

        				$result = $stmt_lookup->fetch(PDO::FETCH_ASSOC);

        				if ($result) {
            					$fields[] = "b.resource_id = :resource_id";
            					$params[':resource_id'] = (int)$result['resource_id'];
        				} else {
            					$comment = "No resource found with code: " . htmlspecialchars($data_resource_code);
            					return;
        				}
    				}

    				if ($data_user_code !== '') {
        				$sql_lookup = "SELECT user_id FROM users WHERE user_code = :user_code LIMIT 1";
        				$stmt_lookup = $pdo->prepare($sql_lookup);
        				$stmt_lookup->execute([
            					':user_code' => $data_user_code
        				]);

        				$result = $stmt_lookup->fetch(PDO::FETCH_ASSOC);

        				if ($result) {
            					$fields[] = "b.user_id = :user_id";
            					$params[':user_id'] = (int)$result['user_id'];
        				} else {
            					$comment = "No user found with code: " . htmlspecialchars($data_user_code);
            					return;
        				}
    				}

    				if ($data_booking_code !== '') {
        				$fields[] = "b.booking_code = :booking_code";
        				$params[':booking_code'] = $data_booking_code;
    				}

    				$sql = "
        				SELECT
            					b.id,
            					b.booking_code,
            					b.start_time,
            					b.end_time,
            					b.status,
          					u.user_code,
            					u.name AS user_name,
            					r.resource_code,
            					r.resource_name
        				FROM bookings b
        				INNER JOIN users u ON b.user_id = u.user_id
        				INNER JOIN resources r ON b.resource_id = r.resource_id
    					";

    				if (count($fields) > 0) {
        				$sql .= " WHERE " . implode(" AND ", $fields);
    				}

    				$sql .= " ORDER BY b.start_time DESC";

    				$stmt = $pdo->prepare($sql);
    				$stmt->execute($params);

    				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    				if (count($rows) > 0) {
        				$comment = "<h3 class='section-title'>Booking Search Results</h3>";
        				$comment .= "<div class='table-wrap'>";
        				$comment .= "<table border='1' cellpadding='6'>";
        				$comment .= "<tr>
                        			<th>ID</th>
                        			<th>Booking Code</th>
                        			<th>User</th>
                        			<th>Resource</th>
                        			<th>Start</th>
                        			<th>End</th>
                        			<th>Status</th>
                    				</tr>";

        				foreach ($rows as $row) {
            					$comment .= "<tr>";
            					$comment .= "<td>" . htmlspecialchars($row['id']) . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['booking_code']) . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['user_name'] . " (" . $row['user_code'] . ")") . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['resource_name'] . " (" . $row['resource_code'] . ")") . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['start_time']) . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['end_time']) . "</td>";
            					$comment .= "<td>" . htmlspecialchars($row['status']) . "</td>";
            					$comment .= "</tr>";
        				}

        				$comment .= "</table>";
        				$comment .= "</div>";
    				} else {
        				$comment = "No bookings found for the given filters.";
    				}
			}
			if (($_POST['action'] ?? '') === 'booking_creation') {

    				$booker_auth = trim($_POST['booker_auth'] ?? '');
    				$booker_auth_pass = trim($_POST['booker_auth_pass'] ?? '');

    				$stmt = $pdo->prepare("SELECT user_id, user_code, password FROM users WHERE user_code = :code AND is_active = 1");
    				$stmt->execute([':code' => $booker_auth]);
    				$user = $stmt->fetch(PDO::FETCH_ASSOC);
	
    				if ($user && password_verify($booker_auth_pass, $user['password'])) {

        				$_SESSION['booking_user'] = $user['user_id'];

        				$comment = "<hr>";
        				$comment .= "<h3>Select Resource</h3>";

        				$comment .= "<form action='#create_bookings' method='post'>";
        				$comment .= "<input type='hidden' name='stage' value='choose_resource'>";

        				$resources = $pdo->query("
            					SELECT resource_id, resource_code, resource_name, resource_type 
            					FROM resources 
            					WHERE is_active = 1
            					ORDER BY resource_type, resource_name
        				");

        				$comment .= "<select name='resource_id' required>";
        				$comment .= "<option value=''>Select Resource</option>";
        				foreach ($resources as $r) {
         			   		$comment .= "<option value='{$r['resource_id']}'>
                    					{$r['resource_code']} — {$r['resource_name']} ({$r['resource_type']})
                  				</option>";
        				}
        				$comment .= "</select>";

        				$comment .= "<button class='btn btn-primary'>Continue</button>";
       					$comment .= "</form>";

    				} else {
        				echo "<div class='notice error'>Invalid credentials</div>";
    				}
			}
			if (($_POST['stage'] ?? '') === 'choose_resource') {

    				$_SESSION['chosen_resource'] = (int)$_POST['resource_id'];
    				$rid = $_SESSION['chosen_resource'];

    				$stmt = $pdo->prepare("
        				SELECT resource_name, daily_open_time, daily_closing_time, max_booking_minutes
        				FROM resources WHERE resource_id = :id
    				");
    				$stmt->execute([':id'=>$rid]);
    				$res = $stmt->fetch(PDO::FETCH_ASSOC);

    				if (!$res) {
        				$comment = "Invalid resource selected.";
        				return;
    				}

    				$comment = "<hr>";
    				$comment .= "<h3 class='section-title'>Available Slots — {$res['resource_name']}</h3>";

   				 /* =========================
       					TIME ENGINE (REAL FIX)
       				========================= */

    				$now = new DateTime(); // real current time

    				/* Build this week Monday → Friday */
    				$monday = new DateTime("monday this week");
   				 $week = [];

    				for ($i=0;$i<5;$i++) {
        				$d = clone $monday;
        				$d->modify("+$i day");

        				/* Skip past days completely */
        				if ($d->format("Y-m-d") < $now->format("Y-m-d")) continue;

        				$week[] = clone $d;
    				}

    				/* SLOT TEMPLATE (time only) */
    				$openTime  = new DateTime($res['daily_open_time']);
    				$closeTime = new DateTime($res['daily_closing_time']);

    				/* midnight close fix */
    				if ($closeTime <= $openTime) {
        				$closeTime->modify("+1 day");
    				}

    				$slotDuration = (int)$res['max_booking_minutes'] + 15;

    				$slots = [];
    				$cursor = clone $openTime;
    				$slotNo = 1;

    				while ($cursor < $closeTime) {

        				$end = clone $cursor;
        				$end->modify("+{$slotDuration} minutes");

        				if ($end > $closeTime) $end = clone $closeTime;

        				$slots[$slotNo] = [
            					'start' => $cursor->format("H:i:s"),
            					'end'   => $end->format("H:i:s")
        				];

        				$cursor = $end;
        				$slotNo++;
    				}

    				/* =========================
       					GRID
       				========================= */

    				$comment .= "<form action='#create_bookings' method='post'>";
    				$comment .= "<input type='hidden' name='stage' value='choose_slot'>";

    				$comment .= "<div class='table-wrap'>";
    				$comment .= "<table class='booking-grid'>";

    				/* header */
    				$comment .= "<thead><tr><th>Slot</th>";
    				foreach ($week as $day) {
        				$comment .= "<th>".$day->format("D<br>d M")."</th>";
    				}
    				$comment .= "</tr></thead><tbody>";

    				/* rows */
    				foreach ($slots as $sno=>$s) {

       					$comment .= "<tr>";
        				$comment .= "<td class='slot-label'>Slot $sno<br>".substr($s['start'],0,5)." - ".substr($s['end'],0,5)."</td>";

        				foreach ($week as $day) {

    						// build full datetime using day + slot
    						$slotStartDT = clone $day;
						$slotStartDT->setTime(
    							(int)substr($s['start'],0,2),
    							(int)substr($s['start'],3,2),
    							0
						);

						$slotEndDT = clone $day;
						$slotEndDT->setTime(
    							(int)substr($s['end'],0,2),
    							(int)substr($s['end'],3,2),
    							0
						);

    						$nowDT = new DateTime();

    						$nowTS = time();
						$slotEndTS = $slotEndDT->getTimestamp();

						$isPast = ($slotEndTS <= $nowTS);


    						if ($isPast) {
        						$comment .= "<td class='past'>Expired</td>";
        						continue;
    						}

    						$chk = $pdo->prepare("
        						SELECT COUNT(*) FROM bookings
        						WHERE resource_id = :rid
        						AND status='confirmed'
        						AND (start_time < :end AND end_time > :start)
    						");

    						$chk->execute([
        						':rid'=>$rid,
        						':start'=>$slotStartDT->format("Y-m-d H:i:s"),
        						':end'=>$slotEndDT->format("Y-m-d H:i:s")
    						]);

    						$booked = $chk->fetchColumn();

    						if ($booked) {
        						$comment .= "<td class='booked'>Booked</td>";
    						} else {
        						$val = $slotStartDT->format("Y-m-d H:i:s") . "|" . $slotEndDT->format("Y-m-d H:i:s");
        						$comment .= "<td class='available'>
            						<label>
                						<input type='radio' name='slot' value='$val' required>
                						Select
            						</label>
        						</td>";
    						}
					}
        				$comment .= "</tr>";
   				}

    				$comment .= "</tbody></table></div>";

    				$comment .= "<br>Notes:<br>
                 				<textarea name='notes' placeholder='Optional notes'></textarea><br>";

    				$comment .= "<button class='btn btn-primary'>Confirm Booking</button>";
    				$comment .= "</form>";
			}

			if (($_POST['stage'] ?? '') === 'choose_slot') {

    				if (!isset($_SESSION['chosen_resource'], $_SESSION['booking_user'])) {
        				$comment = "Session expired. Please restart booking.";
        				return;
    				}

    				if (empty($_POST['slot'])) {
        				$comment = "No slot selected.";
        				return;
    				}

    				$rid = (int)$_SESSION['chosen_resource'];
    				$uid = (int)$_SESSION['booking_user'];

    				list($start, $end) = explode('|', $_POST['slot']);

    				$startDT = new DateTime($start);
   				$endDT   = new DateTime($end);
    				$now     = new DateTime();

    				/* ---------- HARD VALIDATIONS ---------- */

    				if ($endDT <= $now) {
        				$comment = "Cannot book past time slot.";
        				return;
    				}

    				/* load resource rules again (NEVER trust UI) */
    				$res = $pdo->prepare("
        				SELECT daily_open_time, daily_closing_time, max_booking_minutes
        				FROM resources WHERE resource_id = :id
    				");
    				$res->execute([':id'=>$rid]);
    				$resource = $res->fetch(PDO::FETCH_ASSOC);

    				if (!$resource) {
        				$comment = "Invalid resource.";
        				return;
   				}

    				/* validate duration */
    				$duration = ($endDT->getTimestamp() - $startDT->getTimestamp()) / 60;

    				if ($duration > ($resource['max_booking_minutes'] + 15)) {
        				$comment = "Invalid slot duration.";
        				return;
   				}

    				/* ---------- TRANSACTION LOCK ---------- */

    				$pdo->beginTransaction();

    				$chk = $pdo->prepare("
        				SELECT COUNT(*) FROM bookings
        				WHERE resource_id = :rid
        				AND status='confirmed'
        				AND (start_time < :end AND end_time > :start)
        				FOR UPDATE
    				");

    				$chk->execute([
        				':rid'=>$rid,
        				':start'=>$startDT->format("Y-m-d H:i:s"),
        				':end'=>$endDT->format("Y-m-d H:i:s")
    				]);

    				if ($chk->fetchColumn() > 0) {
        				$pdo->rollBack();
        				$comment = "Sorry — someone just booked this slot.";
        				return;
    				}

    				/* create booking */
    				$booking_code = strtoupper(bin2hex(random_bytes(6)));

    				$stmt = $pdo->prepare("
        				INSERT INTO bookings
        				(booking_code, user_id, resource_id, start_time, end_time, notes)
        				VALUES (:code, :uid, :rid, :start, :end, :notes)
    				");

    				$stmt->execute([
        				':code'=>$booking_code,
        				':uid'=>$uid,
        				':rid'=>$rid,
        				':start'=>$startDT->format("Y-m-d H:i:s"),
        				':end'=>$endDT->format("Y-m-d H:i:s"),
        				':notes'=>trim($_POST['notes'] ?? '')
    				]);

    				$pdo->commit();

    				$comment = "Booking confirmed! Code: <b>$booking_code</b>";
			}
		}
	} catch(PDOException $e){
			$output = 'Error:'.$e;
	}
	include __DIR__.'/../../templates/output.html.php';
?>
