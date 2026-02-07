<?php include __DIR__.'/../../templates/header_app.php'; ?>
<main>
	<section id = "overview">
		<h2> Overview </h2>
		<p>
			Smart Campus Resource Manager is a PHP + MySQL based web application designed to solve a real-world campus problem: managing shared resources such as classrooms, 						laboratories, and equipment without conflicts or double-booking.

			The system focuses on backend fundamentals like authentication, session-based access control, clean database design, and secure CRUD operations using PDO prepared 						statements. It supports role-based workflows where administrators manage staff accounts and resources, staff members manage student accounts within their department scope, 					and users can create and track bookings through a structured interface.

			This project is intentionally built without frameworks to strengthen core PHP, SQL, and request–response flow understanding while maintaining scalable architecture through 					modular file organization (`public` for pages and `src` for logic/helpers).

		<p>
		<h4> - Zatch Winston </h4>
	</section>
	
</main>
<?php include __DIR__.'/../../templates/footer.php'; ?>

