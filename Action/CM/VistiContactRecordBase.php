<?php

/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：小记模块
 * 创建人：wzx
 * 添加时间：2012-10-19 
 * 修改人：      修改时间：
 * 修改描述：
 * */

require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AgContactRecodeBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerBLL.php';
require_once __DIR__.'/../../Class/BLL/IntentionRatingBLL.php';
require_once __DIR__.'/../../Class/BLL/DataConfigBLL.php';
require_once __DIR__.'/../../Class/BLL/ConstDataBLL.php';
require_once __DIR__.'/../../Class/BLL/AgContactBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerLogBLL.php';

class VistiContactRecordBase extends ActionBase
{
    public function __construct()
    {
    }
    
    /**
     * @functional 添加的时候取得Model
    */
    protected function f_getInfoForModify($id)
    {        
        $objAgContactRecodeInfo = null;
        $isManager = 0;
        $inviteID = 0;
        
        if($id <= 0)
        {
            $inviteID = Utility::GetFormInt('inviteID',$_GET);
            $id = $inviteID;
            
            $objAgContactRecodeBLL = new AgContactRecodeBLL();
            if($id > 0)
            {
                $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
            }
            
            if($objAgContactRecodeInfo == null)
            {
                $objAgContactRecodeInfo = new AgContactRecodeInfo();
                $objAgContactRecodeInfo->strContactTime = "";
                
                $customerID = Utility::GetFormInt('customerID',$_GET);        
                if($customerID > 0) //添加
                {
                    $objAgContactRecodeInfo->iCustomerId = $customerID;
                    $objCustomerBLL = new CustomerBLL();
                    $arrayData = $objCustomerBLL->selectTop("cm.customer_name"," cm.customer_id=ag.customer_id and ag.customer_id=$customerID and ag.agent_id=".$this->getAgentId().
                        " and ag.service_user_no like '".$this->getUserNo()."%'","","",1);

                    if(isset($arrayData)&&count($arrayData)>0)
                    {
                        $objAgContactRecodeInfo->strCustomerName = $arrayData[0]["customer_name"];
                        
                        //找到客户主要联系人
                        $objAgContactBLL = new AgContactBLL();
                        $arrayData = $objAgContactBLL->selectTop("contact_name,contact_tel,contact_mobile,isCharge","customer_id=$customerID and agent_id=".$this->getAgentId(),
                            "isCharge desc,contact_id","",1);
                        if(isset($arrayData)&&count($arrayData))
                        {
                            $objAgContactRecodeInfo->strContactName = $arrayData[0]["contact_name"];
                            $objAgContactRecodeInfo->strContactTel = $arrayData[0]["contact_tel"];
                            $objAgContactRecodeInfo->strContactMobile = $arrayData[0]["contact_mobile"];
                            
                            $objAgContactRecodeInfo->strInviteContactName = $arrayData[0]["contact_name"];
                            $objAgContactRecodeInfo->strInviteContactTel = $arrayData[0]["contact_tel"];
                            $objAgContactRecodeInfo->strInviteContactMobile = $arrayData[0]["contact_mobile"];
                            $isManager = $arrayData[0]["isCharge"];
                        }
                    }
                    else
                        exit("未找到客户。");
                        
                    $objAgContactRecodeInfo->strInviteTime = "";
                    $objAgContactRecodeInfo->strInviteETime = "";
                    
                    $arrInviteList = $objAgContactRecodeBLL->select("recode_id,invite_contact_name,invite_contact_mobile,invite_contact_tel", "create_uid = 0 and is_visit = 0 and is_del = 0 and agent_id = {$this->getAgentId()} and customer_id = {$customerID}");
                    $this->smarty->assign("InvitelList",$arrInviteList);
                }
            }
            else //
            {   
                if($objAgContactRecodeInfo->iInviteCreateUid > 0)
                {
                    $objAgContactRecodeInfo->strContactTime = $objAgContactRecodeInfo->strInviteTime;
                    $objAgContactRecodeInfo->strContactETime = $objAgContactRecodeInfo->strInviteETime;
                }
                else
                {
                    $objAgContactRecodeInfo->strContactTime = "";                    
                }
                
                //找到客户主要联系人
                $objAgContactBLL = new AgContactBLL();
                $objAgContactRecodeInfo->strContactName = $objAgContactRecodeInfo->strInviteContactName;
                $objAgContactRecodeInfo->strContactTel = $objAgContactRecodeInfo->strInviteContactTel;
                $objAgContactRecodeInfo->strContactMobile = $objAgContactRecodeInfo->strInviteContactMobile;
                $arrayData = $objAgContactBLL->selectTop("contact_name,contact_tel,contact_mobile,isCharge","customer_id=".$objAgContactRecodeInfo->iCustomerId
                    ." and agent_id=".$this->getAgentId()." and contact_name='".$objAgContactRecodeInfo->strInviteContactName."'","isCharge desc,contact_id","",1);
                if(isset($arrayData)&&count($arrayData)>0)
                {
                    $objAgContactRecodeInfo->strContactTel = $arrayData[0]["contact_tel"];
                    $objAgContactRecodeInfo->strContactMobile = $arrayData[0]["contact_mobile"];
                    if($arrayData[0]["isCharge"]==1)
                        $isManager = 1;
                }
            }
            
        }
        else
        {
            //目前还没有编辑功能 还不需要编码
            
        }
        
        $iHavePredictIncome = 0;
        $objPredictIncomeInfo = $objAgContactRecodeBLL->GetPredictIncome($objAgContactRecodeInfo->iCustomerId,$this->getAgentId());
        if($objPredictIncomeInfo != null)
            $iHavePredictIncome = 1;
        
        $this->smarty->assign('iHavePredictIncome',$iHavePredictIncome);
        $this->smarty->assign('objPredictIncomeInfo',$objPredictIncomeInfo);
        
        $this->smarty->assign('inviteID',$inviteID);
        $this->smarty->assign('isManager',$isManager);
        $this->smarty->assign('objAgContactRecodeInfo',$objAgContactRecodeInfo);
    }
    
