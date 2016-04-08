<?php

/* * http://localhost/?c=cm&d=cm&a=index
* @functional 客户资料管理 张雪林
*/
require_once __DIR__ . '/../Common/Alert.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/CommonAction.php';
require_once __DIR__ . '/../../Class/Model/CustomerInfo.php';
require_once __DIR__ . '/../../Class/Model/AgContactInfo.php';
require_once __DIR__ . '/../../Class/Model/CustomerLogInfo.php';
require_once __DIR__ . '/../../Class/Model/CustomerAgentInfo.php';
require_once __DIR__ . '/../../Class/BLL/CustomerBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerLogBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerAgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/AreaBLL.php';
require_once __DIR__ . '/../../Class/BLL/IndustryBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgContactBLL.php';
require_once __DIR__ . '/../Common/UploadFile.php';
require_once __DIR__ . '/../../Class/BLL/OrderBLL.php';
require_once __DIR__ . '/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__ . '/../../AddCusToBasicPlat/AddCusToBasicPlatAction.php';
require_once __DIR__ . '/../../Class/BLL/DataConfigBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerExBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgContactRecodeBLL.php';
require_once __DIR__ . '/../../Class/BLL/IntentionRatingBLL.php';

class CMInfoAction extends ActionBase
{

    private $strTitle = ''; //设置网页标题
    private $strMsg = ''; //设置网页消息
    private $objNewsBLL = '';
    private $objCommonBLL = '';
    private $strWhere = '';

    public function __construct()
    {

    }

    public function Index()
    {
        $this->smarty->assign('strTitle', '客户资料管理');
        $this->displayPage("CM/ManageList.tpl");
    }

