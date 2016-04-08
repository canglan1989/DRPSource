<?php

/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：联系小记模块
 * 创建人：wzx
 * 添加时间：2012-10-19 
 * 修改人：      修改时间：
 * 修改描述：
 * */

require_once __DIR__ . '/VistiContactRecordBase.php';
require_once __DIR__ . '/../../Class/BLL/UserBLL.php';
require_once __DIR__ . '/../../Class/BLL/AgentBLL.php';
require_once __DIR__ . '/../../Class/BLL/CustomerExBLL.php';
class ContactRecordAction extends VistiContactRecordBase
{
    public function __construct()
    {
    }
    
    
    /**
     * @functional 展示添加拜访预约页面
    */
    public function ContactInviteModify()
    {
        $this->PageRightValidate("ContactInviteList",Rightvalue::add);  
        $this->f_getInfoForModify(0);        
        $this->displayPage('CM/ContactRecord/ContactInviteModify.tpl'); 
    }
    
    /**
     * @functional 
    */
    public function ContactInviteModifySubmit()
    {
        $this->PageRightValidate("ContactInviteList",Rightvalue::add);  
        
        $id = Utility::GetFormInt('tbxID',$_POST);
        if($id <= 0)
            exit("ID无效"); 
                        
        $tbxContactName = Utility::GetForm('tbxInviteContactName',$_POST);
        if($tbxContactName == "")
            exit("请填写被联系人");
            
        $tbxContactMobile = Utility::GetForm('tbxInviteContactMobile',$_POST);
        $tbxContactTel = Utility::GetForm('tbxInviteContactTel',$_POST);
        if($tbxContactMobile == "" && $tbxContactTel == "")
            exit("手机号或固定电话必须输入一项");
        
        $tbxContactTime = Utility::GetForm('tbxInviteContactTime',$_POST);
        if($tbxContactTime == "")
            exit("请输入联系时间");
            
        $tbxContactTime .= ":00";
        if(!Utility::is_time($tbxContactTime)) 
            exit("联系时间格式不正确");
                                         
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        
        if($objAgContactRecodeInfo == null)
            exit("未找到对应记录！");
                
        $objAgContactRecodeInfo->strInviteContactTel = $tbxContactTel;
        $objAgContactRecodeInfo->strInviteContactMobile = $tbxContactMobile;        
        $objAgContactRecodeInfo->strInviteContactName = $tbxContactName;
        $objAgContactRecodeInfo->strInviteTime = $tbxContactTime;
        $objAgContactRecodeInfo->iInviteUpdateUid = $this->getUserId();
        $objAgContactRecodeInfo->strInviteUpdateUserName = $this->getUserName()." ".$this->getUserCNName(); 
        $objAgContactRecodeInfo->strInviteUpdateTime = Utility::Now();
        
        $objAgContactRecodeBLL->updateByID($objAgContactRecodeInfo);
        
        //如果当前联系人是否为负责人 则没有同名的则插入 有则 更新负责人标记
        $chkIsManager = Utility::GetFormInt('chkIsManager',$_POST);
        $this->f_UpdateCustomerManager($objAgContactRecodeInfo->iCustomerId,$objAgContactRecodeInfo->strInviteContactName,
            $objAgContactRecodeInfo->strInviteContactTel,$objAgContactRecodeInfo->strInviteContactMobile,$chkIsManager);
            
        exit("0");
    }
    
    
    
    
    /**
     * @functional 展示添加联系小记页面
    */
    public function ContactRecodeModify()
    {
        $this->PageRightValidate("ContactRecordList",Rightvalue::add);        
        $strTitle = "添加联系小记";
        $id = Utility::GetFormInt('id',$_GET);        
        if($id > 0)
            $strTitle = "联系小记修改";
            
        $this->smarty->assign('strTitle',$strTitle);
        $this->smarty->assign('strPath',"客户管理<span>&gt;</span>联系/拜访小记<span>&gt;</span>{$strTitle}");

        $this->f_getInfoForModify($id);
        
        //踢入公海时间
        $objDataConfigBLL = new DataConfigBLL();
        $arrayToSeaProtectDate = $objDataConfigBLL->GetToSeaProtectDate($this->getAgentId());
        $this->smarty->assign('arrayToSeaProtectDate',$arrayToSeaProtectDate);
        //无效联系项
        $objConstDataBLL =  new ConstDataBLL();
        $arrayNotValid = $objConstDataBLL->select("c_value,c_name","data_type='".CustomerDataConfig::Invalid_Contact."'","sort_index");
        $this->smarty->assign('arrayNotValid',$arrayNotValid);
        
        //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $arrayInvite = $objIntentionRatingBLL->SelectList();
        $this->smarty->assign('arrayInvite',$arrayInvite);
        $this->displayPage('CM/ContactRecord/ContactRecordModify.tpl');           
    }
    
