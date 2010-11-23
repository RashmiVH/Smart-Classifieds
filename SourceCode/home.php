<?php


$var = $username;
//$cat = @$_GET['Category'];




$con = mysql_connect("localhost","root","mysql"); 
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("sc", $con);

 $sql="";
$sql1=mysql_query("select USER_ID from User where USERNAME='$var'");
while($uid = mysql_fetch_array($sql1))
{
	/*echo $uid['USER_ID'];*/
	$a=$uid['USER_ID'];
	$sql2=mysql_query("select INT_ID from internal_user where USER_ID='$a'");
	while($intid = mysql_fetch_array($sql2))
	{
			$r=$intid['INT_ID'];
			if($sql!="")
				$sql.=" UNION ";
			$sql.="select * from CLASSIFIED where INT_ID =$r";
	} 
}
$sql="SELECT DISTINCT * FROM (" .$sql.") a";
$sql3=mysql_query($sql);
$f=true;
while($sql3 && $result=mysql_fetch_array($sql3))
{
		if($f) {echo "<hr><h2>My Classifieds</h2>"; $f=false;}
	//if($result['TYPE']=='S') echo "grey";
				?>
				

				<div style="position:relative">
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>topleft"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>topright"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>left"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>right"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottom"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottomleft"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottomright"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>title"><b class="titlelabel" ><a href="view.php?class_id=<?php echo $result['CLASS_ID']; ?>"><?php echo $result['TITLE']; ?> </a> - <?php if($result['TYPE']=='S') echo "Sell"; else echo "Buy"; ?> <a href="match.php?class_id=<?php echo $result['CLASS_ID']; ?>" style="position:relative;right:10;padding-left:10em ">Search for matches</a></b></div>
					<div class="content" style="z-index:5 ">
					<table width="100%">
					<tr><td width="30%"><a href="view.php?class_id=<?php echo $result['CLASS_ID']; ?>"><img src="<?php echo $result['IMAGE']; ?>" width="50px"></a></td>
					<!-- <td><?php echo $result['TITLE']; ?> </td></tr> -->
					<td><b>Minimum Value : &nbsp;Rs.&nbsp;<?php echo $result['MIN_VALUE']; ?>/-</b></td>
					<td><b>Maximum Value : &nbsp;Rs.&nbsp;<?php echo $result['MAX_VALUE']; ?>/-</b></td>
					<td><b>Expiry Date :&nbsp; &nbsp;<?php echo $result['EXP_DATE']; ?></b></td></tr>
					</table>
				</div>
				</div>
				<br>
			<?php
}

mysql_close($con);
?> 

