<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：收据记录模块
 * 创建人：wzx
 * 添加时间：2011-8-25 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/ReceiptBLL.php';
require_once __DIR__.'/../../Class/BLL/InvoiceIsseuBLL.php';


class ReceiptAction extends ActionBase
{
    public function __construct()
    {
    }
     
    /**
     * @functional 收据列表数据
     */
    public function ReceiptList()
    {
        $this->PageRightValidate("ReceiptList",Rightvalue::view);        
        
        $this->smarty->assign('ReceiptListBody',"/?d=FM&c=Receipt&a=ReceiptListBody");
        $this->smarty->display('FM/Front/ReceiptList.tpl');        
    }
    
    /**
     * @functional 收据列表数据
     */
    public function ReceiptListBody()
    {
        $this->ExitWhenNoRight("ReceiptList",Rightvalue::view);
        $sWhere = " and `fm_receivable_pay`.`fr_object_id` = ".$this->getAgentId()
        ." and fm_invoice_isseu.f_type = ".InvoiceTypes::Receipt." and `fm_invoice_isseu`.f_invoice_state <> ".InvoiceStates::NotOpen;  
        /*
        $iProductTypeID = Utility::GetFormInt("cbProductType",$_GET);        
        if($iProductTypeID != -100)
            $sWhere .= " and `fm_receivable_pay`.c_product_id =".$iProductTypeID;
            */
        $iAccountType = Utility::GetFormInt("cbAccountType",$_GET);        
        if($iAccountType != -100)
            $sWhere .= " and fm_receivable_pay.fr_type = ".$iAccountType;
            
        $iReceiptState = Utility::GetFormInt("cbReceiptState",$_GET);
        if($iReceiptState == 0)
            $sWhere .= " and if(`fm_invoice_isseu`.f_invoice_state,`fm_invoice_isseu`.f_invoice_state,".InvoiceStates::NotOpen.") <= ".InvoiceStates::NotOpen;
        else if($iReceiptState == 1)
            $sWhere .= " and if(`fm_invoice_isseu`.f_invoice_state,`fm_invoice_isseu`.f_invoice_state,".InvoiceStates::NotOpen.") > ".InvoiceStates::NotOpen;
            
        $postSDate = Utility::GetForm("tbxOptSDate",$_GET);
        $postEDate = Utility::GetForm("tbxOptEDate",$_GET);
        if($postSDate."".$postEDate != "")
            $sWhere .= " and `fm_invoice_isseu`.`f_open_userid` >0 ";      
            
        if($postSDate != "")
            $sWhere .= " and `fm_invoice_isseu`.`f_opentime` >= '".$postSDate."'";             
            
        if($postEDate != "")
            $sWhere .= " and `fm_invoice_isseu`.`f_opentime` < date_add('".$postEDate."',interval 1 day)";        
            
        $strInvoiceNo = Utility::GetForm("tbxInvoiceNo",$_GET);
        if($strInvoiceNo != "")
            $sWhere .= " and `fm_invoice_bill`.`invoice_no` like '%".$strInvoiceNo."%'";
       
        $strPactNo = Utility::GetForm("tbxPactNo",$_GET);
        if($strPactNo != "")
            $sWhere .= " and `fm_receivable_pay`.`fr_no` like '%".$strPactNo."%'";
       
        $strInvoiceHead = Utility::GetForm("tbxInvoiceHead",$_GET);
        if($strInvoiceHead != "")
            $sWhere .= " and `fm_invoice_isseu`.`f_invoice_title` like '%".$strInvoiceHead."%'";
                    
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
                        
        $objReceiptBLL = new ReceiptBLL();
        $arrPageList = $this->getPageList($objReceiptBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign('arrayInvoice',$arrPageList['list']);
        $this->smarty->display('FM/Front/ReceiptListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
    /**
     * @functional 收据确认
    */
    public function ReceiptConfirm()
    {
        $this->ExitWhenNoRight("ReceiptList",RightValue::check);
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("参数有误！");
        /*
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $objInvoiceIsseuInfo = $objInvoiceIsseuBLL->getModelByID($id,$this->getAgentId());
        
        if($objInvoiceIsseuInfo != null)
            $objInvoiceIsseuInfo->ifInvoiceMoney = Utility::FormatMoney($objInvoiceIsseuInfo->ifInvoiceMoney);
        
        $this->smarty->assign('objInvoiceIsseuInfo',$objInvoiceIsseuInfo);*/
        
        $objInvoiceBillBLL = new InvoiceBillBLL();
        $objInvoiceBillInfo = $objInvoiceBillBLL->getModelByID($id,$this->getAgentId());
        if($objInvoiceBillInfo == null)
            exit("查询数据出错！");
            
        if($objInvoiceBillInfo != null)
            $objInvoiceBillInfo->iInvoiceMoney = Utility::FormatMoney($objInvoiceBillInfo->iInvoiceMoney);
            
        $this->smarty->assign('objInvoiceBillInfo',$objInvoiceBillInfo);
        
        $this->displayPage('FM/Front/ReceiptConfirm.tpl'); 
    }
    
    /**
     * @functional 收据确认
    */
    public function ReceiptConfirmSubmit()
    {
        $this->ExitWhenNoRight("ReceiptList",RightValue::check);
        $returnData = array("success"=>false,"msg"=>"");
        
        $id = Utility::GetFormInt('id',$_POST);
        $receipted = Utility::GetForm('confirmResult',$_POST);
        
        if($id <= 0)
        {
            $returnData["msg"] = "参数有误！";
            exit(json_encode($returnData));
        }
        
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $strUserName = $this->getUserName()." ".$this->getUserCNName();
        if($objInvoiceIsseuBLL->ReceiptConfirm($id,$this->getAgentId(),$this->getUserId(),$strUserName,$receipted == "true"? 1:0) > 0)
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
    
    public function Test_OpenReceipt()
    {
        $ids = Utility::GetForm('ids',$_POST);
        if($ids == "")
            exit("ID都没有！");
        $money = Utility::GetFormDouble('money',$_POST);
        $objInvoiceIsseuBLL = new InvoiceIsseuBLL();
        $openTime = date("Y-m-d H:i:s",time());
        $no = time()."";
        
        $iReceiptID = $objInvoiceIsseuBLL->OpenReceipt($ids,$this->getUserId(),$this->getUserName(),$openTime,
        1,$no,$this->getAgentName(),$money,2,"remark",0);
        
        exit($iReceiptID."");
    }
}
?>