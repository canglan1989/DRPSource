<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：赠送产品订单
 * 创建人：wzx
 * 添加时间：2012-4-23 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/OrderBLL.php';
require_once __DIR__ . '/../../Class/BLL/OrderGiftSetBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerBLL.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/AgContactBLL.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderWebsiteBLL.php';


class GiftOrderAction extends ActionBase
{
    public function __construct()
    {
    }
     
     
    public function Index()
    {
        $this->MyGiftOrderList();
    }
    
    
    public function GiftOrderModify()
    {        
        $this->PageRightValidate("GiftOrderModify",RightValue::add);      
        $id = Utility::GetFormInt('id',$_GET);
        $strTitle = "";
        $objOrder = null;        
        $objSourceOrderProductInfo = null;
        if($id <= 0)
        {  
            $strTitle = '添加订单';    
            $objOrder = new OrderInfo();   
        }
        else
        {
            $strTitle ='修改订单';   
            $objOrderBLL = new OrderBLL();            
            $objOrder = $objOrderBLL->getModelByID($id,$this->getAgentId());  
            if($objOrder == null)
                exit("未找到此订单！");  
            
            $objSourceOrderProductInfo = $objOrderBLL->GetOrderProductInfo($objOrder->iSourceOrderId);
            $objOrder->strOrderRemark = str_replace(array("<BR/><BR/>","<BR/>", "<br/>"),"\r",$objOrder->strOrderRemark);
            
        }
        
        $this->smarty->assign('strTitle',$strTitle); 
        $this->smarty->assign('objSourceOrderProductInfo',$objSourceOrderProductInfo);
        $this->smarty->assign('objOrder',$objOrder);
        $this->displayPage('OM/GiftProduct/GiftOrderModify.tpl');
    }
    
    
    /**
     * @functional 取得可赠送的产品
    */
    public function UpdateGiftSelect()
    {        
        $order_product_type_id = Utility::GetFormInt('order_product_type_id',$_POST);
        if($order_product_type_id <= 0)
            exit("[]".$order_product_type_id);
        
        $strGiftProductJson = "";
        $objOrderGiftSetBLL = new OrderGiftSetBLL();
        $arrayGiftProduct = $objOrderGiftSetBLL->GetGiftProductType($this->getAgentId(),$order_product_type_id);
        foreach($arrayGiftProduct as $key => $value)
        {
            $strGiftProductJson .= "{'value':'".$value["gift_product_id"]."','text':'".$value["gift_product_name"]."'},";
        }
        
        if (strlen($strGiftProductJson) > 0)
            $strGiftProductJson = substr($strGiftProductJson, 0, strlen($strGiftProductJson) - 1);
            
        $strGiftProductJson = "[{$strGiftProductJson}]";
        
        exit($strGiftProductJson);
    }
     
    /**
     * @functional 取得可赠送产品的订单
    */
    public function AutoOrderJson()
    {        
        $text = Utility::GetForm('q',$_GET);
            
        $objOrderBLL = new OrderBLL();
        $strJson = $objOrderBLL->AutoOrderJson($text,$this->getAgentId(),$this->getFinanceUid());
        exit($strJson);
    }
    
