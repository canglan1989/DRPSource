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
require_once __DIR__.'/../../Class/BLL/CustomerPermitBLL.php';
require_once __DIR__ . '/../Common/ShowImage.php';

class CustomerPermitAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
    }
            
    /**
     * @functional 客户资质  营业执照
     */
    public function ShowBusinessLicense()
    {
        $icustomerID = Utility::GetFormInt("customerID",$_GET);
        if($icustomerID <= 0)
            exit("客户ID参数有误！");
            
        $objCustomerPermitBLL = new CustomerPermitBLL();   
        $filePath = $objCustomerPermitBLL->GetBusinessLicensePath($icustomerID,$this->getAgentId());
        if($filePath == "")
            exit("未找到相应资质！");
            //exit($filePath);
        $objShowImage = new ShowImage();
        $objShowImage::Show($filePath);
    }
    
    
    /**
     * @functional 客户资质  法人身份证
     */
    public function ShowCorporatePhoto()
    {
        $icustomerID = Utility::GetFormInt("customerID",$_GET);
        if($icustomerID <= 0)
            exit("客户ID参数有误！");
            
        $objCustomerPermitBLL = new CustomerPermitBLL();   
        $filePath = $objCustomerPermitBLL->GetCorporatePhotoPath($icustomerID,$this->getAgentId());
        if($filePath == "")
            exit("未找到相应资质！");
            
            //exit($filePath);
        $objShowImage = new ShowImage();
        $objShowImage::Show($filePath);
    }
}