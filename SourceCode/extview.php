<?php
 session_start();
 
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

	$username= $_SESSION['user_sc'];
	$password="";
	$login=2;

	require_once('lib/pdomap.php');
	pdoMap::config('config.xml');
	$category = pdoMap::get('category_master')->SelectAll();
	$ret="";
	$js="([";
	foreach ($category as $key => $value)
	{
		if($js!="([") $js.=",";
		$ret.="<option value='" . $value->CAT_ID ."'>".$value->CATEGORY_NAME ."</option>";
		$js.="{'ID' : '" . $value->CAT_ID . "','Name' : '" . $value->CATEGORY_NAME ."','Comment' : '".$value->COMMENTS ."'}";
	}
	$js.="])";
?>
<script language="javascript">
var categoryMaster= eval(<?php echo $js;?>);
//alert(categoryMaster);
</script>
<table width="100%"  border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>
		<table border="0" width="100%">
			<tr>
				<td></td>
				<td width="30%">
					

					
						<div style="position:relative; height:37px">
						<div class="topleft"></div><div class="topright"></div><div class="top"></div>
						<div class="title"></div>
						<div class="titlelabel" style="left:3">Welcome <?php echo $username;?>,</div>
						<div class="bottom" style="left:0;right:0 "></div>
						</div>
						<div style="position:relative; height:37px">
						<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
						<div class="titlelabel" style="left:5px;right:5px;top:3"><table width="100%" border="0"><tr><td width="70%"><a href="account.php">My Account</a></td><td width="70%"><a href="logout.php">Logout</a></td></tr></table>
						</div>
						</div>		
				</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>

	<div style="position:relative; height:37px">
	<div class="topleft"></div><div class="topright"></div><div class="top"></div>
	<div class="title"></div>
	<form action="index.php" method="get">
<center><label style="position:relative;top:3; z-index:3 ">Search : &nbsp; &nbsp; </label><input type="text" name="q" style="position:relative;z-index:3;top:5; " size="50"> 
<select style="position:relative; background-image:url(images/title.png); top:5; " name="Category" >
<option value="">All Categories</option>
<?php echo $ret; ?>
<option> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; </option>
</select>
	  <input type="image" onClick="this.Submit()" style="position:absolute;z-index:3;"  height="25px" src="images/search.png">
	  </center>
	</form>
	<div class="bottom" style="z-index:4;left:0;right:0 "></div>
	</div>
	<!-- Menu Bar -->
	<div style="position:relative; height:37px">
	<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
	<div class="titlelabel" style="left:5px;right:5px;top:3" >
	<table border="0" width="100%" align="center">
	<tr>
	<td align="center" width="33%"><a href="index.php">Home</a></td>
	<td align="center" width="33%"><a href="about.html">About</a></td>
	<td align="center" width="33%"><a href="contact.html">Contact Us</a></td>
	</tr>
	</table>
	</div>
	</div>
	</td>
  </tr>
  
<tr><td>&nbsp;</td></tr>
 <tr>
 <td>
<?php
$error=false;
if(!isset($_POST['title']))
	$error=true;
if($error)
{
?>		
 

<?php $class_id=$_GET['class_id'];?>
<?php
							
		$con = mysql_connect("localhost",'root','mysql');
		if ($con)
		{
			mysql_select_db("sc", $con);
			$sql="SELECT * from classified where CLASS_ID=".$class_id;
			$result = mysql_query($sql);
			if($result && $row = mysql_fetch_array($result))
			{
				$sql1="SELECT INFO_NAME,INFO_VALUE,TYPE from additional_info A,additional_info_master M where A.ADD_INFO_MASTER_ID=M.ADD_INFO_MASTER_ID and A.CLASS_ID=".$class_id ." ORDER BY A.ADD_INFO_MASTER_ID";
				$result1 = mysql_query($sql1);
				
?>
<div style="position:relative;top:20;left:50;right:50;">
<div class="topleft"></div><div class="topright"></div><div class="left"></div><div class="right"></div><div class="bottom"></div><div class="bottomleft"></div><div class="bottomright"></div>
<div class="title"><b class="titlelabel"><font size="+2"><?php echo $row['TITLE']; ?> </font>- <font size="+3"><?php if($row['TYPE']=="B") echo "Buy"; else echo "Sell" ?></font></b></div>

					<table width="100%"><tr><td>&nbsp;</td><td width="20%"><img <?php echo "src='". $row['IMAGE'] ."'";?> width="100px"></td><td><table border="0" width="100%" class="content">
			<?php 
				while($result1 && $row1 = mysql_fetch_array($result1))
				{
			?>
						<tr>
							<td align="right" width="30%"><?php echo $row1['INFO_NAME'];?> :</td>
							<td align="left" style="left:5;" width="70%" colspan="2">
							<?php 
							if($row1['TYPE']=="T") 
								echo $row1['INFO_VALUE'];
							else if($row1['TYPE']=="I")
								echo "<img src='".$row1['INFO_VALUE']."'>";
							else
								echo "<a href='".$row1['INFO_VALUE']."'>Download</a>";
							?>
							</td>
						</tr>
			<?php
				}
			?>
										
						<tr>
							<td align="right" width="30%">Minimum Value :</td>
							<td align="left" style="left:5;" width="70%" colspan="2">
							<?php echo $row['MIN_VALUE']; ?>
							</td>
						</tr>
						<tr>
							<td align="right" width="30%">Maximum Value :</td>
							<td align="left" style="left:5;" width="70%" colspan="2">
							<?php
							    echo $row['MAX_VALUE']; 
						  	?></td>
						</tr>
						
						
						<tr>
							<td align="right" width="30%">Valid From :</td>
							<td align="left" style="left:5 " width="70%" colspan="2">
							<?php
								echo $row['AD_DATE']; 
							?></td>
						</tr>
						<tr>
							<td align="right" width="30%">Valid To :</td>
							<td align="left" style="left:5 " width="70%" colspan="2">
							<?php
								echo $row['EXP_DATE'];
							?></td>
						</tr>
						
					</table></td></tr></table>
</div>

<?php
			mysql_close($con);
		}
	}
}
else
{
?>

<?php
}
?>
 </td>
 </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
}
?>
</body>
</html>
