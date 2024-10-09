<?php
session_start(); // Corrected SESSION_start to session_start
if ($_SESSION['admin_login_status'] != "loged in" && !isset($_SESSION['user_id'])) {
    header("location:../index.php");
    exit(); // It's a good practice to call exit after header redirection
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
    <title>Change Password</title>
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
    <h1>Change Password</h1>
</div>

<div class="topnav">
    <a href="home.php">Home</a>
    <a href="addbook.php">Add Book</a>
    <a href="store.php">Store</a>

    <a href="corder.php">Customer Order</a>
    <a href="?sign=out" style="float:right">Logout</a>
  
</div>

<div class="row">
    <h2 align='center'>Change Your Password</h2>
    <div class="container">
        <form action="changepassword.php" method="post">
            <div class="row">
                <div class="col-25">
                    <label for="opass">Old Password</label>
                </div>
                <div class="col-75">
                    <input type="password" id="opass" name="opass" placeholder="Your old password.." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="npass">New Password</label>
                </div>
                <div class="col-75">
                    <input type="password" id="npass" name="npass" placeholder="Your new password.." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="cpass">Confirm Password</label>
                </div>
                <div class="col-75">
                    <input type="password" id="cpass" name="cpass" placeholder="Retype your new password.." required>
                </div>
            </div>
            <div class="row">
                <input type="submit" value="Change Password" name="submit">
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        include("../connection.php");
        $id = $_SESSION['user_id'];
        $opass = $_POST['opass'];
        $npass = $_POST['npass'];
        $cpass = $_POST['cpass'];

        // Check if new password and confirmation match
        if ($npass === $cpass) {
            // Verify old password
            $sql = "SELECT password FROM Admins WHERE admin_id = '$id'"; // Adjust the table name if needed
            $r = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($r);
            
            if ($row && password_verify($opass, $row['password'])) { // Use password_verify for old password check
                // Update password
                $hashed_new_password = password_hash($npass, PASSWORD_DEFAULT); // Hash the new password
                $update_sql = "UPDATE Admins SET password = '$hashed_new_password' WHERE admin_id = '$id'";
                
                if (mysqli_query($con, $update_sql)) {
                    echo "<script>alert('Password changed successfully!');</script>";
                } else {
                    echo "Error updating password: " . mysqli_error($con);
                }
            } else {
                echo "<script>alert('Old password does not match.');</script>";
            }
        } else {
            echo "<script>alert('New passwords do not match.');</script>";
        }
    }
    ?>
</div>

<div class="footer">
    <h2>Copyright @omme symon</h2>
</div>
</body>
</html>