    //展现客户资料后台管理列表[主页面]
    public function showBackInfoList()
    {
        $this->PageRightValidate("showBackInfoList", RightValue::view);
        $strUrl = $this->getActionUrl('CM', 'CMInfo', 'showBackInfoListBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/InfoListBack.tpl");
    }

    //展现客户资料后台列表主体
    public function showBackInfoListBody()
    {
        $customerBLL = new CustomerBLL();
        $strWhere = $this->getBackInfoListWhere();
        $strOrder = Utility::GetForm("sortField", $_GET);
        $arrPageList = $customerBLL->getBackInfoListData($strWhere,$strOrder);
        self::showPageSmarty($arrPageList, 'CM/InfoListBackBody.tpl');
    }
    
    public function getBackInfoListWhere(){
        $strWhere = '';
        $strCustomerName = Utility::GetForm("customer_name", $_GET);
        if(!empty ($strCustomerName)){
            $strWhere .= " and (cm_customer.customer_name like '%{$strCustomerName}%' or cm_customer.customer_id = '{$strCustomerName}') ";
        }
        $strCreateUser = Utility::GetForm("user_name", $_GET);
        if(!empty ($strCreateUser)){
            $strWhere .= " and cm_customer.create_user_name like '%{$strCreateUser}%' ";
        }
        $strCreateTimeBegin = Utility::GetForm("create_time_begin", $_GET);
        if(!empty ($strCreateTimeBegin)){
            $strWhere .= " and cm_customer.create_time >= '{$strCreateTimeBegin}' ";
        }
        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if(!empty ($strCreateTimeEnd)){
            $strWhere .= " and cm_customer.create_time < DATE_ADD('{$strCreateTimeEnd}',INTERVAL 1 day) ";
        }
        $iIndustyPid = Utility::GetFormInt("industry_pid", $_GET);
        if($iIndustyPid > 0){
            $strWhere .= " and cm_customer.industry_pid = {$iIndustyPid} ";
            $iIndustyId = Utility::GetFormInt("industry_id", $_GET);
            if($iIndustyId > 0){
                $strWhere .= " and cm_customer.industry_id = {$iIndustyId} ";
            }
        }
        $iCustomerResource = Utility::GetFormInt("customer_resource", $_GET);
        if($iCustomerResource == 1){
            $strWhere .= " and cm_customer.customer_resource = ".CustomerResource::AutoRegister." ";
        }  elseif ($iCustomerResource == 2) {
            $strWhere .= " and (cm_customer.customer_resource < ".CustomerResource::AutoRegister." or cm_customer.customer_resource > ".CustomerResource::AutoRegister.") ";
        }
        $iProvinceId = Utility::GetFormInt("selProvince", $_GET);
        if($iProvinceId > 0){
            $strWhere .= " and cm_customer.province_id = {$iProvinceId} ";
            $iCityId = Utility::GetFormInt("selCity", $_GET);
            if($iCityId > 0){
                $strWhere .= " and cm_customer.city_id = {$iCityId} ";
                $iAreaID = Utility::GetFormInt("area_id", $_GET);
                if($iAreaID > 0){
                    $strWhere .= " and cm_customer.area_id = {$iAreaID} ";
                }
            }
        }
        $strAgentName = Utility::GetForm("agent_name", $_GET);
        if(!empty ($strAgentName)){
            $strWhere .= " and am_agent_source.agent_name like '%{$strAgentName}%' ";
        }
        return $strWhere;
    }

    //【前台】客户转移管理[主页面]
    public function showCustomerTransferList()
    {
        $this->PageRightValidate("showCustomerTransferList", RightValue::view);
        $strUrl = $this->getActionUrl('CM', 'CMInfo', 'showCustomerTransferListBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/CustomerTransferFront.tpl");
    }

    //【前台】客户转移管理主体列表
    public function showCustomerTransferListBody()
    {
        $this->ExitWhenNoRight("showCustomerTransferList", RightValue::view);
        $customerBLL = new CustomerBLL();
        $agent_id = parent::getAgentId();
        $user_no = parent::getUserNo();
        
        $sWhere = "";
        $customer_name = Utility::GetForm("customer_name", $_GET);
        $industry_pid = Utility::GetFormInt("industry_pid", $_GET);
        $industry_id = Utility::GetFormInt("industry_id", $_GET);
        $province_id = Utility::GetFormInt("selProvince", $_GET);
        $city_id = Utility::GetFormInt("selCity", $_GET);
        $area_id = Utility::GetFormInt("area_id", $_GET);
        $user_in_name = Utility::GetForm("user_in_name", $_GET);
        $strOrder = Utility::GetForm("sortField", $_GET);
        if ($area_id != "" && $area_id != "-1") {
            $sWhere .= " and cm.area_id = {$area_id}";
        }
        else if ($city_id != "" && $city_id != "-1") {
            $sWhere .= " and cm.`city_id` = {$city_id}";
        }
        else if ($province_id != "" && $province_id != "-1") {
            $sWhere .= " and cm.`province_id` = {$province_id}";
        }
        if ($industry_id != "" && $industry_id != "-1") {
            $sWhere .= " and cm.`industry_id`={$industry_id}";
        }
        else if ($industry_pid != "" && $industry_pid != "-1") {
            $sWhere .= " and cm.`industry_pid`={$industry_pid}";
        }
        
        if ($customer_name != "") {
            $sWhere .= " and cm.customer_name like '%{$customer_name}%'";
        }
        if ($user_in_name != "") {
            $sWhere .= " and (create_user.user_name like '%{$user_in_name}%' or create_user.e_name like '%{$user_in_name}%')";
        } 
        
        if ($strOrder != "") {
            $sWhere .= " order by {$strOrder}";
        } else {
            $sWhere .= " order by create_time desc";
        }
        
        $arrPageList = $customerBLL->getFrontTransferLog($agent_id, $this->getFinanceUid(),$sWhere);
        self::showPageSmarty($arrPageList, "CM/CustomerTransferFrontBody.tpl");
    }

    //【前台】展现客户资料管理列表[主页面]
    public function showFrontInfoList()
    {
        $this->PageRightValidate("showFrontInfoList", RightValue::view);
        $strUrl = $this->getActionUrl('CM', 'CMInfo', 'showFrontInfoListBody');
        
        $objDataConfigBLL = new DataConfigBLL();
        $arrConfig = $objDataConfigBLL->getFrontprotectDateList($this->getAgentId());
        
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->JsonForMultiSelect(false);
        $this->smarty->assign('strIntentionRatingJson',$strIntentionRatingJson); 
        
        $this->smarty->assign('ProtectTel',$arrConfig['ProtectTime_Tel']);
        $this->smarty->assign('ProtectSelfNo',$arrConfig['ProtectTime_Self_No_Record']);
        $this->smarty->assign('ProtectDefendNo',$arrConfig['ProtectTime_Protect_No_Record']);
        $this->smarty->assign('ProtectSelfHas',$arrConfig['ProtectTime_Self_Record']);
        $this->smarty->assign('ProtextDefendHas',$arrConfig['ProtectTime_Protect_Record']);
        $this->smarty->assign('ProtectFormat',$arrConfig['ProtectTime_Formal']);
        $this->smarty->assign('strUrl', $strUrl);
        $this->displayPage("CM/InfoListFront.tpl");
    }

    //【前台】展现客户资料列表主体
    public function showFrontInfoListBody()
    {
        $customerBLL = new CustomerBLL();
        $agent_id = parent::getAgentId();
        $user_id = parent::getUserNo();
        $USERID = parent::getUserId();
        //print_r($USERID);exit;
        
        $valueProduct = 0;//签了增值产品 wzx
        $unitProduct = 0;//签了网盟产品 wzx
        $objProductTypeBLL = new ProductTypeBLL();
        $objSignProduct = $objProductTypeBLL->GetAgentSignedProductType($agent_id,true);
        foreach($objSignProduct as $key => $value) 
        {
            if($value["data_type"] == 1)
                $unitProduct = 1;
            else
                $valueProduct = 1;
                
            if($unitProduct == 1 && $valueProduct == 1)
                break;
        }
        
        $this->smarty->assign('valueProduct', $valueProduct);
        $this->smarty->assign('unitProduct', $unitProduct);
        
        $strOrder = Utility::GetForm("sortField", $_GET);  
        $strWhere = $this->FrontInfoListWhere();
        $arrPageList = $customerBLL->getFrontInfoListData($strWhere, $strOrder,  $this->getAgentId());
        //print_r($arrPageList);
        //exit;
        $this->smarty->assign('USERID', $USERID);
        self::showPageSmarty($arrPageList, 'CM/InfoListFrontBody.tpl');
    }
    
    public function FrontInfoListWhere() {
        $strWhere = " and cm_customer_agent.user_id = {$this->getUserId()} and cm_customer_ex.to_sea_time > '".Utility::Now()."' ";

        $customer_name = Utility::GetForm('customer_name', $_GET);
        if (!empty($customer_name)) {
            $strWhere .= " and cm_customer.`customer_name` like '%{$customer_name}%' ";
        }

        $check_status = Utility::GetFormInt('check_status', $_GET);
        if ($check_status != '99') {
            $strWhere .= " and cm_customer_agent.`check_status` = {$check_status}";
        }

        $person_resource = Utility::GetFormInt('person_resource', $_GET);
        if(!empty ($person_resource)){
            $strWhere .= " and cm_customer_agent.customer_resource_person = {$person_resource} ";
        }

        $create_time_begin = Utility::GetForm('create_time_begin', $_GET);
        if (!empty($create_time_begin)) {
            $strWhere .= " and cm_customer_ex.last_record_time >= '{$create_time_begin}' ";
        }
        $create_time_end = Utility::GetForm('create_time_end', $_GET);
        if (!empty($create_time_end)) {
            $strWhere .= " and cm_customer_ex.last_record_time < date_add('{$create_time_end}',interval 1 day) ";
        }
        
        $province_id = Utility::GetForm("selProvince", $_GET);
        if (!empty($province_id) && $province_id != "-1") {
            $strWhere .= " and cm_customer.`province_id` = {$province_id} ";
        }
        $city_id = Utility::GetForm("selCity", $_GET);
        if (!empty($city_id) && $city_id != "-1") {
            $strWhere .= " and cm_customer.`city_id` = {$city_id} ";
        }
        $area_id = Utility::GetForm("area_id", $_GET);
        if (!empty($area_id) && $area_id != "-1") {
            $strWhere .= " and cm_customer.area_id = {$area_id} ";
        }
        $industry_pid = Utility::GetForm("industry_pid", $_GET);
        if (!empty($industry_pid) && $industry_pid != "-1") {
            $strWhere .= " and cm_customer.`industry_pid`={$industry_pid} ";
        }
        $industry_id = Utility::GetForm("industry_id", $_GET);
        if (!empty($industry_id) && $industry_id != "-1") {
            $strWhere .= " and cm_customer.`industry_id`={$industry_id} ";
        }
        
        $iDefendState = Utility::GetFormInt("defend_state", $_GET);
        if(!empty ($iDefendState)){
            $strWhere .= " and cm_customer_ex.defend_state={$iDefendState}";
        }
        
        $strIntentionList = Utility::GetForm("IntentionRating", $_GET);
        if(!empty ($strIntentionList)){
            $strWhere .= " and cm_customer_ex.intention_rating in ({$strIntentionList}) ";
        }
        
        return $strWhere;
    }
    
    public function showDelFrontClient(){
        $this->displayPage("CM/DelCustomer.tpl");
    }

    //客户删除
    public function delFrontClient()
    {
        $this->ExitWhenNoRight("showFrontInfoList", RightValue::del);
        $customerBLL = new CustomerBLL();
        $cusId = Utility::GetForm("customerids", $_POST);
        //验证是否选择客户
        if (empty ($cusId)) {
            Utility::Msg("请选择需要删除的客户");
        } else { 
            $objCustomerLogBLL = new CustomerLogBLL();
            $arrLogList = $objCustomerLogBLL->getCheckingLog($cusId,1,$this->getAgentId());
            if($arrLogList){
                Utility::Msg("存在审核中申请的数据不得删除");
            }
            
            //判断是否有联系小记
            $objAgContactRecordBLL = new AgContactRecodeBLL();
            $arrContactList = $objAgContactRecordBLL->select("customer_id,customer_name", "customer_id in ({$cusId}) and is_del = 0 and create_uid > 0 and agent_id={$this->getAgentId()}");
            if($arrContactList){
                $ErrorMsg = array();
                foreach($arrContactList as $arrContactInfo){
                    if(!array_search($arrContactInfo['customer_id'], $ErrorMsg)){
                        $ErrorMsg[$arrContactInfo['customer_id']] = $arrContactInfo['customer_name'];
                    }
                }
                Utility::Msg("客户".  implode(",", $ErrorMsg)."存在联系小记，不能删除");
            }
            //判断是否正式客户
            $objCustomerExBLL = new CustomerExBLL();
            $arrCustomerList = $objCustomerExBLL->getCustomerExListByCustomerID($cusId, $this->getAgentId());
            if($arrCustomerList && $arrCustomerList[0]['defend_state'] == CustomerDefendState::HasOrderCustomer){
                Utility::Msg("存在正式客户");
            }
            //判断是否有订单
            $customerBLL = new CustomerBLL();
            $A = $customerBLL->getOrder($cusId);
            //print_r($A);exit;
            if ($A != array()) {
                Utility::Msg("该客户已有订单,不能删除");
            }
            
            $strDelReason = urldecode(Utility::GetForm("delreason", $_POST));
            if(empty ($strDelReason)){
                Utility::Msg("请填写删除的原因");
            }
            //基础平台同步添加客户
            $objAddCusToBasicPlatAction = new AddCusToBasicPlatAction();
            $objCustomerInfo = new CustomerInfo();
            $objCustomerInfo->iCustomerId = $cusId;
            $objAddCusToBasicPlatAction->AddCusToBasicPlat($objCustomerInfo,"del");
            //分离直接删除与需要审核的信息
            
            $arrCustomerInfo =$customerBLL->getCustomerInfoByCustomerIDList($cusId); 
            $arrIDPool = array(
                'HasChecked'=>array(),
                'NoChecked'=>array()
            );
            foreach($arrCustomerInfo as $data){
                if($data['history_check'] > 0){
                    $arrIDPool['HasChecked'][] = $data['customer_id'];
                }else{
                    $arrIDPool['NoChecked'][] = $data['customer_id'];
                }
            }
            
            if(count($arrIDPool['HasChecked'])>0){
                //更新客户表信息
                $iHasCustomerRtn = $customerBLL->UpdateData(array(
                    'is_del'=>1,
                    'update_uid'=>  $this->getUserId(),
                    'update_user_name'=>"{$this->getUserName()} {$this->getUserCNName()}",
                    'update_time'=>  Utility::Now()
                ), "customer_id in (".  implode(',', $arrIDPool['HasChecked']).")");
                //更新关系表信息
                $objCustomerAgentBLL = new CustomerAgentBLL();
                $iHasCustomerAgentRtn = $objCustomerAgentBLL->UpdateData(array(
                    'is_del'=>1,
                    'del_reason'=>$strDelReason,
                    'check_status'=>  CheckStatus::auditting
                ), "customer_id in (".  implode(',', $arrIDPool['HasChecked']).") and agent_id = {$this->getAgentId()}");
            }
            
            if(count($arrIDPool['NoChecked'])>0){
                $iCustomerRtn = $customerBLL->UpdateData(array(
                    'is_del'=>2,
                    'update_uid'=>  $this->getUserId(),
                    'update_user_name'=>"{$this->getUserName()} {$this->getUserCNName()}",
                    'update_time'=>  Utility::Now()
                ), "customer_id in (".  implode(',', $arrIDPool['NoChecked']).")");
                
                $objCustomerAgentBLL = new CustomerAgentBLL();
                $iCustomerAgentRtn = $objCustomerAgentBLL->UpdateData(array(
                    'is_del'=>2,
                    'del_reason'=>$strDelReason
                ), "customer_id in (".  implode(',', $arrIDPool['NoChecked']).") and agent_id = {$this->getAgentId()}");
            }
            if((isset ($iHasCustomerRtn) && $iHasCustomerRtn === false) ||(isset ($iHasCustomerAgentRtn) && $iHasCustomerAgentRtn === false)){
                Utility::Msg("提交删除审核申请失败");
            }
            if((isset ($iCustomerRtn) && $iCustomerRtn === false) || (isset ($iCustomerAgentRtn) && $iCustomerAgentRtn === false)){
                Utility::Msg("直接删除客户失败");
            }
            //生成删除记录
            $objCustomerLogInfo = new CustomerLogInfo();
            $objCustomerLogInfo->iAgentID = $this->getAgentId();
            $objCustomerLogInfo->iCreateUid = $this->getUserId();
            $objCustomerLogInfo->strCreateTime = Utility::Now();
            $objCustomerLogInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
            $objCustomerLogInfo->iCheckType = 3;
            $objCustomerLogInfo->iLogType = 1;
            $bFlag = true;
            foreach($arrCustomerInfo as $data){
                if($data['history_check'] == 0){
                    $objCustomerLogInfo->iCheckState = CheckStatus::notPost;
                }
                $objCustomerLogInfo->iCustomerId = $data['customer_id'];
                $iLogRtn = $objCustomerLogBLL->insert($objCustomerLogInfo);
                if($iLogRtn === false){
                    $bFlag = false;
                }
            }
            if(!$bFlag){
                Utility::Msg("生成删除记录失败");
            }
            
            Utility::Msg("删除成功",true);
        }
    }
    
    public function delFrontClient1()
    {
        $this->ExitWhenNoRight("showFrontInfoList", RightValue::del);
        $customerBLL = new CustomerBLL();
        $Tip = array();
        $user_id = parent::getUserId();
        $agent_id = parent::getAgentId();
        $cusId = Utility::isNullOrEmpty('listid', $_REQUEST);
        if ($cusId === false) {
            $Tip['success'] = false;
        } else { //判断是否有订单
            $customerBLL = new CustomerBLL();
            $A = $customerBLL->getOrder($cusId);
            //print_r($A);exit;
            if ($A != array()) {
                die("该客户已有订单,不能删除");
            }
            $customerBLL->delFrontClientData1($cusId, $user_id,$agent_id);
            $Tip['success'] = true;
        }
        echo json_encode($Tip);
    }

    //【前台】展现审核状态信息页面
    public function showCheckStatus()
    {
        $arrCheckStatusInfo = self::getCheckStatusInfo();
        // print_r($arrCheckStatusInfo);exit;
        $this->smarty->assign('arrCheckStatusInfo', $arrCheckStatusInfo);
        $this->displayPage("CM/CheckInformation.tpl");
    }

    //【前台】审核状态查询
    public function getCheckStatusInfo()
    {
        $agent_id = parent::getAgentId();
        $objCustomer = new CustomerBLL();
        $arrCheckStatus = $objCustomer->selCheckStatus($agent_id);

        return $arrCheckStatus;
        //echo json_encode(array('success'=>'true','info'=>array('state'=>"{$arrCheckStatus[0]['check_status_name']}","comment"=>"{$arrCheckStatus[0]['check_remark']}")));
    }

    //【前台】展现所属账号信息【用户信息卡片】
    public function showUserInformation()
    {
        $arrUserInformationInfo = self::getUserInformationInfo();
        $arrSuperiorInformationInfo = self::getSuperiorInformationInfo();
        //print_r($arrUserInformationInfo);exit;
        $this->smarty->assign('arrUserInformationInfo', $arrUserInformationInfo);

        $this->smarty->assign('arrSuperiorInformationInfo', $arrSuperiorInformationInfo);
        //print_r($arrSuperiorInformationInfo);exit;
        $this->displayPage("CM/UserInformationFront.tpl");
    }

    //【前台】展现所属账号信息查询【用户本身信息】
    public function getUserInformationInfo()
    {
        $objCustomer = new CustomerBLL();
        $arrUserInformation = $objCustomer->selUserInformation();
        //var_dump($arrUserInformation);exit;
        return $arrUserInformation;
    }

    //【前台】展现所属账号上级信息查询【为了上级姓名】
    public function getSuperiorInformationInfo()
    {
        $objCustomer = new CustomerBLL();
        $arrUserInformationInfo = self::getUserInformationInfo();
        //print_r($arrUserInformationInfo);exit;
        if (strlen($arrUserInformationInfo[0]['user_no']) <= 2) {
            return $arrSuperiorInformation = "木有上级";
        } else
            $superiorUser_no = substring($user_no, 0, -2);
        $arrSuperiorInformation = $objCustomer->selSuperiorInformation($superiorUser_no);
        return $arrSuperiorInformation;
    }

    //【前台】展现代理商用户【上级所有】信息
    public function showSuperiorInfor()
    {
        $objCustomer = new CustomerBLL();
        $user_no = Utility::GetForm('$arrUserInformationInfo.0.user_no', $_REQUEST);
        $arrUserInformationInfo = $objCustomer->selSuperioInfo($user_no);
        $this->smarty->assign('arrSuperiorInformationInfo', $arrSuperiorInformationInfo);
        //print_r($arrSuperiorInformationInfo);exit;
        $this->displayPage("CM/UserInformationFront.tpl");
    }

    //【前台】展现客户录入[跳转]
    public function showInsertFront()
    {
        $this->PageRightValidate("showFrontInfoList", RightValue::add);

        //模糊匹配出来的客户数据直接赋到该页面
        if (isset($_GET["mode"])) {
            self::getCustomerInfo();
        }

        $this->smarty->assign('strTitle','新增');
        $this->displayPage("CM/InsertFront.tpl");
    }

    //获取匹配客户的 信息 并导入到页面
    public function getCustomerInfo()
    {

        $customerID = $_GET["customer_id"];

        $customerBLL = new CustomerBLL();
        $arryInfo = $customerBLL->selectOnlyCustomer("*,(select industry_pid from `sys_industry` ind where ind.`industry_id`=cm.`industry_id`)as industry_pid",
            "cm.customer_id=" . $customerID, "");
         $area_id = $arryInfo[0]['reg_place'];
         if($area_id !="" && $area_id != -1){
          $AREAIDs = $customerBLL->getAllAREA($area_id);
          $arryInfo[0]['province_id1'] = $AREAIDs[0]['province_id'];
          $arryInfo[0]['city_id1'] = $AREAIDs[0]['city_id'];}
         // print_r($AREAIDs);exit;
        $arryContactInfo = $customerBLL->selectContact($customerID);// print_r($arryContactInfo);print_r($arryInfo);
        //exit;
        if (isset($arryInfo) && count($arryInfo) == 1) {
            $this->smarty->assign($arryInfo[0]);
            $this->smarty->assign($arryContactInfo[0]);
        }
    }


    //后台展现客户录入[跳转]
    public function showInsertBack()
    {
        $this->PageRightValidate("showBackInfoList", RightValue::add);
        $this->smarty->assign('strTitle', '新增');
        $this->displayPage("CM/Insert.tpl");
    }

    //展现客户编辑[跳转]
    public function showModifyBack()
    {
        $this->PageRightValidate("showBackInfoList", RightValue::edit);
        self::showCommonModify();
        $this->displayPage("CM/Insert.tpl");
    }

    //展现客户审核编辑[跳转]
    public function showVerifyModifyBack()
    {
        self::showCommonModify();
        $this->displayPage("CM/VerifyInsert.tpl");
    }

    public function showCommonModify()
    {
        if (isset($_GET["mode"])) //表示是新增时即时搜索跳转
            {
            $this->smarty->assign('strTitle', '新增');
        } else {
            $this->smarty->assign('strTitle', '编辑');
        }
        $customerID = $_GET["customer_id"];
        //insert into mysql
        $customerBLL = new CustomerBLL();
        $arryInfo = $customerBLL->selectOnlyCustomer("*,(select industry_pid from `sys_industry` ind where ind.`industry_id`=cm.`industry_id`)as industry_pid",
            "cm.customer_id=" . $customerID, "");
           if($arryInfo[0]['reg_place'] != -1 && $arryInfo[0]['reg_place'] != "" ){
           $pCityArea = $customerBLL->getPcArea($arryInfo[0]['reg_place']);
           // print_r($pCityArea);exit;
            $arryInfo[0]['city1'] = $pCityArea[0]['city_id'];
            $arryInfo[0]['province1'] = $pCityArea[0]['province_id'];}
            //print_r($arryInfo);exit;
        $arrcontact = $customerBLL->getContactNews($customerID);
        if (isset($arryInfo) && count($arryInfo) == 1) {
            $this->smarty->assign($arryInfo[0]);
            $this->smarty->assign("reg_date", CommonAction::GetDate($arryInfo[0]["reg_date"]));
        }
        if (isset($arrcontact) && count($arrcontact) == 1) {
            $this->smarty->assign($arrcontact[0]);
            $remark = str_replace(array("<BR/><BR/>", "<BR/>", "<br/>"), "\r", $arrcontact[0]["contact_remark"]);
            $this->smarty->assign("contact_remark", $remark);
        }
    }

    //展现客户资料明细[跳转]
    public function showDetail()
    {
        $this->smarty->assign('strTitle', '客户信息查看');
        $customerID = $_GET["customer_id"];
        //insert into mysql
        $customerBLL = new CustomerBLL();
        $arryInfo = $customerBLL->GetCustomerInfo($customerID);
        //var_dump($arryInfo);exit;
        //        if ($arryInfo($customer_from,$reg_status,$contact_importance,$contact_net_awareness)=-1){
        //        	$arryInfo($customer_from,$reg_status,$contact_importance,$contact_net_awareness)='';
        //        }
        //
        if (isset($arryInfo) && count($arryInfo) == 1) {
            $this->smarty->assign($arryInfo[0]);
            $remark = str_replace(array("<BR/><BR/>", "<BR/>", "<br/>"), "<BR/>", $arryInfo[0]["contact_remark"]);
            $this->smarty->assign("contact_remark", $remark);
            $this->smarty->assign("reg_date", CommonAction::GetDate($arryInfo[0]["reg_date"]));
            $this->displayPage("CM/Detail.tpl");
        }
    }
    //【前台】转移客户[弹出页面]
    public function frontTransfer()
    {
        // $this->PageRightValidate("showFrontInfoList",RightValue::v32);
        $this->smarty->display("CM/TransferFront.tpl");
    }

    //前台转移客户提交
    public function frontTransferSubmit()
    {
//        $customer_ids = Utility::isNullOrEmpty('listid', $_REQUEST);
//        $agent_id = parent::getAgentId();
//        $user_id = Utility::GetForm('userid', $_REQUEST);
//        $customerBLL = new CustomerBLL();
//        if ($customerBLL->transferFront($customer_ids, $agent_id,
//            $user_id, $this->getUserId()) > 0) {
//            exit('0');
//        } else {
//            exit('转移失败');
//        }
        $strCustomerIdList = Utility::GetForm("listid", $_REQUEST);
        $iUserID = Utility::GetFormInt("userid", $_REQUEST);
        if(empty ($strCustomerIdList))
            Utility::Msg ('请选择需要转移的客户');
        if(empty ($iUserID))
            Utility::Msg ("请选择需转入的账号");
        $objCustomerExBLL = new CustomerExBLL();
        $arrCustomerList = $objCustomerExBLL->getCustomerExListByCustomerID($strCustomerIdList, $this->getAgentId());
        $arrIdPool = array(
            'ProtectNo'=>array(),
            'Protect'=>array(),
            'Format'=>array()            
        );
        foreach($arrCustomerList as $arrCustomerItem){
            if($arrCustomerItem['defend_state'] == CustomerDefendState::HasOrderCustomer){
                $arrIdPool['Format'][] = $arrCustomerItem['customer_id'];
            }else{
                if($arrCustomerItem['record_count'] > 0){
                    $arrIdPool['Protect'][] = $arrCustomerItem['customer_id'];
                }else{
                    $arrIdPool['ProtectNo'][] = $arrCustomerItem['customer_id'];
                }
            }
        }
        $objCustomerBLL = new CustomerBLL();
        if($objCustomerBLL->transferFront($strCustomerIdList, $this->getAgentId(), $iUserID,  $this->getUserId())>0){
            $objDataConfigBLL = new DataConfigBLL();
            $bFalg = true;
            foreach($arrIdPool as $DefendType=>$arrIds){
                if(count($arrIds)>0){
                    if($DefendType == 'ProtectNo'){
                        $iDefendTime = $objDataConfigBLL->GetProtectTime_Protect_No_Record($this->getAgentId());
                        $iRtn = $objCustomerExBLL->UpdateToSeaTime($this->getAgentId(), Utility::addDay(Utility::Now(),$iDefendTime,false), implode(',', $arrIds), CustomerDefendState::DefendCustomer);
                    }elseif($DefendType == 'Protect'){
                        $iDefendTime = $objDataConfigBLL->GetProtectTime_Protect_Record($this->getAgentId());
                        $iRtn = $objCustomerExBLL->UpdateToSeaTime($this->getAgentId(), Utility::addDay(Utility::Now(),$iDefendTime,false), implode(',', $arrIds), CustomerDefendState::DefendCustomer);
                    }else{
                        $iDefendTime = $objDataConfigBLL->GetProtectTime_Formal($this->getAgentId());
                        $iRtn = $objCustomerExBLL->UpdateToSeaTime($this->getAgentId(), Utility::addDay(Utility::Now(),$iDefendTime,false), implode(',', $arrIds), CustomerDefendState::HasOrderCustomer);
                    }
                    if($iRtn === false){
                        $bFalg = false;
                    }
                }
            }
            if($bFalg){
                Utility::Msg("转移客户成功",true);
            }else{
                Utility::Msg("重置保护时间出错");
            }
        }else{
            Utility::Msg("转移客户失败");
        }
    }

    //【前台】转移客户模块匹配
    public function CompleteUserId()
    {
        $userName = Utility::GetForm('q', $_REQUEST);
        if($userName == "")
            exit("");
            
        $objUserBLL = new UserBLL();
        $sWhere = " agent_id=".$this->getAgentId()." and finance_no like '".$this->getFinanceNo()."%' and 
        (user_name like '%{$userName}%' or e_name like '%{$userName}%') ";        
        $arrEmployee = $objUserBLL->select("`user_id`,concat(`user_name`,'(',`e_name`,')') user_name",$sWhere,"finance_no,user_no,user_name");
        exit(json_encode(array('value' => $arrEmployee)));
    }

    //后台展现客户转移[弹出页面]
    public function showTransfer()
    {
        $this->PageRightValidate("showBackInfoList", RightValue::v512);
        $this->smarty->assign('strTitle', '客户转移记录');
        $this->displayPage("CM/Transfer.tpl");
    }

    //拉取客户
    public function import()
    {
        //添加到客户代理商关系表
        //审他妹啊！天天吃饱了没事干玩审核
        $iCustomerId = $_POST["customer_id"];
        $user_id = parent::getUserId();
        $agent_id = parent::getAgentId();
        if (CommonAction::IsExistCustomerInAgent($iCustomerId, $agent_id)) {
            die("该客户已被其他同事拉去,请选择其他客户名.");
        }
        $customerAgentInfo = new CustomerAgentInfo();
        $customerAgentInfo->iAgentId = $agent_id;
        $customerAgentInfo->iCustomerId = $iCustomerId;
        $customerAgentInfo->iUserId = $user_id;
        $customerAgentInfo->iCreateUid = $user_id;
        $customerAgentBLL = new CustomerAgentBLL();
        $customerAgentBLL->insert($customerAgentInfo);
        Alert::succeed();
    }

    //添加客户
    public function add()
    {
        $customerBLL = new CustomerBLL();
        //添加到客户表
        $area_id = Utility::GetForm("area_id", $_POST);
        $userId = parent::getUserId();
        //根据渠道经理绑定的区域进行录入匹配
        //$areaIds = $customerBLL->getUserAreaId($userId);
        //$areaID = "";
        //$ispipei = "";
        //foreach ($areaIds as $value) {
          //  $areaID = $value['area_id'];
           // if ($areaID == $area_id) {
             //   $ispipei = "匹配";
            //}
        //}
      // if ($ispipei == "匹配") {
            $AgContactInfo = new AgContactInfo();
            $customerInfo = self::getInfoFromPost();
            $AgContactInfo = self::getInfoFromPost();
            $customerInfo->iCreateUid = parent::getUserId();
            $AgContactInfo->iCreateUid = parent::getUserId();
           // print_r($AgContactInfo);exit;
            //$customerInfo->strCustomerNo = CommonAction::GetCustomerNo($customerInfo->iAreaId);
            $customerInfo->strCustomerNo = "";
            //insert into mysql
             //     var_dump($customerInfo);exit();
//            if (CommonAction::IsExistCustomerName($customerInfo->strCustomerName)) {
//                die("该客户名已存在,请输入其他客户名.");
//            }
            $customerBLL = new CustomerBLL();
            //判断是否存在该客户（cm_customer表is_del字段不等于2）
            $isNone = $customerBLL->NameIsNoneBackAdd($customerInfo->strCustomerName);
            if($isNone != array()){die("该客户名已存在,请输入其他客户名.");}
            
            $rtn = $customerBLL->insertINSERT($customerInfo);
            $customerBLL->updateCustomerNo($rtn);
            
            $objCustomerExInfo = new CustomerExInfo();
        $objCustomerExInfo->iAgentId = 0;
        $objCustomerExInfo->iCustomerId = $rtn;
        $objCustomerExInfo->iDefendState = CustomerDefendState::AddMyselfCustomer;
        $objCustomerExBLL = new CustomerExBLL();
        $iRtn = $objCustomerExBLL->insert($objCustomerExInfo);

        $res = $customerBLL->insert_contact($AgContactInfo, $rtn);
            //插入 代理商客户关系表
            $customerAgentInfo = new CustomerAgentInfo();
            $customerAgentBLL = new CustomerAgentBLL();
            $customerAgentInfo->iAgentId = 0;
            $customerAgentInfo->iCustomerId = $rtn;
            $customerAgentInfo->iUserId = $customerInfo->iCreateUid;
            $customerAgentInfo->iCustomerResource = CustomerResource::BackAdd;
            $customerAgentInfo->iCustomerResourcePerson = CustomerResourcePerson::SelfAdd;
            $customerAgentInfo->iCreateUid = $customerInfo->iCreateUid;
            $customerAgentInfo->iCheckStatus = 1;
            $customerAgentBLL->insert($customerAgentInfo);
            
            
            $objAddCusToBasicPlatAction = new AddCusToBasicPlatAction();
            $objAddCusToBasicPlatAction->AddCusToBasicPlat($customerInfo,"add",$rtn);
            Alert::succeed();
        //} else {
          //  die("2");
       // }
    }

    //【前台】添加客户 //【匹配出来的客户编辑也在】
    public function addFront()
    {
        $objCustomerExBLL = new CustomerExBLL();
        $iCustomerCount = $objCustomerExBLL->getCustomerCountByID($this->getUserId(), $this->getAgentId(), CustomerDefendState::AddMyselfCustomer);
        $iCustomerCount = $iCustomerCount[0]['num'];
        $objDataConfigBLL = new DataConfigBLL();
        $iMaxCount = $objDataConfigBLL->GetAllow_Count_Self($this->getAgentId());
        if($iMaxCount < ($iCustomerCount + 1)){
            die('已达自录客户最大容量');
        }

        //添加到客户表
        $customerInfo = self::getInfoFromPostFront();// print_r($customerInfo);exit;

      //print_r($customerInfo);exit;
        $iselProvince = Utility::GetFormInt('selProvince', $_POST);
        $iselCity = Utility::GetFormInt('selCity', $_POST);
        $iAreaId = Utility::GetFormInt('area_id', $_POST);
        $iAgentId = parent::getAgentId();
      // print_r($customerInfo->strRegPlace);exit;
        $pushCustomerId = Utility::GetFormInt('customer_id', $_POST); //如果是拉去过来的客户 $A != 0
        $this->CanViewTheCustomerInfo($pushCustomerId);
       //拉取的客户 比对修改的信息 提交审核 【↓开始】
       
        if ($pushCustomerId != 0) {
            //更新 代理商客户关系表【一个客户可以被%#多个%#代理商同时拥有】 同时改变客户的check_status 置为0
            $customerAgentInfo = new CustomerAgentInfo();
            $customerAgentBLL = new CustomerAgentBLL();
            $customerAgentInfo->iAgentId = parent::getAgentId();
            $customerAgentInfo->iCustomerId = $pushCustomerId;
            $customerAgentInfo->iUserId = parent::getUserId();
            $customerAgentInfo->iCreateUid =  Utility::GetFormInt('create_id', $_POST);
           
            $customerBLL = new CustomerBLL();
            //获取匹配拉取过来的客户信息
            $pushCustomerBefore = $customerBLL->GetPushCustomerBefore($pushCustomerId);
            //  print_r($pushCustomerBefore);exit;
            //if($customerInfo->strRegPlace != $pushCustomerBefore[0]['reg_place']){  die("2");}
             if($pushCustomerBefore[0]['reg_place'] == ""){$pushCustomerBefore[0]['reg_place'] = -1;}
            //循环比较客户信息修改的地方
            $keyValue = "{";
            foreach ($pushCustomerBefore[0] as $key => $value) {
                if ($key != "customer_resource") {
                    settype($value, "string");
                    $oldValue = $value;
                    $newValue = Utility::GetForm($key, $_POST); /** $key  从页面获取  */
                    if ($key == "contact_sex") { //防止0被过滤掉
                        $newValue = $_POST["contact_sex"];
                    }
                    if (self::isCompareKey($key) == true) {
                        if ($oldValue != $newValue) {
                            $keyValue .= "\"$key\":\"{$newValue}\",";
                        }
                    }
                }
            }
            if ($keyValue != "{") {
                $keyValue = substr($keyValue, 0, -1) . "}";
            } else {
                $keyValue = "{}";
            }
            if ($keyValue != "{}") {//print_r($keyValue);exit;
                die("2");
                              }
            $agContactBefore = new AgContactBLL();
            $contactID = Utility::GetFormInt('contact_id', $_POST);
            $agContactBefore = $agContactBefore->getContactFront($contactID,$this->getAgentId()); //修改之前的信息
            $keyValue = "{";
            foreach ($agContactBefore[0] as $key => $value) {
                settype($value, "string");
                $oldValue = $value;
                $newValue = Utility::GetForm($key, $_POST);
                if ($key == "contact_sex") { //防止0被过滤掉
                    $newValue = $_POST["contact_sex"];
                }
                if (self::isCompareKeyFrontPush($key) == true) {
                    if ($oldValue != $newValue) {
                        $keyValue .= "\"$key\":\"{$newValue}\",";
                    }
                }
            }
            if ($keyValue != "{") {
                $keyValue = substr($keyValue, 0, -1);
                $keyValue = $keyValue . ',"contact_id":"' . $agContactBefore[0]["contact_id"] .
                    '"';
                $keyValue = $keyValue . "}";
            } else {
                $keyValue = "{}";
            }
            if($keyValue != "{}")
            {//print_r($keyValue);exit;
                 die("2");

            }
            $agContactBefore[0]['agent_id'] = $customerAgentInfo->iAgentId;//print_r($agContactBefore[0]);exit;
            
            $customerAgentBLL->insertPush($customerAgentInfo);
            //负责人在拉取的时候 跟着拉取， 新添一条记录
            $customerAgentBLL->insertContact($agContactBefore[0]);
           //【↑结束】
           Alert::succeed();
        }

        //【前台】以下是新增客户时候操作
        $customerBLL = new CustomerBLL();
        $customerInfo->iCreateUid = parent::getUserId();
        $customerInfo->iCustomerResource = CustomerResource::FrontAdd;
        //$customerInfo->strCustomerNo = CommonAction::GetCustomerNo($customerInfo->iAreaId);
        //insert into mysql
        //var_dump($customerInfo);exit();
        //判断是否存在该客户（cm_customer表is_del字段不等于2）
        $isNone = $customerBLL->NameIsNoneBackAdd($customerInfo->strCustomerName);
        if($isNone != array()){die("该客户名已存在,请输入其他客户名.");}
//        if (CommonAction::IsExistCustomerName($customerInfo->strCustomerName)) {
//            die("该客户名已存在,请输入其他客户名.");
//        }
        $rtn = $customerBLL->insertFront($customerInfo);
        $customerBLL->updateCustomerNo($rtn); //更新客户NO 等于id
        
        $objCustomerExInfo = new CustomerExInfo();
        $objCustomerExInfo->iAgentId = $this->getAgentId();
        $objCustomerExInfo->iCustomerId = $rtn;
        $objCustomerExInfo->iDefendState = CustomerDefendState::AddMyselfCustomer;
        $iRtn = $objCustomerExBLL->insert($objCustomerExInfo);        

        //插入 代理商客户关系表
        //var_dump($rtn);exit;
        $customerAgentInfo = new CustomerAgentInfo();
        $customerAgentBLL = new CustomerAgentBLL();
        $customerAgentInfo->iAgentId = parent::getAgentId();
        $customerAgentInfo->iCustomerResource = CustomerResource::FrontAdd;
        $customerAgentInfo->iCustomerResourcePerson = CustomerResourcePerson::SelfAdd;
        $customerAgentInfo->iCustomerId = $rtn;
        //var_dump($customerAgentInfo->iCustomerId);exit;
        $customerAgentInfo->iUserId = $customerInfo->iCreateUid;
        $customerAgentInfo->iCreateUid = $customerInfo->iCreateUid;
       // print_r($customerAgentInfo);exit;
        $customerAgentBLL->insert($customerAgentInfo);

        //插入 客户代理商联系人信息表
        $AgContactInfo = new AgContactInfo();
        $AgContactBLL = new AgContactBLL();
        $AgContactInfo->iCustomerId = $rtn;
        // $AgContactInfo->isCharge = $customerInfo->iIsCharge;
        $AgContactInfo->iAgentId = parent::getAgentId();
        $AgContactInfo->strContactName = $customerInfo->strContactName;
        $AgContactInfo->iContactSex = $customerInfo->iContactSex;
        $AgContactInfo->strContactPosition = $customerInfo->strContactPosition;
        $AgContactInfo->strContactMobile = $customerInfo->strContactMobile;
        $AgContactInfo->strContactTel = $customerInfo->strContactTel;
        $AgContactInfo->strContactEmail = $customerInfo->strContactEmail;
        $AgContactInfo->strContactNetAwareness = $customerInfo->strContactNetAwareness;
        $AgContactInfo->strContactFax = $customerInfo->strContactFax;
        $AgContactInfo->strContactImportance = $customerInfo->strContactImportance;
        $AgContactInfo->strContactRemark = $customerInfo->strContactRemark;
        $AgContactInfo->iCreateUid = parent::getUserId();
        $AgContactInfo->iIscharge = 1;
        $AgContactBLL->insert($AgContactInfo);
        
        $objAddCusToBasicPlatAction = new AddCusToBasicPlatAction();
        $objAddCusToBasicPlatAction->AddCusToBasicPlat($customerInfo,"add",$rtn);

        Alert::succeed();
    }
    /**
     * 新的客户添加
     */
    public function AddCsutomerInfoFront(){
        if(!$this->HaveRight("showFrontInfoList", RightValue::add)){
            Utility::Msg("对不起，您没有权限");
        }
        $objCustomerExBLL = new CustomerExBLL();
        $iCustomerCount = $objCustomerExBLL->getCustomerCountByID($this->getUserId(), $this->getAgentId(), CustomerDefendState::AddMyselfCustomer);
        $iCustomerCount = $iCustomerCount[0]['num'];
        $objDataConfigBLL = new DataConfigBLL();
        $iMaxCount = $objDataConfigBLL->GetAllow_Count_Self($this->getAgentId());
        $bIsToSea = false;
        if ($iMaxCount < ($iCustomerCount + 1)) {
            $bIsToSea = true;
        }
        $objCustomerInfo = self::getInfoFromPostFront();
        $objCustomerInfo->iCustomerResource = CustomerResource::FrontAdd;
        $objCustomerInfo->iCreateUid = $this->getUserId();
        $objCustomerInfo->strCreateTime = Utility::Now();
        $objCustomerInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName();
        $objCustomerInfo->iUpdateUid = $this->getUserId();
        $objCustomerInfo->strUpdateTime = Utility::Now();
        $objCustomerInfo->strUpdateUserName = $this->getUserName()." ".$this->getUserCNName();
        
        $objCustomerInfo->iCheckStatus = CheckStatus::isPass;
        $objCustomerInfo->iCheckUid = $this->getUserId();
        $objCustomerInfo->strCheckTime = Utility::Now();
        $objCustomerInfo->strCheckUserName = $this->getUserName()." ".$this->getUserCNName();
        $objCustomerInfo->iHistoryCheck = 1;
        
        $objCustomerBLL = new CustomerBLL();
        $iCustomerRtn = $objCustomerBLL->insert($objCustomerInfo);
        if($iCustomerRtn <= 0){
            Utility::Msg("创建客户信息失败");
        }
        
        $objAddCusToBasicPlatAction = new AddCusToBasicPlatAction();
        $objAddCusToBasicPlatAction->AddCusToBasicPlat($objCustomerInfo,"add",$iCustomerRtn);
        
        $customerAgentInfo = new CustomerAgentInfo();
        $customerAgentBLL = new CustomerAgentBLL();
        $customerAgentInfo->iAgentId = parent::getAgentId();
        $customerAgentInfo->iCustomerResource = CustomerResource::FrontAdd;
        $customerAgentInfo->iCustomerResourcePerson = CustomerResourcePerson::SelfAdd;
        $customerAgentInfo->iCustomerId = $iCustomerRtn;
        //var_dump($customerAgentInfo->iCustomerId);exit;
        $customerAgentInfo->iUserId = $objCustomerInfo->iCreateUid;
        $customerAgentInfo->iCreateUid = $objCustomerInfo->iCreateUid;
        $customerAgentInfo->strCreateTime = Utility::Now();
                
        $customerAgentInfo->iCheckStatus = CheckStatus::isPass;
        $customerAgentInfo->iCheckUid = $this->getUserId();
        $customerAgentInfo->strCheckTime = Utility::Now();
        
       // print_r($customerAgentInfo);exit;
        $iCustomerAgentRtn = $customerAgentBLL->insert($customerAgentInfo);
        if($iCustomerAgentRtn===false){
            Utility::Msg("创建客户关系数据失败");
        }
        
        $objCustomerExInfo = new CustomerExInfo();
        $objCustomerExInfo->iAgentId = $this->getAgentId();
        $objCustomerExInfo->iCustomerId = $iCustomerRtn;
        $objCustomerExInfo->iDefendState = CustomerDefendState::AddMyselfCustomer;
        if($bIsToSea){
            $objCustomerExInfo->strToSeaTime = Utility::Now();
            $objCustomerExInfo->strShieldTime = Utility::Now();
        }else{
            $iDefendTime = $objDataConfigBLL->GetProtectTime_Self_No_Record($this->getAgentId());
            $objCustomerExInfo->strToSeaTime = Utility::addDay(Utility::Now(), $iDefendTime,false);
        }
        $iExRtn = $objCustomerExBLL->insert($objCustomerExInfo);  
        if($iExRtn === false){
            Utility::Msg("创建扩展数据失败");
        }
        
        $AgContactInfo = new AgContactInfo();
        $AgContactBLL = new AgContactBLL();
        $AgContactInfo->iCustomerId = $iCustomerRtn;
        // $AgContactInfo->isCharge = $customerInfo->iIsCharge;
        $AgContactInfo->iAgentId = parent::getAgentId();
        $AgContactInfo->strContactName = $objCustomerInfo->strContactName;
        $AgContactInfo->iContactSex = $objCustomerInfo->iContactSex;
        $AgContactInfo->strContactPosition = $objCustomerInfo->strContactPosition;
        $AgContactInfo->strContactMobile = $objCustomerInfo->strContactMobile;
        $AgContactInfo->strContactTel = $objCustomerInfo->strContactTel;
        $AgContactInfo->strContactEmail = $objCustomerInfo->strContactEmail;
        $AgContactInfo->strContactNetAwareness = $objCustomerInfo->strContactNetAwareness;
        $AgContactInfo->strContactFax = $objCustomerInfo->strContactFax;
        $AgContactInfo->strContactImportance = $objCustomerInfo->strContactImportance;
        $AgContactInfo->strContactRemark = $objCustomerInfo->strContactRemark;
        $AgContactInfo->iCreateUid = parent::getUserId();
        $AgContactInfo->iIscharge = 1;
        $iContactRtn = $AgContactBLL->insert($AgContactInfo);
        if($iContactRtn <= 0){
            Utility::Msg("创建负责人添失败");
        }
        
        $objCustomerLogInfo = new CustomerLogInfo();
        $objCustomerLogInfo->iCustomerId = $iCustomerRtn;
        $objCustomerLogInfo->iAgentID = $this->getAgentId();
        $objCustomerLogInfo->iCheckType = 1;
        $objCustomerLogInfo->iLogType = 1;
        $objCustomerLogInfo->strCreateTime = Utility::Now();
        $objCustomerLogInfo->iCreateUid = $this->getUserId();
        $objCustomerLogInfo->strCreateUserName = $objCustomerInfo->strCreateUserName;
        
        $objCustomerLogInfo->iCheckUid = $this->getUserId();
        $objCustomerLogInfo->strCheckTime = Utility::Now();
        $objCustomerLogInfo->strCheckUserName = $this->getUserName()." ".$this->getUserCNName();
        $objCustomerLogInfo->iCheckState = CheckStatus::isPass;
        
        $objCustomerLogBLL = new CustomerLogBLL();
        $iLogRtn = $objCustomerLogBLL->insert($objCustomerLogInfo);
        if($iLogRtn <= 0){
            Utility::Msg("创建客户失败");
        }        
        Utility::Msg("客户录入成功。".($bIsToSea?"因为已达客户最大容量限制，故该客户已流入公海":""),true,'/?d=CM&c=CMInfo&a=showFrontInfoList');
    }
    
//【前台】联系人修改记录时判断是否需要进行比对的键
    private function isCompareKeyFrontPush($key)
    {
        $arrNoCompareKeys = array("contact_id", "customer_id", "agent_id", "update_uid",
            "update_time", "create_uid", "create_time", "contact_net_awareness","isCharge","contact_id",
            "contact_importance");
        if (in_array($key, $arrNoCompareKeys)) {
            return false;
        } else {
            return true;
        }
    }
    ////比较录入客户地区是否是代理商地区内
    //     public function checkAreaFront()
    //     {
    //      $AreaIdInfo = Utility::GetFormInt('area_id', $_POST);
    //      $agent_id = parent::getAgentId();
    //      $customerBLL = new CustomerBLL();
    //      $Area= $customerBLL->getAreaId($agent_id,$AreaIdInfo);
    //
    //      if($Area == array()){exit("1");}
    //     }
    //修改客户
    public function modify()
    {
        //修改客户表
        $iCustomerId = $_POST["customer_id"];
        $AgContactInfo = new AgContactInfo();
        $customerInfo = new CustomerInfo();
        $AgContactInfo = self::getInfoFromPost();
        $customerInfo = self::getInfoFromPost();
        $customerInfo->iCustomerId = $iCustomerId;
        //判断是否存在该客户
//        if (CommonAction::IsExistCustomerNameExceptTheID($customerInfo->strCustomerName,
//            $customerInfo->iCustomerId)) {
//            die("该客户名已存在,请输入其他客户名.");
//        }
        $customerBLL = new CustomerBLL();
        //判断是否存在该客户（cm_customer表is_del字段不等于2）
        $isNone = $customerBLL->NameIsNone($customerInfo->strCustomerName,$iCustomerId);
        if($isNone != array()){die("该客户名已存在,请输入其他客户名.");}
        $customerInfo->iUpdateUid = parent::getUserId();
        //增加客户修改记录表
        $arryInfo = $customerBLL->GetOnlyCustomerInfo($iCustomerId);
        if (isset($arryInfo) && count($arryInfo) == 1) {
            //            //比对需要增加的键值对
            //            $keyValue = "{";
            //            foreach ($arryInfo[0] as $key => $value)
            //            {
            //                settype($value, "string");
            //                $oldValue = $value;
            //                $newValue = Utility::GetForm($key, $_POST);
            //                if ($key == "contact_sex")
            //                { //防止0被过滤掉
            //                    $newValue = $_POST["contact_sex"];
            //                }
            //                if (self::isCompareKey($key) == true)
            //                {
            //                    if ($oldValue != $newValue)
            //                    {
            //                        $keyValue .= "\"{$key}\":{\"oldValue\":\"{$oldValue}\",\"newValue\":\"{$newValue}\"},";
            //                    }
            //                }
            //            }
            //            if ($keyValue != "{")
            //            {
            //                $keyValue = substr($keyValue, 0, -1) . "}";
            //            }
            //            else
            //            {
            //                $keyValue = "{}";
            //            }
            
            
            //            if($keyValue != "{}"){
            //            //更新修改日志
            //            $customerLogInfo = new CustomerLogInfo();
            //            $customerLogInfo->iCustomerId = $iCustomerId;
            //            $customerLogInfo->strChangeValues = str_replace("<br /><br />","<br />",str_replace(array("<br /><br /><br />","<br /><br />","<br />"),"<br />",str_replace(array("\n\r","\n","\r","\t"),"<br />",$keyValue)));
            //            //妈的不是我想这么写的 都是mysql逼我的！！！
            //            $customerLogInfo->iCreateUid = parent::getUserId();
            //            $customerLogBLL = new CustomerLogBLL();
            //            $customerLogBLL->insert($customerLogInfo);
            //            }
            $objAddCusToBasicPlatAction = new AddCusToBasicPlatAction();
            $customerInfo->strCreateTime = $arryInfo[0]['create_time'];
            $objAddCusToBasicPlatAction->AddCusToBasicPlat($customerInfo,"mod",$iCustomerId,$arryInfo[0]['pub_id']);
            //更新客户表
            $res = $customerBLL->updateByID($customerInfo);
            $customerBLL->updataByID_Contact($AgContactInfo, $iCustomerId);
            Alert::succeed();
        } else {
            Alert::failed();
        }
    }

    //插入修改记录时判断是否需要进行比对的键
    private function isCompareKey($key)
    {
        $arrNoCompareKeys = array("customer_no", "check_status", "is_del", "update_uid",
            "update_time", "create_uid", "create_time", "check_uid", "check_time",
            "assign_check_id", "check_remark", "legal_person_name", "legal_person_id",
            "business_license", "history_check");
        if (in_array($key, $arrNoCompareKeys)) {
            return false;
        } else {
            return true;
        }
    }

    //从表单获取客户信息
    private function getInfoFromPost()
    {
        $t_Customer = new CustomerInfo();
        Alert::textIsEmpty($t_Customer->strCustomerName = Utility::GetForm('customer_name',
            $_POST), "客户名");
        Alert::noSelected($t_Customer->iAreaId = Utility::GetFormInt('area_id', $_POST),
            "地区");
        Alert::textIsEmpty($t_Customer->strAddress = Utility::GetForm('address', $_POST),
            "地区");
        Alert::noSelected($t_Customer->iIndustryId = Utility::GetFormInt('industry_id',
            $_POST), "行业"); //保存第二级别即可
        $t_Customer->strMainBusiness = Utility::GetForm('main_business', $_POST);
        $t_Customer->strMajorMarkets = Utility::GetForm('major_markets', $_POST);
        $t_Customer->strCompanyProfile = Utility::GetForm('company_profile', $_POST);
        $t_Customer->strCompanyScope = Utility::GetForm('company_scope', $_POST);
        $t_Customer->strRegStatus = Utility::GetForm('reg_status', $_POST);
        $t_Customer->strRegDate = Utility::GetForm('reg_date', $_POST);
        date_default_timezone_set("Asia/Shanghai");
        $a = time();
        $b = strtotime("$t_Customer->strRegDate");
        $c = $a - $b;
        if ($c < 0) {
            die("注册时间不能大于今天");
        }
        $t_Customer->strWebsite = Utility::GetForm('website', $_POST);
        $t_Customer->strPostcode = Utility::GetForm('postcode', $_POST);
        $t_Customer->strCustomerFrom = Utility::GetForm('customer_from', $_POST);
        Alert::noSelected($t_Customer->strBusinessModel = Utility::GetForm('business_model',
            $_POST), "经营模式");
        $t_Customer->strNetExtensionAbout = Utility::GetForm('net_extension_about', $_POST);
        $t_Customer->strBusinessScope = Utility::GetForm('business_scope', $_POST);
        $t_Customer->strAnnualSales = Utility::GetForm('annual_sales', $_POST);
        $t_Customer->strRegCapital = Utility::GetForm('reg_capital', $_POST);
        $t_Customer->strRegPlace = Utility::GetForm('reg_place', $_POST);
        Alert::textIsEmpty($t_Customer->strContactName = Utility::GetForm('contact_name',
            $_POST), "姓名");
        $t_Customer->iContactSex = Utility::GetFormInt('contact_sex', $_POST);
        $t_Customer->strContactMobile = Utility::GetForm('contact_mobile', $_POST);
        $t_Customer->strContactTel = Utility::GetForm('contact_tel', $_POST);
        $t_Customer->strContactEmail = Utility::GetForm('contact_email', $_POST);
        $t_Customer->strContactPosition = Utility::GetForm('contact_position', $_POST);
        $t_Customer->strContactNetAwareness = Utility::GetForm('contact_net_awareness',
            $_POST);
        $t_Customer->strContactFax = Utility::GetForm('contact_fax', $_POST);
        $t_Customer->strContactImportance = Utility::GetForm('contact_importance', $_POST);
        $t_Customer->strContactRemark = str_replace(array("\r\n", "\n", "\r"), "<BR/>",
            Utility::GetForm('contact_remark', $_POST));
        $objAreaBLL = new AreaBLL;
        $objAreaInfo = $objAreaBLL->getModelByID($t_Customer->iAreaId);
        if($objAreaInfo != null)
        {
            $t_Customer->iProvinceId = $objAreaInfo->iProvinceId;
            $t_Customer->iCityId = $objAreaInfo->iCityId;
            $t_Customer->strAreaName = $objAreaInfo->strAreaFullname;
        }
        
        $objIndustryBLL = new IndustryBLL();
        $objIndustryInfo = $objIndustryBLL->getModelByID($t_Customer->iIndustryId);
        if($objIndustryInfo != null)
        {
            $t_Customer->iIndustryPid = $objIndustryInfo->iIndustryPid;
            $t_Customer->strIndustryName = $objIndustryInfo->strIndustryFullName;
        }
                
        $t_Customer->iCheckStatus = 0; //Utility::GetFormInt('check_status', $_POST);
        return $t_Customer;
    }

    //从【前台】表单获取客户信息
    private function getInfoFromPostFront()
    {
        $t_Customer = new CustomerInfo();
        Alert::textIsEmpty($t_Customer->strCustomerName = Utility::GetForm('customer_name',
            $_POST), "客户名");

        Alert::noSelected($t_Customer->iAreaId = Utility::GetFormInt('area_id', $_POST),
            "地区");
        Alert::textIsEmpty($t_Customer->strAddress = Utility::GetForm('address', $_POST),
            "地区");
        Alert::noSelected($t_Customer->iIndustryId = Utility::GetFormInt('industry_id',
            $_POST), "行业"); //保存第二级别即可
        
        $objCustomerBLL = new CustomerBLL();
        $isNone = $objCustomerBLL->NameIsNoneBackAdd($t_Customer->strCustomerName);
        if ($isNone != array()) {
            Utility::Msg("客户名已存在");
        }
        $contact_mobile = Utility::GetForm('contact_mobile', $_POST);
        $objAgContactBLL = new AgContactBLL();
        if($contact_mobile != "" && $objAgContactBLL->IsExistContactPone($contact_mobile) == true)
            Utility::Msg("该客户已存在");
            
        $objAreaBLL = new AreaBLL;
        $objAreaInfo = $objAreaBLL->getModelByID($t_Customer->iAreaId);
        $t_Customer->iProvinceId = $objAreaInfo->iProvinceId;
        $t_Customer->iCityId = $objAreaInfo->iCityId;
        $t_Customer->strAreaName = $objAreaInfo->strAreaFullname;
        $objIndustryBLL = new IndustryBLL();
        $objIndustryInfo = $objIndustryBLL->getModelByID($t_Customer->iIndustryId);
        $t_Customer->iIndustryPid = $objIndustryInfo->iIndustryPid;
        $t_Customer->strIndustryName = $objIndustryInfo->strIndustryFullName;
        $t_Customer->strMainBusiness = Utility::GetForm('main_business', $_POST);
        $t_Customer->strMajorMarkets = Utility::GetForm('major_markets', $_POST);
        $t_Customer->strCompanyProfile = Utility::GetForm('company_profile', $_POST);
        $companyScope = Utility::GetForm('company_scope', $_POST);
        $a = preg_match("/[a-z]|[A-Z]/u", $companyScope);
        if ($a == 0) {
            $t_Customer->strCompanyScope = $companyScope;
        } else {
            Utility::Msg("公司规模中不允许出现英文字母");
        }
        //print_r($a); die("sss");
        //$t_Customer->strCompanyScope

        $t_Customer->strRegStatus = Utility::GetForm('reg_status', $_POST);
        $t_Customer->strRegDate = Utility::GetForm('reg_date', $_POST);
        date_default_timezone_set("Asia/Shanghai");
        $a = time();
        $b = strtotime("$t_Customer->strRegDate");
        $c = $a - $b;
        if ($c < 0) {
            Utility::Msg("注册时间不能大于今天");
        }
        $t_Customer->strWebsite = Utility::GetForm('website', $_POST);
        $t_Customer->strPostcode = Utility::GetForm('postcode', $_POST);
        $t_Customer->strCustomerFrom = Utility::GetForm('customer_from', $_POST);
        Alert::noSelected($t_Customer->strBusinessModel = Utility::GetForm('business_model',
            $_POST), "经营模式");
        $t_Customer->strNetExtensionAbout = Utility::GetForm('net_extension_about', $_POST);
        $t_Customer->strBusinessScope = Utility::GetForm('business_scope', $_POST);
        $annualSales = Utility::GetForm('annual_sales', $_POST);
        $a = preg_match("/[a-z]|[A-Z]/u", $annualSales);
        if ($a == 0) {
            $t_Customer->strAnnualSales = $annualSales;
        } else {
            Utility::Msg("年销售额中不允许出现英文字母");
        }

        $regCapital = Utility::GetForm('reg_capital', $_POST);
        $a = preg_match("/[a-z]|[A-Z]/u", $regCapital);
        if ($a == 0) {
            $t_Customer->strRegCapital = $regCapital;
        } else {
            Utility::Msg("注册资金中不允许英文字母");
        }


        $t_Customer->strRegPlace = Utility::GetForm('reg_place', $_POST);
        //Alert::textIsEmpty($t_Customer->strContactName = Utility::GetForm('contact_name',$_POST), "姓名");
        $t_Customer->strContactName = Utility::GetForm('contact_name', $_POST);
        $t_Customer->iContactSex = Utility::GetFormInt('contact_sex', $_POST);
        $t_Customer->strContactMobile = Utility::GetForm('contact_mobile', $_POST);
        $t_Customer->strContactTel = Utility::GetForm('contact_tel', $_POST);
        $t_Customer->strContactEmail = Utility::GetForm('contact_email', $_POST);
        $t_Customer->strContactPosition = Utility::GetForm('contact_position', $_POST);
        $t_Customer->strContactNetAwareness = Utility::GetForm('contact_net_awareness',
            $_POST);
        $t_Customer->strContactFax = Utility::GetForm('contact_fax', $_POST);
        $t_Customer->strContactImportance = Utility::GetForm('contact_importance', $_POST);
        $t_Customer->strContactRemark = str_replace(array("\r\n", "\n", "\r"), "<BR/>",
            Utility::GetForm('contact_remark', $_POST));
            
        $objAreaBLL = new AreaBLL;
        $objAreaInfo = $objAreaBLL->getModelByID($t_Customer->iAreaId);
        if($objAreaInfo != null)
        {
            $t_Customer->iProvinceId = $objAreaInfo->iProvinceId;
            $t_Customer->iCityId = $objAreaInfo->iCityId;
            $t_Customer->strAreaName = $objAreaInfo->strAreaFullname;
        }
        
        $objIndustryBLL = new IndustryBLL();
        $objIndustryInfo = $objIndustryBLL->getModelByID($t_Customer->iIndustryId);
        if($objIndustryInfo != null)
        {
            $t_Customer->iIndustryPid = $objIndustryInfo->iIndustryPid;
            $t_Customer->strIndustryName = $objIndustryInfo->strIndustryFullName;
        }
        
        $t_Customer->iCheckStatus = 0; //Utility::GetFormInt('check_status', $_POST);
        return $t_Customer;
    }

    //通过联系人名称 编号获取客户编号(名称)
    public function getContactName_ID()
    {
        $customer_id = Utility::GetForm("customer_id", $_GET);
        $contactName_ID = Utility::GetForm('q', $_GET);
        $customerBLL = new CustomerBLL();
        if (trim($contactName_ID) == "")
            exit("");
        $agent_id = parent::getAgentId();
        $arrayData = $customerBLL->getContactName_ID($contactName_ID, $customer_id,$agent_id);//print_r($arrayData);exit;
        exit(json_encode(array('value' => $arrayData)));
    }
    public function array_multi2single($A)
    {
        static $result_array = array();
        foreach ($A as $value) {
            if (is_array($value)) {
                self::array_multi2single($value);
            } else
                $result_array[] = $value;
        }
        return $result_array;
    }
    //通过客户名称 编号获取客户编号(名称)
    public function getCustomerName_IDFront()
    { //匹配出来的客户需要在代理商代理区域内【这里做区域限制】
        $agent_id = parent::getAgentId();
        //获取代理商的代理区域 N围数组
        $customerBLL = new CustomerBLL();
        $A = $customerBLL->selectAgentArea($agent_id);
//print_r($A);exit;
        $area = "";
        $arrayLength = count($A);
        for ($i = 0; $i < $arrayLength; $i++) {
            $area .= "," . $A[$i]["area"];
        }

        $area = substr($area, 1);
        $area = explode(',', $area);
        $area = array_unique($area);

        //print_r($A);exit;
        $_PCA = array();
        $p = "0";
        $c = "0";
        $a = "0";

        foreach ($area as $value) {
            if (strstr($value, 'p_')) {
                $arrID = explode('_', $value);
                $p .= ',' . $arrID[1];
            } else
                if (strstr($value, 'c_')) {
                    $arrID = explode('_', $value);
                    $c .= ',' . $arrID[1];
                } else //if(strstr($value,'a_'))
                {
                    $arrID = explode('_', $value);
                    $a .= ',' . $arrID[1];
                }
        }

        //从【系统地区表】获取该代理商所代理区域内 area_id 的总合
        $areaIDs = $customerBLL->getAllAreaId($p, $c);
        //将select出来的 省和市area_id重新组合
        $areaIDS = "";
        for ($i = 0; $i < count($areaIDs); $i++) {
            $areaIDS .= $areaIDs[$i]["area_id"] . ",";
        }

        $areaIDS = substr($areaIDS, 0, strlen($areaIDS) - 1);
        if ($areaIDS != "") {
            $areaIDS = $a . "," . $areaIDS;
        } else {
            $areaIDS = $a;
        }
        //print_r($areaIDS);exit;
        $customerName_ID = Utility::GetForm('q', $_GET);
        $customerBLL = new CustomerBLL();
        if (trim($customerName_ID) == "")
            exit("");
        $customerBLL = new CustomerBLL();
        $Agent_id = parent::getAgentId();
        //筛选出该代理商旗下的 所有客户id
        $customerIDs = $customerBLL->getAllCustomerId($Agent_id);
        $customerIDS = "";
        for ($i = 0; $i < count($customerIDs); $i++) {
            $customerIDS .= $customerIDs[$i]["customer_id"] . ",";
        }
        $customerIDS = substr($customerIDS, 0, strlen($customerIDS) - 1);//截取最后一个逗号之前的substr
        //print_r($customerIDS);exit;
        if($customerIDS != ""){
        $arrayData = $customerBLL->getCustomerName_IDFront($customerName_ID, $areaIDS, $Agent_id,$customerIDS);}
        else{$arrayData = $customerBLL->getCustomerName_IDFront1($customerName_ID, $areaIDS, $Agent_id);}
         //print_r($arrayData);exit;
        exit(json_encode(array('value' => $arrayData)));
    }

    /**
     * @functional 上传图片
     * @note ajax上传成功后 返回图片路劲
     * @author wzx
     */
    public function FileUpload()
    {
        //$dir = 'FrontFile/upload/customerPermit/';
        $dir = $this->arrSysConfig['UPFILE_PATH']['CUSTOMER_PERMIT'];
        $filePath = Utility::GetForm("upControl", $_GET);
        $strFileName = "";
        $msg = UploadFile::UploadJPGImg($filePath, $dir, $strFileName);
        $showImage = "/?a=ShowImage&filePath=CUSTOMER_PERMIT&fileName=".$strFileName;
        $arrayData = array("success" => false, "msg" => "");
        if ($msg == "") {
            $arrayData = array("success" => true, "msg" => $showImage);
        } else {
            $arrayData = array("success" => false, "msg" => $msg);
        }

        exit(json_encode($arrayData));
    }
    
    /**
     * 客户公海详细信息入口
     */
    public function showCustomerDetail(){
        $_GET['CanEdit'] = 10;
        $this->showDetailFront();
    }
    
    public  function showCustomerDetail4CustomerInfo(){
        $_GET['CanEdit'] = 5;
        $this->showDetailFront();
    }

    //展现 【前台】客户档案+联系人信息+联系小记 页面
    public function showDetailFront() {
        $this->smarty->assign('strTitle', '客户档案');
        $customerBLL = new CustomerBLL();
        $customer_id = Utility::GetFormInt('customer_id', $_GET);
        $this->CanViewTheCustomerInfo($customer_id);
        $customerFront = $customerBLL->getCustomerFront($customer_id,$this->getAgentId()); //print_r($customerFront);exit;
        if ($customerFront && $customerFront[0]['reg_place'] != "" && $customerFront[0]['reg_place'] != -1) {
            $reg_place = $customerBLL->getRegPlace($customerFront[0]['reg_place']); //print_r($reg_place);exit;
            $customerFront[0]['reg_place'] = $reg_place[0]['area_fullname'];
        }
        $this->smarty->assign('customerFront', $customerFront);
        if(count($customerFront)==0)
            exit("未找到客户信息");
        
        $agent_id = parent::getAgentId();
        //联系人列表
        $customerContactFront = $customerBLL->getcustomerContactFront($customer_id, $agent_id);
        $this->smarty->assign('customerContactFront', $customerContactFront);
        //联系小记列表
        $customerContactRecode = $customerBLL->getcustomerContactRecodeFront($customer_id, $agent_id);
        $time = date("Y-m-d H:i:s");
        
        $objOrderBLL = new OrderBLL();
        $arrOrderList = $objOrderBLL->getOrderInfoByCustomerID($customer_id,  $this->getAgentId());
        $this->smarty->assign("OrderList",$arrOrderList);
        
        $iCanEdit = Utility::GetFormInt("CanEdit", $_GET);
        $objCustomerAgentBLL = new CustomerAgentBLL();
        $arrayCustomerAgent = $objCustomerAgentBLL->select("customer_id"," customer_id=$customer_id and agent_id=$agent_id and user_id=".$this->getUserId(),"");
        if(!(isset($arrayCustomerAgent)&&count($arrayCustomerAgent)>0))
            $iCanEdit = 8;
        
        $this->smarty->assign("canedit", $iCanEdit);
        
        $valueProduct = 0;//签了增值产品 wzx
        $unitProduct = 0;//签了网盟产品 wzx
        $objProductTypeBLL = new ProductTypeBLL();
        $objSignProduct = $objProductTypeBLL->GetAgentSignedProductType($agent_id,true);
        foreach($objSignProduct as $key => $value) 
        {
            if($value["data_type"] == 1)
                $unitProduct = 1;
            else
                $valueProduct = 1;
                
            if($unitProduct == 1 && $valueProduct == 1)
                break;
        }
        
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrLogList = $objCustomerLogBLL->getCheckingLog($customer_id, 1,  $this->getAgentId());
        $this->smarty->assign("HasCheck",count($arrLogList)>0?1:0);
        $this->smarty->assign('valueProduct', $valueProduct);
        $this->smarty->assign('unitProduct', $unitProduct);
        $this->smarty->assign('customerContactRecode', $customerContactRecode);
        $this->smarty->assign('time', $time);
        $this->displayPage("CM/DetailFront.tpl");
    }

    //【前台】展现客户编辑[跳转]
    public function showFrontModify()
    {
        self::showCommonModify();
        $this->displayPage("CM/Insert.tpl");
    }

    //推荐客户管理
    public function showCustomerRecommend()
    {
        $this->PageRightValidate("showRecommendCustomer", RightValue::view);
        $strUrl = $this->getActionUrl('CM', 'CMInfo', 'showCustomerRecommendBody');
        $arrAssign = array('strUrl' => $strUrl);
        $customerBLL = new CustomerBLL();
        $countArry = $customerBLL->getNotTransferNum();
        if (isset($countArry['list']) && count($countArry['list']) == 1) {
            $this->smarty->assign("notTransfer", $countArry['list'][0]["transstat"]);
        } else {
            $this->smarty->assign("notTransfer", "0");
        }

        $this->objProductTypeBLL = new ProductTypeBLL();
        $arrProductType = $this->objProductTypeBLL->GetAgentSignedProductType($this->getAgentId());//调用WZX函数 获取已签约的产品
        //print_r($arrProductType);exit;
        //$arrProductType = $this->objProductTypeBLL->getHasSignProduct($this->getAgentId()); print_r($arrProductType);exit;
        $newType = array();
        foreach ($arrProductType as $key => $type) {
            $newType[$key]['key'] = $type['aid'];
            $newType[$key]['value'] = $type['product_type_name'];
        }
        $arrJsonType = json_encode($newType);
        $this->smarty->assign('arrJsonType', $arrJsonType);

        $this->displayPage("CM/CustomerRecommed.tpl", $arrAssign);
    }

    //推荐客户管理
    public function showCustomerRecommendBody()
    {
        $strWhere = " and E.agent_id =".$this->getAgentId()." and E.finance_uid = ".$this->getFinanceUid()." ";
        //      $strWhere = "and E.user_id=" . $this->getUserId() . " "; //上面注释掉 用这句
        $customeName = Utility::GetForm("customerName", $_GET);
        if ($customeName != "")
            $strWhere .= " and A.customer_name like '%$customeName%' ";

        $editTimeS = Utility::GetForm("editTimeS", $_GET);
        $editTimeE = Utility::GetForm("editTimeE", $_GET);

        if ($editTimeS != "" && $editTimeE != "")
            $strWhere .= " and A.create_time >= '$editTimeS 00:00:00' and A.create_time <= '$editTimeE 23:59:59' ";
        //GetFormInt 取的一定是数字，
        $industry_pid = Utility::GetFormInt("industry_pid", $_GET);
        $industry_id = Utility::GetFormInt("industry_id", $_GET);
        if ($industry_pid > 0)
            $strWhere .= " and B.industry_pid=$industry_pid ";
        if ($industry_id > 0)
            $strWhere .= " and B.industry_id=$industry_id ";

        $pri = Utility::GetFormInt("pri", $_GET);
        if ($pri > 0)
            $strWhere .= " and C.province_id =$pri ";

        $city = Utility::GetFormInt("city", $_GET);
        if ($city > 0)
            $strWhere .= " and C.city_id=$city ";

        $area = Utility::GetForm("area", $_GET);
        if ($area != -1 && $area != "")
            $strWhere .= " and C.area_id=$area ";

        $source = Utility::GetForm("source", $_GET);
        if ($source != 0)
            $strWhere .= " and E.customer_resource = $source ";

      //    $inten_product = Utility::GetForm("inten_product", $_GET);
       // print_r($inten_product);exit;
         
        $product = Utility::GetForm("pro", $_GET);
        
        if ($product != "") {
            $strWhere .= " and (";
            $arrPro = explode(",", $product);
            foreach ($arrPro as $strPro) {
                $strWhere .= "inten.intention_name_id like '%$strPro%' or ";
            }
            $strWhere = substr($strWhere, 0, -3);
            $strWhere .= ")";
        }
        //print_r($strWhere);exit;
        $user_no = parent::getUserNo();
        $customerBLL = new CustomerBLL();
        $arrPageList = $customerBLL->getRecommendList($strWhere, $user_no);
        $this->showPageSmarty($arrPageList, "CM/CustomerRecommendBody.tpl");
    }

    //【前台】客户信息编辑
    public function showModifyFront()
    {
        self::showCommonModify1();
        $canModifyCustomerName = 0;
        if($this->HaveRight("showFrontInfoList",RightValue::v1024)==true)
            $canModifyCustomerName = 1;
            
        $this->smarty->assign('canModifyCustomerName',$canModifyCustomerName);
        $this->displayPage("CM/InsertCustomer.tpl");
    }

    //【前台】客户信息编辑页面导入信息
    public function showCommonModify1()
    {
        if (isset($_GET["mode"])) //表示是新增时即时搜索跳转
            {
            $this->smarty->assign('strTitle', '新增客户');
        } else {
            $this->smarty->assign('strTitle', '编辑客户');
        }
        $customerID = Utility::GetFormInt("customer_id",$_GET);
        $this->CanViewTheCustomerInfo($customerID);
        //insert into mysql
        $customerBLL = new CustomerBLL();
        $arryInfo = $customerBLL->selectOnlyCustomer("*,(select industry_pid from `sys_industry` ind where ind.`industry_id`=cm.`industry_id`)as industry_pid",
            "cm.customer_id=" . $customerID, "");
        if($arryInfo[0]['reg_place'] != "" && $arryInfo[0]['reg_place'] != -1){
        $PcArea = $customerBLL->getPcArea($arryInfo[0]['reg_place']);
        $arryInfo[0]['selProvince1'] = $PcArea[0]['province_id'];
        $arryInfo[0]['selCity1'] = $PcArea[0]['city_id'];}
        
        //print_r($arryInfo);exit;
        if (isset($arryInfo) && count($arryInfo) == 1) {
           // print_r($arryInfo);exit;
            $this->smarty->assign($arryInfo[0]);
        }
    }

    //【前台】修改客户信息
    public function modify1()
    {
        $iCustomerID = Utility::GetFormInt("customer_id", $_POST);
        $this->CanViewTheCustomerInfo($iCustomerID);
        $strCustomerName = Utility::GetForm("customer_name", $_POST);
        if(empty ($strCustomerName))
            Utility::Msg ("请填写用户名称");
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrCheckingLog = $objCustomerLogBLL->getCheckingLog($iCustomerID, 1,  $this->getAgentId());
        if($arrCheckingLog)
            Utility::Msg ("存在正在审核中的申请，不能再次修改");
        $arrChangeValue = array();
        $objCustomerInfo = $this->getInfoFromPost1($iCustomerID,&$arrChangeValue);
        if(!$objCustomerInfo)
            Utility::Msg ("获取客户信息失败");
        
        $objCustomerBLL = new CustomerBLL();
        $iCustomerRtn = $objCustomerBLL->updateByID($objCustomerInfo);
        if($iCustomerRtn === false){
            Utility::Msg("修改客户信息失败");
        }
        $objCustomerLogInfo = new CustomerLogInfo();
        $objCustomerLogInfo->iCustomerId = $iCustomerID;
        $objCustomerLogInfo->iAgentID = $this->getAgentId();
        $objCustomerLogInfo->strCreateTime = Utility::Now();
        $objCustomerLogInfo->strChangeValues = !empty ($arrChangeValue)? '{'.  implode(',', $arrChangeValue).'}':'';
        $objCustomerLogInfo->iCreateUid = $this->getUserId();
        $objCustomerLogInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objCustomerLogInfo->iCheckState = ($strCustomerName != $objCustomerInfo->strCustomerName)? CheckStatus::auditting  :  CheckStatus::isPass;
        $objCustomerLogInfo->iCheckType = 2;
        $objCustomerLogInfo->iLogType = 1;
        $iLogRtn = $objCustomerLogBLL->insert($objCustomerLogInfo);
        if ($iLogRtn === false) {
            Utility::Msg("提交客户审核申请失败");
        }
        
        $objCustomerAgentBLL = new CustomerAgentBLL();
        if($strCustomerName != $objCustomerInfo->strCustomerName){            
            $iAgentRtn = $objCustomerAgentBLL->UpdateData(array(
                'check_status'=>  CheckStatus::auditting
            ), "customer_id={$iCustomerID} and agent_id = {$this->getAgentId()}");
            
            if($iAgentRtn === false){
                Utility::Msg("初始化审核数据失败");
            }
            Utility::Msg("客户修改申请提交成功",true);
        }else{
            $objCustomerAgentBLL->UpdateData(array(
                'check_status'=>  CheckStatus::isPass
            ), "customer_id={$iCustomerID} and agent_id = {$this->getAgentId()}");
            Utility::Msg("客户修改成功",true);
        }
        
//        //修改客户表
//        $iCustomerId = $_POST["customer_id"];
//        $customerInfo = self::getInfoFromPost1($iCustomerId);//print_r($customerInfo);exit;
//        $customerInfo->iCustomerId = $iCustomerId;
//        //判断是否存在该客户
////        if (CommonAction::IsExistCustomerNameExceptTheID($customerInfo->strCustomerName, $customerInfo->iCustomerId)
////           ) {
////            die("该客户名已存在,请输入其他客户名.");
////        }//由于客户可以同时属于很多代理商，修改客户信息的时候判断名称是否重复去cm_customer表查的时候 出现重复名字，但不属于该代理商，
//        //判断该客户是否是新增，并且还未经过审核
//        $customerBLL = new CustomerBLL();
//        //判断是否存在该客户（cm_customer表is_del字段不等于2）
//        $isNone = $customerBLL->NameIsNone($customerInfo->strCustomerName,$iCustomerId);
//        if($isNone != array()){die("该客户名已存在,请输入其他客户名.");}
//        $customerInfo->iUpdateUid = parent::getUserId();
//        $agent_id = parent::getAgentId();
//        $a = $customerBLL->getCustomerStatus($iCustomerId,$agent_id);//print_r($agent_id);exit;
//        $a = $a[0];
//        
//        $objAddCusToBasicPlatAction = new AddCusToBasicPlatAction();
//        $customerInfo->strCreateTime = Utility::Now();
//        $objAddCusToBasicPlatAction->AddCusToBasicPlat($customerInfo,"mod",$customerInfo->iCustomerId,$customerInfo->iPubId);
//        
//        $arryInfo = $customerBLL->GetOnlyCustomerInfo($iCustomerId);
//        if ($arryInfo) {
//            //若客户名称未改变，则所有信息直接修改。若客户名称改变且是已发起审核（未发起审核的客户不是正式客户）的客户，则所有信息存入修改记录，审核通过后修改        
//            if ($arryInfo[0]['customer_name'] != $customerInfo->strCustomerName && $a["check_status"] != 0 && $a["check_uid"] != 0) {
//                //审核
//                $keyValue = "{";
//                foreach ($arryInfo[0] as $key => $value) {
//                    if ($key != "customer_resource") {
//                        settype($value, "string");
//                        $oldValue = $value;
//                        $newValue = Utility::GetForm($key, $_POST);
//                        if ($key == "contact_sex") { //防止0被过滤掉
//                            $newValue = $_POST["contact_sex"];
//                        }
//                        if ($oldValue != $newValue) {
//                            $keyValue .= "\"$key\":\"{$newValue}\",";
//                        }
//                    }
//                }
//                if ($keyValue != "{") {
//                    $keyValue = substr($keyValue, 0, -1) . "}";
//                } else {
//                    $keyValue = "{}";
//                }
//                if ($keyValue != "{}") {
//                    $keyValue = '{"customer":' . $keyValue . '}';
//                    //更新修改日志cm_customer_log
//                    $customerLogInfo = new CustomerLogInfo();
//                    $customerLogInfo->iCustomerId = $iCustomerId;
//                    $customerLogInfo->strChangeValues = $keyValue;
//                    $customerLogInfo->iCreateUid = parent::getUserId();
//                    $customerLogInfo->iAgentId = parent::getAgentId();
//                    $customerLogBLL = new CustomerLogBLL();
//                    $customerAgentBLL = new CustomerAgentBLL();
//                    $customerAgentBLL->updateCustomerCheckStatus($iCustomerId);
//                    $iRtn = $customerLogBLL->insert1($customerLogInfo);
//                    if($iRtn>0){
//                        Alert::succeed();
//                    }else{
//                        Alert::failed();
//                    }    
//                }
//            } else {
//                //直接修改
//                $iRtn = $customerBLL->updateByID($customerInfo);
//                if ($iRtn !== false) {
//                    Alert::succeed();
//                } else {
//                    Alert::failed();
//                }
//            }
//        }
//        if ($a["check_status"] == 0 && $a["check_uid"] == 0) {
//            //【新增客户审核中进行修改：直接改数据库表】
//            $customerBLL = new CustomerBLL();
//            $customerBLL->updateCustomer($customerInfo);
//            Alert::succeed();
//        }
    }

    //【前台】从表单获取客户修改信息
    private function getInfoFromPost1($iCustomerID,&$arrChangeValue)
    {
        $objCustomerBLL = new CustomerBLL();
        $objCustomerInfo = $objCustomerBLL->getModelByID($iCustomerID);
        if  ($objCustomerInfo) {
            $strCustomerName = Utility::GetForm("customer_name", $_POST);
            $iIsName = $objCustomerBLL->NameIsNone($strCustomerName, $iCustomerID);
            if ($strCustomerName != $objCustomerInfo->strCustomerName && $iIsName != array()) {
                Utility::Msg("客户名已存在");
            }
            $arrChangeValue = $this->getPostInfo($strCustomerName, &$objCustomerInfo->strCustomerName, $arrChangeValue, 'customer_name',CustomerBLL::$_NeedCheckField);
        
            $iAreaID = Utility::GetFormInt('area_id', $_POST);
            if(empty ($iAreaID))
                Utility::Msg ("请选择地区");
            if($objCustomerInfo->iAreaId !=$iAreaID){
                $arrChangeValue[] = '"area_id":{"oldValue":"'.$objCustomerInfo->iAreaId.'","newValue":"'.$iAreaID.'"}';
                if (!in_array('area_id', CustomerBLL::$_NeedCheckField)) {
                    $objAreaBLL = new AreaBLL();
                    $objAreaInfo = $objAreaBLL->getModelByID($iAreaID);
                    $objCustomerInfo->iAreaId = $iAreaID;
                    $objCustomerInfo->iProvinceId = $objAreaInfo->iProvinceId;
                    $objCustomerInfo->iCityId = $objAreaInfo->iCityId;
                    $objCustomerInfo->strAreaName = $objAreaInfo->strAreaFullname;
                }
            }
            
            $iIndustyID = Utility::GetFormInt('industry_id', $_POST);
            if(empty ($iIndustyID))
                Utility::Msg ("请选择行业");
            if($objCustomerInfo->iIndustryId != $iIndustyID){
                $arrChangeValue[] = '"industry_id":{"oldValue":"' . $objCustomerInfo->iIndustryId . '","newValue":"' . $iIndustyID . '"}';
                if (!in_array('industry_id', CustomerBLL::$_NeedCheckField)) {
                    $objIndustryBLL = new IndustryBLL();
                    $objIndustryInfo = $objIndustryBLL->getModelByID($iIndustyID);
                    $objCustomerInfo->iIndustryId = $iIndustyID;
                    $objCustomerInfo->iIndustryPid = $objIndustryInfo->iIndustryPid;
                    $objCustomerInfo->strIndustryName = $objIndustryInfo->strIndustryFullName;
                }
            }
          
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("main_business",$_POST), &$objCustomerInfo->strMainBusiness, $arrChangeValue, 'main_business',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("major_markets",$_POST), &$objCustomerInfo->strMajorMarkets, $arrChangeValue, 'major_markets',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("company_profile",$_POST), &$objCustomerInfo->strCompanyProfile, $arrChangeValue, 'company_profile',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("company_scope",$_POST), &$objCustomerInfo->strCompanyScope, $arrChangeValue, 'company_scope',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("reg_status",$_POST), &$objCustomerInfo->strRegStatus, $arrChangeValue, 'reg_status',CustomerBLL::$_NeedCheckField);
            $strRegDate = Utility::GetForm("reg_date",$_POST);
            if($strRegDate > date('Y-m-d')){
                Utility::Msg("注册时间不能大于今天");
            }
            $arrChangeValue = $this->getPostInfo($strRegDate, &$objCustomerInfo->strRegDate, $arrChangeValue, 'reg_date',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("website",$_POST), &$objCustomerInfo->strWebsite, $arrChangeValue, 'website',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("postcode",$_POST), &$objCustomerInfo->strPostcode, $arrChangeValue, 'postcode',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("customer_from",$_POST), &$objCustomerInfo->strCustomerFrom, $arrChangeValue, 'customer_from',CustomerBLL::$_NeedCheckField);
            $strBUsinessModel = Utility::GetForm("business_model",$_POST);
            if(empty ($strBUsinessModel)){
                Utility::Msg('请选择经营模式');
            }
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("business_model",$_POST), &$objCustomerInfo->strBusinessModel, $arrChangeValue, 'business_model',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("net_extension_about",$_POST), &$objCustomerInfo->strNetExtensionAbout, $arrChangeValue, 'net_extension_about',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("business_scope",$_POST), &$objCustomerInfo->strBusinessScope, $arrChangeValue, 'business_model',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("annual_sales",$_POST), &$objCustomerInfo->strAnnualSales, $arrChangeValue, 'annual_sales',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("reg_capital",$_POST), &$objCustomerInfo->strRegCapital, $arrChangeValue, 'reg_capital',CustomerBLL::$_NeedCheckField);
            $arrChangeValue = $this->getPostInfo(Utility::GetForm("reg_place",$_POST), &$objCustomerInfo->strRegPlace, $arrChangeValue, 'reg_place',CustomerBLL::$_NeedCheckField);
            
            return $objCustomerInfo;
        }
        return false;
        
//        $objCustomerBLL = new CustomerBLL();
//        if(empty ($iCustomerID)){
//            $t_Customer = new CustomerInfo();
//        }else{
//            $t_Customer = $objCustomerBLL->getModelByID($iCustomerID);
//        }
//        
//        Alert::noSelected($t_Customer->iAreaId = Utility::GetFormInt('area_id', $_POST),
//            "地区");
//        Alert::textIsEmpty($t_Customer->strAddress = Utility::GetForm('address', $_POST),
//            "地区");
//        Alert::noSelected($t_Customer->iIndustryId = Utility::GetFormInt('industry_id',
//            $_POST), "行业"); //保存第二级别即可
//        
//        $t_Customer->strMainBusiness = Utility::GetForm('main_business', $_POST);
//        $t_Customer->strMajorMarkets = Utility::GetForm('major_markets', $_POST);
//        $t_Customer->strCompanyProfile = Utility::GetForm('company_profile', $_POST);
//        $t_Customer->strCompanyScope = Utility::GetForm('company_scope', $_POST);
//        $t_Customer->strRegStatus = Utility::GetForm('reg_status', $_POST);
//        $t_Customer->strRegDate = Utility::GetForm('reg_date', $_POST);
//        date_default_timezone_set("Asia/Shanghai");
//        $a = time();
//        $b = strtotime("$t_Customer->strRegDate");
//        $c = $a - $b;
//        if ($c < 0) {
//            //die("注册时间不能大于今天");
//            Utility::Msg("注册时间不能大于今天");
//        }
//        $t_Customer->strWebsite = Utility::GetForm('website', $_POST);
//        $t_Customer->strPostcode = Utility::GetForm('postcode', $_POST);
//        $t_Customer->strCustomerFrom = Utility::GetForm('customer_from', $_POST);
//        Alert::noSelected($t_Customer->strBusinessModel = Utility::GetForm('business_model',
//            $_POST), "经营模式");
//        $t_Customer->strNetExtensionAbout = Utility::GetForm('net_extension_about', $_POST);
//        $t_Customer->strBusinessScope = Utility::GetForm('business_scope', $_POST);
//        $t_Customer->strAnnualSales = Utility::GetForm('annual_sales', $_POST);
//        $t_Customer->strRegCapital = Utility::GetForm('reg_capital', $_POST);
//        $t_Customer->strRegPlace = Utility::GetForm('reg_place', $_POST);
//        $t_Customer->iCheckStatus = 0; //Utility::GetFormInt('check_status', $_POST);
//        return $t_Customer;
    }
    
