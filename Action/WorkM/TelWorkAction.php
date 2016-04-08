<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：电话任务
 * 创建人：xxf
 * 添加时间：2012-12-11 
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../Common/Utility.php';
require_once __DIR__ . '/NoteBase.php';
require_once __DIR__.'/../../Class/BLL/VisitAppointBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentContactBLL.php';
require_once __DIR__.'/../../Class/BLL/ExpectChargeBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/IntentionRatingBLL.php';
require_once __DIR__.'/../../Class/BLL/ConstDataBLL.php';
require_once __DIR__.'/../../Class/BLL/VisitNoteBLL.php';

class TelWorkAction extends NoteBase { 
    public function __construct()
    {
    }
     
    public function Index()
    {
        $this->showAddTelInvite();
    }
    
    public function showAddTelInvite(){
        $this->PageRightValidate("TelTaskManage", RightValue::add);
        $iAppointId = Utility::GetFormInt("appointid", $_GET);
        //获取代理商ID
        $objVisitAppointBLL = new VisitAppointBLL();
        if(empty ($iAppointId)){
            $iAgentId = Utility::GetFormInt("agentid", $_GET);
        }else{
            $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
            if($objVisitAppointInfo){
                $iAgentId = $objVisitAppointInfo->iAgentId;
            }else{
                $iAgentId = 0;
            }  
        }
        $strSappointTime = Utility::GetForm("nexttime", $_GET);
        if(!$strSappointTime){
            $strSappointTime = Utility::addDay(Utility::Now(), 1);
        }
        
        //获取代理商名称
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($iAgentId);
        if($objAgentSourceInfo){
            $strAgentName = $objAgentSourceInfo->strAgentName;
        }
        //获取网盟意向
        $objExpectChargeBLL = new ExpectChargeBLL();
        $arrExpectInfo = $objExpectChargeBLL->getInfoByAgentId($iAgentId);
        if($arrExpectInfo){
            $strIntertionRating = $arrExpectInfo[0]['inten_level'];
        }
        
        $objAgentContactBLL = new AgentContactBLL();
        if (empty($iAppointId)) {//添加，则获取最近一条电话任务所使用的联系人
            $objVisitNoteBLL = new VisitNoteBLL();
            $arrLastNote = $objVisitNoteBLL->getLastNote($iAgentId);
            if ($arrLastNote) {
                $arrContactInfo = $objAgentContactBLL->getContactInfo($arrLastNote[0]['visitor'], $iAgentId);
            }
        } else {
            $arrContactInfo = $objAgentContactBLL->getContactInfoById($objVisitAppointInfo->iContactId);
        }
        if (isset ($arrContactInfo)&& $arrContactInfo) {
            $strVisitor = $arrContactInfo['contact_name'];
            $strTel = $arrContactInfo['tel'];
            $strMobile = $arrContactInfo['mobile'];
            $iIsCharge = $arrContactInfo['isCharge'];
            $iContactId = $arrContactInfo['aid'];
        }
        
        $this->smarty->assign('AppointId',$iAppointId);
        $this->smarty->assign("AgentID",$iAgentId);
        $this->smarty->assign("AgentName",  isset ($strAgentName)?$strAgentName:'');
        $this->smarty->assign("Visitor",  isset ($strVisitor)?$strVisitor:'');
        $this->smarty->assign("Tel",  isset ($strTel)?$strTel:'');
        $this->smarty->assign("Mobile",  isset ($strMobile)?$strMobile:'');
        $this->smarty->assign("IntentionRating",  isset ($strIntertionRating)?$strIntertionRating:'');
        $this->smarty->assign("ContactId",  isset ($iContactId)?$iContactId:0);
        $this->smarty->assign("IsCharge",  isset ($iIsCharge)?$iIsCharge:1);
        $this->smarty->assign("appointtime",  isset ($objVisitAppointInfo)?$objVisitAppointInfo->strSappointTime:$strSappointTime);
        $this->smarty->assign("title",  isset ($objVisitAppointInfo)?$objVisitAppointInfo->strTitle:'');
        $this->displayPage('Agent/WorkManagement/AddTelInvite.tpl');
    }
    
