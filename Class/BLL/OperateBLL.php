<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表log_operate的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-4 15:37:16
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/OperateInfo.php';

class OperateBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param OperateInfo $objOperateInfo  Operate实例
     * @return 
     */
	public function insert(OperateInfo $objOperateInfo)
	{
		$sql = "INSERT INTO `log_operate`(`log_ip`,`log_type`,`log_page`,`log_name`,`log_level`,`create_uid`,`create_time`)"
		." values('".$objOperateInfo->strLogIp."',".$objOperateInfo->iLogType.",'".$objOperateInfo->strLogPage."','".$objOperateInfo->strLogName."',".$objOperateInfo->iLogLevel.",".$objOperateInfo->iCreateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param OperateInfo $objOperateInfo  Operate实例
     * @return
     */
	public function updateByID(OperateInfo $objOperateInfo)
	{
		$sql = "update `log_operate` set `log_ip`='".$objOperateInfo->strLogIp."',`log_type`=".$objOperateInfo->iLogType.",`log_page`='".$objOperateInfo->strLogPage."',`log_name`='".$objOperateInfo->strLogName."',`log_level`=".$objOperateInfo->iLogLevel." where log_id=".$objOperateInfo->iLogId;
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
			$sField = T_Operate::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder == "")
			$sOrder = " order by sort_index";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `log_operate` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个log_operate对象
	 * @param int $id 
     * @return log_operate对象
     */
	public function getModelByID($id)
	{
		$objOperateInfo = null;
		$arrayInfo = $this->select("*","log_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objOperateInfo = new OperateInfo();
			$objOperateInfo->iLogId = $arrayInfo[0]['log_id'];
			$objOperateInfo->strLogIp = $arrayInfo[0]['log_ip'];
			$objOperateInfo->iLogType = $arrayInfo[0]['log_type'];
			$objOperateInfo->strLogPage = $arrayInfo[0]['log_page'];
			$objOperateInfo->strLogName = $arrayInfo[0]['log_name'];
			$objOperateInfo->iLogLevel = $arrayInfo[0]['log_level'];
			$objOperateInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objOperateInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objOperateInfo->iLogId,"integer");
			
			settype($objOperateInfo->iLogType,"integer");
			
			
			settype($objOperateInfo->iLogLevel,"integer");
			settype($objOperateInfo->iCreateUid,"integer");
			
		}
		
		return $objOperateInfo;
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `log_operate` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `log_operate` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>