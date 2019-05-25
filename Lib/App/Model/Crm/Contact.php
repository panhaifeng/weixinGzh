<?php
load_class('TMIS_TableDataGateway');
class Model_Crm_Contact extends TMIS_TableDataGateway {
	var $tableName = 'jichu_client_contact';
	var $primaryKey = 'id';
	var $primaryName = 'contact_name';
}
?>