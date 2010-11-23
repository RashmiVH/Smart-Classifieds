<?php // GEN Test AT 2010-04-14 04:56:09
$return = new pdoMap_Mapping_Metadata_Table('test', 'test', 'TestEntityImpl', 'ITestAdapter');
$return->fields['Id'] = new pdoMap_Mapping_Metadata_Field(
'Id','Id',
'Primary',array (
));
$return->fields['Name'] = new pdoMap_Mapping_Metadata_Field(
'Name','Name',
'Char',array (
  'size' => '64',
));
$return->fields['Value'] = new pdoMap_Mapping_Metadata_Field(
'Value','Value',
'Text',array (
  'null' => 'true',
));
return $return;
