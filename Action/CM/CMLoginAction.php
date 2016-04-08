<?php
/**
* @functional 注册客户管理 张雪林
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
require_once __DIR__ . '/../../Class/BLL/AreaBLL.php';
require_once __DIR__ . '/../../Class/BLL/IndustryBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';

class CMLoginAction extends ActionBase
{
    public function __construct()
    {
    }
    public function Index()
    {
        $this->smarty->assign('strTitle', '注册客户管理');
        $this->displayPage("CM/CustomerLoginList.tpl");
    }
    //展现客户注册信息列表[主页面]
    public function showCustomerLoginInfoList()
    {
        $this->PageRightValidate("showCustomerLoginInfoList", RightValue::view);
        $customerBLL = new CustomerBLL();
        $countArry = $customerBLL->getNotTransferNum();
        if (isset($countArry['list']) && count($countArry['list']) == 1) {
            $this->smarty->assign("notTransfer", $countArry['list'][0]["transstat"]);
            
        }
        else
        {
            $this->smarty->assign("notTransfer", "0");
        }
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");
        //print_r($arrProductType);exit;
        $newType = array();
        foreach ($arrProductType as $key => $type)
        {   //print_r($arrProductType);exit;
            $newType[$key]['key'] = $type['aid'];
            $newType[$key]['value'] = $type['product_type_name'];
        }
        $arrJsonType = json_encode($newType);
        $this->smarty->assign('arrJsonType',$arrJsonType);
        $this->smarty->assign('strTitle', '注册客户管理');
        $strUrl = $this->getActionUrl('CM','CMLogin','showCustomerLoginInfoListBody');
        $this->smarty->assign('strUrl',$strUrl);
        $this->displayPage("CM/CustomerLoginList.tpl");
    }
    //展现客户注册信息列表主页面
    public function showCustomerLoginInfoListBody()
    {
        $customer = new CustomerBLL();
        $arrPageList = $customer->getCustomerLoginInfoListData();
        self::showPageSmarty($arrPageList, 'CM/CustomerLoginListBody.tpl');
    }
    
    //展现客户转移页面
    public function showCustomerTransfer()
    {
        $this->PageRightValidate("showCustomerLoginInfoList",RightValue::v512);
        $this->smarty->assign('strTitle', '客户资料转移记录');
        $customer_ids=$_GET["customer_ids"];
        //接收客户ID数组
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");
        $newType = array();
        foreach ($arrProductType as $key => $type)
        {
            $newType[$key]['key'] = $type['aid'];
            $newType[$key]['value'] = $type['product_type_name'];
        }
        $arrJsonType = json_encode($newType);
        $this->smarty->assign('arrJsonType',$arrJsonType);
        $this->smarty->assign('customer_ids', $customer_ids);
        $strUrl = $this->getActionUrl('CM', 'CMLogin', 'showCustomerTransferBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/CustomerLoginTransfer.tpl");
    }
    //展现客户资料转移明细列表主体
    public function showCustomerTransferBody()
    {
        $customer_ids=$_GET["customer_ids"];
        $customerBLL = new CustomerBLL();
        $arrPageList = $customerBLL->getTransferDetailListData($customer_ids);
        $this->smarty->assign('arrayData', $arrPageList);
        self::showPageSmarty($arrPageList, 'CM/CustomerLoginTransferBody.tpl');
    }
    //展现客户背景资料
    public function showCustomerBJ()
    {
        $customerID = Utility::GetFormInt("id",$_GET);//print_r($customerID);exit;
        if($customerID <= 0)
            exit("客户ID无效");
            
        if($this->isAgentUser())
        {
            $objCustomerAgentBLL = new CustomerAgentBLL();
            $arrayData = $objCustomerAgentBLL->select("customer_id","customer_id=$customerID and agent_id=".$this->getAgentId(),"");
            if(!(isset($arrayData)&& count($arrayData)>0))
                exit("您无权查看此客户信息");
        }
        
        $customerBLL = new CustomerBLL();
        $arr = $customerBLL->getInterProduct($customerID);
        $product = "";
        foreach ($arr as $value)
        {
            $product .= $value['intention_name'].','; 
        }
        $interProduct = substr($product, 0, -1);
        $arryInfo = $customerBLL->GetCustomerInfo($customerID);
        //print_r($arryInfo);exit;
        if($arryInfo[0]['reg_place'] != -1 && $arryInfo[0]['reg_place'] != 0)
        {
        $area_id = $arryInfo[0]['reg_place'];
        $AreaFullName = $customerBLL->getRegPlace($area_id);
        $arryInfo[0]['reg_place'] = $AreaFullName[0]['area_fullname'];
        }
        //print_r($arryInfo);exit;
        $arrInfo = $customerBLL->getCustomerConnectInfo($customerID);
      // var_dump($arrInfo);exit;
        if (isset($arryInfo) && count($arryInfo) == 1) {
	        if ($arryInfo[0]["customer_from"]=="-1")
	    	{
	    		$arryInfo[0]["customer_from"]="";
	    	}
	    	if ($arryInfo[0]["reg_status"]=="-1")
	    	{
	    		$arryInfo[0]["reg_status"]="";
	    	}
//	    	if ($arrInfo[0]["contact_importance"]=="-1")
//	    	{
//	    		$arrInfo[0]["contact_importance"]="";
//	    	}
//	    	if ($arrInfo[0]["contact_net_awareness"]=="-1")
//	    	{
//	    		$arrInfo[0]["contact_net_awareness"]="";
//	    	}
           
            $this->smarty->assign($arryInfo[0]);
           // print_r($arrInfo);exit;
            $this->smarty->assign($arrInfo[0]);
            //var_dump($arrInfo);exit;
            $remark=str_replace(array("<BR/><BR/>","<BR/>", "<br/>"),"<BR/>",$arrInfo[0]["contact_remark"]);
            $this->smarty->assign('interProduct', $interProduct);
            $this->smarty->assign("contact_remark", $remark);
            $this->smarty->assign("reg_date", CommonAction::GetDate($arryInfo[0]["reg_date"]));
            $this->displayPage("CM/showCustomerBJ.tpl");
        }
    }
}
?>
