<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 om_order_recharge 的类业务逻辑层
 * 表描述：
 * 创建人：温智星
 * 添加时间：2012-02-20 16:59:22
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/OrderRechargeInfo.php';
require_once __DIR__.'/OrderBLL.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailActBLL.php';
require_once __DIR__.'/../../WebService/Adhai_Service.php';
require_once "AgentIntentionRatingBLL.php";
require_once "CustomerAgentBLL.php";

class OrderRechargeBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objOrderRechargeInfo  OrderRechargeInfo 实例
     * @return 
     */
	public function insert(OrderRechargeInfo $objOrderRechargeInfo)
	{
        $owner_account_name = "";
        $product_type_id = 0 ;
        
        $objOrderBLL = new OrderBLL();            
        $arrayData = $objOrderBLL->select("product_type_id,owner_account_name","order_id=".$objOrderRechargeInfo->iOrderId);
        if(isset($arrayData) && count($arrayData))
        {
            $owner_account_name = $arrayData[0]["owner_account_name"];
            $product_type_id = $arrayData[0]["product_type_id"];
        }
        else
        {
            return 0;
        }
        
        $arrData = $this->getRechargeInfoByCustomerAccount($objOrderRechargeInfo->strCustomerAccount);
        if($arrData){
            $iIsNew = 2;
        }else{
            $iIsNew = 1;
        }
        
        //调用Adhai转款接口
        $objAdhai_FinanceService = new Adhai_FinanceService();//先在这里New一下，免得数据插入后 连不上啊，出错啊种种
        
		$sql = "INSERT INTO `om_order_recharge`(`recharge_no`,`order_id`,`order_no`,`agent_id`,`agent_no`,`agent_name`,`customer_id`,`customer_name`,`agent_pact_id`,`agent_pact_no`,`pre_money`,`rebate_money`,`recharge_money`,`customer_account`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`,`remark`,`is_del`,`allolt_uid`,`allolt_user_name`,`allolt_time`,`audit_uid`,`audit_user_name`,`allolt_remark`,`is_charge`,`charge_date`,`recharge_status`,`recharge_status_text`,`account_group_id`,`is_first_charge`,`finance_uid`,`finance_no`) 
        values('".$objOrderRechargeInfo->strRechargeNo."',".$objOrderRechargeInfo->iOrderId.",'".$objOrderRechargeInfo->strOrderNo."',".$objOrderRechargeInfo->iAgentId.",'".$objOrderRechargeInfo->strAgentNo."','".$objOrderRechargeInfo->strAgentName."',".$objOrderRechargeInfo->iCustomerId.",'".$objOrderRechargeInfo->strCustomerName."',".$objOrderRechargeInfo->iAgentPactId.",'".$objOrderRechargeInfo->strAgentPactNo."',".$objOrderRechargeInfo->iPreMoney.",".$objOrderRechargeInfo->iRebateMoney.",".$objOrderRechargeInfo->iRechargeMoney.",'".$objOrderRechargeInfo->strCustomerAccount."',".$objOrderRechargeInfo->iCreateUid.",'".$objOrderRechargeInfo->strCreateUserName."',now(),".$objOrderRechargeInfo->iUpdateUid.",'".$objOrderRechargeInfo->strUpdateUserName."',now(),'".$objOrderRechargeInfo->strRemark."',".$objOrderRechargeInfo->iIsDel.",".$objOrderRechargeInfo->iAlloltUid.",'".$objOrderRechargeInfo->strAlloltUserName."','".$objOrderRechargeInfo->strAlloltTime."',".$objOrderRechargeInfo->iAuditUid.",'".$objOrderRechargeInfo->strAuditUserName."','".$objOrderRechargeInfo->strAlloltRemark."',".$objOrderRechargeInfo->iIsCharge.",'".$objOrderRechargeInfo->strChargeDate."',".$objOrderRechargeInfo->iRechargeStatus.",'".$objOrderRechargeInfo->strRechargeStatusText."',".$objOrderRechargeInfo->iAccountGroupId.",".$objOrderRechargeInfo->iIsFirstCharge.",".$objOrderRechargeInfo->iFinanceUid.",'".$objOrderRechargeInfo->strFinanceNo."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {            
            $id = $this->objMysqlDB->lastInsertId();
            
            $isSuccess = 0;
            $isSuccess = $objAdhai_FinanceService->Recharge($owner_account_name,$objOrderRechargeInfo->iRechargeMoney,$objOrderRechargeInfo->strRemark);
            if($isSuccess == false)
            {
                $sql = "update om_order_recharge set is_del=1 where order_recharge_id=".$id;
                $this->objMysqlDB->executeNonQuery(false,$sql,null);
                return 0;
            }
            
            //本系统中扣款                
            $strActDate = Utility::Now();
            //直接扣款
            $objOutMoneyAct = new OutMoneyAct();
            if($objOrderRechargeInfo->iPreMoney > 0)
            {
                $objOutMoneyAct->Init($objOrderRechargeInfo->iAgentId,$objOrderRechargeInfo->strFinanceNo,$product_type_id,AgentAccountTypes::UnitPreDeposits,BillTypes::UnitOrderCharge,$strActDate,
                $objOrderRechargeInfo->iPreMoney,$objOrderRechargeInfo->iOrderId,$objOrderRechargeInfo->strOrderNo);
                $isSuccess = $objOutMoneyAct->Insert($objOrderRechargeInfo->iCreateUid,$objOrderRechargeInfo->strRemark); 
            }
            
            if($objOrderRechargeInfo->iRebateMoney > 0)
            {
                $objOutMoneyAct->Init($objOrderRechargeInfo->iAgentId,$objOrderRechargeInfo->strFinanceNo,$product_type_id,AgentAccountTypes::UnitSaleReward,BillTypes::UnitOrderCharge,$strActDate,
                $objOrderRechargeInfo->iRebateMoney,$objOrderRechargeInfo->iOrderId,$objOrderRechargeInfo->strOrderNo);
                $isSuccess = $objOutMoneyAct->Insert($objOrderRechargeInfo->iCreateUid,$objOrderRechargeInfo->strRemark); 
            }
            
            //更新网盟订单 转款金额
            $this->UpdateOrderActPrice($objOrderRechargeInfo->iOrderId);
            
            if($iIsNew == 1)//新开转款
                $this->IntentionRatingReport($objOrderRechargeInfo->iAgentId,$objOrderRechargeInfo->iCustomerId,Utility::Today());
            return $id;
        }
        
        return 0;
	}

    /** 
     * 意向报表数据更新 新开转款
    */
    public function IntentionRatingReport($agentId,$customerId,$reportDate)
    {
        $userId = 0;
        $objCustomerAgentBLL = new CustomerAgentBLL();
        $arrayData = $objCustomerAgentBLL->select("user_id","agent_id=$agentId AND customer_id = $customerId");
        if (isset($arrayData)&& count($arrayData)>0)
            $userId = $arrayData[0]["user_id"];
            
        if($userId <= 0)
            return ;
                    
        $sql ="SELECT ifnull(sum(om_order_recharge.recharge_money),0) as recharge_money,
            count(om_order_recharge.order_recharge_id) AS recharge_count FROM cm_customer_agent 
            INNER JOIN om_order_recharge ON om_order_recharge.agent_id = cm_customer_agent.agent_id AND om_order_recharge.customer_id = cm_customer_agent.customer_id 
            where cm_customer_agent.user_id = $userId and cm_customer_agent.agent_id = $agentId and 
            DATE_FORMAT(om_order_recharge.create_time,'%Y-%m-%d') ='{$reportDate}' and om_order_recharge.is_first_charge = 1 and om_order_recharge.is_del=0 and cm_customer_agent.is_del=0";
       
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if (isset($arrayData)&& count($arrayData)>0)
        {  
            if($arrayData[0]["recharge_count"] <= 0)
                return ;
                
            $objAgentIntentionRatingBLL = new AgentIntentionRatingBLL();
            $objAgentIntentionRatingBLL->insertData($agentId,$userId,$reportDate); 
            $sql = "update rpt_agent_intention_rating set charge_count=".$arrayData[0]["recharge_count"].",charge_money=".$arrayData[0]["recharge_money"]
                ." where agent_id = $agentId and user_id = $userId and report_date ='$reportDate'"; 
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
    }
    
    /**
     * 更新网盟订单 转款金额
    */
    private function UpdateOrderActPrice($orderID)
    {        
        $recharge_money = 0;
        $sql = "select sum(recharge_money) as recharge_money from om_order_recharge where order_id = $orderID and is_del=0 ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if (isset($arrayData)&& count($arrayData)>0)
            $recharge_money = $arrayData[0]["recharge_money"];
            
        $sql = "update om_order set act_price = ".$recharge_money." where order_id=".$orderID;
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     
    public function deleteByID($id,$userID)
    {
        $iOrderId = 0;
        $sql = "select order_id from om_order_recharge where order_recharge_id=".$id;
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if (isset($arrayData)&& count($arrayData)>0)
            $iOrderId = $arrayData[0]["order_id"];
            
		$sql = "update `om_order_recharge` set is_del=1,update_uid=".$userID.",update_time=now() where order_recharge_id=".$id;
		$updateCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        if($updateCount > 0)
        {            
            //更改冻结金额
            
            //$this->UpdateOrderActPrice($iOrderId);
        }
            
        return $updateCount;
    }*/
    
	/**
     * @functional 返回数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "")
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    } 
	
				
	/**
     * @functional 返回TOP数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
	 * @param string $sGroup group  by 关键字的分组
	 * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_OrderRecharge::AllFields;
		     
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `om_order_recharge` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
   	
    
	/**
     * @functional 分页数据
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strPageFields
	 * @param string $strWhere
	 * @param string $strOrder
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
    */
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel=false)
	{
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
        $offset = ($iPageIndex-1)*$iPageSize;        
       	$strWhere = " where is_del = 0 ".$strWhere;
              		
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY create_time desc";
         
        if($bExportExcel == false)
        {
            $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `om_order_recharge` $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);  
        }   
       			
        $sqlData  = "SELECT ".T_OrderRecharge::AllFields." FROM `om_order_recharge` $strWhere $strOrder LIMIT $offset,$iPageSize";
        //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    
    /**
     * @functional 取待充值金额
    */
    public function GetWaitInMoney($iOrderID)    
    {
        $arrayData = $this->selectTop("sum(recharge_money) as recharge_money","order_id=$iOrderID and is_charge < 1","","order_id",1);
        if (isset($arrayData)&& count($arrayData)>0)
            return $arrayData[0]["recharge_money"];
        
        return 0;
    }
    
    
	/**
     * @functional 根据ID,返回一个 OrderRechargeInfo 对象
	 * @param int $id 
     * @return OrderRechargeInfo 对象
     */
	public function getModelByID($id)
	{
		$objOrderRechargeInfo = null;
		$arrayInfo = $this->select("*","order_recharge_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objOrderRechargeInfo = new OrderRechargeInfo();
            		        
            $objOrderRechargeInfo->iOrderRechargeId = $arrayInfo[0]['order_recharge_id'];
            $objOrderRechargeInfo->strRechargeNo = $arrayInfo[0]['recharge_no'];
            $objOrderRechargeInfo->iOrderId = $arrayInfo[0]['order_id'];
            $objOrderRechargeInfo->strOrderNo = $arrayInfo[0]['order_no'];
            $objOrderRechargeInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objOrderRechargeInfo->strAgentNo = $arrayInfo[0]['agent_no'];
            $objOrderRechargeInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objOrderRechargeInfo->iCustomerId = $arrayInfo[0]['customer_id'];
            $objOrderRechargeInfo->strCustomerName = $arrayInfo[0]['customer_name'];
            $objOrderRechargeInfo->iAgentPactId = $arrayInfo[0]['agent_pact_id'];
            $objOrderRechargeInfo->strAgentPactNo = $arrayInfo[0]['agent_pact_no'];
            $objOrderRechargeInfo->iPreMoney = $arrayInfo[0]['pre_money'];
            $objOrderRechargeInfo->iRebateMoney = $arrayInfo[0]['rebate_money'];
            $objOrderRechargeInfo->iRechargeMoney = $arrayInfo[0]['recharge_money'];
            $objOrderRechargeInfo->strCustomerAccount = $arrayInfo[0]['customer_account'];
            $objOrderRechargeInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objOrderRechargeInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objOrderRechargeInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objOrderRechargeInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objOrderRechargeInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objOrderRechargeInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objOrderRechargeInfo->strRemark = $arrayInfo[0]['remark'];
            $objOrderRechargeInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objOrderRechargeInfo->iAlloltUid = $arrayInfo[0]['allolt_uid'];
            $objOrderRechargeInfo->strAlloltUserName = $arrayInfo[0]['allolt_user_name'];
            $objOrderRechargeInfo->strAlloltTime = $arrayInfo[0]['allolt_time'];
            $objOrderRechargeInfo->iAuditUid = $arrayInfo[0]['audit_uid'];
            $objOrderRechargeInfo->strAuditUserName = $arrayInfo[0]['audit_user_name'];
            $objOrderRechargeInfo->strAlloltRemark = $arrayInfo[0]['allolt_remark'];
            $objOrderRechargeInfo->iIsCharge = $arrayInfo[0]['is_charge'];
            $objOrderRechargeInfo->strChargeDate = $arrayInfo[0]['charge_date'];
            $objOrderRechargeInfo->iRechargeStatus = $arrayInfo[0]['recharge_status'];
            $objOrderRechargeInfo->strRechargeStatusText = $arrayInfo[0]['recharge_status_text'];
            $objOrderRechargeInfo->iAccountGroupId = $arrayInfo[0]['account_group_id'];
            $objOrderRechargeInfo->iIsFirstCharge = $arrayInfo[0]['is_first_charge'];
            $objOrderRechargeInfo->iFinanceUid = $arrayInfo[0]['finance_uid'];
            $objOrderRechargeInfo->strFinanceNo = $arrayInfo[0]['finance_no'];
            settype($objOrderRechargeInfo->iOrderRechargeId,"integer");
            settype($objOrderRechargeInfo->iOrderId,"integer");
            settype($objOrderRechargeInfo->iAgentId,"integer");
            settype($objOrderRechargeInfo->iCustomerId,"integer");
            settype($objOrderRechargeInfo->iAgentPactId,"integer");
            settype($objOrderRechargeInfo->iPreMoney,"float");
            settype($objOrderRechargeInfo->iRebateMoney,"float");
            settype($objOrderRechargeInfo->iRechargeMoney,"float");
            settype($objOrderRechargeInfo->iCreateUid,"integer");
            settype($objOrderRechargeInfo->iUpdateUid,"integer");
            settype($objOrderRechargeInfo->iIsDel,"integer");
            settype($objOrderRechargeInfo->iAlloltUid,"integer");
            settype($objOrderRechargeInfo->iAuditUid,"integer");
            settype($objOrderRechargeInfo->iIsCharge,"integer");
            settype($objOrderRechargeInfo->iRechargeStatus,"integer");
            settype($objOrderRechargeInfo->iAccountGroupId,"integer");
            settype($objOrderRechargeInfo->iIsFirstCharge,"integer");
            settype($objOrderRechargeInfo->iFinanceUid,"integer");
            
        }
		return $objOrderRechargeInfo;
       
	}
    
    
    
	/**
     * @functional 取得新编号
     */
    public function GetNewNo()
    {
        $prefixNo = "XF";
        $strNo = $prefixNo.date("Ymd",time());
        $iCount = 1;
        $sql = "SELECT `prefix_no` ,`no_index` FROM `com_bill_no` where bill_type='OrderRechargeNo' and `prefix_no`='$prefixNo' ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);

       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $iCount = $arrayData[0]["no_index"];
            settype($iCount,"integer");
            $iCount = $iCount+1;            
        }
        else
        {        
            $sql = "insert into com_bill_no(bill_type,prefix_no,no_index) values('OrderRechargeNo','$prefixNo',0);";            
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
        if($iCount < 10)
            $strNo .= "00".$iCount;
        else if($iCount < 100)
            $strNo .= "0".$iCount;
        else if($iCount < 1000)
            $strNo .= "".$iCount;
            
        $sql = "update com_bill_no set no_index=$iCount where bill_type='OrderRechargeNo' and prefix_no = '$prefixNo';";            
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        return $strNo;
    }
    
    /**
     * 代理商网盟业绩报表详细内容，网盟订单内容
     * @param type $strWhere
     * @param type $strOrder
     * @return type 
     */
    public function getAdHaiRechargeReportList($strWhere,$strOrder){
        $strWhere = "where om_order_recharge.is_del = 0 {$strWhere}";
        if(empty($strOrder)){
            $strOrder = ' order by order_recharge_id desc ';
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        
        $sql = "SELECT om_order_recharge.customer_name,om_order_recharge.customer_id,om_order.owner_account_name,om_order.create_time as add_time,
                om_order_recharge.recharge_money,om_order_recharge.create_user_name,om_order_recharge.create_time,om_order_recharge.agent_id
                FROM om_order_recharge 
                left join om_order on om_order.order_id = om_order_recharge.order_id
                {$strWhere} {$strOrder}";
         $arrData = $this->getPageData($sql);
         return $arrData;
    }
    
    public function getChannelAdhaiReportList($strWhere,$strOrder,$strSubWhere,$strBeginTime,$strEndTime,$IsDownload = false){
        $strWhere = " where (sys_account_group.account_no = '10' or sys_account_group.account_no = '11' or sys_account_group.account_no = '12') and sys_account_group_user.is_del = 0 {$strWhere} ";
        if(empty ($strOrder)){
            $strOrder = " ORDER BY sys_account_group_user.account_group_id desc";
        }else{
            $strOrder = " order by {$strOrder} ";
        }
        $sql = "select sys_account_group_user.user_id,sys_user.e_name,sys_user.user_name,area.account_name,new_count.count as new_count,new_count.new_pre_money,new_count.new_cash_money,new_count.new_money from sys_account_group_user
                left join sys_account_group on sys_account_group.account_group_id = sys_account_group_user.account_group_id
                left join sys_user on sys_user.user_id = sys_account_group_user.user_id
                left join (select max(sys_account_group.account_no) as account_max_no,sys_account_group_user.user_id from sys_account_group_user 
					left join sys_account_group on sys_account_group.account_group_id = sys_account_group_user.account_group_id 
					where sys_account_group.account_no like '10%' and LENGTH(sys_account_group.account_no) = 6 and sys_account_group_user.is_del = 0 and sys_account_group.is_del = 0 
					GROUP BY sys_account_group_user.user_id) max_area_no on max_area_no.user_id = sys_account_group_user.user_id 
                left join sys_account_group area on area.account_no = max_area_no.account_max_no and area.is_del = 0
                left join (select count(1) as count,SUM(pre_deposit_received) as new_pre_money,SUM(cash_deposit_received) as new_cash_money,(SUM(pre_deposit_received)+SUM(cash_deposit_received)) as new_money,create_uid as channel_uid from am_agent_pact where pact_type = 1 {$strSubWhere} GROUP BY create_uid) new_count on new_count.channel_uid = sys_account_group_user.user_id
                {$strWhere} {$strOrder} ";
        if($IsDownload){
            $arrData = array('list'=>  $this->objMysqlDB->fetchAllAssoc(false,$sql,null));
        }else{
            $arrData = $this->getPageData($sql);
        }
        for($i=0;$i<count($arrData['list']);$i++){
            $arrData['list'][$i]['new_count'] = empty ($arrData['list'][$i]['new_count'])?'0':$arrData['list'][$i]['new_count'];
            $arrData['list'][$i]['new_pre_money'] = empty ($arrData['list'][$i]['new_pre_money'])?'0.00':$arrData['list'][$i]['new_pre_money'];
            $arrData['list'][$i]['new_cash_money'] = empty ($arrData['list'][$i]['new_cash_money'])?'0.00':$arrData['list'][$i]['new_cash_money'];
            $arrData['list'][$i]['new_money'] = empty ($arrData['list'][$i]['new_money'])?'0.00':$arrData['list'][$i]['new_money'];
            $arrData['list'][$i]['user_info'] = empty ($arrData['list'][$i]['user_name'])?'':"{$arrData['list'][$i]['user_name']}({$arrData['list'][$i]['e_name']})";
            $arrData['list'][$i]['begin_time'] = $strBeginTime;
            $arrData['list'][$i]['end_time'] = $strEndTime;
        }
        return $arrData;
    }
    
    /**
     * @functional 本月新开代理商数，按合同个数统计 
     * @return json
    */
    public function ChannelNewAgent(){
        $sql = "SELECT v_hr_employee.e_id,v_hr_employee.e_name,COUNT(am_agent_pact.agent_id) as agent_count,sum(pre_deposit) as pre_deposit,v_hr_employee.dept_id,v_hr_employee.dept_name
                FROM am_agent_pact INNER JOIN am_agent_source ON am_agent_source.agent_id = am_agent_pact.agent_id 
                INNER JOIN sys_user ON sys_user.user_id = am_agent_source.channel_uid inner join v_hr_employee on v_hr_employee.e_id = sys_user.e_uid 
                where am_agent_pact.pact_type = 1 and DATE_FORMAT(am_agent_pact.create_time,'%Y%m') = DATE_FORMAT(NOW(),'%Y%m') 
                GROUP BY am_agent_source.channel_uid order by COUNT(am_agent_pact.agent_id) desc,v_hr_employee.e_id limit 0,5";

        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $json = "";
            foreach($arrayData as $key => $value)
            {
                $json .= ',{';
                foreach($value as $k=>$v)
                {
                    $json .= '"'.$k.'":"'.$v.'",';
                }
                $json = substr($json,0,strlen($json)-1);
                $json .= "}";
            }
            
            $json = "[".substr($json,1)."]";
            return $json;
        }
            
        return "";
    }
    
    public function getRechargeInfoByCustomerAccount($strAccount){
        $sql = "select * from om_order_recharge where customer_account = '{$strAccount}' and is_del = 0";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
    public function getCountForChannelAdhaiReport(){
        $strMonth = date('Y-m');
        $sql = "select count(1) as count from am_agent_pact 
                left join sys_account_group_user on sys_account_group_user.user_id = am_agent_pact.create_uid
                left join sys_account_group on sys_account_group.account_group_id = sys_account_group_user.account_group_id
                where am_agent_pact.pact_type = 1 and am_agent_pact.received_date >= '{$strMonth}'
                and (sys_account_group.account_no = '10' or sys_account_group.account_no = '11' or sys_account_group.account_no = '12') and sys_account_group_user.is_del = 0 ";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
    public function getCountForChannelAdhaiOldReport(){
        $sql = "select count(1) as count from am_agent_pact 
                left join sys_account_group_user on sys_account_group_user.user_id = am_agent_pact.create_uid
                left join sys_account_group on sys_account_group.account_group_id = sys_account_group_user.account_group_id
                where am_agent_pact.pact_type = 1 
                and (sys_account_group.account_no = '10' or sys_account_group.account_no = '11' or sys_account_group.account_no = '12') and sys_account_group_user.is_del = 0";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
    public function getTotalMoneyForAgent($iAgentID,$strBeginTime,$strEndTime,$iType){
        $sql = "select SUM(pre_money) as total_pre_money,SUM(rebate_money) as total_rebate_money,SUM(recharge_money) as total_recharge_money from om_order_recharge 
                where create_time >'{$strBeginTime}' and create_time <='{$strEndTime} 23:59:59' and agent_id = {$iAgentID} and is_first_charge = {$iType} and is_del = 0";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);        
    }
}
		 