    private function getPostInfo($NewValue,&$OldValue,$ChangeValue,$key,$arrCheckField,$bIsChange = true){
        if($NewValue != $OldValue){
            $ChangeValue[]='"'.$key.'":{"oldValue":"'.$OldValue.'","newValue":"'.$NewValue.'"}';
            if (!$bIsChange || !in_array($key, $arrCheckField)) {
                $OldValue = $NewValue;
            }
        }
        return $ChangeValue;
    }

    //【前台】添加客户联系人页面
    public function showContactInfo()
    {
        $customerID = Utility::GetForm('customer_id', $_GET);
        $this->smarty->assign("customer_id", $customerID);
        $this->displayPage("CM/ContactInfo.tpl");
    }

    //【前台】添加联系人
    public function addContactFront()
    {
        $contactInfo = new AgContactInfo();
        $contactInfo = self::getContactFront();
        $agContactBLL = new AgContactBLL();
        $AgContactInfo = $contactInfo;
        //var_dump($AgContactInfo);exit;
        $iContactRtn = $agContactBLL->insert($AgContactInfo);
        if($iContactRtn == false){
            die("生成联系人信息失败");
        }
        
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogInfo = new CustomerLogInfo();
        $objCustomerLogInfo->iCustomerId = $AgContactInfo->iCustomerId;
        $objCustomerLogInfo->iAgentID = $AgContactInfo->iAgentId;
        $objCustomerLogInfo->iContactId = $iContactRtn;
        $objCustomerLogInfo->iCreateUid = $this->getUserId();
        $objCustomerLogInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objCustomerLogInfo->strCreateTime = Utility::Now();
        $objCustomerLogInfo->iCheckState = CheckStatus::isPass;//CheckStatus::notPost;
        $objCustomerLogInfo->iLogType = 2;
        $objCustomerLogInfo->iCheckType = CustomerLogCheckType::Add;
        $iLogRtn = $objCustomerLogBLL->insert($objCustomerLogInfo);
        if($iLogRtn === false){
            die("生成日志失败");
        }
        die("1");
    }

