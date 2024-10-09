<?php
session_start();
if ($_SESSION['customer_login_status'] != "loged in" && !isset($_SESSION['user_id'])) {
    header("location:../index.php");
    exit();
}

// Logout code
if (isset($_GET['sign']) && $_GET['sign'] == "out") {
    $_SESSION['customer_login_status'] = "loged out";
    unset($_SESSION['user_id']);
    header("location:../index.php");
    exit();
}

include("../connection.php");

if (isset($_POST['submit'])) {
    $customer_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new password and confirmation match
    if ($new_password === $confirm_password) {
        // Verify current password
        $sql = "SELECT password FROM Users WHERE cus_id = '$customer_id'"; // Adjust table name if needed
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($current_password, $row['password'])) {
            // Update password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password
            $update_sql = "UPDATE Users SET password = '$hashed_new_password' WHERE cus_id = '$customer_id'";

            if (mysqli_query($con, $update_sql)) {
                echo "<script>alert('Password changed successfully!');</script>";
            } else {
                echo "Error updating password: " . mysqli_error($con);
            }
        } else {
            echo "<script>alert('Current password does not match.');</script>";
        }
    } else {
        echo "<script>alert('New passwords do not match.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial; padding: 10px; background: #f1f1f1; }
        .header { padding: 15px; text-align: center; background: lightblue; }
        .form-container { max-width: 400px; margin: auto; padding: 20px; background: white; border-radius: 5px; }
        .form-container label { display: block; margin-bottom: 5px; }
        .form-container input { width: 100%; padding: 10px; margin-bottom: 10px; }
        .form-container button { padding: 10px; background: salmon; color: white; border: none; cursor: pointer; }
        .form-container button:hover { background: darksalmon; }
        .topnav { overflow: hidden; background-color: #333; }
        .topnav a { float: left; display: block; color: #f2f2f2; text-align: center; padding: 14px 16px; text-decoration: none; }
        .topnav a:hover { background-color: #ddd; color: black; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Change Password</h1>
    </div>

    <div class="topnav">
        <a href="home.php">Home</a>
        <a href="product.php">All Items</a>
        <a href="cusorder.php">Place Order</a>
        <a href="?sign=out" style="float:right">Logout</a>
    </div>

    <div class="form-container">
        <form action="changepassword_customer.php" method="post">
            <label for="current_password">Current Password</label>
            <input type="password" name="current_password" required>

            <label for="new_password">New Password</label>
            <input type="password" name="new_password" required>

            <label for="confirm_password">Confirm New Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit" name="submit">Change Password</button>
        </form>
    </div>
</body>
</html>


