<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：向单点提供 订单有效期 接口
 * 创建人：wzx
 * 添加时间：2012-05-10 
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Action/Common/WebServiceProviderBase.php';
require_once __DIR__.'/../Class/BLL/OrderBLL.php';

class SingleLogin extends WebServiceProviderBase
{    
    public function __construct()
    {        
        parent::__construct();
        $this->_Permission_IP = $this->_arrSysConfig["SingleLogin".$this->_sys_evn]["Permission_IP"];
    }
    
    /**
     * @functional 更新订单有效期
     * @param $orderID 订单ID
     * @param $sDate 有效期开始时间 时间格式 2000-01-01
     * @param $eDate 有效期结束时间 时间格式 2000-01-01
     * @return int 1 成功 0失败 -1 IP被拒绝
    */
    public function UpdateEffectDate($orderID,$sDate,$eDate)
    {
        $this->AddLog(__FUNCTION__,array($orderID,$sDate,$eDate));
        if($this->IPIsNotPermission()) return -1;
        
        $objOrderBLL = new OrderBLL();
        return $objOrderBLL->UpdateEffectDate($orderID,$sDate,$eDate);
    }    
    
    /**
     * @functional 单点更新用户名
     * @param $orderID 订单ID
     * @param $strUserName 新用户名
     * @return int 1 成功 0失败 -1 IP被拒绝
    */
    public function UpdateUserName($orderID,$strUserName)
    {
        $this->AddLog(__FUNCTION__,array($orderID,$strUserName));
        if($this->IPIsNotPermission()) return -1;
                    
        $objOrderBLL = new OrderBLL();
        $objOrderBLL->SingleLoginUpdateUserName($orderID,$strUserName);
        return 1;
    }  
}

$server = new SoapServer(null, array('uri' => '127.0.0.1'));
$server->setClass('SingleLogin');
$server->handle();

?>