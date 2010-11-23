<?php // GEN External_system AT 2010-04-15 00:05:22
$return = new pdoMap_Mapping_Metadata_Table('external_system', 'external_system', 'External_systemEntityImpl', 'IExternal_systemAdapter');
$return->fields['EXT_ID'] = new pdoMap_Mapping_Metadata_Field(
'EXT_ID','EXT_ID',
'Primary',array (
));
$return->fields['USER_ID'] = new pdoMap_Mapping_Metadata_Field(
'USER_ID','USER_ID',
'Foreign',array (
  'adapter' => 'user',
));
$return->fields['URL'] = new pdoMap_Mapping_Metadata_Field(
'URL','URL',
'Text',array (
));
return $return;
