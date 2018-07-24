<?php
$conn_error='Could not connect to database';
$mysql_host='localhost';
$mysql_user='root';
$mysql_password='';
$mysql_database='webchall';
$conn=@mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database) or die($conn_error);
?>