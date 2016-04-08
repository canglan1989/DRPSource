<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：调用 Adhai 财务WebService 接口
 * 创建人：wzx
 * 添加时间：2012-3-6
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Action/Common/WebServiceCallerBase.php';


class Adhai_Service extends WebServiceCallerBase
{
    public function __construct()
    {
        parent::__construct();
        $serviceUrl = $this->_arrSysConfig["Adhai".$this->_sys_evn]["UFO_WebService"]."crm";
        $this->CreatePHPClient($serviceUrl);
        $this->GetSessionID();
    }
    
    /**
     * @functional 取得客户帐户信息
    */
    public function GetOwnerInfo($oid)
    {    
        $param = array("oid"=>$oid);
        //$id = $this->AddLog(__FUNCTION__,$param); //经常用，又不重要，一般也不会出错，不记录日志。
        $rtn = $this->ClientCall("getOwnerInfo",$param);  
        //$this->UpdateLog($id,$rtn);
        return $rtn;
    }
}

/**
 * 网盟转款相关
*/
class Adhai_FinanceService extends WebServiceCallerBase
{
    public function __construct()
    {
        parent::__construct();
        $serviceUrl = $this->_arrSysConfig["Adhai".$this->_sys_evn]["UFO_WebService"]."api";
        $this->CreatePHPClient($serviceUrl);
        $this->GetSessionID();
    }
    
    /**
     * @functional 客户转款 调用Adhai充值接口
     * @return bool true 成功
    */ 
     public function Recharge($ownerName,$money,$remark)
     {                         
        return $this->RechargeOrRefund($ownerName,$money,$remark);
     } 
     
     /**
      * @functional 调用Adhai退款接口
     * @return bool true 成功
     */
     public function Refund($ownerName,$money,$remark)
     {
        $money = -$money;
        return $this->RechargeOrRefund($ownerName,$money,$remark);
     }
     
     /**
      * @functional 调用Adhai充值、退款接口 负数表示退款
     * @return bool true 成功
     */
     public function RechargeOrRefund($ownerName,$money,$remark)
     {
        $checkcode = $this->getCheckCode($ownerName);
        
         /**
         * @param oAccount	string	广告主账号
         * @param money	decimal	充值金额：充值为正、退款为负
         * @param flag	tinyint	标志来源：CRM=1，DRP=2，ERP=3
         * @param checkcode	char(32)	加密串
         * @param remark	varchar(512)	备注
         */
        $param = array("oAccount"=>$ownerName, "money"=>$money, "flag"=>2, "checkcode"=>$checkcode, "remark"=>$remark);
        $id = $this->AddLog(__FUNCTION__,$param);
        
        $rtn = $this->ClientCall("rechargeOrRefund",$param,0);
        $this->UpdateLog($id,$rtn);
        if($rtn == 1)
            return true;
            
        return false;
        
     }
     
     /**
      * @functional 查询广告主账户余额
      * @param oAccount	string	广告主账号
     */
     public function GetOwnerBalance($ownerName)
     {
        $checkcode = $this->getCheckCode($ownerName);
        $param = array("oAccount"=>$ownerName, "flag"=>2, "checkcode"=>$checkcode);
        
        $id = $this->AddLog(__FUNCTION__,$param);        
        $rtn = $this->ClientCall("getOwnerBalance",$param,0);
        $this->UpdateLog($id,$rtn);
        
        if(is_array($rtn))
            $rtn = $rtn["balance"];
        
        if(is_numeric($rtn))
            $rtn = round($rtn,2); 
            
        return $rtn;
     }
     
     /**
      * @functional Adhai 给过来的
      */
    function getCheckCode($oAccount)
    {
        $flag = 2;//CRM=1，DRP=2，ERP=3
    	$current = time();
    	$tmp_res = $current % 300;
    	$current -= $tmp_res;
    	$str1 = date('Y|m|d|H|i',$current).'|'.$oAccount;
    	
    	$checkcode = md5($str1);
    	$pre_length = 1<<$flag;
    	$tmp1 = substr($checkcode,0,$pre_length);
    	$tmp2 = substr($checkcode,$pre_length);
    	$normal_seq = strrev($tmp1).strrev($tmp2);
    	return $normal_seq;    	
    }
    
