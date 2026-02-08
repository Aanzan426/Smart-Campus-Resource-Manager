<?php
	$pdo->exec("
    		UPDATE bookings
    		SET status = 'completed'
    		WHERE status = 'confirmed'
    		AND end_time <= NOW()
	");
?>