    public function AddTelInvite(){
        if(!$this->HaveRight("TelTaskManage", RightValue::add)){
            Utility::Msg("对不起，您没有权限");
        }
        $iAgentID = Utility::GetFormInt("agentid", $_POST);
        if(empty ($iAgentID))
            Utility::Msg("获取代理商信息失败");
        $strAppointTime = Utility::GetForm("appointtime", $_POST);
        if(empty ($strAppointTime))
            Utility::Msg("请设置联系时间");
        $strVisitor = Utility::GetForm("visitor", $_POST);
        if(empty ($strVisitor))
            Utility::Msg ("请填写被访人姓名");
        $strTel = Utility::GetForm("telphone", $_POST);
        $strMobile = Utility::GetForm("mobile", $_POST);
        if(empty ($strTel) && empty ($strMobile))
            Utility::Msg ("固话和手机必须填写一项");
        $strTitle = urldecode(Utility::GetForm("title", $_POST));
        $strIntenLevel = Utility::GetForm("intenlevel", $_GET);
        $iAppointId = Utility::GetFormInt("appointid", $_POST);
        
        //检查联系人信息，有出入则更新联系人表
        $iIsCharge = isset ($_POST['ischarge'])?0:1;
        $objAgentContactBLL = new AgentContactBLL();
        $arrContactInfo = $objAgentContactBLL->getContactInfo($strVisitor, $iAgentID); //查看该代理商是否存在同名的联系人
        if(empty ($arrContactInfo)){
            $objAgentContactInfo = new AgentContactInfo();
            $objAgentContactInfo->iAgentId = $iAgentID;
            $objAgentContactInfo->iEventType = 0;
            $objAgentContactInfo->iContactType = 0;
            $objAgentContactInfo->strContactName = $strVisitor;
            $objAgentContactInfo->strMobile = $strMobile;
            $objAgentContactInfo->iIscharge = $iIsCharge;
            $objAgentContactInfo->strTel = $strTel;
            $objAgentContactInfo->strCreateTime = Utility::Now();
            $objAgentContactInfo->iCreateUid = $this->getUserId();
            $objAgentContactInfo->iUpdateUid = $this->getUserId();
            $objAgentContactInfo->strUpdateTime = Utility::Now();
            $iContactRtn = $objAgentContactBLL->insert($objAgentContactInfo);
            if($iContactRtn !== false){
                $iContactId = $iContactRtn;
            }
        }else{  
            if($arrContactInfo['isCharge'] == 0 && $iIsCharge == 1){
                Utility::Msg("不允许由负责人直接修改为非负责人");
            }
            
            $arrEdit = array();
            if($iIsCharge != $arrContactInfo['isCharge'])
                $arrEdit['isCharge'] = $iIsCharge;
            if($strTel != $arrContactInfo['tel'])
                $arrEdit['tel'] = $strTel;
            if($strMobile != $arrContactInfo['mobile'])
                $arrEdit['mobile'] = $strMobile;
            if(count($arrEdit)> 0){
                $iContactRtn = $objAgentContactBLL->UpdateData($arrEdit, "aid={$arrContactInfo['aid']}");
            }
            $iContactId = $arrContactInfo['aid'];
        }  
        $objVisitAppointBLL = new VisitAppointBLL();
        if (empty($iAppointId)) {
            $objVisitAppointInfo = new VisitAppointInfo();
            $objVisitAppointInfo->iIsVisit = 1;
            $objVisitAppointInfo->iEuserId = $this->getUserId();
            $objVisitAppointInfo->iAgentId = $iAgentID;
            $objVisitAppointInfo->strRoleName = isset ($arrContactInfo['role'])?$arrContactInfo['role']:'';
            $objVisitAppointInfo->strPosition = isset ($arrContactInfo['position'])?$arrContactInfo['position']:'';
            $objVisitAppointInfo->iCreateId = $this->getUserId();
            $objVisitAppointInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
            $objVisitAppointInfo->strCreateTime = Utility::Now();
        }else{
            $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
            $objVisitAppointInfo->iCheckStatus = AgentCheckStatus::UnCheck;
        }
        $objVisitAppointInfo->strVisitor = $strVisitor;
        $objVisitAppointInfo->strTel = $strTel;
        $objVisitAppointInfo->strMobile = $strMobile;
        $objVisitAppointInfo->strTitle = $strTitle;
        $objVisitAppointInfo->strIntenLevel = $strIntenLevel;
        $objVisitAppointInfo->strSappointTime = $strAppointTime;
        $objVisitAppointInfo->iUpdateId = $this->getUserId();
        $objVisitAppointInfo->iContactId = $iContactId;
        $objVisitAppointInfo->strUpdateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitAppointInfo->strUpdateTime = Utility::Now();
        if(empty ($iAppointId)){
            $iRtn =$objVisitAppointBLL->insert($objVisitAppointInfo);
        }else{
            $iRtn =$objVisitAppointBLL->updateByID($objVisitAppointInfo);
        }
        if($iRtn === false){
            Utility::Msg("设置电话任务失败");
        }
        Utility::Msg("设置电话任务成功",true);
    }
    
    public function getContactInfoJson(){
        $iAgentID = Utility::GetFormInt("agentid", $_GET);
        $q = Utility::GetForm("q", $_GET);
        $objAgentContactBLL = new AgentContactBLL();
        $arrData = $objAgentContactBLL->getContactInfoJson($q, $iAgentID);
        echo json_encode(array('value'=>$arrData));
    }
    
