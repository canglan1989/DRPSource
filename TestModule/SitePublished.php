<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：网营门户已经发布成功，可能由于超时DRP数据状态没有更新 这段代码就是更新DRP的数据
 * 创建人： wzx
 * 添加时间：2012-4-27
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
print_r("s==".time());        /*
if (!defined("SYS_CONFIG")) {
    //读取配置文件
    $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}
require_once __DIR__ . '/../Class/Common/BLLBase.php';
require_once __DIR__ . '/../Class/BLL/OrderBLL.php';
require_once __DIR__ . '/../WebService/BasePlatform_Service.php';

set_time_limit(0);
    $objBasePlatform_Service = new BasePlatform_Service();
    $objBasePlatform_Service->AddAdhaiAccount(159,"LL1801_岳麓国际教育","www.csylpx.com");
    

$objOrderBLL = new OrderBLL();
$arrayData = $objOrderBLL->select("om_order.owner_id,om_order.owner_account_name,om_order.owner_login_pwd,
om_order.owner_website_name,om_order.owner_domain_url","owner_id >0 and is_del=0 and create_time<'2012-04-13 10:35:00'");
if (isset($arrayData) && count($arrayData) > 0)
{
    $objBasePlatform_Service = new BasePlatform_Service();
    foreach($arrayData as $key=>$value)
    {
        print_r($value["owner_domain_url"]."<br/>");
        $objBasePlatform_Service->AddAdhaiAccount($value["owner_id"],$value["owner_account_name"],$value["owner_domain_url"]);
    }
}
*/

if (!defined("SYS_CONFIG")) {
    //读取配置文件
    $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}
require_once __DIR__ . '/../Class/Common/BLLBase.php';
require_once __DIR__ . '/../Class/BLL/TMNetOpeBLL.php';


$objOrderChargeAct = new OrderChargeAct();
$order_id= 50;
$strActDate = "2012-08-20 14:16:52";
$iAuditUid = 3699;
$objOrderChargeAct->Init(intval($order_id), "$strActDate");
$objOrderChargeAct->Insert($iAuditUid, "网营门户上线，订单款项扣除");
                        
print_r(time()."--OK");/*
require_once __DIR__.'/../Action/Common/WebServiceCallerBase.php';


class tt extends WebServiceCallerBase
{
    public function __construct()
    {
        parent::__construct();
        $serviceUrl = "http://192.168.32.215:2000/WebService/SingleLogin.php";
        $this->CreatePHPClient($serviceUrl);
    }
    
    public function call()
    {        
        //$param = array(454,"2012-01-01","2013-01-01");
        //$rtn = $this->_client->__call("UpdateEffectDate",$param);  
        
        $param = array(268,"newName");
        $rtn = $this->_client->__call("UpdateUserName",$param);
        return $rtn;
    }
}

$obj = new tt();
$ret = $obj->call();
print_r($ret);
print_r("end==".time());*/


?>