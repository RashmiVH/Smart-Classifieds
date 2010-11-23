<?php // GEN Additional_info_master AT 2010-04-16 17:21:08
$return = new pdoMap_Mapping_Metadata_Table('additional_info_master', 'additional_info_master', 'Additional_info_masterEntityImpl', 'IAdditional_info_masterAdapter');
$return->fields['ADD_INFO_MASTER_ID'] = new pdoMap_Mapping_Metadata_Field(
'ADD_INFO_MASTER_ID','ADD_INFO_MASTER_ID',
'Primary',array (
));
$return->fields['CAT_ID'] = new pdoMap_Mapping_Metadata_Field(
'CAT_ID','CAT_ID',
'Foreign',array (
  'adapter' => 'category_master',
));
$return->fields['INFO_NAME'] = new pdoMap_Mapping_Metadata_Field(
'INFO_NAME','INFO_NAME',
'Char',array (
  'size' => '20',
));
$return->fields['MANDATORY'] = new pdoMap_Mapping_Metadata_Field(
'MANDATORY','MANDATORY',
'Integer',array (
  'size' => 'tiny',
));
$return->fields['TYPE'] = new pdoMap_Mapping_Metadata_Field(
'TYPE','TYPE',
'Char',array (
  'size' => '1',
));
$return->fields['COMMENTS'] = new pdoMap_Mapping_Metadata_Field(
'COMMENTS','COMMENTS',
'Text',array (
  'null' => 'true',
));
return $return;
