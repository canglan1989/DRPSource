<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_agent_account_detail的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-9-7 10:32:17
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentAccountDetailInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';
require_once __DIR__.'/../../Class/BLL/AgentAccountDetailActBLL.php';

class AgentAccountDetailBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param $objAgentAccountDetailInfo  AgentAccountDetailInfo 实例
     * @return 
     */
	public function insert(AgentAccountDetailInfo $objAgentAccountDetailInfo)
	{
		$sql = "INSERT INTO `fm_agent_account_detail`(`account_detail_no`,`agent_pact_id`,`agent_pact_no`,`agent_id`,`account_type`,`product_type_id`,`source_id`,`source_bill_no`,`data_type`,`rev_money`,`pay_money`,`act_money`,`act_date`,`balance_money`,`is_red`,`source_detail_id`,`from_account_type`,`remark`,`create_uid`,`create_time`,`update_uid`,`update_time`,`create_user_name`,`update_user_name`,`is_del`,`finance_uid`,`finance_no`) 
        values('".$objAgentAccountDetailInfo->strAccountDetailNo."',".$objAgentAccountDetailInfo->iAgentPactId.",'".$objAgentAccountDetailInfo->strAgentPactNo."',".$objAgentAccountDetailInfo->iAgentId.",".$objAgentAccountDetailInfo->iAccountType.",".$objAgentAccountDetailInfo->iProductTypeId.",".$objAgentAccountDetailInfo->iSourceId.",'".$objAgentAccountDetailInfo->strSourceBillNo."',".$objAgentAccountDetailInfo->iDataType.",".$objAgentAccountDetailInfo->iRevMoney.",".$objAgentAccountDetailInfo->iPayMoney.",".$objAgentAccountDetailInfo->iActMoney.",'".$objAgentAccountDetailInfo->strActDate."',".$objAgentAccountDetailInfo->iBalanceMoney.",".$objAgentAccountDetailInfo->iIsRed.",".$objAgentAccountDetailInfo->iSourceDetailId.",".$objAgentAccountDetailInfo->iFromAccountType.",'".$objAgentAccountDetailInfo->strRemark."',".$objAgentAccountDetailInfo->iCreateUid.",now(),".$objAgentAccountDetailInfo->iUpdateUid.",now(),'".$objAgentAccountDetailInfo->strCreateUserName."','".$objAgentAccountDetailInfo->strUpdateUserName."',".$objAgentAccountDetailInfo->iIsDel.",".$objAgentAccountDetailInfo->iFinanceUid.",'".$objAgentAccountDetailInfo->strFinanceNo."')";

        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {                        
            $id = $this->objMysqlDB->lastInsertId();
    	    //更新本次记录的余额            
            $iLastBalance = $this->GetLastBalance($objAgentAccountDetailInfo->iAgentId,$objAgentAccountDetailInfo->iFinanceUid,$objAgentAccountDetailInfo->iAccountType,
                $objAgentAccountDetailInfo->iProductTypeId,$objAgentAccountDetailInfo->strActDate,$id);
            $objAgentAccountDetailInfo->iBalanceMoney = $iLastBalance + $objAgentAccountDetailInfo->iRevMoney - $objAgentAccountDetailInfo->iPayMoney;
            $sql = "update fm_agent_account_detail set `balance_money`=".$objAgentAccountDetailInfo->iBalanceMoney." where account_detail_id=".$id;
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
            //更新本次记录后的余额
            $this->UpdateNextBalance($objAgentAccountDetailInfo->iAgentPactId,$objAgentAccountDetailInfo->iFinanceUid,$objAgentAccountDetailInfo->iAccountType,
                $objAgentAccountDetailInfo->iProductTypeId,$objAgentAccountDetailInfo->strActDate,$id,$objAgentAccountDetailInfo->iBalanceMoney);
            return $id;
        }
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objAgentAccountDetailInfo  AgentAccountDetailInfo 实例
     * @return
     */
	public function updateByID(AgentAccountDetailInfo $objAgentAccountDetailInfo)
	{
	   $oldInfo = $this->getModelByID($objAgentAccountDetailInfo->iAccountDetailId);
       if($oldInfo == null)
        return 0;
    
        $objAgentAccountDetailInfo->iBalanceMoney = $oldInfo->iBalanceMoney;
        
        $bUpdateAccount = false;
        
        if($objAgentAccountDetailInfo->iAgentId != $oldInfo->iAgentId || 
            $objAgentAccountDetailInfo->iAccountType != $oldInfo->iAccountType || 
            $objAgentAccountDetailInfo->iProductTypeId != $oldInfo->iProductTypeId ||
            $objAgentAccountDetailInfo->iDataType != $oldInfo->iDataType ||
            $objAgentAccountDetailInfo->iRevMoney != $oldInfo->iRevMoney ||
            $objAgentAccountDetailInfo->iPayMoney != $oldInfo->iPayMoney ||
            $objAgentAccountDetailInfo->strActDate != $oldInfo->strActDate ||
            $objAgentAccountDetailInfo->iIsDel != $oldInfo->iIsDel)
                $bUpdateAccount = true;
            
        if($bUpdateAccount)
        {
            //本次记录前的余额
            $iLastBalance = $this->GetLastBalance($objAgentAccountDetailInfo->iAgentId,$objAgentAccountDetailInfo->iFinanceUid,$objAgentAccountDetailInfo->iAccountType,
            $objAgentAccountDetailInfo->iProductTypeId,$objAgentAccountDetailInfo->strActDate,$id);
            $objAgentAccountDetailInfo->iBalanceMoney = $iLastBalance + $objAgentAccountDetailInfo->iRevMoney - $objAgentAccountDetailInfo->iPayMoney;
        }
        
       $sql = "update `fm_agent_account_detail` set `account_detail_no`='".$objAgentAccountDetailInfo->strAccountDetailNo."',`agent_pact_id`=".$objAgentAccountDetailInfo->iAgentPactId.",`agent_pact_no`='".$objAgentAccountDetailInfo->strAgentPactNo."',`agent_id`=".$objAgentAccountDetailInfo->iAgentId.",`account_type`=".$objAgentAccountDetailInfo->iAccountType.",`product_type_id`=".$objAgentAccountDetailInfo->iProductTypeId.",`source_id`=".$objAgentAccountDetailInfo->iSourceId.",`source_bill_no`='".$objAgentAccountDetailInfo->strSourceBillNo."',`data_type`=".$objAgentAccountDetailInfo->iDataType.",`rev_money`=".$objAgentAccountDetailInfo->iRevMoney.",`pay_money`=".$objAgentAccountDetailInfo->iPayMoney.",`act_money`=".$objAgentAccountDetailInfo->iActMoney.",`act_date`='".$objAgentAccountDetailInfo->strActDate."',`balance_money`=".$objAgentAccountDetailInfo->iBalanceMoney.",`is_red`=".$objAgentAccountDetailInfo->iIsRed.",`source_detail_id`=".$objAgentAccountDetailInfo->iSourceDetailId.",`from_account_type`=".$objAgentAccountDetailInfo->iFromAccountType.",`remark`='".$objAgentAccountDetailInfo->strRemark."',`update_uid`=".$objAgentAccountDetailInfo->iUpdateUid.",`update_time`= now(),`create_user_name`='".$objAgentAccountDetailInfo->strCreateUserName."',`update_user_name`='".$objAgentAccountDetailInfo->strUpdateUserName."',`is_del`=".$objAgentAccountDetailInfo->iIsDel.",`finance_uid`=".$objAgentAccountDetailInfo->iFinanceUid.",`finance_no`='".$objAgentAccountDetailInfo->strFinanceNo."' where account_detail_id=".$objAgentAccountDetailInfo->iAccountDetailId;      
       $backData = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        if($bUpdateAccount)
            $this->UpdateNextBalance($objAgentAccountDetailInfo->iAgentPactId,$objAgentAccountDetailInfo->iFinanceUid,$objAgentAccountDetailInfo->iAccountType,
                $objAgentAccountDetailInfo->iProductTypeId,$objAgentAccountDetailInfo->strActDate,
                $objAgentAccountDetailInfo->iAccountDetailId,$objAgentAccountDetailInfo->iBalanceMoney);
                        
        return $backData;
       
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
        $oldInfo = $this->getModelByID($id);
        if($oldInfo != null)
        {
            $sql = "delete from `fm_agent_account_detail` where account_detail_id=".$id;
    		$backData = $this->objMysqlDB->executeNonQuery(false,$sql,null);
            
            //本次记录前的余额       
            $iLastBalance = $this->GetLastBalance($oldInfo->iAgentId,$oldInfo->iFinanceUid,$oldInfo->iAccountType,
            $oldInfo->iProductTypeId,$oldInfo->strActDate,$id);
            $oldInfo->iBalanceMoney = $iLastBalance;
            
            $this->UpdateNextBalance($oldInfo->iAgentPactId,$oldInfo->iFinanceUid,$oldInfo->iAccountType,
                    $oldInfo->iProductTypeId,$oldInfo->strActDate,$oldInfo->iAccountDetailId,$oldInfo->iBalanceMoney);
                    
            return $backData;
        }
        
        return 0;
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
			$sField = T_AgentAccountDetail::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `fm_agent_account_detail` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个 AgentAccountDetailInfo 对象
	 * @param int $id 
     * @return AgentAccountDetailInfo 对象
     */
	public function getModelByID($id)
	{
		$objAgentAccountDetailInfo = null;
		$arrayInfo = $this->select("*","account_detail_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentAccountDetailInfo = new AgentAccountDetailInfo();
            		
        
            $objAgentAccountDetailInfo->iAccountDetailId = $arrayInfo[0]['account_detail_id'];
            $objAgentAccountDetailInfo->strAccountDetailNo = $arrayInfo[0]['account_detail_no'];
            $objAgentAccountDetailInfo->iAgentPactId = $arrayInfo[0]['agent_pact_id'];
            $objAgentAccountDetailInfo->strAgentPactNo = $arrayInfo[0]['agent_pact_no'];
            $objAgentAccountDetailInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentAccountDetailInfo->iAccountType = $arrayInfo[0]['account_type'];
            $objAgentAccountDetailInfo->iProductTypeId = $arrayInfo[0]['product_type_id'];
            $objAgentAccountDetailInfo->iSourceId = $arrayInfo[0]['source_id'];
            $objAgentAccountDetailInfo->strSourceBillNo = $arrayInfo[0]['source_bill_no'];
            $objAgentAccountDetailInfo->iDataType = $arrayInfo[0]['data_type'];
            $objAgentAccountDetailInfo->iRevMoney = $arrayInfo[0]['rev_money'];
            $objAgentAccountDetailInfo->iPayMoney = $arrayInfo[0]['pay_money'];
            $objAgentAccountDetailInfo->iActMoney = $arrayInfo[0]['act_money'];
            $objAgentAccountDetailInfo->strActDate = $arrayInfo[0]['act_date'];
            $objAgentAccountDetailInfo->iBalanceMoney = $arrayInfo[0]['balance_money'];
            $objAgentAccountDetailInfo->iIsRed = $arrayInfo[0]['is_red'];
            $objAgentAccountDetailInfo->iSourceDetailId = $arrayInfo[0]['source_detail_id'];
            $objAgentAccountDetailInfo->iFromAccountType = $arrayInfo[0]['from_account_type'];
            $objAgentAccountDetailInfo->strRemark = $arrayInfo[0]['remark'];
            $objAgentAccountDetailInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgentAccountDetailInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objAgentAccountDetailInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objAgentAccountDetailInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objAgentAccountDetailInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objAgentAccountDetailInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objAgentAccountDetailInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objAgentAccountDetailInfo->iFinanceUid = $arrayInfo[0]['finance_uid'];
            $objAgentAccountDetailInfo->strFinanceNo = $arrayInfo[0]['finance_no'];
            settype($objAgentAccountDetailInfo->iAccountDetailId,"integer");
            settype($objAgentAccountDetailInfo->iAgentPactId,"integer");
            settype($objAgentAccountDetailInfo->iAgentId,"integer");
            settype($objAgentAccountDetailInfo->iAccountType,"integer");
            settype($objAgentAccountDetailInfo->iProductTypeId,"integer");
            settype($objAgentAccountDetailInfo->iSourceId,"integer");
            settype($objAgentAccountDetailInfo->iDataType,"integer");
            settype($objAgentAccountDetailInfo->iRevMoney,"float");
            settype($objAgentAccountDetailInfo->iPayMoney,"float");
            settype($objAgentAccountDetailInfo->iActMoney,"float");
            settype($objAgentAccountDetailInfo->iBalanceMoney,"float");
            settype($objAgentAccountDetailInfo->iIsRed,"integer");
            settype($objAgentAccountDetailInfo->iSourceDetailId,"integer");
            settype($objAgentAccountDetailInfo->iFromAccountType,"integer");
            settype($objAgentAccountDetailInfo->iCreateUid,"integer");
            settype($objAgentAccountDetailInfo->iUpdateUid,"integer");
            settype($objAgentAccountDetailInfo->iIsDel,"integer");
            settype($objAgentAccountDetailInfo->iFinanceUid,"integer");
		}
		
		return $objAgentAccountDetailInfo;
	}
		  
    /**
    * Excel 数据导出
    */
    public function ExportPageData($strWhere,$strOrder="")
	{
    	$iRecordCount = 0;
        return $this->selectPaged(1, DataToExcel::max_record_count, "*", $strWhere, $strOrder, $iRecordCount,true);
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
        $offset = ($iPageIndex-1)*$iPageSize;
        $strWhere = " where fm_agent_account_detail.is_del=0 ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		if($bExportExcel == false)
        {	
    		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `fm_agent_account_detail` $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        
        $sqlData  = "SELECT 
            `fm_agent_account_detail`.`account_detail_id`,
          `fm_agent_account_detail`.`account_detail_no`,
          `fm_agent_account_detail`.`agent_pact_no`,
          `fm_agent_account_detail`.`agent_id`,
          `fm_agent_account_detail`.`product_type_id`,
          `fm_agent_account_detail`.`source_id`, `fm_agent_account_detail`.`data_type`,
          `fm_agent_account_detail`.`act_money`, `fm_agent_account_detail`.`create_uid`,
          `fm_agent_account_detail`.`create_time`,`fm_agent_account_detail`.source_bill_no,
          `sys_product_type`.`product_type_name`,
          `fm_agent_account_detail`.`account_type`,
          `fm_agent_account_detail`.`rev_money`, `fm_agent_account_detail`.`pay_money`,
          `fm_agent_account_detail`.`balance_money`, `fm_agent_account_detail`.`remark`,
          `fm_agent_account_detail`.`agent_pact_id` 
        FROM 
          `fm_agent_account_detail` left JOIN 
          `sys_product_type` ON `fm_agent_account_detail`.`product_type_id` =
            `sys_product_type`.`aid` $strWhere $strOrder LIMIT $offset,$iPageSize";
          //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
      
	/**
     * @functional 分页数据 带财务帐户名
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strPageFields
	 * @param string $strWhere
	 * @param string $strOrder
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'id,text','WHERE','ORDER BY',$iRecordCount));
    */
	public function selectPagedFinanceUserName($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount,$bExportExcel=false)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
        $strWhere = " where fm_agent_account_detail.is_del=0 ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		if($bExportExcel == false)
        {	
    		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `fm_agent_account_detail` $strWhere";
            $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		}
        
        $sqlData  = "SELECT fm_agent_account_detail.account_detail_id,
            fm_agent_account_detail.account_detail_no,
            fm_agent_account_detail.agent_pact_no,
            fm_agent_account_detail.agent_id,
            fm_agent_account_detail.product_type_id,
            fm_agent_account_detail.source_id,
            fm_agent_account_detail.data_type,
            fm_agent_account_detail.act_money,
            fm_agent_account_detail.act_date,
            fm_agent_account_detail.create_uid,
            fm_agent_account_detail.create_user_name,
            fm_agent_account_detail.create_time,
            fm_agent_account_detail.source_bill_no,
            sys_product_type.product_type_name,
            fm_agent_account_detail.account_type,
            fm_agent_account_detail.rev_money,
            fm_agent_account_detail.pay_money,
            fm_agent_account_detail.balance_money,
            fm_agent_account_detail.remark,
            fm_agent_account_detail.agent_pact_id,
            fm_agent_account_detail.finance_uid,
            sys_user.user_name as finance_user_name,
            sys_user.e_name as finance_e_name 
            FROM 
            fm_agent_account_detail 
            LEFT JOIN sys_product_type ON fm_agent_account_detail.product_type_id = sys_product_type.aid 
            INNER JOIN sys_user ON fm_agent_account_detail.finance_uid = sys_user.user_id 
            $strWhere $strOrder LIMIT $offset,$iPageSize";
          //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
      
    
	/**
     * @functional 取得新编号
     */
    public function GetNewNo()
    {
        $prefixNo = "M";
        $strNo = $prefixNo;
        $iCount = 1;
        $sql = "SELECT `prefix_no` ,`no_index` FROM `com_bill_no` where bill_type='AccountDetailNo' and `prefix_no`='$prefixNo' ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);

       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $iCount = $arrayData[0]["no_index"];
            settype($iCount,"integer");
            $iCount = $iCount+1;            
        }
        else
        {        
            $sql = "insert into com_bill_no(bill_type,prefix_no,no_index) values('AccountDetailNo','$prefixNo',0);";            
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
    
        if($iCount < 10)
            $strNo .= "000000".$iCount;
        else if($iCount < 100)
            $strNo .= "00000".$iCount;
        else if($iCount < 1000)
            $strNo .= "0000".$iCount;
        else if($iCount < 10000)
            $strNo .= "000".$iCount;
        else if($iCount < 100000)
            $strNo .= "00".$iCount;
        else if($iCount < 1000000)
            $strNo .= "0".$iCount;
        else
            $strNo .= "".$iCount;
            
        $sql = "update com_bill_no set no_index=$iCount where bill_type='AccountDetailNo' and prefix_no = '$prefixNo';";            
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        
        return $strNo;
    }
    
	/**
     * @functional 取本次记录($detailID)前的余额
     */    
    public function GetLastBalance($iAgentId,$iFinanceUid,$iAccountType,$iProductTypeId,$strActDate,$detailID)
    {
        $iLastBalance = 0;
                      
        $sql = "select if(balance_money,balance_money,0) as balance_money from (select sum(`rev_money`-`pay_money`) as balance_money from `fm_agent_account_detail` 
        where `agent_id`=".$iAgentId." and finance_uid = $iFinanceUid and `account_type`=".$iAccountType.(AgentAccountTypes::RelevantWithProduct($iAccountType)? " and `product_type_id`=".$iProductTypeId : "")
        ." and (`act_date`<'".$strActDate."' or (`act_date`='".$strActDate."' and `account_detail_id`<".$detailID.")) and is_del = 0)t ";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $iLastBalance = $arrayData[0]["balance_money"];
        }
        
        return $iLastBalance;
    }
    
    
	/**
     * @functional 更新本次记录($detailID)后的余额
     */ 
    public function UpdateNextBalance($iAgentId,$iFinanceUid,$iAccountType,$iProductTypeId,$strActDate,$detailID,$iLastBalance)
    {                
        $sql = "select `account_detail_id`,`act_date`,`rev_money`,`pay_money` from `fm_agent_account_detail` 
        where `agent_id`=".$iAgentId." and finance_uid = $iFinanceUid and `account_type`=".$iAccountType.(AgentAccountTypes::RelevantWithProduct($iAccountType)? " and `product_type_id`=".$iProductTypeId : "")." and 
        (`act_date`>'".$strActDate."' or (`act_date`='".$strActDate."' and `account_detail_id`>".$detailID.")) and is_del = 0 order by act_date,account_detail_id";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $iLastBalance += $arrayData[0]["rev_money"] - $arrayData[0]["pay_money"];
            
            $sql = "UPDATE fm_agent_account_detail SET `balance_money`=".$iLastBalance." WHERE `account_detail_id`=".$arrayData[0]["account_detail_id"];
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
            $this->UpdateNextBalance($iAgentId,$iFinanceUid,$iAccountType,$iProductTypeId,$arrayData[0]["act_date"],$arrayData[0]["account_detail_id"],$iLastBalance);
        }
    } 
    
	/**
     * @functional 取得订单已经冻结的款项
     */ 
    public function GetOrderFreezeMoney($orderID,&$preDepositsMoney,&$saleRewardMoney)
    {
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        
        $sql = "select if(preDepositsPrice,preDepositsPrice,0) as preDepositsPrice from(select sum(act_money) as preDepositsPrice from fm_agent_account_detail where source_id = ".$orderID.
            " and data_type=".BillTypes::OrderFreeze." and account_type=".AgentAccountTypes::PreDeposits." and is_del=0)t";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            $preDepositsMoney = $arrayData[0]["preDepositsPrice"];
        
        $sql = "select if(saleRewardPrice,saleRewardPrice,0) as saleRewardPrice from(select sum(act_money) as saleRewardPrice from fm_agent_account_detail where source_id = ".$orderID.
        " and data_type=".BillTypes::OrderFreeze." and account_type=".AgentAccountTypes::SaleReward2PreDeposits." and is_del=0)t";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)   
            $saleRewardMoney = $arrayData[0]["saleRewardPrice"]; 
    }
    
    /**
     *取得订单已经退款的款项
     * @param type $orderID
     * @param type $preDepositsMoney
     * @param type $saleRewardMoney 
     */
    public function getOrderBackedMoney($orderID,&$preDepositsMoney,&$saleRewardMoney){
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        
        $sql = "select if(preDepositsPrice,preDepositsPrice,0) as preDepositsPrice from(select sum(act_money) as preDepositsPrice from fm_agent_account_detail where source_id = ".$orderID.
            " and data_type=".BillTypes::ChargeBack." and account_type=".AgentAccountTypes::PreDeposits." and is_del=0)t";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            $preDepositsMoney = $arrayData[0]["preDepositsPrice"];
        
        $sql = "select if(saleRewardPrice,saleRewardPrice,0) as saleRewardPrice from(select sum(act_money) as saleRewardPrice from fm_agent_account_detail where source_id = ".$orderID.
        " and data_type=".BillTypes::ChargeBack." and account_type=".AgentAccountTypes::SaleReward2PreDeposits." and is_del=0)t";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)   
            $saleRewardMoney = $arrayData[0]["saleRewardPrice"]; 
    }
    
    /**
     * 获取退单详细信息
     * @param type $iOrderID
     * @return type 
     */
    public function getOrderBackInfo($iOrderID){
        $sql = "select am_agent_source.agent_name,fm_agent_account_detail.source_bill_no,fm_agent_account_detail.remark,fm_agent_account_detail.create_user_name,fm_agent_account_detail.create_time from fm_agent_account_detail 
                INNER join am_agent_source on am_agent_source.agent_id = fm_agent_account_detail.agent_id and am_agent_source.is_del = 0 
                where fm_agent_account_detail.data_type = ".BillTypes::ChargeBack." and fm_agent_account_detail.source_id = {$iOrderID}";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(!$arrData){
            return false;
        }
        
        $dFreezePreDepositisMoney = 0;
        $dFreezeSaleRewardMoney = 0;
        $dBackedPreDepositisMoney = 0;
        $dBackedSaleRewardMoney = 0;
        $this->GetOrderFreezeMoney($iOrderID, $dFreezePreDepositisMoney, $dFreezeSaleRewardMoney);
        $this->getOrderBackedMoney($iOrderID, $dBackedPreDepositisMoney, $dBackedSaleRewardMoney);
        
        if($dFreezePreDepositisMoney+$dFreezeSaleRewardMoney-$dBackedPreDepositisMoney-$dBackedSaleRewardMoney == 0){
            $BackType = '全额退款';
        }else if($dBackedPreDepositisMoney+$dBackedSaleRewardMoney == 0){
            $BackType = '未退款';
        }else{
            $BackType = '部分退款';
        }
        
        return array(
            'agent_name'=>$arrData[0]['agent_name'],
            'source_bill_no'=>$arrData[0]['source_bill_no'],
            'back_type'=>$BackType,
            'freeze_predepositis_money'=>$dFreezePreDepositisMoney,
            'freeze_salereward_money'=>$dFreezeSaleRewardMoney,
            'backed_predepositis_money'=>$dBackedPreDepositisMoney,
            'backed_salereward_money'=>$dBackedSaleRewardMoney,
            'remark'=>$arrData[0]['remark'],
            'create_user'=>$arrData[0]['create_user_name'],
            'create_time'=>$arrData[0]['create_time']
        );
    }
    
    /**
     * @functional 转款时取值
    */
    public function GetUnitChargeMoney($agentID,$strFinanceNo,$iChargeMoney,&$preDepositsMoney,&$saleRewardMoney)
    { 
        $arrayDetailChargeMoney = array();
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        
        if($iChargeMoney <= 0)
            return $arrayDetailChargeMoney;
            
        //找到可扣款的充值记录        
        $aPreDeposits = $this->f_getUnitCanChargeMoney($agentID,$strFinanceNo);    
        $arrayLength = count($aPreDeposits);
        //print_r($aPreDeposits);
        //{	
            //若预存款设置1，返点设置0，则表示对每一条充值的金额先转预存款，再转返点，进行转款时需遵循预存款即先进先出原则；
            for($i=0;$i<$arrayLength;$i++)
            {                    
                if($aPreDeposits[$i]["pre_money"]>$iChargeMoney)
                {
                    array_push($arrayDetailChargeMoney,array("account_detail_id"=>$aPreDeposits[$i]["pre_id"],"money"=>$iChargeMoney));
                    $preDepositsMoney += $iChargeMoney;
                    break;
                }
                else
                {
                    array_push($arrayDetailChargeMoney,array("account_detail_id"=>$aPreDeposits[$i]["pre_id"],"money"=>$aPreDeposits[$i]["pre_money"]));
                    $preDepositsMoney += $aPreDeposits[$i]["pre_money"];
                    $iChargeMoney = $iChargeMoney-$aPreDeposits[$i]["pre_money"];
                    
                    if($aPreDeposits[$i]["reward_money"]>$iChargeMoney)
                    {
                        array_push($arrayDetailChargeMoney,array("account_detail_id"=>$aPreDeposits[$i]["reward_id"],"money"=>$iChargeMoney));
                        $saleRewardMoney += $iChargeMoney;
                        break;
                    }
                    else
                    {
                        array_push($arrayDetailChargeMoney,array("account_detail_id"=>$aPreDeposits[$i]["reward_id"],"money"=>$aPreDeposits[$i]["reward_money"]));
                        $saleRewardMoney += $aPreDeposits[$i]["reward_money"];
                        $iChargeMoney = $iChargeMoney-$aPreDeposits[$i]["reward_money"];
                    }
                }                
            }
        //}
        
        $preDepositsMoney = round($preDepositsMoney,2);
        $saleRewardMoney = round($saleRewardMoney,2);
        
        if(($preDepositsMoney + $saleRewardMoney)<$iChargeMoney)
            $preDepositsMoney = $iChargeMoney - $saleRewardMoney;
        
        //print_r($arrayDetailChargeMoney);
        return $arrayDetailChargeMoney;
    }
    
    protected function f_getUnitCanChargeMoney($agentID,$strFinanceNo)
    {
        $objProductTypeBLL = new ProductTypeBLL();
        $productTypeID = $objProductTypeBLL->GetUnitProductTypeID();
        
        //找到充值记录
        $sql = "SELECT account_detail_id,create_time,account_type,`rev_money`-charge_money as rev_money,rev_money as back_money from(
        SELECT account_detail_id,DATE_FORMAT(create_time,'%Y-%m-%d %H:%i') as create_time,account_type,`rev_money`,
        ifnull((SELECT sum(fm_unit_out_money.out_money) from fm_unit_out_money where fm_unit_out_money.account_detail_id=fm_agent_account_detail.account_detail_id),0) as charge_money FROM `fm_agent_account_detail` 
        where agent_id={$agentID} and product_type_id = {$productTypeID} and finance_no='{$strFinanceNo}' and is_del=0 and (account_type = ".AgentAccountTypes::UnitPreDeposits.
        " or account_type = ".AgentAccountTypes::UnitSaleReward.")  and ( data_type =".BillTypes::UnitPreDeposits." or data_type =".BillTypes::UnitSaleReward." or data_type =".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub." or data_type =".BillTypes::UnitBackMoney." )
        )t order by t.`create_time`,t.account_type";
        $aUnitPreDeposits = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        //print_r($sql);
        $aPreDeposits = array();  
        $arrayLength = count($aUnitPreDeposits);
        for($i=0;$i<$arrayLength;$i++)
        {
            $aElement = array("pre_id"=>0,"reward_id"=>0,"pre_money"=>0,"reward_money"=>0,"back_pre_money"=>0,"back_reward_money"=>0);
            if($aUnitPreDeposits[$i]["account_type"] == AgentAccountTypes::UnitPreDeposits)
            {
                $aElement["pre_id"] = $aUnitPreDeposits[$i]["account_detail_id"];
                $aElement["pre_money"] = $aUnitPreDeposits[$i]["rev_money"];
                $aElement["back_pre_money"] = $aUnitPreDeposits[$i]["back_money"];
                
                if($i < $arrayLength-1 && $aUnitPreDeposits[$i+1]["account_type"] == AgentAccountTypes::UnitSaleReward             
                && $aUnitPreDeposits[$i+1]["create_time"] == $aUnitPreDeposits[$i]["create_time"])
                {
                    $aElement["reward_id"] = $aUnitPreDeposits[$i+1]["account_detail_id"];
                    $aElement["back_reward_money"] = $aUnitPreDeposits[$i+1]["back_money"];
                    
                    $aElement["reward_money"] = $aUnitPreDeposits[$i+1]["rev_money"];
                    $i++;
                }
            }            
            else
            {
                $aElement["reward_id"] = $aUnitPreDeposits[$i]["account_detail_id"];
                $aElement["back_reward_money"] = $aUnitPreDeposits[$i]["back_money"];
                
                $aElement["reward_money"] = $aUnitPreDeposits[$i]["rev_money"];
            }
                 
            array_push($aPreDeposits,$aElement);
        }
        
        $aPreDepositsTemp = array();
        //得到可扣款的预存款和销奖
        foreach($aPreDeposits  as $key => $value)
        {
            if($value["pre_money"]+$value["reward_money"]<=0)
                unset($aPreDeposits[$key]);
            else
                array_push($aPreDepositsTemp,$value);
        }
        
        $aPreDeposits = null;
        return $aPreDepositsTemp;
    }
    
    /**
     * @functional 从网盟预存款中转出金额时对应返点扣除多少
    */
    public function UnitPreDepositsMoveMoney($agentID,$strFinanceNo,$iMoveMoney,&$saleRewardMoney)
    {
        $saleRewardMoney = 0;
        $arrayDetailChargeMoney = array();
        if($iMoveMoney <= 0)
            return $arrayDetailChargeMoney;
                             
        //找到可扣款的充值记录        
        $aPreDeposits = $this->f_getUnitCanChargeMoney($agentID,$strFinanceNo);
        $arrayLength = count($aPreDeposits);
        $rewardMoney = 0;
        //print_r($aPreDeposits);
        //若预存款设置1，返点设置0，则表示对每一条充值的金额先转预存款，再转返点，进行转款时需遵循预存款即先进先出原则；
        for($i=0;$i<$arrayLength;$i++)
        {                    
            if($aPreDeposits[$i]["pre_money"]>$iMoveMoney)
            {
                array_push($arrayDetailChargeMoney,array("account_detail_id"=>$aPreDeposits[$i]["pre_id"],"money"=>$iMoveMoney));
                $rewardMoney = $iMoveMoney*$aPreDeposits[$i]["back_reward_money"]/$aPreDeposits[$i]["back_pre_money"];
                array_push($arrayDetailChargeMoney,array("account_detail_id"=>$aPreDeposits[$i]["reward_id"],"money"=>$rewardMoney));
                $saleRewardMoney += $rewardMoney;
                break;
            }
            else if($aPreDeposits[$i]["back_pre_money"]>0)
            {                
                array_push($arrayDetailChargeMoney,array("account_detail_id"=>$aPreDeposits[$i]["pre_id"],"money"=>$aPreDeposits[$i]["pre_money"]));
                $rewardMoney = $aPreDeposits[$i]["pre_money"]*$aPreDeposits[$i]["back_reward_money"]/$aPreDeposits[$i]["back_pre_money"];
                array_push($arrayDetailChargeMoney,array("account_detail_id"=>$aPreDeposits[$i]["reward_id"],"money"=>$rewardMoney));
                $saleRewardMoney += $rewardMoney;//$aPreDeposits[$i]["reward_money"];
                $iMoveMoney = $iMoveMoney-$aPreDeposits[$i]["pre_money"];
            }
        }
    
        $saleRewardMoney = round($saleRewardMoney,2);
        //print_r($arrayDetailChargeMoney);
        return $arrayDetailChargeMoney;
    }
    
    
    /**
     * @functional 网盟预存款支出扣款对应充值记录
    */
    public function UnitPreDepositsOutMoney($agentID,$strFinanceNo,$iUnitPreDepositsCharge,$iUnitSaleRewardCharge)
    {
        $arrayDetailChargeMoney = array();
        if($iUnitPreDepositsCharge+$iUnitSaleRewardCharge <= 0)
            return $arrayDetailChargeMoney;
                             
        //找到可扣款的充值记录        
        $aPreDeposits = $this->f_getUnitCanChargeMoney($agentID,$strFinanceNo);
        //print_r($aPreDeposits);
        //exit();        
        if($iUnitPreDepositsCharge > 0)
        {
            foreach($aPreDeposits  as $key => $value)
            {
                if($value["pre_money"] > $iUnitPreDepositsCharge)
                {
                    array_push($arrayDetailChargeMoney,array("account_detail_id"=>$value["pre_id"],"money"=>$iUnitPreDepositsCharge));
            
                    $aPreDeposits[$key]["pre_money"] = $value["pre_money"] - $iUnitPreDepositsCharge;
                    break;
                }
                else
                {
                    array_push($arrayDetailChargeMoney,array("account_detail_id"=>$value["pre_id"],"money"=>$value["pre_money"]));
            
                    $iUnitPreDepositsCharge = $iUnitPreDepositsCharge - $value["pre_money"];
                    $aPreDeposits[$key]["pre_money"] = 0;
                }
            }
        }
        
        if($iUnitSaleRewardCharge > 0)
        {
            foreach($aPreDeposits  as $key => $value)
            {
                if($value["reward_money"] > $iUnitSaleRewardCharge)
                {
                    array_push($arrayDetailChargeMoney,array("account_detail_id"=>$value["reward_id"],"money"=>$iUnitSaleRewardCharge));
            
                    $aPreDeposits[$key]["reward_money"] = $value["reward_money"] - $iUnitSaleRewardCharge;
                    break;
                }
                else
                {
                    array_push($arrayDetailChargeMoney,array("account_detail_id"=>$value["reward_id"],"money"=>$value["reward_money"]));
            
                    $iUnitSaleRewardCharge = $iUnitSaleRewardCharge - $value["reward_money"];
                    $aPreDeposits[$key]["reward_money"] = 0;
                }
            }
        }
        
        //print_r($arrayDetailChargeMoney);
        return $arrayDetailChargeMoney;
    }
    
    
	/**
     * @functional 客户退款的时候预存和返点各退多少
     * @param string $accountName 客户帐号名
     */
    public function GetUnitReturnPreReMoney($accountName,$canReturnMoney,&$preDepositsMoney,&$saleRewardMoney)
    {
        $preDepositsMoney = 0;
        $saleRewardMoney = 0;
        $sql = "SELECT pre_money, rebate_money FROM om_order_recharge where is_del = 0 and customer_account='{$accountName}' order by create_time desc";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $arrayLength = count($arrayData);//先消费本金，后消费返点
            //print_r($arrayData);
            for($i=0;$i<$arrayLength;$i++)
            {                    
                if($arrayData[$i]["rebate_money"]>$canReturnMoney)
                {
                    $saleRewardMoney += $canReturnMoney;
                    break;
                }
                else 
                {
                    $saleRewardMoney += $arrayData[$i]["rebate_money"];
                    $canReturnMoney = $canReturnMoney-$arrayData[$i]["rebate_money"];
                    
                    if($arrayData[$i]["pre_money"]>$canReturnMoney)
                    {
                        $preDepositsMoney += $canReturnMoney;
                        break;
                    }
                    else
                    {
                        $preDepositsMoney += $arrayData[$i]["pre_money"];
                        $canReturnMoney = $canReturnMoney-$arrayData[$i]["pre_money"];
                    }
                }
            }
            
            $preDepositsMoney = round($preDepositsMoney,2);
            $saleRewardMoney = round($saleRewardMoney,2);
            
        }
        
    }
    
    /**
     * @functional 插入记录：网盟每笔消费对应充值ID
    */
    public function InsertChargeMoneyDetail($arrayDetailChargeMoney)
    {
        $sql = "";
        foreach($arrayDetailChargeMoney as $key => $value)
        {            
            if($value["money"] != 0)
                $sql .= "insert into fm_unit_out_money(account_detail_id,out_money) values(".$value["account_detail_id"].",".$value["money"].");";
        }
        
        if($sql != "")
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
    public function f_initChargeMoneyDetail()
    {
        $objProductTypeBLL = new ProductTypeBLL();
        $productTypeID = $objProductTypeBLL->GetUnitProductTypeID();
        $sql = "SELECT distinct agent_id FROM `fm_agent_account_detail` 
        where product_type_id = {$productTypeID} and is_del=0 and (account_type = ".AgentAccountTypes::UnitPreDeposits.
        " or account_type = ".AgentAccountTypes::UnitSaleReward.")  and ( data_type =".BillTypes::UnitPreDeposits." or data_type =".BillTypes::UnitSaleReward." or data_type =".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub." or data_type =".BillTypes::UnitBackMoney." ) group by agent_id ";
        $arrayAgent = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        foreach($arrayAgent as $k => $v)
        {
            $arrayDetailChargeMoney = array();
            $agentID  = $v["agent_id"];
            //找到充值记录
            $sql = "SELECT account_detail_id,DATE_FORMAT(create_time,'%Y-%m-%d %H:%i') as create_time,account_type,`rev_money` FROM `fm_agent_account_detail` 
            where agent_id={$agentID} and product_type_id = {$productTypeID} and is_del=0 and (account_type = ".AgentAccountTypes::UnitPreDeposits.
            " or account_type = ".AgentAccountTypes::UnitSaleReward.")  and ( data_type =".BillTypes::UnitPreDeposits." or data_type =".BillTypes::UnitSaleReward." or data_type =".BillTypes::MoveMoneyIn." or data_type=".BillTypes::MoveMoneyInSub." or data_type =".BillTypes::UnitBackMoney." ) order by `create_time`,account_type";
            $aUnitPreDeposits = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            
            $aPreDeposits = array();  
            $arrayLength = count($aUnitPreDeposits);
            for($i=0;$i<$arrayLength;$i++)
            {
                $aElement = array("pre_id"=>0,"reward_id"=>0,"pre_money"=>0,"reward_money"=>0,"back_pre_money"=>0,"back_reward_money"=>0);
                if($aUnitPreDeposits[$i]["account_type"] == AgentAccountTypes::UnitPreDeposits)
                {
                    $aElement["pre_id"] = $aUnitPreDeposits[$i]["account_detail_id"];
                    $aElement["pre_money"] = $aUnitPreDeposits[$i]["rev_money"];
                    if($i < $arrayLength-1 && $aUnitPreDeposits[$i+1]["account_type"] == AgentAccountTypes::UnitSaleReward             
                    && $aUnitPreDeposits[$i+1]["create_time"] == $aUnitPreDeposits[$i]["create_time"])
                    {
                        $aElement["reward_id"] = $aUnitPreDeposits[$i+1]["account_detail_id"];
                        $aElement["reward_money"] = $aUnitPreDeposits[$i+1]["rev_money"];
                        $i++;
                    }
                }            
                else
                {
                    $aElement["reward_id"] = $aUnitPreDeposits[$i]["account_detail_id"];
                    $aElement["reward_money"] = $aUnitPreDeposits[$i]["rev_money"];
                }
                
                $aElement["back_pre_money"] = $aElement["pre_money"];
                $aElement["back_reward_money"] = $aElement["reward_money"];            
                array_push($aPreDeposits,$aElement);
            }
            
            //已扣款金额
            $sql = "SELECT ifnull(sum(`pay_money`),0) as charge_money FROM `fm_agent_account_detail` where agent_id={$agentID} and is_del=0 and account_type = ".AgentAccountTypes::UnitPreDeposits.   
            " and product_type_id = {$productTypeID} and ( data_type =".BillTypes::PunishMoney." or  data_type =".BillTypes::UnitOrderCharge."  or  data_type =".BillTypes::MoveMoneyOut." or data_type=".BillTypes::MoveMoneyOutSup." or data_type =".BillTypes::UnitSaleCharge." ) order by `create_time`";
            $iUnitPreDepositsCharge = $this->objMysqlDB->executeAndReturn(false,$sql,null);  
            if($iUnitPreDepositsCharge > 0)
            {
                foreach($aPreDeposits  as $key => $value)
                {
                    if($value["pre_money"] > $iUnitPreDepositsCharge)
                    {
                        array_push($arrayDetailChargeMoney,array("account_detail_id"=>$value["pre_id"],"money"=>$iUnitPreDepositsCharge));
                
                        $aPreDeposits[$key]["pre_money"] = $value["pre_money"] - $iUnitPreDepositsCharge;
                        break;
                    }
                    else
                    {
                        array_push($arrayDetailChargeMoney,array("account_detail_id"=>$value["pre_id"],"money"=>$value["pre_money"]));
                
                        $iUnitPreDepositsCharge = $iUnitPreDepositsCharge - $value["pre_money"];
                        $aPreDeposits[$key]["pre_money"] = 0;
                    }
                }
            }
            
            $sql = "SELECT ifnull(sum(`pay_money`),0) as charge_money FROM `fm_agent_account_detail` where agent_id={$agentID} and is_del=0 and account_type = ".AgentAccountTypes::UnitSaleReward.   
            " and product_type_id = {$productTypeID} and ( data_type =".BillTypes::PunishMoney." or  data_type =".BillTypes::UnitOrderCharge."  or  data_type =".BillTypes::MoveMoneyOut." or data_type=".BillTypes::MoveMoneyOutSup." or data_type =".BillTypes::UnitSaleCharge." ) order by `create_time`";
            $iUnitSaleRewardCharge = $this->objMysqlDB->executeAndReturn(false,$sql,null);  
            if($iUnitSaleRewardCharge > 0)
            {
                foreach($aPreDeposits  as $key => $value)
                {
                    if($value["reward_money"] > $iUnitSaleRewardCharge)
                    {
                        array_push($arrayDetailChargeMoney,array("account_detail_id"=>$value["reward_id"],"money"=>$iUnitSaleRewardCharge));
                
                        $aPreDeposits[$key]["reward_money"] = $value["reward_money"] - $iUnitSaleRewardCharge;
                        break;
                    }
                    else
                    {
                        array_push($arrayDetailChargeMoney,array("account_detail_id"=>$value["reward_id"],"money"=>$value["reward_money"]));
                
                        $iUnitSaleRewardCharge = $iUnitSaleRewardCharge - $value["reward_money"];
                        $aPreDeposits[$key]["reward_money"] = 0;
                    }
                }
            }
                
            $this->InsertChargeMoneyDetail($arrayDetailChargeMoney);
        }

    }
    
}