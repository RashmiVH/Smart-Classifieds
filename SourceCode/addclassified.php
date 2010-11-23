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

<script language="javascript">
function showError(id,msg)
{
	document.getElementById(id).innerHTML="<img src='images/error.png'>" + msg;
}

function success(id)
{
	document.getElementById(id).innerHTML="<img src='images/success.png'>";
}


var categoryAjax;
var info;
function getAdditionalInfo()
{
	if(categoryAjax.readyState==4)
		if(categoryAjax.status==200)
		{
			info=categoryAjax.responseText;
		 	//alert(info);
			info=eval(info);
			var table=document.getElementById('tableContainer');
			table.style.display="";
			table.innerHTML="";
			for(var i=0;i<info.length;i++)
			{
				var type=info[i].TYPE=="T"?"text":"file";
				var innerhtml="<td width='30%' align='right'>" + info[i].INFO_NAME + " : </td><td colspan=2 align='left'><input type='"+ type +"' name='" + info[i].INFO_NAME + "' title='"+ info[i].COMMENTS +"'>";
				//alert(innerhtml);
				if(info[i].MANDATORY==0) innerhtml+=" <a href='javascript:removeElement(\"tableContainer\",\"tr" +  info[i].INFO_NAME + "\")'><img src='images/remove.png' width='20px'></a>";
				innerhtml+="</td>";
				addElement("tableContainer","tr",innerhtml,"tr" + info[i].INFO_NAME)
			}
			
			//table.innerHTML='';
		}
}

function loadAdditionalInfo()
{
	var categoryS=document.getElementById("category");
	var category=categoryS[categoryS.selectedIndex].value;
	if(category=="other")
	{
		document.getElementById('trOtherCategory').style.display="";
		document.getElementById('tableContainer').innerHTML="";
	}
	else
	{
	//category="1";
		document.getElementById('trOtherCategory').style.display="none";
		categoryAjax= new XMLHttpRequest();
		categoryAjax.onreadystatechange=getAdditionalInfo;
		categoryAjax.open("get","loadAdditionalInfo.php?category="+category,true);
		categoryAjax.send();
	}
}

function addNewCustomElement()
{
	document.getElementById('tableCustom').style.display="";
	var numi = document.getElementById('theValue');
	var num = parseInt(numi.value)+1;
	numi.value = num;
	var innerhtml="<td width='30%' align='right'><a href='javascript:removeCustomElement(\""+ num + "\")'><img src='images/remove.png' width='20px' align='left'></a><input type='text' name='customField" +  num + "' id='customField" +  num + "'> : </td><td align='left'><input type='text' name='customValue" + num + "' id='customValue" + num + "'><td align='left'><select name='customType" + num + "' id='customType" + num + "' onChange='changeInput(\"customType" + num + "\",\"customValue"+ num +"\")'><option value='text'>text</option><option value='image'>image</option><option value='file'>Other File</option></select></td><td><textarea name='customComment" + num + "' id='customComment" + num + "'></textarea></td>";
	addElement('tableCustom',"tr",innerhtml,"trCustom"+num);
}

function removeCustomElement(num)
{
	var numi = document.getElementById('theValue');
	if(confirm('You are about to delete ' + document.getElementById('customField' + num).value + '. This cannot be undone.\nAre you sure want to delete it?'))
	{
		removeElement('tableCustom',"trCustom"+num);
		for(var i=num;i<numi.value;i++)
		{
			document.getElementById('customField' + (parseInt(i)+1)).name='customField' + i;
			document.getElementById('customValue' + (parseInt(i)+1)).name='customValue' + i;
			document.getElementById('customType' + (parseInt(i)+1)).name='customType' + i;
			document.getElementById('customComment' + (parseInt(i)+1)).name='customComment' + i;
			document.getElementById('customField' + (parseInt(i)+1)).id='customField' + i;
			document.getElementById('customValue' + (parseInt(i)+1)).id='customValue' + i;
			document.getElementById('customType' + (parseInt(i)+1)).id='customType' + i;
			document.getElementById('customComment' + (parseInt(i)+1)).id='customComment' + i;
		}
		numi.value = numi.value-1;
		//if(numi.value==0) 	document.getElementById('tableCustom').style.display="none";
	}
	
}
function changeInput(typeId,inputId)
{
	if(document.getElementById(typeId).value=="text")
		changeInputType(inputId,"text");
	else
		changeInputType(inputId,"file");
}
//*************************************

function addElement(parent,element,innerhtml,divIdName) {
  var ni = document.getElementById(parent);
  var newdiv = document.createElement(element);
  //var divIdName = 'my'+num+'td';
  newdiv.setAttribute('id',divIdName);
  //'<input type="text" name="author" id="divauthor"> <a href=\'javascript:removeElement('+divIdName+')\'>x "'+divIdName+'"</a>'
  newdiv.innerHTML = innerhtml;
  ni.appendChild(newdiv);
}

function removeElement(parent,divNum) {
  var d = document.getElementById(parent);
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}

function changeInputType(inputId,type)
{
	var old=document.getElementById(inputId);
	var newI=document.createElement('input');
	newI.type=type;
	for(var property in old)
		if(property!="type")
		{
			try
			{
			newI[property]=old[property];
			}
			catch(e)
			{}
			//if(property=='value') alert(old[property]);
		}
	var pElement=old.parentNode;
	pElement.removeChild(old);
	pElement.appendChild(newI);
}

