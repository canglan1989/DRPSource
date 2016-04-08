<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：linxishengjiong@163.com
 * 添加时间：2011-8-30
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../../Class/BLL/TMNetOpeBLL.php';
require_once __DIR__ . '/../../Action/TM/WhereSQL.php';
require_once __DIR__ . '/../../Class/BLL/AgentcheckLogBLL.php';

class NetOpeAction extends ActionBase
{

    public function __construct()
    {
        $this->objAgentcheckLogBLL = new AgentcheckLogBLL();
    }
    /**
     * 前台 
     * */
    //显示网营门户任务查询列表
    public function ShowNetTaskListFront()
    {
        $strUrl = $this->getActionUrl('TM', 'NetOpe', 'ShowNetTaskListFrontBody');
        $tmNetOpeBLL = new TMNetOpeBLL();
        $agent_id = self::getAgentId();
        $user_no = self::getUserNo();
        $where = WhereSQL::GetMyCustomerOrdersWhere(array("agent_id" => $agent_id,"finance_uid" => $this->getFinanceUid(),
            "user_no" => $user_no));
        $where .= " and ord.order_id not in(SELECT o.source_order_id from om_order as o where o.agent_id=$agent_id and o.order_type=2 and o.is_del=0)";
        $headData = $tmNetOpeBLL->GetHeadData($where);
        if (count($headData) == 1) {
            $this->smarty->assign('headData', $headData[0]);
        }
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/NetOpe/TaskListFront.tpl");
    }

