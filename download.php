<?php
include('session.php');
$month_val = date('m');
//echo $login_code;
$auth_plant1=pg_query($db_connection,"SELECT plant_code from auth_plant where auth_code='".$login_code."'");
$auth_plant2=pg_query($db_connection,"SELECT plant_code from auth_plant where auth_code='".$login_code."'");
$auth_plant3=pg_query($db_connection,"SELECT plant_code from auth_plant where auth_code='".$login_code."'");

//$auth_plant_final = pg_fetch_assoc($auth_plant);

$year = pg_query($db_connection, "SELECT * from year_master ORDER BY code DESC");


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

$plant = pg_query($db_connection, "SELECT name from plant_master where code='".$_POST['plant_code']."' ORDER BY name");
$plant_name = pg_fetch_assoc($plant);

if(isset($_POST['month_code'] )&& $_POST['month_code'] != "0") {
$month_code_value=$_POST['month_code'];
}
					
$check_data_exist = "SELECT * FROM plant_data
where 
year_code='".$_POST['year_code']."' AND 
value_mode='".$_POST['value_mode']."' AND
indicator_code='".$_POST['indicator_code']."' AND 
plant_code='".$_POST['plant_code']."' AND
sector_code='".$_POST['sector_code']."' ORDER BY activity_code,month_value
";
$result = pg_query($db_connection,$check_data_exist);

$num_rows = pg_num_rows($result);

//print_r($_POST);
?>
<?php
/*echo "SELECT plant_data.plant_code, plant_master.name as plant_name,plant_data.year_code, plant_data.month_value, sector_master.code as sector_code ,sector_master.name as sector_name, activity_master.code as activity_code, activity_master.name as activity_name,
sum(CASE when planned_nb_table.planned_NB is null then 0 else planned_nb_table.planned_NB END::float) AS planned_NB,
sum(CASE when planned_bg_table.planned_BG is null then 0 else planned_bg_table.planned_BG END::float) AS planned_BG,
sum(CASE when planned_lv_table.planned_LV is null then 0 else planned_lv_table.planned_LV END::float) AS planned_LV,
sum(CASE when achieved_nb_table.achieved_NB is null then 0 else achieved_nb_table.achieved_NB END::float) AS achieved_NB,
sum(CASE when achieved_bg_table.achieved_BG is null then 0 else achieved_bg_table.achieved_BG END::float) AS achieved_BG,
sum(CASE when achieved_lv_table.achieved_LV is null then 0 else achieved_lv_table.achieved_LV END::float) AS achieved_LV


FROM
sector_master, activity_master, plant_master, plant_data

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as planned_NB
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='planned' and indicator_code='NB') as planned_nb_table
ON plant_data.activity_code=planned_nb_table.activity_code and plant_data.value_mode=planned_nb_table.value_mode and plant_data.indicator_code=planned_nb_table.indicator_code

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as planned_BG
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='planned' and indicator_code='BG') as planned_bg_table
ON plant_data.activity_code=planned_bg_table.activity_code and plant_data.value_mode=planned_bg_table.value_mode and plant_data.indicator_code=planned_bg_table.indicator_code

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as planned_LV
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='planned' and indicator_code='LV') as planned_lv_table
ON plant_data.activity_code=planned_lv_table.activity_code and plant_data.value_mode=planned_lv_table.value_mode and plant_data.indicator_code=planned_lv_table.indicator_code

LEFT JOIN
(SELECT activity_code, value_mode, indicator_code, plant_value as achieved_NB
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='achieved' and indicator_code='NB') as achieved_nb_table
ON plant_data.activity_code=achieved_nb_table.activity_code and plant_data.value_mode=achieved_nb_table.value_mode and plant_data.indicator_code=achieved_nb_table.indicator_code

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as achieved_BG
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='achieved' and indicator_code='BG') as achieved_bg_table
ON plant_data.activity_code=achieved_bg_table.activity_code and plant_data.value_mode=achieved_bg_table.value_mode and plant_data.indicator_code=achieved_bg_table.indicator_code

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as achieved_LV
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='achieved' and indicator_code='LV' ) as achieved_lv_table
ON plant_data.activity_code=achieved_lv_table.activity_code and plant_data.value_mode=achieved_lv_table.value_mode and plant_data.indicator_code=achieved_lv_table.indicator_code


WHERE
sector_master.code=plant_data.sector_code and
activity_master.code=plant_data.activity_code and
plant_data.year_code='".$_POST['year_code']."' and
plant_data.plant_code='".$_POST['plant_code']."' and
plant_data.month_value='".$_POST['month_code']."' and
plant_data.plant_code=plant_master.code
GROUP BY
plant_data.plant_code, plant_master.name,plant_data.year_code, plant_data.month_value, sector_master.code,sector_master.name , activity_master.code, activity_master.name order by sector_master.code,activity_master.code";

*/

