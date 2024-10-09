<?php
session_start();
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Home</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f1f1f1;
        }
        .header {
            padding: 15px;
            text-align: center;
            background: lightblue;
        }
        .header h1 {
            font-size: 50px;
        }
        .topnav {
            overflow: hidden;
            background-color: #333;
        }
        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
        .row {
            display: flex;
            margin: 20px;
        }
        .leftcolumn {
            flex: 70%;
            padding: 20px;
        }
        .rightcolumn {
            flex: 30%;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
        }
        .card {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            background: #ddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Welcome to Customer's Page</h1>
</div>

<div class="topnav">
    <a href="home.php">Home</a>
    <a href="product.php">All Items</a>
    <a href="cusorder.php">Place Order</a>
    <a href="payment.php">Make Payment</a>
    <a href="?sign=out" style="float:right">Logout</a>
    <a href="changepassword_customer.php" style="float:right">Change Password</a>
</div>

<div class="row">
    <div class="leftcolumn">
        <div class="card">
            <h3>"There is no friend as loyal as a book"</h3>
            <img src="mmn.JPG" alt="bgg" height="400" width="100%">
        </div>
    </div>
    <div class="rightcolumn">
        <div class="card">
            <h2>About Me</h2>
            <?php
            include("../connection.php");
            $cusid = $_SESSION['user_id'];
            $sql = "SELECT fullname, location, mobile_no, email, image FROM customer WHERE cus_id='$cusid'";
            $r = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($r);
            $name = $row['fullname'];
            $image = $row['image'];
            $adds = $row['location'];
            $mbl = $row['mobile_no'];
            $email = $row['email'];

            echo "<h3>Hello, I am $name</h3>";
            echo "<div style='height:100px;'><img src='../uploadedimage/$image' height='100px' width='100px' style='border-radius: 50%;'></div>";
            echo "<p><b>Location:</b> $adds<br><b>Mobile No:</b> $mbl<br><b>Email:</b> $email</p>";
            ?>
        </div>
    </div>
</div>

<div class="footer">
    <h2>Copyright @saima</h2>
</div>

</body>
</html>

