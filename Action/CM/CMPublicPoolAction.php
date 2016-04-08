<?php

/**
 * 公海客户
 *
 * @author XXF
 */

require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerAgentBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerExBLL.php';
require_once __DIR__.'/../../Class/BLL/DataConfigBLL.php';


class CMPublicPoolAction extends ActionBase {
    //put your code here
    public function index(){
        $this->showPublicPoolList();
    }


    public function showPublicPoolList(){
        $this->PageRightValidate("PublicPoolManager", RightValue::view);
        $objProductTypeBLL = new ProductTypeBLL();
        $strProductTypeJson = $objProductTypeBLL->GetSignedProductTypeJson($this->getAgentId(),true);
        $this->smarty->assign('strProductTypeJson',$strProductTypeJson);
        
        $qProductTypeIDs = "";
        $qProductTypeNames = "";
        $productTypeID = Utility::GetFormInt("productTypeID",$_GET);
        if($productTypeID > 0)
        {
            $qProductTypeIDs = $productTypeID;
            $arrayProductType = $objProductTypeBLL->select("product_type_name","aid=".$productTypeID);
            if(isset($arrayProductType) && count($arrayProductType))
                $qProductTypeNames = $arrayProductType[0]["product_type_name"];
        }
        
        $this->smarty->assign('qProductTypeIDs',$qProductTypeIDs);
        $this->smarty->assign('qProductTypeNames',$qProductTypeNames);
        
        $this->smarty->assign("BodyUrl",  $this->getActionUrl("CM", "CMPublicPool", "showPublicPoolBody"));
        $this->displayPage('CM/PublicPool/showPublicPoolList.tpl');
    }
    
    public function showPublicPoolBody(){
        $this->ExitWhenNoRight("PublicPoolManager", RightValue::view);
        $strWhere = $this->showPublicPool_Where();
        $strOrder = Utility::GetForm("sortField", $_GET);
        $objCustomerBLL = new CustomerBLL();
        $arrCustomerList  = $objCustomerBLL->getPublicPoolList($strWhere, $strOrder, Utility::Now(),  $this->getUserId());
        $this->showPageSmarty($arrCustomerList, 'CM/PublicPool/showPublicPoolBody.tpl');
    }
    
    private function showPublicPool_Where(){
        $strWhere = " and cm_customer_ex.agent_id = '{$this->getAgentId()}' and cm_customer_agent.finance_uid=".$this->getFinanceUid();
        $strCustomerName = Utility::GetForm("customerName", $_GET);
        if(empty ($strCustomerName)){
            $strWhere .= " and cm_customer_ex.to_sea_time <= '".Utility::Now()."' and (cm_customer_ex.shield_time < '".Utility::Now()."' or cm_customer_ex.shield_uid = {$this->getUserId()})  ";
        }else{
            $strWhere .= " and cm_customer.customer_name like '%{$strCustomerName}%' ";
        }
        
        $iCustomerResource = Utility::GetFormInt("source", $_GET);
        if($iCustomerResource >= 0){
            if($iCustomerResource == 4){
                $strWhere .= " and cm_customer.customer_resource in (".CustomerResource::BackAdd.",".CustomerResource::FromSea.",".CustomerResource::Other.",".CustomerResource::AutoRegister.",".CustomerResource::PSOpr.")";
            }else{
                $strWhere .= " and cm_customer.customer_resource = {$iCustomerResource} ";
            }
        }
        
        $strProduceTypeIDs = Utility::GetForm("productTypeIDs", $_GET);
        if (!empty($strProduceTypeIDs)) {
            $arrProductTypeIDs = explode(',', $strProduceTypeIDs);
            foreach ($arrProductTypeIDs as $strProductTypeID) {
                $arrProductType[] = " CONCAT(',',cm_customer_ex.buy_product_ids,',') like '%,{$strProductTypeID},%' ";
            }
            $strWhere .= " and (" . implode('or', $arrProductType) . ")";
        }
        
        $iIsBuy = Utility::GetFormInt("is_buy", $_GET);
        if($iIsBuy == 1){
            $strWhere .= " and cm_customer_ex.buy_product_ids > '' ";
        }else if ($iIsBuy == 2){
            $strWhere .= " and cm_customer_ex.buy_product_ids = '' ";
        }
        
        $iPri = Utility::GetFormInt("pri", $_GET);
        if($iPri>0){
            $strWhere .= " and cm_customer.province_id = {$iPri} ";
            $iCity = Utility::GetFormInt("city", $_GET);
            if($iCity>0){
                $strWhere .= " and cm_customer.city_id = {$iCity} ";
                $iArea = Utility::GetFormInt("area", $_GET);
                if($iArea>0){
                    $strWhere .= " and cm_customer.area_id = {$iArea} ";
                }
            }
        }
        
        
        $iIndustryPid = Utility::GetFormInt("industry_pid", $_GET);
        if($iIndustryPid>0){
            $strWhere .= " and cm_customer.industry_pid = {$iIndustryPid} ";
            $iIndustryId = Utility::GetFormInt("industry_id", $_GET);
            if($iIndustryId>0){
                $strWhere .= " and cm_customer.industry_id = {$iIndustryId} ";
            }
        }
        return $strWhere;
    }
    
