<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：向网营专家提供 WebService 接口
 * 创建人：Calycao  caole@adpanshi.com
 * 添加时间：2011-10-9
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__ . '/../Class/BLL/NMexpertBLL.php';

class Netmarketing
{
    public function __construct()
    {
        if (!defined("SYS_CONFIG")) {
            //读取配置文件
            $arrSysConfig = require __DIR__ . '/../Config/SysConfig.php';
            define("SYS_CONFIG", serialize($arrSysConfig));
        }
    }
    
    
    /**
     * @functional 获取诚信认证产品有效期
     * @param $customer_id 客户ID
     * @param $website_name 域名
     * @return string $date 截止日期为空，表示没有开通
     */ 
    public function GetAuthenticationDate($customer_id,$website_name)
    {
        $nmexpertBLL = new NMexpertBLL();
        return $nmexpertBLL->GetAuthenticationDate($customer_id,$website_name);
    }
    
    
    /**
     * @function 获得指定客户的客服信息
     * @param $customer_id 客户ID
     * @return string $array 客服信息列表数据
     */
    public function GetCustomerService($customer_id)
    {
        $nmexpertBLL = new NMexpertBLL();
        return $nmexpertBLL->GetCustomerService($customer_id);
    }
     
     
    /**
     * @function 获取磐邮产品有效期
     * @param $customer_id 客户ID
     * @return string $date 有效期为空，表示没有开通
     */
     public function GetPanshiMailDate($customer_id)
     {
         $nmexpertBLL = new NMexpertBLL();
         return $nmexpertBLL->GetPanshiMailDate($customer_id);
     }

}
ini_set("soap.wsdl_cache_enabled", 0);
$soap = new SoapServer(null, array('uri' => '127.0.0.1'));
$soap->setClass('Netmarketing');
$soap->handle();