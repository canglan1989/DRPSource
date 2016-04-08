<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_base_data的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-9 20:58:42
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/BaseDataInfo.php';

class BaseDataBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param BaseDataInfo $objBaseDataInfo  BaseData实例
     * @return 
     */
	public function insert(BaseDataInfo $objBaseDataInfo)
	{
		$sql = "INSERT INTO `sys_base_data`(`d_value`,`d_no`,`d_name`,`data_type`,`sort_index`,`is_lock`,`is_system`,`is_def`,`is_del`,`d_remark`,`create_uid`,`create_time`,`update_uid`,`update_time`)"
		." values('".$objBaseDataInfo->strdValue."','".$objBaseDataInfo->strdNo."','".$objBaseDataInfo->strdName."','".$objBaseDataInfo->strDataType."',".$objBaseDataInfo->iSortIndex.",".$objBaseDataInfo->iIsLock.",".$objBaseDataInfo->iIsSystem.",".$objBaseDataInfo->iIsDef.",".$objBaseDataInfo->iIsDel.",'".$objBaseDataInfo->strdRemark."',".$objBaseDataInfo->iCreateUid.",now(),".$objBaseDataInfo->iUpdateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param BaseDataInfo $objBaseDataInfo  BaseData实例
     * @return
     */
	public function updateByID(BaseDataInfo $objBaseDataInfo)
	{
		$sql = "update `sys_base_data` set `d_value`='".$objBaseDataInfo->strdValue."',`d_no`='".$objBaseDataInfo->strdNo."',`d_name`='".$objBaseDataInfo->strdName."',`data_type`='".$objBaseDataInfo->strDataType."',`sort_index`=".$objBaseDataInfo->iSortIndex.",`is_lock`=".$objBaseDataInfo->iIsLock.",`is_system`=".$objBaseDataInfo->iIsSystem.",`is_def`=".$objBaseDataInfo->iIsDef.",`is_del`=".$objBaseDataInfo->iIsDel.",`d_remark`='".$objBaseDataInfo->strdRemark."',`update_uid`=".$objBaseDataInfo->iUpdateUid.",`update_time`= now() where d_id=".$objBaseDataInfo->idId;
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
		$sql = "update `sys_base_data` set is_del=1,update_uid=".$userID.",update_time=now() where d_id=".$id;
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
			$sField = T_BaseData::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_base_data` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_base_data对象
	 * @param int $id 
     * @return sys_base_data对象
     */
	public function getModelByID($id)
	{
		$objBaseDataInfo = null;
		$arrayInfo = $this->select("*","d_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objBaseDataInfo = new BaseDataInfo();
			$objBaseDataInfo->idId = $arrayInfo[0]['d_id'];
			$objBaseDataInfo->strdValue = $arrayInfo[0]['d_value'];
			$objBaseDataInfo->strdNo = $arrayInfo[0]['d_no'];
			$objBaseDataInfo->strdName = $arrayInfo[0]['d_name'];
			$objBaseDataInfo->strDataType = $arrayInfo[0]['data_type'];
			$objBaseDataInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objBaseDataInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objBaseDataInfo->iIsSystem = $arrayInfo[0]['is_system'];
			$objBaseDataInfo->iIsDef = $arrayInfo[0]['is_def'];
			$objBaseDataInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objBaseDataInfo->strdRemark = $arrayInfo[0]['d_remark'];
			$objBaseDataInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objBaseDataInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objBaseDataInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objBaseDataInfo->strUpdateTime = $arrayInfo[0]['update_time'];
		
			settype($objBaseDataInfo->idId,"integer");
			settype($objBaseDataInfo->iSortIndex,"integer");
			settype($objBaseDataInfo->iIsLock,"integer");
			settype($objBaseDataInfo->iIsSystem,"integer");
			settype($objBaseDataInfo->iIsDef,"integer");
			settype($objBaseDataInfo->iIsDel,"integer");			
			settype($objBaseDataInfo->iCreateUid,"integer");			
			settype($objBaseDataInfo->iUpdateUid,"integer");			
		}
		
		return $objBaseDataInfo;
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_base_data` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `sys_base_data` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * @functional 取得通用数据
     * @param string $dataType 数据类型
    */
    public function GetCommDataJson($dataType)
    {
        if($dataType == "")
            return "[]";
            
        $strJson = "[";
        $arrayData = $this->select("`d_value`,`d_name`","data_type='$dataType'");
        if(isset($arrayData) && count($arrayData) > 0)
        {            
            $iArrayLength = count($arrayData);
            for($i=0;$i<$iArrayLength;$i++)
            {
                $strJson .= "{'name':'".$arrayData[$i]["d_name"]."','value':'".$arrayData[$i]["d_value"]."'},";
            }
            
            if($iArrayLength > 0)
				$strJson = substr($strJson, 0, strlen($strJson) - 1);
                
        }
        
        $strJson .= "]";
        return $strJson;
    }
}
?>