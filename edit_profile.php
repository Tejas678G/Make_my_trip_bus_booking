<?php
session_start();

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "libms");

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch user data based on the session email (to display current info)
$query = "SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($connection, $_SESSION['email']) . "'";
$query_run = mysqli_query($connection, $query);

// Ensure query execution was successful and fetch the user details
if ($query_run && mysqli_num_rows($query_run) > 0) {
    $row = mysqli_fetch_assoc($query_run);
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $address = $row['address'];
} else {
    echo "<script>alert('User details not found. Please log in again.'); window.location.href = 'logout.php';</script>";
    exit;
}

// Variable to hold error messages
$error_message = "";

// Check if the form is submitted to update the email or mobile
if (isset($_POST['update_profile'])) {
    $new_email = mysqli_real_escape_string($connection, $_POST['new_email']);
    $new_mobile = mysqli_real_escape_string($connection, $_POST['new_mobile']);
    $new_address = mysqli_real_escape_string($connection, $_POST['new_address']);
    $current_email = $_SESSION['email']; // The current email stored in session

    // Validate email
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL) || !preg_match("/@gmail.com$/", $new_email) || strtolower($new_email) !== $new_email) {
        $error_message = 'Invalid email format. Please use a valid @gmail.com email in lowercase.';
    }
    // Validate mobile number
    elseif (!preg_match("/^[1-9]{1}[0-9]{9}$/", $new_mobile)) {
        $error_message = 'Mobile number must be 10 digits and not start with 0.';
    }
    // Check if the email or mobile already exists
    elseif (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM users WHERE email = '$new_email'")) > 0) {
        $error_message = 'The email is already in use by another user.';
    }
    elseif (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM users WHERE mobile = '$new_mobile'")) > 0) {
        $error_message = 'The mobile number is already in use by another user.';
    }

    // If no errors, proceed with updating the profile
    if (empty($error_message)) {
        $update_query = "UPDATE users SET email = '$new_email', mobile = '$new_mobile', address = '$new_address' WHERE email = '$current_email'";

        if (mysqli_query($connection, $update_query)) {
            // Update the session email after successful update
            $_SESSION['email'] = $new_email;

            // Redirect to view profile page with a success message
            echo "<script>alert('Profile updated successfully.'); window.location.href = 'view_profile.php';</script>";
        } else {
            echo "<script>alert('Error updating profile.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="bootstrap-4.4.1/js/jquery_latest.js"></script>
    <script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_dashboard.php">Make My Trip</a>
            <span style="color: white;"><strong>Welcome: <?php echo $_SESSION['name']; ?></strong></span>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="view_profile.php">View Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav><br>
    <center><h4>Edit Profile</h4><br></center>
    
    <!-- Display error message if any -->
    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php } ?>
    
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form method="POST" action="edit_profile.php">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" value="<?php echo $name; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="email">Current Email:</label>
                    <input type="text" value="<?php echo $email; ?>" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label for="new_email">New Email:</label>
                    <input type="email" name="new_email" class="form-control" value="<?php echo isset($_POST['new_email']) ? $_POST['new_email'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Current Mobile:</label>
                    <input type="text" class="form-control" value="<?php echo $mobile; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="new_mobile">New Mobile:</label>
                    <input type="text" name="new_mobile" class="form-control" value="<?php echo isset($_POST['new_mobile']) ? $_POST['new_mobile'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="new_address">New Address:</label>
                    <input type="text" name="new_address" class="form-control" value="<?php echo isset($_POST['new_address']) ? $_POST['new_address'] : ''; ?>" required>
                </div>
                <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>
</html>
