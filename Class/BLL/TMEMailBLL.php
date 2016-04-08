<?PHP

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：所有邮箱业务功能
 * 表描述：
 * 创建人：lxs  linxishengjiong@163.com
 * 添加时间：2011-9-5 15:18:29
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../BLL/TMCommonBLL.php';
require_once __DIR__ . '/../BLL/OrderBLL.php';

class TMEMailBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    public function GetListData($where, $outWhere)
    {
        $sql = "
select 
ord.`order_no`,
ord.order_id,
customer_id,
agent_id,
concat(`customer_name`,'/',`customer_id`) cus_name_id,
product_series product_name,
product_specs,
case when ord.`order_type`=1 then '新签' when ord.`order_type`=2 then '续签' when ord.`order_type`=-1 then '退单' else '未知' end order_type,
case when state=5 then '已开通' when state=4 then '解析失败' when state=3 then '已解析' when state=2 then '已申请' when state=1 then '已确认' when (state=0 or state is null) then '未确认' else '未知' end order_state,
(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=ord.`post_uid`)user_name,
date_format(ord.`create_time`,'%y-%m-%d')create_time,
ord.`contact_name`,
concat(ord.`contact_mobile`,' ',ord.`contact_tel`)contact_way,
ord.`last_check_time`,
case when mail.`info_confirm_uid`<>0 then '已确认' else '未确认' end info_state,
case when mail.`analy_uid`<>0 then '已解析' else '未解析' end analy_state,
case when mail.`turnOn_uid`<>0 then '已开通' else '未开通' end mail_state,
concat(date_format(ord.`order_sdate`,'%y-%m-%d'),'至<br />',date_format(ord.`order_edate`,'%y-%m-%d'))order_date,
concat(date_format(ord.`effect_sdate`,'%y-%m-%d'),'至<br />',date_format(ord.`effect_edate`,'%y-%m-%d'))effect_date,
turnOn_time,
concat(`agent_name`,'/',`agent_no`)agent_name_id,
(select group_concat(`website_name` SEPARATOR '<br />') from `om_order_website` web where web.`order_id`=ord.order_id group by ord.`order_id`) web_site,
1
from `om_order` ord 
left join `tm_eMail` mail on ord.`order_id`=mail.`order_id` 
left join sys_product pro on pro.`product_id`=ord.`product_id`
where 1=1
and ord.`check_status`=1 and ord.`order_type`=1
and ord.`product_id` in(select `product_id` from `sys_product` _pro where _pro.`product_type_id` in(select `aid` from `sys_product_type` _type where `product_type_no`='py'))
";
        if ($where <> "") {
            $sql .= $where;
        }
        $sql = "select * from($sql)tb where 1=1";
        if ($outWhere <> "") {
            $sql .= $outWhere;
        }
        //die($sql);
        return self::getPageData(self::getOrderBySQl($sql, ""));
    }

    public function GetOrderFlow($order_id)
    {
        $tmCommonBLL = new TMCommonBLL();
        $ordrSql = $tmCommonBLL->getOrderFlowSQL($order_id, "email");
        $sqlOrderList = "";
        if ($tmCommonBLL->iExistEmailOrder($order_id, 0)) {
            $sqlOrderList = "
{$ordrSql}
union
select '代理商确认内容开通',(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=mail.`info_confirm_uid`)ope_name,info_confirm_time,case when info_confirm_uid<>0 then '已确认' end 'result','-' remark from `tm_eMail` mail where mail.order_id=$order_id
union
select '域名申请',(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=mail.`apply_uid`)ope_name,apply_time,case when apply_uid<>0 then '已申请' end 'result','-' remark from `tm_eMail` mail where mail.order_id=$order_id
union
select '解析邮箱域名',(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=mail.`analy_uid`)ope_name,analy_time,case when analy_uid<>0 then '已解析' end 'result','-' remark from `tm_eMail` mail where mail.order_id=$order_id
union
select '邮箱开通',(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=mail.`turnOn_uid`)ope_name,turnOn_time,case when turnOn_uid<>0 then '已开通' end 'result','-' remark from `tm_eMail` mail where mail.order_id=$order_id
";
        } else { //不存在该任务 则任务流程全部显示空
            $sqlOrderList = "
{$ordrSql}
union
select '代理商确认内容开通','','','','-'
union
select '域名申请','','','','-'
union
select '解析邮箱域名','','','','-'
union
select '邮箱开通','','','','-'
";
        }
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlOrderList, null);
    }

    public function setInfoStatus($order_id, $ids, $domains)
    {
        $sql = "delete from om_order_website where order_id=$order_id;";
        $sql .= "insert into om_order_website (order_id,website_provider,website_name) values";
        $arrIDS = explode(",", $ids);
        $arrDomain = explode(",", $domains);
        foreach ($arrIDS as $key => $value) {
            switch ($value) {
                case 1:
                    $provider = "厂商提供";
                    break;
                case 2:
                    $provider = "代理商提供";
                    break;
                case 3:
                    $provider = "客户提供";
                    break;
                default:
                    $provider = "";
            }
            $url = $arrDomain[$key];
            $sql .= "($order_id,'$provider','$url'),";
        }
        $sql = substr($sql, 0, -1);
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //确认信息状态 $order_id--订单号 $con_uid--确认人 $domains--域名
    public function ConfirmInfo($order_id, $con_uid, $domains)
    {
        $tMCommonBLL = new TMCommonBLL();
        $sql = "";
        if (!$tMCommonBLL->iExistEmailOrder($order_id, $con_uid)) {
            $sql = "insert into `tm_eMail`(`order_id`,`state`,`info_confirm_uid`,`info_confirm_time`)
values($order_id,1,$con_uid,now());";
        } else {
            $sql = "update `tm_eMail` mail
set mail.`state`=1,mail.`info_confirm_uid`=$con_uid,mail.`info_confirm_time`=now()
where mail.order_id=$order_id;";
        }
        $order_info = $tMCommonBLL->getEmailInfo($order_id);
        if (count($order_info) <> 0) {
            $info = $order_info[0];
            $param = array($info["customer_name"], $info["order_sdate"], $info["order_edate"],
                $info["product_specs"], $info["whole_cubage"], $info["single_cubage"], $domains);
            $rtn = $tMCommonBLL->doSoapEmail("CreateCorp", $param);
            $rtn = json_decode($rtn);
            //print_r($rtn);exit;
            if ($rtn && $rtn->DbId <> 0) {
                //保存CorpId DbId到邮箱任务
                $sql .= "update `tm_eMail` mail
set mail.`CorpId`=$rtn->CorpId,mail.`DbId`=$rtn->DbId where mail.order_id=$order_id;";
                $this->objMysqlDB->executeNonQuery(false, $sql, null);
            }
            return $rtn;
        }
        return false;
    }
    //标记域名解析完成
    public function SetAnalyUid($order_id, $user_id)
    {
        $sql = "";
        $tMCommonBLL = new TMCommonBLL();
        if (!$tMCommonBLL->iExistEmailOrder($order_id, $user_id)) {
            $sql = "insert into `tm_eMail`(`order_id`,`analy_uid`,`analy_time`,`state`)
values($order_id,$user_id,now(),3)";
        } else {
            $sql = "UPDATE tm_eMail
                set `state`=3,analy_uid=$user_id,analy_time=NOW()
                WHERE order_id=$order_id";
        }
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //开通邮箱
    public function TurnOnEmail($order_id, $turnOn_uid)
    {
        $sql = "
update `tm_eMail` set `state`=5,`turnOn_uid`=$turnOn_uid,`turnOn_time`=now()
where `order_id`=$order_id
";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
}
?>