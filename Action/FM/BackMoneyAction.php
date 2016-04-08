<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：打款模块
 * 创建人：wzx
 * 添加时间：2011-10-19 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentBankBLL.php';
require_once __DIR__.'/../../Class/BLL/BankAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/ReceivablePayBLL.php';
require_once __DIR__.'/../../Class/BLL/InvoiceIsseuBLL.php';
require_once __DIR__.'/../../Class/BLL/DepartmentBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPostMoneyNoticeBLL.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';


class BackMoneyAction extends ActionBase
{    
    /**
     * @functional 显示退款页面
    */
    public function BackMoneyModify()
    {        
        $this->smarty->assign('strTitle','退款');
        $id = Utility::GetFormInt('id',$_GET);
        $objReceivablePayInfo = new ReceivablePayInfo();
        /*----------------------公司银行账户--------------------s------------*/
        $objBankAccountBLL = new BankAccountBLL();
        $arrayAccount = $objBankAccountBLL->SelectAcceptAccount();
        $this->smarty->assign('arrayAccount',$arrayAccount);        
        /*----------------------公司银行账户数据--------------------e------------*/
        //打款时间        
        $objReceivablePayInfo->strFrPeerDate = Utility::Now();
        
        if($id > 0)
        {
            $objReceivablePayBLL = new ReceivablePayBLL();
            $objReceivablePayInfo = $objReceivablePayBLL->getModelByID($id);
            if($objReceivablePayInfo->iFrPaymentId != PayTypes::QuickMoney )//不为快钱
            {
                $objReceivablePayInfo->strFrRpNum = "";
                $objReceivablePayInfo->strFrPeerBankName = "";   
            }
        }
        else
        {
            $objReceivablePayInfo->strFrPeerBankName = "浙江盘石信息技术有限公司";
        }
        
        $this->smarty->assign('id',$id);        
        $this->smarty->assign('objReceivablePayInfo',$objReceivablePayInfo);
        
        $this->displayPage('FM/Backend/BackMoneyModify.tpl');           
    }
    
    
    /**
     * @functional 返回代理商银行账户
    */
    public function GetAgentBackAccount()
    {
        $agentID = Utility::GetFormInt('agentID',$_POST);
        $objAgentBankBLL = new AgentBankBLL();
        $arrayData = $objAgentBankBLL->select("agent_bank_id,`bank_name`,`account_name`,`account_no`",
        "agent_id=".$agentID,"`bank_name`,`account_name`,`account_no`");
       
        $strJson = "[";
        if (isset($arrayData) && count($arrayData) > 0)
	    {
	       $arrayLength = count($arrayData);
           for($i= 0 ;$i<$arrayLength;$i++)
           {
               $strJson .= "{'id':'".$arrayData[$i]["agent_bank_id"]."','name':'".$arrayData[$i]["bank_name"]." ".$arrayData[$i]["account_name"]." ".$arrayData[$i]["account_no"]."'}";
               if($i != $arrayLength-1) 
                    $strJson .= ",";
           }
        }
        $strJson .= "]";
        exit($strJson);
    }
    
    
    /**
     * @functional 
    */
    public function BackMoneyModifySubmit()
    {        
        $id = Utility::GetFormInt('id',$_GET);
        
        $billType = Utility::GetFormInt('cbBackAccount',$_POST);
        if($billType <= 0)
            exit("请选择退款类型！");
            
        $agentID = Utility::GetFormInt('tbxAgentID',$_POST);
        if($agentID <= 0)
            exit("请选择代商！");
            
        $productTypeID = Utility::GetFormInt('cbProductType',$_POST);
        if($productTypeID <= 0)
            exit("请选择代理产品！");
        
        $postDate = Utility::GetForm('tbxPostDate',$_POST,15);
        if($postDate == "")
           exit("请选择退款日期！"); 
               
        if(Utility::isShortTime($postDate) == 0)
           exit("退款日期格式不正确！");     
            
        $payType = Utility::GetFormInt('cbPayTypes',$_POST);
        $payTypeName = Utility::GetForm('payTypeName',$_POST,10);
        
        if($payType <= 0)
            exit("请选择支付方式！");
            
        $postAccountID = Utility::GetFormInt('cbPostAccount',$_POST);
        $postAccountName = Utility::GetForm('postAccountName',$_POST,128);
        
        $iAcceptAccount = Utility::GetFormInt('cbAcceptAccountName',$_POST);
        $strAcceptAccountName = Utility::GetForm('acceptAccountName',$_POST,128);
        
        //快钱
        $strTransactionNo = Utility::GetForm('tbxTransactionNo',$_POST,50);
        $strPostAccountName = Utility::GetForm('tbxPostAccountName',$_POST,50);   
             
        if($payType != PayTypes::Cash)
        {
            if($payType == PayTypes::QuickMoney)
            {
                if($strTransactionNo == "")
                    exit("请输入快钱交易号！");
                    
                if($strPostAccountName == "")
                    exit("请输入打款账户名称！");
            }
            else
            {
                if($postAccountID <= 0)
                   exit("请选择打款账号！");
    
                if($iAcceptAccount <= 0)
                    exit("请选择收款账户！");
            }            
        }
        
        $postPrice = Utility::GetFormDouble('tbxPrice',$_POST); 
        if($postPrice <= 0)
           exit("请输入有效退款金额！");   
        
        $objAgentAccountBLL = new AgentAccountBLL();
        $canUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($agentID,"10",$billType,$productTypeID);
        $postPrice = round($postPrice,2);
        $canUseMoney = round($canUseMoney,2);
        if($postPrice > $canUseMoney)
            exit("退款金额超过账户可退金额！");
                                       
        /*----------------------合同数据--------------------s------------*/
        $objAgentPactBLL = new AgentPactBLL();
        $arrayAgentPact = $objAgentPactBLL->GetAgentPact($agentID,$productTypeID);
        if(!(isset($arrayAgentPact) && count($arrayAgentPact)>0))
        {
            exit("未找到代理商该产品相应签约合同数据！");
        }
        /*----------------------合同数据--------------------e------------*/
        $remark = Utility::GetRemarkForm('tbxRemark',$_POST,256);
        
        $objReceivablePayBLL = new ReceivablePayBLL();
        $objReceivablePayInfo = new ReceivablePayInfo();
        
        if($id > 0)
        {
            $objReceivablePayInfo = $objReceivablePayBLL->getModelByID($id);
            $objReceivablePayInfo->iUpdateUid = $this->getUserId();
    		$objReceivablePayInfo->strUpdateUserName = $this->getUserName()." ".$this->getUserCNName();
        }
        else
        {            
			$objReceivablePayInfo->strFrNo = $objReceivablePayBLL->GetNewNo($billType,$arrayAgentPact[0]['product_type_no']);
			$objReceivablePayInfo->iFrType = $billType;
            $objReceivablePayInfo->iCreateUid = $this->getUserId();
            $objReceivablePayInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName();
            $objReceivablePayInfo->iUpdateUid = 0;
    		$objReceivablePayInfo->iIsDel = 0;
        }
        
        $objReceivablePayInfo->iFrPeerBankId = 0;
        $objReceivablePayInfo->strFrPeerBankName = "";        
        $objReceivablePayInfo->iFrBankId = 0;
        $objReceivablePayInfo->strFrBankName = ""; 
            
		$objReceivablePayInfo->icContractId = $arrayAgentPact[0]['agent_pact_id'];        
		$objReceivablePayInfo->strcContractNo = $arrayAgentPact[0]["pact_number"]."".$arrayAgentPact[0]["pact_stage"];        
		$objReceivablePayInfo->icContractType = $arrayAgentPact[0]['pact_type'];
		$objReceivablePayInfo->icContractArea = 0;        
		$objReceivablePayInfo->icProductId = $productTypeID;
        
		$objReceivablePayInfo->strcProductName = $arrayAgentPact[0]['product_type_name'];
		$objReceivablePayInfo->iFrObjectId = $agentID;
		$objReceivablePayInfo->strFrObjectName = $arrayAgentPact[0]['company_name'];
        
		$objReceivablePayInfo->iFrPaymentId = $payType;//$payType;
		$objReceivablePayInfo->strFrPaymentName = $payTypeName;     
		$objReceivablePayInfo->iFrRevMoney = 0;
		$objReceivablePayInfo->iFrPayMoney = $postPrice;
		$objReceivablePayInfo->iFrMoney = 0;
		$objReceivablePayInfo->iFrRpUserid = $this->getUserId();
		$objReceivablePayInfo->strFrRpUsername = $this->getUserName()." ".$this->getUserCNName();
                             
        if($payType == PayTypes::Cash)
        {
            $objReceivablePayInfo->iFrPeerBankId = 0;
            $objReceivablePayInfo->strFrPeerBankName = "";            
    		$objReceivablePayInfo->iFrBankId = 0;
    		$objReceivablePayInfo->strFrBankName = "";            
        }
        else if($payType == PayTypes::QuickMoney)
        {
            $objReceivablePayInfo->strFrRpNum = $strTransactionNo;
            $objReceivablePayInfo->strFrPeerBankName = $strPostAccountName;            
        }
        else
        {
            $objReceivablePayInfo->iFrPeerBankId = $iAcceptAccount;
            $objReceivablePayInfo->strFrPeerBankName = $strAcceptAccountName;            
    		$objReceivablePayInfo->iFrBankId = $postAccountID;
    		$objReceivablePayInfo->strFrBankName = $postAccountName;               
        }
        
		$objReceivablePayInfo->strFrPeerDate = $postDate;        
		$objReceivablePayInfo->strFrRpFiles = "";
        
		$objReceivablePayInfo->ifInvoiceMoney = 0;
		$objReceivablePayInfo->strfInvoiceDate = "2000-01-01";
		$objReceivablePayInfo->ifInvoiceArea = 0;
		$objReceivablePayInfo->ifInvoiceSourceid = 0;
		$objReceivablePayInfo->iFrState = ReceivablePayStates::NotEffect;//收支状态 -1:退回 0:未生效 1:待收 2:已收 3:红冲
		$objDepartmentBLL = new DepartmentBLL();        
        $objReceivablePayInfo->iFrCorpId = $objDepartmentBLL->GetPanShiCompanyID();//?产商ID
		$objReceivablePayInfo->iFrSourceId = 0;//
        if($billType == BillTypes::GuaranteeMoney)            
            $objReceivablePayInfo->iFrTypeid = 13;//收支来源类型 和ERP里的对应 11代理商的保证金 12代理商的预存款 13保证金退款 14预存款退款
        else
            $objReceivablePayInfo->iFrTypeid = 14;
             
		$objReceivablePayInfo->iFrRpArea = 0;
		$objReceivablePayInfo->iFrFromPlatform = 0;              
        $objReceivablePayInfo->strFrRemark = $remark;
        
        if($id > 0)
        {
            if($objReceivablePayBLL->updateByID($objReceivablePayInfo) <= 0)
                exit("修改失败！");
        }
        else
        {
            $id = $objReceivablePayBLL->insert($objReceivablePayInfo);
            if($id <= 0)
                exit("添加失败！");                
        } 
        
        exit("0");
    }
        
