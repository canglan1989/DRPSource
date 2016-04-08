<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：
 * 表描述：
 * 创建人：wzx
 * 添加时间：2012-3-5
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../../WebService/CRM_Service.php';

class AdhaiCustomerAccountBLL extends BLLBase
{
    /**
     * @functional 帐号名是否存在 不能修改的
    */
    public function IsExistAccountName($strAccountName)
    {
        $objCRM_Customer_Service = new CRM_Customer_Service();
        return $objCRM_Customer_Service->IsExistLoginName($strAccountName);
    }
    
    
    /**
     * @functional 添加帐号
     * @return 插入成功后的客户ID
    */
    public function AddAccount($arrayCustomerAccountInfo)
    {
        $objCRM_Customer_Service = new CRM_Customer_Service();
        return $objCRM_Customer_Service->AddAccount($arrayCustomerAccountInfo);
    }
}