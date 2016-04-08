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
require_once __DIR__ . '/../../Class/BLL/TMEMailBLL.php';
require_once __DIR__ . '/../../Class/BLL/OrderWebsiteBLL.php';
require_once __DIR__ . '/../../Action/TM/WhereSQL.php';


class EMailAction extends ActionBase
{

    private $objOrderWebsiteBLL = "";

    public function __construct()
    {
        $this->objOrderWebsiteBLL = new OrderWebsiteBLL();
    }

    /**
     * 前台
     * */
    //显示前台列表
    public function ShowListFront()
    {
        $this->PageRightValidate("EMail",RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'EMail', 'ShowListFrontBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/EMail/ListFront.tpl");
    }

    public function ShowListFrontBody()
    {
        $tmEMailBLL = new TMEMailBLL();
        $where = self::GetWhere();
        $agent_id = self::getAgentId();
        $user_no = self::getUserNo();
        $where .= WhereSQL::GetMyCustomerOrdersWhere(array("agent_id" => $agent_id,"finance_uid" => $this->getFinanceUid(),
            "user_no" => $user_no));
        $arrPageList = $tmEMailBLL->GetListData($where, self::GetOutWhere());
        self::showPageSmarty($arrPageList, 'TM/EMail/ListFrontBody.tpl');
    }

    //显示前台信息状态
    public function ShowInfoState()
    {
        $order_id = Utility::GetForm("id", $_GET);
        $rst = $this->objOrderWebsiteBLL->getInfoStatus($order_id);
        //        var_dump($rst);
        $this->smarty->assign("data", $rst);
        $this->displayPage("TM/EMail/ShowInfoStatus.tpl");
    }

    //前台保存信息状态
    public function SaveInfoState()
    {
        $domains = Utility::GetForm("domain", $_POST);
        $ids = Utility::GetForm("origin", $_POST);
        $order_id = Utility::GetForm("id", $_POST);
        $user_id = self::getUserId();
        $tmEMailBLL = new TMEMailBLL();
        $rtn = $tmEMailBLL->ConfirmInfo($order_id, $user_id, $domains);
        //print_r($rtn);exit;        
        if ($rtn <> false && $rtn->DbId <> 0) {
            $tmEMailBLL->setInfoStatus($order_id, $ids, $domains);
            //print_r($rtn);exit;
            echo json_encode(array("success" => true, "msg" => "提交成功"));
        } else
            echo json_encode(array("success" => false, "msg" => "域名" . $rtn->msg . "已存在."));
    }

    //设置域名解析完成
    public function setAnalyFinsh()
    {
        $order_id = Utility::GetForm("id", $_POST);
        $tmEMailBLL = new TMEMailBLL();
        $rst = $tmEMailBLL->SetAnalyUid($order_id, $this->getUserId());
        if ($rst)
            echo json_encode(array("success" => true, "msg" => "设置成功"));
        else
            echo json_encode(array("success" => false, "msg" => "设置失败"));
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
        
        $tmEMailBLL = new TMEMailBLL();
        $rst = $tmEMailBLL->GetOrderFlow($order_id);
        $this->displayPage("TM/EMail/WebMakeProcess.tpl", array('data' => $rst,'backhtml'=>$strBackHtml));
    }

    /**
     * 后台
     * */
    //显示后台列表
    public function ShowListBack()
    {
        $this->PageRightValidate("EMail",RightValue::view);
        $strUrl = $this->getActionUrl('TM', 'EMail', 'ShowListBackBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/EMail/ListBack.tpl");
    }

    public function ShowListBackBody()
    {
        $this->PageRightValidate("EMail",RightValue::view);
        $tmEMailBLL = new TMEMailBLL();
        $where = self::GetWhere();
        $where .= "
 and mail.`info_confirm_uid`<>0
";
        $arrPageList = $tmEMailBLL->GetListData($where, self::GetOutWhere());
        self::showPageSmarty($arrPageList, 'TM/EMail/ListBackBody.tpl');
    }

    //获取页面搜索条件并生成where语句
    public function GetWhere()
    {
        $where = "";
        $where .= WhereSQL::GetTMSingleWhere("order_no");
        $where .= WhereSQL::GetTMSingleWhere("cus_name");
        $where .= WhereSQL::GetTMSingleWhere("pro_type2");
        $where .= WhereSQL::GetTMSingleWhere("post_name");
        $where .= WhereSQL::GetTMSingleWhere("mail_state");
        $where .= WhereSQL::GetTMSingleWhere("mail_analy_state");
        $where .= WhereSQL::GetTMSingleWhere("mail_info_state");
        $where .= WhereSQL::GetTMSingleWhere("order_time_begin");
        $where .= WhereSQL::GetTMSingleWhere("order_time_end");
        $where .= WhereSQL::GetTMSingleWhere("agent_name");
        $where .= WhereSQL::GetTMSingleWhere("ord_type");
        return $where;
    }

    //获取页面外搜索条件并生成outWhere语句
    public function GetOutWhere()
    {
        $outWhere = "";
        $outWhere .= WhereSQL::GetTMSingleWhere("web_site");
        return $outWhere;
    }

}

?>