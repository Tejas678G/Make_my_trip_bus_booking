<?php
	session_start();
	$error = "";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$mobile = $_POST['mobile'];
		$address = $_POST['address'];

		// Validate email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, '@gmail.com') === false || $email !== strtolower($email)) {
			$error = "Email must be a valid @gmail.com address and in lowercase.";
		}
		// Validate password
		elseif (strlen($password) != 8) {
			$error = "Password must be exactly 8 characters long.";
		}
		// Validate mobile number
		elseif (!preg_match('/^[1-9][0-9]{9}$/', $mobile)) {
			$error = "Mobile number must be 10 digits and not start with 0.";
		}

		// Check if the email or mobile number already exists in the database
		if (empty($error)) {
			$connection = mysqli_connect("localhost", "root", "");
			$db = mysqli_select_db($connection, "libms");

			$email_check_query = "SELECT * FROM users WHERE email = '$email'";
			$result = mysqli_query($connection, $email_check_query);
			$mobile_check_query = "SELECT * FROM users WHERE mobile = '$mobile'";
			$mobile_result = mysqli_query($connection, $mobile_check_query);

			if (mysqli_num_rows($result) > 0) {
				$error = "Email is already registered. Please try a new email address.";
			} elseif (mysqli_num_rows($mobile_result) > 0) {
				$error = "Mobile number is already registered. Please try a new mobile number.";
			} else {
				// Save the data to session if email and mobile are unique
				$_SESSION['signup_data'] = $_POST;
				header("Location: register.php");
				exit();
			}
		}
	}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
	<title>LMS</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="bootstrap-4.4.1/js/jquery_latest.js"></script>
  	<script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
	#main_content{
		padding: 50px;
		background-color: whitesmoke;
	}
	#side_bar{
		background-color: whitesmoke;
		padding: 50px;
		width: 300px;
		height: 450px;
	}
</style>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Make My Trip</a>
			</div>
		    <ul class="nav navbar-nav navbar-right">
		      <li class="nav-item">
		        <a class="nav-link" href="#">Register</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="index.php">Login</a>
		      </li>
		    </ul>
		</div>
	</nav><br>
	<span><marquee>This is the official Make My Trip website</marquee></span><br><br>
	
		<div class="col-md-8" id="main_content">
			<center><h3><u>User Registration Form</u></h3></center>
			<?php if (!empty($error)): ?>
				<div class="alert alert-danger"><?php echo $error; ?></div>
			<?php endif; ?>
			<form action="signup.php" method="post">
				<div class="form-group">
					<label for="name">Full Name:</label>
					<input type="text" name="name" class="form-control" value="<?php echo isset($name) ? $name : (isset($_SESSION['signup_data']['name']) ? $_SESSION['signup_data']['name'] : ''); ?>" required>
				</div>
				<div class="form-group">
					<label for="email">Email ID:</label>
					<input type="text" name="email" class="form-control" value="<?php echo isset($email) ? $email : (isset($_SESSION['signup_data']['email']) ? $_SESSION['signup_data']['email'] : ''); ?>" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" class="form-control" value="<?php echo isset($password) ? $password : (isset($_SESSION['signup_data']['password']) ? $_SESSION['signup_data']['password'] : ''); ?>" required>
				</div>
				<div class="form-group">
					<label for="mobile">Mobile:</label>
					<input type="text" name="mobile" class="form-control" value="<?php echo isset($mobile) ? $mobile : (isset($_SESSION['signup_data']['mobile']) ? $_SESSION['signup_data']['mobile'] : ''); ?>" required>
				</div>
				<div class="form-group">
					<label for="address">Address:</label>
					<textarea name="address" class="form-control" required><?php echo isset($address) ? $address : (isset($_SESSION['signup_data']['address']) ? $_SESSION['signup_data']['address'] : ''); ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Register</button>
			</form>
		</div>
	</div>
</body>
</html>
