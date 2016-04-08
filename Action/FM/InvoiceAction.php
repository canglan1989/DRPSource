<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：发票记录模块
 * 创建人：wzx
 * 添加时间：2011-8-25 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgentPermitBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/InvoiceIsseuBLL.php';
require_once __DIR__.'/../../Class/BLL/InvoiceBillBLL.php';

class InvoiceAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 发票申请
     */
    public function InvoiceModify()
    {           
        $this->PageRightValidate("InvoiceModify",Rightvalue::add);  
        //代理商名称
        $agentName = $this->getAgentName();
        //是否有一般纳税人资质     
        $permitPath = $this->GetPermitPath();
        $id = Utility::GetFormInt("id",$_GET);
        if($id > 0)
        {
            //目前没有编辑的需求 
        }
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayProductType = $objProductTypeBLL->GetAgentSignedProductType($this->getAgentId());
        $this->smarty->assign('arrayProductType',$arrayProductType);
          
        $this->smarty->assign('permitPath',$permitPath);
        $this->smarty->assign('agentName',$agentName);
        $this->smarty->display('FM/Front/InvoiceModify.tpl');
    }
    
    /**
     * @functional 取得当前代理商资质 
    */
    public function GetPermitPath()
    {
        $permitPath = "";
        $objAgentPermitBLL = new AgentPermitBLL();   
        $arrayPermit = $objAgentPermitBLL->select("permit_name,file_path,file_ext","permit_type =5 AND agent_id = ".$this->getAgentId(),"");
        if(isset($arrayPermit) && count($arrayPermit) > 0)
            $permitPath = $arrayPermit[0]["file_path"].".".$arrayPermit[0]["file_ext"];
                
        return $permitPath;
    }
      
    /**
     * @functional 发票申请数据提交
     */
    public function InvoiceModifySubmit()
    {        
        $this->PageRightValidate("InvoiceModify",Rightvalue::add); 
        $id = Utility::GetFormInt("id",$_GET);
        
        $productTypeID = Utility::GetFormInt('cbProductType',$_POST);        
        if($productTypeID <= 0)
            exit("请选择产品！");
            
        $permitPath = Utility::GetForm('permitJ_upload0',$_POST,128);
        $isGeneralTaxpayer = Utility::GetFormInt('chkGeneralTaxpayer',$_POST);       
        
        if($isGeneralTaxpayer == 1 && $permitPath == "")
            exit("请上传一般纳税人资格证！");
            
        $invoiceType = Utility::GetFormInt('cbInvoiceType',$_POST);
        if($invoiceType <= 0)
            exit("请选择发票种类！");

        $applyMoney = Utility::GetFormDouble('tbxApplyPrice',$_POST);
        if($applyMoney <= 0)
            exit("请输入申请金额！");
            
        $remark = Utility::GetRemarkForm('tbxRemark',$_POST,256);
        //申请金额是否超出可申请的验证
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $canApplyMoney = $objInvoiceIsseuBLL->CanApplyMoney($this->getAgentId(),$productTypeID);
        $applyMoney = round($applyMoney,2);
        $canApplyMoney = round($canApplyMoney,2);
        if($applyMoney > $canApplyMoney)
            exit("申请金额超过可申请金额！");
        
        /*----------------------合同数据--------------------s------------*/
        $objAgentPactBLL = new AgentPactBLL();
        
        $arrayAgentPact = $objAgentPactBLL->GetAgentPact($this->getAgentId(),$productTypeID);
        if(!(isset($arrayAgentPact) && count($arrayAgentPact)>0))
        {
            exit("未找到相应合同数据！");
        }
        /*----------------------合同数据--------------------e------------*/
        
        //====================添加一般纳税人资格证========s========//        
        $strOldPermitPath = Utility::GetForm('tbxOldPermitPath',$_POST,128);
        if($isGeneralTaxpayer == 1 &&$permitPath != "" && $strOldPermitPath != $permitPath)
        {
            $objAgentPermitBLL = new AgentPermitBLL();
            $objAgentPermitInfo = new AgentPermitInfo();
            $objAgentPermitInfo->strPermitName = '一般纳税人资格证';
            $objAgentPermitInfo->iAgentId      = $this->getAgentId();
            $objAgentPermitInfo->iPermitType   = 5;
            $objAgentPermitInfo->iCreateUid    = $this->getUserId();
            $arrPermit = explode('.',$permitPath);
            if(is_array($arrPermit) && count($arrPermit)>0)
            {
                $objAgentPermitInfo->strFilePath = $arrPermit[0];
                $objAgentPermitInfo->strFileExt  = $arrPermit[1];
            }
                
            $objAgentPermitBLL->insert($objAgentPermitInfo);
        }
        //====================添加一般纳税人资格证========e========//
        $objInvoiceIsseuInfo = new InvoiceIsseuInfo();
        $objInvoiceIsseuInfo->iFiiType = 5;//4:保证金开票 5:消费开票
        if($id > 0)
        {
            $objInvoiceIsseuInfo = $objInvoiceIsseuBLL->getModelByID($id);
            $objInvoiceIsseuInfo->iUpdateUid = $this->getUserId();
    		$objInvoiceIsseuInfo->strUpdateUserName = $this->getUserName()." ".$this->getUserCNName();
        }
        else
        {
   			$objInvoiceIsseuInfo->strFiiNo = $objInvoiceIsseuBLL->GetNewNo($this->getAgentNo());
			$objInvoiceIsseuInfo->iAgentId = $this->getAgentId();
			$objInvoiceIsseuInfo->ifType = InvoiceTypes::Invoice;
            $objInvoiceIsseuInfo->iCreateUid = $this->getUserId();
            $objInvoiceIsseuInfo->strCreateUsername = $this->getUserName()." ".$this->getUserCNName();
            $objInvoiceIsseuInfo->iUpdateUid = 0;
    		$objInvoiceIsseuInfo->iIsDel = 0;
        }
            
		$objInvoiceIsseuInfo->icContractId = $arrayAgentPact[0]['agent_pact_id'];
		$objInvoiceIsseuInfo->strcContractNo = $arrayAgentPact[0]["pact_number"]."".$arrayAgentPact[0]["pact_stage"];
		$objInvoiceIsseuInfo->icContractType = $arrayAgentPact[0]['pact_type'];
		$objInvoiceIsseuInfo->icProductId = $productTypeID;
		$objInvoiceIsseuInfo->strcProductName =  $arrayAgentPact[0]['product_type_name'];
                
		$objInvoiceIsseuInfo->ifInvoiceType = $invoiceType;//申请类型
		$objInvoiceIsseuInfo->strfInvoiceTitle = $this->getAgentName();
		$objInvoiceIsseuInfo->ifInvoiceApplyMoney = $applyMoney;
		$objInvoiceIsseuInfo->ifrMoney = 0;
		$objInvoiceIsseuInfo->ifrMoneyArea = 0;
		$objInvoiceIsseuInfo->ifMoneyIstoaccount = 0;
		$objInvoiceIsseuInfo->strfMoneyDate = '2000-01-01';
		$objInvoiceIsseuInfo->ifMoneySourceid = 0;
		$objInvoiceIsseuInfo->ifReceiveType = 2;//发票领取方式 1:自领2:邮寄
		$objInvoiceIsseuInfo->ifInvoiceState = 0;
		$objInvoiceIsseuInfo->ifInvoiceMoney = 0;
		$objInvoiceIsseuInfo->ifOpenUserid = 0;
		$objInvoiceIsseuInfo->strfOpentime = '2000-01-01';
		$objInvoiceIsseuInfo->ifIssend = 0;
		$objInvoiceIsseuInfo->strfSenddate = '2000-01-01';
		$objInvoiceIsseuInfo->ifIsreceipt = 0;
		$objInvoiceIsseuInfo->strfReceiptdate = '2000-01-01';
		$objInvoiceIsseuInfo->ifSourceId = 0;
		$objInvoiceIsseuInfo->ifInvoiceArea = 0;
		$objInvoiceIsseuInfo->iFrFromPlatform = 0;
        $objInvoiceIsseuInfo->strfRemark = $remark;
        if($id > 0)
        {
            if($objInvoiceIsseuBLL->updateByID($objInvoiceIsseuInfo) > 0)
                exit("seccess,".$id);              
            else
                exit("修改失败！");
        }
        else
        {
            $id = $objInvoiceIsseuBLL->insert($objInvoiceIsseuInfo);
            if($id > 0)
                exit("seccess,".$id);
            else
                exit("添加失败！");
        }        
    }
    
    /**
     * @functional 发票申请明细
     */
    public function InvoiceDetail()
    {
        $this->PageRightValidate("InvoiceList",Rightvalue::view);
        
        $id = Utility::GetFormInt("id",$_GET);
        if($id <= 0)
            exit("未找到单据！");
                    
        $this->smarty->assign('strTitle','发票申请信息');
        //是否有一般纳税人资质     
        $permitPath = $this->GetPermitPath();          
        $this->smarty->assign('permitPath',$permitPath); 
        
        //代理商名称
        $agentName = $this->getAgentName();
        $this->smarty->assign('agentName',$agentName);
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $arrayInvoice = $objInvoiceIsseuBLL->GetInvoiceIsseuInfo($id,$this->getAgentId());
        if(!(isset($arrayInvoice)&&count($arrayInvoice)>0))
            exit("未找到单据！");
            
        $this->smarty->assign('arrayInvoice',$arrayInvoice);
                   
        $this->smarty->display('FM/Front/InvoiceDetail.tpl');
    }
    
    /**
     * @functional 申请金额是否超出可申请的验证
     */
    public function CanApplyMoney()
    {    
        $price = 0;
        $productTypeID = Utility::GetFormInt('productType',$_POST);        
        if($productTypeID > 0)
        {                
            $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
            $price = $objInvoiceIsseuBLL->CanApplyMoney($this->getAgentId(),$productTypeID);
        }
        
        exit($price."");
    }
    
    public function AgentCustomerUnitCost()
    {
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $arrayData = $objInvoiceIsseuBLL->AgentCustomerUnitCost(date("Y-m-d",time()));
        
        //print_r($arrayData);
        //var_dump($arrayData);
    }
    
    
    /**
     * @functional 发票记录列表
     */
    public function InvoiceList()
    {
        $this->PageRightValidate("InvoiceList",Rightvalue::view);        
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $strNoticeHTML = "";
        $arrayData = $objInvoiceIsseuBLL->ListNotice($this->getAgentId());
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength ;$i++)
            {                
                $strNoticeHTML .= "<span class='ui_link'>".$arrayData[$i]["product_type_name"]
                ."：(<em id='emPostAmount'>".Utility::FormatMoney($arrayData[$i]["can_apply_money"])."</em>)</span>";
            }
        }
        
        $this->smarty->assign('strNoticeHTML',$strNoticeHTML);
        
        $this->smarty->assign('InvoiceListBody',"/?d=FM&c=Invoice&a=InvoiceListBody");
        $this->smarty->display('FM/Front/InvoiceList.tpl');
    }


     /**
     * @functional 发票记录列表数据
     */
    public function InvoiceListBody()
    {
        $this->ExitWhenNoRight("InvoiceList",Rightvalue::view);
        $sWhere = " and `fm_invoice_isseu`.agent_id = ".$this->getAgentId()." and fm_invoice_isseu.f_type = ".InvoiceTypes::Invoice;  
        
        $iProductTypeID = Utility::GetFormInt("cbProductType",$_GET);        
        if($iProductTypeID != -100)
            $sWhere .= " and `fm_invoice_isseu`.c_product_id =".$iProductTypeID;
                    
        $iInvoiceTypeID = Utility::GetFormInt("cbInvoiceType",$_GET);
        if($iInvoiceTypeID != -100)
            $sWhere .= " and `fm_invoice_isseu`.f_invoice_type =".$iInvoiceTypeID;
        
        $iInvoiceStateID = Utility::GetFormInt("cbInvoiceState",$_GET);
        if($iInvoiceStateID != -100)
            $sWhere .= " and `fm_invoice_isseu`.f_invoice_state =".$iInvoiceStateID;
                                     
        $postSDate = Utility::GetForm("tbxOptSDate",$_GET);
        if($postSDate != "")
            $sWhere .= " and `fm_invoice_isseu`.f_opentime >= '".$postSDate."'";             
            
        $postEDate = Utility::GetForm("tbxOptEDate",$_GET);
        if($postEDate != "")
            $sWhere .= " and `fm_invoice_isseu`.f_opentime < date_add('".$postEDate."',interval 1 day)";    
               
        $strInvoiceNo = Utility::GetForm("tbxInvoiceNo",$_GET);
        if($strInvoiceNo != "")
            $sWhere .= " and `fm_invoice_isseu`.fii_no like '%".$strInvoiceNo."%'";
            
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $arrPageList = $this->getPageList($objInvoiceIsseuBLL,"*",$sWhere,"",$iPageSize);

        $this->smarty->assign('arrayInvoice',$arrPageList['list']);
        $this->smarty->display('FM/Front/InvoiceListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
        
    }

    /**
     * @functional 开票明细列表数据
     */
    public function MakeInvoiceList()
    {
        $this->PageRightValidate("MakeInvoiceList",Rightvalue::view);    
        
        $strInvoiceVerNo = Utility::GetForm("strInvoiceVerNo",$_GET);
        $this->smarty->assign('strInvoiceVerNo',$strInvoiceVerNo);
        $this->smarty->assign('MakeInvoiceListBody',"/?d=FM&c=Invoice&a=MakeInvoiceListBody");
        $this->smarty->display('FM/Front/MakeInvoiceList.tpl');
        
    }
    
    /**
     * @functional 开票明细列表数据
     */
    public function MakeInvoiceListBody()
    {
        $this->ExitWhenNoRight("MakeInvoiceList",Rightvalue::view);
        
        $sWhere = " and `fm_invoice_isseu`.agent_id = ".$this->getAgentId()
        ." and fm_invoice_isseu.f_type = ".InvoiceTypes::Invoice." and `fm_invoice_isseu`.f_invoice_state <> ".InvoiceStates::NotOpen;  
        
        $iProductTypeID = Utility::GetFormInt("cbProductType",$_GET);        
        if($iProductTypeID != -100)
            $sWhere .= " and `fm_invoice_isseu`.c_product_id =".$iProductTypeID;
                    
        $iInvoiceTypeID = Utility::GetFormInt("cbInvoiceType",$_GET);
        if($iInvoiceTypeID != -100)
            $sWhere .= " and `fm_invoice_isseu`.f_invoice_type =".$iInvoiceTypeID;
        
        $iInvoiceStateID = Utility::GetFormInt("cbInvoiceState",$_GET);
        
        if($iInvoiceStateID == 0)
            $sWhere .= " and `fm_invoice_isseu`.f_invoice_state < ".InvoiceStates::NotOpen;
        else if($iInvoiceStateID == 1)
            $sWhere .= " and `fm_invoice_isseu`.f_invoice_state > ".InvoiceStates::NotOpen ;
            
        $strInvoiceNo = Utility::GetForm("tbxInvoiceNo",$_GET);
        if($strInvoiceNo != "")
            $sWhere .= " and `fm_invoice_bill`.`invoice_no` like '%".$strInvoiceNo."%'";
       
        $strInvoiceVerNo = Utility::GetForm("tbxInvoiceVerNo",$_GET);
        if($strInvoiceVerNo != "")
            $sWhere .= " and `fm_invoice_isseu`.`fii_no` like '%".$strInvoiceVerNo."%'";
       
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
                
        $objInvoiceBillBLL = new InvoiceBillBLL();
        $arrPageList = $this->getPageList($objInvoiceBillBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign('arrayInvoice',$arrPageList['list']);
        $this->smarty->display('FM/Front/MakeInvoiceListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
        
    /**
     * @functional 发票确认
    */
    public function InvoiceConfirm()
    {
        $this->ExitWhenNoRight("MakeInvoiceList",RightValue::check);
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("参数有误！");
        
        $objInvoiceBillBLL = new InvoiceBillBLL();
        $objInvoiceInfo = $objInvoiceBillBLL->getModelByID($id,$this->getAgentId());       
        if($objInvoiceInfo != null)         
            $objInvoiceInfo->iInvoiceMoney = Utility::FormatMoney($objInvoiceInfo->iInvoiceMoney);
        
        $this->smarty->assign('objInvoiceInfo',$objInvoiceInfo);
        $this->displayPage('FM/Front/InvoiceConfirm.tpl'); 
    }
    
    /**
     * @functional 发票确认
    */
    public function InvoiceConfirmSubmit()
    {
        $this->ExitWhenNoRight("MakeInvoiceList",RightValue::check);
               
        $id = Utility::GetFormInt('id',$_POST);//发票ID
        $receipted = Utility::GetForm('confirmResult',$_POST);
        
        if($id <= 0)
            $this->ExitByError("参数有误！");
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $strUserName = $this->getUserName()." ".$this->getUserCNName();
        $updateCount = $objInvoiceIsseuBLL->ReceiptConfirm($id,$this->getAgentId(),$this->getUserId(),$strUserName,$receipted == "true"? 1:0);
        if($updateCount > 0)
        {
            $this->ExitBySuccess("确认成功！");
        }
        
        $this->ExitByError("确认失败！");
    }
    
     
    /**
     * @functional 开票明细列表数据
     */
    public function Test_OPenInvoice()
    {
        $id = Utility::GetFormInt("id",$_POST);
        if($id <= 0)
            exit("未找到单据！");
            
        $money = Utility::GetFormDouble("money",$_POST);
        $openTime = Utility::Now();
        $strInvoiceNums = time()."";
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        
        $isSeccess = $objInvoiceIsseuBLL->OpenInvoice($id,2,$this->getUserId(),$this->getUserName(),2,0,
           array($this->getUserId()),array($this->getUserName()),array($openTime),array(1),
           array($strInvoiceNums),array($this->getAgentName()),array($money),array("no remark"));
           
        if($isSeccess)
            exit("单个开票成功");
        
        exit("单个开票失败");
    }
    
     
    /**
     * @functional 开票明细列表数据
     */
    public function Test_OPenInvoices()
    {
        $ids = Utility::GetForm("ids",$_POST);
        $money = Utility::GetFormDouble("money",$_POST);
        
        if($ids == "")
            exit("未找到单据！");
            
        $openTime = Utility::Now();
        $strInvoiceNums = time()."";
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        
        $isSeccess = $objInvoiceIsseuBLL->OpenInvoices($ids,$this->getUserId(),$this->getUserName(),$openTime,1,
        $strInvoiceNums,$this->getAgentName(),$money,2,"no remark",0);        
        
        if($isSeccess)
            exit("多个开票成功");
        
        exit("多个开票失败");
    }
}
?>