    public function showExcelAdd(){
        $this->PageRightValidate("PublicPoolManager", RightValue::v4);
        $this->displayPage('CM/PublicPool/showExcelAdd.tpl');
    }
    
    /**
     * 公海客户拉取
     */
    public function DefendCustomer(){
        if(!$this->HaveRight("PublicPoolManager", RightValue::v8)){
            Utility::Msg("对不起，您没有权限");
        }
        //判断是否在拉取时间段内
        $objDatConfigBLL = new DataConfigBLL();
        $arrTimeList = $objDatConfigBLL->GetPullCustomerTime($this->getAgentId());
        if($arrTimeList){
            $bFalg = false;
            foreach ($arrTimeList as $item) {
                $item = explode('|', $item['d_value']);
                foreach ($item as $data) {
                    $arrTemp = explode(',', $data);
                    if ($arrTemp[0] <= date('H:i:s',time()) && date('H:i:s',time()) <= $arrTemp[1]) {
                        $bFalg = true;
                        break;
                    }
                }
            }
            if(!$bFalg){
                Utility::Msg("不在允许拉取时间段内，不允许拉取");
            }
        }
        $strCustomerID = Utility::GetForm("customerid", $_POST);
        if(empty ($strCustomerID)){
            Utility::Msg("请选择需要拉取的客户");
        }
        
        //判断时候达到最大容量
        $objCustomerExBLL = new CustomerExBLL();
        $iCustomerCount = $objCustomerExBLL->getCustomerCountByID($this->getUserId(), $this->getAgentId(), CustomerDefendState::TelCustomer);
        $iCustomerCount = $iCustomerCount[0]['num'];
        $arrCustomerID = explode(",", $strCustomerID);
        $iMaxCount = $objDatConfigBLL->GetAllow_Count_Tel($this->getAgentId());
        if(count($arrCustomerID) + $iCustomerCount > $iMaxCount){
            Utility::Msg("超出电话客户最大容量");
        }
        
        //拉取客户
        $objCustomerAgentBLL = NEW CustomerAgentBLL();
        $iAgentRtn = $objCustomerAgentBLL->updateCustomerAgentWithUserID($this->getAgentId(),$this->getUserId(), $strCustomerID);
        if($iAgentRtn === false){
            Utility::Msg("拉取客户出错");
        }
        $iDefendTime = $objDatConfigBLL->GetProtectTime_Tel($this->getAgentId());
        $iExtRtn = $objCustomerExBLL->UpdateToSeaTime($this->getAgentId(),Utility::addDay(Utility::Now(), $iDefendTime, false), $strCustomerID,  CustomerDefendState::TelCustomer);
        if($iExtRtn === false){
            Utility::Msg("设置保护时间失败");
        }
        Utility::Msg("客户拉取成功",true);
//        //将customerid按设置种类分成6部分
//        $arrCustomerEx = $objCustomerExBLL->getCustomerExListByCustomerID($strCustomerID, $this->getAgentId());
//        $arrCustomerID = array(
//            'Tel'=>array(),
//            'Self'=>array(),
//            'SelfNo'=>array(),
//            'Protect'=>array(),
//            'ProtectNo'=>array(),
//            'Format'=>array(),
//        );//标记保护类型是否全部异常
//        $arrMsg = array();
//        foreach ($arrCustomerEx as $arrCustomerExItem) {
//            switch ($arrCustomerExItem['defend_state']) {
//                case CustomerDefendState::TelCustomer: {
//                        $arrCustomerID['Tel'][] = $arrCustomerExItem['customer_id'];
//                    }break;
//                case CustomerDefendState::AddMyselfCustomer: {
//                        if ($arrCustomerExItem['record_count'] > 0) {
//                            $arrCustomerID['Self'][] = $arrCustomerExItem['customer_id'];
//                        } else {
//                            $arrCustomerID['SelfNo'][] = $arrCustomerExItem['customer_id'];
//                        }
//                    }break;
//                case CustomerDefendState::DefendCustomer: {
//                        if ($arrCustomerExItem['record_count'] > 0) {
//                            $arrCustomerID['Protect'][] = $arrCustomerExItem['customer_id'];
//                        } else {
//                            $arrCustomerID['ProtectNo'][] = $arrCustomerExItem['customer_id'];
//                        }
//                    }break;
//                case CustomerDefendState::HasOrderCustomer: {
//                        $arrCustomerID['Format'][] = $arrCustomerExItem['customer_id'];
//                    }break;
//                default :$arrMsg[] = "{$arrCustomerExItem['customer_id']}";break;
//            }
//        }
//        if(count($arrMsg)> 0){
//            Utility::Msg("客户".  implode(',', $arrMsg)."的保护类型异常");
//        }
//        //设置到公海时间
//        $bFlag = true;//标记设置保护时间操作是否全部成功
//        foreach ($arrCustomerID as $strDefendState => $iCustomerID) {
//            if (count($iCustomerID) > 0) {
//                switch ($strDefendState) {
//                    case 'Tel': {
//                            $iDefendTime = $objDatConfigBLL->GetProtectTime_Tel($this->getAgentId());
//                        }break;
//                    case 'Self': {
//                            $iDefendTime = $objDatConfigBLL->GetProtectTime_Self_Record($this->getAgentId());
//                        }break;
//                    case 'SelfNo': {
//                            $iDefendTime = $objDatConfigBLL->GetProtectTime_Self_No_Record($this->getAgentId());
//                        }break;
//                    case 'Protect': {
//                            $iDefendTime = $objDatConfigBLL->GetProtectTime_Protect_Record($this->getAgentId());
//                        }break;
//                    case 'ProtectNo': {
//                            $iDefendTime = $objDatConfigBLL->GetProtectTime_Protect_No_Record($this->getAgentId());
//                        }break;
//                    case 'Format': {
//                            $iDefendTime = $objDatConfigBLL->GetProtectTime_Formal($this->getAgentId());
//                        }break;
//                    default :$iDefendTime = 0;
//                        break;
//                }
//                $iExtRtn = $objCustomerExBLL->UpdateToSeaTime($this->getAgentId(),Utility::addDay(Utility::Now(), $iDefendTime, false), implode(',', $iCustomerID),  CustomerDefendState::TelCustomer);
//                if($iExtRtn === false){
//                    $bFlag = false;
//                }
//            }
//        }
    }
    
