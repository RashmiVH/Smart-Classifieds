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
.titlelabel{position:absolute;top:7px;left:-10px;}
/*----------Para Styles----------*/
DIV,UL,OL /* Left */
{
 margin-top: 0px;
 margin-bottom: 0px;
}
</style>
<?php
require_once('lib/pdomap.php');
pdoMap::config('config.xml');
$error=false;
$first=false;
if(!isset($_POST['username']))
{
	$error=true;
	$first=true;
}
else
{
	if(strlen($_POST[ 'password' ])>15)
		$error = true;
	else if(strlen($_POST[ 'password' ])<5)
		$error = true;
	if(trim($_POST['email'])=='')
		$error = true;
	else if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email']))
		$error = true;
	$userA=true;
	$user = pdoMap::get('user')->SelectBy("USERNAME",$_POST['username']);
	if ($user->count())
	{
		$error = true;
		$userA=false;
	}
	if(strlen($_POST[ 'name' ])==0)
		$error = true;
	if(strlen($_POST[ 'addl1' ])==0)
		$error = true;
	if(strlen($_POST[ 'city' ])==0)
		$error = true;
	if(strlen($_POST[ 'state' ])==0)
		$error = true;
	if(strlen($_POST[ 'pin' ])==0)
		$error = true;
	else if(strlen($_POST[ 'pin' ])<2)
		$error = true;
	if(strlen($_POST[ 'phone' ])==0)
		$error = true;
	else if(strlen($_POST[ 'phone' ])<5)
		$error = true;
	if($_POST[ "country" ]=="")
		$error = true;
}
if($error)
{
?>
<script language="javascript">
var userAvail=false;
function showError(id,msg)
{
	document.getElementById(id).innerHTML="<img src='images/error.png'>" + msg;
}

function success(id)
{
	document.getElementById(id).innerHTML="<img src='images/success.png'>";
}

function empty(id)
{
	document.getElementById(id).innerHTML="";
}

function validatePassword()
{
	if(document.getElementById("password").value.length>15)
	{
		showError("divPassword","Password cannot be greater than 15 characters");
		return false;
	}
	else if(document.getElementById("password").value.length<5)
	{
		showError("divPassword","Password cannot be less than five");
		return false;
	}
	else
	{
		success("divPassword");
		return true;
	}
}

function confirmPassword()
{
	if(document.getElementById("cpassword").value.length==0)
	{
		showError("divCPassword","Confirm Password");
		return false;
	}
	else if(document.getElementById("password").value===document.getElementById("cpassword").value)
	{
		success("divCPassword");
		return true;
	}
	else
	{
		showError("divCPassword","Passwords Does not Match");
		return false;
	}
}

function validateEmail()
{
	var email=document.getElementById("email").value;
	var v=true;
	var ending=email.split("@");
	if(ending.length!=2) 
		v= false;
	else
	{
		var address=ending[0];
		var domain=ending[1].split('.');
		if(domain.length!=2)
		{
			v= false;
		}
		else
		{
			ending=domain[1];
			domain=domain[0];
			if(address.length==0 || domain.length==0 || ending.length==0) v=false;
		}
	}
	if(v==true)
	{
		success("divEmail");
		return true;
	}
	else
	{
		showError("divEmail","Invalid Email Address. Enter a valid Email.");
		return false;
	}
	return false;
}

function confirmEmail()
{
	if(document.getElementById("cemail").value.length==0)
	{
		showError("divCEmail","Confirm Email");
		return false;
	}
	else if(document.getElementById("email").value===document.getElementById("cemail").value)
	{
		success("divCEmail");
		return true;
	}
	else
	{
		showError("divCEmail","Emails Does not Match");
		return false;
	}
}

var userAjax;
function checkUser()
{
//alert("got");
	if(userAjax.readyState==4)
	{
		if(userAjax.status==200)
		{
			var available=userAjax.responseText;
			//alert(available);
			if(available==0)
			{
				success("divUsername");
				userAvail=true;
			}
			else if(available==1)
			{
				showError("divUsername","Username already taken. Select other Username");
				userAvail=false;
			}
			else
			{
				showError("divUsername","Unable to check due to error in server. Retrying...");
				userAvail=false;
				isUserAvailable();
			}
		}
	}
}
function isUserAvailable()
{
	userAjax=new XMLHttpRequest();
	var username=document.getElementById("username");
	var url="user.php?user=" + username.value;
	//alert("|" + url + "|")
	userAjax.onreadystatechange=checkUser;
	userAjax.open("get",url,true);
	userAjax.send();
}

function validateName()
{
	if(document.getElementById('name').value.length==0)
	{
		showError("divName","Enter your name");
		return false;
	}
	else 
	{
		success("divName");
		return true;
	}
}

function validateAddl1()
{
	if(document.getElementById('addl1').value.length==0)
	{
		showError("divAddl1","Line one cant be empty");
		return false;
	}
	else 
	{
		success("divAddl1");
		return true;
	}
}

function validateCity()
{
	if(document.getElementById('city').value.length==0)
	{
		showError("divCity","Enter your City");
		return false;
	}
	else 
	{
		success("divCity");
		return true;
	}
}

function validateState()
{
	if(document.getElementById('state').value.length==0)
	{
		showError("divState","Enter your State");
		return false;
	}
	else 
	{
		success("divState");
		return true;
	}
}

function validatePin()
{
	if(document.getElementById('pin').value.length==0)
	{
		showError("divPin","Enter your Pincode/Zip Code");
		return false;
	}else if(document.getElementById('pin').value.length<2)
	{
		showError("divPin","Enter valid Pincode/Zip Code");
		return false;
	}
	else 
	{
		success("divPin");
		return true;
	}
}

function validatePhone()
{
	if(document.getElementById('phone').value.length==0)
	{
		showError("divPhone","Enter your Phone Number");
		return false;
	}
	else if(document.getElementById('phone').value.length<5)
	{
		showError("divPhone","Enter valid Phone Number");
		return false;
	}
	else
	{
		success("divPhone");
		return true;
	}
}

function validateCountry()
{
	if(document.getElementById("country").value=="Select a Country")
	{
		showError("divCountry","Select Country");
		return false;
	}
	else
	{
		success("divCountry");
		return true;
	}
}

function validateAgree()
{
	if(!document.getElementById('agree').checked)
	{
		showError("divAgree","You should agree to the Term & Conditions");
		return false;
	}
	else
	{
		success("divAgree");
		return true;
	}
}

function validateAll()
{
	var fsubmit=true;
	if(!userAvail)
	{
		showError("divUsername","Select a Username");
		fsubmit= false;
	}
	if(!validatePassword())
		fsubmit=false;
	if(!confirmPassword())
		fsubmit=false;
	if(!validateEmail())
		fsubmit=false;
	if(!confirmEmail())
		fsubmit=false;
	if(!validateName())
		fsubmit=false;
	if(!validateAddl1())
		fsubmit=false;
	if(!validateCity())
		fsubmit=false;
	if(!validateState())
		fsubmit=false;
	if(!validateCountry())
		fsubmit=false;
	if(!validatePin())
		fsubmit=false;
	if(!validatePhone())
		fsubmit=false;
	if(!validateAgree())
		fsubmit=false;
		
	return fsubmit;
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
	
	<!-- Menu Bar -->
	<div style="position:relative; height:37px">
	<div class="greytop" style="z-index:3;left:0;right:0 "></div>
	<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
	<div class="titlelabel" style="left:5px;right:5px;top:3" >
	<table border="0" width="100%">
	<tr>
	<td><a href="index.php">Home</a></td>
	<td><a href="about.html">About</a></td>
	<td><a href="contact.html">Contact Us</a></td>
	</tr>
	</table>
	</div>
	</div>
	</div>
	</td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td> <!-- Content Section having menu section, Information relating to the page, Login Section -->
		<div style="position:relative;" >
				<div class="topleft"></div><div class="topright"></div><div class="left"></div><div class="right"></div><div class="bottom"></div><div class="bottomleft"></div><div class="bottomright"></div>
				<div class="title"><b class="titlelabel">New User Registeration</b></div>
				<div class="content" style="z-index:5 ">
				<p></p>
				<form method="post" action="register.php" onSubmit="return validateAll();">
				<table border="0" width="100%">
					<tr>
						<td align="right" width="25%">Username :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="username" id="username" onChange="isUserAvailable()" <?php if(!$first) echo "value='".$_POST['username']."'"?>><span id="divUsername">
						<?php 
						if(!$first)
							if(!$userA) 
						  		echo "<img src='images/error.png'>This username is not available. Select another username";
						?>
						<!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">Password :</td>
						<td align="left" style="left:5 " width="75%"><input type="password" name="password" id="password" onChange="validatePassword();confirmPassword()"><span id="divPassword">
						<?php 
						if(!$first)
							if(strlen($_POST[ 'password' ])>15)
								echo "<img src='images/error.png'>Password cannot be greater than 15 characters";
							else if(strlen($_POST[ 'password' ])<5)
								echo "<img src='images/error.png'>Password cannot be less than five";
						 ?>
						<!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">Confirm Password :</td>
						<td align="left" style="position:relative;left:5 " width="75%"><input type="password" id="cpassword" onChange="confirmPassword()"><span id="divCPassword"><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">&nbsp;</td>
						<td align="left" style="left:5 " width="75%">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" width="25%">Email Id :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="email" id="email" onChange="validateEmail();confirmEmail();" maxlength="60" <?php if(!$first) echo "value='".$_POST['email']."'"?>><span id="divEmail">
						<?php 
						if(!$first)
								 if(trim($_POST['email'])=='')
									echo "<img src='images/error.png'>An email address is required!";
								  else 
									if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email']))
										echo "<img src='images/error.png'>The e-mail you entered was not in the proper format!";
						?>
						<!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">Confirm Email Id :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" id="cemail" onChange="confirmEmail()" maxlength="60" <?php if(!$first) echo "value='".$_POST['email']."'"?>><span id="divCEmail"><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">&nbsp;</td>
						<td align="left" style="left:5 " width="75%">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" width="25%">Name :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="name" id="name" maxlength="50" onChange="validateName();" <?php if(!$first) echo "value='".$_POST['name']."'"?>><span id="divName">
						<?php 
						if(!$first)
							if(strlen($_POST['name'])==0)
								echo "<img src='images/error.png'>Enter your name";
						?>
						<!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">&nbsp;</td>
						<td align="left" style="left:5 " width="75%">&nbsp;</td>
					</tr>
					<tr>
					<th align="right">Address :</th>
					<td></td>
					</tr>
					<tr>
						<td align="right" width="25%">Line 1:</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="addl1" id="addl1" maxlength="100" onChange="validateAddl1();" <?php if(!$first) echo "value='".$_POST['addl1']."'"?>><span id="divAddl1">
						<?php 
						if(!$first)
							if(strlen($_POST['addl1'])==0)
								echo "<img src='images/error.png'>Line one cant be empty";
						?><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">Line 2 :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="addl2" id="addl2" maxlength="100" <?php if(!$first) echo "value='".$_POST['addl2']."'"?>><span id="divAddl2"><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">City :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="city" id="city" maxlength="50" onChange="validateCity();" <?php if(!$first) echo "value='".$_POST['city']."'"?>><span id="divCity">
						<?php 
						if(!$first)
							if(strlen($_POST[ 'city' ])==0)
								echo "<img src='images/error.png'>Enter your City";
						?><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">State :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="state" id="state" maxlength="50" onChange="validateState();" <?php if(!$first) echo "value='".$_POST['state']."'"?>><span id="divState">
						<?php 
						if(!$first)
							if(strlen($_POST[ 'state' ])==0)
								echo "<img src='images/error.png'>Enter your State";
						?><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">Country :</td>
						<td align="left" style="left:5 " width="75%">
						<select name="country" id="country" onChange="validateCountry();">
							  <option>Select a Country</option> 
							  <option value="Åland Islands">Åland Islands</option> 
							  <option value="Afghanistan">Afghanistan</option> 
							  <option value="Albania">Albania</option> 
							  <option value="Algeria">Algeria</option> 
							  <option value="American Samoa">American Samoa</option> 
							  <option value="Andorra">Andorra</option> 
							  <option value="Angola">Angola</option> 
							  <option value="Anguilla">Anguilla</option> 
							  <option value="Antarctica">Antarctica</option> 
							  <option value="Antigua And Barbuda">Antigua And Barbuda</option> 
							  <option value="Argentina">Argentina</option> 
							  <option value="Armenia">Armenia</option> 
							  <option value="Aruba">Aruba</option> 
							  <option value="Australia">Australia</option> 
							  <option value="Austria">Austria</option> 
							  <option value="Azerbaijan">Azerbaijan</option> 
							  <option value="Bahamas">Bahamas</option> 
							  <option value="Bahrain">Bahrain</option> 
							  <option value="Bangladesh">Bangladesh</option> 
							  <option value="Barbados">Barbados</option> 
							  <option value="Belarus">Belarus</option> 
							  <option value="Belgium">Belgium</option> 
							  <option value="Belize">Belize</option> 
							  <option value="Benin">Benin</option> 
							  <option value="Bermuda">Bermuda</option> 
							  <option value="Bhutan">Bhutan</option> 
							  <option value="Bolivia">Bolivia</option> 
							  <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
							  <option value="Botswana">Botswana</option> 
							  <option value="Bouvet Island">Bouvet Island</option> 
							  <option value="Brazil">Brazil</option> 
							  <option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
							  <option value="Brunei">Brunei</option> 
							  <option value="Bulgaria">Bulgaria</option> 
							  <option value="Burkina Faso">Burkina Faso</option> 
							  <option value="Burundi">Burundi</option> 
							  <option value="Cambodia">Cambodia</option> 
							  <option value="Cameroon">Cameroon</option> 
							  <option value="Canada">Canada</option> 
							  <option value="Cape Verde">Cape Verde</option> 
							  <option value="Cayman Islands">Cayman Islands</option> 
							  <option value="Central African Republic">Central African Republic</option> 
							  <option value="Chad">Chad</option> 
							  <option value="Chile">Chile</option> 
							  <option value="China">China</option> 
							  <option value="Christmas Island">Christmas Island</option> 
							  <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
							  <option value="Colombia">Colombia</option> 
							  <option value="Comoros">Comoros</option> 
							  <option value="Congo">Congo</option> 
							  <option value="Congo, Democractic Republic">Congo, Democractic Republic</option> 
							  <option value="Cook Islands">Cook Islands</option> 
							  <option value="Costa Rica">Costa Rica</option> 
							  <option value="Cote D'Ivoire (Ivory Coast)">Cote D'Ivoire (Ivory Coast)</option> 
							  <option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option> 
							  <option value="Cuba">Cuba</option> 
							  <option value="Cyprus">Cyprus</option> 
							  <option value="Czech Republic">Czech Republic</option> 
							  <option value="Denmark">Denmark</option> 
							  <option value="Djibouti">Djibouti</option> 
							  <option value="Dominica">Dominica</option> 
							  <option value="Dominican Republic">Dominican Republic</option> 
							  <option value="East Timor">East Timor</option> 
							  <option value="Ecuador">Ecuador</option> 
							  <option value="Egypt">Egypt</option> 
							  <option value="El Salvador">El Salvador</option> 
							  <option value="Equatorial Guinea">Equatorial Guinea</option> 
							  <option value="Eritrea">Eritrea</option> 
							  <option value="Estonia">Estonia</option> 
							  <option value="Ethiopia">Ethiopia</option> 
							  <option value="Falkland Islands (Islas Malvinas)">Falkland Islands (Islas Malvinas)</option> 
							  <option value="Faroe Islands">Faroe Islands</option> 
							  <option value="Fiji Islands">Fiji Islands</option> 
							  <option value="Finland">Finland</option> 
							  <option value="France">France</option> 
							  <option value="France, Metropolitan">France, Metropolitan</option> 
							  <option value="French Guiana">French Guiana</option> 
							  <option value="French Polynesia">French Polynesia</option> 
							  <option value="French Southern Territories">French Southern Territories</option> 
							  <option value="Gabon">Gabon</option> 
							  <option value="Gambia, The">Gambia, The</option> 
							  <option value="Georgia">Georgia</option> 
							  <option value="Germany">Germany</option> 
							  <option value="Ghana">Ghana</option> 
							  <option value="Gibraltar">Gibraltar</option> 
							  <option value="Greece">Greece</option> 
							  <option value="Greenland">Greenland</option> 
							  <option value="Grenada">Grenada</option> 
							  <option value="Guadeloupe">Guadeloupe</option> 
							  <option value="Guam">Guam</option> 
							  <option value="Guatemala">Guatemala</option> 
							  <option value="Guernsey">Guernsey</option> 
							  <option value="Guinea">Guinea</option> 
							  <option value="Guinea-Bissau">Guinea-Bissau</option> 
							  <option value="Guyana">Guyana</option> 
							  <option value="Haiti">Haiti</option> 
							  <option value="Heard and McDonald Islands">Heard and McDonald Islands</option> 
							  <option value="Honduras">Honduras</option> 
							  <option value="Hong Kong S.A.R.">Hong Kong S.A.R.</option> 
							  <option value="Hungary">Hungary</option> 
							  <option value="Iceland">Iceland</option> 
							  <option value="India">India</option> 
							  <option value="Indonesia">Indonesia</option> 
							  <option value="Iran">Iran</option> 
							  <option value="Iraq">Iraq</option> 
							  <option value="Ireland">Ireland</option> 
							  <option value="Isle of Man">Isle of Man</option> 
							  <option value="Israel">Israel</option> 
							  <option value="Italy">Italy</option> 
							  <option value="Jamaica">Jamaica</option> 
							  <option value="Japan">Japan</option> 
							  <option value="Jersey">Jersey</option> 
							  <option value="Jordan">Jordan</option> 
							  <option value="Kazakhstan">Kazakhstan</option> 
							  <option value="Kenya">Kenya</option> 
							  <option value="Kiribati">Kiribati</option> 
							  <option value="Korea">Korea</option> 
							  <option value="Korea, North">Korea, North</option> 
							  <option value="Kuwait">Kuwait</option> 
							  <option value="Kyrgyzstan">Kyrgyzstan</option> 
							  <option value="Laos">Laos</option> 
							  <option value="Latvia">Latvia</option> 
							  <option value="Lebanon">Lebanon</option> 
							  <option value="Lesotho">Lesotho</option> 
							  <option value="Liberia">Liberia</option> 
							  <option value="Libya">Libya</option> 
							  <option value="Liechtenstein">Liechtenstein</option> 
							  <option value="Lithuania">Lithuania</option> 
							  <option value="Luxembourg">Luxembourg</option> 
							  <option value="Macau S.A.R.">Macau S.A.R.</option> 
							  <option value="Macedonia">Macedonia</option> 
							  <option value="Madagascar">Madagascar</option> 
							  <option value="Malawi">Malawi</option> 
							  <option value="Malaysia">Malaysia</option> 
							  <option value="Maldives">Maldives</option> 
							  <option value="Mali">Mali</option> 
							  <option value="Malta">Malta</option> 
							  <option value="Marshall Islands">Marshall Islands</option> 
							  <option value="Martinique">Martinique</option> 
							  <option value="Mauritania">Mauritania</option> 
							  <option value="Mauritius">Mauritius</option> 
							  <option value="Mayotte">Mayotte</option> 
							  <option value="Mexico">Mexico</option> 
							  <option value="Micronesia">Micronesia</option> 
							  <option value="Moldova">Moldova</option> 
							  <option value="Monaco">Monaco</option> 
							  <option value="Mongolia">Mongolia</option> 
							  <option value="Montenegro">Montenegro</option> 
							  <option value="Montserrat">Montserrat</option> 
							  <option value="Morocco">Morocco</option> 
							  <option value="Mozambique">Mozambique</option> 
							  <option value="Myanmar">Myanmar</option> 
							  <option value="Namibia">Namibia</option> 
							  <option value="Nauru">Nauru</option> 
							  <option value="Nepal">Nepal</option> 
							  <option value="Netherlands">Netherlands</option> 
							  <option value="Netherlands Antilles">Netherlands Antilles</option> 
							  <option value="New Caledonia">New Caledonia</option> 
							  <option value="New Zealand">New Zealand</option> 
							  <option value="Nicaragua">Nicaragua</option> 
							  <option value="Niger">Niger</option> 
							  <option value="Nigeria">Nigeria</option> 
							  <option value="Niue">Niue</option> 
							  <option value="Norfolk Island">Norfolk Island</option> 
							  <option value="Northern Mariana Islands">Northern Mariana Islands</option> 
							  <option value="Norway">Norway</option> 
							  <option value="Oman">Oman</option> 
							  <option value="Pakistan">Pakistan</option> 
							  <option value="Palau">Palau</option> 
							  <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
							  <option value="Panama">Panama</option> 
							  <option value="Papua new Guinea">Papua new Guinea</option> 
							  <option value="Paraguay">Paraguay</option> 
							  <option value="Peru">Peru</option> 
							  <option value="Philippines">Philippines</option> 
							  <option value="Pitcairn Island">Pitcairn Island</option> 
							  <option value="Poland">Poland</option> 
							  <option value="Portugal">Portugal</option> 
							  <option value="Puerto Rico">Puerto Rico</option> 
							  <option value="Qatar">Qatar</option> 
							  <option value="Reunion">Reunion</option> 
							  <option value="Romania">Romania</option> 
							  <option value="Russia">Russia</option> 
							  <option value="Rwanda">Rwanda</option> 
							  <option value="Saint Helena">Saint Helena</option> 
							  <option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option> 
							  <option value="Saint Lucia">Saint Lucia</option> 
							  <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
							  <option value="Saint Vincent And The Grenadines">Saint Vincent And The Grenadines</option> 
							  <option value="Samoa">Samoa</option> 
							  <option value="San Marino">San Marino</option> 
							  <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
							  <option value="Saudi Arabia">Saudi Arabia</option> 
							  <option value="Senegal">Senegal</option> 
							  <option value="Serbia">Serbia</option> 
							  <option value="Seychelles">Seychelles</option> 
							  <option value="Sierra Leone">Sierra Leone</option> 
							  <option value="Singapore">Singapore</option> 
							  <option value="Slovakia">Slovakia</option> 
							  <option value="Slovenia">Slovenia</option> 
							  <option value="Solomon Islands">Solomon Islands</option> 
							  <option value="Somalia">Somalia</option> 
							  <option value="South Africa">South Africa</option> 
							  <option value="South Georgia And The South Sandwich Islands">South Georgia And The South Sandwich Islands</option> 
							  <option value="Spain">Spain</option> 
							  <option value="Sri Lanka">Sri Lanka</option> 
							  <option value="Sudan">Sudan</option> 
							  <option value="Suriname">Suriname</option> 
							  <option value="Svalbard And Jan Mayen Islands">Svalbard And Jan Mayen Islands</option> 
							  <option value="Swaziland">Swaziland</option> 
							  <option value="Sweden">Sweden</option> 
							  <option value="Switzerland">Switzerland</option> 
							  <option value="Syria">Syria</option> 
							  <option value="Taiwan">Taiwan</option> 
							  <option value="Tajikistan">Tajikistan</option> 
							  <option value="Tanzania">Tanzania</option> 
							  <option value="Thailand">Thailand</option> 
							  <option value="Timor-Leste">Timor-Leste</option> 
							  <option value="Togo">Togo</option> 
							  <option value="Tokelau">Tokelau</option> 
							  <option value="Tonga">Tonga</option> 
							  <option value="Trinidad And Tobago">Trinidad And Tobago</option> 
							  <option value="Tunisia">Tunisia</option> 
							  <option value="Turkey">Turkey</option> 
							  <option value="Turkmenistan">Turkmenistan</option> 
							  <option value="Turks And Caicos Islands">Turks And Caicos Islands</option> 
							  <option value="Tuvalu">Tuvalu</option> 
							  <option value="Uganda">Uganda</option> 
							  <option value="Ukraine">Ukraine</option> 
							  <option value="United Arab Emirates">United Arab Emirates</option> 
							  <option value="United Kingdom">United Kingdom</option> 
							  <option value="United States">United States</option> 
							  <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
							  <option value="Uruguay">Uruguay</option> 
							  <option value="Uzbekistan">Uzbekistan</option> 
							  <option value="Vanuatu">Vanuatu</option> 
							  <option value="Vatican City State (Holy See)">Vatican City State (Holy See)</option> 
							  <option value="Venezuela">Venezuela</option> 
							  <option value="Vietnam">Vietnam</option> 
							  <option value="Virgin Islands (British)">Virgin Islands (British)</option> 
							  <option value="Virgin Islands (US)">Virgin Islands (US)</option> 
							  <option value="Wallis And Futuna Islands">Wallis And Futuna Islands</option> 
							  <option value="WESTERN SAHARA">WESTERN SAHARA</option> 
							  <option value="Yemen">Yemen</option> 
							  <option value="Zambia">Zambia</option> 
							  <option value="Zimbabwe">Zimbabwe</option> 
						</select>

						<span id="divCountry">
						<?php 
						if(!$first)
							echo "<img src='images/error.png'>Select Country";
						?><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">Pin/Zip Code :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="pin" id="pin" maxlength="10" onChange="validatePin();" <?php if(!$first) echo "value='".$_POST['pin']."'"?>><span id="divPin">
						<?php
						if(!$first)
							if(strlen($_POST[ 'pin' ])==0)
								echo "<img src='images/error.png'>Enter your Pincode/Zip Code";
							else if(strlen($_POST[ 'pin' ])<2)
								echo "<img src='images/error.png'>Enter valid Pincode/Zip Code";
						?><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">&nbsp;</td>
						<td align="left" style="left:5 " width="75%">&nbsp;</td>
					</tr>
					<tr>
						<td align="right" width="25%">Phone Number :</td>
						<td align="left" style="left:5 " width="75%"><input type="text" name="phone" id="phone" maxlength="15" onChange="validatePhone();" <?php if(!$first) echo "value='".$_POST['phone']."'"?>><span id="divPhone">
						<?php 
						if(!$first)
							if(strlen($_POST[ 'phone' ])==0)
								echo "<img src='images/error.png'>Enter your Phone Number";
							else if(strlen($_POST[ 'phone' ])<5)
								echo "<img src='images/error.png'>Enter valid Phone Number";
						?><!--check--></span></td>
					</tr>
					<tr>
						<td align="right" width="25%">&nbsp;</td>
						<td align="left" style="left:5 " width="75%">&nbsp;</td>
					</tr>
					 <tr>
					 	<td></td>
						<td align="left"><input type="checkbox" value="agree" name="agree" id="agree" onClick="validateAgree()">I agree to the terms & Conditions of the site<span id="divAgree"><!--check--></span></td>
					  </tr>
					  <tr>
						<td colspan="2" align="center"><input type="submit" value="Register" name="register"></td>
					  </tr>
				</table>
				</form>
				</div>
		</div>
	</td>
  </tr>
</table>


<?php
}
else
{
	$user = pdoMap::get('user')->Create();
	$user->USERNAME=$_POST['username'];
	$user->PASSWORD=$_POST['password'];
	$user->TYPE="I";
	$user->Insert();
	//$user->User=pdoMap::get('internal_user')->Create();
	$user=pdoMap::get('user')->SelectBy("USERNAME",$user->USERNAME);
	$iuser=pdoMap::get('internal_user')->Create();
	$iuser->USER_ID=$user->current()->USER_ID;
	$iuser->NAME=$_POST['name'];
	$iuser->EMAIL=$_POST['email'];
	$iuser->ADDR_LINE1=$_POST['addl1'];
	$iuser->ADDR_LINE2=$_POST['addl2'];
	$iuser->ADDR_CITY=$_POST['city'];
	$iuser->ADDR_STATE=$_POST['state'];
	$iuser->ADDR_COUNTRY=$_POST['country'];
	$iuser->PIN=$_POST['pin'];
	$iuser->PHONE=$_POST['phone'];
	$iuser->Insert();
?>
<center>
<div style="position:relative; ">
						<div style="position:relative; height:37px;width:500px">
						<div class="topleft"></div><div class="topright"></div><div class="top"></div>
						<div class="title"></div>
						<div class="titlelabel" style="top:5px;left:10px "><b>User Successfully Created</b></div>
						<div class="bottom" style="left:0;right:0 "></div>
						</div>
						<div style="position:relative; height:37px;width:500px">
						<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
						<div class="titlelabel" style="left:5px;right:5px;top:3"><a href='index.php'>Login</a> to contine
						</div>
						</div>	</div></center>
<?php
}
pdoMap::cache()->closeSession();
?>

</body>
</html>
