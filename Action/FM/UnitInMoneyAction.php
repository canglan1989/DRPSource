<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：网盟订单转款模块
 * 创建人：wzx
 * 添加时间：2012-2-19 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerUserBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderRechargeBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../WebService/Adhai_Service.php';
require_once __DIR__.'/../../Class/BLL/AgentModelDetailBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

class UnitInMoneyAction extends ActionBase
{
    public function __construct()
    {
    }
    
    /**
     * @functional 显示转款申请页面
    */
    public function InMoneyModify()
    {
        $this->ExitWhenNoRight("UnitInMoneyList",RightValue::add);
        $objAgentAccountBLL = new AgentAccountBLL();
        //返点可用余额
        $iSaleAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::UnitSaleReward);
        //预存款可用金额
        $iPreDepositsAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::UnitPreDeposits);       
        
        $objComSettingBLL = new ComSettingBLL();
        $iMinInMoney = $objComSettingBLL->GetValueByName(ComSettings::UnitMinInMoney);  
        $this->smarty->assign('iMinInMoney',$iMinInMoney);
        
        $this->smarty->assign('iSaleAccountMoney',$iSaleAccountMoney);
        $this->smarty->assign('iPreDepositsAccountMoney',$iPreDepositsAccountMoney);
                    
        $this->displayPage('FM/Front/UnitInMoney/InMoneyModify.tpl');
    }
    
    public function GetUnitChargeMoney()
    {
        $actMoney = Utility::GetForm("actMoney",$_POST);
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();        
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        $objAgentAccountDetailBLL->GetUnitChargeMoney($this->getAgentID(),$this->getFinanceNo(),$actMoney,$preDepositsMoney,$saleRewardMoney);
        exit($preDepositsMoney.",".$saleRewardMoney);
    }
    
    /**
     * @functional 转款申请提交   
    */
    public function InMoneyModifySubmit()
    {        
        $this->ExitWhenNoRight("UnitInMoneyList",RightValue::add);
        
        $strCustomerUser = Utility::GetForm("tbxCustomerUser",$_POST);
        if($strCustomerUser == "")
            exit("请填写转款帐户！");
            
        $iOrderID = 0;    
        $iProductTypeId = 0;
        $objOrderBLL = new OrderBLL();
        $arrayData = $objOrderBLL->select("order_id,product_type_id","owner_account_name='$strCustomerUser' and is_del=0 and agent_id=".$this->getAgentId(),"order_id desc");
        if(isset($arrayData)&& count($arrayData) > 0)
        {
            $iOrderID = $arrayData[0]["order_id"];
            $iProductTypeId = $arrayData[0]["product_type_id"];
        }
                        
        if($iOrderID <= 0)
            exit("未找到订单ID！");
                
        $iActMoney = Utility::GetFormDouble("tbxActMoney",$_POST);        
        if($iActMoney <= 0)
            exit("请输入转款金额");
            
        $objComSettingBLL = new ComSettingBLL();
        $iMinInMoney = $objComSettingBLL->GetValueByName(ComSettings::UnitMinInMoney);  
        if(round($iActMoney,2) < round($iMinInMoney,2)) 
            exit("转款金额小于最低转款额！");
            
        $agentPactID = 0;
        $agentPactNo = "";
        $objAgentPactBLL = new AgentPactBLL();
        $arrayData = $objAgentPactBLL->GetAgentPact($this->getAgentId(),$iProductTypeId);
        if(isset($arrayData) && count($arrayData)>0)
        {   
            $agentPactID = $arrayData[0]["agent_pact_id"];
            $agentPactNo = $arrayData[0]["pact_number"]."".$arrayData[0]["pact_stage"];
        }
        else
        {
            exit("未找到与此产品的签约合同！");
        }
        
        $iPreDepositsChargeMoney = 0;
        $iSaleChargeMoney = 0;
        /*------------------------预存款账户金额----------e--------------*/ 
        $objAgentAccountBLL = new AgentAccountBLL();
        //返点可用余额
        $iSaleAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::UnitSaleReward);
        //预存款可用金额
        $iPreDepositsAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::UnitPreDeposits);       
        
        if($iSaleAccountMoney + $iPreDepositsAccountMoney < $iActMoney)
            exit("您好，您的预存款余额不足，请及时打款！"); 
           
        /*------------------------扣款比例----------s--------------*/
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();        
        $arrayDetailChargeMoney = $objAgentAccountDetailBLL->GetUnitChargeMoney($this->getAgentId(),$this->getFinanceNo(),$iActMoney,$iPreDepositsChargeMoney,$iSaleChargeMoney);

        /*------------------------扣款比例----------e--------------*/     
        if(round($iPreDepositsAccountMoney,2) < round($iPreDepositsChargeMoney,2))
            exit("您好，您的预存款余额不足，请及时打款！"); 
            
        if(round($iSaleAccountMoney,2) < round($iSaleChargeMoney,2))
            exit("您好，您的返点余额不足！"); 
            
        /*------------------------预存款账户金额----------e--------------*/  
		$objOrderInfo = $objOrderBLL->getModelByID($iOrderID);
        if($objOrderInfo == null)
            exit("未找到此订单！");
            
        $strRemark = Utility::GetRemarkForm("tbxRemark",$_POST);   
		$objOrderRechargeBLL = new OrderRechargeBLL();
                
		$objOrderRechargeInfo = new OrderRechargeInfo();    
        $objOrderRechargeInfo->strRechargeNo = $objOrderRechargeBLL->GetNewNo();
        $objOrderRechargeInfo->iOrderId = $objOrderInfo->iOrderId;
        $objOrderRechargeInfo->strOrderNo = $objOrderInfo->strOrderNo;
        $objOrderRechargeInfo->iCustomerId = $objOrderInfo->iCustomerId;
        $objOrderRechargeInfo->strCustomerName = $objOrderInfo->strCustomerName;
        
        $objOrderRechargeInfo->strCustomerAccount = $strCustomerUser;
        $objOrderRechargeInfo->iAgentId = $this->getAgentId();
        $objOrderRechargeInfo->strAgentNo = $this->getAgentNo();
        $objOrderRechargeInfo->strAgentName = $this->getAgentName();
        $objOrderRechargeInfo->iAgentPactId = $agentPactID;
        $objOrderRechargeInfo->strAgentPactNo = $agentPactNo;
        
        $objOrderRechargeInfo->iPreMoney = $iPreDepositsChargeMoney;        
        $objOrderRechargeInfo->iRebateMoney = $iSaleChargeMoney;
    
        $objOrderRechargeInfo->iRechargeMoney = $iActMoney;
        $objOrderRechargeInfo->iCreateUid = $this->getUserId();
        $objOrderRechargeInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName();
        $objOrderRechargeInfo->strCreateTime = Utility::Now();
        $objOrderRechargeInfo->iUpdateUid = 0;
        $objOrderRechargeInfo->strUpdateUserName = '';
        $objOrderRechargeInfo->strUpdateTime = $objOrderRechargeInfo->strCreateTime;
        $objOrderRechargeInfo->strRemark = $strRemark;
        $objOrderRechargeInfo->iIsDel = 0;
        $objOrderRechargeInfo->iIsCharge = 1;
        $objOrderRechargeInfo->strChargeDate = $objOrderRechargeInfo->strCreateTime;
        $objOrderRechargeInfo->iRechargeStatus = 1;
        $objOrderRechargeInfo->strRechargeStatusText = "已转款";
        
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objOrderRechargeInfo->iAccountGroupId = $objAccountGroupUserBLL->getGroupIdByAgentId($this->getAgentId());
        
        if($objOrderRechargeBLL->insert($objOrderRechargeInfo) >0)
        {
            $objAgentAccountDetailBLL->InsertChargeMoneyDetail($arrayDetailChargeMoney);
            exit("0");
        }
            
        exit("转款失败！");
    }
    
            
    /**
     * @functional 网盟推广转款记录
    */
    public function UnitInMoneyList()
    {
        $this->PageRightValidate("UnitInMoneyList",RightValue::view);
        
        $iOnlyChargePre = Utility::GetForm("onlyChargePre",$_GET);    
        if($iOnlyChargePre == "")
            $iOnlyChargePre = -100;
        
        $strCreateTimeBegin = Utility::GetForm("starttime", $_GET);
        $strCreateTimeEnd = Utility::GetForm("endtime", $_GET);
        $strOperName = Utility::GetForm("opername", $_GET);
        
        $this->smarty->assign("OperName",$strOperName);
        $this->smarty->assign("CreateTimeBegin",$strCreateTimeBegin);
        $this->smarty->assign("CreateTimeEnd",$strCreateTimeEnd);
        $this->smarty->assign('iOnlyChargePre',$iOnlyChargePre); 
        $this->smarty->assign('UnitInMoneyListBody',"/?d=FM&c=UnitInMoney&a=UnitInMoneyListBody"); 
        $this->displayPage('FM/Front/UnitInMoney/UnitInMoneyList.tpl');
    }
    
            
    /**
     * @functional 网盟推广转款记录
    */
    public function Back_UnitInMoneyList()
    {
        $this->PageRightValidate("Back_UnitInMoneyList",RightValue::view);
        $strBeginTime = Utility::GetForm("begintime", $_GET);
        $strEndTime = Utility::GetForm("endtime", $_GET);
        $iIsFirstCharge = Utility::GetFormInt("chargetype", $_GET);
        $iOnlyChargePre = Utility::GetForm("onlyChargePre",$_GET);    
        if($iOnlyChargePre == "")
            $iOnlyChargePre = -100;
        
            
        $qAgentNo = Utility::GetForm("agentNo",$_GET);        
        $this->smarty->assign('qAgentNo',$qAgentNo); 
        $this->smarty->assign("BeginIime",$strBeginTime);
        $this->smarty->assign("EndTime",$strEndTime);
        $this->smarty->assign('ChargeType',$iIsFirstCharge);
        $this->smarty->assign('iOnlyChargePre',$iOnlyChargePre); 
        $this->smarty->assign('UnitInMoneyListBody',"/?d=FM&c=UnitInMoney&a=Back_UnitInMoneyListBody"); 
        $this->displayPage('FM/Backend/UnitInMoneyList.tpl');
    }
    
        
    /**
     * @functional 网盟推广转款记录
    */
    public function Back_UnitInMoneyListBody()
    {
        $this->PageRightValidate("Back_UnitInMoneyList",RightValue::view);
        $sWhere = $this->InMoneyListGetWhere();
                
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
            
        $bExportExcel = false;        
        if(Utility::GetFormInt('exportExcel',$_GET) > 0)
            $bExportExcel = true; 
                
        if($bExportExcel)   
            $iPageSize = DataToExcel::max_record_count;
                    
        $objOrderRechargeBLL = new OrderRechargeBLL();
        $arrPageList = $this->getPageList($objOrderRechargeBLL,"*",$sWhere,"",$iPageSize,$bExportExcel);
        $arrayData = &$arrPageList['list'];
        foreach($arrayData as $key =>$value)
        {
            $arrayData[$key]["charge_type"] = $arrayData[$key]["is_first_charge"] == 1? "新签":"续费";
        }
        
        if($bExportExcel) 
        {            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();

            $objExcelBottomColumns->Add(new ExcelBottomColumn("转款交易号","recharge_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("订单号","order_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no",ExcelDataTypes::String,15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,25));
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("客户名称","customer_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("帐户名","customer_account",ExcelDataTypes::String,25));
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("转款金额","recharge_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款","pre_money",ExcelDataTypes::Double));  
            $objExcelBottomColumns->Add(new ExcelBottomColumn("返点","rebate_money",ExcelDataTypes::Double));  
            $objExcelBottomColumns->Add(new ExcelBottomColumn("操作人","create_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("操作时间","create_time",ExcelDataTypes::DateTime)); 
            $objExcelBottomColumns->Add(new ExcelBottomColumn("转款类型","charge_type"));
            
            $objDataToExcel->Init("网盟推广转款记录",$arrayData,null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
        else
        {
            $this->smarty->assign('arrayData',$arrayData);
            $this->smarty->display('FM/Backend/UnitInMoneyListBody.tpl'); 
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        }
        
    }
    
    protected function InMoneyListGetWhere()
    {
        $sWhere = "";
              
        $strSDate = Utility::GetForm("tbxOptSDate",$_GET);
        $strEDate = Utility::GetForm("tbxOptEDate",$_GET);
        if($strSDate != "")
            $sWhere .= " and `create_time` >= '".$strSDate."'";             
            
        if($strEDate != "")
            $sWhere .= " and `create_time` < ".Utility::SQLEndDate($strEDate);
                          
        $iOnlyChargePre = Utility::GetFormInt("cbOnlyChargePre",$_GET,-100);

        if($iOnlyChargePre == 1)
            $sWhere = " and rebate_money = 0";
        else if($iOnlyChargePre == 0)
            $sWhere = " and rebate_money <> 0";
                
        $strNo = Utility::GetForm("tbxNo",$_GET);        
        if($strNo != "")
            $sWhere .= " and `recharge_no` like '%$strNo%' ";
                
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);
        if($strAgentNo != "")
            $sWhere .= " and agent_no = '".$strAgentNo."'";   
                        
        $strCustomerName = Utility::GetForm("tbxCustomerName",$_GET);        
        if($strCustomerName != "")
            $sWhere .= " and `customer_name` like '%$strCustomerName%' ";
            
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);        
        if($strAgentName != "")
            $sWhere .= " and `agent_name` like '%$strAgentName%' ";
        
        $iIsFirstCharge = Utility::GetFormInt("chargetype", $_GET);
        if(!empty ($iIsFirstCharge)){
            $sWhere .= " and `is_first_charge` = {$iIsFirstCharge} ";
        }
        
        $strOperName = Utility::GetForm("opername", $_GET);
        if(!empty ($strOperName)){
            $sWhere .= " and `create_user_name` like '%{$strOperName}%'";
        }
        
            //exit($sWhere);
        return $sWhere;
    }
    
    /**
     * @functional 网盟推广转款记录
    */
    public function UnitInMoneyListBody()
    {
        $this->PageRightValidate("UnitInMoneyList",RightValue::view);
        $sWhere = " and agent_id=".$this->getAgentId()." and finance_uid=".$this->getFinanceUid().$this->InMoneyListGetWhere();//" and `om_order`.check_status >".CheckStatus::notPost ;  
                
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
                    
        $objOrderRechargeBLL = new OrderRechargeBLL();
        $arrPageList = $this->getPageList($objOrderRechargeBLL,"*",$sWhere,"",$iPageSize);
        $arrayData = &$arrPageList['list'];
        $this->smarty->assign('arrayData',$arrayData);
        $this->smarty->display('FM/Front/UnitInMoney/UnitInMoneyListBody.tpl'); 
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    
    }
    
    
    /**
     * @functional 取得转款帐户
    */
    public function AutoCustomerAccountJson()
    {
        $text = Utility::GetForm('q',$_GET);
        $agentID = $this->getAgentId();
        if($agentID <= 0)
            exit("代理商ID不正确。");
            
        $objOrderBLL = new OrderBLL();
        $strJson = $objOrderBLL->AutoCustomerAccountJson($text,$agentID);
        exit($strJson);
    }
    
    /**
     * @functional 展示退款提交页面
    */
    public function AdhaiMoneyReturnModify()
    {
        $this->PageRightValidate("InOutMoneyModify",RightValue::add);
        
        $agentID = Utility::GetFormInt('agentID',$_GET);
        if($agentID <= 0)
            exit("代理商ID不正确。");
        
        $agentName = Utility::GetForm('agentName',$_GET);
        $this->smarty->assign('agentID',$agentID);
        $this->smarty->assign('agentName',$agentName);
        $this->smarty->display('FM/Backend/AdhaiMoneyReturnModify.tpl'); 
    }
    
    
    /**
     * @functional 网盟退款提交 从Adhai中退回给终端客户的转款。
    */
    public function AdhaiMoneyReturnModifySubmit()
    {
        $this->PageRightValidate("InOutMoneyModify",RightValue::add);
        $agentID = Utility::GetFormInt('tbxAgentID',$_POST);
        if($agentID <= 0)
            exit("代理商ID不正确。");
            
        $accountName = Utility::GetForm('tbxCustomerUser',$_POST);        
        if($accountName == "")
            exit("请选择退款帐号。");
                    
        $objAdhai_FinanceService = new Adhai_FinanceService();
        $canReturnMoeny = $objAdhai_FinanceService->GetOwnerBalance($accountName);
        if(!is_numeric($canReturnMoeny))
            $canReturnMoeny = 0;    
                    
        if($canReturnMoeny <= 0)
            exit("帐号可退金额为0");
            
        /*$iActMoney = Utility::GetFormFloat('tbxActMoney',$_POST);
        if($iActMoney <= 0)
            exit("请输入退款金额。");
        $iActMoney = round($iActMoney,2);
            
        if($canReturnMoeny < $iActMoney)
            exit("退款金额大于帐号可退金额");*/
            
        $iActMoney = $canReturnMoeny;//全部退款
                      
        $objProductTypeBLL = new ProductTypeBLL();        
        $productTypeID = $objProductTypeBLL->GetUnitProductTypeID();       
        $strFinanceNo = "10";
        $iPreMoney = 0;
        $iPreReMoney = 0;
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $aUnitPreReMoneyRate = $objAgentAccountDetailBLL->GetUnitReturnPreReMoney($accountName,$iActMoney,$iPreMoney,$iPreReMoney);
        
        $strRemark = Utility::GetForm('tbxRemark',$_POST);
        $strRemark .=" 终端客户：".$accountName;
        $iCount = 0;
        $objAgentAccountBLL = new AgentAccountBLL();
        if($iPreMoney > 0)
        {
            $objInMoneyAct = new InMoneyAct();
            $objInMoneyAct->Init($agentID,$strFinanceNo,$productTypeID,AgentAccountTypes::UnitPreDeposits,
                BillTypes::UnitBackMoney,Utility::Now(),$iPreMoney);
            $iCount += $objInMoneyAct->Insert($this->getUserId(),$strRemark);
            $objAgentAccountBLL->UpdateOutMoney($agentID,AgentAccountTypes::UnitPreDeposits,$productTypeID);
        }
                
        if($iPreReMoney > 0)
        {
            $objRePreInMoneyAct = new InMoneyAct();
            $objRePreInMoneyAct->Init($agentID,$strFinanceNo,$productTypeID,AgentAccountTypes::UnitSaleReward,
                BillTypes::UnitBackMoney,Utility::Now(),$iPreReMoney);
            $iCount += $objRePreInMoneyAct->Insert($this->getUserId(),$strRemark);
            $objAgentAccountBLL->UpdateOutMoney($agentID,AgentAccountTypes::UnitSaleReward,$productTypeID);
        }
        
        if($iCount > 0)
        {
            $objAdhai_FinanceService->Refund($accountName,$iActMoney,$strRemark);
            exit("0");
        }
        
        exit("退款出错！");
    }
    
	/**
     * @functional 有网盟转款记录的客户帐号
     */
    public function UnitHaveChargeMoneyCustomerAccount()
    {               
        if($this->isAgentUser()) 
            exit("");
            
        $text = Utility::GetForm('q',$_GET);
        $agentID = Utility::GetFormInt('agentID',$_GET);
        if($agentID <= 0)
            exit("代理商ID不正确。");
            
        $objAgentAccountBLL = new AgentAccountBLL();
        $strJson = $objAgentAccountBLL->UnitHaveChargeMoneyCustomerAccount($text,$agentID);
        exit($strJson);
    }
    
    public function GetCustomerCanReturnMoney()
    {        
        if($this->isAgentUser()) 
            exit("0,0,0");//CanReturnMoney  PreRate  ReRate
            
        $accountName = Utility::GetForm('accountName',$_POST);
        if($accountName == "")
            exit("0,0,0");
            
        $objAdhai_FinanceService = new Adhai_FinanceService();
        $moeny = $objAdhai_FinanceService->GetOwnerBalance($accountName);
        if(!is_numeric($moeny))
            $moeny = 0;
            
        if($moeny == 0)
            exit("0,0,0");
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $aUnitPreReMoneyRate = $objAgentAccountDetailBLL->GetUnitReturnPreReMoney($accountName,$moeny,$preDepositsMoney,$saleRewardMoney);
        
        exit("{$moeny},".$preDepositsMoney.",".$saleRewardMoney);
    }
}
?>