<?php
load_class('TMIS_TableDataGateway');
class Model_Trade_Order extends TMIS_TableDataGateway {
	var $tableName = 'trade_order';
	var $primaryKey = 'id';
	var $primaryName = 'orderCode';


	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader',
		),
		array(
			'tableClass' => 'Model_Jichu_Client',
			'foreignKey' => 'clientId',
			'mappingName' => 'Client',
		),
		// array(
		// 	'tableClass' => 'Model_Acm_User',
		// 	'foreignKey' => 'userId',
		// 	'mappingName' => 'User',
		// )
	);
	
	var $hasMany = array (
		array(
			'tableClass' => 'Model_Trade_Order2Product',
			'foreignKey' => 'orderId',
			'mappingName' => 'Products',
		)
	);

	//取得新合同编号
	function getNewOrderCode() {
		$arr=$this->find(null,'orderCode desc','orderCode');
		// by zcc 2016年11月3日  原因在编号后面加入了业务员代码 所以在提取9位 如DS161103001A 
		$max = substr($arr['orderCode'],2);// 去除了DS 变成161103001A 
		$max = substr($max,0,9);//提取161103001 
		$temp = date("ymd")."001";
		if ($temp>$max) return 'DS'.$temp;
		$a = substr($max,-3)+1001;
		return 'DS'.substr($max,0,-3).substr($a,1);
	}

	//得到合同的收款金额
	function getMoneyAccept($orderId) {
		$sql = "select sum(x.money) as money
			from caiwu_ar_guozhang x
			inner join cangku_chuku2product y on x.id=y.guozhangId
			inner join trade_order2product z on y.order2productId=z.id
			where x.incomeId>0 and z.orderId='$orderId'";
		$re = $this->findBySql($sql);
		return $re[0]['money'];
	}
}


?>