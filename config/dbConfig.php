<?php
$db_connection = pg_connect("host=localhost dbname=sss user=ddd password=xx");
if(!$db_connection) {
      echo "Error : Unable to open database\n";
   } 
?>
