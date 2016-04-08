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
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/AgContactBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__.'/../../Class/BLL/AdhaiCustomerAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/DRPCityToAdhaiBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerExBLL.php';
require_once __DIR__.'/../../Class/BLL/DataConfigBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderMoveLogBLL.php';

class UnitOrderAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->MyUnitOrderList();
    }
        
    /**
     * @functional 网盟订单列表
    */
    public function MyUnitOrderList()
    {
        $this->PageRightValidate("MyUnitOrderList",RightValue::view);
        
        $this->smarty->assign('MyUnitOrderListBody',"/?d=OM&c=UnitOrder&a=MyUnitOrderListBody"); 
        $this->displayPage('OM/MyUnitOrderList.tpl');
    }
    
     
    /**
     * @functional 网盟订单列表
    */
    public function MyUnitOrderListBody()
    {
        $this->ExitWhenNoRight("MyUnitOrderList",RightValue::view);
                        
        $sWhere = " and om_order.agent_id=".$this->getAgentId()." and om_order.finance_uid=".$this->getFinanceUid()." and `cm_customer_agent`.user_id=".$this->getUserId();
                    
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
        
        /*
        $iIsNotEffect = Utility::GetFormInt("cbIsNotEffect",$_GET);
        if($iIsNotEffect == 1)//已失效
        {
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate <'".Utility::Today()."'";
        }   
        else if($iIsNotEffect == 0)//未失效
        {
            $sWhere .= " and om_order.`check_status` = ".CheckStatus::isPass." and `om_order`.effect_edate >='".Utility::Today()."'";
        } 
        */
        
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
        
        $objOrderBLL = new UnitOrderBLL();
        $arrPageList = $this->getPageList($objOrderBLL,"*",$sWhere,"",$iPageSize);
        CustomerOrderTypes::ReplaceArrayText($arrPageList['list'],"order_type");
        $this->smarty->assign('arrayOrder',$arrPageList['list']);
        $this->smarty->display('OM/MyUnitOrderListBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
     
    
    /**
     * 网盟的验证
    */
    protected function f_WM_OrderModifySubmitCheck()
    {               
        $strAccountName = Utility::GetForm('tbxAccountName',$_POST,50);
        if ($strAccountName == "")
            exit("请输入客户账户名称！");   
        
        $strPwd = Utility::GetForm('tbxPwd',$_POST,50);
        if ($strPwd == "")
            exit("请输入客户账户密码！");           
        
        $strPwdCheck = Utility::GetForm('tbxPwdCheck',$_POST,50);
        if ($strPwdCheck == "")
            exit("请输入客户账户确认密码！"); 
            
        if($strPwd != $strPwdCheck)
            exit("请输入客户账户确认密码与密码不同！"); 
            
        $strWebSiteName = Utility::GetForm('tbxWebSiteName',$_POST,50);
        if ($strWebSiteName == "")
            exit("请输入客户推广网站名称！");
        
        $strWebSite = Utility::GetForm('tbxWebSite',$_POST,128);            
        if($strWebSite == "")
            exit("请输入客户推广域名名称！");
            
        $contact_fax = Utility::GetForm('contact_fax',$_POST,128);            
        if($contact_fax == "")
            exit("请输入传真号码！");
            
        $contact_email = Utility::GetForm('contact_email',$_POST,128);            
        if($contact_email == "")
            exit("请输入电子邮箱！");
            
        $iCustomerID = Utility::GetFormInt('tbxCustomerID',$_POST);
        if($iCustomerID <= 0)
            exit("客户ID有误！");
            
        $objAdhaiCustomerAccountBLL = new AdhaiCustomerAccountBLL();
        if($objAdhaiCustomerAccountBLL->IsExistAccountName($strAccountName))
            exit("该客户账户名称已经存在！");
            
    }
    
    /**
     * @functional 订单数据提交
    */
    public function OrderModifySubmit()
    {        
        if (!$this->HaveRight("UnitOrderModify",RightValue::add))
            exit("您没有此操作权限！");
        
        $id = Utility::GetFormInt('id',$_POST);
        $productID = Utility::GetFormInt('tbxProductID',$_POST);
        if($productID <= 0)
            exit("请选择产品！");
                    
        $customerID = Utility::GetFormInt('tbxCustomerID',$_POST);
        if($customerID <= 0)
            exit("请选择客户！");
                                    
        $sData = "2000-01-01";
        $eData = "2000-01-01";
        
        $legalPersonName = Utility::GetForm('tbxLegalPersonName',$_POST,10);        
        if($legalPersonName == "")
            exit("请输入客户法人姓名。若为个人用户，请填写联系人姓名。");
        
        $legalPersonID = Utility::GetForm('tbxLegalPersonID',$_POST,24);
        /*if($legalPersonID == "")
            exit("请输入客户法人身份证！");*/
        
        $permit = Utility::GetForm('tbxPermit',$_POST,64);
        /*if($permit == "")
            exit("请输入客户营业执照！");*/
               
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
        /*
        if($legalPersonIDPath == "")
            exit("请上传客户法人身份证！");
        */
        $permitPath = Utility::GetForm('permitJ_upload1',$_POST,128);//tbxPermitPath
        /*
        if($permitPath == "")
            exit("请上传客户营业执照！");
        */
        $this->f_WM_OrderModifySubmitCheck();
        
        
        /*----------------------合同数据--------------------s------------*/
        $agentPactID = 0;
        $agentPactNo = "";
        $productTypeID = 0;
        $strProductTypeName = "";
        
        $objProductBLL = new ProductBLL();
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
            /*------------------------订单提交时的存款限制-------------0不限制------------s--------*/
            $objComSettingBLL = new ComSettingBLL();
            $objAgentAccountBLL = null;
            $iPreMoney = 0;
            $iGuaMoney = 0;
            $iPreMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::UnitOrder_PreAccountBalance);
                
            if($iPreMoney > 0)
            {
                $objAgentAccountBLL = new AgentAccountBLL();                
                //预存款可用金额
                $iPreCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::UnitPreDeposits,$productTypeID);
                if(round($iPreCanUseMoney,2) < round($iPreMoney,2))
                    exit("您好，您的{$strProductTypeName}预存款不足，请将订单保存，并及时充值。");
            }
            
            $iGuaMoney = $objComSettingBLL->GetValueByNameWithOutLock(ComSettings::UnitOrder_GuaAccountBalance ); 
                
            if($iGuaMoney > 0)
            {
                if($objAgentAccountBLL == null)
                    $objAgentAccountBLL = new AgentAccountBLL(); 
                //保证金可用金额
                $iGuaCanUseMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->getAgentId(),$this->getFinanceNo(),AgentAccountTypes::GuaranteeMoney,$productTypeID);
                
                //print_r(round($iGuaCanUseMoney,2) ."==========". round($iGuaMoney,2));                
                if(round($iGuaCanUseMoney,2) < round($iGuaMoney,2))
                    exit("您好，您的{$strProductTypeName}保证金不足，请将订单保存，并及时充值。");
            }
            
            /*------------------------订单提交时的存款限制-------------0不限制------------e--------*/
    
            //客户订单已存在的提示 
            $orderCounts = $objOrderBLL->TodayPostedOrderCount($this->getAgentId(),$customerID,$productID);
            if($orderCounts >= 2)
                exit("对同一客户同一产品的订单，24小时内只允许提交2次，请您选择保存当前订单！");
            
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
        if($strComWebSite == "")
            $strComWebSite = Utility::GetForm('tbxWebSite',$_POST,128);
            
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
        
        /*    
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
        */
        
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
        
        $objOrderInfo->iActPrice = 0;
        
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
        
    	$objOrderInfo->strBusinessLicensePath = $permitPath;
    	$objOrderInfo->strLegalPersonIdPath = $legalPersonIDPath;
        
    	$objOrderInfo->strBusinessLicense = $permit;
    	$objOrderInfo->strLegalPersonId = $legalPersonID;
        
        $objOrderInfo->iAgentPactId = $agentPactID;
        $objOrderInfo->strAgentPactNo = $agentPactNo;       
        $strServiceTel = Utility::GetForm('tbxServiceTel',$_POST);
        if($strServiceTel != "")
            $objOrderInfo->strServiceTel = $strServiceTel;
                        
        $objOrderInfo->strOwnerAccountName = Utility::GetForm("tbxAccountName",$_POST,64);            
        $objOrderInfo->strOwnerLoginPwd = Utility::GetForm('tbxPwd',$_POST,64);
        $objOrderInfo->strOwnerWebsiteName = Utility::GetForm('tbxWebSiteName',$_POST,50);
        $objOrderInfo->strOwnerDomainUrl = Utility::GetForm('tbxWebSite',$_POST,128);
        
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objOrderInfo->iAccountGroupId = $objAccountGroupUserBLL->getGroupIdByAgentId($this->getAgentId());///区域组///
                
        if($postCheck == 1)
        {            
       	    $objOrderInfo->iPostUid = $this->getUserId(); 
                        
            $objOrderInfo->iIsCharge = 1;
        	$objOrderInfo->iCheckStatus = CheckStatus::isPass;                
            $objOrderInfo->iOrderStatus = OrderStatus::isPass;     
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
        
        $newOwnerID = 0;
        if($postCheck == 1)
        {                             
            $adhaiProciceCode = "";
            $adhaiCityCode = "";
            $objDRPCityToAdhaiBLL = new DRPCityToAdhaiBLL();
            $objDRPCityToAdhaiBLL->GetAdhaiID($objCustomerInfo->iAreaId,$adhaiProciceCode,$adhaiCityCode);
            
            /* 添加 Adhai客户帐户的信息*/
            $arrayCustomerAccountInfo = array(
            "user_id"=>$this->getUserId(),
            "agent_id"=>$this->getAgentId(),
            "strLogin"=>$objOrderInfo->strOwnerAccountName,
            "strPassword"=>$objOrderInfo->strOwnerLoginPwd,
            "strEmail"=>$objOrderInfo->strContactEmail,
            "strCompany"=>$objOrderInfo->strCustomerName,
            "strSitename"=>$objOrderInfo->strOwnerWebsiteName,
            "strDomain"=>$objOrderInfo->strOwnerDomainUrl,
            "iProvince"=>$adhaiProciceCode,
            "iCity"=>$adhaiCityCode,
            "strContactor"=>$objOrderInfo->strContactName,
            "strAddress"=>$objCustomerInfo->strAddress,
            "strPostcode"=>$objCustomerInfo->strPostcode,
            "strPhone"=>$objOrderInfo->strContactTel,
            "strMobile"=>$objOrderInfo->strContactMobile,
            "strFax"=>$objOrderInfo->strContactFax,
            "iCustomerId"=>$objOrderInfo->iCustomerId);
            
            $objAdhaiCustomerAccountBLL = new AdhaiCustomerAccountBLL();
            
            $newOwnerID = $objAdhaiCustomerAccountBLL->AddAccount($arrayCustomerAccountInfo);
            
            if($newOwnerID<=0)
                exit("帐号开通失败！");
                
            //$newOwnerID = $this->f_WM_OrderModifyAccountInfo($id);            
        }
        
        $objOrderInfo->iOwnerId = $newOwnerID;
        
        if($id > 0)
        {
            if($objOrderBLL->updateByID($objOrderInfo) <= 0)                
                exit("修改失败！");
        }
        else
        {
            $id = $objOrderBLL->insert($objOrderInfo);
            if($id <= 0)   
                exit("添加失败！");
        }
        
        if($postCheck == 1)
        {
            $objOrderBLL->UpdateCustomerBuyProducts($objOrderInfo->iCustomerId,$objOrderInfo->iAgentId);
        }
        
        exit("0,".$id);
    }
     
    
    public function AddAdhaiAccountToBasePlatform()
    {        
        return;
        $orderID = Utility::GetFormInt('orderID',$_POST);
            
        if($orderID > 0)
        {
            $objOrderBLL = new OrderBLL();  
            $rtn = $objOrderBLL->AddAdhaiAccountToBasePlatform($orderID);
            exit(get_object_vars($rtn));
        }
        
        exit("参数有误！");
    }
    
    /**
     * @functional 登录到网盟
     * @return json data
    */ 
    public function GetLoginToOwnerUrl()
    {
        $oid = Utility::GetFormInt("oid",$_POST);
        if($oid <= 0)
            exit("客户ID有误！");
            
        $objAdhai_LoginService = new Adhai_LoginService();
        $url = $objAdhai_LoginService->GetLoginToOwnerUrl($oid,$this->getUserName());
        exit($url);
    }
    
    /**
     * @functional 登录到网盟 定向到 资质列表
     * @return json data
    */ 
    public function GetLoginToCertUrl()
    {
        $oid = Utility::GetFormInt("oid",$_POST);
        if($oid <= 0)
            exit("客户ID有误！");
            
        $objAdhai_LoginService = new Adhai_LoginService();
        $url = $objAdhai_LoginService->GetLoginToCertUrl($oid,$this->getUserName());
        exit($url);
    }
    
    /**
     * @functional 网盟订单卡片信息
    */
    public function getOrderStatusWm()
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
        $arrayStatus = $objOrderBLL->getOrderStatusWm($orderID);
            
        $this->smarty->assign('arrayStatus',$arrayStatus);   
        $this->smarty->assign('backhtml',$strBackHtml);
        $this->displayPage("OM/WM_OrderStatus.tpl");
    }
    
    public function UnitOrderMoveList(){
        $this->PageRightValidate("UnitOrderMove", RightValue::view);
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("OM", "UnitOrder", "UnitOrderMoveBody"));
        $this->displayPage('OM/UnitOrderMoveList.tpl');
    }
    
    public function UnitOrderMoveBody(){
        $this->ExitWhenNoRight("UnitOrderMove", RightValue::view);
        $strWhere = $this->UnitOrderMoveWhere();
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objOrderMoveLogBLL = new OrderMoveLogBLL();
        $arrLogList = $objOrderMoveLogBLL->getUnitOrderMoveList($strWhere, $strOrder);
        $this->showPageSmarty($arrLogList, 'OM/UnitOrderMoveBody.tpl');
    }
    
    public function UnitOrderMoveWhere(){
        $strWhere = "";
        $strFromAgentName = Utility::GetForm("from_agent", $_GET);
        if($strFromAgentName != ""){
            $strWhere .=" and om_order_move_log.from_agent_name like '%{$strFromAgentName}%' ";
        }
        
        $strToAgentName = Utility::GetForm("to_agent", $_GET);
        if($strToAgentName != ""){
            $strWhere .= " and om_order_move_log.to_agent_name like '%{$strToAgentName}%' ";
        }
        
        $strOrderNo = Utility::GetForm("order_no", $_GET);
        if($strOrderNo != ""){
            $strWhere .= " and om_order_move_log.order_no like '%{$strOrderNo}%' ";
        }
        
        $strNewOrderNo = Utility::GetForm("new_order_no", $_GET);
        if($strNewOrderNo != ""){
            $strWhere .= " and om_order_move_log.new_order_no like '%{$strNewOrderNo}%' ";
        }
        
        $strBeginTime = Utility::GetForm("create_time_begin", $_GET);
        if(!empty ($strBeginTime)&&Utility::isShortTime($strBeginTime)){
            $strWhere .= " and om_order_move_log.create_time >= '{$strBeginTime}' ";
        }
        
        $strEndTime = Utility::GetForm("create_time_end", $_GET);
        if(!empty ($strEndTime)&&Utility::isShortTime($strEndTime)){
            $strWhere .= " and om_order_move_log.create_time < DATE_ADD('{$strEndTime}',INTERVAL 1 DAY) ";
        }
        
        $strAdHaiAccount = Utility::GetForm("adhaiaccount", $_GET);
        if($strAdHaiAccount != ""){
            $strWhere .= " and om_order.owner_account_name like '%{$strAdHaiAccount}%' ";
        }
        
        return $strWhere;
        
    }
}
?>