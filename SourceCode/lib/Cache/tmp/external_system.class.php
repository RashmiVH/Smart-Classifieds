<?php // GEN External_system AT 2010-04-15 00:05:22
interface IExternal_systemAdapter {
}
class External_systemAdapterImpl
extends pdoMap_Mapping_Adapter
implements IExternal_systemAdapter {
	public static $adapter = 'external_system';
	public function __construct() {
		parent::__construct('external_system');
	}
}
class External_systemEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('external_system', $values);
	}
}
