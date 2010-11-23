<?php // GEN Additional_info AT 2010-04-15 00:05:22
$return = new pdoMap_Mapping_Metadata_Table('additional_info', 'additional_info', 'Additional_infoEntityImpl', 'IAdditional_infoAdapter');
$return->fields['ADD_INFO_ID'] = new pdoMap_Mapping_Metadata_Field(
'ADD_INFO_ID','ADD_INFO_ID',
'Primary',array (
));
$return->fields['CLASS_ID'] = new pdoMap_Mapping_Metadata_Field(
'CLASS_ID','CLASS_ID',
'Foreign',array (
  'adapter' => 'classified',
));
$return->fields['ADD_INFO_MASTER_ID'] = new pdoMap_Mapping_Metadata_Field(
'ADD_INFO_MASTER_ID','ADD_INFO_MASTER_ID',
'Foreign',array (
  'adapter' => 'additional_info_master',
));
$return->fields['INFO_VALUE'] = new pdoMap_Mapping_Metadata_Field(
'INFO_VALUE','INFO_VALUE',
'Char',array (
  'size' => '100',
));
$return->fields['INFO_TYPE'] = new pdoMap_Mapping_Metadata_Field(
'INFO_TYPE','INFO_TYPE',
'Char',array (
  'size' => '1',
));
return $return;
