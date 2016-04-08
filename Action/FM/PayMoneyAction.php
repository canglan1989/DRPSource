<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：打款模块
 * 创建人：wzx
 * 添加时间：2011-09-01 
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
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentBLL.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/PostMoneyBLL.php';
require_once __DIR__.'/../../Class/BLL/PactMoneyInAccountBLL.php';
require_once __DIR__ . '/../Common/ExportExcel.php';

require_once __DIR__ . '/../Common/UploadFile.php';
require_once __DIR__ . '/../Common/ShowImage.php';
require_once __DIR__.'/../../WebService/ERP_FinanceService.php';

class PayMoneyAction extends ActionBase
{    
    /**
     * @functional 显示提交打款页面
    */
    public function PayMoneyModify()
    {        
        $bPostMoneyAtBackend = !$this->isAgentUser();
        $strTitle = "提交打款";
        $id = Utility::GetFormInt('id',$_GET);        
        if($id > 0)
            $strTitle = "提交打款修改";
        
        if(!$bPostMoneyAtBackend)
            $this->PageRightValidate("PostMoneyModify",RightValue::add);
        else
        {            
            $this->PageRightValidate("mySigned",RightValue::v32);//后台提交打款
            $this->smarty->assign('strPath',"代理商管理<span>&gt;</span>签约管理<span>&gt;</span>{$strTitle}");
        }
        
        $iAgentID = Utility::GetFormInt('agentID',$_GET);
        if($iAgentID <= 0)
            $iAgentID = $this->getAgentId();
            
        if($iAgentID <= 0)
            exit("参数有误！");
                        
        $this->smarty->assign('strTitle',$strTitle);
        $objPostMoneyInfo = new PostMoneyInfo();
        //打款时间        
        $objPostMoneyInfo->strPostDate = Utility::Now();
        $objPostMoneyInfo->iPostMoneyAmount = "0.00";
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayProduct = $objProductTypeBLL->GetAgentSignedProductType($iAgentID);
                
        if($id > 0)
        {
            $objPostMoneyBLL = new PostMoneyBLL();
            $objPostMoneyInfo = $objPostMoneyBLL->getModelByID($id,$iAgentID);
            if($objPostMoneyInfo == null)
                exit("未找到数据！");
                
            if($objPostMoneyInfo->iPostMoneyState > ReceivablePayStates::NotEffect)//收支状态 -1:退回 0:未生效 1:待收 2:已收 3:红冲
                exit("该打款单据状态为：".ReceivablePayStates::GetText($objPostMoneyInfo->iPostMoneyState)."，不能再被编辑！");
            
            if($objPostMoneyInfo->iPaymentId != PayTypes::QuickMoney )//不为快钱
            {
                $objPostMoneyInfo->strRpNum = "";
                $objPostMoneyInfo->strAgentBankName = "";   
            }
            
            $objReceivablePayBLL = new ReceivablePayBLL();
            $arrayData = $objReceivablePayBLL->select("*","fr_no='".$objPostMoneyInfo->strPostMoneyNo."'");//打款明细
            foreach($arrayProduct as $key=>$value)
            {
                $arrayProduct[$key]["gua_money"] = 0;
                $arrayProduct[$key]["pre_money"] = 0;
                
                foreach($arrayData as $k=>$v)
                {
                    if($v["c_product_id"] == $value["product_type_id"])
                    {                        
                        if($v["fr_type"] == AgentAccountTypes::GuaranteeMoney)
                            $arrayProduct[$key]["gua_money"] = $v["fr_rev_money"];
                        else
                            $arrayProduct[$key]["pre_money"] = $v["fr_rev_money"];
                    }
                }
            }
            
        }
        else
        {
            foreach($arrayProduct as $key=>$value)
            {
                $arrayProduct[$key]["gua_money"] = 0;
                $arrayProduct[$key]["pre_money"] = 0;
            }
            
            $objPostMoneyInfo->iAgentId = $iAgentID;
            
            if(!$bPostMoneyAtBackend)
                $objPostMoneyInfo->strAgentBankName = $this->getAgentName();
            else
            {
                $objAgentBLL = new AgentBLL();
                $arrayData = $objAgentBLL->select("agent_no,agent_name","agent_id='".$iAgentID."'","");
                if(isset($arrayData) && count($arrayData) > 0)
                {
                    $objPostMoneyInfo->strAgentNo = $arrayData[0]["agent_no"];
                    $objPostMoneyInfo->strAgentName = $arrayData[0]["agent_name"];
                    $objPostMoneyInfo->strAgentBankName = $arrayData[0]["agent_name"];
                }
            }
              
        }
        
        $this->smarty->assign('arrayProduct',$arrayProduct);
        /*----------------------银行账户数据--------------------s------------*/
        $objBankAccountBLL = new BankAccountBLL();
        $arrayAccount = $objBankAccountBLL->SelectAcceptAccount();
        $this->smarty->assign('arrayAccount',$arrayAccount);
        
        $objAgentBankBLL = new AgentBankBLL();
        $arrayAgentAccount = $objAgentBankBLL->select("agent_bank_id,`bank_name`,`account_name`,`account_no`","agent_id=".$iAgentID,"`bank_name`,`account_name`,`account_no`");
        $this->smarty->assign('arrayAgentAccount',$arrayAgentAccount);
        
        if($bPostMoneyAtBackend && isset($arrayAgentAccount) && count($arrayAgentAccount)>0)
        {
            $this->smarty->assign('strBankName',$arrayAgentAccount[0]["bank_name"]); 
            $this->smarty->assign('strAccountName',$arrayAgentAccount[0]["account_name"]);  
            $this->smarty->assign('strAccountNo',$arrayAgentAccount[0]["account_no"]);  
        }
        
        /*----------------------银行账户数据--------------------e------------*/
             //若款项信息为“退回”时的编辑，页面中需包含用厂商退回操作时所填写的备注信息
        $strBackRemark = "";
        if($objPostMoneyInfo->iPostMoneyState == ReceivablePayStates::Back)
        {
            $objReceivablePayStateBLL = new ReceivablePayStateBLL();
            $arrayData = $objReceivablePayStateBLL->select("`back_remark`","`fr_id`=".$id);
            if(isset($arrayData) && count($arrayData) > 0)
                $strBackRemark = $arrayData[0]["back_remark"];
            
            if($strBackRemark != "")
            {
                $strBackRemark ="<div class=\"tf\"><label>退回备注：</label><div class=\"inp\">".$strBackRemark."</div></div> ";
            }
        }
        
        $this->smarty->assign('strBackRemark',$strBackRemark);  
        $this->smarty->assign('id',$id);        
        $this->smarty->assign('objPostMoneyInfo',$objPostMoneyInfo);
        
        if($bPostMoneyAtBackend)
            $this->displayPage('FM/Backend/PayMoneyModify.tpl'); 
        else
            $this->displayPage('FM/Front/PayMoneyModify.tpl'); 
            
    }
    
