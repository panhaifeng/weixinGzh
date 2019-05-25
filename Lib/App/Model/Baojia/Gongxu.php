<?php
load_class('TMIS_TableDataGateway');
class Model_Baojia_Gongxu extends TMIS_TableDataGateway {
	var $tableName = 'baojia_gongxu';
	var $primaryKey = 'id';
	var $primaryName = 'name';
	var $sortByKey = ' letters';
	var $optgroup = true;
}
?>