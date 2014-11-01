<?php

require_once("mysql.php");

$uid = $_POST['uid'];
$movie_uid = $_POST['movie_uid'];
$comment = $_POST['comment'];

$comment = mysql_real_escape_string($comment);

$sql = "INSERT INTO comments (uid,movie_uid,comment) 
				VALUES ('" . $uid . "','" . $movie_uid . "','" . $comment . "')";
				$result = mysql_query($sql);
				if(!$result) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}
				
?>
