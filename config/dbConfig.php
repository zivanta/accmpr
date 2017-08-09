<?php
$db_connection = pg_connect("host=localhost dbname=accmpr_admin user=accmpr-admin password=h5Bwv59");
if(!$db_connection) {
      echo "Error : Unable to open database\n";
   } 
?>
