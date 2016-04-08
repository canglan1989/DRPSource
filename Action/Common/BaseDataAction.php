<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：基础数据模块
 * 创建人：wzx
 * 添加时间：2011-8-9 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/BaseDataBLL.php';

class BaseDataAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
    }
    
    /**
     * @functional 支付类型
    */
    public function GetPayType()
    {
        $objBaseDataBLL = new BaseDataBLL();
        return $objBaseDataBLL->GetCommDataJson(BaseDataTypes::payType);
    }
}
?>