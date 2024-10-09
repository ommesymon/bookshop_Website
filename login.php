<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
  </head>
     <body>
         

     <title>sign in</title>
<style>

body{
background:url(dddd.JPG)

}
</style>


 <u> <h2 style=color:lightcoral;" align="center">LOGIN FORM</h2></u>
<br>

<center>
<p>dont have an account?please <a href="signup.php"> Sign up</a></p>
</center>
<form action="login.php" method="post">
<center>
 <h3>User ID:
    <input type="text" id="uid" name="id" placeholder="User ID"/></h3>
   <h3> Password:
    <input type="password" id="pass" name="pass" placeholder="Password"/></h3>
    <br><br>
    <input type="submit" value="sign In" name="login" /></p>
</form>
    </center>
              </body>
       </html>
<?php
include("connection.php");
if(isset($_POST['login']))
{
        $id=$_POST['id'];
        $pass=$_POST['pass'];
        
        $sql="select userid,password from admin where userid='$id' and password='$pass'";
        $sql1="select cus_id,password from customer where cus_id='$id' and password='$pass'";
          
              $r=mysqli_query($con,$sql);
              $r1=mysqli_query($con,$sql1);
              if(mysqli_num_rows($r)>0)
             {
               $_SESSION['user_id']=$id;
               $_SESSION['admin_login_status']="loged in";
               header("location:admin/home.php");
              }

             else if(mysqli_num_rows($r1)>0)
{
              $_SESSION['user_id']=$id;
              $_SESSION['admin_login_status']="loged in";
              header("location:customer/home.php");
}
else
{
  echo"<p style='color:red;'>incorrect userid or password</p>";
}
}
?>
             
