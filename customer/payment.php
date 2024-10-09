<?php
session_start();

// Check if user is logged in
if ($_SESSION['customer_login_status'] != "loged in" && !isset($_SESSION['user_id'])) {
    header("location:../index.php");
}

// Logout code
if (isset($_GET['sign']) && $_GET['sign'] == "out") {
    $_SESSION['customer_login_status'] = "loged out";
    unset($_SESSION['user_id']);
    header("location:../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment</title>
    <style>
        body {
            background-image: url('mn.jfif'); /* Use your background image */
            background-size: cover;
            background-position: center;
            color: white; /* White text for better visibility */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
            max-width: 600px;
            margin: 20px auto;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50; /* Green background */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Payment Page</h1>
</div>

<div class="topnav">
    <a href="home.php">Home</a>
    <a href="product.php">All Items</a>
    <a href="cusorder.php">Place Order</a>
    
    <a href="?sign=out" style="float:right">Logout</a>
    <a href="changepassword_customer.php" style="float:right">Change Password</a>
</div>

<div class="container">
    <h2>Payment Method</h2>
    <form action="payment.php" method="post">
        <label for="bkash">Bkash Number:</label>
        <input type="text" name="bkash" value="01943331625" readonly><br><br>
        <label for="amount">Amount:</label>
        <input type="number" name="amount" required><br><br>
        <input type="submit" name="submit" value="Make Payment">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Payment processing logic
        $bkash = $_POST['bkash'];
        $amount = $_POST['amount'];

        // Store the payment information in the database
        include("../connection.php");
        $sql = "INSERT INTO payments (customer_id, amount, transaction_id) VALUES ('" . $_SESSION['user_id'] . "', '$amount', '1234567890')"; // Adjust column names as necessary
        if (mysqli_query($con, $sql)) {
            echo "<p style='color: green;'>Payment successful!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . mysqli_error($con) . "</p>";
        }
    }
    ?>
</div>


</body>
</html>