    /**
     * @functional 上传图片
     * @note ajax上传成功后 返回图片路径
    */
    public function UpReprint()
    {
        $dir = $this->arrSysConfig['UPFILE_PATH']['FM_REPRINT'];
        $filePath = "J_upload0";//Utility::GetForm("J_upload0",$_POST);
        $strFileName = "";
        $msg = UploadFile::UploadJPGImg($filePath, $dir, $strFileName);
        $showImage = "/?a=ShowImage&filePath=FM_REPRINT&fileName=".$strFileName;
        $arrayData = array("success"=>false,"msg"=>"");
        if($msg == "")
        {
            $arrayData = array("success"=>true,"msg"=>$showImage);            
        }
        else
        {
            $arrayData = array("success"=>false,"msg"=>$msg);            
        }
        
        exit(json_encode($arrayData));
    } 
    
    /**
     * @functional 提交打款
    */
    public function PayMoneyModifySubmit()
    {        
        $bPostMoneyAtBackend = !$this->isAgentUser();
        
        if($bPostMoneyAtBackend)
            $this->ExitWhenNoRight("mySigned",RightValue::v32);//后台提交打款
        else   
            $this->ExitWhenNoRight("PostMoneyModify",RightValue::add);
            
        $id = Utility::GetFormInt('id',$_GET);
        
        $iAgentID = Utility::GetFormInt('tbxAgentID',$_POST);
        if($iAgentID <= 0)
            $iAgentID = $this->getAgentId();
            
        if($iAgentID <= 0)
            exit("参数有误！");
                                                
        $postDate = Utility::GetForm('tbxPostDate',$_POST,15);
        if($postDate == "")
           exit("请选择打款日期！"); 
               
        if(Utility::isShortTime($postDate) == 0)
           exit("打款日期格式不正确！");     
            
        $payType = Utility::GetFormInt('cbPayTypes',$_POST);
        $payTypeName = Utility::GetForm('payTypeName',$_POST,10);
        
        if($payType <= 0)
            exit("请选择支付方式！");
            
        $postAccountID = Utility::GetFormInt('cbPostAccount',$_POST);
        $postAccountName = Utility::GetForm('postAccountName',$_POST,128);
        if($bPostMoneyAtBackend)
        {
            $strBankName = Utility::GetForm('bankName',$_POST,128);
            $strAccountName = Utility::GetForm('AccountName',$_POST,128);
            $strAccountNo = Utility::GetForm('AccountNo',$_POST,128);
            
            $objAgentBankBLL = new AgentBankBLL();
            $arrayAgentAccount = $objAgentBankBLL->select("agent_bank_id,`bank_name`,`account_name`,`account_no`",
                "`bank_name`='{$strBankName}' and `account_name`='{$strAccountName}' and `account_no`='{$strAccountNo}'");
            if(isset($arrayData) && count($arrayData) > 0)
            {
                $postAccountID = $arrayAgentAccount[0]["agent_bank_id"];
                $postAccountName = $arrayAgentAccount[0]["bank_name"]." ".$arrayAgentAccount[0]["account_name"]." ".$arrayAgentAccount[0]["account_no"];
            }
            else
            {
                $objAgentBankInfo = new AgentBankInfo();
                $objAgentBankInfo->iAgentId = $iAgentID;
    			$objAgentBankInfo->strBankName = $strBankName;
    			$objAgentBankInfo->strAccountName = $strAccountName;
    			$objAgentBankInfo->strAccountNo = $strAccountNo;
                
    			$objAgentBankInfo->iCreateUid = $this->getUserId();
    			$objAgentBankInfo->strCreateTime = Utility::Now();
    			$objAgentBankInfo->iUpdateUid = $objAgentBankInfo->iCreateUid;
    			$objAgentBankInfo->strUpdateTime = $objAgentBankInfo->strCreateTime;
    			$objAgentBankInfo->iIsDel = 0;
                $postAccountID = $objAgentBankBLL->insert($objAgentBankInfo);
                $postAccountName = $strBankName." ".$strAccountName." ".$strAccountNo;
            }
        }
        
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
        
        $postMoneyAmount = 0;
        $objProductTypeBLL = new ProductTypeBLL();
        $objAgentPactBLL = new AgentPactBLL();
        $arrayProduct = $objProductTypeBLL->GetAgentSignedProductType($iAgentID);
        $bHaveGua = 0;
        $bHavePre = 0;
        
        foreach($arrayProduct as $key=>$value)
        {
            $tbxGuaMoney = Utility::GetFormDouble('tbxGuaMoney_'.$value["aid"],$_POST); 
            $tbxPreMoney = Utility::GetFormDouble('tbxPreMoney_'.$value["aid"],$_POST); 
            
            if($tbxGuaMoney > 0)
            {
                $arrayProduct[$key]["gua_money"] = $tbxGuaMoney;
                $bHaveGua = 1;
            }
            else
                $arrayProduct[$key]["gua_money"] = 0;
                
            if($tbxPreMoney > 0)
            {
                $arrayProduct[$key]["pre_money"] = $tbxPreMoney;
                $bHavePre = 1;
            }
            else
                $arrayProduct[$key]["pre_money"] = 0;
                
            if($tbxGuaMoney > 0 || $tbxPreMoney > 0)
            {                
                /*----------------------合同数据--------------------s------------*/
                $arrayAgentPact = $objAgentPactBLL->GetAgentPact($iAgentID,$value["aid"]);
                if(isset($arrayAgentPact) && count($arrayAgentPact)>0)
                {
                    $arrayProduct[$key]["agent_pact_id"] = $arrayAgentPact[0]['agent_pact_id'];        
            		$arrayProduct[$key]["pact_no"] = $arrayAgentPact[0]["pact_number"]."".$arrayAgentPact[0]["pact_stage"];        
            		$arrayProduct[$key]["pact_type"] = $arrayAgentPact[0]['pact_type'];
                }
                else
                {
                    exit("未找到相应合同数据！");
                }                  
                /*----------------------合同数据--------------------e------------*/  
                $postMoneyAmount += $arrayProduct[$key]["gua_money"] + $arrayProduct[$key]["pre_money"];
            }
        }
                    
        if($postMoneyAmount <= 0)
           exit("请输入有效金额！");   
           
        $billType = BillTypes::GuaranteeMoney;
        if($bHaveGua == 1 && $bHavePre == 1)
            $billType = BillTypes::PreDeposits2GuaranteeMoney;
        else if($bHavePre == 1)
           $billType = BillTypes::PreDeposits;
           
        $strReprintPath = Utility::GetForm('permitJ_upload0',$_POST,128);        
        if(($payType == PayTypes::BankTransfer || $payType == PayTypes::OnlineBankingPayment) && $strReprintPath == "")
            exit("请上传底单扫描件！");
        
        $strOldReprintPath = Utility::GetForm("tbxOldReprintPath",$_POST,128);        
        if($strReprintPath != "")
        { 
            if($strOldReprintPath != $strReprintPath)//只在新上传或重新上传才保存到数据库
                $strReprintPath = $this->arrSysConfig['UPFILE_PATH']['FM_REPRINT'].array_pop(explode("=",$strReprintPath));
            else
                $strReprintPath = "";
        }
          
        $remark = Utility::GetRemarkForm('tbxRemark',$_POST,256);
        
        ///添加或编辑数据          
        $objReceivablePayBLL = new ReceivablePayBLL();
        $objPostMoneyBLL = new PostMoneyBLL();
        $objPostMoneyInfo = new PostMoneyInfo();
        if($id > 0)
        {
            $objPostMoneyInfo = $objPostMoneyBLL->getModelByID($id,$iAgentID);
            if($objPostMoneyInfo == null)
                exit("未找到数据！");
                
            if($objPostMoneyInfo->iPostMoneyState > ReceivablePayStates::NotEffect)//收支状态 -1:退回 0:未生效 1:待收 2:已收 3:红冲
                exit("该打款单据状态为：".ReceivablePayStates::GetText($objPostMoneyInfo->iPostMoneyState)."，不能再被编辑！");
            
            $objPostMoneyInfo->iUpdateUid = $this->getUserId();
    		$objPostMoneyInfo->strUpdateUserName = $this->getUserName()." ".$this->getUserCNName();
            $objReceivablePayBLL->deleteByFrNo($objPostMoneyInfo->strPostMoneyNo);//删除明细
        }
        else
        {            
            $objPostMoneyInfo->iPostEntryType = 0;
			$objPostMoneyInfo->strPostMoneyNo = $objReceivablePayBLL->GetNewNo($billType);
            $objPostMoneyInfo->iAgentId = $iAgentID;
            $objPostMoneyInfo->iCreateUid = $this->getUserId();
            $objPostMoneyInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName();
            $objPostMoneyInfo->iUpdateUid = 0;
    		$objPostMoneyInfo->iIsDel = 0;
        }
        
        if(!$bPostMoneyAtBackend)
        {      
            $objPostMoneyInfo->strAgentNo = $this->getAgentNo();   
            $objPostMoneyInfo->strAgentName = $this->getAgentName(); 
            $objPostMoneyInfo->iPostEntryType = 0;
        }
        else
        {            
            $objAgentBLL = new AgentBLL();
            $arrayData = $objAgentBLL->select("agent_no,agent_name","agent_id='".$iAgentID."'","");
            if(isset($arrayData) && count($arrayData))
            {
                $objPostMoneyInfo->strAgentNo = $arrayData[0]["agent_no"];
                $objPostMoneyInfo->strAgentName = $arrayData[0]["agent_name"];
            }
            $objPostMoneyInfo->iPostEntryType = 1;
        }
        
        $objPostMoneyInfo->strPostDate = $postDate;                
        $objPostMoneyInfo->iPaymentId = $payType;
        $objPostMoneyInfo->strPaymentName = $payTypeName;
        
        if($objPostMoneyInfo->iPaymentId == PayTypes::Cash)
        {
            $objPostMoneyInfo->iAgentBankId = 0;
            $objReceivablePayInfo->strAgentBankName = "";            
    		$objReceivablePayInfo->iBankId = 0;
    		$objReceivablePayInfo->strBankName = "";            
        }
        else if($objPostMoneyInfo->iPaymentId == PayTypes::QuickMoney)
        {
            $objReceivablePayInfo->strRpNum = $strTransactionNo;
            $objReceivablePayInfo->strAgentBankName = $strPostAccountName;            
        }
        else
        {
            $objPostMoneyInfo->iAgentBankId = $postAccountID;
            $objPostMoneyInfo->strAgentBankName = $postAccountName;        
            $objPostMoneyInfo->iBankId = $iAcceptAccount;
            $objPostMoneyInfo->strBankName = $strAcceptAccountName;            
        }
                        
        if($strReprintPath != "")
		  $objPostMoneyInfo->strRpFiles = $strReprintPath;
          
        $objPostMoneyInfo->strPostRemark = $remark;
        $objPostMoneyInfo->iPostMoneyAmount = $postMoneyAmount;
        $objPostMoneyInfo->iPostMoneyState = ReceivablePayStates::NotEffect;
        
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objPostMoneyInfo->iAccountGroupId = $objAccountGroupUserBLL->getGroupIdByAgentId($iAgentID);
        
        $objPostMoneyInfo->strAgentPactIds = "";
        $objPostMoneyInfo->strAgentPactNos = "";
        $objPostMoneyInfo->strProductTypeIds = "";
        $objPostMoneyInfo->strProductTypeNames = "";
        foreach($arrayProduct as $key=>$value)
        {
            if($value["gua_money"] > 0 || $value["pre_money"] > 0)
            {                       
                $objPostMoneyInfo->strAgentPactIds .= ",".$value['agent_pact_id'];
                $objPostMoneyInfo->strAgentPactNos .= ",".$value['pact_no'];
                $objPostMoneyInfo->strProductTypeIds .= ",".$value['product_type_id'];
                $objPostMoneyInfo->strProductTypeNames .= ",".$value['product_type_name'];
            }
        }
        
        $objPostMoneyInfo->strAgentPactIds = substr($objPostMoneyInfo->strAgentPactIds,1);
        $objPostMoneyInfo->strAgentPactNos = substr($objPostMoneyInfo->strAgentPactNos,1);
        $objPostMoneyInfo->strProductTypeIds = substr($objPostMoneyInfo->strProductTypeIds,1);
        $objPostMoneyInfo->strProductTypeNames = substr($objPostMoneyInfo->strProductTypeNames,1);            
        if($id > 0)
        {
            if($objPostMoneyBLL->updateByID($objPostMoneyInfo) <= 0)
                exit("修改失败！");
        }
        else
        {
            $id = $objPostMoneyBLL->insert($objPostMoneyInfo);
            if($id <= 0)
                exit("添加失败！");
        }        
                
        $objReceivablePayInfo = new ReceivablePayInfo();
        
		$objReceivablePayInfo->strFrNo = $objPostMoneyInfo->strPostMoneyNo;
		$objReceivablePayInfo->iFrObjectId = $objPostMoneyInfo->iAgentId;
		$objReceivablePayInfo->strFrObjectName = $objPostMoneyInfo->strAgentName;        
		$objReceivablePayInfo->iFrPaymentId = $objPostMoneyInfo->iPaymentId;//$payType;
		$objReceivablePayInfo->strFrPaymentName = $objPostMoneyInfo->strPaymentName;  
		$objReceivablePayInfo->strFrPeerDate = $objPostMoneyInfo->strPostDate;                                 
        $objReceivablePayInfo->strFrRpNum = $objPostMoneyInfo->strRpNum;
        $objReceivablePayInfo->iFrPeerBankId = $objPostMoneyInfo->iAgentBankId;
        $objReceivablePayInfo->strFrPeerBankName = $objPostMoneyInfo->strAgentBankName;            
		$objReceivablePayInfo->iFrBankId = $objPostMoneyInfo->iBankId;
		$objReceivablePayInfo->strFrBankName = $objPostMoneyInfo->strBankName;                      
        $objReceivablePayInfo->strFrRpFiles = $objPostMoneyInfo->strRpFiles;
        $objReceivablePayInfo->strFrRemark = $objPostMoneyInfo->strPostRemark;        
        $objReceivablePayInfo->iAccountGroupId = $objPostMoneyInfo->iAccountGroupId;
		$objReceivablePayInfo->iFrState = $objPostMoneyInfo->iPostMoneyState;//收支状态 -1:退回 0:未生效 1:待收 2:已收 3:红冲
        $objReceivablePayInfo->iFrEntryType = $objPostMoneyInfo->iPostEntryType;
        
        $objReceivablePayInfo->iCreateUid = $this->getUserId();
        $objReceivablePayInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName();
        $objReceivablePayInfo->iUpdateUid = 0;
		$objReceivablePayInfo->iIsDel = 0;
                    
		$objReceivablePayInfo->icContractArea = 0;           
		$objReceivablePayInfo->iFrPayMoney = 0;
		$objReceivablePayInfo->iFrMoney = 0;
		$objReceivablePayInfo->iFrRpUserid = $this->getUserId();
		$objReceivablePayInfo->strFrRpUsername = $this->getUserName()." ".$this->getUserCNName();
                             
		$objReceivablePayInfo->ifInvoiceMoney = 0;
		$objReceivablePayInfo->strfInvoiceDate = "2000-01-01";
		$objReceivablePayInfo->ifInvoiceArea = 0;
		$objReceivablePayInfo->ifInvoiceSourceid = 0;
		$objDepartmentBLL = new DepartmentBLL();        
        $objReceivablePayInfo->iFrCorpId = $objDepartmentBLL->GetPanShiCompanyID();//?产商ID
		$objReceivablePayInfo->iFrSourceId = 0;//
        
		$objReceivablePayInfo->iFrRpArea = 0;
		$objReceivablePayInfo->iFrFromPlatform = 0;              
        $unitProductTypeID = $objProductTypeBLL->GetUnitProductTypeID();
        
        foreach($arrayProduct as $key=>$value)
        {
            if($value["gua_money"] > 0 || $value["pre_money"] > 0)
            {
                $objReceivablePayInfo->icContractId = $value['agent_pact_id'];
                $objReceivablePayInfo->strcContractNo = $value['pact_no'];
                $objReceivablePayInfo->icContractType = $value['pact_type'];
                $objReceivablePayInfo->icProductId = $value['product_type_id'];
                $objReceivablePayInfo->strcProductName = $value['product_type_name'];
                
                if($value["gua_money"] > 0)
                {
                    $objReceivablePayInfo->iFrType = BillTypes::GuaranteeMoney;
                    $objReceivablePayInfo->iFrTypeid = 11;//收支来源类型 和ERP里的对应 11代理商的保证金 12代理商的预存款
                    $objReceivablePayInfo->iFrRevMoney = $value["gua_money"];
                    $objReceivablePayBLL->insert($objReceivablePayInfo);
                }
		        
                if($value["pre_money"] > 0)
                {
                    if($objReceivablePayInfo->icProductId == $unitProductTypeID)
                        $objReceivablePayInfo->iFrType = BillTypes::UnitPreDeposits;
                    else
                        $objReceivablePayInfo->iFrType = BillTypes::PreDeposits;
                        
                    $objReceivablePayInfo->iFrTypeid = 12;//收支来源类型 和ERP里的对应 11代理商的保证金 12代理商的预存款
                    $objReceivablePayInfo->iFrRevMoney = $value["pre_money"];
                    $objReceivablePayBLL->insert($objReceivablePayInfo);
                }
		        
            }
        }// end foreach  
              
        /*
        //直接标记在途        
        $objPostMoneyBLL->UpdatePostMoneyState($id,ReceivablePayStates::Receivable,$this->getUserId(),
            $this->getUserCNName(),$objPostMoneyInfo->strPostDate,"",$objPostMoneyInfo->iPostMoneyAmount,$objPostMoneyInfo->iBankId ,
            $objPostMoneyInfo->strBankName);//1 底单入款
        */
        exit("seccess,".$id);
    }
        
