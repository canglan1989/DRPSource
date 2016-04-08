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
require_once __DIR__ . '/../../Class/BLL/TMTrustworthyBLL.php';
require_once __DIR__ . '/../../Action/TM/WhereSQL.php';

class TrustworthyAction extends ActionBase
{

    public function __construct()
    {
        
    }

    /**
     * 前台 
     * */
    //显示前台列表
    public function ShowListFront()
    {
        $this->PageRightValidate("Trustworthy",RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'Trustworthy', 'ShowListFrontBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/Trustworthy/ListFront.tpl");
    }

    public function ShowListFrontBody()
    {
        $this->PageRightValidate("Trustworthy",RightValue::view);
        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $where = self::GetWhere();
        $agent_id = self::getAgentId();
        $user_no = self::getUserNo();
        $where .= WhereSQL::GetMyCustomerOrdersWhere(array("agent_id" => $agent_id,"finance_uid" => $this->getFinanceUid(),
            "user_no" => $user_no));
        $arrPageList = $tmTrustworthyBLL->GetListData($where, self::GetOutWhere());
        self::showPageSmarty($arrPageList, 'TM/Trustworthy/ListFrontBody.tpl');
    }

    //获取页面搜索条件并生成where语句
    public function GetWhere()
    {
        $where = "";
        $where.=WhereSQL::GetTMSingleWhere("order_no");
        $where.=WhereSQL::GetTMSingleWhere("agent_name");
        $where.=WhereSQL::GetTMSingleWhere("cus_name");
        $where.=WhereSQL::GetTMSingleWhere("ord_type");
        $where.=WhereSQL::GetTMSingleWhere("pro_type2");
        $where.=WhereSQL::GetTMSingleWhere("pro_type1");
        $where.=WhereSQL::GetTMSingleWhere("trust_task_state");
        $where.=WhereSQL::GetTMSingleWhere("trust_verify");
        $where.=WhereSQL::GetTMSingleWhere("post_name");
        $where.=WhereSQL::GetTMSingleWhere("post_time_begin");
        $where.=WhereSQL::GetTMSingleWhere("post_time_end");
        $where.=WhereSQL::GetTMSingleWhere("trust_install_name");
        $where.=WhereSQL::GetTMSingleWhere("order_time_begin");
        $where.=WhereSQL::GetTMSingleWhere("order_time_end");
        $where.=WhereSQL::GetTMSingleWhere("order_sdate_begin");
        $where.=WhereSQL::GetTMSingleWhere("order_sdate_end");
        $where.=WhereSQL::GetTMSingleWhere("order_edate_begin");
        $where.=WhereSQL::GetTMSingleWhere("order_edate_end");
        $strCode = Utility::GetForm('tCode', $_GET);
        if($strCode != "")
            $where .= " and `code` like '%$strCode%'";
        return $where;
        
    }

    //获取页面外搜索条件并生成outWhere语句
    public function GetOutWhere()
    {
        $outWhere = "";
        $outWhere.=WhereSQL::GetTMSingleWhere("web_site");
        return $outWhere;
    }

    //获取认证代码
    public function getComfirmCode()
    {
        $order_id = Utility::GetFormInt("id", $_GET);
        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $code = $tmTrustworthyBLL->getCode($order_id);
        if ($code)
        {
            $code = "<a id='___szfw_logo___' href='https://search.szfw.org/cert/l/{$code}' target='_blank'><img src='https://search.szfw.org/cert.png?l={$code}'></a><script type='text/javascript'>(function(){document.getElementById('___szfw_logo___').oncontextmenu = function(){return false;}})();</script>";
            exit(json_encode(array("success" => true, "msg" => $code)));
        }
        else
            exit(json_encode(array("success" => false, "msg" => "未添加认证代码")));
    }

    //获取认证代码
    public function ViewComfirmCode()
    {
        $order_id = Utility::GetForm("id", $_GET);
        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $code = $tmTrustworthyBLL->getCode($order_id);
        if ($code)
        {
            $code = "<a id='___szfw_logo___' href='https://search.szfw.org/cert/l/{$code}' target='_blank'><img src='https://search.szfw.org/cert.png?l={$code}'></a><script type='text/javascript'>(function(){document.getElementById('___szfw_logo___').oncontextmenu = function(){return false;}})();</script>";

            $this->smarty->assign('code', $code);
            $this->displayPage("TM/Trustworthy/ViewComfirmCode.tpl");
        }
        else
            exit("未添加认证代码");
            
    }
    //设置任务标记
    public function setTaskFlag()
    {
        $order_id = Utility::GetForm("id", $_POST);
//        $taskTag = Utility::GetForm("taskTag", $_POST);
        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $rst = $tmTrustworthyBLL->setInstalUid($order_id, $this->getUserId());
        if ($rst)
            echo json_encode(array("success" => true, "msg" => "设置成功"));
        else
            echo json_encode(array("success" => false, "msg" => "设置出错"));
    }

    //显示任务标记
    public function ShowTaskMarkFront()
    {
        
    }

    //任务标记
    public function TaskMarkFront()
    {
        
    }

    //显示产品订单状态
    public function getOrderStatus()
    {
        $order_id = Utility::GetForm("id", $_GET);
        
        include_once __DIR__ . '/../../Class/BLL/AgentAccountDetailBLL.php';
        $objAgentAccountDetail = new AgentAccountDetailBLL();
        $arrData = $objAgentAccountDetail->getOrderBackInfo($order_id);
        $this->smarty->assign("BackInfo",$arrData);
        $strBackHtml = $this->smarty->fetch('TM/BackOrderInfo.tpl');
        
        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $rst = $tmTrustworthyBLL->GetOrderListData($order_id);
        $this->displayPage("TM/Trustworthy/WebMakeProcess.tpl", array('data' => $rst,'backhtml'=>$strBackHtml));
    }

    /**
     * 后台
     * */
    //显示后台列表
    public function ShowListBack()
    {
        $this->PageRightValidate("Trustworthy",RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'Trustworthy', 'ShowListBackBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/Trustworthy/ListBack.tpl");
    }

    public function ShowListBackBody()
    {
        $this->ExitWhenNoRight("Trustworthy",RightValue::view);
        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $arrPageList = $tmTrustworthyBLL->GetListData(self::GetWhere(), self::GetOutWhere());
        self::showPageSmarty($arrPageList, 'TM/Trustworthy/ListBackBody.tpl');
    }

    //添加诚信代码卡片
    public function TrustCodeCard()
    {
        $order_id = Utility::GetForm("oid", $_GET);
        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $rst = $tmTrustworthyBLL->GetOrderInfo_AddCode($order_id);
        $code = $tmTrustworthyBLL->getCode($order_id,false);
        $this->smarty->assign('code', $code);
        $this->displayPage("TM/Trustworthy/CodeCard.tpl", array("data" => $rst, "order_id" => $order_id));
    }

    //保存诚信代码
    public function SetTrustCode()
    {
        $order_id = Utility::GetFormInt("order_id", $_POST);
        if($order_id <= 0)
            exit(json_encode(array("success" => false, "msg" => "订单ID不能为空")));
            
        $code = Utility::GetForm("code", $_POST);
        if($code == "")
            exit(json_encode(array("success" => false, "msg" => "诚信代码不能为空")));
            
        $effect_sdate = Utility::GetForm("create_timeS", $_POST);
        $effect_edate = Utility::GetForm("create_timeE", $_POST);
        
        $uid = $this->getUserId();

        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $rst = $tmTrustworthyBLL->AddCode($order_id, $code, $uid, $effect_sdate, $effect_edate);
        if ($rst)
            exit(json_encode(array("success" => true, "msg" => "设置成功")));
        else
            exit(json_encode(array("success" => false, "msg" => "设置出错")));
    }

    //校验诚信代码
    public function checkTrustCode()
    {
        $order_id = Utility::GetForm("id", $_POST);
        $verify_uid = $this->getUserId();

        $tmTrustworthyBLL = new TMTrustworthyBLL();
        $rst = $tmTrustworthyBLL->CheckCode($order_id, $verify_uid);
        if ($rst)
            echo json_encode(array("success" => true, "msg" => "校验成功"));
        else
            echo json_encode(array("success" => false, "msg" => "校验出错"));
    }

}

?>