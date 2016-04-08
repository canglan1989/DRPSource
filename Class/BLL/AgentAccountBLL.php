<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_agent_account的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-2 20:23:43
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentAccountInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountAmountBLL.php';

class AgentAccountBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objAgentAccountInfo  AgentAccountInfo 实例
     * @return 
     */
	public function insert(AgentAccountInfo $objAgentAccountInfo)
	{
		$sql = "INSERT INTO `fm_agent_account`(`agent_id`,`product_type_id`,`account_type`,`in_money`,`out_money`,`balance_money`,`lock_money`,`can_use_money`,`order_out_money`,`finance_uid`,`finance_no`) 
        values(".$objAgentAccountInfo->iAgentId.",".$objAgentAccountInfo->iProductTypeId.",".$objAgentAccountInfo->iAccountType.",".$objAgentAccountInfo->iInMoney.",".$objAgentAccountInfo->iOutMoney.",".$objAgentAccountInfo->iBalanceMoney.",".$objAgentAccountInfo->iLockMoney.",".$objAgentAccountInfo->iCanUseMoney.",".$objAgentAccountInfo->iOrderOutMoney.",".$objAgentAccountInfo->iFinanceUid.",'".$objAgentAccountInfo->strFinanceNo."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objAgentAccountInfo  AgentAccountInfo 实例
     * @return
     */
	public function updateByID(AgentAccountInfo $objAgentAccountInfo)
	{
	   $sql = "update `fm_agent_account` set `agent_id`=".$objAgentAccountInfo->iAgentId.",`product_type_id`=".$objAgentAccountInfo->iProductTypeId.",`account_type`=".$objAgentAccountInfo->iAccountType.",`in_money`=".$objAgentAccountInfo->iInMoney.",`out_money`=".$objAgentAccountInfo->iOutMoney.",`balance_money`=".$objAgentAccountInfo->iBalanceMoney.",`lock_money`=".$objAgentAccountInfo->iLockMoney.",`can_use_money`=".$objAgentAccountInfo->iCanUseMoney.",`order_out_money`=".$objAgentAccountInfo->iOrderOutMoney.",`finance_uid`=".$objAgentAccountInfo->iFinanceUid.",`finance_no`='".$objAgentAccountInfo->strFinanceNo."' where account_id=".$objAgentAccountInfo->iAccountId;      
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	
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
			$sField = T_AgentAccount::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
		
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `fm_agent_account` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个 AgentAccountInfo 对象
	 * @param int $id 
     * @return AgentAccountInfo 对象
     */
	public function getModelByID($id)
	{
		$objAgentAccountInfo = null;
		$arrayInfo = $this->select("*","account_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentAccountInfo = new AgentAccountInfo();
            		        
            $objAgentAccountInfo->iAccountId = $arrayInfo[0]['account_id'];
            $objAgentAccountInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentAccountInfo->iProductTypeId = $arrayInfo[0]['product_type_id'];
            $objAgentAccountInfo->iAccountType = $arrayInfo[0]['account_type'];
            $objAgentAccountInfo->iInMoney = $arrayInfo[0]['in_money'];
            $objAgentAccountInfo->iOutMoney = $arrayInfo[0]['out_money'];
            $objAgentAccountInfo->iBalanceMoney = $arrayInfo[0]['balance_money'];
            $objAgentAccountInfo->iLockMoney = $arrayInfo[0]['lock_money'];
            $objAgentAccountInfo->iCanUseMoney = $arrayInfo[0]['can_use_money'];
            $objAgentAccountInfo->iOrderOutMoney = $arrayInfo[0]['order_out_money'];
            $objAgentAccountInfo->iFinanceUid = $arrayInfo[0]['finance_uid'];
            $objAgentAccountInfo->strFinanceNo = $arrayInfo[0]['finance_no'];
            settype($objAgentAccountInfo->iAccountId,"integer");
            settype($objAgentAccountInfo->iAgentId,"integer");
            settype($objAgentAccountInfo->iProductTypeId,"integer");
            settype($objAgentAccountInfo->iAccountType,"integer");
            settype($objAgentAccountInfo->iInMoney,"float");
            settype($objAgentAccountInfo->iOutMoney,"float");
            settype($objAgentAccountInfo->iBalanceMoney,"float");
            settype($objAgentAccountInfo->iLockMoney,"float");
            settype($objAgentAccountInfo->iCanUseMoney,"float");
            settype($objAgentAccountInfo->iOrderOutMoney,"float");
            settype($objAgentAccountInfo->iFinanceUid,"integer");
            
		}
		
		return $objAgentAccountInfo;
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
		if ($strWhere != "")
       		 $strWhere = " where ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
			
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `fm_agent_account` $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `fm_agent_account` $strWhere $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
	/**
     * @functional 代理商即时账户数据
     * @param int $agentID 代理商ID
	 * @param int $accountType 账户类别
     */
    public function GetAgentAccountAmount($agentID,$strFinanceNo,$accountType,$productTypeID = 0)
    {
        if($agentID <= 0 || $accountType<= 0 || $strFinanceNo == "")
            exit("参数有误！");
            
        $sql = "SELECT agent_id,account_type,sum(in_money) as in_money,sum(out_money) as out_money,
                sum(balance_money) as balance_money,sum(lock_money) as lock_money,
                sum(can_use_money) as can_use_money,sum(order_out_money) as order_out_money 
                FROM fm_agent_account_amount where `agent_id`=$agentID and `account_type`=$accountType and finance_no='{$strFinanceNo}'";
                
        if($productTypeID<=0)
        {
            $sql .= " group by agent_id,account_type ";
        }
        else
        {
            $sql .= " and product_type_id=$productTypeID group by agent_id,account_type,product_type_id";
        }
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null); 
        if(isset($arrayData) && count($arrayData)>0)
        {
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength;$i++)
            {
                $arrayData[$i]["other_out_money"] = $arrayData[$i]["out_money"] - $arrayData[$i]["order_out_money"];     
            }  
        }

        return  $arrayData;
        
    }
    
	/**
     * @functional 代理商即时账户数据
     * @param int $agentID 代理商ID
     * @param string $strFinanceNo 代理商财务帐户层级
     * @param int $productTypeID 产品类别ID
     */
    public function GetAgentAccount($agentID,$strFinanceNo,$accountType,$productTypeID = 0)
    {
        if($agentID <= 0 || $accountType <= 0 || $strFinanceNo == "")
            exit("代理商参数有误！");
            
        $sWhere = " and `fm_agent_account`.`account_type`=$accountType and `fm_agent_account`.finance_no='{$strFinanceNo}'"; 
            
        if($productTypeID > 0)
            $sWhere .= " and `fm_agent_account`.`product_type_id`=$productTypeID"; 
            
        $productGroup = "";
        if($accountType == AgentAccountTypes::PreDeposits || $accountType == AgentAccountTypes::SaleReward2PreDeposits
         || $accountType == AgentAccountTypes::GuaranteeMoney2PreDeposits)
            $productGroup = " and `agent_pact_product`.`product_group` = ".ProductGroups::ValueIncrease;
        else if($accountType == AgentAccountTypes::UnitPreDeposits || $accountType == AgentAccountTypes::UnitSaleReward)
            $productGroup = " and `agent_pact_product`.`product_group` = ".ProductGroups::NetworkAlliance;
                
        $sql = "SELECT if(`fm_agent_account`.`account_id` is null,0,`fm_agent_account`.`account_id`) as account_id, 
            if(`fm_agent_account`.`account_type` is null,0,`fm_agent_account`.`account_type`) as account_type,
           if(`fm_agent_account`.`in_money` is null,0,`fm_agent_account`.`in_money`) as in_money,
           if(`fm_agent_account`.`out_money` is null,0,`fm_agent_account`.`out_money`) as out_money,
           if(`fm_agent_account`.`order_out_money` is null,0,`fm_agent_account`.`order_out_money`) as order_out_money,
           if(`fm_agent_account`.`balance_money` is null,0,`fm_agent_account`.`balance_money`) as balance_money,
           if(`fm_agent_account`.`lock_money` is null,0,`fm_agent_account`.`lock_money`) as lock_money,
           if(`fm_agent_account`.`can_use_money` is null,0,`fm_agent_account`.`can_use_money`) as can_use_money,           
           `am_agent_pact`.`agent_id`,am_agent_pact.aid as agent_pact_id,am_agent_pact.pact_number,
           am_agent_pact.pact_stage,concat(am_agent_pact.pact_number,am_agent_pact.pact_stage) as pact_no,
            am_agent_pact.pact_type,`am_agent_pact`.`agent_level`,
           `am_agent_pact`.`pact_status`,`am_agent_pact`.`pact_sdate`, `am_agent_pact`.`pact_edate`,                    
          `agent_pact_product`.`product_type_id`,`agent_pact_product`.`product_type_no`, 
          `agent_pact_product`.`product_type_name` , `agent_pact_product`.`product_group` 
            FROM v_am_agent_pact_product as agent_pact_product inner join am_agent_pact on am_agent_pact.aid=agent_pact_product.agent_pact_id 
           left JOIN 
          `fm_agent_account` ON (`fm_agent_account`.`agent_id` = `agent_pact_product`.`agent_id` and 
          `fm_agent_account`.`product_type_id` = `agent_pact_product`.`product_type_id` $sWhere)
           where `agent_pact_product`.`agent_id`=$agentID ".($productTypeID>0?" and agent_pact_product.product_type_id=$productTypeID ":"")." $productGroup order by `agent_pact_product`.`product_type_name` ";
          //print_r($sql);
          
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);          
        $arrayLength = count($arrayData);
        for($i=0;$i<$arrayLength;$i++)
        {
            $arrayData[$i]["other_out_money"] = $arrayData[$i]["out_money"] - $arrayData[$i]["order_out_money"];     
        } 
        return  $arrayData;
        
    }
    
    
	/**
     * @functional 代理商即时账户数据
	 * @param int $accountType 账户类别
     */
    public function Back_GetAgentAccount($accountType,$financeNo="10")
    {            
        if($accountType <= 0)
            exit("账户类别有误！");
                                                
        $sql = "select t.`account_type`,t.`product_type_id`,t.in_money, t.out_money, t.order_out_money,t.balance_money, 
        t.lock_money, t.can_use_money,t.other_out_money, `sys_product_type`.`product_type_name` from(        
        SELECT `fm_agent_account`.`account_type`,`fm_agent_account`.`product_type_id`,
          sum(`fm_agent_account`.`in_money`) as in_money, sum(`fm_agent_account`.`out_money`) as out_money, 
          sum(`fm_agent_account`.`order_out_money`) as order_out_money,sum(`fm_agent_account`.`balance_money`) as balance_money, 
          sum(`fm_agent_account`.`lock_money`) as lock_money, sum(`fm_agent_account`.`can_use_money`) as can_use_money,0 as other_out_money  
        FROM
          `fm_agent_account` where `fm_agent_account`.`account_type`=$accountType and `fm_agent_account`.finance_no = '{$financeNo}'
          group by `fm_agent_account`.`account_type`,`fm_agent_account`.`product_type_id`)t left JOIN
          `sys_product_type` ON `sys_product_type`.`aid` = t.`product_type_id` ";
          
        //print_r($sql);           
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $arrayLength = count($arrayData);
        //var_dump($arrayData);
        for($i=0;$i<$arrayLength;$i++)
        {
            $arrayData[$i]["other_out_money"] = $arrayData[$i]["out_money"] - $arrayData[$i]["order_out_money"];
        } 
        return $arrayData;
    }
    
	/**
     * @functional 取得账户可用金额
     * @param int $agentID 代理商ID
     * @param int $financeNo 代理商财务帐户层级
	 * @param int $accountType 账户类别 AgentAccountTypes
     * @param int $productTypeID 产品类别ID
     */
    public function GetAccountCanUseMoney($agentID,$financeNo,$accountType,$productTypeID = 0)
    {            
        $sql = "SELECT `fm_agent_account`.`can_use_money`  
        FROM 
          `fm_agent_account` where `fm_agent_account`.`agent_id`=$agentID and `fm_agent_account`.finance_no='{$financeNo}' "
           .(AgentAccountTypes::RelevantWithProduct($accountType)&&$productTypeID>0  ? " and `fm_agent_account`.`product_type_id`=".$productTypeID :"")
           ." and `fm_agent_account`.`account_type`=$accountType order by `fm_agent_account`.`product_type_id`";
           //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        if(isset($arrayData) && count($arrayData))
            return $arrayData[0]["can_use_money"];
        
        return 0;
           
    }
    
        
	/**
     * @functional 显示预存款打款被退回数
     * @param int $agentID 代理商ID
     * @param int $productTypeID 产品类别ID
     
    public function GetPreDepositsPostBackBillCount($agentID,$frType = BillTypes::PreDeposits)
    {
        //and `fm_receivable_pay`.`c_product_id`= $productTypeID 
        $sql = "SELECT count(`fm_receivable_pay`.`fr_id`) as back_count   
        FROM
          `fm_receivable_pay` where `fr_object_id` = $agentID 
          and fr_type=$frType and is_del = 0 and `fm_receivable_pay`.`fr_state`=".ReceivablePayStates::Back;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sql, null);
        //print_r($sql);
        return $iRecordCount;
    }           
    */
    
	/**
     * @functional 显示保证金打款被退回数
     * @param int $agentID 代理商ID
     * @param int $productTypeID 产品类别ID
     
    public function GetGuaranteePostBackBillCount($agentID,$productTypeID = 0)
    {
        $sql = "SELECT count(`fm_receivable_pay`.`fr_id`) as back_count   
        FROM
          `fm_receivable_pay` where `fr_object_id` = $agentID ";
        
        if($productTypeID > 0)
          $sql .= " and `fm_receivable_pay`.`c_product_id`= $productTypeID ";
          
        $sql .= " and fr_type=".AgentAccountTypes::GuaranteeMoney." and is_del = 0 and `fm_receivable_pay`.`fr_state`=".ReceivablePayStates::Back;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sql, null);
        //print_r($sql);
        return $iRecordCount;
    }
        */
    
	/**
     * @functional 提交打款账户信息
     */
    public function GetPostMoneyAccountInfo($agentID,$accountType=0,$productTypeID=0)
    {
        $sWhere = " where fm_receivable_pay.`fr_object_id`=".$agentID
            ." and fm_receivable_pay.is_del = 0 ";
        
        if($accountType > 0)
            $sWhere .= " and fm_receivable_pay.`fr_type`=".$accountType;
            
        if($productTypeID > 0)
            $sWhere .= " and fm_receivable_pay.`c_product_id`=".$productTypeID;
            
        //打款总额\未到账金额\信息退回金额\底单入款金额\到账金额\红冲
        $arrayMoney = array("PostAmount"=>0,"NotEffect"=>0,"Back"=>0,"Receivable"=>0,"Received"=>0,"Red"=>0);
        
        $sql = "SELECT sum(fm_receivable_pay.fr_rev_money) as fr_money,fm_receivable_pay.fr_state 
            FROM fm_post_money INNER JOIN fm_receivable_pay ON fm_receivable_pay.fr_no = fm_post_money.post_money_no $sWhere";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
        foreach($arrayData as $key=>$value)
        {
            switch($value["fr_state"])
            {
                case ReceivablePayStates::NotEffect://未到账金额
                    $arrayMoney["NotEffect"] = $value["fr_money"];
                break;                
                case ReceivablePayStates::Receivable://底单入款金额
                    $arrayMoney["Receivable"] = $value["fr_money"];
                break;                
                case ReceivablePayStates::Received://到账金额
                    $arrayMoney["Received"] = $value["fr_money"];
                break;                
                case ReceivablePayStates::Red://红冲
                    $arrayMoney["Red"] = $value["fr_money"];
                break;              
                case ReceivablePayStates::Back://退回
                    $arrayMoney["Back"] = $value["fr_money"];
                break;                
            }
        }
        
        $arrayMoney["Received"] = $arrayMoney["Received"] - $arrayMoney["Red"];
        $arrayMoney["PostAmount"] = $arrayMoney["NotEffect"]+$arrayMoney["Receivable"]+$arrayMoney["Received"];
        
        return $arrayMoney;
             
    }
    
    public function UpdateInMoney($agentID,$accountType,$productTypeID,$financeUid,$financeNo)
    {
        $iAccountID = 0;
        $in_money = 0;        
        
        $sql = "SELECT account_id FROM `fm_agent_account` WHERE `agent_id`=".$agentID." and finance_uid=".$financeUid
        ." and `account_type`=".$accountType.(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID:"");
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $iAccountID = $arrayData[0]["account_id"];
        }
        
        $sql = "SELECT sum(`rev_money`) as inMoneyAmount FROM `fm_agent_account_detail` where `agent_id`=".$agentID." and finance_uid=".$financeUid
        ." and `account_type`=".$accountType.(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID:"")." and is_del=0 ";
        /**/
        switch($accountType)
        {            
            case AgentAccountTypes::PreDeposits:
                $sql .= " and (data_type=".BillTypes::PreDeposits." or data_type=".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub.")";
            break;
            case AgentAccountTypes::GuaranteeMoney:
                $sql .= " and (data_type=".BillTypes::GuaranteeMoney." or data_type=".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub.")";
            break;
            case AgentAccountTypes::UnitPreDeposits:
                $sql .= " and (data_type=".BillTypes::UnitPreDeposits." or data_type=".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub.")";
            break;
            case AgentAccountTypes::SaleReward2PreDeposits:
                $sql .= " and data_type=".BillTypes::SaleReward2PreDeposits." or data_type=".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub.")";
            break;
            case AgentAccountTypes::SaleReward:
                $sql .= " and data_type=".BillTypes::SaleReward." or data_type=".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub.")";
            break;
            case AgentAccountTypes::UnitSaleReward:
                $sql .= " and (data_type=".BillTypes::UnitSaleReward ." or data_type=".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub.")";
            break;
        }
        
        $sql = "select ifnull(inMoneyAmount,0) as inMoneyAmount from(".$sql.") t"; 
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            $in_money = $arrayData[0]["inMoneyAmount"];
            
        if($iAccountID > 0)
        {
            $sql = "update `fm_agent_account` set `in_money`=$in_money,`balance_money`=$in_money-`out_money`,`can_use_money`=$in_money-`out_money`-`lock_money` WHERE `account_id`=".$iAccountID;            
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        else
        {
            $sql = "insert into fm_agent_account(`agent_id`,`account_type`,`product_type_id`,`in_money`,`out_money`,
            `balance_money`,`lock_money`,`can_use_money`,`finance_uid`,`finance_no`) 
             values(".$agentID.",".$accountType.",".(AgentAccountTypes::RelevantWithProduct($accountType) ? $productTypeID:0).",$in_money, 0,
             $in_money,0,$in_money,$financeUid,'{$financeNo}');";
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }      
          
        $objAgentAccountAmountBLL = new AgentAccountAmountBLL();
        $objAgentAccountAmountBLL->InsertOrUpdate($agentID,$accountType,$productTypeID,$financeUid,$financeNo);
    }
    
    
    public function UpdateLockMoney($agentID,$accountType,$productTypeID,$financeUid,$financeNo)
    {
        $iAccountID = 0;
        $lock_money = 0;
        $lock_to_out_money = 0;
        
        $sql = "SELECT account_id FROM `fm_agent_account` WHERE `agent_id`=".$agentID." and finance_uid=".$financeUid
        ." and `account_type`=".$accountType.(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID:"");
       
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $iAccountID = $arrayData[0]["account_id"];
        }
        
        if($iAccountID == 0)
            exit("未找到此代理商的".AgentAccountTypes::GetText($accountType)."！");
        
        //当前账户转冻结
        $sql = "select ifnull(sum(lockMoneyAmount),0) as lockMoneyAmount from(
                SELECT sum(`pay_money`) as lockMoneyAmount FROM `fm_agent_account_detail` where `agent_id`=".$agentID." and finance_uid=".$financeUid
                ." and `account_type`=".$accountType                
                .(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID:"")
                ." and data_type=".BillTypes::OrderFreeze." and is_del=0 
              union all 
                SELECT sum(-`rev_money`) as lockMoneyAmount FROM `fm_agent_account_detail` where `agent_id`=".$agentID." and finance_uid=".$financeUid
                ." and `account_type`=".$accountType.(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID :"")
                ." and data_type=".BillTypes::OrderUnFreeze." and rev_money <>0 and is_del=0           
            ) t";
            
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            $lock_money = $arrayData[0]["lockMoneyAmount"];
        
        //已经扣款
        $sql = "select ifnull(chargeMoneyAmount,0) as chargeMoneyAmount from( 
        SELECT  sum(`charge_money`.`pay_money`) as chargeMoneyAmount 
        FROM 
          `fm_agent_account_detail` 
          INNER JOIN 
          `fm_agent_account_detail` as lock_money  ON `lock_money`.`source_detail_id` = `fm_agent_account_detail`.`account_detail_id` 
          and `lock_money`.`account_type`=".AgentAccountTypes::Frozen." 
          INNER JOIN
          `fm_agent_account_detail` as charge_money ON `charge_money`.`source_detail_id` = `lock_money`.`account_detail_id` 
          where `fm_agent_account_detail`.`agent_id` = $agentID and `fm_agent_account_detail`.finance_uid=".$financeUid
          .(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `fm_agent_account_detail`.`product_type_id`=".$productTypeID:"")
          ." and `fm_agent_account_detail`.`account_type` = $accountType and fm_agent_account_detail.is_del=0 and lock_money.is_del=0 and charge_money.is_del=0 )t";
            
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            $lock_money -= $arrayData[0]["chargeMoneyAmount"];
            
        $sql = "update `fm_agent_account` set lock_money = $lock_money,`can_use_money`=`in_money`-`out_money`-$lock_money WHERE `account_id`=".$iAccountID;  
         //print_r($sql);
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        $objAgentAccountAmountBLL = new AgentAccountAmountBLL();
        $objAgentAccountAmountBLL->InsertOrUpdate($agentID,$accountType,$productTypeID,$financeUid,$financeNo);
            
    }
    
    
    public function UpdateOutMoney($agentID,$accountType,$productTypeID,$financeUid,$financeNo)
    {
        $iAccountID = 0;
        $order_out_money = 0;
        $out_money = 0;
        $in_money = 0;
        $lock_money = 0;
        
        $sql = "SELECT account_id,in_money,lock_money FROM `fm_agent_account` WHERE `agent_id`=".$agentID." and finance_uid=".$financeUid
        ." and `account_type`=".$accountType.(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID:"");
        
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $iAccountID = $arrayData[0]["account_id"];
            $in_money = $arrayData[0]["in_money"];
            $lock_money = $arrayData[0]["lock_money"];
        }
        
        if($iAccountID == 0)
            exit("未找到此代理商的".AgentAccountTypes::GetText($accountType)."！");
        
         //订单扣款  (除去退款) //网盟消费
        switch($accountType)
        {            
            case AgentAccountTypes::UnitPreDeposits:
            case AgentAccountTypes::UnitSaleReward:
                $sql = "SELECT  sum(`pay_money`) as chargeMoneyAmount 
                FROM `fm_agent_account_detail` 
                  where `fm_agent_account_detail`.`agent_id` = $agentID and `fm_agent_account_detail`.finance_uid=".$financeUid
                  .(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `fm_agent_account_detail`.`product_type_id`=".$productTypeID:"")
                  ." and `fm_agent_account_detail`.`account_type` = $accountType and data_type=".BillTypes::UnitOrderCharge." and fm_agent_account_detail.is_del=0 
                 union all 
                SELECT sum(-`rev_money`) as chargeMoneyAmount FROM `fm_agent_account_detail` where `agent_id`=".$agentID." and finance_uid=".$financeUid
                ." and `account_type`=".$accountType.(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID :"")
                ." and data_type=".BillTypes::UnitBackMoney." and rev_money <>0 and is_del=0 ";
            break;
            default:
                $sql = " SELECT  sum(`charge_money`.`pay_money`) as chargeMoneyAmount 
                FROM 
                  `fm_agent_account_detail` 
                  INNER JOIN
                  `fm_agent_account_detail` as lock_money  ON `lock_money`.`source_detail_id` = `fm_agent_account_detail`.`account_detail_id` 
                  and `lock_money`.`account_type`=".AgentAccountTypes::Frozen." 
                  INNER JOIN
                  `fm_agent_account_detail` as charge_money ON `charge_money`.`source_detail_id` = `lock_money`.`account_detail_id` 
                  where `fm_agent_account_detail`.`agent_id` = $agentID and `fm_agent_account_detail`.finance_uid=".$financeUid
                  .(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `fm_agent_account_detail`.`product_type_id`=".$productTypeID:"")
                  ." and `fm_agent_account_detail`.`account_type` = $accountType and fm_agent_account_detail.is_del=0 and lock_money.is_del=0 and charge_money.is_del=0 
                union all 
                SELECT sum(-`rev_money`) as chargeMoneyAmount FROM `fm_agent_account_detail` where `agent_id`=".$agentID." and finance_uid=".$financeUid
                ." and `account_type`=".$accountType.(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID :"")
                ." and data_type=".BillTypes::ChargeBack." and rev_money <>0 and is_del=0 ";
            break;
        }
        
        $sql = "select ifnull(sum(chargeMoneyAmount),0) as chargeMoneyAmount from({$sql})t";          
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            $order_out_money = $arrayData[0]["chargeMoneyAmount"];
            
        $out_money = $order_out_money;
        
        //其他支出
        $sql = "select ifnull(outMoneyAmount,0) as outMoneyAmount from(
                SELECT sum(`pay_money`) as outMoneyAmount FROM `fm_agent_account_detail` where `agent_id`=".$agentID." and finance_uid=".$financeUid
                ." and `account_type`=".$accountType.(AgentAccountTypes::RelevantWithProduct($accountType) ? " and `product_type_id`=".$productTypeID :"")
                ." and (data_type=".BillTypes::GuaranteeMoneyBack." or data_type=".BillTypes::PunishMoney." or data_type=".
                BillTypes::BackMoney." or data_type=".BillTypes::UnitSaleCharge." or data_type=".BillTypes::MoveMoneyOut." or data_type=".BillTypes::MoveMoneyOutSup.") and pay_money <>0 and is_del=0 
            ) t";
           //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            $out_money += $arrayData[0]["outMoneyAmount"];
                        
        $balance_money = $in_money - $out_money;
        $can_use_money = $balance_money - $lock_money;
        
        $sql = "update `fm_agent_account` set out_money = $out_money,balance_money = $balance_money,
        order_out_money=$order_out_money,`can_use_money`=$can_use_money WHERE `account_id`=".$iAccountID;   
        //print_r($sql);         
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        $objAgentAccountAmountBLL = new AgentAccountAmountBLL();
        $objAgentAccountAmountBLL->InsertOrUpdate($agentID,$accountType,$productTypeID,$financeUid,$financeNo);
    }
    
    /**
     * @functional 根据代理商Id和产品Id获取保证金余额
     * @author liujunchen
    */
    public function getBalance($agentId,$proId)
    {
        $sql = "SELECT balance_money FROM `fm_agent_account` where agent_id=".$agentId." AND product_type_id=".$proId." AND account_type = 1";
        return $this->objMysqlDB->executeAndReturn(false,$sql,null);
    }
    
    
	/**
     * @functional 
     * @param int $agentID 代理商ID
     */
    public function GetAgentMainAccount($agentID)
    {         
        $sql  = "SELECT * from (SELECT product_type_id, product_type_name,".AgentAccountTypes::GuaranteeMoney." as account_type 
        FROM v_am_agent_pact_product where agent_id= $agentID
        union all 
        SELECT product_type_id, product_type_name,case product_group when 1 then ".AgentAccountTypes::UnitPreDeposits." else ".AgentAccountTypes::PreDeposits." end as account_type 
        FROM v_am_agent_pact_product where agent_id= $agentID) t order by product_type_id,account_type";
        //print_r($sql);
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
        foreach($arrayData as $key => $value)
        {
            $arrayData[$key]["account_type_text"] = $value["product_type_name"]." ".AgentAccountTypes::GetText($value["account_type"]);
        }
        return $arrayData;
    }
    
    
	/**
     * @functional 有网盟转款记录的客户帐号
     * @param int $agentID 代理商ID
     */
    public function UnitHaveChargeMoneyCustomerAccount($text,$agentID)
    {
        $sql = "SELECT DISTINCT customer_account as `id`,customer_account as `name` FROM om_order_recharge  
        where agent_id=$agentID and is_charge=1 and is_del=0 and customer_account like '%$text%' order by customer_account";
                
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        return json_encode(array('value' => $arrayData));
    }
    
    
    
	/**
     * @functional 代理商给客户转款 预存款和返点的比值
     * @param string $accountName 客户帐号名
     * @return array(PreRate,ReRate)
     */
    public function UnitPreReMoneyRate($accountName)
    {
        $sql = "SELECT if(pre_money,pre_money,1) as pre_money,if(recharge_money,recharge_money,1) as recharge_money from (
        SELECT sum(pre_money) as pre_money,sum(recharge_money) as recharge_money 
        FROM `om_order_recharge` where customer_account='{$accountName}' and is_del=0)t";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $pre_rate = $arrayData[0]["pre_money"]/$arrayData[0]["recharge_money"];
            $pre_rate = round($pre_rate*100000,2);
            return array($pre_rate,100000-$pre_rate);
        }
        
        return array(1,0);
    }
    
    
	/**
     * @functional 代理商即时账户可用金额
     * @param int $agentID 代理商ID
     * @param int $iFinanceUid 代理商财务帐户层级ID
     */
    public function GetAgentAccountDetail($agentID,$iFinanceUid)
    {
        $sql = "SELECT v_am_agent_pact_product.product_type_id,v_am_agent_pact_product.product_type_name,
        ifnull(fm_agent_account.account_type,0) as account_type,ifnull(fm_agent_account.can_use_money,0) as can_use_money,
        fm_agent_account.in_money,fm_agent_account.out_money,fm_agent_account.balance_money,fm_agent_account.lock_money,fm_agent_account.order_out_money 
        FROM v_am_agent_pact_product 
        Left JOIN fm_agent_account ON fm_agent_account.product_type_id=v_am_agent_pact_product.product_type_id and fm_agent_account.finance_uid=".$iFinanceUid." and fm_agent_account.account_type in(".
        AgentAccountTypes::GuaranteeMoney.",".AgentAccountTypes::PreDeposits.
        ",".AgentAccountTypes::SaleReward.",".AgentAccountTypes::UnitPreDeposits.",".AgentAccountTypes::UnitSaleReward.")
        where v_am_agent_pact_product.agent_id = ".$agentID." order by v_am_agent_pact_product.product_type_id,
        fm_agent_account.account_type";
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
	/**
     * @functional 代理商即时账户可用金额
     * @param int $agentID 代理商ID
     * @param int $iFinanceUid 代理商财务帐户层级ID
     */
    public function GetAgentAccountCanUseMoney($agentID,$iFinanceUid)
    {
        $arrayData = $this->GetAgentAccountDetail($agentID,$iFinanceUid);
        $arrayAccount = array(array());
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $oldProductID = 0;
            $fIndex = -1;
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength;$i++)
            {
                if($oldProductID != $arrayData[$i]["product_type_id"])
                {
                    $fIndex++;
                    $oldProductID = $arrayData[$i]["product_type_id"];
                    $arrayAccount[$fIndex]["product_type_id"] = $oldProductID;
                    $arrayAccount[$fIndex]["product_type_name"] = $arrayData[$i]["product_type_name"];                    
                    
                    $arrayAccount[$fIndex]["gua_money"] = 0;
                    $arrayAccount[$fIndex]["pre_money"] = 0;
                    $arrayAccount[$fIndex]["rew_money"] = 0;
                }
                
                switch($arrayData[$i]["account_type"])
                {
                    case AgentAccountTypes::GuaranteeMoney:
                        $arrayAccount[$fIndex]["gua_money"] = $arrayData[$i]["can_use_money"];
                    break;
                    case AgentAccountTypes::PreDeposits:
                    case AgentAccountTypes::UnitPreDeposits:
                        $arrayAccount[$fIndex]["pre_money"] = $arrayData[$i]["can_use_money"];
                    break;
                    case AgentAccountTypes::SaleReward:
                    case AgentAccountTypes::UnitSaleReward:
                        $arrayAccount[$fIndex]["rew_money"] = $arrayData[$i]["can_use_money"];
                    break;
                }
            }
        }
        
        return $arrayAccount;
    }
}