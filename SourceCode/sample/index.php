<?php
// Include RAP
define("RDFAPI_INCLUDE_DIR", "rdfapi-php/api/");
include(RDFAPI_INCLUDE_DIR . "RDFAPI.php");

// Filename of an RDF document
//$base="rdfapi-php/doc/example1.rdf";
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
/*
// Ceate new statements and add them to the model
$statement1 = new Statement(new Resource($instBaseNS . "book1"),
				  		    $type,
					  		new Resource($instSCNS . "Book"));
					  
$imodel->add($statement1);

$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "Author"),
					  		new Literal("Karthikeyan"));
$imodel->add($statement2);

$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "BookName"),
					  		new Literal("How to tie a tie"));
$imodel->add($statement2);
$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "BookType"),
					  		new Literal("Computer Science"));
$imodel->add($statement2);
$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "ClassifiedDate"),
					  		new Literal("2010-04-11T00:00:00",NULL, "http://www.w3.org/2001/XMLSchema#dateTime"));
$imodel->add($statement2);

$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "ClassifiedType"),
					  		new Literal("Sell"));
$imodel->add($statement2);
$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "Image"),
					  		new Literal("none"));
$imodel->add($statement2);						
$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "MinValue"),
					  		new Literal("200",NULL,"http://www.w3.org/2001/XMLSchema#float"));
$imodel->add($statement2);
$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "Title"),
					  		new Literal("Dont know to tie a tie?"));
$imodel->add($statement2);

$statement2 = new Statement(new Resource($instBaseNS . "book1"),
					  		new Resource($instSCNS . "ValidTill"),
					  		new Literal("2011-04-11T00:00:00",NULL, "http://www.w3.org/2001/XMLSchema#dateTime"));
$imodel->add($statement2);
*/
echo $imodel->writeRdfToString();

?>