function validate()
{
	var frm=document.forms.addClassified;
	var frmsubmit=true;
	var str="";
	if(!frm.type[0].checked && !frm.type[1].checked){str="Type\n";  frmsubmit=false;}
	for(var i=0;i<frm.length;i++)
	{
		if(frm[i].type=='text' && frm[i].value=="")
		{
			if(frm[i].name=='newCategory' && frm.category[frm.category.selectedIndex].value!='other' ) continue;
				str+=" "+frm[i].name+"\n";
				frmsubmit=false;
				//break;
		}
		else if(frm[i].type=='file' && frm[i].value=="")
		{
			str+=" "+frm[i].name+"\n";
			frmsubmit=false;
			//break;
		}
	}
	if(frm.category.selectedIndex==0){ str+=" Category"; frmsubmit=false;}
	if(!frmsubmit) alert("You have not filled "+ str +". \nIf a field is not mandatory then delete that field.\nIf there is no delete link is there then its mandatory field");
	return frmsubmit;
}

//***********************************

</script>

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
 <form method="POST" name="addClassified" action="upload.php" enctype="multipart/form-data" onSubmit="return validate();">

<div style="position:relative;top:20;left:50;right:50;">
<div class="topleft"></div><div class="topright"></div><div class="left"></div><div class="right"></div><div class="bottom"></div><div class="bottomleft"></div><div class="bottomright"></div>
<div class="title"><b class="titlelabel">Add New Classified1</b></div>

					<table border="0" width="100%" class="content">
						<tr>
							<td align="right" width="30%">Title :</td>
							<td align="left" style="left:5; " colspan="2" width="70%"><input type="text" name="title" id="title"><span id="divTitle"><!--check--></span></td>
						</tr>
						<tr>
							<td align="right" width="30%">Type :</td>
							<td align="left" style="left:5; " width="25%" colspan="2"><input type="radio" name="type" value="sell">Sell &nbsp; &nbsp; <input type="radio" name="type" value="buy">Buy &nbsp; &nbsp; <span id="divType"><!--check--></span></td>
						</tr>
						<tr>
							<td align="right" width="30%">Upload Image :</td>
							<td align="left" style="left:5 " width="70%" colspan="2"><input type="file" name="image" id="image"><span id="divImage"><!--check--></span></td>
						</tr>
						<tr><td colspan="3"></td></tr>
						<tr>
							<td align="right" width="30%">Category :</td>
							<td align="left" style="position:relative;left:5 " colspan="2" width="70%">
							<select name="category" id="category" onChange="loadAdditionalInfo();">
								<option value="">Select a Category</option>
								<?php echo $ret;?>
								<option value="other">Other</option>
							</select>
							<input type="hidden" value="0" id="theValue" />
							<span id="divCategory"><!--check--></span></td>
						</tr>
						<tr id="trOtherCategory" style="display:none "><td align="right" width="30%">Specify new category :</td><td><input type="text" name="newCategory" id='newCategory'></td><td><textarea name="newCategoryComment"></textarea></td></tr>
						<tr>
							<td colspan="3" width="100%">
								<table id="tableContainer" width="100%" style="display:none" border="0">
									
								</table>
							</td>
						</tr>
						<tr><td align="right"><h2>Custom Fields</h2></td><td><a href="javascript:addNewCustomElement();"><img src='images/add.png' width='20px' style="position:relative;left:30px"></a></td><td></td></tr>
						<tr>
							<td colspan="3" width="100%">
								<table id="tableCustom" width="100%" style="display:none" border="0">
									<tr><th width="30%" align="center">Field Name</th><th>Value</th><th title="Select whether it is a text field or image or other file">Type</th><th>Comments</th></tr>
								</table>
							</td>
						</tr>
						<tr>
							<td align="right" width="30%">Minimum Value :</td>
							<td align="left" style="left:5;" width="70%" colspan="2"><input type="text" name="min" id="min"><span id="divMin"><!--check--></span></td>
						</tr>
						<tr>
							<td align="right" width="30%">Maximum Value :</td>
							<td align="left" style="left:5;" width="70%" colspan="2"><input type="text" id="max" name="max"><span id="divMax"><!--check--></span></td>
						</tr>
						
						<tr>
							<td colspan="3" align="right">All values are in Indian Rupees</td>
						</tr>
						<tr>
							<td align="right" width="30%">&nbsp;</td>
							<td align="left" style="left:5;" width="70%" colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td align="right" width="30%">Valid From :</td>
							<td align="left" style="left:5 " width="70%" colspan="2"><input type="text" name="validfrom" id="validfrom"><span id="divValidFrom"><!--check--></span></td>
						</tr>
						<tr>
							<td align="right" width="30%">Valid To :</td>
							<td align="left" style="left:5 " width="70%" colspan="2"><input type="text" name="validto" id="validto"><span id="divValidTo"><!--check--></span></td>
						</tr>
						<tr>
							<td align="right" width="30%">&nbsp;</td>
							<td align="left" style="left:5 " width="70%" colspan="2">&nbsp;</td>
						</tr>
						
						  <tr>
							<td colspan="3" align="center"><input type="submit" value="Add Classified" name="register"></td>
						  </tr>
					</table>
</div>

</form>
<?php
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
