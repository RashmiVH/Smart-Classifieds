<?php
$x=0;
$d=0;
$c=1;

$var = strtolower(@$_GET['q']);
$cat = @$_GET['Category'];
$cat1=array();


if ($var == "")
{
  echo "<p>Please enter a search...</p>";
  exit;
}

$con = mysql_connect("localhost","root","mysql"); 
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("sc", $con);

 
$array = array();
$array = explode(" ", $var);
$cnt=count($array);

$i=0;
$query1=array();
$matches=0;

if($cat!="")
{
$sql="";
	while($cnt!=0)
	{
		//echo $array[$i]; 
		echo "<br>";
		$query = mysql_query("select DISTINCT CLASS_ID from CLASSIFIED where CAT_ID='$cat'");  
		while($row = mysql_fetch_array($query))
		{
			/*echo "classid ";
			echo $row['CLASS_ID'];*/
			$r=$row['CLASS_ID'];
			$query2=mysql_query("select distinct CLASS_ID from (select CLASS_ID from additional_info where CLASS_ID ='$r' and INFO_VALUE like '%$array[$i]%' union select CLASS_ID from CLASSIFIED where CLASS_ID='$r' and title like '%$array[$i]%') as raja") or
				die("Error: ". mysql_error(). " with query ". $query2);

			while($classid = mysql_fetch_array($query2))
			{
						
						if($sql!="")
							$sql.=" UNION ";
						$r1=$classid['CLASS_ID'];
						$sql.="select * from CLASSIFIED where CLASS_ID =$r1 and EXPIRED=0";
			}
		}
		$i++;
		$cnt--;
	}

$sql="SELECT DISTINCT * FROM (" .$sql.") a";
$query1=mysql_query($sql);
//if( $query1) echo "<table border=1><th>Category Id</th><th>Int ID</th><th>Title</th><th>Type</th><th>Min value</th><th>Max value</th><th>Date</th><th>Expiry Date</th>";
			while($query1 && $result = mysql_fetch_array($query1))
			{
				//if($result['TYPE']=='S') echo "grey";
				?>
				<br>

				<div style="position:relative">
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>topleft"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>topright"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>left"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>right"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottom"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottomleft"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottomright"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>title"><b class="titlelabel"><a href="<?php if(!isset($username)) echo "javascript:alert('You should be a registered user to view a classified');"; else echo "view.php?class_id=".$result['CLASS_ID']; ?>"><?php echo $result['TITLE']; ?></a></b></div>
					<div class="content" style="z-index:5 ">
					<table width="100%">
					<tr><td width="30%"><a href="<?php if(!isset($username)) echo "javascript:alert('You should be a registered user to view a classified');"; else echo "view.php?class_id=".$result['CLASS_ID']; ?>"><img src="<?php echo $result['IMAGE']; ?>" width="50px"></a></td>
					<!-- <td><?php echo $result['TITLE']; ?></td></tr> -->
					<td><b>Minimum Value : &nbsp;Rs.&nbsp;<?php echo $result['MIN_VALUE']; ?>/-</b></td>
					<td><b>Maximum Value : &nbsp;Rs.&nbsp;<?php echo $result['MAX_VALUE']; ?>/-</b></td>
					<td><b>Expiry Date :&nbsp; &nbsp;<?php echo $result['EXP_DATE']; ?></b></td></tr>
					</table>
				</div>
				</div>
				
			<?php
				
			/*
				echo "<tr><td>".$result['CAT_ID']."</td>";

				echo "<td>".$result['INT_ID']."</td>";
				//echo "<br>";
				echo "<td>".$result['TITLE']."</td>";
				//echo "<br>";
				echo "<td>".$result['TYPE']."</td>";
				  //echo "<br>";
				  echo "<td>".$result['MIN_VALUE']."</td>";
				  //echo "<br>";
				  echo "<td>".$result['MAX_VALUE']."</td>";
				  //echo "<br>";
				  echo "<td>".$result['AD_DATE']."</td>";
				  //echo "<br>";
				  echo "<td>".$result['EXP_DATE']."</tr></td>";*/
					
		}
	if( $query1)	$matches = mysql_num_rows($query1);
	//if( $query1) echo "</table>";
	echo "<br>";


									

      //echo "Sorry, we can not find an entry to match your query<br><br>";
    
	
						
    //echo "<b>Searched For:</b> " .$_GET['q'];


}


