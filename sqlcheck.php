<?php
$server   = "localhost";
$database = "american_ADB";
$username = "root";
$password = "0ZVK5aF8SMNThJhYlM6k";

$mysqlConnection = mysql_connect($server, $username, $password);
if (!$mysqlConnection)
{
  echo "Please try later.";
}
else
{
	echo "conexted";
mysql_select_db($database, $mysqlConnection);
}
?>
