<?php

/**
 * Description of index
 *
 * @author 许亮
 */
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/MapBLL.php';
require_once __DIR__ . '/../../Class/Model/MapInfo.php';

class IndexAction extends ActionBase
{

    private $objMapBLL = "";
    private $objMapInfo = "";

    public function __construct()
    {
        $this->objMapBLL = new MapBLL();
        $this->objMapInfo = new MapInfo();
    }

    public function showList()
    {
        $page = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);
        $pageSize = 20;
        $pageIndex = ($page - 1) * $pageSize;
        $pageCount = 1;
        $rst = $this->objMapBLL->selectAllData($pageIndex, $pageSize, &$pageCount);

        $this->smarty->assign("page", $page);
        $this->smarty->assign("pageCount", $pageCount);
        $this->smarty->assign("data", $rst);
        $this->displayPage('Map/AgentList.tpl');
    }

    public function showAdd()
    {
        $this->displayPage('Map/AgentAdd.tpl');
    }

    public function showMap()
    {
        $xy = Utility::GetForm("xy", $_GET);

        $rst = $this->objMapBLL->selectAllArea();
        $str = "";
        $groupStr = "";
        foreach ($rst as $key => $row)
        {
            $str.="{id:'{$row['id']}',title:'{$row['agent_name']}',point:'{$row['coordinate']}'},";
            $pos = "'" . str_replace('|', "','", $row['group_coordinate']) . "'";
            $groupStr.="{area:'{$row['group_name']}',center:'{$row['group_center_coordinate']}',pos:[{$pos}]},";
        }
        $str = substr($str, 0, -1);
        $groupStr = substr($groupStr, 0, -1);

        $this->smarty->assign("xy", $xy);
        $this->smarty->assign("area", $str);
        $this->smarty->assign("groupStr", $groupStr);
        $this->displayPage('Map/AgentMap.tpl');
    }

    public function showDetailInfo()
    {
        $id = Utility::GetForm("id", $_GET);
        $rst = $this->objMapBLL->getModelByID($id);

        $this->smarty->assign("data", $rst);
        $this->displayPage('Map/AgentInfo.tpl');
    }

    public function SaveAddInfo()
    {
        $this->objMapInfo->iAdhaiOnlineNum = urldecode(Utility::GetForm("adhai_online_num", $_REQUEST));
        $this->objMapInfo->iDeposits = urldecode(Utility::GetForm("deposits", $_REQUEST));
        $this->objMapInfo->iEnsureMoney = urldecode(Utility::GetForm("ensure_money", $_REQUEST));
        $this->objMapInfo->iRealVisit = urldecode(Utility::GetForm("real_visit", $_REQUEST));
        $this->objMapInfo->iVisitNum = urldecode(Utility::GetForm("visit_num", $_REQUEST));
        $this->objMapInfo->strAgentName = urldecode(Utility::GetForm("agent_name", $_REQUEST));
        $this->objMapInfo->strArea = urldecode(Utility::GetForm("area", $_REQUEST));
        $this->objMapInfo->strCoordinate = urldecode(Utility::GetForm("coordinate", $_REQUEST));
        $this->objMapInfo->strDeadline = urldecode(Utility::GetForm("deadline", $_REQUEST));
        $this->objMapInfo->strFollowCustomer = urldecode(Utility::GetForm("follow_customer", $_REQUEST));
        $this->objMapInfo->strGroupCenterCoordinate = urldecode(Utility::GetForm("group_center_coordinate", $_REQUEST));
        $this->objMapInfo->strGroupCoordinate = urldecode(Utility::GetForm("group_coordinate", $_REQUEST));
        $this->objMapInfo->strGroupName = urldecode(Utility::GetForm("group_name", $_REQUEST));
        $this->objMapInfo->strNewCustomer = urldecode(Utility::GetForm("new_customer", $_REQUEST));
        $this->objMapInfo->strSignName = urldecode(Utility::GetForm("sign_name", $_REQUEST));
        $this->objMapInfo->strSignedCustomer = urldecode(Utility::GetForm("signed_customer", $_REQUEST));
        $this->objMapInfo->strStatus = urldecode(Utility::GetForm("status", $_REQUEST));
        $this->objMapInfo->strVisitRate = urldecode(Utility::GetForm("visit_rate", $_REQUEST));
        $this->objMapInfo->strProductName = urldecode(Utility::GetForm("product_name", $_REQUEST));
        $rst = $this->objMapBLL->insert($this->objMapInfo);
        if ($rst)
        {
            echo json_encode(array("success" => true));
        }
        else
        {
            echo json_encode(array("success" => false));
        }
    }

    public function DelInfo()
    {
        $id = Utility::GetForm('id', $_POST);

        $rst = $this->objMapBLL->delete($id);
        if ($rst != 0)
        {
            echo json_encode(array("success" => true));
        }
        else
        {
            echo json_encode(array("success" => false));
        }
    }

    public function showEdit()
    {
        $id = Utility::getform('id', $_GET);
        $rst = $this->objMapBLL->getModelByID($id);
        $this->smarty->assign("data", $rst);
        $this->displayPage('Map/AgentEdit.tpl');
    }

    public function SaveEdit()
    {
        $this->objMapInfo->iId = Utility::getform('id', $_REQUEST);
        $this->objMapInfo->iAdhaiOnlineNum = urldecode(Utility::GetForm("adhai_online_num", $_REQUEST));
        $this->objMapInfo->iDeposits = urldecode(Utility::GetForm("deposits", $_REQUEST));
        $this->objMapInfo->iEnsureMoney = urldecode(Utility::GetForm("ensure_money", $_REQUEST));
        $this->objMapInfo->iRealVisit = urldecode(Utility::GetForm("real_visit", $_REQUEST));
        $this->objMapInfo->iVisitNum = urldecode(Utility::GetForm("visit_num", $_REQUEST));
        $this->objMapInfo->strAgentName = urldecode(Utility::GetForm("agent_name", $_REQUEST));
        $this->objMapInfo->strArea = urldecode(Utility::GetForm("area", $_REQUEST));
        $this->objMapInfo->strCoordinate = urldecode(Utility::GetForm("coordinate", $_REQUEST));
        $this->objMapInfo->strDeadline = urldecode(Utility::GetForm("deadline", $_REQUEST));
        $this->objMapInfo->strFollowCustomer = urldecode(Utility::GetForm("follow_customer", $_REQUEST));
        $this->objMapInfo->strGroupCenterCoordinate = urldecode(Utility::GetForm("group_center_coordinate", $_REQUEST));
        $this->objMapInfo->strGroupCoordinate = urldecode(Utility::GetForm("group_coordinate", $_REQUEST));
        $this->objMapInfo->strGroupName = urldecode(Utility::GetForm("group_name", $_REQUEST));
        $this->objMapInfo->strNewCustomer = urldecode(Utility::GetForm("new_customer", $_REQUEST));
        $this->objMapInfo->strSignName = urldecode(Utility::GetForm("sign_name", $_REQUEST));
        $this->objMapInfo->strSignedCustomer = urldecode(Utility::GetForm("signed_customer", $_REQUEST));
        $this->objMapInfo->strStatus = urldecode(Utility::GetForm("status", $_REQUEST));
        $this->objMapInfo->strVisitRate = urldecode(Utility::GetForm("visit_rate", $_REQUEST));
        $this->objMapInfo->strProductName = urldecode(Utility::GetForm("product_name", $_REQUEST));

        $rst = $this->objMapBLL->updateByID($this->objMapInfo);
        if ($rst == 1)
        {
            echo json_encode(array("success" => true));
        }
        else
        {
            echo json_encode(array("success" => false));
        }
    }

}

?>
