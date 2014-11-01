<?php

require_once("mysql.php");

$title = $_POST['title'];
$year = $_POST['year'];
$image_url = $_POST['image_url'];
$uid = $_POST['uid'];

$title = mysql_real_escape_string($title);
$year = mysql_real_escape_string($year);
$image_url = mysql_real_escape_string($image_url);

$sql = "INSERT INTO movies (uid,title,year,image_url) 
				VALUES ('" . $uid . "','" . $title . "','" . $year . "','" . $image_url ."')";
				$result = mysql_query($sql);
				if(!$result) { 
					echo "Fail " .  mysql_error() . "</br>"; 
				}
				
?>