    public function DelBackMoneyModify()
    {
        $returnData = array("success"=>false,"msg"=>"");
        
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
        {
            $returnData["msg"] = "参数有误！";
            exit(json_encode($returnData));
        }
        $objReceivablePayBLL = new ReceivablePayBLL();
        //能否删除的判断
        
        //删除数据
        if($objReceivablePayBLL->deleteByID($id,0,$this->getUserId()) > 0)
        {
            $returnData["success"] = true;
            exit(json_encode($returnData));
        }
        else
        {
            $returnData["msg"] = "删除失败";
            exit(json_encode($returnData));
        }
    }
    
    
    /**
     * @functional 显示提交打款详细页面
    */
    public function BackMoneyModifyDetail()
    {
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("参数有误！");            
        
        $objReceivablePayBLL = new ReceivablePayBLL();        
        $objReceivablePayInfo = $objReceivablePayBLL->getModelByID($id);
        if($objReceivablePayInfo == null)
            exit("查询数据出错！");
            
        $objReceivablePayInfo->iFrRevMoney = Utility::FormatMoney($objReceivablePayInfo->iFrRevMoney);
        
        $strSupTitle = "";
        $strTitle = "";
        if($objReceivablePayInfo->iFrType == AgentAccountTypes::GuaranteeMoney)
        {            
            $strSupTitle = "保证金提交明细";   
            $strTitle = "保证金提交信息";
        }
        else
        {
            $strSupTitle = "预存款打款明细";   
            $strTitle = "预存款打款信息";
        }   
        
        $this->smarty->assign('strSupTitle',$strSupTitle);   
        $this->smarty->assign('strTitle',$strTitle);
        /*----------------------合同数据--------------------s------------*/
        $objAgentPactBLL = new AgentPactBLL();
        $arrayData = $objAgentPactBLL->GetAgentPact($objReceivablePayInfo->iFrObjectId,$objReceivablePayInfo->icProductId);
        if(isset($arrayData) && count($arrayData)>0)
        {            
            $this->smarty->assign('pactSDate',$arrayData[0]["pact_sdate"]);
            $this->smarty->assign('pactEDate',$arrayData[0]["pact_edate"]);
        }
        else
        {
            exit("未找到相应合同数据！");
        }
        /*----------------------合同数据--------------------e------------*/        
        $this->smarty->assign('acceptBankAccountName',$objReceivablePayInfo->strFrBankName);
        $this->smarty->assign('postBankAccountName',$objReceivablePayInfo->strFrPeerBankName);
        
        $this->smarty->assign('objReceivablePayInfo',$objReceivablePayInfo);
        $this->displayPage('FM/Front/PayMoneyDetail.tpl');   
    }
    