    //【前台】获取添加联系人 表单信息
    private function getContactFront()
    {
        $t_Contact = new AgContactInfo();
        $t_Contact->strContactName = Utility::GetForm('contact_name', $_POST);
        $t_Contact->iIscharge = 0;
        $t_Contact->iContactSex = Utility::GetFormInt('contact_sex', $_POST);
        $t_Contact->strContactMobile = Utility::GetForm('contact_mobile', $_POST);
        $t_Contact->strContactTel = Utility::GetForm('contact_tel', $_POST);
        $t_Contact->strContactEmail = Utility::GetForm('contact_email', $_POST);
        $t_Contact->strContactPosition = Utility::GetForm('contact_position', $_POST);
        $t_Contact->strContactNetAwareness = Utility::GetForm('contact_net_awareness', $_POST);
        $t_Contact->strContactFax = Utility::GetForm('contact_fax', $_POST);
        $t_Contact->strContactImportance = Utility::GetForm('contact_importance', $_POST);
        $t_Contact->strContactRemark = Utility::GetForm('contact_remark', $_POST);
        $t_Contact->iAgentId = parent::getAgentId();
        $t_Contact->iCustomerId = Utility::GetFormInt('customer_id', $_POST);
        $t_Concatc->iContactSex = Utility::GetForm('ContactSex', $_POST);
        return $t_Contact;
    }

