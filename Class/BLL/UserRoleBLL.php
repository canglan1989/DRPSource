<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_user_role的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/UserRoleInfo.php';

class UserRoleBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param UserRoleInfo $objUserRoleInfo  UserRole实例
     * @return 
     */
	public function insert(UserRoleInfo $objUserRoleInfo)
	{
		$sql = "INSERT INTO `sys_user_role`(`user_id`,`role_id`,`agent_id`,`create_uid`,`create_time`)"
		." values(".$objUserRoleInfo->iUserId.",".$objUserRoleInfo->iRoleId.",".$objUserRoleInfo->iAgentId.",".$objUserRoleInfo->iCreateUid.",now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param UserRoleInfo $objUserRoleInfo  UserRole实例
     * @return
     */
	public function updateByID(UserRoleInfo $objUserRoleInfo)
	{
		$sql = "update `sys_user_role` set `user_id`=".$objUserRoleInfo->iUserId.",`role_id`=".$objUserRoleInfo->iRoleId.",`agent_id`=".$objUserRoleInfo->iAgentId." where aid=".$objUserRoleInfo->iAid;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
	 * @param mixed $id 记录ID
     * @param mixed $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `sys_user_role` set is_del=1,update_uid=".$userID.",update_time=".strtotime("now")." where aid=".$id;
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
			$sField = T_UserRole::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_user_role` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_user_role对象
	 * @param int $id 
     * @return sys_user_role对象
     */
	public function getModelByID($id)
	{
		$objUserRoleInfo = null;
		$arrayInfo = $this->select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objUserRoleInfo = new UserRoleInfo();
			$objUserRoleInfo->iAid = $arrayInfo[0]['aid'];
			$objUserRoleInfo->iUserId = $arrayInfo[0]['user_id'];
			$objUserRoleInfo->iRoleId = $arrayInfo[0]['role_id'];
			$objUserRoleInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objUserRoleInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objUserRoleInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objUserRoleInfo->iAid,"integer");
			settype($objUserRoleInfo->iUserId,"integer");
			settype($objUserRoleInfo->iRoleId,"integer");
			settype($objUserRoleInfo->iAgentId,"integer");
			settype($objUserRoleInfo->iCreateUid,"integer");
		}
		
		return $objUserRoleInfo;
	}
	
    
	/**
     * @functional 角色能否删除
     * @return true 可以 false 不行
     */
    public function CanDel($iRoleID)
    {
        $sql = "select 1 from sys_role where role_id=$iRoleID and is_system=0 and role_type=0";
        if(count($this->objMysqlDB->fetchAllAssoc(false,$sql,null)) > 0)
        {                
            $sql = "SELECT 1 FROM `sys_user_role` inner join sys_user on sys_user.user_id = sys_user_role.user_id 
            where sys_user_role.role_id=$iRoleID and sys_user.agent_id>0 and sys_user.is_del = 0 ";
            if(count($this->objMysqlDB->fetchAllAssoc(false,$sql,null)) > 0)
                return false;
            else
                return true;
        }
        
        return false;            
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
		if ($strWhere != "")
       		 $strWhere = " where ".$strWhere;
				
		if ($strOrder != "")
       		 $strOrder = " ORDER BY ".$strOrder;
			
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_user_role` $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `sys_user_role` $strWhere $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
      
             
    /**
     * @functional 删除代理商用户角色
     */
    public function DelRoles($userID,$agentID = 0)
    {
        if($userID <= 0 )
            return false;
            
        $sql = "DELETE from `sys_user_role` where `user_id`= $userID".($agentID > 0?" and agent_id=$agentID":"");
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);        
    }
              
    /**
     * @functional 添加代理商用户角色
     */
    public function AddRoles($userID,$agentID,$strRoleIDs,$updateUid)
    {
        if($userID <= 0 || $agentID <= 0 || strlen($strRoleIDs) == 0)
            return false;
            
        $objUserRoleBLL = new UserRoleBLL();
        $bHaveAddData = false;
        $arrayRoleID = explode(",",$strRoleIDs);
        $arrayLength = count($arrayRoleID);
        $sql = "INSERT INTO `sys_user_role`(`user_id`,`role_id`,`agent_id`,`create_uid`,`create_time`) values ";
        for($i = 0;$i < $arrayLength; $i++)
        {
            if(count($objUserRoleBLL->select("1","`user_id`=$userID and `role_id`=$arrayRoleID[$i]","")) > 0)//未找到角色才进行添加
                continue;
                
            $sql .= "($userID,$arrayRoleID[$i],$agentID,$updateUid,now()),";
            
            $bHaveAddData = true;
        }
        $iAddCount = 0;
        
        if($bHaveAddData)
        {
            $sql = substr($sql,0,strlen($sql)-1);             
            $sql .= ";";
            $iAddCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);            
        }
        
        return $iAddCount;
    }  
    
    
    /**
     * @functional 用户是否为管理员
     */
    public function UserIsAdmin($userID)
    {
        $sql = "select 1 from sys_user_role inner join sys_role on sys_role.role_id = sys_user_role.role_id 
         where sys_user_role.user_id = $userID and sys_role.role_type=100 and sys_role.is_system=1 
         and sys_role.is_lock=0 and sys_role.is_del=0 ";
         
        $arrayData =$this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            return true;
        else
            return false;
    }
    
}
?>