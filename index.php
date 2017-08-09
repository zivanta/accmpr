<?php
/*print_r($_COOKIE);

print_r($_COOKIE);*/
  //session_start();
 include('session.php');

$month_val = sprintf('%02d',(date('m')-01));

$auth_plant1=pg_query($db_connection,"SELECT plant_code from auth_plant where auth_code='".$login_code."'");
$auth_plant2=pg_query($db_connection,"SELECT plant_code from auth_plant where auth_code='".$login_code."'");
$auth_plant3=pg_query($db_connection,"SELECT plant_code from auth_plant where auth_code='".$login_code."'");
$auth_plant4=pg_query($db_connection,"SELECT plant_code from auth_plant where auth_code='".$login_code."'");
//echo $login_admin;

$year = pg_query($db_connection, "SELECT * from year_master ORDER BY code DESC");

$sector = pg_query($db_connection, "SELECT * from sector_master ORDER BY name");
$indicator= pg_query($db_connection, "SELECT * from indicator_master ORDER BY name");

if ($_POST['action']=='submit') {
        header("location:index.php");
    }

if(isset($_POST['year_code']) && isset($_POST['plant_code'])){
//echo "SELECT * from activity_master where year_code='".$_POST['year_code']."' AND plant_code='".$_POST['plant_code']."' AND sector_code='".$_POST['sector_code']."' ORDER BY code";
$plant_activity= pg_query($db_connection, "SELECT * from activity_master where year_code='".$_POST['year_code']."' AND plant_code='".$_POST['plant_code']."' AND sector_code='".$_POST['sector_code']."' ORDER BY code");
}
$months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');				

if(isset($_POST['year_code'] )&& $_POST['year_code'] != "0") {
$year_code_value=$_POST['year_code'];
}else{
$year_code_value='';
}
if(isset($_POST['plant_code'] )&& $_POST['plant_code'] != "0") {
$plant_code_value=$_POST['plant_code'];
}else{
$plant_code_value='';
}
if(isset($_POST['sector_code'] )&& $_POST['sector_code'] != "0") {
$sector_code_value=$_POST['sector_code'];
}else{
$sector_code_value='';
}
if(isset($_POST['indicator_code'] )&& $_POST['indicator_code'] != "0") {
$indicator_code_value=$_POST['indicator_code'];
}else{
$indicator_code_value='';
}
if(isset($_POST['value_mode'] )&& $_POST['value_mode'] != "0") {
$value_mode_value=$_POST['value_mode'];
}

//print_r($_POST);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ACC-Data Entry</title>

<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/materialize.css">
<link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script>

function submit_type(){ 

if(document.getElementById("sector_code").value!="")
        document.getElementById("button").disabled=false;
		document.getElementById("button1").disabled=true;	
        
}