    public function ContactRecordModifySubmit()
    {
        $this->ExitWhenNoRight("ContactRecordList",Rightvalue::add); 
        
        $tbxCustomerID = Utility::GetForm('tbxCustomerID',$_POST);
        if($tbxCustomerID <= 0)
            exit("客户ID无效");
            
        $tbxContactName = Utility::GetForm('tbxContactName',$_POST);
        if($tbxContactName == "")
            exit("请填写被联系人");
            
        $tbxContactMobile = Utility::GetForm('tbxContactMobile',$_POST);
        $tbxContactTel = Utility::GetForm('tbxContactTel',$_POST);
        if($tbxContactMobile == "" && $tbxContactTel == "")
            exit("手机号或固定电话必须输入一项");
        
        $tbxContactTime = Utility::GetForm('tbxContactTime',$_POST);
        if($tbxContactTime == "")
            exit("请输入联系时间");
        
        $tbxContactTime .= ":00";
        if(!Utility::is_time($tbxContactTime)) 
            exit("联系时间格式不正确");
            
        $chkContactResult = Utility::GetFormInt('chkContactResult',$_POST);//1有效 0无效 
        $bIsValidContact = true;
        if($chkContactResult <= 0)
            $bIsValidContact = false;
        
        $tbxContactRecode = "";
        $aAlliance = array(-100,0);
        $chkAlliance = 0;
        $cbContactResult = 0;
        $chkDelCustomer = 0;
        $tbxDelCustomer = "";
        $tbxIncomeDate = "";
        $tbxIncomeMoney = 0;
        $objPredictIncomeInfo = null;
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objPredictIncomeInfo = $objAgContactRecodeBLL->GetPredictIncome($tbxCustomerID,$this->getAgentId());
        
        if($bIsValidContact == true)
        {
            $chkAlliance = Utility::GetFormInt('chkAlliance',$_POST);
            $cbAlliance = Utility::GetForm('cbAlliance',$_POST);
            $aAlliance = explode("|",$cbAlliance);
            if($chkAlliance == 1)
            {                
                if($aAlliance[0] <= 0)
                    exit("请选择网盟推广意向等级");
                    
                if((int)$aAlliance[1] == 1)//有到帐的
                {                    
                    if($objPredictIncomeInfo == null)
                    {
                        $tbxIncomeDate = Utility::GetForm('tbxIncomeDate',$_POST);
                        if(!($tbxIncomeDate != "" && Utility::isShortTime($tbxIncomeDate)))
                            exit("请输入预计到账时间");
                        
                        $tbxIncomeMoney = Utility::GetFormDouble('tbxIncomeMoney',$_POST);
                        if($tbxIncomeMoney <= 0)
                            exit("请输入预计到账金额");
                    }
                    else
                    {
                        $tbxIncomeDate = $objPredictIncomeInfo->strIncomeDate;
                        $tbxIncomeMoney = $objPredictIncomeInfo->iIncomeMoney;
                    }
                }
            }
                        
            $tbxContactRecode = Utility::GetRemarkForm('tbxContactRecode',$_POST,500);
            if($tbxContactRecode == "")
                exit("请输入联系内容");            
        }
        else
        {
            $cbContactResult = Utility::GetFormInt('cbContactResult',$_POST);
            if($cbContactResult <= 0)
                exit("请选择无效联系选项");
                
            $chkDelCustomer = Utility::GetFormInt('chkDelCustomer',$_POST);
            $tbxDelCustomer = Utility::GetForm('tbxDelCustomer',$_POST);            
            if($chkDelCustomer == 1 && $tbxDelCustomer == "")
                exit("请输入删除原因");
        }
        
        $chkToSea = Utility::GetFormInt('chkToSea',$_POST);
        $cbToSea = Utility::GetFormInt('cbToSea',$_POST);
        if($chkToSea == 1 && $cbToSea <= 0)
            exit("请选择踢入公海屏蔽天数");
            
        if($chkToSea == 1)
        {
            $chkDelCustomer = 0;
            $tbxDelCustomer = "";
        }
        
        $tbxInviteTime = Utility::GetForm('tbxInviteTime',$_POST);
        if($tbxInviteTime != "")
        {
            $tbxInviteTime .= ":00";
            if(!Utility::is_time($tbxInviteTime)) 
                exit("下次联系时间格式不正确");
        }
                    
        $id = Utility::GetFormInt('tbxID',$_POST);
        $iInviteItem = Utility::GetFormInt("inviteitem", $_POST);
        if(!empty ($iInviteItem)){
            $id = $iInviteItem;
        }
        $objAgContactRecodeInfo = null;
        if($id > 0)
        {
            $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        }
        
        if($objAgContactRecodeInfo == null)
        {
            $id = 0;
            $objAgContactRecodeInfo = new AgContactRecodeInfo();
            $objAgContactRecodeInfo->iIsVisit = 0;// 1拜访小记  0联系小记
            $objAgContactRecodeInfo->iAgentId = $this->getAgentId();
            $objAgContactRecodeInfo->strAgentNo = $this->getAgentNo();
            $objAgContactRecodeInfo->strAgentName = $this->getAgentName();
            $objAgContactRecodeInfo->iCustomerId = $tbxCustomerID;
            
            $objCustomerBLL = new CustomerBLL();
            $arrayData = $objCustomerBLL->selectTop("cm.customer_name"," cm.customer_id=ag.customer_id and ag.customer_id=$tbxCustomerID and ag.agent_id=".$this->getAgentId().
                " and ag.service_user_no like '".$this->getUserNo()."%'","","",1);
            if(isset($arrayData)&&count($arrayData))
            {
                $objAgContactRecodeInfo->strCustomerName = $arrayData[0]["customer_name"];
            }
            else
            {
                exit("未找到对应客户信息");
            }            
        }
        
        if($objAgContactRecodeInfo->iInviteCreateUid > 0)
            $objAgContactRecodeInfo->iInviteStatus = 1;
            
        $objAgContactRecodeInfo->iCreateUid = $this->getUserId();
        $objAgContactRecodeInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName(); 
        $objAgContactRecodeInfo->strCreateTime = Utility::Now();
        
        $objAgContactRecodeInfo->strContactTel = $tbxContactTel;
        $objAgContactRecodeInfo->strContactMobile = $tbxContactMobile;
        if($cbContactResult > 0)//选择了无效联系选项
        {
            $objAgContactRecodeInfo->iNotValidContactId = $cbContactResult;
            $objConstDataBLL =  new ConstDataBLL();
            $arrayData = $objConstDataBLL->select("c_name","c_value='".$objAgContactRecodeInfo->iNotValidContactId
                ."' and data_type='".CustomerDataConfig::Invalid_Contact."'","");
            if(isset($arrayData)&&count($arrayData) > 0)
                $objAgContactRecodeInfo->strNotValidContactName = $arrayData[0]['c_name'];//无效的联系项名称
            else
                $objAgContactRecodeInfo->strNotValidContactName = "";
        }
        else
        {
            $objAgContactRecodeInfo->iNotValidContactId = 0;
            $objAgContactRecodeInfo->strNotValidContactName = "";
        }
                
        $objAgContactRecodeInfo->strContactName = $tbxContactName;
        $objAgContactRecodeInfo->strContactTime = $tbxContactTime;
        $objAgContactRecodeInfo->strContactRecode = $tbxContactRecode;
        $objAgContactRecodeInfo->iIsAlliance = $chkAlliance;
        $objAgContactRecodeInfo->iIntentionRating = $aAlliance[0];
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $objAgContactRecodeInfo->strIntentionRatingName = $objIntentionRatingBLL->GetNameByID($objAgContactRecodeInfo->iIntentionRating);
        
        $objAgContactRecodeInfo->strIncomeDate = $tbxIncomeDate;
        $objAgContactRecodeInfo->iIncomeMoney = $tbxIncomeMoney;
        
        $objAgContactRecodeInfo->iIsToSea = $chkToSea;
        $objAgContactRecodeInfo->strShieldDay = $cbToSea;
        $objAgContactRecodeInfo->iIsDelCustomer = $chkDelCustomer;
        $objAgContactRecodeInfo->strDelCustomerReson = $tbxDelCustomer;
        
        if($objAgContactRecodeInfo->iIsDelCustomer == 1 || $objAgContactRecodeInfo->iIsToSea == 1)
            $tbxInviteTime = "";
            
        $objAgContactRecodeInfo->strNextTime = $tbxInviteTime;        
        $objAgContactRecodeInfo->iIsDel = 0;
        
        $tbxInviteID = Utility::GetFormInt('tbxInviteID',$_POST);
        if($tbxInviteID > 0)
            $objAgContactRecodeBLL->updateByID($objAgContactRecodeInfo);
        else
        {
            $objAgContactRecodeInfo->iFinanceUid = $this->getFinanceUid();
            $objAgContactRecodeInfo->strFinanceNo = $this->getFinanceNo();
            $id = $objAgContactRecodeBLL->insert($objAgContactRecodeInfo);
            if($objAgContactRecodeInfo->iIsDelCustomer == 1)//删除客户
            {
                //目前还不用相关编码 wzx 2012.11.08
            }
        }
                
        if($tbxInviteTime != "")//有下次联系时间产生一条预约
        {
            $objAgContactRecodeInfo->iRecodeId = $id;
            $this->f_addNextInvite($objAgContactRecodeInfo,$tbxInviteTime);
        }
        
        //如果当前联系人是否为负责人 则没有同名的则插入 有则 更新负责人标记
        $chkIsManager = Utility::GetFormInt('chkIsManager',$_POST);
        $this->f_UpdateCustomerManager($objAgContactRecodeInfo->iCustomerId,$objAgContactRecodeInfo->strContactName,$objAgContactRecodeInfo->strContactTel,
            $objAgContactRecodeInfo->strContactMobile,$chkIsManager);
        
        //目前还没有编辑功能 还不需要编码
        exit("0");
    }
    
