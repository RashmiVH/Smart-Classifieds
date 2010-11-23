<?php // GEN Category_master AT 2010-04-15 00:05:22
interface ICategory_masterAdapter {
}
class Category_masterAdapterImpl
extends pdoMap_Mapping_Adapter
implements ICategory_masterAdapter {
	public static $adapter = 'category_master';
	public function __construct() {
		parent::__construct('category_master');
	}
}
class Category_masterEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('category_master', $values);
	}
}
