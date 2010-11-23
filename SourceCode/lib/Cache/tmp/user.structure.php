<?php // GEN User AT 2010-04-15 00:12:20
$return = new pdoMap_Mapping_Metadata_Table('user', 'user', 'UserEntityImpl', 'IUserAdapter');
$return->fields['USER_ID'] = new pdoMap_Mapping_Metadata_Field(
'user_id','USER_ID',
'Primary',array (
));
$return->fields['USERNAME'] = new pdoMap_Mapping_Metadata_Field(
'username','USERNAME',
'Char',array (
  'size' => '15',
));
$return->fields['PASSWORD'] = new pdoMap_Mapping_Metadata_Field(
'password','PASSWORD',
'Char',array (
  'size' => '15',
));
$return->fields['TYPE'] = new pdoMap_Mapping_Metadata_Field(
'type','TYPE',
'Char',array (
  'size' => '1',
));
return $return;