    /**
     * 代理商打款提醒 列表
    */
    public function AgentPostMoneyNotice()
    {
        $this->PageRightValidate("AgentPostMoneyNotice",Rightvalue::view);
        //$this->smarty->assign('strTitle','代理商打款提醒');
        
        $objComSettingBLL = new ComSettingBLL();
        $arrayAccountBalanceWarning = $objComSettingBLL->GetAgentAccountBalanceWarning();
                        
        $this->smarty->assign('arrayAccountBalanceWarning',$arrayAccountBalanceWarning);
        
        $this->smarty->assign('AgentPostMoneyNoticeListBody',"/?d=FM&c=BackMoney&a=AgentPostMoneyNoticeBody");
        $this->displayPage('FM/Backend/AgentPostMoneyNotice.tpl');           
    }
    
        
    /**
     * 代理商打款提醒 列表数据
    */
    public function AgentPostMoneyNoticeBody()
    {
        $this->ExitWhenNoRight("AgentPostMoneyNotice",Rightvalue::view);
              
        $sWhere = "";
        $iAccountType = Utility::GetFormDouble('cbAccountType',$_GET);
        
        //print_r($iAccountType."--");
        if($iAccountType > 0)
            $sWhere = " and account_type =".$iAccountType;
            
        $iSCanUserMoney = Utility::GetFormDouble('tbxSBalanceMoney',$_GET,-1);
        $iECanUserMoney = Utility::GetFormDouble('tbxEBalanceMoney',$_GET,-1);
        
        if($iSCanUserMoney >= 0)
            $sWhere .= " and can_use_money >= ".$iSCanUserMoney;  
            
        if($iECanUserMoney >= 0)
            $sWhere .= " and can_use_money <= ".$iECanUserMoney; 
             
        $iProductType = Utility::GetFormInt('cbProductType',$_GET);        
        if($iProductType > 0)
            $sWhere .= " and product_type_id = ".$iProductType;     
            
        $strAgentNo = Utility::GetForm("tbxAgentNo",$_GET);
        if($strAgentNo != "")
            $sWhere .= " and agent_no like '%".$strAgentNo."%'";     
                          
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($strAgentName != "")
            $sWhere .= " and agent_name like '%".$strAgentName."%'"; 
           
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $sOrder = Utility::GetForm("sortField", $_GET);
        if($sOrder == "")
            $sOrder = "`agent_no`,account_type,product_type_name";
        //    exit($sWhere);
            
        $objAgentPostMoneyNoticeBLL = new AgentPostMoneyNoticeBLL();
        $arrPageList = $this->getPageList($objAgentPostMoneyNoticeBLL,"",$sWhere,$sOrder,$iPageSize);
        Utility::FormatArrayMoney($arrPageList['list'],"balance_money,can_use_money");
        $this->smarty->assign('arrayAccountList',$arrPageList['list']);
        $this->smarty->display('FM/Backend/AgentPostMoneyNoticeBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        
    }
}
?>