    public function showToSeaPage(){
        $this->ExitWhenNoRight("showFrontInfoList", RightValue::v16);
        $objDataConfigBLL = new DataConfigBLL();
        $arrToSeaDate = $objDataConfigBLL->GetToSeaProtectDate($this->getAgentId());
        $this->smarty->assign("ToSeaList",$arrToSeaDate);
        echo $this->smarty->fetch('CM/PublicPool/ToSeaPage.tpl');
    }
    
    public function ToSeaPage(){
        if(!$this->HaveRight("showFrontInfoList", RightValue::v16)){
            Utility::Msg("对不起，您没有权限",true);
        }
        $strCustomerIDs = Utility::GetForm("customerlist", $_GET);
        $iShieldTime = Utility::GetFormInt("sheldtime", $_POST);
        
        if(empty ($strCustomerIDs)){ 
            Utility::Msg ("请选择踢入公海的客户");
        }
        if(empty ($iShieldTime)){
            Utility::Msg ("请选择屏蔽的天数");
        }
        
        $strNewShieldDate = Utility::addDay(Utility::Now(), $iShieldTime, FALSE);
        $objCustomerExBLL = new CustomerExBLL();
        $iRtn = $objCustomerExBLL->setToSeaOpr(Utility::Now(), $strNewShieldDate, $strCustomerIDs,  $this->getUserId());
        if($iRtn!==false){
            Utility::Msg("踢入公海成功",true);
        }else{
            Utility::Msg("踢入公海失败");
        }
    }
    
