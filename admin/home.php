<?php
session_start();
if ($_SESSION['admin_login_status'] != "loged in" && !isset($_SESSION['user_id'])) {
    header("location:../index.php");
    exit();
}

// Logout code
if (isset($_GET['sign']) && $_GET['sign'] == "out") {
    $_SESSION['admin_login_status'] = "loged out";
    unset($_SESSION['user_id']);
    header("location:../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('mn.jfif') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .header {
            padding: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
        }
        .header h1 {
            font-size: 50px;
            margin: 0;
        }
        .topnav {
            background-color: rgba(0, 0, 0, 0.8);
            overflow: hidden;
        }
        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-weight: bold;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            margin: 20px auto;
            width: 80%;
        }
        .card {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .footer {
            padding: 20px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
        }
        @media (max-width: 800px) {
            .topnav a {
                float: none;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Welcome to Admin Page</h1>
</div>

<div class="topnav">
    <a href="#">Home</a>
    <a href="addbook.php">Add Book</a>
    <a href="store.php">Store</a>
    <a href="corder.php">Customer Orders</a>
    <a href="view_payments.php">View Payments</a>
    <a href="?sign=out" style="float:right">Logout</a>
    <a href="changepassword.php" style="float:right">Change Password</a>
</div>

<div class="container">
    <div class="card">
        <h5>Today: <?php echo date('D M Y'); ?></h5>
        <h2>ZIA ONLINE BOOK SHOP</h2>
        <img src="books.JPG" alt="Books" style="width: 100%; height: auto;">
    </div>

    <div class="card">
        <h4>About Me</h4>
        <p>Hello, I am Saima!</p>
        <img src="bl.JPG" alt="Profile" style="width: 100%; height: auto;">
    </div>

    <div class="card">
        <h4>Gallery</h4>
        <img src="jp.JPG" alt="Gallery Image" style="width: 100%; height: auto;">
    </div>
</div>

<div class="footer">
    <h2>Contact: symon@gmail.com</h2>
</div>

</body>
</html>


