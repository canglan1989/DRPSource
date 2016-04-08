<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：预存款模块
 * 创建人：wzx
 * 添加时间：2011-8-18 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/PayMoneyAction.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/InvoiceIsseuBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPreDepositsBLL.php';
require_once __DIR__.'/../../Class/BLL/Back_AgentAccountDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentBLL.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailActBLL.php';
require_once __DIR__.'/../../Class/BLL/ReceivablePayBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentModelDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailBLL.php';

class PreDepositsAction extends PayMoneyAction
{
    public function __construct()
    {
    }
     
    /**
     * @functional 预存款账户管理
     */
    public function PreDepositsAccount()
    {        
        $this->PageRightValidate("PreDepositsAccount",Rightvalue::view);      
        $this->ShowPreDepositsAccountInfo($this->getAgentId(),$this->getFinanceNo());
        $this->smarty->display('FM/Front/PreDepositsAccount.tpl');
    }
    
    
    protected function ShowPreDepositsAccountInfo($agentID,$strFinanceNo)
    {                                         
        $objAgentAccountBLL = new AgentAccountBLL();
        //预存款账户
        $arrayPreDeposits = $objAgentAccountBLL->GetAgentAccount($agentID,$strFinanceNo,AgentAccountTypes::PreDeposits);
        if(!(isset($arrayPreDeposits) && count($arrayPreDeposits) > 0))
            exit("未找到签约产品");
        
        //销奖转预存账户
        $arraySaleReward = $objAgentAccountBLL->GetAgentAccount($agentID,$strFinanceNo,AgentAccountTypes::SaleReward2PreDeposits);
            
        //预存款账户+销奖转预存账户=列表中显示的“预存款账户”        
        $arrayMoney = $objAgentAccountBLL->GetAgentAccountAmount($agentID,$strFinanceNo,AgentAccountTypes::PreDeposits);
        if(!(isset($arrayMoney) && count($arrayMoney)>0))
        {
            $arrayMoney = array(array());
            $arrayMoney[0] = array(
                "account_id" => 0,
                "account_type" => "",
                "product_type_id" => 0,
                "product_type_name" => "",
                "agent_id" => $agentID,
                "in_money" => 0,
                "out_money" => 0,
                "order_out_money" => 0,
                "balance_money" => 0,
                "lock_money" => 0,
                "can_use_money" => 0,
                "other_out_money" => 0
            );
        }
        
        //显示打款被退回信息
        //$postBackBillCount = $objAgentAccountBLL->GetPreDepositsPostBackBillCount($agentID);
        
        //打款提醒
        $postMoneyNotice = "";
        $objComSettingBLL = new ComSettingBLL();
        foreach($arrayPreDeposits as $key => $value)
        {
            if($value["pact_status"] != AgentPactStatus::haveSign)
                continue;
                
            $NoticeMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::Pre_BalanceWarning,0,$value["product_type_no"]);
            if($NoticeMoney > 0)
            {
                if(round($NoticeMoney,2) > round($value["can_use_money"],2))
                {
                    $NoticeMoney = Utility::FormatMoney($NoticeMoney);
                    $postMoneyNotice .= $value["product_type_name"]."预存款余额少于 {$NoticeMoney} 元；";                      
                }
            }
        }
        
        if(strlen($postMoneyNotice) > 0)
        {
            $postMoneyNotice = "您好，您的".$postMoneyNotice."为了不影响您的业务，请及时打款";
        }
        
