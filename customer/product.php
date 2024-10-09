<?php
session_start();

// Add to Cart Functionality
if (isset($_POST['add'])) {
    if (isset($_SESSION['cart'])) {
        $item_array_id = array_column($_SESSION['cart'], 'item_id');
        if (!in_array($_GET['id'], $item_array_id)) {
            $count = count($_SESSION['cart']);
            $item_array = array(
                'item_id' => $_GET['id'],
                'item_name' => $_POST['hname'],
                'item_price' => $_POST['hprice'],
                'item_q' => $_POST['quantity']
            );
            $_SESSION['cart'][$count] = $item_array;
        } else {
            echo "<script>alert('Item already added')</script>";
            echo "<script>window.location='product.php'</script>";
        }
    } else {
        $item_array = array(
            'item_id' => $_GET['id'],
            'item_name' => $_POST['hname'],
            'item_price' => $_POST['hprice'],
            'item_q' => $_POST['quantity']
        );
        $_SESSION['cart'][0] = $item_array;
    }
}

// Remove from Cart Functionality
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    foreach ($_SESSION['cart'] as $keys => $values) {
        if ($values['item_id'] == $_GET['id']) {
            unset($_SESSION['cart'][$keys]);
        }
    }
}

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
<html>
<head>
    <title>Customer Page</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial; padding: 10px; background: #f1f1f1; }
        .header { padding: 15px; text-align: center; background: salmon; }
        .header h1 { font-size: 50px; }
        .topnav { overflow: hidden; background-color: #333; }
        .topnav a { float: left; display: block; color: #f2f2f2; text-align: center; padding: 14px 16px; text-decoration: none; }
        .topnav a:hover { background-color: #ddd; color: black; }
        .footer { padding: 20px; text-align: center; background: #ddd; margin-top: 20px; }
        @media screen and (max-width: 400px) { .topnav a { float: none; width: 100%; } }
    </style>
</head>
<body>

<div class="header">
    <h1>Customer Page</h1>
</div>

<div class="topnav">
    <a href="home.php">Home</a>
    <a href="cusorder.php">Place Order</a>

    <a href="payment.php">Make payment</a>
    <a href="?sign=out" style="float:right">Logout</a>
    <a href="changepassword_customer.php" style="float:right">Change Password</a>
</div>

<div class="row">
    <div class="container">
        <form action="product.php" method="post">
            <div class="row">
                <div class="col-25">
                    <label for="catg">Select a Category</label>
                </div>
                <div class="col-75">
                    <select name="catg" id="catg" required>
                        <?php
                        include("../connection.php");
                        $sql = "SELECT DISTINCT ptype FROM product";
                        $r = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($r)) {
                            $type = $row['ptype'];
                            echo "<option value='$type'>$type</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <input type="submit" value="Go" name="go">
            </div>
        </form>
    </div>
    <div>

        <?php
        if (isset($_POST['go'])) {
            $c = $_POST['catg'];
            $query = "SELECT p.p_id, p.pname, p.ptype, p.writtername, p.bprice, s.sellingprice, p.image 
                      FROM product p 
                      JOIN store s ON p.p_id = s.p_id 
                      WHERE p.ptype = '$c'";
            $r = mysqli_query($con, $query);

            echo "<table id='customers'>";
            echo "<tr>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Writer Name</th>
            <th>Product Price</th>
            <th>Product Image</th>
            <th>Add Quantity</th>
            <th>Action</th>
            </tr>";

            while ($row = mysqli_fetch_array($r)) {
                $pid = $row['p_id'];
                $image = $row['image'];
                $pname = $row['pname'];
                $type = $row['ptype'];
                $writter = $row['writtername'];
                $price = $row['sellingprice'];

                echo "<form action='product.php?action=add&id=$pid' method='post'>";
                echo "<tr>
                <td>$pname</td>
                <td>$type</td>
                <td>$writter</td>
                <td>$price</td>
                <td><img src='../uploadedimage/$image' height='50px' width='50px'></td>
                <td><input type='text' value='1' name='quantity'>
                <input type='hidden' value='$pname' name='hname'>
                <input type='hidden' value='$price' name='hprice'>
                </td>
                <td><input type='submit' value='Add to Cart' name='add'></td>
                </tr>";
                echo "</form>";
            }
            echo "</table>";
        }
        ?>
    </div>
</div>

<div>
    <h3>Order Details</h3>
    <table id='customers'>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Product Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php
        if (!empty($_SESSION['cart'])) {
            $total = 0;
            foreach ($_SESSION['cart'] as $keys => $values) {
                echo "<tr>";
                ?>
                <td><?php echo $values['item_name']; ?></td>
                <td><?php echo $values['item_q']; ?></td>
                <td><?php echo $values['item_price']; ?></td>
                <td><?php echo number_format($values['item_q'] * $values['item_price'], 2); ?></td>
                <td><a href='product.php?action=delete&id=<?php echo $values['item_id']; ?>'>Remove</a></td>
                </tr>
                <?php
                $total += ($values['item_q'] * $values['item_price']);
            }
            echo "<tr>";
            echo "<td colspan='3' align='right'>Total</td>";
            ?>
            <td><?php echo number_format($total, 2); ?></td>
            <td></td>
            <?php
        }
        ?>
    </table>
</div>

<div>
    <form action='product.php' method='post'>
        <div class="row">
            <input type="submit" value="Submit Your Order" name="corder">
        </div>
    </form>

    <?php
    if (isset($_POST['corder'])) {
        include("../connection.php");
        $num = rand(10, 1000);
        $order_id = "o-" . $num;
        $order_date = date("Y-m-d");
        $cid = $_SESSION['user_id'];

        // Insert into customer_order table
        $sqlorder = "INSERT INTO customer_order (order_id, customer_id, order_date, status) 
                     VALUES ('$order_id', '$cid', '$order_date', 0)";

        if (mysqli_query($con, $sqlorder)) {
            // Insert into orderline table for each item in the cart
            foreach ($_SESSION['cart'] as $keys => $values) {
                $pid = $values['item_id'];
                $quantity = $values['item_q'];
                $total = $values['item_q'] * $values['item_price'];
                $sql = "INSERT INTO orderline (order_id, product_id, quantity, total) 
                        VALUES ('$order_id', '$pid', '$quantity', $total)";
                if (!mysqli_query($con, $sql)) {
                    echo "Error inserting orderline: " . mysqli_error($con);
                }
            }
            echo "Your order has been submitted successfully!";
            unset($_SESSION['cart']);
        } else {
            echo "Error inserting order: " . mysqli_error($con);
        }
    }
    ?>
</div>


</body>
</html>


