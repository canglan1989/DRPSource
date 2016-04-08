<?php

require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/AgentcheckLogBLL.php';
require_once __DIR__ . '/../../Class/Model/AgentcheckLogInfo.php';
require_once __DIR__ . '/../../Class/Model/AgentContactInfo.php';
require_once __DIR__ . '/../../Class/BLL/AgentContactBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
class TaskAssignAction extends ActionBase
{

    private $objAgentcheckLogBLL = "";
    private $objAgentContactBLL = '';

    public function __construct()
    {
        $this->objAgentcheckLogBLL = new AgentcheckLogBLL();
        $this->objAgentContactBLL = new AgentContactBLL();
    }

    public function AutoComplete()
    {
//        var_dump($_REQUEST);
        $name = Utility::GetForm("q", $_GET);
        $queryRST = $this->objAgentcheckLogBLL->getAutoComplete($name);
        echo json_encode(array('value' => $queryRST));
    }
    public function AutoCompleteById()
    {
        $name = Utility::GetForm("q", $_GET);
        
        $objUserBLL = new UserBLL();
        $userInfo =  $objUserBLL->getAccountGroupById($this->getUserId());
        
        $accountNo=$userInfo[0]['account_no'];
        $queryRST = $this->objAgentcheckLogBLL->getAutoCompleteById($name,$accountNo);
       
        echo json_encode(array('value' => $queryRST));
    }
    public function TaskAssign()
    {
        $auditerName = Utility::GetForm("name", $_POST);
        $listId = Utility::GetForm("id", $_POST);
        $arrName = explode("(", $auditerName);
        $user_name = $arrName[0];
        $user_id = $this->objAgentcheckLogBLL->getUserIDByName($user_name);
        if ($user_id == "" || $user_id == 0)
        {
            die(json_encode(array("success" => false, "msg" => "不存在此用户")));
        }
        $rst = $this->objAgentcheckLogBLL->setCheckUid($listId, $user_id);
        if ($rst != 0)
        {
            die(json_encode(array("success" => true, "msg" => "修改成功")));
        }
        else
        {
            die(json_encode(array("success" => false, "msg" => "没有记录被修改")));
        }
    }

    public function PurposeGradeIndex()
    {
        $this->PageRightValidate("showPurposeGrade", RightValue::view);
        $strUrl = $this->getActionUrl('Agent', 'TaskAssign', 'PurposeGradeList');
        $arrAssign = array(
            'strTitle' => '意向评级统计',
            'strUrl' => $strUrl
        );
        $this->displayPage('Agent/PurposeGradeIndex.tpl', $arrAssign);
    }

    public function PurposeGradeList()
    {
        $strWhere = "";
        $user = Utility::GetForm("workno", $_GET);
        if (strstr($user, '('))
        {
            $arr = explode("(", $user);
            $user_name = $arr[0];
            $strWhere.="and tbl.user_name like '%$user_name%' ";
        }
        else
        {
            $strWhere.="and (tbl.e_name like '%$user%' or tbl.user_name like '%$user%') ";
        }
        $sTime = Utility::GetForm("sTime", $_GET);
        //$eTime = Utility::GetForm("eTime", $_GET);
        if ($sTime != "")
        {
            $strWhere.="and tbl.contact_time>='$sTime'";
        }
        $rstA = $this->objAgentContactBLL->getCountByGrade($strWhere);
        $rstB = $this->objAgentContactBLL->getGradeListData($strWhere);
        $this->smarty->assign('rstA', $rstA);
        $this->showPageSmarty($rstB, 'Agent/PurposeGradeList.tpl');
    }

}
?>