        Utility::FormatArrayMoney($arrayPreDeposits,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        if(isset($arraySaleReward) && count($arraySaleReward)>0 )
            Utility::FormatArrayMoney($arraySaleReward,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");

        Utility::FormatArrayMoney($arrayMoney,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        
        
        $this->smarty->assign('postMoneyNotice',$postMoneyNotice);
        //$this->smarty->assign('postBackBillCount',$postBackBillCount);        
        $this->smarty->assign('arrayPreDeposits',$arrayPreDeposits);
        $this->smarty->assign('arraySaleReward',$arraySaleReward);
        $this->smarty->assign('arrayMoney',$arrayMoney); 
    }
    
    /**
     * @functional 预存款打款记录
     */
    public function PreDepositsList()
    {
        $this->PageRightValidate("PreDepositsList",Rightvalue::view);        
        //$this->smarty->assign('strTitle','预存款打款明细');
        
        $strPayTypeJson = PayTypes::ToMultiSelectJson();
        $this->smarty->assign('strPayTypeJson',$strPayTypeJson);
        $strPriceStatus = ReceivablePayStates::ToMultiSelectJson();
        
        $qPriceStatusValue = Utility::GetFormInt("priceStatus",$_GET,-100);
        $qPriceStatusText = "";
        if($qPriceStatusValue != -100)
        {
            $qPriceStatusText = ReceivablePayStates::GetText($qPriceStatusValue);
        }
        else
        {
            $qPriceStatusValue = "";
        }        
        
        $qFrTypes = Utility::GetFormInt("cbFrTypes",$_GET);
        
        $this->smarty->assign('qFrTypes',$qFrTypes);
        $this->smarty->assign('strPriceStatus',$strPriceStatus);
        $this->smarty->assign('qPriceStatusValue',$qPriceStatusValue);
        $this->smarty->assign('qPriceStatusText',$qPriceStatusText);
        
        $objProductTypeBLL = new ProductTypeBLL();
        $strProductTypeJson = $objProductTypeBLL->GetSignedProductTypeJson($this->getAgentId(),true);
        $this->smarty->assign('strProductTypeJson',$strProductTypeJson);
        
        $qProductTypeIDs = "";
        $qProductTypeNames = "";
        $productTypeID = Utility::GetFormInt("productTypeID",$_GET);
        if($productTypeID > 0)
        {
            $qProductTypeIDs = $productTypeID;
            $arrayProductType = $objProductTypeBLL->select("product_type_name","aid=".$productTypeID);
            if(isset($arrayProductType) && count($arrayProductType))
                $qProductTypeNames = $arrayProductType[0]["product_type_name"];
        }
        
        $this->smarty->assign('qProductTypeIDs',$qProductTypeIDs);
        $this->smarty->assign('qProductTypeNames',$qProductTypeNames);
                
        $this->smarty->assign('SYS_EVN',$this->arrSysConfig["SYS_EVN"]); 
        $this->smarty->assign('PreDepositsListBody',"/?d=FM&c=PreDeposits&a=PreDepositsListBody");
        $this->smarty->display('FM/Front/PreDepositsList.tpl');
    }


     /**
     * @functional 预存款打款记录数据
     */
    public function PreDepositsListBody()
    {
        $this->ExitWhenNoRight("PreDepositsList",Rightvalue::view); 
        $this->smarty->assign('SYS_EVN',$this->arrSysConfig["SYS_EVN"]);         
        $this->PayMoneyDetailListBody($this->PreDepositsListGetWhere(),"FM/Front/PreDepositsListBody.tpl");
    }
    
     /**
     * @functional 预存款打款记录数据获取查询条件
     */
    public function PreDepositsListGetWhere()
    {   
        $sWhere = " and fm_receivable_pay.fr_object_id=".$this->getAgentId();  
        
        $cbFrTypes = Utility::GetFormInt("cbFrTypes",$_GET);
        if($cbFrTypes > 0)
            $sWhere .= " and fm_receivable_pay.fr_type = ".$cbFrTypes;
        else
            $sWhere .= " and (fm_receivable_pay.fr_type = ".BillTypes::PreDeposits ." or fm_receivable_pay.fr_type = ".BillTypes::UnitPreDeposits.") ";
        
        $productTypeIDs = Utility::GetForm("productTypeIDs",$_GET);         
        $sWhere .= Utility::SQLMultiSelect("fm_receivable_pay.c_product_id",$productTypeIDs);
                
        $priceStatus = Utility::GetForm("priceStatus",$_GET);         
        $sWhere .= Utility::SQLMultiSelect("fm_receivable_pay.fr_state",$priceStatus);
        
        $payMentModels = Utility::GetForm("payMentModels",$_GET);         
        $sWhere .= Utility::SQLMultiSelect("fm_receivable_pay.fr_payment_id",$payMentModels);
                
        $iReceiptStatus = Utility::GetFormInt("cbReceiptStatus",$_GET);
        if($iReceiptStatus == 1)//已开收据
            $sWhere .= " and if(`fm_invoice_bill`.`invoice_bill_id`,`fm_invoice_bill`.`invoice_bill_id`,0) > 0 ";
        else if($iReceiptStatus == 0)//未开收据
            $sWhere .= " and if(`fm_invoice_bill`.`invoice_bill_id`,`fm_invoice_bill`.`invoice_bill_id`,0) = 0 ";
                
        $iInAccount = Utility::GetFormInt("cbInAccount",$_GET);
        if($iInAccount == 1)//已充值
            $sWhere .= " and if(`fm_receivable_pay_state`.`income_uid`,`fm_receivable_pay_state`.`income_uid`,0) > 0 ";
        else if($iInAccount == 0)//未充值   
            $sWhere .= " and if(`fm_receivable_pay_state`.`income_uid`,`fm_receivable_pay_state`.`income_uid`,0) = 0 ";
            
        $postSDate = Utility::GetForm("tbxOptSDate",$_GET);
        if($postSDate != "")
            $sWhere .= " and `fm_receivable_pay`.fr_peer_date >= '".$postSDate."'";             
            
        $postEDate = Utility::GetForm("tbxOptEDate",$_GET);
        if($postEDate != "")
            $sWhere .= " and `fm_receivable_pay`.fr_peer_date < date_add('".$postEDate."',interval 1 day)";    
            
        $strFrNo = Utility::GetForm("tbxFrNo",$_GET);
        if($strFrNo != "")
            $sWhere .= " and `fm_receivable_pay`.fr_no like '%".$strFrNo."%'";
            
        $strRactNo = Utility::GetForm("tbxRactNo",$_GET);
        if($strRactNo != "")
            $sWhere .= " and `fm_receivable_pay`.c_contract_no like '%".$strRactNo."%'";
            
        $strReceiptNo = Utility::GetForm("tbxReceiptNo",$_GET);
        if($strReceiptNo != "")
            $sWhere .= " and `fm_invoice_bill`.`invoice_no` like '%".$strReceiptNo."%'";
                                                
        return $sWhere;        
    }
    
     /**
     * @functional 预存款打款记录数据EXCEL导出
     */
    public function ExcelExportPreDepositsList()
    {
        $this->ExitWhenNoRight("PreDepositsList",Rightvalue::view);  
        $sWhere = $this->PreDepositsListGetWhere();
        
        parent::ExportPostMoneyList("预存款",$sWhere);
        
    }
    
     /**
     * @functional 预存账户充值记录
     */
    public function PreDepositsChange()
    {
        $this->PageRightValidate("PreDepositsChange",Rightvalue::view);
        
        
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
        
        $qAccountType = Utility::GetForm("accountType",$_GET);        
        $qAccountTypeText = "";
        if($qAccountType != "")
        {            
            $aAccountType = explode(",",$qAccountType);
            $iCount = count($aAccountType);
            for($i=0;$i<$iCount;$i++)
            {                
                $qAccountTypeText .= BillTypes::GetText($aAccountType[$i]);
                if($i<$iCount-1)
                    $qAccountTypeText .= "，";
            }
        }
        $this->smarty->assign('qAccountType',$qAccountType); 
        $this->smarty->assign('qAccountTypeText',$qAccountTypeText); 
        $this->smarty->assign('PreDepositsChangeBody',"/?d=FM&c=PreDeposits&a=PreDepositsChangeBody");
        $this->smarty->display('FM/Front/PreDepositsChange.tpl');
    }

    /**
     * @functional 预存账户充值记录数据
     */
    public function PreDepositsChangeBody()
    {
        $this->ExitWhenNoRight("PreDepositsChange",Rightvalue::view);
        $sWhere = $this->PreDepositsChangeGetWhere();
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
        $this->smarty->display('FM/Front/PreDepositsChangeBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
    protected function PreDepositsChangeGetWhere()
    {        
        $sWhere = " and fm_agent_account_detail.agent_id=".$this->getAgentId();
        
        $strAccountType = Utility::GetForm("accountType",$_GET);        
        if($strAccountType != "")
            $sWhere .= Utility::SQLMultiSelect("fm_agent_account_detail.data_type",$strAccountType);
        else
            $sWhere .= " and (fm_agent_account_detail.data_type=".BillTypes::PreDeposits .
            " or fm_agent_account_detail.data_type=".BillTypes::SaleReward2PreDeposits.
            " or fm_agent_account_detail.data_type=".BillTypes::UnitPreDeposits .
            " or fm_agent_account_detail.data_type=".BillTypes::UnitSaleReward.")";
            
        $iProductTypeID = Utility::GetFormInt("cbProductType",$_GET);
        if($iProductTypeID > 0)
            $sWhere .= " and `fm_agent_account_detail`.product_type_id = ".$iProductTypeID;
            
        $optSDate = Utility::GetForm("tbxOptSDate",$_GET);
        if($optSDate != "")
            $sWhere .= " and `fm_agent_account_detail`.create_time >= '".$optSDate."'";             
            
        $optEDate = Utility::GetForm("tbxOptEDate",$_GET);
        if($optEDate != "")
            $sWhere .= " and `fm_agent_account_detail`.create_time < ".Utility::SQLEndDate($optEDate);   //date_add('".$optEDate."',interval 1 day) 
        
        $strAccountDetailNo = Utility::GetForm("tbxAccountDetailNo",$_GET);
        if($strAccountDetailNo != "")
            $sWhere .= " and `fm_agent_account_detail`.source_bill_no like '%".$strAccountDetailNo."%'";
            
        $strContractNo = Utility::GetForm("tbxContractNo",$_GET);
        if($strContractNo != "")
            $sWhere .= " and `fm_agent_account_detail`.agent_pact_no like '%".$strContractNo."%'";
            
        return $sWhere;           
    }
    
    public function ExcelExportPreDepositsChangeList()
    {
        $this->ExitWhenNoRight("PreDepositsChange",Rightvalue::view);
        $sWhere = $this->PreDepositsChangeGetWhere();
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();

        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "create_time desc";
            
        $arrayData = $objAgentAccountDetailBLL->ExportPageData($sWhere,$sOrder);
        
        BillTypes::ReplaceArrayText($arrayData,"data_type");
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款交易号","source_bill_no",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","agent_pact_no",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品","product_type_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("充值金额","act_money",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("充值类型","data_type"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("充值时间","create_time",ExcelDataTypes::DateTime));
        $objDataToExcel->Init("预存账户充值记录",$arrayData,null,$objExcelBottomColumns);
        $objDataToExcel->Export();
    }
        
    /**
     * @functional 代理商预存款账户
    */
    public function Back_PreDepositsAccountList()
    {
        $this->PageRightValidate("Back_PreDepositsAccountList",RightValue::view);
                
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID);              
        
        $this->smarty->assign('PreDepositsAccountBody',"/?d=FM&c=PreDeposits&a=Back_PreDepositsAccountListBody");        
        $this->displayPage('FM/Backend/PreDepositsAccount.tpl'); 
    }
    
    /**
     * @functional 代理商预存款账户数据
    */
    public function Back_PreDepositsAccountListBody()
    {
        $this->ExitWhenNoRight("Back_PreDepositsAccountList",RightValue::view);
        $sWhere = " and fm_agent_account.account_type<>".AgentAccountTypes::GuaranteeMoney." and fm_agent_account.finance_no='10'";
        
        $iAccountType = Utility::GetFormInt("cbAccountType",$_GET);
        if($iAccountType > 0)
            $sWhere .= " and fm_agent_account.account_type = ".$iAccountType;
            
        $iProductType = Utility::GetFormInt("cbProductType",$_GET);
        if($iProductType > 0)
            $sWhere .= " and `fm_agent_account`.`product_type_id` = ".$iProductType;
          
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);        
        if($strAgentNo != "")
            $sWhere .= " and `am_agent_source`.`agent_no` like '%".$strAgentNo."%'";  
                       
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($strAgentName != "")
            $sWhere .= " and `am_agent_source`.`agent_name` like '%".$strAgentName."%'";  
        /*      
        $iLevel = Utility::GetFormInt("cbLevel",$_GET);
        
        if($iLevel > 0)
            $sWhere .= " and `am_agent_pact`.`agent_level` = '".$iLevel."'";
           
        $strPactNo = Utility::GetForm("tbxPactNo",$_GET);        
        if($strPactNo != "")
            $sWhere .= " and `am_agent_pact`.`pact_no` like '%".$strPactNo."%'";  
        */
            
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
            if($value["account_type"]==AgentAccountTypes::UnitPreDeposits)
                $arrayData[$key]["account_type_text"] = "网盟预存款";
            else
                $arrayData[$key]["account_type_text"] = "增值产品预存款";
        }
        
        if($bExportExcel)
        {
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,30));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("产品","product_type_name",ExcelDataTypes::String,25));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("预存款类型","account_type_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("充值总额","in_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("冻结金额","lock_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("消费总额","order_out_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("其他支出","other_out_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("可用金额","can_use_money",ExcelDataTypes::Double));
                        
            $objDataToExcel->Init("代理商预存款账户明细",$arrayData,null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
        else
        {
            $this->smarty->assign('arrayAccountList',$arrayData);
            $this->displayPage('FM/Backend/PreDepositsAccountBody.tpl'); 
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        }
    }
    
    
     /**
     * @functional 收支记录
     */
    public function AccountMoneyInOutList()
    {
        $this->PageRightValidate("AccountMoneyInOutList",Rightvalue::view);        
        
        $qAccountType = Utility::GetFormInt("accountType",$_GET);        
        $this->smarty->assign('qAccountType',$qAccountType); 
                
        $qInOutTypes = Utility::GetForm("inOutTypes",$_GET);  
        $qInOutTypeNames = "";
        if($qInOutTypes != "")
        {
            $qInOutTypeIDs = explode(",",$qInOutTypes);
            $arrayLength = count($qInOutTypeIDs);
            for($i = 0;$i < $arrayLength; $i++)
            {
                settype($qInOutTypeIDs[$i],"integer");
                
                if($qInOutTypeIDs[$i] < 0)
                {
                    $qInOutTypeNames .= BillTypes::GetText(0-$qInOutTypeIDs[$i]);
                    $qInOutTypeNames .= "冲销";
                }
                else
                {                    
                    $qInOutTypeNames .= BillTypes::GetText($qInOutTypeIDs[$i]);
                }
                if($i != $arrayLength-1)
                    $qInOutTypeNames .= "，";
            }
        }
        
        $this->smarty->assign('strInOutTypeJson',BillTypes::ToMultiSelectJson());
        $this->smarty->assign('qInOutTypeNames',$qInOutTypeNames);         
        $this->smarty->assign('qInOutTypes',$qInOutTypes); 
                
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);        
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
                
        $qDataType = Utility::GetFormInt("dataType",$_GET);        
        $this->smarty->assign('qDataType',$qDataType); 
        
        $qInOutType = Utility::GetFormInt("inOutType",$_GET);        
        $this->smarty->assign('qInOutType',$qInOutType); 
        
        
        $this->smarty->assign('AccountMoneyInOutListBody',"/?d=FM&c=PreDeposits&a=AccountMoneyInOutListBody");
        $this->smarty->display('FM/Front/AccountMoneyInOutList.tpl');
    }

    /**
     * @functional 收支记录数据
     */
    public function AccountMoneyInOutListBody()
    {
        $this->ExitWhenNoRight("AccountMoneyInOutList",Rightvalue::view);
        $sWhere = " and fm_agent_account_detail.agent_id=".$this->getAgentId()." and fm_agent_account_detail.finance_uid=".$this->getFinanceUid();
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        //$sOrder = Utility::GetForm("sortField", $_GET);
        $aboutFrozen = 0;//有关于订单冻结和扣款的查询
        $sWhere .= $this->Back_PreDepositsInOutListGetWhere($aboutFrozen);
        
            
        $objBack_AgentAccountDetailBLL = new Back_AgentAccountDetailBLL();
        $arrPageList = $this->getPageList($objBack_AgentAccountDetailBLL,"*",$sWhere,$aboutFrozen,$iPageSize);
        $arrayData = $arrPageList['list'];
        
        AgentAccountTypes::ReplaceArrayText($arrayData,"account_type");
        BillTypes::ReplaceArrayText($arrayData,"data_type");
        
        Utility::FormatArrayMoney($arrayData,"act_money");
        
        $this->smarty->assign('arrayAccountDetail',$arrayData);
        $this->smarty->display('FM/Front/AccountMoneyInOutListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
     /**
     * @functional 收支记录
     */
    public function Back_AccountMoneyInOutList()
    {
        $this->PageRightValidate("Back_AccountMoneyInOutList",Rightvalue::view);      
        
        $qAccountType = Utility::GetFormInt("accountType",$_GET);        
        $this->smarty->assign('qAccountType',$qAccountType); 
        
        $qAgentNo = Utility::GetForm("agentNo",$_GET);        
        $this->smarty->assign('qAgentNo',$qAgentNo); 
        
        $qProductTypeID = Utility::GetFormInt("productTypeID",$_GET);   
        if($qProductTypeID <=0)     
            $qProductTypeID = Utility::GetFormInt("productType",$_GET); 
            
        $this->smarty->assign('qProductTypeID',$qProductTypeID); 
                        
        $qInOutTypes = Utility::GetForm("inOutTypes",$_GET);  
        $qInOutTypeNames = "";
        if($qInOutTypes != "")
        {
            $qInOutTypeIDs = explode(",",$qInOutTypes);
            $arrayLength = count($qInOutTypeIDs);
            for($i = 0;$i < $arrayLength; $i++)
            {
                settype($qInOutTypeIDs[$i],"integer");
                
                if($qInOutTypeIDs[$i] < 0)
                {
                    $qInOutTypeNames .= BillTypes::GetText(0-$qInOutTypeIDs[$i]);
                    $qInOutTypeNames .= "冲销";
                }
                else
                {                    
                    $qInOutTypeNames .= BillTypes::GetText($qInOutTypeIDs[$i]);
                }
                if($i != $arrayLength-1)
                    $qInOutTypeNames .= "，";
            }
        }
        
        $this->smarty->assign('strInOutTypeJson',BillTypes::ToMultiSelectJson());
        $this->smarty->assign('qInOutTypeNames',$qInOutTypeNames);         
        $this->smarty->assign('qInOutTypes',$qInOutTypes); 
                        
        $qInOutType = Utility::GetFormInt("inOutType",$_GET);        
        $this->smarty->assign('qInOutType',$qInOutType); 
        
        $this->smarty->assign('AccountMoneyInOutListBody',"/?d=FM&c=PreDeposits&a=Back_AccountMoneyInOutListBody");
        $this->smarty->display('FM/Backend/AccountMoneyInOutList.tpl');
    }

    /**
     * @functional 收支记录数据
     */
    public function Back_AccountMoneyInOutListBody()
    {
        $this->ExitWhenNoRight("Back_AccountMoneyInOutList",Rightvalue::view);
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        //$sOrder = Utility::GetForm("sortField", $_GET);
        $aboutFrozen = 0;//有关于订单冻结和扣款的查询
        $sWhere = $this->Back_PreDepositsInOutListGetWhere($aboutFrozen);
        
        $objBack_AgentAccountDetailBLL = new Back_AgentAccountDetailBLL();
        $arrPageList = $this->getPageList($objBack_AgentAccountDetailBLL,"*",$sWhere,$aboutFrozen,$iPageSize);
        $arrayData = &$arrPageList['list'];
        
        AgentAccountTypes::ReplaceArrayText($arrayData,"account_type");
        BillTypes::ReplaceArrayText($arrayData,"data_type");
        
        Utility::FormatArrayMoney($arrayData,"act_money");
        
        $this->smarty->assign('arrayAccountDetail',$arrayData);
        $this->smarty->display('FM/Backend/AccountMoneyInOutListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
     /**
     * @functional 收支记录数据
     */
    public function Back_Export_AccountMoneyInOutList()
    {
        $aboutFrozen = 0;//有关于订单冻结和扣款的查询
        $sWhere = $this->Back_PreDepositsInOutListGetWhere($aboutFrozen);
        
    	$iRecordCount = 0;
        $objBack_AgentAccountDetailBLL = new Back_AgentAccountDetailBLL();
        $arrayData = $objBack_AgentAccountDetailBLL->selectPaged(1,DataToExcel::max_record_count,"*",$sWhere,$aboutFrozen,$iRecordCount,true);

        AgentAccountTypes::ReplaceArrayText($arrayData,"account_type");
        BillTypes::ReplaceArrayText($arrayData,"data_type");
        
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("编号","account_detail_no"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","agent_pact_no",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("打款交易号/订单号","source_bill_no",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("账户类型","account_type"));        
        $objExcelBottomColumns->Add(new ExcelBottomColumn("产品","product_type_name",ExcelDataTypes::String,25));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("款项收支类型","data_type"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("收入","rev_money",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("支出","pay_money",ExcelDataTypes::Double));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("操作人","create_user_name",ExcelDataTypes::String,15));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("操作时间","act_date",ExcelDataTypes::DateTime));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("备注","remark",ExcelDataTypes::String,40));

        $objDataToExcel->Init("代理商款项账户收支记录",$arrayData,null,$objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
    protected function Back_PreDepositsInOutListGetWhere(&$aboutFrozen)
    {           
        $sWhere = "";
        $strInOutTypes = Utility::GetForm("inOutTypes",$_GET);        
        if($strInOutTypes != "")
        {
            $aboutFrozen = 1;
            $qInOutTypeIDs = explode(",",$strInOutTypes);
            $arrayLength = count($qInOutTypeIDs);
            $strTemp = " and (";
            $iDataTypeTemp = 0;
            for($i = 0;$i < $arrayLength; $i++)
            {
                settype($qInOutTypeIDs[$i],"integer"); 
                $iDataTypeTemp = $qInOutTypeIDs[$i];
                             
                if($iDataTypeTemp < 0)
                {
                    $strTemp .= " (fm_agent_account_detail.is_red = 1 and ";
                    $iDataTypeTemp = 0 - $iDataTypeTemp;
                }
                
                switch($iDataTypeTemp)
                {
                    case BillTypes::OrderCharge:
                        $strTemp .= " if(order_charge_detail.account_detail_id,1,0) = 1";
                    break;
                    case BillTypes::OrderFreeze:
                        $strTemp .= " if(order_charge_detail.account_detail_id,1,0) = 0 and if(order_lock_detail.account_detail_id,1,0) = 1";
                    break;
                    default:                            
                        $strTemp .= " fm_agent_account_detail.data_type =".$qInOutTypeIDs[$i]." ";
                        $aboutFrozen = 0;
                    break;
                }
                                                   
                if($qInOutTypeIDs[$i] < 0)
                    $strTemp .= ") ";
                    
                if($i != $arrayLength-1)
                    $strTemp .= " or ";
            }
            
            $strTemp .= ")";
            $sWhere .= $strTemp;
        }
                       
        $iAccountType = Utility::GetFormInt("cbAccountType",$_GET);        
        if($iAccountType > 0)
        {
            /**/
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
                    
        $iProductType = Utility::GetFormInt("cbProductType",$_GET);     
        if($iProductType > 0)
            $sWhere .= " and fm_agent_account_detail.product_type_id = ".$iProductType;   
                       
        $iInOutType = Utility::GetFormInt("cbInOutType",$_GET);        
        if($iInOutType == 1 )
            $sWhere .= " and fm_agent_account_detail.rev_money <> 0 ";                  
        else if($iInOutType == -1 )
            $sWhere .= " and fm_agent_account_detail.pay_money <> 0 ";                  
            
        $strPostMoneyNo = Utility::GetForm("tbxPostMoneyNo",$_GET);
        if($strPostMoneyNo != "")
        {            
            $sWhere .= " and (fm_agent_account_detail.data_type = ".BillTypes::GuaranteeMoney
            ." or fm_agent_account_detail.data_type = ".BillTypes::PreDeposits.") ";   
            $sWhere .= " and `fm_agent_account_detail`.`source_bill_no` like '%".$strPostMoneyNo."%'";
        }
            
        $strContractNo = Utility::GetForm("tbxContractNo",$_GET);
        if($strContractNo != "")
            $sWhere .= " and `fm_agent_account_detail`.agent_pact_no like '%".$strContractNo."%'";
             
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);
        if($strAgentNo != "")
            $sWhere .= " and `am_agent`.`agent_no` like '%".$strAgentNo."%'";
            
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($strAgentName != "")
            $sWhere .= " and `am_agent`.`agent_name` like '%".$strAgentName."%'";
            
        $strSourceBillNo = Utility::GetForm("tbxSourceBillNo",$_GET);
        if($strSourceBillNo != "")
        {
            $sWhere .= " and (fm_agent_account_detail.data_type = ".BillTypes::OrderFreeze
            ." or fm_agent_account_detail.data_type = ".BillTypes::OrderCharge
            ." or fm_agent_account_detail.data_type = ".BillTypes::ChargeBack.") ";            
            $sWhere .= " and `fm_agent_account_detail`.`source_bill_no` like '%".$strSourceBillNo."%'";
        }
        
            //print_r($sWhere);
        return $sWhere;           
    }
    
    /**
     * @functional 显示支出操作 
    */
    public function InOutMoneyModify()
    {
        $this->ExitWhenNoRight("InOutMoneyModify",Rightvalue::add);
        $bIsPre = Utility::GetFormInt("isPre",$_GET);
        if($bIsPre == 0)
            $bIsPre = false;
        else 
            $bIsPre = true;
            
        $agentID = Utility::GetFormInt("agentID",$_GET);
        $accountType = Utility::GetFormInt("accountType",$_GET);
        $productTypeID = Utility::GetFormInt("productTypeID",$_GET);
        if($agentID <=0 || $accountType <=0 || $productTypeID <= 0)
            exit("参数有误！");
            
        $canUseMoney = 0;
        $strAgentName = "";
        $strProductTypeName = "";
        
        $objAgentBLL = new AgentBLL();
        $arrayData = $objAgentBLL->select("agent_name","agent_id=".$agentID,"");
        if(isset($arrayData) && count($arrayData) > 0)
            $strAgentName = $arrayData[0]["agent_name"];
        else
            exit("未找到代理商！");
        
        $objProductTypeBLL = new ProductTypeBLL();
        if($productTypeID > 0)
        {
            $arrayData = $objProductTypeBLL->select("product_type_name","aid=".$productTypeID,"");
            if(isset($arrayData) && count($arrayData) > 0)
                $strProductTypeName = $arrayData[0]["product_type_name"];
        }
                
        $strAccountTypeText = AgentAccountTypes::GetText($accountType);
        
        $strDataTypeHTML = "<option value='".BillTypes::PunishMoney."'>违规罚款</option>";
        
        if($bIsPre)
            $strDataTypeHTML .= "<option value='".BillTypes::BackMoney."'>退款</option>";
        else
            $strDataTypeHTML .= "<option value='".BillTypes::GuaranteeMoneyBack."'>退款</option>";
           
        $this->smarty->assign('strDataTypeHTML',$strDataTypeHTML);
        
        $this->smarty->assign('agentID',$agentID);
        $this->smarty->assign('accountType',$accountType);
        $this->smarty->assign('productTypeID',$productTypeID);
        
        $this->smarty->assign('strAgentName',$strAgentName);
        $this->smarty->assign('strProductTypeName',$strProductTypeName);
        $this->smarty->assign('strAccountTypeText',$strAccountTypeText);
        
        $strFinanceNo = "10";
        $objAgentAccountBLL = new AgentAccountBLL();
        $canUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,$accountType,$productTypeID);
        $canRewardUseMoney = 0;
        if($bIsPre)
        {
            if($accountType == AgentAccountTypes::UnitPreDeposits)
                $canRewardUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,AgentAccountTypes::UnitSaleReward,$productTypeID);
            else
                $canRewardUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,AgentAccountTypes::SaleReward,$productTypeID);
        }
        
        $canUseMoneyText = Utility::FormatMoney($canUseMoney);
        $canRewardUseMoneyText = Utility::FormatMoney($canRewardUseMoney);
        
        $this->smarty->assign('canUseMoney',$canUseMoney);
        $this->smarty->assign('canUseMoneyText',$canUseMoneyText);
        
        $this->smarty->assign('canRewardUseMoney',$canRewardUseMoney);
        $this->smarty->assign('canRewardUseMoneyText',$canRewardUseMoneyText);
        
        $this->smarty->assign('bIsPre',$bIsPre?1:0);   
        $this->smarty->assign('bIsUnit',$accountType == AgentAccountTypes::UnitPreDeposits?1:0);     
        $this->smarty->display('FM/Backend/InOutMoneyModify.tpl');
            
    }
    
    /**
     * @functional 收支操作数据提交
    */
    public function InOutMoneyModifySubmit()
    {
        $this->ExitWhenNoRight("InOutMoneyModify",Rightvalue::add);
        $agentID = Utility::GetFormInt("tbxAgentID",$_POST);
        $accountType = Utility::GetFormInt("tbxAccountType",$_POST);
        $productTypeID = Utility::GetFormInt("tbxProductTypeID",$_POST);
        
        if($agentID <=0 || $accountType <=0 )
            exit("参数有误！");
            
        if(AgentAccountTypes::RelevantWithProduct($accountType) && $productTypeID <= 0)
            exit("产品ID有误！");
                    
        $inOutType = Utility::GetFormInt("cbInOutType",$_POST);
        if($inOutType <= 0)
            exit("请选择收支类型！");
            
        $actMoney = Utility::GetFormDouble("tbxActMoney",$_POST);
        $actRewardMoney = Utility::GetFormDouble("tbxRewardActMoney",$_POST);
        if($actMoney+$actRewardMoney <= 0)
            exit("金额不能小等于0！");
        
        $remark = Utility::GetRemarkForm("tbxRemark",$_POST,250);
        $strActDate = date("Y-m-d H:i:s",time());
        $strFinanceNo = "10";
        
        $objAgentAccountBLL = new AgentAccountBLL();
        if($actMoney > 0)
        {
            $canUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,$accountType,$productTypeID);
            $canUseMoney = round($canUseMoney,2);
            $actMoney = round($actMoney,2);
            
            if($canUseMoney < $actMoney)
            {
                if($accountType == AgentAccountTypes::UnitPreDeposits
                || $accountType == AgentAccountTypes::PreDeposits)                
                    exit("预存款支出金额小于可用金额！");
                else            
                    exit("保证金支出金额小于可用金额！");                    
            }
        }
        
        if($actRewardMoney > 0)
        {
            $canUseMoney = 0;
            if($accountType == AgentAccountTypes::UnitPreDeposits)
                $canUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,AgentAccountTypes::UnitSaleReward,$productTypeID);
            else
                $canUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,AgentAccountTypes::SaleReward,$productTypeID);
                
            $canUseMoney = round($canUseMoney,2);
            
            if($canUseMoney < $actRewardMoney)
            {
                if($accountType == AgentAccountTypes::UnitPreDeposits)                
                    exit("返点支出金额小于可用金额！");
                else            
                    exit("销奖支出金额小于可用金额！");   
            }      
        }
        
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayDetailChargeMoney = null;
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        //$bIsUnitProduct = $objProductTypeBLL->IsNetworkAlliance($productTypeID);
        if($accountType == AgentAccountTypes::UnitPreDeposits)
        {
            $arrayDetailChargeMoney = $objAgentAccountDetailBLL->UnitPreDepositsOutMoney($agentID,$strFinanceNo,$actMoney,$actRewardMoney);
        }
        
        $isSuccess = false;        
        if($actMoney > 0)
        {
            $objOutMoneyAct = new OutMoneyAct();
            $objOutMoneyAct->Init($agentID,$strFinanceNo,$productTypeID,$accountType,$inOutType,$strActDate,$actMoney);
            $isSuccess = $objOutMoneyAct->Insert($this->getUserId(),$remark);      
        }
        
        if($actRewardMoney > 0)
        {
            $objOutMoneyAct = new OutMoneyAct();
            
            if($accountType == AgentAccountTypes::UnitPreDeposits)  
                $objOutMoneyAct->Init($agentID,$strFinanceNo,$productTypeID,AgentAccountTypes::UnitSaleReward,$inOutType,$strActDate,$actRewardMoney);
            else
                $objOutMoneyAct->Init($agentID,$strFinanceNo,$productTypeID,AgentAccountTypes::SaleReward,$inOutType,$strActDate,$actRewardMoney);
            
            $isSuccess &= $objOutMoneyAct->Insert($this->getUserId(),$remark); 
        }
        
        if($isSuccess == true)
        {
            if($arrayDetailChargeMoney != null)
                $objAgentAccountDetailBLL->InsertChargeMoneyDetail($arrayDetailChargeMoney);
                
            exit("0");
        }
        
        exit("操作失败！");
    }
    
    
    /**
     * @functional 代理商的预存款账户金额汇总
    */
    public function PreDepositAccountAmount()
    {
        $this->PageRightValidate("PreDepositAccountAmount",Rightvalue::view);    
        
        //预存款账户+销奖转预存账户=列表中显示的“预存款账户”         
        $arrayMoney = array(array());
        $arrayMoney[0]["product_type_id"] = 0;
        $arrayMoney[0]["product_type_name"] = "";
        $arrayMoney[0]["account_type"] = 0;
        $arrayMoney[0]["in_money"] = 0;
        $arrayMoney[0]["out_money"] = 0;
        $arrayMoney[0]["order_out_money"] = 0;
        $arrayMoney[0]["balance_money"] = 0;
        $arrayMoney[0]["lock_money"] = 0;
        $arrayMoney[0]["can_use_money"] = 0;
        $arrayMoney[0]["other_out_money"] = 0;
            
        $objAgentAccountBLL = new AgentAccountBLL();
        //预存款账户        
        $arrayPreDeposits = $objAgentAccountBLL->Back_GetAgentAccount(AgentAccountTypes::PreDeposits);
        foreach($arrayPreDeposits as $key => $value)
        {
            $arrayMoney[0]["in_money"] += $value["in_money"];
            $arrayMoney[0]["out_money"] += $value["out_money"];
            $arrayMoney[0]["order_out_money"] += $value["order_out_money"];
            $arrayMoney[0]["balance_money"] += $value["balance_money"];
            $arrayMoney[0]["lock_money"] += $value["lock_money"];
            $arrayMoney[0]["can_use_money"] += $value["can_use_money"];
            $arrayMoney[0]["other_out_money"] += $value["other_out_money"];
        }
        
        //销奖转预存账户
        $arraySaleReward = $objAgentAccountBLL->Back_GetAgentAccount(AgentAccountTypes::SaleReward2PreDeposits);
        foreach($arraySaleReward as $key => $value)
        {
            $arrayMoney[0]["in_money"] += $value["in_money"];
            $arrayMoney[0]["out_money"] += $value["out_money"];
            $arrayMoney[0]["order_out_money"] += $value["order_out_money"];
            $arrayMoney[0]["balance_money"] += $value["balance_money"];
            $arrayMoney[0]["lock_money"] += $value["lock_money"];
            $arrayMoney[0]["can_use_money"] += $value["can_use_money"];
            $arrayMoney[0]["other_out_money"] += $value["other_out_money"];
        }
        
        Utility::FormatArrayMoney($arrayPreDeposits,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        if(isset($arraySaleReward) && count($arraySaleReward)>0 )
            Utility::FormatArrayMoney($arraySaleReward,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        Utility::FormatArrayMoney($arrayMoney,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");

        $this->smarty->assign('arrayPreDeposits',$arrayPreDeposits);
        $this->smarty->assign('arraySaleReward',$arraySaleReward);
        $this->smarty->assign('arrayMoney',$arrayMoney);    
            
        $this->smarty->display('FM/Backend/PreDepositsAccountAmount.tpl');
    }
    
    public function UnitPreDepositAccountAmount()
    {       
        $this->PageRightValidate("UnitPreDepositAccountAmount",Rightvalue::view);   
        //预存款账户+销奖转预存账户=列表中显示的“预存款账户”         
        $arrayMoney = array(array());
        $objAgentAccountBLL = new AgentAccountBLL();
        //预存款账户        
        $arrayPreDeposits = $objAgentAccountBLL->Back_GetAgentAccount(AgentAccountTypes::UnitPreDeposits);
        if(!(isset($arrayPreDeposits)&& count($arrayPreDeposits)>0))
        {
            $arrayPreDeposits = array(array());
            $arrayPreDeposits[0]["product_type_id"] = 0;
            $arrayPreDeposits[0]["product_type_name"] = "";
            $arrayPreDeposits[0]["account_type"] = AgentAccountTypes::UnitPreDeposits;
            $arrayPreDeposits[0]["in_money"] = 0;
            $arrayPreDeposits[0]["out_money"] = 0;
            $arrayPreDeposits[0]["order_out_money"] = 0;
            $arrayPreDeposits[0]["balance_money"] = 0;
            $arrayPreDeposits[0]["lock_money"] = 0;
            $arrayPreDeposits[0]["can_use_money"] = 0;
            $arrayPreDeposits[0]["other_out_money"] = 0;
        }
        
        $arrayLength = count($arrayPreDeposits);
        for($i=0;$i<$arrayLength;$i++)
        {
            $arrayPreDeposits[$i]["other_out_money"] = $arrayPreDeposits[$i]["out_money"] - $arrayPreDeposits[$i]["order_out_money"];
        }
         
        $arrayMoney[0] = array(
            "product_type_id" => $arrayPreDeposits[0]["product_type_id"],
            "product_type_name" => "",
            "account_type" => AgentAccountTypes::UnitPreDeposits."".AgentAccountTypes::UnitSaleReward,
            "in_money" => $arrayPreDeposits[0]["in_money"],
            "out_money" => $arrayPreDeposits[0]["out_money"],
            "order_out_money" => $arrayPreDeposits[0]["order_out_money"],
            "balance_money" => $arrayPreDeposits[0]["balance_money"],
            "lock_money" => $arrayPreDeposits[0]["lock_money"],
            "can_use_money" => $arrayPreDeposits[0]["can_use_money"],
            "other_out_money" => $arrayPreDeposits[0]["other_out_money"]
            );
            
        //销奖转预存账户
        $arraySaleReward = $objAgentAccountBLL->Back_GetAgentAccount(AgentAccountTypes::UnitSaleReward);
        if(isset($arraySaleReward) && count($arraySaleReward)>0 )
        {
            $arrayLength = count($arraySaleReward);
            for($i=0;$i<$arrayLength;$i++)
            {
                $arraySaleReward[$i]["other_out_money"] = $arraySaleReward[$i]["out_money"] - $arraySaleReward[$i]["order_out_money"];
                
                $arrayMoney[0]["in_money"] += $arraySaleReward[$i]["in_money"];
                $arrayMoney[0]["out_money"] += $arraySaleReward[$i]["out_money"];
                $arrayMoney[0]["order_out_money"] += $arraySaleReward[$i]["order_out_money"];
                $arrayMoney[0]["balance_money"] += $arraySaleReward[$i]["balance_money"];
                $arrayMoney[0]["lock_money"] += $arraySaleReward[$i]["lock_money"];
                $arrayMoney[0]["can_use_money"] += $arraySaleReward[$i]["can_use_money"];
                $arrayMoney[0]["other_out_money"] += $arraySaleReward[$i]["other_out_money"];
            }
        }
              
        Utility::FormatArrayMoney($arrayPreDeposits,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        if(isset($arraySaleReward) && count($arraySaleReward)>0 )
            Utility::FormatArrayMoney($arraySaleReward,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        Utility::FormatArrayMoney($arrayMoney,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");

        $this->smarty->assign('arrayPreDeposits',$arrayPreDeposits);
        $this->smarty->assign('arraySaleReward',$arraySaleReward);
        $this->smarty->assign('arrayMoney',$arrayMoney);    
            
        $this->smarty->display('FM/Backend/UnitPreDepositsAccountAmount.tpl'); 
    }
    
    
    public function AgentPreDepositsAccount()
    {
        $agentID = Utility::GetFormInt("agentID",$_GET);
        if($agentID <= 0)
            exit("参数有误！");
            
        $strFinanceNo = Utility::GetForm("financeNo",$_GET);
        if($strFinanceNo == "")
            $strFinanceNo = "10";
            
        $productTypeID = Utility::GetFormInt("productTypeID",$_GET);
        
        //$this->smarty->assign('strTitle',"代理商预存款明细");    
        $objAgentBLL = new AgentBLL();
        $arrayData = $objAgentBLL->select("agent_no,agent_name","agent_id=$agentID","");
        $strAgentNo = "";
        $strAgentName = "";
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $strAgentNo = $arrayData[0]["agent_no"];
            $strAgentName = $arrayData[0]["agent_name"];
        }
        
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayProduct = $objProductTypeBLL->GetAgentSignedProductType($agentID);
        $unitProductTypeID = $objProductTypeBLL->GetUnitProductTypeID();
        foreach($arrayProduct as $key => $value)
        {
            if($value["product_type_id"] == $unitProductTypeID)
            {
                unset($arrayProduct[$key]);
                break;
            }
        }
        
        $objAgentAccountBLL = new AgentAccountBLL();        
        //预存款账户
        $arrayPreDeposits = $objAgentAccountBLL->GetAgentAccount($agentID,$strFinanceNo,AgentAccountTypes::PreDeposits,$productTypeID);
        if(!(isset($arrayPreDeposits) && count($arrayPreDeposits) > 0))
            exit("未找到签约产品");
            
        //销奖转预存账户
        $arraySaleReward = $objAgentAccountBLL->GetAgentAccount($agentID,$strFinanceNo,AgentAccountTypes::SaleReward2PreDeposits,$productTypeID);
        
        //预存款账户+销奖转预存账户=列表中显示的“预存款账户”        
        $arrayMoney = $objAgentAccountBLL->GetAgentAccountAmount($agentID,$strFinanceNo,AgentAccountTypes::PreDeposits,$productTypeID);
        if(!(isset($arrayMoney) && count($arrayMoney)>0))
        {
            $arrayMoney = array(array());
            $arrayMoney[0] = array(
                "account_id" => 0,
                "account_type" => "",
                "product_type_id" => 0,
                "product_type_name" => "",
                "agent_id" => $agentID,
                "in_money" => 0,
                "out_money" => 0,
                "order_out_money" => 0,
                "balance_money" => 0,
                "lock_money" => 0,
                "can_use_money" => 0,
                "other_out_money" => 0
            );
        }
        
        Utility::FormatArrayMoney($arrayPreDeposits,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        if(isset($arraySaleReward) && count($arraySaleReward)>0 )
            Utility::FormatArrayMoney($arraySaleReward,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");

        Utility::FormatArrayMoney($arrayMoney,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
                       
        $this->smarty->assign('agentID',$agentID);  
        $this->smarty->assign('productTypeID',$productTypeID); 
        $this->smarty->assign('arrayProduct',$arrayProduct);
        $this->smarty->assign('agentNo',$strAgentNo); 
        $this->smarty->assign('strAgentName',$strAgentName);   
        
        $this->smarty->assign('arrayPreDeposits',$arrayPreDeposits);
        $this->smarty->assign('arraySaleReward',$arraySaleReward);
        $this->smarty->assign('arrayMoney',$arrayMoney); 
        
         
        $this->smarty->display('FM/Backend/AgentPreDepositsAccount.tpl');
    }
    
    
    public function UnitAgentPreDepositsAccount()
    {
        $agentID = Utility::GetFormInt("agentID",$_GET);
        if($agentID <= 0)
            exit("参数有误！");
            
        $strFinanceNo = Utility::GetForm("financeNo",$_GET);
        if($strFinanceNo  == "")
            $strFinanceNo = "10";
        
        //$this->smarty->assign('strTitle',"代理商预存款明细");    
        $objAgentBLL = new AgentBLL();
        $arrayData = $objAgentBLL->select("agent_no,agent_name","agent_id=$agentID","");
        $strAgentNo = "";
        $strAgentName = "";
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $strAgentNo = $arrayData[0]["agent_no"];
            $strAgentName = $arrayData[0]["agent_name"];
        }
        
        $this->ShowUnitPreDepositsAccountInfo($agentID,$strFinanceNo);
        $this->smarty->assign('agentID',$agentID);  
        $this->smarty->assign('agentNo',$strAgentNo); 
        $this->smarty->assign('strAgentName',$strAgentName);    
        $this->smarty->display('FM/Backend/AgentUnitPreDepositsAccount.tpl');
    }
    
    
    public function UnitPreDepositsAccount()
    {
        $this->PageRightValidate("UnitPreDepositsAccount",Rightvalue::view);
        $this->ShowUnitPreDepositsAccountInfo($this->getAgentId(),$this->getFinanceNo());        
        $this->smarty->display('FM/Front/UnitPreDepositsAccount.tpl');
    }
    
    private function ShowUnitPreDepositsAccountInfo($agentID,$strFinanceNo)
    {         
        $objAgentAccountBLL = new AgentAccountBLL();       
        //预存款账户        
        $arrayPreDeposits = $objAgentAccountBLL->GetAgentAccount($agentID,$strFinanceNo,AgentAccountTypes::UnitPreDeposits);  
        if(!(isset($arrayPreDeposits) && count($arrayPreDeposits) > 0))            
            exit("未找到签约产品");
            
        //返点转预存账户
        $arraySaleReward = $objAgentAccountBLL->GetAgentAccount($agentID,$strFinanceNo,AgentAccountTypes::UnitSaleReward);
        
        //预存款账户+返点转预存账户=列表中显示的“预存款账户” 
        $arrayMoney = $objAgentAccountBLL->GetAgentAccountAmount($agentID,$strFinanceNo,AgentAccountTypes::UnitPreDeposits);
        if(!(isset($arrayMoney) && count($arrayMoney)>0))
        {
            $arrayMoney = array(array());
            $arrayMoney[0] = array(
                "account_id" => 0,
                "account_type" => "",
                "product_type_id" => 0,
                "product_type_name" => "",
                "agent_id" => $agentID,
                "in_money" => 0,
                "out_money" => 0,
                "order_out_money" => 0,
                "balance_money" => 0,
                "lock_money" => 0,
                "can_use_money" => 0,
                "other_out_money" => 0
            );
        }
        
        //显示打款被退回信息
        //$postBackBillCount = $objAgentAccountBLL->GetPreDepositsPostBackBillCount($agentID,BillTypes::UnitPreDeposits);
        
        //打款提醒
        $postMoneyNotice = "";
        $objComSettingBLL = new ComSettingBLL();
        foreach($arrayPreDeposits as $key => $value)
        {
            if($value["pact_status"] != AgentPactStatus::haveSign)
                continue;
                
            $NoticeMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::Pre_BalanceWarning,0,$value["product_type_no"]);
            if($NoticeMoney > 0)
            {
                if(round($NoticeMoney,2) > round($value["can_use_money"],2))
                {
                    $NoticeMoney = Utility::FormatMoney($NoticeMoney);
                    $postMoneyNotice .= $value["product_type_name"]."预存款账户余额少于 {$NoticeMoney} 元；";                      
                }
            }
        }
        
        if(strlen($postMoneyNotice) > 0)
        {
            $postMoneyNotice = "您好，您的".$postMoneyNotice."为了不影响您的业务，请及时打款";
        }
        
        Utility::FormatArrayMoney($arrayPreDeposits,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        if(isset($arraySaleReward) && count($arraySaleReward)>0 )
            Utility::FormatArrayMoney($arraySaleReward,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        Utility::FormatArrayMoney($arrayMoney,"in_money,out_money,balance_money,lock_money,can_use_money,order_out_money,other_out_money");
        
        $this->smarty->assign('postMoneyNotice',$postMoneyNotice);
        //$this->smarty->assign('postBackBillCount',$postBackBillCount);
        $this->smarty->assign('arrayPreDeposits',$arrayPreDeposits);
        $this->smarty->assign('arraySaleReward',$arraySaleReward);
        $this->smarty->assign('arrayMoney',$arrayMoney); 
    }
    
    
    /**
     * @functional 显示转款操作 
    */
    public function MoveMoneyModify()
    {
        if($this->isAgentUser())
            $this->ExitWhenNoRight("SubAccountDetailList",Rightvalue::add);
        else
            $this->ExitWhenNoRight("InOutMoneyModify",Rightvalue::add);
            
        $agentID = Utility::GetFormInt("agentID",$_GET);
        $iFinanceUid = Utility::GetFormInt("financeUid",$_GET);
        $strFinanceNo = "10";
        $strFinanceUserName = "";
        $iIsAgentUser = 0;//是否为代理商前台的操作
        $strAgentName = "";
        if($this->isAgentUser())
        {
            $agentID = $this->getAgentId();
            $objUserBLL = new UserBLL();
            $objUserInfo = $objUserBLL->getModelByID($iFinanceUid,$agentID);
            $strFinanceNo = $objUserInfo->strFinanceNo;
            $strFinanceUserName = $objUserInfo->strUserName." ".$objUserInfo->strEName;
            $iIsAgentUser = 1;
        }
        else
        {
            $objUserBLL = new UserBLL();            
            $iFinanceUid = $objUserBLL->GetAgentAdminUserID($agentID);
            
            $objAgentBLL = new AgentBLL();
            $arrayData = $objAgentBLL->select("agent_name","agent_id=".$agentID,"");
            if(isset($arrayData) && count($arrayData) > 0)
                $strAgentName = $arrayData[0]["agent_name"];
            else
                exit("未找到代理商！");
        }
        
        $accountType = Utility::GetFormInt("accountType",$_GET);
        $productTypeID = Utility::GetFormInt("productTypeID",$_GET);
        if($agentID <=0 || $accountType <=0 || $productTypeID <=0 || $iFinanceUid <=0 )
            exit("参数有误！");
            
        $canUseMoney = 0;
        $strProductTypeName = "";
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayData = $objProductTypeBLL->select("product_type_name","aid=".$productTypeID,"");
        if(isset($arrayData) && count($arrayData) > 0)
            $strProductTypeName = $arrayData[0]["product_type_name"];
            
        $strAccountTypeText = AgentAccountTypes::GetText($accountType);
        
        $objAgentAccountBLL = new AgentAccountBLL();
        $arrayAgentAccount = $objAgentAccountBLL->GetAgentMainAccount($agentID);
        
        foreach($arrayAgentAccount as $key => $value)
        {   
            if($value["account_type"] == $accountType && $value["product_type_id"] ==$productTypeID)
            {
                unset($arrayAgentAccount[$key]);
            }
        }
        
        $this->smarty->assign('arrayAgentAccount',$arrayAgentAccount);        
        $this->smarty->assign('agentID',$agentID);
        $this->smarty->assign('accountType',$accountType);
        $this->smarty->assign('productTypeID',$productTypeID);
        
        $this->smarty->assign('strAgentName',$strAgentName);
        $this->smarty->assign('strProductTypeName',$strProductTypeName);
        $this->smarty->assign('strAccountTypeText',$strAccountTypeText);
                    
        $objAgentAccountBLL = new AgentAccountBLL();
        $canUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,$accountType,$productTypeID);
        $canUseMoneyText = Utility::FormatMoney($canUseMoney);
        $this->smarty->assign('canUseMoney',$canUseMoney);
        $this->smarty->assign('canUseMoneyText',$canUseMoneyText);
                
        $reMoney = 0;
        $this->smarty->assign('reMoney',$reMoney);
            
        $bIsUnitPreDeposits = 0;
        $iUnitSaleRewardMoney = 0;
        $iUnitSaleRewardMoneyText = "";
        if($accountType == AgentAccountTypes::UnitPreDeposits)
        {
            $bIsUnitPreDeposits = 1;
            $iUnitSaleRewardMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,AgentAccountTypes::UnitSaleReward,$productTypeID);
            $iUnitSaleRewardMoneyText = Utility::FormatMoney($iUnitSaleRewardMoney);
        }
        
        $this->smarty->assign('bIsUnitPreDeposits',$bIsUnitPreDeposits);
        $this->smarty->assign('iUnitSaleRewardMoney',$iUnitSaleRewardMoney);
        $this->smarty->assign('iUnitSaleRewardMoneyText',$iUnitSaleRewardMoneyText);
        
        $this->smarty->assign('iIsAgentUser',$iIsAgentUser);
        $this->smarty->assign('iFinanceUid',$iFinanceUid);
        $this->smarty->assign('strFinanceUserName',$strFinanceUserName);
        $this->smarty->display('FM/Backend/MoveMoneyModify.tpl');
            
    }
    
    /**
     * @functional 转款操作数据提交
    */
    public function MoveMoneyModifySubmit()
    {
        $agentID = 0;
        $strFinanceNo = "10";
        
        if($this->isAgentUser())
        {
            $this->ExitWhenNoRight("SubAccountDetailList",Rightvalue::add);
            $agentID = $this->getAgentId();
            $iFinanceUid = Utility::GetFormInt("tbxFinanceUid",$_POST);
            if($iFinanceUid <=0 )
                exit("参数有误！");
                
            $objUserBLL = new UserBLL();
            $objUserInfo = $objUserBLL->getModelByID($iFinanceUid,$agentID);
            $strFinanceNo = $objUserInfo->strFinanceNo;
        }            
        else
        {
            $this->ExitWhenNoRight("InOutMoneyModify",Rightvalue::add);
            $agentID = Utility::GetFormInt("tbxAgentID",$_POST);            
        }
                                
        $accountType = Utility::GetFormInt("tbxAccountType",$_POST);
        $productTypeID = Utility::GetFormInt("tbxProductTypeID",$_POST);
        
        if($agentID <=0 || $accountType <=0 )
            exit("参数有误！");
            
        if($productTypeID <= 0)
            exit("产品ID有误！");
                    
        $strAccountProductType = Utility::GetForm("cbAccountProductType",$_POST);
        if($strAccountProductType == "")
            exit("请选择转入帐户！");
            
        $aAccountProductType = explode(",",$strAccountProductType);
        $iAccountType = $aAccountProductType[0];
        $iProductType = $aAccountProductType[1];
        settype($iAccountType,"integer");
        settype($iProductType,"integer");
        if($iProductType < 0 || $iAccountType < 0)    
            exit("转入帐户有误！");
            
        $actMoney = Utility::GetFormDouble("tbxActMoney",$_POST);
        if($actMoney <= 0)
            exit("金额不能小等于0！");
        
        $remark = Utility::GetRemarkForm("tbxRemark",$_POST,250);
        
        $objAgentAccountBLL = new AgentAccountBLL();
        $canUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,$accountType,$productTypeID);
        $canUseMoney = round($canUseMoney,2);
        $actMoney = round($actMoney,2);
        
        if($canUseMoney < $actMoney)
        {
            exit("转款金额大于可用金额！");
        }    
        
        $iUnitSaleRewardMoney = 0;
        $arrayDetailChargeMoney = null;
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL(); 
        if($accountType == AgentAccountTypes::UnitPreDeposits)
        {          
            $arrayDetailChargeMoney = $objAgentAccountDetailBLL->UnitPreDepositsMoveMoney($agentID,$strFinanceNo,$actMoney,$iUnitSaleRewardMoney);

            $iUnitSaleRewardCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,$strFinanceNo,AgentAccountTypes::UnitSaleReward,$productTypeID);
            if($iUnitSaleRewardMoney > round($iUnitSaleRewardCanUseMoney,2))
            {
                exit("返点扣款金额大于可用金额！");
            }
        }
        
        $isSuccess = false;
        $objAccountMoneyMove = new AccountMoneyMove();
        $isSuccess = $objAccountMoneyMove->Move($agentID,$strFinanceNo,$accountType,$productTypeID,$iAccountType,
        $iProductType,$actMoney,$this->getUserId(),$remark);
        if($isSuccess == true)
        {
            if($accountType == AgentAccountTypes::UnitPreDeposits && $iUnitSaleRewardMoney > 0)
            {
                //扣除返点
                $strActDate = Utility::Now();
                $objOutMoneyAct = new OutMoneyAct();
                $objOutMoneyAct->Init($agentID,$strFinanceNo,$productTypeID,AgentAccountTypes::UnitSaleReward,
                BillTypes::UnitSaleCharge,$strActDate,$iUnitSaleRewardMoney);
                $isSuccess = $objOutMoneyAct->Insert($this->getUserId(),$remark);  
                
                if($isSuccess == false)
                    exit("返点扣款失败！");
            }
            
            if($arrayDetailChargeMoney != null)
                $objAgentAccountDetailBLL->InsertChargeMoneyDetail($arrayDetailChargeMoney);
                
            exit("0");
        }
        
        exit("操作失败！");
    }
    
    /**
     * @functional 从网盟预存款中转出金额时对应返点扣除多少
    */
    public function UnitPreDepositsMoveMoney()
    {
        if(!$this->isAgentUser() && !$this->HaveRight("InOutMoneyModify",Rightvalue::add))
            exit("0");
                        
        $strFinanceNo = "10";
        $agentID = Utility::GetFormInt("agentID",$_POST);
        if($this->isAgentUser())
        {
            $agentID = $this->getAgentId();
            
            $iFinanceUid = Utility::GetFormInt("financeUid",$_POST);
            if($iFinanceUid <=0 )
                exit("参数有误！");
                
            $objUserBLL = new UserBLL();
            $objUserInfo = $objUserBLL->getModelByID($iFinanceUid,$agentID);
            $strFinanceNo = $objUserInfo->strFinanceNo;
        }            
            
        $actMoney = Utility::GetFormDouble("actMoney",$_POST);
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();      
        $iUnitSaleRewardMoney = 0;  
        $objAgentAccountDetailBLL->UnitPreDepositsMoveMoney($agentID,$strFinanceNo,$actMoney,$iUnitSaleRewardMoney);
        
        exit($iUnitSaleRewardMoney."");
    }
    
    
    /**
     * @functional 金额转入网盟预存款时返点金额返多少
    */
    public function GetUnitSaleRewardMoney()
    {
        if(!$this->isAgentUser() && !$this->HaveRight("InOutMoneyModify",Rightvalue::add))
            exit("0");
            
        $iUnitSaleRewardMoney = 0;
        $agentID = Utility::GetFormInt("agentID",$_POST);
        if($this->isAgentUser())    
            $agentID = $this->getAgentId();
            
        $actMoney = Utility::GetFormDouble("actMoney",$_POST);
        
        $objAgentModelDetailBLL = new AgentModelDetailBLL();        
        $iUnitSaleRewardMoney = $objAgentModelDetailBLL->GetUnitSaleRewardMoney($agentID,$actMoney);
        
        exit($iUnitSaleRewardMoney."");
    }
    
}
?>