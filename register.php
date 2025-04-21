<?php
	session_start();
	if (!isset($_SESSION['signup_data'])) {
		header("Location: signup.php");
		exit();
	}
	$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, "libms");

	$data = $_SESSION['signup_data'];

	// Check if the email already exists
	$email_query = "SELECT * FROM users WHERE email = '{$data['email']}'";
	$email_result = mysqli_query($connection, $email_query);
	if (mysqli_num_rows($email_result) > 0) {
		// Email already exists
		echo "<script type='text/javascript'>
				alert('This email is already registered. Please try a different email.');
				window.location.href = 'signup.php';
			  </script>";
		exit(); // Stop further execution
	}

	// Check if the mobile number already exists
	$mobile_query = "SELECT * FROM users WHERE mobile = '{$data['mobile']}'";
	$mobile_result = mysqli_query($connection, $mobile_query);
	if (mysqli_num_rows($mobile_result) > 0) {
		// Mobile number already exists
		echo "<script type='text/javascript'>
				alert('This mobile number is already registered. Please try a different mobile number.');
				window.location.href = 'signup.php';
			  </script>";
		exit(); // Stop further execution
	}

	// Insert the new user data into the database
	$query = "INSERT INTO users (name, email, password, mobile, address) VALUES ('{$data['name']}', '{$data['email']}', '{$data['password']}', '{$data['mobile']}', '{$data['address']}')";
	$query_run = mysqli_query($connection, $query);

	// Clear session data after successful registration
	unset($_SESSION['signup_data']); 

	// Show success message
	echo "<script type='text/javascript'>
			alert('Registration successful! You may login now.');
			window.location.href = 'index.php';
		  </script>";
?>


