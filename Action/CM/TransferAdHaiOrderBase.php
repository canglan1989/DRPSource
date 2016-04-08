<?php

/*
 * 网盟订单转移操作库
 */
require_once __DIR__ . '/../Common/Utility.php';
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../WebService/Adhai_Service.php';
require_once __DIR__.'/../../Class/BLL/OrderBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentSourceBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentPactBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductBLL.php';
require_once __DIR__.'/../../Class/BLL/ProductTypeBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailActBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderRechargeBLL.php';
require_once __DIR__.'/../../Class/BLL/AccountGroupUserBLL.php';
require_once __DIR__.'/../../Class/BLL/OrderMoveLogBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerExBLL.php';
require_once __DIR__.'/../../Class/BLL/UserBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerAgentBLL.php';
require_once __DIR__.'/../../Class/BLL/AgContactBLL.php';
require_once __DIR__.'/../../Class/BLL/CustomerMoveBLL.php';

class TransferAdHaiOrder extends ActionBase {
    private $iOrderID = 0;
    private $iCustomerId = 0;
    private $objOrderInfo = null;
    private $objOldOrderInfo = null;
    private $objToAgentInfo = null;
    private $objFromAgentInfo = null;
    private $iToAgentID = 0;
    private $iFromAgentID = 0;
    private $dTransMoney = 0;
    private $dFromAgent_preDepositsMoney = 0;//原终端预存金额
    private $dFromAgent_saleRewardMoney = 0;//原终端返点金额
    private $dToAgent_PreDepositsChargeMoney = 0;//新代理商预存款金额
    private $dToAgent_SaleChargeMoney = 0;//新代理商返点金额
    private $arrayDetailChargeMoney = array();
    private $iAgentPactID = 0;//合同ID
    private $iAgentPactNo = '';//合同号
    private $iActType = 0;//操作类型 0订单转移 1客户转移
    
    public function goTransferOrder(){
        $this->InitOrder(Utility::GetFormInt("orderid", $_GET), Utility::GetFormInt("to_agent_id", $_POST), Utility::GetFormInt("from_agent_id", $_POST));        
        $this->ValidOldAgentAccount();//验证原代理商终端账户余额（终端-》代理商）        
        $this->ValidNewAgentAccount();  //验证新代理商账户余额（代理商-》终端）        
        $this->ValidAgentPact();//验证是否存在此签约合同        
        $this->ValidOrderExit();//验证网盟订单与增值订单(网盟订单必然存在，一则正常多则冻结)  
        $this->doTransferOrder();//订单转移        
        $this->addOrderMoveLog();//增加订单转移记录           
        $this->doTransferCustomer();    //转移客户
        $this->addCustomerMoveLog();//添加客户转移记录
        Utility::Msg("网盟订单转移成功",true);
    }
    
    public function goTransfetCustomer(){
        $this->InitCustomer(Utility::GetFormInt("customer_ids", $_POST), Utility::GetFormInt("to_anget_id", $_POST), Utility::GetFormInt("from_agent_id", $_GET));     
        
        $this->ValidOrderExit();//验证网盟订单与增值订单(网盟订单必然存在，一则正常多则冻结) 
       
        $this->doTransferCustomer();    //转移客户
         
        $this->addCustomerMoveLog();//添加客户转移记录
        Utility::Msg("客户转移成功",true,  $this->getActionUrl("CM", "CMInfo", "showBackInfoList"));
    }
    
    private function InitOrder($iOrderID,$iToAgentID,$iFromAgent){
        $this->iActType = 1;
        $objOrderBLL = new OrderBLL();
        $this->objOldOrderInfo = $objOrderBLL->getModelByID($iOrderID);
        if(!$this->objOldOrderInfo){
            Utility::Msg("获取原代理商信息失败");
        }
        $this->iOrderID = $iOrderID;
        $this->iCustomerId = $this->objOldOrderInfo->iCustomerId;
        $objAgentSourceBLL = new AgentSourceBLL();
        $this->objToAgentInfo = $objAgentSourceBLL->getModelByID($iToAgentID);
        if(!$this->objToAgentInfo){
            Utility::Msg("获取新代理商信息失败");
        }
        $this->iToAgentID = $iToAgentID;
        $this->objFromAgentInfo = $objAgentSourceBLL->getModelByID($iFromAgent);
        if(!$this->objFromAgentInfo){
            Utility::Msg("获取原代理商数据失败");
        }
        $this->iFromAgentID = $iFromAgent;
        
    }
    