    //【前台】编辑联系人信息页面
    public function showModifyContact()
    {
        $contactID = Utility::GetFormInt('contact_id', $_GET);
        $this->smarty->assign('contact_id', $contactID);
        self::showModifyContact1();
        $this->displaypage("CM/ContactModify.tpl");
    }

    //【前台】获取和导入联系人信息
    public function showModifyContact1()
    {
        $contactID = Utility::GetFormInt('contact_id', $_GET);
        $agContactBLL = new AgContactBLL();
        $arrContact = $agContactBLL->getContactFront($contactID,$this->getAgentId());
        //print_r($arrContact);exit;
        if(isset($arrContact)&&count($arrContact)>0)
            $this->smarty->assign($arrContact[0]);
    }

    //【前台】编辑联系人信息
    public function modifyContact()
    {
        $iContactID = Utility::GetFormInt('contact_id', $_POST);
        $arrChangeValue = array();
        $agContactInfo = self::getContactModify($iContactID,&$arrChangeValue); //修改后的信息
        $objAgContactBLL = new AgContactBLL();
        
        $isCharge = Utility::GetForm('isCharge', $_POST);
        if(empty ($isCharge)){
            $isCharge = 0;
        }
        $bNeedCheck = false;
        if($agContactInfo->iIscharge == 1 || $isCharge == 1){
            $bNeedCheck = true;
        }
        if($isCharge == 1){
            $arrChangeValue[] = '"isCharge":{"oldValue":"0","newValue":"1"}';
        }
        
        $agContactInfo->strUpdateTime = Utility::Now();
        $agContactInfo->iUpdateUid = $this->getUserId();
        if($bNeedCheck){
            $agContactInfo->iCheckState = CheckStatus::auditting;
        }
        $iContactRtn = $objAgContactBLL->updateByID($agContactInfo);
        if($iContactRtn === false){
            Utility::Msg("修改用户信息失败");
        }
        
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogInfo = new CustomerLogInfo();
        $objCustomerLogInfo->iCustomerId = $agContactInfo->iCustomerId;
        $objCustomerLogInfo->iAgentID = $this->getAgentId();
        $objCustomerLogInfo->iContactId = $agContactInfo->iContactId;
        $objCustomerLogInfo->strChangeValues = count($arrChangeValue)>0?'{'.implode(',', $arrChangeValue).'}':'';
        $objCustomerLogInfo->iCheckType = 2;
        $objCustomerLogInfo->iLogType = 2;
        $objCustomerLogInfo->iCreateUid = $this->getUserId();
        $objCustomerLogInfo->iCheckState = $bNeedCheck?CheckStatus::auditting:  CheckStatus::isPass;
        $objCustomerLogInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $iLogRtn = $objCustomerLogBLL->insert($objCustomerLogInfo);
       if($iLogRtn === false){
           Utility::Msg("添加修改记录失败");
       }
       Utility::Msg($bNeedCheck?"提交审核申请成功":"修改成功",true,  $this->getActionUrl("CM", "CMInfo", "showDetailFront","&customer_id={$agContactInfo->iCustomerId}"));
//      
//       
//        if($isCharge == 1&&$agContactInfo->iIscharge == 0){
//            $iChargeRtn = $objAgContactBLL->ClearChargeContact($agContactInfo->iCustomerId);
//            if($iChargeRtn === false){
//                Utility::Msg("负责人转换失败");
//            }
//            $agContactInfo->iIscharge = 1;
//        } 
//        
//        //获取修改之前联系人信息【↓】
//        //var_dump($agContactInfo);exit;
//        $agContactBefore = new AgContactBLL();
//        $contactID = Utility::GetFormInt('contact_id', $_POST);
//        $agContactBefore = $agContactBefore->getContactFront($contactID,$this->getAgentId()); //修改之前的信息
//        //如果从负责人修改成非负责人【不允许这么操作】
//        if ($agContactBefore[0]["isCharge"] == 1 && $agContactInfo->iIscharge == 0) {
//            die("您没有权限将负责人修改为非负责人");
//        }
//        
//        $customerBLL = new CustomerBLL();
//        $contactABC = $customerBLL->getContactStatus($contactID);
//        //负责人，未发起审核的电话号码，固定电话要审核，其他不要
//        if($agContactBefore[0]['isCharge'] == 1 && 
//                $agContactBefore[0]['contact_tel'] != $agContactInfo->strContactTel && $agContactBefore[0]['contact_mobile'] != $agContactInfo->strContactMobile 
//                && $contactABC[0]["check_status"] != 0 && $contactABC[0]["check_uid"] != 0){
//            //审核
//            $keyValue = "{";
//            foreach ($agContactBefore[0] as $key => $value) {
//                settype($value, "string");
//                $oldValue = $value;
//                $newValue = Utility::GetForm($key, $_POST);
//                if ($key == "contact_sex") { //防止0被过滤掉
//                    $newValue = $_POST["contact_sex"];
//                }
//                    if ($oldValue != $newValue) {
//                        $keyValue .= "\"$key\":\"{$newValue}\",";
//                    }
//            }
//            if ($keyValue != "{") {
//                $keyValue = substr($keyValue, 0, -1);
//                $keyValue = $keyValue . ',"contact_id":"' . $agContactBefore[0]["contact_id"] .
//                    '"';
//                $keyValue = $keyValue . "}";
//            } else {
//                $keyValue = "{}";
//            }
//            if ($keyValue != "{}") {
//                $keyValue = '{"contact":' . $keyValue . '}';
//                //更新修改日志cm_customer_log
//                //    if($keyValue != "{}"){
//                //            //更新修改日志
//                $customerLogInfo = new CustomerLogInfo();
//                $customerLogInfo->iCustomerId = $agContactInfo->iCustomerId;
//                $customerLogInfo->strChangeValues = $keyValue;
//                //str_replace("<br /><br />","<br />",str_replace(array("<br /><br /><br />","<br /><br />","<br />"),"<br />",str_replace(array("\n\r","\n","\r","\t"),"<br />",$keyValue)));
//                $customerLogInfo->iCreateUid = parent::getUserId();
//                $customerLogInfo->iAgentId = parent::getAgentId();
//                $customerLogBLL = new CustomerLogBLL();
//                $customerAgentBLL = new CustomerAgentBLL();
//                $iCustomerId = $agContactInfo->iCustomerId;
//                $customerAgentBLL->updateCustomerCheckStatus($iCustomerId);
//                //print_r($customerLogInfo);exit;
//                $iRtn = $customerLogBLL->insert1($customerLogInfo);
//                if($iRtn >0){
//                    Alert::succeed();
//                }else{
//                    Alert::failed();
//                }
//            }
//        }else{
//            $agContactBLL = new AgContactBLL();
//            $iRtn = $agContactBLL->updateByID($agContactInfo);
//            if($iRtn !==false){
//                Alert::succeed();
//            }else{
//                Alert::failed();
//            }
//        }
    }

