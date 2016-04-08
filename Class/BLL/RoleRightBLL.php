<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_role_right的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-15 9:07:26
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/RoleRightInfo.php';

class RoleRightBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @function 新增一条记录
     * @param int $roleID  角色ID
     * @param int $rightID  权限ID
     * @param int $userID  操作人ID
     * @return 
     */
	public function insert($roleID,$rightID,$userID)
	{
		$sql = "INSERT INTO `sys_role_right`(`role_id`,`right_id`,`create_uid`,`create_time`) values($roleID,$rightID,$userID,now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @function 删除一条记录
     * @param int $roleID  角色ID
     * @param int $rightID  权限ID
     * @return
     */
	public function delete($roleID,$rightID)
	{
	   $sql = "SELECT DISTINCT sys_user.user_id,sys_user.agent_id,sys_user.finance_no 
       FROM sys_user INNER JOIN sys_user_role ON sys_user_role.user_id = sys_user.user_id 
        where sys_user.is_finance=1 and sys_user_role.role_id=$roleID and sys_user.is_del=0 and length(sys_user.finance_no)>2 ";
        $arrayFinanceUser = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
       
		$sql = "delete from `sys_role_right` where `role_id`=$roleID and `right_id`=$rightID";
        $updateCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        if($updateCount > 0)
        {
            $sql = "";
            foreach($arrayFinanceUser as $key=>$value)
            {
                $sql .= "delete from `sys_role_right` where `right_id`=$rightID and role_id in(
                    SELECT sys_role.role_id from sys_role where sys_role.agent_id = ".$value["agent_id"]
                    ." and sys_role.finance_no like '".$value["finance_no"]."%');";            
            }
            
            if(strlen($sql) > 0)
                $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
        
        return $updateCount;
	}
	
	/**
     * @function 返回数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere)
    {
        return self::selectTop($sField, $sWhere, -1);
    } 
				
	/**
     * @function 返回TOP数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
	 * @param string $sGroup group  by 关键字的分组
	 * @param int $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_RoleRight::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		        
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_role_right` ".$sWhere.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @function 根据ID,返回一个sys_role_right对象
	 * @param int $id 
     * @return sys_role_right对象
     */
	public function getModelByID($id)
	{
		$objRoleRightInfo = null;
		$arrayInfo = self::select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objRoleRightInfo = new RoleRightInfo();
			$objRoleRightInfo->iAid = $arrayInfo[0]['aid'];
			$objRoleRightInfo->iRoleId = $arrayInfo[0]['role_id'];
			$objRoleRightInfo->iRightId = $arrayInfo[0]['right_id'];
			$objRoleRightInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objRoleRightInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objRoleRightInfo->iAid,"integer");
			settype($objRoleRightInfo->iRoleId,"integer");
			settype($objRoleRightInfo->iRightId,"integer");
			settype($objRoleRightInfo->iCreateUid,"integer");			
		}
		
		return $objRoleRightInfo;
	}
    
    /**
     * @function 删除角色权限
     * @param int $roleID  角色ID
     * @return
     */
	public function DelRights($roleID,$delRightIDs,$updateUid)
	{
	    $iDelCount = 0;        
        if(strlen($delRightIDs)>0)
        {
            $arrayRightID = explode(",",$delRightIDs);
            $arrayLength = count($arrayRightID);
            
            for($i = 0;$i < $arrayLength; $i++)
            {                
               $iDelCount += $this->delete($roleID,$arrayRightID[$i]);
            }
        }
                
        return $iDelCount;
        
	}
    
    /**
     * @function 添加角色权限
     * @param int $roleID  角色ID
     * @return
     */
    public function AddRights($roleID,$addRightIDs,$updateUid)
	{
	   $iAddCount = 0;        
        if(strlen($addRightIDs)>0)
        {
            $arrayRightID = explode(",",$addRightIDs);
            $arrayLength = count($arrayRightID);
            
            for($i = 0;$i < $arrayLength; $i++)
            {                
               $iAddCount += self::insert($roleID,$arrayRightID[$i],$updateUid);
            }
        }
                
        return $iAddCount;
    }
    
}
?>
