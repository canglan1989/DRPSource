<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_role的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/RoleInfo.php';
require_once __DIR__.'/../BLL/RoleRightBLL.php';

class RoleBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param $objRoleInfo  RoleInfo 实例
     * @return 
     */
	public function insert(RoleInfo $objRoleInfo)
	{
		$sql = "INSERT INTO `sys_role`(`role_name`,`role_remark`,`agent_id`,`role_type`,`is_system`,`sort_index`,`is_lock`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`,`finance_uid`,`finance_no`,`is_finance`) 
        values('".$objRoleInfo->strRoleName."','".$objRoleInfo->strRoleRemark."',".$objRoleInfo->iAgentId.",".$objRoleInfo->iRoleType.",".$objRoleInfo->iIsSystem.",".$objRoleInfo->iSortIndex.",".$objRoleInfo->iIsLock.",".$objRoleInfo->iIsDel.",".$objRoleInfo->iCreateUid.",now(),".$objRoleInfo->iUpdateUid.",now(),".$objRoleInfo->iFinanceUid.",'".$objRoleInfo->strFinanceNo."',".$objRoleInfo->iIsFinance.")";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;            
	}

	/**
     * @functional 根据ID更新一条记录
     * @param $objRoleInfo  RoleInfo 实例
     * @return
     */
	public function updateByID(RoleInfo $objRoleInfo)
	{
	   $sql = "update `sys_role` set `role_name`='".$objRoleInfo->strRoleName."',`role_remark`='".$objRoleInfo->strRoleRemark."',`agent_id`=".$objRoleInfo->iAgentId.",`role_type`=".$objRoleInfo->iRoleType.",`is_system`=".$objRoleInfo->iIsSystem.",`sort_index`=".$objRoleInfo->iSortIndex.",`is_lock`=".$objRoleInfo->iIsLock.",`is_del`=".$objRoleInfo->iIsDel.",`update_uid`=".$objRoleInfo->iUpdateUid.",`update_time`= now(),`finance_uid`=".$objRoleInfo->iFinanceUid.",`finance_no`='".$objRoleInfo->strFinanceNo."',`is_finance`=".$objRoleInfo->iIsFinance." where role_id=".$objRoleInfo->iRoleId;      
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
		$sql = "update `sys_role` set is_del=1,update_uid=".$userID.",update_time=now() where role_id=".$id;
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
			$sField = T_Role::AllFields;
		
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
			
		$sql = "SELECT ".$sField." FROM `sys_role` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个 RoleInfo 对象
	 * @param int $id 
     * @return RoleInfo 对象
     */
	public function getModelByID($id,$agentID=0)
	{
		$objRoleInfo = null;
		$arrayInfo = $this->select("*","role_id=".$id.($agentID > 0?(" and agent_id=".$agentID):""),"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objRoleInfo = new RoleInfo();
			$objRoleInfo->iRoleId = $arrayInfo[0]['role_id'];
			$objRoleInfo->strRoleName = $arrayInfo[0]['role_name'];
			$objRoleInfo->strRoleRemark = $arrayInfo[0]['role_remark'];
			$objRoleInfo->iAgentId = $arrayInfo[0]['agent_id'];
			$objRoleInfo->iRoleType = $arrayInfo[0]['role_type'];
			$objRoleInfo->iIsSystem = $arrayInfo[0]['is_system'];
			$objRoleInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objRoleInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objRoleInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objRoleInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objRoleInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objRoleInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objRoleInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objRoleInfo->iFinanceUid = $arrayInfo[0]['finance_uid'];
            $objRoleInfo->strFinanceNo = $arrayInfo[0]['finance_no'];
            $objRoleInfo->iIsFinance = $arrayInfo[0]['is_finance'];
            settype($objRoleInfo->iRoleId,"integer");
            settype($objRoleInfo->iAgentId,"integer");
            settype($objRoleInfo->iRoleType,"integer");
            settype($objRoleInfo->iIsSystem,"integer");
            settype($objRoleInfo->iSortIndex,"integer");
            settype($objRoleInfo->iIsLock,"integer");
            settype($objRoleInfo->iIsDel,"integer");
            settype($objRoleInfo->iCreateUid,"integer");
            settype($objRoleInfo->iUpdateUid,"integer");
            settype($objRoleInfo->iFinanceUid,"integer");
            settype($objRoleInfo->iIsFinance,"integer");
		}
		
		return $objRoleInfo;
	}
	
    /**
     * @functional 分页组装数据 (wzx 2011.07.18 暂时不做分页)
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strPageFields
	 * @param string $strWhere
	 * @param string $strOrder
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'*','WHERE','ORDER BY',$c));
    */
	public function selectPaged($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
		//组装sql语句
        $sqlCount = "SELECT COUNT(1) AS `counts` FROM `sys_role` WHERE $strWhere";
        $arrCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        $sqlData  = "SELECT $strPageFields FROM `sys_role` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        $arrData  = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
        $iRecordCount = $arrCount; 
        return $arrData;
	}
    
    /**
    * @functional 代理商角色列表 加了用户名
    */
    public function AgentRoleList($iAgentID,$finance_no)
    {
        $sql = "select ttt.`role_id`,ttt.`role_name`,ttt.`role_remark`,ttt.`agent_id`,ttt.`is_lock`,ttt.`sort_index`,ttt.`is_del`,ttt.role_type,ttt.is_system,
        ttt.`update_uid`,ttt.`update_time`,ttt.`create_uid`,ttt.`create_time`,ttt.finance_user_name,ttt.is_finance,ttt.finance_uid,ttt.finance_level,tt.user_name from 
        (select sys_role.`role_id`,`role_name`,`role_remark`,`agent_id`,`is_lock`,`sort_index`,`is_del`,role_type,is_system,
                `update_uid`,`update_time`,`create_uid`,`create_time`,'' as finance_user_name,sys_role.is_finance,0 as finance_uid,1 as finance_level from sys_role where sys_role.is_del = 0 and agent_id=0";
        
        if($finance_no != '10')
        {
            $sql .= " and role_type <> 100 ";//Admin
        }
        
        $sql .= " and is_system=1 
        union all select sys_role.`role_id`,sys_role.`role_name`,sys_role.`role_remark`,sys_role.`agent_id`,
        sys_role.`is_lock`,sys_role.`sort_index`,sys_role.`is_del`,sys_role.role_type,sys_role.is_system,
        sys_role.`update_uid`,sys_role.`update_time`,sys_role.`create_uid`,sys_role.`create_time`,sys_user.user_name as finance_user_name,sys_role.is_finance,sys_role.finance_uid, 
        if(sys_role.finance_no='{$finance_no}',1,0) as finance_level from sys_role 
        inner join sys_user on sys_user.user_id = sys_role.finance_uid and sys_user.is_del=0 where sys_role.is_del = 0 
        and sys_role.agent_id = $iAgentID and sys_role.finance_no like '{$finance_no}%' 
        ) ttt 
        left join 
        ( 
            select t.role_id,GROUP_CONCAT(t.user_name) as user_name from (
                select sys_user_role.role_id,CONCAT(sys_user.user_name,'(',sys_user.e_name,')') as user_name from sys_user inner join 
                `sys_user_role` on sys_user_role.user_id = sys_user.user_id where sys_user_role.agent_id = $iAgentID and sys_user.is_del=0 and sys_user.finance_no like '{$finance_no}%'
                group by sys_user_role.role_id,sys_user.user_name,sys_user.e_name order by sys_user.user_name 
            )t group by t.role_id 
        )tt 
        on tt.role_id = ttt.role_id order by ttt.finance_level desc,ttt.finance_user_name,ttt.role_name
        where 1=1 ;";

        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    
    /**
     * @functional 分页组装数据 (wzx 2011.07.18 暂时不做分页)
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strPageFields
	 * @param string $strWhere
	 * @param string $strOrder
	 * @param int $iRecordCount
	 * @desc $rtn = $obj->selectPaged(1,20,'*','WHERE','ORDER BY',$c));
    */
	public function selectPaged2($iPageIndex,$iPageSize,$iAgentID,$strWhere,$finance_no,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
		//组装sql语句
        $sql = "SELECT COUNT(1) AS `counts` FROM (
        select sys_role.`role_id`,`role_name`,0 as finance_uid from sys_role where sys_role.is_del = 0 and agent_id=0 ";
        
        if($finance_no != '10')
        {
            $sql .= " and role_type <> 100 ";//Admin
        }
        
        $sql .= " and is_system=1 
        union all 
        select sys_role.`role_id`,sys_role.`role_name`,sys_role.finance_uid from sys_role 
        where sys_role.agent_id = $iAgentID and sys_role.finance_no like '{$finance_no}%' 
        ) as ttt WHERE 1=1 $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sql,null);
        
        $sql = "select ttt.`role_id`,ttt.`role_name`,ttt.`role_remark`,ttt.`agent_id`,ttt.`is_lock`,ttt.`sort_index`,ttt.`is_del`,ttt.role_type,ttt.is_system,
        ttt.`update_uid`,ttt.`update_time`,ttt.`create_uid`,ttt.create_user_name,ttt.`create_time`,ttt.finance_user_name,ttt.is_finance,ttt.finance_uid,ttt.finance_level,tt.user_name from 
        (select sys_role.`role_id`,`role_name`,`role_remark`,`agent_id`,`is_lock`,`sort_index`,`is_del`,role_type,is_system,
                `update_uid`,`update_time`,`create_uid`,'' as create_user_name,`create_time`,'' as finance_user_name,sys_role.is_finance,0 as finance_uid,1 as finance_level from sys_role where sys_role.is_del = 0 and agent_id=0";
        
        if($finance_no != '10')
        {
            $sql .= " and role_type <> 100 ";//Admin
        }
        
        $sql .= " and is_system=1 
        union all select sys_role.`role_id`,sys_role.`role_name`,sys_role.`role_remark`,sys_role.`agent_id`,
        sys_role.`is_lock`,sys_role.`sort_index`,sys_role.`is_del`,sys_role.role_type,sys_role.is_system,
        sys_role.`update_uid`,sys_role.`update_time`,sys_role.`create_uid`,
        CONCAT(create_user.user_name,' ',create_user.e_name) as create_user_name,
        sys_role.`create_time`,CONCAT(sys_user.user_name,' ',sys_user.e_name) as finance_user_name,sys_role.is_finance,sys_role.finance_uid, 
        if(sys_role.finance_no='{$finance_no}',1,0) as finance_level from sys_role 
        left join sys_user create_user on create_user.user_id = sys_role.create_uid 
        inner join sys_user on sys_user.user_id = sys_role.finance_uid and sys_user.is_del=0 where sys_role.is_del = 0 
        and sys_role.agent_id = $iAgentID and sys_role.finance_no like '{$finance_no}%' 
        ) ttt 
        left join 
        ( 
            select t.role_id,GROUP_CONCAT(t.user_name) as user_name from (
                select sys_user_role.role_id,CONCAT(sys_user.user_name,'(',sys_user.e_name,')') as user_name from sys_user inner join 
                `sys_user_role` on sys_user_role.user_id = sys_user.user_id where sys_user_role.agent_id = $iAgentID and sys_user.is_del=0 and sys_user.finance_no like '{$finance_no}%'
                group by sys_user_role.role_id,sys_user.user_name,sys_user.e_name order by sys_user.user_name 
            )t group by t.role_id 
        )tt 
        on tt.role_id = ttt.role_id where 1=1 $strWhere order by ttt.finance_level desc,ttt.finance_user_name,ttt.role_name;";

        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
	}
    
    
    /**
     * @functional 取得角色权限 列出权限列表 用户具有的权限 is_check 标记为 1
     */
    public function selectRoleRight($rootModelGroupNo,$roleID,$iAgentID)
    {
        $arrayRole = $this->getRoleRight($rootModelGroupNo,$roleID,$iAgentID);
        $this->ConstraintRole($roleID,$arrayRole,$rootModelGroupNo);
        return $arrayRole;
    }
    
    private function getRoleRight($rootModelGroupNo,$roleID,$iAgentID)
    {
        $sWhere = "";
        if($rootModelGroupNo != "")
            $sWhere = " and left(sys_model_group.`mgroup_no`,2) = '$rootModelGroupNo'";
        
        $sql = "SELECT * from (SELECT sys_model_group.`mgroup_id`,sys_model_group.mgroup_name,sys_model_group.`mgroup_no`,sys_model.model_id,
        sys_model.model_name,sys_model_right.right_name,sys_model_right.right_id,sys_model_right.right_remark,
            if(sys_model_group.`is_lock`+`sys_model`.`is_lock`+sys_model_right.`is_lock`,1,0) as is_lock,
            if(t.right_id,1,0) as is_check,
            concat(left(sys_model_group.`mgroup_no`,length(sys_model_group.`mgroup_no`)-2),sys_model_group.`sort_index`) as model_group_mgroup_no,
          sys_model_group.`sort_index` as sys_model_group_sort_index,sys_model.`sort_index` as sys_model_sort_index,sys_model_right.`right_value` as sys_model_right_right_value
            FROM sys_model_group 
            INNER JOIN 
            sys_model ON (sys_model.mgroup_id = sys_model_group.mgroup_id) 
            INNER JOIN sys_model_right ON (sys_model.model_id = sys_model_right.model_id) 
            left join ( 
                select sys_role_right.`right_id` from sys_role_right 
                INNER JOIN sys_role ON sys_role.role_id = sys_role_right.role_id 
                WHERE sys_role.`is_del`=0 and  sys_role.`role_id`= $roleID 
            ) t on t.right_id = sys_model_right.`right_id` 
            WHERE sys_model.`product_type_ids` = '' and 
          sys_model.is_agent = 1 and sys_model_group.is_del=0 and sys_model_group.is_lock = 0 and 
          sys_model.is_del=0 and sys_model.is_lock = 0 and sys_model_right.is_del=0 and sys_model_right.is_lock=0 $sWhere 
          union all 
          SELECT distinct sys_model_group.`mgroup_id`,sys_model_group.mgroup_name,sys_model_group.`mgroup_no`,sys_model.model_id,
            sys_model.model_name,sys_model_right.right_name,sys_model_right.right_id,sys_model_right.right_remark,
            if(sys_model_group.`is_lock`+`sys_model`.`is_lock`+sys_model_right.`is_lock`,1,0) as is_lock,
            if(t.right_id,1,0) as is_check,
            concat(left(sys_model_group.`mgroup_no`,length(sys_model_group.`mgroup_no`)-2),sys_model_group.`sort_index`) as model_group_mgroup_no,
          sys_model_group.`sort_index` as sys_model_group_sort_index,sys_model.`sort_index` as sys_model_sort_index,sys_model_right.`right_value` as sys_model_right_right_value
            FROM sys_model_group 
            INNER JOIN 
            sys_model ON (sys_model.mgroup_id = sys_model_group.mgroup_id) 
            INNER JOIN sys_model_right ON (sys_model.model_id = sys_model_right.model_id) 
            inner join `v_am_agent_pact_product` as agent_pact on (agent_pact.agent_id = $iAgentID 
            and sys_model.`product_type_ids` like concat('%,',`agent_pact`.`product_type_id`,',%')) 
            left join (
                select sys_role_right.`right_id` from sys_role_right 
                INNER JOIN sys_role ON sys_role.role_id = sys_role_right.role_id 
                WHERE sys_role.`is_del`=0 and  sys_role.`role_id`= $roleID 
            ) t on t.right_id = sys_model_right.`right_id` 
            WHERE sys_model.`product_type_ids` <> '' and 
          sys_model.is_agent = 1 and sys_model_group.is_del=0 and sys_model_group.is_lock = 0 and 
          sys_model.is_del=0 and sys_model.is_lock = 0 and sys_model_right.is_del=0 and sys_model_right.is_lock=0 $sWhere 
          )tt 
          order by model_group_mgroup_no,sys_model_group_sort_index,sys_model_sort_index,sys_model_right_right_value ";
            
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * @functional 取得用户角色 列出角色列表 用户具有的角色 is_check 标记为 1
     */
    public function getAgentUserRole($iAgentID,$iUserID,$financeUid,$isFinance=-1)
    {
        if($iAgentID <= 0)
            return "";
        $sWhere = "";
        if($isFinance != -1)
             $sWhere = " and sys_role.is_finance=".$isFinance;
             
        $financeNo = "10";        
        $sql = "SELECT finance_no from sys_user where user_id=$financeUid";
        
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData)&&count($arrayData) > 0)
             $financeNo = $arrayData[0]["finance_no"];
             
        $sql = "SELECT sys_role.role_id,sys_role.role_name,if(sys_user_role.`aid`,1,0) as is_check FROM  sys_role 
         left JOIN sys_user_role ON (sys_role.role_id = sys_user_role.role_id and sys_user_role.`user_id`=".$iUserID
         .") where sys_role.`is_lock`=0 and sys_role.`is_del` =0 $sWhere and ((sys_role.`agent_id`="
         .$iAgentID." and sys_role.finance_uid={$financeUid}) or (is_system=1 ".(($financeNo=="10")?"":" and role_type<>100").")) order by sys_role.`sort_index`,sys_role.role_name";
       
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
        
    /**
     * @functional 管理员角色ID
     */
    public function GetAdminRoleID()
    {
        $sql = "select role_id from `sys_role` where role_type = 100 and is_system=1 and is_del=0";
        $iRoleID = $this->objMysqlDB->executeAndReturn(false,$sql,null);
        return $iRoleID;
    }
        
        
    /**
     * @functional 管理员角色ID
     */
    public function GetFinanceRoleID()
    {
        $sql = "select role_id from `sys_role` where role_type = 99 and is_system=1 and is_del=0";
        $iRoleID = $this->objMysqlDB->executeAndReturn(false,$sql,null);
        return $iRoleID;
    }
    
        
    /**
     * @functional 引角色为系统角色
     */
    public function IsSystemRole($roleID)
    {
        $sql = "select role_id from `sys_role` where role_id = $roleID and is_system=1 and is_del=0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
        if(isset($arrayData)&&count($arrayData)>0)
            return true;
            
        return false;
    }
    
    
    /**
     * @functional 将代理商用户添加管理员角色 一般用在账号开通时
	 * @param int $iAgentID 代理商ID
	 * @param int $iUserID 用户ID
	 * @param int $updateUid 添加人ID
     */
    public function AddUserToAdminRole($iAgentID,$iUserID,$updateUid)
    {        
        if($iAgentID <= 0 || $iUserID<=0)
            return "";
            
        $sql = "INSERT INTO `sys_user_role`(`user_id`,`role_id`,`agent_id`,`create_uid`,`create_time`)"
		." values(".$iUserID.",".$this->GetAdminRoleID().",".$iAgentID.",".$updateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
            
    }
    
    /**
     * @functional 代理商删除
     * @param string $agentIDs 代理商ID
     */
    public function DelAgentRole($agentIDs)
    {
        if(strlen($agentIDs)>0)
        {
            $arrayAgentID = explode(",",$agentIDs);
            $arrayLength = count($arrayAgentID);
            $sql = "";
            for($i = 0;$i < $arrayLength; $i++)
            { 
                if($arrayAgentID[$i] != "0" && $arrayAgentID[$i] != "")
                    continue;
                //删除代理商角色表
                $sql .= "delete from `sys_role_right` where `role_id` in(select role_id from `sys_role` where `agent_id`=".$arrayAgentID[$i].");";
                //删除代理商角色权限表 `role_id`
                $sql .= "delete from `sys_role` where `agent_id`=".$arrayAgentID[$i].";";
                //删除代理商账号
            	$sql .= "update sys_user set is_del=1 where agent_id=".$arrayAgentID[$i].";";
            }
            
            if(strlen($sql) > 0)
                return $this->objMysqlDB->executeNonQuery(false, $sql, null);
            else
                return 0;
        }
    }
    
    private function ConstraintRole($roleID,&$arrayRole,$rootModelGroupNo="")
    {
        if(count($arrayRole) == 0)
            return ;
        //如果是一级的财务帐户角色
        $sql = "SELECT agent_id,finance_uid,finance_no FROM sys_role where role_id = $roleID and is_finance=1 
             and length(finance_no) = 2";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
        if(isset($arrayData)&&count($arrayData)>0)
        {
            $arrayData[0]["role_id"] = $this->GetFinanceRoleID();
        }
        else
        {
            $sql = "SELECT sys_user_role.role_id,sys_role.agent_id,sys_role.is_finance,sys_role.finance_uid,sys_role.finance_no FROM sys_user_role 
            INNER JOIN sys_role ON sys_user_role.user_id = sys_role.finance_uid where sys_role.role_id = $roleID 
            and length(sys_role.finance_no) > 2";
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null); 
        }
               
        if(isset($arrayData)&&count($arrayData)>0)
        {            
            $ids = "0";
            $arrayFinanceRole = $this->getRoleRight($rootModelGroupNo,$arrayData[0]["role_id"],$arrayData[0]["agent_id"]);
            foreach($arrayFinanceRole as $key => $value)
            {
                if($value["is_check"] != 1)
                    $ids .= ",".$value["right_id"];
            }
            
            if(strlen($ids) == 1)
                return ;
            
            $ids .= ",";
            
            $aTemp = array();
            foreach($arrayRole as $key => $value)
            {
               $aTemp[$key] = $value;
            }
            $arrayRole = array();
            foreach($aTemp as $key => $value)
            {
                if(strpos($ids,$value["right_id"])>0)
                {
                    $aTemp[$key] = null;
                    unset($aTemp[$key]);
                }
            }
            
            $i = 0;
            foreach($aTemp as $key => $value)
            {
                $arrayRole[$i++] = $aTemp[$key];
            }
            $aTemp = null;
            unset($aTemp);
        }
    }
}
?>