    /**
     * @functional 添加下次联系预约
     * @param 当前做的 联系或拜访 Model
     * @param 下次联系时间
    */
    protected function f_addNextInvite(AgContactRecodeInfo $objAgContactRecodeInfo,$strInviteTime)
    {
        if($strInviteTime == "")
            return ;
            
        $objInvite = new AgContactRecodeInfo();
        $objInvite->iSourceId = $objAgContactRecodeInfo->iRecodeId;
        $objInvite->iIsVisit = 0;//$objAgContactRecodeInfo->iIsVisit;
        $objInvite->iAgentId = $objAgContactRecodeInfo->iAgentId;
        $objInvite->strAgentNo = $objAgContactRecodeInfo->strAgentNo;
        $objInvite->strAgentName = $objAgContactRecodeInfo->strAgentName;
        $objInvite->iCustomerId = $objAgContactRecodeInfo->iCustomerId;
        $objInvite->strCustomerName = $objAgContactRecodeInfo->strCustomerName;
        $objInvite->strInviteContactName = $objAgContactRecodeInfo->strContactName;
        $objInvite->strInviteContactTel = $objAgContactRecodeInfo->strContactTel;
        $objInvite->strInviteContactMobile = $objAgContactRecodeInfo->strContactMobile;
        $objInvite->strInviteTime = $strInviteTime;
        $objInvite->strInviteCreateTime = Utility::Now();
        $objInvite->iInviteCreateUid = $this->getUserId();
        $objInvite->strInviteCreateUserName = $this->getUserName()." ".$this->getUserCNName();
        $objInvite->iFinanceUid = $this->getFinanceUid();
        $objInvite->strFinanceNo = $this->getFinanceNo();
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeBLL->insert($objInvite);
    }

