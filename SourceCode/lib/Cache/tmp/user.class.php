<?php // GEN User AT 2010-04-15 00:12:20
interface IUserAdapter {
}
class UserAdapterImpl
extends pdoMap_Mapping_Adapter
implements IUserAdapter {
	public static $adapter = 'user';
	public function __construct() {
		parent::__construct('user');
	}
}
class UserEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('user', $values);
	}
	public function getterUser() {
		if (!$this->User) {
		}
		return $this->User;
	}
}
