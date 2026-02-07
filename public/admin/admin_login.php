	<?php include __DIR__.'/../../templates/header_public.php'; ?>
	<?php require __DIR__.'/../../src/auth/admin_auth.php'; ?>
	<main>
		<div class="auth-shell">
  			<div class="auth-card">
    				<h1 class="auth-title">Admin Login</h1>
    				<p class="auth-subtitle">Access the Smart Campus system securely.</p>
    				<form action="" method="post">
      					<input type="hidden" name="action" value="admin">
        
        				<label>Username:</label>
        				<input type="text" name="username" required>
        
        				<label>Password:</label>
        				<input type="password" name="password" required>
        
        				<button class="btn btn-primary" type="submit">Login</button>
				</form>
			</div>
		</div>
	</main>
	<?php include __DIR__.'/../../templates/footer.php'; ?>