function submitForm() {
var a = document.getElementById("year_code");
var year = a.options[a.selectedIndex].value;

var b = document.getElementById("plant_code");
var plant = b.options[b.selectedIndex].value;

var c = document.getElementById("sector_code");
var sector = c.options[c.selectedIndex].value;

var d = document.getElementById("value_mode");
var value_mode = d.options[d.selectedIndex].value;

var e = document.getElementById("indicator_code");
var indicator = e.options[e.selectedIndex].value;

  
	if (year=="Choose your option"){  
	  alert("Year can't be blank");  
	  return false;	
	}else if (plant=="Choose your option"){  
	  alert("Plant Code can't be blank"); 
	  return false;	
	}else if (sector=="Choose your option"){  
	  alert("Sector Code can't be blank"); 
	  return false;	
	}else if (value_mode=="Choose your option"){  
	  alert("Value Mode(Planned/Achieved) can't be blank");  
	  return false;	
	}else if (indicator=="Choose your option"){  
	  alert("Indicator Code can't be blank"); 
	  return false;	
	}else{
	return true;	
	}   
	
	
}
</script>

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
		  <?php if($login_admin == 't'){?>
          <span class="page-title">Data Entry Form</span>
		  <?php }elseif($login_admin == 'f'){?>
		  <?php
						$auth_plant_final2 = pg_fetch_assoc($auth_plant2);
						$plant2 = pg_query($db_connection, "SELECT * from plant_master where code='".$auth_plant_final2['plant_code']."' ORDER BY name");
				  		$plant_code2 = pg_fetch_assoc($plant2);
				
                ?>
		  <span class="page-title">Data Entry Form-<?php echo $plant_code2['name'];?></span>
		  <?php }?>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>Hi <?php echo $login_user_name ;?> &nbsp;</li>
            <li><a href="#" title="menu" data-activates="slide-out" class="accc waves-effect nave"><i class="material-icons">menu</i></a>&nbsp;</li>
            <li><a href="logout.php" class="accc waves-effect" title="logout"><i class="material-icons dp48">power_settings_new</i></a></li>
          </ul>
        </div>
      </nav>
    </div>
  </div>


  </header><!--header-end-->
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="myform">
  <section class="body-container"><!--body-container-start-->
    <div class="container gray z-depth-3">
      <div class="de-header">
        <div class="row">
		  <nav class="col c-breadcrumb">
			<div class="nav-wrapper">
			  <div class="">
				<a href="landing.php" class="breadcrumb">ACC</a>
				<?php if($login_admin == 't'){?>
				<a href="index.php" class="breadcrumb">Data Entry Form</a>
				<?php }elseif($login_admin == 'f'){?>
				<?php
						$auth_plant_final3 = pg_fetch_assoc($auth_plant3);
						$plant3 = pg_query($db_connection, "SELECT * from plant_master where code='".$auth_plant_final3['plant_code']."' ORDER BY name");
				  		$plant_code3 = pg_fetch_assoc($plant3);
				
                ?>
					<a href="index.php" class="breadcrumb">Data Entry Form-<?php echo $plant_code3['name'];?></a>
                		
				<?php }?>				
			   
			  </div>
			</div>
		  </nav>
		</div> 
        <div class="row">		
          <div class="input-field col s12 mm2">
            <select name="year_code" id="year_code">
              <option disabled selected>Choose your option</option>
                <?php
                                    
					while ($year_code = pg_fetch_assoc($year)) {
				
                ?>
					<option <?php echo ($year_code_value == $year_code['code'] ? 'Selected' : ''); ?> value="<?php echo $year_code['code'];?>"><?php echo $year_code['name'];?></option>
                <?php
                 }
                
                ?>
            </select>
            <label>Year</label>
          </div>
          <div class="input-field col s12 mm2">
		  <?php if($login_admin == 't'){?>
            <select name="plant_code" id="plant_code" onchange="submit_type()">
              <option disabled selected>Choose your option</option>              
                <?php
                  while ($auth_plant_final4 = pg_fetch_assoc($auth_plant4)) {
						$plant4 = pg_query($db_connection, "SELECT * from plant_master where code='".$auth_plant_final4['plant_code']."' ORDER BY name");
				  
					while ($plant_code4 = pg_fetch_assoc($plant4)) {
				
                ?>
					<option <?php echo ($plant_code_value == $plant_code4['code'] ? 'Selected' : ''); ?> value="<?php echo $plant_code4['code'];?>"><?php echo $plant_code4['name'];?></option>
                <?php
                 }
                }
                ?>
            </select> 
			<?php }elseif($login_admin == 'f'){?>
			
			  <select name="plant_code" id="plant_code">                           
                <?php
                  while ($auth_plant_final4 = pg_fetch_assoc($auth_plant4)) {
						$plant4 = pg_query($db_connection, "SELECT * from plant_master where code='".$auth_plant_final4['plant_code']."' ORDER BY name");
				  
					while ($plant_code4 = pg_fetch_assoc($plant4)) {
				
                ?>
					<option <?php echo ($plant_code_value == $plant_code4['code'] ? 'Selected' : ''); ?> value="<?php echo $plant_code4['code'];?>"><?php echo $plant_code4['name'];?></option>
                <?php
                 }
                }
                ?>
            </select> 
			<?php
                 }
                
             ?>
			
            <label>Plant</label>
          </div>
          <div class="input-field col s12 mm2">
            <select name="sector_code" id="sector_code" onchange="submit_type()">
              <option disabled selected>Choose your option</option>              
                <?php
                                    
					while ($sector_code = pg_fetch_assoc($sector)) {
				
                ?>
					<option <?php echo ($sector_code_value == $sector_code['code'] ? 'Selected' : ''); ?> value="<?php echo $sector_code['code'];?>"><?php echo $sector_code['name'];?></option>
                <?php
                 }
                
                ?>
            </select>
            <label>Sector</label>
          </div>
          <div class="input-field col s12 mm2">
            <select name="value_mode" id="value_mode" onchange="submit_type()">
              <option disabled selected>Choose your option</option>
              <option <?php echo ($value_mode_value == 'planned' ? 'Selected' : ''); ?> value="planned">Planned</option>
              <option <?php echo ($value_mode_value == 'achieved' ? 'Selected' : ''); ?> value="achieved">Achieved</option>
            </select>
            <label>Planned / Achieved</label>
          </div>
          <div class="input-field col s12 mm2">
            <select name="indicator_code" id="indicator_code" onchange="submit_type()">
              <option disabled selected>Choose your option</option>
               <?php
                                    
					while ($indicator_code = pg_fetch_assoc($indicator)) {
				
                ?>
					<option <?php echo ($indicator_code_value == $indicator_code['code'] ? 'Selected' : ''); ?> value="<?php echo $indicator_code['code'];?>"><?php echo $indicator_code['name'];?></option>
                <?php
                 }
                
                ?>
            </select>
            <label>Indicator</label>
          </div>		  
        </div>
      </div>
    </div>   
    <div class="container">	
    <div class="ac-panel">
	<?php if(isset($_POST['year_code'] )&& $_POST['year_code'] != "0" && isset($_POST['plant_code'] )&& $_POST['plant_code'] != "0") {?>
    <strong>ACTIVITY</strong>
	<?php } ?>
    </div>
     <div class="field-container">
	<?php while ($plant_activity_code = pg_fetch_assoc($plant_activity)) {
	    $plant_data = "SELECT * FROM plant_data
		where 
		year_code='".$_POST['year_code']."' AND 
		value_mode='".$_POST['value_mode']."' AND
		indicator_code='".$_POST['indicator_code']."' AND 
		plant_code='".$_POST['plant_code']."' AND
		sector_code='".$_POST['sector_code']."' AND 
		activity_code='".$plant_activity_code['code']."'
		ORDER BY activity_code,month_value
		";
		$plant_data_final = pg_query($db_connection,$plant_data);
		$plant_data_rows = pg_num_rows($plant_data_final);
		
		if($plant_data_rows==0 && $_POST['action']=='submit'){
			$all_submit_value = array();
			
			for($i=1;$i<=13;$i++){						
			  $all_submit_value[$i] = $_POST[$plant_activity_code['code'].'_'.sprintf('%02d', $i)];
			}
			
			for ($i = 1; $i < count($all_submit_value); $i++) {			
		    /*echo "INSERT INTO plant_data(plant_code,sector_code,activity_code,year_code,month_value,value_mode,indicator_code,plant_value,auth_code,curr_datetime)
									VALUES ('".$_POST['plant_code']."','".$_POST['sector_code']."','".$plant_activity_code['code']."','".$_POST['year_code']."','".sprintf('%02d', $i)."','".$_POST['value_mode']."','".$_POST['indicator_code']."','".$all_submit_value[$i]."','".$login_code."',current_timestamp)";*/
				$final_submit=pg_query($db_connection, "INSERT INTO plant_data(plant_code,sector_code,activity_code,year_code,month_value,value_mode,indicator_code,plant_value,auth_code,curr_datetime)
									VALUES ('".$_POST['plant_code']."','".$_POST['sector_code']."','".$plant_activity_code['code']."','".$_POST['year_code']."','".sprintf('%02d', $i)."','".$_POST['value_mode']."','".$_POST['indicator_code']."','".$all_submit_value[$i]."','".$login_code."',current_timestamp)");

			}
		}elseif($plant_data_rows > 0 && $_POST['action']=='submit'){
			$all_submit_value = array();			
			for($i=1;$i<=13;$i++)
			{						
			  $all_submit_value[$i] = $_POST[$plant_activity_code['code'].'_'.sprintf('%02d', $i)];
			}	
			for ($i = 1; $i < count($all_submit_value); $i++) {			
				//echo "update plant_data set plant_value='".$all_submit_value[$i]."',curr_datetime=current_timestamp,auth_code='".$login_code."' WHERE plant_code='".$_POST['plant_code']."'  AND sector_code='".$_POST['sector_code']."' AND activity_code='".$plant_activity_code['code']."'  AND year_code='".$_POST['year_code']."' AND month_value='".sprintf('%02d', $i)."' AND value_mode='".$_POST['value_mode']."' AND indicator_code='".$_POST['indicator_code']."' AND auth_code='".$login_code."'";
				$final_submit=pg_query($db_connection, "update plant_data set plant_value='".$all_submit_value[$i]."',curr_datetime=current_timestamp,auth_code='".$login_code."' WHERE plant_code='".$_POST['plant_code']."'  AND sector_code='".$_POST['sector_code']."' AND activity_code='".$plant_activity_code['code']."'  AND year_code='".$_POST['year_code']."' AND month_value='".sprintf('%02d', $i)."' AND value_mode='".$_POST['value_mode']."' AND indicator_code='".$_POST['indicator_code']."'");
				}
		}
	?>
	
		<?php if(empty($plant_data_rows)|| $plant_data_rows==0){?>
		<div class="row">
          <div class="col s12 m2">
				<strong class="row-label"><?php echo $plant_activity_code['name'];?></strong>
		  </div>
          <div class="col s12 m10">
            <div class="">
			<?php foreach ($months as $m => $m_val) {?>
			 
              <div class="input-field col m1">	
			  <?php if($login_admin == 't'){?>
					<?php if($_POST['indicator_code']=='NB'){?>
					<input id="last_name" type="text" name="<?php echo $plant_activity_code['code'].'_'.$m;?>" value="0" placeholder="" class="validate np0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" >
					<?php }else {?>
					<input id="last_name" type="text" name="<?php echo $plant_activity_code['code'].'_'.$m;?>" value="0" placeholder="" class="validate p00" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
					<?php }?>
			  <label for="last_name"><?php echo $m_val;?></label>
			  <?php }elseif($login_admin == 'f'){?>
			 <?php  if($_POST['value_mode']=='planned'){?>
			  
			       <?php if($_POST['indicator_code']=='NB'){?>
					<input id="last_name" type="text" name="<?php echo $plant_activity_code['code'].'_'.$m;?>" value="0" placeholder="" class="validate invalid np0" readonly="readonly">
					<?php }else {?>
					<input id="last_name" type="text" name="<?php echo $plant_activity_code['code'].'_'.$m;?>" value="0" placeholder="" class="validate invalid p00" readonly="readonly">
					<?php }?>
			  
			  <?php}else{?>
			  
				<?php if( $m == $month_val){?>
					<?php if($_POST['indicator_code']=='NB'){?>
					<input id="last_name" type="text" name="<?php echo $plant_activity_code['code'].'_'.$m;?>" value="0" placeholder="" class="validate np0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" >
					<?php }else {?>
					<input id="last_name" type="text" name="<?php echo $plant_activity_code['code'].'_'.$m;?>" value="0" placeholder="" class="validate p00" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
					<?php }?>
			   <?php }else{?>
					<?php if($_POST['indicator_code']=='NB'){?>
					<input id="last_name" type="text" name="<?php echo $plant_activity_code['code'].'_'.$m;?>" value="0" placeholder="" class="validate invalid np0" readonly="readonly">
					<?php }else {?>
					<input id="last_name" type="text" name="<?php echo $plant_activity_code['code'].'_'.$m;?>" value="0" placeholder="" class="validate invalid p00" readonly="readonly">
					<?php }?>
			   
			   <?php } ?>
			   
			   <?php } }?>
			   <!--<input id="last_name" name="<?php //echo $plant_activity_code['code'].'_'.$m;?>" type="text" value="0.00" class="validate"> -->
				<label for="last_name"><?php echo $m_val;?></label>
              </div>
			  <?php } ?>              
            </div>
          </div>
		  </div>
		  <?php }else {?>
		  <div class="row">
		   <div class="col s12 m2">
				<strong class="row-label"><?php echo $plant_activity_code['name'];?></strong>
		  </div>
          <div class="col s12 m10">
            <div class="">		
			 <?php  while ($result_value = pg_fetch_assoc($plant_data_final)) {?>
			 
             <div class="input-field col m1">
				<?php if($login_admin == 't'){?>
				<?php if($_POST['indicator_code']=='NB'){?>
					<input id="last_name" type="text" name="<?php echo $result_value['activity_code'].'_'.$result_value['month_value'];?>" value="<?php echo $result_value['plant_value']?>" placeholder="" class="validate np0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" >
					<?php }else {?>
					<input id="last_name" type="text" name="<?php echo $result_value['activity_code'].'_'.$result_value['month_value'];?>" value="<?php echo $result_value['plant_value']?>" placeholder="" class="validate p00" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
					<?php } ?>
				<label for="last_name"><?php echo $months[$result_value['month_value']];?></label>
				<?php }elseif($login_admin == 'f'){ ?>	
					<?php  if($_POST['value_mode']=='planned'){?>
					<input id="last_name" type="text" name="<?php echo $result_value['activity_code'].'_'.$result_value['month_value'];?>" value="<?php echo $result_value['plant_value']?>" placeholder="" class="validate invalid" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly="readonly">
					<label for="last_name"><?php echo $months[$result_value['month_value']];?></label>
					<?php }else{?>

				
				<?php if($result_value['month_value'] == $month_val){?>
					<?php if($_POST['indicator_code']=='NB'){?>
					<input id="last_name" type="text" name="<?php echo $result_value['activity_code'].'_'.$result_value['month_value'];?>" value="<?php echo $result_value['plant_value']?>" placeholder="" class="validate np0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" >
					<?php }else {?>
					<input id="last_name" type="text" name="<?php echo $result_value['activity_code'].'_'.$result_value['month_value'];?>" value="<?php echo $result_value['plant_value']?>" placeholder="" class="validate p00" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
					<?php } ?>
				<?php }else {?>
			   <input id="last_name" type="text" name="<?php echo $result_value['activity_code'].'_'.$result_value['month_value'];?>" value="<?php echo $result_value['plant_value']?>" placeholder="" class="validate invalid" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly="readonly">
			    <?php } ?>			   
				<label for="last_name"><?php echo $months[$result_value['month_value']];?></label>
              
			  <?php }?>
			  
			  
			  
			  <?php }?>
			  </div>
			   <?php }?>
            </div>
          </div>
		  </div>
		  <?php } ?>
        
		
	<?php }?>
	  </div>
	  
	  
      <div class="field-container-footer">
        <div class="row">
          <div class="col s12 m1"><strong class="row-label"> </strong></div>
            <div class="col s12 m11 right-align">
			<?php if(isset($_POST['year_code'] )&& $_POST['year_code'] != "0" && isset($_POST['plant_code'] )&& $_POST['plant_code'] != "0") {?>
            <button class="btn waves-effect waves-light"  id="button" disabled type="submit" name="action" value="edit">Edit
              <i class="material-icons right">send</i>
            </button>
			<?php }else{?>
			<button class="btn waves-effect waves-light"  id="button" type="submit" name="action" value="edit" onclick="return submitForm();">Edit
              <i class="material-icons right">send</i>
            </button>
			<?php } ?>
			<?php if(isset($_POST['year_code'] )&& $_POST['year_code'] != "0" && isset($_POST['plant_code'] )&& $_POST['plant_code'] != "0") {?>
            <button class="btn waves-effect waves-light" id="button1" type="submit" name="action" value="submit">Submit
              <i class="material-icons right">send</i>
            </button>
			<?php }else{?>
			<button class="btn waves-effect waves-light" id="button1" disabled type="submit" name="action" value="submit">Submit
              <i class="material-icons right">send</i>
            </button>
			<?php } ?>
          </div>
        </div>  
      </div>
    </div>
  </section>
</form>


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