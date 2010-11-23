<?php
 //session_start();
 $other="upload";
 include "index.php";
 //echo "<br>";
if (empty($_SESSION['user_sc']) )
{
header( 'Location: index.php' ) ;
}
else
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Instant Classifieds</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="generator" content="Web Page Maker (unregistered version)">
<style type="text/css">
html{height:100%;margin:0;padding:0}
body{FONT-SIZE:0.8em;COLOR:#944;height:100%;min-width:900px}
/*----------Text Styles----------*/
.wpmd {font-size: 13px;font-family: 'Arial';font-style: normal;font-weight: normal;}
.topleft{position:absolute;top:0;left:0; width:14px; height:37px;background:url(images/topleft.png)}
.topright{position:absolute;top:0;right:0;width:13px;height:37px;background: url(images/topright.png)}
.blanktopleft{position:absolute;top:0;left:0; width:13px; height:12px;background:url(images/blankleft.png)}
.blanktopright{position:absolute;top:0;right:0;width:13px;height:12px;background: url(images/blankright.png)}
.title{position:absolute;top:0;left:14px;right:13px;background:white;height:37px;background: url(images/title.png) repeat-x;}
.top{position:absolute;top:0;left:14px;right:13px;background:white;height:2px;background: url(images/horizantal.png) repeat-x;}
.left{position: absolute;top: 37px;left: 0px;bottom: 11px;width: 2px;background: url(images/vertical.png) repeat-y ;}
.right{position: absolute;top: 37px;right: 0px;bottom: 11px;width: 2px;background: url(images/vertical.png) repeat-y ;}
.blankleft{position: absolute;top: 12px;left: 0px;bottom: 11px;width: 2px;background: url(images/vertical.png) repeat-y ;}
.blankright{position: absolute;top: 12px;right: 0px;bottom: 11px;width: 2px;background: url(images/vertical.png) repeat-y ;}
.bottom{position:absolute;bottom:0px;left:12px;right:10px;background:white;height:2px;background: url(images/horizantal.png) repeat-x }
.bottomleft{position:absolute;bottom:0;left:0;width:12px;height:11px;background: url(images/bottomleft.png)}
.bottomright{position:absolute;bottom:0;right:0;width:13px;height:12px;background: url(images/bottomright.png)}

.greytopleft{position:absolute;top:0;left:0; width:14px; height:37px;background:url(images/greytopleft.png)}
.greytopright{position:absolute;top:0;right:0;width:13px;height:37px;background: url(images/greytopright.png)}
.greyblanktopleft{position:absolute;top:0;left:0; width:13px; height:12px;background:url(images/greyblankleft.png)}
.greyblanktopright{position:absolute;top:0;right:0;width:13px;height:12px;background: url(images/greyblankright.png)}
.greytitle{position:absolute;top:0;left:14px;right:13px;background:white;height:37px;background: url(images/greytitle.png) repeat-x;}
.greytop{position:absolute;top:0;left:14px;right:13px;background:white;height:2px;background: url(images/greyhorizantal.png) repeat-x;}
.greyleft{position: absolute;top: 37px;left: 0px;bottom: 11px;width: 2px;background: url(images/greyvertical.png) repeat-y ;}
.greyright{position: absolute;top: 37px;right: 0px;bottom: 11px;width: 2px;background: url(images/greyvertical.png) repeat-y ;}
.greyblankleft{position: absolute;top: 12px;left: 0px;bottom: 11px;width: 2px;background: url(images/greyvertical.png) repeat-y ;}
.greyblankright{position: absolute;top: 12px;right: 0px;bottom: 11px;width: 2px;background: url(images/greyvertical.png) repeat-y ;}
.greybottom{position:absolute;bottom:0px;left:12px;right:10px;background:white;height:2px;background: url(images/greyhorizantal.png) repeat-x }
.greybottomleft{position:absolute;bottom:0;left:0;width:12px;height:11px;background: url(images/greybottomleft.png)}
.greybottomright{position:absolute;bottom:0;right:0;width:13px;height:12px;background: url(images/greybottomright.png)}
.greyfooter{position:absolute;top:0;left:13px;right:14px;background:white;height:37px;background: url(images/greyfooter.png) repeat-x;}
.greyfooterleft{position:absolute;top:0;left:0; width:13px; height:37px;background:url(images/greyfooterleft.png)}
.greyfooterright{position:absolute;top:0;right:0;width:14px;height:37px;background: url(images/greyfooterright.png)}

.content{padding:42px 10px 10px 15px;}
.blankcontent{padding:5px 10px 10px 15px;}
.titlelabel{position:absolute;top:7px;left:2px;}
/*----------Para Styles----------*/
DIV,UL,OL /* Left */
{
 margin-top: 0px;
 margin-bottom: 0px;
}
.style1 {color: #FF0000}
</style>
</head>

<body>
<?php
//echo $_POST['newCategoryComment'];
$msg="";
$error="";
$con = mysql_connect('localhost', 'root', 'mysql');
if ($con)
{
	mysql_select_db("sc", $con);
	if($_POST['category']=="other")
	{
	 	//$con = mysql_connect('localhost', 'username', 'password');	
		//$sql="UPDATE or DELETE or INSERT";
		//mysql_query($sql,$con);
		/// SELECT 
		$sql="SELECT * from category_master where lower(CATEGORY_NAME)='". strtolower($_POST['newCategory'])."'";
		$result = mysql_query($sql);
		if($row = mysql_fetch_array($result))
		{
			$msg="Similar category exists already. Select category '" . $row['CATEGORY_NAME']."' from the Dropdown";
			$error="error";
		}
		else
		{
			$sql="INSERT INTO category_master (CATEGORY_NAME,COMMENTS) values ('".$_POST['newCategory']."','". $_POST['newCategoryComment'] ."')";
			mysql_query($sql,$con);
			$sql="SELECT * from category_master where CATEGORY_NAME='". $_POST['newCategory']."'";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$cat_id=$row['CAT_ID'];
		}
	}
	else
	{
		$cat_id=$_POST['category'];
	}
	if($msg=="")
	{
		$sql="SELECT INT_ID from internal_user where USER_ID=(SELECT USER_ID FROM user where USERNAME='". $_SESSION['user_sc']."')";
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		$int_id=$row['INT_ID'];
		if($_POST['type']=="sell")
			$type="S";
		else
			$type="B";
		//Check if a classified is a duplicate
		$sql="SELECT * FROM classified where INT_ID=".$int_id." AND CAT_ID=".$cat_id." AND TITLE='".$_POST['title']."' AND TYPE='".$type."' AND MIN_VALUE=".$_POST['min']." AND MAX_VALUE=".$_POST['max']." AND AD_DATE='".$_POST['validfrom']."' AND EXP_DATE='". $_POST['validto'] ."' AND EXPIRED=0";
		//echo $sql."<br>";
		$result = mysql_query($sql);
		if($row=mysql_fetch_array($result))
		{
			$msg.="This classified already exists or you have refreshed the page.|";
			$error="error";
		}
		else
		{
			
			
			$sql="INSERT INTO classified (INT_ID,CAT_ID,TITLE,TYPE,MIN_VALUE,MAX_VALUE,AD_DATE,EXP_DATE,EXPIRED,IMAGE) values (".$int_id.",".$cat_id.",'".$_POST['title']."','".$type."',".$_POST['min'].",".$_POST['max'].",'".$_POST['validfrom']."','". $_POST['validto'] ."',0,'')";
			//echo $sql."<br>";
			mysql_query($sql,$con);
			$sql="SELECT CLASS_ID FROM classified where INT_ID=".$int_id." AND CAT_ID=".$cat_id." AND TITLE='".$_POST['title']."' AND TYPE='".$type."' AND MIN_VALUE=".$_POST['min']." AND MAX_VALUE=".$_POST['max']." AND AD_DATE='".$_POST['validfrom']."' AND EXP_DATE='". $_POST['validto'] ."' AND EXPIRED=0 AND IMAGE=''";
			//echo $sql."<br>";
			$result = mysql_query($sql);
			$row=mysql_fetch_array($result);
			$class_id=$row['CLASS_ID'];
			$img_name='file_uploads/'.$class_id."_".$_FILES['image']['name'];
			$sql="UPDATE classified SET IMAGE='".$img_name."' WHERE CLASS_ID=".$class_id;
			//echo $sql."<br>";
			mysql_query($sql,$con);
			foreach($_POST as $key => $value)
			{
				if(strlen($key)>11 && substr($key,0,11)=="customField")
				{
				//echo "<br>".$key." |1|<br>";
					$i=substr($key,11);
					if($value!=""/*add code for checking blank value of customValue*/)
					{
						
						$sql="SELECT * from additional_info_master where CAT_ID=".$cat_id." AND lower(INFO_NAME)='". str_replace('_',' ',strtolower($_POST['customField'.$i]))."'";
						//echo "<br><h3>".$sql."</h3><br>";
						$result = mysql_query($sql);
						if($row = mysql_fetch_array($result))
						{
							$add_info_id=$row['ADD_INFO_MASTER_ID'];
							$sql="INSERT INTO additional_info (CLASS_ID,ADD_INFO_MASTER_ID,INFO_VALUE) values (".$class_id.",".$add_info_id.",'".$_POST['customValue'.$i]."')";
							mysql_query($sql,$con);
						}
						else
						{
							if($_POST['customType'.$i]=="text")
								$type='T';
							else if($_POST['customType'.$i]=="image")
								$type='I';
							else
								$type='F';
							$sql="INSERT INTO additional_info_master (CAT_ID,INFO_NAME,MANDATORY,TYPE,COMMENTS) values (".$cat_id.",'".str_replace('_',' ',$_POST['customField'.$i])."',0,'".$type."','". $_POST['customComment' .$i] ."')";
							mysql_query($sql,$con);
							$sql="SELECT * from additional_info_master where CAT_ID=".$cat_id." AND INFO_NAME='". str_replace('_',' ',$_POST['customField'.$i])."'";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result);
							$add_info_id=$row['ADD_INFO_MASTER_ID'];
							//echo"<br><h2>".$add_info_id."</h2><br>";
							if($type=="T")
							{
								$sql="INSERT INTO additional_info (CLASS_ID,ADD_INFO_MASTER_ID,INFO_VALUE) values (".$class_id.",".$add_info_id.",'".$_POST['customValue'.$i]."')";
								//echo"<br>".$sql."<br>";
								mysql_query($sql,$con);
							}
							else
							{
								$sql="INSERT INTO additional_info (CLASS_ID,ADD_INFO_MASTER_ID,INFO_VALUE) values (".$class_id.",".$add_info_id.",'".$class_id."')";
								//echo"<br>".$sql."<br>";
								mysql_query($sql,$con);
								$sql="SELECT ADD_INFO_ID FROM additional_info where CLASS_ID=".$class_id." AND ADD_INFO_MASTER_ID=".$add_info_id." AND INFO_VALUE='".$class_id."'";
								//echo$sql."<br>";
								$result = mysql_query($sql);
								$row=mysql_fetch_array($result);
								$add_id=$row['ADD_INFO_ID'];
								$file_name='file_uploads/'.$class_id."_".$add_id."_".$_FILES['customValue'.$i]['name'];
								move_uploaded_file($_FILES['customValue'.$i]['tmp_name'],$file_name);
								$sql="UPDATE additional_info SET INFO_VALUE='".$file_name."' where ADD_INFO_ID=".$add_id;
								//echo$sql."<br>";
								mysql_query($sql,$con);
								//add code for upload of the file and insert it to db;
							}
						}
					}
				}
				else if((strlen($key)>11 && substr($key,0,11)=="customValue") || (strlen($key)>13 && substr($key,0,13)=="customComment") || (strlen($key)>10 && substr($key,0,10)=="customType"))
				{
					//echo"<br>".$key." |2| <br>";
					//dont do anything for customValue and other paramentrs of custom 
				}
				else
				{
				//echo"<br>".$key."<br>";
					$sql="SELECT * from additional_info_master where CAT_ID=".$cat_id." AND INFO_NAME='". str_replace('_',' ',$key) ."'";
					$result = mysql_query($sql);
					$row = mysql_fetch_array($result);
					$add_info_id=$row['ADD_INFO_MASTER_ID'];
					if($add_info_id!="")
					{
						$sql="INSERT INTO additional_info (CLASS_ID,ADD_INFO_MASTER_ID,INFO_VALUE) values (".$class_id.",".$add_info_id.",'".$value."')";
						//echo"<br>".$sql."<br>";
						mysql_query($sql,$con);
					}
				}
				
			}
			//add code for uploading of image and updating the table
			move_uploaded_file($_FILES['image']['tmp_name'],$img_name);
		}
	}
}
if($error=="")
{
?>
<center>
<div style="position:relative; ">
						<div style="position:relative; height:37px;width:500px">
						<div class="topleft"></div><div class="topright"></div><div class="top"></div>
						<div class="title"></div>
						<div class="titlelabel" style="top:5px;left:10px "><b>Classified <I><?php echo $_POST['title']; ?></I> Successfully Created</b></div>
						<div class="bottom" style="left:0;right:0 "></div>
						</div>
						<div style="position:relative; height:37px;width:500px">
						<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
						<div class="titlelabel" style="left:5px;right:5px;top:3"><a <?php echo "href='view.php?class_id=".$class_id ."'"; ?>>View</a> the classified
						</div>
						</div>	</div></center>
						<?php if($msg!="") echo "Warnings : " . $msg; ?>
</body></html>
<?php
}
else
{
?>
<center>
<div style="position:relative; ">
						<div style="position:relative; height:37px;width:500px">
						<div class="topleft"></div><div class="topright"></div><div class="top"></div>
						<div class="title"></div>
						<div class="titlelabel" style="top:5px;left:10px "><b>Error</b></div>
						<div class="bottom" style="left:0;right:0 "></div>
						</div>
						<div style="position:relative; height:37px;width:500px">
						<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
						<div class="titlelabel" style="left:5px;right:5px;top:3"><?php echo $msg;?>
						</div>
						</div>	</div></center>
<?php
}
}
?>
						