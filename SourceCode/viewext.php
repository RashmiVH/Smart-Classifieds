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
 

<?php $class_id=$_GET['class_id'];
$class_id=substr($class_id,2);
echo $class_id;
// Include RAP
define("RDFAPI_INCLUDE_DIR", "rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RDFAPI.php");

// Filename of an RDF document
//$base="rdfapi-php/doc/example1.rdf";
$base="classified.owl";
$instance="http://localhost/SC/owl.php";
include "getrdf.php";
$ext_url="http://localhost/SC";
// Create a new MemModel
$model = ModelFactory::getDefaultModel();
$imodel=ModelFactory::getDefaultModel();
// Load and parse document
set_time_limit(0);
$model->load($base);
$imodel->loadFromString($instance,"rdf");



$type=new Resource("http://www.w3.org/1999/02/22-rdf-syntax-ns#type");

		$classified['id'] = $class_id;
		//$classifieds[$i]['category']= $statement->getSubject()->getLocalname();
		
		//to get all the attributes of the instance. It also returns the fact that its a type of the category
		$inter=$imodel->find(NULL,$type,NULL);
		foreach($inter->triples as $inst)
		{
			if($inst->getSubject()->getLocalname()==$class_id)	$inst_sub=$inst->getSubject();
				
		}
		if(isset($inst_sub))
		{
			$ins=$imodel->find($inst_sub,NULL,NULL);
			foreach($ins->triples as $attributes)
			{
				if($attributes->getPredicate()->getLocalName()!="type")
				{
					$classified[$attributes->getPredicate()->getLocalName()]= $attributes->getObject()->getLabel();
				}
				else
				{
					$classified['category']=$attributes->getObject()->getLabel();
				}
			}
			$title=$classified['Title'];
			$minvalue=$classified['MinValue'];
			if(isset($classified['MaxValue']))$maxvalue=$classified['MaxValue']; else $maxvalue=$classified['MinValue'];
			$ctype=$classified['ClassifiedType'];
			$classid=$classified['id'];
			$category=$classified['category'];
			$expdate=substr($classified['ValidTill'],0,10);
			if($classified['Image']!='none')$image=$ext_url.$classified['Image']; else $image='';
			$ad_date=substr($classified['ClassifiedDate'],0,10);
			unset($classified['ClassifiedDate']);
			unset($classified['Title']);
			unset($classified['MinValue']);
			unset($classified['MaxValue']);
			unset($classified['ClassifiedType']);
			unset($classified['id']);
			unset($classified['category']);
			unset($classified['ValidTill']);
			unset($classified['Image']);
					
	?>
	<div style="position:relative;top:20;left:50;right:50;">
	<div class="topleft"></div><div class="topright"></div><div class="left"></div><div class="right"></div><div class="bottom"></div><div class="bottomleft"></div><div class="bottomright"></div>
	<div class="title"><b class="titlelabel"><font size="+2"><?php echo $title; ?> </font>- <font size="+3"><?php if($ctype=="Buy") echo "Buy"; else echo "Sell" ?></font></b></div>
	
						<table width="100%"><tr><td>&nbsp;</td><td width="20%"><img <?php echo "src='". $image ."'";?> width="100px"></td><td><table border="0" width="100%" class="content">
				<?php 
					foreach($classified as $row1['INFO_NAME'] => $row1['INFO_VALUE'])
					{
				?>
							<tr>
								<td align="right" width="30%"><?php echo $row1['INFO_NAME'];?> :</td>
								<td align="left" style="left:5;" width="70%" colspan="2">
								<?php 
								//if($row1['TYPE']=="T") 
									echo $row1['INFO_VALUE'];
								/*else if($row1['TYPE']=="I")
									echo "<img src='".$row1['INFO_VALUE']."'>";
								else
									echo "<a href='".$row1['INFO_VALUE']."'>Download</a>";*/
								?>
								</td>
							</tr>
				<?php
					}
				?>
											
							<tr>
								<td align="right" width="30%">Minimum Value :</td>
								<td align="left" style="left:5;" width="70%" colspan="2">
								<?php echo $minvalue ?>
								</td>
							</tr>
							<tr>
								<td align="right" width="30%">Maximum Value :</td>
								<td align="left" style="left:5;" width="70%" colspan="2">
								<?php
									echo $maxvalue; 
								?></td>
							</tr>
							
							
							<tr>
								<td align="right" width="30%">Valid From :</td>
								<td align="left" style="left:5 " width="70%" colspan="2">
								<?php
									echo $ad_date; 
								?></td>
							</tr>
							<tr>
								<td align="right" width="30%">Valid To :</td>
								<td align="left" style="left:5 " width="70%" colspan="2">
								<?php
									echo $expdate;
								?></td>
							</tr>
							
						</table></td></tr></table>
	</div>
	
	<?php
				
		
	}
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