    //【前台】联系人修改记录时判断是否需要进行比对的键
    private function isCompareKeyFront($key)
    {
        $arrNoCompareKeys = array("contact_id", "customer_id", "agent_id", "update_uid",
            "update_time", "create_uid", "create_time", "contact_net_awareness",
            "contact_importance");
        if (in_array($key, $arrNoCompareKeys)) {
            return false;
        } else {
            return true;
        }
    }

    //【前台】获取联系人编辑 表单信息
    private function getContactModify($iContactID,&$arrChangeValue)
    {
        $objAgContactBLL = new AgContactBLL();
        $t_Contact = $objAgContactBLL->getModelByID($iContactID,$this->getAgentId());
        if(!$t_Contact){
            return false;
        }
        
        $bNeedCheck = false;
        if(Utility::GetForm("isCharge", $_POST) == 1 || $t_Contact->iIscharge == 1){
            $bNeedCheck = true;
        }
        
        $strContactName = Utility::GetForm('contact_name', $_POST);
        if(empty ($strContactName))
            Utility::Msg ("联系人姓名不得为空");
        $arrChangeValue = $this->getPostInfo($strContactName, &$t_Contact->strContactName, $arrChangeValue, 'contact_name',AgContactBLL::$_NeedCheckField,$bNeedCheck);
        $arrChangeValue = $this->getPostInfo(Utility::GetForm('contact_mobile', $_POST), &$t_Contact->strContactMobile, $arrChangeValue, 'contact_mobile',AgContactBLL::$_NeedCheckField,$bNeedCheck);      
        $arrChangeValue = $this->getPostInfo(Utility::GetForm('contact_tel', $_POST), &$t_Contact->strContactTel, $arrChangeValue, 'contact_tel',AgContactBLL::$_NeedCheckField,$bNeedCheck);
        $arrChangeValue = $this->getPostInfo(Utility::GetForm('contact_email', $_POST), &$t_Contact->strContactEmail, $arrChangeValue, 'contact_email',AgContactBLL::$_NeedCheckField,$bNeedCheck);   
        $arrChangeValue = $this->getPostInfo(Utility::GetForm('contact_sex', $_POST), &$t_Contact->iContactSex, $arrChangeValue, 'contact_sex',AgContactBLL::$_NeedCheckField,$bNeedCheck);        
        $arrChangeValue = $this->getPostInfo(Utility::GetForm('contact_position', $_POST), &$t_Contact->strContactPosition, $arrChangeValue, 'contact_position',AgContactBLL::$_NeedCheckField,$bNeedCheck);
        $arrChangeValue = $this->getPostInfo(Utility::GetForm('contact_fax', $_POST), &$t_Contact->strContactFax, $arrChangeValue, 'contact_fax',AgContactBLL::$_NeedCheckField,$bNeedCheck);
        $arrChangeValue = $this->getPostInfo(Utility::GetForm('contact_remark', $_POST), &$t_Contact->strContactRemark, $arrChangeValue, 'contact_remark',AgContactBLL::$_NeedCheckField,$bNeedCheck);
        //print_r($isCharge);exit;
//        $t_Contact->iIscharge = $isCharge;
//        $t_Contact->iContactSex = Utility::GetFormInt('contact_sex', $_POST);
//        $t_Contact->strContactMobile = Utility::GetForm('contact_mobile', $_POST);
//        $t_Contact->strContactTel = Utility::GetForm('contact_tel', $_POST);
//        $t_Contact->strContactEmail = Utility::GetForm('contact_email', $_POST);
//        $t_Contact->strContactPosition = Utility::GetForm('contact_position', $_POST);
//        $t_Contact->strContactNetAwareness = Utility::GetForm('contact_net_awareness', $_POST);
//        $t_Contact->strContactFax = Utility::GetForm('contact_fax', $_POST);
//        $t_Contact->strContactImportance = Utility::GetForm('contact_importance', $_POST);
//        $t_Contact->strContactRemark = Utility::GetForm('contact_remark', $_POST);
//        $t_Contact->iAgentId = parent::getAgentId();
//        $t_Contact->iCustomerId = Utility::GetFormInt('customer_id', $_POST);
//        $t_Contact->iContactSex = Utility::GetForm('ContactSex', $_POST);
        return $t_Contact;
    }

