<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：订单客户账号管理模块
 * 创建人：wzx
 * 添加时间：2011-8-9 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/OrderBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerUserBLL.php';
require_once __DIR__.'/../../Class/BLL/TMSingleLoginBLL.php';

class CustomerUserAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->CustomerUserManager();
    }
        
    /**
     * @functional 客户订单列表
    */
    public function CustomerUserManager()
    {
        $this->PageRightValidate("CustomerUserManager",RightValue::view);
        
        $this->smarty->assign('strTitle','客户账号查询');
        
        $this->smarty->assign('customerUserManagerBody',"/?d=OM&c=CustomerUser&a=CustomerUserManagerBody"); 
        $this->displayPage('OM/CustomerUserManager.tpl');
    }
     
    /**
     * @functional 客户订单列表数据内容
    */
    public function CustomerUserManagerBody()
    {        
        $this->PageRightValidate("CustomerUserManager",RightValue::view);
        $sWhere = "";
             
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
            
        $strAgentName = Utility::GetForm("tbxAgentName",$_GET);
        if($strAgentName != "")
            $sWhere .= " and `om_order`.agent_name like '%".$strAgentName."%'";   
            
        $strCustomerNo = Utility::GetForm("tbxCustomerNo",$_GET);
        if($strCustomerNo != "")
            $sWhere .= " and `cm_customer`.customer_no like '%".$strCustomerNo."%'";       
            
        $strCustomerName = Utility::GetForm("tbxCustomerName",$_GET);
        if($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%".$strCustomerName."%'";           
                       
        $strAccountName = Utility::GetForm("tbxAccountName",$_GET);
        if($strAccountName != "")
            $sWhere .= " and `tm_single_info`.`login_name` like '%".$strAccountName."%'";   
                
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
            
            
        $objCustomerUserBLL = new CustomerUserBLL();
        $arrPageList = $this->getPageList($objCustomerUserBLL,"*",$sWhere,"",$iPageSize);
        
        $this->smarty->assign('arrayOrder',$arrPageList['list']);        
        $this->smarty->display('OM/CustomerUserManagerBody.tpl');
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
       
    }
    
     
    /**
     * @functional 开启、停用、订单对应的账号
    */
    public function LockCustomerUser()
    {
        $this->PageRightValidate("CustomerUserManager",RightValue::edit);
        $id = Utility::GetFormInt("id",$_GET);//用户单点登录的用户ID
        $iIsLock = Utility::GetFormInt("islock",$_GET);//1是
        $bIsLock = false;
        if($iIsLock == 1)
            $bIsLock = true;
            
        $objTMSingleLoginBLL = new TMSingleLoginBLL();
        if($objTMSingleLoginBLL->LockUser($id,$bIsLock,$this->getUserId()))
            exit("0");
        else
            exit("更新失败！");
    }
    
      
    /**
     * @functional 重置账号密码
    */
    public function ResetPwd()
    {
        exit("{'success':false,'msg':'单点中还未实现该功能！'}");
        
        $this->PageRightValidate("CustomerUserManager",RightValue::view);
        $id = Utility::GetFormInt("id",$_GET);//用户单点登录的用户ID
        
        $objTMSingleLoginBLL = new TMSingleLoginBLL();
        $objUserBLL = new UserBLL();
        $iniPwd = "888888";
        
        if($objTMSingleLoginBLL->ResetPwd($id,$this->getUserId(),$iniPwd) > 0)
            exit("{'success':true,'msg':'密码重置成功！新密码为：".$iniPwd."'}");
        else
            exit("{'success':false,'msg':'密码重置失败！'}");
    }
    
}    
?>