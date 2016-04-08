<?php
/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 sys_unit_salereward_rate_model 的类业务逻辑层
 * 表描述：网盟充值返点比例模板 
 * 创建人：温智星
 * 添加时间：2012-09-17 14:15:41
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/UnitSalerewardRateModelInfo.php';

class UnitSalerewardRateModelBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
	/**
     * @functional 新增一条记录
     * @param $objUnitSalerewardRateModelInfo  UnitSalerewardRateModelInfo 实例
     * @return 
     */
	public function insert(UnitSalerewardRateModelInfo $objUnitSalerewardRateModelInfo)
	{
		$sql = "INSERT INTO `sys_unit_salereward_rate_model`(`model_name`,`product_id`,`model_type`,`model_remark`,`is_del`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`) 
        values('".$objUnitSalerewardRateModelInfo->strModelName."',".$objUnitSalerewardRateModelInfo->iProductId.",".$objUnitSalerewardRateModelInfo->iModelType.",'".$objUnitSalerewardRateModelInfo->strModelRemark."',".$objUnitSalerewardRateModelInfo->iIsDel.",".$objUnitSalerewardRateModelInfo->iCreateUid.",'".$objUnitSalerewardRateModelInfo->strCreateUserName."',now(),".$objUnitSalerewardRateModelInfo->iUpdateUid.",'".$objUnitSalerewardRateModelInfo->strUpdateUserName."',now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objUnitSalerewardRateModelInfo  UnitSalerewardRateModelInfo 实例
     * @return
     */
	public function updateByID(UnitSalerewardRateModelInfo $objUnitSalerewardRateModelInfo)
	{
	   $sql = "update `sys_unit_salereward_rate_model` set `model_name`='".$objUnitSalerewardRateModelInfo->strModelName."',`product_id`=".$objUnitSalerewardRateModelInfo->iProductId.",`model_type`=".$objUnitSalerewardRateModelInfo->iModelType.",`model_remark`='".$objUnitSalerewardRateModelInfo->strModelRemark."',`is_del`=".$objUnitSalerewardRateModelInfo->iIsDel.",`create_user_name`='".$objUnitSalerewardRateModelInfo->strCreateUserName."',`update_uid`=".$objUnitSalerewardRateModelInfo->iUpdateUid.",`update_user_name`='".$objUnitSalerewardRateModelInfo->strUpdateUserName."',`update_time`= now() where salereward_rate_model_id=".$objUnitSalerewardRateModelInfo->iSalerewardRateModelId;      
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
		$sql = "update `sys_unit_salereward_rate_model` set is_del=1,update_uid=".$userID.",update_time=now() where salereward_rate_model_id=".$id;
		if($this->objMysqlDB->executeNonQuery(false,$sql,null)>0)
        {            
            $sql = "delete from sys_unit_salereward_rate_model_detail where salereward_rate_model_id=".$id;
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
            
            return 1;
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
			$sField = T_UnitSalerewardRateModel::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `sys_unit_salereward_rate_model` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
    } 
    	
	/**
     * @functional 根据ID,返回一个 UnitSalerewardRateModelInfo 对象
	 * @param int $id 
     * @return UnitSalerewardRateModelInfo 对象
     */
	public function getModelByID($id)
	{
		$objUnitSalerewardRateModelInfo = null;
		$arrayInfo = $this->select("*","salereward_rate_model_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objUnitSalerewardRateModelInfo = new UnitSalerewardRateModelInfo();
            		
        
            $objUnitSalerewardRateModelInfo->iSalerewardRateModelId = $arrayInfo[0]['salereward_rate_model_id'];
            $objUnitSalerewardRateModelInfo->strModelName = $arrayInfo[0]['model_name'];
            $objUnitSalerewardRateModelInfo->iProductId = $arrayInfo[0]['product_id'];
            $objUnitSalerewardRateModelInfo->iModelType = $arrayInfo[0]['model_type'];
            $objUnitSalerewardRateModelInfo->strModelRemark = $arrayInfo[0]['model_remark'];
            $objUnitSalerewardRateModelInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objUnitSalerewardRateModelInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objUnitSalerewardRateModelInfo->strCreateUserName = $arrayInfo[0]['create_user_name'];
            $objUnitSalerewardRateModelInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objUnitSalerewardRateModelInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objUnitSalerewardRateModelInfo->strUpdateUserName = $arrayInfo[0]['update_user_name'];
            $objUnitSalerewardRateModelInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            settype($objUnitSalerewardRateModelInfo->iSalerewardRateModelId,"integer");
            settype($objUnitSalerewardRateModelInfo->iProductId,"integer");
            settype($objUnitSalerewardRateModelInfo->iModelType,"integer");
            settype($objUnitSalerewardRateModelInfo->iIsDel,"integer");
            settype($objUnitSalerewardRateModelInfo->iCreateUid,"integer");
            settype($objUnitSalerewardRateModelInfo->iUpdateUid,"integer");
            
        }
		return $objUnitSalerewardRateModelInfo;
       
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
        $offset   = ($iPageIndex-1)*$iPageSize;
        $sWhere = " is_del=0 ";
        if($strWhere != "")
            $sWhere .= $strWhere;
            
        if($strOrder == "")
            $strOrder = " create_time";
        
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_unit_salereward_rate_model` where ".$sWhere;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        $sqlData  = "SELECT ".T_UnitSalerewardRateModel::AllFields." FROM `sys_unit_salereward_rate_model` WHERE $sWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    
}
		 