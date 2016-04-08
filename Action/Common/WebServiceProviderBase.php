<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：提供 WebService 的基类
 * 创建人：wzx
 * 添加时间：2012-2-28 
 * 修改人：      修改时间：
 * 修改描述：
 **/

header("Content-type: text/html; charset=utf-8");
ini_set("soap.wsdl_cache_enabled", 0);

require_once __DIR__.'/Utility.php';
require_once __DIR__ . '/../../Class/BLL/WebserviceBLL.php';

if(!defined("SYS_CONFIG"))
{
    //读取配置文件
    $arrSysConfig = require __DIR__ . '/../../Config/SysConfig.php';
    define("SYS_CONFIG", serialize($arrSysConfig));
}

/*
* 提供 WebService 的基类
*/
class WebServiceProviderBase
{
    protected $_arrSysConfig = null;//配置文件数据
    protected $_sys_evn = 0;//系统环境 0开发 1测试 2正式
    protected $_Permission_IP = null;
    public function __construct()
    {
        $this->_arrSysConfig = unserialize(SYS_CONFIG);
        $this->_sys_evn = $this->_arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
        $this->_Permission_IP = array();
    }
        
    /**
     * @functional 是否允许此IP调用 WebService 
     * @param 配置里的IP限制标记
     * @return bool 
     */
    public function IPIsNotPermission($aPermissionIP = array())
    {
        return $aPermissionIP;
        if(count($aPermissionIP) == 0)
            $aPermissionIP = $this->_Permission_IP;
            
        if(count($aPermissionIP) == 0)
             return false;
                 
        $ip = Utility::getIP();
        $bPermissionIP = false;
        foreach($aPermissionIP as $key => $value)
        {    
            if($value == "" || preg_match($value, $ip))
            {
                $bPermissionIP = true;
                break;
            }
        }
        
        return !$bPermissionIP;
    }
    
    protected function AddLog($strFunctionName,$arrayParam)
    {
        $strParam = "";
        foreach($arrayParam as $key => $value)
        {
            $strParam .= $key.":".$value.";";
        }
        
        $objWebserviceInfo = new WebserviceInfo();
        $objWebserviceInfo->strClassName =  get_class($this);
        $objWebserviceInfo->strFunctionName =  $strFunctionName;
        $objWebserviceInfo->strParams = $strParam;
        $objWebserviceInfo->strLogIp = Utility::getIP();
        $objWebserviceInfo->iCreateUid = 0;
        $objWebserviceInfo->strCreateTime = Utility::Now();
        
        $objWebserviceBLL = new WebserviceBLL();
        $objWebserviceBLL->insert($objWebserviceInfo);
    }
}
