<?php
  session_start();
  if($_SESSION['admin_login_status'] != "loged in" && !isset($_SESSION['user_id'])) {
      header("location:../index.php");
  }

  // Logout code
  if(isset($_GET['sign']) && $_GET['sign'] == "out") {
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
  background: gray;
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

/* Responsive layout */
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

  <a href="corder.php">Customer Order</a>
  <a href="store.php">Store</a>
 
  <a href="?sign=out" style="float:right">Logout</a>
  <a href="changepassword.php" style="float:right">Change Password</a>
</div>

<div class="container">
  <h2 align='center'>Add New Product</h2>
  <form action="addbook.php" method="post" enctype="multipart/form-data">
    <label for="pid">Product ID</label>
    <input type="text" id="pid" name="pid" placeholder="Product ID" required>
    <br><br>

    <label for="pname">Product Name</label>
    <input type="text" id="pname" name="pname" placeholder="Product Name" required>
    <br><br>

    <label for="ptype">Product Type</label>
    <select id="ptype" name="ptype">
      <option value="book">Books</option>
      <option value="stationary">Stationery</option>
      <option value="others">Others</option>
    </select>
    <br><br>

    <label for="rname">Writer</label>
    <input type="text" id="rname" name="rname" placeholder="Writer Name" required>
    <br><br>

    <label for="bprice">Buying Price</label>
    <input type="text" id="bprice" name="bprice" placeholder="Buying Price" required>
    <br><br>

    <label for="image">Product Image</label>
    <input type="file" id="image" name="pic" required>
    <br><br>

    <input type="submit" value="Add" name="submit">
  </form>
</div>

<div class="footer">
  <h2>Copyright @omme symon</h2>
</div>
</body>
</html>

<?php
include("../connection.php");

if(isset($_POST['submit'])) {
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $ptype = $_POST['ptype'];
    $rname = $_POST['rname'];
    $bprice = $_POST['bprice'];

    // Image upload code
    $ext = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);
    $image_name = md5(time() . $pid) . '.' . $ext;
    $image_path = "../uploadedimage/" . $image_name;

    // Insert into `product` table
    $query = "INSERT INTO product (p_id, pname, ptype, writtername, bprice, image) 
              VALUES ('$pid', '$pname', '$ptype', '$rname', '$bprice', '$image_name')";

    if(mysqli_query($con, $query)) {
        echo "Product successfully inserted!";
        move_uploaded_file($_FILES['pic']['tmp_name'], $image_path);
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

