<?php

require_once("mysql.php");

$sql = "SELECT * FROM comments";
				$resulting = mysql_query($sql);
				if(!$resulting) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}
				
?>