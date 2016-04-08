<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：调用 ERP 财务WebService 接口
 * 创建人：wzx
 * 添加时间：2011-9-18 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Action/Common/WebServiceCallerBase.php';

class ERP_FinanceService extends WebServiceCallerBase
{
    private $_bankID = 115;
    public function __construct()
    {
        parent::__construct();
        if($this->_sys_evn == 2)
        {
            $this->_bankID = 646;//ERP 正式上那个什么银行的ID是646，不过，这个转过去他们也没用在默认值上。
        }
        
        $serviceUrl = $this->_arrSysConfig["ERP".$this->_sys_evn]["Finance_WebService"];
        $this->CreateNetClient($serviceUrl);
    }

    /**
     * @functional 款项认领 
     * @param  $params 参数
     *  //<param name="RpmModeID">收支方式编号</param>
        //<param name="AdrpAccountNo">账户编号</param>
        //<param name="AdrpObjectName">收支对象</param>
        //<param name="AdrpReceiptMoney">收款金额</param>
        //<param name="AdrpCreateTime">收款时间</param>
        //<param name="AdrpUserNamePR">交领款人姓名</param>
        //<param name="AdrpUsserNameOP">收支员工姓名</param>
        //<param name="AdrpFromID">来源编号</param>
        //<param name="AdrpType">订单类型，11－代理保证金 12－代理预存款 17－代理预存款和保证金</param>
        //<param name="AbrID">银行到账记录编号</param>
        //<param name="IsCoerce">是否强制认领，１强制０不强制</param>
     * @return bool true 成功
    */
    public function Finance_Bank_Claim($params)
    {    
        $id = $this->AddLog(__FUNCTION__,$params);
        $result = $this->_client->Finance_Bank_Claim($params);
        $this->UpdateLog($id,$result->Finance_Bank_ClaimResult);
        $v = $result->Finance_Bank_ClaimResult;
        /*
        -1数据操作失败
-2收支类型错误
-3银行记录不存在
-4插入数据到银行资金记录失败
-5银行认领失败
        */
        
        settype($v,"integer");
        return $v;
        /*if($v <= 0)
            return false;
            
        return true;*/
    }  

    public function Finance_Account_BankRecord_Key($params)
    {
        $id = $this->AddLog(__FUNCTION__,$params);
        $result = $this->_client->Finance_Account_BankRecord_Key($params);
        $v = $result->Finance_Account_BankRecord_KeyResult;
        $this->UpdateLog($id,str_replace("'","\"",$v));
        return $v;
    }
    
    /**
     * @functional 添加财务应收和应付记录 
     * @param $params 应收和应付记录数组对象
     * @return bool true 成功
    */ 
     public function Finance_Add_ReceivableOrPay($params)
     {
        $params["P_FR_BANK_ID"] = $this->_bankID; 
        $id = $this->AddLog(__FUNCTION__,$params);
        try
        {                               
            $result = $this->_client->Finance_Add_ReceivableOrPay($params);
            $this->UpdateLog($id,$result->Finance_Add_ReceivableOrPayResult);
            $v = $result->Finance_Add_ReceivableOrPayResult;
            settype($v,"integer");      
            if($v <= 0)
                return false;
        }
        catch(Exception $ex)
        {
            return false;
        }
            
        return true;
     } 


    /**
     * @functional 添加财务开票申请 
     * @param  $params 发票申请数组对象
     * @return bool true 成功
    */
    public function Finance_Add_InvoiceAndPost($params)
    {        
        $id = $this->AddLog(__FUNCTION__,$params);
        //return true;
        try
        {
            $result = $this->_client->Finance_Add_InvoiceAndPost($params);
            $this->UpdateLog($id,$result->Finance_Add_InvoiceAndPostResult);
            $v = $result->Finance_Add_InvoiceAndPostResult;
            settype($v,"integer");
            if($v <= 0)
                return false;
        }
        catch(Exception $ex)
        {
            return false;
        }
        
        return true;
    }  


    /**
     * @functional 打款申请 删除
     * @param  $id  打款申请ID
     * @param  $fr_typeid  打款类型
     * @return bool true 成功
    */
    public function Finance_Del_ReceivableOrPay($id,$fr_typeid)
    {     
        $params = array("P_FR_SOURCE_ID"=>$id,"P_FR_TYPEID"=>$fr_typeid);
        $id = $this->AddLog(__FUNCTION__,$params);
        try
        {
            $result = $this->_client->Finance_Del_ReceivableOrPay($params);
            $this->UpdateLog($id,$result->Finance_Del_ReceivableOrPayResult);
            $v = $result->Finance_Del_ReceivableOrPayResult;
            settype($v,"integer");
            if($v <= 0)
                return false;
        }
        catch(Exception $ex)
        {
            return false;
        }
        
        return true;
    }
}
?>