<?php   
session_start();
setcookie('name',$myusername, time() + (60*60*24*1));
setcookie('password',$mypassword, time() + (60*60*24*1));
setcookie('remember',$remember, time() + (60*60*24*1));
unset($_COOKIE['name']);
unset($_COOKIE['password']);
unset($_COOKIE['remember']);
session_destroy();
               
header('Location: login.php');

?>