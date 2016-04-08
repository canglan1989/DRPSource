<?PHP

require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../BLL/OrderBLL.php';

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：所有邮箱业务功能
 * 表描述：
 * 创建人：lxs  linxishengjiong@163.com
 * 添加时间：2011-9-5 15:18:29
 * 修改人：      修改时间：
 * 修改描述：
 * */
class TMCommonBLL extends BLLBase
{
    /**
     * 公共函数
     */
    //获取邮箱订单信息
    public function getEmailInfo($order_id)
    {
        $sql = "
select 
ord.`customer_name`,
ord.`order_sdate`,
ord.`order_edate`,
group_concat(site.`website_name`)web_site,
pro.product_specs,
1000*300*pro.product_specs+10*1000 whole_cubage,
1000*300 single_cubage
 from `om_order` ord
left join `om_order_website` site on site.order_id=ord.order_id
join sys_product pro on pro.product_id=ord.product_id
where ord.order_id=$order_id
group by ord.order_id
";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //获取订单信息
    public function getOrderInfo($order_id)
    {
        $sql = "
select 
ord.`customer_id`,
ord.`order_id`,
ord.`customer_name`,
ord.`order_sdate`,
ord.`order_edate`,
ord.legal_person_name,
ord.`contact_name`,
ord.`contact_tel`,
ord.`contact_mobile`,
ord.`contact_fax`,
ord.`contact_email`,
group_concat(site.`website_name`) web_site,
user.`user_id` post_user_id,
user.`tel` post_tel,
user.`phone` post_phone,
pro.product_type_id,
pro.product_id,
pro.product_no,
pro.product_specs,
pro.product_name,
pro.product_group,
ord.`agent_id`,ord.`agent_name`,ord.`customer_id`,
ord.`customer_name`,'' as source_product_type_no,
ord.source_order_id from `om_order` ord
left join `om_order_website` site on site.order_id=ord.order_id
join sys_product pro on pro.product_id=ord.product_id
left join sys_user user on user.`user_id`=ord.`post_uid`
where ord.order_id=$order_id
group by ord.order_id";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if(isset($arrayData) && count($arrayData)>0)
        {
            if($arrayData[0]["product_group"] != 1 && $arrayData[0]["order_sdate"]==$arrayData[0]["order_edate"])
            {
                $arrayData[0]["order_sdate"] = date("Y-m-d",time());
                $arrayData[0]["order_edate"] = '2038-01-01';
            }
            
            if($arrayData[0]["source_order_id"] > 0)
            {
                $sql = "SELECT sys_product_type.product_type_no FROM om_order INNER JOIN sys_product_type 
                ON om_order.product_type_id = sys_product_type.aid where om_order.order_id=".$arrayData[0]["source_order_id"];
                $aData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
                if(isset($aData) && count($aData)>0)
                    $arrayData[0]["source_product_type_no"] = $aData[0]["product_type_no"];
            }
        }
        return $arrayData;
    }
    //获取网营任务信息
    public function getNetInfo($order_id)
    {
        $sql = "
select net.site_id,group_concat(site.`website_name`)web_site,net.bakcUp_code from `tm_net` net 
left join `om_order_website` site
on site.`order_id`=net.`order_id`
where net.order_id=$order_id
group by net.`order_id`
";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //生成随机网营帐号 $agent_id--代理商ID $agent_uid--代理商子账户ID
    public function getWYZH($agent_id, $agent_uid)
    {
        $wyzh = "";
        $wyzh .= "ps_drp_wyzh_{$agent_id}_{$agent_uid}_" . mt_rand(0, 9999);
        return $wyzh;
    }
    //获取验证码 $p--加密字符串
    public function getVerifi_code($str)
    {
        $wymhEncrypt = array("suffixStr" => "|" . date('Y-m-d', time()), "subLen" => 30);
        $suffix = $wymhEncrypt["suffixStr"];
        return substr(md5($str . $suffix), 0, $wymhEncrypt["subLen"]);
    }
    //执行网营门户soap接口
    //正式的http://m3.epanshi.com/ws/wsfordrp.wsdl
    //测试的http://m2.epanshi.com/ws/wsfordrp.wsdl
    public function doSoapWYMH($funName, $param)
    {
        $arrSysConfig = unserialize(SYS_CONFIG);
        $arrSysConfig = $arrSysConfig['SoapLocation' . $arrSysConfig['SYS_EVN']];
        $url = $arrSysConfig['WYMH'];
        $client = new SoapClient("{$url}", array('cache_wsdl' => 0));
        $this->saveSoapLog($url, $funName, $param, "before");
        $rtn = $client->__call($funName, $param);
        $this->saveSoapLog($url, $funName, $param, $rtn);
        return $rtn;
    }
    //执行单点登录soap接口
    //正式的 http://sso.adpanshi.com/SSOSoapMetaService/WSDL/sso.wsdl
    //测试的 http://192.168.95.39/SSOSoapMetaService/WSDL/sso.wsdl
    public function doSoapSSO($funName, $param)
    {
        $arrSysConfig = unserialize(SYS_CONFIG);
        $arrSysConfig = $arrSysConfig['SoapLocation' . $arrSysConfig['SYS_EVN']];
        $url = $arrSysConfig['SSO'];
        $client = new SoapClient("{$url}", array('cache_wsdl' => 0));
        //print_r($param);exit;
        $this->saveSoapLog($url, $funName, $param, "before");
        $rtn = $client->__call($funName, $param);
        $this->saveSoapLog($url, $funName, $param, $rtn);
        return $rtn;
    }
    //执行邮箱soap接口
    public function doSoapEmail($funName, $param)
    {
        $arrSysConfig = unserialize(SYS_CONFIG);
        $arrSysConfig = $arrSysConfig['SoapLocation' . $arrSysConfig['SYS_EVN']];
        //die($arrSysConfig['Email']);exit;
        $url = $arrSysConfig['Email'];
        $client = new SoapClient(null, array('location' => "{$url}", 'uri' =>
            "http://127.0.0.1", ));
        $this->saveSoapLog($url, $funName, $param, "before");
        $rtn = $client->__call($funName, $param);
        $this->saveSoapLog($url, $funName, $param, $rtn);
        return $rtn;
    }
    //保存调用接口日志，如传值与返回的值
    public function saveSoapLog($url, $funName, $param, $rtn)
    {
        $param = json_encode($param);
        $sql = "insert into sys_soap_log(url,fun_name,param,rtn,create_time)values
('$url','$funName','$param','$rtn',now())";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //判断是否已存在该订单号任务
    public function iExistOrder($order_id)
    {
        $sql = "select count(1) count from `om_order` net where 
order_id=$order_id";
        $data = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (count($data) == 1 && $data[0]["count"] <> 0) {
            return true;
        } else {
            return false;
        }
    }
    //判断网营专家是否已存在该订单号任务（直接到单点这里找）
    public function iExistWYZJOrder($order_id)
    {
        $sql = "select count(1) count from `tm_single_info` where 
order_id=$order_id";
        $data = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (count($data) == 1 && $data[0]["count"] <> 0) {
            return true;
        } else {
            return false;
        }
    }
    //判断诚信认证里是否已存在该订单号任务
    public function iExistCXRZJOrder($order_id)
    {
        $sql = "select count(1) count from `tm_trustworthy` where 
order_id=$order_id";
        $data = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (count($data) == 1 && $data[0]["count"] <> 0) {
            return true;
        } else {
            return false;
        }
    }
    //判断网营任务里是否已存在该订单号任务
    public function iExistWYMHOrder($order_id, $user_id)
    {
        $sql = "select count(1) count from `tm_net` net where 
net.order_id=$order_id";
        $data = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (count($data) == 1 && $data[0]["count"] <> 0) {
            return true;
        } else {
            if ($user_id <> 0) {
                //到订单标识任务开始
                $orderBLL = new OrderBLL();
                $orderBLL->OrderTaskBegin($order_id, $user_id);
                return false;
            }
        }
    }
    //判断邮箱任务里是否已存在该订单号任务
    public function iExistEmailOrder($order_id, $user_id)
    {
        $sql = "select count(1) count from `tm_eMail` email where 
email.order_id=$order_id";
        $data = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if (count($data) == 1 && $data[0]["count"] <> 0) {
            return true;
        } else {
            if ($user_id <> 0) {
                //到订单标识任务开始
                $orderBLL = new OrderBLL();
                $orderBLL->OrderTaskBegin($order_id, $user_id);
            }
        }
        return false;
    }
    //任务前流程SQL语句
    public function getOrderFlowSQL($order_id, $order_type)
    {
        if ($order_type == "netope") {
            $sql = "
select '订单提交' main_step_name,'' part_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=ord.`create_uid`)ope_name,agent_name,post_date ope_time,case when ord.check_status=-2 then '未提交' when ord.check_status<>-2 then '已提交' end result,order_remark remark from `om_order` ord where ord.order_id=$order_id
union
select '厂商审核任务分配' main_step_name,'' part_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=ord.`allolt_uid`)ope_name,agent_name,ord.allolt_time ope_time,case when ord.allolt_uid = 0 then '未分配' when ord.allolt_uid <> 0 then '已分配' end result,ord.`allolt_remark` remark from `om_order` ord where ord.`order_id`=$order_id
union
select * from(
select '厂商审核' main_step_name,'' part_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=record.`audit_uid`)ope_name,agent_name,record.audit_time ope_time,case when is_pass=1 then '审核通过' when is_pass=0 then '审核未通过' else '未审核' end result,record.`audit_remark` remark from `om_order` ord left join `com_audit_record` record on ord.`order_id`=record.`t_id` and record.t_name='om_order' and ord.order_id=$order_id order by record.audit_time desc limit 0,1
)assign
";
        } else {
            $sql = "
select '订单提交' main_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=ord.`create_uid`)ope_name,post_date ope_time,case when ord.check_status=-2 then '未提交' when ord.check_status<>-2 then '已提交' end result,order_remark remark from `om_order` ord where ord.order_id=$order_id
union
select '厂商审核任务分配' main_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=ord.`allolt_uid`)ope_name,ord.allolt_time ope_time,case when ord.allolt_uid = 0 then '未分配' when ord.allolt_uid <> 0 then '已分配' end result,ord.`allolt_remark` remark from `om_order` ord where ord.`order_id`=$order_id
union
select * from(
select '厂商审核' main_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=record.`audit_uid`)ope_name,record.audit_time ope_time,case when is_pass=1 then '审核通过' when is_pass=0 then '审核未通过' else '未审核' end result,record.`audit_remark` remark from `om_order` ord left join `com_audit_record` record on ord.`order_id`=record.`t_id` and record.t_name='om_order' and ord.order_id=$order_id order by record.audit_time desc limit 0,1
)assign
";
        }
        return $sql;
    }
}
?>