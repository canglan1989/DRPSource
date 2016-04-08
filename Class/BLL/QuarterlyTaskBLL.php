<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_quarterly_task的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-10-17 20:27:03
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/QuarterlyTaskInfo.php';

class QuarterlyTaskBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param QuarterlyTaskInfo $objQuarterlyTaskInfo  QuarterlyTask实例
     * @return 
     */
	public function insert(QuarterlyTaskInfo $objQuarterlyTaskInfo)
	{
		$sql = "INSERT INTO `am_quarterly_task`(`agent_id`,`product_type_id`,`agent_pact_id`,`agent_pact_no`,`agent_level`,`task_year`,`task_quarterly`,`task_quarterly_text`,`task_money`,`finish_money`,`sale_award_money`,`market_funds`,`distribution_funds`,`audit_status`,`quarterly_task_remark`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`,`is_del`,`account_group_id`,`award_money`,`award_uid`,`award_user_name`,`award_time`,`award_remark`)"
		." values(".$objQuarterlyTaskInfo->iAgentId.",".$objQuarterlyTaskInfo->iProductTypeId.",".$objQuarterlyTaskInfo->iAgentPactId.",'".$objQuarterlyTaskInfo->strAgentPactNo."',".$objQuarterlyTaskInfo->iAgentLevel.",".$objQuarterlyTaskInfo->iTaskYear.",".$objQuarterlyTaskInfo->iTaskQuarterly.",'".$objQuarterlyTaskInfo->strTaskQuarterlyText."',".$objQuarterlyTaskInfo->iTaskMoney.",".$objQuarterlyTaskInfo->iFinishMoney.",".$objQuarterlyTaskInfo->iSaleAwardMoney.",".$objQuarterlyTaskInfo->iMarketFunds.",".$objQuarterlyTaskInfo->iDistributionFunds.",".$objQuarterlyTaskInfo->iAuditStatus.",'".$objQuarterlyTaskInfo->strQuarterlyTaskRemark."',".$objQuarterlyTaskInfo->iCreateUid.",'".$objQuarterlyTaskInfo->strCreateUserName."',now(),".$objQuarterlyTaskInfo->iUpdateUid.",'".$objQuarterlyTaskInfo->strUpdateUserName."',now(),".$objQuarterlyTaskInfo->iIsDel.",".$objQuarterlyTaskInfo->iAccountGroupId.",".$objQuarterlyTaskInfo->iAwardMoney.",".$objQuarterlyTaskInfo->iAwardUid.",'".$objQuarterlyTaskInfo->strAwardUserName."','".$objQuarterlyTaskInfo->strAwardTime."','".$objQuarterlyTaskInfo->strAwardRemark."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param QuarterlyTaskInfo $objQuarterlyTaskInfo  QuarterlyTask实例
     * @return
     */
	public function updateByID(QuarterlyTaskInfo $objQuarterlyTaskInfo)
	{
		$sql = "update `am_quarterly_task` set `agent_id`=".$objQuarterlyTaskInfo->iAgentId.",`product_type_id`=".$objQuarterlyTaskInfo->iProductTypeId.",`agent_pact_id`=".$objQuarterlyTaskInfo->iAgentPactId.",`agent_pact_no`='".$objQuarterlyTaskInfo->strAgentPactNo."',`agent_level`=".$objQuarterlyTaskInfo->iAgentLevel.",`task_year`=".$objQuarterlyTaskInfo->iTaskYear.",`task_quarterly`=".$objQuarterlyTaskInfo->iTaskQuarterly.",`task_quarterly_text`='".$objQuarterlyTaskInfo->strTaskQuarterlyText."',`task_money`=".$objQuarterlyTaskInfo->iTaskMoney.",`finish_money`=".$objQuarterlyTaskInfo->iFinishMoney.",`sale_award_money`=".$objQuarterlyTaskInfo->iSaleAwardMoney.",`market_funds`=".$objQuarterlyTaskInfo->iMarketFunds.",`distribution_funds`=".$objQuarterlyTaskInfo->iDistributionFunds.",`audit_status`=".$objQuarterlyTaskInfo->iAuditStatus.",`quarterly_task_remark`='".$objQuarterlyTaskInfo->strQuarterlyTaskRemark."',`create_user_name`='".$objQuarterlyTaskInfo->strCreateUserName."',`update_uid`=".$objQuarterlyTaskInfo->iUpdateUid.",`update_user_name`='".$objQuarterlyTaskInfo->strUpdateUserName."',`update_time`= now(),`is_del`=".$objQuarterlyTaskInfo->iIsDel.",`account_group_id`=".$objQuarterlyTaskInfo->iAccountGroupId.",`award_money`=".$objQuarterlyTaskInfo->iAwardMoney.",`award_uid`=".$objQuarterlyTaskInfo->iAwardUid.",`award_user_name`='".$objQuarterlyTaskInfo->strAwardUserName."',`award_time`='".$objQuarterlyTaskInfo->strAwardTime."',`award_remark`='".$objQuarterlyTaskInfo->strAwardRemark."' where quarterly_task_id=".$objQuarterlyTaskInfo->iQuarterlyTaskId;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `am_quarterly_task` set is_del=1,update_uid=".$userID.",update_time=now() where quarterly_task_id=".$id;
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
			$sField = T_QuarterlyTask::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `am_quarterly_task` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个am_quarterly_task对象
	 * @param int $id 
     * @return am_quarterly_task对象
     */
	public function getModelByID($id)
	{
		$objQuarterlyTaskInfo = null;
		$arrayInfo = $this->select("*","quarterly_task_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objQuarterlyTaskInfo = new QuarterlyTaskInfo();
			$objQuarterlyTaskInfo->iQuarterlyTaskId = $arrayInfo[0]['quarterly_task_id'];
			$objQuarterlyTaskInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objQuarterlyTaskInfo->iProductTypeId = $arrayInfo[0]['product_type_id'];
			$objQuarterlyTaskInfo->iAgentPactId = $arrayInfo[0]['agent_pact_id'];
			$objQuarterlyTaskInfo->strAgentPactNo = $arrayInfo[0]['agent_pact_no'];
			$objQuarterlyTaskInfo->iAgentLevel = $arrayInfo[0]['agent_level'];
			$objQuarterlyTaskInfo->iTaskYear = $arrayInfo[0]['task_year'];
			$objQuarterlyTaskInfo->iTaskQuarterly = $arrayInfo[0]['task_quarterly'];
			$objQuarterlyTaskInfo->strTaskQuarterlyText = $arrayInfo[0]['task_quarterly_text'];
			$objQuarterlyTaskInfo->iTaskMoney = $arrayInfo[0]['task_money'];
			$objQuarterlyTaskInfo->iFinishMoney = $arrayInfo[0]['finish_money'];
			$objQuarterlyTaskInfo->iSaleAwardMoney = $arrayInfo[0]['sale_award_money'];
			$objQuarterlyTaskInfo->iMarketFunds = $arrayInfo[0]['market_funds'];
			$objQuarterlyTaskInfo->iDistributionFunds = $arrayInfo[0]['distribution_funds'];
			$objQuarterlyTaskInfo->iAuditStatus = $arrayInfo[0]['audit_status'];
			$objQuarterlyTaskInfo->strQuarterlyTaskRemark = $arrayInfo[0]['quarterly_task_remark'];
			$objQuarterlyTaskInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objQuarterlyTaskInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
			$objQuarterlyTaskInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objQuarterlyTaskInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objQuarterlyTaskInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
			$objQuarterlyTaskInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objQuarterlyTaskInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objQuarterlyTaskInfo->iAccountGroupId = $arrayInfo[0]['account_group_id'];
			$objQuarterlyTaskInfo->iAwardMoney = $arrayInfo[0]['award_money'];
			$objQuarterlyTaskInfo->iAwardUid = $arrayInfo[0]['award_uid'];
			$objQuarterlyTaskInfo->strAwardUserName = $arrayInfo[0]['award_user_name'];
			$objQuarterlyTaskInfo->strAwardTime = $arrayInfo[0]['award_time'];
			$objQuarterlyTaskInfo->strAwardRemark = $arrayInfo[0]['award_remark'];
		
			settype($objQuarterlyTaskInfo->iQuarterlyTaskId,"integer");
			settype($objQuarterlyTaskInfo->iAgentId,"integer");
			settype($objQuarterlyTaskInfo->iProductTypeId,"integer");
			settype($objQuarterlyTaskInfo->iAgentPactId,"integer");			
			settype($objQuarterlyTaskInfo->iAgentLevel,"integer");
			settype($objQuarterlyTaskInfo->iTaskYear,"integer");
			settype($objQuarterlyTaskInfo->iTaskQuarterly,"integer");			
			settype($objQuarterlyTaskInfo->iTaskMoney,"float");
			settype($objQuarterlyTaskInfo->iFinishMoney,"float");
			settype($objQuarterlyTaskInfo->iSaleAwardMoney,"float");
			settype($objQuarterlyTaskInfo->iMarketFunds,"float");
			settype($objQuarterlyTaskInfo->iDistributionFunds,"float");
			settype($objQuarterlyTaskInfo->iAuditStatus,"integer");			
			settype($objQuarterlyTaskInfo->iCreateUid,"integer");
			settype($objQuarterlyTaskInfo->iUpdateUid,"integer");
			settype($objQuarterlyTaskInfo->iIsDel,"integer");
			settype($objQuarterlyTaskInfo->iAccountGroupId,"integer");
			settype($objQuarterlyTaskInfo->iAwardMoney,"float");
			settype($objQuarterlyTaskInfo->iAwardUid,"integer");
		}
		
		return $objQuarterlyTaskInfo;
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
        $strWhere = " where `am_quarterly_task`.is_del = 0 ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
		else
             $strOrder = " ORDER BY `am_quarterly_task`.`task_year` desc, `am_quarterly_task`.`task_quarterly` desc,
             `am_agent`.`agent_no`, `am_agent`.`agent_name`,`sys_product_type`.`product_type_name`,`am_quarterly_task`.`quarterly_task_id` desc";
             
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `am_quarterly_task` INNER JOIN
              `am_agent` ON `am_agent`.`agent_id` = `am_quarterly_task`.`agent_id` $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT
          `am_quarterly_task`.`quarterly_task_id`, `am_quarterly_task`.`agent_id`,
          `am_quarterly_task`.`product_type_id`, `am_quarterly_task`.`agent_pact_id`,
          `am_quarterly_task`.`agent_pact_no`, `am_quarterly_task`.`agent_level`,
          `am_quarterly_task`.`task_year`, `am_quarterly_task`.`task_quarterly`,
          `am_quarterly_task`.`task_quarterly_text`, `am_quarterly_task`.`task_money`,
          `am_quarterly_task`.`finish_money`, `am_quarterly_task`.`sale_award_money`,
          `am_quarterly_task`.`market_funds`, `am_quarterly_task`.`distribution_funds`,
          `am_quarterly_task`.`audit_status`,
          `am_quarterly_task`.`quarterly_task_remark`, `am_quarterly_task`.`create_uid`,
          `am_quarterly_task`.`create_user_name`, `am_quarterly_task`.`create_time`,
          `am_quarterly_task`.`update_uid`, `am_quarterly_task`.`update_user_name`,
          `am_quarterly_task`.`update_time`, `am_quarterly_task`.`is_del`,
          `am_quarterly_task`.`account_group_id`, `am_quarterly_task`.`award_money`,
          `am_quarterly_task`.`award_uid`, `am_quarterly_task`.`award_user_name`,
          `am_quarterly_task`.`award_time`, `am_quarterly_task`.`award_remark`,
          `am_agent`.`agent_no`, `am_agent`.`agent_name`,`sys_product_type`.`data_type` as product_group,
          `sys_product_type`.`product_type_no`, `sys_product_type`.`product_type_name`
        FROM
          `am_quarterly_task` INNER JOIN
          `am_agent` ON `am_agent`.`agent_id` = `am_quarterly_task`.`agent_id`
          INNER JOIN
          `sys_product_type` ON `am_quarterly_task`.`product_type_id` =
            `sys_product_type`.`aid` $strWhere $strOrder LIMIT $offset,$iPageSize";
        
        //print_r($sqlData);
                 
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * @functional 能否被删除 
    */
    public function CanDel($id)
    {
        $sql = "SELECT 1 FROM `am_quarterly_task` where `quarterly_task_id`=$id and `is_del` = 0 and `award_money` <= 0 ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
        if (isset($arrayData)&& count($arrayData)>0)
            return true;
        else
            return false;
    }
    
    
    public function GetYears()
    {
        $sql = "SELECT `task_year` as year FROM `am_quarterly_task` where is_del = 0 group by task_year  order by task_year;";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);		
    }
    
}
?>
