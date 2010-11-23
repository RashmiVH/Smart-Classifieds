<?php // GEN Search AT 2010-04-15 00:05:22
$return = new pdoMap_Mapping_Metadata_Table('search', 'search', 'SearchEntityImpl', 'ISearchAdapter');
$return->fields['SEARCH_ID'] = new pdoMap_Mapping_Metadata_Field(
'SEARCH_ID','SEARCH_ID',
'Primary',array (
));
$return->fields['CLASS_ID'] = new pdoMap_Mapping_Metadata_Field(
'CLASS_ID','CLASS_ID',
'Foreign',array (
  'adapter' => 'classified',
));
$return->fields['INT_ID'] = new pdoMap_Mapping_Metadata_Field(
'INT_ID','INT_ID',
'Foreign',array (
  'adapter' => 'internal_user',
));
$return->fields['SEARCH_STRING'] = new pdoMap_Mapping_Metadata_Field(
'SEARCH_STRING','SEARCH_STRING',
'Text',array (
));
$return->fields['SEARCH_TIMESTAMP'] = new pdoMap_Mapping_Metadata_Field(
'SEARCH_TIMESTAMP','SEARCH_TIMESTAMP',
'Date',array (
));
return $return;
