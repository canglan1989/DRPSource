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
require_once __DIR__ . '/../../Class/BLL/CustomerExBLL.php';
require_once __DIR__ . '/../../Class/BLL/DataConfigBLL.php';
require_once __DIR__ . '/CMInfoAction.php';
require_once __DIR__ . '/TransferAdHaiOrderBase.php';

class CMTransferAction extends TransferAdHaiOrder
{
    private $strTitle = ''; //设置网页标题
    private $strMsg = ''; //设置网页消息
    private $objNewsBLL = '';
    private $objCommonBLL = '';

    public function __construct()
    {
        $this->strTitle = '客户资料转移记录';
    }
    public function Index()
    {
        $this->smarty->assign('strTitle', '客户资料转移记录');
        $this->displayPage("CM/ManageList.tpl");
    }
    //展现客户转移页面
    public function showTransfer()
    {
        $this->PageRightValidate("showBackInfoList",RightValue::v512);
        $this->smarty->assign('strTitle', '客户资料转移记录');
        $customer_ids=$_GET["customer_ids"];//var_dump($customer_ids);exit;
        //接收客户ID数组
        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->select("aid,product_type_name", "", "");
        $newType = array();
        foreach ($arrProductType as $key => $type)
        {
            $newType[$key]['key'] = $type['aid'];
            $newType[$key]['value'] = $type['product_type_name'];
        }
        //$length = count($arrProductType);
//        $newType[$length]['key'] = '6';
//        $newType[$length]['value'] = "请选择";
      //  print_r($newType);exit;
        $arrJsonType = json_encode($newType);//print_r($arrJsonType);exit;
        $this->smarty->assign('arrJsonType',$arrJsonType);
        $this->smarty->assign('customer_ids', $customer_ids);
        $strUrl = $this->getActionUrl('CM','CMTransfer','showTransferBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/TransferBack.tpl");
    }
    //展现客户资料转移明细列表主体
    public function showTransferBody()
    {
        $customer_ids=$_GET["customer_ids"];//print_r($customer_ids);exit;
        $customerBLL = new CustomerBLL();
        $arrPageList = $customerBLL->getTransferDetailListData($customer_ids);
      //var_dump($arrPageList);exit;
        $this->smarty->assign('arrayData', $arrPageList);
        self::showPageSmarty($arrPageList, 'CM/TransferBody.tpl');
    }
    //展现客户资料转移记录列表[主页面]
    public function showTransferList()
    {
        $this->PageRightValidate("showTransferList",RightValue::view);
        $this->smarty->assign('strTitle', '客户资料转移记录');
        $strUrl = $this->getActionUrl('CM', 'CMTransfer', 'showTransferListBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/TransferList.tpl");
    }
    //展现客户资料转移记录列表主体
    public function showTransferListBody()
    {
        $customerBLL = new CustomerBLL();
        $arrPageList = $customerBLL->getTransferListData();//var_dump($arrPageList);exit;
        self::showPageSmarty($arrPageList, 'CM/TransferListBody.tpl');
    }
    //通过代理商名称获取 代理商帐号(名称)
    public function getAgentName_ID()
    {
        $agentName = Utility::GetForm('q',$_GET);
        $customerBLL = new CustomerBLL();
        if(trim($agentName) == "")
            exit("");
        $customerBLL = new CustomerBLL();
        $arrayData = $customerBLL->getAgentName_ID($agentName);
        exit(json_encode(array('value'=>$arrayData)));
    }
    //后台转移客户
    public function transferBack() {
        $this->PageRightValidate("showBackInfoList", RightValue::v512);
        
        $to_anget_id = Utility::GetForm("to_anget_id", $_POST); //print_r($to_anget_id);die("333");
        $agent_customer_id = Utility::GetForm('listid', $_POST);
        $inten_products = Utility::GetForm('inten_product', $_POST);
        //     $customer_ids = Utility::GetForm('listid',$_POST);
        $create_uid = parent::getUserId();
        $customerBLL = new CustomerBLL();
        //获取每条$agent_customer_id对应的customer_id
        $customer_ids = $customerBLL->getCMid($agent_customer_id);
        if(empty ($customer_ids)){
            Utility::Msg("请选择待转移的数据");
        }
        
        $arrCM = array();
        foreach ($customer_ids as $value) {
            $arrCM[] = "{$value['customer_id']}";
        }
        //判断目标代理商是否超出容量
        $objAgentBLL = new AgentBLL();
        $objAgentInfo = $objAgentBLL->getModelByID($to_anget_id);
        $objCustomerExBLL = new CustomerExBLL();
        
        $iCustomerCount = $objCustomerExBLL->getCustomerCountByID($objAgentInfo->iChannelUid, $to_anget_id, CustomerDefendState::DefendCustomer);
        $iCustomerCount = $iCustomerCount[0]['num'];
        $objDataConfigBLL = new DataConfigBLL();
        
        $iMaxCount = $objDataConfigBLL->GetAllow_Count_Protect($to_anget_id);
        if($iMaxCount < (count($arrCM) + $iCustomerCount)){
            Utility::Msg("转移失败,该代理商主账号保护客户容量已达到最大");
        }
        
        $strCustomerIDs = implode(',', $arrCM);
        $Rtn = $this->TransferVaild($strCustomerIDs);
        if($Rtn !== true){
            Utility::Msg("转移失败。".$Rtn);
        }
        
        if ($inten_products == "") {
            $inten_product = "";
        } else {
            $inten_product = explode(",", $inten_products);
        }
        //根据产品ID获取产品名
        $arr = "";
        if ($inten_product != "") {
            foreach ($inten_product as $key => $value) {
                $res = $customerBLL->getProductName($value);

                $arr .= $res[0]["product_type_name"] . ",";
            }
            $product_name = substr($arr, 0, -1);
        } else {
            $product_name = "";
        }
        $arrayData = $customerBLL->transferBack($to_anget_id, $agent_customer_id, $create_uid, $product_name, $strCustomerIDs);
        if($arrayData){
            
            //检查EX表中是否已经存在该客户的数据，若已经存在则不变，否则添加一条EX记录
            $arrCustomerExList = $objCustomerExBLL->getCustomerExListByCustomerID($arrCM, $to_anget_id);
            foreach($arrCustomerExList as $Item){
                $strKey = array_search($Item['customer_id'], $arrCM);
                if($strKey !==false){
                    unset ($arrCM[$strKey]);
                }
            }
            if(count($arrCM)>0){
                $objCustomerExInfo = new CustomerExInfo();
                $objCustomerExInfo->iAgentId = $to_anget_id;
                $objCustomerExInfo->iRecordCount = 0;
                $objCustomerExInfo->strToSeaTime = Utility::addDay(Utility::Now(), $objDataConfigBLL->GetProtectTime_Protect_No_Record($to_anget_id),false);
                $objCustomerExInfo->iDefendState = CustomerDefendState::DefendCustomer;
                foreach($arrCM as $iCustomerID){
                    $objCustomerExInfo->iCustomerId = $iCustomerID;
                    $iRtn = $objCustomerExBLL->insert($objCustomerExInfo);
                }
            }
        }
        
        $customerBLL->deleteIntenProduct($arrCM); //删除原有的意向产品
        if ($inten_product != "") {
            $customerBLL->insertIntenProduct($inten_product, $arrCM);
        }//更新意向产品
        Utility::Msg("转移成功",true,  $this->getActionUrl("CM", "CMInfo", "showBackInfoList"));
    }
    
    

    //后台转移客户(##自动注册##)
    public function transferZhuceBack()
    {
        $this->PageRightValidate("showCustomerLoginInfoList",RightValue::v512);
        $to_anget_id=Utility::GetForm("to_anget_id",$_POST);
        $agent_customer_id=Utility::GetForm('listid',$_POST);
        $inten_product = Utility::GetForm('inten_product', $_POST);//print_r($inten_product);die("tttt");exit;
        //$customer_id = Utility::GetForm('customer_ids', $_POST);
        $create_uid=parent::getUserId();
        $customerBLL = new CustomerBLL();
        
        //获取每条$agent_customer_id对应的customer_id  #丅#
        $customer_ids = $customerBLL->getCMid($agent_customer_id);
        $arrCM = "";
        foreach($customer_ids as $value)
        {
            $arrCM .= $value['customer_id'].",";
        }   
        $arrCM = substr($arrCM, 0, -1);//选中的客户id 组 #丄#
       
        $customerOrders = $customerBLL->getcustomerOrders($arrCM); //判断被转移的客户是否存在订单
        if ($customerOrders != array()) {die("2");}
        
        
        //根据产品ID获取产品名
       $arr = "";
     if($inten_product != ""){ 
        $inten_product = explode(",", $inten_product);//print_r($inten_product);die("ttt");exit;
        foreach($inten_product as $key => $value)
        {
            $res = $customerBLL->getProductName($value);
        //die("ttt");
            $arr .= $res[0]["product_type_name"].",";
        }
        $product_name = substr($arr, 0,-1);} else{$product_name = "";} //print_r($product_name);exit;
        $arrayData = $customerBLL->transferBack($to_anget_id,$agent_customer_id,$create_uid,$product_name,$arrCM);
        $customerBLL->deleteIntenProduct($arrCM);
        if($inten_product != ""){
        $customerBLL->insertIntenProduct($inten_product,$arrCM);}
        die("1");
    } 
    
    public function getTransfer(){
        $this->goTransferOrder();
    }
}