    /**
     * @functional 电话预约列表
    */
    public function ContactInviteList()
    {
        $this->PageRightValidate("ContactInviteList",Rightvalue::view);
        
        $this->smarty->assign('ContactInviteListBody',"/?d=CM&c=ContactRecord&a=ContactInviteListBody");        
        $this->displayPage('CM/ContactRecord/ContactInviteList.tpl');   
    }
    
    
    /**
     * @functional 电话预约列表内容
    */
    public function ContactInviteListBody()
    {        
        $this->ExitWhenNoRight("ContactInviteList",Rightvalue::view);
        $this->InviteListBody(0,'CM/ContactRecord/ContactInviteListBody.tpl');
    }
    
    
    /**
     * @functional 删除
    */
    public function ContactInviteDel()
    {        
        $this->ExitWhenNoRight("ContactInviteList",Rightvalue::del);
        $this->InviteDel(0);
    }
    
    /**
     * @functional 作废
    */
    public function ContactInviteDrop()
    {        
        $this->ExitWhenNoRight("ContactInviteList",Rightvalue::add);
        $this->InviteDrop(0);
    }
       
    
    /**
     * @functional 联系小记列表
    */
    public function ContactRecordList()
    {
        if (!$this->HaveRight("ContactRecordList", RightValue::v8,true)) {
            $this->PageRightValidate("ContactRecordList", RightValue::view);
        }
        
        //联系量页面跳转传递过来的参数
        $user_id = Utility::GetForm("user_id", $_GET);
        $bdate = Utility::GetForm("bdate", $_GET);
        $edate = Utility::GetForm("edate", $_GET);
        $tp = Utility::GetForm("tp", $_GET);//1有效联系2无效3全部
        $this->smarty->assign('bdate', $bdate);
        $this->smarty->assign('edate', $edate);
        $this->smarty->assign("IsVaileContact",$tp);
        if($user_id!="")
        {
            $objuserBLL = new UserBLL();
            $this->smarty->assign('CreateUserName',$objuserBLL->GetUserNameByUID($user_id));
        }
        //
        $strCustomerName = Utility::GetForm("customername", $_GET);
        $iCustomerID = Utility::GetFormInt("customerID", $_GET);
        if($iCustomerID<= 0 )
            $iCustomerID = "";
        //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->JsonForMultiSelect(false);
        $this->smarty->assign('strIntentionRatingJson',$strIntentionRatingJson);  
        
        $this->smarty->assign("CustomerName",$strCustomerName);
        $this->smarty->assign("CustomerID",$iCustomerID);
        $this->smarty->assign('ContactRecordListBody',"/?d=CM&c=ContactRecord&a=ContactRecordListBody");        
        $this->displayPage('CM/ContactRecord/ContactRecordList.tpl');   
    }
    
    
    /**
     * @functional 联系小记列表内容
    */
    public function ContactRecordListBody()
    {   
        $iIsAllView = false;
        if($this->HaveRight("ContactRecordList", RightValue::v8)){
            $iIsAllView = true;
        }else{
            $this->ExitWhenNoRight("ContactRecordList", RightValue::view);
        }
        
        $this->RecordListBody(0,'CM/ContactRecord/ContactRecordListBody.tpl',$iIsAllView);
    }
    
