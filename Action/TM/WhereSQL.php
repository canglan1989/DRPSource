<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：所有邮箱业务功能
 * 表描述：
 * 创建人：lxs  linxishengjiong@163.com
 * 添加时间：2011-9-7 19:18:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

class WhereSQL
{
    //获取该代理商下该用户所拥有客户的订单where语句
    //array("agent_id"=>$agent_id,"user_no"=>$user_no)
    public static function GetMyCustomerOrdersWhere($ary)
    {
        $where = " and ord.agent_id={$ary["agent_id"]} and ord.finance_uid={$ary["finance_uid"]} and ord.customer_id in(select cm_ag.customer_id from cm_customer_agent cm_ag where cm_ag.user_id in(SELECT user.user_id from sys_user user where user.user_no like '{$ary["user_no"]}%'
 and agent_id={$ary["agent_id"]}))";
        return $where;
    }
    //获取页面单个搜索条件对应where语句
    //$searchName--搜索条件对应name值
    public static function GetTMSingleWhere($searchName)
    {
        $where = "";
        switch ($searchName) {
            case "order_no":
                $order_no = Utility::GetForm('order_no', $_GET);
                if ($order_no <> "") {
                    $where .= " and ord.`order_no` like '%$order_no%'";
                }
                break;
            case "cus_name":
                $cus_name = Utility::GetForm('cus_name', $_GET);
                if ($cus_name <> "") {
                    $where .= " and (ord.`customer_name` like '%$cus_name%' or ord.`customer_id` like '%$cus_name%')";
                }
                break;
            case "ord_type":
                $ord_type = Utility::GetFormInt('ord_type', $_GET,-100);
                if ($ord_type >= -1 && $ord_type != 0) {
                    $where .= " and ord.`order_type`=$ord_type";
                }
                break;
            case "pro_type1":
                $pro_type1 = Utility::GetFormInt('pro_type1', $_GET);
                if ($pro_type1 != "" && $pro_type1 <> -100) {
                    $where .= " and ord.`product_id` in(select `product_id` from `sys_product` _pro where _pro.`product_type_id` in(select `aid` from `sys_product_type` _type where `aid`='$pro_type1'))";
                }
                break;
            case "pro_type2":
                $pro_type2 = Utility::GetFormInt('pro_type2', $_GET);
                if ($pro_type2 != "" && $pro_type2 <> -100) {
                    $where .= " and ord.`product_id` = $pro_type2";
                }
                break;
            case "post_name":
                $post_name = Utility::GetForm('post_name', $_GET);
                if ($post_name <> "") {
                    $where .= " and ord.`post_uid` in (select `user_id` from `sys_user` where e_name like '%$post_name%' or user_name like '%$post_name%')";
                }
                break;
            case "mail_state":
                $mail_state = Utility::GetForm('mail_state', $_GET);
                if ($mail_state <> "" && $mail_state <> -1) {
                    if ($mail_state == 1)
                        $where .= " and mail.`turnOn_uid`<>0";
                    else
                        $where .= " and (mail.`turnOn_uid`=0 or mail.`turnOn_uid` is null)";
                }
                break;
            case "mail_analy_state":
                $analy_state = Utility::GetForm('mail_analy_state', $_GET);
                if ($analy_state <> "" && $analy_state <> -1) {
                    if ($analy_state == 1)
                        $where .= " and mail.`analy_uid`<>0";
                    else
                        $where .= " and (mail.`analy_uid`=0 or mail.`analy_uid` is null)";
                }
                break;
            case "mail_info_state":
                $info_state = Utility::GetForm('mail_info_state', $_GET);
                if ($info_state <> "" && $info_state <> -1) {
                    if ($info_state == 1)
                        $where .= " and mail.`info_confirm_uid`<>0";
                    else
                        $where .= " and (mail.`info_confirm_uid`=0 or mail.`info_confirm_uid` is null)";
                }
                break;
            case "order_time_begin": //下单时间
                $order_time_begin = Utility::GetForm('order_time_begin', $_GET);
                if ($order_time_begin <> "") {
                    $where .= " and ord.`last_check_time` >= '$order_time_begin'";
                }
                break;
            case "order_time_end":
                $order_time_end = Utility::GetForm('order_time_end', $_GET);
                if ($order_time_end <> "") {
                    $where .= " and ord.`last_check_time` < date_add('{$order_time_end}',interval 1 day)";
                }
                break;
            case "agent_name":
                $agent_name = Utility::GetForm('agent_name', $_GET);
                if ($agent_name <> "") {
                    $where .= " and (ord.`agent_name` like '%$agent_name%' or ord.`agent_id` like '%$agent_name%')";
                }
                break;
            case "web_site":
                $web_site = Utility::GetForm('web_site', $_GET);
                if ($web_site <> "") {
                    $where .= " and web_site like '%$web_site%'";
                }
                break;
            case "trust_task_state":
                $trust_task_state = Utility::GetForm('trust_task_state', $_GET);
                if ($trust_task_state <> "" && $trust_task_state <> -1) {
                    if ($trust_task_state == 1)
                        $where .= " and install_uid<>0";
                    else
                        $where .= " and (install_uid=0 or install_uid is null)";
                }
                break;
            case "trust_verify":
                $trust_verify = Utility::GetForm('trust_verify', $_GET);
                if ($trust_verify <> "" && $trust_verify <> -1) {
                    if ($trust_verify == 1)
                        $where .= " and verify_uid<>0";
                    else
                        $where .= " and (verify_uid=0 or verify_uid is null)";
                }
                break;
            case "post_time_begin": //下单时间
                $post_time_begin = Utility::GetForm('post_time_begin', $_GET);
                if ($post_time_begin <> "") {
                    $where .= " and ord.`create_time` >= '$post_time_begin'";
                }
                break;
            case "post_time_end":
                $post_time_end = Utility::GetForm('post_time_end', $_GET);
                if ($post_time_end <> "") {
                    $where .= " and ord.`create_time` < date_add('{$post_time_end}',interval 1 day)";
                }
                break;
            case "trust_install_name":
                $trust_install_name = Utility::GetForm('trust_install_name', $_GET);
                if ($trust_install_name <> "") {
                    $where .= " and install_uid in(select user_id from sys_user where e_name like '%$trust_install_name%' or user_name like '%$trust_install_name%')";
                }
                break;
            case "order_sdate_begin": //订单开始
                $order_sdate_begin = Utility::GetForm('order_sdate_begin', $_GET);
                if ($order_sdate_begin <> "") {
                    $where .= " and ord.`order_sdate` >= '$order_sdate_begin'";
                }
                break;
            case "order_sdate_end": //订单结束
                $order_sdate_end = Utility::GetForm('order_sdate_end', $_GET);
                if ($order_sdate_end <> "") {
                    $where .= " and ord.`order_edate` < date_add('{$order_sdate_end}',interval 1 day)";
                }
                break;
            case "order_edate_begin": //有效期开始
                $order_edate_begin = Utility::GetForm('order_edate_begin', $_GET);
                if ($order_edate_begin <> "") {
                    $where .= " and ord.`effect_sdate` >= '$order_edate_begin'";
                }
                break;
            case "order_edate_end": //有效期结束
                $order_edate_end = Utility::GetForm('order_edate_end', $_GET);
                if ($order_edate_end <> "") {
                    $where .= " and ord.`effect_edate` < date_add('{$order_edate_end}',interval 1 day)";
                }
                break;
            case "single_account":
                $single_account = Utility::GetForm('single_account', $_GET);
                if ($single_account <> "") {
                    $where .= " and single.login_name like '%$single_account%'";
                }
                break;
            case "single_deal_name":
                $single_deal_name = Utility::GetForm('single_deal_name', $_GET);
                if ($single_deal_name <> "") {
                    $where .= " and single.`create_uid` in (select `user_id` from `sys_user` where e_name like '%$single_deal_name%' or user_name like '%$single_deal_name%')";
                }
                break;
            case "single_deal_time_begin": //单点帐号添加/处理时间
                $single_deal_time_begin = Utility::GetForm('single_deal_time_begin', $_GET);
                if ($single_deal_time_begin <> "") {
                    $where .= " and single.`create_time` >= '$single_deal_time_begin'";
                }
                break;
            case "single_deal_time_end": //单点帐号添加/处理时间
                $single_deal_time_end = Utility::GetForm('single_deal_time_end', $_GET);
                if ($single_deal_time_end <> "") {
                    $where .= " and single.`create_time` < date_add('{$single_deal_time_end}',interval 1 day)";
                }
                break;
            case "single_account_state": //帐号状态 关闭--不包括未开通的情况
                $single_account_state = Utility::GetForm('single_account_state', $_GET);
                if ($single_account_state <> "" && $single_account_state <> -1) {
                    if ($single_account_state == 1)
                        $where .= " and single.login_state<>0";
                    else
                        $where .= " and (single.login_state=0)";
                }
                break;
            case "net_assign_state":
                $net_assign_state = Utility::GetForm('net_assign_state', $_GET);
                if ($net_assign_state <> "" && $net_assign_state <> -1) {
                    if ($net_assign_state == 1)
                        $where .= " and net.assign_uid<>0";
                    else
                        $where .= " and (net.assign_uid=0 or net.assign_uid is null)";
                }
                break;
            case "net_make_name":
                $net_make_name = Utility::GetForm('net_make_name', $_GET);
                if ($net_make_name <> "") {
                    $where .= " and net.`make_uid` in (select `user_id` from `sys_user` where e_name like '%$net_make_name%' or user_name like '%$net_make_name%')";
                }
                break;
            case "net_make_state":
                $net_make_state = Utility::GetForm('net_make_state', $_GET);
                if ($net_make_state <> "" && $net_make_state <> -1) {
                    $where .= " and net.make_state=$net_make_state";
                }
                break;
            case "net_verify_state":
                $net_verify_state = Utility::GetForm('net_verify_state', $_GET);
                if ($net_verify_state <> "" && $net_verify_state <> -1) {
                    $where .= " and net.verify_state=$net_verify_state";
                }
                break;
            case "net_make_time_begin":
                $net_make_time_begin = Utility::GetForm('net_make_time_begin', $_GET);
                if ($net_make_time_begin <> "") {
                    $where .= " and net.`make_time` >= '$net_make_time_begin'";
                }
                break;
            case "net_make_time_end":
                $net_make_time_end = Utility::GetForm('net_make_time_end', $_GET);
                if ($net_make_time_end <> "") {
                    $where .= " and net.`make_time` < date_add('{$net_make_time_end}',interval 1 day)";
                }
                break;
            case "net_analy_state":
                $net_analy_state = Utility::GetForm('net_analy_state', $_GET);
                if ($net_analy_state <> "" && $net_analy_state <> -1) {
                    if ($net_analy_state == 1)
                        $where .= " and net.analy_uid<>0";
                    else
                        $where .= " and (net.analy_uid=0 or net.analy_uid is null)";
                }
                break;
            case "net_analy_time_begin":
                $net_analy_time_begin = Utility::GetForm('net_analy_time_begin', $_GET);
                if ($net_analy_time_begin <> "") {
                    $where .= " and net.`analy_time` >= '$net_analy_time_begin'";
                }
                break;
            case "net_analy_time_end":
                $net_analy_time_end = Utility::GetForm('net_analy_time_end', $_GET);
                if ($net_analy_time_end <> "") {
                    $where .= " and net.`analy_time` < date_add('{$net_analy_time_end}',interval 1 day)";
                }
                break;
            case "net_online_time_begin":
                $net_online_time_begin = Utility::GetForm('net_online_time_begin', $_GET);
                if ($net_online_time_begin <> "") {
                    $where .= " and net.`onLine_time` >= '$net_online_time_begin'";
                }
                break;
            case "net_online_time_end":
                $net_online_time_end = Utility::GetForm('net_online_time_end', $_GET);
                if ($net_online_time_end <> "") {
                    $where .= " and net.`onLine_time` < date_add('{$net_online_time_end}',interval 1 day)";
                }
                break;
            case "icp_no":
                $icp_no = Utility::GetForm('icp_no', $_GET);
                if ($icp_no <> "") {
                    $where .= " and net.bakcUp_code like '%$icp_no%'";
                }
                break;
            case "backUp_state":
                $backUp_state = Utility::GetForm('backUp_state', $_GET);
                if ($backUp_state <> "" && $backUp_state <> -1) {
                    $where .= " and net.backUp_state =$backUp_state";
                }
                break;
            case "begin_backUp_time_begin": //开始备案时间
                $begin_backUp_time_begin = Utility::GetForm('begin_backUp_time_begin', $_GET);
                if ($begin_backUp_time_begin <> "") {
                    $where .= " and net.`begin_backUp_time` >= '$begin_backUp_time_begin'";
                }
                break;
            case "begin_backUp_time_end":
                $begin_backUp_time_end = Utility::GetForm('begin_backUp_time_end', $_GET);
                if ($begin_backUp_time_end <> "") {
                    $where .= " and net.`begin_backUp_time` < date_add('{$begin_backUp_time_end}',interval 1 day)";
                }
                break;
            case "end_backUp_time_begin": //完成备案时间
                $end_backUp_time_begin = Utility::GetForm('end_backUp_time_begin', $_GET);
                if ($end_backUp_time_begin <> "") {
                    $where .= " and net.`end_backUp_time` >= '$end_backUp_time_begin'";
                }
                break;
            case "end_backUp_time_end":
                $end_backUp_time_end = Utility::GetForm('end_backUp_time_end', $_GET);
                if ($end_backUp_time_end <> "") {
                    $where .= " and net.`end_backUp_time` < date_add('{$end_backUp_time_end}',interval 1 day)";
                }
                break;
            case "net_publish_time_begin": //网站发布时间
                $end_backUp_time_begin = Utility::GetForm('net_publish_time_begin', $_GET);
                if ($end_backUp_time_begin <> "") {
                    $where .= " and net.`publish_time` >= '$end_backUp_time_begin'";
                }
                break;
            case "net_publish_time_end":
                $net_publish_time_end = Utility::GetForm('net_publish_time_end', $_GET);
                if ($net_publish_time_end <> "") {
                    $where .= " and net.`publish_time` < date_add('{$net_publish_time_end}',interval 1 day)";
                }
                break;
            case "pub_state":
                $pub_state = Utility::GetForm('pub_state', $_GET);
                if ($pub_state <> "" && $pub_state <> -1) {
                    $where .= " and net.publish_state =$pub_state";
                }
                break;
            case "i_backUp":
                $i_backUp = Utility::GetForm('i_backUp', $_GET);
                if ($i_backUp <> "" && $i_backUp <> -1) {
                    if ($i_backUp == -2) {
                        $where .= " and net.backUp_state<>2";
                    } else
                        if ($i_backUp == 2) {
                            $where .= " and net.backUp_state=2";
                        }
                }
                break;
            default:
                break;
        }
        return $where;
    }
}
?>