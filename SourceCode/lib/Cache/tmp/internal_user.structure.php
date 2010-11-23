<?php // GEN Internal_user AT 2010-04-15 00:12:21
$return = new pdoMap_Mapping_Metadata_Table('internal_user', 'internal_user', 'Internal_userEntityImpl', 'IInternal_userAdapter');
$return->fields['INT_ID'] = new pdoMap_Mapping_Metadata_Field(
'INT_ID','INT_ID',
'Primary',array (
));
$return->fields['USER_ID'] = new pdoMap_Mapping_Metadata_Field(
'USER_ID','USER_ID',
'Foreign',array (
  'adapter' => 'user',
));
$return->fields['NAME'] = new pdoMap_Mapping_Metadata_Field(
'NAME','NAME',
'Char',array (
  'size' => '50',
));
$return->fields['EMAIL'] = new pdoMap_Mapping_Metadata_Field(
'EMAIL','EMAIL',
'Char',array (
  'size' => '60',
));
$return->fields['ADDR_LINE1'] = new pdoMap_Mapping_Metadata_Field(
'ADDR_LINE1','ADDR_LINE1',
'Char',array (
  'size' => '100',
));
$return->fields['ADDR_LINE2'] = new pdoMap_Mapping_Metadata_Field(
'ADDR_LINE2','ADDR_LINE2',
'Char',array (
  'size' => '100',
  'null' => 'true',
));
$return->fields['ADDR_CITY'] = new pdoMap_Mapping_Metadata_Field(
'ADDR_CITY','ADDR_CITY',
'Char',array (
  'size' => '50',
));
$return->fields['ADDR_STATE'] = new pdoMap_Mapping_Metadata_Field(
'ADDR_STATE','ADDR_STATE',
'Char',array (
  'size' => '50',
));
$return->fields['ADDR_COUNTRY'] = new pdoMap_Mapping_Metadata_Field(
'ADDR_COUNTRY','ADDR_COUNTRY',
'Char',array (
  'size' => '50',
));
$return->fields['PIN'] = new pdoMap_Mapping_Metadata_Field(
'PIN','PIN',
'Char',array (
  'size' => '10',
));
$return->fields['PHONE'] = new pdoMap_Mapping_Metadata_Field(
'PHONE','PHONE',
'Char',array (
  'size' => '15',
));
return $return;