    public function AdHaiIntentionRatingRecord(){
        if(!$this->HaveRight("AdHaiIntentionRecord", RightValue::v4,true)){
            $this->PageRightValidate("AdHaiIntentionRecord", RightValue::view);
        }
        
        //意向等级统计页面跳转过来的处理
        $user_id = Utility::GetFormInt("user_id", $_GET);
        $rating_id = Utility::GetFormInt("rating_id", $_GET);
        $bdate = Utility::GetForm("bdate", $_GET);
        $edate = Utility::GetForm("edate", $_GET);
        $isincome = Utility::GetForm("isincome", $_GET);
        if($isincome=="1")//表示显示预计到账信息
        {
            $this->smarty->assign('income_dateb',$bdate);
            $this->smarty->assign('income_datee',$edate);
        }else{
            $this->smarty->assign('create_dateb',$bdate);
            $this->smarty->assign('create_datee',$edate);
        }
        if($rating_id!="")
        {
            $objRatingBLL = new IntentionRatingBLL();
            $objRatingInfo = $objRatingBLL->getModelByID($rating_id);
            
            $this->smarty->assign('rating_id',$objRatingInfo->iRatingId);
            $this->smarty->assign('rating_text',$objRatingInfo->strRatingName." ".$objRatingInfo->strRemark);
        }
        if($user_id!="")
        {
            $objuserBLL = new UserBLL();
            $this->smarty->assign('user_name',$objuserBLL->GetUserNameByUID($user_id));
        }
        ///
        //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->JsonForMultiSelect();
        $this->smarty->assign('strIntentionRatingJson',$strIntentionRatingJson); 
        
        $this->smarty->assign('BodyUrl',  $this->getActionUrl("CM", "ContactRecord", "AdHaiIntentionRatingBody"));
        $this->displayPage('CM/ContactRecord/AdHaiIntentionRatingRecord.tpl');
    }
    
