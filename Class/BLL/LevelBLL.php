<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表hr_level的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-3 17:43:09
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/LevelInfo.php';

class LevelBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param LevelInfo $objLevelInfo  Level实例
     * @return 
     */
	public function insert(LevelInfo $objLevelInfo)
	{
		$sql = "INSERT INTO `hr_level`(`level_name`,`m_value`,`level_type`,`sort_index`,`is_lock`,`is_del`,`create_uid`,`create_time`)"
		." values('".$objLevelInfo->strLevelName."','".$objLevelInfo->strmValue."',".$objLevelInfo->iLevelType.",".$objLevelInfo->iSortIndex.",".$objLevelInfo->iIsLock.",".$objLevelInfo->iIsDel.",".$objLevelInfo->iCreateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param LevelInfo $objLevelInfo  Level实例
     * @return
     */
	public function updateByID(LevelInfo $objLevelInfo)
	{
		$sql = "update `hr_level` set `level_name`='".$objLevelInfo->strLevelName."',`m_value`='".$objLevelInfo->strmValue."',`level_type`=".$objLevelInfo->iLevelType.",`sort_index`=".$objLevelInfo->iSortIndex.",`is_lock`=".$objLevelInfo->iIsLock.",`is_del`=".$objLevelInfo->iIsDel." where level_id=".$objLevelInfo->iLevelId;
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
		$sql = "update `hr_level` set is_del=1,update_uid=".$userID.",update_time=now() where level_id=".$id;
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
			$sField = T_Level::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " order by sort_index";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `hr_level` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个hr_level对象
	 * @param int $id 
     * @return hr_level对象
     */
	public function getModelByID($id)
	{
		$objLevelInfo = null;
		$arrayInfo = $this->select("*","level_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objLevelInfo = new LevelInfo();
			$objLevelInfo->iLevelId = $arrayInfo[0]['level_id'];
			$objLevelInfo->strLevelName = $arrayInfo[0]['level_name'];
			$objLevelInfo->strmValue = $arrayInfo[0]['m_value'];
			$objLevelInfo->iLevelType = $arrayInfo[0]['level_type'];
			$objLevelInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objLevelInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objLevelInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objLevelInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objLevelInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objLevelInfo->iLevelId,"integer");
			
			
			settype($objLevelInfo->iLevelType,"integer");
			settype($objLevelInfo->iSortIndex,"integer");
			settype($objLevelInfo->iIsLock,"integer");
			settype($objLevelInfo->iIsDel,"integer");
			settype($objLevelInfo->iCreateUid,"integer");
			
		}
		
		return $objLevelInfo;
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `hr_level` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `hr_level` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>