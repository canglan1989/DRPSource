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
require_once __DIR__.'/../../Config/PublicEnum.php';

class TMTrustworthyBLL extends BLLBase
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
ord.`post_uid`,
agent_id,get_code_uid,
case when get_code_uid>0 then '已获取' else '未获取' end get_code_state,trust.`code` as trustworthy_code,
concat(`customer_name`,'/',`customer_id`) cus_name_id,
(select `product_series` from `sys_product` pro where pro.`product_id`=ord.`product_id`)product_name,
case when ord.`order_type`=1 then '新签' when ord.`order_type`=2 then '续签' when ord.`order_type`=-1 then '退单' else '未知' end order_type,
case when trust.verify_uid<>0 then '已校验' when trust.install_uid<>0 then '已添加' when trust.get_code_uid<>0 then '已获取' else '审核通过' end order_state,
(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=ord.`post_uid`)user_name_id,
date_format(ord.`create_time`,'%y-%m-%d')create_time,
ord.`last_check_time`,
case when install_uid<>0 then '已添加' else '未添加' end task_state,
(select GROUP_CONCAT(`website_name` SEPARATOR '<br />') from `om_order_website` site where site.order_id=ord.order_id group by site.order_id)web_site,
concat(ord.`contact_name`,'<br />',ord.`contact_mobile`,' ',ord.`contact_tel`) contact_name,
concat(date_format(ord.`order_sdate`,'%y-%m-%d'),'至<br />',date_format(ord.`order_edate`,'%y-%m-%d'))order_date,
concat(date_format(ord.`effect_sdate`,'%y-%m-%d'),'至<br />',date_format(ord.`effect_edate`,'%y-%m-%d'))effect_date,
case when verify_uid<>0 then '已校验' else '未校验' end i_verify,
concat(`agent_name`,'/',`agent_no`)agent_name_id,
1
from `om_order` ord 
left join `tm_trustworthy` trust on ord.`order_id`=trust.`order_id` 
where ord.`check_status`=1 and ord.`order_type`=1 
and ord.`product_type_id` in(select `aid` from `sys_product_type` _type where is_del=0 and (`product_type_no`='".ProductTypes::cxrz."' or `product_type_no`='".ProductTypes::kxrz."'))
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

    public function GetOrderListData($order_id)
    {
        $tmCommonBLL = new TMCommonBLL();
        $ordrSql = $tmCommonBLL->getOrderFlowSQL($order_id, "trust");
        $sqlOrderList = "";
        if ($tmCommonBLL->iExistCXRZJOrder($order_id, 0)) {
            $sqlOrderList = "
{$ordrSql}
union
select '厂商获取认证代码' main_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=trust.get_code_uid)ope_name,get_code_time,case when trust.get_code_uid<>0 then '已获取' else '未获取' end result,'' remark from `tm_trustworthy` trust where order_id=$order_id
union
select '认证安装' main_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=trust.install_uid)ope_name,install_time,case when trust.install_uid<>0 then '已添加' else '未添加' end result,'' remark from `tm_trustworthy` trust where order_id=$order_id
union
select '认证安装校验' main_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=trust.verify_uid)ope_name,verify_time,case when trust.verify_uid<>0 then '已校验' else '未校验' end result,'' remark from `tm_trustworthy` trust where order_id=$order_id
";
        } else { //不存在该任务 则任务流程全部显示空
            $sqlOrderList = "{$ordrSql}
union
select '厂商获取认证代码' main_step_name,'' ope_name,'','' result,'' remark
union
select '认证安装' main_step_name,'' ope_name,'','' result,'' remark
union
select '认证安装校验' main_step_name,'' ope_name,'','' result,'' remark";
        }
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlOrderList, null);
    }
    
    //获取诚信代码
    public function getCode($orderId,$bWithHTML=true)
    {
        if($bWithHTML == false)
        {
            $sql = "SELECT `code` FROM `tm_trustworthy` where order_id=$orderId";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            if(isset($arrayData)&&count($arrayData) > 0)
                return $arrayData[0]["code"];
        }
        else
        {
            $sql = "SELECT tm_trustworthy.`code`,sys_product_type.product_type_no from om_order 
                inner join tm_trustworthy on tm_trustworthy.order_id = om_order.order_id 
                inner join sys_product_type on sys_product_type.aid = om_order.product_type_id 
                where tm_trustworthy.order_id = $orderId";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            if(isset($arrayData)&&count($arrayData) > 0)
            {
                if($arrayData[0]["product_type_no"] == ProductTypes::kxrz)
                {
                    $code = "<a href='https://ss.knet.cn/verifyseal.dll?sn=".$arrayData[0]["code"]
                    ."' id='kx_verify' tabindex='-1' target='_blank' kx_type='图标式' style='display:inline-block;'> <img src='https://kxlogo.knet.cn/seallogo.dll?kind=pic&amp;sn=".$arrayData[0]["code"]
                    ."' style='border:none;' oncontextmenu='return false;' alt='可信网站'> </a>";
                    return $arrayData[0]["code"];
                }
                else
                {
                    
                    $code = "<a id='___szfw_logo___' href='https://search.szfw.org/cert/l/".$arrayData[0]["code"]
                    ."' target='_blank'><img src='https://search.szfw.org/cert.png?l=".$arrayData[0]["code"]
                    ."'></a><script type='text/javascript'>(function(){document.getElementById('___szfw_logo___').oncontextmenu = function(){return false;}})();</script>";

                    return $code;
                }
            }
        }
        
        return "";
    }

    //安装诚信代码
    public function setInstalUid($order_id, $user_id)
    {
        $sql = "update tm_trustworthy set install_uid=$user_id,install_time=NOW() WHERE order_id=$order_id";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //获取添加诚信代码时所需信息（包括订单有效期 开始时间为系统当前时间，结束时间根据订单时间推算）
    public function GetOrderInfo_AddCode($order_id)
    {
        $sql = "select ord.`customer_name`,GROUP_CONCAT(`website_name`)web_site,date_format(now(),'%Y-%m-%d')`effect_sdate`,
ADDDATE(date_format(now(),'%y-%m-%d'),DATEDIFF(`order_edate`,`order_sdate`))`effect_edate`
from `om_order` ord LEFT join `om_order_website` site 
on ord.order_id=site.`order_id` where ord.order_id=$order_id group by ord.order_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //添加诚信代码 $order_id--订单号 $code--诚信代码 $uid--操作人ID $effect_sdate--有效期开始 $effect_edate--有效期结束
    public function AddCode($order_id, $code, $uid, $effect_sdate, $effect_edate)
    {
        $sql = "select order_id from tm_trustworthy where order_id=$order_id";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $sql = "";
        if(isset($arrayData)&&count($arrayData)>0)
        {
            $sql = "update `tm_trustworthy` set`code`='{$code}',`get_code_uid`=$uid,`get_code_time`=now() where `order_id`=$order_id;";            
        }
        else
        {
            //到订单标识任务开始
            $orderBLL = new OrderBLL();
            $orderBLL->OrderTaskBegin($order_id, $uid);
            //添加诚信代码
            $sql = "insert into `tm_trustworthy`(`order_id`,`code`,`get_code_uid`,`get_code_time`)
                values($order_id,'{$code}',$uid,now());    ";            
        }
        
        //更新订单有效期
        $sql .= "update `om_order` set `effect_sdate`='$effect_sdate',`effect_edate`='$effect_edate' where `order_id`=$order_id;";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //校验诚信代码 $order_id--订单号 $verify_uid--校验人ID
    public function CheckCode($order_id, $verify_uid)
    {
        $sql = "update `tm_trustworthy` set `verify_uid`=$verify_uid,`verify_time`=now() where `order_id`=$order_id;";        //到订单标识任务结束
        $orderBLL = new OrderBLL();
        $orderBLL->OrderTaskEnd($order_id, $verify_uid);

        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

}

?>