    private function InitCustomer($iCustomerId,$iToAgentID,$iFromAgent){
        $objCustomerAgentBLL = new CustomerAgentBLL();
        $objCustomerInfo = $objCustomerAgentBLL->select("agent_id", "customer_id={$iCustomerId}");
        $this->iActType = 2;
        if(empty ($iCustomerId))
            Utility::Msg ("获取客户信息失败");
        $this->iCustomerId = $iCustomerId;
        $objAgentSourceBLL = new AgentSourceBLL();
        $this->objToAgentInfo = $objAgentSourceBLL->getModelByID($iToAgentID);
        if(!$this->objToAgentInfo)
            Utility::Msg ("获取新代理商信息失败");
        $this->iToAgentID = $iToAgentID;
//        if(empty ($iFromAgent))
//            Utility::Msg ("获取原代理商信息失败");
        
        $this->iFromAgentID = $objCustomerInfo[0]['agent_id'];
    }
    
    private function ValidOldAgentAccount(){
        $strAccountName = $this->objOldOrderInfo->strOwnerAccountName;
        $objAdhai_FinanceService = new Adhai_FinanceService();
        //查询广告主账户余额(adhai接口)
        $this->dTransMoney = $objAdhai_FinanceService->GetOwnerBalance($strAccountName);
        if(!is_numeric($this->dTransMoney))
            Utility::Msg ("账户{$strAccountName}金额不足以扣款");
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();
        $aUnitPreReMoneyRate = $objAgentAccountDetailBLL->GetUnitReturnPreReMoney($strAccountName,$this->dTransMoney,  $this->dFromAgent_preDepositsMoney,  $this->dFromAgent_saleRewardMoney);
        if(($this->dFromAgent_preDepositsMoney + $this->dFromAgent_saleRewardMoney)< $this->dTransMoney)
            Utility::Msg ("账户{$strAccountName}金额不足以扣款");
    }
    
    private function ValidNewAgentAccount(){
        
        $strFinanceNo = "10";
        $objAgentAccountBLL = new AgentAccountBLL();
        //返点可用余额
        $iSaleAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->iToAgentID,$strFinanceNo,AgentAccountTypes::UnitSaleReward);
        //预存款可用金额
        $iPreDepositsAccountMoney = $objAgentAccountBLL->GetAccountCanUseMoney($this->iToAgentID,$strFinanceNo,AgentAccountTypes::UnitPreDeposits);       
        
        if($iSaleAccountMoney + $iPreDepositsAccountMoney < $this->dTransMoney)
            Utility::Msg("新代理商预存款余额不足！"); 
           
        /*------------------------扣款比例----------s--------------*/
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL();        
        $this->arrayDetailChargeMoney = $objAgentAccountDetailBLL->GetUnitChargeMoney($this->iToAgentID,$strFinanceNo, $this->dTransMoney,  $this->dToAgent_PreDepositsChargeMoney,  $this->dToAgent_SaleChargeMoney);

        /*------------------------扣款比例----------e--------------*/     
        if(round($iPreDepositsAccountMoney,2) < round($this->dToAgent_PreDepositsChargeMoney,2))
            Utility::Msg("新代理商预存款余额不足，请及时打款！"); 
            
