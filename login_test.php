<html>
<head>
<style type="text/css">
 input{
 border:1px solid olive;
 border-radius:5px;
 }
 h1{
  color:darkgreen;
  font-size:22px;
  text-align:center;
 }
span{
  color:lightgreen;

 }
</style>
</head>
<body>
<h1>Login<h1>
<form action='#' method='post'>
<table cellspacing='5' align='center'>
<tr><td>User name:</td><td><input type='text' name='name'/></td></tr>
<tr><td>Password:</td><td><input type='password' name='password'/></td></tr>
<tr><td></td><td><input type='checkbox' name='remember' /> <span>Stay signed in</span></td></tr>
<tr><td></td><td> <span><a href="forgot.php">Forgot password</a></span></td></tr>
<tr><td></td><td><input type='submit' name='submit' value='Submit'/></td></tr>
</table>

</form>
<?php
 require_once 'config/dbConfig.php';
   session_start();
//your values are stored in cookies, then you can login without validate
if(isset($_COOKIE['name']) && isset($_COOKIE['password']))
{
    header('location:index.php');
}
// login validation in php
if(isset($_POST['submit']))
{
 
 $myusername = pg_escape_string($db_connection,$_POST['name']);
 $mypassword = pg_escape_string($db_connection,$_POST['password']); 
	  
 if($myusername!=''&& $mypassword!='')
 {
   $query=("select * from auth_master where name='".$myusername."' and password='".$mypassword."'");
   $result = pg_query($db_connection,$query); 
   $res=pg_fetch_row($result);
   if($res)
   {
    if(isset($_POST['remember']))
 {
   setcookie('name',$myusername, time() + (60*60*24*1));
   setcookie('password',$mypassword, time() + (60*60*24*1));
 }
    $_SESSION['name']=$myusername;
    header('location:index.php');
   }
   else
   {
   $error = "Your Login Name or Password is invalid";   
   }
 }
 else
 {
   $error = "Enter both username and password";
 }
}
?>
</body>
</html>