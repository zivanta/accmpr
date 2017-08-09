<?php
include('session.php');
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ACC-Quick Report</title>

<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/materialize.css">
<link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" type="text/css" href="css/style.css">


</head>
<body>
<ul id="slide-out" class="side-nav">
  <li><a class="subheader accc" style="color: #fff;font-size: 18px;font-weight: normal;">Menu</a></li>
  <li><a class="waves-effect" href="index.php">Data Entry</a></li>
  <li><a class="waves-effect" href="download.php">Report Download</a></li>
  <li><a class="waves-effect" href="https://datastudio.google.com/u/0/org//reporting/0B9KpuN-Luu2gZGd4cWJzV0xjUjQ/page/QM0E" target="_blank">MPR Dashboard</a></li>
  <li><a class="waves-effect" href="quick_report.php">Quick Report</a></li>
</ul>
<section class="wrapper">

  <header id="header"><!--header-start-->

  <div id="nav">
    <div class="navbar-fixed">
      <nav class="tunaapprox">
        <div class="nav-wrapper container">
          <a href="landing.php" class="brand-logo"><img src="images/logo.png" alt=""></a>
          <span class="page-title">Quick Report</span>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>Hi <?php echo $login_user_name;?> &nbsp;</li>
            <li><a href="#" title="menu" data-activates="slide-out" class="accc waves-effect nave"><i class="material-icons">menu</i></a>&nbsp;</li>           
            <li><a href="logout.php" class="accc waves-effect" title="logout"><i class="material-icons dp48">power_settings_new</i></a></li>
          </ul>
        </div>
      </nav>
    </div>
  </div>


  </header><!--header-end-->

  <section class="body-container"><!--body-container-start-->
    <div class="container gray z-depth-3">
      <div class="de-header"></div>
    </div>   
    <div class="container">
      <div class="field-container-footer">
        <div class="row" style="margin:0px;"></div>  
      </div>
      <div class="field-container" style="position: relative;">
        <div class="landing-ico-box-wrap q-report"><!-- landing-ico-box-wrap start -->
          <div class="landing-ico-box">
            <a href="upload/MPR_Quick_Report_May2017.pptx" download>
              <figure><img src="upload/images/ACC_QUICK_REPORT_THUMBNAIL_MAY.png" alt="ACC_QUICK_REPORT_MAY"></figure>
              <span class="li-title">May (2017)</span>
            </a>
          </div><div class="landing-ico-box" download>
            <a href="upload/MPR_Quick_Report_June 2017.pptx">
              <figure><img src="upload/images/ACC_QUICK_REPORT_THUMBNAIL_JUNE.png" alt="ACC_QUICK_REPORT_JUNE"></figure>
              <span class="li-title">June (2017)</span>
            </a>
          </div>

        </div><!-- landing-ico-box-wrap end -->    
      </div>	  
    </div>

    </section><!--body-container-end-->

  <footer id="footer" class="page-footer">
          
          <div class="footer-copyright tunaapprox">
            <div class="container">
            © 2017 ACC LIMITED
            
            </div>
          </div>
        </footer>
    
</section>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/custom.js"></script>


</body>
</html>