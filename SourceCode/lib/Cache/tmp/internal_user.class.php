<?php // GEN Internal_user AT 2010-04-15 00:12:21
interface IInternal_userAdapter {
}
class Internal_userAdapterImpl
extends pdoMap_Mapping_Adapter
implements IInternal_userAdapter {
	public static $adapter = 'internal_user';
	public function __construct() {
		parent::__construct('internal_user');
	}
}
class Internal_userEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('internal_user', $values);
	}
}