    public function DelPayMoney()
    {
        $this->ExitWhenNoRight("PostMoneyModify",RightValue::del);
        $returnData = array("success"=>false,"msg"=>"");
        
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
        {
            $returnData["msg"] = "参数有误！";
            exit(json_encode($returnData));
        }
        
        $objPostMoneyBLL = new PostMoneyBLL();
        
        $objPostMoneyInfo = $objPostMoneyBLL->getModelByID($id,$this->getAgentId());
        if($objPostMoneyInfo == null)
        {
            $returnData["msg"] = "未找到数据！";
            exit(json_encode($returnData));
        }
                
        //能否删除的判断
        if($objPostMoneyInfo->iPostMoneyState >= ReceivablePayStates::Receivable)//收支状态 -1:退回 0:未生效 1:待收 2:已收 3:红冲
        {
            $returnData["msg"] = "该打款单据状态为：".ReceivablePayStates::GetText($objPostMoneyInfo->iPostMoneyState)."，不能被删除！";
            exit(json_encode($returnData));
        }
                    
        //删除数据
        if($objPostMoneyBLL->deleteByID($id,$this->getUserId(),$this->getAgentId()) > 0)
        {
            $objReceivablePayBLL = new ReceivablePayBLL();
            $objReceivablePayBLL->deleteByFrNo($objPostMoneyInfo->strPostMoneyNo);
            
            $returnData["success"] = true;
            exit(json_encode($returnData));
        }
        
        $returnData["msg"] = "删除失败";
        exit(json_encode($returnData));            
    }
    
        
    /**
     * @functional 提交打款记录
    */
    public function PostMoneyList()
    {        
        $this->PageRightValidate("PostMoneyList",RightValue::view);
        $qPriceStatus = Utility::GetFormInt("priceStatus",$_GET,-100);
        $this->smarty->assign('qPriceStatus',$qPriceStatus); 
        
        $this->smarty->assign('PostMoneyListBody',"/?d=FM&c=PayMoney&a=PostMoneyListBody");        
        $this->smarty->display('FM/Front/PostMoneyList.tpl');
    }
    
