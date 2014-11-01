<?php

require_once("mysql.php");

$uid = $_POST['uid'];

$sql = "DELETE FROM movies WHERE uid = '$uid'";
				$result = mysql_query($sql);
				if(!$result) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}

$sql = "DELETE FROM comments WHERE movie_uid = '$uid'";
				$result = mysql_query($sql);
				if(!$result) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}

?>