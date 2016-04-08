<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：向ERP提供 财务WebService 接口
 * 创建人：wzx
 * 添加时间：2011-8-30 
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Action/Common/WebServiceProviderBase.php';
require_once __DIR__.'/../Class/BLL/ReceivablePayBLL.php';
require_once __DIR__.'/../Class/BLL/InvoiceIsseuBLL.php';
require_once __DIR__.'/../Class/BLL/UserBLL.php';
require_once __DIR__.'/../Class/BLL/OrderRechargeBLL.php';

class Finance extends WebServiceProviderBase
{    
    public function __construct()
    {        
        parent::__construct();
        $this->_Permission_IP = $this->_arrSysConfig["ERP".$this->_sys_evn]["Permission_IP"];
    }
    
    /**
     * @functional 打款退回
     * @param $frID 应收款项操作单据ID
     * @param $backUid 退回人
     * @param $backRemark 退回备注
     * @return int 1 成功
    */
    public function PostMoneyBack($frID,$backUid,$backRemark)
    {
        $this->AddLog(__FUNCTION__,array($frID,$backUid,$backRemark));
        if($this->IPIsNotPermission()) return 0;            
            
        $userID = 0;
        $userName = "";
        $objUserBLL = new UserBLL();
        $objUserBLL->GetUserNameAndIDByEID($backUid,$userID,$userName);
        
        $objReceivablePayBLL = new ReceivablePayBLL();
        if($objReceivablePayBLL->UpdatePostMoneyState($frID,ReceivablePayStates::Back,$userID,$userName,$backRemark))//-1 退回
            return 1;
            
        return 0;
    }
    
    /**
     * @functional 底单入款
     * @param $frID 应收款项操作单据ID
     * @param $receivableUid 入款人
     * @param $actMoney 入款金额
     * @param $iBankId 入款银行ID
     * @param $strBankName 入款银行名称
     * @param $strRemark 入款备注
     * @return int 1 成功
    */
    public function PostMoneyReceivable($frID,$receivableUid,$actMoney,$iBankId ,$strBankName,$strRemark)
    {
        $this->AddLog(__FUNCTION__,array($frID,$receivableUid,$actMoney,$iBankId ,$strBankName,$strRemark));
        if($this->IPIsNotPermission()) return 0;  
        
        $userID = 0;
        $userName = "";
        $objUserBLL = new UserBLL();
        $objUserBLL->GetUserNameAndIDByEID($receivableUid,$userID,$userName);
        
        $objReceivablePayBLL = new ReceivablePayBLL();
        if($objReceivablePayBLL->UpdatePostMoneyState($frID,ReceivablePayStates::Receivable,$userID,$userName,$strRemark,$actMoney,$iBankId ,$strBankName))//1 底单入款
            return 1;
            
        return 0;
    }
    