    /**
     * @functional 提交打款记录数据内容
    */
    public function PostMoneyListBody()
    {        
        $this->ExitWhenNoRight("PostMoneyList",RightValue::view);
        $sWhere = " and fm_post_money.agent_id=".$this->getAgentId();  
        
        $iPriceStatus = Utility::GetFormInt("cbPriceStatus",$_GET);
        if($iPriceStatus != -100)
            $sWhere .= " and `fm_post_money`.post_money_state =".$iPriceStatus;
        
        $iReceiptStatus = Utility::GetFormInt("cbReceiptStatus",$_GET);
        if($iReceiptStatus == 1)//已开收据
            $sWhere .= " and if(`fm_invoice_bill`.`invoice_bill_id`,`fm_invoice_bill`.`invoice_bill_id`,0) > 0 ";
        else if($iReceiptStatus == 0)//未开收据
            $sWhere .= " and if(`fm_invoice_bill`.`invoice_bill_id`,`fm_invoice_bill`.`invoice_bill_id`,0) = 0 ";

        $strFrNo = Utility::GetForm("tbxFrNo",$_GET);
        if($strFrNo != "")
            $sWhere .= " and `fm_post_money`.post_money_no like '%".$strFrNo."%'";
            
        $strPactNo = Utility::GetForm("tbxPactNo",$_GET);
        if($strPactNo != "")
            $sWhere .= " and `fm_post_money`.agent_pact_nos like '%".$strPactNo."%'";
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        
        $objPostMoneyBLL = new PostMoneyBLL();
        $arrPageList = $this->getPageList($objPostMoneyBLL,"*",$sWhere,"",$iPageSize,($iExportExcel==1?true:false));
        $arrayData = &$arrPageList['list'];
        $iRecordCount = count($arrayData);
        
        for ($i = 0; $i < $iRecordCount; $i++)
        {       
            if($arrayData[$i]["payment_id"] != PayTypes::Cash)
            {
                if($arrayData[$i]["rp_num"] != "")
                    $arrayData[$i]["agent_bank_name"] = $arrayData[$i]["rp_num"]." ".$arrayData[$i]["agent_bank_name"];
                    
            }
            else
            {
                $arrayData[$i]["agent_bank_name"] = "";
            }
                        
            if($arrayData[$i]["post_money_state"] < ReceivablePayStates::Received)           
                $arrayData[$i]["received_time"] = "";
            
            if($arrayData[$i]["income_uid"] <= 0)
                $arrayData[$i]["income_time"] = "";
                        
            if($arrayData[$i]["invoice_bill_id"] <= 0)
            {        
                $arrayData[$i]["invoice_no"] = "";               
                $arrayData[$i]["invoice_money"] = "";            
                $arrayData[$i]["open_time"] = "";
            }    
            
            if($arrayData[$i]["receipt_uid"] <= 0)
            {          
                $arrayData[$i]["receipt_user_name"] = "";            
                $arrayData[$i]["receipt_time"] = "";
            }
            $arrayData[$i]["post_money_state_text"] = ReceivablePayStates::GetText($arrayData[$i]["post_money_state"]);
        }
        
        if($iExportExcel == 0)
        {
            Utility::FormatArrayMoney($arrayData,"post_money_amount");
            //print_r($arrayData);
            $this->smarty->assign('arrayPayMoney',$arrayData);
            $this->smarty->display("FM/Front/PostMoneyListBody.tpl");
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
           
        }
        else
        {                
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("交易号","post_money_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("关联合同号","agent_pact_nos",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款产品","product_type_names",ExcelDataTypes::String,25));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款金额","post_money_amount",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款类型","payment_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款信息","agent_bank_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("提交人","create_user_name",ExcelDataTypes::String,15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款时间","post_date",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("款项状态","post_money_state_text",ExcelDataTypes::String,15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("到账时间","received_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("充值时间","income_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据号","invoice_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据金额","invoice_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据开票时间","open_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据确认人","receipt_user_name",ExcelDataTypes::String,15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据确认时间","receipt_time",ExcelDataTypes::DateTime));
                        
            $objDataToExcel->Init("打款提交记录",$arrayData,null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }

    }
    
