<?php

// Include RAP
define("RDFAPI_INCLUDE_DIR", "rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RDFAPI.php");

// Filename of an RDF document
$base="classified.owl";
$instance="instance.owl";
// Create a new MemModel
$model = ModelFactory::getDefaultModel();
$imodel=ModelFactory::getDefaultModel();
// Load and parse document
$model->load($base);
$imodel->load($instance);
set_time_limit(0);

// Output model as HTML table
//$imodel->writeAsHtmlTable();
$classified = new Resource("http://localhost/SC/classified.owl#Classified");
$subclass= new Resource("http://www.w3.org/2000/01/rdf-schema#subClassOf");
$type=new Resource("http://www.w3.org/1999/02/22-rdf-syntax-ns#type");
$domain=new Resource("http://www.w3.org/2000/01/rdf-schema#domain");
$class=new Resource("http://www.w3.org/2002/07/owl#Class");
$property=new Resource("http://www.w3.org/2002/07/owl#DatatypeProperty");

$instBaseNS=$imodel->findFirstMatchingStatement(NULL,NULL,NULL)->getSubject()->getURI() . "#";
$instSCNS="http://localhost/SC/classified.owl#";



$x=0;
$d=0;
$c=1;

$var = strtolower(@$_GET['q']);
$array = array();
$array = explode(" ", $var);
$cnt=count($array);
$con = mysql_connect("localhost","root","mysql"); 
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("sc", $con);


$i=0;

$matches=0;

$sql="";
while($cnt!=0)
	{
		$query = mysql_query("select DISTINCT CLASS_ID from CLASSIFIED");  
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
while($query1 && $result = mysql_fetch_array($query1))
{
		
		switch ($result['CAT_ID'])
		{
			case 1:
				$category="Book";
				break;
			case 2:
				$category="Cars";
				break;
			case 3:
				$category="Computer";
				break;
			case 4:
				$category="Mobile";
				break;
			case 5:
				$category="Real_Estate";
				break;
			default:
				$category="Other";
		}
		//echo $category."<br>";
		$statement1 = new Statement(new Resource($instBaseNS . "SA".$result['CLASS_ID']),
				  		    $type,
					  		new Resource($instSCNS . $category));
		$imodel->add($statement1);
		$statement2 = new Statement(new Resource($instBaseNS . "SA".$result['CLASS_ID']),
									new Resource($instSCNS . "ClassifiedDate"),
									new Literal($result['AD_DATE']."T00:00:00",NULL, "http://www.w3.org/2001/XMLSchema#dateTime"));
		$imodel->add($statement2);
		
		$statement2 = new Statement(new Resource($instBaseNS . "SA".$result['CLASS_ID']),
									new Resource($instSCNS . "ClassifiedType"),
									new Literal($result['TYPE']=='S'?"Sell":"Buy"));
		$imodel->add($statement2);
		$statement2 = new Statement(new Resource($instBaseNS . "SA".$result['CLASS_ID']),
									new Resource($instSCNS . "Image"),
									new Literal($result['IMAGE']));
		$imodel->add($statement2);						
		$statement2 = new Statement(new Resource($instBaseNS . "SA".$result['CLASS_ID']),
									new Resource($instSCNS . "MinValue"),
									new Literal($result['MIN_VALUE'],NULL,"http://www.w3.org/2001/XMLSchema#float"));
		$imodel->add($statement2);
		$statement2 = new Statement(new Resource($instBaseNS . "SA".$result['CLASS_ID']),
									new Resource($instSCNS . "MaxValue"),
									new Literal($result['MAX_VALUE'],NULL,"http://www.w3.org/2001/XMLSchema#float"));
		$imodel->add($statement2);
		$statement2 = new Statement(new Resource($instBaseNS . "SA".$result['CLASS_ID']),
									new Resource($instSCNS . "Title"),
									new Literal($result['TITLE']));
		$imodel->add($statement2);
		
		$statement2 = new Statement(new Resource($instBaseNS . "SA".$result['CLASS_ID']),
									new Resource($instSCNS . "ValidTill"),
									new Literal($result['EXP_DATE']."T00:00:00",NULL, "http://www.w3.org/2001/XMLSchema#dateTime"));
		$imodel->add($statement2);
		
}



mysql_close($con);
echo $imodel->writeRdfToString();
?>


					