    /**
     * 屏蔽客户
     */
    public function ShieldCustomer(){
        if(!$this->HaveRight("CustomerInfo", RightValue::v32)){
            Utility::Msg("对不起，您没有权限",true);
        }
        $strCustomerIDs = Utility::GetForm("customerlist", $_GET);
        $iShieldTime = Utility::GetFormInt("sheldtime", $_POST);
        
        if(empty ($strCustomerIDs)){ 
            Utility::Msg ("请选择需要屏蔽的客户");
        }
        if(empty ($iShieldTime)){
            Utility::Msg ("请选择屏蔽的天数");
        }
        
        //将选中客户分类，客户若在个人库中，则执行踢入公海操作，否则单纯执行屏蔽操作
        $strPublicCustomerList = "";
        $strPrivateCustomerList = "";
        $objCustomerExBLL = new CustomerExBLL();
        $arrCustomerList = $objCustomerExBLL->getCustomerExListByCustomerID($strCustomerIDs, $this->getAgentId());
        if ($arrCustomerList) {
            $arrPublicCustomerList = array();
            $arrPrivateCustomerList = array();
            foreach ($arrCustomerList as $arrCustomerInfo) {
                if ($arrCustomerInfo['to_sea_time'] < Utility::Now()) {//在公海
                    $arrPublicCustomerList[] = $arrCustomerInfo['customer_id'];
                } else {
                    $arrPrivateCustomerList[] = $arrCustomerInfo['customer_id'];
                }
            }
            $strPublicCustomerList = implode(',', $arrPublicCustomerList);
            $strPrivateCustomerList = implode(',', $arrPrivateCustomerList);
        }
        
        $strShieldTime = Utility::addDay(Utility::Now(), $iShieldTime);
        $iPublicRtn = $objCustomerExBLL->setShieldTime($strPublicCustomerList, $strShieldTime, $this->getUserId());
        $iPrivateRtn = $objCustomerExBLL->setToSeaOpr(Utility::Now(), $strShieldTime, $strPrivateCustomerList, $this->getUserId());
        if($iPublicRtn !== false && $iPrivateRtn !== false){
            Utility::Msg("屏蔽成功",true);
        }else{
            Utility::Msg("屏蔽失败");
        }
    }
    
    /**
     * 取消屏蔽客户
     */
    public function UnShield(){
        if(!$this->HaveRight("CustomerInfo", RightValue::v32)){
            Utility::Msg("对不起，您没有权限",true);
        }
        $strCustomerIDs = Utility::GetForm("customerlist", $_POST);
        if(empty ($strCustomerIDs)){
            Utility::Msg("请选择需要取消屏蔽的客户");
        }
        
        $objCustomerExBLL = new CustomerExBLL();
        $iRtn = $objCustomerExBLL->setShieldTime($strCustomerIDs, Utility::Now(), $this->getUserId());
        if($iRtn!==false){
            Utility::Msg("取消屏蔽成功",true);
        }else{
            Utility::Msg("取消屏蔽失败");
        }
    }
    
