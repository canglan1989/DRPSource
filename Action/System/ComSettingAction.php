<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：公司用户管理模块
 * 创建人：wzx
 * 添加时间：2011-11-7
 * 修改人：      修改时间：
 * 修改描述：系统通用设置
 **/

require_once __DIR__.'/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/ComSettingBLL.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/DataConfigBLL.php';
require_once __DIR__.'/../../Class/BLL/ConstDataBLL.php';
require_once __DIR__.'/../../Class/BLL/IntentionRatingBLL.php';

class ComSettingAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
    }
    
    /**
     * @functional 显示 网盟转款最低金额限制 页面
    */
    public function UnitMinInMoney()
    {
        $this->PageRightValidate("UnitMinInMoney",Rightvalue::view);
        $objComSettingBLL = new ComSettingBLL();
        $iMinInMoney = $objComSettingBLL->GetValueByName(ComSettings::UnitMinInMoney);  

        $strUnitPreReMoneyRate = $objComSettingBLL->GetValueByName(ComSettings::UnitPreReMoneyRate,"1,0");               
        $aPreReRate = explode(",",$strUnitPreReMoneyRate);
        $this->smarty->assign('iPreRate',$aPreReRate[0]);
        $this->smarty->assign('iReRate',$aPreReRate[1]);
        
        $this->smarty->assign('iMinInMoney',$iMinInMoney);
        $this->smarty->display('System/ComSetting/UnitMinInMoney.tpl');
    }
    
    /**
     * @functional 网盟转款最低金额限制
    */
    public function UnitMinInMoneySubmit()
    {
        $this->ExitWhenNoRight("UnitMinInMoney",Rightvalue::add);
        $iMinInMoney = Utility::GetFormDouble('tbxMinInMoney',$_POST);
        if($iMinInMoney < 0)
            exit("网盟转款最低金额限制金额有误！");
        /*
        $iPreRate = Utility::GetFormDouble('tbxPreRate',$_POST);
        if($iPreRate < 0)
            exit("网盟转款比例“预存款”有误！");
        
        $iReRate = Utility::GetFormDouble('tbxReRate',$_POST);
        if($iReRate < 0)
            exit("网盟转款比例“返点”有误！");
        
        if($iPreRate + $iReRate <= 0)
            exit("网盟转款比例有误！");
        */
        $objComSettingBLL = new ComSettingBLL();
        $objComSettingInfo = new ComSettingInfo();      
        $objComSettingInfo->iIsLock = 0;
        $objComSettingInfo->iCreateUid = $this->getUserId();
        $objComSettingInfo->strCreateUserName = $this->getUserCNName();
        $objComSettingInfo->iUpdateUid = $this->getUserId();
        $objComSettingInfo->strUpdateUserName = $this->getUserCNName();
        
        $objComSettingInfo->strSettingName = ComSettings::UnitMinInMoney;  
        $objComSettingInfo->strSettingValue = $iMinInMoney;
            
        $updateID = 0;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        if($updateID <= 0)
            exit("网盟转款最低金额限制设置出错！");
        /*
        $objComSettingInfo->strSettingName = ComSettings::UnitPreReMoneyRate;  
        $objComSettingInfo->strSettingValue = $iPreRate.",".$iReRate;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        if($updateID <= 0)
            exit("网盟转款比例设置出错！");*/
                
        exit("0");
    }
    
    /**
     * @functional 显示账户余额(订单下单)设置页面
    */
    public function Order_AccountBalance()
    {
        $this->PageRightValidate("Order_AccountBalance",Rightvalue::view);
        //$this->smarty->assign('strTitle','账户余额(订单下单)设置');
        
        $iGuaMoney = 0;
        $iPreMoney = 0;
        
        $objComSettingBLL = new ComSettingBLL();
        $iGuaMoney = $objComSettingBLL->GetValueByName(ComSettings::Order_GuaAccountBalance);        
        $iPreMoney = $objComSettingBLL->GetValueByName(ComSettings::Order_PreAccountBalance);
            
        $iUnitGuaMoney = $objComSettingBLL->GetValueByName(ComSettings::UnitOrder_GuaAccountBalance);        
        $iUnitPreMoney = $objComSettingBLL->GetValueByName(ComSettings::UnitOrder_PreAccountBalance);
        
        $this->smarty->assign('iGuaMoney',$iGuaMoney);
        $this->smarty->assign('iPreMoney',$iPreMoney);
        $this->smarty->assign('iUnitGuaMoney',$iUnitGuaMoney);
        $this->smarty->assign('iUnitPreMoney',$iUnitPreMoney);
        $this->smarty->display('System/ComSetting/Order_AccountBalance.tpl');
    }
    
    /**
     * @functional 账户余额(订单下单)设置提交
    */
    public function Order_AccountBalanceSubmit()
    {
        $this->ExitWhenNoRight("Order_AccountBalance",Rightvalue::add);
        $iGuaMoney = Utility::GetFormDouble('tbxGuaMoney',$_POST);
        $iPreMoney = Utility::GetFormDouble('tbxPreMoney',$_POST);
        $iUnitGuaMoney = Utility::GetFormDouble('tbxUnitGuaMoney',$_POST);
        $iUnitPreMoney = Utility::GetFormDouble('tbxUnitPreMoney',$_POST);
        
        if($iGuaMoney < 0)
            exit("增值产品保证金款项金额有误！");
        
        if($iPreMoney < 0)
            exit("增值产品预存款款项金额有误！");
            
        if($iUnitGuaMoney < 0)
            exit("网盟保证金款项金额有误！");
        
        if($iUnitPreMoney < 0)
            exit("网盟预存款款项金额有误！");
            
        $objComSettingBLL = new ComSettingBLL();
        $objComSettingInfo = new ComSettingInfo();      
        $objComSettingInfo->iIsLock = 0;
        $objComSettingInfo->iCreateUid = $this->getUserId();
        $objComSettingInfo->strCreateUserName = $this->getUserCNName();
        $objComSettingInfo->iUpdateUid = $this->getUserId();
        $objComSettingInfo->strUpdateUserName = $this->getUserCNName();
        
        $objComSettingInfo->strSettingName = ComSettings::Order_GuaAccountBalance;  
        $objComSettingInfo->strSettingValue = $iGuaMoney;
            
        $updateID = 0;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        if($updateID <= 0)
            exit("增值产品保证金款项金额设置出错！");
        
        $objComSettingInfo->strSettingName = ComSettings::Order_PreAccountBalance;  
        $objComSettingInfo->strSettingValue = $iPreMoney;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        if($updateID <= 0)
            exit("增值产品预存款款项金额设置出错！");
                
        $objComSettingInfo->strSettingName = ComSettings::UnitOrder_GuaAccountBalance;  
        $objComSettingInfo->strSettingValue = $iUnitGuaMoney;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        if($updateID <= 0)
            exit("网盟保证金款项金额设置出错！");
                        
        $objComSettingInfo->strSettingName = ComSettings::UnitOrder_PreAccountBalance;  
        $objComSettingInfo->strSettingValue = $iUnitPreMoney;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        if($updateID <= 0)
            exit("网盟预存款款项金额设置出错！");
            
        exit("0");
    }
    
    /**
     * @functional 显示代理商账户余额提醒页面
    */
    public function AgentAccountBalanceWarning()
    {
        $this->PageRightValidate("AgentAccountBalanceWarning",Rightvalue::view);
        //$this->smarty->assign('strTitle','代理商账户余额提醒');
        
        $objComSettingBLL = new ComSettingBLL();
        $arrayData = $objComSettingBLL->GetAgentAccountBalanceWarning();
                
        $this->smarty->assign('arrayData',$arrayData);
        $this->smarty->display('System/ComSetting/AgentAccountBalanceWarning.tpl');
    }
    
      
    /**
     * @functional 显示代理商账户余额提醒 设置提交
    */
    public function AgentAccountBalanceWarningSubmit()
    {
        $this->ExitWhenNoRight("AgentAccountBalanceWarning",Rightvalue::add);
        
        $arrayPreMoney = array();
        $objProductTypeBLL = new ProductTypeBLL();
        $arrayProductType = $objProductTypeBLL->select("aid,product_type_no,product_type_name","","product_type_name");
        foreach($arrayProductType as $key => $value)
        {                
            $strProductID = $value["aid"];
            $iPreMoney = Utility::GetFormDouble('tbxPreMoney_'.$value["aid"],$_POST);
            $iGuaMoney = Utility::GetFormDouble('tbxGuaMoney_'.$value["aid"],$_POST);
            
            if($iPreMoney < 0)
                exit($value["product_type_name"]."保证金打款提醒金额有误！");
                
            if($iPreMoney < 0)
                exit($value["product_type_name"]."预存款打款提醒金额有误！");
            
            
            $arrayPreMoney["p_".$strProductID] = array($value["product_type_name"],$iGuaMoney,$iPreMoney);                 
        }
        
        $objComSettingBLL = new ComSettingBLL();        
        $objComSettingInfo = new ComSettingInfo();       
        $objComSettingInfo->iIsLock = 0;
        $objComSettingInfo->iCreateUid = $this->getUserId();
        $objComSettingInfo->strCreateUserName = $this->getUserCNName();
        $objComSettingInfo->iUpdateUid = $this->getUserId();
        $objComSettingInfo->strUpdateUserName = $this->getUserCNName();
        
        $updateID = 0;
        foreach($arrayProductType as $key => $value)
        {
            $updateID = 0;
            $objComSettingInfo->strDataType = $value["product_type_no"];
            $objComSettingInfo->strSettingName = ComSettings::Gua_BalanceWarning; 
            $objComSettingInfo->strSettingValue = $arrayPreMoney["p_".$value["aid"]][1];
            $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
            if($updateID <= 0)
                exit($arrayPreMoney["p_".$value["aid"]][0]."保证金打款提醒金额设置出错！");
                
            $objComSettingInfo->strSettingName = ComSettings::Pre_BalanceWarning; 
            $objComSettingInfo->strSettingValue = $arrayPreMoney["p_".$value["aid"]][2];
            $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
            if($updateID <= 0)
                exit($arrayPreMoney["p_".$value["aid"]][0]."预存款打款提醒金额设置出错！");                
        }
        
        exit("0");
    }
    
	/**
	 * @functional 显示代理商提交签约保证金预存款限制
     * @author 刘君臣
	*/
    public function ShowAgentSignBlanceSet()
    {
        $this->PageRightValidate("AgentSignSet",Rightvalue::view);
        //$this->smarty->assign('strTitle','代理商提交签约金额设置');
        
        $iGuaMoney = 0;
        $iPreMoney = 0;
        
        $objComSettingBLL = new ComSettingBLL();
        $iGuaMoney = $objComSettingBLL->GetValueByName(ComSettings::AgentSignGuaSet);        
        $iPreMoney = $objComSettingBLL->GetValueByName(ComSettings::AgentSignPreSet);
            
        $this->smarty->assign('iGuaMoney',$iGuaMoney);
        $this->smarty->assign('iPreMoney',$iPreMoney);
        $this->smarty->display('System/ComSetting/AgentSign_BalanceSet.tpl');
    }
    
    /**
	 * @functional 提交代理商提交签约保证金预存款限制
     * @author 刘君臣
	*/
    public function ShowAgentSignBlanceSubmit()
    {
        $this->ExitWhenNoRight("AgentSignSet",Rightvalue::add);
        $iGuaMoney = Utility::GetFormDouble('tbxGuaMoney',$_POST);
        $iPreMoney = Utility::GetFormDouble('tbxPreMoney',$_POST);
        
        if($iGuaMoney < 0)
            exit("保证金款项金额有误！");
        
        if($iPreMoney < 0)
            exit("预存款款项金额有误！");
            
        $objComSettingBLL = new ComSettingBLL();
        $objComSettingInfo = new ComSettingInfo();      
        $objComSettingInfo->iIsLock = 0;
        $objComSettingInfo->iCreateUid = $this->getUserId();
        $objComSettingInfo->strCreateUserName = $this->getUserCNName();
        $objComSettingInfo->iUpdateUid = $this->getUserId();
        $objComSettingInfo->strUpdateUserName = $this->getUserCNName();
        
        $objComSettingInfo->strSettingName = ComSettings::AgentSignGuaSet;  
        $objComSettingInfo->strSettingValue = $iGuaMoney;
            
        $updateID = 0;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        if($updateID <= 0)
            exit("保证金款项金额设置出错！");
        
        $objComSettingInfo->strSettingName = ComSettings::AgentSignPreSet;  
        $objComSettingInfo->strSettingValue = $iPreMoney;
        $updateID = $objComSettingBLL->InsertOrUpdate($objComSettingInfo);
        if($updateID <= 0)
            exit("预存款款项金额设置出错！");
        
        exit("0");
    }
    
    public function showCustomerCommenParse(){
        $this->PageRightValidate("CustomerCommentParse", RightValue::view);
        $objDataConfigBLL = new DataConfigBLL();
        $arrProtectDateList = $objDataConfigBLL->getProtectDate();
        foreach($arrProtectDateList as $arrProtectDateInfo){
            $this->smarty->assign($arrProtectDateInfo['data_type'],$arrProtectDateInfo);
        }
        //$objConstDataBLL = new ConstDataBLL();
        //$arrayNotValid = $objConstDataBLL->select("c_value,c_name","data_type='".CustomerDataConfig::Invalid_Contact."'","sort_index");
        $this->displayPage('System/ComSetting/CustomerCommenParse.tpl');
    }
    
    public function getCMIntentionRatingBody(){
        $this->ExitWhenNoRight("CustomerCommentParse",  RightValue::v128);
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $arrIntentionRatingList = $objIntentionRatingBLL->getIntentionRating();
        $this->smarty->assign("IntentionRatingList",$arrIntentionRatingList);
        echo $this->smarty->fetch('System/ComSetting/CMSetIntentionRatingBody.tpl');
    }
    
    public function getCMInvalidContactBody(){
        $this->ExitWhenNoRight("CustomerCommentParse", RightValue::v64);
        $objConstDataBLL = new ConstDataBLL();
        $arrInvaildContactList = $objConstDataBLL->select("c_id,c_value,c_name,data_type,sort_index","data_type='".CustomerDataConfig::Invalid_Contact."'","sort_index");
        $this->smarty->assign("InvaildContactList",$arrInvaildContactList);
        echo $this->smarty->fetch('System/ComSetting/CMSetInvalidContactBody.tpl');
    }
    
    public function getCMToSeaBody(){
        $this->ExitWhenNoRight("CustomerCommentParse", RightValue::view);
        $objDataConfigBLL = new DataConfigBLL();
        $arrToSeaTimeList = $objDataConfigBLL->getToSeaTimeList();
        $this->smarty->assign("ToSeaTimeList",$arrToSeaTimeList);
        echo $this->smarty->fetch('System/ComSetting/CMSetToSeaTimeBody.tpl');
    }
    
    public function getCMToSeaOptionBody(){
        $this->ExitWhenNoRight("CustomerCommentParse", RightValue::view);
        $objDataConfigBLL = new DataConfigBLL();
        $arrToSeaOptionList = $objDataConfigBLL->getToSeaOption();
        $this->smarty->assign("ToSeaOptionList",$arrToSeaOptionList);
        echo $this->smarty->fetch('System/ComSetting/CMSetToSeaOptionBody.tpl');
    }
    
    public function showAddToSeaTime(){
        $this->ExitWhenNoRight("CustomerCommentParse", RightValue::v4);
        $iDid = Utility::GetFormInt("id", $_GET);
        $this->showAddToSeaTimeCommon($iDid);
    }
    
    public function showAddToSeaTimeCommon($iDid){
        $objDataConfigBLL = new DataConfigBLL();
        $strMinTime = '';
        $strMaxTime = '';
        if($iDid>0){
            $objDataConfigInfo = $objDataConfigBLL->getModelByID($iDid);
            $arrTime = explode(',', $objDataConfigInfo->strDValue);
            $strMinTime = $arrTime[0];
            $strMaxTime = $arrTime[1];
        }
        $this->smarty->assign("MinTime",$strMinTime);
        $this->smarty->assign("MaxTime",$strMaxTime);
        echo $this->smarty->fetch('System/ComSetting/AddToSeaTime.tpl');
    }
    
    public function AddToSeaTime(){
        if (!$this->HaveRight("CustomerCommentParse", RightValue::v4)) {
            Utility::Msg("对不起，您没有权限", true);
        }

        $iDid = Utility::GetFormInt("id", $_GET);
        $strMinTime = Utility::GetForm("min_time", $_POST);
        $strMaxTime = Utility::GetForm("max_time", $_POST);
        if (empty($strMinTime)) {
            Utility::Msg("请设置区间最小时间");
        }
        if (empty($strMaxTime)) {
            Utility::Msg("请设置区间最大时间");
        }

        $objDataConfigBLL = new DataConfigBLL();
        $arrTimeList = $objDataConfigBLL->getToSeaTimeArray();
        if ($iDid > 0) {
            $objDataConfigInfo = $objDataConfigBLL->getModelByID($iDid);
            //消去对应的区间
            for($i = 0;$i<count($arrTimeList);$i++){
                if(str_replace(',', ' - ', $objDataConfigInfo->strDValue) == $arrTimeList[$i]){
                    unset($arrTimeList[$i]);
                }
            }
        } else {
            $objDataConfigInfo = new DataConfigInfo();
        }
        if (!$this->VaildScope($arrTimeList, $strMinTime, $strMaxTime)) {
            Utility::Msg("区间重合");
        }
        
        
        $objDataConfigInfo->strDValue = "{$strMinTime},{$strMaxTime}";
        $objDataConfigInfo->iUpdateUid = $this->getUserId();
        $objDataConfigInfo->strUpdateTime = Utility::Now();
        if($iDid > 0){
            $iRtn = $objDataConfigBLL->updateByID($objDataConfigInfo);
        }else{
            $objDataConfigInfo->strDName = '允许拉取客户的时间段';
            $objDataConfigInfo->strDataType = 'PullCustomerTime';
            $objDataConfigInfo->iCreateUid = $this->getUserId();
            $objDataConfigInfo->strCreateTime = Utility::Now();
            $iRtn = $objDataConfigBLL->insert($objDataConfigInfo);
        }
        if($iRtn !==false){
            Utility::Msg("设置成功",true);
        }else{
            Utility::Msg("设置失败");
        }
    }
    
    public function showAddToSeaOption(){
        $iDid = Utility::GetFormInt("id", $_GET);
        $objDataConfigBLL = new DataConfigBLL();
        $strMinTime = '';
        $strMaxTime = '';
        $strDName = '';
        if($iDid>0){
            $objDataConfigInfo = $objDataConfigBLL->getModelByID($iDid);
            $strDName = $objDataConfigInfo->strDName;
            $arrTime = explode(',', $objDataConfigInfo->strDValue);
            $strMinTime = $arrTime[0];
            $strMaxTime = $arrTime[1];
        }
        $this->smarty->assign('SelectOption',$strDName);
        $this->smarty->assign("MinTime",$strMinTime);
        $this->smarty->assign("MaxTime",$strMaxTime);
        $this->displayPage('System/ComSetting/AddToSeaOption.tpl');
    }
    
    public function AddToSeaOption(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::v8)){
            Utility::Msg("对不起，您没有权限",true);
        }
        
        $iDid = Utility::GetFormInt("id", $_GET);
        $iMinDay = Utility::GetFormInt("min_day", $_POST);
        $iMaxDay = Utility::GetFormInt("max_day", $_POST);
        $strVName = Utility::GetForm("selectname", $_POST);
        if(empty ($iMinDay)||$iMinDay < 0){
            Utility::Msg("请设置最小时间");
        }
        if(empty ($iMaxDay)||$iMaxDay < 0){
            Utility::Msg("请设置最大时间");
        }
        if(empty ($strVName)){
            Utility::Msg("选项内容不得为空");
        }
        
        if($iMinDay > $iMaxDay){
            $iTemp = $iMinDay;
            $iMinDay = $iMaxDay;
            $iMaxDay = $iTemp;
        }
        
        $objDataConfigBLL = new DataConfigBLL();
        if($iDid > 0){
            $objDataConfigInfo = $objDataConfigBLL->getModelByID($iDid);
        }else{
            $objDataConfigInfo = new DataConfigInfo();
            $objDataConfigInfo->strDataType = 'ToSeaProtectDate';
            $objDataConfigInfo->iCreateUid = $this->getUserId();
            $objDataConfigInfo->strCreateTime = Utility::Now();
        }
        
        $objDataConfigInfo->strDValue = "{$iMinDay},{$iMaxDay}";
        $objDataConfigInfo->strDName = $strVName;
        $objDataConfigInfo->iUpdateUid = $this->getUserId();
        $objDataConfigInfo->strUpdateTime = Utility::Now();
        if($iDid > 0){
            $iRtn = $objDataConfigBLL->updateByID($objDataConfigInfo);
        }else{
            $iRtn = $objDataConfigBLL->insert($objDataConfigInfo);
        }
        if($iRtn !==false){
            Utility::Msg("设置成功",true);
        }else{
            Utility::Msg("设置失败");
        }
    }
    
    public function showEditDataConfigValue(){
        $iDid = Utility::GetFormInt("id", $_GET);
        $objDataConfigBLL = new DataConfigBLL();
        $strMinTime = '';
        $strMaxTime = '';
        if($iDid>0){
            $objDataConfigInfo = $objDataConfigBLL->getModelByID($iDid);
            $arrTime = explode(',', $objDataConfigInfo->strDValue);
            $strMinTime = $arrTime[0];
            $strMaxTime = $arrTime[1];
        }
        $this->smarty->assign("MinTime",$strMinTime);
        $this->smarty->assign("MaxTime",$strMaxTime);
        $this->displayPage('System/ComSetting/EditProtectDate.tpl');
    }
    
    public function EditDataConfigValue(){
        $iDid = Utility::GetFormInt("id",$_GET);
        $iMinDay = Utility::GetFormInt("min_day", $_POST);
        $iMaxDay = Utility::GetFormInt("max_day", $_POST);
        if(empty ($iDid)){
            Utility::Msg("获取配置参数出错，请重新刷新页面");
        }
        if(empty ($iMinDay)&&$iMinDay < 0){
            Utility::Msg("请设置最小时间");
        }
        if(empty ($iMaxDay)&&$iMaxDay < 0){
            Utility::Msg("请设置最大时间");
        }
        if($iMinDay > $iMaxDay){
            $iTemp = $iMinDay;
            $iMinDay = $iMaxDay;
            $iMaxDay = $iTemp;
        }
        $objDataConfigBLL = new DataConfigBLL();
        $iRtn = $objDataConfigBLL->UpdateValue($iDid, "{$iMinDay},{$iMaxDay}", $this->getUserId(), Utility::Now());
        if($iRtn !==false){
            Utility::Msg("设置成功",true,"{$iMinDay} - {$iMaxDay}");
        }else{
            Utility::Msg("设置失败");
        }
    }
    
    public function showEditProtectDate(){
        $this->ExitWhenNoRight("CustomerCommentParse", RightValue::v16);
        $this->showEditDataConfigValue();
    }
    
    public function EditProtectDate(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::v16)){
            Utility::Msg("对不起，您没有权限");
        }
        $this->EditDataConfigValue();
    }
    
    public function showEditAllowCount(){
        $this->ExitWhenNoRight("CustomerCommentParse", RightValue::v32);
        $this->showEditDataConfigValue();
    }
    
    public function EditAllowCount(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::v32)){
            Utility::Msg("对不起，您没有权限");
        }
        $this->EditDataConfigValue();
    }
    
    public function showAddInvaildContact(){
        $this->ExitWhenNoRight("CustomerCommentParse", RightValue::v64);
        $iCid = Utility::GetFormInt("id", $_GET);
        $strCName = '';
        $iSortIndex = 0;
        if($iCid > 0){
            $objConstDataBLL = new ConstDataBLL();
            $objConstDataInfo = $objConstDataBLL->getModelByID($iCid);
            $strCName = $objConstDataInfo->strcName;
            $iSortIndex = $objConstDataInfo->iSortIndex;
        }
        $this->smarty->assign("OptionItem",$strCName);
        $this->smarty->assign("SortIndex",$iSortIndex);
        echo $this->smarty->fetch('System/ComSetting/AddInvaildContact.tpl'); 
    }
    
    public function AddInvaildContact(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::v64)){
            Utility::Msg("对不起，您没有权限");
        }
        $iCid = Utility::GetFormInt("id", $_GET);
        $strCName = Utility::GetForm("optionitem", $_POST);
        $iSortIndex = Utility::GetFormInt("sortindex", $_POST);
        if(empty ($strCName)){
            Utility::Msg("选项内容不得为空");
        }
        if(empty ($iSortIndex)){
            Utility::Msg("请填写排序");
        }
        
        $objConstDataBLL = new ConstDataBLL();
        
        
        if($iCid >0){
            $objConstDataInfo = $objConstDataBLL->getModelByID($iCid);
        }else{
            $objConstDataInfo = new ConstDataInfo();
            $objConstDataInfo->strDataType = 'Invalid_Contact';
            $objConstDataInfo->strcValue = $objConstDataBLL->getNewInvaildContactValue();
            $objConstDataInfo->iCreateUid = $this->getUserId();
            $objConstDataInfo->strCreateTime = Utility::Now();
        }
        if ($objConstDataInfo->iSortIndex != $iSortIndex) {
            $isExit = $objConstDataBLL->selectTop("1", "data_type='" . CustomerDataConfig::Invalid_Contact . "' and sort_index={$iSortIndex}", "", "", 1);
            if ($isExit) {
                Utility::Msg("选项排序重复");
            }
        }
        $objConstDataInfo->iSortIndex = $iSortIndex;
        $objConstDataInfo->strcName = $strCName;
        $objConstDataInfo->iUpdateUid = $this->getUserId();
        $objConstDataInfo->strUpdateTime = Utility::Now();
        if($iCid > 0){
            $iRtn = $objConstDataBLL->updateByID($objConstDataInfo);
        }else{
            $iRtn = $objConstDataBLL->insert($objConstDataInfo);
        }
        if($iRtn !==false){
            Utility::Msg("设置成功",true);
        }else{
            Utility::Msg("设置失败");
        }
    }
    
    public function showAddIntentionRating(){
        $this->ExitWhenNoRight("CustomerCommentParse", RightValue::v128);
        $iRatngID = Utility::GetFormInt("id", $_GET);
        $strRatingName = '';
        $strRemark = '';
        $iSortIndex = 0;
        $iIsMoneyTime = 0;
        if($iRatngID > 0){
            $objIntentionRatingBLL = new IntentionRatingBLL();
            $objIntentionRatingInfo = $objIntentionRatingBLL->getModelByID($iRatngID);
            $strRatingName = $objIntentionRatingInfo->strRatingName;
            $strRemark = $objIntentionRatingInfo->strRemark;
            $iSortIndex = $objIntentionRatingInfo->iSortIndex;
            $iIsMoneyTime = $objIntentionRatingInfo->iIsMoneyTime;
        }
        $this->smarty->assign("RatingName",$strRatingName);
        $this->smarty->assign("Remark",$strRemark);
        $this->smarty->assign("SortIndex",$iSortIndex);
        $this->smarty->assign("IsMoneyTime",$iIsMoneyTime);
        echo $this->smarty->fetch('System/ComSetting/AddIntentionRating.tpl'); 
    }
    
    public function AddIntentionRating(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::v128)){
            Utility::Msg("对不起，您没有权限");
        }
        $iRatingID = Utility::GetFormInt("id",$_GET);
        $strRatingName = Utility::GetForm("ratingname", $_POST);
        $strRemark = Utility::GetForm("remark", $_POST);
        $iSortIndex = Utility::GetFormInt("sortindex", $_POST);
        $iIsMoneyTime = Utility::GetFormInt("ismoneytime", $_POST);
        
        if(empty ($strRatingName)){
            Utility::Msg("选项等级不能为空");
        }
        if(empty ($iSortIndex)){
            Utility::Msg("选项排序必须大于0");
        }
        if(empty ($strRemark)){
            Utility::Msg("选项内容不能为空");
        }
        $objIntentionRatingBLL =new IntentionRatingBLL();
        if($iRatingID > 0){
            $objIntentionRatingInfo = $objIntentionRatingBLL->getModelByID($iRatingID);
        }else{
            $objIntentionRatingInfo = new IntentionRatingInfo();
            $objIntentionRatingInfo->iIsReport = 0;
            $objIntentionRatingInfo->strCreateTime = Utility::Now();
            $objIntentionRatingInfo->iCreateUid = $this->getUserId();
        }
        if($objIntentionRatingInfo->strRatingName != $strRatingName || $objIntentionRatingInfo->iSortIndex != $iSortIndex){
            $arrData = $objIntentionRatingBLL->IsIntentionRatngExist($iSortIndex, $strRatingName);
            if($objIntentionRatingInfo->strRatingName != $strRatingName && $arrData[0]){
                Utility::Msg("选项等级已经存在");
            }
            if($objIntentionRatingInfo->iSortIndex != $iSortIndex && $arrData[1]){
                Utility::Msg("选项排序已经存在");
            }
        }
        $objIntentionRatingInfo->strRatingName = $strRatingName;
        $objIntentionRatingInfo->strRemark = $strRemark;
        $objIntentionRatingInfo->iSortIndex = $iSortIndex;
        $objIntentionRatingInfo->iIsMoneyTime = $iIsMoneyTime;
        $objIntentionRatingInfo->strUpdateTime = Utility::Now();
        $objIntentionRatingInfo->iUpdateUid = $this->getUserId();
        if($iRatingID > 0){
            $iRtn = $objIntentionRatingBLL->updateByID($objIntentionRatingInfo);
        }else{
            $iRtn = $objIntentionRatingBLL->insert($objIntentionRatingInfo);
        }
        if($iRtn !==false){
            Utility::Msg("设置成功",true);
        }else{
            Utility::Msg("设置失败");
        }
    }
    
    public function DelToSeaTime(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::add)){
            Utility::Msg("对不起，您没有权限");
        }
        $objDataConfigBLL = new DataConfigBLL();
        $arrToSeaList = $objDataConfigBLL->getToSeaTimeList();
        if($arrToSeaList && count($arrToSeaList)>1){
            $this->DelCommon();
        }
        Utility::Msg("删除失败，至少要保留一个区间");
    }
    
    public function DelToSeaOption(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::v8)){
            Utility::Msg("对不起，您没有权限");
        }
        $objDataConfigBLL = new DataConfigBLL();
        $arrToSeaList = $objDataConfigBLL->getToSeaOption();
        if($arrToSeaList && count($arrToSeaList)>1){
            $this->DelCommon();
        }
        Utility::Msg("删除失败，至少要保留一个选项");
    }
    
    public function DelInvaildContact(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::v64)){
            Utility::Msg("对不起，您没有权限");
        }
        $objConstDataBLL = new ConstDataBLL();
        $arrInvaildContactList = $objConstDataBLL->select("c_value,c_name","data_type='".CustomerDataConfig::Invalid_Contact."'","sort_index");
        if($arrInvaildContactList && count($arrInvaildContactList)>1){
            $iDid = Utility::GetFormInt("id", $_GET);
            $iRtn = $objConstDataBLL->deleteByID($iDid, $this->getUserId());
            if($iRtn!==false){
                Utility::Msg("删除成功",true);
            }else{
                Utility::Msg("删除失败");
            }
        }
        Utility::Msg("删除失败，至少要保留一个选项");
    }
    
    public function DelIntentionRating(){
        if(!$this->HaveRight("CustomerCommentParse", RightValue::v128)){
            Utility::Msg("对不起，您没有权限");
        }
        $iRating = Utility::GetFormInt("id", $_GET);
        $objIntentionRatingBLL = new IntentionRatingBLL();
        $objIntentionRatingInfo = $objIntentionRatingBLL->getModelByID($iRating);
        if($objIntentionRatingInfo&&$objIntentionRatingInfo->iIsReport == 0){
            $iRtn = $objIntentionRatingBLL->deleteByID($iRating, $this->getUserId());
            if($iRtn !== false){
                Utility::Msg("删除成功",true);
            }else{
                Utility::Msg("删除失败");
            }
        }
        Utility::Msg("删除失败，不能删除涉及报表统计的项");
    }
    
    private function DelCommon(){
        $objDataConfigBLL = new DataConfigBLL();
        $iDid = Utility::GetFormInt("id", $_GET);
        $iRtn = $objDataConfigBLL->deleteByID($iDid, $this->getUserId());
        if($iRtn!==false){
            Utility::Msg("删除成功",true);
        }else{
            Utility::Msg("删除失败");
        }
    }
    
    public function showCustomerCommen_Front(){
        $this->PageRightValidate("FrontCommonSet", RightValue::view);
        $this->displayPage("System/Front/CustomerCommen.tpl");
    }
    
    public function getFrontProtectDateBody(){
        $this->ExitWhenNoRight("FrontCommonSet", RightValue::v8);
        $objDataConfigBLL = new DataConfigBLL();
        $arrProtectDateList = $objDataConfigBLL->getFrontprotectDateList($this->getAgentId());
        $this->smarty->assign("ProtectDateList",$arrProtectDateList);
        echo $this->smarty->fetch('System/Front/ProtectDateBody.tpl');
    }
    
    public function getFrontAllowCountBody(){
        $this->ExitWhenNoRight("FrontCommonSet", RightValue::v32);
        $objDataConfigBLL = new DataConfigBLL();
        $arrAllowCountList = $objDataConfigBLL->getFrontAllowCountList($this->getAgentId());
        $this->smarty->assign("AllowCountList",$arrAllowCountList);
        echo $this->smarty->fetch('System/Front/AllowCountBody.tpl');
    }
    
    public function getFrontToSeaOptionBody(){
        $this->ExitWhenNoRight("FrontCommonSet", RightValue::v16);
        $objDataConfigBLL = new DataConfigBLL();
        $arrToSeaList = $objDataConfigBLL->GetToSeaProtectDate($this->getAgentId());
        $this->smarty->assign("ToSeaList",$arrToSeaList);
        echo $this->smarty->fetch('System/Front/ToSeaOptionBody.tpl');
    }
    
    public function getFrontToSeaTimeBody(){
        $this->ExitWhenNoRight("FrontCommonSet", RightValue::v4);
        $objDataConfigBLL = new DataConfigBLL();
        $arrToSeaTimeList = $objDataConfigBLL->getToSeaTimeList4Front($this->getAgentId());
        for($i = 0;$i<count($arrToSeaTimeList);$i++){
            $arrToSeaTimeList[$i]['back_value'] = str_replace(',', ' - ', $arrToSeaTimeList[$i]['back_value']);
            $arrToSeaTimeList[$i]['front_value'] = str_replace('|', ' , ', str_replace(',', ' - ', $arrToSeaTimeList[$i]['front_value']));
            if(empty ($arrToSeaTimeList[$i]['front_id'])) $arrToSeaTimeList[$i]['front_id'] = 0;
        }
        $this->smarty->assign("ToSeaTime",$arrToSeaTimeList);
        echo $this->smarty->fetch('System/Front/ToSeaTimeBody.tpl');
    }
    
    public function showEditProtectDateFront(){
        $this->ExitWhenNoRight("FrontCommonSet", RightValue::v8);
        $strDataType = Utility::GetForm("datatype", $_GET);
        $objDataConfigBLL = new DataConfigBLL();
        $arrProtectDateList = $objDataConfigBLL->getFrontprotectDateList($this->getAgentId());
        $arrBackScope = $objDataConfigBLL->GetDataConfigByBack($strDataType);
        $this->smarty->assign("ValueData",$arrProtectDateList[$strDataType]);
        $this->smarty->assign("ScopeValue",$arrBackScope[0]['d_value']);
        $this->displayPage('System/Front/EditProtectDate.tpl');
    }
    
    public function showEditAlowCountFront(){
        $this->ExitWhenNoRight("FrontCommonSet", RightValue::v32);
        $strDataType = Utility::GetForm("datatype", $_GET);
        $objDataConfigBLL = new DataConfigBLL();
        $arrAllowCountList = $objDataConfigBLL->getFrontAllowCountList($this->getAgentId());
        $arrBackScope = $objDataConfigBLL->GetDataConfigByBack($strDataType);
        $this->smarty->assign("ValueData",$arrAllowCountList[$strDataType]);
        $this->smarty->assign("ScopeValue",$arrBackScope[0]['d_value']);
        $this->displayPage('System/Front/EditProtectDate.tpl');
    }
    
    public function EditAlowCountFront(){
        if (!$this->HaveRight("FrontCommonSet", RightValue::v32)) {
            Utility::Msg("对不起，您没有权限");
        }
        $objDataConfigBLL = new DataConfigBLL();
        $objDataConfigBLL->ClearAllowCountCache($this->getAgentId());
        $this->EditCommonFront();
    }
    
    public function EditProtectDateFront(){
        if (!$this->HaveRight("FrontCommonSet", RightValue::v8)) {
            Utility::Msg("对不起，您没有权限");
        }
        $objDataConfigBLL = new DataConfigBLL();
        $objDataConfigBLL->ClearProtectDateCache($this->getAgentId());
        $this->EditCommonFront();
    }
    
    public function EditCommonFront(){
        $iDValue = Utility::GetFormInt("valueday", $_POST);
        $strDataType = Utility::GetForm("datatype", $_GET);
        if (empty($iDValue))
            Utility::Msg("必须是数值");
        if (empty($strDataType))
            Utility::Msg("必须指定配置类型");
        $objDataConfigBLL = new DataConfigBLL();
        $objBackProtectDataInfo = $objDataConfigBLL->getModelByDataType($strDataType, 0);
        if ($objBackProtectDataInfo) {
            if (!$this->IsInTheScope($iDValue, $objBackProtectDataInfo->strDValue))
                Utility::Msg("数值必须介于" . str_replace(',', ' - ', $objBackProtectDataInfo->strDValue) . "之间");

            $objFrontProtectDataInfo = $objDataConfigBLL->getModelByDataType($strDataType, $this->getAgentId());
            if ($objFrontProtectDataInfo) {
                $objFrontProtectDataInfo->strDValue = $iDValue;
                $objFrontProtectDataInfo->strUpdateTime = Utility::Now();
                $objFrontProtectDataInfo->iUpdateUid = $this->getUserId();
                $iRtn = $objDataConfigBLL->updateByID($objFrontProtectDataInfo);
            } else {
                $objBackProtectDataInfo->iSId = $objBackProtectDataInfo->iDId;
                $objBackProtectDataInfo->iAgentId = $this->getAgentId();
                $objBackProtectDataInfo->strDValue = $iDValue;
                $objBackProtectDataInfo->strCreateTime = Utility::Now();
                $objBackProtectDataInfo->iCreateUid = $this->getUserId();
                $objBackProtectDataInfo->strUpdateTime = Utility::Now();
                $objBackProtectDataInfo->iUpdateUid = $this->getUserId();
                $iRtn = $objDataConfigBLL->insert($objBackProtectDataInfo);
            }
            
            if ($iRtn !== false) {
                Utility::Msg("设置成功", true);
            } else {
                Utility::Msg("设置失败");
            }
        }
        Utility::Msg("设置出错，不存在该项设置");
    }
    
    public function showToSeaOptionFront(){
        $this->ExitWhenNoRight("FrontCommonSet", RightValue::v16);
        $iValue = Utility::GetFormInt("oldvalue", $_GET);
        $iSid = Utility::GetFormInt("backid", $_GET);
        $objDataConfigBLL = new DataConfigBLL();
        $objDataConfigInfo = $objDataConfigBLL->getModelByID($iSid);
        $strScope = str_replace(",", " - ", $objDataConfigInfo->strDValue);
        $this->smarty->assign("ScopeValue",$strScope);
        $this->smarty->assign("ValueData",$iValue);
        $this->displayPage('System/Front/EditProtectDate.tpl');
    }
    
    public function ToSeaOptionFront(){
        if(!$this->HaveRight("FrontCommonSet", RightValue::v16)){
            Utility::Msg("对不起，您没有权限");
        }
        $iSid = Utility::GetFormInt("backid", $_GET);
        $iDid = Utility::GetFormInt("frontid", $_GET);
        $iDValue = Utility::GetFormInt("valueday", $_POST);
        if($iSid <= 0)
            Utility::Msg ("获取初始化数据失败");
        if($iDValue <= 0)
            Utility::Msg ("屏蔽天数不得为空");
        $objDataConfigBLL = new DataConfigBLL();
        $objBackToSeaInfo = $objDataConfigBLL->getModelByID($iSid);
        if($objBackToSeaInfo){
            if (!$this->IsInTheScope($iDValue, $objBackToSeaInfo->strDValue))
                Utility::Msg("数值必须介于" . str_replace(',', ' - ', $objBackToSeaInfo->strDValue) . "之间");
            
            if($iDid > 0){
                $objFrontToSeaInfo = $objDataConfigBLL->getModelByID($iDid);
                $objFrontToSeaInfo->strDValue = $iDValue;
                $objFrontToSeaInfo->strUpdateTime = Utility::Now();
                $objFrontToSeaInfo->iUpdateUid = $this->getUserId();
                $iRtn = $objDataConfigBLL->updateByID($objFrontToSeaInfo);
            }else{
                $objBackToSeaInfo->iSId = $objBackToSeaInfo->iDId;
                $objBackToSeaInfo->iAgentId = $this->getAgentId();
                $objBackToSeaInfo->strDValue = $iDValue;
                $objBackToSeaInfo->iCreateUid = $this->getUserId();
                $objBackToSeaInfo->strCreateTime = Utility::Now();
                $objBackToSeaInfo->iUpdateUid = $this->getUserId();
                $objBackToSeaInfo->strUpdateTime = Utility::Now();
                $iRtn = $objDataConfigBLL->insert($objBackToSeaInfo);
            }
            if($iRtn !==false){
                Utility::Msg("设置成功",true);
            }else{
                Utility::Msg("设置失败");
            }
        }
        Utility::Msg("设置出错，不存在该项设置");
    }
    
    public function showAddToSeaTimeFront(){
        $this->ExitWhenNoRight("FrontCommonSet", RightValue::v4);
        $iBackID = Utility::GetFormInt("backid", $_GET);
        $iFrontID = Utility::GetFormInt("frontid", $_GET);
        $objDataConfigBLL = new DataConfigBLL();
        $objBackDataConfigInfo = $objDataConfigBLL->getModelByID($iBackID);
        if (!empty($iFrontID)) {
            $objFrontDataConfigInfo = $objDataConfigBLL->getModelByID($iFrontID);
            $arrTemp = explode('|', $objFrontDataConfigInfo->strDValue);
        }else{
            $arrTemp = array();
        }
        $iCount = count($arrTemp);
        if ($iCount > 3)
            $iCount = 3;
        for ($i = 0; $i < 3; $i++) {
            if (isset($arrTemp[$i])) {
                $arrValue[] = explode(',', $arrTemp[$i]);
            } else {
                $arrValue[] = array('', '');
            }
        }
        
        $this->smarty->assign('Count',$iCount);
        $this->smarty->assign('FrontValue',$arrValue);
        $this->smarty->assign('BackTime',  str_replace(',', ' - ', $objBackDataConfigInfo->strDValue));
        $this->displayPage('System/Front/ToSeaTimeSet.tpl');
    }
    
    public function AddToSeaTimeFront(){
        if(!$this->HaveRight("FrontCommonSet", RightValue::v4)){
            Utility::Msg("对不起，您没有权限");
        }
        $iBackID = Utility::GetFormInt("backid", $_GET);
        $iFrontID = Utility::GetFormInt("frontid", $_GET);
        $arrTimePool[] = Utility::GetForm("value_begin_1", $_POST);
        $arrTimePool[] = Utility::GetForm('value_begin_2', $_POST);
        $arrTimePool[] = Utility::GetForm('value_begin_3', $_POST);
        $arrTimePool[] = Utility::GetForm('value_end_1', $_POST);
        $arrTimePool[] = Utility::GetForm('value_end_2', $_POST);
        $arrTimePool[] = Utility::GetForm('value_end_3', $_POST);
        
        if(empty ($iBackID)){
            Utility::Msg("厂商获取参数失败");
        }
        $arrTimePool = array_filter($arrTimePool);
        sort($arrTimePool);
        
        $objDataConfigBLL = new DataConfigBLL();
        if(!empty($arrTimePool)) {
            $objDataConfigInfo = $objDataConfigBLL->getModelByID($iBackID);
            $arrBackTimeScope = explode(',', $objDataConfigInfo->strDValue);
            if ($arrTimePool[0] < $arrBackTimeScope[0] || $arrTimePool[count($arrTimePool) - 1] > $arrBackTimeScope[1]) {
                Utility::Msg("所设置时间必须在后台默认范围内");
            }
            $strValue = "";
            $bFlag = true;
            foreach ($arrTimePool as $data) {
                if ($bFlag) {
                    $strValue .= "|{$data}";
                    $bFlag = false;
                } else {
                    $strValue .= ",{$data}";
                    $bFlag = true;
                }
            }
            $strValue = (strlen($strValue) > 1) ? substr($strValue, 1) : '';
        }else{
            $strValue = '';
        }
        
        
        if(empty ($iFrontID)){
            $objDataConfigInfo = $objDataConfigBLL->getModelByID($iBackID);
            $objDataConfigInfo->iAgentId = $this->getAgentId();
            $objDataConfigInfo->iSId = $iBackID;
            $objDataConfigInfo->strCreateTime = Utility::Now();
            $objDataConfigInfo->iCreateUid = $this->getUserId();
        }else{
            $objDataConfigInfo = $objDataConfigBLL->getModelByID($iFrontID);
        }
        $objDataConfigInfo->strDValue = $strValue;
        $objDataConfigInfo->strUpdateTime = Utility::Now();
        $objDataConfigInfo->iUpdateUid = $this->getUserId();
        if(empty ($iFrontID)){
            $iRtn = $objDataConfigBLL->insert($objDataConfigInfo);
        }else{
            $iRtn = $objDataConfigBLL->updateByID($objDataConfigInfo);
        }
        if($iRtn !==false){
            Utility::Msg("设置成功",true);
        }else{
            Utility::Msg("设置失败");
        }
        
        
        
//        $iSid = Utility::GetFormInt("backid'", $_GET);
//        $iDid = Utility::GetFormInt("frontid", $_GET);        
//        $strMinTime = Utility::GetForm("min_time", $_POST);
//        $strMaxTime = Utility::GetForm("max_time", $_POST);
//        if(empty ($strMinTime))
//            Utility::Msg ("请出入开始时间");
//        if(empty ($strMaxTime))
//            Utility::Msg ("请输入结束时间");
//        if($strMaxTime < $strMinTime){
//            $strTemp = $strMinTime;
//            $strMaxTime = $strMinTime;
//            $strMinTime = $strTemp;
//        }
//        
//        $objDataConfigBLL = new DataConfigBLL();
//        $arrBackTimeList = $objDataConfigBLL->getToSeaTimeArray();
//        $arrToSeaList = $objDataConfigBLL->GetPullCustomerTime($this->getAgentId());
//        if(empty ($iSid)){
//            $objFrontToSeaTimeInfo = $objDataConfigBLL->getModelByDataType(CustomerDataConfig::PullCustomerTime, 0);
//            for ($i = 0; $i < count($arrToSeaList); $i++) {
//                $arrFrontTimeList[] = str_replace(',', ' - ', $arrToSeaList[$i]['d_value']); 
//            }
//        }else{
//            if (empty($iDid)) {
//                $objFrontToSeaTimeInfo = $objDataConfigBLL->getModelByID($iSid);
//            } else {
//                $objFrontToSeaTimeInfo = $objDataConfigBLL->getModelByID($iDid);
//            }
//            for ($i = 0; $i < count($arrToSeaList); $i++) {
//                if($objFrontToSeaTimeInfo->strDValue != $arrToSeaList[$i]['d_value']){
//                    $arrFrontTimeList[] = str_replace(',', ' - ', $arrToSeaList[$i]['d_value']); 
//                }
//            }
//        }
//        
//        if(!$this->VaildInBackScope($arrBackTimeList, $strMinTime, $strMaxTime)){
//            Utility::Msg("请在允许设置范围内填写"); 
//        }
//        sort($arrFrontTimeList);
//        if(!$this->VaildScope($arrFrontTimeList, $strMinTime, $strMaxTime)){
//            Utility::Msg("区间重复");
//        }
//        $objFrontToSeaTimeInfo->strDValue = "{$strMinTime},{$strMaxTime}";
//        $objFrontToSeaTimeInfo->iUpdateUid = $this->getUserId();
//        $objFrontToSeaTimeInfo->strUpdateTime = Utility::Now();
//        if(empty ($iDid)){
//            $objFrontToSeaTimeInfo->iSId = $objFrontToSeaTimeInfo->iDId;
//            $objFrontToSeaTimeInfo->iAgentId = $this->getAgentId();
//            $objFrontToSeaTimeInfo->iCreateUid = $this->getUserId();
//            $objFrontToSeaTimeInfo->strCreateTime = Utility::Now();
//            $iRtn = $objDataConfigBLL->insert($objFrontToSeaTimeInfo);
//        }else{
//            $iRtn = $objDataConfigBLL->updateByID($objFrontToSeaTimeInfo);
//        }
//        if($iRtn!==false){
//            Utility::Msg("设置成功",true);
//        }else{
//            Utility::Msg("设置失败");
//        }
    }
    
    public function DelToSeaTimeFront(){
        if(!$this->HaveRight("FrontCommonSet", RightValue::v4)){
            Utility::Msg("对不起，您没有权限");
        }
        $iDid = Utility::GetFormInt("frontid", $_GET);
        if(empty ($iDid)){
            Utility::Msg("该时间段为后台设置，不允许删除");
        }
        $objDataConfigBLL = new DataConfigBLL();
        $iRtn = $objDataConfigBLL->deleteByID($iDid, $this->getUserId());
        if($iRtn !== false){
            Utility::Msg("删除成功".true);
        }else{
            Utility::Msg("删除失败");
        }
    }
    
    /**
     * 判断数值是否在区间之内
     * @param type $iValue
     * @param type $strScope
     * @return type 
     */
    private function IsInTheScope($iValue,$strScope){
        $arrScope = explode(',', $strScope);
        return ($arrScope[0] <= $iValue) && ($iValue <= $arrScope[1]);
    }
    
    /**
     * 判断时候区间重合，min和max都小于某一项的最小值，若i>0，则还要判断都大于前一项的最大值
     * @param type $ScopeList
     * @param type $strMinValue
     * @param type $strMaxValue
     * @return boolean 
     */
    private function VaildScope($ScopeList,$strMinValue,$strMaxValue){
       $bFalg = false;
       $iCount = 1;
       $strBeforeKey = '';
       $iMaxCount = count($ScopeList);
       foreach($ScopeList as $key=>$item) {
            $arrTemp[$key] = explode(' - ', $ScopeList[$key]);
            if (($iCount == 1 && $strMinValue <= $arrTemp[$key][0] && $strMaxValue <= $arrTemp[$key][0])
              ||($iCount == $iMaxCount && $strMinValue >= $arrTemp[$key][1] && $strMaxValue >= $arrTemp[$key][1])
              ||(1 < $iCount && $iCount < $iMaxCount &&$arrTemp[$strBeforeKey][1] <= $strMinValue && $strMinValue <= $arrTemp[$key][0] && $arrTemp[$strBeforeKey][1] <= $strMaxValue && $strMaxValue <= $arrTemp[$key][0])) {
                $bFalg = true;
                break;
            }
            $iCount++;
            $strBeforeKey = $key;
        }
        return $bFalg;
    }
    
    /**
     * 判断是否在区间类表之内
     * @param type $arrBackTimeList
     * @param type $strMinValue
     * @param type $strMaxValue 
     */
    private function VaildInBackScope($arrBackTimeList,$strMinValue,$strMaxValue){
        $bFalg = false;
        for($i=0;$i<count($arrBackTimeList);$i++){
            $arrTemp = explode(' - ', $arrBackTimeList[$i]);
            if($arrTemp[0] <= $strMinValue && $strMaxValue <= $arrTemp[1]){
                $bFalg = true;
                break;
            }
        }
        return $bFalg;
    }
    
} 