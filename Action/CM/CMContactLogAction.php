<?php

require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../../Class/BLL/AgContactBLL.php';

class CMContactLogAction extends ActionBase
{

    private $objAgContactBLL = "";

    public function __construct()
    {
        $this->objAgContactBLL = new AgContactBLL();
    }

    public function ContactLogIndex()
    {
        $strUrl = $this->getActionUrl('CM', 'CMContactLog', 'ContactLogList');
        $arrAssign = array(
            'strUrl' => $strUrl
        );
        $this->displayPage("CM/ContactLogIndex.tpl", $arrAssign);
    }

    public function ContactLogList()
    {
        $strWhere = "";
        //该代理商帐下的联系小记内容
        $agent_id = parent::getAgentId();
        $strWhere.="and A.agent_id = '$agent_id'
                    and D.agent_id = '$agent_id'
                    and C.agent_id = '$agent_id' ";
        $customerName = Utility::GetForm("customerName", $_GET);
        if ($customerName != "")
            $strWhere.="and B.customer_name like '%$customerName%' ";

        $intentRating = Utility::GetForm("intentRating", $_GET);
        if ($intentRating != "" && $intentRating != -1)
            $strWhere.="and A.intention_rating = '$intentRating' ";

        $contactTimeS = Utility::GetForm("contactTimeS", $_GET);
        $contactTimeE = Utility::GetForm("contactTimeE", $_GET);
        if ($contactTimeS != "" && $contactTimeE != "")
            $strWhere.="and (A.contact_time >= '$contactTimeS 00:00:00' and A.contact_time<= '$contactTimeE 23:59:59') ";
        $user_no = parent::getUserNo();
        $rst = $this->objAgContactBLL->getContactLogList($strWhere,$user_no);
       // print_r($rst);exit;
        $this->showPageSmarty($rst, "CM/ContactLogList.tpl");
    }

}

?>
