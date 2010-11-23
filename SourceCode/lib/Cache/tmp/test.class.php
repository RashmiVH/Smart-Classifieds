<?php // GEN Test AT 2010-04-14 04:56:09
interface ITestAdapter {
}
class TestAdapterImpl
extends pdoMap_Mapping_Adapter
implements ITestAdapter {
	public static $adapter = 'test';
	public function __construct() {
		parent::__construct('test');
	}
}
class TestEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('test', $values);
	}
}
