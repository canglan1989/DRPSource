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
require_once __DIR__ . '/../BLL/AgentAccountDetailActBLL.php';
require_once __DIR__ . '/../BLL/OrderBLL.php';

class TMNetOpeBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 操作事件
     */
    //分配任务 $order_id--订单号 $assign_uid--分配人 $make_uid--制作人
    public function TaskAssign($order_id, $assign_uid, $assign_remark, $make_uid, $i_transfer)
    {
        $tMCommonBLL = new TMCommonBLL();
        //新建站点
        //获取订单信息
        if ($i_transfer == 0) {
            $order_info = $tMCommonBLL->getOrderInfo($order_id);
            if (count($order_info) <> 0) {
                $info = $order_info[0];
                $cus_ip = $_SERVER["REMOTE_ADDR"];
                //新建站点 获取预览地址 $info["order_id"]
                $param = array($info["customer_name"], $info["order_id"], $info["order_sdate"],
                    $info["order_edate"], $info["agent_id"], $info["agent_name"], $info["product_specs"],
                    $info["customer_id"], $assign_uid, $cus_ip, $tMCommonBLL->getVerifi_code($info["customer_name"]));
                $rtn = $tMCommonBLL->doSoapWYMH("createSite", $param);
                
                eval('$rtn=' . $rtn . ';');
                if ($rtn["site_id"] <> "") {
                    $sql = "";
                    
                    $arrSysConfig = unserialize(SYS_CONFIG);
                    $TM_Website_Preview = $arrSysConfig['TM_Website_Preview'];        
                    $rtn["preview"] .= $TM_Website_Preview;
                    
                    if (!$tMCommonBLL->iExistWYMHOrder($order_id, $assign_uid)) {
                        $sql = "insert into `tm_net`(`order_id`,`assign_uid`,`assign_time`,`assign_remark`,`make_uid`,`site_id`,`site_account_name`,`site_ip`)
        values($order_id,$assign_uid,now(),'$assign_remark',$make_uid,'{$rtn["site_id"]}','{$rtn["account"]}','{$rtn["preview"]}')";
                    } else {
                        $sql = "update `tm_net` net
        set net.`assign_uid`=$assign_uid,`assign_time`=now(),`make_uid`=$make_uid,`assign_remark`='$assign_remark',`site_id`='{$rtn["site_id"]}',`site_account_name`='{$rtn["account"]}',`site_ip`='{$rtn["preview"]}'
        where net.order_id=$order_id";
                    }
                    return $this->objMysqlDB->executeNonQuery(false, $sql, null);
                } else {                    
                    return $rtn["error"];
                }
            }
            return 1;
        } else {
            if (!$tMCommonBLL->iExistWYMHOrder($order_id, $assign_uid)) {
                $sql = "insert into `tm_net`(`order_id`,`assign_uid`,`assign_time`,`assign_remark`,`make_uid`)
    values($order_id,$assign_uid,now(),'$assign_remark',$make_uid)";
            } else {
                $sql = "update `tm_net` net
    set net.`assign_uid`=$assign_uid,`assign_time`=now(),`assign_remark`='$assign_remark',`make_uid`=$make_uid
    where net.order_id=$order_id";
            }
            /*
            //绑定建站帐号 系统生成随机网营帐号与代理商子帐号绑定
            $user_name = $tMCommonBLL->getWYZH($info["agent_id"], $make_uid);
            $rtn = $tMCommonBLL->doSoapWYMH("createAccount", array($info["site_id"], $user_name,
            $assign_uid, "no_ip", $tMCommonBLL->getVerifi_code($user_name)));
            */
            //更新sql语句 更新网营帐号
            return $this->objMysqlDB->executeNonQuery(false, $sql, null);
        }
        return 0;
    }

    //添加网营帐号 $net_u_name--帐号名 $pwd--密码 $is_lock--是否关闭1关闭，0开启
    public function AddNetAccount($net_u_name, $pwd, $is_lock)
    {
        $sql = "
insert into `tm_net_account`(`net_u_name`,`pwd`,`is_lock`)
values('$net_u_name','$pwd',$is_lock)
";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //设置网营帐号状态 $is_lock--是否关闭1关闭，0开启 $net_u_name--网营帐号名
    public function SetNetAccountState($is_lock, $net_u_name)
    {
        //先调用网营设置状态接口。。。
        $sql = "
update `tm_net_account` set `is_lock`=$is_lock
where `net_u_name`=$net_u_name
";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //设置网营帐号密码修改
    public function SetNetAccountPwd($pwd, $net_u_name)
    {
        //先调用网营修改密码接口。。。
        $sql = "
update `tm_net_account` set `pwd`=$pwd
where `net_u_name`=$net_u_name
";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //获取网营帐号信息（用于绑定代理商显示）
    //绑定网营帐号给代理商 $agent_uid--代理商帐号ID $agent_id--代理商ID $bind_uid--绑定人ID $net_u_name--网营帐号
    public function BindNetAccount($agent_uid, $agent_id, $bind_uid, $net_u_name)
    {
        $sql = "
update `tm_net_account` set `agent_uid`=$agent_uid,`agent_id`=$agent_id,`bind_uid`=$bind_uid,`bind_time`=now()
where `net_u_name`='$net_u_name'
";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //转移任务
    public function TaskTransfer($order_id, $assign_uid, $make_uid)
    {
        return self::TaskAssign($order_id, $assign_uid, "", $make_uid, 1);
    }

    //标记网建任务制作完成 $make_state--制作完成状态 1--已完成 2--修改完成
    public function setFinshTag($order_id, $make_state, $user_id)
    {
        $sql = "UPDATE tm_net
                set make_state=$make_state,make_uid=$user_id,make_time=NOW()";
        if ($make_state == 2) { //修改完成需要更新审核状态为未审核
            $sql .= ",verify_state=0";
        }
        $sql .= " WHERE order_id=$order_id";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //标记域名解析完成
    public function SetAnalyUid($order_id, $user_id)
    {
        $tMCommonBLL = new TMCommonBLL();
        $sql = "";
        if (!$tMCommonBLL->iExistWYMHOrder($order_id, $user_id)) {
            $sql = "insert into `tm_net`(`order_id`,`analy_uid`,`analy_time`)
values($order_id,$user_id,now())";
        } else {
            $sql = "UPDATE tm_net
                set analy_uid=$user_id,analy_time=NOW()
                WHERE order_id=$order_id";
        }
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //修改备案联系人 $name--联系人姓名 $mobile--联系人手机 $tel--联系人电话
    public function ICPContactModify($order_id, $uid, $name, $mobile, $tel)
    {
        $tMCommonBLL = new TMCommonBLL();
        $sql = "";
        if (!$tMCommonBLL->iExistWYMHOrder($order_id, $uid)) {
            $sql = "insert into `tm_net`(`order_id`,`icp_contact_name`,`icp_contact_mobile`,`icp_contact_tel`)
values($order_id,'$name','$mobile','$tel')";
        } else {
            $sql = "update `tm_net` set icp_contact_name='$name',`icp_contact_mobile`='$mobile',`icp_contact_tel`='$tel'
where `order_id`=$order_id";
        }
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //ICP备案完成 $back_uid--备案人 $bakcUp_code--备案号
    public function ICPBackUpFinish($order_id, $back_uid, $bakcUp_code)
    {
        $tMCommonBLL = new TMCommonBLL();
        $sql = "";
        if (!$tMCommonBLL->iExistWYMHOrder($order_id, $back_uid)) {
            $sql = "insert into `tm_net`(`order_id`,`backUp_state`,`end_backUp_uid`,`end_backUp_time`,`bakcUp_code`)
values($order_id,2,$back_uid,now(),'$bakcUp_code')";
        } else {
            $sql = "update `tm_net` set backUp_state=2,`end_backUp_uid`=$back_uid,`end_backUp_time`=now(),`bakcUp_code`='$bakcUp_code',verify_state=0
where `order_id`=$order_id";

            //传给网营门户备案号
            /* @param unknown_type $site_id 站点ID
             * @param unknown_type $icp 备案号	
             * @param unknown_type $create_user 操作人
             * @param unknown_type $ip 操作人IP    */
            $order_info = $tMCommonBLL->getNetInfo($order_id);
       
            $info = $order_info[0];
            $cus_ip = Utility::getIP();
            $param = array($info["site_id"],$bakcUp_code,$back_uid, $cus_ip, $tMCommonBLL->getVerifi_code($info["site_id"]));
            $rtn = $tMCommonBLL->doSoapWYMH("setRecordInfo", $param);
        }
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //获取ICP备案联系人
    public function GetICPContact($order_id)
    {
        $sql = "
select 
case when net.`icp_contact_name`<>'' then net.`icp_contact_name` else (select con.`contact_name` from `cm_ag_contact` con where con.`customer_id`=ord.`customer_id` and con.`isCharge`=1 limit 0,1) end contact_name,
case when net.`icp_contact_name`<>'' then net.`icp_contact_mobile` else (select con.`contact_mobile` from `cm_ag_contact` con where con.`customer_id`=ord.`customer_id` and con.`isCharge`=1 limit 0,1) end contact_mobile,
case when net.`icp_contact_name`<>'' then net.`icp_contact_tel` else (select con.`contact_tel` from `cm_ag_contact` con where con.`customer_id`=ord.`customer_id` and con.`isCharge`=1 limit 0,1) end contact_tel
from `om_order` ord left join `tm_net` net 
on ord.order_id=net.order_id
where ord.order_id=$order_id
";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //网站评审操作 $verify_uid--评审人 $verify_state--评审状态 1--审核通过 2--审核不通过 $verify_remark--评审备注
    //$un_pass_reason--不通过理由 site--建站问题 icp--ICP备份问题 也可以是两个 site,icp
    public function SiteVerify($order_id, $verify_uid, $verify_state, $verify_remark,
        $un_pass_reason)
    {
        $sql = "";
        if ($verify_state == 1) //审核通过
            {
            $sql = "update `tm_net` set `verify_state`=$verify_state,`verify_uid`=$verify_uid,`verify_remark`='$verify_remark',`verify_time`=now()
where `order_id`=$order_id;";
        } else
            if ($verify_state == 2) //审核不通过，设置制作状态为未完成
                {
                $sql = "update `tm_net` set ";
                if (strpos($un_pass_reason, "site") !== false) {
                    $sql .= "make_state=0,make_time='',";
                }
                if (strpos($un_pass_reason, "icp") !== false) {
                    $sql .= "backUp_state=0,end_backUp_time='',";
                }
                $sql .= " `verify_state`=$verify_state,`verify_uid`=$verify_uid,`verify_remark`='$verify_remark',`verify_time`=now()
where `order_id`=$order_id;";
            } else {
                return false;
            }
            $sql .= "insert into `tm_net_verify`(`order_id`,`verify_state`,`verify_remark`,`create_uid`,`create_time`)
values($order_id,$verify_state,'$verify_remark',$verify_uid,now());";
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
        return true;
    }

    //标识发布成功 $order_ids--订单号用逗号隔开 $i_success--成功失败标识 1成功 0失败 给网营提供
    public function SitePublished($order_id, $i_success, $msg)
    {
        if ($i_success == 1)
            $i_success = 2; //成功
        else
            $i_success = 3; //失败
        
        $sql = "update `tm_net` set `publish_state`=$i_success,`publish_failed_reason`='$msg' where `order_id` in($order_id)";
        //标识网站发布中
        $rtn = $this->objMysqlDB->executeNonQuery(false, $sql, null);
        try {
            if ($i_success == 2) {
                $sql = "update `tm_net` set `onLine_time`=now() where `order_id` in($order_id)";
                //标识网站发布成功
                $rtn = $this->objMysqlDB->executeNonQuery(false, $sql, null);
                //对第一次发布成功后进行扣款
                if (count(self::iDeductMoney($order_id)) == 0) {
                    $objOrderChargeAct = new OrderChargeAct();
                    $strActDate = date("Y-m-d H:i:s", time());
                    $iAuditUid = self::GetPublishNameID($order_id); //发布人ID
                    if (count($iAuditUid) > 0) {
                        $iAuditUid = $iAuditUid[0]["publish_uid"];
                        $objOrderChargeAct->Init(intval($order_id), "$strActDate");
                        $objOrderChargeAct->Insert($iAuditUid, "网营门户上线，订单款项扣除");
                        //标识已经扣款 下次无需再扣
                        $sqlDeductMoney = "update `tm_net` set `i_deduct_money`=1 where `order_id`=$order_id";
                        $this->objMysqlDB->executeNonQuery(false, $sqlDeductMoney, null);
                    }
                    //到订单标识任务结束
                    $orderBLL = new OrderBLL();
                    $orderBLL->OrderTaskEnd($order_id, $iAuditUid);
                    $this->objMysqlDB->executeNonQuery(false, $sql, null);
                }
            }
            return "1";
        }
        catch (exception $e) {
            /**
             * $sqlDeductMoney = "update `tm_net` set `test`='" . $e->getMessage() .
             *                 "' where `order_id`=$order_id";
             *             $this->objMysqlDB->executeNonQuery(false, $sqlDeductMoney, null);
             */
            return "0";
        }
    }
    //查看该网营站点是否已经扣款
    public function iDeductMoney($order_id)
    {
        $sql = "select 1 from `tm_net` where `order_id`=$order_id and `i_deduct_money`=1";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //获取网营发布人ID
    public function GetPublishNameID($order_id)
    {
        $sql = "select publish_uid from `tm_net` where `order_id`=$order_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //标识发布中 $order_ids--订单号用逗号隔开
    public function SitePublish($order_ids, $publish_uid)
    {
        $sql = "update `tm_net` set `publish_state`=1,`publish_uid`=$publish_uid,`publish_time`=now()
where `order_id` in($order_ids)";
        //标识网站发布中
        $rtn = $this->objMysqlDB->executeNonQuery(false, $sql, null);
        return $rtn;
    }

    //通知网营发布网站
    public function SitePublishWYMH($order_ids, $publish_uid)
    {
        $order_id_array = explode(",", $order_ids);
        $tMCommonBLL = new TMCommonBLL();
        foreach ($order_id_array as $order_id) {
            //获取订单信息
            $order_info = $tMCommonBLL->getNetInfo($order_id);
            if (count($order_info) <> 0) {
                $info = $order_info[0];
                $cus_ip = $_SERVER["REMOTE_ADDR"];
                //新建站点 获取预览地址 $info["site_id"] 3360
                $param = array($info["site_id"], $info["web_site"], 0, 1, $info["bakcUp_code"],
                    $publish_uid, $cus_ip, $tMCommonBLL->getVerifi_code($info["site_id"]));
                //print_r($param);exit;
                $rtn = $tMCommonBLL->doSoapWYMH("publishSite", $param);
                //print_r($rtn);exit;
            }
        }
        return $rtn;
    }

    /**
     * 列表数据获取
     */
    //获取评审记录列表
    public function GetVerifyHistoryList($order_id)
    {
        $sql = "
select case when `verify_state`=0 then '未审核' when `verify_state`=1 then '审核通过' when `verify_state`=2 then '审核未通过' else '未知' end verify_state,
`verify_remark`,
(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=verify.`create_uid`)ope_name,
`create_time` ope_time
from `tm_net_verify` verify
where verify.`order_id`=$order_id
";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function GetHeadData($where)
    {
        //已分配,未分配,制作完成,制作未完成,厂商评审通过,厂商评审未通过
        $sql = "
select 
case when `assign_uid`<>0 then 1 else 0 end assign,
case when (`assign_uid`=0 or `assign_uid` is null) then 1 else 0 end un_assign,
case when `make_state`<>0 then 1 else 0 end make,
case when `make_state`=0 then 1 else 0 end un_make,
case when `verify_state`=1 then 1 else 0 end verify_pass,
case when `verify_state`=2 then 1 else 0 end verify_un_pass
 from `om_order` ord left join 
 `tm_net` net on ord.order_id = net.order_id
 where 
ord.`check_status`=1 and ord.`order_type`=1
and ord.`product_id` in(select `product_id` from `sys_product` _pro where _pro.`product_type_id` in(select `aid` from `sys_product_type` _type where `product_type_no`='wymh'))
";
        if ($where <> "") {
            $sql .= $where;
        }
        $sql = "select sum(assign)assign,sum(un_assign)un_assign,sum(make)make,sum(un_make)un_make,sum(verify_pass)verify_pass,sum(verify_un_pass)verify_un_pass from 
($sql)tb";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //获取网站评审头部信息
    public function GetSiteVerifyHeadData()
    {
        $sql = "
select 
case when (net.`make_state`=1 and net.`verify_state`=0)then 1 else 0 end add_un_verify,
case when (net.`make_state`=2 and net.`verify_state`=0)then 1 else 0 end edit_un_verify,
case when `verify_state`=1 then 1 else 0 end verify_pass,
case when `verify_state`=2 then 1 else 0 end verify_un_pass
 from `om_order` ord left join 
 `tm_net` net on ord.order_id = net.order_id
 where 
ord.`check_status`=1 and ord.`order_type`=1
and net.analy_uid<>0 and net.make_state<>0
and ord.`product_id` in(select `product_id` from `sys_product` _pro where _pro.`product_type_id` in(select `aid` from `sys_product_type` _type where `product_type_no`='wymh'))
";// and backUp_state=2
        $sql = "select sum(add_un_verify)add_un_verify,sum(edit_un_verify)edit_un_verify,sum(verify_pass)verify_pass,sum(verify_un_pass)verify_un_pass from 
($sql)tb";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //获取网站发布头部信息
    public function GetSitePublishHeadData()
    {
        $sql = "
select 
case when net.`publish_state`=0 then 1 else 0 end un_publish,
case when net.`publish_state`=1 then 1 else 0 end publishing,
case when net.`publish_state`=2 then 1 else 0 end publish_succeed,
case when net.`publish_state`=3 then 1 else 0 end publish_failed
 from `tm_net` net
 where 
net.analy_uid<>0 and verify_state=1
";// and backUp_state=2
        $sql = "select sum(un_publish)un_publish,sum(publishing)publishing,sum(publish_succeed)publish_succeed,sum(publish_failed)publish_failed from 
($sql)tb";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //网营帐号列表数据
    public function GetNetUserData($where)
    {
        $sql = "select `aid`,`net_u_name`,
case when tm_user.`is_lock`=1 then '关闭' else '正常' end account_state,
ag.`agent_id`,ag.agent_name,`bind_time`,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=tm_user.`bind_uid`)bind_user_name from `tm_net_account` tm_user
join `am_agent` ag on ag.`agent_id`=tm_user.`agent_id`";
        if ($where <> "") {
            $sql .= $where;
        }
        return self::getPageData(self::getOrderBySQl($sql));
    }

    //评审记录列表数据
    public function GetVerifyRecordListData($order_id)
    {
        $sql = "
select 
case when `verify_state`=1 then '审核通过' else '审核不通过' end verify_state,
`verify_remark`,
(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=`create_uid`)verify_name,
`create_time` verify_time
from `tm_net_verify`
where `order_id`=$order_id
";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //主列表数据 $fields=array("order_id","order_no") 需要字段 下次应该把不同字段连接的表也不同做进去
    public function GetListData($where, $outWhere, $fields_ary, $sortField)
    {
        $fields = "";
        //订单号,客户名称,产品,订单类型,订单状态,提交人/公司,提交时间,下单时间,任务状态,制作人,分配人,分配时间
        //"order_id","order_no","customer_name","customer_id"
        if (in_array("order_id", $fields_ary)) {
            $fields .= "ord.order_id,";
        }
        if (in_array("order_no", $fields_ary)) {
            $fields .= "ord.`order_no`,";
        }
        if (in_array("customer_name", $fields_ary)) {
            $fields .= "ord.`customer_name`,";
        }
        if (in_array("customer_id", $fields_ary)) {
            $fields .= "ord.customer_id,";
        }
        if (in_array("make_uid", $fields_ary)) {
            $fields .= "net.make_uid,";
        }
        if (in_array("assign_uid", $fields_ary)) {
            $fields .= "net.assign_uid,";
        }
        if (in_array("analy_uid", $fields_ary)) {
            $fields .= "net.analy_uid,";
        }
        if (in_array("post_uid", $fields_ary)) {
            $fields .= "ord.`post_uid`,";
        }
        if (in_array("agent_id", $fields_ary)) {
            $fields .= "ord.agent_id,";
        }
        if (in_array("verify_uid", $fields_ary)) {
            $fields .= "net.`verify_uid`,";
        }
        if (in_array("product_name", $fields_ary)) {
            $fields .= "(select `product_series` from `sys_product` pro where pro.`product_id`=ord.`product_id`)product_name,";
        }
        if (in_array("order_type", $fields_ary)) {
            $fields .= "case when ord.`order_type`=1 then '新签' when ord.`order_type`=2 then '续签' when ord.`order_type`=-1 then '退单' else '未知' end order_type,";
        }
        if (in_array("order_state", $fields_ary)) {
            $fields .= "case when net.publish_state<>0 then (case when net.publish_state=1 then '发布中' when net.publish_state=2 then '发布成功' when net.publish_state=3 then '发布失败' end) when net.`verify_state`<>0 then(case when net.`verify_state`=1 then '审核通过' when net.`verify_state`=2 then '审核未通过' end) when (net.`make_uid`<>0 and `make_time`<>'0000-00-00 00:00:00') then '已制作' when net.`assign_uid`<>0 then '已分配' else '未分配' end order_state,";
        }
        if (in_array("post_user_name_id", $fields_ary)) {
            $fields .= "(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=ord.`post_uid`)post_user_name_id,";
        }
        if (in_array("post_time", $fields_ary)) {
            $fields .= "date_format(ord.`create_time`,'%y-%m-%d')post_time,";
        }
        if (in_array("last_check_time", $fields_ary)) {
            $fields .= "ord.`last_check_time`,";
        }
        if (in_array("task_state", $fields_ary)) {
            $fields .= "case when net.assign_uid<>0 then '已分配' else '未分配' end task_state,";
        }
        if (in_array("make_name", $fields_ary)) {
            $fields .= "(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`make_uid`)make_name,";
        }
        if (in_array("assign_name", $fields_ary)) {
            $fields .= "(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`assign_uid`)assign_name,";
        }
        if (in_array("assign_time", $fields_ary)) {
            $fields .= "net.`assign_time`,";
        }
        if (in_array("make_state", $fields_ary)) {
            $fields .= "case when make_state=0 then '未完成' when make_state=1 then '已完成' when make_state=2 then '已修改完成' else '未知' end make_state,";
        }
        if (in_array("verify_state", $fields_ary)) {
            $fields .= "case when `verify_state`=0 then '未审核' when `verify_state`=1 then '审核通过' when `verify_state`=2 then '审核未通过' else '未知' end verify_state,";
        }
        if (in_array("make_finish_time", $fields_ary)) {
            $fields .= "if(make_state<>0,make_time, '--') make_finish_time,";
        }
        if (in_array("agent_name", $fields_ary)) {
            $fields .= "concat(`agent_name`,'/',`agent_id`)agent_name,";
        }
        if (in_array("contact_name", $fields_ary)) {
            $fields .= "concat(ord.`contact_name`,'<br />',ord.`contact_mobile`,' ',ord.`contact_tel`) contact_name,";
        }
        if (in_array("icp_contact_name", $fields_ary)) {
            $fields .= "case when net.`icp_contact_name`<>'' then concat(net.`icp_contact_name`,'<br />',net.`icp_contact_mobile`,' ',net.`icp_contact_tel`) else (select concat(con.`contact_name`,'<br />',con.`contact_mobile`,' ',con.`contact_tel`) from `cm_ag_contact` con where con.`customer_id`=ord.`customer_id` and con.`isCharge`=1 limit 0,1) end icp_contact_name,";
        }
        if (in_array("web_site", $fields_ary)) {
            $fields .= "(select GROUP_CONCAT(`website_name` SEPARATOR '<br />') from `om_order_website` site where site.order_id=ord.order_id group by site.order_id)web_site,";
        }
        if (in_array("backUp_state", $fields_ary)) {
            $fields .= "case when (`backUp_state`=0 or `backUp_state` is null) then '未备案' when `backUp_state`=1 then '备案中' when `backUp_state`=2 then '备案完成' else '未知' end backUp_state,";
        }
        if (in_array("bakcUp_code", $fields_ary)) {
            $fields .= "`bakcUp_code`,";
        }
        if (in_array("begin_back", $fields_ary)) {
            $fields .= "(select concat(`begin_backUp_time`,'<p></p>',`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`begin_backUp_uid`)begin_back,";
        }
        if (in_array("end_back", $fields_ary)) {
            $fields .= "(select concat(case when backUp_state<>0 then end_backUp_time else '' end,'<p></p>',`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`end_backUp_uid`)end_back,";
        }
        if (in_array("make_type", $fields_ary)) {
            $fields .= "case when make_state=1 then '新建' when make_state=2 then '修改' else '未知' end make_type,";
        }
        if (in_array("verify_remark", $fields_ary)) {
            $fields .= "`verify_remark`,";
        }
        if (in_array("verify_name_id", $fields_ary)) {
            $fields .= "(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`verify_uid`)verify_name_id,";
        }
        if (in_array("verify_time", $fields_ary)) {
            $fields .= "case when verify_state<>0 then date_format(`verify_time`,'%y-%m-%d <br /> %H:%i:%s') else '' end verify_time,";
        }
        if (in_array("cus_name_id", $fields_ary)) {
            $fields .= "concat(`customer_name`,'/',`customer_id`) cus_name_id,";
        }
        if (in_array("agent_name_id", $fields_ary)) {
            $fields .= "concat(`agent_name`,'/',`agent_no`) agent_name_id,";
        }
        if (in_array("publish_state", $fields_ary)) {
            $fields .= "case when publish_state=0 then '未发布' when publish_state=1 then '发布中' when publish_state=2 then '发布成功' when publish_state=3 then '发布失败' else '未知' end publish_state,";
        }
        if (in_array("publish_name", $fields_ary)) {
            $fields .= "(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`publish_uid`)publish_name,";
        }
        if (in_array("publish_time", $fields_ary)) {
            $fields .= "publish_time,";
        }
        if (in_array("is_analy", $fields_ary)) {
            $fields .= "case when analy_uid<>0 then '已解析' else '未解析' end is_analy,";
        }
        if (in_array("analy_time", $fields_ary)) {
            $fields .= "`analy_time`,";
        }
        if (in_array("analy_name", $fields_ary)) {
            $fields .= "(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`analy_uid`)analy_name,";
        }
        if (in_array("onLine_time", $fields_ary)) {
            $fields .= "`onLine_time`,";
        }
        if (in_array("site_id", $fields_ary)) {
            $fields .= "site_id,";
        }
        if (in_array("site_account_name", $fields_ary)) {
            $fields .= "site_account_name,";
        }
        if (in_array("site_ip", $fields_ary)) {
            $fields .= "site_ip,";
        }
        if (in_array("site_md_str", $fields_ary)) {
            $fields .= "concat(net.site_id,'-',net.site_account_name,'-',date_format(now(),'%Y-%m-%d')) site_md_str,";
        }
        if (in_array("i_effect", $fields_ary)) {
            $fields .= "case when (now()>=ord.effect_sdate and now()<=ord.effect_edate) then 1 else 0 end i_effect,";
        }
        if (in_array("i_backUp", $fields_ary)) {
            $fields .= "case when backUp_state<>2 then '未备案' when backUp_state=2 then '备案完成' end i_backUp,";
        }
        $sql = "
select distinct $fields
1
from `om_order` ord 
left join `tm_net` net on ord.`order_id`=net.`order_id` 
where 1=1
and ord.`check_status`=1 and (ord.`order_type`=1 or ord.`order_type`=2)
and ord.`product_id` in(select `product_id` from `sys_product` _pro where _pro.`product_type_id` in(select `aid` from `sys_product_type` _type where `product_type_no`='wymh'))
";
        //var_dump($sql);exit;
        if ($where <> "") {
            $sql .= $where;
        }
        $sql = "select * from($sql)tb where 1=1";
        if ($outWhere <> "") {
            $sql .= $outWhere;
        }
        
        return self::getPageData(self::getOrderBySQl($sql, $sortField));
    }

    public function GetOrderFlowShort($order_id)
    {
        //网页制作流程 步骤，操作人，操作时间，操作结果，备注(需要传入订单号)
        $sqlSiteMakeFlow = "
select '网站制作任务分配' step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`assign_uid`)ope_name,`assign_time` ope_time,case when net.assign_uid<>0 then '已分配' else '未分配' end result,net.assign_remark remark from `tm_net` net where `order_id`='$order_id'
union
select '网站制作' step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`make_uid`)ope_name,`make_time` ope_time,case when make_state=0 then '未完成' when make_state=1 then '已完成' when make_state=2 then '已修改完成' else '未知' end result,'' remark from `tm_net` net where `order_id`='$order_id'
union
select '厂商建站质量评估' step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`verify_uid`)ope_name,`verify_time` ope_time,case when `verify_state`=0 then '未审核' when `verify_state`=1 then '审核通过' when `verify_state`=2 then '审核未通过' else '未知' end result,net.`verify_remark` remark from `tm_net` net where `order_id`=$order_id;
";
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlSiteMakeFlow, null);
    }

    public function getOrderStatusWyzj($order_id)
    {
        $tMCommonBLL = new TMCommonBLL();
        $ordrSql = $tMCommonBLL->getOrderFlowSQL($order_id, "WYJL");
        $sqlOrderList = "";
        if ($tMCommonBLL->iExistWYZJOrder($order_id, 0)) {
            $sqlOrderList = "
{$ordrSql}
union
select '开通网营专家' main_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=single.`create_uid`) ope_name,`create_time`,'开通成功' result,'-' remark from `tm_single_info` single
where order_id = $order_id
";
        } else { //不存在该任务 则任务流程全部显示空
            $sqlOrderList = "
{$ordrSql}
union
select '开通网营专家' main_step_name,'' ope_name,'','' result,'-' remark 
";
        }
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlOrderList, null);
    }

    public function GetOrderFlowLong($order_id)
    {
        //网银门户订单业务流 步骤，操作人，操作时间，操作结果，备注(需要传入订单号)
        $tmCommonBLL = new TMCommonBLL();
        $ordrSql = $tmCommonBLL->getOrderFlowSQL($order_id, "netope");
        $sqlOrderList = "";
        if ($tmCommonBLL->iExistWYMHOrder($order_id, 0)) {
            $sqlOrderList = "
{$ordrSql}
union
select '' main_step_name,'网站制作任务分配' part_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`assign_uid`)ope_name,(select `agent_name` from `om_order` ord where ord.order_id=net.assign_uid)agent_name,`assign_time` ope_time,case when net.assign_uid<>0 then '已分配' else '未分配' end result,net.assign_remark remark from `tm_net` net where `order_id`=$order_id
union
select '' main_step_name,'网站制作' part_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`make_uid`)ope_name,(select `agent_name` from `om_order` ord where ord.order_id=net.assign_uid)agent_name,`make_time` ope_time,case when make_state=0 then '未完成' when make_state=1 then '已完成' when make_state=2 then '已修改完成' else '未知' end result,'' remark from `tm_net` net where `order_id`=$order_id
union
select '' main_step_name,'厂商建站质量评估' part_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`verify_uid`)ope_name,'-' agent_name,`verify_time` ope_time,case when `verify_state`=0 then '未审核' when `verify_state`=1 then '审核通过' when `verify_state`=2 then '审核未通过' else '未知' end result,net.`verify_remark` remark from `tm_net` net where `order_id`=$order_id
union
select '网站上线' main_step_name,'-'part_step_name,(select concat(`user_name`,'(',`e_name`,')') from `sys_user` user where user.`user_id`=net.`publish_uid`)ope_name,'-'agent_name,net.publish_time,case when publish_state=0 then '未发布' when publish_state=1 then '发布中' when publish_state=2 then '发布成功' when publish_state=3 then '发布失败' else '未知' end result,'' remark from `tm_net` net where `order_id`=$order_id;
";
        } else { //不存在该任务 则任务流程全部显示空
            $sqlOrderList = "
{$ordrSql}
union
select '' main_step_name,'网站制作任务分配' part_step_name,'' ope_name,'' agent_name,'' ope_time,'' result,'' remark
union
select '' main_step_name,'网站制作' part_step_name,'' ope_name,'' agent_name,'' ope_time,'' result,'' remark
union
select '' main_step_name,'厂商建站质量评估' part_step_name,'' ope_name,'' agent_name,'' ope_time,'' result,'' remark
union
select '网站上线' main_step_name,'-'part_step_name,'' ope_name,'' agent_name,'' ope_time,'' result,'' remark
";
        }
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlOrderList, null);
    }

    public function getAutoComplete($name, $agentid)
    {
        $sql = "select user_id,user_name,e_name from sys_user where (e_name like '%$name%' or user_name like '%$name%') and is_lock=0 and is_del=0 and agent_id=$agentid";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function getUserIDByName($name, $agentid)
    {
        $sql = "select user_id from sys_user where user_name='$name' and is_lock=0 and is_del=0 and agent_id=$agentid";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
    //创建代理商子管理员账号
    public function CreateSubAccount($agentID)
    {
        $tMCommonBLL = new TMCommonBLL();
        $param = array($agentID, $tMCommonBLL->getVerifi_code($agentID));
        $rtn = $tMCommonBLL->doSoapWYMH("createSubManager", $param);
        $rtn = json_decode($rtn, true);
        return $rtn;
    }

    //网营门户当前登录帐号查询
    public function selectBoundUserArray($agent_id,$financeUid)
    {
        $sql = "select A.user_id,A.WY_uname,A.load_time,B.user_name,case when B.is_lock=0 then '正常' when B.is_lock = 1 then '锁定' end as is_lock_name
            from tm_net_model_manage_user A 
            left join sys_user B on A.user_id = B.user_id
            where A.agent_id = $agent_id and B.finance_uid=$financeUid";
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
    }

    //网营门户历史绑定登录帐号查询
    public function selectHistoryBoundUserArray($agent_id,$financeUid)
    {
        $sql = "select A.Id,A.user_id,A.create_id,A.create_time,B.user_name,B.tel,B.phone,C.user_name as create_name,B.e_name
            from tm_net_model_manage_user_history A 
            Inner join sys_user C on A.create_id = C.user_id 
            left join sys_user B on A.user_id = B.user_id 
            where A.agent_id = $agent_id and C.finance_uid=$financeUid order by A.Id desc";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    //网营门户登录帐号绑定
    public function insertSubAccount($agent_id, $user_id, $WY_Uname, $creat_id)
    {
        $sql = "insert into `tm_net_model_manage_user`(`agent_id`,`user_id`,`WY_uname`,`create_id`,`create_time`)
             values($agent_id,$user_id,'$WY_Uname',$creat_id,now())  ";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //网营门户登录帐号帮定更新
    public function updateSubAcccount($user_id, $creat_id, $agent_id)
    {
        $sql = "update tm_net_model_manage_user set user_id = $user_id,update_id = $creat_id,update_time = now() where agent_id = $agent_id ";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //网营门户登录记录最后时间更新
    public function updateSubAcccountTime($agent_id)
    {
        $sql = "update tm_net_model_manage_user set load_time = now() where agent_id = $agent_id";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    //网营门户登录帐号绑定 历史记录
    public function insertSubHistory($agent_id, $user_id, $creat_id)
    {
        $sql = "insert into `tm_net_model_manage_user_history`(`agent_id`,`user_id`,`create_id`,`create_time`)
             values($agent_id,$user_id,$creat_id,now())  ";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    //select代理商是否已经获得绑定网营门户管理模块的帐号
    public function selectAccount($agent_id)
    {
        $sql = "select `WY_uname` from `tm_net_model_manage_user` where agent_id = $agent_id";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    //获取登录模块管理地址
    public function GetModelManageUrl($agentID, $account)
    {
        $date = date('Y-m-d');
        $DrpEncryptCode = md5("$account" . "$agentID" . "$date");
        $account = urlencode($account);
        $url = "http://m2.epanshi.com/?DrpEncryptCode=$DrpEncryptCode&account=$account";
        return $url;
    }
    
    
    public function GetSiteIDAndPublishState($orderID)
    {
        $sql = "SELECT tm_net.publish_state,tm_net.site_id FROM tm_net where order_id = $orderID";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
}
