<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：网盟订单转款模块
 * 创建人：wzx
 * 添加时间：2013-3-4 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/Back_AgentAccountDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderRechargeBLL.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPreDepositsBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentModelDetailBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

class AccountInOutMoneyAction extends ActionBase
{
    public function __construct()
    {
    }
    
    /**
     * @function 给下级转款
    */
    public function SubAccountInMoneyModify()
    {
        //$this->ExitWhenNoRight("SubAccountInMoneyList",RightValue::add);
        $objProductTypeBLL = new ProductTypeBLL();
        $unitProductTypeID = $objProductTypeBLL->GetUnitProductTypeID();
        $this->smarty->assign('unitProductTypeID',$unitProductTypeID);
        
        $objUserBLL = new UserBLL();
        $arraySubAccount = $objUserBLL->select("user_id,user_name,e_name","agent_id=".$this->getAgentId()
            ." and is_finance = 1 and length(finance_no)=".(strlen($this->getFinanceNo())+2),"user_name");        
        $this->smarty->assign('arraySubAccount',$arraySubAccount);
        
        $objAgentAccountBLL = new AgentAccountBLL();
        $arrayAgentAccount = $objAgentAccountBLL->GetAgentAccountCanUseMoney($this->getAgentId(),$this->getFinanceUid());
        $this->smarty->assign('arrayAgentAccount',$arrayAgentAccount);
        
        $this->smarty->display('FM/Front/SubAccountInMoneyModify.tpl');
    }
    
    
    /**
     * @function 给下级转款
    */
    public function SubAccountInMoneyModifySubmit()    
    {
        //$this->ExitWhenNoRight("SubAccountInMoneyList",RightValue::add);
        $accountID = Utility::GetFormInt("cbAccountName",$_POST);
        if($accountID <= 0)
            exit("请选择下级财务账户");
        
        $toFinanceNo = "";
        $objUserBLL = new UserBLL();
        $arraySubAccount = $objUserBLL->select("finance_no","agent_id=".$this->getAgentId()
           ." and user_id = ".$accountID." and is_finance = 1 and length(finance_no)=".(strlen($this->getFinanceNo())+2),"user_name");  
        if(isset($arraySubAccount)&&count($arraySubAccount) >0)        
            $toFinanceNo = $arraySubAccount[0]["finance_no"];
        else
            exit("未找到下级财务账户");
        
        $objAgentAccountBLL = new AgentAccountBLL();
        $arrayAgentAccount = $objAgentAccountBLL->GetAgentAccountDetail($this->getAgentId(),$this->getFinanceUid());
        $moneyAmount = 0;
        $aProductType = array();
        $aAccountType = array();
        $aInMoney = array();
        $cText = "";
        $fIndex = -1;
        $fText = "";
        
        foreach($arrayAgentAccount as $key=>$value)
        {
            if($value["account_type"] <= 0)
                continue;
            
            $fText = "";
            $cText = "";
            switch($value["account_type"])
            {
                case AgentAccountTypes::GuaranteeMoney:
                    $fText = "Gua";
                    $cText = $value["product_type_name"]."保证金帐户";
                break;
                case AgentAccountTypes::PreDeposits:
                case AgentAccountTypes::UnitPreDeposits:
                    $fText = "Pre";
                    $cText = $value["product_type_name"]."预存款帐户";
                break;
                case AgentAccountTypes::SaleReward:
                    $fText = "Rew";
                    $cText = $value["product_type_name"]."销奖帐户";
                break;
                case AgentAccountTypes::UnitSaleReward:
                    $fText = "Rew";
                    $cText = $value["product_type_name"]."返点帐户";
                break;
            }
            
            $fText = "tbx{$fText}Money_".$value["product_type_id"];
            if(Utility::GetFormDouble($fText,$_POST)<=0)
                continue;
                                
            $fIndex++;
            $aInMoney[$fIndex] = Utility::GetFormDouble($fText,$_POST);            
            if($aInMoney[$fIndex]-$value["can_use_money"]>0)            
                exit($cText."金额不足！");
                
            $aAccountType[$fIndex] = $value["account_type"];
            $aProductType[$fIndex] = $value["product_type_id"];
                
            $moneyAmount += $aInMoney[$fIndex];
        }        
        
        if($moneyAmount <= 0)
            exit("请输入转款金额！");
            
        $agentID = $this->getAgentId();
        $remark = Utility::GetRemarkForm("tbxRemark",$_POST);        
        $count = count($aProductType);
        $strActDate = Utility::Now();
        $strOutFinanceNo = $this->getFinanceNo();
        $actUid = $this->getUserId();
        $arrayDetailChargeMoney = null;
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        //$bIsUnitProduct = $objProductTypeBLL->IsNetworkAlliance($productTypeID);
        
        for($i=0;$i<$count;$i++)
        {
            $arrayDetailChargeMoney = null;
            if($aAccountType[$i] == AgentAccountTypes::UnitPreDeposits)
            {
                $arrayDetailChargeMoney = $objAgentAccountDetailBLL->UnitPreDepositsOutMoney($agentID,$strOutFinanceNo,$aInMoney[$i],0);
            }
            else if($aAccountType[$i] == AgentAccountTypes::UnitSaleReward)
            {
                $arrayDetailChargeMoney = $objAgentAccountDetailBLL->UnitPreDepositsOutMoney($agentID,$strOutFinanceNo,0,$aInMoney[$i]);
            }
            
            $objOutMoneyAct = new OutMoneyAct();
            $objOutMoneyAct->Init($agentID,$strOutFinanceNo,$aProductType[$i],$aAccountType[$i],
                BillTypes::MoveMoneyOutSup,$strActDate,$aInMoney[$i]);
            $isSuccess = $objOutMoneyAct->Insert($actUid,$remark);
            if($isSuccess)
            {
                $objInMoneyAct = new InMoneyAct();
                $objInMoneyAct->Init($agentID,$toFinanceNo,$aProductType[$i],$aAccountType[$i],
                    BillTypes::MoveMoneyInSub,$strActDate,$aInMoney[$i]);
                $objInMoneyAct->Insert($actUid,$remark);
                
                if($arrayDetailChargeMoney != null)
                    $objAgentAccountDetailBLL->InsertChargeMoneyDetail($arrayDetailChargeMoney);
            }
        }
        
        exit("0");
    }
    
    
    public function SubAccountInMoneyList()
    {
        $this->PageRightValidate("SubAccountInMoneyList",RightValue::view);
        
        $objUserBLL = new UserBLL();
        $arraySubAccount = $objUserBLL->select("user_id,user_name,e_name","agent_id=".$this->getAgentId()
            ." and is_finance = 1 and length(finance_no)=".(strlen($this->getFinanceNo())+2),"user_name");        
        $this->smarty->assign('arraySubAccount',$arraySubAccount);
        
        $iProductType = Utility::GetFormInt("productTypeID",$_GET,-100);            
        $iFinanceUid = Utility::GetFormInt("financeUid",$_GET,-100);                                
        $iAccountType = Utility::GetFormInt("accountType",$_GET,-100);
        if($iAccountType == AgentAccountTypes::UnitSaleReward)
            $iAccountType = AgentAccountTypes::UnitPreDeposits;
        else if($iAccountType == AgentAccountTypes::SaleReward)
            $iAccountType = AgentAccountTypes::PreDeposits;
            
        $this->smarty->assign('iProductType',$iProductType);  
        $this->smarty->assign('iFinanceUid',$iFinanceUid);  
        $this->smarty->assign('iAccountType',$iAccountType);  
        
        $this->smarty->assign('ListBody',"/?d=FM&c=AccountInOutMoney&a=SubAccountInMoneyListBody");        
        $this->smarty->display('FM/Front/SubAccountInMoneyList.tpl');
    }
    
