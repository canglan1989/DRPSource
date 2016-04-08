<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：调用基础平台接口
 * 创建人：wzx
 * 添加时间：2012-5-8
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Action/Common/WebServiceCallerBase.php';

/**
 * 调用基础平台接口
 */
class BasePlatform_Service extends WebServiceCallerBase
{
    public function __construct()
    {
        parent::__construct();
        $serviceUrl = $this->_arrSysConfig["BasePlatform".$this->_sys_evn]["WebService"];
        $this->_client = new SoapClient($serviceUrl,array('trace'=>1));
    }
        
    /**
     * @functional 通知单点Adhai中已添加客户帐户。
     * @param $oid 客户ID
     * @param $accountName 客户帐户名
     * @param $domain 客户推广域名
    */
    public function AddAdhaiAccount($oid,$accountName,$domain)
    {
        $oid = $oid+5000000;
        $params = new stdClass();
        $params->accountInfo = array("id"=>$oid,"adhaiAccount"=>$accountName,"domain"=>$domain);
        $id = $this->AddLog(__FUNCTION__,$params->accountInfo);
        $params->accountInfo = json_encode($params->accountInfo);
        $rtn = $this->_client->__call('addAdhaiAccount', array($params));
        $this->UpdateLog($id,get_object_vars($rtn));
        return $rtn;
    }
}
