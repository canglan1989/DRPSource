<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：所有邮箱业务功能
 * 表描述：
 * 创建人：lxs  linxishengjiong@163.com
 * 添加时间：2011-9-5 15:18:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../BLL/TMCommonBLL.php';
require_once __DIR__ . '/../BLL/OrderBLL.php';

class TMRealNameBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    //获取域名解析头部信息
    public function GetRealmNameHeadData($where)
    {
        $sql = "
select
case when net.`analy_uid`<>0 then 1 else 0 end analy,
case when (net.`analy_uid`=0 or net.`analy_uid` is null) then 1 else 0 end un_analy
 from `om_order` ord 
join `sys_product` pro on pro.`product_id`=ord.`product_id`
left join 
(
select `order_id`,`analy_uid`,`analy_time`,`info_confirm_uid` from `tm_eMail`
union
select `order_id`,`analy_uid`,`analy_time`,'1' `info_confirm_uid` from `tm_net`
)net on ord.order_id = net.order_id
 where 
ord.`check_status`=1 and ord.`order_type`=1
and ord.`product_id` in(select `product_id` from `sys_product` _pro where _pro.`product_type_id` in(select `aid` from `sys_product_type` _type where `product_type_no`='wymh' or `product_type_no`='py'))
and ((pro.`product_type_id`=1 and net.info_confirm_uid<>0) or (pro.`product_type_id`=2))";
        if ($where <> "") {
            $sql .= $where;
        }
        $sql = "select sum(analy)analy,sum(un_analy)un_analy from 
($sql)tb";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //主列表数据
    public function GetListData($where, $outWhere)
    {
        //订单号 客户名称 产品 域名 解析状态 下单时间 操作时间 操作人
        $sql = "select 
ord.order_id,
ord.`order_no`,
customer_id,
net.analy_uid,
concat(`customer_name`,'/',`customer_id`) cus_name_id,
pro.`product_series` product_name,
pro.`product_type_id`,
(select GROUP_CONCAT(`website_name` SEPARATOR '<br />') from `om_order_website` site where site.order_id=ord.order_id group by site.order_id)web_site,
case when net.analy_uid<>0 then '已解析' else '未解析' end is_analy,
net.`analy_time`,
(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`analy_uid`)analy_name,
ord.`last_check_time`,
1
from `om_order` ord 
join `sys_product` pro on pro.`product_id`=ord.`product_id` 
inner join sys_product_type _type on _type.aid = pro.`product_type_id`
left join
(
select `order_id`,`analy_uid`,`analy_time`,`info_confirm_uid` from `tm_eMail`
union
select `order_id`,`analy_uid`,`analy_time`,'1' `info_confirm_uid` from `tm_net`
)net
on ord.`order_id`=net.`order_id` 
where 1=1
and ord.`check_status`=1 and ord.`order_type`=1 
and (_type.`product_type_no`='wymh' or (_type.`product_type_no`='py' and net.info_confirm_uid<>0)) ";
        if ($where <> "") {
            $sql .= $where;
        }
        //die($sql);
        $sql = "select * from($sql)tb where 1=1";
        if ($outWhere <> "") {
            $sql .= $outWhere;
        }
        //die($sql);
        return self::getPageData(self::getOrderBySQl($sql, ""));
    }
}
?>