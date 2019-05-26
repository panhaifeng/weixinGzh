<?php
FLEA::loadClass('TMIS_ControllerApp');
class Controller_App_Exhibition extends TMIS_ControllerApp {

    // /构造函数
    function __construct() {

    }


    /**
     * 手机端首页
     * Time：2018/07/24 13:35:58
     * @author li
    */
    function actionIndex(){


    }

    /**
     * 手机端首页
     * Time：2018/07/24 13:35:58
     * @author li
    */
    function actionSave(){
        $this->authCheck(0);

        //查找最后一次设置的展会档案
        $mdlEx = FLEA::getSingleton('Model_Jichu_Exhibition');
        $row = $mdlEx->find(array(),'id desc');
        if(!$row){
            echo json_encode(array('succ'=>'false','msg'=>'管理员还没有设置展会信息'));
            exit;
        }

        if(!$_POST['cardImg']){
            echo json_encode(array('succ'=>'false','msg'=>'请上传名片图片'));
            exit;
        }

        if(!$_POST['proIds']){
            echo json_encode(array('succ'=>'false','msg'=>'请扫描样品'));
            exit;
        }

        //处理图片文件上传到服务器
        $imageData = str_replace('data:image/jpeg;base64,', '', $_POST['cardImg']);
        if( $imageData){
            $img = base64_decode($imageData);
            $imgName = date('ymdHis').rand(1000,9999).".jpg";
            $path = "upload/client/card/";
            $size = file_put_contents($path.$imgName, $img);
            if(!$size){
                echo json_encode(array('succ'=>'false','msg'=>'名片上传失败，请重新提交'));
                exit;
            }else{
                $imgCode = @md5_file($path.$imgName);
            }
        }else{
            echo json_encode(array('succ'=>'false','msg'=>'名片图片数据异常'));
            exit;
        }

        //组织数据
        $arr = array(
            'userId'   =>$_SESSION['USERID'],
            'cardPath' =>$path.$imgName,
            'imgCode'  =>$imgCode,
            'tip'      =>$_POST['tips'],
            'memo'     =>$_POST['memo'],
            'exid'     =>$row['id'],
        );

        $mdlClient = FLEA::getSingleton('Model_Jichu_Client');
        $mdlPro2Client = FLEA::getSingleton('Model_Jichu_ProClient');

        //保存客户信息
        $cid = $mdlClient->save($arr);

        //处理样品id
        if($cid){
            $sampleIds = explode(',', $_POST['proIds']);
            $s2c = array();
            foreach ($sampleIds as $key => &$v) {
                $s2c[] = array(
                    'clientId' =>$cid,
                    'sampleId' =>$v,
                    'userId'   =>$_SESSION['USERID'],
                    'exid'     =>$row['id'],
                );
            }
            //保存
            $mdlPro2Client->saveRowset($s2c);

            //自动识别名片信息
            FLEA::loadClass('TMIS_Common');
            $rows = TMIS_Common::getSysSet();
            if($rows['tengxun_appid'] && $rows['tengxun_secret_id'] && $rows['tengxun_secret_key']){
                try{
                    $crontab = FLEA::getSingleton('Model_Crontab');
                    $crontab->publish(array('type'=>'quick','description'=>'名片文字识别','action'=>'Controller_Event_Client@orcCard'),array('cid'=>$cid));
                }catch(Exception $e){
                    ;
                }
            }
            //end
            echo json_encode(array('succ'=>'true','msg'=>'提交成功'));
            exit;
        }else{
            echo json_encode(array('succ'=>'false','msg'=>'客户信息保存失败，重新提交'));
            exit;
        }

    }
}

?>