else
{


$z=0;
$sql="";
while($cnt!=0)
{
		//echo $array[$i]; 
		echo "<br>";
		$query = mysql_query("select DISTINCT CLASS_ID from CLASSIFIED"); // where CAT_ID='$cat1[$z]'");  
		while($row = mysql_fetch_array($query))
		{
			$r=$row['CLASS_ID'];

			$query2=mysql_query("select distinct CLASS_ID from (select CLASS_ID from additional_info where CLASS_ID ='$r' and INFO_VALUE like '%$array[$i]%' union select CLASS_ID from CLASSIFIED where CLASS_ID='$r' and title like '%$array[$i]%') as raja")  or
				die("Error: ". mysql_error(). " with query ". $query2);
			
			while($classid = mysql_fetch_array($query2))
			{
				
				if($sql!="")
					$sql.=" UNION ";
				$r1=$classid['CLASS_ID'];
				$sql.="select * from CLASSIFIED where CLASS_ID =$r1 and EXPIRED=0" ;
			}
		}
		$i++;
		$cnt--;
}

		$sql="SELECT DISTINCT * FROM (" .$sql.") a";
		$query1=mysql_query($sql);
		//if( $query1) echo "<table border=1><th>Category Id</th><th>Int ID</th><th>Title</th><th>Type</th><th>Min value</th><th>Max value</th><th>Date</th><th>Expiry Date</th>";
		while($query1 && $result = mysql_fetch_array($query1))
		{
			?>
				<br>
				<div style="position:relative">
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>topleft"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>topright"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>left"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>right"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottom"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottomleft"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>bottomright"></div>
					<div class="<?php if($result['TYPE']=='S') echo "grey"; ?>title"><b class="titlelabel"><a href="<?php if(!isset($username)) echo "javascript:alert('You should be a registered user to view a classified');"; else echo "view.php?class_id=".$result['CLASS_ID']; ?>"><?php echo $result['TITLE']; ?></a></b></div>
					<div class="content" style="z-index:5 ">
					<table width="100%">
					<tr><td width="30%"><a href="<?php if(!isset($username)) echo "javascript:alert('You should be a registered user to view a classified');"; else echo "view.php?class_id=".$result['CLASS_ID']; ?>"><img src="<?php echo $result['IMAGE']; ?>" width="50px"></a></td>
					<!-- <td><?php echo $result['TITLE']; ?></td></tr> -->
					<td><b>Minimum Value : &nbsp;Rs.&nbsp;<?php echo $result['MIN_VALUE']; ?>/-</b></td>
					<td><b>Maximum Value : &nbsp;Rs.&nbsp;<?php echo $result['MAX_VALUE']; ?>/-</b></td>
					<td><b>Expiry Date :&nbsp; &nbsp;<?php echo $result['EXP_DATE']; ?></b></td></tr>
					</table>
				</div>
				

</div>
					
			<?php
		  //echo "<table><th><tr>Category Id</th></tr>";
		 /* echo "<tr><td>".$result['CAT_ID']."</td>";
		  //echo "<br>";
		  echo "<td>".$result['INT_ID']."</td>";
		  //echo "<br>";
		  echo "<td>".$result['TITLE']."</td>";
		  //echo "<br>";
		  echo "<td>".$result['TYPE']."</td>";
		  //echo "<br>";
		  echo "<td>".$result['MIN_VALUE']."</td>";
		  //echo "<br>";
		  echo "<td>".$result['MAX_VALUE']."</td>";
		  //echo "<br>";
		  echo "<td>".$result['AD_DATE']."</td>";
		  //echo "<br>";
		  echo "<td>".$result['EXP_DATE']."</tr></td>";
		  //echo "<br>";
		  //echo "<br>";*/
		
		}
	if($query1)	$matches = mysql_num_rows($query1);
 
echo "<br>";

		
									

      //echo "Sorry, we can not find an entry to match your query<br><br>";
    
	
						
    //echo "<b>Searched For:</b> " .$_GET['q'];
}

mysql_close($con);

echo "<h3>External Search<h3>";
		include "searchext.php";
$matches= $count + $matches;
echo "<br>";
if ($matches == 0)
	{?>
		<table align='center'>
		<tr><td>
		<center>
		<div style="position:relative; height:37px;width:500px">
		<div class="topleft"></div><div class="topright"></div><div class="top"></div>
		<div class="title"></div>
		<div class="titlelabel" style="top:5px;left:10px " align="center" >No Search results found!</b></div>
		<div class="bottom" style="left:0;right:0 "></div>
		</div>
<?php
									

      //echo "Sorry, we can not find an entry to match your query<br><br>";
    }
	else
	{
	?>
	
	<center>
		<div style="position:relative; height:37px;width:500px">
		<div class="topleft"></div><div class="topright"></div><div class="top"></div>
		<div class="title"></div>
		<div  style="position:absolute;top:5px;left:10px" ><b>Search returned <?php echo $matches; ?> results</b></div>
		<div class="bottom" style="left:0;right:0 "></div>
		</div>
	<?php
	}

?>
		<div style="position:relative; height:37px;width:500px">
		<div class="greyfooterleft"></div><div class="greyfooterright"></div><div class="greyfooter"></div>
		<div class="titlelabel" style="left:5px;right:5px;top:3"><b>Searched For:<?php echo $_GET['q']; ?></b>
		</div>
		</div> 
		
		</center>
		</td></tr></table>
		


					

