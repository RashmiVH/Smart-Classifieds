

<?php
// Include RAP
define("RDFAPI_INCLUDE_DIR", "rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RDFAPI.php");

// Filename of an RDF document
//$base="rdfapi-php/doc/example1.rdf";
$base="classified.owl";
$instance="http://localhost/SC/extsearch.php?q=" . $_GET['q'];
include "getrdf.php";
$ext_url="http://localhost/SC";
// Create a new MemModel
$model = ModelFactory::getDefaultModel();
$imodel=ModelFactory::getDefaultModel();
// Load and parse document
set_time_limit(0);
$model->load($base);
$imodel->loadFromString($text,"rdf");



$classified = new Resource("http://localhost/SC/classified.owl#Classified");
$subclass= new Resource("http://www.w3.org/2000/01/rdf-schema#subClassOf");
$type=new Resource("http://www.w3.org/1999/02/22-rdf-syntax-ns#type");
$domain=new Resource("http://www.w3.org/2000/01/rdf-schema#domain");
$class=new Resource("http://www.w3.org/2002/07/owl#Class");
$property=new Resource("http://www.w3.org/2002/07/owl#DatatypeProperty");
//$res = $model->find(NULL, $domain, $classified);
$category=$model->find(NULL,$subclass,$classified); //getting all category type
$i=0;

foreach($category->triples as $statement)
{
 //to get any instances are there? Actually the output will be the triplets having the type of the catergory
 $res = $imodel->find(NULL, $type, new Resource($statement->getSubject()->getNamespace().$statement->getSubject()->getLocalname()));

 if($res->size()>0)
 {
 
 	foreach($res->triples as $instances)
	{
		$classifieds[$i]['id'] = $instances->getSubject()->getLocalName();
		$classifieds[$i]['category']= $statement->getSubject()->getLocalname();
		
		//to get all the attributes of the instance. It also returns the fact that its a type of the category
		$ins=$imodel->find(new Resource(strtolower($instances->getSubject()->getNamespace()).$instances->getSubject()->getLocalname()),NULL,NULL);
		foreach($ins->triples as $attributes)
		{
			if($attributes->getPredicate()->getLocalName()!="type")
			{
				$classifieds[$i][$attributes->getPredicate()->getLocalName()]= $attributes->getObject()->getLabel();
			}
		}
		
			$i++;
	}
 }
 //$res->writeAsHtmlTable();
}
if(isset($classifieds))
 	foreach($classifieds as $ad)
	{
		$title=$ad['Title'];
		$minvalue=$ad['MinValue'];
		if(isset($ad['MaxValue']))$maxvalue=$ad['MaxValue']; else $maxvalue=$ad['MinValue'];
		$ctype=$ad['ClassifiedType'];
		$classid=$ad['id'];
		$category=$ad['category'];
		$expdate=substr($ad['ValidTill'],0,10);
		if($ad['Image']!='none')$image=$ext_url.$ad['Image']; else $image='';
	?>
	<br>

				<div style="position:relative">
					<div class="<?php if($ctype=='Sell') echo "grey"; ?>topleft"></div>
					<div class="<?php if($ctype=='Sell') echo "grey"; ?>topright"></div>
					<div class="<?php if($ctype=='Sell') echo "grey"; ?>left"></div>
					<div class="<?php if($ctype=='Sell') echo "grey"; ?>right"></div>
					<div class="<?php if($ctype=='Sell') echo "grey"; ?>bottom"></div>
					<div class="<?php if($ctype=='Sell') echo "grey"; ?>bottomleft"></div>
					<div class="<?php if($ctype=='Sell') echo "grey"; ?>bottomright"></div>
					<div class="<?php if($ctype=='Sell') echo "grey"; ?>title"><b class="titlelabel"><a href="viewext.php?class_id=<?php echo $classid; ?>"><?php echo $title; ?></a> - <?php echo $category; ?> </b></div>
					<div class="content" style="z-index:5 ">
					<table width="100%">
					<tr><td width="30%"><a href="view.php?class_id=<?php echo $classid; ?>"><img src="<?php echo $image; ?>" width="50px"></a></td>
					
					<td><b>Minimum Value : &nbsp;Rs.&nbsp;<?php echo $minvalue; ?>/-</b></td>
					<td><b>Maximum Value : &nbsp;Rs.&nbsp;<?php echo $maxvalue; ?>/-</b></td>
					<td><b>Expiry Date :&nbsp; &nbsp;<?php echo $expdate; ?></b></td></tr>
					</table>
				</div>
				</div>
	<?php
		
	}
			
$count=$i;
?>