$accmpr_download = pg_query($db_connection,"SELECT plant_data.plant_code, plant_master.name as plant_name,plant_data.year_code, plant_data.month_value, sector_master.code as sector_code ,sector_master.name as sector_name, activity_master.code as activity_code, activity_master.name as activity_name,
sum(CASE when planned_nb_table.planned_NB is null then 0 else planned_nb_table.planned_NB END::float) AS planned_NB,
sum(CASE when planned_bg_table.planned_BG is null then 0 else planned_bg_table.planned_BG END::float) AS planned_BG,
sum(CASE when planned_lv_table.planned_LV is null then 0 else planned_lv_table.planned_LV END::float) AS planned_LV,
sum(CASE when achieved_nb_table.achieved_NB is null then 0 else achieved_nb_table.achieved_NB END::float) AS achieved_NB,
sum(CASE when achieved_bg_table.achieved_BG is null then 0 else achieved_bg_table.achieved_BG END::float) AS achieved_BG,
sum(CASE when achieved_lv_table.achieved_LV is null then 0 else achieved_lv_table.achieved_LV END::float) AS achieved_LV


FROM
sector_master, activity_master, plant_master, plant_data

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as planned_NB
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='planned' and indicator_code='NB') as planned_nb_table
ON plant_data.activity_code=planned_nb_table.activity_code and plant_data.value_mode=planned_nb_table.value_mode and plant_data.indicator_code=planned_nb_table.indicator_code

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as planned_BG
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='planned' and indicator_code='BG') as planned_bg_table
ON plant_data.activity_code=planned_bg_table.activity_code and plant_data.value_mode=planned_bg_table.value_mode and plant_data.indicator_code=planned_bg_table.indicator_code

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as planned_LV
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='planned' and indicator_code='LV') as planned_lv_table
ON plant_data.activity_code=planned_lv_table.activity_code and plant_data.value_mode=planned_lv_table.value_mode and plant_data.indicator_code=planned_lv_table.indicator_code

LEFT JOIN
(SELECT activity_code, value_mode, indicator_code, plant_value as achieved_NB
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='achieved' and indicator_code='NB') as achieved_nb_table
ON plant_data.activity_code=achieved_nb_table.activity_code and plant_data.value_mode=achieved_nb_table.value_mode and plant_data.indicator_code=achieved_nb_table.indicator_code

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as achieved_BG
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='achieved' and indicator_code='BG') as achieved_bg_table
ON plant_data.activity_code=achieved_bg_table.activity_code and plant_data.value_mode=achieved_bg_table.value_mode and plant_data.indicator_code=achieved_bg_table.indicator_code

LEFT JOIN
(SELECT activity_code , value_mode, indicator_code, plant_value as achieved_LV
FROM plant_data
WHERE year_code='".$_POST['year_code']."' and plant_code='".$_POST['plant_code']."' and month_value='".$_POST['month_code']."' and value_mode='achieved' and indicator_code='LV' ) as achieved_lv_table
ON plant_data.activity_code=achieved_lv_table.activity_code and plant_data.value_mode=achieved_lv_table.value_mode and plant_data.indicator_code=achieved_lv_table.indicator_code


WHERE
sector_master.code=plant_data.sector_code and
activity_master.code=plant_data.activity_code and
plant_data.year_code='".$_POST['year_code']."' and
plant_data.plant_code='".$_POST['plant_code']."' and
plant_data.month_value='".$_POST['month_code']."' and
plant_data.plant_code=plant_master.code
GROUP BY
plant_data.plant_code, plant_master.name,plant_data.year_code, plant_data.month_value, sector_master.code,sector_master.name , activity_master.code, activity_master.name order by sector_master.code,activity_master.code

