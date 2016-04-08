<?php

/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：拜访小记模块
 * 创建人：wzx
 * 添加时间：2012-10-19 
 * 修改人：      修改时间：
 * 修改描述：
 * */

require_once __DIR__ . '/VistiContactRecordBase.php';

class VisitRecordAction extends VistiContactRecordBase
{
    public function __construct()
    {
    }
    
    /**
     * @functional 展示添加拜访预约页面
    */
    public function VisitInviteModify()
    {
        $this->PageRightValidate("VisitInviteList",Rightvalue::add);  
        $this->f_getInfoForModify(0);        
        $this->displayPage('CM/ContactRecord/VisitInviteModify.tpl'); 
    }
    
    /**
     * @functional 
    */
    public function VisitInviteModifySubmit()
    {
        $this->PageRightValidate("VisitInviteList",Rightvalue::add);  
        
        $tbxCustomerID = Utility::GetForm('tbxCustomerID',$_POST);
        if($tbxCustomerID <= 0)
            exit("客户ID无效");
            
        $tbxVisitTheme = Utility::GetForm('tbxVisitTheme',$_POST,30);
        if($tbxVisitTheme == "")
            exit("请填写拜访主题");
                 
        $tbxContactName = Utility::GetForm('tbxInviteContactName',$_POST);
        if($tbxContactName == "")
            exit("请填写被访人");
            
        $tbxContactMobile = Utility::GetForm('tbxInviteContactMobile',$_POST);
        $tbxContactTel = Utility::GetForm('tbxInviteContactTel',$_POST);
        if($tbxContactMobile == "" && $tbxContactTel == "")
            exit("手机号或固定电话必须输入一项");
        
        $tbxContactTime = Utility::GetForm('tbxInviteContactTime',$_POST);
        if($tbxContactTime == "")
            exit("请输入拜访开始时间");
            
        $tbxContactTime .= ":00";
        if(!Utility::is_time($tbxContactTime)) 
            exit("拜访开始时间格式不正确");
                    
        $tbxContactETime = Utility::GetForm('tbxInviteContactETime',$_POST);
        if($tbxContactETime == "")
            exit("请输入拜访结束时间");
            
        $tbxContactETime .= ":00";
        if(!Utility::isTime($tbxContactETime)) 
            exit("拜访结束时间格式不正确");
        
        $arrTemp = explode(' ', $tbxContactTime);
        if($arrTemp[1]> $tbxContactETime){
            exit("拜访开始时间必须小于结束时间");
        }
                        
        $id = Utility::GetFormInt('tbxID',$_POST);                      
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objAgContactRecodeInfo = null;
        if($id > 0)
            $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        
        if($objAgContactRecodeInfo == null)
        {
            $id = 0;
            $objAgContactRecodeInfo = new AgContactRecodeInfo();
            
            $objAgContactRecodeInfo->iIsVisit = 1;// 1拜访小记  0联系小记
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
            
            $objAgContactRecodeInfo->iInviteCreateUid = $this->getUserId();
            $objAgContactRecodeInfo->strInviteCreateUserName = $this->getUserName()." ".$this->getUserCNName(); 
            $objAgContactRecodeInfo->iFinanceUid = $this->getFinanceUid();
            $objAgContactRecodeInfo->strFinanceNo = $this->getFinanceNo();
        }
            
        
        $objAgContactRecodeInfo->strVisitTheme = $tbxVisitTheme;
        $objAgContactRecodeInfo->strInviteContactTel = $tbxContactTel;
        $objAgContactRecodeInfo->strInviteContactMobile = $tbxContactMobile;        
        $objAgContactRecodeInfo->strInviteContactName = $tbxContactName;
        $objAgContactRecodeInfo->strInviteTime = $tbxContactTime;
        $objAgContactRecodeInfo->strInviteETime = $tbxContactETime;
        $objAgContactRecodeInfo->iInviteUpdateUid = $this->getUserId();
        $objAgContactRecodeInfo->strInviteUpdateUserName = $this->getUserName()." ".$this->getUserCNName(); 
        $objAgContactRecodeInfo->strInviteUpdateTime = Utility::Now();
        if($id > 0)
            $objAgContactRecodeBLL->updateByID($objAgContactRecodeInfo);
        else
        {
            $objAgContactRecodeBLL->insert($objAgContactRecodeInfo);
        }
        
        //如果当前联系人是否为负责人 则没有同名的则插入 有则 更新负责人标记
        $chkIsManager = Utility::GetFormInt('chkIsManager',$_POST);
        $this->f_UpdateCustomerManager($objAgContactRecodeInfo->iCustomerId,$objAgContactRecodeInfo->strInviteContactName,
        $objAgContactRecodeInfo->strInviteContactTel,$objAgContactRecodeInfo->strInviteContactMobile,$chkIsManager);
            
        exit("0");
    }
    
    
    /**
     * @functional 展示添加拜访小记页面
    */
    public function VisitRecodeModify()
    {
        $this->PageRightValidate("VisitRecordList",Rightvalue::add);        
        $strTitle = "添加拜访小记";
        $id = Utility::GetFormInt('id',$_GET);        
        if($id > 0)
            $strTitle = "拜访小记修改";
            
        $this->smarty->assign('strTitle',$strTitle);
        $this->smarty->assign('strPath',"客户管理<span>&gt;</span>拜访/拜访小记<span>&gt;</span>{$strTitle}");
        
        $this->f_getInfoForModify($id);
        //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $arrayInvite = $objIntentionRatingBLL->SelectList();
        $this->smarty->assign('arrayInvite',$arrayInvite);
        $this->displayPage('CM/ContactRecord/VisitRecordModify.tpl');           
    }
    
