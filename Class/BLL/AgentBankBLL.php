<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表fm_agent_bank的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-8-20 11:45:40
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentBankInfo.php';

class AgentBankBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AgentBankInfo $objAgentBankInfo  AgentBank实例
     * @return 
     */
	public function insert(AgentBankInfo $objAgentBankInfo)
	{
		$sql = "INSERT INTO `fm_agent_bank`(`agent_id`,`bank_name`,`account_name`,`account_no`,`update_uid`,`update_time`,`create_uid`,`create_time`,`is_del`)"
		." values(".$objAgentBankInfo->iAgentId.",'".$objAgentBankInfo->strBankName."','".$objAgentBankInfo->strAccountName."','".$objAgentBankInfo->strAccountNo."',".$objAgentBankInfo->iUpdateUid.",now(),".$objAgentBankInfo->iCreateUid.",now(),".$objAgentBankInfo->iIsDel.")";
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        return $this->objMysqlDB->lastInsertId();
	}

	/**
     * @functional 根据ID更新一条记录
     * @param AgentBankInfo $objAgentBankInfo  AgentBank实例
     * @return
     */
	public function updateByID(AgentBankInfo $objAgentBankInfo)
	{
		$sql = "update `fm_agent_bank` set `agent_id`=".$objAgentBankInfo->iAgentId.",`bank_name`='".$objAgentBankInfo->strBankName."',`account_name`='".$objAgentBankInfo->strAccountName."',`account_no`='".$objAgentBankInfo->strAccountNo."',`update_uid`=".$objAgentBankInfo->iUpdateUid.",`update_time`= now(),`is_del`=".$objAgentBankInfo->iIsDel." where agent_bank_id=".$objAgentBankInfo->iAgentBankId;
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
		$sql = "update `fm_agent_bank` set is_del=1,update_uid=".$userID.",update_time=now() where agent_bank_id=".$id;
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
			$sField = T_AgentBank::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " ";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `fm_agent_bank` ".$sWhere.$sOrder.$sGroup.$sLimit ;
      
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个fm_agent_bank对象
	 * @param int $id 
     * @return fm_agent_bank对象
     */
	public function getModelByID($id)
	{
		$objAgentBankInfo = null;
		$arrayInfo = $this->select("*","agent_bank_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentBankInfo = new AgentBankInfo();
			$objAgentBankInfo->iAgentBankId = $arrayInfo[0]['agent_bank_id'];
			$objAgentBankInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objAgentBankInfo->strBankName = $arrayInfo[0]['bank_name'];
			$objAgentBankInfo->strAccountName = $arrayInfo[0]['account_name'];
			$objAgentBankInfo->strAccountNo = $arrayInfo[0]['account_no'];
			$objAgentBankInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objAgentBankInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objAgentBankInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAgentBankInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objAgentBankInfo->iIsDel = $arrayInfo[0]['is_del'];
		
			settype($objAgentBankInfo->iAgentBankId,"integer");
			settype($objAgentBankInfo->iAgentId,"integer");
			settype($objAgentBankInfo->iUpdateUid,"integer");			
			settype($objAgentBankInfo->iCreateUid,"integer");			
			settype($objAgentBankInfo->iIsDel,"integer");
		}
		
		return $objAgentBankInfo;
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `fm_agent_bank` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		$sOrder = "";
        if($strOrder != "")
            $sOrder .= $strOrder;
        $sqlData  = "SELECT $strPageFields FROM `fm_agent_bank` WHERE $strWhere $sOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>
