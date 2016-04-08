<?php

/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_agent_move 的类业务逻辑层
 * 表描述：代理商转移 
 * 创建人：温智星
 * 添加时间：2012-12-24 16:28:30
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgentMoveInfo.php';

class AgentMoveBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objAgentMoveInfo  AgentMoveInfo 实例
     * @return 
     */
	public function insert(AgentMoveInfo $objAgentMoveInfo)
	{
		$sql = "INSERT INTO `am_agent_move`(`move_type`,`agent_id`,`data_from`,`data_to`,`create_uid`,`create_user_name`,`create_time`) 
        values(".$objAgentMoveInfo->iMoveType.",".$objAgentMoveInfo->iAgentId.",'".$objAgentMoveInfo->strDataFrom."','".$objAgentMoveInfo->strDataTo."',".$objAgentMoveInfo->iCreateUid.",'".$objAgentMoveInfo->strCreateUserName."',now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objAgentMoveInfo  AgentMoveInfo 实例
     * @return
     */
	public function updateByID(AgentMoveInfo $objAgentMoveInfo)
	{
	   $sql = "update `am_agent_move` set `move_type`=".$objAgentMoveInfo->iMoveType.",`agent_id`=".$objAgentMoveInfo->iAgentId.",`data_from`='".$objAgentMoveInfo->strDataFrom."',`data_to`='".$objAgentMoveInfo->strDataTo."',`create_user_name`='".$objAgentMoveInfo->strCreateUserName."', where aid=".$objAgentMoveInfo->iAid;      
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
			$sField = T_AgentMove::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_agent_move` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 AgentMoveInfo 对象
	 * @param int $id 
     * @return AgentMoveInfo 对象
     */
	public function getModelByID($id)
	{
		$objAgentMoveInfo = null;
		$arrayInfo = $this->select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgentMoveInfo = new AgentMoveInfo();
            		
            $objAgentMoveInfo->iAid = $arrayInfo[0]['aid'];
            $objAgentMoveInfo->iMoveType = $arrayInfo[0]['move_type'];
            $objAgentMoveInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentMoveInfo->strDataFrom = $arrayInfo[0]['data_from'];
            $objAgentMoveInfo->strDataTo = $arrayInfo[0]['data_to'];
            $objAgentMoveInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgentMoveInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objAgentMoveInfo->strCreateTime = $arrayInfo[0]['create_time'];
            settype($objAgentMoveInfo->iAid,"integer");
            settype($objAgentMoveInfo->iMoveType,"integer");
            settype($objAgentMoveInfo->iAgentId,"integer");
            settype($objAgentMoveInfo->iCreateUid,"integer");
	}

	return $objAgentMoveInfo;
    }

    /**
     * @functional 分页组装数据
     * @author liujunchen
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields
     * @param string $strWhere
     * @param string $strOrder
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'*','WHERE','ORDER BY',$c));
     */
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
    	$offset = ($iPageIndex - 1) * $iPageSize;
        
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
        else
            $strOrder = " ORDER BY am_agent_move.aid desc";
            
    	$sqlCount = "SELECT COUNT(*) AS `counts` FROM am_agent_move 
            INNER JOIN am_agent_source ON am_agent_source.agent_id = am_agent_move.agent_id WHERE am_agent_source.is_del<>2 $strWhere";
    	$iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
    	$sqlData = "SELECT am_agent_source.agent_id,am_agent_source.agent_no,am_agent_source.agent_name,
            am_agent_source.reg_province_id,am_agent_source.reg_city_id,am_agent_source.reg_area_id,am_agent_source.agent_reg_area_full_name,
            am_agent_move.move_type,am_agent_move.data_from,am_agent_move.data_to,am_agent_move.create_uid,
            am_agent_move.create_user_name,am_agent_move.create_time FROM am_agent_move 
            INNER JOIN am_agent_source ON am_agent_source.agent_id = am_agent_move.agent_id 
            WHERE am_agent_source.is_del<>2 $strWhere $strOrder LIMIT $offset,$iPageSize";
            
    	return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }    
    

}