    protected function f_UpdateCustomerManager($customerID,$name,$tel,$mobile,$isManager)
    {
        //找到客户主要联系人
        $objAgContactBLL = new AgContactBLL();
        $objCustomerLogBLL = new CustomerLogBLL();
        $arrayData = $objAgContactBLL->selectTop("contact_id,contact_tel,contact_mobile,isCharge,customer_id","contact_name='{$name}' and customer_id=$customerID and is_del = 0 and agent_id=".$this->getAgentId(),
            "isCharge desc,contact_id","",1);
        if(isset($arrayData)&&count($arrayData))
        {
            if($arrayData[0]["contact_tel"] != $tel || $arrayData[0]["contact_mobile"] != $mobile)
            {
                if($arrayData[0]['isCharge'] == 0){
                    $objAgContactInfo = $objAgContactBLL->getModelByID($arrayData[0]["contact_id"], $this->getAgentId());
                    if ($objAgContactInfo == null)
                        return;
                    $objAgContactInfo->strContactTel = $tel;
                    $objAgContactInfo->strContactMobile = $mobile;
                    $objAgContactBLL->updateByID($objAgContactInfo);
                }
                $arrChargeValue = array();
                if ($arrayData[0]["contact_tel"] != $tel) {
                    $arrChargeValue[] = '"contact_tel":{"oldValue":"' . $arrayData[0]['contact_tel'] . '","newValue":"' . $tel . '"}';
                }
                if ($arrayData[0]["contact_mobile"] != $tel) {
                    $arrChargeValue[] = '"contact_mobile":{"oldValue":"' . $arrayData[0]['contact_mobile'] . '","newValue":"' . $mobile . '"}';
                }
                $objCustomerLogInfo = new CustomerLogInfo();
                $objCustomerLogInfo->iCustomerId = $arrayData[0]['customer_id'];
                $objCustomerLogInfo->iContactId = $arrayData[0]['contact_id'];
                $objCustomerLogInfo->iAgentID = $this->getAgentId();
                $objCustomerLogInfo->strChangeValues = "{" . implode(',', $arrChargeValue) . "}";
                $objCustomerLogInfo->iCreateUid = $this->getUserId();
                $objCustomerLogInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
                $objCustomerLogInfo->strCreateTime = Utility::Now();
                $objCustomerLogInfo->iCheckState = $arrayData[0]['isCharge'] == 0? CheckStatus::notPost:CheckStatus::auditting;
                $objCustomerLogInfo->iLogType = 2;
                $objCustomerLogInfo->iCheckType = CustomerLogCheckType::Edit;
                $iLogRtn = $objCustomerLogBLL->insert($objCustomerLogInfo);
            }            
        }
        else
        {
            $objAgContactInfo = new AgContactInfo();
            $objAgContactInfo->iCustomerId = $customerID;
            $objAgContactInfo->iIscharge = 0;
            $objAgContactInfo->iAgentId = $this->getAgentId();
            $objAgContactInfo->strContactName = $name;
            $objAgContactInfo->iContactSex = 0;
            $objAgContactInfo->strContactTel = $tel;
            $objAgContactInfo->strContactMobile = $mobile;
            $objAgContactInfo->iCreateUid = $this->getUserId();
            $objAgContactInfo->strCreateTime = Utility::Now();
            $iContactId = $objAgContactBLL->insert($objAgContactInfo);
            if($iContactId > 0){
                
                $objCustomerLogInfo = new CustomerLogInfo();
                $objCustomerLogInfo->iCustomerId = $objAgContactInfo->iCustomerId;
                $objCustomerLogInfo->iAgentID = $objAgContactInfo->iAgentId;
                $objCustomerLogInfo->iContactId = $iContactId;
                $objCustomerLogInfo->iCreateUid = $this->getUserId();
                $objCustomerLogInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
                $objCustomerLogInfo->strCreateTime = Utility::Now();
                $objCustomerLogInfo->iCheckState = CheckStatus::notPost;
                $objCustomerLogInfo->iLogType = 2;
                $objCustomerLogInfo->iCheckType = CustomerLogCheckType::Add;
                $iLogRtn = $objCustomerLogBLL->insert($objCustomerLogInfo);
            }
        }
    }
    
    public function GetContactInfo()
    {
        $customerID = Utility::GetFormInt('customerID',$_GET); 
        $contactID = Utility::GetFormInt('contactID',$_GET);         
        if($customerID <= 0 || $contactID <= 0)
            exit("");
            
        $objCustomerBLL = new CustomerBLL();
        $arrayData = $objCustomerBLL->getContactInfo($contactID,$customerID,$this->getAgentId());
        if(isset($arrayData)&&count($arrayData)>0)
        {
            exit(json_encode($arrayData[0]));
        }
        
        exit("");
        
    }
    
