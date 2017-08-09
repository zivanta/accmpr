<?php
   require_once 'config/dbConfig.php';
   session_start();
//your values are stored in cookies, then you can login without validate
if(isset($_COOKIE['name']) && isset($_COOKIE['password']) && isset($_COOKIE['remember']))
{
    header('location:landing.php');
}

// login validation in php
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
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
				setcookie('remember',$remember, time() + (60*60*24*1));
			}
			$_SESSION['name']=$myusername;
			header('location:landing.php');
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
<html>
   
   <head>
      <title>Login Page</title>
      
      <!-- <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }
      </style> -->
<link rel="stylesheet" type="text/css" href="css/materialize.css">      
<link rel="stylesheet" type="text/css" href="css/style.css">     
</head>
   
<body class="log-body" bgcolor="#FFFFFF" style="background-image:url(images/log-bg2.jpg);">
   <header id="header"><!--header-start-->
     <div id="nav">
       <div class="navbar-fixed">
         <nav class="acc-transparent">
           <div class="nav-wrapper container">
             <a href="landing.php" class="brand-logo odd"><img src="images/logo.png" alt=""></a>
             <!-- <span class="page-title">Monthly Progress Report Input Form</span> -->
           </div> 
         </nav>
       </div>
     </div>
   </header><!--header-end-->
      <div>
         <div class="sm-container corner-rounded">
            <div class="sm-header"><span>Login</span></div>
				
            <div class="sm-block">
               
               <form action = "" method = "post">
                  <div class="input-field col s6">
                     <input id="name" type="text" class="validate box" required="" name = "name" >
                     <label for="name">UserName  :</label>
                  </div>
                  <div class="input-field col s12">
                     <input id="password" type="password" name = "password" required="" class="validate box">
                     <label for="password">Password  :</label>
                  </div>
                  <p>
                     <input type="checkbox" id="test6" name = "remember">
                     <label for="test6">Stay signed in</label>
                   </p>
                  <button class="btn waves-effect waves-light" type="submit" name="action">
                     Submit
                  </button>&nbsp;
                  <span><a class="accc-text chover" href="forgot-password.php">Trouble signing in?</a></span>
               </form>
               
               <div class="error"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>      
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
   </body>
</html>