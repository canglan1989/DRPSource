<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：保证金模块
 * 创建人：wzx
 * 添加时间：2011-8-17 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/PayMoneyAction.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPreDepositsBLL.php';


class GuaranteeMoneyAction extends PayMoneyAction
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->GuaranteeMoneyAccount();
    }    
        
    /**
     * @functional 保证金列表
    */
    public function GuaranteeMoneyAccount()
    {        
        $this->PageRightValidate("GuaranteeMoneyAccount",RightValue::view);
                    
        $objAgentAccountBLL = new AgentAccountBLL();       
        //保证金账户        
        $arrayGuaranteeMoney = $objAgentAccountBLL->GetAgentAccount($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::GuaranteeMoney);  
        if(!(isset($arrayGuaranteeMoney) && count($arrayGuaranteeMoney) > 0))            
            exit("未找到签约产品");
                    
        //保证金总账户
        $arrPageList = $objAgentAccountBLL->GetAgentAccountAmount($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::GuaranteeMoney);
        if(!(isset($arrPageList) && count($arrPageList)>0))
        {
            $arrPageList = array(array());
            $arrPageList[0] = array(
                "account_id" => 0,
                "account_type" => "",
                "product_type_id" => 0,
                "product_type_name" => "",
                "agent_id" => $this->getAgentId(),
                "in_money" => 0,
                "out_money" => 0,
                "order_out_money" => 0,
                "balance_money" => 0,
                "lock_money" => 0,
                "can_use_money" => 0,
                "other_out_money" => 0
            );
        }
        
        //打款提醒
        $postMoneyNotice = "";
        $objComSettingBLL = new ComSettingBLL();
        foreach($arrayGuaranteeMoney as $key => $value)
        {
            if($value["pact_status"] != AgentPactStatus::haveSign)
                continue;
                
            $NoticeMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::Gua_BalanceWarning,0,$value["product_type_no"]);
            if($NoticeMoney > 0)
            {
                if(round($NoticeMoney,2) > round($value["can_use_money"],2))
                {
                    $NoticeMoney = Utility::FormatMoney($NoticeMoney);
                    $postMoneyNotice .= $value["product_type_name"]."保证金余额少于 {$NoticeMoney} 元；";                      
                }
            }
        }
        
        if(strlen($postMoneyNotice) > 0)
        {
            $postMoneyNotice = "您好，您的".$postMoneyNotice."为了不影响您的业务，请及时打款";
        }
        
        Utility::FormatArrayMoney($arrPageList,"in_money,out_money,order_out_money,balance_money,lock_money,can_use_money");
        Utility::FormatArrayMoney($arrayGuaranteeMoney,"in_money,out_money,order_out_money,balance_money,lock_money,can_use_money");
        
        $this->smarty->assign('arrayGuaranteeMoney',$arrayGuaranteeMoney);
        $this->smarty->assign('arrPageList',$arrPageList);
        $this->smarty->assign('postMoneyNotice',$postMoneyNotice);
        $this->smarty->display('FM/Front/GuaranteeMoneyAccount.tpl');
    }
    
        
    /**
     * @functional 保证金列表
    */
    public function GuaranteeMoneyList()
    {        
        $this->PageRightValidate("GuaranteeMoneyList",RightValue::view);
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);
        $qPriceStatus = Utility::GetFormInt("priceStatus",$_GET,-100);
        $this->smarty->assign('qPriceStatus',$qPriceStatus); 
        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
        $this->smarty->assign('GuaranteeMoneyListBody',"/?d=FM&c=GuaranteeMoney&a=GuaranteeMoneyListBody");        
        $this->smarty->display('FM/Front/GuaranteeMoneyList.tpl');
    }
    
    /**
     * @functional 保证金列表数据内容
    */
    public function GuaranteeMoneyListBody()
    {        
        $this->ExitWhenNoRight("GuaranteeMoneyList",RightValue::view);
        $sWhere = $this->GuaranteeMoneyListGetWhere();       

        $this->PayMoneyDetailListBody($sWhere,"FM/Front/GuaranteeMoneyListBody.tpl");
    }
    
    protected function GuaranteeMoneyListGetWhere()
    {
        $sWhere = " and fm_receivable_pay.fr_type = ".BillTypes::GuaranteeMoney
        ." and fm_receivable_pay.fr_object_id=".$this->getAgentId();  
        
        $iPriceStatus = Utility::GetFormInt("cbPriceStatus",$_GET);
        if($iPriceStatus != -100)
            $sWhere .= " and `fm_receivable_pay`.fr_state =".$iPriceStatus;
        
        $iProductType = Utility::GetFormInt("cbProductType",$_GET);
        if($iProductType != -100)
            $sWhere .= " and `fm_receivable_pay`.c_product_id =".$iProductType;
                    
        $iReceiptStatus = Utility::GetFormInt("cbReceiptStatus",$_GET);
        if($iReceiptStatus == 1)//已开收据
            $sWhere .= " and if(`fm_invoice_bill`.`invoice_bill_id`,`fm_invoice_bill`.`invoice_bill_id`,0) > 0 ";
        else if($iReceiptStatus == 0)//未开收据
            $sWhere .= " and if(`fm_invoice_bill`.`invoice_bill_id`,`fm_invoice_bill`.`invoice_bill_id`,0) = 0 ";

        $strFrNo = Utility::GetForm("tbxFrNo",$_GET);
        if($strFrNo != "")
            $sWhere .= " and `fm_receivable_pay`.fr_no like '%".$strFrNo."%'";
            
        $strPactNo = Utility::GetForm("tbxPactNo",$_GET);
        if($strPactNo != "")
            $sWhere .= " and `fm_receivable_pay`.c_contract_no like '%".$strPactNo."%'";
        
        return $sWhere;
    }
    
    /**
     * @functional 保证金账户收支明细
    */
    public function GuaranteeMoneyInOutList()    
    {
        $this->PageRightValidate("GuaranteeMoneyInOutList",Rightvalue::view);
        
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
        
        $this->smarty->assign('GuaranteeMoneyInOutListBody',"/?d=FM&c=GuaranteeMoney&a=GuaranteeMoneyInOutListBody");
        $this->smarty->display('FM/Front/GuaranteeMoneyInOutList.tpl');
    }
        
      
    /**
     * @functional 保证金账户收支明细
    */
    public function GuaranteeMoneyInOutListBody()    
    {
        $this->ExitWhenNoRight("GuaranteeMoneyInOutList",Rightvalue::view);
        $sWhere = $this->GuaranteeMoneyInOutListGetWhere();
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "create_time desc";
            
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $arrPageList = $this->getPageList($objAgentAccountDetailBLL,"*",$sWhere,$sOrder,$iPageSize);
        
        BillTypes::ReplaceArrayText($arrPageList['list'],"data_type");
        Utility::FormatArrayMoney($arrPageList['list'],"act_money");
        
        $this->smarty->assign('arrayAccountDetail',$arrPageList['list']);
        $this->smarty->display('FM/Front/GuaranteeMoneyInOutListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }  
    
    private function GuaranteeMoneyInOutListGetWhere()
    {
        $sWhere = " and fm_agent_account_detail.agent_id=".$this->getAgentId()
        ." and fm_agent_account_detail.account_type=".AgentAccountTypes::GuaranteeMoney;
        
        $iDataType = Utility::GetFormInt("cbDataType",$_GET);        
        if($iDataType > 0)
            $sWhere .= " and fm_agent_account_detail.data_type = ".$iDataType;  
                     
        $iProductTypeID = Utility::GetFormInt("cbProductType",$_GET);
        if($iProductTypeID > 0)
            $sWhere .= " and `fm_agent_account_detail`.product_type_id = ".$iProductTypeID;
            
        $strAccountDetailNo = Utility::GetForm("tbxAccountDetailNo",$_GET);
        if($strAccountDetailNo != "")
            $sWhere .= " and `fm_agent_account_detail`.source_bill_no like '%".$strAccountDetailNo."%'";
            
        $strContractNo = Utility::GetForm("tbxContractNo",$_GET);
        if($strContractNo != "")
            $sWhere .= " and `fm_agent_account_detail`.agent_pact_no like '%".$strContractNo."%'";
                   
        $optSDate = Utility::GetForm("tbxOptSDate",$_GET);
        if($optSDate != "")
            $sWhere .= " and `fm_agent_account_detail`.create_time >= '".$optSDate."'";             
            
        $optEDate = Utility::GetForm("tbxOptEDate",$_GET);
        if($optEDate != "")
            $sWhere .= " and `fm_agent_account_detail`.create_time < ".Utility::SQLEndDate($optEDate);   //date_add('".$optEDate."',interval 1 day) 
        return $sWhere;
    }
    
    public function ExcelExportGuaranteeMoneyInOutList()    
    {
        $sWhere = $this->GuaranteeMoneyInOutListGetWhere();
        
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "create_time desc";
            
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $arrayData = $objAgentAccountDetailBLL->ExportPageData($sWhere,$sOrder);
        BillTypes::ReplaceArrayText($arrayData,"data_type");
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("保证金交易号","source_bill_no"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","agent_pact_no",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品","product_type_name",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("款项操作类型","data_type"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("收入","rev_money",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("支出","pay_money",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("余额","balance_money",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("款项操作时间","create_time",ExcelDataTypes::DateTime));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("操作备注","remark",ExcelDataTypes::String,30));

        $objDataToExcel->Init("保证金账户收支记录",$arrayData,null,$objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
    /**
     * @functional 保证金列表EXCEL导出
    */
    public function ExcelExportGuaranteeMoneyAccount()
    {              
        $objAgentAccountBLL = new AgentAccountBLL();       
        //保证金账户        
        $arrayGuaranteeMoney = $objAgentAccountBLL->GetAgentAccount($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::GuaranteeMoney);  
        if(!(isset($arrayGuaranteeMoney) && count($arrayGuaranteeMoney) > 0))            
            exit("未找到签约产品");
                    
        //保证金总账户
        $arrData = $objAgentAccountBLL->GetAgentAccountAmount($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::GuaranteeMoney);        
        if(isset($arrData) && count($arrData)>0)
        {
             $arrData[0]["account_id"] = 0;
             $arrData[0]["account_type"] = 0;
             $arrData[0]["product_type_id"] = 0;
             $arrData[0]["pact_no"] = "";
             $arrData[0]["pact_sdate"] = "";
             $arrData[0]["pact_edate"] = "";
             $arrData[0]["product_type_name"] = "";
             $arrData[0]["agent_id"] = $this->getAgentId();
        }
        else
        {
            $arrData = array(array());
            $arrData[0] = array(
                "account_id" => 0,
                "account_type" => "",
                "product_type_id" => 0,
                "pact_no" => "",
                "pact_sdate" => "",
                "pact_edate" => "",
                "product_type_name" => "",
                "agent_id" => $this->getAgentId(),
                "in_money" => 0,
                "out_money" => 0,
                "order_out_money" => 0,
                "balance_money" => 0,
                "lock_money" => 0,
                "can_use_money" => 0,
                "other_out_money" => 0
            );
        }
        
        $arrPageList = array();
        foreach($arrData as $key => $value)
        {
            array_push($arrPageList,$value);
        }
        
        foreach($arrayGuaranteeMoney as $key => $value)
        {
            array_push($arrPageList,$value);
        }
        
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品","product_type_name",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","pact_no",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同开始日期","pact_sdate",ExcelDataTypes::Date));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同结束日期","pact_edate",ExcelDataTypes::Date));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("入账金额","in_money",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("出账金额","out_money",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("账户余额","balance_money",ExcelDataTypes::Double));
        $objDataToExcel->Init("保证金账户信息",$arrPageList,null,$objExcelBottomColumns);
        $objDataToExcel->Export();
        
    }
        
      
    /**
     * @functional 代理商保证金账户管理
    */
    public function Back_GuaranteeAccountList()
    {
        $this->PageRightValidate("Back_GuaranteeAccountList",RightValue::view);        
        
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
                    
        $this->smarty->assign('GuaranteeAccountListBody',"/?d=FM&c=GuaranteeMoney&a=Back_GuaranteeAccountListBody");
        
        $this->displayPage('FM/Backend/GuaranteeMoneyAccount.tpl'); 
    }
    
    /**
     * @functional 代理商保证金账户数据
    */
    public function Back_GuaranteeAccountListBody()
    {
        $this->ExitWhenNoRight("Back_GuaranteeAccountList",RightValue::view);
        $sWhere = " and fm_agent_account.account_type=".AgentAccountTypes::GuaranteeMoney." and fm_agent_account.finance_no='10'";
        
        $iProductType = Utility::GetFormInt("cbProductType",$_GET);
        if($iProductType > 0)
            $sWhere .= " and `fm_agent_account`.`product_type_id` = ".$iProductType;
          
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);        
        if($strAgentNo != "")
            $sWhere .= " and `am_agent_source`.`agent_no` like '%".$strAgentNo."%'";  
                       
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($strAgentName != "")
            $sWhere .= " and `am_agent_source`.`agent_name` like '%".$strAgentName."%'";  
                        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        
        $sOrder = Utility::GetForm("sortField", $_GET);            
            
        $objAgentPreDepositsBLL = new AgentPreDepositsBLL();        
        $arrPageList = $this->getPageList($objAgentPreDepositsBLL,"*",$sWhere,$sOrder,$iPageSize,($iExportExcel==1?true:false));
        //AgentAccountTypes::ReplaceArrayText($arrPageList['list'],"account_type");
        if($iExportExcel == 1)
        {
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("产品","product_type_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("入账金额","in_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("出账金额","out_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("账户余额","balance_money",ExcelDataTypes::Double));
            $objDataToExcel->Init("保证金账户",$arrPageList['list'],null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
        else
        {
            Utility::FormatArrayMoney($arrPageList['list'],"in_money,out_money,balance_money,lock_money,can_use_money,have_apply_money,can_apply_money,other_out_money,order_out_money");        
       
            $this->smarty->assign('arrayAccountList',$arrPageList['list']);
            $this->displayPage('FM/Backend/GuaranteeMoneyAccountBody.tpl'); 
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
           
        }
        
    }   
    
}
