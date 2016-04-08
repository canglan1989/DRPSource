<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_agroup_manager_detail的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-25 13:33:18
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgroupManagerDetailInfo.php';

class AgroupManagerDetailBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AgroupManagerDetailInfo $objAgroupManagerDetailInfo  AgroupManagerDetail实例
     * @return 
     */
	public function insert(AgroupManagerDetailInfo $objAgroupManagerDetailInfo)
	{
		$sql = "INSERT INTO `sys_agroup_manager_detail`(`agroup_manager_id`,`agroup_id`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`)"
		." values(".$objAgroupManagerDetailInfo->iAgroupManagerId.",".$objAgroupManagerDetailInfo->iAgroupId.",".$objAgroupManagerDetailInfo->iIsDel.",".$objAgroupManagerDetailInfo->iUpdateUid.",now(),".$objAgroupManagerDetailInfo->iCreateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param AgroupManagerDetailInfo $objAgroupManagerDetailInfo  AgroupManagerDetail实例
     * @return
     */
	public function updateByID(AgroupManagerDetailInfo $objAgroupManagerDetailInfo)
	{
		$sql = "update `sys_agroup_manager_detail` set `agroup_manager_id`=".$objAgroupManagerDetailInfo->iAgroupManagerId.",`agroup_id`=".$objAgroupManagerDetailInfo->iAgroupId.",`is_del`=".$objAgroupManagerDetailInfo->iIsDel.",`update_uid`=".$objAgroupManagerDetailInfo->iUpdateUid.",`update_time`= now() where agroup_manager_detail=".$objAgroupManagerDetailInfo->iAgroupManagerDetail;
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
		$sql = "update `sys_agroup_manager_detail` set is_del=1,update_uid=".$userID.",update_time=now() where agroup_manager_detail=".$id;
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
			$sField = T_AgroupManagerDetail::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_agroup_manager_detail` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_agroup_manager_detail对象
	 * @param int $id 
     * @return sys_agroup_manager_detail对象
     */
	public function getModelByID($id)
	{
		$objAgroupManagerDetailInfo = null;
		$arrayInfo = $this->select("*","agroup_manager_detail=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgroupManagerDetailInfo = new AgroupManagerDetailInfo();
			$objAgroupManagerDetailInfo->iAgroupManagerDetail = $arrayInfo[0]['agroup_manager_detail'];
			$objAgroupManagerDetailInfo->iAgroupManagerId = $arrayInfo[0]['agroup_manager_id'];
			$objAgroupManagerDetailInfo->iAgroupId = $arrayInfo[0]['agroup_id'];
			$objAgroupManagerDetailInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objAgroupManagerDetailInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objAgroupManagerDetailInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objAgroupManagerDetailInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAgroupManagerDetailInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objAgroupManagerDetailInfo->iAgroupManagerDetail,"integer");
			settype($objAgroupManagerDetailInfo->iAgroupManagerId,"integer");
			settype($objAgroupManagerDetailInfo->iAgroupId,"integer");
			settype($objAgroupManagerDetailInfo->iIsDel,"integer");
			settype($objAgroupManagerDetailInfo->iUpdateUid,"integer");			
			settype($objAgroupManagerDetailInfo->iCreateUid,"integer");			
		}
		
		return $objAgroupManagerDetailInfo;
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_agroup_manager_detail` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `sys_agroup_manager_detail` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
}
?>