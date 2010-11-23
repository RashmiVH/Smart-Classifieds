<?php // GEN Classified AT 2010-04-15 00:05:22
$return = new pdoMap_Mapping_Metadata_Table('classified', 'classified', 'ClassifiedEntityImpl', 'IClassifiedAdapter');
$return->fields['CLASS_ID'] = new pdoMap_Mapping_Metadata_Field(
'CLASS_ID','CLASS_ID',
'Primary',array (
));
$return->fields['CAT_ID'] = new pdoMap_Mapping_Metadata_Field(
'CAT_ID','CAT_ID',
'Foreign',array (
  'adapter' => 'category_master',
));
$return->fields['INT_ID'] = new pdoMap_Mapping_Metadata_Field(
'INT_ID','INT_ID',
'Foreign',array (
  'adapter' => 'internal_user',
));
$return->fields['TITLE'] = new pdoMap_Mapping_Metadata_Field(
'TITLE','TITLE',
'Char',array (
  'size' => '50',
));
$return->fields['TYPE'] = new pdoMap_Mapping_Metadata_Field(
'TYPE','TYPE',
'Char',array (
  'size' => '1',
));
$return->fields['MIN_VALUE'] = new pdoMap_Mapping_Metadata_Field(
'MIN_VALUE','MIN_VALUE',
'Float',array (
));
$return->fields['MAX_VALUE'] = new pdoMap_Mapping_Metadata_Field(
'MAX_VALUE','MAX_VALUE',
'Float',array (
));
$return->fields['AD_DATE'] = new pdoMap_Mapping_Metadata_Field(
'AD_DATE','AD_DATE',
'Char',array (
  'size' => '1',
));
$return->fields['EXP_DATE'] = new pdoMap_Mapping_Metadata_Field(
'EXP_DATE','EXP_DATE',
'Char',array (
  'size' => '1',
));
$return->fields['EXPIRED'] = new pdoMap_Mapping_Metadata_Field(
'EXPIRED','EXPIRED',
'Integer',array (
  'size' => 'tiny',
));
$return->fields['IMAGE'] = new pdoMap_Mapping_Metadata_Field(
'IMAGE','IMAGE',
'Char',array (
  'size' => '50',
));
return $return;