"); 
while ($accmpr_download_value = pg_fetch_assoc($accmpr_download)) {
$test[]=$accmpr_download_value;
}
//print_r($test);
	  
$accmpr_download_final=json_encode($test);
//print_r($accmpr_download_final);
	?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ACC-Report Download</title>

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
          <?php if($login_admin == 't'){?>
          <span class="page-title">Report Download</span>
		  <?php }elseif($login_admin == 'f'){?>
		  <?php
						$auth_plant_final2 = pg_fetch_assoc($auth_plant2);
						$plant2 = pg_query($db_connection, "SELECT * from plant_master where code='".$auth_plant_final2['plant_code']."' ORDER BY name");
				  		$plant_code2 = pg_fetch_assoc($plant2);
				
                ?>
		  <span class="page-title">Report Download-<?php echo $plant_code2['name'];?></span>
		  <?php }?>
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
  <section class="body-container">
  <form action="" method="post" name="myform">
  <!--body-container-start-->
    <div class="container gray z-depth-3">
      <div class="de-header">
        <!--<div class="row">
		  <nav class="col c-breadcrumb">
			<div class="nav-wrapper">
			  <div class="">
				<a href="http://accmpr-dashboard.zivanta-analytics.com/accmpr/index.php#!" class="breadcrumb">ACC</a>
				<a href="http://accmpr-dashboard.zivanta-analytics.com/accmpr/download.php#!" class="breadcrumb">Data Download</a>
			   
			  </div>
			</div>
		  </nav>
		</div> -->
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
            <select name="plant_code" id="plant_code">
              <option disabled selected>Choose your option</option>              
                <?php
                                    
					while ($auth_plant_final3 = pg_fetch_assoc($auth_plant3)) {
						$plant3 = pg_query($db_connection, "SELECT * from plant_master where code='".$auth_plant_final3['plant_code']."' ORDER BY name");
				  
					while ($plant_code3 = pg_fetch_assoc($plant3)) {
				
                ?>
					<option <?php echo ($plant_code_value == $plant_code3['code'] ? 'Selected' : ''); ?> value="<?php echo $plant_code3['code'];?>"><?php echo $plant_code3['name'];?></option>
                <?php
                 }
				 }
                
                ?>
            </select> 
			<?php }elseif($login_admin == 'f'){?>
			<select name="plant_code" id="plant_code">                           
                <?php
                  while ($auth_plant_final3 = pg_fetch_assoc($auth_plant3)) {
						$plant3 = pg_query($db_connection, "SELECT * from plant_master where code='".$auth_plant_final3['plant_code']."' ORDER BY name");
				  
					while ($plant_code3= pg_fetch_assoc($plant3)) {
				
                ?>
					<option <?php echo ($plant_code_value == $plant_code3['code'] ? 'Selected' : ''); ?> value="<?php echo $plant_code3['code'];?>"><?php echo $plant_code3['name'];?></option>
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
            <select name="month_code" id="month_code">
              <option disabled selected>Choose your option</option>              
                                                   
					<?php foreach($months as $m => $m_val) {?>		
					
					<option  <?php echo ($month_code_value == $m ? 'Selected' : ''); ?>  value="<?php echo $m ;?>"><?php echo $m_val;?></option>
                <?php
                 }
                
                ?>
            </select>            
            <label>Months</label>
          </div>
          <div class="input-field col s12 mm2" style="margin-top: 24px;">
            <button class="btn waves-effect waves-light" id="button" type="submit" name="action" value="submit">Submit
              <i class="material-icons right">send</i>
            </button>
          </div>

		  
        </div>
      </div>
    </div>   
    <div class="container">
      <div class="field-container-footer">
        <div class="row" style="margin:0px;">
          <div class="col s12 table_header_option">
              
          </div>
        </div>  
      </div>
      <div class="field-container mcs_nmr" style="position: relative;">
        <div class="acc_t_clone"></div>
        <table id="accmpr_download" class="table d-table va-top va-middle table-bordered table-striped" cellspacing="0" width="99%">
          <thead>
            <tr>
			 
			  <th>Plant Name</th> 
              <th>Sector Name</th>              
              <th>Activity Name</th>              
              <th>Planned Budget</th> 
              <th>Planned Leverage</th> 
			  <th>Planned Beneficiary</th>
			  <th>Achieved Budget</th> 
              <th>Achieved Leverage</th> 
              <th>Achieved Beneficiary</th>  

            </tr>
          </thead>
           <tfoot>
              <tr>
                <th></th> 
                <th></th>              
                <th></th>              
                <th></th> 
                <th></th> 
                <th></th>
                <th></th> 
                <th></th> 
                <th></th>                          
              </tr>
            </tfoot>
        </table>   
      </div>	  
      
    </div>
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



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.15/api/sum().js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script> 

<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<script>
	$(document).ready(function() {
		$('#accmpr_download').DataTable( {  
     
    /*fixedHeader: {
            header: true,
            footer: true
        },*/    
		data: <?php echo $accmpr_download_final?>,	
					//"order": [[ 0, 'asc' ], [ 1, 'asc' ]],
					"ordering": false,
					dom: 'lBfrtip',
					lengthMenu: [
						[ 10, 20, 50,100, 200, -1 ],
						[ '10','20','50', '100', '200', 'Show all' ]
					],
           drawCallback: function(row, data, start, end, display) {
                    //console.log('in footerCallback');
                    var api = this.api();


                    api.columns([3,4,5,6,7,8], { page: 'current' }).every(function () {
                        var sum = api
                            .cells( null, this.index(), { page: 'current'} )
                            .render('display')
                            .reduce(function (a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                            var allSum = api
                            .cells( null, this.index() )
                            .render('display')
                            .reduce(function (a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);

                        //console.log(this.index() +' '+ sum); //alert(sum);
                        $(this.footer()).html(sum +' ('+ allSum+')');
                    });
                },
                /*columnDefs: [
              { className: "dt-body-left", "targets": [ 0 ] }
            ],*/
					buttons: [{
            extend: 'print',
            exportOptions: {
            columns: ':visible'
            },
            defaultStyle: {
            alignment: 'left'
            },
            title: 'ACC MPR Report <?php echo $plant_name['name']?>-<?php echo $months[$_POST['month_code']].' , '.$_POST['year_code']?>'
                     },
                     {

                       extend: 'pdf',					    
                       title: 'ACC MPR Report <?php echo $plant_name['name']?>-<?php echo $months[$_POST['month_code']].' , '.$_POST['year_code']?>',
                       
					   customize: function(doc) {
                         doc.styles['tableHeader'] = {
                           color: 'white',
                           fontSize: '8',
                           fillColor: '#c24e1c',   
                           alignment: 'left'
						   
                         }
                         doc.styles['tableBodyEven'] = {
                          fontSize: '8',						  
						  alignment: 'left'
						 
                         }  
                         doc.styles['tableBodyOdd'] = {
                          fontSize: '8',                        
						  alignment: 'left'
                         }  
                       }  
                     },
                     {

                       extend: 'csv',
                       title: 'ACC MPR Report <?php echo $plant_name['name']?>-<?php echo $months[$_POST['month_code']].' , '.$_POST['year_code']?>'
                     },
                     {

                       extend: 'excel',
                       title: 'ACC MPR Report <?php echo $plant_name['name']?>-<?php echo $months[$_POST['month_code']].' , '.$_POST['year_code']?>'
                       
                     }
                     ],						 
    "columns": [		
      { "data": "plant_name" },
      { "data": "sector_name" },
      { "data": "activity_name" },		
      { "data": "planned_bg" },
      { "data": "planned_lv" },
      { "data": "planned_nb" },
      { "data": "achieved_bg" },
      { "data": "achieved_lv" },	
      { "data": "achieved_nb" }	
		],
       rowsGroup: [0,1,2,3,4,5,6,7         ],
       

    } );

    $(".buttons-print").addClass("fa fa-print");
    $(".buttons-print").children("span").remove();
    $(".buttons-pdf").addClass("fa fa-file-pdf-o");
    $(".buttons-pdf").children("span").remove();
    $(".buttons-excel").addClass("fa fa-file-excel-o");
    $(".buttons-excel").css({"color":"#08743B"});
    $(".buttons-excel").children("span").remove();
    $("#accmpr_download_length").appendTo(".table_header_option");
    $(".dt-buttons").appendTo(".table_header_option");
    
    $("#accmpr_download").clone().appendTo( ".acc_t_clone" )

	})
</script>
</body>
</html>