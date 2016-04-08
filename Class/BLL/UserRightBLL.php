<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_user_right的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/UserRightInfo.php';

class UserRightBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param UserRightInfo $objUserRightInfo  UserRight实例
     * @return 
     */
	public function insert(UserRightInfo $objUserRightInfo)
	{
		$sql = "INSERT INTO `sys_user_right`(`user_id`,`right_id`,`is_forbid`,`is_allow`,`create_uid`,`create_time`)"
		." values(".$objUserRightInfo->iUserId.",".$objUserRightInfo->iRightId.",".$objUserRightInfo->iIsForbid.",".$objUserRightInfo->iIsAllow.",".$objUserRightInfo->iCreateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param UserRightInfo $objUserRightInfo  UserRight实例
     * @return
     */
	public function updateByID(UserRightInfo $objUserRightInfo)
	{
		$sql = "update `sys_user_right` set `user_id`=".$objUserRightInfo->iUserId.",`right_id`=".$objUserRightInfo->iRightId.",`is_forbid`=".$objUserRightInfo->iIsForbid.",`is_allow`=".$objUserRightInfo->iIsAllow." where aid=".$objUserRightInfo->iAid;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	
    /**
     * @functional 删除用户权限
     */
    public function delete($userID,$rightID)
    {
        $sql = "delete from sys_user_right where user_id=$userID and right_id=$rightID";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
	/**
     * @functional 返回数据
	 * @param string $sField 字段
	 * @param string $sWhere 不用加 where	
	 * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder)
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
			$sField = T_UserRight::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder != "")
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_user_right` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_user_right对象
	 * @param int $id 
     * @return sys_user_right对象
     */
	public function getModelByID($id)
	{
		$objUserRightInfo = null;
		$arrayInfo = $this->select("*","aid=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objUserRightInfo = new UserRightInfo();
			$objUserRightInfo->iAid = $arrayInfo[0]['aid'];
			$objUserRightInfo->iUserId = $arrayInfo[0]['user_id'];
			$objUserRightInfo->iRightId = $arrayInfo[0]['right_id'];
			$objUserRightInfo->iIsForbid = $arrayInfo[0]['is_forbid'];
			$objUserRightInfo->iIsAllow = $arrayInfo[0]['is_allow'];
			$objUserRightInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objUserRightInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objUserRightInfo->iAid,"integer");
			settype($objUserRightInfo->iUserId,"integer");
			settype($objUserRightInfo->iRightId,"integer");
			settype($objUserRightInfo->iIsForbid,"integer");
			settype($objUserRightInfo->iIsAllow,"integer");
			settype($objUserRightInfo->iCreateUid,"integer");
			
		}
		
		return $objUserRightInfo;
	}
	
    
     /*-------------------------公司用户-----------begin----------------*/
    /**
     * @function 公司用户是否具有此权限
     * @return bool true 是 false 否
     */
    public function UserExistRight($userID,$rightID)
    {
        $sql = "select right_id from(
            select right_id,sum(is_forbid) as is_forbid 
            FROM(
            SELECT sys_post_right.right_id,0 as is_forbid FROM sys_user 
            INNER JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id) 
            INNER JOIN hr_dept_position ON (hr_employee.dept_position_id = hr_dept_position.dept_position_id) 
            INNER JOIN sys_post_right ON (hr_dept_position.post_id = sys_post_right.post_id) 
            where sys_user.user_id = $userID and sys_post_right.`right_id` = $rightID 
            union all 
            SELECT `sys_user_right`.`right_id`,sys_user_right.`is_forbid` FROM sys_user 
            INNER JOIN sys_user_right on (sys_user.user_id = sys_user_right.user_id) 
            where sys_user.user_id = $userID and sys_user_right.`right_id` = $rightID 
            ) t  group by t.right_id
            )tt where tt.is_forbid=0";
        
        $arrayRight = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        return (isset($arrayRight) && count($arrayRight)>0) ? true : false;
    }
    
    
    /**
     * @function 添加用户权限
     */
    public function AddUserRight($userID,$rightID,$updateUid)
    {
        $arrayRight = $this->select("is_forbid,is_allow"," user_id=$userID and right_id=$rightID","");
        if(isset($arrayRight) && count($arrayRight)>0)
        {
            $sql ="delete from sys_user_right where user_id=$userID and right_id=$rightID";
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
        if($this->UserExistRight($userID,$rightID) == true)
            return 1;
         
        $objUserRightInfo = new UserRightInfo();
        
        $objUserRightInfo->iUserId = $userID;
    	$objUserRightInfo->iRightId = $rightID;
    	$objUserRightInfo->iIsAllow = 1;
    	$objUserRightInfo->iIsForbid = 0;
        $objUserRightInfo->iCreateUid = $updateUid;

        return $this->insert($objUserRightInfo);
    }
    
    /**
     * @function 删除用户权限
     */
    public function DelUserRight($userID,$rightID,$updateUid)
    {        
        $arrayRight = $this->select("is_forbid,is_allow"," user_id=$userID and right_id=$rightID","");
        if(isset($arrayRight) && count($arrayRight)>0)
        {
            $sql ="delete from sys_user_right where user_id=$userID and right_id=$rightID";
            $this->objMysqlDB->executeNonQuery(false,$sql,null);
        }
        
        if($this->UserExistRight($userID,$rightID) == true)
        {
            $objUserRightInfo = new UserRightInfo();
        
            $objUserRightInfo->iUserId = $userID;
        	$objUserRightInfo->iRightId = $rightID;
        	$objUserRightInfo->iIsAllow = 0;
        	$objUserRightInfo->iIsForbid = 1;
            $objUserRightInfo->iCreateUid = $updateUid;
    
            return $this->insert($objUserRightInfo);
        } 
        //print_r();
        return 1;
    }
    
    
    
     /**
     * @functional 用户权限批量添加
     */
    public function AddRights($userID,$addRightIDs,$updateUid)
    {
        $iAddCount = 0;        
        if(strlen($addRightIDs)>0)
        {
            $arrayRightID = explode(",",$addRightIDs);
            $arrayLength = count($arrayRightID);
            
            for($i = 0;$i < $arrayLength; $i++)
            {                
               $iAddCount += $this->AddUserRight($userID,$arrayRightID[$i],$updateUid);
            }
        }
                
        return $iAddCount;
    }
     
     /**
     * @functional 用户权限批量删除
     */
    public function DelRights($userID,$delRightIDs,$updateUid)
    {
        $iDelCount = 0;
        if(strlen($delRightIDs)>0)
        {
            $arrayRightID = explode(",",$delRightIDs);
            $arrayLength = count($arrayRightID);
            for($i = 0;$i < $arrayLength; $i++)
            {                
               $iDelCount += $this->DelUserRight($userID,$arrayRightID[$i],$updateUid);
            }
        } 
        
        return $iDelCount;
    }
    
     /*-------------------------公司用户-----------end----------------*/
     /**
     * @function 代理商用户是否具有此权限
     * @return bool true 是 false 否
     */
    public function AgentUserExistRight($userID,$rightID)
    {
        $sql = "select right_id from(
            select right_id,sum(is_forbid) as is_forbid 
            FROM(
            SELECT sys_role_right.`right_id`,0 as is_forbid FROM  sys_user 
            INNER JOIN sys_user_role ON (sys_user.user_id = sys_user_role.user_id) 
            INNER JOIN sys_role_right ON (sys_user_role.role_id = sys_role_right.role_id)   
            where sys_user.user_id=$userID and sys_role_right.`right_id`=$rightID  
            union all   
            SELECT `sys_user_right`.`right_id`,sys_user_right.`is_forbid` FROM  sys_user 
            INNER JOIN sys_user_right on (sys_user.user_id = sys_user_right.user_id)   
            where sys_user.user_id=$userID and sys_user_right.`right_id`=$rightID
            ) t group by t.right_id
            )tt where tt.is_forbid=0";
        $arrayRight = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        return (isset($arrayRight) && count($arrayRight)>0) ? true : false;
    }
}
?>