     /**
      * @functional 加密串算法如下：
        1.  年|月|日|小时|分钟|$oAccount  分钟向前取5的倍数 
           例如：2012-05-01 15:54:00 取值为2012|05|01|15|50|test_bjqy。 (test_bjqy 为广告主账号)
        2. 假如MD5加密该字符串“2012|05|01|15|50|test_bjqy” = f5a39831e96a7b4aadbaff44b93c7665
        3. 取前四位倒序后面的倒序后拼接的值：3a5f5667c39b44ffabdaa4b7a69e1389
     */
     protected function Encryption($oAccount)
     {
        $time = date('Y|m|d|H',time());
        $s = date("i",time());
        $s = floor($s/5)*5;
        if($s<10)
            $s = "0".$s;
            
        $md5Code = md5($time."|".$s."|"."{$oAccount}");
        return strrev(substr($md5Code,0,4)).strrev(substr($md5Code,4));
     }
}


/**
 * 伪登录相关
*/
class Adhai_LoginService extends WebServiceCallerBase
{
    public function __construct()
    {
        parent::__construct();
        $serviceUrl = $this->_arrSysConfig["Adhai".$this->_sys_evn]["Owner_Url"]."/service/login";
        $this->CreatePHPClient($serviceUrl);
    }
    
    /**
     * @functional 登录到网盟
     * @return json data
    */ 
     public function GetLoginToOwnerUrl($oid,$userName)
     {                        
        //$userName = "ps_admin";//用户还没开通 先用 ps_admin 顶//DRP 的用户已经开通到Adhai里去了，就不用这个了。
        $loginName = $this->_arrSysConfig["Adhai_Passport"]["loginName"];
        $loginPwd = $this->_arrSysConfig["Adhai_Passport"]["loginPwd"]; 
        
        $param = array($oid,$userName,$loginName,$loginPwd);
        
        $id = $this->AddLog(__FUNCTION__,$param);
        
        $rtn = $this->ClientCall("redirect",$param);
        $this->UpdateLog($id,$rtn);
                                
        $strOwner_Url = $this->_arrSysConfig["Adhai".$this->_sys_evn]["Owner_Url"];          
        $url = $strOwner_Url . "?sessionid=" . $rtn['sessionid'];
        
        return json_encode(array('base' => $strOwner_Url."/account/redirect" . "?sessionid=" . $rtn['sessionid'],
            'url' => $url, 'loninouturl' => "http://" . $_SERVER["SERVER_NAME"]));
     } 
     
     
    /**
     * @functional 登录到网盟 定向到 资质列表
     * @return json data
    */ 
     public function GetLoginToCertUrl($oid,$userName)
     {                         
        //$userName = "ps_admin";//用户还没开通 先用 ps_admin 顶
        $loginName = $this->_arrSysConfig["Adhai_Passport"]["loginName"];
        $loginPwd = $this->_arrSysConfig["Adhai_Passport"]["loginPwd"]; 
        $param = array($oid,$userName,$loginName,$loginPwd);
        
        $id = $this->AddLog(__FUNCTION__,$param);
        
        $rtn = $this->ClientCall("redirect",$param);
        $this->UpdateLog($id,$rtn);
        $strOwner_Url = $this->_arrSysConfig["Adhai".$this->_sys_evn]["Owner_Url"];  
         
        $url = $strOwner_Url . "/cert?sessionid=" . $rtn['sessionid']; //就比 上面的 GetLoginToOwnerUrl 多了一个 cert
        
        return json_encode(array('base' => $strOwner_Url."/account/redirect" . "?sessionid=" . $rtn['sessionid'],
            'url' => $url, 'loninouturl' => "http://" . $_SERVER["SERVER_NAME"]));
     } 
}