    public function SubAccountInMoneyListBody()
    {
        $this->ExitWhenNoRight("SubAccountInMoneyList",RightValue::view);
        $sWhere = " and fm_agent_account_detail.agent_id=".$this->getAgentId()
            ." and length(fm_agent_account_detail.finance_no)=".(strlen($this->getFinanceNo())+2)
            ." and fm_agent_account_detail.data_type=".BillTypes::MoveMoneyInSub; 
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $sOrder = Utility::GetForm("sortField", $_GET);
        
        $iProductType = Utility::GetFormInt("cbProductType",$_GET);     
        if($iProductType > 0)
            $sWhere .= " and fm_agent_account_detail.product_type_id = ".$iProductType; 
            
        $cbSubAccount = Utility::GetFormInt("cbSubAccount",$_GET);     
        if($cbSubAccount > 0)
            $sWhere .= " and fm_agent_account_detail.finance_uid = ".$cbSubAccount;   
                                
        $iAccountType = Utility::GetFormInt("cbAccountType",$_GET);        
        if($iAccountType > 0)
        {
            if($iAccountType == AgentAccountTypes::PreDeposits)
            {                
                $sWhere .= " and (fm_agent_account_detail.account_type = ".AgentAccountTypes::PreDeposits .
                " or fm_agent_account_detail.account_type = ".AgentAccountTypes::SaleReward2PreDeposits .
                " or fm_agent_account_detail.account_type = ".AgentAccountTypes::GuaranteeMoney2PreDeposits .") "; 
            }
            else if($iAccountType == AgentAccountTypes::UnitPreDeposits)
            {                
                $sWhere .= " and (fm_agent_account_detail.account_type = ".AgentAccountTypes::UnitPreDeposits .
                " or fm_agent_account_detail.account_type = ".AgentAccountTypes::UnitSaleReward .") "; 
            }
            else
                $sWhere .= " and fm_agent_account_detail.account_type = ".$iAccountType; 
        } 
                    
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $arrPageList = $this->getPageList2($objAgentAccountDetailBLL,"selectPagedFinanceUserName","*",$sWhere,$sOrder,$iPageSize);
        $arrayData = &$arrPageList['list'];
        AgentAccountTypes::ReplaceArrayText($arrayData,"account_type");
        /*
        BillTypes::ReplaceArrayText($arrayData,"data_type");
        
        Utility::FormatArrayMoney($arrayData,"act_money");
        */
        $this->smarty->assign('arrayAccountDetail',$arrayData);
        $this->smarty->display('FM/Front/SubAccountInMoneyListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
    
    public function SubAccountDetailList()
    {
        $this->PageRightValidate("SubAccountDetailList",RightValue::view);
        
        $objUserBLL = new UserBLL();
        $arraySubAccount = $objUserBLL->select("user_id,user_name,e_name","agent_id=".$this->getAgentId()
            ." and is_finance = 1 and length(finance_no)=".(strlen($this->getFinanceNo())+2),"user_name");        
        $this->smarty->assign('arraySubAccount',$arraySubAccount);
        $this->smarty->assign('ListBody',"/?d=FM&c=AccountInOutMoney&a=SubAccountDetailListBody");        
        $this->smarty->display('FM/Front/SubAccountDetailList.tpl');
    }
    
    public function SubAccountDetailListBody()
    {
        $this->ExitWhenNoRight("SubAccountDetailList",RightValue::view);
        $sWhere = " and fm_agent_account.agent_id=".$this->getAgentId()
            ." and length(fm_agent_account.finance_no)=".(strlen($this->getFinanceNo())+2);
        
        $iAccountType = Utility::GetFormInt("cbAccountType",$_GET);
        if($iAccountType > 0)
            $sWhere .= " and fm_agent_account.account_type = ".$iAccountType;
            
        $iProductType = Utility::GetFormInt("cbProductType",$_GET);
        if($iProductType > 0)
            $sWhere .= " and `fm_agent_account`.`product_type_id` = ".$iProductType;
          
        $cbSubAccount = Utility::GetFormInt("cbSubAccount",$_GET);     
        if($cbSubAccount > 0)
            $sWhere .= " and fm_agent_account.finance_uid = ".$cbSubAccount;  
            
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $sOrder = Utility::GetForm("sortField", $_GET);            
        $bExportExcel = (Utility::GetFormInt("iExportExcel", $_GET) == 1?true:false); 
        $objAgentPreDepositsBLL = new AgentPreDepositsBLL();        
        $arrPageList = $this->getPageList($objAgentPreDepositsBLL,"*",$sWhere,$sOrder,$iPageSize,$bExportExcel);
        $arrayData = &$arrPageList['list'];
        Utility::FormatArrayMoney($arrayData,"in_money,out_money,balance_money,lock_money,can_use_money,have_apply_money,can_apply_money,other_out_money,order_out_money");        
        foreach($arrayData as $key => $value )
        {
            if($value["account_type"] == AgentAccountTypes::GuaranteeMoney)
                $arrayData[$key]["account_type_text"] = "保证金帐户";
            else
                $arrayData[$key]["account_type_text"] = "预存款帐户";
        }
        
        if($bExportExcel)
        {
        }
        else
        {
            $this->smarty->assign('arrayAccountList',$arrayData);
            $this->displayPage('FM/Front/SubAccountDetailListBody.tpl'); 
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        }
    }
    
}
?>