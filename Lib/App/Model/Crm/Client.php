<?php
load_class('TMIS_TableDataGateway');
class Model_Crm_Client extends TMIS_TableDataGateway {
	var $tableName = 'intention_client';
	var $primaryKey = 'id';
	var $primaryName = 'company';


	var $hasMany = array(
		array(
			'tableClass' => 'Model_Crm_Contact',
			'foreignKey' => 'cid',
			'mappingName' => 'Contacts'
		)

	);
}
?>