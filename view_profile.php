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
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
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
    <center><h4>View Profile</h4><br></center>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" value="<?php echo $name; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" value="<?php echo $email; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile:</label>
                    <input type="text" class="form-control" value="<?php echo $mobile; ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" value="<?php echo $address; ?>" disabled>
                </div>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>
</html>