    /**
     * @functional 预约列表内容
    */
    protected function InviteListBody($is_visit,$strTPLPath)
    {        
        $sWhere = " and cm_ag_contact_recode.agent_id=".$this->getAgentId()." and cm_ag_contact_recode.finance_uid=".$this->getFinanceUid()
            ." and cm_ag_contact_recode.invite_create_uid=".$this->getUserId()." and cm_ag_contact_recode.is_visit = $is_visit";
            
        $tbxCustomerID = Utility::GetFormInt('tbxCustomerID',$_GET,-100);
        if($tbxCustomerID >0)
            $sWhere .= " and cm_ag_contact_recode.customer_id=".$tbxCustomerID;
            
        $cbInviteStatus = Utility::GetFormInt('cbInviteStatus',$_GET,-100);
        if($cbInviteStatus != -100)
            $sWhere .= " and cm_ag_contact_recode.invite_status=".$cbInviteStatus;
        
        $cbRevisitStatus = Utility::GetFormInt('cbRevisitStatus',$_GET,-100);
        if($cbRevisitStatus == 0)
            $sWhere .= " and cm_ag_contact_recode.create_uid>0 and cm_ag_contact_recode.revisit_uid <= 0";
        else if($cbRevisitStatus == 1)
            $sWhere .= " and cm_ag_contact_recode.create_uid>0 and cm_ag_contact_recode.revisit_uid > 0";
        
        $tbxContactName = Utility::GetForm('tbxContactName',$_GET,20);
        if($tbxContactName != "")
            $sWhere .= " and cm_ag_contact_recode.invite_contact_name like '%{$tbxContactName}%'";
        
        $tbxCustomerName = Utility::GetForm('tbxCustomerName',$_GET,40);
        if($tbxCustomerName != "")
            $sWhere .= " and cm_ag_contact_recode.customer_name like '%{$tbxCustomerName}%'";
                        
        $tbxSInviteCreateTime = Utility::GetForm("tbxSInviteCreateTime",$_GET);
        if($tbxSInviteCreateTime != "" && Utility::isShortTime($tbxSInviteCreateTime))
            $sWhere .= " and cm_ag_contact_recode.invite_time >= '".$tbxSInviteCreateTime."'";             
            
        $tbxEInviteCreateTime = Utility::GetForm("tbxEInviteCreateTime",$_GET);
        if($tbxEInviteCreateTime != "" && Utility::isShortTime($tbxEInviteCreateTime))
            $sWhere .= " and cm_ag_contact_recode.invite_time < ".Utility::SQLEndDate($tbxEInviteCreateTime);    
                   
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
               
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $arrPageList = $this->getPageList($objAgContactRecodeBLL,"",$sWhere,"",$iPageSize,$iExportExcel);
        $arrayData = &$arrPageList['list'];
        foreach($arrayData as $key => $value)
        {
            $arrayData[$key]["invite_status_text"] = "已完成";
            if($value["invite_status"] == 0)
            {
                $arrayData[$key]["invite_status_text"] = "未完成";
            }
            else if($value["invite_status"] == -1)
            {
                $arrayData[$key]["invite_status_text"] = "作废";
            }
            
            $arrayData[$key]["revisit_status_text"] = "--";
            if($value["create_uid"] > 0)
            {
                if($value["revisit_uid"] > 0)
                    $arrayData[$key]["revisit_status_text"] = "已回访";
                else
                    $arrayData[$key]["revisit_status_text"] = "未回访";
            }
            
            $arrayData[$key]["invite_time"] = date("Y-m-d H:i",strtotime($arrayData[$key]["invite_time"]));
            $arrayData[$key]["contact_time"] = date("Y-m-d H:i",strtotime($arrayData[$key]["contact_time"]));
            $arrayData[$key]["invite_e_time"] = date("H:i",strtotime($arrayData[$key]["invite_e_time"]));
            $arrayData[$key]["contact_e_time"] = date("H:i",strtotime($arrayData[$key]["contact_e_time"]));
        }
        
        $this->smarty->assign('arrayData',$arrayData);
        $this->smarty->display($strTPLPath);
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        
    }
    
    
    /**
     * @functional 删除
    */
    protected function InviteDel($is_visit)
    {                
        $ids = Utility::GetForm('ids',$_GET);
        if($ids == "")
            exit("请选择预约记录！");
            
        $aID = explode(",",$ids);
        foreach($aID as $v)
        {
            if(!is_numeric($v))
                exit("有异常ID！");                
        }
        
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeBLL->InviteDel($is_visit,$ids,$this->getAgentId(),$this->getUserId(),$this->getUserName()." ".$this->getUserCNName());
        
        exit("0");
    }
    