    /**
     * @functional 打款确认 
     * @param $frID 应收款项操作单据ID
     * @param $confirmUid 确认人ID
     * @param $confirmTime 确认时间
     * @return int 1 成功
    */
    public function PostMoneyConfirm($frID,$confirmUid,$actMoney,$iBankId,$strBankName,$strRemark)
    {
        $this->AddLog(__FUNCTION__,array($frID,$confirmUid,$actMoney,$iBankId,$strBankName,$strRemark));
        if($this->IPIsNotPermission()) return 0;  
        
        $userID = 0;
        $userName = "";
        $objUserBLL = new UserBLL();
        $objUserBLL->GetUserNameAndIDByEID($confirmUid,$userID,$userName);
        //到帐时间用的是到账操作时间，可能和ERP里的到账时间有出入(它那里的可以改到账时间)
        //影响不大，就不改这个接口了 2011.12.29
        $objReceivablePayBLL = new ReceivablePayBLL();                
        if($objReceivablePayBLL->PostMoneyConfirm($frID,$userID,$userName,$actMoney,$iBankId ,$strBankName,$strRemark))
            return 1;
            
        return 0;
    }
           
    
    /**
     * @functional 到账后 财务开收据
     * @param $ifMoneySourceIDs 收据来源 关联fm_receivable_pay表的fr_id，以“,”分隔
     * @param $iOpenUid 开据人ID
     * @param $strOpenTime 开据时间
     * @param $iFinancialPlatform 财务平台
     * @param $strReceiptNum 收据号 为空则表示删除
     * @param $fInvoiceTitle 收据抬头
     * @param $ifInvoiceApplyMoney 收据金额
     * @param $ifReceiveType 收据领取方式 1:自领2:邮寄
     * @param $strfRemark 开据备注
     * @param $fIssend 是否已领取
     * @return int 1 成功 0失败 
    */
    public function OpenReceipt($ifMoneySourceIDs,$iOpenUid,$strOpenTime,$iFinancialPlatform,
        $strReceiptNum,$fInvoiceTitle,$ifInvoiceApplyMoney,$ifReceiveType,$strfRemark,$fIssend)
    {
        $this->AddLog(__FUNCTION__,array($ifMoneySourceIDs,$iOpenUid,$strOpenTime,$iFinancialPlatform,
        $strReceiptNum,$fInvoiceTitle,$ifInvoiceApplyMoney,$ifReceiveType,$strfRemark,$fIssend));
        if($this->IPIsNotPermission()) return 0;  
        
        $userID = 0;
        $userName = "";
        $objUserBLL = new UserBLL();
        $objUserBLL->GetUserNameAndIDByEID($iOpenUid,$userID,$userName);
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        return $objInvoiceIsseuBLL->OpenReceipt($ifMoneySourceIDs,$userID,$userName,$strOpenTime,$iFinancialPlatform,
        $strReceiptNum,$fInvoiceTitle,$ifInvoiceApplyMoney,$ifReceiveType,$strfRemark,$fIssend);
    }
    
     /**
     * @functional 合并开票
     * @param $fiiIDs 发票申单据ID，以“,”分隔
     * @param $iOpenUid 开发人ID
     * @param $strOpenTime 开发时间
     * @param $iFinancialPlatform 财务平台
     * @param $strInvoiceNum 发票号 为空则表示删除
     * @param $fInvoiceTitle 发票抬头
     * @param $ifInvoiceApplyMoney 发票金额
     * @param $ifReceiveType 发票领取方式 1:自领2:邮寄
     * @param $strfRemark 发票备注
     * @param $fIssend 是否已领取
     * @return int 1 成功 0失败 
    */
    public function OpenInvoices($fiiIDs,$iOpenUid,$strOpenTime,$iFinancialPlatform,
        $strInvoiceNum,$fInvoiceTitle,$ifInvoiceApplyMoney,$ifReceiveType,$strfRemark,$fIssend)
    {       
        $this->AddLog(__FUNCTION__,array($fiiIDs,$iOpenUid,$strOpenTime,$iFinancialPlatform,
        $strInvoiceNum,$fInvoiceTitle,$ifInvoiceApplyMoney,$ifReceiveType,$strfRemark,$fIssend));
        if($this->IPIsNotPermission()) return 0;  
        
        $userID = 0;
        $userName = "";
        $objUserBLL = new UserBLL();
        $objUserBLL->GetUserNameAndIDByEID($iOpenUid,$userID,$userName);
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        if($strInvoiceNum == "")
            return $objInvoiceIsseuBLL->OpenInvoicesBack($fiiIDs,$userID,$userName);
        else
            return $objInvoiceIsseuBLL->OpenInvoices($fiiIDs,$userID,$userName,$strOpenTime,$iFinancialPlatform,
            $strInvoicetNum,$fInvoiceTitle,$ifInvoiceApplyMoney,$ifReceiveType,$strfRemark,$fIssend);
    }
    
