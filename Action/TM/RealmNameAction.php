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
require_once __DIR__ . '/../../Action/TM/WhereSQL.php';
require_once __DIR__ . '/../../Class/BLL/TMRealNameBLL.php';

class RealmNameAction extends ActionBase
{

    public function __construct()
    {

    }

    /**
     * 前台
     * */
    //显示域名解析列表
    public function ShowRealmNameAnalyListFront()
    {
        $strUrl = $this->getActionUrl('TM', 'RealmName',
            'ShowRealmNameAnalyListFrontBody');
            
        $agent_id = self::getAgentId();
        $where = " and ord.agent_id=".$agent_id." and ord.finance_uid=".$this->getFinanceUid();
        $user_no = self::getUserNo();
        $tmRealNameBLL = new TMRealNameBLL();
        $headData = $tmRealNameBLL->GetRealmNameHeadData($where);
        if (count($headData) == 1) {
            $this->smarty->assign('headData', $headData[0]);
        }
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("TM/RealmName/RealmNameAnalyFront.tpl");
    }

    public function ShowRealmNameAnalyListFrontBody()
    {
        $agent_id = self::getAgentId();
        $where = " and ord.agent_id=".$agent_id." and ord.finance_uid=".$this->getFinanceUid();
        $where .= self::GetWhere();
        $user_no = self::getUserNo();
        $tmRealNameBLL = new TMRealNameBLL();
        $arrPageList = $tmRealNameBLL->GetListData($where, self::GetOutWhere());
        self::showPageSmarty($arrPageList, 'TM/RealmName/RealmNameAnalyFrontBody.tpl');
    }

    /**
     * 后台
     * */
    //显示后台域名管理列表
    public function ShowListBack()
    {
        die("adfa");
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

}

?>