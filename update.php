<?php
session_start();

// Validate the email and mobile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Email validation: should be lowercase and end with @gmail.com
    $email = $_POST['email'];
    $email = strtolower($email); // Convert email to lowercase
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@gmail\.com$/", $email)) {
        echo "<script>alert('Invalid email. It must be a valid Gmail address in lowercase.'); window.history.back();</script>";
        exit();
    }

    // Mobile validation: should be 10 digits and not start with 0
    $mobile = $_POST['mobile'];
    if (!preg_match("/^[1-9][0-9]{9}$/", $mobile)) {
        echo "<script>alert('Invalid mobile number. It must be 10 digits and not start with 0.'); window.history.back();</script>";
        exit();
    }

    // Sanitize inputs
    $name = $_POST['name'];
    $address = $_POST['address'];

    // Database connection
    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, "libms");

    // Check if the email or mobile already exists
    $email_check = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email' AND email != '$_SESSION[email]'");
    $mobile_check = mysqli_query($connection, "SELECT * FROM users WHERE mobile = '$mobile' AND mobile != '$_SESSION[mobile]'");

    if (mysqli_num_rows($email_check) > 0) {
        echo "<script>alert('The email is already in use by another user.'); window.history.back();</script>";
        exit();
    }

    if (mysqli_num_rows($mobile_check) > 0) {
        echo "<script>alert('The mobile number is already in use by another user.'); window.history.back();</script>";
        exit();
    }

    // Update user information
    $update_query = "UPDATE users SET name = '$name', email = '$email', mobile = '$mobile', address = '$address' WHERE email = '$_SESSION[email]'";
    if (mysqli_query($connection, $update_query)) {
        $_SESSION['email'] = $email; // Update the session email
        echo "<script>alert('Profile updated successfully!'); window.location.href = 'view_profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile.'); window.history.back();</script>";
    }
}
?>
