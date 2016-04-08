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

class CMVerifyAction extends ActionBase
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
        $this->smarty->assign('strTitle', '客户资料管理');
        $this->displayPage("CM/ManageList.tpl");
    }
    //显示审核任务分配页面
    public function showVerifyAssign()
    {
        $this->PageRightValidate("showVerifyList",RightValue::v512);
        $customer_ids = $_GET["customer_ids"];
        $this->smarty->assign('customer_ids', $customer_ids);
        $this->smarty->display("CM/VerifyAssign.tpl");
    }
    //通过用户名称帐号获取 用户帐号(名称)
    public function getUserName_ID()
    {
        $userName_ID = Utility::GetForm('q',$_GET);
        $customerBLL = new CustomerBLL();
        if(trim($userName_ID) == "")
            exit("");
        $customerBLL = new CustomerBLL();
        $arrayData = $customerBLL->getUserName_ID($userName_ID);
        exit(json_encode(array('value'=>$arrayData)));
    }
    //审核任务分配
    public function verifyAssign()
    {
        $customer_ids = $_POST["customer_ids"];
        $assign_check_id = $_POST["assign_check_id"];//审核人ID
        $arrId = explode(',', $customer_ids);
        $arr = '';
        foreach($arrId as $value)
        {
            $arr = $value;
            if(substr($arr, 0,2) == '0-' )
            {
                $customerid = substr($arr, 2);
                $customerBLL = new CustomerBLL();
                $customerBLL->verifyAssignCM($assign_check_id,$customerid);
            }
            else
            {
                $customerBLL = new CustomerBLL();
                $customerBLL->verifyAssignClog($assign_check_id,$arr);
            }
        }
        die("1");
    }
    //展现客户资料审核列表[主页面]
    public function showVerifyList()
    {
        $this->PageRightValidate("showVerifyList",RightValue::view);
        $customerBLL = new CustomerBLL();
        $countArry = $customerBLL->getVerifyListCountData();//print_r($countArry);exit;
        if (isset($countArry) && count($countArry) == 1) {
            $this->smarty->assign("newCount", $countArry[0]["newCount"]);
            $this->smarty->assign("modifyCount", $countArry[0]["modifyCount"]); 
            $this->smarty->assign("delCount", $countArry[0]["delCount"]);
        }
        else
        {
            $this->smarty->assign("newCount", "0");
            $this->smarty->assign("modifyCount", "0");
            $this->smarty->assign("delCount", "0");
        }
        $this->smarty->assign('strTitle', '客户资料审核');
        /*$customerBLL = new CustomerBLL();
        $agent_id = parent::getAgentId();
        $arrPageList = $customerBLL->getVerifyDate($agent_id);//print_r($arrPageList);exit;
        $infotype = '';
        foreach($arrPageList['list'] as $value)
        {
            $infotype = $value['info_type'];
        }
        $this->smarty->assign('customer_ids', $infotype);*/
        $strUrl = $this->getActionUrl('CM', 'CMVerify', 'showVerifyListBody');
        $this->smarty->assign('strUrl', $strUrl);
        $this->smarty->assign('IsNew', 0);
        $this->displayPage("CM/VerifyList.tpl");
    }
    //展现审核列表主体
    public function showVerifyListBody()
    { 
         //$agent_id = parent::getAgentId();
        $customerBLL = new CustomerBLL();
        $arrPageList = $customerBLL->getVerifyDate();//print_r($arrPageList);exit;
        self::showPageSmarty($arrPageList, 'CM/VerifyListBody.tpl');
    }
    //展现客户资料审核[跳转]
    public function showVerify()
    {
        $this->PageRightValidate("showVerifyList",RightValue::v4);
        $this->smarty->assign('strTitle', '客户资料审核');
        $customer_ids = Utility::GetForm('aid', $_GET);//print_r($customer_ids);exit;
        $agent_customer_id = Utility::GetFormInt("agent_customer_id",$_GET);
        $agent_id = Utility::GetFormInt("agent_id",$_GET);
        if(substr($customer_ids,0,2) == "0-")
        //前台新增客户直接状态“新增”，按照以下审核
        {   
            $customerID = substr($customer_ids, 2);
            $customerBLL = new CustomerBLL();
            $arryInfo = $customerBLL->GetCustomerInfo($customerID);
            $area_id = $arryInfo[0]['reg_place'];
            $reg_place2 = "";
        if($area_id != "" && $area_id != -1){
            $AREA = $customerBLL->getRegPlace($area_id);//print_r($AREA);exit;
            $reg_place2 = $AREA[0]['area_fullname'];}
            $this->smarty->assign('reg_place2',$reg_place2);
            //print_r($arryInfo);exit;
            $arrcontact = $customerBLL->getContactNews($customerID,$agent_id);
            
            if (isset($arryInfo) && count($arryInfo) == 1 && isset($arrcontact) && count($arrcontact) == 1) {
                $arr = array_merge($arryInfo[0], $arrcontact[0]);
                $this->smarty->assign($arr);
                $this->smarty->assign("reg_date", CommonAction::GetDate($arr["reg_date"]));
            }
            $this->smarty->assign("change_values", "{}");
//         var_dump($arrcontact);exit;
//         if (isset($arrcontact) && count($arrcontact) == 1){
//            $this->smarty->assign($arrcontact[0]);
//          }
        }
        else
        //以下是 前台 客户和联系人修改审核
        {
            $customerBLL = new CustomerBLL();
            $customerID = $customerBLL->getCustomerIdFromAids($customer_ids);  //通过log表id获取对应的客户id
            $arryInfo = $customerBLL->GetCustomerInfo($customerID[0]['customer_id']);
            $arrcontact = $customerBLL->getContactNews($customerID[0]['customer_id'],$agent_id);
            if (isset($arryInfo) && count($arryInfo) == 1 && isset($arrcontact) && count($arrcontact) == 1) {
                $arr = array_merge($arryInfo[0], $arrcontact[0]);
                $arry = $customerBLL->getJson($customer_ids); //===》获取修改记录
                $array = json_decode($arry[0]['change_values']);
                $newarray = "";
                foreach ($array as $key => $value)
                {
                    $newarray = $value;
                }
                if($key == "contact")
                {
                    $contact_id = $newarray->contact_id;//print_r($contact_id);exit;
                    $this->smarty->assign('contact_id',$contact_id);
                    $arrr = (array)($newarray);//print_r($arrr);exit;
                    if(array_key_exists("isCharge",$arrr)){ // 判断isCharge键值是否存在
                    if($arrr['isCharge'] == 1){
                    $ChangeContactName = $customerBLL->getContactNM($arrr['contact_id']);
                    
                    $this->smarty->assign('isCharge1',$arrr['isCharge']);
                    $this->smarty->assign('contactName1',$ChangeContactName[0]['contact_name']);
                    }}  
                }
                $jsonarr = "";
                foreach($newarray as $keys => $value)
                {
                    if($keys != "contact_id")
                    {
                        $jsonarr[$keys] = $value;
                    }
                }
                $res = (array)$jsonarr;
                $newarry = array();
                $keyValue = "{";
                foreach($res as $key => $value)
                {
                    $newarry[$key] = $arr[$key];
                    $arr[$key] = $value;
                    $keyValue .= "\"{$key}\":{\"oldValue\":\"{$newarry[$key]}\",\"newValue\":\"{$arr[$key]}\"},";
                }
                if($keyValue != "{")
                {
                    $keyValue = substr($keyValue, 0, -1) . "}";
                }
                else{
                    $keyValue = "{}";
                }
                $this->smarty->assign('aid',$customer_ids);
                $this->smarty->assign('keyValue',$keyValue);
                $this->smarty->assign($arr);
                $areaID = $arr['area_id'];
                $areaFullname = $customerBLL->getVerifyAreaFullname($areaID);
                $this->smarty->assign("areaFullname", $areaFullname[0]["area_fullname"]);
                $this->smarty->assign("reg_place1", $areaFullname[0]["area_fullname"]);
                $industryID = $arr['industry_id'];
                $industryFullname = $customerBLL->getVerifyIndustryFullname($industryID);
                $this->smarty->assign("industryFullname", $industryFullname[0]["industry_fullname"]);
                $this->smarty->assign("reg_date", CommonAction::GetDate($arr["reg_date"]));
                //获取客户的更新信息
                $customerLogBLL = new CustomerLogBLL();
                $arryLogInfo = $customerLogBLL->GetLastModifyInfo($customer_ids);
                $change_values = $arryLogInfo[0]['change_values'];
                $reg_place1 = json_decode($change_values);
                $arryy = (array)$reg_place1;
                if(array_key_exists("customer",$arryy)){
                    $thingss = $reg_place1->customer;
                    $thingss = (array)$thingss;
                  // if(count($reg_place1)>1)
                    if(array_key_exists("reg_place",$thingss))
                    {
                        $reg_place1 =  $thingss["reg_place"];//$reg_place1->customer->reg_place;//对象取值！   
                        $reg_place2 = $customerLogBLL->GetAreaName($reg_place1);
                        $this->smarty->assign("reg_place2", $reg_place2);
                    }
                    if(array_key_exists("area_id",$thingss))
                    {
                        $area_id = $thingss["area_id"];//对象取值！   
                        //print_r($area_id);exit;
                        $area_N = $customerLogBLL->GetAreaName($area_id);
                        $this->smarty->assign("area_N", $area_N);
                    }
                }
                if(isset($arryLogInfo) && count($arryLogInfo) == 1) {
                    $arr = json_encode($newarry);
                  //print_r($arr);
                    $change_values = "{\"{$keys}\":{$arr}}";
 //               print_r($change_values);exit;
                    $this->smarty->assign("change_values", $change_values);
                }
                else {
                    $this->smarty->assign("change_values", "{}");
                }
            }
        }
//        print_r($change_values);exit;
        $this->smarty->assign("agent_customer_id", $agent_customer_id);
        $this->displayPage("CM/Verify.tpl");
    }
    //审核客户 注意删除客户审核 需要更新is_del 字段为2
    public function verify() {
        $objCustomerAgentInfo = new CustomerAgentInfo();
        $objCustomerAgentBLL = new CustomerAgentBLL();
        $commonBLL = new CommonBLL();
        $customerBLL = new CustomerBLL();
        $agent_customer_id = Utility::GetForm("agent_customer_id", $_GET);
        //提交请求的agent_id
        //  $agen_id = $customerBLL-> getAgentid($agent_customer_id);
        $recoverKeys = Utility::GetForm("recoverKeys", $_POST);
        $check_status = Utility::GetForm("check_status", $_POST);
        $is_del = Utility::GetForm("is_del", $_POST);
        $customer_id = Utility::GetForm("customer_id", $_POST); //print_r($customer_id);die("6666");
        $check_uid = parent::getUserId();
        $contact_id = Utility::GetForm("contact_id", $_POST);
        $check_remark = Utility::GetForm('check_remark', $_POST);
        $aid = Utility::GetForm("aid", $_POST);
        $user_id = parent::getUserId();
        $keyValue = Utility::GetForm('keyValue', $_POST); //print_r($keyValue);exit;
        $is_contact = Utility::GetForm("is_contact", $_POST);
        $arr = explode(",", $recoverKeys);
        $arrays = array_flip($arr);
        $contactId = $customerBLL->getContactId($contact_id);
        $contactId = $contactId[0]['contact_id'];
        //通过customer_id  select找出所有的改客户的代理商
        //$agent_ids = $customerBLL->getAgentID($customer_id);
//        
//        $agent_ID = "";
//        foreach($agent_ids as $value)
//        {
//            $agent_ID .= $value['agent_id'].",";
//        } 
//        $agent_ID = substr($agent_ID, 0, -1); //代理商ID组
//        $agent_ID = explode(",",$agent_ID);
        // print_r($agent_ID);exit;
        if ($is_del == "1") {//删除审核 只需要更新is_del字段为2
            if ($check_status == "1")
                $is_del_after_verify = "2";
            else
                $is_del_after_verify = "0";
            //更新客户表的是否审核字段、审核人、审核时间
            $is_del_result = $customerBLL->getIsDelVerify($is_del_after_verify, $check_status, $check_uid, $check_remark, $customer_id);
            if ($is_del != 0)
                die("1");
        }
        $objCustomerAgentInfo->iAgentCustomerId = $agent_customer_id;
        $objCustomerAgentInfo->iCheckStatus = $check_status;
        $objCustomerAgentInfo->strCheckRemark = $check_remark;

        $objCustomerAgentInfo->iCheckUid = $user_id;
        $objCustomerAgentBLL->updateCheckState($objCustomerAgentInfo);
        if ($check_status == "1") {//审核通过才能改客户信息
            if ($recoverKeys == "") {//如果不复原就更新客户信息(包括更新人，更新时间)【history_check 审核成功 赋值 1  /  审核不通过 不作改变】
                $sql = "update `cm_customer` set update_time = now(),update_uid = {$user_id},check_uid = {$check_uid},`check_status`={$check_status},
                        check_time = now(),check_remark = '{$check_remark}',history_check = 1 where `customer_id` = {$customer_id}";
                //echo($sql."++");
            }
            if ($aid != "/") {
                $customerBLL = new CustomerBLL();
                $res = $customerBLL->getCreateUid($aid);
                $update_uid = $res[0]['create_uid'];
                $update_time = $res[0]['create_time'];
                $arry = $customerBLL->getJson($aid);
                $array = json_decode($arry[0]['change_values']);
                $jsonarr = "";
                foreach ($array as $key => $value) {
                    $jsonarr = $value;
                }
                $res = (array) $jsonarr;
                $res = array_flip($res);
                $result = array_diff($res, $arr);
                $result = array_flip($result); //print_r($result);exit;

                if ($result == Array()) {
                    die("-1");
                } else {
                    if ($key == "customer") {
                        $sql = "update `cm_customer` set ";
                        foreach ($result as $key => $value) {
                            $sql .= $key . "='" . $value . "',";
                        }
                        $sql = substr($sql, 0, -1);
                        $sql .= " where `customer_id` = {$customer_id} ";
                        $commonBLL->Exec($sql);
                    }
                    if ($key == "contact") {
                        $isCharged = "";
                        $sql = "update `cm_ag_contact` set ";
                        foreach ($result as $key => $value) {
                            if ($key == "isCharge") {
                                $isCharged = 1;
                            }
                            if ($key != "contact_id") {
                                $sql .= $key . "='" . $value . "',";
                            }
                        }//print_r($value);exit; 
                        $contact_ID = $value; //==>修改成负责人的ID
                        //获取联系人的姓名

                        $contact = $customerBLL->getContactNameBACK($contact_ID, $customer_id); //改成获取所有信息了
                        $contact = $contact[0];
                        $contact_name = $contact['contact_name'];
                        //print_r($contact_name);exit;
                        $sql = substr($sql, 0, -1); //print_r($sql);exit;
                        $sql .= " where 
                     customer_id = {$customer_id}
                    and isCharge = 1
                     ;";/** 少个agent_id 列表 */
                        if ($isCharged == "1") {
                            $sql .= "update `cm_ag_contact` set `isCharge` = 0 where `customer_id` = {$customer_id} and `isCharge` = 1;
                                 update `cm_ag_contact` set `isCharge` = 1 where `customer_id` = {$customer_id} and contact_name = '{$contact_name}' ";
                        }

                        $commonBLL->Exec($sql);

                        if ($isCharged == "1") {
                            $agentContact = $customerBLL->getagentContact($contact_name);

                            $L = count($agentContact);

                            //处理其他代理商的负责人 （虽然他们的负责人都是一样的，只是contact_id 和agent_id不一样） 
                            $customerBLL->changeContact($agentContact, $contact);
                        }
                    }
                    $sql = "update `cm_customer` set history_check = 1,check_status=" . $check_status . ",update_uid = {$update_uid},update_time = '{$update_time}',check_uid=" .
                            $user_id . ",check_time=now(),check_remark='" . $check_remark . "' where customer_id=" . $customer_id . ";";
                    $sql .= "update `cm_customer_log` set `change_values` = '{$keyValue}',`check_time` = now(),`check_uid` = {$user_id} where `aid` = {$aid}";
                }
                $commonBLL->Exec($sql);
            }
            $commonBLL->Exec($sql);
            Alert::succeed();
        }
        if ($check_status == "-1") {
            if ($aid == "/") {
                $customerBLL->getVerifyNotPass($customer_id, $user_id, $check_remark);
            } else {
                $customerBLL->getVerifyLogNotPass($aid, $customer_id, $user_id, $check_remark);
            }
            die("-1");
        }
    }
    
    public function showCustomerInfoCheckList(){
        $this->PageRightValidate("CustomerInfoCheck",  RightValue::view);
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrCheckCount = $objCustomerLogBLL->getCheckTypeCount(1);
        $arrCount = array(
            'add'=>0,
            'edit'=>0,
            'del'=>0
        );
        if($arrCheckCount){
            foreach($arrCheckCount as $data){
                if($data['check_type'] == 1){
                    $arrCount['add'] = $data['num'];
                }
                if($data['check_type'] == 2){
                    $arrCount['edit'] = $data['num'];
                }
                if($data['check_type'] == 3){
                    $arrCount['del'] = $data['num'];
                }
            }
        }
        $this->smarty->assign('newCount',$arrCount['add']);
        $this->smarty->assign('modifyCount',$arrCount['edit']);
        $this->smarty->assign('delCount',$arrCount['del']);
        $this->smarty->assign("strUrl",  $this->getActionUrl("CM", "CMVerify", "showCustomerInfoCheckBody"));
        $this->displayPage('CM/CheckManage/CustomerCheckInfoList.tpl');
    }
    
    public function showCustomerInfoCheckBody(){
        $this->ExitWhenNoRight("CustomerInfoCheck", RightValue::view);
        $strWhere = $this->getCustomerInfoCheckWhere();
        $strOrder= Utility::GetForm("sortField", $_GET);
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrCustomerCheckList = $objCustomerLogBLL->getCustomerLogList($strWhere, $strOrder);
        $this->showPageSmarty($arrCustomerCheckList, 'CM/CheckManage/CustomerCheckInfoBody.tpl');
    }
    
    public function getCustomerInfoCheckWhere(){
        $strWhere = " and cm_customer_log.check_state = 0 ";
        
        $strCustomerName = Utility::GetForm("customer_name", $_GET);
        if(!empty ($strCustomerName)){
            $strWhere .= " and (cm_customer.customer_name like '%{$strCustomerName}%' or cm_customer_log.customer_id = '{$strCustomerName}') ";
        }
        
        $strAgentName = Utility::GetForm("agent_name", $_GET);
        if(!empty ($strAgentName)){
            $strWhere .= " and am_agent_source.agent_name like '%{$strAgentName}%' ";
        }
        
        $strContactNamee = Utility::GetForm("contact_name", $_GET);
        if(!empty ($strContactNamee)){
            $strWhere .= " and cm_ag_contact.contact_name like '%{$strContactNamee}%' ";
        }
        
        $strCreateTimeBegin = Utility::GetForm("create_time_begin", $_GET);
        if(!empty ($strCreateTimeBegin) && Utility::isShortTime($strCreateTimeBegin)){
            $strWhere .= " and cm_customer_log.create_time > '{$strCreateTimeBegin}' ";
        }      
                
        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if(!empty ($strCreateTimeEnd) && Utility::isShortTime($strCreateTimeEnd)){
            $strWhere .= " and cm_customer_log.create_time <= DATE_ADD('{$strCreateTimeEnd}',INTERVAL 1 DAY) ";
        }
        
        return $strWhere;
    }
    
     public function showContactInfoCheckList(){
        $this->PageRightValidate("ContractCheckBack",  RightValue::view);
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrCheckCount = $objCustomerLogBLL->getCheckTypeCount(2);
        $arrCount = array(
            'add'=>0,
            'edit'=>0,
            'del'=>0
        );
        if($arrCheckCount){
            foreach($arrCheckCount as $data){
                if($data['check_type'] == 1){
                    $arrCount['add'] = $data['num'];
                }
                if($data['check_type'] == 2){
                    $arrCount['edit'] = $data['num'];
                }
                if($data['check_type'] == 3){
                    $arrCount['del'] = $data['num'];
                }
            }
        }
        $this->smarty->assign('newCount',$arrCount['add']);
        $this->smarty->assign('modifyCount',$arrCount['edit']);
        $this->smarty->assign('delCount',$arrCount['del']);
        $this->smarty->assign("strUrl",  $this->getActionUrl("CM", "CMVerify", "showContactInfoCheckBody"));
        $this->displayPage('CM/CheckManage/ContactCheckInfoList.tpl');
    }
    
    public function showContactInfoCheckBody(){
        $this->ExitWhenNoRight("ContractCheckBack", RightValue::view);
        $strWhere = $this->getCustomerInfoCheckWhere();
        
        $strOrder= Utility::GetForm("sortField", $_GET);
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrContactCheckList = $objCustomerLogBLL->getContactLogList($strWhere, $strOrder);
        $this->showPageSmarty($arrContactCheckList, 'CM/CheckManage/ContactCheckInfoBody.tpl');
    }
    
    public function showEditContactCheck(){
        $this->PageRightValidate("ContractCheckBack", RightValue::v4);
        $iAid = Utility::GetFormInt("aid", $_GET);
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogInfo = $objCustomerLogBLL->getModelByID($iAid);
        if(!$objCustomerLogInfo){
            Utility::Msg("获取用户数据失败");
        }
        $objChangeValue = json_decode($objCustomerLogInfo->strChangeValues);
        $objAgContactBLL = new AgContactBLL();
        $arrContactInfo = $objAgContactBLL->getContactInfo($objCustomerLogInfo->iContactId);
        foreach (AgContactBLL::$_NeedCheckField as $item) {
            if (isset($objChangeValue->$item)) {
                $arrContactInfo[$item] = $objChangeValue->$item->newValue;
                $arrContactInfo[$item.'_old'] = $objChangeValue->$item->oldValue;
            }
        }
        $this->smarty->assign('LogId',$iAid);
        $this->smarty->assign('ContactInfo',$arrContactInfo);
        $this->displayPage('CM/CheckManage/showEditContactCheck.tpl');
    }
    
    public function EditContactCheck(){
        if(!$this->HaveRight("ContractCheckBack", RightValue::v4)){
            Utility::Msg("对不起，您没有权限");
        }
        $iAid = Utility::GetFormInt("logid", $_POST);
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogInfo = $objCustomerLogBLL->getModelByID($iAid);
        if(!$objCustomerLogInfo){
            Utility::Msg("获取日志信息失败");
        }
        $iCheckState = Utility::GetFormInt("check_status", $_POST);
        $iContactID = Utility::GetFormInt("contactid", $_POST);
        $objAgContactBLL = new AgContactBLL();
        $arrChargeValue = array();
        if ($iCheckState > 0) {
            $arrChargeValue = $this->getContactChangeValue(json_decode($objCustomerLogInfo->strChangeValues));
            $objAgContactInfo = $objAgContactBLL->getModelByID($iContactID, $this->getAgentId());
            if (isset($arrChargeValue['isCharge']) && $objAgContactInfo->iIscharge == 0 && $arrChargeValue['isCharge'] == 1) {
                $iChargeRtn = $objAgContactBLL->ClearChargeContact($objCustomerLogInfo->iCustomerId);
                if ($iChargeRtn === false) {
                    Utility::Msg("负责人设置失败");
                }
            }
        }
        $arrChargeValue['check_state'] = $iCheckState;
        $iContactRtn = $objAgContactBLL->UpdateData($arrChargeValue, "contact_id = {$iContactID}");
        if($iContactRtn === false){
            Utility::Msg("联系人信息更新失败");
        }
        $strCheckRemark = Utility::GetForm("check_remark", $_POST);
        
        $objCustomerLogInfo->iCheckUid = $this->getUserId();
        $objCustomerLogInfo->strCheckTime = Utility::Now();
        $objCustomerLogInfo->iCheckState = $iCheckState;
        $objCustomerLogInfo->strCheckUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objCustomerLogInfo->strCheckRemark = $strCheckRemark;
        $iLogRtn = $objCustomerLogBLL->updateByID($objCustomerLogInfo);
        if($iLogRtn === false){
            Utility::Msg("更新日志信息失败");
        }
        Utility::Msg("审核成功",true,  $this->getActionUrl("CM", "CMVerify", "showContactInfoCheckList"));
    }
    
    public function getContactChangeValue($objChangeValue){
        $arrChangeValue=array();
        foreach (AgContactBLL::$_NeedCheckField as $item) {
            if (!isset($_POST[$item]) && isset($objChangeValue->$item)) {
                $arrChangeValue[$item] = $objChangeValue->$item->newValue;
            }
        }
        return $arrChangeValue;
    }
    
    public function showCustomerInfoList(){
        $this->PageRightValidate('CustomerLogList', RightValue::view);
        $this->smarty->assign("strUrl",  $this->getActionUrl("CM", "CMVerify", "showCustomerInfoBody"));
        $this->displayPage('CM/CheckManage/CustomerLogInfoList.tpl');
    }
    
    public function showCustomerInfoBody(){
        $this->ExitWhenNoRight("CustomerLogList", RightValue::view);
        $strWhere = $this->getCustomerInfoWhere();
        $strOrder= Utility::GetForm("sortField", $_GET);
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrCustomerInfoList = $objCustomerLogBLL->getCustomerLogList($strWhere, $strOrder);
        for($i = 0;$i<count($arrCustomerInfoList['list']);$i++){
            $arrCustomerInfoList['list'][$i]['check_state_cn'] = CheckStatus::GetText($arrCustomerInfoList['list'][$i]['check_state']);
            $arrCustomerInfoList['list'][$i]['check_type_cn'] = CustomerLogCheckType::getText($arrCustomerInfoList['list'][$i]['check_type']);
        }
        $this->showPageSmarty($arrCustomerInfoList, 'CM/CheckManage/CustomerLogInfoBody.tpl');
    }
    
    public function getCustomerInfoWhere(){
        $strWhere = "";
        $strCustomerName = Utility::GetForm("customer_name", $_GET);
        if(!empty ($strCustomerName)){
            $strWhere .= " and cm_customer.customer_name like '%{$strCustomerName}%' ";
        }
        
        $strAgentName = Utility::GetForm("agent_name", $_GET);
        if(!empty($strAgentName)){
            $strWhere .= " and am_agent_source.agent_name like '%{$strAgentName}%' ";
        }
        
        $strCreateName = Utility::GetForm("create_name", $_GET);
        if(!empty ($strCreateName)){
            $strWhere .= " and cm_customer_log.create_user_name like '%{$strCreateName}%' ";
        }
        
        $strCreateTimeBegin = Utility::GetForm("create_time_begin", $_GET);
        if(!empty ($strCreateTimeBegin)&&Utility::isShortTime($strCreateTimeBegin)){
            $strWhere .= " and cm_customer_log.create_time >= '{$strCreateTimeBegin}' ";
        }
        
        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if(!empty ($strCreateTimeEnd)&&Utility::isShortTime($strCreateTimeEnd)){
            $strWhere .= " and cm_customer_log.create_time < DATE_ADD('{$strCreateTimeEnd}',INTERVAL 1 day) ";
        }
        
        $iCheckState = Utility::GetFormInt("checkstate", $_GET);
        if($iCheckState > -100){
            $strWhere .= " and cm_customer_log.check_state = {$iCheckState} ";
        }
        return $strWhere;
    }
    
    public function showContractInfoList(){
        $this->PageRightValidate('ContractLogBack', RightValue::view);
        $this->smarty->assign("strUrl",  $this->getActionUrl("CM", "CMVerify", "showContractInfoBody"));
        $this->displayPage('CM/CheckManage/ContactLogInfoList.tpl');
    }
    
    public function showContractInfoBody(){
        $this->ExitWhenNoRight("ContractLogBack", RightValue::view);
        $strWhere = $this->getCustomerInfoWhere();
        $strOrder= Utility::GetForm("sortField", $_GET);
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrCustomerInfoList = $objCustomerLogBLL->getContactLogList($strWhere, $strOrder);
        for($i = 0;$i<count($arrCustomerInfoList['list']);$i++){
            $arrCustomerInfoList['list'][$i]['check_state_cn'] = CheckStatus::GetText($arrCustomerInfoList['list'][$i]['check_state']);
            $arrCustomerInfoList['list'][$i]['check_type_cn'] = CustomerLogCheckType::GetText($arrCustomerInfoList['list'][$i]['check_type']);
        }
        $this->showPageSmarty($arrCustomerInfoList, 'CM/CheckManage/ContactLogInfoBody.tpl');
    }
    
    public function GetAreaName()
    {
        $regareaid = Utility::GetForm("id", $_GET);
        $customerLogBLL = new CustomerLogBLL();
        $fullAreaName = $customerLogBLL->GetAreaName($regareaid);
        echo($fullAreaName);
    }
    
    public function showCustomerCheckPageByCustomerID(){
        $objCustomerLogBLL = new CustomerLogBLL();
        $iCustomerID = Utility::GetFormInt("customerid", $_GET);
        $_GET['logid'] = $objCustomerLogBLL->getLastCheck($iCustomerID, 1);
        $this->showCustomerCheckPage();
    }
    
    public function showCustomerCheckPage(){
        $iLogID = Utility::GetFormInt("logid", $_GET);
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLigInfo = $objCustomerLogBLL->getModelByID($iLogID);
        if (!$objCustomerLigInfo)
            die("获取审核信息失败");
        switch ($objCustomerLigInfo->iCheckType) {
            case 1: {
                    $objCustomerLigInfo->strCheckTypeCN = "新增审核";
                }break;
            case 2: {
                    $objCustomerLigInfo->strCheckTypeCN = "修改审核";
                }break;
            case 3: {
                    $objCustomerLigInfo->strCheckTypeCN = "删除审核";
                }break;
            default :$objCustomerLigInfo->strCheckTypeCN = "";
        }
        $this->smarty->assign("CheckType", $objCustomerLigInfo->strCheckTypeCN);
        $this->smarty->assign("CheckStateCN",  CheckStatus::GetText($objCustomerLigInfo->iCheckState));
        $this->smarty->assign("CheckUser",$objCustomerLigInfo->strCheckUserName);
        $this->smarty->assign("CheckTime",$objCustomerLigInfo->strCheckTime == '0000-00-00 00:00:00'?'':$objCustomerLigInfo->strCheckTime);
        $this->displayPage('CM/CheckManage/CheckPage.tpl');
    }
    
    public function showCHechInfo(){
        $this->PageRightValidate("CustomerInfoCheck", RightValue::v4);
        $iCheckType = Utility::GetFormInt("posttype", $_GET);
        if($iCheckType == 3){
            $this->showDelCheckInfo();
        }else{
            $this->showAddCheckInfo();
        }
    }
    
    public function showAddCheckInfo(){
        $iAid = Utility::GetFormInt("aid", $_GET);
        $iCheckType = Utility::GetFormInt("posttype", $_GET);
        
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogInfo = $objCustomerLogBLL->getModelByID($iAid);
        if(!$objCustomerLogInfo){
            Utility::Msg("获取申请数据出错");
        }
        $objCustomerBLL = new CustomerBLL();
        $objCustomerInfo = $objCustomerBLL->GetPushCustomerBefore($objCustomerLogInfo->iCustomerId);
        if(!$objCustomerInfo){
            Utility::Msg("获取客户信息失败");
        }
        $objCustomerInfo = $objCustomerInfo[0];
        $arrAreaFullName = $objCustomerBLL->getRegPlace($objCustomerInfo['reg_place']);
        if($arrAreaFullName){
            $objCustomerInfo['reg_full_place'] = $arrAreaFullName[0]['area_fullname'];
        }else{
            $objCustomerInfo['reg_full_place'] = "";
        }
        
        if ($iCheckType == 1) {
            $objContactBLL = new AgContactBLL();
            $objAgContactInfo = $objContactBLL->GetManagerByCustomerID($objCustomerInfo['customer_id']);
            $this->smarty->assign("ContantInfo", $objAgContactInfo);
        } else {
            $objChangeValue = json_decode($objCustomerLogInfo->strChangeValues);
            foreach (CustomerBLL::$_NeedCheckField as $item) {
                if (isset($objChangeValue->$item)) {
                    $objCustomerInfo[$item] = $objChangeValue->$item->newValue;
                    $objCustomerInfo[$item . '_old'] = $objChangeValue->$item->oldValue;
                }
            }
        }
        $this->smarty->assign("CheckType",$objCustomerLogInfo->iCheckType);
        $this->smarty->assign("CustomerInfo",$objCustomerInfo);
        $this->displayPage('CM/CheckManage/showAddCheck.tpl');
    }
    
    public function AddCheckInfo(){
        if (!$this->HaveRight("CustomerInfoCheck", RightValue::add)) {
            Utility::Msg("对不起，您没有权限");
        }
        $iAid = Utility::GetFormInt("logid", $_GET);
        $strCheckRemark = urldecode(Utility::GetForm("check_remark", $_POST));
        $iCheckState = Utility::GetFormInt("check_status", $_POST);
        if (empty($iAid))
            Utility::Msg("获取申请数据出错");
        if (empty($iCheckState))
            Utility::Msg("获取审核结果出错");
        //修改操作日志
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogBInfo = $objCustomerLogBLL->getModelByID($iAid);
        $objCustomerLogBInfo->iCheckUid = $this->getUserId();
        $objCustomerLogBInfo->strCheckTime = Utility::Now();
        $objCustomerLogBInfo->strCheckUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objCustomerLogBInfo->strCheckRemark = $strCheckRemark;
        $objCustomerLogBInfo->iCheckState = $iCheckState;
        $iLogRtn = $objCustomerLogBLL->updateByID($objCustomerLogBInfo);
        if ($iLogRtn === false) {
            Utility::Msg("审核失败");
        }
        //客户表审核信息
        $objCustomerBLL = new CustomerBLL();
        $arrEdit = array(
            'check_status' => $iCheckState,
            'check_remark' => $strCheckRemark,
            'check_uid' => $this->getUserId(),
            'check_user_name' => $objCustomerLogBInfo->strCheckUserName,
            'check_time' => Utility::Now(),
            'history_check' => ($iCheckState > 0 ? "1" : "0")
        );
        //关系表审核信息
        $arrAgentEdit = array(
            'check_status' => $iCheckState,
            'check_uid' => $this->getUserId(),
            'check_time' => Utility::Now(),
            'check_remark' => $strCheckRemark,
        );
        if ($iCheckState < 0) {
            $arrEdit['is_del'] = 0;
            $arrAgentEdit['is_del'] = 0;
        }
        $iCustomerRtn = $objCustomerBLL->UpdateData($arrEdit, 'customer_id=' . $objCustomerLogBInfo->iCustomerId);
        if ($iCustomerRtn <= 0) {
            Utility::Msg("更新客户数据失败");
        }
        $objCustomerAgentBLL = new CustomerAgentBLL();
        $iAgentRtn = $objCustomerAgentBLL->UpdateData($arrAgentEdit, "customer_id = {$objCustomerLogBInfo->iCustomerId} and is_del < 2");
        if($iAgentRtn <= 0){
            Utility::Msg("更新客户关系失败");
        }
        Utility::Msg("审核成功",true,  $this->getActionUrl("CM", "CMVerify", "showCustomerInfoCheckList"));
    }
    
    public function showDelCheckInfo(){
        $iAid = Utility::GetFormInt("aid", $_GET);
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrDelListList = $objCustomerLogBLL->getDelSeasonByAid($iAid);
        $this->smarty->assign('DelReason',$arrDelListList?$arrDelListList[0]['del_reason']:'');
        $this->smarty->assign('strTitle','客户删除审核');
        $this->displayPage('CM/CheckManage/showDelCheck.tpl');
    }
    
    public function DelCheckInfo(){
        if(!$this->HaveRight("CustomerInfoCheck", RightValue::add)){
            Utility::Msg("对不起，您没有权限");
        }
        $iAid = Utility::GetFormInt("logid", $_GET);
        $iCheckState = Utility::GetFormInt("check_status", $_POST);
        $strCheckRemark = urldecode(Utility::GetForm("check_remark", $_POST));
        if(empty ($iAid))
            Utility::Msg ("获取申请数据出错");
        if(empty ($iCheckState))
            Utility::Msg ("获取审核结果出错");
        
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogInfo = $objCustomerLogBLL->getModelByID($iAid);
        $objCustomerLogInfo->iCheckUid = $this->getUserId();
        $objCustomerLogInfo->strCheckTime = Utility::Now();
        $objCustomerLogInfo->strCheckUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objCustomerLogInfo->strCheckRemark = $strCheckRemark;
        $objCustomerLogInfo->iCheckState = $iCheckState;
        $iLogRtn = $objCustomerLogBLL->updateByID($objCustomerLogInfo);
        if($iLogRtn === false){
            Utility::Msg("审核失败");
        }
        
        $objCustomerAgentBLL = new CustomerAgentBLL();
        $iCustomerAgentRtn = $objCustomerAgentBLL->UpdateData(array(
                'check_status'=>$iCheckState,
                'check_remark'=>$strCheckRemark,
                'check_uid'=>  $this->getUserId(),
                'check_time'=>  Utility::Now(),
                'is_del'=>$iCheckState>0?2:0
        ),"customer_id = {$objCustomerLogInfo->iCustomerId} and agent_id={$objCustomerLogInfo->iAgentID}");
        
        $objCustomerBLL = new CustomerBLL();
        $iCustomerRtn = $objCustomerBLL->UpdateData(array(
                'is_del'=>$iCheckState>0?2:0
            ), "customer_id={$objCustomerLogInfo->iCustomerId}");
            
        if($iCustomerAgentRtn === false){
            Utility::Msg("更新审核信息失败");
        }
        if($iCustomerRtn === false){
            Utility::Msg("更新客户信息失败");
        }
        
        Utility::Msg("审核成功",true,  $this->getActionUrl("CM", "CMVerify", "showCustomerInfoCheckList"));
    }
    
    public function EditCheckInfo(){
        if (!$this->HaveRight("CustomerInfoCheck", RightValue::add)) {
            Utility::Msg("对不起，您没有权限");
        }
        
        $iAid = Utility::GetFormInt("logid", $_GET);
        $objCustomerLogBLL = new CustomerLogBLL();
        $objCustomerLogInfo = $objCustomerLogBLL->getModelByID($iAid);
        if(!$objCustomerLogInfo){
            Utility::Msg("获取客户信息失败");
        }
        $iCheckState = Utility::GetFormInt("check_status", $_POST);
        if ($iCheckState > 0) {
            $arrEditValue = array();
            $arrChangeValue = json_decode($objCustomerLogInfo->strChangeValues);
            foreach (CustomerBLL::$_NeedCheckField as $item) {
                if (isset($arrChangeValue->$item) && !isset($_POST[$item])) {
                    $arrEditValue[$item] = $arrChangeValue->$item->newValue;
                }
            }
            if (count($arrEditValue) > 0) {
                $objCustomerBLL = new CustomerBLL();
                $iCustomerRtn = $objCustomerBLL->UpdateData($arrEditValue, "customer_id = {$objCustomerLogInfo->iCustomerId}");
                if($iCustomerRtn === false){
                    Utility::Msg("修改客户信息失败");
                }
                if (isset($arrEditValue['customer_name'])) {
                    $objAgContactRecordBLL = new AgContactRecodeBLL();
                    $iRecordRtn = $objAgContactRecordBLL->UpdateData(array(
                        'customer_name' => $arrEditValue['customer_name']
                    ), "customer_id = {$objCustomerLogInfo->iCustomerId}");
                }
            }
        }
        
        $strCheckRemark = Utility::GetForm("check_remark", $_POST);
        
        $objCustomerLogInfo->iCheckState = $iCheckState;
        $objCustomerLogInfo->strCheckRemark = $strCheckRemark;
        $objCustomerLogInfo->strCheckTime = Utility::Now();
        $objCustomerLogInfo->strCheckUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objCustomerLogInfo->iCheckUid = $this->getUserId();
        $iLogRtn = $objCustomerLogBLL->updateByID($objCustomerLogInfo);
        if($iLogRtn === false){
            Utility::Msg("记录审核信息失败");
        }
        
        $objCustomerAgentBLL = new CustomerAgentBLL();
        $iAgentRtn = $objCustomerAgentBLL->UpdateData(array(
            'check_status'=>$iCheckState,
            'check_remark'=>$strCheckRemark,
            'check_uid'=>  $this->getUserId(),
            'check_time'=>  Utility::Now()
        ), "customer_id={$objCustomerLogInfo->iCustomerId} and agent_id={$objCustomerLogInfo->iAgentID}");
        if($iAgentRtn === false){
            Utility::Msg("更新客户关系失败");
        }
        
        Utility::Msg("审核成功",true,$this->getActionUrl("CM", "CMVerify", "showCustomerInfoCheckList"));
    }
    
    
    
    
    
//    private function TransEditContent($strChangeValue){
//        $objChangeValue = json_decode($strChangeValue);
//        var_dump($objChangeValue);
//        $arrOldValue = array();
//        $arrNewValue = array();
//        if(is_object($objChangeValue)){
//            foreach($objChangeValue as $key=>$Item){
//                $arrNewValue[] = "{$key}:{$Item}";
//            }
//        }else{
//            foreach($objChangeValue['oldvalue'] as $key=>$Item){
//                $arrOldValue[] = "{$key}:{$Item}";
//            }
//            foreach($objChangeValue['newvalue'] as $key=>$Item){
//                $arrNewValue[] = "{$key}:{$Item}";
//            }
//        }
//        return array(
//            'oldvalue'=>  implode('<br />', $arrOldValue),
//            'newvalue'=>  implode('<br />', $arrNewValue)
//        );
//    }
}
