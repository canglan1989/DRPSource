<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_agentpact_checklog的类业务逻辑层
 * 表描述：
 * 创建人：liujunchen
 * 添加时间：2011-8-30 11:08:09
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentpactChecklogInfo.php';
require_once __DIR__ . '/../../Class/BLL/AccountGroupUserBLL.php';

class AgentpactChecklogBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AgentpactChecklogInfo $objAgentpactChecklogInfo  AgentpactChecklog实例
     * @return 
     */
	public function insert(AgentpactChecklogInfo $objAgentpactChecklogInfo)
	{
		$sql = "INSERT INTO `am_agentpact_checklog`(`pact_id`,`agent_id`,`check_type`,`check_status`,`check_uid`,`check_time`,`check_remark`)"
		." values(".$objAgentpactChecklogInfo->iPactId.",".$objAgentpactChecklogInfo->iAgentId.",".$objAgentpactChecklogInfo->iCheckType.",".$objAgentpactChecklogInfo->iCheckStatus.",".$objAgentpactChecklogInfo->iCheckUid.",NOW(),'".$objAgentpactChecklogInfo->strCheckRemark."')";
        $this->objMysqlDB->executeNonQuery(false,$sql,null);
        return $this->objMysqlDB->lastInsertId();
	}

	/**
     * @functional 根据ID更新一条记录
     * @param AgentpactChecklogInfo $objAgentpactChecklogInfo  AgentpactChecklog实例
     * @return
     */
	public function updateByID(AgentpactChecklogInfo $objAgentpactChecklogInfo)
	{
		$sql = "update `am_agentpact_checklog` set `pact_id`=".$objAgentpactChecklogInfo->iPactId.",`agent_id`=".$objAgentpactChecklogInfo->iAgentId.",`check_type`=".$objAgentpactChecklogInfo->iCheckType.",`check_status`=".$objAgentpactChecklogInfo->iCheckStatus.",`check_uid`=".$objAgentpactChecklogInfo->iCheckUid.",`check_time`='".$objAgentpactChecklogInfo->strCheckTime."',`check_remark`='".$objAgentpactChecklogInfo->strCheckRemark."' where aid=".$objAgentpactChecklogInfo->iAid;
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
			$sField = T_AgentpactChecklog::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
		
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_agentpact_checklog` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个am_agentpact_checklog对象
	 * @param int $id 
     * @return am_agentpact_checklog对象
     */
	public function getModelByID($id)
	{
		$objAgentpactChecklogInfo = null;
		$arrayInfo = $this->select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentpactChecklogInfo = new AgentpactChecklogInfo();
			$objAgentpactChecklogInfo->iAid = $arrayInfo[0]['aid'];
			$objAgentpactChecklogInfo->iPactId = $arrayInfo[0]['pact_id'];
			$objAgentpactChecklogInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objAgentpactChecklogInfo->iCheckType = $arrayInfo[0]['check_type'];
			$objAgentpactChecklogInfo->iCheckStatus = $arrayInfo[0]['check_status'];
			$objAgentpactChecklogInfo->iCheckUid = $arrayInfo[0]['check_uid'];
			$objAgentpactChecklogInfo->strCheckTime = $arrayInfo[0]['check_time'];
			$objAgentpactChecklogInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
		
			settype($objAgentpactChecklogInfo->iAid,"integer");
			settype($objAgentpactChecklogInfo->iPactId,"integer");
			settype($objAgentpactChecklogInfo->iAgentId,"integer");
			settype($objAgentpactChecklogInfo->iCheckType,"integer");
			settype($objAgentpactChecklogInfo->iCheckStatus,"integer");
			settype($objAgentpactChecklogInfo->iCheckUid,"integer");
			
			
		}
		
		return $objAgentpactChecklogInfo;
	}
	
    /**
     * @functional 获取该签约合同的所有签约记录
     * @author liujunchen
     * 
    */
	public function getEachsignDetialListData($agentId,$pactId)
    {
        $sql = "SELECT DISTINCT A.pact_id,A.check_time,B.pact_status,B.pact_number,B.pact_stage,B.pact_type,B.cash_deposit,
        B.pre_deposit,B.create_uid,'' as account_name,E.e_name,E.user_name FROM am_agentpact_checklog A JOIN am_agent_pact B ON 
        A.pact_id = B.aid JOIN sys_user E ON B.create_uid = E.user_id AND A.check_type = 1 
        AND A.check_status = 1 WHERE A.pact_id = ".$pactId." AND A.agent_id = ".$agentId."";
        
        $arrayPage = self::getPageData($sql);
        
        $arrayData = null;
        if(isset($arrayPage["list"]) && count($arrayPage["list"]) > 0)
        {
            $arrayData = &$arrayPage["list"];        
            $oldCreateUserID = 0;
            $tempAccountName = "";
            $objAccountGroupUserBLL = new AccountGroupUserBLL();
            foreach($arrayData as $key => $value)
            {
                if($arrayData[$key]["create_uid"] > 0)
                {
                    if($oldCreateUserID != $arrayData[$key]["create_uid"])
                    {
                        $tempAccountName = $objAccountGroupUserBLL->GetGroupNameByUserId($arrayData[$key]["create_uid"]);                            
                        $oldCreateUserID = $arrayData[$key]["create_uid"];
                    }
                    
                    $arrayData[$key]["account_name"] = $tempAccountName;                    
                }
            }
        }
            
       
       return $arrayPage;
            
    }
    
    /**
     * @functional 显示该签约合同的审核流程
     * @author liujunchen
    */
    public function getPactCheckInfo($pactId)
    {
        $sql = "SELECT A.check_type,A.check_status,A.check_remark,A.check_time,B.e_name,B.user_name,B.user_id,C.dept_name,dept_fullname FROM am_agentpact_checklog A JOIN sys_user B ON A.check_uid = B.user_id JOIN v_hr_employee C ON B.e_uid = C.e_id AND A.pact_id = ".$pactId;
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
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
		if ($strWhere != "")
       		 $strWhere = " where ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
			
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `am_agentpact_checklog` $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `am_agentpact_checklog` $strWhere $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>
