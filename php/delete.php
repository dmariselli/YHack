<?php

require_once("mysql.php");

$sql = "DELETE FROM movies";
				$result = mysql_query($sql);
				if(!$result) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}

$sql = "DELETE FROM comments";
				$resulting = mysql_query($sql);
				if(!$resulting) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}

?>