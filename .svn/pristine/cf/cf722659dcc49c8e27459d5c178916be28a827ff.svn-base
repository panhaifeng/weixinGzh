<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Trade_Order extends Tmis_Controller {
    var $title = "订单管理-登记";
    var $fldMain;
    var $headSon;
    var $rules; //表单元素的验证规则
    // **************************************构造函数 begin********************************
    function __construct() {
        $this->_modelDefault = &FLEA::getSingleton('Model_Trade_Order');
        $this->_modelExample = &FLEA::getSingleton('Model_Trade_Order');
        $this->jichu_employ= &FLEA::getSingleton('Model_Jichu_Employ');
        // 定义模板中的主表字段
        $this->fldMain = array('orderCode' => array('title' => '订单编号', "type" => "text", 'readonly' => true, 'value' => $this->_modelDefault->getNewOrderCode()),
            'orderDate' => array('title' => '订单日期', 'type' => 'calendar', 'value' => date('Y-m-d')),

            'finalDate' => array('title' => '最终交期', 'type' => 'calendar', 'value' => date('Y-m-d')),
            'traderId' => array('title' => '业务负责', 'type' => 'select', 'value' => '','options'=>$this->jichu_employ->getSelect()),

            'clientId' => array('title' => '客户名称', 'type' => 'clientpopup', 'clientName' => ''),
            'clientOrder' => array('title' => '客户单号', 'type' => 'text', 'value' => ''),
            'xsType' => array('title' => '内/外销', 'type' => 'select', 'value' => '', 'options' => array(
                    array('text' => '内销', 'value' => '内销'),
                    array('text' => '外销', 'value' => '外销'),
                    )),
            'pichang' => array('title' => '成品匹长', 'type' => 'text', 'value' => '', 'addonEnd' => '米'),

            'overflow' => array('title' => '溢短装', 'type' => 'text', 'value' => '', 'addonEnd' => '%'),
            'warpShrink' => array('title' => '经向缩率', 'type' => 'text', 'value' => '', 'addonEnd' => '%'),
            'weftShrink' => array('title' => '纬向缩率', 'type' => 'text', 'value' => '', 'addonEnd' => '%'),
            'packing' => array('title' => '包装要求', 'type' => 'text', 'value' => ''),
            'checking' => array('title' => '跟单', 'type' => 'select', 'value' => '','options'=>$this->jichu_employ->getGenDan()),
            
            'moneyDayang' => array('title' => '打样收费', 'type' => 'text', 'value' => ''),
            'bizhong' => array('title' => '交易币种', 'type' => 'select', 'value' => '', 'options' => array(
                    array('text' => 'RMB', 'value' => 'RMB'),
                    array('text' => 'USD', 'value' => 'USD'),
                    )),
            // 定义了name以后，就不会以memo作为input的id了
            // 'memo'=>array('title'=>'订单备注','type'=>'textarea','disabled'=>true,'name'=>'orderMemo'),
            // 下面为隐藏字段
            'orderId' => array('type' => 'hidden', 'value' => ''),
            );
        // /从表表头信息
        // /type为控件类型,在自定义模板控件
        // /title为表头
        // /name为控件名
        // /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
        $this->headSon = array(
            '_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
            'productId' => array('type' => 'btproductpopup', "title" => '产品选择', 'name' => 'productId[]'),
            'proName' => array('type' => 'bttext', "title" => '品名&规格', 'name' => 'proName[]', 'readonly' => true),
            // 'guige' => array('type' => 'bttext', "title" => '规格', 'name' => 'guige[]', 'readonly' => true),
            'color' => array('type' => 'bttext', "title" => '颜色', 'name' => 'color[]','readonly' => true),
            'unit' => array('type' => 'btselect', "title" => '单位', 'name' => 'unit[]', 'value'=>'公斤','options' =>array(
                array('text'=>'公斤','value'=>'公斤'),
                array('text'=>'米','value'=>'米'),
                array('text'=>'码','value'=>'码'),
                array('text'=>'磅','value'=>'磅'),
                array('text'=>'条','value'=>'条'),
            )),
            'jixing'=>array('type'=>'bttext','title'=>'机型','name'=>'jixing[]','value'=>''),
            'cntYaohuo' => array('type' => 'bttext', "title" => '数量', 'name' => 'cntYaohuo[]'),
            'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
            'money' => array('type' => 'bttext', "title" => '金额', 'name' => 'money[]', 'readonly' => true),
            // 'supplierId' => array('type' => 'BtSupplierSelect', "title" => '原料供应商', 'name' => 'supplierId[]'),
            'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'),
            // ***************如何处理hidden?
            'id' => array('type' => 'bthidden', 'name' => 'id[]'),
            //'shenheid' => array('type' => 'bthidden', 'name' => 'shenheid[]'),
            );
        // 表单元素的验证规则定义
        $this->rules = array(
            'orderCode' => 'required',
            'orderDate' => 'required',
            'clientId' => 'required',
            'traderId' => 'required',
            'cntYaohuo[]'=> 'required',
            'danjia[]'=> 'required',
            );
    }
    // ******************************构造函数 end******************************************
    // ***************************** 订单查询 begin*************************************
    function actionRight() {
        //$this->authCheck('1-2-6');
        FLEA::loadClass('TMIS_Pager');
        // /构造搜索区域的搜索类型
        $serachArea = TMIS_Pager::getParamArray(array(
            'dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))),
            'dateTo' => date("Y-m-d"),
            'clientId' => '',
            'traderId' => '',
            //'isCheck' => 2,
            'orderCode' => '',
            'key' => '',
            ));
        // dump($serachArea);exit;
        $sql = "select y.id,
                       y.orderCode,
                       y.orderDate,
                       y.clientId,
                       y.traderId,
                       y.clientOrder,
                       y.memo as orderMemo,
                       y.bizhong,
                       y.isExport,
                       t.productId,
                       t.id as ord2proId
                           from trade_order y
                            join trade_order2product t on y.id =t.orderId
                           ";
        $str = "select
                x.orderCode,
                x.orderDate,
                x.clientId,
                x.traderId,
                x.clientOrder,
                x.orderMemo,
                x.id,
                x.bizhong,
                x.ord2proId,
                x.isExport,
                p.proName,
                p.guige,
                y.compName,
                m.employName,
                g.id as guozhangId
                from (" . $sql . ") x
                left join jichu_product p on p.id = x.productId
                left join jichu_client y on x.clientId = y.id
                left join jichu_employ m on m.id=x.traderId
                left join caiwu_ar_guozhang g on g.orderId=x.id
                where 1";

        $str .= " and orderDate >= '$serachArea[dateFrom]' and orderDate<='$serachArea[dateTo]'";
        if ($serachArea['key'] != '') $str .= " and (p.proName like '%$serachArea[key]%' or p.guige like '%$serachArea[key]%')";
        //if ($serachArea['isCheck'] < 2) $str .= " and sh.isCheck = '$serachArea[isCheck]'";
        if ($serachArea['orderCode'] != '') $str .= " and x.orderCode like '%$serachArea[orderCode]%'";
        if ($serachArea['clientId'] != '') $str .= " and x.clientId = '$serachArea[clientId]'";
        if ($serachArea['traderId'] != '') $str .= " and x.traderId = '$serachArea[traderId]'";

        //该用户关联的业务员的订单
        $mUser = & FLEA::getSingleton('Model_Acm_User');
        if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
            //得到当前用户匹配的员工id
            $traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
            if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
                $str .= " and 0";
            } else {
                $s = join(',',$traderIds);
                $str .= " and x.traderId in ({$s})";
            }
        }
        $str .= " group by x.id order by orderDate desc, orderCode desc";
		// dump($str);exit;
        $pager = &new TMIS_Pager($str);
        $rowset = $pager->findAll();
		// dump($rowset);exit;
        $trade_order2product = &FLEA::getSingleton('Model_Trade_Order2Product');
        $trade_shenhe= &FLEA::getSingleton('Model_Trade_Shenhe');
        $canEdit= $this->authCheck('1-2-1',true);
        $canRemove=$this->authCheck('1-2-2',true);
        if (count($rowset) > 0) foreach($rowset as &$value) {
            //导出后变绿色
            if($value['isExport']==1) $value['_bgColor'] = "#7FF1AC";

            //有订单修改权限
            if($canEdit) {
                if ($value["guozhangId"]) {
                    $tip = "ext:qtip='已过账'";
                    $value['_edit'] .= " <a href='javascript:void(0)' style='color:black' $tip>修改</a>";
                }else{
                    //根据主订单 得到明细id，判断是否全部审核
                    $res = $trade_order2product->findAll(array('orderId' => $value['id']));
                    //dump($res);exit;
                    $i=0;//判断审核的记录个数
                    foreach($res as &$v){
                        if($v['Shenhe']['isCheck']){
                            $i++;//有审核就累加一次
                        }
                    }
                    if(count($res)==$i){
                        //如果个数相同，表示都已经审核过了，
                            $tip = "ext:qtip='订单明细已全部审核'";
                            $value['_edit'] .= " <a $tip  >修改</a>";
                    }else{
                            $value['_edit'] .= " <a href='" . $this->_url('Edit', array('id' => $value['id'])) . "'>修改</a>";
                    }
                }

            }
            //有订单删除权限
            if($canRemove) {
                if ($value["guozhangId"]) {
                    $tip = "ext:qtip='已过账'";
                    $value['_edit'] .= " <a $tip  >删除</a>";
                }else{
                    //根据主订单 得到明细id，判断是否审核，如果其中有一个审核就不能删除，
                    $res = $trade_order2product->findAll(array('orderId' => $value['id']));//dump($res);exit;
                    $i=ture;//判断是否有审核的记录
                    foreach($res as &$v){
                          if($v['Shenhe']['isCheck']){
                              $tip = "ext:qtip='订单明细有审核'";
                              $value['_edit'] .= " <a $tip  >删除</a>";
                              $i=false;
                              break;
                          }
                    }
                    if($i){
                        //$i为true，则表示没有审核明细记录
                        $value['_edit'] .= " <a href='" . $this->_url('Remove', array('id' => $value['id'])) . "'  onclick=\"return confirm('确认删除吗?')\" >删除</a>";
                    }
                }
            }

            // 在左侧中 显示 总数量 和 总金额 初始化
            $value['cntTotal'] = 0;
            $value['moneyTotal'] = 0;

            //根据主订单 得到明细id，判断是否审核，如果其中有一个审核就不能删除，
            $res = $trade_order2product->findAll(array('orderId' => $value['id']));//dump($res);exit;
            // $res = $value['Products'];
            foreach($res as &$item) {
                $item['_edit'] = "<a href='".$this->_url('PrintDingchan',array(
                    'ord2proId'=>$item['id']
                ))."'>导出</a>";

                //根据$trade_order2product 的id 查询 trade_shenhe表
                $str=$trade_shenhe->findAll(array('ord2proId'=>$item['id']));

                //如果已审核，可以打印定产单; 并且不能删除
                //修改为不需要审核也可以导出 by czb 2016年3月8日 09:27:58
                // if($str[0]['isCheck']) {

                // 	$item['_edit'] = "<a href='".$this->_url('PrintDingchan',array(
                // 		'ord2proId'=>$item['id']
                // 	))."'>导出</a>";
                // } else {
                // 	$item['_edit'] = "未审";
                // }
                // 添加信息
                $item['cntYaohuo'] = round($item['cntYaohuo'], 2);
                $item['danjia'] = round($item['danjia'], 2);
                $item['proCode'] = $item['Products']['proCode'];
                $item['proName'] = $item['Products']['proName'];
                $item['guige'] = $item['Products']['guige'];
                // 客户需求颜色自己填写 不是从基础档案调过来
                // $item['color'] = $item['color'];
                // 客户需求颜色 从基础档案调过来
                $item['color'] = $item['Products']['color'];
                $item['kind'] = $item['Products']['kind'];
                $item['money'] = round($item['cntYaohuo'] * $item['danjia'], 2);
                // 在左侧中 显示 总数量 和 总金额 累加
                $value['cntTotal'] += $item['cntYaohuo'];
                $value['moneyTotal'] += $item['money'];
                unset($item['Order']);

            }
            $value['DetailProducts'] = $res;
            // dump($res);exit;


        }

        //判断当前用户是否可以看客户和看金额
        foreach($rowset as & $v) {
            if(!$this->authCheck('1-2-3',true)) {//客户
                $v['compName'] = '';
            }
            //总金额
            if(!$this->authCheck('1-2-4',true)) {//金额
                $v['moneyTotal'] = '';
            }
            foreach($v['DetailProducts'] as & $vv) {
                if(!$this->authCheck('1-2-4',true)) {//金额
                    $vv['danjia'] = '';
                    $vv['money'] = '';
                }
            }
            $v['dateJiaohuo'] = $v['DetailProducts'][0]['dateJiaohuo'];
        }
        // 合计行
        $smarty = &$this->_getView();
        // 右侧信息
        $arrFieldInfo = array(
            "_edit" => array("text"=>'操作','width'=>120),
            "orderDate" => "下单日期",
            "dateJiaohuo" => "交货日期",
            'orderCode' => '生产编号',
            "compName" => array("text"=>"客户名称",'width'=>170),
            'employName' => '业务员',
            // 'pinming'=>'品名',
            // 'guige'=>'规格',
            "cntTotal" => '总数量',
            // "danjia" =>'单价',
            "moneyTotal" => '总金额',
            "bizhong" => '币种',
            // "orderMemo" =>'订单备注',
            //"ord2proId" =>'明细id'
            );
        // 下面显示的信息
        $arrField = array(
            '_edit'=>array("text"=>'定产单','width'=>50),
            'proCode' => '编码',
            'proName' => '品名',
            'guige' => '规格',
            'color'=>'颜色',
            'kind'=>'类型',
            "cntYaohuo" => '数量',
            "unit" => '单位',
            "danjia" => '单价',
            "money" => '金额',
            // "memo" =>'产品备注'
            );

        $smarty->assign('title', '订单查询');
        $smarty->assign('pk', $this->_modelDefault->primaryKey);
        $smarty->assign('arr_field_info', $arrFieldInfo);
        $smarty->assign('arr_field_info2', $arrField);
        $smarty->assign('sub_field', 'DetailProducts');
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_condition', $serachArea);
        $smarty->assign('arr_field_value', $rowset);
        $smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $serachArea));
        $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
        // $smarty->display('TableList.tpl');
        $smarty->display('TblListMore.tpl');
    }
    // ***********************************订单查询 end***********************************
    function actionSetOver() {
        // dump($_GET);exit;
        $sql = "update trade_order set isCheck={$_GET['isCheck']} where id='{$_GET['id']}'";
        // echo $sql;exit;
        // mysql_query($sql) or die(mysql_error());
        $this->_modelDefault->execute($sql);
        // redirect($this->_url('ListForOver'));
        $msg = $_GET['isCheck'] == 1?"审核成功!":"取消审核成功!";
        js_alert(null, "window.parent.showMsg('{$msg}')", $this->_url($_GET['fromAction']));
    }
    // 查看详细
    function actionView() {
        FLEA::loadClass('TMIS_Common');
        $pk = $this->_modelDefault->primaryKey;
        $rowset = $this->_modelDefault->find($_GET[$pk]);
        $mPro = &FLEA::getSingleton('Model_Jichu_Product');
        if (count($rowset) > 0) if (count($rowset['Products']) > 0) {
            foreach($rowset['Products'] as &$value) {
                $row = $mPro->findByField('id', $value['productId']);
                $value['proCode'] = $row['proCode'];
                $value['proName'] = $row['proName'];
                $value['guige'] = $row['guige'];
                // $value['unit']			= $row['unit'];
                $value['money'] = number_format($value['danjia'] * $value['cnt'], 2, '.', '');
                $value['danjia'] = number_format($value['danjia'], 2, '.', '');
                $value['cnt'] = round($value['cnt'], 2);
                // if ($value['money'] == 0)	$value['money'] = $value['cnt'] * $value['danjia'];
                $totalCnt += $value['cnt'];
                $totalMoney += $value['money'];
            }
        }
        $smarty = &$this->_getView();
        $smarty->assign('title', '销售订单');
        $smarty->assign("arr_field_value", $rowset);
        $smarty->assign("total_cnt", $totalCnt);
        $smarty->assign("total_money", $totalMoney);
        $smarty->assign('money', TMIS_Common::trans2rmb($totalMoney));
        $smarty->display('Trade/OrderView.tpl');
    }
    // 打印生产单
    function actionManuPrint() {
        $pk = $this->_modelDefault->primaryKey;
        $rowset = $this->_modelDefault->find($_GET[$pk]);
        $mPro = &FLEA::getSingleton('Model_Jichu_Product');
        if (count($rowset) > 0) if (count($rowset['Products']) > 0) {
            foreach($rowset['Products'] as &$value) {
                $row = $mPro->findByField('id', $value['productId']);
                $value['proCode'] = $row['proCode'];
                $value['proName'] = $row['proName'];
                $value['guige'] = $row['guige'];
                $value['unit'] = $row['unit'];

                if ($value['money'] == 0) $value['money'] = $value['cnt'] * $value['danjia'];

                $totalCnt += $value['cnt'];
                $totalMoney += $value['money'];
            }
        }
        $smarty = &$this->_getView();
        $smarty->assign('title', '生产单');
        $smarty->assign("arr_field_value", $rowset);
        $smarty->assign("total_cnt", $totalCnt);
        $smarty->assign("total_money", $totalMoney);
        $smarty->display('Trade/ManuPrint.tpl');
    }
    // 打印领料单
    function actionLingliaoPrint() {
        $mYl = &FLEA::getSingleton('Model_Jichu_Yl');
        $mPro = &FLEA::getSingleton('Model_Jichu_Product');
        $kucun = &FLEA::getSingleton('Controller_Cangku_Yl_Kucun');
        $pk = $this->_modelDefault->primaryKey;
        $rowset = $this->_modelDefault->find($_GET[$pk]);
        if (count($rowset) > 0) if (count($rowset['Products']) > 0) {
            foreach($rowset['Products'] as &$value) {
                $sql = "select ylId, ylCnt from jichu_product2yl where productId = " . $value['productId'];
                $yls = $this->_modelDefault->findBySql($sql);
                // dump($yls); exit;
                if (count($yls) > 0) foreach($yls as &$v) {
                    $v['ylCnt'] = $v['ylCnt'] * $value['cnt'];
                    $v['chejianKucun'] = $kucun->getChejianKucun($rowset['chejianId'], $v['ylId']);
                    $newRowset[] = $v;
                    $arrYlId [] = $v['ylId'];
                }
            }
        }
        // dump($newRowset); //exit;
        if (count($arrYlId) > 0) {
            $arrYlId = array_count_values($arrYlId); //统计存在重量的id

            // dump($arrYlId);
            foreach($arrYlId as $k => $v) {
                $cnt = 0;
                if ($v > 1) { // 如果存在重复
                    foreach($newRowset as $vv) {
                        if ($vv['ylId'] == $k) {
                            // echo($vv['ylCnt']);
                            $cnt += $vv['ylCnt'];
                            $finalArr = $vv;
                        }
                    }
                    $finalArr['ylCnt'] = $cnt;
                    // dump($finalArr);exit;
                }else {
                    foreach($newRowset as $vvv) {
                        if ($vvv['ylId'] == $k) {
                            $finalArr = $vvv;
                        }
                    }
                }

                $arr[] = $finalArr; //去掉重复的数据, 把重复的cnt相加得出新的arr
            }

            if (count($arr) > 0) foreach($arr as &$value) {
                $rowPro = $mYl->find($value['ylId']);
                $value['ylCode'] = $rowPro['ylCode'];
                $value['ylName'] = $rowPro['ylName'];
                $value['guige'] = $rowPro['guige'];
                $value['unit'] = $rowPro['unit'];
                $value['wantLing'] = $value['ylCnt'] - $value['chejianKucun'];
            }
            // dump($arr); exit;
            $smarty = &$this->_getView();
            $smarty->assign('title', '领料单');
            $smarty->assign("arr_field_value", $rowset);
            $smarty->assign('arr_yl', $arr);
            $smarty->display('Trade/LingliaoPrint.tpl');
        }else {
            js_alert('产品组成不完整, 无法直接生成领料单!', "window.close()");
        }
    }
    // 装箱单打印
    function actionBoxPrint() {
        $pk = $this->_modelDefault->primaryKey;
        $rowset = $this->_modelDefault->find($_GET[$pk]);
        $mPro = &FLEA::getSingleton('Model_Jichu_Product');
        if (count($rowset) > 0) if (count($rowset['Products']) > 0) {
            foreach($rowset['Products'] as &$value) {
                $row = $mPro->findByField('id', $value['productId']);
                $value['proCode'] = $row['proCode'];
                $value['proName'] = $row['proName'];
                $value['guige'] = $row['guige'];
                $value['unit'] = $row['unit'];
                $value['boxCnt'] = ceil($value['cnt'] / $value['perBoxCnt']);
            }
        }

        $smarty = &$this->_getView();
        $smarty->assign('title', '装箱单');
        $smarty->assign("arr_field_value", $rowset);
        $smarty->assign("total_cnt", $totalCnt);
        $smarty->assign("total_money", $totalMoney);
        // $smarty->display('Trade/BoxPrint.tpl');
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=BoxPrint.xml");
        // $smarty->display('Trade/BoxPrint.tpl');
        $smarty->display('Trade/Export2Excel.tpl');
    }
    // 原料仓库领料介面
    function actionViewForYlChuku() {
        $mPro = &FLEA::getSingleton('Model_Jichu_Product');

        FLEA::loadClass('TMIS_Pager');
        $arrGet = TMIS_Pager::getParamArray(array('dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))),
                'dateTo' => date("Y-m-d"),
                'clientId' => '',
                // 'chejianId'		=> '',
                'orderCode' => '',
                'key' => ''
                ));

        $condition[] = array('dateOrder', $arrGet['dateFrom'], '>=');
        $condition[] = array('dateOrder', $arrGet['dateTo'], '<=');
        if ($arrGet['clientId'] != '') $condition[] = array('clientId', $arrGet['clientId']);
        // if ($arrGet['chejianId'] != '') $condition[] = array('chejianId', $arrGet['chejianId']);
        if ($arrGet['orderCode'] != '') {
            $condition[] = array('orderCode', '%' . $arrGet['orderCode'] . '%', 'like');
        }
        $condition[] = array('isLingliao', 0);

        $pager = &new TMIS_Pager($this->_modelDefault, $condition, "dateOrder desc");
        $rowset = $pager->findAll();
        if (count($rowset) > 0) foreach($rowset as &$value) {
            $value['clientName'] = $value['Client']['compName'];
            $value['chejianName'] = $value['Chejian']['name'];
            $arrPro = array();
            if (count($value['Products']) > 0) foreach($value['Products'] as &$pv) {
                $arrPro[] = $mPro->getProStr($mPro->find(array('id' => $pv['productId']))) . ": $pv[cnt]";
            }
            $title = join("<br>", $arrPro);
            $value['_edit'] = "<a href='" . $this->_url('View', array('id' => $value['id'])) . "' target='_blank' title='$title' onmouseover='tipOver(this,event)' onmouseout='tipOut(this)'>查看详细</a> | <a href='" . $this->_url('LingliaoPrint', array('id' => $value['id'])) . "' target='_blank' title='$title' onmouseover='tipOver(this,event)' onmouseout='tipOut(this)'>打印领料单</a> | <a href='" . $this->_url('Convert2Lingliao', array('id' => $value['id'])) . "' title='$title' onmouseover='tipOver(this,event)' onmouseout='tipOut(this)'>领料</a>";
        }

        $arrFieldInfo = array('orderCode' => '单号',
            'dateOrder' => '日期',
            'clientName' => '客户名称',
            'chejianName' => '车间名称',
            'memo' => '备注',
            '_edit' => '操作'
            );
        $smarty = &$this->_getView();
        $smarty->assign('title', $this->title);
        $smarty->assign('pk', $this->_modelRuku->primaryKey);
        $smarty->assign('arr_field_info', $arrFieldInfo);
        $smarty->assign('arr_field_value', $rowset);
        $smarty->assign('arr_condition', $arrGet);
        $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('tip', 'calendar')));
        $smarty->assign('page_info', $pager->getNavBar($this->_url('right', $arrGet)));
        $smarty->display('TableList2.tpl');
    }
