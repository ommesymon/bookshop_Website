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
<html>
<head>
    <title>Customer Orders</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial;
            padding: 10px;
            background: #f1f1f1;
        }

        .header {
            padding: 15px;
            text-align: center;
            background: salmon;
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

        .footer {
            padding: 20px;
            text-align: center;
            background: #ddd;
            margin-top: 20px;
        }

        @media screen and (max-width: 400px) {
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
    <a href="home.php">Home</a>
    <a href="addbook.php">Add Book</a>
    
    <a href="store.php">Store</a>
   
   
    <a href="?sign=out" style="float:right">Logout</a>
    <a href="#" style="float:right">Change Password</a>
</div>

<div class="container">
    <h2>All Customer Orders</h2>
    <?php
    include("../connection.php");
    $sql = "SELECT * FROM customer_order WHERE status = 0"; // Fix SQL Query
    $r = mysqli_query($con, $sql);
    echo "<table id='customers'>";
    echo "<tr>
        <th>Order ID</th>
        <th>Customer ID</th>
        <th>Order Date</th>
        <th>Action</th>
    </tr>";
    while ($row = mysqli_fetch_array($r)) {
        $oid = $row['order_id'];
        $cid = $row['customer_id']; // Adjust column name to match your DB
        $odate = $row['order_date'];
        echo "<tr>
            <td>$oid</td>
            <td>$cid</td>
            <td>$odate</td>
            <td><a href='corder.php?action=show&id=$oid'>Show Details</a></td>
        </tr>";
    }
    echo "</table>";
    ?>

    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'show') {
        $oid = $_GET['id'];
        $_SESSION['orderid'] = $oid;
        $sql = "SELECT * FROM orderline WHERE order_id='$oid'";
        $r = mysqli_query($con, $sql);

        echo "<h2>Order Details</h2>";
        echo "<table id='customers'>
        <tr>
            <th>Product ID</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>";
        $gtotal = 0;
        while ($row = mysqli_fetch_array($r)) {
            $pid = $row['p_id'];
            $q = $row['quantity'];
            $total = $row['total'];
            echo "<tr>
                <td>$pid</td>
                <td>$q</td>
                <td>$total</td>
            </tr>";
            $gtotal += $total;
        }
        echo "<tr><td colspan='2' align='right'>Grand Total</td><td>$gtotal</td></tr>";
        echo "</table>";
    }
    ?>
</div>

<form action='corder.php' method='post'>
    <div class="row">
        <input type="submit" value="Confirm Order" name="corder">
    </div>
</form>

<?php
if (isset($_POST['corder'])) {
    $oid = $_SESSION['orderid'];
    $sql = "SELECT * FROM orderline WHERE order_id='$oid'";
    $r = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($r)) {
        $pid = $row['p_id'];
        $q = $row['quantity'];
        $sqlupdate = "UPDATE store SET quantity = quantity - $q WHERE p_id = '$pid'";
        mysqli_query($con, $sqlupdate);
    }
    $sqlorderupdate = "UPDATE customer_order SET status = 1 WHERE order_id = '$oid'";
    mysqli_query($con, $sqlorderupdate);
    header("location:corder.php");
}
?>

<div class="footer">
    <h2>Copyright @omme symon</h2>
</div>

</body>
</html>
