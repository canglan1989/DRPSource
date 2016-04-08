<?php 
/**
 * @functional 预计到帐
 * @date       2012-12-25
 * @author     wzx
 * @copyright  盘石
 */
require_once __DIR__ . '/../../Config/PublicEnum.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/ExportExcel.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupBLL.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeHistoryBLL.php';
require_once __DIR__ . '/../../Class/BLL/ExpectChargeBLL.php';
class ExpectMoneyAction extends ActionBase
{
    public function __construct()
    {
    }
    
    public function Index()
    {
        
    }
    
    /**
     * @functional 代理商预计到帐列表
     * @author wzx
     */
    public function ExpectMoneyList()
    {        
        $this->PageRightValidate("ExpectMoneyList", RightValue::view);
        
        $objAccountGroupBLL = new AccountGroupBLL();
        $arrayData = $objAccountGroupBLL->select("account_no, account_name","account_no in('10','11','12')","account_no");            
        $this->smarty->assign('arrayData', $arrayData);
        
        $strIntentionLevelJson = "[{'value':'A','key':'A'},{'value':'B+','key':'B+'},{'value':'B-','key':'B-'},
        {'value':'C','key':'C'},{'value':'D','key':'D'},{'value':'E','key':'E'}]";
        $this->smarty->assign('strIntentionLevelJson', $strIntentionLevelJson);
        $this->smarty->assign('ExpectMoneyListBody', "/?d=Agent&c=ExpectMoney&a=ExpectMoneyListBody");
        $this->smarty->display('Agent/ExpectMoneyList.tpl');
    }
    
    /**
     * @functional 代理商预计到帐列表数据内容
     * @author wzx
     */
    public function ExpectMoneyListBody()
    {
        $sWhere = "";
        if(!$this->HaveRight("ExpectMoneyList", RightValue::viewCompany,true))
        {
            $this->ExitWhenNoRight("ExpectMoneyList", RightValue::view);
            $sWhere = " and am_agent_source.channel_uid=".$this->getUserId();
        }
        
        $cbExpectMoneyType = Utility::GetFormInt("cbExpectMoneyType", $_GET,-100);
        if($cbExpectMoneyType >= 0)
            $sWhere .= " and am_expect_charge_history.expect_type = ".$cbExpectMoneyType;
            
        $cbIntentionLevel = Utility::GetForm("cbIntentionLevel", $_GET);
        if ($cbIntentionLevel != "")
        {
            $sWhere .= Utility::SQLMultiSelect('am_expect_charge_history.inten_level',$cbIntentionLevel,false);
        }    
        
        $cbChannelUserGroup = Utility::GetFormInt("cbChannelUserGroup", $_GET);
        if($cbChannelUserGroup > 0)
            $sWhere .= " and sys_account_group.account_no like '".$cbChannelUserGroup."%'";
            
        $tbxChannelUserName = Utility::GetForm("tbxChannelUserName", $_GET);
        if($tbxChannelUserName != "")
            $sWhere .= " and am_agent_source.agent_channel_user_name like '%{$tbxChannelUserName}%'";
            
        $tbxExpectMoneySDate = Utility::GetForm("tbxExpectMoneySDate", $_GET);
        if ($tbxExpectMoneySDate != "" && Utility::isShortTime($tbxExpectMoneySDate))
            $sWhere .= " and date(am_expect_charge_history.expect_time) >= '" . $tbxExpectMoneySDate . "'";
            
        $tbxExpectMoneyEDate = Utility::GetForm("tbxExpectMoneyEDate", $_GET);        
        if ($tbxExpectMoneyEDate != "" && Utility::isShortTime($tbxExpectMoneyEDate))
            $sWhere .= " and date(am_expect_charge_history.expect_time) < " . Utility::SQLEndDate($tbxExpectMoneyEDate);
            
        $tbxCreateSDate = Utility::GetForm("tbxCreateSDate", $_GET);
        if ($tbxCreateSDate != "" && Utility::isShortTime($tbxCreateSDate))
            $sWhere .= " and am_expect_charge_history.create_time >= '" . $tbxCreateSDate . "'";
            
        $tbxCreateEDate = Utility::GetForm("tbxCreateEDate", $_GET);        
        if ($tbxCreateEDate != "" && Utility::isShortTime($tbxCreateEDate))
            $sWhere .= " and am_expect_charge_history.create_time < " . Utility::SQLEndDate($tbxCreateEDate);
            
        $tbxAgentNo = Utility::GetForm("tbxAgentNo", $_GET);
        if ($tbxAgentNo != "")
            $sWhere .= " and `am_agent_source`.agent_no like '%" . $tbxAgentNo . "%'";

        $tbxAgentName = Utility::GetForm("tbxAgentName", $_GET);
        if ($tbxAgentName != "")
            $sWhere .= " and `am_agent_source`.agent_name like '%" . $tbxAgentName . "%'";

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);
        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];

        $bExportExcel = Utility::GetFormInt('iExportExcel',$_GET)==1?true:false;
        
        $objExpectChargeHistoryBLL = new ExpectChargeHistoryBLL();
        $arrPageList = $this->getPageList($objExpectChargeHistoryBLL, "*", $sWhere, "", $iPageSize,$bExportExcel);
        $arrayData = &$arrPageList['list'];
        foreach($arrayData as $key => $value)
        {
            $arrayData[$key]["expect_type_text"] = "";
            if($value["expect_type"] == 1)
                $arrayData[$key]["expect_type_text"] = "承诺";
            else if($value["expect_type"] == 2)
                $arrayData[$key]["expect_type_text"] = "备份";
        }
        
        if($bExportExcel == false)
        {
            $this->smarty->assign('arrayData', $arrPageList['list']);
            $this->smarty->display('Agent/ExpectMoneyListBody.tpl');
            echo("<script>pageList.totalPage=" . $arrPageList['totalPage'] . ";pageList.recordCount=" . $arrPageList['recordCount'] . ";</script>");
        }
        else
        {
            
        }
    }
     public function expectMoneyInfo()
    {
        $agent_id =Utility::GetFormInt('agent_id', $_GET);
        $objExpectChargeBLL = new ExpectChargeBLL();
        $arrInfo =$objExpectChargeBLL->getExpectMoneyByAgentId($agent_id);
        $this->displayPage('Agent/ExpectMoneyInfo.tpl', $arrInfo[0]);
    }
    
}
?>