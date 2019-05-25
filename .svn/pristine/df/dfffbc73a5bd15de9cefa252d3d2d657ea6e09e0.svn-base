<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Crm_Intention extends Tmis_Controller {
	var $_modelExample;
    var $title = "意向客户";

	function Controller_Crm_Intention() {
        $this->_modelExample = &FLEA::getSingleton('Model_Crm_Client');

        $this->_modelProvince = &FLEA::getSingleton('Model_Crm_Province');
        $this->_modelCity = &FLEA::getSingleton('Model_Crm_City');
        $this->_modelArea = &FLEA::getSingleton('Model_Crm_Area');
		$this->fldMain = array(
            'id' => array('type' => 'hidden', 'value' =>'','name'=>'clientId'),
			'ctime'=>array('title'=>'','type'=>'hidden','value'=>''),
        	'company'=>array('title'=>'公司名称','type'=>'text','value'=>''),
            'industry'=>array('title'=>'行业','type'=>'select','model' => 'Model_Crm_Industry','isSearch'=>true),
            'source'=>array('title'=>'客户来源','type'=>'select','model' => 'Model_Crm_Source','isSearch'=>true),
            'kefu_id'=>array('title'=>'业务员','type'=>'select','model' => 'Model_Jichu_Employ','isSearch'=>true,'condition'=>'depId in(select id from jichu_department where depName like "%业务%")'),

            'province'=>array('title'=>'省份','type'=>'select','value'=>'','model' => 'Model_Crm_Province'),
            'city'=>array('title'=>'城市','type'=>'select','value'=>'','model' => 'Model_Crm_City'),
        	'area'=>array('title'=>'区/县','type'=>'select','value'=>'','model' => 'Model_Crm_Area'),
            'address'=>array('title'=>'详细地址','type'=>'text','value'=>''),
        
            'memo'=>array('title'=>'备注','type'=>'textarea','value'=>''),
        );

        $this->headSon = array(
            '_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
            'contact_name' => array('type' => 'bttext', "title" => '联系人', 'name' => 'contact_name[]'),
            'telephone' => array('type' => 'bttext', "title" => '电话', 'name' => 'telephone[]'),
            'TelAddress'=>array('type'=>'bttext','title'=>'地址','name'=>'TelAddress[]','value'=>''),
            'email' => array('type' => 'bttext', "title" => '邮箱', 'name' => 'email[]'),
            'contact_memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'contact_memo[]'),
            // ***************如何处理hidden?
            'id' => array('type' => 'bthidden', 'name' => 'id[]'),
        );

        $this->sonTpl = 'Crm/JsSon.tpl';
	}

	function actionRight() {
		$this->authCheck('11-1-4');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
            'clientName' => '',
            'traderId' => '',
            'industry'=>'',
            'source'=>'',
            'province'=>'',
		));
		$str = "SELECT x.*,y.name as industryName,z.name as sourceName,b.province as pName,c.city as cName,
                d.area as aName,a.employName
                from intention_client x
                left join jichu_industry y on x.industry=y.id
                left join jichu_source z on z.id=x.source
                left join jichu_employ a on a.id=x.kefu_id
                left join jichu_province b on x.province=b.provinceid
                left join jichu_city c on c.cityid=x.city
                left join jichu_area d on d.areaid=x.area
                where 1 ";
        if ($arr['clientName'] != '') $str .= " and x.company like '%{$arr['clientName']}%'";
        if ($arr['traderId'] != '') $str .= " and x.kefu_id = '{$arr['traderId']}'";
        if ($arr['industry'] != '') $str .= " and x.industry = '{$arr['industry']}'";
        if ($arr['source'] != '') $str .= " and x.source = '{$arr['source']}'";
        if ($arr['province'] != '') $str .= " and x.province = '{$arr['province']}'";
		if ($arr['key'] != '') $str .= " and company like '%{$arr['key']}%'";

        //该用户关联的业务员
        $mUser = & FLEA::getSingleton('Model_Acm_User');
        if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
            //得到当前用户匹配的员工id
            $traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
            if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
                $str .= " and 0";
            } else {
                $s = join(',',$traderIds);
                $str .= " and x.kefu_id in ({$s})";
            }
        }

		$str .= " order by id asc";
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAllBySql($str); 
        $editCheck = $this->authCheck('11-1-1',true);
        $removeCheck = $this->authCheck('11-1-2',true);
        $addCheck = $this->authCheck('11-1-3',true);
        $viewCheck = $this->authCheck('11-1-4',true);
		if (count($rowset) > 0) foreach($rowset as &$v) {
            $v['action'] = '';

            $v['action'] .= "<a href='".url('Crm_Action','Add',array(
                'id'    => $v['id'],
            ))."' target=''>添加</a>";
            
            $v['action'] .= "&nbsp;&nbsp;<a href='".url('Crm_Action','Right',array(
                    'id'    => $v['id'],
                ))."' target=''>查看</a>";

            
            
            $v['_edit'] = '';
            if($editCheck){
                $v['_edit'] .= $this->getEditHtml($v['id']);
            }

            if($removeCheck){
                $v['_edit'] .= ' ' .$this->getRemoveHtml($v['id']);
            }

            if($viewCheck){
                $v['_edit'] .= "&nbsp;&nbsp;<a href='".$this->_url('Edit',array(
                    'id'    => $v['id'],
                    'flag'  => true,
                ))."' target=''>详细</a>";
            }

            $v['address'] = $v['pName'].$v['cName'].$v['aName'];
		}

		$smarty = &$this->_getView();
		$smarty->assign('title', '意向客户查询');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$arr_field_info = array(
            "action"  => '行动',
            "id"        =>"序号",
			"company"  => '公司名称',
			"industryName" => '行业',
            "sourceName" => '客户来源',
            "employName" => '业务员',
            // "pName" => '省份',
            // "cName" => '城市',
            // "aName" => '区/县',
            "address" => array('text'=>'地区','width'=>'180'),
            "_edit" => array('text'=>'操作','width'=>'150'),
		);
		$smarty->assign('arr_field_info', $arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        if(!$addCheck){
            $smarty->assign('add_display', 'none'); 
        }

		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');

	} 
	
	function actionAdd(){
        $areaMain = array('title' => '订单基本信息', 'fld' => $this->fldMain);
        $headSon = $this->headSon;

        // 从表信息字段,默认5行
        for($i = 0;$i < 2;$i++) {
            $rowsSon[] = array(

            );
        }
		$smarty = & $this->_getView();
		$smarty->assign('areaMain',$areaMain);
        $smarty->assign('headSon', $headSon);
        $smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('title','工序信息编辑');
        $smarty->assign('rules',$this->rules);
		$smarty->assign('sonTpl',$this->sonTpl);
        $smarty->display('Main2Son/T1.tpl');
	}

    function actionEdit(){
        

        $row = $this->_modelExample->find(array('id'=>$_GET['id']));
        $this->fldMain = $this->getValueFromRow($this->fldMain,$row);
       

        // dump($row);die;
       
        foreach($row['Contacts'] as &$v) {
            $temp = array();
            foreach($this->headSon as $kk => &$vv) {
                $temp[$kk] = array('value' => $v[$kk]);
            }
            $rowsSon[] = $temp;
        } 

        // 从表信息字段,默认5行
        $cnt = count($rowsSon);
        for($i=5;$i>$cnt;$i--) {
            $rowsSon[] = array();
        }
         if($_GET['flag']==true){
            foreach ($this->fldMain as $key => &$v) {
                $v['disabled'] = true;
                $v['readonly'] = true;
            }
            foreach ($this->headSon as $key => &$v) {
                $v['disabled'] = true;
                $v['readonly'] = true;
            }
            unset($this->headSon['_edit']);
        }
        // $this->fldMain['clientId']['value'] = $row['id'];
        $areaMain = array('title' => '订单基本信息', 'fld' => $this->fldMain);
        $headSon = $this->headSon;
        $smarty = & $this->_getView();
        $smarty->assign('areaMain',$areaMain);
        $smarty->assign('headSon', $this->headSon);
        $smarty->assign('rowsSon', $rowsSon);
        $smarty->assign('rules',$this->rules);
        $smarty->assign('title',$this->title);
        $smarty->assign('sonTpl',$this->sonTpl);
        $smarty->assign('flag',$_GET['flag']);
        // $smarty->display('Crm/A.tpl');
        $smarty->display('Main2Son/T2.tpl');
    }

    /**
     * AJAX根据省份ID查询城市
     * @author shen
     * 2018年6月5日 14:12:05
     * @return 城市数组
     */
    function actionGetCity(){
        $fatherid = $_GET['fatherid'];

        $cities = $this->_modelCity->findAll(array('fatherid'=>$fatherid));
        echo json_encode($cities);
        exit;
    }
    /**
     * AJAX根据城市ID查询区域
     * @author shen
     * 2018年6月5日 14:12:05
     * @return 区域数组
     */
    function actionGetArea(){
        $fatherid = $_GET['fatherid'];

        $areas = $this->_modelArea->findAll(array('fatherid'=>$fatherid));

        echo json_encode($areas);
        exit;
    }

    function actionPopup(){
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            //'traderId' => '',
            'key' => '',
            'showModel'=>''
        ));
        $str = "SELECT x.*,y.employName
                from intention_client x
                left join jichu_employ y on y.id=x.kefu_id
                where 1";
        if ($arr[key]!='') $str .= " and company like '%$arr[key]%' ";
        
        //该用户关联的业务员的订单
        $mUser = & FLEA::getSingleton('Model_Acm_User');
        if(!$mUser->canSeeAllOrder($_SESSION['USERID'])) {
            //得到当前用户匹配的员工id
            $traderIds = $mUser->getTraderIdOfCurUser($_SESSION['USERID']);
            if(count($traderIds)==0) {//说明用户没有指定关联业务员，禁止访问
                $str .= " and 0";
            } else {
                $s = join(',',$traderIds);
                $str .= " and traderId in ({$s})";
            }
        }

        $str .=" order by id desc";
        $pager =& new TMIS_Pager($str);
        $rowset =$pager->findAllBySql($str);
        if(count($rowset)>0) foreach($rowset as & $v){
            
        }
        $arr_field_info = array(
            "company" =>"名称",
            'employName'=>'本厂联系人',
        );
      
        $smarty = & $this->_getView();
        $smarty->assign('title', '选择客户');
        $pk = $this->_modelExample->primaryKey;
        $smarty->assign('pk', $pk);
        $smarty->assign('add_display','none');
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('s',$arr);
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty->assign('arr_condition',$arr);
        $smarty->assign('clean',true);
        $smarty-> display('Popup/CommonNew.tpl');
    }   

    function actionSave(){
        $row = array();
        foreach($this->fldMain as $k=>&$vv) {
            $name = $vv['name']?$vv['name']:$k;
            $row[$k] = $_POST[$name];
        }
        $row['ctime'] = $_POST['id']?$_POST['ctime']:time();


        $pros = array();
        foreach ($_POST['contact_name'] as $key => &$v) {
            if ($v == '' ) continue;
            $temp = array();
            foreach ($this->headSon as $k => &$vv) {
                $temp[$k] = $_POST[$k][$key];
            }
            $pros[] = $temp;
        }
        $row['Contacts'] = $pros;
        // dump($row);die;
        if(!$this->_modelExample->save($row)) {
            js_alert('保存失败','window.history.go(-1)');
            exit;
        }
        
        //跳转
        js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
        exit;

    }

}

?>