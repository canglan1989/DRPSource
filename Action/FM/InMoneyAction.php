<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：打款充值模块
 * 创建人：wzx
 * 添加时间：2011-10-27 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgentBankBLL.php';
require_once __DIR__.'/../../Class/BLL/BankAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/ReceivablePayBLL.php';
require_once __DIR__.'/../../Class/BLL/InvoiceIsseuBLL.php';
require_once __DIR__.'/../../Class/BLL/DepartmentBLL.php';
require_once __DIR__.'/../../Class/BLL/ReceivablePayStateBLL.php';
require_once __DIR__.'/../../Class/BLL/InMoneyBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailActBLL.php';
require_once __DIR__.'/../../Class/BLL/ReceivablesDetailsBLL.php';
require_once __DIR__.'/../../Class/BLL/PostMoneyBLL.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPostMoneyDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentModelDetailBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

class InMoneyAction extends ActionBase
{    
    /**
     * @functional 已收款充值管理列表
    */ 
    public function MoneyInAccountList()
    {      
        $this->PageRightValidate("MoneyInAccountList",Rightvalue::view);
        
        $qAgentNo = Utility::GetForm("agentNo",$_GET);
        $this->smarty->assign('qAgentNo',$qAgentNo);
        
        $this->smarty->assign('MoneyInAccountListBody',"/?d=FM&c=InMoney&a=MoneyInAccountListBody");
        $this->smarty->display('FM/Backend/MoneyInAccountList.tpl'); 
    }
    
    
    /**
     * @functional 已收款充值管理列表 数据
    */ 
    public function MoneyInAccountListBody()
    {
        $this->ExitWhenNoRight("MoneyInAccountList",Rightvalue::view);
        $sWhere = "";
        
        /*$iMoneyState = Utility::GetFormInt("cbMoneyState",$_GET);        
        if($iMoneyState != -100)
            $sWhere .= " and `fm_post_money`.`post_money_state` =".$iMoneyState;*/
            
        $iInAccountState = Utility::GetFormInt("cbInAccountState",$_GET);        
        if($iInAccountState != -100)
        {
            if($iInAccountState == 1)//已充值
                $sWhere .= " and `fm_receivable_pay_state`.income_uid > 0";
            else if($iInAccountState == 0)//未充值
                $sWhere .= " and `fm_receivable_pay_state`.fr_state > -1 and `fm_receivable_pay_state`.income_uid <= 0";
            else if($iInAccountState == -1)//取消充值
                $sWhere .= " and `fm_receivable_pay_state`.fr_state = -1";
        }
                        
        $strContractNo = Utility::GetForm("tbxContractNo",$_GET);        
        if($strContractNo != "")
            $sWhere .= " and `fm_post_money`.`agent_pact_nos` like '%$strContractNo%' ";
        
        $strPostMoneyNo = Utility::GetForm("tbxPostMoneyNo",$_GET);        
        if($strPostMoneyNo != "")
            $sWhere .= " and `fm_post_money`.`post_money_no` like '%$strPostMoneyNo%' ";
            
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);        
        if($strAgentNo != "")
            $sWhere .= " and `fm_post_money`.`agent_no` like '%$strAgentNo%' ";
            
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);        
        if($strAgentName != "")
            $sWhere .= " and `fm_post_money`.`agent_name` like '%$strAgentName%' ";

        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
                        
        $bExportExcel = false;        
        if(Utility::GetFormInt('iExportExcel',$_GET) > 0)
            $bExportExcel = true; 
                
        $objInMoneyBLL = new InMoneyBLL();
        $arrPageList = $this->getPageList($objInMoneyBLL,"*",$sWhere,"",$iPageSize,$bExportExcel);
        $arrayData = &$arrPageList['list'];
        
        foreach($arrayData as $key => $value)
        {
            if($arrayData[$key]["payment_id"] != PayTypes::Cash)
            {
                if($arrayData[$key]["rp_num"] != "")
                    $arrayData[$key]["agent_bank_name"] = $arrayData[$key]["rp_num"]." ".$arrayData[$key]["agent_bank_name"];
                    
            }
            else
            {
                $arrayData[$key]["agent_bank_name"] = "";
            }
            
            $arrayData[$key]["income_state_text"] = "未充值";
            if($value["income_uid"] > 0)
                $arrayData[$key]["income_state_text"] = "已充值";
            else
            {
                if($value["income_state"] == -1)//-1取消充值
                    $arrayData[$key]["income_state_text"] = "取消充值";
                
                $arrayData[$key]["income_money"] = "";
                $arrayData[$key]["income_user_name"] = "";
                $arrayData[$key]["income_time"] = "";
                $arrayData[$key]["income_remark"] = "";
            }
        }
        
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrayInMoney',$arrayData);
            $this->smarty->display('FM/Backend/MoneyInAccountListBody.tpl'); 
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
           
        }
        else
        {
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款交易号","post_money_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,25));    
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款产品","product_type_names",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("关联合同号","agent_pact_nos",ExcelDataTypes::String,25));    
            $objExcelBottomColumns->Add(new ExcelBottomColumn("支付方式","payment_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款信息","agent_bank_name",ExcelDataTypes::String,25)); 
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款金额","post_money_amount",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收款金额","in_account_money",ExcelDataTypes::Double));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("款项状态","post_money_state_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("充值状态","income_state_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("充值金额","income_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("充值人","income_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("充值时间","income_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("充值备注","income_remark",ExcelDataTypes::String,35)); 
            
            $objDataToExcel->Init("已收款管理",$arrayData,null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
       
    /**
     * @functional 显示打款充值页面
    */ 
    public function InMoneyModify()
    {
        $this->ExitWhenNoRight("MoneyInAccountList",Rightvalue::add);   
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("参数有误！");
            
        $objAgentModelDetailBLL = new AgentModelDetailBLL();
                
        $postMoneyNo = Utility::GetForm('postMoneyNo',$_GET);
        $aPreReRate = null;
        $objReceivablePayBLL = new ReceivablePayBLL();
        $arrayData = $objReceivablePayBLL->select("fr_object_id,c_contract_no,c_product_name,fr_type,fr_type as fr_type_text,fr_rev_money,fr_rev_money as in_account_money","fr_no='{$postMoneyNo}'");
        if(isset($arrayData) && count($arrayData) > 0)
        {
            foreach($arrayData as $key => $value)
            {
                if($arrayData[$key]["fr_type"] == BillTypes::UnitPreDeposits)
                {
                    $arrayData[$key]["reward_money"] = $objAgentModelDetailBLL->GetUnitSaleRewardMoney($value["fr_object_id"],$value["fr_rev_money"]);
                    $arrayData[$key]["in_account_money"] = round($arrayData[$key]["reward_money"]+$value["fr_rev_money"],2);
                } 
            }
              
            BillTypes::ReplaceArrayText($arrayData,"fr_type_text");
        }
        
        $strAgentName = Utility::GetForm('agentName',$_GET);        
        $this->smarty->assign('strAgentName',$strAgentName);
        
        $this->smarty->assign('arrayData',$arrayData);        
        $this->smarty->display('FM/Backend/InMoneyModify.tpl');
    }               
       
       
    /**
     * @functional 打款充值数据提交
    */ 
    public function InMoneyModifySubmit()
    {
        $this->ExitWhenNoRight("MoneyInAccountList",Rightvalue::add);   
        $id = Utility::GetFormInt('id',$_POST);
        if($id <= 0)
            exit("参数有误！");
            
        $objPostMoneyBLL = new PostMoneyBLL();
        $arrayData = $objPostMoneyBLL->select("post_money_no","post_money_id=".$id);
        if(!(isset($arrayData) && count($arrayData) > 0))
            exit("未找到打款数据！");
            
        $strRemark = Utility::GetRemarkForm("tbxRemark",$_POST,250);
                
        $iCount = 0;
        $aPreReRate = null;
        $objReceivablePayBLL = new ReceivablePayBLL();
        $arrayData = $objReceivablePayBLL->select("fr_id,fr_no,fr_object_id,c_product_id,c_product_name,fr_type,
        fr_rev_money,0 as reward_money","fr_no='".$arrayData[0]["post_money_no"]."'"); 
        
        $inMoneyAmount = 0;     
        $objAgentModelDetailBLL = new AgentModelDetailBLL();
        if(isset($arrayData) && count($arrayData) > 0)
        {
            foreach($arrayData as $key => $value)
            {                
                if($arrayData[$key]["fr_type"] == BillTypes::UnitPreDeposits)
                {
                    $arrayData[$key]["reward_money"] = $objAgentModelDetailBLL->GetUnitSaleRewardMoney($value["fr_object_id"],$value["fr_rev_money"]);
                } 
                
                $inMoneyAmount += $arrayData[$key]["fr_rev_money"]+$arrayData[$key]["reward_money"];
            }
                
            $success = $objPostMoneyBLL->PostMoneyInAccount($id,$this->getUserId(),$this->getUserCNName(),$inMoneyAmount,$strRemark);
            
            if(!$success)
                exit("充值失败！");
                    
            foreach($arrayData as $key => $value)
            {                
                $iCount += $objReceivablePayBLL->PostMoneyInAccount($value["fr_id"],$this->getUserId(),$this->getUserCNName(),$arrayData[$key]["fr_rev_money"],$strRemark,$arrayData[$key]["reward_money"]);
              
                if($arrayData[$key]["reward_money"] > 0)
                {                            
                    $objInMoneyAct = new InMoneyAct();
                    $objInMoneyAct->Init($value["fr_object_id"],"10",$value["c_product_id"],AgentAccountTypes::UnitSaleReward,
                    BillTypes::UnitSaleReward,Utility::Now(),$arrayData[$key]["reward_money"],$value["fr_id"],$value["fr_no"]);
                    $iCount += $objInMoneyAct->Insert($this->getUserId(),$strRemark);
                }
            }            
        }
        
        if($iCount == 0)
            exit("充值失败！");
        
        exit("0");
    }
    
         
    /**
     * @functional 删除充值数据
    */ 
    public function DelInMoneySubmit()
    {
        $this->ExitWhenNoRight("MoneyInAccountList",Rightvalue::del);   
        $id = Utility::GetFormInt('id',$_POST);
        if($id <= 0)
            exit("参数有误！");
        
        $objPostMoneyBLL = new PostMoneyBLL();
        $bInAccountSeccess = $objPostMoneyBLL->RedPostMoneyInAccount($id,$this->getUserId(),$this->getUserCNName());
        
        if($bInAccountSeccess == true)
            exit("0");
        else
            exit("取消失败！");
    }
    
    
    /**
     * @functional 应收款明细
    */ 
    public function ReceivablesDetails()
    {      
        $this->PageRightValidate("ReceivablesDetails",Rightvalue::view);
        
        $objProductTypeBLL = new ProductTypeBLL();
        $productTypes = $objProductTypeBLL->GetProductTypeJson(true);          
        $this->smarty->assign('productTypes',$productTypes);
                
        $agentNo = Utility::GetForm("agentNo",$_GET);
        $this->smarty->assign('agentNo',$agentNo);
        
        $accountType = Utility::GetFormInt("accountType",$_GET);
        $this->smarty->assign('qAccountType',$accountType);
        
        $this->smarty->assign('ReceivablesDetailsListBody',"/?d=FM&c=InMoney&a=ReceivablesDetailsBody");
        $this->smarty->display('FM/Backend/ReceivablesDetailsList.tpl'); 
    }
    
    
    /**
     * @functional 应收款明细 数据
    */ 
    public function ReceivablesDetailsBody()
    {
        $this->ExitWhenNoRight("ReceivablesDetails",Rightvalue::view);
        $sWhere = "";
                
        $iMoneyState = Utility::GetFormInt("cbMoneyState",$_GET);        
        if($iMoneyState != -100)
            $sWhere .= " and `fm_post_money`.`post_money_state` =".$iMoneyState;
            /*
        $iLevel = Utility::GetFormInt("cbLevel",$_GET);        
        if($iLevel > 0)
            $sWhere .= " and `am_agent_pact`.`agent_level` =".$iLevel;
        */
        //打款时间            
        $postSDate = Utility::GetForm("tbxPostSDate",$_GET);
        $postEDate = Utility::GetForm("tbxPostEDate",$_GET);
        if($postSDate != "")
            $sWhere .= " and `fm_post_money`.`post_date` >= '".$postSDate."'";             
            
        if($postEDate != "")
            $sWhere .= " and `fm_post_money`.`post_date` < ".Utility::SQLEndDate($postEDate);    
        
        //提交时间            
        $submitSDate = Utility::GetForm("tbxSubmitSDate",$_GET);
        $submitEDate = Utility::GetForm("tbxSubmitEDate",$_GET);
        if($submitSDate != "")
            $sWhere .= " and `fm_post_money`.`create_time` >= '".$submitSDate."'";             
            
        if($submitEDate != "")
            $sWhere .= " and `fm_post_money`.`create_time` < ".Utility::SQLEndDate($submitEDate);    
                                                    
        $tbxReceivedSDate = Utility::GetForm("tbxReceivedSDate",$_GET);
        $tbxReceivedEDate = Utility::GetForm("tbxReceivedEDate",$_GET);

        if($tbxReceivedSDate != "")
            $sWhere .= " and fm_receivable_pay_state.received_uid>0 and `fm_receivable_pay_state`.`received_time` >= '".$tbxReceivedSDate."'";             
            
        if($tbxReceivedEDate != "")
            $sWhere .= " and fm_receivable_pay_state.received_uid>0 and `fm_receivable_pay_state`.`received_time` < ".Utility::SQLEndDate($tbxReceivedEDate);    
            
        $tbxERPBankRecordID = Utility::GetFormInt('tbxERPBankRecordID',$_GET); 
        if($tbxERPBankRecordID > 0)
            $sWhere .= " and fm_receivable_pay_state.check_in_account_uid>0 and fm_receivable_pay_state.erp_banck_record_id=".$tbxERPBankRecordID;
        
        $cbIsCheckInAccount = Utility::GetFormInt('cbIsCheckInAccount',$_GET,0); 
        if($cbIsCheckInAccount == 1)
            $sWhere .= " and fm_receivable_pay_state.check_in_account_uid<=0 ";
        else if($cbIsCheckInAccount == 2)
            $sWhere .= " and fm_receivable_pay_state.check_in_account_uid>0 ";
                          
        $strPostUser = Utility::GetForm("tbxPostUser",$_GET);        
        if($strPostUser != "")
            $sWhere .= " and `fm_post_money`.`create_user_name` like '%$strPostUser%' ";            
            
        $strContractNo = Utility::GetForm("tbxPactNo",$_GET);        
        if($strContractNo != "")
            $sWhere .= " and `fm_post_money`.`agent_pact_nos` like '%$strContractNo%' ";
        
        $strPostMoneyNo = Utility::GetForm("tbxPostMoneyNo",$_GET);        
        if($strPostMoneyNo != "")
            $sWhere .= " and `fm_post_money`.`post_money_no` like '%$strPostMoneyNo%' ";
            
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);        
        if($strAgentNo != "")
            $sWhere .= " and `fm_post_money`.`agent_no` like '%$strAgentNo%' ";
            
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);        
        if($strAgentName != "")
            $sWhere .= " and `fm_post_money`.`agent_name` like '%$strAgentName%' ";
            
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $bExportExcel = false;        
        if(Utility::GetFormInt('exportExcel',$_GET) > 0)
            $bExportExcel = true; 
                
        if($bExportExcel)   
            $iPageSize = DataToExcel::max_record_count;
             //exit($sWhere);
        $objReceivablesDetailsBLL = new ReceivablesDetailsBLL();
        $arrPageList = $this->getPageList($objReceivablesDetailsBLL,"*",$sWhere,"",$iPageSize,$bExportExcel);
        $arrayData = &$arrPageList['list'];     
     
        foreach($arrayData as $key => $value)
        {
            if($value["payment_id"] != 1)
            {
                if($value["rp_num"] != "")
                    $arrayData[$key]["agent_bank_name"] = $value["rp_num"]." ".$value["agent_bank_name"];
            }
            else
            {
                $arrayData[$key]["agent_bank_name"] = "";
            }
            
            if($value["check_in_account_uid"] <= 0)
            {
                $arrayData[$key]["check_in_account_time"] = "";
            }
        }
        
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrayData',$arrayData);
            $this->smarty->display('FM/Backend/ReceivablesDetailsListBody.tpl'); 
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        }
        else
        {            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("交易号","post_money_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,25));    
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款产品","product_type_names",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","agent_pact_nos",ExcelDataTypes::String,25));        
            $objExcelBottomColumns->Add(new ExcelBottomColumn("支付方式","payment_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款信息","agent_bank_name",ExcelDataTypes::String,35));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款金额","post_money_amount",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收款金额","in_account_money",ExcelDataTypes::Double));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("状态","post_money_state_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款时间","post_date",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("战区","account_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人","create_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间","create_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("到帐银行","bank_name",ExcelDataTypes::String,35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("到帐日期","check_in_account_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("认领编号","erp_banck_record_id"));
            $objDataToExcel->Init("打款收款",$arrayData,null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
       
    public function AgentPostMoneyDetailList()
    {
        $this->ExitWhenNoRight("ReceivablesDetails",Rightvalue::view);
        $this->smarty->assign('strTitle',"代理商打款明细");
        
        $objProductTypeBLL = new ProductTypeBLL();
        $productTypes = $objProductTypeBLL->GetProductTypeJson(true);          
        $this->smarty->assign('productTypes',$productTypes);
                
        $agentNo = Utility::GetForm("agentNo",$_GET);
        $this->smarty->assign('agentNo',$agentNo);
        
        $accountType = Utility::GetFormInt("accountType",$_GET);
        $this->smarty->assign('qAccountType',$accountType);
        
        $productTypeID = Utility::GetFormInt("productTypeID",$_GET);
        $this->smarty->assign('qProductTypeID',$productTypeID);
        
        $productTypeName = Utility::GetForm("productTypeName",$_GET);
        $this->smarty->assign('qProductTypeName',$productTypeName);
        
        $this->smarty->assign('AgentPostMoneyDetailListBody',"/?d=FM&c=InMoney&a=AgentPostMoneyDetailListBody");
        $this->smarty->display('FM/Backend/AgentPostMoneyDetailList.tpl'); 
    }
       
    public function AgentPostMoneyDetailListBody()
    {        
        $sWhere = "";
        
        $iAccountType = Utility::GetFormInt("cbAccountType",$_GET);        
        if($iAccountType != -100)
            $sWhere .= " and `fm_receivable_pay`.`fr_type` =".$iAccountType;
        
        $iMoneyState = Utility::GetFormInt("cbMoneyState",$_GET);        
        if($iMoneyState != -100)
            $sWhere .= " and `fm_receivable_pay`.`fr_state` =".$iMoneyState;
            /*
        $iLevel = Utility::GetFormInt("cbLevel",$_GET);        
        if($iLevel > 0)
            $sWhere .= " and `am_agent_pact`.`agent_level` =".$iLevel;
        */
        //打款时间            
        $postSDate = Utility::GetForm("tbxPostSDate",$_GET);
        $postEDate = Utility::GetForm("tbxPostEDate",$_GET);
        if($postSDate != "")
            $sWhere .= " and `fm_receivable_pay`.`fr_peer_date` >= '".$postSDate."'";             
            
        if($postEDate != "")
            $sWhere .= " and `fm_receivable_pay`.`fr_peer_date` < date_add('".$postEDate."',interval 1 day)";    
        
        //提交时间            
        $submitSDate = Utility::GetForm("tbxSubmitSDate",$_GET);
        $submitEDate = Utility::GetForm("tbxSubmitEDate",$_GET);
        if($submitSDate != "")
            $sWhere .= " and `fm_receivable_pay`.`create_time` >= '".$submitSDate."'";             
            
        if($submitEDate != "")
            $sWhere .= " and `fm_receivable_pay`.`create_time` < date_add('".$submitEDate."',interval 1 day)";   
                          
        $strPostUser = Utility::GetForm("tbxPostUser",$_GET);        
        if($strPostUser != "")
            $sWhere .= " and `fm_receivable_pay`.`create_user_name` like '%$strPostUser%' ";            
            
        $strContractNo = Utility::GetForm("tbxPactNo",$_GET);        
        if($strContractNo != "")
            $sWhere .= " and `fm_receivable_pay`.`c_contract_no` like '%$strContractNo%' ";
        
        $strPostMoneyNo = Utility::GetForm("tbxPostMoneyNo",$_GET);        
        if($strPostMoneyNo != "")
            $sWhere .= " and `fm_receivable_pay`.`fr_no` like '%$strPostMoneyNo%' ";
            
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);        
        if($strAgentNo != "")
            $sWhere .= " and `am_agent_source`.`agent_no` like '%$strAgentNo%' ";
            
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);        
        if($strAgentName != "")
            $sWhere .= " and `fm_receivable_pay`.`fr_object_name` like '%$strAgentName%' ";
            
        //产品
        $strProductTypes = Utility::GetForm("productTypes",$_GET); 
        if($strProductTypes != "")
            $sWhere .= Utility::SQLMultiSelect("`fm_receivable_pay`.`c_product_id`",$strProductTypes);
                    
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $bExportExcel = false;        
        if(Utility::GetFormInt('iExportExcel',$_GET) > 0)
            $bExportExcel = true; 
                             
        $objReceivablesDetailsBLL = new AgentPostMoneyDetailBLL();
        $arrPageList = $this->getPageList($objReceivablesDetailsBLL,"*",$sWhere,"",$iPageSize,$bExportExcel);
        $arrayData = &$arrPageList['list'];     
         
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrayData',$arrayData);
            $this->smarty->display('FM/Backend/AgentPostMoneyDetailListBody.tpl'); 
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        }
        else
        {
            foreach($arrayData as $key => $value)
            {
                if($value["fr_payment_id"] != 1)
                {
                    if($value["fr_rp_num"] != "")
                        $value["fr_peer_bank_name"] = $value["fr_rp_num"]." ".$value["fr_peer_bank_name"];
                }
                else
                {
                    $value["fr_peer_bank_name"] = "";
                }
            }
            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("款项类型","fr_type_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("交易号","fr_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","c_contract_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,25));
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理产品","c_product_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("支付方式","fr_payment_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款信息","fr_peer_bank_name",ExcelDataTypes::String,25));
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款金额","fr_rev_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收款金额","fr_money",ExcelDataTypes::Double));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("款项状态","fr_state"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款时间","fr_peer_date",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("战区","account_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人","post_user_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交时间","post_time",ExcelDataTypes::DateTime));
            $objDataToExcel->Init("代理商打款明细",$arrayData,null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
    
    /**
     * @functional 收款详情
    */
    public function MoneyInAccountDetail()
    {
        $this->smarty->assign('type',1);
        $this->f_MoneyInAccountDetail();
    }
    
    protected function f_MoneyInAccountDetail()
    {        
        $this->ExitWhenNoRight("ReceivablesDetails",Rightvalue::view);
        $id = Utility::GetFormInt("id",$_GET);
        if($id <= 0)
            exit("参数有误！");
            
        $objReceivablePayStateBLL = new ReceivablePayStateBLL();
        $objReceivablePayStateInfo = $objReceivablePayStateBLL->getModelByFrID($id);
        
        $this->smarty->assign('objReceivablePayStateInfo',$objReceivablePayStateInfo);
        $this->smarty->display('FM/Backend/MoneyInAccountDetail.tpl'); 
    }
    
    /**
     * @functional 认领详情
    */
    public function CheckMoneyInAccountDetail()
    {
        $this->smarty->assign('type',2);
        $this->f_MoneyInAccountDetail();        
    }
}
?>