    /**
     * @functional 更新提示信息
    */
    public function UpdateNotice()
    {        
        $objAgentAccountBLL = new AgentAccountBLL();
        $arrayMoney = $objAgentAccountBLL->GetPostMoneyAccountInfo($this->getAgentId());
        $arrayMoney["PostAmount"] = Utility::FormatMoney($arrayMoney["PostAmount"]);
        $arrayMoney["NotEffect"] = Utility::FormatMoney($arrayMoney["NotEffect"]);
        $arrayMoney["Back"] = Utility::FormatMoney($arrayMoney["Back"]);
        $arrayMoney["Receivable"] = Utility::FormatMoney($arrayMoney["Receivable"]);
        $arrayMoney["Received"] = Utility::FormatMoney($arrayMoney["Received"]);
        $arrayMoney["Red"] = Utility::FormatMoney($arrayMoney["Red"]);
        
        $backHtml = "<label>提示信息：</label><span class=\"ui_link\">打款总额：(<em id=\"emPostAmount\">".$arrayMoney["PostAmount"]."</em>)</span>
        <span class=\"ui_link\">未到账金额：(<em id=\"emNotEffect\">".$arrayMoney["NotEffect"]."</em>)</span>
        <span class=\"ui_link\">信息退回金额：(<em id=\"emBack\">".$arrayMoney["Back"]."</em>)</span>
        <span class=\"ui_link\">底单入款金额：(<em id=\"emReceivable\">".$arrayMoney["Receivable"]."</em>)</span>
        <span class=\"ui_link\">到账金额：(<em id=\"emReceived\">".$arrayMoney["Received"]."</em>)</span>";
        exit($backHtml);
    }
    
      
    /**
     * @functional 提交打款记录
    */
    public function PostMoneyDetailList()
    {        
        $this->PageRightValidate("PostMoneyDetailList",RightValue::view);
        
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
                       
        $this->smarty->assign('PostMoneyDetailListBody',"/?d=FM&c=PayMoney&a=PostMoneyDetailListBody");        
        $this->smarty->display('FM/Front/PostMoneyDetailList.tpl');
    }
    
