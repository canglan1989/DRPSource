<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_user_area的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-8-31 16:52:20
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/UserAreaInfo.php';

class UserAreaBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param UserAreaInfo $objUserAreaInfo  UserArea实例
     * @return 
     */
	public function insert(UserAreaInfo $objUserAreaInfo)
	{
		$sql = "INSERT INTO `sys_user_area`(`agroup_user_id`,`area_group_id`,`is_del`,`update_uid`,`create_uid`,`update_time`,`create_time`)"
		." values(".$objUserAreaInfo->iAgroupUserId.",".$objUserAreaInfo->iAreaGroupId.",".$objUserAreaInfo->iIsDel.",".$objUserAreaInfo->iUpdateUid.",".$objUserAreaInfo->iCreateUid.",now(),now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param UserAreaInfo $objUserAreaInfo  UserArea实例
     * @return
     */
	public function updateByID(UserAreaInfo $objUserAreaInfo)
	{
		$sql = "update `sys_user_area` set `agroup_user_id`=".$objUserAreaInfo->iAgroupUserId.",`area_group_id`=".$objUserAreaInfo->iAreaGroupId.",`is_del`=".$objUserAreaInfo->iIsDel.",`update_uid`=".$objUserAreaInfo->iUpdateUid.",`update_time`= now() where user_areagroup_id=".$objUserAreaInfo->iUserAreagroupId;
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
		$sql = "update `sys_user_area` set is_del=1,update_uid=".$userID.",update_time=now() where user_areagroup_id=".$id;
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
			$sField = T_UserArea::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " order by agroup_user_id";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_user_area` ".$sWhere.$sOrder.$sGroup.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_user_area对象
	 * @param int $id 
     * @return sys_user_area对象
     */
	public function getModelByID($id)
	{
		$objUserAreaInfo = null;
		$arrayInfo = $this->select("*","user_areagroup_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objUserAreaInfo = new UserAreaInfo();
			$objUserAreaInfo->iUserAreagroupId = $arrayInfo[0]['user_areagroup_id'];
			$objUserAreaInfo->iAgroupUserId = $arrayInfo[0]['agroup_user_id'];
			$objUserAreaInfo->iAreaGroupId = $arrayInfo[0]['area_group_id'];
			$objUserAreaInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objUserAreaInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objUserAreaInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objUserAreaInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objUserAreaInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objUserAreaInfo->iUserAreagroupId,"integer");
			settype($objUserAreaInfo->iAgroupUserId,"integer");
			settype($objUserAreaInfo->iAreaGroupId,"integer");
			settype($objUserAreaInfo->iIsDel,"integer");
			settype($objUserAreaInfo->iUpdateUid,"integer");
			settype($objUserAreaInfo->iCreateUid,"integer");
			
			
		}
		
		return $objUserAreaInfo;
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_user_area` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `sys_user_area` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    /**
     * @functional 账号组绑定区域
     * @param int $id:account_group_user_id(账号组里面绑定的用户的ID)
    */
    public function AreaBind($id,$area="",$uid)//先删除后添加绑定account_group_user_id
    {
        $updateCount = 0;
        $objUserAreaInfo = new UserAreaInfo();
        
        $sql = "delete from `sys_user_area` where agroup_user_id=$id";   //先删除原有区域的绑定-
        $f = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        if($area == "")
            $area = "''";
        $sqlarea_name = "select group_concat(agroup_name) from sys_area_group where agroup_id in($area) and is_del=0";
        //exit($sql1);
        $agroup_name = $this->objMysqlDB->executeAndReturn(false,$sqlarea_name,null);
        
        $sqlUpdate = "update sys_account_group_user set area_group_name='$agroup_name' where account_group_user_id=$id";
        $this->objMysqlDB->executeNonQuery(false,$sqlUpdate,null);
    
        
        if(strlen($area) > 0)
        {
            $area = explode(",",$area);
            $arrayLength = count($area); 
            for($i = 0;$i < $arrayLength; $i++)
            {  
                $objUserAreaInfo->iAgroupUserId = $id;
                $objUserAreaInfo->iCreateUid = $uid;
                $objUserAreaInfo->iAreaGroupId = $area[$i];
                $updateCount += $this->insert($objUserAreaInfo);
                
            }
        }
        return $updateCount;
    }
}
?>
