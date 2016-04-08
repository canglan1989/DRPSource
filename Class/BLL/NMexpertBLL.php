<?PHP

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：网营专家业务逻辑层
 * 表描述：
 * 创建人：Calycao  caole@adpanshi.com
 * 添加时间：2011-10-9
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';

class NMexpertBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }
    
    //获取诚信认证产品有效期 $customer_id--客户ID $website_name--域名
    public function GetAuthenticationDate($customer_id,$website_name)
    {
        $sql = "select ord.`effect_sdate`,ord.`effect_edate` 
                from `om_order` ord LEFT join `om_order_website` site on ord.`order_id`=site.`order_id`
                where ord.`customer_id`=".$customer_id." and site.`website_name`='".$website_name."' 
                group by ord.order_id";
                
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    //获得指定客户的客服信息 $customer_id--客户ID
    public function GetCustomerService($customer_id)
    {
        $sql = "select `e_name`,`user_name`,`contact_tel`,`contact_mobile`,`contact_email` 
                from `om_order` ord 
                LEFT join `sys_user` user on ord.`create_uid`=user.`user_id`
                where ord.`customer_id`=".$customer_id;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    //获取磐邮产品有效期 $customer_id--客户ID
    public function GetPanshiMailDate($customer_id)
    {
        $sql = "select ord.`effect_sdate`,ord.`effect_edate`
                from `tm_eMail` email LEFT join `om_order` ord on email.`order_id`=ord.`order_id`
                where ord.`customer_id`=".$customer_id."
                group by email.aid";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
}