    /**
     * @functional 发票申请 的开票
     * @param $fiiID 发票申单据ID
     * @param $iInvoiceState 开票状态 2全部开票 1部分开票
     * @param $updateUid 更新人ID
     * @param $ifReceiveType 开票领取方式 1:自领2:邮寄
     * @param $fIssend 是否已领取 /=====以下是有效发票信息====/
     * @param $iOpenUids 开票人ID，以“,”分隔
     * @param $strOpenTimes 开票时间，以“,”分隔
     * @param $iFinancialPlatforms 开票平台，以“,”分隔
     * @param $strInvoiceNums 发票号，以“,”分隔
     * @param $fInvoiceTitles 发票台头，以“,”分隔
     * @param $strInvoiceMoney 发票金额，以“,”分隔
     * @param $strRemark 备注，以“,”分隔
     * @return int 1 成功
     */
    public function OpenInvoice($fiiID,$iInvoiceState,$updateUid,$ifReceiveType,$fIssend,
    $iOpenUids,$strOpenTimes,$iFinancialPlatforms,$strInvoiceNums,$fInvoiceTitles,$strInvoiceMoneys,$strfRemarks)
    {        
        $this->AddLog(__FUNCTION__,array($fiiID,$iInvoiceState,$updateUid,$ifReceiveType,$fIssend,
        $iOpenUids,$strOpenTimes,$iFinancialPlatforms,$strInvoiceNums,$fInvoiceTitles,$strInvoiceMoneys,$strfRemarks));
        if($this->IPIsNotPermission()) return 0;  
        
        $userID = 0;
        $userName = "";
        $objUserBLL = new UserBLL();        
        $objUserBLL->GetUserNameAndIDByEID($updateUid,$userID,$userName);
        
        $aOpenUid = array();
        $aOpenUserName = array();        
        $aOpenTime = array();
        $aFinancialPlatform = array();
        $aInvoiceNum = array();
        $aInvoiceTitle = array();
        $aInvoiceMoney = array();
        $aRemark = array();
        
        if($strInvoiceNums != 0 && $strInvoiceNums != "")
        {
            $aOpenUid = explode(",",$iOpenUids);
            $iOpenUidCount = count($aOpenUid);
            
            for($i=0;$i<$iOpenUidCount;$i++)
            {
                $openUid = $aOpenUid[$i];
                $aOpenUid[$i] = 0;
                $aOpenUserName[$i] = "";
                $objUserBLL->GetUserNameAndIDByEID($openUid,$aOpenUid[$i],$aOpenUserName[$i]);            
            }
            
            $aOpenTime = explode(",",$strOpenTimes);
            $aFinancialPlatform = explode(",",$iFinancialPlatforms);
            $aInvoiceNum = explode(",",$strInvoiceNums);
            $aInvoiceTitle = explode(",",$fInvoiceTitles);
            $aInvoiceMoney = explode(",",$strInvoiceMoneys);
            $aRemark = explode(",",$strfRemarks);            
        }
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        if($objInvoiceIsseuBLL->OpenInvoice($fiiID,$iInvoiceState,$userID,$userName,$ifReceiveType,$fIssend,
        $aOpenUid,$aOpenUserName,$aOpenTime,$aFinancialPlatform,$aInvoiceNum,$aInvoiceTitle,$aInvoiceMoney,$aRemark) == true)
            return 1;
        
        return 0;
    }
    
    /**
     * @functional 发票申单退回操作 
     * @param $fiiID 发票申单据ID
     * @param $updateUid 退回人ID
     * @param $strRemark 备注
     * @return int 1 成功
    */
    public function InvoiceBack($fiiID,$backUid,$strRemark)
    {
        $this->AddLog(__FUNCTION__,array($fiiID,$backUid,$strRemark));
        if($this->IPIsNotPermission()) return 0;  
        
        $userID = 0;
        $userName = "";
        $objUserBLL = new UserBLL();
        $objUserBLL->GetUserNameAndIDByEID($backUid,$userID,$userName);
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        if($objInvoiceIsseuBLL->InvoiceBack($fiiID,$userID,$userName,$strRemark) == true)
            return 1;
        
        return 0;
    }
    
    /**
     * @functional 本月新开代理商数，按合同个数统计 
     * @return json
    */
    public function ChannelNewAgent()
    {
        $objOrderRechargeBLL = new OrderRechargeBLL();
        return $objOrderRechargeBLL->ChannelNewAgent();            
    }
}

$arrSysConfig = unserialize(SYS_CONFIG);
$sys_evn = $arrSysConfig['SYS_EVN'];//系统环境 0开发 1测试 2正式
settype($sys_evn,"integer");
$server = new SoapServer(($sys_evn == 2? "Finance.wsdl":"TestFinance.wsdl"), array('soap_version' => SOAP_1_2));
$server->setClass("Finance");
$server->handle();

?>