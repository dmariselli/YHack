<?php

require_once("mysql.php");

$sql = "SELECT * FROM movies";
				$result = mysql_query($sql);
				if(!$result) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}
				
?>