    /**
     * @functional 提交打款记录数据内容
    */
    public function PostMoneyDetailListBody()
    {        
        $this->ExitWhenNoRight("PostMoneyDetailList",RightValue::view);
        
        $sWhere = " and fm_receivable_pay.fr_object_id=".$this->getAgentId();          
        $cbFrTypes = Utility::GetFormInt("cbFrTypes",$_GET);
        if($cbFrTypes > 0)
            $sWhere .= " and fm_receivable_pay.fr_type = ".$cbFrTypes;
                
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
                  
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        $arrPageList = null;
        $arrayData = null;
        $objReceivablePayBLL = new ReceivablePayBLL();
        if($iExportExcel == 0)
        {            
            $arrPageList = $this->getPageList($objReceivablePayBLL,"*",$sWhere,"",$iPageSize);
            $arrayData = &$arrPageList['list'];
        }
        else
        {
            $arrayData = $objReceivablePayBLL->ExportPageData($sWhere);
        }
        $iRecordCount = count($arrayData);
        
        for ($i = 0; $i < $iRecordCount; $i++)
        {       
            if($arrayData[$i]["fr_payment_id"] != PayTypes::Cash)
            {
                if($arrayData[$i]["fr_rp_num"] != "")
                    $arrayData[$i]["fr_peer_bank_name"] = $arrayData[$i]["fr_rp_num"]." ".$arrayData[$i]["fr_peer_bank_name"];                    
            }
            else
            {
                $arrayData[$i]["fr_peer_bank_name"] = "";
            }
                        
            if($arrayData[$i]["fr_state"] < ReceivablePayStates::Received)           
                $arrayData[$i]["received_time"] = "";
            
            if($arrayData[$i]["income_uid"] <= 0)
                $arrayData[$i]["income_time"] = "";
                        
            if($arrayData[$i]["invoice_bill_id"] <= 0)
            {        
                $arrayData[$i]["invoice_no"] = "";               
                $arrayData[$i]["invoice_money"] = "";            
                $arrayData[$i]["open_time"] = "";
            }    
            
            if($arrayData[$i]["receipt_uid"] <= 0)
            {          
                $arrayData[$i]["receipt_user_name"] = "";            
                $arrayData[$i]["receipt_time"] = "";
            }
        }
        
        ReceivablePayStates::ReplaceArrayText($arrayData,"fr_state");
        if($iExportExcel == 0)
        {
            $this->smarty->assign('arrayPayMoney',$arrayData);
            $this->smarty->display("FM/Front/PostMoneyDetailListBody.tpl");
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
           
        }
        else
        {
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            
            for ($i = 0; $i < $iRecordCount; $i++)
            { 
                if($arrayData[$i]["fr_type"] == BillTypes::PreDeposits)
                    $arrayData[$i]["fr_type"] = "增值产品预存款";
                else if($arrayData[$i]["fr_type"] == BillTypes::UnitPreDeposits)
                    $arrayData[$i]["fr_type"] = "网盟预存款";
                else
                    $arrayData[$i]["fr_type"] = "保证金";
            }
            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("款项类型","fr_type",ExcelDataTypes::String));   
            $objExcelBottomColumns->Add(new ExcelBottomColumn("交易号","fr_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","c_contract_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("合同开始时间","pact_sdate",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("合同结束时间","pact_edate",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款产品","c_product_name"));            
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款金额","fr_rev_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款类型","fr_payment_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款信息","fr_peer_bank_name",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("操作人","create_user_name",ExcelDataTypes::String,15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("打款时间","fr_peer_date",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("款项状态","fr_state",ExcelDataTypes::String,15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("到账时间","received_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("充值时间","income_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据号","invoice_no"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据金额","invoice_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据开票时间","open_time",ExcelDataTypes::DateTime));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据确认人","receipt_user_name",ExcelDataTypes::String,15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("收据确认时间","receipt_time",ExcelDataTypes::DateTime));
            
            $objDataToExcel->Init("打款明细",$arrayData,null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
    
    
    /**
     * @functional 收据确认
    */
    protected function ConfirmReceipt()
    {
        $returnData = array("success"=>false,"msg"=>"");
        
        $id = Utility::GetFormInt('id',$_POST);
        $receipted = Utility::GetForm('receipted',$_POST);
        
        if($id <= 0)
        {
            $returnData["msg"] = "参数有误！";
            exit(json_encode($returnData));
        }
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        if($objInvoiceIsseuBLL->ReceiptConfirm($id,$this->getAgentId(),$this->getUserId(),$this->getUserName(),$receipted == "true"? 1:0) > 0)
        {
            $returnData["success"] = true;
            exit(json_encode($returnData));
        }
        else
        {
            $returnData["msg"] = "确认失败";
            exit(json_encode($returnData));
        }
    }
    
    /**
     * @functional 显示提交打款详细页面
    */
    public function SignedPayMoneyDetail()
    {
        $this->PageRightValidate("mySigned",RightValue::v64);
        $this->PostMoneyDetail();
    }
        
    /**
     * @functional 显示提交打款详细页面
    */
    public function PayMoneyDetail()
    {        
        if(!$this->HaveRight("PostMoneyModify",RightValue::view)&&
        !$this->HaveRight("ReceivablesDetails",Rightvalue::view)&&
        !$this->HaveRight("MoneyInAccountList",Rightvalue::view))
        {            
    	    $this->smarty->assign('strTitle', '访问限制');
    	    $this->smarty->assign('strErrMsg', '对不起，您无权访问该页面！<a href="javascript:;" onclick="PageBack()">返回</a>');
    	    $this->smarty->display('Error.tpl');
    	    exit();
        }
        
        $this->PostMoneyDetail();
    }
    
    /**
     * @functional 显示提交打款详细页面
    */
    protected function PostMoneyDetail()
    {            
        $id = Utility::GetFormInt('id',$_GET);        
        if($id <= 0)
            exit("参数有误！");            
        
        $objPostMoneyBLL = new PostMoneyBLL();
        $objPostMoneyInfo = $objPostMoneyBLL->getModelByID($id,$this->getAgentId());
        if($objPostMoneyInfo == null)
            exit("未找到相关数据");
            
        $this->smarty->assign('strTitle',"打款信息");
        
        $objPostMoneyInfo->iPostMoneyAmount = Utility::FormatMoney($objPostMoneyInfo->iPostMoneyAmount);
        $objReceivablePayBLL = new ReceivablePayBLL();    
        $arrayProduct = $objReceivablePayBLL->GetPostMoneyDetailByNo($objPostMoneyInfo->strPostMoneyNo);
        Utility::FormatArrayMoney($arrayProduct,"gua_money,pre_money");
        
        $this->smarty->assign('arrayProduct',$arrayProduct);
        $this->smarty->assign('objPostMoneyInfo',$objPostMoneyInfo);
        
        $this->smarty->assign('isBackend',($this->isAgentUser() ? 0 : 1));
        $objReceivablePayStateBLL = new ReceivablePayStateBLL();    
        $objReceivablePayStateInfo = $objReceivablePayStateBLL->getModelByFrID($id,$this->getAgentId());
        $this->smarty->assign('objReceivablePayStateInfo',$objReceivablePayStateInfo);
        $this->displayPage('FM/Front/PayMoneyDetail.tpl');
    }
    
        
    /**
     * @functional 显示打款退回操作界面 
     */
    public function BackMoney()
    {        
        $this->ExitWhenNoRight("ReceivablesDetails",RightValue::v4); 
        $this->smarty->assign('isBackMoney',"1");
        $this->PostMoneyDetail();
        
    }
    
        
    /**
     * @functional 打款退回操作 
     */
    public function BackMoneySubmit()
    {
        $this->ExitWhenNoRight("ReceivablesDetails",RightValue::v4);      
        $id = Utility::GetFormInt('id',$_POST);        
        if($id <= 0)
            exit("参数有误！");            
        
        $backRemark = Utility::GetRemarkForm('tbxRemark',$_POST,256);
        
        $objPostMoneyBLL = new PostMoneyBLL();
        if($objPostMoneyBLL->UpdatePostMoneyState($id,ReceivablePayStates::Back,$this->getUserId(),
        $this->getUserCNName(),Utility::Now(),$backRemark))
            exit("0");
                    
        exit("退回失败！");
    }
    
    /**
     * @functional 显示打款收款操作界面 
     */
    public function MoneyInAccount()
    {        
        $this->ExitWhenNoRight("ReceivablesDetails",RightValue::v4); 
        $this->smarty->assign('isMoneyInAccount',"1");
        $this->PostMoneyDetail();
        
    }
    
    /**
     * @functional 款项认领 时根据ERP记录ID 显示ERP银行到帐信息
     */
    public function CheckMoneyShowERPInAccount()
    {
        $strBankRecordNo = Utility::GetForm('tbxBankRecordNo',$_POST,50);
        $objERP_FinanceService = new ERP_FinanceService();
        $params = array("keyID" => $strBankRecordNo);
        $retValue = $objERP_FinanceService->Finance_Account_BankRecord_Key($params);
        exit($retValue."");
    }
    
    /**
     * @functional 款项认领 
     */
    public function CheckMoneyInAccount()
    {
        $this->ExitWhenNoRight("ReceivablesDetails",RightValue::v8); 
        $id = Utility::GetFormInt('post_money_id',$_POST); 
        if($id <= 0)
            exit("参数有误！"); 
        
        $strBankRecordNo = Utility::GetForm('tbxBankRecordNo',$_POST,50); 
        $objPostMoneyBLL = new PostMoneyBLL();
        $objPostMoneyInfo = $objPostMoneyBLL->getModelByID($id);
        if($objPostMoneyInfo == null)
            exit("未找到打款记录！"); 
        /*
        if($objPostMoneyInfo->iPostMoneyState != ReceivablePayStates::Received
            && $objPostMoneyInfo->iPostMoneyState != ReceivablePayStates::Receivable) 
            */
        if($objPostMoneyInfo->iPostMoneyState != ReceivablePayStates::Receivable
        && $objPostMoneyInfo->iPostMoneyState != ReceivablePayStates::Received) 
            exit("该单据已不能再认领！"); 
        
        $IsCoerce = Utility::GetFormInt('IsCoerce',$_POST,0);
        
        $objERP_FinanceService = new ERP_FinanceService();
        $params = array("keyID" => $strBankRecordNo);
        $retValue = $objERP_FinanceService->Finance_Account_BankRecord_Key($params);
        if($retValue == "")
            exit("银行记录不存在！"); 
        
        $retValue = str_replace("'","\"",$retValue);
        $aBankData = json_decode($retValue,true);  
        //print_r($aBankData);
        //{"ID":"11070","BA_ACCOUNT_NAME":"工行祥符支行(浙江盘石)","OBJECTNAME":"李一","A_MONEY":"8000","MONEYTOTIME":"2012-07-30","ABR_STATE":"部分认领"}
        
        if(round($objPostMoneyInfo->iPostMoneyAmount,2) != round($aBankData["A_MONEY"],2))
            exit("金额不匹配！"); 
            
        if($IsCoerce == 0 && $objPostMoneyInfo->strAgentName != $aBankData["OBJECTNAME"])
            exit("客户名称不匹配！"); 
        
        $inComeDate = $aBankData["MONEYTOTIME"];
        
        //先在ERP中认领 
        /*账户编号 就是代理商的银行帐户号
        收支对象 就是代理商名称
        收款时间 就是到帐时间
        交领款人姓名 就是打款人吧
        收支员工姓名 就是收款人*/
        $iDrpType = 17;//类型，11－代理保证金 12－代理预存款 17－代理预存款和保证金
        $aNo = explode("-",$objPostMoneyInfo->strPostMoneyNo);
        if($aNo[0] == "BZJ")
            $iDrpType = 11;
        else if($aNo[0] == "YCK")
            $iDrpType = 12;
            
        $params = array("RpmModeID" => $objPostMoneyInfo->iPaymentId,
                        "AdrpAccountNo" => $objPostMoneyInfo->iBankId,//116,//
                        "AdrpObjectName" => $objPostMoneyInfo->strAgentName,
                        "AdrpReceiptMoney" => $objPostMoneyInfo->iPostMoneyAmount,
                        "AdrpCreateTime" => Utility::Today(),
                        "AdrpUserNamePR" => $objPostMoneyInfo->strCreateUserName,
                        "AdrpUsserNameOP" => $this->getUserCNName(),
                        "AdrpFromID" => $objPostMoneyInfo->iPostMoneyId,
                        "AdrpType" => $iDrpType,
                        "AbrID" => $strBankRecordNo,
                        "IsCoerce" => $IsCoerce);
        $retValue = $objERP_FinanceService->Finance_Bank_Claim($params);   
        if($retValue <= 0)
        {
            switch($retValue)
            {
                case -1:
                    exit("数据操作失败");
                break;
                case -2:
                    exit("收支类型错误");
                break;
                case -3:
                    exit("客户名称不匹配");
                break;
                case -4:
                    exit("插入数据到银行资金记录失败");
                break;
                case -5:
                    exit("银行认领失败");
                break;
                case -6:
                    exit("收款金额和银行金额不相等");
                break;
            }
            
            exit("认领失败。");
        }
        
        //标记到帐
        if($objPostMoneyInfo->iPostMoneyState == ReceivablePayStates::Receivable)
            $objPostMoneyBLL->PostMoneyConfirm($id,$this->getUserId(),$this->getUserCNName(),$inComeDate,"");
        
        if($objPostMoneyBLL->CheckMoneyInAccount($id,$this->getUserId(),$this->getUserCNName(),Utility::Now(),
        $strBankRecordNo,$aBankData["OBJECTNAME"],""))
            exit("0");
                    
        exit("认领失败！");
    }
    
    
        
    /**
     * @functional 打款收款操作 
     */
    public function MoneyInAccountSubmit()
    {
        $this->ExitWhenNoRight("ReceivablesDetails",RightValue::v4);        
        $id = Utility::GetFormInt('id',$_POST); 
        if($id <= 0)
            exit("参数有误！");            
                
        $chkOnTheWay = Utility::GetFormInt('chkOnTheWay',$_POST,0); 
        $strInDate = Utility::GetForm('tbxInDate',$_POST,20);
        if(!Utility::isShortTime($strInDate))
            exit("日期格式不正确！"); 
            
        $strRemark = Utility::GetRemarkForm('tbxRemark',$_POST,256);
        
        $objPostMoneyBLL = new PostMoneyBLL();
        $objPostMoneyInfo = $objPostMoneyBLL->getModelByID($id);
        if($objPostMoneyInfo == null)
            exit("未找到打款提交数据！");  
            
        if($chkOnTheWay == 1)
        {            
            if($objPostMoneyInfo->iPostMoneyState != ReceivablePayStates::NotEffect)
                exit("该单据不能进行收款！");  
                
            if($objPostMoneyBLL->UpdatePostMoneyState($id,ReceivablePayStates::Receivable,$this->getUserId(),
                $this->getUserCNName(),$strInDate,$strRemark,$objPostMoneyInfo->iPostMoneyAmount,$objPostMoneyInfo->iBankId ,
                $objPostMoneyInfo->strBankName))//1 底单入款
                exit("0");
        }
        else
        {            
            if($objPostMoneyInfo->iPostMoneyState != ReceivablePayStates::NotEffect
            && $objPostMoneyInfo->iPostMoneyState != ReceivablePayStates::Receivable)
                exit("该单据不能进行收款！");  
                
            if($objPostMoneyBLL->PostMoneyConfirm($id,$this->getUserId(),$this->getUserCNName(),$strInDate,$strRemark))
                exit("0");
        }
        
        exit("收款失败！");
    }
    
    /**
     * @functional 显示收据信息
     */
    public function ShowInvoiceIsseuInfo()
    {
        $id = Utility::GetFormInt('id',$_POST);        
        if($id <= 0)
            exit("参数有误！");
            /*
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $objInvoiceIsseuInfo = $objInvoiceIsseuBLL->getModelByID($id,$this->getAgentId());
        if($objInvoiceIsseuInfo == null)
            exit("查询数据出错！");
            
        $objInvoiceIsseuInfo->ifInvoiceMoney = Utility::FormatMoney($objInvoiceIsseuInfo->ifInvoiceMoney);
        $this->smarty->assign('objInvoiceIsseuInfo',$objInvoiceIsseuInfo);*/
        
        $objInvoiceBillBLL = new InvoiceBillBLL();
        $objInvoiceBillInfo = $objInvoiceBillBLL->getModelByID($id,$this->getAgentId());
        if($objInvoiceBillInfo == null)
            exit("查询数据出错！");
            
        if($objInvoiceBillInfo != null)
            $objInvoiceBillInfo->iInvoiceMoney = Utility::FormatMoney($objInvoiceBillInfo->iInvoiceMoney);
        $this->smarty->assign('objInvoiceBillInfo',$objInvoiceBillInfo);
        $this->displayPage('FM/Front/InvoiceIsseuInfo.tpl');   
    }
    
    
    /**
     * @functional 打款-->充值信息
     */
    public function ShowInAccountDetailInfo()
    {        
        $id = Utility::GetFormInt('id',$_POST);        
        if($id <= 0)
            exit("参数有误！");
            
        $objReceivablePayBLL = new ReceivablePayBLL();    
        $arrayData = $objReceivablePayBLL->GetInAccountInfo($id,$this->getAgentId());
        if(isset($arrayData) && count($arrayData) > 0)
        {
            Utility::FormatArrayMoney($arrayData,"act_money");
            BillTypes::ReplaceArrayText($arrayData,"data_type");
            $this->smarty->assign('arrayData',$arrayData);
            $this->displayPage('FM/Front/InAccountDetailInfo.tpl'); 
        }
        else
            exit("未找到数据！");

    }
    
    /**
     * @functional 打款-->充值信息
     */
    public function ShowInAccountInfo()
    {        
        $id = Utility::GetFormInt('id',$_POST);        
        if($id <= 0)
            exit("参数有误！");
            
        $objReceivablePayBLL = new ReceivablePayStateBLL();    
        $objReceivablePayInfo = $objReceivablePayBLL->getModelByFrID($id,$this->getAgentId());
        if($objReceivablePayInfo == null)
            exit("未找到数据！");
            
        $this->smarty->assign('objReceivablePayInfo',$objReceivablePayInfo);
        $this->displayPage('FM/Front/InAccountInfo.tpl');             
    }
        
    /**
     * @functional  合同款项到帐查询
     */
    public function PactMoneyInAccountList()
    {   
        $strModelName = "PactMoneyInAccountList";
        if(!($this->HaveRight($strModelName,RightValue::v2) ||
        $this->HaveRight($strModelName,RightValue::v4)))
        {
            exit("您没有此操作权限！");  
        }
                    
        $strPath = "";
        $strTitle = "";
        $this->GetModelPathByModelCode($strModelName,$strPath,$strTitle);            
        $this->smarty->assign('strTitle',$strTitle);
        $this->smarty->assign('strPath',$strPath);
            
        $agentNo = Utility::GetForm('agentNo',$_GET);         
        $productID = Utility::GetForm('productID',$_GET); 
        
        $this->smarty->assign('agentNo',$agentNo);
        $this->smarty->assign('qProductTypeID',$productID);
    
        $objProductTypeBLL = new ProductTypeBLL();
        $unitProductTypeID = $objProductTypeBLL->GetUnitProductTypeID();
        $this->smarty->assign('unitProductTypeID',$unitProductTypeID);
            
        $this->smarty->assign('PactMoneyInAccountListBody',"/?d=FM&c=PayMoney&a=PactMoneyInAccountListBody");        
        $this->smarty->display('FM/Backend/PactMoneyInAccountList.tpl');
    }
    
    
    /**
     * @functional  合同款项到帐查询
     */
    public function PactMoneyInAccountListBody()
    {                
        $strModelName = "PactMoneyInAccountList";        
        $sWhere = " ";    
        if(!($this->HaveRight($strModelName,RightValue::v2)))//v2 所有数据
        {
            if($this->HaveRight($strModelName,RightValue::v4)
            ||$this->HaveRight("mySigned",RightValue::v512))//只看自己的代理商
            {
                $sWhere = " and am_agent_source.channel_uid = " . $this->getUserId();
            }
            else
            {
                exit("您没有此操作权限！");  
            }
        }
                    
        $cbProductType = Utility::GetFormInt('cbProductType',$_GET);     
        if($cbProductType > 0)
            $sWhere .= " and v_am_effect_pact_product.product_type_id = {$cbProductType}";  
        
        $agent_no = Utility::GetForm("tbxAgentNo",$_GET);
        if($agent_no != "")
            $sWhere .= " and am_agent_source.agent_no like '%".$agent_no."%'";             
            
        $agent_name = Utility::GetForm("tbxAgentName",$_GET);
        if($agent_name != "")
            $sWhere .= " and am_agent_source.agent_name like '%".$agent_name."%'";      
            
        $pact_no = Utility::GetForm("tbxPactNo",$_GET);
        if($pact_no != "")
            $sWhere .= " and v_am_effect_pact_product.pact_no like '%".$pact_no."%'";
            
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $iExportExcel = Utility::GetFormInt('iExportExcel',$_GET);
        if($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
            
        $objPactMoneyInAccountBLL = new PactMoneyInAccountBLL();        
        $arrPageList = $this->getPageList($objPactMoneyInAccountBLL,"*",$sWhere,"",$iPageSize,$iExportExcel);
        if($iExportExcel == false)
        {            
            $this->smarty->assign('arrayData',$arrPageList['list']);
            $this->smarty->display("FM/Backend/PactMoneyInAccountListBody.tpl");
            echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        }
        else
        {            
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("合同号","pact_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商代码","agent_no",ExcelDataTypes::String,25));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称","agent_name",ExcelDataTypes::String,30));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理产品","product_type_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("签约类型","pact_type_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理等级","agent_level_text"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("应收保证金","pre_deposit",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("已收保证金","pre_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("应收预存款","cash_deposit",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("已收预存款","cash_money",ExcelDataTypes::Double));
            
            $strPath = "";
            $strTitle = "";
            $this->GetModelPathByModelCode($strModelName,$strPath,$strTitle);    
            $objDataToExcel->Init($strTitle,$arrPageList['list'],null,$objExcelBottomColumns);
            $objDataToExcel->Export();
        }
      
    }
    
    /**
     * @functional 
     */
    public function Test_PostPriceAudit()
    {
        $id = Utility::GetFormInt('id',$_GET);
        if($id > 0)
        {
            $objReceivablePayBLL = new ReceivablePayBLL();
            $objReceivablePayBLL->PostMoneyConfirm($id,$this->getUserId(),$this->getUserCNName(),2,646,"adsf","asdf");
        }    
    }
    
    /**
     * @functional 
     */
    public function Test_UpdatePostMoneyState()
    {
        $id = Utility::GetFormInt('id',$_GET);
        if($id > 0)
        {
            $objReceivablePayBLL = new ReceivablePayBLL();
            $objReceivablePayBLL->UpdatePostMoneyState($id,ReceivablePayStates::Receivable,$this->getUserId(),$this->getUserCNName(),"");
        }    
    }
    
    
    /**
     * @functional 
     */
    public function Test_PostMoneyBack()
    {
        $id = Utility::GetFormInt('id',$_GET);
        if($id > 0)
        {
            $objReceivablePayBLL = new ReceivablePayBLL();
            $objReceivablePayBLL->UpdatePostMoneyState($id,ReceivablePayStates::Back,$this->getUserId(),$this->getUserCNName(),"");
        }    
    }
    
    
    public function ViewImage()
    {
        $id = Utility::GetFormInt("id",$_GET);
        if($id <= 0)
            exit("ID参数有误！");
            
        $sWhere = "post_money_id=".$id;
        if($this->isAgentUser())
            $sWhere .= " and agent_id=".$this->getAgentId();
            
        $objPostMoneyBLL = new PostMoneyBLL();
        $arrayData = $objPostMoneyBLL->select("rp_files",$sWhere);
        if(isset($arrayData) && count($arrayData) > 0 && $arrayData[0]["rp_files"] != "")
        {
            ShowImage::Show($arrayData[0]["rp_files"]);
        }
        
        exit("未找到图片");            
    }
}
?>