    //【前台】删除联系人
    public function delContact()
    {
        $contact_id = Utility::GetFormInt('contact_id', $_GET);
        $agContactBLL = new AgContactBLL();
        $objAgContactInfo = $agContactBLL->getModelByID($contact_id, $this->getAgentId());
        if (!$objAgContactInfo) {
            Utility::Msg("获取信息失败");
        }
        if ($objAgContactInfo->iIscharge == 0) {
            //不是负责人，直接删除
            $iDelRtn = $agContactBLL->delContactByID($contact_id,  $this->getUserId(),$this->getAgentId());
            if ($iDelRtn === false) {
                Utility::Msg("删除失败");
            }
        }

        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogInfo = new CustomerLogInfo();
        $objCustomerLogInfo->iCustomerId = $objAgContactInfo->iCustomerId;
        $objCustomerLogInfo->iContactId = $contact_id;
        $objCustomerLogInfo->iAgentID = $this->getAgentId();
        $objCustomerLogInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objCustomerLogInfo->iCreateUid = $this->getUserId();
        $objCustomerLogInfo->iCheckState = $objAgContactInfo->iIscharge ? CheckStatus::auditting : CheckStatus::isPass;
        $objCustomerLogInfo->iLogType = 2;
        $objCustomerLogInfo->iCheckType = 3;
        $iLogRtn = $objCustomerLogBLL->insert($objCustomerLogInfo);

        if ($iLogRtn === false) {
            Utility::Msg("添加修改记录失败");
        }

        Utility::Msg("删除成功", true);
    }

