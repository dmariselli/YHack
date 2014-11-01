<?php

require_once("mysql.php");

$sql = "SELECT * FROM comments INNER JOIN movies ON movies.uid = comments.movie_uid";
				$resultsboth = mysql_query($sql);
				if(!$resultsboth) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}

?>