// 生产单转换成领料单
    function actionConvert2Lingliao() {
        $mYl = &FLEA::getSingleton('Model_Jichu_Yl');
        $mPro = &FLEA::getSingleton('Model_Jichu_Product');
        $kucun = &FLEA::getSingleton('Controller_Cangku_Yl_Kucun');
        $pk = $this->_modelDefault->primaryKey;
        $rowset = $this->_modelDefault->find($_GET[$pk]);
    // dump($rowset
        if (count($rowset) > 0) if (count($rowset['Products']) > 0) {
            foreach($rowset['Products'] as &$value) {
                $sql = "select ylId, ylCnt from jichu_product2yl where productId = " . $value['productId'];
                $yls = $this->_modelDefault->findBySql($sql);
                // dump($yls); exit;
                if (count($yls) > 0) foreach($yls as &$v) {
                    $v['ylCnt'] = $v['ylCnt'] * $value['cnt'];
                    $v['chejianKucun'] = $kucun->getChejianKucun($rowset['chejianId'], $v['ylId']);
                    $newRowset[] = $v;
                    $arrYlId [] = $v['ylId'];
                }
            }
        }
        // dump($newRowset); //exit;
        if (count($arrYlId) > 0) {
            $arrYlId = array_count_values($arrYlId); //统计存在重量的id

            // dump($arrYlId);
            foreach($arrYlId as $k => $v) {
                $cnt = 0;
                if ($v > 1) { // 如果存在重复
                    foreach($newRowset as $vv) {
                        if ($vv['ylId'] == $k) {
                            // echo($vv['ylCnt']);
                            $cnt += $vv['ylCnt'];
                            $finalArr = $vv;
                        }
                    }
                    $finalArr['ylCnt'] = $cnt;
                    // dump($finalArr);exit;
                }else {
                    foreach($newRowset as $vvv) {
                        if ($vvv['ylId'] == $k) {
                            $finalArr = $vvv;
                        }
                    }
                }

                $arr[] = $finalArr; //去掉重复的数据, 把重复的cnt相加得出新的arr
            }

            if (count($arr) > 0) foreach($arr as &$value) {
                $rowPro = $mYl->find($value['ylId']);
                $value['ylCode'] = $rowPro['ylCode'];
                $value['ylName'] = $rowPro['ylName'];
                $value['guige'] = $rowPro['guige'];
                $value['unit'] = $rowPro['unit'];
                $value['cnt'] = $value['ylCnt'] - $value['chejianKucun'];
            }

            $mYlChuku = &FLEA::getSingleton('Model_Cangku_Yl_Chuku');
            $arrF['chukuNum'] = $mYlChuku->getNewChukuNum();
            $arrF['chejianId'] = $rowset['chejianId'];
            $arrF['Yl'] = $arr;

            $smarty = &$this->_getView();
            $smarty->assign('title', '原料出库');
            $smarty->assign('isConvert2Lingliao', 1);
            $smarty->assign('orderId', $rowset['id']);
            $smarty->assign('operator_id', $_SESSION['USERID']);
            $smarty->assign('real_name', $_SESSION['REALNAME']);
            $smarty->assign("arr_field_value", $arrF);
            $smarty->assign('default_date', date("Y-m-d"));
            $pk = $this->_mYlChuku->primaryKey;
            $primary_key = (isset($_GET[$pk])?$pk:"");
            $smarty->assign("pk", $primary_key);
            $smarty->display('Cangku/Yl/ChukuEdit.tpl');
        }else {
            js_alert('产品组成不完整, 无法直接生成领料单!', "window.history.go(-1)");
        }
    }
    // 编辑订单基本信息
    function _edit($Arr, $tag = 0) {
        // dump($Arr); exit;
        $smarty = &$this->_getView();
        $smarty->assign('title', '订单登记');
        $smarty->assign('user_id', $_SESSION['USERID']);
        $smarty->assign('real_name', $_SESSION['REALNAME']);
        $smarty->assign("arr_field_value", $Arr);
        $smarty->assign('default_date', date("Y-m-d"));
        $pk = $this->_modelDefault->primaryKey;
        $primary_key = (isset($_GET[$pk])?$pk:"");
        $smarty->assign("pk", $primary_key);
        $smarty->display('Trade/OrderEdit.tpl');
    }
    // ***************************订单登记 begin*********************************
    // /1.0 给控件填充信息
    // /2.0 主从表界面的展示
    // /3.0
    function actionAdd() {
        $this->authCheck('1-1');
        // 生成业务员信息
        // $m_jichu_employ = &FLEA::getSingleton('Model_Jichu_Employ');
        // $sql = "select * from jichu_employ where 1";
        // $rowset = $m_jichu_employ->findBySql($sql);
        // foreach($rowset as &$v) {
        // 	// *根据要求：options为数组,必须有text和value属性
        // 	$rowsTrader[] = array('text' => $v['employName'], 'value' => $v['id']);
        // }
        // 主表信息字段
        $fldMain = $this->fldMain;
        // *在主表字段中加载业务员选项*
        //$fldMain['traderId']['options'] = $rowsTrader;
        // *订单号的默认值的加载*
        $fldMain['orderCode']['value'] = $this->_modelDefault->getNewOrderCode();
        $orderCode = $fldMain['orderCode']['value'];
        $m_jichu_employ = &FLEA::getSingleton('Model_Jichu_Employ');
        $employId=$_SESSION['USERID'];
        $sql = "select traderId  from acm_user2trader where userId = {$employId}";
        $row = $m_jichu_employ->findBySql($sql);
        $rowset = $m_jichu_employ->find(array('id'=>$row[0]['traderId']));
        if ($rowset['codeAtEmploy']) {
            $fldMain['orderCode']['value'].= $rowset['codeAtEmploy'];
        }
        $fldMain['traderId']['value'] = $row[0]['traderId'];
        // dump($fldMain);exit;
        $headSon = $this->headSon;
        // 从表信息字段,默认5行
        for($i = 0;$i < 5;$i++) {
            $rowsSon[] = array(
                );
        }
        // 主表区域信息描述
        $areaMain = array('title' => '订单基本信息', 'fld' => $fldMain);
        // 从表区域信息描述
        $smarty = &$this->_getView();
        $smarty->assign('areaMain', $areaMain);
        $smarty->assign('headSon', $headSon);
        $smarty->assign('rowsSon', $rowsSon);
        $smarty->assign('rules', $this->rules);
        // 合同备注
        $arrMemo = array('memoTrade' => array('title' => '经营要求', 'type' => 'textarea', 'disabled' => true, 'name' => 'memoTrade'),
            'memoYongjin' => array('title' => '佣金备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'memoYongjin'),
            'memoWaigou' => array('title' => '外购备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'memoWaigou'),

            );
        // 合同条款
        $arrItem = array('orderItem1' => array('title' => '第二条 质量标准', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem1', 'value' => '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。'),
            'orderItem2' => array('title' => '第三条 包装标准', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem2', 'value' => '塑料薄膜包装。特殊要求另行协商。'),
            'orderItem3' => array('title' => '第四条 交货数量', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem3', 'value' => '大货数量允许 ±3%。'),
            'orderItem4' => array('title' => '第五条 交货方式', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem4', 'value' => '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。'),
            'orderItem5' => array('title' => '第六条 交货时间', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem5', 'value' => '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。'),
            'orderItem6' => array('title' => '第七条 结算方式', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem6', 'value' => '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。'),
            'orderItem7' => array('title' => '第八条 争议解决', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem7', 'value' => '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；'),
            );
        $smarty->assign("arr_memo", $arrMemo);
        $smarty->assign("arr_item", $arrItem);
        $smarty->assign("orderCode", $orderCode);
        $smarty->assign("tbl_son_width", '120%');
        $smarty->assign("sonTpl2", 'Trade/_addInfoJs.tpl');
        $smarty->assign("otherInfoTpl", 'Trade/otherInfoTpl.tpl');
        $smarty->display('Main2Son/T1.tpl');
    }
    // ***************************订单登记 end*********************************
    // ***************************订单编辑 begin*********************************
    function actionEdit() {
        // $pk=$this->_modelDefault->primaryKey;
        $arr = $this->_modelDefault->find(array('id' => $_GET['id']));
        //dump($arr);exit;
        foreach ($this->fldMain as $k => &$v) {
            $v['value'] = $arr[$k];
            // $arr[$k] =
        }
        $this->fldMain['orderId']['value'] = $arr['id'];
        // $this->fldMain['orderId']['orderMemo'] = $arr['memo'];
        $this->fldMain['clientId']['clientName'] = $arr['Client']['compName'];
        $this->fldMain['finalDate']['value'] = $arr['Products']['0']['dateJiaohuo'];
        // dump($this->fldMain);exit;
        // otherInfoTpl中数据处理
        $otherInfo = array('memo' => $arr['orderMemo'], // 备注
            'memoTrade' => $arr['memoTrade'], // 经营要求
            'memoYongjin' => $arr['memoYongjin'], // 佣金备注
            'memoWaigou' => $arr['memoWaigou'], // 外购备注
            'orderItem1' => $arr['orderItem1'],
            'orderItem2' => $arr['orderItem2'],
            'orderItem3' => $arr['orderItem3'],
            'orderItem4' => $arr['orderItem4'],
            'orderItem5' => $arr['orderItem5'],
            'orderItem6' => $arr['orderItem6'],
            'orderItem7' => $arr['orderItem7'],
            );


        $areaMain = array('title' => '订单基本信息', 'fld' => $this->fldMain);
        // 订单明细处理
        // 订单明细的产品信息处理
        // dump($arr['Products']);exit;
        foreach($arr['Products'] as &$v) {
            // dump($v);exit;
            $sql = "select * from jichu_product where id='{$v['productId']}'";
            $_temp = $this->_modelDefault->findBySql($sql);
            $v['proCode'] = $_temp[0]['proCode'];
            $v['proName'] = $_temp[0]['proName'];
            $v['guige'] = $_temp[0]['guige'];
            $v['color']=$_temp[0]['color'];
            // dump($_temp);exit;
            $v['money'] = round($v['danjia'] * $v['cntYaohuo'], 2);
            // $v['']
        }
        // dump($arr['Products']);exit;
        foreach($arr['Products'] as &$v) {
            $temp = array();
            foreach($this->headSon as $kk => &$vv) {
                $temp[$kk] = array('value' => $v[$kk]);
            }
            $rowsSon[] = $temp;
        }

        //补齐5行
        $len = count($rowsSon);
        for($i=5;$i>$len;$i--) {
            $rowsSon[] = array();
        }
        //dump($rowsSon);exit;
        //查到到本单的业务员编号
        $sql = "select codeAtEmploy from jichu_employ where id={$arr['traderId']}";
        $codeAtEmploy=$this->_modelDefault->findBySql($sql);
        $codeAtEmploy = $codeAtEmploy[0]['codeAtEmploy'];
        $orderCode = str_replace($codeAtEmploy,'',$arr['orderCode']);
        //dump($orderCode);exit();
        $smarty = &$this->_getView();
        $smarty->assign('areaMain', $areaMain);
        $smarty->assign('otherInfo', $otherInfo);
        $smarty->assign('orderCode', $orderCode);
        $smarty->assign('headSon', $this->headSon);
        $smarty->assign('rowsSon', $rowsSon);
        $smarty->assign('rules', $this->rules);
        // 合同备注
        $arrMemo = array('memoTrade' => array('title' => '经营要求', 'type' => 'textarea', 'disabled' => true, 'name' => 'memoTrade', 'value' => $arr['memoTrade']),
            'memoYongjin' => array('title' => '佣金备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'memoYongjin', 'value' => $arr['memoYongjin']),
            'memoWaigou' => array('title' => '外购备注', 'type' => 'textarea', 'disabled' => true, 'name' => 'memoWaigou', 'value' => $arr['memoWaigou']),

            );
        // 合同条款
        $arrItem = array('orderItem1' => array('title' => '第二条 质量标准', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem1', 'value' => $arr['orderItem1']),
            'orderItem2' => array('title' => '第三条 包装标准', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem2', 'value' => $arr['orderItem2']),
            'orderItem3' => array('title' => '第四条 交货数量', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem3', 'value' => $arr['orderItem3']),
            'orderItem4' => array('title' => '第五条 交货方式', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem4', 'value' => $arr['orderItem4']),
            'orderItem5' => array('title' => '第六条 交货时间', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem5', 'value' => $arr['orderItem5']),
            'orderItem6' => array('title' => '第七条 结算方式', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem6', 'value' => $arr['orderItem6']),
            'orderItem7' => array('title' => '第八条 争议解决', 'type' => 'textarea', 'disabled' => true, 'name' => 'orderItem7', 'value' => $arr['orderItem7']),
            );
        $smarty->assign("arr_memo", $arrMemo);
        $smarty->assign("arr_item", $arrItem);
        $smarty->assign("tbl_son_width",'120%');
        $smarty->assign("sonTpl2", 'Trade/_addInfoJs.tpl');
        $smarty->assign("otherInfoTpl", 'Trade/otherInfoTpl.tpl');
        $smarty->display('Main2Son/T.tpl');
    }
    // ***************************订单编辑 end*********************************
    function actionCopy() {
        $pk = $this->_modelDefault->primaryKey;
        $arr = $this->_modelDefault->find($_GET[$pk]);

        $arr['id'] = '';
        $arr['orderCode'] = $this->_modelDefault->getNewOrderCode();

        if (count($arr['Products']) > 0) foreach($arr['Products'] as &$v) {
            $mPro = &FLEA::getSingleton('Model_Jichu_Product');
            $row = $mPro->find($v['productId']);
            $v['proName'] = $row['proName'];
            $v['guige'] = $row['guige'];

            $v['id'] = '';
            $v['orderId'] = '';
        }
        // dump($arr);
        $this->_edit($arr);
    }

    function actionRemove() {
        $this->authCheck($this->funcId);
        $pk = $this->_modelDefault->primaryKey;
        $this->_modelDefault->removeByPkv($_GET[$pk]);
        redirect($this->_url('right'));
    }
    // 编辑界面利用ajax删除
    function actionRemoveByAjax() {
        $m = &FLEA::getSingleton('Model_Trade_Order2Product');
        $r = $m->removeByPkv($_POST['id']);
        if (!$r) {
            $arr = array('success' => false, 'msg' => '删除失败');
            echo json_encode($arr);
            exit;
        }
        $arr = array('success' => true);
        echo json_encode($arr);
        exit;
    }
    // ********************************数据保存 begin********************************
    function actionSave() {
        //dump($_POST); EXIT;

        // ~~半成品与成品明细登记时 不允许成品和半成品同时存在 ，如果存在则禁止保存~~
        // dump($_POST); EXIT;
        //首次保存时判断是否存在orderCode
        if(empty($_POST['orderId'])){
            $odCode = substr($_POST['orderCode'],0,-1);
            //取到业务员代码
            $employDm = substr($_POST['orderCode'],-1);
            $sql1 = "select * from trade_order where orderCode like '%{$odCode}%'";
            $ar1 = $this->_modelExample->findBySql($sql1);
            if($ar1[0]){
                //已经存在相同编号的情况
                $_POST['orderCode'] = $this->getOrderCode($odCode,$employDm);
            }else{
                //不存在相同编号，就正常返回post值
                $_POST['orderCode'] = $_POST['orderCode'];
            }
        }
        //dump($_POST['orderCode']);die;
        //首次保存时 判断是否已存在ordercode以及orderId是否为空
        // $res=$this->_modelExample->findAll(array('orderCode'=>$_POST['orderCode']));
        // if(count($res)>0&&empty($_POST['orderId'])){
        //     js_alert(null, 'window.parent.showMsg("订单编号已存在，请重新登记！");', $this->_url('add'));exit;
        // }


        // trade_order2product 表 的数组
        $trade_order2product = array();
        foreach ($_POST['productId'] as $key => $v) {
            // 当没有记录 或者 没有输入数量时 跳出本次循环 防止多保存
            if (empty($_POST['productId'][$key]) || empty($_POST['cntYaohuo'][$key])) continue;
            $trade_order2product[] = array('id' => $_POST['id'][$key], // 主键id
                'productId' => $_POST['productId'][$key], // 产品id
                'supplierId' => $_POST['supplierId'][$key]+0, // 产品id
                'cntYaohuo' => $_POST['cntYaohuo'][$key], // 要货数量
                'color' => $_POST['color'][$key], // 颜色
                'unit' => $_POST['unit'][$key], // 单位
                'danjia' => $_POST['danjia'][$key], // 单价
                'memo' => $_POST['memo'][$key] . '', // 备注
                'dateJiaohuo' => $_POST['finalDate'], // 交货日期
                'jixing'=>$_POST['jixing'][$key] ,
                );
        }

        //dump($trade_order2product);exit;
        if(count($trade_order2product)==0) {
            js_alert('未发现有效的产品明细','window.history.go(-1)');
            exit;
        }
        // trade_order 表 的数组
        $trade_order = array(
            'id' => $_POST['orderId'], // 主键id
            'orderCode' => $_POST['orderCode'], // 订单号
            'orderDate' => $_POST['orderDate'], // 签订日期
            'finalDate'=>$_POST['finalDate'],                //最终交期
            'traderId' => $_POST['traderId'], // 业务员id
            'clientId' => $_POST['clientId'], // 客户id
            'clientOrder' => $_POST['clientOrder'], // 客户合同号
            'xsType' => $_POST['xsType'], // 内外销
            'pichang' => $_POST['pichang'], // 匹长
            'overflow' => $_POST['overflow'], // 溢短装
            'warpShrink' => $_POST['warpShrink'], // 经向缩率
            'weftShrink' => $_POST['weftShrink'], // 纬向缩率
            'packing' => $_POST['packing'], // 包装要求
            'checking' => $_POST['checking'], // 检验要求
            'moneyDayang' => $_POST['moneyDayang'], // 打样收费
            'bizhong' => $_POST['bizhong'], // 币种
            'memo' => $_POST['orderMemo'] . '', // 备注
            'memoTrade' => $_POST['memoTrade'], // 经营要求
            'memoYongjin' => $_POST['memoYongjin'], // 佣金备注
            'memoWaigou' => $_POST['memoWaigou'], // 外购备注
            'orderItem1' => $_POST['orderItem1'],
            'orderItem2' => $_POST['orderItem2'],
            'orderItem3' => $_POST['orderItem3'],
            'orderItem4' => $_POST['orderItem4'],
            'orderItem5' => $_POST['orderItem5'],
            'orderItem6' => $_POST['orderItem6'],
            'orderItem7' => $_POST['orderItem7'],
            );
        // 表之间的关联
        $trade_order['Products'] = $trade_order2product;
        // 保存 并返回trade_order表的主键
        // dump($trade_order);exit;
        $itemId = $this->_modelExample->save($trade_order);
        if ($itemId) {
            js_alert(null, 'window.parent.showMsg("保存成功！");', $this->_url('right'));
        }else die('保存失败!');
    }

    public function GetOrderCode($orderCode,$employM){
        //dump($orderCode);die;
        //订单号获取，如果订单表里已经存在，那么订单号自动+1
        $od = substr($orderCode,2);
        $odAdd = $od+1;
        return 'DS'.$odAdd.$employM;
    }
    // ********************************数据保存 end********************************
    function actionGetYlJson() {
        $sql = "select
m.*,sum(y.cnt*x.cnt*z.ylCnt) as ylCnt,z.ylId as ylId,ifnull(a.kucunCnt,0) as kucunCnt
from trade_order2product x
inner join jichu_pro2chengpin y on x.productId=y.chengpinId
inner join jichu_product2yl z on y.proId=z.productId
inner join jichu_yl m on z.ylId=m.id
left join cangku_yl_init a on m.id=a.ylId
where x.orderId='{$_GET['orderId']}'
group by z.ylId";
        // echo $sql;exit;
        $rowset = $this->_modelExample->findBySql($sql);
        // dump($rowset);
        echo json_encode($rowset);
        exit;
    }
    // ********************************订单弹出后台 begin********************
    // /从色坯纱管理中弹出订单，只能选择色纱和坯纱， 用isSePiSha=1来标示
    // /从成品管理中弹出订单，只能选择坯布和其他
    function actionPopup() {
        FLEA::loadClass('TMIS_Pager');
        // /构造搜索区域的搜索类型
        $serachArea = TMIS_Pager::getParamArray(array('dateFrom' => date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))),
                'dateTo' => date("Y-m-d"),
                //'clientId' => '',
                //'traderId' => '',
                'orderCode' => '',
                'key' => '',
                ));
        // /查询sql语句
        $sql = "select y.orderCode,
           y.orderDate,
           y.clientId,
           y.traderId,
           y.clientOrder,
           y.isCheck,
           x.id,
           x.orderId as orderId,
           x.productId,
           x.danjia,
           x.cntYaohuo,
           x.unit
               from trade_order2product x
               left join trade_order y on (x.orderId = y.id)";

        $str = "select
        x.orderId,
        x.orderCode,
        x.orderDate,
        x.clientId,
        x.traderId,
        x.productId,
        x.clientOrder,
        x.cntYaohuo,
        x.danjia,
        x.danjia*x.cntYaohuo as money,
        x.isCheck,
        x.unit,
        y.id,
        y.compName,
        z.proCode,
        z.proName,
        z.guige,
        z.kind,
        z.color,
        m.employName
        from (" . $sql . ") x
        left join jichu_client y on x.clientId = y.id
        left join jichu_product z on x.productId = z.id
        left join jichu_employ m on m.id=x.traderId
        where 1 ";
        // /判断是从哪个页面进入的
        if (isset($_GET['isSePiSha'])) {
            if ($_GET['isSePiSha'] == 1) {
                $str .= " and z.kind in ('坯纱','色纱')";
            }
        }elseif (isset($_GET['isChengPing'])) {
            if ($_GET['isChengPing'] == 1) {
                $str .= " and z.kind in ('坯布','其他')";
            }
        }

        $str .= " and orderDate >= '$serachArea[dateFrom]' and orderDate<='$serachArea[dateTo]'";
        if ($serachArea['key'] != '') $str .= " and (x.orderCode like '%$serachArea[key]%'
                        or z.proName like '%$serachArea[key]%'
                        or z.proCode like '%$serachArea[key]%'
                        or z.guige like '%$serachArea[key]%')";
        if ($serachArea['orderCode'] != '') $str .= " and x.orderCode like '%$serachArea[orderCode]%'";
        //if ($serachArea['clientId'] != '') $str .= " and x.clientId = '$serachArea[clientId]'";
        //if ($serachArea['traderId'] != '') $str .= " and x.traderId = '$serachArea[traderId]'";
        $str .= " order by orderDate desc, orderCode desc";
         // dump($str);exit;
        $pager = &new TMIS_Pager($str);
        $rowset = $pager->findAll();

        if (count($rowset) > 0) foreach($rowset as $i => &$v) {
            $v['cnt'] -= $cnt;
            $v['danjia'] = round($v['danjia'], 2);
            $v['money'] = round($v['money'], 2);
        }
        $arrFieldInfo = array(
            //'orderId'=>'id',
            "orderCode" => "单号",
            "orderDate" => "日期",
            //"compName" => "客户名称",
            'proCode' => '产品编码',
            'proName' => '产品名称',
            'guige' => '规格',
            'unit'=>'单位',
            "cntYaohuo" => '数量',
            // "danjia" =>'单价',
            // "money" =>'金额'
            );
        $smarty = &$this->_getView();
        $smarty->assign('title', '选择客户');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('pk', $pk);
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_field_info', $arrFieldInfo);
        $smarty->assign('arr_field_value', $rowset);
        $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
        $smarty->assign('arr_condition', $serachArea);
        $smarty->assign('page_info', $pager->getNavBar($this->_url('Popup', $serachArea)));
        $smarty->display('Popup/CommonNew.tpl');
    }
    // ********************************订单弹出后台 end********************
    function actionGetJsonById() {
        $mPro = &FLEA::getSingleton("Model_Jichu_Product");
        $order = $this->_modelDefault->find(array('id' => $_GET['orderId']));
        // dump($order);exit;
        if ($order['Products']) foreach($order['Products'] as $i => &$v) {
            $sql = "select sum(cnt)as cnt from cangku_chuku2product where order2productId = '{$v['id']}' group by order2productId ";
            $cnt = $this->_modelDefault->findBySql($sql);
            $cnt = $cnt[0]['cnt'];
            if ($cnt >= $v['cnt']) {
                unset($order['Products'][$i]);
                continue;
            }

            $v['cnt'] -= $cnt;
            $v['money'] = $v['cnt'] * $v['danjia'];
            $v['Pro'] = $mPro->find(array('id' => $v['productId']));
        }
        $newOrder = $order;
        $newOrder['Products'] = '';
        foreach ($order['Products'] as $i => &$v) {
            $newOrder['Products'][] = $v;
        }
        // dump($newOrder);exit;
        echo json_encode($newOrder);
        exit;
    }
    // 客户对账单
    function actionDuizhang() {
        // $this->authCheck(113);
        $title = '客户对账单';
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array('dateFrom' => date('Y-m-01'),
                'dateTo' => date("Y-m-d"),
                // 'key'			=>'',
                'clientId' => '',
                'proId' => ''
                ));

        $sql = "select
a.compName,z.dateGuozhang,b.*,x.cnt,z.money,z.money/x.cnt as danjia
from cangku_chuku2product x
inner join cangku_chuku y on x.chukuId=y.id
inner join jichu_product b on x.productId=b.id
inner join caiwu_ar_guozhang z on x.guozhangId=z.id
left join jichu_client a on z.clientId=a.id
where x.guozhangId>0 and z.dateGuozhang>='{$arr['dateFrom']}' and z.dateGuozhang<='{$arr['dateTo']}'";
        $sql .= " and z.clientId='{$arr['clientId']}'";
        // if($arr['traderId']>0) $sql .= " and y.traderId='{$arr['traderId']}'";
        if ($arr['proId'] > 0) $sql .= " and x.productId='{$arr['proId']}'";
        // $sql .= " group by y.clientId,x.productId,y.traderId";
        // echo $sql;
        // $pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset = $this->_modelExample->findBySql($sql);
        // dump($rowset[0]);
        if (count($rowset) > 0) foreach($rowset as &$v) {
            $v['danjia'] = round($v['danjia'], 2);
            $v['cnt'] = round($v['cnt'], 2);
            $v['money'] = round($v['money'], 2);
        }
        // 合计行
        $heji = $this->getHeji($rowset, array('cnt', 'money'), 'compName');
        $rowset[] = $heji;

        $smarty = &$this->_getView();
        // 客户，单据日期，单据类型，单据号，货品编号，货品名称，规格，单位，数量，单价，金额
        // 搜索项：客户，快捷查询，日期，货品。
        $arrFieldInfo = array("compName" => "客户名称",
            "dateGuozhang" => "过账日期",
            // "compName" =>"出库单号",
            "proCode" => "货品编号",
            'proName' => '名称',
            'guige' => '规格',
            'unit' => '单位',
            'cnt' => '数量',
            'danjia' => '单价',
            "money" => "总金额"
            );

        $smarty->assign('title', $title);
        // $smarty->assign('pk', $this->_modelDefault->primaryKey);
        $smarty->assign('arr_field_info', $arrFieldInfo);
        $smarty->assign('add_display', 'none');
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_value', $rowset);
        // $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arrGet)));
        $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('calendar')));
        $smarty->display('TableList2.tpl');
    }
    // 应收账款余额查询
    function actionYingshou() {
        // $this->authCheck(114);
        redirect(url('Caiwu_Ar_Report', 'month'));
    }
    // 超账期应收款查询
    function actionChaoqi() {
    }
    // 测试bootstrap的代码
    function actionAddTest() {
        // 生成业务员信息
        $sql = "select * from jichu_employ where 1";
        $rowset = $this->_modelDefault->findBySql($sql);
        foreach($rowset as &$v) {
            $rowsTrader[] = array('text' => $v['employName'], 'value' => $v['id']);
        }
        // 主表信息字段
        $fldMain = array('orderCode' => array('title' => '订单编号', "type" => "text", 'readonly' => true, 'value' => $this->_modelDefault->getNewOrderCode()),
            'dateOrder' => array('title' => '订单日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
            // options为数组,必须有text和value属性
            'traderId' => array('title' => '业务负责', 'type' => 'select', 'options' => $rowsTrader, 'selected' => 'a'),
            'daoKuanDate' => array('title' => '到款日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
            'clientOrderCode' => array('title' => '客户单号', 'type' => 'text', 'value' => ''),
            'proKind' => array('title' => '产品类型', 'type' => 'select', 'selected' => '', 'options' => array(
                    array('text' => '成品', 'value' => '0'),
                    array('text' => '半成品', 'value' => '1'),
                    )),
            // clientpopup需要显示客户名称,所以需要定义clientName属性,value属性作为clientId用
            'clientId' => array('title' => '客户名称', 'type' => 'clientpopup', 'clientName' => ''),
            'xsType' => array('title' => '内/外销', 'type' => 'select', 'selected' => '', 'options' => array(
                    array('text' => '内销', 'value' => '内销'),
                    array('text' => '外销', 'value' => '外销'),
                    )),
            'orderMemo' => array('title' => '订单备注', 'type' => 'textarea', 'disabled' => true),
            // 下面为隐藏字段
            'orderId' => array('type' => 'hidden', 'value' => ''),
            );
        // 从表表头信息
        // type为控件类型,在自定义模板控件
        // title为表头
        // name为控件名
        $headSon = array('_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
            'productId' => array('type' => 'btproductpopup', "title" => '产品编码', 'name' => 'productId[]'),
            'proName' => array('type' => 'bttext', "title" => '品名', 'name' => 'proName[]', 'readonly' => true),
            'guige' => array('type' => 'bttext', "title" => '规格', 'name' => 'guige[]', 'readonly' => true),
            'unit' => array('type' => 'bttext', "title" => '单位', 'name' => 'unit[]', 'readonly' => true),
            'cnt' => array('type' => 'bttext', "title" => '数量', 'name' => 'cnt[]'),
            'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
            'money' => array('type' => 'bttext', "title" => '金额(元)', 'name' => 'money[]', 'readonly' => true),
            'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'),
            // ***************如何处理hidden?
            'id' => array('type' => 'bthidden', 'name' => 'id[]'),
            );
        // 从表信息字段
        $rowsSon = array(
            array('productId' => array('value' => ''),
                'proName' => array('value' => ''),
                'guige' => array('value' => ''),
                'unit' => array('value' => ''),
                'cnt' => array('value' => ''),
                'danjia' => array('value' => ''),
                'money' => array('value' => ''),
                'memo' => array('value' => ''),
                // 从表中有时需要hidden控件的。
                'id' => array('value' => ''),
                ),
            );
        // 主表区域信息描述
        $areaMain = array('title' => '订单基本信息', 'fld' => $fldMain);
        // 从表区域信息描述
        $areaSon = array('title' => '产品信息', 'fld' => $fldSon);

        $smarty = &$this->_getView();
        $smarty->assign('areaMain', $areaMain);
        $smarty->assign('headSon', $headSon);
        $smarty->assign('rowsSon', $rowsSon);

        $smarty->display('Main2Son/T.tpl');
    }

    /**
     * 打印定产单
     */
    function actionPrintDingchan() {
        $m = & FLEA::getSingleton('Model_Trade_Order2Product');
        $ord2proId = $_GET['ord2proId'];
        $ord2pro = $m->find(array('id'=>$ord2proId));
        $order = $ord2pro['Order'];
        $mC = & FLEA::getSingleton('Model_Jichu_Client');
        $client = $mC->find(array('id'=>$order['clientId']));
        $product = $ord2pro['Products'];
        $product['fontSize'] = mb_strlen($product['guige'])>40?'2':1;
        // dump($product);exit;

        $mShenhe = & FLEA::getSingleton('Model_Trade_Shenhe');
        $row = $mShenhe->find(array('ord2proId'=>$ord2proId));
        $sh = unserialize($row['serialStr']);
        //dump($sh['ceshiMenfu']);exit();

        $order['checkingMan'] = '';
        $modelEmploy = &FLEA::getSingleton("Model_Jichu_Employ");
        if(is_numeric($order['checking'])){
            $employInfo = $modelEmploy->find(array('id'=>$order['checking']));
            $order['checkingMan'] = $employInfo['employName'];
        }
        $arr=array(
                'id'=>$ord2pro['orderId'],
                'isExport'=>1,
        );
        $this->_modelDefault->save($arr);

        $this->exportWithXml('Trade/Dingchan.xml',array(
            'order'=>$order,
            'ord2pro'=>$ord2pro,
            'product'=>$product,
            'client'=>$client,
            'sh'=>$sh,
        ));

    }

    /**
     * 在成品生产入库时弹出选择订单后，需要利用ajax根据orderId得到所有订单明细
     */
    function actionGetMinxiByOrderId() {
        $orderId = $_POST['orderId'];
        if($orderId=='') {
            echo json_encode(array('success'=>false,'msg'=>'订单号为空'));
            exit;
        }

        $order = $this->_modelExample->find(array('id'=>$orderId));
        foreach($order['Products'] as & $v) {
            $sql = "select * from jichu_product where id='{$v['productId']}'";
            $_temp = $this->_modelExample->findBySql($sql);
            $v['ord2proId'] = $v['id'];
            $v['proCode'] = $_temp[0]['proCode'];
            $v['proName'] = $_temp[0]['proName'];
            $v['guige'] = $_temp[0]['guige'];
            $v['color'] = $_temp[0]['color'];
        }

        // $sql = "select * from trade_order where id='{$orderId}'";
        // $_rows = $this->_modelExample->findBySql($sql);
        // $order = $_rows[0];

        // $sql = "select
        // x.id as ord2proId,x.orderId as orderId,x.productId,
        // y.proCode,y.proName,y.guige
        // from trade_order2product x
        // left join jichu_product y on x.productId=y.id
        // where x.orderId='{$orderId}'";
        // $order['Products'] = $this->_modelExample->findBySql($sql);
        echo json_encode(array('success'=>true,'order'=>$order));
        exit;
    }

    //订单审核,按订单明细显示
    function actionShenheList() {
        // $this->authCheck('3-3');
        FLEA::loadClass('TMIS_Pager');
        // /构造搜索区域的搜索类型
        $arr = TMIS_Pager::getParamArray(array(
            'dateFrom' => date("Y-m-01"),
            'dateTo' => date("Y-m-d"),
            'isCheck' => 2,
            'isOver' => 0,
            'orderCode'=>'',
            'traderId'=>'',
            'gendanyuan' =>'',
            'key' => '',
        ));
        $arrFieldInfo = array(
            "_edit" => '审核',
            "_isOver" => '是否完成',
            'orderCode' => '生产编号',
            // "compName" => "客户名称",
            'employName' => '业务员',
            'checkingMan' => '跟单',
            'proCode' => '产品编码',
            'proName' => '品名',
            'guige' => '规格',
            'color'=>'颜色',
            "cntYaohuo" => '要货数量',
            "unit" => '单位',
            "dateJiaohuo" => "交货日期",
            "orderDate" => "下单日期",
            // "danjia" => '单价',
            // "money" => '金额',
            // "memo" =>'产品备注'
            );
        $str="select x.* ,
                 (case when sh.isCheck is Null then 0 else sh.isCheck end) as isCheck
                 from trade_order2product x
                 left join trade_order_shenhe sh on sh.ord2proId=x.id";
        $sql = "select
                   y.isOver,
                   y.orderDate,
                   y.orderCode,
                   y.id as orderId,
                   y.checking,
                   x.id,
                   x.dateJiaohuo,
                   x.cntYaohuo,
                   x.unit,
                   x.isCheck,
                   b.employName,
                   z.proCode,
                   z.proName,
                   z.guige,
                   z.color,
                   g.employName as checkingMan
        from (" . $str . ") x
        left join trade_order y on x.orderId=y.id
        left join jichu_product z on x.productId=z.id
        left join jichu_employ b on y.traderId=b.id
        left join jichu_client jc on jc.id=y.clientId
        left join jichu_employ g on g.id=y.checking
        where 1
        ";
        $sql .= " and orderDate >= '{$arr['dateFrom']}' and orderDate<='{$arr['dateTo']}'";
        if ($arr['key'] != '') $sql .= " and (z.proCode like '%{$arr['key']}%' or z.proName like '%{$arr['key']}%' or z.guige like '%{$arr['key']}%')";
        if ($arr['isCheck'] !=2) $sql .= " and x.isCheck = '$arr[isCheck]'";
        if ($arr['orderCode'] !='') $sql .= " and y.orderCode like '%{$arr['orderCode']}%'";
        if ($arr['isOver'] <2) $sql .= " and y.isOver = '$arr[isOver]'";
        if ($arr['traderId'] !=''){
            $sql1 = "select employName from jichu_employ where id='{$arr[traderId]}'";
            $employNames1 = $this->jichu_employ->findBySql($sql1);
            $sql .= " and b.employName = '{$employNames1[0]['employName']}'";
        }
        if ($arr['gendanyuan']>2) {
            $sql .= " and y.checking = '{$arr['gendanyuan']}'";
        }
// 		dump($str);dump($sql);exit;
        // dump($sql);
        //该用户关联的业务员的订单
        $mUser = & FLEA::getSingleton('Model_Acm_User');
        if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
            //得到当前用户匹配的员工id
            $traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
            if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
                $sql .= " and 0";
            } else {
                $s = join(',',$traderIds);
                $sql .= " and y.traderId in ({$s})";
            }
        }

        $sql .= " order by y.orderCode desc,x.id";
        //得到总计
//        $zongji = $this->getZongji($sql,array('cnt'=>'x.cntYaohuo','money'=>'x.money'));
//         dump($sql);exit;
        $pager = &new TMIS_Pager($sql);
        $rowset = $pager->findAll();
        // dump($rowset);die;
        if (count($rowset) > 0) foreach($rowset as &$v) {
            $v['_edit'] = "<a href='".$this->_url('shenhe',array(
                'ord2proId'=>$v['id'],
                'isCheck'=>$v['isCheck']
            ))."'>审核</a>";
            // if($v['isCheck']==1) $v['_bgColor'] = 'pink';

            //设置完成
            $v['_isOver'].="  <a href='".$this->_url('IsOver',array('id'=>$v['orderId'],'isOver'=>($v['isOver']==0?1:0)))."'>".($v['isOver']==0?'设置完成':'取消完成')."</a>";
            if($v['isOver']==1) $v['_bgColor'] = 'pink';
        }
        // 合计行
        $heji = $this->getHeji($rowset, array('cnt','cntYaohuo'), '_edit');
        $rowset[] = $heji;


        $smarty = &$this->_getView();
        $smarty->assign('title', '订单查询');

        $smarty->assign('arr_field_info', $arrFieldInfo);
        $smarty->assign('add_display', $isShowAdd?'display':'none');
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_value', $rowset);
        //2017年03月01日 输出列中没有金额项（未做总计），隐藏显示
        //"<font color='red'>数量总计:{$zongji['cnt']},金额总计:{$zongji['money']}</font>";
        $msg = "";
        $smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $arr).$msg);
        $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
        $this->_beforeDisplayRight($smarty);
        $smarty->display('TableList.tpl');
    }

    function actionIsOver() {
        $this->authCheck('1-3-9');//设置权限
        $arr = array (
                'id' => $_GET ['id'],
                'isOver' => $_GET ['isOver']
        );
// 		dump($_GET);exit;
        $this->_modelExample->save ($arr);
        redirect ( $this->_url ( 'ShenheList' ) );
    }

    /**
     * 开始审核
     * 1,不同身份的人进入可输入的内容不同,
     * 2,可点击的审核按钮不同
     * 3,已审核的按钮显示审核时间并可取消审核
     */
    function actionShenhe() {
// 		dump($_POST);exit;
        $arrEnable = array(
            '1-3-1'=>array(
                'subTrader',
                'memoTrade',
                'returnBack',
            ),//业务员对id=subTrader的元素可编辑
            '1-3-2'=>array(//跟单审核
                'subGendan',
                'memoTrade',
                'memo2',//跟单备注
                'memo3',//其他备注
                'returnBack',
            ),
            '1-3-3'=>array(//**织造审核
                'subZhizao',
                'pibuMenfu',//坯布门幅
                'gongyiShuju',//工艺数据
                'pibuKeZhong',//坯布克重
                'pibuXianChang',//坯布线长
                'pibuChengfen',//坯布成分
                'shazhi1',//纱支1
                'bilv1',//比率1
                'jihuaYongSha1',//计划用纱1.05%
                'shaqingkuang1',//纱情况
                'sunhao1',//用纱损耗
                'shazhi2',
                'bilv2',
                'jihuaYongSha2',
                'shaqingkuang2',
                'sunhao2',
                'shazhi3',
                'bilv3',
                'jihuaYongSha3',
                'shaqingkuang3',
                'sunhao3',
                'shazhi4',
                'bilv4',
                'jihuaYongSha4',
                'shaqingkuang4',
                'sunhao4',
                'shazhi5',
                'bilv5',
                'jihuaYongSha5',
                'shaqingkuang5',
                'sunhao5',
                'jitaihao',//机台号
                // 'cipinshuliang',//次品数量
                // 'wanchengDate',//完成日期
                'returnBack',
            ),
            '1-3-4'=>array(//定型审核
                'subDingxing',
                // 'pibuMenfu',

                'ceshiMenfu',//测缩门幅
                'ceshiKeZhong',//测缩克重
                'ceshiJingXiang',//经向缩率
                'ceshiWeiXiang',//纬向缩率
                'shifapibu',//实发坯布（匹）
                'shifaGongjin',//实发坯布公斤
                'chengbushuliang',//成布数量（匹）
                'chengbuGongjin',//成布公斤
                'yubushuliang',//余布数量（匹）
                'yubuGongjin',//余布公斤
                'yifashuliang',//已发数量
                'yifaGongjin',//已发公斤
                'dingxingSunhao',//定型损耗
                'returnBack',
            ),
            '1-3-5'=>array(//成品审核
                'subChengpin',
                'ChengbuMenfu',//成布门幅
                'ChengbuKeZhong',//成布克重
                'ChengbuShiJiMenfu',//成布实际门幅
                'ChengbuShiJiKeZhong',//成布实际克重
                // 'ChengbuMenfu',
                // 'ceshiMenfu',
                // 'shazhi1',
                // 'bilv1',
                // 'shazhi2',
                // 'bilv2',
                'returnBack',
            ),
            '1-3-6'=>array(//生产负责审核,可改所有数据
                'subShengchan',
                'memoTrade',

                'pibuMenfu',//坯布门幅
                'gongyiShuju',//工艺数据
                'pibuKeZhong',//坯布克重
                'pibuXianChang',//坯布线长
                'pibuChengfen',//坯布成分
                'shazhi1',//纱支1
                'bilv1',//比率1
                'jihuaYongSha1',//计划用纱1.05%
                'shaqingkuang1',//纱情况
                'sunhao1',//用纱损耗
                'shazhi2',
                'bilv2',
                'jihuaYongSha2',
                'shaqingkuang2',
                'sunhao2',
                'shazhi3',
                'bilv3',
                'jihuaYongSha3',
                'shaqingkuang3',
                'sunhao3',
                'shazhi4',
                'bilv4',
                'jihuaYongSha4',
                'shaqingkuang4',
                'sunhao4',
                'shazhi5',
                'bilv5',
                'jihuaYongSha5',
                'shaqingkuang5',
                'sunhao5',

                'ChengbuMenfu',//成布门幅
                'ChengbuKeZhong',//成布克重
                'ChengbuShiJiMenfu',//成布实际门幅
                'ChengbuShiJiKeZhong',//成布实际克重
                'ceshiMenfu',//测缩门幅
                'ceshiKeZhong',//测缩克重
                'ceshiJingXiang',//经向缩率
                'ceshiWeiXiang',//纬向缩率
                'shifapibu',//实发坯布（匹）
                'shifaGongjin',//实发坯布公斤
                'chengbushuliang',//成布数量（匹）
                'chengbuGongjin',//成布公斤
                'yubushuliang',//余布数量（匹）
                'yubuGongjin',//余布公斤
                'yifashuliang',//已发数量
                'yifaGongjin',//已发公斤
                'dingxingSunhao',//定型损耗
                'jitaihao',//机台号
                'memo',//生产备注
                'returnBack',
            ),
            '1-3-7'=>array(//最终审核
                'subZuizhong',
                'memoTrade',

                'pibuMenfu',//坯布门幅
                'gongyiShuju',//工艺数据
                'pibuKeZhong',//坯布克重
                'pibuXianChang',//坯布线长
                'pibuChengfen',//坯布成分
                'shazhi1',//纱支1
                'bilv1',//比率1
                'jihuaYongSha1',//计划用纱1.05%
                'shaqingkuang1',//纱情况
                'sunhao1',//用纱损耗
                'shazhi2',
                'bilv2',
                'jihuaYongSha2',
                'shaqingkuang2',
                'sunhao2',
                'shazhi3',
                'bilv3',
                'jihuaYongSha3',
                'shaqingkuang3',
                'sunhao3',
                'shazhi4',
                'bilv4',
                'jihuaYongSha4',
                'shaqingkuang4',
                'sunhao4',
                'shazhi5',
                'bilv5',
                'jihuaYongSha5',
                'shaqingkuang5',
                'sunhao5',

                'ChengbuMenfu',//成布门幅
                'ChengbuKeZhong',//成布克重
                'ChengbuShiJiMenfu',//成布实际门幅
                'ChengbuShiJiKeZhong',//成布实际克重
                'ceshiMenfu',//测缩门幅
                'ceshiKeZhong',//测缩克重
                'ceshiJingXiang',//经向缩率
                'ceshiWeiXiang',//纬向缩率
                'shifapibu',//实发坯布（匹）
                'shifaGongjin',//实发坯布公斤
                'chengbushuliang',//成布数量（匹）
                'chengbuGongjin',//成布公斤
                'yubushuliang',//余布数量（匹）
                'yubuGongjin',//余布公斤
                'yifashuliang',//已发数量
                'yifaGongjin',//已发公斤
                'dingxingSunhao',//定型损耗
                'jitaihao',//机台号
                'memo',//生产备注
                'memo2',//跟单备注
                'memo3',//其他备注
                'ischeck',//是否审核
                'returnBack',
            ),
        );
        $rowsE = array();
        foreach($arrEnable as $k=>&$v) {
            if($this->authCheck($k,true)) {//dump($k);
                foreach($v as & $vv) {
                    $rowsE[] = $vv;
                }
            }
        }//exit;
        array_unique($rowsE);
// 		 dump($rowsE);exit;

        $mShenhe = & FLEA::getSingleton('Model_Trade_Shenhe');
// 		dump($_POST);//exit;
        if($_POST) {
            //取得之前保存的所有审核人审核时间，防止重新保存时丢失
            $row = $mShenhe->find(array('ord2proId'=>$_POST['ord2proId']));//dump($_POST);exit;
            $sh = unserialize($row['serialStr']);//dump($sh);exit;

            $s = array();
            //得到序列化的数据
            foreach($sh as $k=>&$v) {
                // if(substr($k,0,3)=='sub') {
                // 	$s[$k] = $v;
                // }
                $s[$k] = $v;
            }
            //dump($s);exit;

            //处理提交数据
            foreach($_POST as $k=>&$v) {
                if($k=='btnSub' || $k=='ord2proId') continue;
                $s[$k] = $v;
                if(substr($k,0,3)=='sub') {
                    if($v=='取消') {
                        unset($s[$k]);
                        unset($s[$k.'Time']);
                    }
                    else {
                        //如果是提交按钮，改为当前用户，并新增审核时间
                        $s[$k] = $_SESSION['REALNAME'];
                        $s[$k.'Time'] = date('Y-m-d H:i:s');
                    }
                }
            }
// 			dump($s);exit;
            $row = $mShenhe->find(array('ord2proId'=>$_POST['ord2proId']));//dump($_POST['ischeck']);exit;
            $row['ord2proId'] = $_POST['ord2proId'];
            $row['isCheck'] = $_POST['ischeck'];
            //dump($s);exit;
            $row['serialStr'] = serialize($s);
// 			dump($row);exit;
            $mShenhe->save($row);
            if($_POST['subZuizhong'] == '最终审核'){
                $query ="update trade_order_shenhe set isCheck=1 where id='".$row['ord2proId']."'";
                mysql_query($query);
            }elseif($_POST['subZuizhong'] == '取消'){
                $query ="update trade_order_shenhe set isCheck=0 where id='".$row['ord2proId']."'";
                mysql_query($query);
            }

            js_alert(null,"window.parent.showMsg('审核成功!')",$this->_url('shenhe',array(
                'ord2proId'=>$_POST['ord2proId']
            )));
            exit;
        }
        //反序列化审核数据
        $row = $mShenhe->find(array('ord2proId'=>$_GET['ord2proId']));
        // dump($row);
        $sh = unserialize($row['serialStr']);
        // dump($sh);exit;
        $ord2proId = $_GET['ord2proId'];
        //得到订单信息
        $mSon = & FLEA::getSingleton('Model_Trade_Order2Product');
        $ord2pro = $mSon->find(array('id'=>$ord2proId));

        $ord2pro['Order']['checkingMan'] = '';
        $modelEmploy = &FLEA::getSingleton("Model_Jichu_Employ");
        if(is_numeric($ord2pro['Order']['checking'])){
            $employInfo = $modelEmploy->find(array('id'=>$ord2pro['Order']['checking']));
            $ord2pro['Order']['checkingMan'] = $employInfo['employName'];
        }

        //得到已审核的数据
        $sql = "select * from trade_order_shenhe x
        where ord2proId='{$ord2proId}'";
        $rowset = $this->_modelExample->findBySql($sql);
        //反序列化
//         dump($sh);dump($ord2pro);exit;

        //显示模板
        $smarty = & $this->_getView();
        $smarty->assign('ord2pro',$ord2pro);
        $smarty->assign('sh',$sh);

        $smarty->assign('rowsE',$rowsE);
        $smarty->display('Trade/OrderShenhe.tpl');
    }
    /**
     * 修复审核信息
     */
/* 	function actionUpdate(){
// 		$isUpdate = "";
// 		if(!$isUpdate){
            //查询数据库/判断数组中是否存在最终审核信息。isset()
            $sql = "select * from trade_order_shenhe";
            $rowset = $this->_modelExample->findBySql($sql);
            foreach($rowset as &$v){
            $sh = unserialize($v['serialStr']);
           // dump($vars);
            if ($sh['subZuizhong']!='') {
            $query ="update trade_order_shenhe set isCheck=1 where id='".$v['id']."'";
            mysql_query($query);
                }
            }
            echo "修复成功!!!!";
// 		}else{
// 			echo "已经修复成功，无需重复更新！！！！！！";
// 		}
    } */

    //保存审核中的备注信息

    function actionSaveMemo(){
        //dump($_GET);exit;
        $sql="update trade_order2product set memo='{$_GET['memo']}' where id='{$_GET['id']}'";
        $sql="update trade_order2product set memo2='{$_GET['memo2']}' where id='{$_GET['id']}'";
        $this->_modelExample->findBySql($sql);
    }
    function actionMingxiRight(){
        FLEA::loadClass('TMIS_Pager');
        // /构造搜索区域的搜索类型
        $arr = TMIS_Pager::getParamArray(array(
                'dateFrom' => date("Y-m-01"),
                'dateTo' => date("Y-m-d"),
                'key' => '',
        ));
        $arrFieldInfo = array(
                "dateJiaohuo" => "交货日期",
                "orderDate" => "下单日期",
                'orderCode' => '生产编号',
                'compName' => '客户名称',
                'traderName' => '业务员',
                'proCode' => '编码',
                'proName'=>'品名',
                "guige" => '规格',
                "color" => '颜色',
                "kind" => "类型",
                "unit" => "单位",
                "bizhong" => '币种',
                "cntYaohuo" => '数量',
                "danjia" =>'单价',
                "money"=>'金额'
        );
        $sql = "select x.dateJiaohuo,x.unit,x.cntYaohuo,x.danjia,p.kind,y.orderCode,y.orderDate,y.bizhong,p.proName,p.proCode,p.guige,p.color,
                c.compName,e.employName as traderName
                 from trade_order2product x
                left join trade_order y on x.orderId=y.id
                left join jichu_product p on p.id=x.productId
                left join jichu_client c on c.id=y.clientId
                left join jichu_employ e on e.id=y.traderId
                where 1";
        $sql .= " and orderDate >= '{$arr['dateFrom']}' and orderDate<='{$arr['dateTo']}'";
        if ($arr['key'] != '') $sql .= " and (p.proCode like '%{$arr['key']}%' or p.proName like '%{$arr['key']}%' or p.guige like '%{$arr['key']}%')";
        //该用户关联的业务员的订单
        $mUser = & FLEA::getSingleton('Model_Acm_User');
        if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
            //得到当前用户匹配的员工id
            $traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
            if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
                $sql .= " and 0";
            } else {
                $s = join(',',$traderIds);
                $sql .= " and y.traderId in ({$s})";
            }
        }
        $sql.=" order by orderDate desc, orderCode desc";
        $pager = &new TMIS_Pager($sql);
        $rowset = $pager->findAll();
        //dump($rowset);die;
        if (count($rowset) > 0) foreach($rowset as &$v) {
            $v['money']=round($v['danjia']*$v['cntYaohuo'],2);
        }
        $smarty = &$this->_getView();
        $smarty->assign('title', '订单明细查询');
        $smarty->assign('arr_field_info', $arrFieldInfo);
        $smarty->assign('add_display','none');
        $smarty->assign('arr_condition', $arr);
        $smarty->assign('arr_field_value', $rowset);
        $smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $arr).$msg);
        $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
        $this->_beforeDisplayRight($smarty);
        $smarty->display('TableList.tpl');
    }

}

?>