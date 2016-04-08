<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_ag_replenish 的类业务逻辑层
 * 表描述：
 * 创建人：刘君臣
 * 添加时间：2012-02-29 14:53:04
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgReplenishInfo.php';

class AgReplenishBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objAgReplenishInfo  AgReplenishInfo 实例
     * @return 
     */
	public function insert(AgReplenishInfo $objAgReplenishInfo)
	{
		$sql = "INSERT INTO `am_ag_replenish`(agent_id,pact_id,pro_id,rep_remark,create_time) 
        values(".$objAgReplenishInfo->iAgentId.",".$objAgReplenishInfo->iPactId.",".$objAgReplenishInfo->iProId.",'".$objAgReplenishInfo->strRepRemark."',NOW())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objAgReplenishInfo  AgReplenishInfo 实例
     * @return
     */
	public function updateByID(AgReplenishInfo $objAgReplenishInfo)
	{
	   $sql = "update `am_ag_replenish` set `agent_id`=".$objAgReplenishInfo->iAgentId.",`pact_id`=".$objAgReplenishInfo->iPactId.",`pro_id`=".$objAgReplenishInfo->iProId.",`rep_remark`='".$objAgReplenishInfo->strRepRemark."',`create_time`='".$objAgReplenishInfo->strCreateTime."' where id=".$objAgReplenishInfo->iId;      
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
			$sField = T_AgReplenish::AllFields;
		
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
				
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
				
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `am_ag_replenish` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 AgReplenishInfo 对象
	 * @param int $id 
     * @return AgReplenishInfo 对象
     */
	public function getModelByID($id)
	{
		$objAgReplenishInfo = null;
		$arrayInfo = $this->select("*","id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgReplenishInfo = new AgReplenishInfo();
            		
        
            $objAgReplenishInfo->iId = $arrayInfo[0]['id'];
            $objAgReplenishInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgReplenishInfo->iPactId = $arrayInfo[0]['pact_id'];
            $objAgReplenishInfo->iProId = $arrayInfo[0]['pro_id'];
            $objAgReplenishInfo->strRepRemark = $arrayInfo[0]['rep_remark'];
            $objAgReplenishInfo->strCreateTime = $arrayInfo[0]['create_time'];
            settype($objAgReplenishInfo->iId,"integer");
            settype($objAgReplenishInfo->iAgentId,"integer");
            settype($objAgReplenishInfo->iPactId,"integer");
            settype($objAgReplenishInfo->iProId,"integer");
            
        }
		return $objAgReplenishInfo;
       
	}
}
		 