    /**
     * @functional 返回订单信息
    */
    public function GetOrderInfoJson()
    {        
        $orderID = Utility::GetFormInt('orderID',$_POST);
        $strJson = "{}";
        $objOrderBLL = new OrderBLL();
        $arrayData = $objOrderBLL->select("*,
            date_format(om_order.order_sdate,'%Y-%m-%d') as ordersdate,date_format(om_order.order_edate,'%Y-%m-%d') as orderedate","order_id=$orderID and agent_id=".$this->getAgentId(),"");
        if(isset($arrayData) && count($arrayData) > 0)
            $strJson = json_encode($arrayData[0]);
            
        exit($strJson);
    }
    
    public function GiftOrderModifySubmit()
    {
        $this->ExitWhenNoRight("GiftOrderModify",RightValue::add);              
        $id = Utility::GetFormInt('tbxID',$_POST);
        $iSourceOrderID = Utility::GetFormInt('tbxSourceOrderID',$_POST);
        if($iSourceOrderID <= 0)
            exit("请输入购买产品订单！");
            
        $iGiftProductID = Utility::GetFormInt('cbGiftProduct',$_POST);
        if($iGiftProductID <= 0)
            exit("请选择赠送产品！");
            
        $strWebSite = Utility::GetForm('tbxWebSite',$_POST,128);
        if($strWebSite == "")
           exit("请输入客户网站域名！");
            
        $contactName = Utility::GetForm('tbxContactName',$_POST,10);
        if($contactName == "")
           exit("请输入客户联系人名称！");

        $contact_mobile = Utility::GetForm('contact_mobile',$_POST,20);
        $contact_tel = Utility::GetForm('contact_tel',$_POST,20);
        if($contact_mobile == "" && $contact_tel == "")
           exit("手机和电话必填一项！");
            
        
        $objProductBLL = new ProductBLL();
        $arrayGiftProduct = $objProductBLL->select("*,(select product_type_no from sys_product_type where sys_product_type.aid = 
        sys_product.product_type_id) as product_type_no","product_id=$iGiftProductID and is_gift=1");
        if(!(isset($arrayGiftProduct) && count($arrayGiftProduct) > 0))
            exit("未找到赠送产品数据信息！");
        
        //订单产品重复赠送的判断
        $objOrderBLL = new OrderBLL();
        $objSourceOrderInfo = $objOrderBLL->getModelByID($iSourceOrderID,$this->getAgentId());
        if($objSourceOrderInfo == null)
            exit("未找到购买订单信息！");
         
        if($objSourceOrderInfo->strEffectSdate != $objSourceOrderInfo->strEffectSdate &&         
            Utility::compareSEDate($objSourceOrderInfo->strEffectSdate,Utility::Now()) < 0 )  //Utility::compareSEDate($objSourceOrderInfo->strEffectSdate , "2000-01-01") != 0 && 
        {
            exit("该订单已经失效！");
        }
        
        //网营专家 以客户为单位，一个客户在订单的有效期内只能赠送一次网营专家； 
        $sWhere = " agent_id=".$this->getAgentId()." and order_type=".CustomerOrderTypes::gift." and product_id = ".$iGiftProductID
        ." and source_order_id > 0 and order_id <> $id ";
        if($arrayGiftProduct[0]["product_type_no"] == ProductTypes::wyzj)
        {            
            $sWhere .= " and customer_id = ".$objSourceOrderInfo->iCustomerId;
            $arrayData = $objOrderBLL->select("order_id",$sWhere);
            if(isset($arrayData) && count($arrayData) > 0)
                exit("网营专家 以客户为单位，一个客户在订单的有效期内只能赠送一次网营专家");
        }
        else if($arrayGiftProduct[0]["product_type_no"] == ProductTypes::link)
        {
            //LINK 以域名为单位，在订单的有效期内，一个域名只可以赠送一次LINK。
            $sWhere .= " and owner_domain_url = '{$strWebSite}' ";
            $arrayData = $objOrderBLL->select("order_id",$sWhere);
            if(isset($arrayData) && count($arrayData) > 0)
                exit("LINK 以域名为单位，在订单的有效期内，一个域名只可以赠送一次LINK");
        }
        
        //添加或修改订单信息
        $objOrderInfo = new OrderInfo();
        if($id > 0)
        {
            $objOrderInfo = $objOrderBLL->getModelByID($id,$this->getAgentId());
            if($objOrderInfo == null)
                exit("订单修改失败，未找到原订单！");
                
            if($objOrderInfo->iCheckStatus != CheckStatus::notPost && $objOrderInfo->iCheckStatus != CheckStatus::notPass)
            {
                exit("该订单已不能再被编辑！");
            }
        }
        
        //客户负责人信息
        $objAgContactBLL = new AgContactBLL();
        $objAgContactInfo = $objAgContactBLL->GetManagerByCustomerID($objSourceOrderInfo->iCustomerId);
        if($objAgContactInfo == null)
            $objAgContactInfo = new AgContactInfo();
            
        $objAgContactInfo->strContactName = $contactName;
        $objAgContactInfo->strContactMobile = $contact_mobile;
        $objAgContactInfo->strContactTel = $contact_tel;
        $objAgContactInfo->strContactFax = Utility::GetForm('contact_fax',$_POST,20);
        $objAgContactInfo->strContactEmail = Utility::GetForm('contact_email',$_POST,60);
            
        if($objAgContactInfo->iContactId > 0)
        {
            $objAgContactInfo->iUpdateUid = $this->getUserId();
            $objAgContactBLL->updateByID($objAgContactInfo);            
        }
        else
        {
            $objAgContactInfo->iContactSex = 1;
            $objAgContactInfo->iIscharge = 1;
            $objAgContactInfo->iCustomerId = $objSourceOrderInfo->iCustomerId;
            $objAgContactInfo->iCreateUid = $this->getUserId();
            $objAgContactBLL->insert($objAgContactInfo);
        }
                
        if($id > 0)
        {
    	    $objOrderInfo->iUpdateUid = $this->getUserId();
        }
        else
        {            
            $objOrderInfo = clone $objSourceOrderInfo;
            $objOrderInfo->iCreateUid = $this->getUserId(); 
            $objOrderInfo->iAlloltUid = 0;
            $objOrderInfo->strAlloltTime = '2000-01-01';
            $objOrderInfo->iAlloltAuditUid = 0;
            $objOrderInfo->strAlloltRemark = '';
            $objOrderInfo->strAlloltUserName = '';
            $objOrderInfo->strAuditUserName = '';
            
            $objOrderInfo->iActPrice = 0;        
            $objOrderInfo->iIsCharge = 1;
            $objOrderInfo->iOwnerId = 0;
            $objOrderInfo->strOwnerAccountName = '';
            $objOrderInfo->strOwnerLoginPwd = '';
            $objOrderInfo->strOwnerWebsiteName = '';
        }
        
        ///添加或修改订单信息        在编辑时 订单或者赠品会改
        $objOrderInfo->strOrderNo = $objOrderBLL->getNewGiftOrderNo($objSourceOrderInfo->iOrderId,$arrayGiftProduct[0]["product_no"],$id);
        
        $objOrderInfo->iOrderType = CustomerOrderTypes::gift;
    	$objOrderInfo->iAgentId = $this->getAgentId();
        $objOrderInfo->strAgentNo = $this->getAgentNo();
    	$objOrderInfo->strAgentName = $this->getAgentName();
    	$objOrderInfo->iProductId = $arrayGiftProduct[0]["product_id"];
        $objOrderInfo->iProductTypeId = $arrayGiftProduct[0]["product_type_id"];
        $objOrderInfo->iSourceOrderId = $objSourceOrderInfo->iOrderId;
        $objOrderInfo->strSourceOrderNo = $objSourceOrderInfo->strOrderNo;
        
        $strRemark = Utility::GetRemarkForm('tbxRemark',$_POST,256);    
        $objOrderInfo->iFinanceUid = $this->getFinanceUid();
        $objOrderInfo->strFinanceNo = $this->getFinanceNo();
    	$objOrderInfo->strContactName = $contactName;
    	$objOrderInfo->strContactMobile = $contact_mobile;
    	$objOrderInfo->strContactTel = $contact_tel;
    	$objOrderInfo->strContactFax = Utility::GetForm("contact_fax",$_POST,20);
    	$objOrderInfo->strContactEmail = Utility::GetForm("contact_email",$_POST,64);
        
    	$objOrderInfo->strOrderRemark = $strRemark;
        
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objOrderInfo->iAccountGroupId = $objAccountGroupUserBLL->getGroupIdByAgentId($this->getAgentId());///区域组///
            
        $postCheck = Utility::GetFormInt("tbxPost",$_POST);                
        if($postCheck == 1)
        {            
       	    $objOrderInfo->iPostUid = $this->getUserId(); 
             
        	$objOrderInfo->iCheckStatus = CheckStatus::auditting;                
            $objOrderInfo->iOrderStatus = OrderStatus::auditting;     
            $objOrderInfo->strOrderStatusText = OrderStatus::GetText($objOrderInfo->iOrderStatus);
        }
        else
        {
        	if($id <= 0)
            {
                $objOrderInfo->iCheckStatus = CheckStatus::notPost;
                $objOrderInfo->iOrderStatus = OrderStatus::notPost;     
                $objOrderInfo->strOrderStatusText = OrderStatus::GetText($objOrderInfo->iOrderStatus);                
            }
                
        	$objOrderInfo->iPostUid = 0;          
        }
        
       	$objOrderInfo->strPostDate = Utility::Now();         
        $objOrderInfo->strOwnerDomainUrl = $strWebSite;

    	$objOrderInfo->iIsDel = 0;
          
        $objOrderWebsiteBLL = new OrderWebsiteBLL();  
        if($id > 0)
        {
            if($objOrderBLL->updateByID($objOrderInfo) <= 0)                
                exit("修改失败！");
            $objOrderWebsiteBLL->DeleteByOrderID($id);
        }
        else
        {
            $id = $objOrderBLL->insert($objOrderInfo);
            if($id <= 0)   
                exit("添加失败！");
        }
        
        //帐户开通的时候 网站 地址 查的是这张表
        $objOrderWebsiteBLL->insertData($id,"",$strWebSite);
                
        exit("0,".$id);
    }
    
    
    public function MyGiftOrderList()
    {        
        $this->PageRightValidate("MyGiftOrderList",RightValue::view);
        
        $this->smarty->assign('myOrderListBody',"/?d=OM&c=GiftOrder&a=MyGiftOrderListBody"); 
        $this->displayPage('OM/GiftProduct/MyOrderList.tpl');
    }
        
    
    public function MyGiftOrderListBody()
    {        
        $this->PageRightValidate("MyGiftOrderList",RightValue::view);
        
        $sWhere = " and om_order.agent_id=".$this->getAgentId()." and om_order.finance_uid=".$this->getFinanceUid()." and `om_order`.order_type = ".CustomerOrderTypes::gift;//." and `cm_customer_agent`.user_id=".$this->getUserId();
        
        $iProductID = Utility::GetFormInt("cbProduct",$_GET);
        if($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=".$iProductID;
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType",$_GET);
            if($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=".$productTypeID;             
        }
               
       $iOrderState = Utility::GetFormInt("cbAuditState",$_GET);
        if($iOrderState != -100)
        {
            if($iOrderState > CheckStatus::isPass)
            {                
                $sWhere .= " and `om_order`.order_status = ".$iOrderState;
            }
            else
                $sWhere .= " and `om_order`.check_status =".$iOrderState;
        }
        
        $iIsNotEffect = Utility::GetFormInt("cbIsNotEffect",$_GET);                    
        if($iIsNotEffect == 1)//已失效
        {
            $sWhere .= " and `om_order`.effect_sdate<>`om_order`.effect_edate and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate <'".Utility::Today()."'";
        }   
        else if($iIsNotEffect == 0)//未失效
        {
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and (`om_order`.effect_edate >='".Utility::Today()."' or `om_order`.effect_sdate =`om_order`.effect_edate) ";
        }         
                         
        $postSDate = Utility::GetForm("tbxPostSDate",$_GET);
        if($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '".$postSDate."'";             
            
        $postEDate = Utility::GetForm("tbxPostEDate",$_GET);
        if($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('".$postEDate."',interval 1 day)";    
            
        $strOrderNo = Utility::GetForm("tbxOrderNo",$_GET);
        if($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%".$strOrderNo."%'";
            
        $strCustomerName = Utility::GetForm("tbxCustomerName",$_GET);
        if($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%".$strCustomerName."%'";               
               
        $strPostUserName = Utility::GetForm("tbxPostUserName",$_GET);
        if($strPostUserName != "")
            $sWhere .= " and (`sys_user`.user_name like '%".$strPostUserName."%' or `sys_user`.e_name like '%".$strPostUserName."%')";               
                              
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //print_r($sWhere);
        
        $objOrderBLL = new OrderBLL();
        $arrPageList = $this->getPageList($objOrderBLL,"*",$sWhere,"",$iPageSize);
        CustomerOrderTypes::ReplaceArrayText($arrPageList['list'],"order_type");
        $this->smarty->assign('arrayOrder',$arrPageList['list']);
        $this->displayPage('OM/GiftProduct/MyOrderListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
    
    /**
     * @functional 客户订单列表
    */
    public function GiftOrderList()
    {
        $this->PageRightValidate("GiftOrderList",RightValue::view);
        
        $this->smarty->assign('GiftOrderListBody',"/?d=OM&c=GiftOrder&a=GiftOrderListBody"); 
        $this->displayPage('OM/GiftProduct/GiftOrderList.tpl');
    }
     
    /**
     * @functional 客户订单列表数据内容
    */
    public function GiftOrderListBody()
    {
        $this->ExitWhenNoRight("GiftOrderList",RightValue::view);
        $sWhere = " and om_order.agent_id=".$this->getAgentId()." and om_order.finance_uid=".$this->getFinanceUid()." and `om_order`.order_type = ".CustomerOrderTypes::gift." and `om_order`.check_status >".CheckStatus::notPost ;  
        
        $iProductID = Utility::GetFormInt("cbProduct",$_GET);
        if($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=".$iProductID;
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType",$_GET);
            if($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=".$productTypeID;             
        }
               
       $iOrderState = Utility::GetFormInt("cbAuditState",$_GET);
        if($iOrderState != -100)
        {
            if($iOrderState > CheckStatus::isPass)
            {                
                $sWhere .= " and `om_order`.order_status = ".$iOrderState;
            }
            else
                $sWhere .= " and `om_order`.check_status =".$iOrderState;
        }
                   
        $iIsNotEffect = Utility::GetFormInt("cbIsNotEffect",$_GET);
        if($iIsNotEffect == 1)//已失效
        {
            $sWhere .= " and `om_order`.effect_sdate<>`om_order`.effect_edate and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate <'".Utility::Today()."'";
        }   
        else if($iIsNotEffect == 0)//未失效
        {
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and (`om_order`.effect_edate >='".Utility::Today()."' or `om_order`.effect_sdate =`om_order`.effect_edate) ";
        }        
            
        $postSDate = Utility::GetForm("tbxPostSDate",$_GET);
        if($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '".$postSDate."'";             
            
        $postEDate = Utility::GetForm("tbxPostEDate",$_GET);
        if($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('".$postEDate."',interval 1 day)";    
                      
        $strOrderNo = Utility::GetForm("tbxOrderNo",$_GET);
        if($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%".$strOrderNo."%'";
            
        $strCustomerName = Utility::GetForm("tbxCustomerName",$_GET);
        if($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%".$strCustomerName."%'";               
               
        $strPostUser= Utility::GetForm("tbxPostUserName",$_GET);
        if($strPostUser != "")
            $sWhere .= " and (`sys_user`.user_name like '%".$strPostUser."%' or `sys_user`.e_name like '%".$strPostUser."%')";
                        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);
        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);
        
        $objOrderBLL = new OrderBLL();
        $arrPageList = $this->getPageList($objOrderBLL,"*",$sWhere,"",$iPageSize);
        $arrayData = &$arrPageList['list'];
        
        CustomerOrderTypes::ReplaceArrayText($arrPageList['list'],"order_type");
        $this->smarty->assign('arrayOrder',$arrPageList['list']);
        
        $this->smarty->display('OM/GiftProduct/GiftOrderListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    
    }
        
    
    /**
     * @functional 客户订单列表
     */
    public function Back_GiftOrderList()
    {
        $this->PageRightValidate("Back_GiftOrderList", RightValue::view);
        $this->smarty->assign('GiftOrderListBody', "/?d=OM&c=GiftOrder&a=Back_GiftOrderListBody");
        $this->displayPage('OM/GiftProduct/Back_GiftOrderList.tpl');
    }

    /**
     * @functional 客户订单列表数据内容
     */
    public function Back_GiftOrderListBody()
    {
        $this->ExitWhenNoRight("Back_GiftOrderList", RightValue::view);        
        $sWhere = " and `om_order`.check_status >" . CheckStatus::notPost . " and `om_order`.order_type =".CustomerOrderTypes::gift;
        
        $iProductID = Utility::GetFormInt("cbProduct", $_GET);
        if ($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=" . $iProductID;
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType", $_GET);
            if ($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=" . $productTypeID;
        }

        $iOrderState = Utility::GetFormInt("cbAuditState", $_GET);
        if ($iOrderState != -100)
        {
            if ($iOrderState > CheckStatus::isPass)
            {
                $sWhere .= " and `om_order`.order_status = " . $iOrderState;
            }
            else
                $sWhere .= " and `om_order`.check_status =" . $iOrderState;
        }

        $iIsNotEffect = Utility::GetFormInt("cbIsNotEffect", $_GET,-100);
        
        if($iIsNotEffect == 1)//已失效
        {
            $sWhere .= " and `om_order`.effect_sdate<>`om_order`.effect_edate and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate <'".Utility::Today()."'";
        }   
        else if($iIsNotEffect == 0)//未失效
        {
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and (`om_order`.effect_edate >='".Utility::Today()."' or `om_order`.effect_sdate = `om_order`.effect_edate) ";
        }        
            
        $iAllotState = Utility::GetFormInt("cbAllotState", $_GET);

        $postSDate = Utility::GetForm("tbxPostSDate", $_GET);
        if ($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '" . $postSDate . "'";

        $postEDate = Utility::GetForm("tbxPostEDate", $_GET);
        if ($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('" . $postEDate . "',interval 1 day)";

        $strOrderNo = Utility::GetForm("tbxOrderNo", $_GET);
        if ($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%" . $strOrderNo . "%'";

        $strAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($strAgentName != "")
            $sWhere .= " and `om_order`.agent_name like '%" . $strAgentName . "%'";

        $strCustomerName = Utility::GetForm("tbxCustomerName", $_GET);
        if ($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%" . $strCustomerName . "%'";

        $strPostUser = Utility::GetForm("tbxPostUserName", $_GET);
        if ($strPostUser != "")
            $sWhere .= " and (`sys_user`.user_name like '%" . $strPostUser . "%' or `sys_user`.e_name like '%" . $strPostUser . "%')";
        
        $strSourceOrderNo = Utility::GetForm("tbxSourceOrderNo", $_GET);
        if(!empty ($strSourceOrderNo))
            $sWhere .= " and om_order.source_order_no like '%{$strSourceOrderNo}%' ";

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);

        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);
        $objOrderBLL = new OrderBLL();
        
        $arrPageList = $this->getPageList($objOrderBLL, "*", $sWhere, "", $iPageSize);

        CustomerOrderTypes::ReplaceArrayText($arrPageList['list'], "order_type");
        $this->smarty->assign('arrayOrder', $arrPageList['list']);
                
        $this->smarty->display('OM/GiftProduct/Back_GiftOrderListBody.tpl');
        
        echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
    }

    
}