<?php
load_class('Model_Cangku_Chuku');
class Model_Cangku_Chengpin_Diaobo extends Model_Cangku_Chuku {
    var $tableName = 'cangku_common_chuku';
	var $primaryKey = 'id';
	var $hasMany = array (
		array(
			'tableClass' => 'Model_Cangku_Chengpin_Diaobo2Product',
			'foreignKey' => 'chukuId',
			'mappingName' => 'Products',
		)
	);

}
?>