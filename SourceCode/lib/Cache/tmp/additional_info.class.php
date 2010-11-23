<?php // GEN Additional_info AT 2010-04-15 00:05:22
interface IAdditional_infoAdapter {
}
class Additional_infoAdapterImpl
extends pdoMap_Mapping_Adapter
implements IAdditional_infoAdapter {
	public static $adapter = 'additional_info';
	public function __construct() {
		parent::__construct('additional_info');
	}
}
class Additional_infoEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('additional_info', $values);
	}
}