        if(round($iSaleAccountMoney,2) < round($this->dToAgent_SaleChargeMoney,2))
            Utility::Msg("新代理商返点余额不足！");   
    }
    
    private function ValidAgentPact(){
        $objAgentPactBLL = new AgentPactBLL();
        $arrayData = $objAgentPactBLL->GetAgentPact($this->iFromAgentID,  $this->objOldOrderInfo->iProductTypeId);
        if(!$arrayData){
            Utility::Msg("未找到与此产品的签约合同！");
        } 
        $this->iAgentPactID = $arrayData[0]["agent_pact_id"];
        $this->iAgentPactNo = $arrayData[0]["pact_number"]."".$arrayData[0]["pact_stage"];
    }
    
    private function ValidOrderExit(){//需要重写 网盟和增值都要验证，订单修改时需要验证除本身外还有没有其他订单，客户修改时要验证是否存在网盟订单
        $objCustomerBLL = new CustomerBLL();
        $strAdHai = '';
        $strValueIncrease = '';
        $arrData = $objCustomerBLL->getCustomerInfoByTransferValid($this->iCustomerId,  $this->iFromAgentID);//获取订单信息     
        if(!empty($arrData[1])){
            foreach($arrData[1] as $CustomerInfo){
                $strValueIncrease .= "<br />{$CustomerInfo['order_no']}({$CustomerInfo['product_name']})";
            }
        }
        if(!empty($arrData[0])){
            foreach($arrData[0] as $AdHaiOrderList){
                if($this->iActType == 1 && $AdHaiOrderList['order_id'] == $this->iOrderID){
                    continue;
                }
                $strAdHai .= "<br />{$AdHaiOrderList['order_no']}({$AdHaiOrderList['product_name']})";
            }
        }
        $msg = '';
        if(!empty ($strValueIncrease)){
            $msg.="存在增值订单：{$strValueIncrease}";
        }
        if(!empty ($strAdHai)){
            $msg.="存在其他网盟订单：{$strAdHai}";
        }
        if(!empty ($msg)){
            Utility::Msg($msg);
        }
    }
    
    private function doTransferOrder(){
        $objProductBLL = new ProductBLL();
        $objOrderBLL = new OrderBLL();
        $arrayProduct = $objProductBLL->select("product_no","product_id=".$this->objOldOrderInfo->iProductId);
        if(!$arrayProduct)
            Utility::Msg ("获取产品信息失败");
        
        $this->objOrderInfo = clone $this->objOldOrderInfo;
        $this->objOrderInfo->strOrderNo = $objOrderBLL->getNewNo(CustomerOrderTypes::newOrder,$arrayProduct[0]['product_no'],  $this->objToAgentInfo->strAgentNo);
        $this->objOrderInfo->iAgentId = $this->iToAgentID;
        $this->objOrderInfo->strAgentNo = $this->objToAgentInfo->strAgentNo;
        $this->objOrderInfo->strAgentName = $this->objToAgentInfo->strAgentName;
        $objUserBLL = new UserBLL();
        $this->objOrderInfo->iFinanceUid = $objUserBLL->GetAgentAdminUserID($this->iToAgentID);
        $this->objOrderInfo->strFinanceNo = "10";
        $iOrderRtn = $objOrderBLL->insert($this->objOrderInfo);
        if($iOrderRtn === false){
            Utility::Msg("生成新订单失败");
        }
        $this->objOrderInfo->iOrderId = $iOrderRtn;
        if($this->dTransMoney > 0){
            //扣款
            $this->doRefund();
            //充值 
            $this->doRecharge();
        }
        
        
        //修改原订单
        $this->objOldOrderInfo->strOrderEdate = Utility::Now();
        $iUpdateOldRtn = $objOrderBLL->updateByID($this->objOldOrderInfo);
        if ($iUpdateOldRtn === false) {
            Utility::Msg("修改原订单失败");
        }
    }
    
    private function doRefund(){
        $objAdhai_FinanceService = new Adhai_FinanceService();
        $objProductTypeBLL = new ProductTypeBLL();        
        $productTypeID = $objProductTypeBLL->GetUnitProductTypeID();       
        $strRemark = '网盟订单转移原订单扣款';
        $iCount = 0;
        $objAgentAccountBLL = new AgentAccountBLL();
        if($this->dFromAgent_preDepositsMoney > 0)
        {
            $objInMoneyAct = new InMoneyAct();
            $objInMoneyAct->Init($this->iFromAgentID,$this->objOldOrderInfo->strFinanceNo,$productTypeID,AgentAccountTypes::UnitPreDeposits,
                BillTypes::UnitBackMoney,Utility::Now(),  $this->dFromAgent_preDepositsMoney);
            $iCount += $objInMoneyAct->Insert($this->getUserId(),$strRemark); 
            $objAgentAccountBLL->UpdateOutMoney($this->iFromAgentID, AgentAccountTypes::UnitPreDeposits, $productTypeID);
        }
                
        if($this->dFromAgent_saleRewardMoney > 0)
        {
            $objRePreInMoneyAct = new InMoneyAct();
            $objRePreInMoneyAct->Init($this->iFromAgentID,$this->objOldOrderInfo->strFinanceNo,$productTypeID,AgentAccountTypes::UnitSaleReward,
                BillTypes::UnitBackMoney,Utility::Now(),  $this->dFromAgent_saleRewardMoney);
            $iCount += $objRePreInMoneyAct->Insert($this->getUserId(),$strRemark);
            $objAgentAccountBLL->UpdateOutMoney($this->iFromAgentID, AgentAccountTypes::UnitSaleReward, $productTypeID);
        }
        
        
        if(($this->dFromAgent_preDepositsMoney > 0 || $this->dFromAgent_saleRewardMoney >0) && empty($iCount)){
            Utility::Msg("退款出错，退款金额获取出错");
        }
        $objAdhai_FinanceService->Refund($this->objOldOrderInfo->strOwnerAccountName, $this->dTransMoney, $strRemark);
    }
    
    private function doRecharge(){
        /* ------------------------预存款账户金额----------e-------------- */
        $objOrderRechargeBLL = new OrderRechargeBLL();
        $objOrderRechargeInfo = new OrderRechargeInfo();
        $objOrderRechargeInfo->strRechargeNo = $objOrderRechargeBLL->GetNewNo();
        $objOrderRechargeInfo->iOrderId = $this->objOrderInfo->iOrderId;
        $objOrderRechargeInfo->strOrderNo = $this->objOrderInfo->strOrderNo;
        $objOrderRechargeInfo->iCustomerId = $this->iCustomerId;
        $objOrderRechargeInfo->strCustomerName = $this->objOrderInfo->strCustomerName;
        $objOrderRechargeInfo->strCustomerAccount = $this->objOrderInfo->strOwnerAccountName;
        $objOrderRechargeInfo->iAgentId = $this->iToAgentID;
        $objOrderRechargeInfo->strAgentNo = $this->objToAgentInfo->strAgentNo;
        $objOrderRechargeInfo->strAgentName = $this->objToAgentInfo->strAgentName;
        $objUserBLL = new UserBLL();
        $objOrderRechargeInfo->iFinanceUid = $objUserBLL->GetAgentAdminUserID($this->iToAgentID);
        $objOrderRechargeInfo->strFinanceNo = "10";
        $objOrderRechargeInfo->iAgentPactId = $this->iAgentPactID;
        $objOrderRechargeInfo->strAgentPactNo = $this->iAgentPactNo;
        $objOrderRechargeInfo->iPreMoney = $this->dToAgent_PreDepositsChargeMoney;
        $objOrderRechargeInfo->iRebateMoney = $this->dToAgent_SaleChargeMoney;
        $objOrderRechargeInfo->iRechargeMoney = $this->dTransMoney;
        $objOrderRechargeInfo->iCreateUid = $this->getUserId();
        $objOrderRechargeInfo->strCreateUserName = $this->getUserName() . " " . $this->getUserCNName();
        $objOrderRechargeInfo->strCreateTime = Utility::Now();
        $objOrderRechargeInfo->iUpdateUid = 0;
        $objOrderRechargeInfo->strUpdateUserName = '';
        $objOrderRechargeInfo->strUpdateTime = $objOrderRechargeInfo->strCreateTime;
        $objOrderRechargeInfo->strRemark = '网盟订单转移转款';
        $objOrderRechargeInfo->iIsDel = 0;
        $objOrderRechargeInfo->iIsCharge = 1;
        $objOrderRechargeInfo->strChargeDate = $objOrderRechargeInfo->strCreateTime;
        $objOrderRechargeInfo->iRechargeStatus = 1;
        $objOrderRechargeInfo->strRechargeStatusText = "已转款";
        $objAccountGroupUserBLL = new AccountGroupUserBLL();
        $objOrderRechargeInfo->iAccountGroupId = $objAccountGroupUserBLL->getGroupIdByAgentId($this->iFromAgentID);
        $iRechargeRtn = $objOrderRechargeBLL->insert($objOrderRechargeInfo);
        if ($iRechargeRtn === false) {
            Utility::Msg("生成充值记录失败");
        }
        $objAgentAccountDetailBLL = new AgentAccountDetailBLL(); 
        $objAgentAccountDetailBLL->InsertChargeMoneyDetail($this->arrayDetailChargeMoney);
    }
    
    private function addOrderMoveLog(){
        $objOrderMoveLogBLL = new OrderMoveLogBLL();
        $objOrderMoveInfo = new OrderMoveLogInfo();
        $objOrderMoveInfo->iOrderId = $this->iOrderID;
        $objOrderMoveInfo->iNewOrderId = $this->objOrderInfo->iOrderId;
        $objOrderMoveInfo->iToAgentId = $this->iToAgentID;
        $objOrderMoveInfo->iFromAgentId = $this->iFromAgentID;
        $objOrderMoveInfo->iCreateUid = $this->getUserId();
        $objOrderMoveInfo->strCreateTime = Utility::Now();
        $objOrderMoveInfo->strCreateUserName = "{$this->getUserName()} {$this->getUserCNName()}";
        $objOrderMoveInfo->strOrderNo = $this->objOldOrderInfo->strOrderNo;
        $objOrderMoveInfo->strNewOrderNo = $this->objOrderInfo->strOrderNo;
        $objOrderMoveInfo->strFromAgentName = $this->objFromAgentInfo->strAgentName;
        $objOrderMoveInfo->strToAgentName = $this->objToAgentInfo->strAgentName;
        $objOrderMoveInfo->strRemark =urldecode(Utility::GetForm("tbxRemark", $_POST));
        $iMoveRtn = $objOrderMoveLogBLL->insert($objOrderMoveInfo);
        if ($iMoveRtn === false) {
            Utility::Msg("生成订单转移记录失败");
        }
    }
    
    private function doTransferCustomer(){
        $objCustomerExBLL = new CustomerExBLL();
        $objCustomerExInfo = $objCustomerExBLL->getModelByID($this->iCustomerId, $this->iToAgentID);
        if (!$objCustomerExInfo) {
            $objCustomerExInfo = new CustomerExInfo();
            $objCustomerExInfo->iAgentId = $this->iToAgentID;
            $objCustomerExInfo->iCustomerId = $this->iCustomerId;
            $objCustomerExInfo->iDefendState = $this->iActType == 1?CustomerDefendState::HasOrderCustomer : CustomerDefendState::DefendCustomer;
            $objDataConfigBLL = new DataConfigBLL();
            if($objCustomerExInfo->iDefendState == CustomerDefendState::HasOrderCustomer){
                $iDefendTime = $objDataConfigBLL->GetProtectTime_Formal($this->iToAgentID);
            }else{
                $iDefendTime = $objDataConfigBLL->GetProtectTime_Protect_No_Record($this->iToAgentID);
            }
            $objCustomerExInfo->strToSeaTime = Utility::addDay(Utility::Now(), $iDefendTime,false);
            $iExRtn = $objCustomerExBLL->insert($objCustomerExInfo);
            if ($iExRtn === false) {
                Utility::Msg("修改客户资料失败");
            }
        }

        $objUserBLL = new UserBLL();
        $arrUserInfo = $objUserBLL->select("user_id,e_name,user_name", "agent_id={$this->iToAgentID} and user_no = '10' and is_del = 0");
        $objCustomerAgentBLL = new CustomerAgentBLL();
        $iCustoemrAgentRtn = $objCustomerAgentBLL->UpdateData(array(
            'agent_id' => $this->iToAgentID,
            'user_id'=>$arrUserInfo?$arrUserInfo[0]['user_id']:0,
            'service_user_no'=>'10',
            'service_user_name'=>$arrUserInfo ? "{$arrUserInfo[0]['user_name']} {$arrUserInfo[0]['e_name']}":'',
            'customer_resource_person'=>  CustomerResourcePerson::SupperAssign,
            'customer_resource'=>  CustomerResource::PSOpr
                ), "customer_id={$this->iCustomerId} and agent_id={$this->iFromAgentID}");
        if ($iCustoemrAgentRtn === false) {
            Utility::Msg("修改客户关系失败");
        }
        
        $objCustoemrBLL = new CustomerBLL();
        $iCustoemrRtn = $objCustoemrBLL->UpdateData(array(
            'customer_resource'=>  CustomerResource::PSOpr
        ), "customer_id = {$this->iCustomerId}");
        if($iCustoemrRtn === false){
            Utility::Msg("修改客户资料失败");
        }
        
        $objAgContactBLL = new AgContactBLL();
        $iContactRtn = $objAgContactBLL->UpdateData(array(
            'agent_id' => $this->iToAgentID
                ), "customer_id={$this->iCustomerId}");
        if ($iContactRtn === false) {
            Utility::Msg("修改联系人归属失败");
        }
    }
    
    private function addCustomerMoveLog(){
        $objCustomerMoveBLL = new CustomerMoveBLL();
        $objCustomerMoveInfo = new CustomerMoveInfo();
        $objCustomerMoveInfo->iCustomerId = $this->iCustomerId;
        $objCustomerMoveInfo->iFromAngetId = $this->iFromAgentID;
        $objCustomerMoveInfo->iToAngetId = $this->iToAgentID;
        $objCustomerMoveInfo->iCreateTime = Utility::Now();
        $objCustomerMoveInfo->iCreateUid = $this->getUserId();
        $objCustomerMoveInfo->strProductName = $objCustomerMoveBLL->getIntention($objCustomerMoveInfo->iCustomerId);
        $iLogRtn = $objCustomerMoveBLL->insert($objCustomerMoveInfo);
        if($iLogRtn === false){
            Utility::Msg("添加客户转移资料失败");
        }
    }
    
}

?>