    public function VisitRecordModifySubmit()
    {
        $this->ExitWhenNoRight("VisitRecordList",Rightvalue::add); 
        
        $tbxCustomerID = Utility::GetForm('tbxCustomerID',$_POST);
        if($tbxCustomerID <= 0)
            exit("客户ID无效");
        
        $tbxContactName = Utility::GetForm('tbxContactName',$_POST);
        if($tbxContactName == "")
            exit("请填写被拜访人");
            
        $tbxContactMobile = Utility::GetForm('tbxContactMobile',$_POST);
        $tbxContactTel = Utility::GetForm('tbxContactTel',$_POST);
        if($tbxContactMobile == "" && $tbxContactTel == "")
            exit("手机号或固定电话必须输入一项");
        
        $tbxContactTime = Utility::GetForm('tbxContactTime',$_POST);
        if($tbxContactTime == "")
            exit("请输入拜访开始时间");
            
        $tbxContactTime .= ":00";
        if(!Utility::is_time($tbxContactTime)) 
            exit("拜访开始时间格式不正确");
                    
        $tbxContactETime = Utility::GetForm('tbxContactETime',$_POST);
        if($tbxContactETime == "")
            exit("请输入拜访结束时间");
        
            
        $tbxContactETime .= ":00";
        if(!Utility::isTime($tbxContactETime)) 
            exit("拜访结束时间格式不正确");
        
        
        $arrTemp = explode(' ', $tbxContactTime);
        if($arrTemp[1] > $tbxContactETime){
            exit ("拜访结束时间不得早于开始时间");
        }
        
        $aAlliance = array(-100,0);
        $tbxIncomeDate = "";
        $tbxIncomeMoney = 0;
        $objAgContactRecodeBLL = new AgContactRecodeBLL();
        $objPredictIncomeInfo = $objAgContactRecodeBLL->GetPredictIncome($tbxCustomerID,$this->getAgentId());
        
        $chkAlliance = Utility::GetFormInt('chkAlliance',$_POST);
        if($chkAlliance == 1)
        {
            $cbAlliance = Utility::GetForm('cbAlliance', $_POST);
            $aAlliance = explode("|", $cbAlliance);

//            if($chkAlliance == 1)
//            {                
            if ($aAlliance[0] <= 0)
                exit("请选择网盟推广意向等级");

            if ((int) $aAlliance[1] == 1) {//有到帐的
                if ($objPredictIncomeInfo == null) {
                    $tbxIncomeDate = Utility::GetForm('tbxIncomeDate', $_POST);
                    if (!($tbxIncomeDate != "" && Utility::isShortTime($tbxIncomeDate)))
                        exit("请输入预计到账时间");

                    $tbxIncomeMoney = Utility::GetFormDouble('tbxIncomeMoney', $_POST);
                    if ($tbxIncomeMoney <= 0)
                        exit("请输入预计到账金额");
                }
                else {
                    $tbxIncomeDate = $objPredictIncomeInfo->strIncomeDate;
                    $tbxIncomeMoney = $objPredictIncomeInfo->iIncomeMoney;
                }
            }
//            }
        }
        
        $tbxContactRecode = Utility::GetRemarkForm('tbxContactRecode',$_POST,500);
        if($tbxContactRecode == "")
            exit("请输入拜访内容");

        $tbxInviteTime = Utility::GetForm('tbxInviteTime',$_POST);
        if($tbxInviteTime != "")
        {
            $tbxInviteTime .= ":00";
            if(!Utility::is_time($tbxInviteTime)) 
                exit("下次拜访时间格式不正确");
        }
                    
        $id = Utility::GetFormInt('tbxID',$_POST);
        
        $objAgContactRecodeInfo = null;
        if($id > 0)
        {
            $objAgContactRecodeInfo = $objAgContactRecodeBLL->getModelByID($id,$this->getAgentId());
        }
        
        if($objAgContactRecodeInfo == null)
            exit("未找到预约记录！");

        if($objAgContactRecodeInfo->iInviteCreateUid > 0)
            $objAgContactRecodeInfo->iInviteStatus = 1;
            
        $objAgContactRecodeInfo->iUpdateUid = $this->getUserId();
        $objAgContactRecodeInfo->strUpdateUserName = $this->getUserName()." ".$this->getUserCNName(); 
               
        $objAgContactRecodeInfo->strContactTel = $tbxContactTel;
        $objAgContactRecodeInfo->strContactMobile = $tbxContactMobile;        
        $objAgContactRecodeInfo->strContactName = $tbxContactName;
        $objAgContactRecodeInfo->strContactTime = $tbxContactTime;
        $objAgContactRecodeInfo->strContactETime = $tbxContactETime;
        $objAgContactRecodeInfo->strContactRecode = $tbxContactRecode;
        
        $objAgContactRecodeInfo->iNotValidContactId = 0;
        $objAgContactRecodeInfo->strNotValidContactName = "";                
        $objAgContactRecodeInfo->iIsAlliance = $chkAlliance;
        $objAgContactRecodeInfo->iIntentionRating = $aAlliance[0];
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $objAgContactRecodeInfo->strIntentionRatingName = $objIntentionRatingBLL->GetNameByID($objAgContactRecodeInfo->iIntentionRating);
        
        $objAgContactRecodeInfo->strIncomeDate = $tbxIncomeDate;
        $objAgContactRecodeInfo->iIncomeMoney = $tbxIncomeMoney;
        
        $objAgContactRecodeInfo->iIsToSea = 0;
        $objAgContactRecodeInfo->strShieldDay = 0;
        $objAgContactRecodeInfo->iIsDelCustomer = 0;
        $objAgContactRecodeInfo->strDelCustomerReson = "";
        $objAgContactRecodeInfo->strNextTime = $tbxInviteTime;
        
        $objAgContactRecodeInfo->iCreateUid = $this->getUserId();
        $objAgContactRecodeInfo->strCreateUserName = $this->getUserName()." ".$this->getUserCNName(); 
        $objAgContactRecodeInfo->strCreateTime = Utility::Now();
        
        $objAgContactRecodeInfo->iIsDel = 0;
        $objAgContactRecodeBLL->updateByID($objAgContactRecodeInfo);
        
        if($tbxInviteTime != "")//有下次拜访时间产生一条预约
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
     * @functional 预约列表
    */
    public function VisitInviteList()
    {
        $this->PageRightValidate("VisitInviteList",Rightvalue::view);
        
        $this->smarty->assign('VisitInviteListBody',"/?d=CM&c=VisitRecord&a=VisitInviteListBody");        
        $this->displayPage('CM/ContactRecord/VisitInviteList.tpl');   
    }
    
    
    /**
     * @functional 预约列表内容
    */
    public function VisitInviteListBody()
    {        
        $this->ExitWhenNoRight("VisitInviteList",Rightvalue::view);
        $this->InviteListBody(1,'CM/ContactRecord/VisitInviteListBody.tpl');
    }
    
    
    /**
     * @functional 删除
    */
    public function VisitInviteDel()
    {        
        $this->ExitWhenNoRight("VisitInviteList",Rightvalue::del);
        $this->InviteDel(1);
    }
    
    /**
     * @functional 作废
    */
    public function VisitInviteDrop()
    {        
        $this->ExitWhenNoRight("VisitInviteList",Rightvalue::add);
        $this->InviteDrop(1);
    }
    
    
    
    /**
     * @functional 小记列表
    */
    public function VisitRecordList()
    {
        if(!$this->HaveRight("VisitRecordList", RightValue::v8,true)){
            $this->PageRightValidate("VisitRecordList", RightValue::view);
        }
        
        $iCustomerID = Utility::GetFormInt("customerID", $_GET);
        if($iCustomerID<= 0 )
            $iCustomerID = "";
        $this->smarty->assign("CustomerID",$iCustomerID);
        //意向等级
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $strIntentionRatingJson = $objIntentionRatingBLL->JsonForMultiSelect(false);
        $this->smarty->assign('strIntentionRatingJson',$strIntentionRatingJson); 
        
        $this->smarty->assign('VisitRecordListBody',"/?d=CM&c=VisitRecord&a=VisitRecordListBody");        
        $this->displayPage('CM/ContactRecord/VisitRecordList.tpl');   
    }
    
    
    /**
     * @functional 小记列表内容
    */
    public function VisitRecordListBody()
    {
        $iIsAllView = false;
        if($this->HaveRight("VisitRecordList", RightValue::v8)){
            $iIsAllView = true;
        }else{
            $this->ExitWhenNoRight("VisitRecordList", RightValue::view);
        }
        $this->RecordListBody(1,'CM/ContactRecord/VisitRecordListBody.tpl',$iIsAllView);
    }
    
}

?>