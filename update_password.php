<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, "libms");
	$password = "";
	$query = "SELECT * FROM users WHERE email = '$_SESSION[email]'";
	$query_run = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($query_run)) {
		$password = $row['password'];
	}

	// Validate if the new password is 8 characters long
	if (strlen($_POST['new_password']) != 8) {
		?>
		<script type="text/javascript">
			alert("New password must be exactly 8 characters long.");
			window.location.href = "change_password.php";
		</script>
		<?php
	} else {
		// Check if the old password matches the current password
		if ($password == $_POST['old_password']) {
			$query = "UPDATE users SET password = '$_POST[new_password]' WHERE email = '$_SESSION[email]'";
			$query_run = mysqli_query($connection, $query);
			?>
			<script type="text/javascript">
				alert("Password updated successfully.");
				window.location.href = "user_dashboard.php";
			</script>
			<?php
		} else {
			?>
			<script type="text/javascript">
				alert("Incorrect old password.");
				window.location.href = "change_password.php";
			</script>
			<?php
		}
	}
?>