    public function AdHaiIntentionRatingBody(){
        $bIsAllView = false;
        if ($this->HaveRight('AdHaiIntentionRecord', RightValue::v4)) {
            $bIsAllView = true;
        } else {
            $this->ExitWhenNoRight("AdHaiIntentionRecord", RightValue::view);
        }
    
        $strWhere = $this->AdHaiIntentionRatingWhere($bIsAllView);
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objAgContactRecordBLL = new AgContactRecodeBLL();
        $arrAdHaiRecordList = $objAgContactRecordBLL->getAdHaiIntentionRatingRecordList($strWhere, $strOrder);
        $this->showPageSmarty($arrAdHaiRecordList, 'CM/ContactRecord/AdHaiIntentionRatingBody.tpl');
    }
    
    public function AdHaiIntentionRatingWhere($bIsAllView){
        $strWhere = " and sys_user.agent_id = ".$this->getAgentId()." and sys_user.finance_uid=".$this->getFinanceUid();
        $iIsVisit = Utility::GetFormInt("is_visit", $_GET);
        if($iIsVisit >= 0){
            $strWhere .= " and cm_ag_contact_recode.is_visit = {$iIsVisit} ";
        }
        
        $chkLastIntention = Utility::GetFormInt("chkLastIntention", $_GET);        
        if($chkLastIntention == 1){
            $strWhere .= " and cm_ag_contact_recode.is_last_intention = 1 ";
        }
        
        if(!$bIsAllView){
            $strWhere .= " and sys_user.user_no like '{$this->getUserNo()}%' ";
        }
                        
        $strCustomerName = Utility::GetForm("customer_name", $_GET);
        if(!empty ($strCustomerName)){
            $strWhere .= " and (cm_ag_contact_recode.customer_name like '%{$strCustomerName}%' or cm_ag_contact_recode.customer_id = '{$strCustomerName}') ";
        }
        
        $strIntentionRating = Utility::GetForm("IntentionRating", $_GET);
        if(!empty ($strIntentionRating)){
            $strWhere .= " and cm_ag_contact_recode.intention_rating in ({$strIntentionRating}) ";
        }
        
        $strCreateUser = Utility::GetForm("create_user", $_GET);
        if(!empty ($strCreateUser)){
            $strWhere .= " and cm_ag_contact_recode.create_user_name like '%{$strCreateUser}%' ";
        }
        
        $strCreateTimeBegin = Utility::GetForm("create_time_begin", $_GET);
        if(!empty ($strCreateTimeBegin)){
            $strWhere .= " and cm_ag_contact_recode.create_time >= '{$strCreateTimeBegin}' ";
        }
        
        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if(!empty ($strCreateTimeEnd)){
            $strWhere .= " and cm_ag_contact_recode.create_time <".Utility::SQLEndDate($strCreateTimeEnd);
        }
        
        $strIncomeTimeBegin = Utility::GetForm("income_time_begin", $_GET);
        if(!empty ($strIncomeTimeBegin)){
            $strWhere .= " and cm_ag_contact_recode.income_date >= '{$strIncomeTimeBegin}' ";
        }
        
        $strIncomeTimeEnd = Utility::GetForm("income_time_end", $_GET);
        if(!empty ($strIncomeTimeEnd)){
            $strWhere .= " and cm_ag_contact_recode.income_date <= '{$strIncomeTimeEnd}' ";
        }
        return $strWhere;
    }
    
