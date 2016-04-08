<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_model_right的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-12 8:48:36
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ModelRightInfo.php';

class ModelRightBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @function 新增一条记录
     * @param mixed $objModelRightInfo  ModelRight实例
     * @return 
     */
	public function insert(ModelRightInfo $objModelRightInfo)
	{
		$sql = "INSERT INTO `sys_model_right`(`model_id`,`right_name`,`right_value`,`right_remark`,`is_lock`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`)"
		." values(".$objModelRightInfo->iModelId.",'".$objModelRightInfo->strRightName."',".$objModelRightInfo->iRightValue.",'".$objModelRightInfo->strRightRemark."',".$objModelRightInfo->iIsLock.",".$objModelRightInfo->iIsDel.",".$objModelRightInfo->iCreateUid.",now(),".$objModelRightInfo->iUpdateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @function 根据ID更新一条记录
     * @param mixed $objModelRightInfo  ModelRight实例
     * @return
     */
	public function updateByID(ModelRightInfo $objModelRightInfo)
	{
		$sql = "update `sys_model_right` set `model_id`=".$objModelRightInfo->iModelId.",`right_name`='".$objModelRightInfo->strRightName."',`right_value`=".$objModelRightInfo->iRightValue.",`right_remark`='".$objModelRightInfo->strRightRemark."',`is_lock`=".$objModelRightInfo->iIsLock.",`is_del`=".$objModelRightInfo->iIsDel.",`update_uid`=".$objModelRightInfo->iUpdateUid.",`update_time`=now() where right_id=".$objModelRightInfo->iRightId;
        //exit($sql);
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * @function 根据ID更新一条记录
	 * @param mixed $id 记录ID
     * @param mixed $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `sys_model_right` set is_del=1,update_uid=".$userID.",update_time=now() where right_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	
	
	/**
     * @function 返回数据
	 * @param mixed $sField 字段
	 * @param mixed $sWhere 不用加 where	
	 * @param mixed $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder)
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    } 
				
	/**
     * @function 返回TOP数据
	 * @param mixed $sField 字段
	 * @param mixed $sWhere 不用加 where	
	 * @param mixed $sOrder 无order  by 关键字的排序语句
	 * @param mixed $sGroup group  by 关键字的分组
	 * @param mixed $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_ModelRight::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " order by right_value";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_model_right` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        //exit($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @function 根据ID,返回一个sys_model_right对象
	 * @param mixed $id 
     * @return sys_model_right对象
     */
	public function getModelByID($id)
	{
		$objModelRightInfo = null;
		$arryInfo = self::select("*","right_id=".$id,"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objModelRightInfo = new ModelRightInfo();
			$objModelRightInfo->iRightId = $arryInfo[0]['right_id'];
			$objModelRightInfo->iModelId = $arryInfo[0]['model_id'];
			$objModelRightInfo->strRightName = $arryInfo[0]['right_name'];
			$objModelRightInfo->iRightValue = $arryInfo[0]['right_value'];
			$objModelRightInfo->strRightRemark = $arryInfo[0]['right_remark'];
			$objModelRightInfo->iIsLock = $arryInfo[0]['is_lock'];
			$objModelRightInfo->iIsDel = $arryInfo[0]['is_del'];
			$objModelRightInfo->iCreateUid = $arryInfo[0]['create_uid'];
			$objModelRightInfo->strCreateTime = $arryInfo[0]['create_time'];
			$objModelRightInfo->iUpdateUid = $arryInfo[0]['update_uid'];
			$objModelRightInfo->strUpdateTime = $arryInfo[0]['update_time'];
		
			settype($objModelRightInfo->iRightId,"integer");
			settype($objModelRightInfo->iModelId,"integer");			
			settype($objModelRightInfo->iRightValue,"integer");			
			settype($objModelRightInfo->iIsLock,"integer");
			settype($objModelRightInfo->iIsDel,"integer");
			settype($objModelRightInfo->iCreateUid,"integer");			
			settype($objModelRightInfo->iUpdateUid,"integer");
		}
		
		return $objModelRightInfo;
	}
}
?>