    public function showTelTaskManageList(){
        if($this->HaveRight("TelTaskManage", RightValue::v64)){
            $this->PageRightValidate("TelTaskManage", RightValue::v64);
            $iViewType = 1;//全部
        }else if($this->HaveRight("TelTaskManage", RightValue::v128)){
            $this->PageRightValidate("TelTaskManage", RightValue::v128);
            $iViewType = 2; //自己以及下属
        }else{
            $this->PageRightValidate("TelTaskManage", RightValue::view);
            $iViewType = 3; //自己
        }
        $this->smarty->assign("ViewType",$iViewType);
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("WorkM", "TelWork", "showTelTaskManageBody"));
        $this->displayPage('Agent/WorkManagement/TelTaskManageList.tpl');
    }
    
    public function showTelTaskManageBody(){
        if($this->HaveRight("TelTaskManage", RightValue::v64)){
            $this->ExitWhenNoRight("TelTaskManage", RightValue::v64);
            $iViewType = 1;//全部
        }else if($this->HaveRight("TelTaskManage", RightValue::v128)){
            $this->ExitWhenNoRight("TelTaskManage", RightValue::v128);
            $iViewType = 2; //自己以及下属
        }else{
            $this->ExitWhenNoRight("TelTaskManage", RightValue::view);
            $iViewType = 3; //自己
        }
        $strWhere = $this->getTelTaskManageWhere($iViewType);
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objVisitAppointBLL = new VisitAppointBLL();
        $arrTelTaskManageList = $objVisitAppointBLL->getTelTaskManageList($strWhere, $strOrder);
        $this->smarty->assign("UserID",  $this->getUserId());
        $this->showPageSmarty($arrTelTaskManageList, 'Agent/WorkManagement/TelTaskManageBody.tpl');
    }
    
    public function getTelTaskManageWhere($iViewType){
        switch($iViewType){
            case 1: $strWhere = "";break;
            case 2: {
                /*
                $DeptNo = $this->getDeptNoBack();
                $strWhere = " and ( (v_hr_employee.dept_no like '{$DeptNo}%' and v_hr_employee.dept_no <> '{$DeptNo}') or am_visit_appoint.create_id = {$this->getUserId()}) ";    */
                $objVisitAppointBLL = new VisitAppointBLL();
                $strUid = $objVisitAppointBLL->GetLowPositionUser($this->getUserId());
                if($strUid != "")
                    $strWhere .= " and (am_visit_appoint.create_id = {$this->getUserId()} or am_visit_accompany.create_uid in({$strUid})) ";
                }break;
            default :$strWhere = " and am_visit_appoint.create_id = {$this->getUserId()} ";break;
        }
        
        $strWhere .=" and am_visit_appoint.is_visit = 1 ";
        
        $strAgentName = Utility::GetForm("agent_name", $_GET);
        if(!empty ($strAgentName)){
            $strWhere .= " and am_agent_source.agent_name like '%{$strAgentName}%'  ";
        }
        $iCheckStatus = Utility::GetFormInt("checkstatus", $_GET);
        if($iCheckStatus > -9){
            $strWhere .= " and am_visit_appoint.check_status  = {$iCheckStatus} ";
        }
        $strAppointTime = Utility::GetForm("appointtime", $_GET);
        if(!empty ($strAppointTime)){
            $strWhere .= " and am_visit_appoint.sappoint_time >= '{$strAppointTime}' ";
        }
        
        $strAppointTimeEnd = Utility::GetForm("appointtime_end", $_GET);
        if(!empty ($strAppointTimeEnd)){
            $strWhere .= " and am_visit_appoint.sappoint_time < DATE_ADD('{$strAppointTimeEnd}',INTERVAL 1 DAY) ";
        }
        
        $iViewTypeFront = Utility::GetFormInt("view_type", $_GET);
        if(!empty ($iViewTypeFront) && $iViewType != 3){
            if($iViewTypeFront == 1){//下属
            /*
                if(!isset ($DeptNo)){
                    $DeptNo = $this->getDeptNoBack();
                }
                $strWhere .= " and v_hr_employee.dept_no like '{$DeptNo}%' and v_hr_employee.dept_no <> '{$DeptNo}' ";*/
            
                $objVisitAppointBLL = new VisitAppointBLL();
                $strUid = $objVisitAppointBLL->GetLowPositionUser($this->getUserId());
                if($strUid != "")
                    $strWhere .= " and am_visit_accompany.create_uid in({$strUid}) ";
                    
            }else{//自己
                $strWhere .= " and am_visit_appoint.create_id = {$this->getUserId()} ";
            }
        }
        
        if($iViewTypeFront < 2){
            $strCreateUserName = Utility::GetForm("create_user", $_GET);
            if(!empty ($strCreateUserName)){
                $strWhere .= " and am_visit_appoint.create_user_name like '%{$strCreateUserName}%' ";
            }
        }
        
        $iNoteState = Utility::GetFormInt("note_state", $_GET);
        if($iNoteState >= 0){
            $strWhere .= " and am_visit_appoint.note = {$iNoteState} ";
        }
        
        return $strWhere;
    }
    
    public function DelAppointTask(){
        if(!$this->HaveRight("TelTaskManage", RightValue::del)){
            Utility::Msg("对不起，您没有权限");
        }
        $iAppointId = Utility::GetFormInt("appointid", $_POST);
        $objVisitAppointBLL = new VisitAppointBLL();
        $iRtn = $objVisitAppointBLL->deleteByID($iAppointId, $this->getUserId(), "{$this->getUserName()} {$this->getUserCNName()}");
        if($iRtn !== false){
            Utility::Msg("删除成功",true);
        }else{
            Utility::Msg("删除失败");
        }
    }
    
    public function showCheckTelInvite(){
        $this->PageRightValidate("TelTaskManage", RightValue::v16);
        $this->showCheckInvite();
    }
    
    public function showCheckVisitInvite(){
        $this->PageRightValidate("VisitAppoint", RightValue::v16);
        $this->showCheckInvite();
    }
    
    private function showCheckInvite(){
        $iAppointId = Utility::GetFormInt("appid", $_GET);
        if(!empty ($iAppointId)){
            $objVisitAppointBLL = new VisitAppointBLL();
            $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
            
            //获取代理商名称
            $objAgentSourceBLL = new AgentSourceBLL();
            $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($objVisitAppointInfo->iAgentId);
            if ($objAgentSourceInfo) {
                $strAgentName = $objAgentSourceInfo->strAgentName;
            }
            //获取网盟意向
            $objExpectChargeBLL = new ExpectChargeBLL();
            $arrExpectInfo = $objExpectChargeBLL->getInfoByAgentId($objVisitAppointInfo->iAgentId);
            if ($arrExpectInfo) {
                $strIntertionRating = $arrExpectInfo[0]['inten_level'];
            } 
        }
        $this->smarty->assign("IsVisit",$objVisitAppointInfo->iIsVisit);
        $this->smarty->assign("ModelInfo", isset ($objVisitAppointInfo)? $objVisitAppointInfo:array());
        $this->smarty->assign("AgentName", isset ($strAgentName)? $strAgentName:'');
        $this->smarty->assign("IntertionRating", isset ($strIntertionRating)? $strIntertionRating:'');
        $this->displayPage('Agent/WorkManagement/CheckTelInvite.tpl');
    }
    
    public function CheckTelInvite(){
        $this->ExitWhenNoRight('TelTaskManage', RightValue::v16);
        $iAppointId = Utility::GetFormInt("appid", $_GET);
        if(empty ($iAppointId)){
            Utility::Msg('获取数据失败');
        }
        $iCheckStatus = Utility::GetFormInt("checkstatus", $_POST);
        if(empty ($iCheckStatus)){
            Utility::Msg("获取审核数据失败");
        }
        $strCheckRemark =urldecode(Utility::GetForm("remark", $_POST));
        $objVisitAppointBLL = new VisitAppointBLL();
        $iRtn = $objVisitAppointBLL->UpdateData(array(
            'check_status'=>$iCheckStatus,
            'check_remark'=>$strCheckRemark,
            'check_time'=>  Utility::Now(),
            'check_user_name'=>"{$this->getUserName()} {$this->getUserCNName()}",
            'check_uid'=>  $this->getUserId()
        ), "appoint_id={$iAppointId}  and is_del = 0");
        
        if($iRtn === false){
            Utility::Msg("审核失败");
        }
        Utility::Msg("审核成功",true);
    }
    
    public function getCheckDetail() {
        $this->ExitWhenNoRight('TelTaskManage', RightValue::view);
        $iAppointId = Utility::GetFormInt("appid", $_GET);
        if ($iAppointId) {
            $objVisitAppointBLL = new VisitAppointBLL();
            $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
            $objVisitAppointInfo->strCheckStatusCN = AgentCheckStatus::GetText($objVisitAppointInfo->iCheckStatus);
        }
        $this->smarty->assign("ModelInfo", isset($objVisitAppointInfo) ? $objVisitAppointInfo : array());
        $this->displayPage('Agent/WorkManagement/CheckTelInviteDetail.tpl');
    }
    
    public function showAddTelNote(){
        $this->PageRightValidate("TelTaskManage", RightValue::v32);
        $iAppointId = Utility::GetFormInt('appid', $_GET);
        $objVisitAppointBLL = new VisitAppointBLL();
        //是否已指定预约
        $iIsSureAppoint = empty ($iAppointId)?0:1;
        if(!$iIsSureAppoint){
            $iAgentId = Utility::GetFormInt("agentid", $_GET);
            $arrAppointList = $objVisitAppointBLL->getAppointListByAgentId($iAgentId);
            $this->smarty->assign("AppointList", $arrAppointList);
            //获取最后拜访人信息（默认值）
            $objAgentContactBLL = new AgentContactBLL();
            $objVisitNoteBLL = new VisitNoteBLL();
            $arrLastAppoint = $objVisitNoteBLL->getLastNote($iAgentId);
            if ($arrLastAppoint) {
                $arrContactInfo = $objAgentContactBLL->getContactInfo($arrLastAppoint[0]['visitor'], $iAgentId);
            }
        }else{
            $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
            $this->smarty->assign("AppointInfo",$objVisitAppointInfo);
            $iAgentId = $objVisitAppointInfo->iAgentId;
            
            //获取拜访人信息
            $objAgentContactBLL = new AgentContactBLL();
            $arrContactInfo = $objAgentContactBLL->getContactInfo($objVisitAppointInfo->strVisitor, $iAgentId);
        }
        //获取代理商信息
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($iAgentId);
        
        //获取联系内容
        $objConstDataBLL = new ConstDataBLL();
        $arrayAgentContactContent = $objConstDataBLL->select("*","data_type='".AgentCommSet::Agent_Contact_Content."'","");
        //判断是否签约代理商
        $iIsPact = ($objAgentSourceInfo->strAgentNo == $objAgentSourceInfo->iAgentId)?0:1;
        $objProductTypeBLL = new ProductTypeBLL();
        if($iIsPact){
            $arrProductType = $objProductTypeBLL->GetAgentProductType($iAgentId);
        }else{
            $arrProductType = $objProductTypeBLL->GetProductType();
        }
        
        
        
        //获取网盟意向
        $objExpectChargeBLL = new ExpectChargeBLL();
        $arrExpectInfo = $objExpectChargeBLL->getInfoByAgentId($iAgentId);
        if(isset($arrExpectInfo[0])){
            $arrExpectInfo = $arrExpectInfo[0];
        } else {
            //获取网盟的ID，默认为选择网盟产品
            $objProductTypeBLL = new ProductTypeBLL();
            $iAdhaiProductId = $objProductTypeBLL->GetUnitProductTypeID();
            $arrExpectInfo = array('inten_level' => 'E', 'product_id' => $iAdhaiProductId);
        }
        $this->smarty->assign("ExpectInfo", $arrExpectInfo);
        $this->smarty->assign("ContactContent",$arrayAgentContactContent);
        $this->smarty->assign("IsPact",$iIsPact);
        $this->smarty->assign("IsSureAppoint", $iIsSureAppoint);
        $this->smarty->assign("ProductType",$arrProductType);
        $this->smarty->assign("AgentInfo",$objAgentSourceInfo);
        $this->smarty->assign("ContactInfo",  isset ($arrContactInfo)?$arrContactInfo:array());
        $this->displayPage('Agent/WorkManagement/AddTelNote.tpl');
    }
    
    public function AddTelNote(){
        if(!$this->HaveRight("TelTaskManage", RightValue::v32)){
            Utility::Msg("对不起,您没有权限");
        }
        $objAgentSourceInfo = null;
        $arrPostInfo = $this->getPostInfo($objAgentSourceInfo);
        //查看联系人是否改变，若改变则更新联系人信息
        $arrChangeInfo = $this->getUpdateInfoByContact($arrPostInfo);
        if ($arrChangeInfo) {
            $iUpdateRtn = $this->UpdateContactInfo($arrChangeInfo);
            if ($iUpdateRtn === false) {
                Utility::Msg("更新联系人信息失败");
            }
        }
        
        //添加联系小记
        $objAgentSourceBLL = new AgentSourceBLL();
        $objVisitNoteInfo = new VisitNoteInfo();
        $objVisitNoteInfo->iVisitnoteid = $arrPostInfo['iAppointId'];
        $objVisitNoteInfo->iAgentId = $arrPostInfo['iAgentID'];
        $objVisitNoteInfo->iIsVisit = 1;
        $objVisitNoteInfo->strAfterlevel = $arrPostInfo['iIntentionRating'];
        $objVisitNoteInfo->iAfterProductid = $arrPostInfo['iProductTypeId'];
        $objVisitNoteInfo->strProductName = $arrPostInfo['strProductType'];
        $objVisitNoteInfo->strVisitor = $arrPostInfo['strVisitor'];
        $objVisitNoteInfo->strMobile = $arrPostInfo['strMobile'];
        $objVisitNoteInfo->strTel = $arrPostInfo['strTel'];
        $objVisitNoteInfo->strVisitTimestart = $arrPostInfo['strVisitTime'];
        $objVisitNoteInfo->iContactContentId = $arrPostInfo['iContactContentId'];
        $objVisitNoteInfo->strResult = $arrPostInfo['strContactContent'];
        $objVisitNoteInfo->strFollowUpTime = $arrPostInfo['strNextVisitTime'];
        $objVisitNoteInfo->strCreateTime = Utility::Now();
        if($arrPostInfo['iContactType'] || $arrPostInfo['iIntentionRating'] >'B-'){
            $objVisitNoteInfo->iIsVertifyed = 2;//已经签约或B-以下的不质检
        }
        $objVisitNoteInfo->iCreateUid = $this->getUserId();
        $objVisitNoteInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitNoteInfo->strUpdateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objVisitNoteInfo->strUpdateTime = Utility::Now();
        $objVisitNoteInfo->iUpdateUid = $this->getUserId();
        $objVisitNoteInfo->iContactType = $arrPostInfo['iContactType'];
        $objVisitNoteBll = new VisitNoteBLL();
        $iNoteRtn = $objVisitNoteBll->insert($objVisitNoteInfo);
        if($iNoteRtn === false){
            Utility::Msg("添加联系小记失败");
        }
        
        
            //更新代理商意向
       $this->addExpectInfo(
               $arrPostInfo['iAgentID'], 
               isset ($arrPostInfo['strIncomeTime'])?$arrPostInfo['strIncomeTime']:'', 
               isset ($arrPostInfo['dIncomeMoney'])?$arrPostInfo['dIncomeMoney']:0,
               isset ($arrPostInfo['dIncomeRate'])?$arrPostInfo['dIncomeRate']:0,
               isset ($arrPostInfo['iIncomeType'])?$arrPostInfo['iIncomeType']:0,
               isset ($arrPostInfo['iIntentionRating'])?$arrPostInfo['iIntentionRating']:'A', 
               $arrPostInfo['iProductTypeId'], 
               $iNoteRtn,$arrPostInfo['iHasIncome']);
     
        
       
        //更新行业动态
        $iDynamicsRtn = $objAgentSourceBLL->UpdateDynamics($arrPostInfo['strDynamics'], $arrPostInfo['iAgentID']);
        if($iDynamicsRtn === false){
            Utility::Msg("更新行业动态失败");
        }
        
        
        //判断是否关联电话任务，若关联，则更新电话任务为已添加联系小记
        $objVisitAppointBLL = new VisitAppointBLL();
        if(!empty ($arrPostInfo['iAppointId'])){
            $iAppointFlagRtn = $objVisitAppointBLL->setNoteAdded($arrPostInfo['iAppointId']);
        }
        
        if(!empty ($arrPostInfo['strNextVisitTime'])){//是否设定下次联系时间，设定的话添加一条电话任务
            Utility::Msg("添加联系小记成功",true,  $this->getActionUrl("WorkM", "TelWork", "showAddTelInvite", "agentid={$arrPostInfo['iAgentID']}&nexttime={$arrPostInfo['strNextVisitTime']}"));
//            $objVisitAppointInfo = new VisitAppointInfo();
//            $objVisitAppointInfo->iIsVisit = 1;
//            $objVisitAppointInfo->iEuserId = $this->getUserId();
//            $objVisitAppointInfo->iAgentId = $arrPostInfo['iAgentID'];
//            $objVisitAppointInfo->iCreateId = $this->getUserId();
//            $objVisitAppointInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
//            $objVisitAppointInfo->strCreateTime = Utility::Now();
//            $objVisitAppointInfo->strVisitor = $arrPostInfo['strVisitor'];
//            $objVisitAppointInfo->strTel = $arrPostInfo['strTel'];
//            $objVisitAppointInfo->strMobile = $arrPostInfo['strMobile'];
//            $objVisitAppointInfo->strTitle = $arrPostInfo['strContactContent'];
//            $objVisitAppointInfo->strIntenLevel = $arrPostInfo['iIntentionRating'];
//            $objVisitAppointInfo->strSappointTime = $arrPostInfo['strNextVisitTime'];
//            $objVisitAppointInfo->iUpdateId = $this->getUserId();
//            $objVisitAppointInfo->iContactId = $arrPostInfo['iContactId'];
//            $objVisitAppointInfo->strUpdateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
//            $objVisitAppointInfo->strUpdateTime = Utility::Now();
//            $iAppointRtn = $objVisitAppointBLL->insert($objVisitAppointInfo);
        }
        
        Utility::Msg("添加联系小记成功",true);
    }
    
    private function getPostInfo(&$objAgentSourceInfo){
        $arrPostInfo = array();
        //获取ID信息
        $arrPostInfo['iAppointId'] = Utility::GetFormInt("appointid", $_POST);
        $arrPostInfo['iAgentID'] = Utility::GetFormInt("agentId", $_POST);
        if (empty($arrPostInfo['iAgentID']))
            Utility::Msg("获取代理商信息失败");
        //获取签约信息
        $arrPostInfo['strProductType'] = urldecode(Utility::GetForm("productType", $_POST));
        if ($arrPostInfo['strProductType'] == '-100')
            Utility::Msg("请选择意向产品");
        list($arrPostInfo['iProductTypeId'], $arrPostInfo['strProductType']) = explode('|', $arrPostInfo['strProductType']);
        
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($arrPostInfo['iAgentID']);
        $arrPostInfo['iContactType'] = $objAgentSourceInfo->iAgentId == $objAgentSourceInfo->strAgentNo ? 0 : 1;
        if($arrPostInfo['iContactType']){//签约
            $arrPostInfo['iIntentionRating'] = 'A+';
            $arrPostInfo['iHasIncome'] = isset($_POST['hasIncome']) ? 1 : 0;
            if ($arrPostInfo['iHasIncome']) {
                $arrPostInfo['strIncomeTime'] = Utility::GetForm("incomeDate", $_POST);
                if (empty($arrPostInfo['strIncomeTime']))
                    Utility::Msg("请确认预计到账时间");
                $arrPostInfo['dIncomeMoney'] = Utility::GetFormDouble("incomeMoney", $_POST);
                if (empty($arrPostInfo['dIncomeMoney']))
                    Utility::Msg("请填写预计到账金额");
                $arrPostInfo['dIncomeRate'] = Utility::GetFormDouble("incomeRate", $_POST);
                if (empty($arrPostInfo['dIncomeRate']))
                    Utility::Msg("请填写预计达成率");
                $arrPostInfo['iIncomeType'] = Utility::GetFormInt("incomeType", $_POST);
            }
        }else {//未签约
            //意向等级
            $arrPostInfo['iIntentionRating'] = urldecode(Utility::GetForm("intentionRating", $_POST));
            $arrPostInfo['iHasIncome'] = $arrPostInfo['iIntentionRating'] <= 'B+' ? 1 : 0;
            if ($arrPostInfo['iHasIncome']) {//若意向等级在B+以上，则验证预计到账信息
                $arrPostInfo['strIncomeTime'] = Utility::GetForm("incomeDate", $_POST);
                if (empty($arrPostInfo['strIncomeTime']))
                    Utility::Msg("请确认预计到账时间");
                $arrPostInfo['dIncomeMoney'] = Utility::GetFormDouble("incomeMoney", $_POST);
                if (empty($arrPostInfo['dIncomeMoney']))
                    Utility::Msg("请填写预计到账金额");
                $arrPostInfo['dIncomeRate'] = Utility::GetFormDouble("incomeRate", $_POST);
                if (empty($arrPostInfo['dIncomeRate']))
                    Utility::Msg("请填写预计达成率");
                $arrPostInfo['iIncomeType'] = Utility::GetFormInt("incomeType", $_POST);
            }else {
                $arrPostInfo['strIncomeTime'] = '';
                $arrPostInfo['dIncomeMoney'] = 0;
                $arrPostInfo['dIncomeRate'] = 0;
                $arrPostInfo['iIncomeType'] = 0;
            }
        }
        //被访人信息
        $arrPostInfo['strVisitor'] =urldecode(Utility::GetForm("con_visitor", $_POST));
        if(empty ($arrPostInfo['strVisitor']))
            Utility::Msg ("请填写被访人");
        $arrPostInfo['iContactId'] = Utility::GetFormInt("con_id", $_POST);;
        $arrPostInfo['iIsCharge'] = isset ($_POST['con_isChargePerson'])?0:1;
        $arrPostInfo['strMobile'] = Utility::GetForm("con_mobile", $_POST);
        $arrPostInfo['strTel'] = Utility::GetForm("con_tel", $_POST);
        if(empty ($arrPostInfo['strMobile']) && empty ($arrPostInfo['strTel'])){
            Utility::Msg("手机电话必填一项");
        }
        $arrPostInfo['strPosition'] = urldecode(Utility::GetForm("con_position", $_POST));
        $arrPostInfo['strFax'] = Utility::GetForm("con_fax", $_POST);
        $arrPostInfo['strEmail'] = urldecode(Utility::GetForm("con_email", $_POST));
        $arrPostInfo['iQq'] = Utility::GetForm("con_qq", $_POST);
        $arrPostInfo['strMsn'] =urldecode(Utility::GetForm("con_msn", $_POST));
        $arrPostInfo['strWeiBo'] = Utility::GetForm("con_weibo", $_POST);
        $arrPostInfo['strRemark'] = urldecode(Utility::GetForm("con_remark", $_POST));
        //联系人内容信息
        $arrPostInfo['strVisitTime'] = urldecode(Utility::GetForm("visit_time", $_POST));
        if(empty ($arrPostInfo['strVisitTime']))
            Utility::Msg ("请填写联系时间");
        $arrPostInfo['strVisitTime'] = "{$arrPostInfo['strVisitTime']}:00";
        $arrPostInfo['iContactContentId'] = Utility::GetFormInt("visit_content", $_POST);
        if(empty ($arrPostInfo['iContactContentId'])){
            $arrPostInfo['strContactContent'] = urldecode(Utility::GetForm("visit_content_new", $_POST));
            if(empty ($arrPostInfo['strContactContent']))
                Utility::Msg ("请填写联系小记内容");
        }else{
            $objConstDataBLL = new ConstDataBLL();
            $objConstDataInfo = $objConstDataBLL->getModelByID($arrPostInfo['iContactContentId'],AgentCommSet::Agent_Contact_Content);
            $arrPostInfo['strContactContent'] = $objConstDataInfo?$objConstDataInfo->strcValue:"";
        }
        $arrPostInfo['strDynamics'] = urldecode(Utility::GetForm("dynamics", $_POST));
        $arrPostInfo['strNextVisitTime'] = Utility::GetForm("next_visit_time", $_POST);
        return $arrPostInfo;
    }
    
    
    
    public function getAppointInfo(){
        $iAppointId = Utility::GetFormInt("appid", $_POST);
        if(!empty ($iAppointId)){
            $objVisitAppointBLL = new VisitAppointBLL();
            $objVisitAppointInfo = $objVisitAppointBLL->getModelByID($iAppointId);
            $objAgentContactBLL = new AgentContactBLL();
            $arrContactInfo = $objAgentContactBLL->getContactInfo($objVisitAppointInfo->strVisitor, $objVisitAppointInfo->iAgentId);
            exit(json_encode(array(
                'status'=>true,
                'appointid'=>$objVisitAppointInfo->iAppointId,
                'aid'=>$arrContactInfo['aid'],
                'visitor'=>$arrContactInfo['contact_name'],
                'isCharge'=>$arrContactInfo['isCharge'],
                'mobile'=>$arrContactInfo['mobile'],
                'tel'=>$arrContactInfo['tel'],
                'position'=>$arrContactInfo['position'],
                'fax'=>$arrContactInfo['fax'],
                'email'=>$arrContactInfo['email'],
                'qq'=>$arrContactInfo['qq'],
                'msn'=>$arrContactInfo['msn'],
                'twitter'=>$arrContactInfo['twitter'],
                'agent_remark'=>$arrContactInfo['agent_remark'],
                'sappoint_time'=>$objVisitAppointInfo->strSappointTime,
                'title'=>$objVisitAppointInfo->strTitle
            )));
        }
        exit(json_encode(array('status'=>false)));
    }
    
    public function getIncomeInfoFromNote(){
        if(!$this->HaveRight("AgentList", RightValue::v8)){
            exit("您没有此操作权限！");
        }
        $iNoteId = Utility::GetFormInt("noteId", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($iNoteId);
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($objVisitNoteInfo->iAgentId);
        $this->smarty->assign('NoteInfo',$objVisitNoteInfo);
        $this->smarty->assign('AgentInfo',$objAgentSourceInfo);
        echo $this->smarty->fetch('Agent/WorkManagement/IncomeInfoFromNote.tpl');
    }
    
    public function getTelNoteDetail(){
        if(!$this->HaveRight("AgentList", RightValue::v8)){
            exit("您没有此操作权限！");
        }
        $iNoteId = Utility::GetFormInt("noteId", $_GET);
        $objVisitNoteBLL = new VisitNoteBLL();
        $objVisitNoteInfo = $objVisitNoteBLL->getModelByID($iNoteId);
        if($objVisitNoteInfo){
            $objVisitNoteInfo->strExpectTypeCN = AgentIncomeType::getText($objVisitNoteInfo->iExpectType);
        }
        $objAgentSourceBLL = new AgentSourceBLL();
        $objAgentSourceInfo = $objAgentSourceBLL->getModelByID($objVisitNoteInfo->iAgentId);
        $this->smarty->assign('NoteInfo',$objVisitNoteInfo);
        $this->smarty->assign('AgentInfo',$objAgentSourceInfo);
        echo $this->smarty->fetch('Agent/WorkManagement/TelNoteInfoDetail.tpl');
    }
    
    

}

?>
