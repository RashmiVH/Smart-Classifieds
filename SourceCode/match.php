
<?php


$other="match";
include "index.php";
$con = mysql_connect("localhost","root","mysql"); 
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("sc", $con);

 $var=$_GET['class_id'];
$sql1=mysql_query("Select CAT_ID,TYPE,CLASS_ID from classified where CLASS_ID=$var");
//echo $sql1;
if($row = mysql_fetch_array($sql1))
{
	
	$cat_id=$row['CAT_ID'];
	$type=$row['TYPE'];
	$class_id=$row['CLASS_ID'];
	//echo $cat_id." ".$type." ".$class_id;
	
}
if($type == 'B')
$type1='S';
else
$type1='B';

$sql="SELECT * FROM (Select  CLASS_ID, count(CLASS_ID) 'MATCH' from 
        (Select A.Class_id 'CLASS_ID',ADD_INFO_MASTER_ID,INFO_VALUE from 
               (Select Class_id from classified where cat_id=$cat_id and type='".$type1."' and expired=0) A,
                additional_info B 
                         where A.class_id=B.class_id) C,
        (Select ADD_INFO_MASTER_ID,INFO_VALUE 'ACTUAL' from additional_info where class_id=$class_id) D
          where C.ADD_INFO_MASTER_ID=D.ADD_INFO_MASTER_ID AND lower(C.INFO_VALUE)=lower(ACTUAL) group by CLASS_ID) M ORDER BY M.MATCH DESC";
//$sql="SELECT * FROM (Select  CLASS_ID, count(CLASS_ID) 'MATCH' from (Select A.Class_id 'CLASS_ID',ADD_INFO_MASTER_ID,INFO_VALUE from (Select Class_id from classified where cat_id=8 and type='S' and expired=0) A, additional_info B where A.class_id=B.class_id) C, (Select ADD_INFO_MASTER_ID,INFO_VALUE 'ACTUAL' from additional_info where class_id=19) D where C.ADD_INFO_MASTER_ID=D.ADD_INFO_MASTER_ID AND lower(C.INFO_VALUE)=lower(ACTUAL) group by CLASS_ID) M ORDER BY M.MATCH DESC";
		  echo $sql;
$sql2=mysql_query($sql);
	
	while($sql2 && $row1=mysql_fetch_array($sql2))
	{
		
			$class_id=$row1['CLASS_ID'];
			$sql3=mysql_query("Select * from classified where CLASS_ID=$class_id");
			if($result=mysql_fetch_array($sql3))
			{
			
			
				?>
				

				<div style="position:relative">
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>topleft"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>topright"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>left"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>right"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottom"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottomleft"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottomright"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>title"><b class="titlelabel"><a href="view.php?class_id=<?php echo $result['CLASS_ID']; ?>"><?php echo $result['TITLE']; ?> </a> - <?php if($result['TYPE']=='S') echo "Sell"; else echo "Buy"; ?></b></div>
					<div class="content" style="z-index:5 ">
					<table width="100%">
					<tr><td width="30%"><a href="view.php?class_id=<?php echo $result['CLASS_ID']; ?>"><img src="<?php echo $result['../../IMAGE']; ?>" width="50px"></a></td>
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
			

}
if(mysql_num_rows($sql2)==0)
{
?>
<center>
<div style="position:relative; ">
<div style="position:relative; height:37px;width:500px">
<div class="topleft"></div><div class="topright"></div><div class="top"></div>
<div class="title"></div>
<div class="titlelabel" style="top:5px;left:10px ">No matches found!</b></div>
<div class="bottom" style="left:0;right:0 "></div>
</div>
<div style="position:relative; height:37px;width:500px">
<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
<div class="titlelabel" style="left:5px;right:5px;top:3">
</div>
</div>
</div>
</center>
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
<div class="titlelabel" style="top:5px;left:10px "><?php echo mysql_num_rows($sql2) ?> matches found!</b></div>
<div class="bottom" style="left:0;right:0 "></div>
</div>
<div style="position:relative; height:37px;width:500px">
<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
<div class="titlelabel" style="left:5px;right:5px;top:3">
</div>
</div>
</div>
</center>
<?php
}
mysql_close($con);
?> 
</body>
</html>
