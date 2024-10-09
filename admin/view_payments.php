<?php
session_start();

// Check if user is logged in
if ($_SESSION['admin_login_status'] != "loged in" && !isset($_SESSION['user_id'])) {
    header("location:../index.php");
}

// Logout code
if (isset($_GET['sign']) && $_GET['sign'] == "out") {
    $_SESSION['admin_login_status'] = "loged out";
    unset($_SESSION['user_id']);
    header("location:../index.php");
}

// Include database connection
include("../connection.php");

// Fetch payment details based on customer_id
$sql = "SELECT * FROM payments WHERE customer_id = '" . $_SESSION['user_id'] . "'";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Payments</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            background-image: url('mn.jfif'); /* Use your background image */
            background-size: cover;
            background-position: center;
            color: #fff; /* White text for visibility */
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
        }
        .topnav {
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            padding: 10px;
        }
        .topnav a {
            float: left;
            display: block;
            color: #fff; /* White text for menu items */
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .topnav a:hover {
            background-color: #ddd; /* Light background on hover */
            color: black;
        }
        .container {
            background: rgba(255, 255, 255, 0.8); /* White background with transparency */
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50; /* Green background for headers */
            color: white;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>View Payment</h1>
</div>

<div class="topnav">
    <a href="home.php">Home</a>
    <a href="product.php">All Items</a>
    <a href="cusorder.php">Place Order</a>
 
    <a href="?sign=out" style="float:right">Logout</a>
    <a href="changepassword.php" style="float:right">Change Password</a>
</div>

<div class="container">
    <h2>Your Payment History</h2>
    <table>
        <tr>
            <th>Transaction ID</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['transaction_id']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['date']}</td>
                  </tr>";
        }
        ?>
    </table>
</div>

<div class="footer">
    <h2>Copyright @saima</h2>
</div>

</body>
</html>

