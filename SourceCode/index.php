

<?php


 session_start();
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
pdoMap::cache()->closeSession();
 
if (!isset($_POST['user']) && !empty($_SESSION['user_sc']) )
{
	$username= $_SESSION['user_sc'];
	$password="";
	$login=2;
}
else if(!isset($_POST['user']))
{
$login=-1;
}
else
{
		
		$_SESSION['user_sc']="";
		$username=$_POST["user"];
		$password=$_POST["password"];
		require_once('lib/pdomap.php');
		pdoMap::config('config.xml');
		
		$user = pdoMap::get('user')->SelectBy("USERNAME",$username);
			if ($user->count()) 
			{
				$user=$user->current();
				if($user->PASSWORD==$password)
				{
				$_SESSION['user_sc']=$username;
				setcookie("user_sc",md5($username . $password),time()+3600);
				$login=2;
				}
				else
				{
					$login=0;
				}
			}
			else
			{
				$login=1;
			}
			pdoMap::cache()->closeSession();
			
}?>
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
<?php
if($login!=2)
{
	?>
	

<script language="javascript">
function showLogin()
{
	document.getElementById('loginband').style.display="none";
	document.getElementById('loginexpand').style.display="";
	document.getElementById('user').focus();
}

function hideLogin()
{
	document.getElementById('loginband').style.display="";
	document.getElementById('loginexpand').style.display="none";
}
</script>

</head>

<body>	


<table width="100%"  border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>
		<table border="0" width="100%">
			<tr>
				<td></td>
				<td width="30%">
					

					<div id="loginband">
						<div style="position:relative; height:37px">
						<div class="topleft"></div><div class="topright"></div><div class="top"></div>
						<div class="title"></div>
						<div class="titlelabel">Welcome Guest,</div>
						<div class="bottom" style="left:0;right:0 "></div>
						</div>
						<div style="position:relative; height:37px">
						<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
						<div class="titlelabel" style="left:5px;right:5px;top:3"><a href="javascript:showLogin()">Signin</a>/<a href="register.php">Register</a> to Post Classifieds
						</div>
						</div>
					</div>

					<div id="loginexpand" style="display:none;position:relative">
					  <div class="topright"></div>  <div class="topleft"></div><div class="left"></div><div class="right"></div><div class="bottomleft"></div>  <div class="bottomright"></div>  <div class="bottom"></div>
					  <div class="title"><b class="titlelabel">Login</b></div><a href="javascript:hideLogin()" style="position:absolute;top:7px;right:5px;"><img src="images/close.png"></a>
					  <div class="content">	
						<form method="post" action="index.php">
							<table border="0" width="100%">
								<tr>
									<td>Username :</td>
									<td><input type="text" name="user" id="user" size="15"></td>
								</tr>
								<tr>
									<td>Password :</td>
									<td><input type="password" name="password" id="password" size="15"></td>
								</tr>
								<tr>
									<td colspan="2" align="center"><input type="submit" value="Login"></td>
								</tr>
								<?php if($login!=-1) echo '<tr><td colspan="2" ><span class="style1">Invalid Username/Password</span></td>'; ?>
								</tr>
								<tr>
									<td colspan="2" align="center">Not a user? <a href="register.php">Register</a> and Post Classifieds</td>
								</tr>
							</table>
						</form>
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
<center><label style="position:relative;top:3; z-index:3 ">Search : &nbsp; &nbsp; </label><input type="text" name="q" style="position:relative;z-index:3;top:5; " size="50" <?php if(isset($_GET['q'])) echo "value='".$_GET['q']."'"; ?>> 
<select style="position:relative; background-image:url(images/title.png); top:5; " name="Category" >
<option value="">All Categories</option>
<?php echo $ret; ?>
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
	<table border="0" width="100%">
	<tr>
	<td><strong>Home</strong></td>
	<td><a href="about.html">About</a></td>
	<td><a href="contact.html">Contact Us</a></td>
	</tr>
	</table>
	<?php
	if(isset($_GET['q']))
	{
		include "search.php";
	}
	?>
	</div>
	</div>
	</td>
  </tr>
  <tr>
    <td> <!-- Content Section having menu section, Information relating to the page, Login Section -->
		
	</td>
  </tr>
</table>

	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<!--
<div id="roundrect2" style="position:relative; overflow:hidden; left:14px; top:104px; width:177px; height:210px; z-index:0">
  <div class="topright"></div>  <div class="topleft"></div><div class="left"></div><div class="right"></div><div class="bottomleft"></div>  <div class="bottomright"></div>  <div class="bottom"></div>
  <div class="title"><b class="titlelabel">Content</b></div>
  <div class="content">	Movies<br>
 	<a href="edu.html">E-Learning</a><br>
 	How-to<br>
  </div>
</div>
-->
<?php
if($login!=-1)
{
?>
<script language="javascript">
document.getElementById('user').value='<?php echo $_POST['user'];?>';
showLogin();
</script>
<?php
}
?>
</body>
</html>

	
	
<?php
}
else
{
?>


</head>

<body>	


<table width="100%"  border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>
		<table border="0" width="100%">
			<tr>
				<td></td>
				<td width="30%">
					

					<div id="loginband">
						<div style="position:relative; height:37px">
						<div class="topleft"></div><div class="topright"></div><div class="top"></div>
						<div class="title"></div>
						<div class="titlelabel" style="left:3">Welcome <?php echo $username ?>,</div>
						<div class="bottom" style="left:0;right:0 "></div>
						</div>
						<div style="position:relative; height:37px">
						<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
						<div class="titlelabel" style="left:5px;right:5px;top:3"><table width="100%" border="0"><tr><td width="50%"><a href="account.php">My Account</a></td><td width="50%"><a href="logout.php">Logout</a></td></tr></table>
						</div>
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
<center><label style="position:relative;top:3; z-index:3 ">Search : &nbsp; &nbsp; </label><input type="text" name="q" style="position:relative;z-index:3;top:5; " size="50" <?php if(isset($_GET['q'])) echo "value='".$_GET['q']."'"; ?>> 
<select style="position:relative; background-image:url(images/title.png); top:5; " name="Category" >
<option value="">All Categories</option>
<?php echo $ret; ?>
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
	<table border="0" width="100%">
	<tr>
	<td><a href="index.php">Home</a></td>
	<td><a href="addclassified.php">New Classified</a></td>
	<td><a href="about.html">About</a></td>
	<td><a href="contact.html">Contact Us</a></td>
	</tr>
	</table>
	</div>
	</div>
	</td>
  </tr>
  <tr>
    <td> <!-- Content Section having menu section, Information relating to the page, Login Section -->
		<?php
	if(isset($_GET['q']))
	{
		echo "<h3>Internal Search<h3>";
		include "search.php";
	}
	else if(!isset($other))
	{
		include "home.php";
	}
	?>
	</td>
  </tr>
</table>

<?php
if(!isset($other))
{
?>
</body>
</html>

<?php
}
}
?>