    public function AgentContactRecordList(){
        if (!$this->HaveRight("AgentContactRecord", RightValue::v4,true)) {
            $this->PageRightValidate("AgentContactRecord", RightValue::view);
        }
        //联系量统计跳转过来的处理
        $agent_id = Utility::GetFormInt("agent_id", $_GET);
        $bdate = Utility::GetForm("bdate", $_GET);
        $edate = Utility::GetForm("edate", $_GET);
        $tp = Utility::GetForm("tp", $_GET);
        $rating_id = Utility::GetForm("rating_id", $_GET);
        $this->smarty->assign('contact_dateb', $bdate);
        $this->smarty->assign('contact_datee', $edate);
        
        if ($tp != "") {
            if ($tp == "1") {
                $this->smarty->assign('tp_sel1', "selected");
            } else {
                $this->smarty->assign('tp_sel0', "selected");
            }
        }
        if ($rating_id != "") {
            $objRatingBLL = new IntentionRatingBLL();
            $objRatingInfo = new IntentionRatingInfo();
            $objRatingInfo = $objRatingBLL->getModelByID($rating_id);

            $this->smarty->assign('rating_id', $objRatingInfo->iRatingId);
            $this->smarty->assign('rating_text', $objRatingInfo->strRatingName . " " . $objRatingInfo->strRemark);
           
        }
        if($agent_id>0)
        {
            $objAgentBLL = new AgentBLL();
            $objAgentInfo = $objAgentBLL->selectAgentDetail($agent_id);
            $this->smarty->assign('agentName', $objAgentInfo->strAgentName);
        }
        ////////
  
        //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->JsonForMultiSelect();
        //var_dump($strIntentionRatingJson);
        $this->smarty->assign('strIntentionRatingJson',$strIntentionRatingJson); 
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("CM", "ContactRecord", "AgentContactRecordBody"));
        $this->displayPage('CM/ContactRecord/AgentContactRecordList.tpl');
    }
    
    public function AgentContactRecordBody(){
            $bAllView = false;
        if ($this->HaveRight("AgentContactRecord", RightValue::v4)) {
            $bAllView = true;
        } else {
            $this->ExitWhenNoRight("AgentContactRecord", RightValue::view);
        }
        
        $strWhere = $this->AgentContactRecordWhere($bAllView);
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objContactRecordBLL = new AgContactRecodeBLL();
        $arrContactRecordList = $objContactRecordBLL->getAgentContactRecordList($strWhere, $strOrder);
        $this->showPageSmarty($arrContactRecordList, 'CM/ContactRecord/AgentContactRecordBody.tpl');
    }
    
    public function AgentContactRecordWhere($bAllView){
        $strWhere = "";
        
        $iIsVisit = Utility::GetFormInt("cbIsVisit", $_GET);
        if($iIsVisit >= 0){
            $strWhere .= " and cm_ag_contact_recode.is_visit = {$iIsVisit} ";
        }
        
        $iRevisitState = Utility::GetFormInt("cbRevisitStatus", $_GET);
        if($iRevisitState == 0){
            $strWhere .= " and cm_ag_contact_recode.revisit_uid = 0  ";
        }elseif($iRevisitState == 1){
            $strWhere .= " and cm_ag_contact_recode.revisit_uid > 0 ";
        }
        
        if(!$bAllView){
            $strWhere = " and sys_user.user_id=".$this->getUserId();
        }
        $iIsVaildContact = Utility::GetFormInt("IsVaildContact", $_GET);
        if($iIsVaildContact == 0 ){
            $strWhere .= " and cm_ag_contact_recode.not_valid_contact_id > 0 ";
        }elseif($iIsVaildContact == 1){
            $strWhere .= " and cm_ag_contact_recode.not_valid_contact_id = 0 ";
        }
        
        $strCustomerName = Utility::GetForm("tbxCustomerName", $_GET);
        if(!empty ($strCustomerName)){
            $strWhere .=" and (cm_ag_contact_recode.customer_name like '%{$strCustomerName}%' or cm_ag_contact_recode.customer_id = '{$strCustomerName}') ";
        }
        
        $strCustomerUserName = Utility::GetForm("tbxCreateUserName", $_GET);
        if(!empty ($strCustomerUserName)){
            $strWhere .= " and cm_ag_contact_recode.create_user_name like '%{$strCustomerUserName}%' ";
        }
        
        $strRevisitTimeBegin = Utility::GetForm("tbxSRevisitTime", $_GET);
        if(!empty ($strRevisitTimeBegin)&&Utility::isShortTime($strRevisitTimeBegin)){
            $strWhere .= " and cm_ag_contact_recode.revisit_time >= '{$strRevisitTimeBegin}' ";
        }
        
        $strRevisitTimeEnd = Utility::GetForm("tbxERevisitTime", $_GET);
        if(!empty ($strRevisitTimeEnd)&&Utility::isShortTime($strRevisitTimeEnd)){
            $strWhere .= " and cm_ag_contact_recode.revisit_time < DATE_ADD('{$strRevisitTimeEnd}',INTERVAL 1 DAY) ";
        }
        
        $strChannelUser = Utility::GetForm("channeluser", $_GET);
        if(!empty ($strChannelUser)){
            $strWhere .= " and sys_user.e_name like '%{$strChannelUser}%' ";
        }
        
        $strAgentName = Utility::GetForm("agentname", $_GET);
        if(!empty ($strAgentName)){
            $strWhere .= " and (am_agent_source.agent_name like '%{$strAgentName}%' or cm_ag_contact_recode.agent_id = '{$strAgentName}') ";
        }
        
        $strRevisitMan = Utility::GetForm("tbxRevisitUserName", $_GET);
        if(!empty ($strRevisitMan)){
            $strWhere .= " and cm_ag_contact_recode.revisit_user_name like '%{$strRevisitMan}%' ";
        }
        
        $strIntentionRating = Utility::GetForm("IntentionRating", $_GET);
        if(!empty ($strIntentionRating)){
            $strWhere .= " and cm_ag_contact_recode.intention_rating in ({$strIntentionRating}) ";
        }
        
        $strContractTimeBegin = Utility::GetForm("ContactTimeBegin", $_GET);
        if(!empty ($strContractTimeBegin)&&Utility::isShortTime($strContractTimeBegin)){
            $strWhere .= " and cm_ag_contact_recode.contact_time >= '{$strContractTimeBegin}' ";
        }
        
        $strContractTimeEnd = Utility::GetForm("ContactTimeEnd", $_GET);
        if(!empty ($strContractTimeEnd)&&Utility::isShortTime($strContractTimeEnd)){
            $strWhere .= " and cm_ag_contact_recode.contact_time < date_add('{$strContractTimeEnd}',interval 1 day)";
        }
            
        return $strWhere;
    }
    
    public function AgentIntentionRecordList(){
        if(!$this->HaveRight("AgentIntentionRecord", RightValue::v4,true)){
            $this->PageRightValidate("AgentIntentionRecord", RightValue::view);
        }
        
         //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->JsonForMultiSelect();
        //var_dump($strIntentionRatingJson);
        $this->smarty->assign('strIntentionRatingJson',$strIntentionRatingJson); 
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("CM", "ContactRecord", "AgentIntentionRecordBody"));
        $this->displayPage('CM/ContactRecord/AgentIntentionRecordList.tpl');
    }
    
    public function AgentIntentionRecordBody(){
            $bAllView = false;
        if($this->HaveRight("AgentIntentionRecord", RightValue::v4)){
            $bAllView = true;
        }else{
            $this->ExitWhenNoRight("AgentIntentionRecord", RightValue::view);
        }
        $strWhere = $this->AgentIntentionRecordWhere($bAllView);
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objContactRecordBLL = new AgContactRecodeBLL();
        $arrContactRecordList = $objContactRecordBLL->getAgentContactRecordList($strWhere, $strOrder);
        $this->showPageSmarty($arrContactRecordList, 'CM/ContactRecord/AgentIntentionRecordBody.tpl');
    }
    
    public function AgentIntentionRecordWhere($bAllView){
        $strWhere = " and cm_ag_contact_recode.is_intention_recode = 1  ";
        if(!$bAllView){
            $strWhere .= " and sys_user.user_id=".$this->getUserId();
        }
        
        $iIsVisit = Utility::GetFormInt("is_visit", $_GET);
        if($iIsVisit >= 0){
            $strWhere .= " and cm_ag_contact_recode.is_visit = {$iIsVisit} ";
        }
        
        $strCustomerName = Utility::GetForm("customer_name", $_GET);
        if(!empty ($strCustomerName)){
            $strWhere .= " and (cm_ag_contact_recode.customer_name like '%{$strCustomerName}%' or cm_ag_contact_recode.customer_id = '{$strCustomerName}') ";
        }
        
        $strIntentionRating = Utility::GetForm("IntentionRating", $_GET);
        if(!empty ($strIntentionRating)){
            $strWhere .= " and cm_ag_contact_recode.intention_rating in ({$strIntentionRating}) ";
        }
        
        $strCreateUser = Utility::GetForm("create_user", $_GET);
        if(!empty ($strCreateUser)){
            $strWhere .= " and cm_ag_contact_recode.create_user_name like '%{$strCreateUser}%' ";
        }
        
        $strCreateTimeBegin = Utility::GetForm("create_time_begin", $_GET);
        if(!empty ($strCreateTimeBegin)&&Utility::isShortTime($strCreateTimeBegin)){
            $strWhere .= " and cm_ag_contact_recode.create_time >= '{$strCreateTimeBegin}' ";
        }
        
        $strCreateTimeEnd = Utility::GetForm("create_time_end", $_GET);
        if(!empty ($strCreateTimeEnd)&&Utility::isShortTime($strCreateTimeEnd)){
            $strWhere .= " and cm_ag_contact_recode.create_time <= '{$strCreateTimeEnd}' ";
        }
        
        $strIncomeTimeBegin = Utility::GetForm("income_time_begin", $_GET);
        if(!empty ($strIncomeTimeBegin)&&Utility::isShortTime($strIncomeTimeBegin)){
            $strWhere .= " and cm_ag_contact_recode.income_date >= '{$strIncomeTimeBegin}' ";
        }
        
        $strIncomeTimeEnd = Utility::GetForm("income_time_end", $_GET);
        if(!empty ($strIncomeTimeEnd)&&Utility::isShortTime($strIncomeTimeEnd)){
            $strWhere .= " and cm_ag_contact_recode.income_date <= '{$strIncomeTimeEnd}' ";
        }
        $strChannelUser = Utility::GetForm("channel_user", $_GET);
        if(!empty ($strChannelUser)){
            $strWhere .= " and sys_user.e_name like '%{$strChannelUser}%' ";
        }
        
        $strAgentName = Utility::GetForm("agent_name", $_GET);
        if(!empty ($strAgentName)){
            $strWhere .= " and (cm_ag_contact_recode.agent_name like '%{$strAgentName}%' or cm_ag_contact_recode.agent_id = '{$strAgentName}') ";
        }
        
        return $strWhere;
    }
    
    public function getContactInfoByRecordID(){
        $iRecordID = Utility::GetFormInt("recordid", $_POST);
        $objAgContactRecordBLL = new AgContactRecodeBLL();
        $objAgContactRecordInfo = $objAgContactRecordBLL->getModelByID($iRecordID);
        if($objAgContactRecordInfo!= null)
            echo json_encode(array(
                'recode_id'=>$objAgContactRecordInfo->iRecodeId,
                'contact_name'=>$objAgContactRecordInfo->strInviteContactName,
                'contact_mobile'=>$objAgContactRecordInfo->strInviteContactMobile,
                'contact_tel'=>$objAgContactRecordInfo->strInviteContactTel,
                'invite_time'=>$objAgContactRecordInfo->strInviteTime
            ));
        else
            echo json_encode(array(
                'recode_id'=>0,
                'contact_name'=>"",
                'contact_mobile'=>"",
                'contact_tel'=>"",
                'invite_time'=>'--'
            ));
    }
    
}

?>