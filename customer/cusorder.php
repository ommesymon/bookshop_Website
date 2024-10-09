<?php
session_start();
if ($_SESSION['customer_login_status'] != "loged in" && !isset($_SESSION['user_id'])) {
    header("location:../index.php");
}
// Logout code
if (isset($_GET['sign']) && $_GET['sign'] == "out") {
    $_SESSION['customer_login_status'] = "loged out";
    unset($_SESSION['user_id']);
    unset($_SESSION['cart']);
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial;
  padding: 10px;
  background: #f1f1f1;
}

/* Header/Blog Title */
.header {
  padding: 15px;
  text-align: center;
  background: pink;
}

.header h1 {
  font-size: 50px;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #333;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Footer */
.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
  margin-top: 20px;
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
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
  <h1>Customer Page</h1>
</div>

<div class="topnav">
  <a href="home.php">Home</a>
 
 
  <a href="product.php">All Items</a>
  <a href="payment.php">Make payment</a>
  <a href="?sign=out" style="float:right">Logout</a>
  <a href="changepassword_customer.php" style="float:right">Change Password</a>
</div>

<div class="row">
  <div class="container">
    <form action="cusorder.php" method="post">
      <div class="row">
        <div class="col-25">
          <label for="catg">Select a Product</label>
        </div>
        <div class="col-75">
          <select name="product">
            <?php
            include("../connection.php");
            $sql = "SELECT pname FROM product";
            $r = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($r)) {
                $p = $row['pname'];
                echo "<option value='$p'>$p</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="quantity">Enter Quantity</label>
        </div>
        <div class="col-75">
          <input type="text" name="quantity" placeholder="Enter quantity">
        </div>
      </div>
      <div class="row">
        <input type="submit" value="Submit" name="submit">
      </div>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        include("../connection.php");
        $num = rand(10, 1000);
        $order_id = "o-" . $num;
        $order_date = date("Y-m-d");
        $cid = $_SESSION['user_id'];
        $pname = $_POST['product'];
        $q = $_POST['quantity'];

        // Insert into customer_order table
        $sqlorder = "INSERT INTO customer_order (order_id, customer_id, order_date, status) 
                     VALUES ('$order_id', '$cid', '$order_date', 0)";

        if (mysqli_query($con, $sqlorder)) {
            // Get product ID from product name
            $query = "SELECT p_id FROM product WHERE pname='$pname'";
            $r = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($r);
            $pid = $row['p_id'];

            // Get selling price
            $query = "SELECT sellingprice FROM store WHERE p_id='$pid'";
            $r1 = mysqli_query($con, $query);
            $row1 = mysqli_fetch_assoc($r1);
            $price = $row1['sellingprice'];

            $total = $q * $price;

            // Insert into orderline table
            $sql = "INSERT INTO orderline (order_id, product_id, quantity, total) 
                    VALUES ('$order_id', '$pid', '$q', $total)";
            if (mysqli_query($con, $sql)) {
                echo "Your order has been submitted successfully!";
            } else {
                echo "Error inserting into orderline: " . mysqli_error($con);
            }
        } else {
            echo "Error inserting into customer_order: " . mysqli_error($con);
        }
    }
    ?>
  </div>
</div>


</body>
</html>
