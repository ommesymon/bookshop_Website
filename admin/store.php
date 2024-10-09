<?php
  session_start();
  if ($_SESSION['admin_login_status'] != "loged in" && !isset($_SESSION['user_id'])) {
      header("location:../index.php");
  }

  // Logout code
  if (isset($_GET['sign']) && $_GET['sign'] == "out") {
      $_SESSION['admin_login_status'] = "loged out";
      unset($_SESSION['user_id']);
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

/* Header */
.header {
  padding: 15px;
  text-align: center;
  background: salmon;
}

.header h1 {
  font-size: 50px;
}

/* Navigation */
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

/* Footer */
.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
  margin-top: 20px;
}

/* Responsive Layout */
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
  <a href="corder.php">Customer Order</a>
  
  
  <a href="?sign=out" style="float:right">Logout</a>
  <a href="changepassword.php" style="float:right">Change Password</a>
</div>

<div class="container">
  <!-- Show Products -->
  <form action="store.php" method="post">
    <input type="submit" value="Show Products" name="show">
  </form>

  <?php
  include("../connection.php");

  if (isset($_POST['show'])) {
      // Correct the SQL query to ensure products are retrieved correctly
      $sql = "SELECT p.p_id, p.pname, p.ptype, p.writtername, p.bprice, s.quantity, s.sellingprice 
              FROM product p 
              LEFT JOIN store s ON p.p_id = s.p_id";

      $r = mysqli_query($con, $sql);

      if (mysqli_num_rows($r) > 0) {
          echo "<table border='1'>
                <tr>
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Product Type</th>
                  <th>Writer</th>
                  <th>Buying Price</th>
                  <th>Quantity</th>
                  <th>Selling Price</th>
                </tr>";

          while ($row = mysqli_fetch_assoc($r)) {
              echo "<tr>
                      <td>{$row['p_id']}</td>
                      <td>{$row['pname']}</td>
                      <td>{$row['ptype']}</td>
                      <td>{$row['writtername']}</td>
                      <td>{$row['bprice']}</td>
                      <td>" . ($row['quantity'] ?? 'Not available') . "</td>
                      <td>" . ($row['sellingprice'] ?? 'Not available') . "</td>
                    </tr>";
          }

          echo "</table>";
      } else {
          echo "No products found.";
      }
  }
  ?>

  <!-- Store New Product Information Form -->
  <h2 align="center">Store New Product Information</h2>
  <form action="store.php" method="post">
    <label for="pid">Product ID:</label>
    <select name="pid">
      <?php
      // Get all product IDs
      $sql = "SELECT p_id FROM product";
      $r = mysqli_query($con, $sql);

      while ($row = mysqli_fetch_assoc($r)) {
          echo "<option value='{$row['p_id']}'>{$row['p_id']}</option>";
      }
      ?>
    </select>
    <br><br>

    <label for="quantity">Quantity:</label>
    <input type="text" id="quantity" name="quantity" placeholder="Enter Quantity" required>
    <br><br>

    <label for="sprice">Selling Price:</label>
    <input type="text" id="sprice" name="sprice" placeholder="Enter Selling Price" required>
    <br><br>

    <input type="submit" value="Add to Store" name="add_to_store">
  </form>

  <?php
  if (isset($_POST['add_to_store'])) {
      $pid = $_POST['pid'];
      $quantity = $_POST['quantity'];
      $sprice = $_POST['sprice'];

      // Insert or update the store information for the product
      $query = "INSERT INTO store (p_id, quantity, sellingprice) 
                VALUES ('$pid', '$quantity', '$sprice') 
                ON DUPLICATE KEY UPDATE quantity = quantity + '$quantity', sellingprice = '$sprice'";

      if (mysqli_query($con, $query)) {
          echo "Product successfully added/updated in the store!";
      } else {
          echo "Error: " . mysqli_error($con);
      }
  }
  ?>
</div>

<div class="footer">
  <h2>Copyright @omme symon</h2>
</div>

</body>
</html>


