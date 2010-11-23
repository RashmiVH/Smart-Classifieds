<?php
$user=$_GET["user"];
require_once('lib/pdomap.php');
pdoMap::config('config.xml');

$user = pdoMap::get('user')->SelectBy("USERNAME",$user);
	if ($user->count()) 
	{
  		echo "1";
 	}
	else
	{
		echo "0";
	}
	pdoMap::cache()->closeSession();
?>