    /**
     * 资料库列表
     */
    public function showCustomerInfoList(){
        $this->PageRightValidate("CustomerInfo", RightValue::view);
        $this->smarty->assign('BodyUrl',  $this->getActionUrl("CM", "CMPublicPool", "showCustomerInfoBody"));
        $this->displayPage('CM/PublicPool/showCustomerInfoList.tpl');
    }
    
    /**
     * 资料库列表Body
     */
    public function showCustomerInfoBody(){
        $this->ExitWhenNoRight("CustomerInfo", RightValue::view);
        $strWhere = $this->showCustomerInfoWhere();
        $strOrder = Utility::GetForm("sortField", $_GET);
        
        $this->smarty->assign("AgentID",  $this->getAgentId());
        $objCustomerBLL = new CustomerBLL();
        $arrCustomerList = $objCustomerBLL->getCustomerInfoList($strWhere, $strOrder,  $this->getAgentId());
        $this->showPageSmarty($arrCustomerList, 'CM/PublicPool/showCustomerInfoBody.tpl');
    }
    
    /**
     * 资料库列表where信息收集
     * @return type 
     */
    public function showCustomerInfoWhere(){
        $strWhere = " and cm_customer_agent.finance_uid=".$this->getFinanceUid();
        $iAreaID = Utility::GetFormInt("area", $_GET);
        if($iAreaID > 0){
            $strWhere .= " and cm_customer.area_id = {$iAreaID} ";
        }
        else
        {
            $iCityID = Utility::GetFormInt("city", $_GET);
            if($iCityID > 0){
                $strWhere .= " and cm_customer.city_id = {$iCityID} ";                
            }
            else
            {
                $iProvinceID = Utility::GetFormInt("pri", $_GET);
                if($iProvinceID > 0){
                    $strWhere .= " and cm_customer.province_id = {$iProvinceID} ";                    
                }
            }
        }
                
        $iCustomerResource = Utility::GetFormInt("resource", $_GET);
        if($iCustomerResource >= 0){
            if($iCustomerResource == 4){
                $strWhere .= " and cm_customer.customer_resource in (".CustomerResource::BackAdd.",".CustomerResource::FromSea.",".CustomerResource::Other.",".CustomerResource::AutoRegister.",".CustomerResource::PSOpr.")";
            }else{
                $strWhere .= " and cm_customer.customer_resource = {$iCustomerResource} ";
            }
        }
        
        $iIndustryID = Utility::GetFormInt("industry_id", $_GET);
        if($iIndustryID > 0){
            $strWhere .= " and cm_customer.industry_id = {$iIndustryID} ";
        }
        else
        {
            $iIndustryPID = Utility::GetFormInt("industry_pid", $_GET);
            if($iIndustryPID > 0){
                $strWhere .= " and cm_customer.industry_pid = {$iIndustryPID} ";                
            }
        }        
        $strCustomerName = trim(Utility::GetForm("customer_name", $_GET));
        if(!empty ($strCustomerName)){
            $strWhere .= " and (cm_customer.customer_name like '%{$strCustomerName}%' or cm_customer.customer_no like '%{$strCustomerName}%') ";
        }
        
        $strUserAccount =trim(Utility::GetForm("belong_user", $_GET));
        if(!empty ($strUserAccount)){
            $strWhere .= "and (sys_user.user_name like '%{$strUserAccount}%' or sys_user.e_name like '%{$strUserAccount}%' )";
        }
        
        $iIsShield = Utility::GetFormInt("is_shield", $_GET);
        if($iIsShield == 1){
            $strWhere .= " and cm_customer_ex.shield_time < '".Utility::Now()."' ";
        }elseif ($iIsShield == 2){
            $strWhere .= " and cm_customer_ex.shield_time >= '".Utility::Now()."'";
        }
        
        return $strWhere;
    }
    
    
}

?>