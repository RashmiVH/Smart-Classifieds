<?php // GEN Search AT 2010-04-15 00:05:22
interface ISearchAdapter {
}
class SearchAdapterImpl
extends pdoMap_Mapping_Adapter
implements ISearchAdapter {
	public static $adapter = 'search';
	public function __construct() {
		parent::__construct('search');
	}
}
class SearchEntityImpl extends pdoMap_Mapping_Entity {
	public function __construct($values = null) {
		parent::__construct('search', $values);
	}
}
