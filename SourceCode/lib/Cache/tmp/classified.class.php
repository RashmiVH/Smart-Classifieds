<?php // GEN Classified AT 2010-04-15 00:05:22
interface IClassifiedAdapter {
}
class ClassifiedAdapterImpl
extends pdoMap_Mapping_Adapter
implements IClassifiedAdapter {
	public static $adapter = 'classified';
	public function __construct() {
		parent::__construct('classified');
	}
}
class ClassifiedEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('classified', $values);
	}
}
