<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：客户订单模块
 * 创建人：wzx
 * 添加时间：2011-8-9 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/AuditAction.php';
require_once __DIR__.'/../../Class/BLL/OrderBLL.php';
require_once __DIR__.'/../../Class/BLL/UnitOrderBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerPermitBLL.php';
require_once __DIR__.'/../../Class/BLL/AreaBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderWebsiteBLL.php';
require_once __DIR__.'/../../Class/BLL/AgContactBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerUserBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderRechargeBLL.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerExBLL.php';
require_once __DIR__.'/../../Class/BLL/DataConfigBLL.php';
require_once __DIR__ . '/../Common/ShowImage.php';

class OrderAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->MyOrderList();
    }
        
    /**
     * @functional 增值产品订单库
    */
    public function MyOrderList()
    {
        $this->PageRightValidate("MyOrderList",RightValue::view);
        
        $this->smarty->assign('myOrderListBody',"/?d=OM&c=Order&a=MyOrderListBody"); 
        $this->displayPage('OM/MyOrderList.tpl');
    }
     
    /**
     * @functional 增值产品订单库 内容
    */
    public function MyOrderListBody()
    {
        $this->ExitWhenNoRight("MyOrderList",RightValue::view);
                
        $sWhere = " and om_order.agent_id=".$this->getAgentId()." and om_order.finance_uid=".$this->getFinanceUid()." and om_order.order_type <> ".CustomerOrderTypes::gift." and `cm_customer_agent`.user_id=".$this->getUserId();
                    
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
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate <'".Utility::Today()."'";
        }   
        else if($iIsNotEffect == 0)//未失效
        {
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate >='".Utility::Today()."'";
        } 
          
        $iOrderType = Utility::GetFormInt("cbOrderType",$_GET);
        if($iOrderType != -100)
            $sWhere .= " and `om_order`.order_type =".$iOrderType;
                                    
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
        $this->smarty->display('OM/MyOrderListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
    /**
     * @functional 客户订单列表
    */
    public function ValueOrderList()
    {
        $this->PageRightValidate("ValueOrderList",RightValue::view);
        
        //$this->smarty->assign('strTitle','增值产品订单明细');
                
        $this->smarty->assign('ValueOrderListBody',"/?d=OM&c=Order&a=ValueOrderListBody"); 
        $this->displayPage('OM/ValueOrderList.tpl');
    }
     
    /**
     * @functional 客户订单列表数据内容
    */
    public function ValueOrderListBody()
    {
        $this->ExitWhenNoRight("ValueOrderList",RightValue::view);
        $sWhere = " and om_order.agent_id=".$this->getAgentId()." and om_order.finance_uid=".$this->getFinanceUid()." and `om_order`.order_type <> ".CustomerOrderTypes::gift." and `om_order`.check_status >".CheckStatus::notPost ;  
        
        $iProductID = Utility::GetFormInt("cbProduct",$_GET);
        if($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=".$iProductID;
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType",$_GET);
            if($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=".$productTypeID;             
        }
               
        $iOrderType = Utility::GetFormInt("cbOrderType",$_GET);
        if($iOrderType != -100)
            $sWhere .= " and `om_order`.order_type =".$iOrderType;
          
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
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate <'".Utility::Today()."'";
        }   
        else if($iIsNotEffect == 0)//未失效
        {
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate >='".Utility::Today()."'";
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
        
        $this->smarty->display('OM/ValueOrderListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    
    }
    
    /**
     * @functional 网盟订单列表
    */
    public function UnitOrderList()
    {
        $this->PageRightValidate("UnitOrderList",RightValue::view);
        
        $this->smarty->assign('UnitOrderListBody',"/?d=OM&c=Order&a=UnitOrderListBody"); 
        $this->displayPage('OM/UnitOrderList.tpl');
    }
     
    /**
     * @functional 网盟订单列表
    */
    public function UnitOrderListBody()
    {
        $this->ExitWhenNoRight("UnitOrderList",RightValue::view);
        $sWhere = " and om_order.agent_id=".$this->getAgentId()." and om_order.finance_uid=".$this->getFinanceUid()." and `om_order`.check_status >".CheckStatus::notPost ;  
                       
        $iOrderType = Utility::GetFormInt("cbOrderType",$_GET);
        if($iOrderType != -100)
            $sWhere .= " and `om_order`.order_type =".$iOrderType;
          
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
        
        $objOrderBLL = new UnitOrderBLL();
        $arrPageList = $this->getPageList($objOrderBLL,"*",$sWhere,"",$iPageSize);
        $arrayData = &$arrPageList['list'];
        
        $objCustomerUserBLL = new CustomerUserBLL();
        $objOrderRechargeBLL = new OrderRechargeBLL();
        
        $iRowCount = count($arrayData);
        for($i=0;$i<$iRowCount;$i++)
        {
            $arrayData[$i]["customer_user_name"] = "";
            $arrayData[$i]["wait_in_money"] = "0";
            
            if($arrayData[$i]["check_status"] == CheckStatus::isPass)
            {
                $arrayData[$i]["customer_user_name"] = $objCustomerUserBLL->GetCustomerUserName($arrayData[$i]["order_id"]);
                $arrayData[$i]["wait_in_money"] = $objOrderRechargeBLL->GetWaitInMoney($arrayData[$i]["order_id"]);
            }
        }
        
        CustomerOrderTypes::ReplaceArrayText($arrPageList['list'],"order_type");
        $this->smarty->assign('arrayOrder',$arrPageList['list']);
        
        $this->smarty->display('OM/UnitOrderListBody.tpl');
            
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
    
    }
     
     
    /**
     * @functional 取得可签单的客户
    */
    public function AutoCustomerJson()
    {
        $text = Utility::GetForm('q',$_GET);
        $agentID = $this->getAgentId();
        if($agentID <= 0)
            exit("您的登录超时过期。");
            
        $objOrderBLL = new OrderBLL();
        $strJson = $objOrderBLL->AutoCustomerJson($text,$agentID,0,$this->getUserId());
        exit($strJson);
    }
    
    /**
     * @functional 订单提交第一步
    */
    public function OrderPostStep1()
    {        
        $this->PageRightValidate("OrderModify",RightValue::add);
        $this->smarty->assign('strTitle','添加订单'); 
              
        $this->displayPage('OM/OrderPost1.tpl');   
    }
    
    /**
     * @functional 订单提交第一步数据提交
    */
    public function OrderPost1Submit()
    {
        $this->ExitWhenNoRight("OrderModify",RightValue::add);    
        
        $iProductId = Utility::GetFormInt('cbProduct',$_POST); 
        if($iProductId <= 0)
            exit("请选择产品！"); 
                  
        $iProductTypeId = Utility::GetFormInt('cbProductType',$_POST); 
        if($iProductTypeId <= 0)
            exit("请选择产品类别！");  
            
        $iCustomerId = Utility::GetFormInt('tbxCustomerID',$_POST);
        if($iCustomerId <= 0)
            exit("请选择客户！");       
              
        exit("0,/?d=OM&c=Order&a=OrderModify");
    }
    

    /**
     * @functional 代理商产品价格
     */
    public function AgentProductPrice()
    {
        $agentID = $this->getAgentId();
        $productID = Utility::GetFormInt('productID',$_POST);
        $objAgentModelBLL = new AgentModelBLL();
        $price = $objAgentModelBLL->GetProductPrice($agentID,$productID,date('Y-m-d H:m:s',time()));
        $price = Utility::FormatMoney($price);
        exit($price);
    }
    
    /**
     * @functional 显示订单
    */
    public function OrderModify()
    {
        if (!$this->HaveRight("OrderModify", RightValue::add) &&
        !$this->HaveRight("UnitOrderModify",RightValue::add))
        {
    	    $this->smarty->assign('strTitle', '访问限制');
    	    $this->smarty->assign('strErrMsg', '对不起，您无权访问该页面！<a href="javascript:;" onclick="PageBack()">返回</a>');
    	    $this->smarty->display('Error.tpl');
    	    exit();
        }
        
        $this->smarty->assign('strTitle','添加订单');          
        $id = Utility::GetFormInt('id',$_GET);//print_r($id);exit;

        $objOrder = new OrderInfo();
        $objCustomerInfo = new CustomerInfo();
        $cityID = "-100";
        $provinceID = "-100";
        $productText = "";
        $orderTypeText = "新签";
        
        //显示域名信息
        $objOrderWebsiteBLL = new OrderWebsiteBLL();
        $arrayOrderWebsite = array();
        $strLastWebSite = "";///最近填写的站点
        $objOrderBLL = new OrderBLL();            
        if($id > 0)
        {
            $this->smarty->assign('strTitle','修改订单');   
            $objOrder = $objOrderBLL->getModelByID($id,$this->getAgentId());  
            if($objOrder == null)
                exit("未找到此订单！");  
                
            $objOrder->iActPrice = Utility::FormatMoney($objOrder->iActPrice); 
            $objOrder->strOrderRemark = str_replace(array("<BR/><BR/>","<BR/>", "<br/>"),"\r",$objOrder->strOrderRemark);
            $arrayOrderWebsite = $objOrderWebsiteBLL->SelectDataByOrderID($objOrder->iOrderId);
        }
        else
        {   
            $objOrder->strOrderSdate = Utility::Now();
            $objOrder->strOrderEdate = Utility::addMonth($objOrder->strOrderSdate,12);
            
            $objOrder->iAgentId = $this->getAgentId();            
            $objOrder->iProductId = Utility::GetFormInt('cbProduct',$_GET);
            $objOrder->iActPrice = Utility::GetForm('tbxProudctPrice',$_GET);
            $objOrder->iCustomerId = Utility::GetFormInt('tbxCustomerID',$_GET);//客户ID
            $objOrder->strCustomerName = Utility::GetForm('tbxCustomerName',$_GET);
            
            //客户资质
            $objCustomerPermitBLL = new CustomerPermitBLL();            
            $objOrder->strBusinessLicensePath = $objCustomerPermitBLL->GetBusinessLicensePath($objOrder->iCustomerId,$this->getAgentId());            
            $objOrder->strLegalPersonIdPath = $objCustomerPermitBLL->GetCorporatePhotoPath($objOrder->iCustomerId,$this->getAgentId());
            
            $arrayOrderWebSite = $objOrderBLL->selectTop("owner_domain_url","customer_id=".$objOrder->iCustomerId." and owner_id>0","create_time desc","",1);
            if(isset($arrayOrderWebSite)&&count($arrayOrderWebSite)>0)
                $strLastWebSite =$arrayOrderWebSite[0]["owner_domain_url"];///最近填写的站点
        }
        
        $this->smarty->assign('strLastWebSite',$strLastWebSite); 
        
        $objProductBLL = new ProductBLL();
        $arrayProduct = $objProductBLL->select("product_name,product_group,product_series,product_type_id","product_id=".$objOrder->iProductId);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
        {
            if($arrayProduct[0]["product_group"] == 1)
            {
                $productText = $arrayProduct[0]["product_name"];
            }
            else
                $productText = $arrayProduct[0]["product_name"].">".$arrayProduct[0]["product_series"];
                
            $objOrder->iProductTypeId = $arrayProduct[0]["product_type_id"];
        } 
        
        $LJcustomerid = $objOrder->iCustomerId;
        //显示客户信息
        $objCustomerBLL = new CustomerBLL();
        $area_id = $objCustomerBLL->getCMAreaId($LJcustomerid);//print_r($area_id[0]['area_id']);exit; 
        $selProvince1 = 0;
        $selCity1 = 0;
        $selarea1 = 0;
        $AREAID = $objCustomerBLL->getAllAREA($area_id[0]['area_id']);//print_r($AREAID);exit;
        if(count($AREAID)>0)
        {
            $selProvince1 = $AREAID[0]['province_id'];
            $selCity1 = $AREAID[0]['city_id'];
            $selarea1 = $area_id[0]['area_id'];
        }
       //print_r($selProvince1);print_r($selCity1);print_r($selarea1);exit;
         //客户地址
        $this->smarty->assign('selProvince1',$selProvince1); 
        $this->smarty->assign('selCity1',$selCity1); 
        $this->smarty->assign('selarea1',$selarea1);
               
        //不同的产品使用不同的模板
        $url = "/?d=OM&c=Order&a=OrderModify";
        $objProductBLL = new ProductBLL();
        $product_type_no = $objProductBLL->GetProductTypeNo($objOrder->iProductId);

        if($product_type_no == ProductTypes::wymh)
            $url = "OM/Order_WYMH_Modify.tpl";
        else if($product_type_no == ProductTypes::cxrz || $product_type_no == ProductTypes::kxrz)
            $url = "OM/Order_CXRZ_Modify.tpl";              
        else if($product_type_no == ProductTypes::py)
            $url = "OM/Order_PY_Modify.tpl";            
        else if($product_type_no == ProductTypes::wm)
        {
            $url = "OM/Order_WM_Modify.tpl"; 
        } 
        else
            exit("未找到产品类别数据！");  //     $url = "OM/Order_WYMH_Modify.tpl";
            
        //显示客户信息
        $objCustomerInfo = $objCustomerBLL->getModelByID($objOrder->iCustomerId);
        if($objCustomerInfo != null)
        {
            $objOrder->strLegalPersonId = $objCustomerInfo->strLegalPersonId;
            $objOrder->strBusinessLicense = $objCustomerInfo->strBusinessLicense;
                        
            //客户负责人信息
            $objAgContactBLL = new AgContactBLL();
            $objAgContactInfo = $objAgContactBLL->GetManagerByCustomerID($objOrder->iCustomerId);
            if($objAgContactInfo != null)
            {
                $objOrder->strContactName = $objAgContactInfo->strContactName;
                $objOrder->strContactMobile = $objAgContactInfo->strContactMobile;
                $objOrder->strContactTel = $objAgContactInfo->strContactTel;
                $objOrder->strContactFax = $objAgContactInfo->strContactFax;
                $objOrder->strContactEmail = $objAgContactInfo->strContactEmail;              
            }        
            
            if($objOrder->strOwnerDomainUrl == "")
                $objOrder->strOwnerDomainUrl = $objCustomerInfo->strWebsite;
        }
        else
            exit("未找到客户信息！");
            
        $objAreaBLL = new AreaBLL();
        if($objCustomerInfo->iAreaId == "")
            $objCustomerInfo->iAreaId = 0;
            
        $arrayArea = $objAreaBLL->select("province_id,city_id","area_id=".$objCustomerInfo->iAreaId,"");
        if(isset($arrayArea) && count($arrayArea) > 0)
        {
            $cityID = $arrayArea[0]["city_id"];
            $provinceID = $arrayArea[0]["province_id"];
        }
        
        $iPreDepositsAccountMoney = 0;
        $iSaleAccountMoney = 0;
        $iPreDepositsChargeMoney = 0;
        $iSaleChargeMoney = 0;
        /*------------------------预存款账户金额----------s--------------*/
        $objAgentAccountBLL = new AgentAccountBLL();
        if($product_type_no == ProductTypes::wm)
        {
            //保证金可用余额
            $iSaleAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::GuaranteeMoney,$objOrder->iProductTypeId);
            //预存款可用金额
            $iPreDepositsAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::UnitPreDeposits,$objOrder->iProductTypeId);            
        }
        else
        {
            //销奖可用余额
            $iSaleAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::SaleReward2PreDeposits,$objOrder->iProductTypeId);
            //预存款可用金额
            $iPreDepositsAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::PreDeposits,$objOrder->iProductTypeId);       
            /*------------------------扣款比例----------s--------------*/
            
            $objAgentModelBLL = new AgentModelBLL();      
            $objAgentModelBLL->ProductChargeMoney($this->getAgentId(),$objOrder->iProductId,$iPreDepositsChargeMoney,$iSaleChargeMoney,0);
            
            if($iSaleAccountMoney < 0.001)//销奖账户(可用)金额 为0
            {
                $iPreDepositsChargeMoney = $iPreDepositsChargeMoney + $iSaleChargeMoney;
                $iSaleChargeMoney = 0;
            }
            else if($iSaleAccountMoney < $iSaleChargeMoney)//销奖账户(可用)金额 小于 销奖扣款
            {
                $iPreDepositsChargeMoney = $iPreDepositsChargeMoney + $iSaleChargeMoney - $iSaleAccountMoney;
                $iSaleChargeMoney = $iSaleAccountMoney;
            }        
            /*------------------------扣款比例----------e--------------*/     
        }
        /*------------------------预存款账户金额----------e--------------*/        
        /*------------------------订单提交时的存款限制-------------0不限制------------s--------*/
        /*
        $iGuaMoney = 0;
        $iPreMoney = 0;
        
        $objComSettingBLL = new ComSettingBLL();
        if($product_type_no == ProductTypes::wm)
        {
            $iGuaMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::UnitOrder_GuaAccountBalance);        
            $iPreMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::UnitOrder_PreAccountBalance);
        }
        else
        {
            $iGuaMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::Order_GuaAccountBalance);        
            $iPreMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::Order_PreAccountBalance);
        }
        
        $this->smarty->assign('iGuaMoney',$iGuaMoney);
        $this->smarty->assign('iPreMoney',$iPreMoney);*/
        /*------------------------订单提交时的存款限制-------------0不限制------------e--------*/
        $iPreDepositsAccountMoney = Utility::FormatMoney($iPreDepositsAccountMoney); 
        $iSaleAccountMoney = Utility::FormatMoney($iSaleAccountMoney); 
        $iPreDepositsChargeMoney = Utility::FormatMoney($iPreDepositsChargeMoney); 
        $iSaleChargeMoney = Utility::FormatMoney($iSaleChargeMoney); 
        
        $this->smarty->assign('iPreDepositsAccountMoney',$iPreDepositsAccountMoney);     
        $this->smarty->assign('iSaleAccountMoney',$iSaleAccountMoney);     
        $this->smarty->assign('iPreDepositsChargeMoney',$iPreDepositsChargeMoney);     
        $this->smarty->assign('iSaleChargeMoney',$iSaleChargeMoney);     
        
        $this->smarty->assign('id',$id);        
        $this->smarty->assign('orderTypeText',$orderTypeText);
        $this->smarty->assign('productText',$productText);
        
        $this->smarty->assign('provinceID',$provinceID); 
        $this->smarty->assign('cityID',$cityID); 
        $this->smarty->assign('arrayOrderWebsite',$arrayOrderWebsite); 
        $this->smarty->assign('objCustomerInfo',$objCustomerInfo); 
        $this->smarty->assign('objOrder',$objOrder);
                
        $this->displayPage($url);         
    }    
        
    /**
     * 网营门户的验证
    */
    protected function f_WYMH_OrderModifySubmitCheck()
    {        
        $strServiceTel = Utility::GetForm('tbxServiceTel',$_POST);        
        /*if($strServiceTel == "")
            exit("请填写公司客户电话，以供账号开通时使用"); 
          */  
        $productID = Utility::GetFormInt('tbxProductID',$_POST);
        $webSiteProvider = Utility::GetForm('domainProviders',$_POST);        
        $strWebSite = Utility::GetForm('webSites',$_POST);
        
        $tempWebSiteProvider = str_replace(",","",$webSiteProvider);
            //exit($tempWebSiteProvider."=====".$strWebSite."++".$webSiteProvider);
        if($tempWebSiteProvider == "")
        {
            $objProductBLL = new ProductBLL();
            $product_type_no = $objProductBLL->GetProductTypeNo($productID);
            if ($product_type_no == ProductTypes::wymh)
                exit("请选择域名提供商！");
            
            $arrayProvider = explode(",",$webSiteProvider);
            $arrayWebSite = explode(",",$strWebSite);
            
            $arrayLength = count($arrayProvider);
            for($i = 0;$i < $arrayLength; $i++)
            {
                if($arrayProvider[$i] != "" && $arrayProvider[$i] != "厂商提供" && $arrayWebSite[$i] == "")
                    exit("第".($i+1)."行，域名不能为空！");
                    //exit("第".($i+1)."行，域名不能为空！"); 
            }                
        }        
    }
    
    /**
     * 诚信认证的验证
    */
    protected function f_CXRZ_OrderModifySubmitCheck($productTypeNo)
    {  
        $strWebSite = Utility::GetForm('tbxWebSite',$_POST,128);
        if ($strWebSite == "")
            exit("请输入网站地址！");
        
        $postCheck = Utility::GetFormInt("tbxPost",$_POST);        
        if($postCheck == 1 && $productTypeNo == ProductTypes::kxrz)//有网盟才可以提交可信认证
        {               
            $customerID = Utility::GetFormInt('tbxCustomerID',$_POST);
            $objOrderBLL = new OrderBLL();
            $msg = $objOrderBLL->CanPostKXRZCheck($customerID,$strWebSite);
            if($msg != "")
                exit($msg);
        }
    }
    
    /**
     * 邮箱的验证
    */
    protected function f_PY_OrderModifySubmitCheck()
    {  
        $webSiteProvider = Utility::GetForm('cbDomainProvider',$_POST,128);
        $strWebSite = Utility::GetForm('tbxWebSite',$_POST,128);
        if ($webSiteProvider == "")
            exit("请选择域名提供商！");
            
        if($webSiteProvider != "厂商提供" && $strWebSite == "")
            exit("请输入域名名称！");
    }
        
    /**
     * 订单提交时的存款限制-------------0不限制
    */
    private function f_CheckMoneyWhenPostOrder($productTypeID,$productID,$productPrice = 0)
    {
        /*------------------------订单提交时的存款限制-------------0不限制------------s--------*/
        $objComSettingBLL = new ComSettingBLL();
        $objAgentAccountBLL = null;
        $iPreMoney = 0;
        $iGuaMoney = 0;
        $iPreMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::Order_PreAccountBalance);
            
        if($iPreMoney > 0)
        {
            $objAgentAccountBLL = new AgentAccountBLL();                
            //预存款可用金额
            $iPreCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::PreDeposits,$productTypeID);
            if(round($iPreCanUseMoney,2) < round($iPreMoney,2))
                exit("您好，您的预存款不足，请将订单保存，并及时充值。");
        }
        
        $iGuaMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::Order_GuaAccountBalance); 
            
        if($iGuaMoney > 0)
        {
            if($objAgentAccountBLL == null)
                $objAgentAccountBLL = new AgentAccountBLL(); 
            //保证金可用金额
            $iGuaCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::GuaranteeMoney,$productTypeID);
            if(round($iGuaCanUseMoney,2) < round($iGuaMoney,2))
                exit("您好，您的保证金不足，请将订单保存，并及时充值！");
        }
        
        /*------------------------订单提交时的存款限制-------------0不限制------------e--------*/
        //金额不足的提示 预存款不少于限制但金额也可能小于产品金额
        $objOrderBLL = new OrderBLL();   
        if($objOrderBLL->IsLackOfBalance($this->getAgentId(),$this->getFinanceNo(),$productTypeID,$productID,$productPrice = 0) == true)
            exit("您好，您的预存款余额不足！");
    }
    
    /**
     * @functional 订单数据提交
    */
    public function OrderModifySubmit()
    {        
        if (!$this->HaveRight("OrderModify", RightValue::add) &&
            !$this->HaveRight("UnitOrderModify",RightValue::add))
        {
            exit("您没有此操作权限！");
        }
        
        $id = Utility::GetFormInt('id',$_POST);
        $productID = Utility::GetFormInt('tbxProductID',$_POST);
        if($productID <= 0)
            exit("请选择产品！");
                    
        $customerID = Utility::GetFormInt('tbxCustomerID',$_POST);
        if($customerID <= 0)
            exit("请选择客户！");
                            
        $objProductBLL = new ProductBLL();//其他不同类型的产品的域名验证
        $productTypeNo = $objProductBLL->GetProductTypeNo($productID);
        $sData = "2000-01-01";
        $eData = "2000-01-01";
        
        $sData = Utility::GetForm('tbxSData',$_POST,15);
        if($sData == "")
           exit("请选择订单合同开始日期！");
               
        $eData = Utility::GetForm('tbxEData',$_POST,15);
        if($eData == "")
           exit("请选择订单合同结束日期！");
               
        if(Utility::isShortTime($sData) == 0)
            exit("订单合同开始日期不正确！");
               
        if(Utility::isShortTime($eData) == 0)
            exit("订单合同结束日期不正确！");
        
        if(Utility::compareSEDate($sData,$eData) < 0)    
            exit("订单合同结束日期小于开始日期！");
        
        $legalPersonName = Utility::GetForm('tbxLegalPersonName',$_POST,10);        
        if($legalPersonName == "")
            exit("请输入客户法人姓名！");
        
        $legalPersonID = Utility::GetForm('tbxLegalPersonID',$_POST,24);
        if($legalPersonID == "")
            exit("请输入客户法人身份证！");
        
        $permit = Utility::GetForm('tbxPermit',$_POST,64);
        if($permit == "")
            exit("请输入客户营业执照！");
               
        $contactName = Utility::GetForm('tbxContactName',$_POST,10);
        if($contactName == "")
           exit("请输入客户联系人名称！");

        $contact_mobile = Utility::GetForm('contact_mobile',$_POST,20);
        $contact_tel = Utility::GetForm('contact_tel',$_POST,20);
        if($contact_mobile == "" && $contact_tel == "")
           exit("手机和电话必填一项！");
        
        $areaID = Utility::GetFormInt('area',$_POST);
        if($areaID <= 0)
            exit("请选择客户地址！");
            
        $contactAddress = Utility::GetForm('contact_address',$_POST,60);
        if($contactAddress == "")
           exit("请输入客户详细地址！");
        
        $legalPersonIDPath = Utility::GetForm('permitJ_upload0',$_POST,128);//tbxLegalPersonIDPath
        if($legalPersonIDPath == "")
            exit("请上传客户法人身份证！");
            
        $permitPath = Utility::GetForm('permitJ_upload1',$_POST,128);//tbxPermitPath
        if($permitPath == "")
            exit("请上传客户营业执照！");
                
        if($productTypeNo == ProductTypes::wymh)
            $this->f_WYMH_OrderModifySubmitCheck();
        else if($productTypeNo == ProductTypes::cxrz || $productTypeNo == ProductTypes::kxrz)
            $this->f_CXRZ_OrderModifySubmitCheck($productTypeNo);
        else if($productTypeNo == ProductTypes::py)
            $this->f_PY_OrderModifySubmitCheck();        
        
        /*----------------------合同数据--------------------s------------*/
        $agentPactID = 0;
        $agentPactNo = "";
        $productTypeID = 0;
        $strProductTypeName = "";
        
        $arrayProductInfo = $objProductBLL->select("product_type_id,product_name","product_id=".$productID,"");
        if(isset($arrayProductInfo) && count($arrayProductInfo)>0)
        {
            $productTypeID = $arrayProductInfo[0]["product_type_id"];
            $strProductTypeName = $arrayProductInfo[0]["product_name"];
        }
        
        if($productTypeID <= 0)
            exit("产品类别有误！");
            
        $objAgentPactBLL = new AgentPactBLL();
        $arrayData = $objAgentPactBLL->GetAgentPact($this->getAgentId(),$productTypeID);
        if(isset($arrayData) && count($arrayData)>0)
        {   
            $agentPactID = $arrayData[0]["agent_pact_id"];
            $agentPactNo = $arrayData[0]["pact_number"]."".$arrayData[0]["pact_stage"];
        }
        else
        {
            exit("未找到与此产品的签约合同！");
        }
        /*----------------------合同数据--------------------e------------*/
        
        $objOrderBLL = new OrderBLL();
        $postCheck = Utility::GetFormInt("tbxPost",$_POST);
        
        if($postCheck == 1)//保存(0)的话这个验证就不要了。
        {          
            //客户订单已存在的提示 
            $orderCounts = $objOrderBLL->TodayPostedOrderCount($this->getAgentId(),$customerID,$productID);
            if($orderCounts >= 2)
                exit("对同一客户同一产品的订单，24小时内只允许提交2次，请您选择保存当前订单！");
            
            $this->f_CheckMoneyWhenPostOrder($productTypeID,$productID); 
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
        
        //更新客户信息
        $objCustomerBLL = new CustomerBLL();
        $objCustomerInfo = $objCustomerBLL->getModelByID($customerID);
        $objCustomerInfo->strLegalPersonName = $legalPersonName;
        $objCustomerInfo->strLegalPersonId = $legalPersonID;
        $objCustomerInfo->strBusinessLicense = $permit;
        $objCustomerInfo->iAreaId = $areaID;
        $objCustomerInfo->strAddress = $contactAddress;
        $strPostCode = Utility::GetForm('tbxPostCode',$_POST,20);
        if($strPostCode != "")
            $objCustomerInfo->strPostcode = $strPostCode;
            
        $strComWebSite = Utility::GetForm('tbxComWebSite',$_POST,64);
        if($strComWebSite != "")
            $objCustomerInfo->strWebsite = $strComWebSite;
            
        $objCustomerBLL->updateByID($objCustomerInfo);
        
        $objCustomerExBLL =new CustomerExBLL();
        $objDataConfigBLL = new DataConfigBLL();
        $iDefendTime = $objDataConfigBLL->GetProtectTime_Formal($this->getAgentId());
        $iUpdateExRtn = $objCustomerExBLL->UpdateData(array(
            'defend_state'=>  CustomerDefendState::HasOrderCustomer,
            'to_sea_time'=>  Utility::addDay(Utility::Now(), $iDefendTime,false)
        ), "customer_id={$customerID} and agent_id={$this->getAgentId()}");
        
       //客户负责人信息
        $objAgContactBLL = new AgContactBLL();
        $objAgContactInfo = $objAgContactBLL->GetManagerByCustomerID($customerID);
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
            $objAgContactInfo->iCustomerId = $customerID;
            $objAgContactInfo->iCreateUid = $this->getUserId();
            $objAgContactBLL->insert($objAgContactInfo);            
        }
            
        //更新法人身份证
        $oldLegalPersonIDPath = Utility::GetForm('tbxOldLegalPersonIDPath',$_POST,128);
        $oldPermitPath = Utility::GetForm('tbxOldPermitPath',$_POST,128);  
        
        if($legalPersonIDPath != $oldLegalPersonIDPath)
            $legalPersonIDPath = $this->arrSysConfig['UPFILE_PATH']['CUSTOMER_PERMIT'].array_pop(explode("=",$legalPersonIDPath));
                   
        if($permitPath != $oldPermitPath)
            $permitPath = $this->arrSysConfig['UPFILE_PATH']['CUSTOMER_PERMIT'].array_pop(explode("=",$permitPath));
                        
        $objCustomerPermitBLL = new CustomerPermitBLL();
        if($oldLegalPersonIDPath != $legalPersonIDPath)
        {
            $objCustomerPermitBLL->UpdatePermit($customerID,CustomerPermits::CorporatePhoto,$legalPersonIDPath,$this->getUserId());
        }
              
        //更新客户资质
        if($oldPermitPath != $permitPath)
        {
            $objCustomerPermitBLL->UpdatePermit($customerID,CustomerPermits::BusinessLicense,$permitPath,$this->getUserId());            
        }
        
        $productNo = "";//产品编号
        $objProductBLL = new ProductBLL();
        $arrayProduct = $objProductBLL->select("product_no","product_id=".$productID);
        
       	if (isset($arrayProduct)&& count($arrayProduct)>0)
        {
            $productNo = $arrayProduct[0]["product_no"];
        }
        
        if($id > 0)
        {                                
    	    $objOrderInfo->iUpdateUid = $this->getUserId();
        }
        else
        {   
            $objOrderInfo->iFinanceUid = $this->getFinanceUid();
            $objOrderInfo->strFinanceNo = $this->getFinanceNo();
            $objOrderInfo->strOrderNo = $objOrderBLL->getNewNo(CustomerOrderTypes::newOrder,$productNo,$this->getAgentNo());
            $objOrderInfo->iCreateUid = $this->getUserId(); 
        }
        
    	$objOrderInfo->iOrderType = CustomerOrderTypes::newOrder;//新签
    	$objOrderInfo->iAgentId = $this->getAgentId();
        $objOrderInfo->strAgentNo = $this->getAgentNo();
    	$objOrderInfo->strAgentName = $this->getAgentName();
    	$objOrderInfo->iCustomerId = $customerID;
    	$objOrderInfo->strCustomerName = $objCustomerInfo->strCustomerName;
    	$objOrderInfo->iProductId = $productID;
        $objOrderInfo->iProductTypeId = $productTypeID;
        
        //根据产品取得价格
        $objAgentModelBLL = new AgentModelBLL();
 	    $objOrderInfo->iActPrice = $objAgentModelBLL->GetProductPrice($this->getAgentId(),$productID,date("Y-m-d H:m:s",time()));
        
    	$objOrderInfo->strOrderSdate = $sData;
    	$objOrderInfo->strOrderEdate = $eData;
        //将订单有效期默认成订单日期
        $objOrderInfo->strEffectSdate = $sData;
        $objOrderInfo->strEffectEdate = $eData;
        
        $strRemark = Utility::GetRemarkForm('tbxRemark',$_POST,256); 
        
    	$objOrderInfo->strOrderRemark = $strRemark;
    	$objOrderInfo->strLegalPersonName = $legalPersonName;
        
    	$objOrderInfo->strContactName = $contactName;
    	$objOrderInfo->strContactMobile = $contact_mobile;
    	$objOrderInfo->strContactTel = $contact_tel;
    	$objOrderInfo->strContactFax = Utility::GetForm("contact_fax",$_POST,20);
    	$objOrderInfo->strContactEmail = Utility::GetForm("contact_email",$_POST,64);
        
        $tbxOldLegalPersonIDPath = Utility::GetForm("tbxOldLegalPersonIDPath",$_POST,640);
        $tbxOldPermitPath = Utility::GetForm("tbxOldPermitPath",$_POST,640);
        
    	$objOrderInfo->strBusinessLicensePath = $permitPath;
    	$objOrderInfo->strLegalPersonIdPath = $legalPersonIDPath;
        
    	$objOrderInfo->strBusinessLicense = $permit;
        
    	$objOrderInfo->strLegalPersonId = $legalPersonID;
        
        $objOrderInfo->iAgentPactId = $agentPactID;
        $objOrderInfo->strAgentPactNo = $agentPactNo;       
        $strServiceTel = Utility::GetForm('tbxServiceTel',$_POST);
        if($strServiceTel != "")
            $objOrderInfo->strServiceTel = $strServiceTel;
            
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objOrderInfo->iAccountGroupId = $objAccountGroupUserBLL->getGroupIdByAgentId($this->getAgentId());///区域组///
                
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
                $objOrderInfo->iIsCharge = 0;
                $objOrderInfo->iCheckStatus = CheckStatus::notPost;
                $objOrderInfo->iOrderStatus = OrderStatus::notPost;     
                $objOrderInfo->strOrderStatusText = OrderStatus::GetText($objOrderInfo->iOrderStatus);                
            }
                
        	$objOrderInfo->iPostUid = 0;          
        }
       	$objOrderInfo->strPostDate = Utility::Now(); 
    	$objOrderInfo->iIsDel = 0;
        
        $strWebSite = Utility::GetForm('webSites',$_POST);        
        if($strWebSite == "")
        {
            $strWebSite = Utility::GetForm('tbxWebSite',$_POST,128);
        }
        else
        {            
            $arrayWebSite = explode(",",$strWebSite);
            $strWebSite = $arrayWebSite[0];
        }
        $objOrderInfo->strOwnerDomainUrl = $strWebSite;
        
        if($id > 0)
        {
            if($objOrderBLL->updateByID($objOrderInfo) <= 0)                
                exit("修改失败！");
        
            //域名提供商
            $objOrderWebsiteBLL = new OrderWebsiteBLL();
            $objOrderWebsiteBLL->DeleteByOrderID($id);
            $objOrderBLL->DelOrderFreezeMoney($id,$this->getUserId());
        }
        else
        {
            $id = $objOrderBLL->insert($objOrderInfo);
            if($id <= 0)   
                exit("添加失败！");
                
        }
               
        if($productTypeNo == ProductTypes::wymh)
        {            
            $this->f_WYMH_OrderModifyAddWebsite($id);
        }
        else if($productTypeNo == ProductTypes::cxrz || $productTypeNo == ProductTypes::kxrz)
            $this->f_CXRZ_OrderModifyAddWebsite($id);
        else if($productTypeNo == ProductTypes::py)
            $this->f_PY_OrderModifyAddWebsite($id);
                        
        if($postCheck == 1)
        {
            $objOrderBLL->AddOrderFreezeMoney($id,$this->getUserId());    
        }
                
        exit("0,".$id);
    }
    
    protected function f_WYMH_OrderModifyAddWebsite($orderID)
    {
        $objOrderWebsiteBLL = new OrderWebsiteBLL();  
        $webSiteProvider = Utility::GetForm('domainProviders',$_POST);        
        $strWebSite = Utility::GetForm('webSites',$_POST);
        $tempWebSiteProvider = str_replace(",","",$webSiteProvider);
        if($tempWebSiteProvider != "")
        {                
            $arrayProvider = explode(",",$webSiteProvider);
            $arrayWebSite = explode(",",$strWebSite);
            $arrayLength = count($arrayProvider);
                        
            for($i = 0;$i < $arrayLength; $i++)
            {
                if($arrayProvider[$i] != "" && $arrayWebSite[$i] != "")
                    $objOrderWebsiteBLL->insertData($orderID,$arrayProvider[$i],$arrayWebSite[$i]);
            }
        }
    }
       
    protected function f_CXRZ_OrderModifyAddWebsite($orderID)
    {
        $objOrderWebsiteBLL = new OrderWebsiteBLL();  
        $strWebSite = Utility::GetForm('tbxWebSite',$_POST,128);
        if($strWebSite != "")
        {           
            $objOrderWebsiteBLL->insertData($orderID,"",$strWebSite);           
        }
    }
    
    protected function f_PY_OrderModifyAddWebsite($orderID)
    {
        $objOrderWebsiteBLL = new OrderWebsiteBLL();  
        $webSiteProvider = Utility::GetForm('cbDomainProvider',$_POST,20);
        $strWebSite = Utility::GetForm('tbxWebSite',$_POST,128);
        if($webSiteProvider != "" && $strWebSite != "")
        {            
            $objOrderWebsiteBLL->insertData($orderID,$webSiteProvider,$strWebSite);           
        }
    }
    
    
    /**
     * @functional 未提交的订单
     */
    public function OrderIsNotPost()
    {
       $productID = Utility::GetFormInt('productID',$_POST);
        if($productID <= 0)
            exit("请选择产品！");
                    
        $customerID = Utility::GetFormInt('customerID',$_POST);
        if($customerID <= 0)
            exit("请选择客户！");

        $objOrderBLL = new OrderBLL();  
        $orderCounts = $objOrderBLL->NotPostOrderCount($this->getAgentId(),$this->getFinanceUid(),$customerID,$productID); 
        
        exit("".$orderCounts);        
    }
        
    /**
     * @functional 未提交的订单
     
    public function UnitOrderIsNotPost()
    {
       $productID = Utility::GetFormInt('productID',$_POST);
        if($productID <= 0)
            exit("请选择产品！");
                    
        $customerID = Utility::GetFormInt('customerID',$_POST);
        if($customerID <= 0)
            exit("请选择客户！");
            
        $objOrderBLL = new OrderBLL();  
        $arrayData = $objOrderBLL->select("1"," agent_id=".$this->getAgentId()." and customer_id = $customerID and product_id =$productID"); 
        $orderCounts = 0;
        if(isset($arrayData) && count($arrayData) > 0)
            $orderCounts = count($arrayData);
            
        exit("".$orderCounts);
    }
    */
    
    /**
     * @functional 显示订单明细
    */
    public function OrderDetail()
    { 
        //订单审核
        $checkFlag = Utility::GetFormInt('checkFlag',$_GET);
        
        if($this->isAgentUser() == false)
        {
            if($checkFlag > 0)
                $this->PageRightValidate("My_AuditWorkList",RightValue::check); 
            else
                $this->PageRightValidate("OrderList",RightValue::view); 
                
            $this->smarty->assign('isAgentUser',0);
        }  
        else
        {
            $this->PageRightValidate("OrderDetail",RightValue::view); 
            
            $this->smarty->assign('isAgentUser',1);
        }
                   
        $id = Utility::GetFormInt('id',$_GET);
        if($id <= 0)
            exit("未找到此订单！");
            
        $this->smarty->assign('strTitle','订单明细');       
                
        $objOrder = new OrderInfo();        
        $objOrderBLL = new OrderBLL();
        $objOrder = null;  
        if($this->isAgentUser())   {
            $objOrder = $objOrderBLL->getModelByID($id,$this->getAgentId()); 
        }else
            $objOrder = $objOrderBLL->getModelByID($id); 
            
        if($objOrder == null)
            exit("未找到此订单！");
                    
        $objOrder->iActPrice = Utility::FormatMoney($objOrder->iActPrice);
        
        $objUserBLL = new UserBLL();
        $strPostEmpName = $objUserBLL->GetUserNameByUID($objOrder->iPostUid);
        $this->smarty->assign('strPostEmpName',$strPostEmpName);
        
        $strProductName = "";
        $strProductTypeNo = "";
        $isUnit = 0;//是否为网盟产品
        $objProductBLL = new ProductBLL();
        $arrayProduct = $objProductBLL->select("product_name,product_series,product_type_id","product_id=".$objOrder->iProductId);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
        {
            $strProductName = $arrayProduct[0]["product_name"].">".$arrayProduct[0]["product_series"];
            $objProductTypeBLL = new ProductTypeBLL();
            $objProductTypeInfo = $objProductTypeBLL->getModelByID($arrayProduct[0]["product_type_id"]);
            if($objProductTypeInfo != null)
            {
                if($objProductTypeInfo->iDataType == ProductGroups::NetworkAlliance)
                    $isUnit = 1;
                else
                    $isUnit = 0;
                    
                $strProductTypeNo = $objProductTypeInfo->strProductTypeNo;
            }            
        }
        
        $strSupTitle = "增值产品订单查询";
        if($isUnit == 1)
            $strSupTitle = "网盟产品订单查询";
            
        if($objOrder->iSourceOrderId > 0)
            $strSupTitle = "赠送产品订单查询";
            
        $this->smarty->assign('strSupTitle',$strSupTitle);
        $this->smarty->assign('isNet',$isUnit);
        $this->smarty->assign('strProductName',$strProductName);
        
        $objCustomerBLL = new CustomerBLL();
        $arrayCustomer = $objCustomerBLL->GetOnlyCustomerInfo($objOrder->iCustomerId);
        if(isset($arrayCustomer) && count($arrayCustomer) > 0)
        {
            $this->smarty->assign('strAddress',$arrayCustomer[0]["address"]);
            
            $objAreaBLL = new AreaBLL();
            $arrayArea = $objAreaBLL->select(T_Area::area_fullname,"area_id=".$arrayCustomer[0]["area_id"],"");
            if(isset($arrayArea) && count($arrayArea) > 0)
            {
                 $this->smarty->assign('areaFullName',$arrayArea[0]["area_fullname"]);
            }            
        }
        
        //==========================域名提供方===========s=====================================//
        $strWebSiteHTML = "";
        if(!$isUnit && $strProductTypeNo != "")
        {                
            $objOrderWebsiteBLL = new OrderWebsiteBLL();
            $arrayWebSite = $objOrderWebsiteBLL->GetWebSites($id);
            
            if(isset($arrayWebSite) && count($arrayWebSite) > 0)
            {
                if($strProductTypeNo == ProductTypes::cxrz || $strProductTypeNo == ProductTypes::kxrz || $objOrder->iSourceOrderId > 0)
                {
                        $strWebSiteHTML = "<tr class=''>
                        <td class='even'><div class='ui_table_tdcntr'>网址</div></td>
                        <td><div class='ui_table_tdcntr'>".$arrayWebSite[0]["website_name"]."</div></td>
                        <td class='even'><div class='ui_table_tdcntr'></div></td>
                        <td><div class='ui_table_tdcntr'></div></td>
                        </tr> ";                   
                }
                else
                {
                    $iWebSiteCount = count($arrayWebSite);
                    $strWebSiteHTML = "<tr class=''>
                        <td class='even'><div class='ui_table_tdcntr'>域名信息</div></td>
                        <td><div class='ui_table_tdcntr'>";
                    for($i=0;$i<$iWebSiteCount;$i++)
                    {
                        if(strlen($arrayWebSite[$i]["website_provider"]) > 0)
                            $strWebSiteHTML .= "提供方：".$arrayWebSite[$i]["website_provider"]."  网站地址：";
                        
                        $strWebSiteHTML .= $arrayWebSite[$i]["website_name"];
                        
                        if($i != $iWebSiteCount-1)
                            $strWebSiteHTML .= "<br/>";
                    }
                                        
                    $strWebSiteHTML .= "</div></td>
                        <td class='even'><div class='ui_table_tdcntr'></div></td>
                        <td><div class='ui_table_tdcntr'></div></td>
                        </tr> ";
                } 
            
            }
        }
        
        $this->smarty->assign('strWebSiteHTML',$strWebSiteHTML);
        //==========================域名提供方===========e=====================================//
        
        //审核信息
        /* 在流程卡里看
        $objAuditAction = new AuditAction();
        $checkInfoHTML = $objAuditAction->ShowAuditInfo(T_Order::Name,$id);
        $this->smarty->assign('checkInfoHTML',$checkInfoHTML);
        */   
          
        $checkHTML = "";
        $passAction = "";
        $notPassAction = "";
        $auditJumpPage = "";
        $giftHTML = "";
        if($objOrder->iOrderType == CustomerOrderTypes::gift && $objOrder->iSourceOrderId > 0) //显示源订单信息
        {
            $arraySourceOrder = $objOrderBLL->select("*","order_id=".$objOrder->iSourceOrderId);
            if(isset($arraySourceOrder) && count($arraySourceOrder) > 0)
            {
                $sProductName = "";
                $aProduct = $objProductBLL->select("product_name,product_series,product_type_id","product_id=".$arraySourceOrder[0]["product_id"]);
                if(isset($aProduct) && count($aProduct) > 0)
                {
                    $sProductName = $aProduct[0]["product_name"].">".$aProduct[0]["product_series"];
                }
                
                $giftHTML = "<div class=\"list_table_main marginBottom10\">
    			<div class=\"ui_table ui_table_nohead\">
    			    <div class=\"ui_table_hd\"><div class=\"ui_table_hd_inner\"><h4 class=\"title\">源订单信息</h4></div></div>
    			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
    			       <tbody class=\"ui_table_bd\">		            
    			            <tr class=\"\">
    			                <td class=\"even\"><div class=\"ui_table_tdcntr\">订单号</div></td>
    			                <td><div class=\"ui_table_tdcntr\"><a href=\"javascript:;\" onclick=\"JumpPage('/?d=OM&c=Order&a=OrderDetail&id=".
                                $arraySourceOrder[0]["order_id"]."')\">".$arraySourceOrder[0]["order_no"]."</a></div></td>
    			                <td class=\"even\"><div class=\"ui_table_tdcntr\">订单类型</div></td>
    			                <td><div class=\"ui_table_tdcntr\">".CustomerOrderTypes::GetText($arraySourceOrder[0]["order_type"])."</div></td>
    			            </tr>
    			            <tr class=\"\">
    			                <td class=\"even\"><div class=\"ui_table_tdcntr\">产品名称</div></td>
    			                <td><div class=\"ui_table_tdcntr\">".$sProductName."</td>
    			                <td class=\"even\"><div class=\"ui_table_tdcntr\">产品价格</div></td>
    			                <td><div class=\"ui_table_tdcntr\"><a href=\"javascript:;\" onclick=\"OrderPriceStatus(".$arraySourceOrder[0]["order_id"].")\"><b class=\"amountStyle\">".
                             Utility::FormatMoney($arraySourceOrder[0]["act_price"])."</b></a></div></td>
    			            </tr></tbody></table></div></div>";
            }
        }
        else //显示赠送订单信息
        {
            $arrayGifts = $objOrderBLL->GetGiftList($id);
            if(isset($arrayGifts) && count($arrayGifts) > 0)
            {
                $giftHTML = "<div class=\"list_table_main marginBottom10\">
    			<div class=\"ui_table ui_table_nohead\">
    			    <div class=\"ui_table_hd\"><div class=\"ui_table_hd_inner\"><h4 class=\"title\">赠送订单信息</h4></div></div>
    			    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
    			       <thead class=\"ui_table_hd\">
                    	<tr>
                        	<th title=\"赠送订单号\">
                            	<div class=\"ui_table_thcntr\">
                                	<div class=\"ui_table_thtext\">赠送订单号</div>
                                </div>
                            </th>
                            <th title=\"产品\">
                            	<div class=\"ui_table_thcntr \">
                                	<div class=\"ui_table_thtext\">产品</div>
                                 </div>
                            </th>
                            <th title=\"域名\">
                            	<div class=\"ui_table_thcntr \">
                                	<div class=\"ui_table_thtext\">域名</div>
                                </div>
                            </th>
                            <th style=\"width:110px;\" title=\"提交人\">
                            	<div class=\"ui_table_thcntr \">
                                	<div class=\"ui_table_thtext\">提交人</div>
                                </div>
                            </th>
                            <th style=\"width:80px;\" title=\"提交时间\">
                            	<div class=\"ui_table_thcntr \">
                                	<div class=\"ui_table_thtext\">提交时间</div>
                                </div>
                            </th>
                            <th style=\"width:80px;\" title=\"订单状态\">
                            	<div class=\"ui_table_thcntr \">
                                	<div class=\"ui_table_thtext\">订单状态</div>
                                </div>
                            </th>
                       </tr>
                       </thead>
                       <tbody class=\"ui_table_bd\">";
                   foreach($arrayGifts as $key => $value)
                   {
                        $giftHTML .= "<tr>
                        <td title=\"".$value["order_no"]."\"><div class=\"ui_table_tdcntr\">
                        <a href=\"javascript:;\" onclick=\"JumpPage('/?d=OM&c=Order&a=OrderDetail&id=".$value["order_id"]."')\">".$value["order_no"]."</a>
                        </div></td>
                        <td  title=\"".$value["product_name"]."\"><div class=\"ui_table_tdcntr\">".$value["product_name"]."</div></td>
                        <td title=\"".$value["owner_domain_url"]."\"><div class=\"ui_table_tdcntr\">".$value["owner_domain_url"]."</div></td>";
                        if($value["check_status"] == -2)
                        {
                            $giftHTML .= "<td title=\"\"><div class=\"ui_table_tdcntr\">--</div></td>
                            <td title=\"\"><div class=\"ui_table_tdcntr\">--</div></td>";
                        }
                        else
                        {
                            $giftHTML .= "<td title=\"".$value["post_e_name"]." ".$value["post_user_name"]."\"><div class=\"ui_table_tdcntr\">
                            ".$value["post_e_name"]." ".$value["post_user_name"]."
                            </div></td><td title=\"".$value["post_date"]."\"><div class=\"ui_table_tdcntr\">".$value["post_date"]."</div></td>";
                        }  
                            
                        $giftHTML .= "<td><div class=\"ui_table_tdcntr\">
                        <a onclick=\"OrderStatusInfo(".$value["order_id"].")\" href=\"javascript:;\">".$value["order_status_text"]."</a>
                        </div></td>
                       </tr>";
                   }                       
                       
                   $giftHTML .= "</tbody></table></div></div>";        
            }
        }
        
        
        if($checkFlag > 0)
        {
            $checkHTML = AuditAction::ShowAudit();
            $passAction = "/?d=OM&c=Back_Order&a=Audit_Pass&id=".$id;
            $notPassAction = "/?d=OM&c=Back_Order&a=Audit_NotPass&id=".$id;
            $auditJumpPage = "/?d=OM&c=Back_Order&a=My_AuditWorkList";
        }
        
        $this->smarty->assign('id',$id);
        $orderTypeText = CustomerOrderTypes::GetText($objOrder->iOrderType);
        $checkStatusText = $objOrder->strOrderStatusText;// CheckStatus::GetText($objOrder->iCheckStatus);        
        if($objOrder->strOrderSdate != $objOrder->strOrderEdate && $objOrder->iCheckStatus != CheckStatus::notPass && Utility::compareSEDate($objOrder->strEffectEdate,date("Y-m-d",time())) > 0)
        {
            $checkStatusText = "已失效";
        }
        
        $this->smarty->assign('giftHTML',$giftHTML);
        $this->smarty->assign('orderTypeText',$orderTypeText);
        $this->smarty->assign('checkStatusText',$checkStatusText);
        $this->smarty->assign('checkFlag',$checkFlag);
        $this->smarty->assign('checkHTML',$checkHTML);
        $this->smarty->assign('passAction',$passAction);
        $this->smarty->assign('notPassAction',$notPassAction);
        $this->smarty->assign('jumpPage',$auditJumpPage);
                        
        if($isUnit == 1)
        {            
            $signWYZJUrl = "";
            if($objOrder->iOwnerId > 0)
            {
                /*
                $arrayOwnerInfo = $objOrderBLL->GetOwnerInfo($objOrder->iOwnerId);
                if(isset($arrayOwnerInfo) && count($arrayOwnerInfo) > 0)
                {                    
                    $objOrder->strOwnerAccountName = $arrayOwnerInfo["login"];
                    $objOrder->strOwnerWebsiteName = $arrayOwnerInfo["sitename"];
                    $objOrder->strOwnerDomainUrl = $arrayOwnerInfo["domain"];
                }
                //$this->smarty->assign('arrayOwnerInfo',$arrayOwnerInfo);
                //print_r($arrayOwnerInfo);*/
                
                $signWYZJUrl = $this->f_getSignWYZJUrl($objOrder->iOwnerId);
            }
            
            //后台用户看到的订单信息
            $strListPath = "/?d=OM&c=Back_Order&a=UnitOrderList";
            if($this->isAgentUser() == true)
                $strListPath = "/?d=OM&c=Order&a=UnitOrderList";
            $this->smarty->assign('signWYZJUrl',$signWYZJUrl);
            $this->smarty->assign('strListPath',$strListPath);
            $this->smarty->assign('objOrder',$objOrder);             
            $this->smarty->display('OM/UnitOrderDetail.tpl'); 
        }
        else
        {            
            //后台用户看到的订单信息
            $strListPath = "/?d=OM&c=Back_Order&a=OrderList";
            if($this->isAgentUser() == true)
            {
                $strListPath = "/?d=OM&c=Order&a=ValueOrderList";                
                if($objOrder->iSourceOrderId > 0)
                    $strListPath = "/?d=OM&c=GiftOrder&a=GiftOrderList"; 
            }
                
            $this->smarty->assign('strListPath',$strListPath);
            
            $this->smarty->assign('objOrder',$objOrder); 
            $this->smarty->display('OM/OrderDetail.tpl'); 
        }           
    }
    
    private function f_getSignWYZJUrl($customerID)
    {
        $time = strtotime(date('Y-m-d'));
        $vc = md5($customerID."#crm#@!@".$time);        
        $url = "http://m.yitian3.com/crm/login?oid={$customerID}&vc=".$vc;
        if($this->arrSysConfig["SYS_EVN"]==2)
            $url = "http://m.adyun.com/crm/login?oid={$customerID}&vc=".$vc;
            
        return $url;
    }

    
    /**
     * @functional 删除订单
    */
    public function DelOrder()
    {
        if(!($this->HaveRight("MyOrderList",RightValue::del)
        || $this->HaveRight("MyGiftOrderList",RightValue::del)
        || $this->HaveRight("MyUnitOrderList",RightValue::del)))
        {
            exit("{'success':false,'msg':'您没有此操作权限！'}");  
        }
                 
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("{'success':false,'msg':'未找到此订单！'}");        
        
        $objOrderBLL = new OrderBLL();            
        if($objOrderBLL->CanDel($id) == false)
            exit("{'success':false,'msg':'该订单不能被删除！'}");
             
        if($objOrderBLL->deleteByID($id,$this->getUserId()) > 0)
            exit("{'success':true,'msg':'删除成功'}");            
        else
            exit("{'success':false,'msg':'删除失败！'}");
    }
    
      
    /**
     * @functional 订单退单
    */
    public function BackOrder()
    {
        $this->ExitWhenNoRight("OrderModify",RightValue::add);  
        $id = Utility::GetFormInt('id',$_POST);
        
        if($id <= 0)
            exit("未找到此订单！");
        
        $objOrderBLL = new OrderBLL();            
        if($objOrderBLL->CanBack($id) == false)
            exit("该订单不能被退单！");
             
        if($objOrderBLL->BackOrder($id,$this->getUserId()) > 0)
            exit("0");
        else
            exit("退单失败！");
    }
        
      
    /**
     * @functional 订单审核信息
    */
    public function AuditList()
    {
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("未找到此订单！");
        
        $objAuditAction = new AuditAction();
        $checkInfoHTML = $objAuditAction->ShowAuditInfo(T_Order::Name,$id);
        $this->smarty->assign('checkInfoHTML',$checkInfoHTML);
        $this->smarty->display('COM/AuditInfo.tpl');        
    }
    
    
    /**
     * @functional 产品订单流程信息
    */
    public function AuditInfo()
    {
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("{'success':false,'msg':'未找到此订单！'}");
        
        $objOrderBLL = new OrderBLL();   
        $strOrderProductTypeNo = $objOrderBLL->GetOrderProductTypeNo($id);
        if($strOrderProductTypeNo == "")
            exit("{'success':false,'msg':'未找到此订单产品！'}");
        
        $strUrl = "/?d=TM&c=EMail&a=getOrderStatus";
        switch($strOrderProductTypeNo)
        {
            case ProductTypes::wymh:
                $strUrl = "/?d=TM&c=NetOpe&a=getOrderStatusLong";
            break;
            case ProductTypes::wyzj:
                $strUrl = "/?d=TM&c=NetOpe&a=getOrderStatusWyzj";
            break;
            case ProductTypes::py:
                $strUrl = "/?d=TM&c=EMail&a=getOrderStatus";
            break;
            case ProductTypes::wm:
                $strUrl = "/?d=OM&c=UnitOrder&a=getOrderStatusWm"; //不用审核
            break;            
            case ProductTypes::cxrz:
            case ProductTypes::kxrz:
                $strUrl = "/?d=TM&c=Trustworthy&a=getOrderStatus";
            case ProductTypes::link:
                $strUrl = "/?d=OM&c=Order&a=getOrderStatusLink";
            break;
        }
        
        exit("{'success':true,'msg':'$strUrl'}");
    }
    
    public function getOrderStatusLink()
    {        
        $orderID = Utility::GetForm("id", $_GET);
        
        if($orderID <= 0)
            exit("'未找到此订单！");
        
        include_once __DIR__ . '/../../Class/BLL/AgentAccountDetailBLL.php';
        $objAgentAccountDetail = new AgentAccountDetailBLL();
        $arrData = $objAgentAccountDetail->getOrderBackInfo($orderID);
        $this->smarty->assign("BackInfo",$arrData);
        $strBackHtml = $this->smarty->fetch('TM/BackOrderInfo.tpl');
            
        $objOrderBLL = new OrderBLL();
        $arrayStatus = $objOrderBLL->getOrderStatusLink($orderID);
            
        $this->smarty->assign('arrayStatus',$arrayStatus); 
        $this->smarty->assign('backhtml',$strBackHtml);
        $this->displayPage("OM/Link_OrderStatus.tpl");
    }
    
    /**
     * @functional 订单相关的客户账户查询
    */
    public function CustomerAccount()
    {
        $this->PageRightValidate("CustomerAccount",RightValue::view);
        
        //$this->smarty->assign('strTitle','客户账号查询');        
        
        $this->smarty->assign('CustomerAccountBody',"/?d=OM&c=Order&a=CustomerAccountBody"); 
        $this->displayPage('OM/CustomerAccount.tpl');
    }
        
      
    /**
     * @functional 订单相关的客户账户查询数据
    */
    public function CustomerAccountBody()
    {
        $this->ExitWhenNoRight("CustomerAccount",RightValue::view);
        
        $sWhere = " and om_order.agent_id=".$this->getAgentId()." and om_order.finance_uid=".$this->getFinanceUid()." ";
             
        $iProductID = Utility::GetFormInt("cbProduct",$_GET);
        if($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=".$iProductID;
        else
        {
            $productTypeID = Utility::GetFormInt("cbProductType",$_GET);
            if($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=".$productTypeID;             
        }
    
        $addSDate = Utility::GetForm("tbxAddSDate",$_GET);
        if($addSDate != "")
            $sWhere .= " and `tm_single_info`.create_time >= '".$addSDate."'";             
            
        $addEDate = Utility::GetForm("tbxAddEDate",$_GET);
        if($addEDate != "")
            $sWhere .= " and `tm_single_info`.create_time < date_add('".$addEDate."',interval 1 day)";    
        
        $accountState = Utility::GetFormInt("cbAccountState",$_GET);
        if($accountState != -100)
            $sWhere .= " and `tm_single_info`.`login_state`=".$accountState; 
                 
        $strOrderNo = Utility::GetForm("tbxOrderNo",$_GET);
        if($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%".$strOrderNo."%'";
                
        $strCustomerNo = Utility::GetForm("tbxCustomerNo",$_GET);
        if($strCustomerNo != "")
            $sWhere .= " and `cm_customer`.customer_no like '%".$strCustomerNo."%'";       
            
        $strCustomerName = Utility::GetForm("tbxCustomerName",$_GET);
        if($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%".$strCustomerName."%'";               
        
        $strAccountName = Utility::GetForm("tbxAccountName",$_GET);
        if($strAccountName != "")
            $sWhere .= " and `tm_single_info`.login_name like '%".$strAccountName."%'";               
                                     
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
                        
        $objCustomerUserBLL = new CustomerUserBLL();
        $arrPageList = $this->getPageList($objCustomerUserBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign('arrayOrder',$arrPageList['list']);        
        $this->smarty->display('OM/CustomerAccountBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
    public function OrderPriceStatus()
    {
        $id = Utility::GetFormInt('id',$_GET);
        
        if($id <= 0)
            exit("未找到此订单！");
        
        $objOrderBLL = new OrderBLL();   
        $objOrderInfo = $objOrderBLL->GetOrderPriceStatus($id,$this->getAgentId());
        if($objOrderInfo != null)
        {
            $arrayMoney = $objOrderInfo["money"];
            AgentAccountTypes::ReplaceArrayText($arrayMoney,"account_type");
            $arryLength = count($arrayMoney);
            $amount = 0;
            for($i =0 ;$i<$arryLength;$i++)
            {
                $amount += $arrayMoney[$i]["act_money"];
            }            
            
            $arrayMoney[$arryLength]["account_type"] = "合计";
            $arrayMoney[$arryLength]["act_money"] = $amount;
            
            Utility::FormatArrayMoney($arrayMoney,"act_money");
            $this->smarty->assign('act_price',$objOrderInfo["act_price"]); 
            $this->smarty->assign('check_status',$objOrderInfo["check_status"]); 
            $this->smarty->assign('is_charge',$objOrderInfo["is_charge"]); 
            
            $this->smarty->assign('arrayMoney',$arrayMoney);  
            $this->smarty->display('OM/OrderPriceStatus.tpl'); 
        }
        else
            exit("未找到数据！");
    }
    
    
    /**
     * @functional 订单提交第一步
    */
    public function UnitOrderPostStep1()
    {        
        $this->PageRightValidate("UnitOrderModify",RightValue::add);
        $this->smarty->assign('strTitle','添加订单'); 
        
        $iPactNotEffect = 0;//合同已经到期
        $objProductBLL = new ProductBLL();
        $productID = $objProductBLL->GetUnitProductID();
        $arrayProductType = $objProductBLL->GetProductTypeInfoByProductID($productID);
        if(isset($arrayProductType)&&count($arrayProductType) > 0)
        {
            $objAgentPactBLL = new AgentPactBLL();
            $arrayPact = $objAgentPactBLL->select("aid","agent_id=".$this->getAgentId()." and pact_status = ".AgentPactStatus::haveSign
                ." and concat(',',`am_agent_pact`.`product_id`,',') like concat('%,',".$arrayProductType[0]["aid"].",',%')","");
            if(!(isset($arrayPact)&&count($arrayPact) > 0))
            {
                $iPactNotEffect = 1;
            }
        }
        else
        {
            exit("合同查询出错！");
        }
        
        $customer_id = Utility::GetFormInt('customer_id',$_GET,-100);      
        $customer_name = "";
        if($customer_id > 0)
        {
            $objCustomerBLL = new CustomerBLL();
            $objCustomerInfo = $objCustomerBLL->select("cm.customer_name","ag.customer_id = cm.customer_id and ag.agent_id = ".$this->getAgentId()."
                and cm.customer_id=$customer_id and ag.is_del=0 and cm.is_del=0","");
            if(isset($objCustomerInfo) && count($objCustomerInfo) > 0)
            {
                $customer_name = $objCustomerInfo[0]["customer_name"];
            }
        }
        
        $this->smarty->assign('iPactNotEffect',$iPactNotEffect); 
        $this->smarty->assign('customer_id',$customer_id); 
        $this->smarty->assign('customer_name',$customer_name); 
        $this->smarty->assign('iProductID',$productID); 
        $this->displayPage('OM/UnitOrderPost1.tpl');   
    }
    
    /**
     * @functional 订单提交第一步数据提交
    */
    public function UnitOrderPost1Submit()
    {
        $this->ExitWhenNoRight("UnitOrderModify",RightValue::add);    
        
        $iProductId = Utility::GetFormInt('cbProduct',$_POST); 
        if($iProductId <= 0)
            exit("请选择产品！"); 
                  
        $iCustomerId = Utility::GetFormInt('tbxCustomerID',$_POST);
        if($iCustomerId <= 0)
            exit("请选择客户！");       
              
        exit("0,/?d=OM&c=Order&a=OrderModify");
    }
    
    /**
     * 续签页面
    */
    public function CSignOrderModify()
    {        
        $this->ExitWhenNoRight("OrderModify",RightValue::add);   
        $id = Utility::GetFormInt('id',$_GET); //源订单ID
        $cid = Utility::GetFormInt('cid',$_GET); //续签ID
        if(($id+$cid) <= 0)
            exit("参数有误"); 
            
        $objOrderBLL = new OrderBLL(); 
        $objOrderInfo = null;
        if($cid > 0)
        {
            $objOrderInfo = $objOrderBLL->getModelByID($cid,$this->getAgentId());  
            if($objOrderInfo == null)
                exit("未找到此订单！");
                 
            $id = $objOrderInfo->iSourceOrderId;
        }
        
        $objOrder = $objOrderBLL->getModelByID($id,$this->getAgentId());  
        if($objOrder == null)
            exit("未找到此订单！");  
                
        $objProductBLL = new ProductBLL();
        $productText = "";
        $arrayProduct = $objProductBLL->select("product_name,product_group,product_series,product_type_id","product_id=".$objOrder->iProductId);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
        {
            if($arrayProduct[0]["product_group"] == 1)
            {
                $productText = $arrayProduct[0]["product_name"];
            }
            else
                $productText = $arrayProduct[0]["product_name"].">".$arrayProduct[0]["product_series"];
        } 
        $strOrderEdate = "";
        if($objOrderInfo != null)
        {
            $strOrderEdate = $objOrderInfo->strOrderEdate;
            $objOrder->iActPrice = $objOrderInfo->iActPrice;
        }
        else
        {
            $strOrderEdate = Utility::addMonth($objOrder->strOrderEdate,12);
        }
        
        $this->smarty->assign('objOrder',$objOrder);
        $this->smarty->assign('strOrderEdate',$strOrderEdate);  
        $this->smarty->assign('strProductName',$productText); 
        $this->displayPage('OM/CSignOrderModify.tpl');           
    }
    
    
    
    /**
     * 提交续签
    */ 
    public function CSignOrderModifySubmit()
    {       
        $this->ExitWhenNoRight("OrderModify",RightValue::add);   
        $id = Utility::GetFormInt('id',$_POST);//源订单ID
        $cid = Utility::GetFormInt('cid',$_POST); //续签ID
        if(($id+$cid) <= 0)
            exit("参数有误");  
            
        $tbxPirce = Utility::GetFormDouble('tbxPrice',$_POST); 
        if($tbxPirce <= 0)
            exit("请输入产品金额！"); 
            
        $tbxEDate = Utility::GetForm('tbxEDate',$_POST); 
        if($tbxEDate == "" || Utility::isShortTime($tbxEDate) == false)
            exit("请输入续签结束日期！"); 
            
        $objOrderBLL = new OrderBLL();
        if($cid > 0)
        {
            //编辑续签
            $objOrderInfo = $objOrderBLL->getModelByID($cid,$this->getAgentId());  
            if($objOrderInfo == null)
                exit("未找到此订单！");  
            
            $this->f_CheckMoneyWhenPostOrder($objOrderInfo->iProductTypeId,$objOrderInfo->iProductId,$tbxPirce);
        
            $objOrderInfo->iActPrice = $tbxPirce;//金额        
            $objOrderInfo->strOrderEdate = $tbxEDate;
            $objOrderInfo->strEffectEdate = $objOrderInfo->strOrderEdate;
            $objOrderInfo->iCheckStatus = CheckStatus::auditting;                
            $objOrderInfo->iOrderStatus = OrderStatus::auditting;     
            $objOrderInfo->strOrderStatusText = OrderStatus::GetText($objOrderInfo->iOrderStatus);
            $objOrderBLL->updateByID($objOrderInfo);
            exit("0"); 
        }
        
        //---------------以下是新增续签订单代码---------------------
        
        $objOrder = $objOrderBLL->getModelByID($id,$this->getAgentId());  
        if($objOrder == null)
            exit("未找到此订单！");  
            
        $this->f_CheckMoneyWhenPostOrder($objOrder->iProductTypeId,$objOrder->iProductId,$tbxPirce);
        
        $objProductBLL = new ProductBLL();        
        $productNo = "";
        $arrayProduct = $objProductBLL->select("product_type_id,product_name,product_no","product_id=".$objOrder->iProductId);
        if(isset($arrayProduct) && count($arrayProduct) > 0)
        {
            $productNo = $arrayProduct[0]["product_no"];            
        }
        else
            exit("未找到产品信息！");
                    
        $objOrderInfo = new OrderInfo();
        $objAgentPactBLL = new AgentPactBLL();
        $arrayData = $objAgentPactBLL->GetAgentPact($this->getAgentId(),$objOrder->iProductTypeId);
        if(isset($arrayData) && count($arrayData)>0)
        {   
            $objOrderInfo->iAgentPactId = $arrayData[0]["agent_pact_id"];
            $objOrderInfo->strAgentPactNo = $arrayData[0]["pact_number"]."".$arrayData[0]["pact_stage"];
        }
        else
        {
            exit("未找到与此产品的签约合同！");
        }
                
        $objOrderInfo->strOrderNo = $objOrderBLL->getNewNo($objOrderInfo->iOrderType,$productNo,$this->getAgentNo());
    	$objOrderInfo->iOrderType = CustomerOrderTypes::continueOrder;
    	$objOrderInfo->iAgentId = $this->getAgentId();
        $objOrderInfo->strAgentNo = $this->getAgentNo();
        $objOrderInfo->strAgentName = $this->getAgentName();
        
        $objOrderInfo->iCustomerId = $objOrder->iCustomerId;
        $objOrderInfo->strCustomerName = $objOrder->strCustomerName;
        $objOrderInfo->iProductId = $objOrder->iProductId;
        
        $objOrderInfo->iActPrice = $tbxPirce;//金额        
        $objOrderInfo->strOrderSdate = Utility::addDay($objOrder->strOrderEdate,1);
        $objOrderInfo->strOrderEdate = $tbxEDate;
        $objOrderInfo->strEffectSdate = $objOrderInfo->strOrderSdate;
        $objOrderInfo->strEffectEdate = $objOrderInfo->strOrderEdate;
        
        $objOrderInfo->iPostUid = $this->getUserId(); 
        $objOrderInfo->strLegalPersonName = $objOrder->strLegalPersonName;
        $objOrderInfo->strLegalPersonId = $objOrder->strLegalPersonId;
        $objOrderInfo->strLegalPersonIdPath = $objOrder->strLegalPersonIdPath;
        $objOrderInfo->strBusinessLicense = $objOrder->strBusinessLicense;
        $objOrderInfo->strBusinessLicensePath = $objOrder->strBusinessLicensePath;
        $objOrderInfo->strPostDate = Utility::Now();
        $objOrderInfo->iCreateUid = $objOrderInfo->iPostUid;
        $objOrderInfo->iIsDel = 0;
        $objOrderInfo->strContactName = $objOrder->strContactName;
        $objOrderInfo->strContactMobile = $objOrder->strContactMobile;
        $objOrderInfo->strContactTel = $objOrder->strContactTel;
        $objOrderInfo->strContactFax = $objOrder->strContactFax;
        $objOrderInfo->strContactEmail = $objOrder->strContactEmail;
        $objOrderInfo->iSourceOrderId = $objOrder->iOrderId;
        $objOrderInfo->strSourceOrderNo = $objOrder->strOrderNo;
        
        $objOrderInfo->strServiceTel = $objOrder->strServiceTel;
        $objOrderInfo->iProductTypeId = $objOrder->iProductTypeId;
              
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objOrderInfo->iAccountGroupId = $objAccountGroupUserBLL->getGroupIdByAgentId($this->getAgentId());
        
        $objOrderInfo->iOwnerId = $objOrder->iOwnerId;
        $objOrderInfo->strOwnerAccountName = $objOrder->strOwnerAccountName;
        $objOrderInfo->strOwnerLoginPwd = $objOrder->strOwnerLoginPwd;
        $objOrderInfo->strOwnerWebsiteName = $objOrder->strOwnerWebsiteName;
        $objOrderInfo->strOwnerDomainUrl = $objOrder->strOwnerDomainUrl;
            
    	$objOrderInfo->iCheckStatus = CheckStatus::auditting;                
        $objOrderInfo->iOrderStatus = OrderStatus::auditting;     
        $objOrderInfo->strOrderStatusText = OrderStatus::GetText($objOrderInfo->iOrderStatus);
        $newID = $objOrderBLL->insert($objOrderInfo);
        if($newID > 0)
        {
            $objOrderBLL->AddOrderFreezeMoney($newID,$this->getUserId());  
            $objOrderBLL->UpdateOrderStatus($id,$this->getUserId(),OrderStatus::haveContinueOrder);
            $objOrderWebsiteBLL = new OrderWebsiteBLL();  
            $arrayData = $objOrderWebsiteBLL->SelectDataByOrderID($id);
            foreach($arrayData as $key => $value)
            {
                $objOrderWebsiteBLL->insertData($newID,$value["website_provider"],$value["website_name"]);
            }
        }
        
        exit("0"); 
    }
    
}
?>