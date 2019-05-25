<?php
FLEA::loadClass('Controller_Cangku_Chuku');
class Controller_Cangku_Yuanliao_Chuku extends Controller_Cangku_Chuku {	
	function __construct() {
		// $this->_kuwei = '原料仓库';//库位
		// $this->_state = '原料';
		$this->_head = 'LLCKA';//单据前缀
		$this->_kind='领料出库';
		$this->_arrKuwei = array('坯纱仓库','色纱仓库');
		parent::__construct();
		// dump($this->_arrKuwei);exit;
	}

	function actionReport(){
		$this->authCheck('3-1-12');
		parent::actionReport();
	}
}