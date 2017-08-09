<?php
   require_once 'config/dbConfig.php';
   session_start();
  if(isset($_COOKIE['name']))
  {   
	$user_check = $_COOKIE['name'];
  }
  else
  {   
	$user_check = $_SESSION['name'];
  }
   $ses_sql = pg_query($db_connection,"select * from auth_master where name = '$user_check' ");
   
   while ( $row = pg_fetch_assoc($ses_sql)) {  
   //print_r($row);
   $login_session = $row['name'];
   $login_code = $row['code'];
   $login_admin = $row['admin'];
   $login_user_name = $row['display_name'];
   }
   
  if(!isset($user_check)){
      header("location:login.php");
   }
  
  /* echo 
   
  
   
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }*/
?>