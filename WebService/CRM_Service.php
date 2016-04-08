<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：调用 crm WebService 接口
 * 创建人：wzx
 * 添加时间：2012-3- 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Action/Common/WebServiceCallerBase.php';
/**
 * 客户的用户
 */
class CRM_Customer_Service extends WebServiceCallerBase
{
    public function __construct()
    {
        parent::__construct();
        $serviceUrl = $this->_arrSysConfig["CRM".$this->_sys_evn]["Customer_WebService"];
        $this->CreatePHPClient($serviceUrl);
    }
    
    /**
     * @functional 客户帐户名是否存在。
     * @return true 存在
    */
    public function IsExistLoginName($strLoginName)
    {
        $params = array($strLoginName);
        $id = $this->AddLog(__FUNCTION__,$params);
        $rtn = $this->_client->__call("checkCustomerName",$params);
        $this->UpdateLog($id,$rtn);
        if($rtn == 0 || $rtn == "0") 
            return false;
            
        return true;        
    }
    
    
    /**
     * @functional 添加客户帐户。
     * @return 插入成功后的客户ID
    */
    public function AddAccount($arrayCustomerAccountInfo)
    {
        $params = array("arrayCustomerInfo"=>$arrayCustomerAccountInfo);
        $id = $this->AddLog(__FUNCTION__,$arrayCustomerAccountInfo);
        $rtn = $this->_client->__call("Insert",$params);
        $this->UpdateLog($id,$rtn);
        return $rtn;
    }
    
    
    
    /**
     * @functional 取得代理商所有客户今日之前网盟已消费金额。
     * @param 代理商ID
     * @return 代理商所有客户已消费金额
     * @author wzx
    */
    public function CustomerCostMoneyAmount($agentId)
    {
        $params = array("agentId"=>$agentId);
        $id = $this->AddLog(__FUNCTION__,$params);
        $rtn = $this->_client->__call("CustomerCostMoneyAmount",$params);
        $this->UpdateLog($id,$rtn);
        return $rtn;
    }
    
    
    /**
     * @functional 代理商信息同步到CRM
     * @param $agentInfo 代理商信息
    */
    public function UpdateAgentInfoToCRM($agentInfo)
    {
        $param = array();
        $param["agent_id"] = $agentInfo->iAgentId;
        $param["agent_name"] = $agentInfo->strAgentName;
        $param["source_type"] = "drp";
        $id = $this->AddLog(__FUNCTION__,$param);        
        //$param = json_encode($param);
        $rtn = $this->_client->__call("SynchronAgentInfo",$param);
        $this->UpdateLog($id,$rtn);
        return $rtn;
    }
}

/**
 * 代理商的用户
 */
class CRM_User_Service extends WebServiceCallerBase
{
    public function __construct()
    {
        parent::__construct();
        $serviceUrl = $this->_arrSysConfig["CRM".$this->_sys_evn]["User_WebService"];
        $this->CreatePHPClient($serviceUrl);
    }
        
    /**
     * @functional CRM里已经存在此用户了
     * @return bool true 存在 
    */
    public function iExistAccount($accountName)
    {
        $params = array($accountName);
        
        $id = $this->AddLog(__FUNCTION__,$params);
        //返回2表示用户名已存在
        $rtn = $this->_client->__call("iExistAccount",$params);
        $this->UpdateLog($id,$rtn);
        if($rtn == 2)
            return true;
            
        return false;
    }
    
        
    /**
     * @functional CRM里已经存在此用户了
     * @return bool true 存在 
    */
    public function iExistAccountNotContentIsDel($accountName)
    {
        $params = array($accountName);
        $id = $this->AddLog(__FUNCTION__,$params);
        //返回2表示用户名已存在
        $rtn = $this->_client->__call("iExistAccountNotContentIsDel",$params);
        $this->UpdateLog($id,$rtn);
        if($rtn == 2)
            return true;
            
        return false;
    }
    
    /**
     * @functional 添加 代理商用户到CRM 基础平台做好后这个接口就不要了 公司的用户不调用空上函数
     * @param $objUserInfo 用户表Model
    */
    public function InserToCRM($objUserInfo)
    {
        $param = array();
        $param["source_type"] = "drp";
        $param["source_id"] = $objUserInfo->iUserId;
        $param["agent_id"] = $objUserInfo->iAgentId;
        $param["agent_name"] = $objUserInfo->strDeptName;
        $param["user_name"] = $objUserInfo->strUserName;
        $param["e_name"] = $objUserInfo->strEName;
        
        if(strlen($objUserInfo->strUserNo) == 2) //1管理员 0客服帐号
            $param["i_admin"] = 1;
        else
            $param["i_admin"] = 0;
            
        $param["user_pwd"] = $objUserInfo->strUserPwd;
        $param["tel"] = $objUserInfo->strTel;
        $param["phone"] = $objUserInfo->strPhone;
        $param["E_mail"] = "";//$objUserInfo->strEmail;
        $param["user_remark"] = $objUserInfo->strUserRemark;
        $param["is_del"] = $objUserInfo->iIsDel;
        
        $id = $this->AddLog(__FUNCTION__,$param);
        
        $param = json_encode($param);
        $rtn = $this->_client->__call("Add",array($param));
        $this->UpdateLog($id,$rtn);
        return $rtn;
    }
    
    /**
     * @functional 更新 代理商用户到CRM 基础平台做好后这个接口就不要了
     * @param $objUserInfo 用户表Model
     * @return 1 成功
    */
    public function UpdateToCRM($objUserInfo)
    {
        $param = array();
        $param["source_type"] = "drp";
        $param["source_id"] = $objUserInfo->iUserId;
        $param["agent_id"] = $objUserInfo->iAgentId;
        $param["agent_name"] = $objUserInfo->strDeptName;
        $param["user_name"] = $objUserInfo->strUserName;
        $param["e_name"] = $objUserInfo->strEName;
        
        if(strlen($objUserInfo->strUserNo) == 2) //1管理员 0客服帐号
            $param["i_admin"] = 1;
        else
            $param["i_admin"] = 0;
            
        $param["user_pwd"] = $objUserInfo->strUserPwd;
        $param["tel"] = $objUserInfo->strTel;
        $param["phone"] = $objUserInfo->strPhone;
        $param["E_mail"] = "";//$objUserInfo->strEmail;
        $param["user_remark"] = $objUserInfo->strUserRemark;
        $param["is_del"] = $objUserInfo->iIsDel;
        
        $id = $this->AddLog(__FUNCTION__,$param);
        
        $param = json_encode($param);        
        $rtn = $this->_client->__call("Edit",array($param));
        $this->UpdateLog($id,$rtn);
        return $rtn;
    }
    
    /**
     * @functional wzx
     * @return true 是 false 否
     */
    public function DRPCanDelUser($userID)
    {
        $params = array($userID);
        $id = $this->AddLog(__FUNCTION__,$params);
        //返回1表示可以
        $rtn = $this->_client->__call("DRPCanDelUser",$params);
        $this->UpdateLog($id,$rtn);
        if($rtn == 1)
            return true;
        
        return false;
    }
    
}

