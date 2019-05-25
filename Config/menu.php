<?php
$_sysMenu = array(
    array(
		'text'=>'订单管理',
		'expanded'=> false,
		'id'=>'1',
		'children'=>array(
			array('text'=>'订单登记','expanded'=> false,'src'=>'?controller=Trade_Order&action=add','leaf'=>true,'id'=>'1-1','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'订单查询','expanded'=> false,'src'=>'?controller=Trade_Order&action=right','leaf'=>true,'id'=>'1-2'),
			array('text'=>'订单审核','expanded'=> false,'src'=>'?controller=Trade_Order&action=ShenheList','leaf'=>true,'id'=>'1-3'),
			//array('text'=>'xiufu','expanded'=> false,'src'=>'?controller=Trade_Order&action=Update','leaf'=>true,'id'=>'1-4')
			array('text'=>'订单明细查询','expanded'=> false,'src'=>'?controller=Trade_Order&action=MingxiRight','leaf'=>true,'id'=>'1-4'),
		)
    ),
	array('text'=>'计划管理','expanded'=> false,'id'=>'2','children'=>array(
		array('text'=>'上机计划设置','expanded'=> false,'src'=>'?controller=Shengchan_Shangji&action=ListForAdd','leaf'=>true,'id'=>'2-1'),
		// array('text'=>'上机设置','expanded'=> false,'src'=>'?controller=Shengchan_Shangji&action=ListForAdd','leaf'=>true,'id'=>'2-1'),
		array('text'=>'机台任务一览','expanded'=> false,'src'=>'?controller=Shengchan_Shangji&action=right','leaf'=>true,'id'=>'2-2'),
		array('text'=>'已完成任务查询','expanded'=> false,'src'=>'?controller=Shengchan_Shangji&action=listOver','leaf'=>true,'id'=>'2-3'),
		// array('text'=>'生产计划查询','expanded'=> false,'src'=>'?controller=Shengchan_Plan&action=right','leaf'=>true,'id'=>'2-2'),
	)),
	array('text'=>'仓库管理','expanded'=> false,'id'=>'3','children'=>array(
		// array('text'=>'色/坯纱仓库','expanded'=> false,'id'=>'3-1','children'=>array(
		// 	array('text'=>'色/坯纱库存初始化','expanded'=> false,'src'=>'?controller=Shengchan_Yuliao_construct&action=init','leaf'=>true,'id'=>'3-1-1','icon'=>'Resource/Image/Menu/add2.gif'),
		// 	array('text'=>'色/坯纱入库登记','expanded'=> false,'src'=>'?controller=Shengchan_Yuliao_ruku&action=add','leaf'=>true,'id'=>'3-1-2','icon'=>'Resource/Image/Menu/add2.gif'),
		// 	array('text'=>'色坯纱入库查询','expanded'=> false,'src'=>'?controller=Shengchan_Yuliao_ruku&action=right','leaf'=>true,'id'=>'3-1-3'),
		// 	array('text'=>'色/坯纱出库登记','expanded'=> false,'src'=>'?controller=Shengchan_Yuliao_ConstructChuku&action=add','leaf'=>true,'id'=>'3-1-4','icon'=>'Resource/Image/Menu/add2.gif'),
		// 	array('text'=>'色/坯纱采购出库登记','expanded'=> false,'src'=>'?controller=Shengchan_Yuliao_Chuku&action=add','leaf'=>true,'id'=>'3-1-5','icon'=>'Resource/Image/Menu/add2.gif'),
		// 	array('text'=>'色/坯纱出库查询','expanded'=> false,'src'=>'?controller=Shengchan_Yuliao_Chuku&action=right','leaf'=>true,'id'=>'3-1-6'),
		// 	array('text'=>'色/坯纱收发存报表','expanded'=> false,'src'=>'?controller=Shengchan_Yuliao_Chuku&action=report','leaf'=>true,'id'=>'3-1-7','icon'=>'Resource/Image/Menu/report2.gif'),
		// )),
		array('text'=>'色/坯纱仓库','expanded'=> false,'id'=>'3-1','children'=>array(
			array('text'=>'库存初始化','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_Init&action=right','leaf'=>true,'id'=>'3-1-1','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'采购入库登记','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_Ruku&action=add','leaf'=>true,'id'=>'3-1-2','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'采购退库登记','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_Cgth&action=add','leaf'=>true,'id'=>'3-1-13','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'入库查询','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_Ruku&action=right','leaf'=>true,'id'=>'3-1-3'),
			array('text'=>'销售出库登记','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_Xsck&action=add','leaf'=>true,'id'=>'3-1-4','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'销售出库查询','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_Xsck&action=right','leaf'=>true,'id'=>'3-1-5','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'生产领用登记','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_SCLY&action=add','leaf'=>true,'id'=>'3-1-6','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'生产领用查询','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_SCLY&action=right','leaf'=>true,'id'=>'3-1-7','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'外加工领用登记','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_FWLL&action=add','leaf'=>true,'id'=>'3-1-8','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'外加工领用查询','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_FWLL&action=right','leaf'=>true,'id'=>'3-1-9','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'其他出库','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_OtherChuku&action=add','leaf'=>true,'id'=>'3-1-10','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'其他出库查询','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_OtherChuku&action=right','leaf'=>true,'id'=>'3-1-11','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'收发存报表','expanded'=> false,'src'=>'?controller=Cangku_Yuanliao_Chuku&action=report','leaf'=>true,'id'=>'3-1-12','icon'=>'Resource/Image/Menu/report2.gif'),
		)),
		array('text'=>'成品布管理','expanded'=> false,'id'=>'3-2','children'=>array(
			array('text'=>'库存初始化','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_RukuInit&action=Right','leaf'=>true,'id'=>'3-2-1'),
			array('text'=>'成品调拨登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_Diaobo&action=Add','leaf'=>true,'id'=>'3-2-10'),
			array('text'=>'成品调拨查询','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_Diaobo&action=right','leaf'=>true,'id'=>'3-2—11'),
			array('text'=>'生产入库','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_Ruku&action=Add','leaf'=>true,'id'=>'3-2-2'),
			array('text'=>'入库查询','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_Ruku&action=right','leaf'=>true,'id'=>'3-2-3'),
			array('text'=>'码单出库','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_CkWithMadan&action=ListMadanCk','leaf'=>true,'id'=>'3-2-4'),
			array('text'=>'销售出库(订单)','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_ChukuSell&action=add','leaf'=>true,'id'=>'3-2-5'),
			array('text'=>'销售出库','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_OtherChuku&action=add','leaf'=>true,'id'=>'3-2-8'),
			array('text'=>'出库查询','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_ChukuSell&action=right','leaf'=>true,'id'=>'3-2-6'),
			array('text'=>'成品收发报表','expanded'=> false,'src'=>'?controller=Cangku_Chengpin_ChukuSell&action=report','leaf'=>true,'id'=>'3-2-7'),
		)),
	)),

	array('text'=>'产量管理','expanded'=> false,'id'=>'8','children'=>array(
		array('text'=>'产量登记','expanded'=> false,'src'=>'?controller=shengchan_chanliang&action=ListForAdd','leaf'=>true,'id'=>'8-1'),
		array('text'=>'产量查询','expanded'=> false,'src'=>'?controller=shengchan_chanliang&action=right','leaf'=>true,'id'=>'8-2'),
		array('text'=>'产量统计报表','expanded'=> false,'src'=>'?controller=shengchan_chanliang&action=report','leaf'=>true,'id'=>'8-3'),
		array('text'=>'外协定型通知单','expanded'=> false,'src'=>'?controller=Shengchan_Waixie_Dingxing&action=Add','leaf'=>true,'id'=>'8-4'),
		array('text'=>'外协查询','expanded'=> false,'src'=>'?controller=Shengchan_Waixie_Dingxing&action=right','leaf'=>true,'id'=>'8-5'),
	)),
	/**/
	array('text'=>'财务管理','expanded'=> false,'id'=>'4','children'=>array(
		array('text'=>'应付管理','expanded'=> false,'id'=>'4-1','children'=>array(
			array('text'=>'应付过账','expanded'=> false,'id'=>'4-1-1','src'=>'?controller=Caiwu_Yf_Guozhang&action=Add','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'应付查询','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Guozhang&action=right','leaf'=>true,'id'=>'4-1-2'),
			array('text'=>'收票登记','expanded'=> false,'id'=>'4-1-3','src'=>'?controller=Caiwu_Yf_Fapiao&action=add','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'收票查询','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Fapiao&action=right','leaf'=>true,'id'=>'4-1-4'),
			array('text'=>'付款登记','expanded'=> false,'id'=>'4-1-5','src'=>'?controller=Caiwu_Yf_Fukuan&action=add','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'付款查询','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Fukuan&action=right','leaf'=>true,'id'=>'4-1-6'),
			array('text'=>'应付款报表','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Guozhang&action=report','leaf'=>true,'id'=>'4-1-7'),
		)),
		array('text'=>'应收管理','expanded'=> false,'id'=>'4-2','children'=>array(
			array('text'=>'应收过账','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'4-2-1','src'=>'?controller=Caiwu_Ys_Guozhang&action=Add','leaf'=>true),
			array('text'=>'应收查询','expanded'=> false,'id'=>'4-2-2','src'=>'?controller=Caiwu_Ys_Guozhang&action=right','leaf'=>true),
			array('text'=>'开票登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'4-2-3','src'=>'?controller=Caiwu_Ys_Fapiao&action=add','leaf'=>true),
			array('text'=>'开票查询','expanded'=> false,'id'=>'4-2-4','src'=>'?controller=Caiwu_Ys_Fapiao&action=right','leaf'=>true),
			array('text'=>'收款登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'4-2-5','src'=>'?controller=Caiwu_Ys_Income&action=add','leaf'=>true),
			array('text'=>'收款查询','expanded'=> false,'id'=>'4-2-6','src'=>'?controller=Caiwu_Ys_Income&action=right','leaf'=>true),
			array('text'=>'应收款报表','expanded'=> false,'id'=>'4-2-7','src'=>'?controller=Caiwu_Ys_Guozhang&action=report','leaf'=>true),
		)),
		array('text'=>'加工费管理','expanded'=> false,'id'=>'4-4','children'=>array(
			array('text'=>'加工费单价设置','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'4-4-1','src'=>'?controller=Shengchan_Waixie_JiaGongFei&action=Add','leaf'=>true),
			array('text'=>'加工费用统计','expanded'=> false,'id'=>'4-4-2','src'=>'?controller=Shengchan_Waixie_JiaGongFei&action=right','leaf'=>true),
			// array('text'=>'开票登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'4-2-3','src'=>'?controller=Caiwu_Ys_Fapiao&action=add','leaf'=>true),
			// array('text'=>'开票查询','expanded'=> false,'id'=>'4-2-4','src'=>'?controller=Caiwu_Ys_Fapiao&action=right','leaf'=>true),
			// array('text'=>'收款登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'4-2-5','src'=>'?controller=Caiwu_Ys_Income&action=add','leaf'=>true),
			// array('text'=>'收款查询','expanded'=> false,'id'=>'4-2-6','src'=>'?controller=Caiwu_Ys_Income&action=right','leaf'=>true),
			// array('text'=>'应收款报表','expanded'=> false,'id'=>'4-2-7','src'=>'?controller=Caiwu_Ys_Guozhang&action=report','leaf'=>true),
		)),
		array('text'=>'基础信息','expanded'=> false,'id'=>'4-3','children'=>array(
			array('text'=>'银行账户档案','expanded'=> false,'src'=>'?controller=caiwu_bank&action=right','leaf'=>true,'id'=>'4-3-1')
		)),
		// 	,
		// array('text'=>'其他收支管理','expanded'=> false,'id'=>'4-3','children'=>array(
		// 	array('text'=>'收款登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=caiwu_income&action=add','leaf'=>true,'id'=>'4-3-1'),
		// 	array('text'=>'收款查询','expanded'=> false,'src'=>'?controller=caiwu_income&action=right','leaf'=>true,'id'=>'4-3-2'),
		// 	array('text'=>'支出登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=Caiwu_Feiyong&action=add','leaf'=>true,'id'=>'4-3-3'),
		// 	array('text'=>'支出查询','expanded'=> false,'src'=>'?controller=Caiwu_Feiyong&action=right','leaf'=>true,'id'=>'4-3-4'),
		// 	array('text'=>'现金日报表','expanded'=> false,'src'=>'?controller=Caiwu_CashReport&action=right','leaf'=>true,'id'=>'4-3-5'),
  		//  array('text'=>'费用明细报表','expanded'=> false,'src'=>'?controller=Caiwu_CashReport&action=Report','leaf'=>true,'id'=>'4-3-8'),
		// 	array('text'=>'支出科目定义','expanded'=> false,'src'=>'?controller=jichu_Feiyong&action=right','leaf'=>true,'id'=>'4-3-7'),
		// )),
	)),
	array(
		'text'=>'报表中心',
		'expanded'=> false,//是否展开
		'id'=>5,
		'children'=>array(//如果是目录，leaf为false,或者不写,同时必须定义children属性，children下是另一颗树
			array('text'=>'订单统计报表','expanded'=> false,'src'=>'?controller=Trade_Order&action=report','leaf'=>true,'id'=>'5-1'),
			array('text'=>'产量统计报表','expanded'=> false,'src'=>'?controller=shengchan_chanliang&action=report','leaf'=>true,'id'=>'5-2'),
			array('text'=>'利润统计报表','expanded'=> false,'src'=>'?controller=Cangku_Ruku&action=Profits','leaf'=>true,'id'=>'5-3'),
			array('text'=>'日生产报表','expanded'=> false,'src'=>'?controller=shengchan_chanliang&action=dayReport','leaf'=>true,'id'=>'5-4'),
		)
	),
	array(
		'text'=>'基础资料',
		'expanded'=> false,
		'id'=>'6',
		'children'=>array(
			array('text'=>'客户档案','expanded'=> false,'src'=>'?controller=Jichu_Client&action=right','leaf'=>true,'id'=>'6-1'),
			array('text'=>'供应商档案','expanded'=> false,'src'=>'?controller=Jichu_Supplier&action=right','leaf'=>true,'id'=>'6-2'),
			//array('text'=>'产品档案','expanded'=> false,'src'=>'?controller=Jichu_Product&action=right','leaf'=>true,'id'=>'6-3'),
			array('text'=>'纱档案','expanded'=> false,'src'=>'?controller=Jichu_Sha&action=right','leaf'=>true,'id'=>'6-20'),
			// array('text'=>'布档案','expanded'=> false,'src'=>'?controller=Jichu_Bu&action=right','leaf'=>true,'id'=>'6-21'),
			array('text'=>'布档案','expanded'=> false,'src'=>'?controller=Jichu_Chanpin&action=right','leaf'=>true,'id'=>'6-21'),

			// array('text'=>'原料档案','expanded'=> false,'src'=>'?controller=Jichu_Yuanliao&action=right','leaf'=>true,'id'=>'6-4'),
		    array('text'=>'库位档案','expanded'=> false,'src'=>'?controller=Jichu_Kuwei&action=right','leaf'=>true,'id'=>'6-17'),
			array('text'=>'织机档案','expanded'=> false,'src'=>'?controller=Jichu_Zhiji&action=right','leaf'=>true,'id'=>'6-18'),
			array('text'=>'加工户档案','expanded'=> false,'src'=>'?controller=Jichu_Jiagonghu&action=right','leaf'=>true,'id'=>'6-19'),
			// array('text'=>'坯/色纱档案','expanded'=> false,'src'=>'?controller=Jichu_Yuanliao&action=right','leaf'=>true,'id'=>'6-4'),
			// array('text'=>'库位档案','expanded'=> false,'src'=>'?controller=Jichu_Kuwei&action=right','leaf'=>true,'id'=>'6-5'),
			array('text'=>'部门档案','expanded'=> false,'src'=>'?controller=Jichu_Department&action=right','leaf'=>true,'id'=>'6-7'),
			array('text'=>'员工档案','expanded'=> false,'src'=>'?controller=Jichu_Employ&action=right','leaf'=>true,'id'=>'6-8'),
			array('text'=>'银行账户档案','expanded'=> false,'src'=>'?controller=caiwu_bank&action=right','leaf'=>true,'id'=>'6-16'),
			// array('text'=>'工序档案','expanded'=> false,'src'=>'?controller=Jichu_Gongxu&action=right','leaf'=>true,'id'=>'6-22')
		)
	),
	array('text'=>'展会管理','expanded'=> false,'id'=>'9','children'=>array(
			array('text'=>'展会结果查询','expanded'=> false,'src'=>'?controller=Zhanhui&action=right','leaf'=>true,'id'=>'9-1'),
			array('text'=>'参展业务员设置','expanded'=> false,'src'=>'?controller=Zhanhui&action=listTrader','leaf'=>true,'id'=>'9-2'),
			array('text'=>'被寄品统计','expanded'=> false,'src'=>'?controller=Zhanhui&action=tongji','leaf'=>true,'id'=>'9-3'),
	)),
	array('text'=>'报价管理','expanded'=> false,'id'=>'10','children'=>array(
			array('text'=>'工序价格设定','expanded'=> false,'src'=>'?controller=Baojia_Gongxu&action=right','leaf'=>true,'id'=>'10-1'),
			array('text'=>'系数设置','expanded'=> false,'src'=>'?controller=Baojia_Ratio&action=ListForSet','leaf'=>true,'id'=>'10-2'),
			array('text'=>'产品报价一览表','expanded'=> false,'src'=>'?controller=Baojia_Report&action=Report','leaf'=>true,'id'=>'10-3'),
	)),
	array('text'=>'客户管理','expanded'=> false,'id'=>'11','children'=>array(
		array('text'=>'意向客户','expanded'=> false,'src'=>'?controller=Crm_Intention&action=Right','leaf'=>true,'id'=>'11-1'),
		array('text'=>'行动统计','expanded'=> false,'src'=>'?controller=Crm_Action&action=Right','leaf'=>true,'id'=>'11-2'),
		array('text'=>'行业','expanded'=> false,'src'=>'?controller=Crm_Industry&action=Right','leaf'=>true,'id'=>'11-3'),
		array('text'=>'客户来源','expanded'=> false,'src'=>'?controller=Crm_Source&action=Right','leaf'=>true,'id'=>'11-4'),
		array('text'=>'行动方式','expanded'=> false,'src'=>'?controller=Crm_ActionType&action=Right','leaf'=>true,'id'=>'11-5'),
	)),

	array(
		'text'=>'系统设置',
		'expanded'=> false,
		'id'=>'7',
		'children'=>array(
			array('text'=>'权限管理','expanded'=> false,'id'=>'7-1','children'=>array(
				array('text'=>'用户管理','icon'=>'Resource/Image/Menu/adduser.png','expanded'=>false,'src'=>'?controller=Acm_User&action=right','leaf'=>true,'id'=>'7-1-1'),
				array('text'=>'组管理','expanded'=> false,'src'=>'?controller=Acm_Role&action=right','leaf'=>true,'id'=>'7-1-2'),
				array('text'=>'权限设置','expanded'=> false,'src'=>'?controller=Acm_Func&action=setQx','leaf'=>true,'id'=>'7-1-3')
			)),
			array('text'=>'修改密码','expanded'=> false,'src'=>'?controller=Acm_User&action=changePwd','leaf'=>true,'id'=>'7-2'),
		)
	),
	array('text'=>'通知管理','icon'=>'Resource/Image/Menu/messages.gif','expanded'=> false,'src'=>'?controller=OaMessage&action=right','leaf'=>true,'id'=>'101'),
	array('text'=>'通知类别','icon'=>'Resource/Image/Menu/messages.gif','expanded'=> false,'src'=>'?controller=OaMessageClass&action=right','leaf'=>true,'id'=>'103'),
	// array('text'=>'一对多通用模板案例','icon'=>'Resource/Image/Menu/messages.gif','expanded'=> false,'src'=>'?controller=Trade_Order&action=addTest','leaf'=>true,'id'=>'104'),
);
?>