    //【前台】展现添加联系小记页面
    public function showAddContactRecode()
    {
        $customer_id = Utility::GetFormInt('customer_id', $_GET);
        $contact_id = Utility::GetFormInt("contact_id", $_GET);
        $contactTime = date("Y-m-d H:i:s");
        $this->smarty->assign('customer_id', $customer_id);
        if (trim($contact_id != "")) {

            $customerBLL = new CustomerBLL();
            $arrInfo = $customerBLL->getContactInfo($contact_id,$customer_id,$this->getAgentId());
            $array = array("contactTime" => $contactTime);
            $arrInfo[0] = array_merge($arrInfo[0],$array);
            $this->displaypage("CM/ContactRecode.tpl", $arrInfo[0]);
//            $this->smarty->assign('contactTime', $contactTime);
        } else {
            $this->smarty->assign('contactTime', $contactTime);
            $this->displaypage("CM/ContactRecode.tpl");
        }
    }

    //【前台】联系小记数据输插入
    public function getContactInfoNews()
    {
        $contact_name = Utility::GetForm("contactName", $_POST);
        $contact_recode = Utility::GetForm("contactRecord", $_POST);
        $contact_time = Utility::GetForm("contactTime", $_POST);
        $customer_id = Utility::GetForm("customer_id", $_POST);
        $contact_tel = Utility::GetForm("fPhone", $_POST);
        $contact_mobile = Utility::GetForm("mPhone", $_POST);
        $intention_rating = Utility::GetForm("intentionRating", $_POST);
        $agent_id = parent::getAgentId();
        $user_id = parent::getUserId();
        $customerBLL = new CustomerBLL();
        $arrrayInfo = $customerBLL->getContactName($customer_id, $contact_name);
        //$arrrayInfo = $arrrayInfo[0];
        if ($arrrayInfo == array()) { //print_r($array);die("aaaa"); exit;
            $customerBLL->insertContacts($contact_name, $customer_id, $contact_tel, $contact_mobile,
                $user_id, $agent_id);
        }
        $customerBLL->insertContactRecode($contact_name, $contact_recode, $contact_time,
            $customer_id, $contact_tel, $contact_mobile, $intention_rating, $agent_id, $user_id);
        Alert::succeed();
    }

    //【前台】联系小记更多信息
    public function getDetailContactNews()
    {
        $customer_id = Utility::GetForm("customer_id", $_GET);
        $customerBLL = new CustomerBLL();
        $customer_name = $customerBLL->getContactCustomerName($customer_id);
        $this->smarty->assign('customer_name', $customer_name[0]['customer_name']);
        $this->smarty->assign('customer_id', $customer_id);
        $strUrl = $this->getActionUrl('CM', 'CMInfo', 'getDetailContactNewsBody',
            'customer_id=' . $customer_id);
        //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->JsonForMultiSelect(false);
        $this->smarty->assign('strIntentionRatingJson',$strIntentionRatingJson); 
        $this->smarty->assign('strUrl', $strUrl);
        $this->displaypage("CM/showAllContact.tpl");
    }

    //【前台】联系人小记详细信息主体
    public function getDetailContactNewsBody()
    {
        $strWhere = "and A.create_uid>0";
        //该代理商帐下指定客户的联系小记内容
        $contactName= Utility::GetForm("contactName", $_GET);
        if ($contactName != "")
           $strWhere.=" and A.contact_name like '%$contactName%' ";

        $intentRating = Utility::GetForm("IntentionRating", $_GET);
        if($intentRating != ""){
            $strWhere .= " and A.intention_rating in ({$intentRating}) ";
        }
        
        $contactTimeS = Utility::GetForm("contactTimeS", $_GET);
        $contactTimeE = Utility::GetForm("contactTimeE", $_GET);        
        if(!empty ($contactTimeS)&&Utility::isShortTime($contactTimeS)){
            $strWhere .= " and date(A.contact_time) >= '{$contactTimeS}' ";
        }
        
        if(!empty ($contactTimeE)&&Utility::isShortTime($contactTimeE)){
            $strWhere .= " and date(A.contact_time) <".Utility::SQLEndDate($contactTimeE)."";
        }
        
        $customer_id = Utility::GetFormInt("customer_id", $_GET);
        $agent_id = parent::getAgentId();
        $customerBLL = new CustomerBLL();
        $arrPageList = $customerBLL->getcustomerContactRecodeFronts($customer_id,$agent_id,$strWhere);
        self::showPageSmarty($arrPageList, 'CM/showAllContactBody.tpl');
    }

    //【前台】客户提交订单
    public function showCustomerOrderFront()
    {
        $customer_id = Utility::GetFormInt('customer_id', $_GET);
        $customerBLL = new CustomerBLL();
        $customer_name = $customerBLL->getCustomerName($customer_id);
        // print_r($customer_name);exit;
        $sWhere = " and om_order.agent_id=" . $this->getAgentId() .
            " and `add_user`.user_id=" . $this->getUserId() . " and om_order.customer_id=" .
            $customer_id;

        $iProductID = Utility::GetFormInt("cbProduct", $_GET);
        if ($iProductID > 0)
            $sWhere .= " and `om_order`.product_id=" . $iProductID;
        else {
            $productTypeID = Utility::GetFormInt("cbProductType", $_GET);
            if ($productTypeID > 0)
                $sWhere .= " and `sys_product`.product_type_id=" . $productTypeID;
        }

        $iAuditState = Utility::GetFormInt("cbAuditState", $_GET);
        if ($iAuditState != -100)
            $sWhere .= " and `om_order`.check_status =" . $iAuditState;

        $iOrderType = Utility::GetFormInt("cbOrderType", $_GET);
        if ($iOrderType != -100)
            $sWhere .= " and `om_order`.order_type =" . $iOrderType;

        $postSDate = Utility::GetForm("tbxPostSDate", $_GET);
        if ($postSDate != "")
            $sWhere .= " and `om_order`.post_date >= '" . $postSDate . "'";

        $postEDate = Utility::GetForm("tbxPostEDate", $_GET);
        if ($postEDate != "")
            $sWhere .= " and `om_order`.post_date < date_add('" . $postEDate .
                "',interval 1 day)";

        $strOrderNo = Utility::GetForm("tbxOrderNo", $_GET);
        if ($strOrderNo != "")
            $sWhere .= " and `om_order`.order_no like '%" . $strOrderNo . "%'";

        $strCustomerName = Utility::GetForm("tbxCustomerName", $_GET);
        if ($strCustomerName != "")
            $sWhere .= " and `om_order`.customer_name like '%" . $strCustomerName . "%'";

        $iPageSize = Utility::GetFormInt('pageSize', $_GET);

        if ($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        //exit($sWhere);

        $objOrderBLL = new OrderBLL();
        $arrPageList = $this->getPageList($objOrderBLL, "*", $sWhere, "", $iPageSize);
        CustomerOrderTypes::ReplaceArrayText($arrPageList['list'], "order_type");
        // print_r($arrPageList['list']);exit;
        $this->smarty->assign('strTitle', '订单');
        $this->smarty->assign('arrayOrder', $arrPageList['list']);
        //【为了订单】需要id和name
        $this->smarty->assign('customer_id', $customer_id);
        $this->smarty->assign('customer_name', $customer_name);
        //$this->displayPage($customer_id,$customer_name,"CM/CustomerOrder.tpl");
        $this->displayPage("CM/CustomerOrder.tpl");
    }

    /**
     * @functional 【前台提交订单】选择产品 跳转
     */
    public function OrderPost1SubmitFront()
    {
        $this->ExitWhenNoRight("OrderModify", RightValue::add);

        $iProductId = Utility::GetFormInt('cbProduct', $_POST);
        if ($iProductId <= 0)
            exit("请选择产品！");

        $iProductTypeId = Utility::GetFormInt('cbProductType', $_POST);
        if ($iProductTypeId <= 0)
            exit("请选择产品类别！");

        $iCustomerId = Utility::GetFormInt('tbxCustomerID', $_POST);
        // print_r($iCustomerId);exit;
        if ($iCustomerId <= 0)
            exit("请选择客户！");
        /* //客户订单已存在的提示
        $objOrderBLL = new OrderBLL();
        if($objOrderBLL->TodayPostedOrderCount($this->getAgentId(),$iCustomerId,$iProductId) > 2)
        exit("24小时内只能提交两个该客户此产品的订单！");

        //金额不足的提示
        if($objOrderBLL->IsLackOfBalance($this->getAgentId(),$this->getFinanceNo(),$iProductTypeId,$iProductId) == true)
        exit("预存款余额不足！");
        */
        exit("0,/?d=OM&c=Order&a=OrderModify");
    }

    //联系人卡片
    public function showConatctCard()
    {
        $agContactBLL = new AgContactBLL();
        $contact_id = Utility::GetFormInt('contact_id', $_GET);
        $contactInfo = $agContactBLL->getContactFront($contact_id,$this->getAgentId());
        $contactInfo = $contactInfo[0];
        //print_r($contactInfo);exit;
        $this->smarty->assign('contactInfo', $contactInfo);
        $this->disPlayPage("CM/ContactCard.tpl");
    }
    
    public function setProtect() {
        if(!$this->HaveRight("showFrontInfoList", RightValue::v32)){
            Utility::Msg("对不起，您没有权限");
        }
        
        $objDataConfigBLL = new DataConfigBLL();
        $objCustomerExBLL = new CustomerExBLL();
        $strCustomerID = Utility::GetForm("customerid", $_POST);
        
        if(empty ($strCustomerID)){
            Utility::Msg("请选择需要操作的客户");
        }
        
        //判断客户是否存在
        $arrCustomerExList = $objCustomerExBLL->getCustomerExListByCustomerID($strCustomerID, $this->getAgentId());
        if ($arrCustomerExList) {
            //判断是否超过容量限制
            $iCustomerCount = $objCustomerExBLL->getCustomerCountByID($this->getUserId(), $this->getAgentId(), CustomerDefendState::DefendCustomer);
            $iCustomerCount = $iCustomerCount[0]['num'];
            $iMaxCount = $objDataConfigBLL->GetAllow_Count_Protect($this->getAgentId());
            if ($iMaxCount < (count($arrCustomerExList) + $iCustomerCount)) {
                Utility::Msg("超过保护客户容量限制");
            }
            
            //根据是否存在联系小记重新分类
            $arrCMID = array(
                'Protect' => array(),
                'ProtectNo' => array()
            );
            foreach ($arrCustomerExList as $arrCustomerExItem) {
                if ($arrCustomerExItem['record_count'] > 0) {
                    $arrCMID['Protect'][] = $arrCustomerExItem['customer_id'];
                } else {
                    $arrCMID['ProtectNo'][] = $arrCustomerExItem['customer_id'];
                }
            }
            //根据不同类型取保护天数，并设置保护
            $bFalg = true;
            foreach ($arrCMID as $DefendType => $strCMIDs) {
                if(count($strCMIDs) > 0){
                    if($DefendType == 'Protect'){
                        $iProtextTime = $objDataConfigBLL->GetProtectTime_Protect_Record($this->getAgentId());
                    }else{
                        $iProtextTime = $objDataConfigBLL->GetProtectTime_Protect_No_Record($this->getAgentId());
                    }
                    $iRtn = $objCustomerExBLL->UpdateToSeaTime($this->getAgentId(),Utility::addDay(Utility::Now(), $iProtextTime,false), implode(',', $strCMIDs),  CustomerDefendState::DefendCustomer);
                    if($iRtn ===false){
                        $bFalg = false;
                    }
                }
            }
            if($bFalg){
                Utility::Msg("设置保护成功",true);
            }else{
                Utility::Msg("设置保护失败");
            }
        }
        Utility::Msg("客户不存在");
    }

    public function uploadCustomerFile($file, $filetempname) {
        //自己设置的上传文件存放路径
        $filePath = 'FrontFile/upload/customerFile';
        $str = "";


        //注意设置时区
        $time = date("y-m-d-H-i-s"); //去当前上传的时间 
        //获取上传文件的扩展名
        $extend = strrchr($file, '.');
        //上传后的文件名
        $name = $time . $extend;
        $uploadfile = $filePath . $name; //上传后的文件名地址 
        //move_uploaded_file() 函数将上传的文件移动到新位置。若成功，则返回 true，否则返回 false。
        $result = move_uploaded_file($filetempname, $uploadfile); //假如上传到当前目录下
        //echo $result;
        if ($result) { //如果上传文件成功，就执行导入excel操作
            //include "conn.php";
            $objReader = PHPExcel_IOFactory::createReader('Excel5'); //use excel2007 for 2007 format 
            $objPHPExcel = $objReader->load($uploadfile);
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();           //取得总行数 
            $highestColumn = $sheet->getHighestColumn(); //取得总列数


            $objWorksheet = $objPHPExcel->getActiveSheet();


            $headtitle = array();
            for ($row = 1; $row <= $highestRow; $row++) {
                $strs = array();
                //注意highestColumnIndex的列数索引从0开始
                for ($col = 0; $col < $highestColumn; $col++) {
                    $strs[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                $sql = "INSERT INTO te(`1`, `2`, `3`, `4`, `5`) VALUES (
            '{$strs[0]}',
            '{$strs[1]}',
            '{$strs[2]}',
            '{$strs[3]}',
            '{$strs[4]}')";
                //die($sql);
                if (!mysql_query($sql)) {
                    return false;
                    echo 'sql语句有误';
                }
            }
        } else {
            $msg = "导入失败！";
        }
        return $msg;
    }
}
