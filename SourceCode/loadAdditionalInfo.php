<?php
$category=$_GET["category"];
require_once('lib/pdomap.php');
pdoMap::config('config.xml');

	$addInfo = pdoMap::get('additional_info_master')->SelectBy("CAT_ID",$category);
	if ($addInfo->count()) 
	{
		$start=true;
		echo "([";
		foreach($addInfo as $key => $value)
		{
			if($start)
				$start=false;
			else
				echo ",";
			echo "{'INFO_NAME' : '" . $value->INFO_NAME . "' , ";
			echo "'MANDATORY' : '" . $value->MANDATORY ."' , ";
			echo "'ADD_INFO_MASTER_ID' : '" . $value->ADD_INFO_MASTER_ID ."' , ";
			echo "'TYPE' : '" . $value->TYPE ."' , ";
			echo "'COMMENTS' : '" . $value->COMMENTS ."'}";
		}
		echo "])";
 	}
	else
	{
	echo "([])";
	}
	pdoMap::cache()->closeSession();
?>