<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：调用 单点 接口
 * 创建人：XXF
 * 添加时间：2012-09-17 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Action/Common/WebServiceCallerBase.php';

class SSO_MetaClient extends WebServiceCallerBase {
    //put your code here
    public function __construct() {
        parent::__construct();
        $serviceUrl = $this->_arrSysConfig["SoapLocation".$this->_sys_evn]["SSO"];
        $this->_client = new SoapClient($serviceUrl);
    }
    
    /**
     * 修改单点登录账号失效时间（变相关闭账号）
     * @param type $iUserID 单点用户ID
     * @param type $strAppID 单点产品代号
     * @param type $strNewTime 新的失效时间
     * @return type 
     */
    /**
	 * 更新应用的过期时间
	 * @param int $appAuthId 唯一标识
	 * @param string $newtime format Y-m-d H:i:s 新的过期时间
	 * @return -1 时间格式不正确 返回bool true和false，但是wsdl全是string，所以返回1成功，返回""失败
	 */
    public function UpdateTheExpireTime($iUserID, $strAppID, $strNewTime) {
        $iAuthID = $this->getAuthIDByUserID($iUserID, $strAppID);
        if ($iAuthID) {
            $param = array($iAuthID, $strNewTime);
            $iLogID = $this->AddLog(__FUNCTION__, $param);
            $objResult = $this->_client->__call('updateAppExpireTime', $param);
            $this->UpdateLog($iLogID, $objResult);
            return $objResult;
        }
        return false;
    }
    
    /**
     * 获取单点AuthID参数
     * @param type $iUserID 单点用户ID
     * @param type $strAppID 单点产品代号
     * @return type 
     */
    public function getAuthIDByUserID($iUserID,$strAppID){
        $param = array($iUserID,$strAppID);
        $iLogID = $this->AddLog(__FUNCTION__,$param);
        $rtn = $this->_client->__call('getAppAuthIdByUserId',$param);
        $this->UpdateLog($iLogID, $rtn);
        $arrRtn = json_decode($rtn);
        if(count($arrRtn)>0){
            return $arrRtn[0];
        }
        return false;
    }

    /**
     * 开通网盟后通知单点
    */
    public function AddAdhaiAccount(OrderInfo $objOrderInfo)
    {        
        $serviceUrl = $this->_arrSysConfig["SoapLocation".$this->_sys_evn]["WM_AddUser"];
        $this->_client = new SoapClient($serviceUrl);
        $param = array("customerId"=>$objOrderInfo->iCustomerId,"customerName"=>$objOrderInfo->strCustomerName,"customerContact"=>$objOrderInfo->strContactName,
            "customerTelePhone"=>$objOrderInfo->strContactMobile,"customerEmail"=>$objOrderInfo->strContactEmail,"customerCallPhone"=>$objOrderInfo->strContactTel,
            "customerOrderId"=>$objOrderInfo->iOrderId,"productId"=>3406,"userLogin"=>$objOrderInfo->strOwnerAccountName,"ownerId"=>$objOrderInfo->iOwnerId,"source"=>1);
        $iLogID = $this->AddLog(__FUNCTION__,$param);
        $param = array(json_encode($param));
        $rtn = $this->_client->__call('addWangMeng',$param);
        $this->UpdateLog($iLogID, $rtn);
        /* 1成功        -3有重名        -6已经有网盟产品        -7产品ID不对        -8其他参数不能为空*/
        return $rtn;
    }
}

?>
