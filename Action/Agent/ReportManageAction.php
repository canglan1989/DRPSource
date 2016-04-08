<?php

/**
 * 报表管理
 *
 * @author XXF
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/ExportExcel.php';
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentInfo.php';
require_once __DIR__ . '/../../Class/BLL/OrderRechargeBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';

class ReportManageAction extends ActionBase {
    //put your code here
    private $objAgentBLL = '';
    private $objOrderRechargeBLL = '';
    private $objProductTypeBLL = '';
    
    public function __construct() {
        $this->objAgentBLL = new AgentBLL();
        $this->objOrderRechargeBLL = new OrderRechargeBLL();
        $this->objProductTypeBLL = new ProductTypeBLL();
    }
    
    public function AgentAdhaiList(){
        $this->PageRightValidate("AgentAdhaiReport", RightValue::view);
        
        $arrWhere = $this->Where_AgentAdhaiBody();
        $arrAdhaiReportList = $this->objAgentBLL->getAgentAdhaiReport($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strNow'],true);
        $TodayNew = 0;
        $MonthNew = 0;
        $TodayOld = 0;
        $MonthOld = 0;
        $TodayNewMoney = 0;
        $MonthNewMoney = 0;
        $TodayOldMoney = 0;
        $MonthOldMoney = 0;
        if ($arrAdhaiReportList['list']) {
            foreach ($arrAdhaiReportList['list'] as $value) {
                $TodayNew +=$value["today_new_count"];
                $MonthNew+=$value["month_new_count"];
                $TodayOld+=$value["today_old_count"];
                $MonthOld+=$value["month_old_count"];
                $TodayNewMoney +=$value['today_new_money'];
                $MonthNewMoney +=$value['month_new_money'];
                $TodayOldMoney +=$value['today_old_money'];
                $MonthOldMoney +=$value['month_old_money'];
            }
        }
        
        $this->smarty->assign('TodayNew',  $TodayNew);
        $this->smarty->assign('MonthNew',  $MonthNew);
        $this->smarty->assign('TodayOld',  $TodayOld);
        $this->smarty->assign('MonthOld',  $MonthOld);
        $this->smarty->assign('TodayNewMoney',  $TodayNewMoney);
        $this->smarty->assign('MonthNewMoney',  $MonthNewMoney);
        $this->smarty->assign('TodayOldMoney',  $TodayOldMoney);
        $this->smarty->assign('MonthOldMoney',  $MonthOldMoney);
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("Agent", "ReportManage", "AgentAdhaiBody"));
        $this->displayPage('Agent/ReportManage/AgentAdhaiList.tpl');
    }
    
    public function AgentAdhaiBody(){
        $this->ExitWhenNoRight("AgentAdhaiReport", RightValue::view);
        $arrWhere = $this->Where_AgentAdhaiBody();
        $arrAdhaiReportList = $this->objAgentBLL->getAgentAdhaiReport($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strNow']);
        $this->smarty->assign("BeginTime",$arrWhere['BeginTime']);
        $this->smarty->assign("EndTime",$arrWhere['EndTime']);
        $this->showPageSmarty($arrAdhaiReportList, 'Agent/ReportManage/AgentAdhaiBody.tpl');
    }
    
    public function AdHaiRechargeReportList(){
        $iAgentID = Utility::GetFormInt("agentid", $_GET);
        $iOperType = Utility::GetFormInt("opertype", $_GET);//1今日新开2本月新开3今日续费4本月续签
        
        switch ($iOperType){
            case 1:{
                $strBeginTime = date('m-d');
                $strEndTime = date('m-d');
                $iOperType = 1;
            }break;
            case 2:{
                $strBeginTime = date('m').'-01';
                $strEndTime = date('m-t');
                $iOperType = 1;
            }break;
            case 3:{
                $strBeginTime = date('m-d');
                $strEndTime = date('m-d');
                $iOperType = 2;
            }break;
            case 4:{
                $strBeginTime = date('m').'-01';
                $strEndTime = date('m-t');
                $iOperType = 2;
            }break;
            default :{
                $strCreateTime = substr(Utility::Now(), 0,10);
                $iOperType = 1;
            }break;
        }
        
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("Agent", "ReportManage", "AdHaiRechargeReportBody"));
        $this->smarty->assign("AgentID",$iAgentID);
        $this->smarty->assign("BeginTime",$strBeginTime);
        $this->smarty->assign("EndTime",$strEndTime);
        $this->smarty->assign("oprtype",$iOperType);
        $this->displayPage('Agent/ReportManage/AdHaiRechargeReportList.tpl');
    }
    
    public function AdHaiRechargeReportBody(){
        $iAgentID = Utility::GetFormInt("agentid", $_GET);
        $strBeginTime = Utility::GetForm("create_timeS", $_GET);
        $strEndTime = Utility::GetForm("create_timeE", $_GET);
        $iOper = Utility::GetFormInt("opertype", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        
        if(!empty ($strBeginTime)){
            $strBTime = date('Y')."-{$strBeginTime} 00:00:00";
        }else{
            $strBTime = date('Y-m').'-01 00:00:00';
        }
        if(!empty ($strEndTime)){
            $strETime = date('Y')."-{$strEndTime} 23:59:59";
        }else{
            $strETime = date('Y-m-t').' 23:59:59';
        }
        
        $strWhere = "and om_order_recharge.create_time >= '{$strBTime}' and om_order_recharge.create_time<='{$strETime}' and om_order_recharge.agent_id = {$iAgentID} and om_order_recharge.is_first_charge = {$iOper}";
        
        $arrRechargeList = $this->objOrderRechargeBLL->getAdHaiRechargeReportList($strWhere, $strOrder);
        $this->showPageSmarty($arrRechargeList, 'Agent/ReportManage/AdHaiRechargeReportBody.tpl');
        
    }
    
    public function AgentAdhaiOldReportList(){
        $this->PageRightValidate("AgentAdhaiOldReport", RightValue::view);
        
        $arrWhere = $this->Where_AgentAdhaiOldReportBody();
        $arrAdhaiReportList = $this->objAgentBLL->getAgentAdhaiOldReport($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],$arrWhere['BeginTime'],$arrWhere['EndTime'],true);
        $NewCount = 0;
        $NewMoney = 0;
        $OldCount = 0;
        $OldMoney = 0;
        if ($arrAdhaiReportList['list']) {
            foreach ($arrAdhaiReportList['list'] as $value) {
                $NewCount +=$value["month_new_count"];
                $OldCount +=$value["month_old_count"];
                $NewMoney +=$value['month_new_money'];
                $OldMoney +=$value['month_old_money'];
            }
        }
        
        $this->smarty->assign('NewCount',  $NewCount);
        $this->smarty->assign('OldCount',  $OldCount);
        $this->smarty->assign('NewMoney',  $NewMoney);
        $this->smarty->assign('OldMoney',  $OldMoney);
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("Agent", "ReportManage", "AgentAdhaiOldReportBody"));
        $this->displayPage('Agent/ReportManage/AgentAdhaiOldReportList.tpl');
    }
    
    public function AgentAdhaiOldReportBody(){
        $this->ExitWhenNoRight("AgentAdhaiOldReport", RightValue::view);
        $arrWhere = $this->Where_AgentAdhaiOldReportBody();
        $arrAdhaiReportList = $this->objAgentBLL->getAgentAdhaiOldReport($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],$arrWhere['BeginTime'],$arrWhere['EndTime']);
        $this->showPageSmarty($arrAdhaiReportList, 'Agent/ReportManage/AgentAdhaiOldReportBody.tpl');
    }
    
    public function ChannelAdhaiReportList(){
        $this->PageRightValidate("ChannelAdhaiReport", RightValue::view);
        
        $arrWhere = $this->Where_ChannelAdhaiReportBody();
        $arrChannelList = $this->objOrderRechargeBLL->getChannelAdhaiReportList($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],date('Y-m-01'),date('Y-m-t'),true);
        $NewCount = 0;
        $NewMoney = 0;
        $NewPreMoney = 0;
        $NewCashMoney = 0;
        if($arrChannelList['list']){
            foreach($arrChannelList['list'] as $value){
                $NewCount += $value['new_count'];
                $NewMoney += $value['new_money'];
                $NewPreMoney += $value['new_pre_money'];
                $NewCashMoney += $value['new_cash_money'];
            }
        }
        
        $this->smarty->assign("COUNT",  $NewCount);
        $this->smarty->assign("NewMoney",  $NewMoney);
        $this->smarty->assign("NewPreMoney",  $NewPreMoney);
        $this->smarty->assign("NewCashMoney",  $NewCashMoney);
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("Agent", "ReportManage", "ChannelAdhaiReportBody"));
        $this->displayPage('Agent/ReportManage/ChannelAdhaiReportList.tpl');
    }
    
    public function ChannelAdhaiReportBody(){
        $this->ExitWhenNoRight("ChannelAdhaiReport", RightValue::view);
        $arrWhere = $this->Where_ChannelAdhaiReportBody();
        $arrChannelList = $this->objOrderRechargeBLL->getChannelAdhaiReportList($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],date('Y-m-01'),date('Y-m-t'));
        $iAdHaiID = $this->objProductTypeBLL->GetUnitProductTypeID();
        $this->smarty->assign("AdHaiID",$iAdHaiID);
        $this->showPageSmarty($arrChannelList, 'Agent/ReportManage/ChannelAdhaiReportBody.tpl');
    }
    
    public function ChannelAdhaiOldReportList(){
        $this->PageRightValidate("ChannelAdhaiOldReport", RightValue::view);
        
        $arrWhere = $this->Where_ChannelAdhaiOldReportBody();
        $arrChannelList = $this->objOrderRechargeBLL->getChannelAdhaiReportList($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],$arrWhere['BeginTime'],$arrWhere['EndTime'],true);
        $OldCount = 0;
        $NewMoney = 0;
        $NewPreMoney = 0;
        $NewCashMoney = 0;
        if($arrChannelList['list']){
            foreach($arrChannelList['list'] as $value){
                $OldCount += $value['new_count'];
                $NewMoney += $value['new_money'];
                $NewPreMoney += $value['new_pre_money'];
                $NewCashMoney += $value['new_cash_money'];
            }
        }
        
        $this->smarty->assign("COUNT",  $OldCount);
        $this->smarty->assign("NewMoney",  $NewMoney);
        $this->smarty->assign("NewPreMoney",  $NewPreMoney);
        $this->smarty->assign("NewCashMoney",  $NewCashMoney);
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("Agent", "ReportManage", "ChannelAdhaiOldReportBody"));
        $this->displayPage('Agent/ReportManage/ChannelAdhaiOldReportList.tpl');
    }
    
    public function ChannelAdhaiOldReportBody(){
        $this->ExitWhenNoRight("ChannelAdhaiOldReport", RightValue::view);
        $arrWhere = $this->Where_ChannelAdhaiOldReportBody();
        $arrChannelList = $this->objOrderRechargeBLL->getChannelAdhaiReportList($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],$arrWhere['BeginTime'],$arrWhere['EndTime']);
        $iAdHaiID = $this->objProductTypeBLL->GetUnitProductTypeID();
        $this->smarty->assign("AdHaiID",$iAdHaiID);
        $this->showPageSmarty($arrChannelList, 'Agent/ReportManage/ChannelAdhaiOldReportBody.tpl');
    }
    
    public function Where_AgentAdhaiBody(){
        $strAgentName = Utility::GetForm("agent_name", $_GET);
        $strChannelName = Utility::GetForm("channel_name", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        
        $iAdHaiID = $this->objProductTypeBLL->GetUnitProductTypeID();
        $strWhere = " and v_am_agent_pact_product.product_id = {$iAdHaiID} ";
        if(!empty ($strAgentName)){
            $strWhere .= " and am_agent.agent_name like '%{$strAgentName}%' ";
        }
        if(!empty ($strChannelName)){
            $strWhere .= " and (sys_user.e_name like '%{$strChannelName}%' or sys_user.user_name like '%{$strChannelName}%' ) ";
        }
        $strNow = Utility::Now();
        $strBeginTime = date('Y-m-01',  strtotime($strNow));
        $strEndTime = date('Y-m-t',  strtotime($strNow));
        return array(
            'strWhere'=>$strWhere,
            'strOrder'=>$strOrder,
            'strNow'=>$strNow,
            'BeginTime'=>$strBeginTime,
            'EndTime'=>$strEndTime
        );
    }
    
    public function Where_AgentAdhaiOldReportBody(){
        $strAgentName = Utility::GetForm("agent_name", $_GET);
        $strChannelName = Utility::GetForm("channel_name", $_GET);
        $strBeginTime = Utility::GetForm("create_timeS", $_GET);
        $strEndTime = Utility::GetForm("create_timeE", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        
        $iAdHaiID = $this->objProductTypeBLL->GetUnitProductTypeID();
        $strWhere = " and v_am_agent_pact_product.product_id = {$iAdHaiID} ";
        $strSubWhere = '';
        if(!empty ($strAgentName)){
            $strWhere .= " and am_agent.agent_name like '%{$strAgentName}%' ";
        }
        if(!empty ($strChannelName)){
            $strWhere .= " and (sys_user.e_name like '%{$strChannelName}%' or sys_user.user_name like '%{$strChannelName}%' ) ";
        }
        if(!empty ($strBeginTime)){
            $strBeginTime = "{$strBeginTime}";
            $strSubWhere .= " and create_time >= '{$strBeginTime}-01 00:00:00' ";
        }else{
            $strBeginTime = '2011-01-01';
        }
        
        if(!empty ($strEndTime)){
            $strEndTime = date('Y-m-t',  strtotime($strEndTime));
            $strSubWhere .= " and create_time < ".Utility::SQLEndDate($strEndTime)." ";
        }else{
            $strEndTime = date('Y-m-d');
        }
        
        return array(
            'strWhere'=>$strWhere,
            'strOrder'=>$strOrder,
            'strSubWhere'=>$strSubWhere,
            'BeginTime'=>$strBeginTime,
            'EndTime'=>$strEndTime
        );
    }
    
    public function Where_ChannelAdhaiReportBody(){
        $strChannelName = Utility::GetForm("channel_name", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        
        $strWhere = '';
        if(!empty ($strChannelName)){
            $strWhere .= " and (sys_user.e_name like '%{$strChannelName}%' or sys_user.user_name like '%{$strChannelName}%' )";
        }
        $strTime = substr(Utility::Now(), 0,7);
        $strSubWhere = " and received_date >= '{$strTime}' ";
        return array(
            'strWhere'=>$strWhere,
            'strOrder'=>$strOrder,
            'strSubWhere'=>$strSubWhere
        );
    }
    
    public function Where_ChannelAdhaiOldReportBody(){
        $strChannelName = Utility::GetForm("channel_name", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        $strBeginTime = Utility::GetForm("create_timeS", $_GET);
        $strEndTime = Utility::GetForm("create_timeE", $_GET);
        
        $strWhere = '';
        $strSubWhere = "";
        if(!empty ($strChannelName)){
            $strWhere .= " and (sys_user.e_name like '%{$strChannelName}%' or sys_user.user_name like '%{$strChannelName}%' )";
        }
        if(!empty ($strBeginTime)){
            $strBeginTime .="-01"; 
            $strSubWhere .= " and received_date >= '{$strBeginTime}' ";
        }else{
            $strBeginTime = "2011-01-01";
        }
        
        if(!empty ($strEndTime)){
            $strEndTime .= date("-t",  strtotime($strEndTime));
            $strSubWhere .= " and received_date <= '{$strEndTime}' ";
        }else{
            $strEndTime = date('Y-m-t');
        }
        
        return array(
            'strWhere'=>$strWhere,
            'strOrder'=>$strOrder,
            'strSubWhere'=>$strSubWhere,
            'BeginTime'=>$strBeginTime,
            'EndTime'=>$strEndTime
        );
    }
    
    public function DownLoad_AgentAdhaiList(){
        $arrWhere = $this->Where_AgentAdhaiBody();
        $arrAdhaiReportList = $this->objAgentBLL->getAgentAdhaiReport($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strNow'],true);
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("区域", "account_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("战区经理", "user_info"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("今日新开单量", "today_new_count"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("今日新开金额", "today_new_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开单量", "month_new_count"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开金额", "month_new_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("今日续费单量", "today_old_count"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("今日续费金额", "today_old_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计续费单量", "month_old_count"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计续费金额", "month_old_money"));
        $objDataToExcel->Init("代理商当前网盟业绩", $arrAdhaiReportList['list'], null, $objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
    public function DownLoad_AgentAdhaiOldReportBody(){
        $arrWhere = $this->Where_AgentAdhaiOldReportBody();
        $arrAdhaiReportList = $this->objAgentBLL->getAgentAdhaiOldReport($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],$arrWhere['BeginTime'],$arrWhere['EndTime'],true);
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("区域", "account_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("战区经理", "user_info"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("起始时间", "begin_time"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("结束时间", "end_time"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("累计新开单量", "month_new_count"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("累计新开金额", "month_new_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("累计续费单量", "month_old_count"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("累计续费金额", "month_old_money"));
        $objDataToExcel->Init("代理商历史网盟业绩", $arrAdhaiReportList['list'], null, $objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
    public function DownLoad_ChannelAdhaiReportBody(){
        $arrWhere = $this->Where_ChannelAdhaiReportBody();
        $arrChannelList = $this->objOrderRechargeBLL->getChannelAdhaiReportList($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],date('Y-m-01'),date('Y-m-t'),true);
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("区域", "account_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("战区经理", "user_info"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开单量", "new_count"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开总金额", "new_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开总保证金", "new_cash_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开总预存款", "new_pre_money"));
        $objDataToExcel->Init("渠道经理当前网盟业绩", $arrChannelList['list'], null, $objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
    public function DownLoad_ChannelAdhaiOldReportBody(){
        $arrWhere = $this->Where_ChannelAdhaiOldReportBody();
        $arrChannelList = $this->objOrderRechargeBLL->getChannelAdhaiReportList($arrWhere['strWhere'], $arrWhere['strOrder'], $arrWhere['strSubWhere'],$arrWhere['BeginTime'],$arrWhere['EndTime'],true);
        $objDataToExcel = new DataToExcel();
        $objExcelBottomColumns = new ExcelBottomColumns();
        $objExcelBottomColumns->Add(new ExcelBottomColumn("区域", "account_name"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("战区经理", "user_info"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("起始时间", "begin_time"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("结束时间", "end_time"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开单量", "new_count"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开总金额", "new_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开总保证金", "new_cash_money"));
        $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计新开总预存款", "new_pre_money"));
        $objDataToExcel->Init("渠道经理历史网盟业绩", $arrChannelList['list'], null, $objExcelBottomColumns);
        $objDataToExcel->Export();
    }
    
    public function MoneyDetail(){
        $iAgentID = Utility::GetFormInt("agentid", $_GET);
        $strBeginTime = Utility::GetForm("begintime", $_GET);
        $strEndTime = Utility::GetForm("endtime", $_GET);
        $iType = Utility::GetFormInt("type", $_GET);
        
        if(empty ($iAgentID))
            $this->Msg ('代理商信息获取失败');
        if(empty ($strBeginTime))
            $this->Msg ("开始时间获取失败");
        if(empty ($strEndTime))
            $this->Msg ("结束时间获取失败");
        if(empty ($iType))
            $this->Msg ("充值类型获取失败");
        
        $arrTotalList = $this->objOrderRechargeBLL->getTotalMoneyForAgent($iAgentID, $strBeginTime, $strEndTime, $iType);
        $this->smarty->assign("PreMoney",  empty ($arrTotalList['total_pre_money'])?'0.00':$arrTotalList['total_pre_money']);
        $this->smarty->assign("RebateMoney",  empty ($arrTotalList['total_rebate_money'])?'0.00':$arrTotalList['total_rebate_money']);
        $this->smarty->assign("RechargeMoney",  empty ($arrTotalList['total_recharge_money'])?'0.00':$arrTotalList['total_recharge_money']);
        echo $this->smarty->fetch("Agent/ReportManage/MoneyDetail.tpl");
    }
    
    private function Msg($msg,$issuccess = false,$url=''){
        $Tip['success'] = $issuccess;
        $Tip['msg'] = $msg;
        if(!empty ($url)){
            $Tip['url'] = $url;
        }
        exit(json_encode($Tip));
    }
    
    
    /**
     * 渠道KPI导出
    */
    public function AgentKpiExport()
    {   
        $iExportExcel = Utility::GetFormInt("iExportExcel", $_GET);
        if($iExportExcel == 0)
        {
            $this->PageRightValidate("AgentKpiExport",Rightvalue::view);        
            $this->smarty->display('Agent/ReportManage/AgentKpiExport.tpl');
        }
        else
        {            
            $this->ExitWhenNoRight("AgentKpiExport",Rightvalue::view); 
            $arrayData = $this->objAgentBLL->getRptKpiBase();
            $objDataToExcel = new DataToExcel();
            $objExcelBottomColumns = new ExcelBottomColumns();
            $objExcelBottomColumns->Add(new ExcelBottomColumn("区域", "area_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("战区经理", "manager_name"));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("代理商名称", "agent_name",ExcelDataTypes::String,35));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("本月新开单量", "this_month_new_count",ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("新开转款金额", "this_month_new_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("本月续费单量", "this_month_renewals_count",ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("续费转款金额", "this_month_renewals_money",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计转出金额", "this_month_charge",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("昨日余额", "yesterday_balance",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("2012年度充值总额", "this_year_income",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("2012年度消费总额", "this_year_cost",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("本月累计消费", "this_month_cost",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("本周累计消费", "this_week_cost",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("今日余额", "today_balance",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("昨日消费", "yesterday_cost",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("最后一次续费时间", "last_charge_date",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("最近一次充值后账户余额", "last_income_balance",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("最近一次充值后消费金额", "last_income_cost",ExcelDataTypes::Double));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("余额占比", "balance_rate",ExcelDataTypes::String,15));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("低于50%日期", "lower_50_date",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("续费日期", "lower_50_income_date",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("老化天数", "old_day",ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("最后续费到今天老化天数", "last_income_old_day",ExcelDataTypes::Int));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("最后一次拜访时间", "last_visit_date",ExcelDataTypes::Date));
            $objExcelBottomColumns->Add(new ExcelBottomColumn("拜访次数", "visit_count",ExcelDataTypes::Int));
            
            $objDataToExcel->Init("渠道KPI导出", $arrayData, null, $objExcelBottomColumns);
            $objDataToExcel->Export();
        }
    }
    
    
}

?>
