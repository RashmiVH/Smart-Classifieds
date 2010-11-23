<?php // GEN Additional_info_master AT 2010-04-16 17:21:08
interface IAdditional_info_masterAdapter {
}
class Additional_info_masterAdapterImpl
extends pdoMap_Mapping_Adapter
implements IAdditional_info_masterAdapter {
	public static $adapter = 'additional_info_master';
	public function __construct() {
		parent::__construct('additional_info_master');
	}
}
class Additional_info_masterEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('additional_info_master', $values);
	}
}