    /**
     * @functional 作废
    */
    protected function InviteDrop($is_visit)
    {                
        $ids = Utility::GetForm('ids',$_GET);
        if($ids == "")
            exit("请选择预约记录！");
            
        $aID = explode(",",$ids);
        foreach($aID as $v)
        {
            if(!is_numeric($v))
                exit("有异常ID！");                
        }
        
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeBLL->InviteDrop($is_visit,$ids,$this->getAgentId(),$this->getUserId(),$this->getUserName()." ".$this->getUserCNName());
        
        exit("0");
    }
            
    /**
     * @functional 小记列表内容
    */
    protected function RecordListBody($is_visit,$strTPLPath,$iIsAllView = false)
    {   
        $sWhere = " and cm_ag_contact_recode.agent_id=".$this->getAgentId()." and cm_ag_contact_recode.finance_uid=".$this->getFinanceUid()." and cm_ag_contact_recode.create_uid > 0 ";
                
        if($is_visit != -1)
                $sWhere .= " and cm_ag_contact_recode.is_visit =$is_visit";
        else
        {
            //回访列表
            $cbIsVisit = Utility::GetFormInt('cbIsVisit',$_GET,-100);
            if($cbIsVisit != -100)
                $sWhere .= " and cm_ag_contact_recode.is_visit = $cbIsVisit";
        }
                
        if(!$iIsAllView){
            $sWhere .= " and sys_user.user_no like '{$this->getUserNo()}%' ";
        }
        
        $tbxCustomerID = Utility::GetFormInt('tbxCustomerID',$_GET,-100);
        if($tbxCustomerID >0)
            $sWhere .= " and cm_ag_contact_recode.customer_id=".$tbxCustomerID;
                        
        $cbIntentionRating = Utility::GetFormInt('cbIntentionRating',$_GET);
        if($cbIntentionRating > 0)
            $sWhere .= " and cm_ag_contact_recode.intention_rating = $cbIntentionRating";
        else
        {
            $cbIntentionRating = Utility::GetForm('IntentionRating',$_GET);//多选
            if($cbIntentionRating != "")
                $sWhere .= Utility::SQLMultiSelect("cm_ag_contact_recode.intention_rating",$cbIntentionRating);
        }
                   
        $cbIsvalidContact = Utility::GetFormInt('cbIsvalidContact',$_GET,-100);
        if($cbIsvalidContact == 0)
            $sWhere .= " and cm_ag_contact_recode.not_valid_contact_id <= 0";
        else if($cbIsvalidContact == 1)
            $sWhere .= " and cm_ag_contact_recode.not_valid_contact_id > 0";
        
        $cbRevisitStatus = Utility::GetFormInt('cbRevisitStatus',$_GET,-100);
        if($cbRevisitStatus == 0)
            $sWhere .= " and cm_ag_contact_recode.revisit_uid <= 0";
        else if($cbRevisitStatus == 1)
            $sWhere .= " and cm_ag_contact_recode.revisit_uid > 0";
        
        $strRevisitTimeBegin = Utility::GetForm("tbxSRevisitTime", $_GET);
        if(!empty ($strRevisitTimeBegin)){
            $sWhere.= " and cm_ag_contact_recode.revisit_time >= '{$strRevisitTimeBegin}' ";
        }
        
        $strRevisitTimeEnd = Utility::GetForm("tbxERevisitTime", $_GET);
        if(!empty ($strRevisitTimeEnd)){
            $sWhere .= " and cm_ag_contact_recode.revisit_time < ADDDATE('{$strRevisitTimeEnd}',INTERVAL 1 day) ";
        }
        
        $strRevisitUser = Utility::GetForm("tbxRevisitUserName", $_GET);
        if(!empty ($strRevisitUser)){
            $sWhere .= " and cm_ag_contact_recode.revisit_user_name like '%{$strRevisitUser}%' ";
        }
        
        $strContactTimeBegin = Utility::GetForm("tbxSContactTime", $_GET);
        if(!empty ($strContactTimeBegin)){
            $sWhere .=" and cm_ag_contact_recode.contact_time >='{$strContactTimeBegin}' ";
        }
        
        $strContactTimeEnd = Utility::GetForm("tbxEContactTime", $_GET);
        if(!empty ($strContactTimeEnd)){
            $sWhere .= " and cm_ag_contact_recode.contact_time < ADDDATE('{$strContactTimeEnd}',INTERVAL 1 day)";
        }
        
        
        $tbxCustomerName = Utility::GetForm('tbxCustomerName',$_GET,40);
        if($tbxCustomerName != "")
            $sWhere .= " and cm_ag_contact_recode.customer_name like '%{$tbxCustomerName}%'";
                        
        $tbxSContactTime = Utility::GetForm("tbxSContactTime",$_GET);
        if($tbxSContactTime != "" && Utility::isShortTime($tbxSContactTime))
            $sWhere .= " and cm_ag_contact_recode.contact_time >= '".$tbxSContactTime."'";             
            
        $tbxEContactTime = Utility::GetForm("tbxEContactTime",$_GET);
        if($tbxEContactTime != "" && Utility::isShortTime($tbxEContactTime))
            $sWhere .= " and cm_ag_contact_recode.contact_time < ".Utility::SQLEndDate($tbxEContactTime);    
        
        $strCreateName = Utility::GetForm("CreateName", $_GET);
        if(!empty ($strCreateName)){
            $sWhere .= " and cm_ag_contact_recode.create_user_name like '%{$strCreateName}%' ";
        }
        
        $strIntertionRatingIDs = Utility::GetForm("IntentionRating", $_GET);
        if(!empty ($strIntertionRatingIDs)){
            $sWhere .= " and cm_ag_contact_recode.intention_rating in ({$strIntertionRatingIDs}) ";
        }
        
        $iPageSize = Utility::GetFormInt('pageSize',$_GET);        
        if($iPageSize <= 0)
            $iPageSize = $this->arrSysConfig['DEF_PAGE_SIZE'];
        
        $iExportExcel = Utility::GetFormInt('iExportExcel', $_GET);
        if($iExportExcel == 1)
            $iExportExcel = true;
        else
            $iExportExcel = false;
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $arrPageList = $this->getPageList($objAgContactRecodeBLL,"",$sWhere,"cm_ag_contact_recode.create_time desc,if(cm_ag_contact_recode.revisit_uid>0,1,0) asc",$iPageSize,$iExportExcel);
        $arrayData = &$arrPageList['list'];
        foreach($arrayData as $key => $value)
        {
            $arrayData[$key]["is_visit_text"] = "联系小记";
            if($value["is_visit"] > 0)
                $arrayData[$key]["is_visit_text"] = "拜访小记";
                
            $arrayData[$key]["is_valid_text"] = "有效联系";
            if($value["not_valid_contact_id"] > 0)
                $arrayData[$key]["is_valid_text"] = "无效联系";
            
            $arrayData[$key]["revisit_status_text"] = "未回访";
            if($value["revisit_uid"] > 0)
                $arrayData[$key]["revisit_status_text"] = "已回访";
            else
            {
                $arrayData[$key]["revisit_time"] = "--";
                $arrayData[$key]["revisit_user_name"] = "--";
            }
            
            $arrayData[$key]["invite_time"] = date("Y-m-d H:i",strtotime($arrayData[$key]["invite_time"]));
            $arrayData[$key]["contact_time"] = date("Y-m-d H:i",strtotime($arrayData[$key]["contact_time"]));
            $arrayData[$key]["invite_e_time"] = date("H:i",strtotime($arrayData[$key]["invite_e_time"]));
            $arrayData[$key]["contact_e_time"] = date("H:i",strtotime($arrayData[$key]["contact_e_time"]));
        }
        
        if($is_visit == -1 && $iExportExcel == false)//回访列表
        {
            $today = Utility::Today();
            $arrayInCome = array();
            foreach($arrayData as $key => $value)
            {
                $arrayData[$key]["can_edit_income_money"] = 0;
                if($value["income_money"] > 0 && Utility::compareSEDate($today,$value["income_date"]) >= 0)
                {   
                    $strInComeKey = $value["agent_id"]."_".$value["customer_id"];
                    if(array_key_exists($strInComeKey, $arrayInCome))
                    {
                         if($arrayInCome[$strInComeKey] == $value["recode_id"])
                            $arrayData[$key]["can_edit_income_money"] = 1;    
                    }
                    else
                    {
                        $sWhere = " agent_id = ".$value["agent_id"]." and customer_id=".$value["customer_id"]." and is_alliance = 1 AND not_valid_contact_id<=0 and create_uid>0 ";
                        $arrayRecord = $objAgContactRecodeBLL->selectTop("recode_id",$sWhere,"contact_time desc,recode_id desc","",1);
                        if(isset($arrayRecord)&&count($arrayRecord) > 0) 
                        {
                            if($arrayRecord[0]["recode_id"] == $value["recode_id"])
                                $arrayData[$key]["can_edit_income_money"] = 1;    
                                
                            $arrayInCome[$strInComeKey] = $arrayRecord[0]["recode_id"]; 
                        }                        
                    }
                }
            }
        }
        
        $this->smarty->assign('arrayData',$arrayData);
        $this->smarty->display($strTPLPath);
        echo("<script>pageList.totalPage=".$arrPageList['totalPage'].";pageList.recordCount=".$arrPageList['recordCount'].";</script>"); 
        
    }
    
    
    /**
     * @functional 
    */
    public function GetContactRecordDetail()
    {
        $id = Utility::GetFormInt('id',$_GET);     
        if($id <= 0)
            exit("参数有误！");
        
        $isReVisit = Utility::GetFormInt('isReVisit',$_GET); 
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        if($objAgContactRecodeInfo == null)
            exit("未找相应记录！");
        
        if(!($this->HaveRight("RevisitList",Rightvalue::view,true) || 
            $this->HaveRight("ContactInviteList",Rightvalue::view,true)|| 
            $this->HaveRight("VisitInviteList",Rightvalue::view,true)||
            $this->HaveRight("AgentContactRecord", RightValue::view,true)||
            $this->HaveRight("AgentContactRecord", RightValue::v4,true)))
        {
            exit("您没有此权限！");
        }
            
        $objAgContactRecodeInfo->strContactRecode = str_replace(array("<BR/><BR/>","<BR/>", "<br/>"),"\r",$objAgContactRecodeInfo->strContactRecode);
        $this->smarty->assign('objAgContactRecodeInfo',$objAgContactRecodeInfo);
        $this->smarty->assign('isReVisit',"0");        
        $this->displayPage('CM/ContactRecord/ReVisitModify.tpl');   
    }
    
    
    public function getRevisitCard()
    {
        $iRecordID = Utility::GetFormInt("id", $_GET);
        if($iRecordID <= 0)
            exit("ID无效");
            
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($iRecordID,$this->getAgentId());
        if($objAgContactRecodeInfo == null || $objAgContactRecodeInfo->iRevisitUid == 0){
            die("无回访记录");
        }
        $this->smarty->assign("ContactRecord",$objAgContactRecodeInfo->strRevisitContent);
        $this->smarty->assign("RevisitUserName",$objAgContactRecodeInfo->strRevisitUserName);
        $this->smarty->assign("RevisitTime",$objAgContactRecodeInfo->strRevisitTime);
        echo $this->smarty->fetch('CM/ContactRecord/RevisitCard.tpl');
    }
    
        
    /**
     * @functional 回访记录列表
    */
    public function RevisitList()
    {
        if (!$this->HaveRight("RevisitList", RightValue::viewCompany,true)) {
            $this->PageRightValidate("RevisitList", RightValue::view);
        }
                
        //联系量统计页面跳转传递过来的参数
        $user_id = Utility::GetForm("user_id", $_GET);
        $bdate = Utility::GetForm("bdate", $_GET);
        $edate = Utility::GetForm("edate", $_GET);
        
        $this->smarty->assign('bdate', $bdate);
        $this->smarty->assign('edate', $edate);
       
        if($user_id!="")
        {
            $objuserBLL = new UserBLL();
            $this->smarty->assign('CreateUserName',$objuserBLL->GetUserNameByUID($user_id));
            $this->smarty->assign("selVisit",1);
        }
        //
        
        //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->JsonForMultiSelect(false);
        $this->smarty->assign('strIntentionRatingJson',$strIntentionRatingJson); 
         
        $this->smarty->assign('RevisitListBody',"/?d=CM&c=ContactRecord&a=RevisitListBody");        
        $this->displayPage('CM/ContactRecord/RevisitList.tpl');   
    }
    
    
    /**
     * @functional 回访记录列表内容
    */
    public function RevisitListBody()
    {        
        $iIsAllView = false;
        if($this->HaveRight("RevisitList", RightValue::viewCompany)){
            $iIsAllView = true;
        }else{
            $this->ExitWhenNoRight("RevisitList", RightValue::view);
        }
        
        $this->RecordListBody(-1,'CM/ContactRecord/RevisitListBody.tpl',$iIsAllView);
    }
    
        
    /**
     * @functional 展示回访操作界面
    */
    public function ReVisitModify()
    {
        $this->PageRightValidate("RevisitList",Rightvalue::add);
        $id = Utility::GetFormInt('id',$_GET);     
        if($id <= 0)
            exit("参数有误！");
        
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        if($objAgContactRecodeInfo == null)
            exit("未找相应记录！");
            
        $objAgContactRecodeInfo->strContactRecode = str_replace(array("<BR/><BR/>","<BR/>", "<br/>"),"\r",$objAgContactRecodeInfo->strContactRecode);
        $this->smarty->assign('objAgContactRecodeInfo',$objAgContactRecodeInfo);
        $this->smarty->assign('isReVisit',"1");        
        $this->displayPage('CM/ContactRecord/ReVisitModify.tpl');   
    }
    
    
    /**
     * @functional 回访提交
    */
    public function ReVisitModifySubmit()
    {
        $this->ExitWhenNoRight("RevisitList",Rightvalue::add);
        
        $id = Utility::GetFormInt('tbxID',$_POST);
        if($id <= 0)
            exit("ID无效");
        
        $tbxRevisitContent = Utility::GetRemarkForm('tbxRevisitContent',$_POST,500);
        if($tbxRevisitContent == "")
            exit("请输入回访内容");
            
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        if($objAgContactRecodeInfo == null)
            exit("未找相应记录！");
        
        $objAgContactRecodeInfo->strRevisitContent = $tbxRevisitContent;
        $objAgContactRecodeInfo->iRevisitUid = $this->getUserId();
        $objAgContactRecodeInfo->strRevisitUserName = $this->getUserName()." ".$this->getUserCNName(); 
        $objAgContactRecodeInfo->strRevisitTime = Utility::Now();
        $objAgContactRecodeBLL->updateByID($objAgContactRecodeInfo,true);
        exit("0");
    }
    
    
    
