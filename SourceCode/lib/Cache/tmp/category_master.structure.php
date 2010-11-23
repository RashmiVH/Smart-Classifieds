<?php // GEN Category_master AT 2010-04-15 00:05:22
$return = new pdoMap_Mapping_Metadata_Table('category_master', 'category_master', 'Category_masterEntityImpl', 'ICategory_masterAdapter');
$return->fields['CAT_ID'] = new pdoMap_Mapping_Metadata_Field(
'CAT_ID','CAT_ID',
'Primary',array (
));
$return->fields['CATEGORY_NAME'] = new pdoMap_Mapping_Metadata_Field(
'CATEGORY_NAME','CATEGORY_NAME',
'Char',array (
  'size' => '20',
));
$return->fields['COMMENTS'] = new pdoMap_Mapping_Metadata_Field(
'COMMENTS','COMMENTS',
'Text',array (
));
return $return;
