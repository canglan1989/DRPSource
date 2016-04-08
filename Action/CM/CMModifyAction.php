<?php
/**http://localhost/?c=cm&d=cm&a=index
* @functional 审核模块 张雪林
*/
require_once __DIR__ . '/../Common/Alert.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/CommonAction.php';
require_once __DIR__ . '/../../Class/Model/CustomerInfo.php';
require_once __DIR__ . '/../../Class/Model/CustomerLogInfo.php';
require_once __DIR__ . '/../../Class/Model/CustomerAgentInfo.php';
require_once __DIR__ . '/../../Class/BLL/CustomerBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerLogBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerAgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/CommonBLL.php';
require_once __DIR__ . '/CMInfoAction.php';

class CMModifyAction extends ActionBase
{
    private $strTitle = ''; //设置网页标题
    private $strMsg = ''; //设置网页消息
    private $objNewsBLL = '';
    private $objCommonBLL = '';

    public function __construct()
    {
        $this->strTitle = '客户资料审核';
    }
    public function Index()
    {
        $this->smarty->assign('strTitle', '客户修改记录');
        $this->displayPage("CM/ManageList.tpl");
    }
    public function showModifyList()
    {
        $this->PageRightValidate("showModifyList",RightValue::view);
        $this->smarty->assign('strTitle', '客户修改记录');
        $strUrl = $this->getActionUrl('CM','CMModify','showModifyListBody');  
        $this->smarty->assign('strUrl',$strUrl);
        $this->displayPage("CM/ModifyList.tpl");
    }
    public function showModifyListBody()
    {
        $customerBLL = new CustomerBLL();
        $arrPageList = $customerBLL->getModifyListData();
        self::showPageSmarty($arrPageList, 'CM/ModifyListBody.tpl');
    }
    public function showModifyHistroyList()
    {
        $iAgentID = Utility::GetFormInt("agentid", $_GET);
        if($iAgentID>0){
            $this->PageRightValidate("CustomerInfo", RightValue::view);
        }else{
            $this->PageRightValidate("showModifyList",RightValue::v128);
        }
        
        $this->smarty->assign('strTitle', '客户修改历史记录');
        $strUrl = $this->getActionUrl('CM','CMModify','showModifyHistroyListBody');    
        $iCustomerID = Utility::GetFormInt("customer_id", $_GET);
        $this->smarty->assign('strUrl',$strUrl);     
        $this->smarty->assign('customer_id',$iCustomerID);
        $this->smarty->assign('agentid',$iAgentID);
        $this->displayPage("CM/ModifyHistoryList.tpl");
    }
    public function showModifyHistroyListBody()
    {
        $customerBLL = new CustomerBLL();
        $customer_id = Utility::GetFormInt("customer_id", $_GET);
        $iAgentID  = Utility::GetFormInt("agentid", $_GET);
        $arrPageList = $customerBLL->getModifyHistoryListData($customer_id,$iAgentID);
        self::showPageSmarty($arrPageList, 'CM/ModifyHistoryListBody.tpl');
    }
}