    /**
     * @functional 展示修改预计到帐操作界面
    */
    public function EditPredictIncome()
    {
        $this->PageRightValidate("RevisitList",Rightvalue::v128);
        $id = Utility::GetFormInt('id',$_GET);     
        if($id <= 0)
            exit("参数有误！");
        
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        if($objAgContactRecodeInfo == null)
            exit("未找相应记录！");
            
        $this->smarty->assign('objAgContactRecodeInfo',$objAgContactRecodeInfo);
        $this->displayPage('CM/ContactRecord/EditPredictIncome.tpl');   
    }
    
    /**
     * @functional 修改预计到帐
    */
    public function EditPredictIncomeSubmit()
    {
        $this->PageRightValidate("RevisitList",Rightvalue::v128);
        $id = Utility::GetFormInt('tbxID',$_POST);
        if($id <= 0)
            exit("ID无效");
        
        $tbxIncomeDate = Utility::GetForm('tbxIncomeDate',$_POST);
        if(!($tbxIncomeDate != "" && Utility::isShortTime($tbxIncomeDate)))
            exit("请输入预计到账时间");
        
        $tbxIncomeMoney = Utility::GetFormDouble('tbxIncomeMoney',$_POST);
        if($tbxIncomeMoney <= 0)
            exit("请输入预计到账金额");
                            
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        if($objAgContactRecodeInfo == null)
            exit("未找相应记录！");
        
        $objAgContactRecodeInfo->strIncomeDate = $tbxIncomeDate;
        $objAgContactRecodeInfo->iIncomeMoney = $tbxIncomeMoney;
        
        $objAgContactRecodeInfo->iUpdateUid = $this->getUserId();
        $objAgContactRecodeInfo->strUpdateUserName = $this->getUserName()." ".$this->getUserCNName(); 
        $objAgContactRecodeBLL->updateByID($objAgContactRecodeInfo);

        exit("0");
         
    }
    
}

?>