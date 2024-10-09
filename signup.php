<!DOCTYPE html>
<html lang="en"> 
  <head>     
 <title>form</title> 
<style>
body{background:url(vv.JPG);
}
</style>
</head>
<body>
<center>
<h5 align="right"><a href="login.php">already have an account?please login</a></h5>
<form action="signup.php" method="post" enctype="multipart/form-data">
<table>
<tr>
<u><h1 style="color:lightcoral;">Create Account</h1></u>
</td>
</tr>
<tr>
<td colspan="2"> <u> <h3 style=color:lightcoral;>personal information</h3></u> </td></tr>
<tr><td><p>please fill in this form to create an account.</p>   
</td></tr>
<tr><td><label for="fullname"><b>fullname:</label><br>
<input type="text" name = "fullname" id="fullname"> </td></tr>
<tr><td><label for="Email">email: </label><br>
<input type="text" name = "email" id="email"></td></tr> 
<tr><td><label for="password">password:</label><br>
<input type="password" name = "password" id="password"></td></tr>
<tr><td><label for="dob">date_of_birth:</label><br>
<input type="date" name = "dob" id="dob"></td></tr>
<tr><td> <label for="Gender">Gender:</label>
<input type="radio" name ="gender" id="gender"value="male">male<input type="radio" name = "gender" id="gender"value="female">female</td></tr></div><br><div>   
<tr><td>mobile_no:</no>   <br>  
      <input type="text" name = "no" id="no"></td></tr> 
//<tr><td><label for="location">location:</label><select name="loc"><option value="Dhaka">Dhaka</option><option value="chittagong">chittagong</option><option value="cumilla">cumilla</option>      </select></td></tr></div><div> <br> <u>
<tr><td><label for ="photo">choose your photo:</label>
<input type="file" name="pic" id="pic"><br>
<tr><td><input type="submit" name="submit" value = "submit"></td></tr>
<tr><td><a href="index.php">back to home page</a></td></tr>
</table>
</center>


      </form>   
     </body> 
<?php
include("connection.php");
if(isset($_POST['submit']))
{
  
 $fullname =$_POST['fullname'];
 $email=$_POST['email'];
 $password=$_POST['password'];
 $dob=$_POST['dob'];
 $gender=$_POST['gender'];
 $mobile=$_POST['no'];
 $loc=$_POST['loc'];
  //customer id gender
  
 $num=rand(10,100);
  
 $cus_id="c-".$num;
 $ext= explode(".",$_FILES['pic']['name']);
 $c=count($ext);
 $ext= $ext[$c-1];
 
 $date =date("D:M:Y");
 $time =date("h:i:s");
 $image_name=md5($date.$time.$cus_id);
 $image=$image_name.".".$ext;
 

 $query="insert into customer values('$cus_id','$fullname','$email','$password','$dob','$gender','$mobile','$loc','$image')";

 if(mysqli_query($con,$query))
 {
 echo "successfully inserted!";
 if($image !=null){
              move_uploaded_file($_FILES['pic']['tmp_name'],"uploadedimage/$image");
              }
 }
 else
{

echo
 "error!".mysqli_error($con);
}
}
?>