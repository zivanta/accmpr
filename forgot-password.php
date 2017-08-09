<?php
   require_once 'config/dbConfig.php';
   session_start();
   
if($_SERVER["REQUEST_METHOD"] == "POST") {

//print_r($_POST);

 $myusername = pg_escape_string($db_connection,$_POST['name']);
 $query=("select * from auth_master where name='".$myusername."'");
 $result = pg_query($db_connection,$query); 
 $res=pg_fetch_array($result);
 
	if($res) 
	 {
	 	  $to=$res['name'];
		  $subject='Remind password';
		  $message='Your password : '.$res['password']; 
		  $headers='From:no-reply@accmpr.com';
		  $m=mail($to,$subject,$message,$headers);
		  if($m)
		  {
			$message='Check your inbox in mail. Your password has been sent successfully ';
		  }
		  else
		  {
		  $message='Unable to send email. Please try again.';
		  }
	 }
	 else
	 {
	  $message='You have entered a wrong email id';
	 }
}

?>
<html>
   
   <head>
      <title>Password Page</title>
      
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
             <a href="index.php" class="brand-logo odd"><img src="images/logo.png" alt=""></a>
             <!-- <span class="page-title">Monthly Progress Report Input Form</span> -->
           </div> 
         </nav>
       </div>
     </div>
   </header><!--header-end-->
      <div>
         <div class="sm-container corner-rounded">
            <div class="sm-header"><span>Your Register Email Id</span></div>
				
            <div class="sm-block">
               
               <form action = "" method = "post">
                  <div class="input-field col s6">
                     <input id="name" type="email" class="validate box" required="" name = "name" >
                     <label for="name">Email  :</label>
                  </div>
                  <button class="btn waves-effect waves-light" type="submit" name="action">
                     Send
                  </button>
               </form>
               
               <div class="error"><?php echo $message; ?></div>
					
            </div>
				
         </div>
			
      </div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>      
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
   </body>
</html>