    public function ShowNetTaskListFrontBody()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $where = self::GetWhere();
        $agent_id = self::getAgentId();
        $user_no = self::getUserNo();
        $where .= WhereSQL::GetMyCustomerOrdersWhere(array("agent_id" => $agent_id,"finance_uid" => $this->getFinanceUid(),
            "user_no" => $user_no));
        $where .= " and ord.order_id not in(SELECT o.source_order_id from om_order as o where o.agent_id=$agent_id and o.order_type=2 and o.is_del=0)";
        $fields_ary = array("order_id", "order_no", "customer_id", "cus_name_id",
            "product_name", "order_type", "order_state", "post_user_name_id", "post_time",
            "last_check_time", "task_state", "make_uid", "make_name", "assign_uid",
            "assign_name", "assign_time", "task_state", "make_uid", "make_name");
        $arrPageList = $tmNetOpeBLL->GetListData($where, "", $fields_ary, "");
        self::showPageSmarty($arrPageList, 'TM/NetOpe/TaskListFrontBody.tpl');
    }

    //显示我的网建任务列表
    public function ShowMyTaskFront()
    {
        $strUrl = $this->getActionUrl('TM', 'NetOpe', 'ShowMyTaskFrontBody');
        $tmNetOpeBLL = new TMNetOpeBLL();
        //已分配 属于自己的任务
        $user_no = self::getUserNo();
        $agent_id = self::getAgentId();
        $where = " and net.assign_uid<>0 and ord.agent_id=$agent_id and net.`make_uid`=".$this->getUserId(); //in(select `user_id` from `sys_user` where `user_no` = '$user_no' and agent_id=$agent_id) 
        $headData = $tmNetOpeBLL->GetHeadData($where);
        if (count($headData) == 1) {
            $this->smarty->assign('headData', $headData[0]);
        }
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/NetOpe/MyTaskListFront.tpl");
    }

    public function ShowMyTaskFrontBody()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $user_no = self::getUserNo();
        $agent_id = self::getAgentId();
        $where = self::GetWhere();
        //已分配 属于自己的任务
        $where .= " and net.assign_uid<>0 and ord.agent_id=$agent_id and net.`make_uid`=".$this->getUserId();//in(select `user_id` from `sys_user` where `user_no` = '$user_no' and agent_id=$agent_id) ;
        $fields_ary = array("order_id", "order_no", "cus_name_id", "customer_id",
            "product_name", "order_state", "make_state", "verify_state", "make_finish_time",
            "assign_uid", "assign_name", "assign_time", "i_effect", "site_account_name",
            "site_id", "site_md_str");
        $sortField = "(case when tb.verify_state='审核未通过' then 0 when tb.verify_state='未审核' then 1 when tb.verify_state='审核通过' then 2 end) asc,assign_time asc";
        $arrPageList = $tmNetOpeBLL->GetListData($where, "", $fields_ary, $sortField);
        //var_dump($arrPageList);exit;
        foreach ($arrPageList["list"] as $item => $value) {
            $arrPageList["list"][$item]["site_url"] = self::getWYURL($arrPageList["list"][$item]["site_id"],
                $arrPageList["list"][$item]["site_account_name"], $arrPageList["list"][$item]["site_md_str"]);
        }
        self::showPageSmarty($arrPageList, 'TM/NetOpe/MyTaskListFrontBody.tpl');
    }

    //得到网营伪登录url
    //正式的 b3.epanshi.com
    //测试的 buildtest.epanshi.com:8080
    function getWYURL($site_id, $site_account_name, $site_md_str)
    {
        $arrSysConfig = unserialize(SYS_CONFIG);
        $arrSysConfig = $arrSysConfig['SoapLocation' . $arrSysConfig['SYS_EVN']];
        $baseUrl = "{$arrSysConfig['WYMHLogin']}/{$site_id}";
        $url = "$baseUrl?u=$site_account_name&md=" . substr(md5($site_md_str), 0, 20);
        return $url;
    }

    //显示上线网站查询
    public function ShowOnlineSiteListFront()
    {
        $strUrl = $this->getActionUrl('TM', 'NetOpe', 'ShowOnlineSiteListFrontBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/NetOpe/OnlineListFront.tpl");
    }

    public function ShowOnlineSiteListFrontBody()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $where = self::GetWhere();
        $agent_id = self::getAgentId();
        $user_no = self::getUserNo();
        //已上线
        $where .= " and net.publish_uid<>0";
        $where .= WhereSQL::GetMyCustomerOrdersWhere(array("agent_id" => $agent_id,"finance_uid" => $this->getFinanceUid(),
            "user_no" => $user_no));
        $fields_ary = array("order_id", "order_no", "cus_name_id", "customer_id",
            "product_name", "order_type", "order_state", "post_user_name_id", "post_uid",
            "post_time", "last_check_time", "onLine_time", "site_ip");
        $arrPageList = $tmNetOpeBLL->GetListData($where, "", $fields_ary, "");
        self::showPageSmarty($arrPageList, 'TM/NetOpe/OnlineListFrontBody.tpl');
    }

    //任务分配
    public function WorkAssign()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();

        $targetUserName = urldecode(Utility::GetForm("accountName", $_POST));
        $order_id = Utility::GetFormInt("id", $_POST);
        $assign_remark = urldecode(Utility::GetForm("assign_remark", $_POST));
        $assign_uid = $this->getUserId();

        $arrName = explode("(", $targetUserName);
        $user_name = $arrName[0];
        $agentid = $this->getAgentId();
        $user_id = $tmNetOpeBLL->getUserIDByName($user_name, $agentid);
        if ($user_id == "" || $user_id == 0) {
            die(json_encode(array("success" => false, "msg" => "不存在此用户")));
        } else {
            $rst = $tmNetOpeBLL->TaskAssign($order_id, $assign_uid, $assign_remark, $user_id,
                0);
            if ($rst > 0)
                echo json_encode(array("success" => true, "msg" => "分配成功"));
            else
            {
                $msg = "分配失败";
                switch($rst)
                {
                    case -1: $msg = "验证失败";
                    break;
                    case -2: $msg = "参数传入出错";
                    break;                    
                    case -3: $msg = "订单ID重复";
                    break;                    
                    case -4: $msg = "添加drp订单信息失败";
                    break;                    
                    case -5: $msg = "添加客户信息失败";
                    break;                    
                    case -6: $msg = "设置默认服务器失败";
                    break;
                    case -7: $msg = "插入站点失败";
                    break;                    
                    case -8: $msg = "添加账号失败";
                    break;                    
                    case -9: $msg = "添加建站角色失败";
                    break;                    
                    case -10: $msg = "添加站点用户关系失败";
                    break;                 
                    case -11: $msg = "设置站点默认信息失败";
                    break;
                }
                echo json_encode(array("success" => false, "msg" => $msg));
            }
                
        }
    }

    //任务转移
    public function WorkTransfer()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();

        $targetUserName = urldecode(Utility::GetForm("amount", $_POST));
        $order_id = Utility::GetFormInt("oid", $_POST);
        $assign_uid = $this->getUserId();

        $arrName = explode("(", $targetUserName);
        $user_name = $arrName[0];
        $agentid = $this->getAgentId();
        $user_id = $tmNetOpeBLL->getUserIDByName($user_name, $agentid);
        if ($user_id == "" || $user_id == 0) {
            die(json_encode(array("success" => false, "msg" => "不存在此用户")));
        } else {
            $rst = $tmNetOpeBLL->TaskTransfer($order_id, $assign_uid, $user_id);
            if ($rst>0)
                echo json_encode(array("success" => true, "msg" => "转移成功"));
            else
            {
                $msg = "转移失败";
                switch($rst)
                {
                    case -1: $msg = "验证失败";
                    break;
                    case -2: $msg = "参数传入出错";
                    break;                    
                    case -3: $msg = "订单ID重复";
                    break;                    
                    case -4: $msg = "添加drp订单信息失败";
                    break;                    
                    case -5: $msg = "添加客户信息失败";
                    break;                    
                    case -6: $msg = "设置默认服务器失败";
                    break;
                    case -7: $msg = "插入站点失败";
                    break;                    
                    case -8: $msg = "添加账号失败";
                    break;                    
                    case -9: $msg = "添加建站角色失败";
                    break;                    
                    case -10: $msg = "添加站点用户关系失败";
                    break;                 
                    case -11: $msg = "设置站点默认信息失败";
                    break;
                }
                echo json_encode(array("success" => false, "msg" => $msg));
            }
                
        }
    }

    //获取转移前任务人信息
    public function getSourseInfo()
    {
        $mkname = Utility::GetForm("mkname", $_GET);
        $assign = array('mkname' => $mkname);
        $this->displayPage("TM/NetOpe/ShowWorkTransfer.tpl", $assign);
    }

    //显示产品订单状态
    public function getOrderStatusShort()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $order_id = Utility::GetFormInt("id", $_GET);
        $rst = $tmNetOpeBLL->GetOrderFlowShort($order_id);
        $this->displayPage("TM/NetOpe/WebMakeProcessShort.tpl", array('data' => $rst));
    }
    public function getOrderStatusWyzj()
    {
        $order_id = Utility::GetFormInt("id", $_GET);
        
        include_once __DIR__ . '/../../Class/BLL/AgentAccountDetailBLL.php';
        $objAgentAccountDetail = new AgentAccountDetailBLL();
        $arrData = $objAgentAccountDetail->getOrderBackInfo($order_id);
        $this->smarty->assign("BackInfo",$arrData);
        $strBackHtml = $this->smarty->fetch('TM/BackOrderInfo.tpl');
        
        $tmNetOpeBLL = new TMNetOpeBLL();
        $rst = $tmNetOpeBLL->getOrderStatusWyzj($order_id);
        $this->displayPage("TM/EMail/WebMakeProcess.tpl", array('data' => $rst,'backhtml'=>$strBackHtml));
    }
    public function getOrderStatusLong()
    {
         $order_id = Utility::GetFormInt("id", $_GET);
         
        include_once __DIR__ . '/../../Class/BLL/AgentAccountDetailBLL.php';
        $objAgentAccountDetail = new AgentAccountDetailBLL();
        $arrData = $objAgentAccountDetail->getOrderBackInfo($order_id);
        $this->smarty->assign("BackInfo",$arrData);
        $strBackHtml = $this->smarty->fetch('TM/BackOrderInfo.tpl');
         
        $tmNetOpeBLL = new TMNetOpeBLL();
        $rst = $tmNetOpeBLL->GetOrderFlowLong($order_id);
        $this->displayPage("TM/NetOpe/WebMakeProcessLong.tpl", array('data' => $rst,'backhtml'=>$strBackHtml));
    }

    //设置完成
    public function setFinish()
    {
        $order_id = Utility::GetFormInt("id", $_POST);
        $status = Utility::GetForm("status", $_POST);
        $tmNetOpeBLL = new TMNetOpeBLL();
        $rst = $tmNetOpeBLL->setFinshTag($order_id, $status, $this->getUserId());
        if ($rst)
            echo json_encode(array("success" => true, "msg" => "设置成功"));
        else
            echo json_encode(array("success" => false, "msg" => "设置失败"));
    }

    //设置域名解析完成
    public function setAnalyFinsh()
    {
        $order_id = Utility::GetForm("id", $_POST);
        $tmNetOpeBLL = new TMNetOpeBLL();
        $rst = $tmNetOpeBLL->SetAnalyUid($order_id, $this->getUserId());
        if ($rst)
            echo json_encode(array("success" => true, "msg" => "设置成功"));
        else
            echo json_encode(array("success" => false, "msg" => "设置失败"));
    }

    /**
     * 后台
     * */
    //显示ICP备案列表
    public function ShowICPListBack()
    {
        $this->PageRightValidate("ICP", RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'NetOpe', 'ShowICPListBackBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/NetOpe/ICPBackUpListBack.tpl");
    }

    public function ShowICPListBackBody()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $where = self::GetWhere();
        $agent_id = self::getAgentId();
        $user_no = self::getUserNo();
        $where .= WhereSQL::GetMyCustomerOrdersWhere(array("agent_id" => $agent_id,"finance_uid" => $this->getFinanceUid(),
            "user_no" => $user_no));
        $fields_ary = array("order_id", "order_no", "product_name", "order_state",
            "cus_name_id", "customer_id", "icp_contact_name", "web_site", "backUp_state",
            "bakcUp_code", "begin_back", "end_back");
        $arrPageList = $tmNetOpeBLL->GetListData($where, self::GetOutWhere(), $fields_ary,
            "");
        self::showPageSmarty($arrPageList, 'TM/NetOpe/ICPBackUpListBackBody.tpl');
    }

    //显示ICP联系人
    public function ShowICPModifyContact()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $order_id = Utility::GetFormInt("order_id", $_GET);
        $icp_contact = $tmNetOpeBLL->GetICPContact($order_id);
        if (count($icp_contact) == 1)
            $this->smarty->assign('icp_contact', $icp_contact[0]);
        $this->smarty->assign('order_id', $order_id);
        $this->displayPage("TM/NetOpe/ICP_modify_contact.tpl");
    }

    //修改联系人
    public function ModifyContact()
    {
        $order_id = Utility::GetFormInt("order_id", $_POST);
        $contact_name = Utility::GetForm("contact_name", $_POST);
        $contact_mobile = Utility::GetForm("contact_mobile", $_POST);
        $contact_tel = Utility::GetForm("contact_tel", $_POST);
        $uid = $this->getUserId();
        $tmNetOpeBLL = new TMNetOpeBLL();
        $rst = $tmNetOpeBLL->ICPContactModify($order_id, $uid, $contact_name, $contact_mobile,
            $contact_tel);
        if ($rst)
            echo json_encode(array("success" => true, "msg" => "修改成功"));
        else
            echo json_encode(array("success" => false, "msg" => "修改失败"));
    }

    //完成备案
    public function FinishBackUp()
    {
        $order_id = Utility::GetFormInt("order_id", $_POST);
        $back_uid = $this->getUserId();
        $bakcUp_code = Utility::GetForm("BA_num", $_POST);
        $tmNetOpeBLL = new TMNetOpeBLL();
        $rst = $tmNetOpeBLL->ICPBackUpFinish($order_id, $back_uid, $bakcUp_code);
        if ($rst)
            echo json_encode(array("success" => true, "msg" => "备案成功"));
        else
            echo json_encode(array("success" => false, "msg" => "备案失败"));
    }

    //显示网站评审列表
    public function ShowSiteVerifyListBack()
    {
        $this->PageRightValidate("SiteVerify", RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'NetOpe', 'ShowSiteVerifyListBackBody');
        $tmNetOpeBLL = new TMNetOpeBLL();
        $headData = $tmNetOpeBLL->GetSiteVerifyHeadData();
        if (count($headData) == 1) {
            $this->smarty->assign('headData', $headData[0]);
        }
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/NetOpe/SiteVerifyBack.tpl");
    }

    public function ShowSiteVerifyListBackBody()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $where = self::GetWhere();
        /**
         * 4.	前置流程： 数据需满足三个条件
         * 1)	域名解析完成
         * 2)	建站完成或修改完成
         * 3)	备案完成(20120330取消该条件)
         */
        $where .= " and net.analy_uid<>0 and net.make_state<>0"; // and backUp_state=2
        $fields_ary = array("order_id", "order_no", "agent_name_id", "order_type",
            "cus_name_id", "customer_id", "product_name", "order_state", "make_type",
            "bakcUp_code", "verify_state", "verify_remark", "verify_time", "verify_uid",
            "verify_name_id", "site_ip", "i_backUp");
        $sortField = "(case when tb.verify_state='未审核' then 0 when tb.verify_state='审核未通过' then 1 when tb.verify_state='审核通过' then 2 end) asc";
        $arrPageList = $tmNetOpeBLL->GetListData($where, "", $fields_ary, $sortField);
        self::showPageSmarty($arrPageList, 'TM/NetOpe/SiteVerifyBackBody.tpl');
    }

    //显示网站评审卡片
    public function ShowSiteVerifyCard()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $order_id = Utility::GetFormInt("order_id", $_GET);
        $arrPageList = $tmNetOpeBLL->GetVerifyHistoryList($order_id);
        $this->smarty->assign('order_id', $order_id);
        $this->smarty->assign('arrayData', $arrPageList);
        $this->displayPage("TM/NetOpe/SiteVerifyCard.tpl");
    }

    //保存评审结果
    public function SaveSiteVerify()
    {
        $order_id = Utility::GetFormInt("order_id", $_POST);
        $verify_uid = $this->getUserId();
        $verify_state = Utility::GetForm("verify_state", $_POST);
        $verify_remark = Utility::GetForm("verify_remark", $_POST);
        $un_pass_reason = Utility::GetForm("un_pass_reason", $_POST);
        //die($order_id."_".$verify_uid."_".$verify_state."_".$verify_remark."_".$un_pass_reason."_");
        $tmNetOpeBLL = new TMNetOpeBLL();
        $rst = $tmNetOpeBLL->SiteVerify($order_id, $verify_uid, $verify_state, $verify_remark,
            $un_pass_reason);
        if ($rst)
            echo json_encode(array("success" => true, "msg" => "评审成功"));
        else
            echo json_encode(array("success" => false, "msg" => "评审失败"));
    }

    //显示网站发布列表
    public function ShowSitePublishListBack()
    {
        $this->PageRightValidate("SitePublish", RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'NetOpe', 'ShowSitePublishListBackBody');
        $tmNetOpeBLL = new TMNetOpeBLL();
        $headData = $tmNetOpeBLL->GetSitePublishHeadData();
        if (count($headData) == 1) {
            $this->smarty->assign('headData', $headData[0]);
        }
        
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/NetOpe/SitePublishBack.tpl");
    }

    public function ShowSitePublishListBackBody()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $where = self::GetWhere();
        /**
         * 4.	前置流程： 数据需满足三个条件
         * 1)	域名解析完成
         * 2)	建站质量评审通过
         * 3)	备案完成(20120330取消该条件)
         */
        $where .= " and net.analy_uid<>0 and verify_state=1"; // and backUp_state=2
        $i_backUp_publish_right = $this->HaveRight("SitePublish", RightValue::v512);
        $un_backUp_publish_right = $this->HaveRight("SitePublish", RightValue::v1024);
        if ($i_backUp_publish_right && !$un_backUp_publish_right) { //只有备案发布功能
            $where .= " and backUp_state=2";
        }
        if ($un_backUp_publish_right && !$i_backUp_publish_right) { //只有未备案发布功能
            $where .= " and backUp_state<>2";
        }
        if (!$un_backUp_publish_right && !$i_backUp_publish_right) { //两个功能都没有
            $where .= " and 1<>1";
        }
        $fields_ary = array("order_id", "order_no", "cus_name_id", "customer_id",
            "agent_name_id", "agent_id", "order_type", "product_name", "web_site",
            "publish_state", "onLine_time", "publish_name", "publish_time", "i_backUp");
        $arrPageList = $tmNetOpeBLL->GetListData($where, self::GetOutWhere(), $fields_ary,
            "");
        self::showPageSmarty($arrPageList, 'TM/NetOpe/SitePublishBackBody.tpl');
    }

    public function SitePublish()
    {
        $order_ids = Utility::GetForm("oids", $_POST);
        $publish_uid = $this->getUserId();
        $tmNetOpeBLL = new TMNetOpeBLL();
        $tmNetOpeBLL->SitePublish($order_ids, $publish_uid);
        echo json_encode(array("success" => true, "msg" => "已在发布中"));
    }

    public function SitePublishWYMH()
    {
        $order_ids = Utility::GetForm("oids", $_POST);
        $publish_uid = $this->getUserId();
        $tmNetOpeBLL = new TMNetOpeBLL();
        $rtn = $tmNetOpeBLL->SitePublishWYMH($order_ids, $publish_uid);
    }

    //显示网营帐号列表
    public function ShowNetAccountListBack()
    {
        $strUrl = $this->getActionUrl('TM', 'NetOpe', 'ShowNetAccountListBackBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/NetOpe/NetAccountListBack.tpl");
    }

    public function ShowNetAccountListBackBody()
    {
        $tmNetOpeBLL = new TMNetOpeBLL();
        $where = "";
        $net_u_name = Utility::GetForm('net_u_name', $_GET);
        if ($net_u_name <> "") {
            $where .= " and tm_user.net_u_name like '%$net_u_name%'";
        }
        $agent_name = Utility::GetForm('agent_name', $_GET);
        if ($agent_name <> "") {
            $where .= " and ag.agent_name like '%$agent_name%'";
        }
        $agent_id = Utility::GetFormInt('agent_id', $_GET);
        if ($agent_id <> "") {
            $where .= " and ag.agent_id = $agent_id";
        }
        $net_user_state = Utility::GetForm('net_user_state', $_GET);
        if ($net_user_state <> "" && $net_user_state <> -1) {
            $where .= " and tm_user.is_lock=$net_user_state";
        }
        $arrPageList = $tmNetOpeBLL->GetNetUserData($where);
        self::showPageSmarty($arrPageList, 'TM/NetOpe/NetAccountListBackBody.tpl');
    }

    //获取页面搜索条件并生成where语句
    public function GetWhere()
    {
        $where = "";
        $where .= WhereSQL::GetTMSingleWhere("order_no");
        $where .= WhereSQL::GetTMSingleWhere("agent_name");
        $where .= WhereSQL::GetTMSingleWhere("cus_name");
        $where .= WhereSQL::GetTMSingleWhere("ord_type");
        $where .= WhereSQL::GetTMSingleWhere("pro_type1");
        $where .= WhereSQL::GetTMSingleWhere("pro_type2");
        $where .= WhereSQL::GetTMSingleWhere("post_name");
        $where .= WhereSQL::GetTMSingleWhere("post_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("post_time_end");
        $where .= WhereSQL::GetTMSingleWhere("order_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("order_time_end");
        $where .= WhereSQL::GetTMSingleWhere("order_sdate_begin");
        $where .= WhereSQL::GetTMSingleWhere("order_sdate_end");
        $where .= WhereSQL::GetTMSingleWhere("order_edate_begin");
        $where .= WhereSQL::GetTMSingleWhere("order_edate_end");
        $where .= WhereSQL::GetTMSingleWhere("i_backUp");

        $where .= WhereSQL::GetTMSingleWhere("net_assign_state");
        $where .= WhereSQL::GetTMSingleWhere("net_make_name");
        $where .= WhereSQL::GetTMSingleWhere("net_make_state");
        $where .= WhereSQL::GetTMSingleWhere("net_verify_state");
        $where .= WhereSQL::GetTMSingleWhere("net_make_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("net_make_time_end");

        $where .= WhereSQL::GetTMSingleWhere("net_analy_state");
        $where .= WhereSQL::GetTMSingleWhere("net_analy_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("net_analy_time_end");

        $where .= WhereSQL::GetTMSingleWhere("net_online_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("net_online_time_end");

        $where .= WhereSQL::GetTMSingleWhere("icp_no");
        $where .= WhereSQL::GetTMSingleWhere("backUp_state");
        $where .= WhereSQL::GetTMSingleWhere("begin_backUp_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("begin_backUp_time_end");
        $where .= WhereSQL::GetTMSingleWhere("end_backUp_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("end_backUp_time_end");

        $where .= WhereSQL::GetTMSingleWhere("net_publish_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("net_publish_time_end");
        $where .= WhereSQL::GetTMSingleWhere("pub_state");
        return $where;
    }

    //获取页面外搜索条件并生成outWhere语句
    public function GetOutWhere()
    {
        $outWhere = "";
        $outWhere .= WhereSQL::GetTMSingleWhere("web_site");
        return $outWhere;
    }

    //自动完成
    public function AutoComplete()
    {
        $name = Utility::GetForm("q", $_GET);
        $objUserBLL = new UserBLL();
        $sWhere = " and agent_id=".$this->getAgentId()." and finance_uid=".$this->getFinanceUid().
            "(e_name like '%$name%' or user_name like '%$name%') and is_lock=0";
        
        $queryRST = $objUserBLL->select("user_id,user_name,e_name",$sWhere,"user_name");
        echo json_encode(array('value' => $queryRST));
    }

}

?>