<?PHP

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_user的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 8:41:40
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/UserInfo.php';
require_once __DIR__ . '/../../Class/BLL/UserRoleBLL.php';
require_once __DIR__ . '/../../WebService/CRM_Service.php';
require_once __DIR__ . '/../../Config/PublicEnum.php';

class UserBLL extends BLLBase
{

    public function __construct()
    {
	   parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objUserInfo  UserInfo 实例
     * @return 
     */
    public function insert(UserInfo $objUserInfo,$bToCRM = false)
    {
		$sql = "INSERT INTO `sys_user`(`agent_id`,`e_uid`,`e_name`,`user_no`,`user_name`,`user_pwd`,`dept_name`,`tel`,`phone`,`user_remark`,`sort_index`,`is_lock`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`,`last_login_time`,`login_count`,`is_finance`,`finance_uid`,`finance_no`) 
        values(".$objUserInfo->iAgentId.",".$objUserInfo->iEUid.",'".$objUserInfo->strEName."','".$objUserInfo->strUserNo."','".$objUserInfo->strUserName."','".$objUserInfo->strUserPwd."','".$objUserInfo->strDeptName."','".$objUserInfo->strTel."','".$objUserInfo->strPhone."','".$objUserInfo->strUserRemark."',".$objUserInfo->iSortIndex.",".$objUserInfo->iIsLock.",".$objUserInfo->iIsDel.",".$objUserInfo->iCreateUid.",now(),".$objUserInfo->iUpdateUid.",now(),'".$objUserInfo->strLastLoginTime."',".$objUserInfo->iLoginCount.",".$objUserInfo->iIsFinance.",".$objUserInfo->iFinanceUid.",'".$objUserInfo->strFinanceNo."')";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {
            $newID = $this->objMysqlDB->lastInsertId();
            if($objUserInfo->iIsFinance == 1)
            {
                $sql = "update sys_user set finance_uid = $newID where user_id = $newID";
                $this->objMysqlDB->executeNonQuery(false,$sql,null);
            }
            
            if($objUserInfo->iAgentId > 0 && ($bToCRM == true))//$objUserInfo->strUserNo == '10'|| 
            {
                if($objUserInfo->strUserNo != "10" && $this->IsSupUserInCRM($newID) == false)
                    return $newID;
                    
                $objCRM_User_Service = new CRM_User_Service();
                $objUserInfo->iUserId = $newID;
                $sql = "select agent_name from am_agent where agent_id=".$objUserInfo->iAgentId;
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
                if(isset($arrayData) && count($arrayData) > 0)
                    $objUserInfo->strDeptName = $arrayData[0]["agent_name"];
                    
                $objCRM_User_Service->InserToCRM($objUserInfo);
                
            }
            return $newID;
        }
        else
            return 0;
    }

    private function IsSupUserInCRM($userID)
    {
        $sql = "SELECT sup_user.agent_id,sup_user.user_name FROM sys_user 
        INNER JOIN sys_user AS sup_user ON sup_user.agent_id = sys_user.agent_id AND left(sys_user.user_no,LENGTH(sys_user.user_no)-2) = sup_user.user_no 
        where sys_user.user_id = $userID and sup_user.is_del=0";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $objCRM_User_Service = new CRM_User_Service();
            return $objCRM_User_Service->iExistAccountNotContentIsDel($arrayData[0]["user_name"]);
        }
        
        return false;
    }
    
    /**
     * @functional 根据ID更新一条记录
     * @param $objUserInfo  UserInfo 实例
     * @return
     */
    public function updateByID(UserInfo $objUserInfo,$bToCRM = false)
    {
        $sql = "update `sys_user` set `agent_id`=".$objUserInfo->iAgentId.",`e_uid`=".$objUserInfo->iEUid.",`e_name`='".$objUserInfo->strEName."',`user_no`='".$objUserInfo->strUserNo."',`user_name`='".$objUserInfo->strUserName."',`user_pwd`='".$objUserInfo->strUserPwd."',`dept_name`='".$objUserInfo->strDeptName."',`tel`='".$objUserInfo->strTel."',`phone`='".$objUserInfo->strPhone."',`user_remark`='".$objUserInfo->strUserRemark."',`sort_index`=".$objUserInfo->iSortIndex.",`is_lock`=".$objUserInfo->iIsLock.",`is_del`=".$objUserInfo->iIsDel.",`update_uid`=".$objUserInfo->iUpdateUid.",`update_time`= now(),`last_login_time`='".$objUserInfo->strLastLoginTime."',`login_count`=".$objUserInfo->iLoginCount.",`is_finance`=".$objUserInfo->iIsFinance.",`finance_uid`=".$objUserInfo->iFinanceUid.",`finance_no`='".$objUserInfo->strFinanceNo."' where user_id=".$objUserInfo->iUserId; 
	    $result = $this->objMysqlDB->executeNonQuery(false, $sql, null);       
        if($result > 0 && $objUserInfo->iAgentId > 0)
        {
            $objCRM_User_Service = new CRM_User_Service();
            
            $sql = "select agent_name from am_agent where agent_id=".$objUserInfo->iAgentId;
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            if(isset($arrayData) && count($arrayData) > 0)
                $objUserInfo->strDeptName = $arrayData[0]["agent_name"];
                
            if($bToCRM == true)
            {
                if($objUserInfo->strUserNo != "10" && $this->IsSupUserInCRM($objUserInfo->iUserId) == false)
                    return $result;
                    
               $ret = $objCRM_User_Service->InserToCRM($objUserInfo);
            }
            else
            {
                $ret = $objCRM_User_Service->UpdateToCRM($objUserInfo);
            }            
        }
        return $result;
    }

    
    /**
     * @functional 根据ID更新一条记录
     * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id, $userID,$agentID=0)
    {
        $objUserInfo = $this->getModelByID($id,$agentID);
        if($objUserInfo == null)
            return 0;
            
        $objUserInfo->iIsDel = 1;
        $objUserInfo->iUpdateUid = $userID;
        return $this->updateByID($objUserInfo);
    }
    
    /**
     * 获取用户名称 格式：psho4655 许丹丹 
     * @param int $iUserId
     * @return string 
     */
    public function getUserNameAndENameById($iUserId){
        if(!$iUserId){
            return "";
        }
        $arrData = $this->selectTop("user_name,e_name", "user_id = {$iUserId} and is_del = 0", "", "", 1);
        if($arrData){
            return "{$arrData[0]['user_name']} {$arrData[0]['e_name']}";
        }
        return "";
    }

    /**
     * @functional 取得代理商明细信息
     */
    public function GetAgentDetailInfo($id,$agentID=0)
    {
        $strWhere = " where sys_user.user_id=$id " ;
        if($agentID >0 )
            $strWhere .= " and sys_user.agent_id=".$agentID;
            
	$sql = "select 
            sys_user.user_id,
            sys_user.user_no,
            sys_user.user_name,
            sys_user.e_uid,
            sys_user.e_name,
            sys_user.dept_name,
            sys_user.tel,
            sys_user.phone,
            sys_user.agent_id,
            am_agent.agent_name
            from
            sys_user
            left join am_agent ON (sys_user.agent_id=am_agent.agent_id) $strWhere order by  sys_user.e_uid,sys_user.agent_id";
	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null); //对
	//return  $this->objMysqlDB->executeAndReturn(false,$sql,null); 
    }

    /**
     * 
     */
    public function UpdateUserNo($oldNo, $newNo, $agentID)
    {
        $noLength = strlen($oldNo);
        $sql = "SELECT user_id, user_no FROM sys_user where agent_id =$agentID and is_del=0 and user_no like '{$oldNo}%'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $sql = "";
        $i= 0;
        $updateCount = 0;
    	foreach($arrayData as $key => $value)
    	{
    	   $sql .= "update sys_user set user_no = concat('{$newNo}',right(user_no,length(user_no)-{$noLength})) where user_id=".$value["user_id"].";";

           $i++;
           if($i == 50)//每50个更新
           {
                $updateCount += $this->objMysqlDB->executeNonQuery(false, $sql, null);
                $sql = "";
                $i=0;
           }
        }
        
    	if($sql != "")
    	   $updateCount += $this->objMysqlDB->executeNonQuery(false, $sql, null);
        
        return $updateCount;
    }

    /**
     * 
     */
    public function UpdateFinanceNo($oldNo, $newNo, $agentID)
    {
        $noLength = strlen($oldNo);
        $sql = "SELECT user_id, finance_no FROM sys_user where agent_id =$agentID and is_del=0 and finance_no like '{$oldNo}%'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $sql = "";
        $i= 0;
        $updateCount = 0;
    	foreach($arrayData as $key => $value)
    	{
    	   $sql .= "update sys_user set finance_no = concat('{$newNo}',right(finance_no,length(finance_no)-{$noLength})) where user_id=".$value["user_id"].";";

           $i++;
           if($i == 50)//每50个更新
           {
                $updateCount += $this->objMysqlDB->executeNonQuery(false, $sql, null);
                $sql = "";
                $i=0;
           }
        }
        
    	if($sql != "")
    	   $updateCount += $this->objMysqlDB->executeNonQuery(false, $sql, null);
        
        return $updateCount;
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
     * @functional 登录验证
     * @param $strUserName string 帐号名
     * @param $strPwd string 密码
     * @param $userID int 返回用户ID
     * @return string 错误信息 
     */
    public function LoginCheck($strUserName,$strPwd,&$userID)
    {
        $userID = 0;
        $sql = "SELECT sys_user.user_id,sys_user.is_lock,ifnull(hr_employee.e_status,0) as e_status, ifnull(hr_employee.is_del,0) as e_is_del 
                FROM sys_user left JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id) 
                WHERE sys_user.is_del = 0 AND sys_user.user_name = '$strUserName' and sys_user.user_pwd = '$strPwd' ";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    	if (isset($arrayData) && count($arrayData) > 0)
        {
            settype($arrayData[0]["is_lock"],"integer");
            settype($arrayData[0]["e_status"],"integer");
            settype($arrayData[0]["is_del"],"integer");
            if($arrayData[0]["is_lock"] == 1 ||$arrayData[0]["e_is_del"] == 1 )
                return "此账号已停用！";
                
            if($arrayData[0]["e_status"] == -9 || $arrayData[0]["e_status"] == -10 || $arrayData[0]["e_status"] == -11)
                return "此账号已停用！";
            
            $userID = $arrayData[0]["user_id"];
            return "";
        }
        
        return "用户名或密码有误！";
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
    	if ($sField == "*" || $sField == "")
    	    $sField = T_User::AllFields;
    	if ($sWhere != "")
    	    $sWhere = " where is_del=0 and " . $sWhere;
    	else
    	    $sWhere = " where is_del=0";
    
    	if ($sOrder == "")
    	    $sOrder = " order by sort_index";
    	else
    	    $sOrder = " order by " . $sOrder;
    
    	if ($sGroup != "")
    	    $sGroup = " group by " . $sGroup;
    
    	$sLimit = "";
    	if (is_int($iRecordCount) && $iRecordCount > 0)
    	    $sLimit = " limit 0," . $iRecordCount;
    
    	$sql = "SELECT " . $sField . " FROM `sys_user` " . $sWhere .$sGroup.$sOrder. $sLimit;
        //print_r($sql);
    	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * 取得代理商主账号
	 * @param int $id 
     * @return UserInfo 对象
     */
    public function getAgentMasterAccountModel($iAgentID)
    {
	   $arrayInfo = self::select("*", "agent_id=$iAgentID and user_no='10'", "");
	   return $this->f_arrayInfoToModel($arrayInfo);
    }

    /**
     * @functional 根据ID,返回一个sys_user对象
     * @param int $id 
     * @return sys_user对象
     */
    public function getModelByID($id,$iAgentID=0)
    {
    	$arrayInfo = $this->select("*", "user_id=" . $id.($iAgentID>0 ? " and agent_id=$iAgentID":""), "");
        return $this->f_arrayInfoToModel($arrayInfo);
    }

    private function f_arrayInfoToModel($arrayInfo)
    {
    	$objUserInfo = null;
    	if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objUserInfo = new UserInfo();
            		
            $objUserInfo->iUserId = $arrayInfo[0]['user_id'];
            $objUserInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objUserInfo->iEUid = $arrayInfo[0]['e_uid'];
            $objUserInfo->strEName = $arrayInfo[0]['e_name'];
            $objUserInfo->strUserNo = $arrayInfo[0]['user_no'];
            $objUserInfo->strUserName = $arrayInfo[0]['user_name'];
            $objUserInfo->strUserPwd = $arrayInfo[0]['user_pwd'];
            $objUserInfo->strDeptName = $arrayInfo[0]['dept_name'];
            $objUserInfo->strTel = $arrayInfo[0]['tel'];
            $objUserInfo->strPhone = $arrayInfo[0]['phone'];
            $objUserInfo->strUserRemark = $arrayInfo[0]['user_remark'];
            $objUserInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objUserInfo->iIsLock = $arrayInfo[0]['is_lock'];
            $objUserInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objUserInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objUserInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objUserInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objUserInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objUserInfo->strLastLoginTime = $arrayInfo[0]['last_login_time'];
            $objUserInfo->iLoginCount = $arrayInfo[0]['login_count'];
            $objUserInfo->iIsFinance = $arrayInfo[0]['is_finance'];
            $objUserInfo->iFinanceUid = $arrayInfo[0]['finance_uid'];
            $objUserInfo->strFinanceNo = $arrayInfo[0]['finance_no'];
            settype($objUserInfo->iUserId,"integer");
            settype($objUserInfo->iAgentId,"integer");
            settype($objUserInfo->iEUid,"integer");
            settype($objUserInfo->iSortIndex,"integer");
            settype($objUserInfo->iIsLock,"integer");
            settype($objUserInfo->iIsDel,"integer");
            settype($objUserInfo->iCreateUid,"integer");
            settype($objUserInfo->iUpdateUid,"integer");
            settype($objUserInfo->iLoginCount,"integer");
            settype($objUserInfo->iIsFinance,"integer");
            settype($objUserInfo->iFinanceUid,"integer");
            
        }
    
    	return $objUserInfo;
    }
    /* -------------------------公司用户-----------begin---------------- */

    /**
     * @functional 公司用户 分页数据
     * @author wzx 2011.07.18
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields 暂时未用上 
     * @param string $strWhere
     * @param string $strOrder 暂时未用上
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'*','WHERE','ORDER BY',$c));
     */
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
    	$offset = ($iPageIndex - 1) * $iPageSize;
    	$iRecordCount = 0;
        if($strOrder == "")
            $strOrder = "sys_user.user_name, hr_employee.e_name";
    	$sqlCount = "SELECT COUNT(1) AS `counts`        
                FROM sys_user 
                  INNER JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id) 
                  LEFT JOIN hr_dept_position ON (hr_employee.dept_position_id = hr_dept_position.dept_position_id) 
                  LEFT JOIN hr_department ON (hr_dept_position.hr_dept_id = hr_department.dept_id) 
                  LEFT JOIN hr_position ON (hr_dept_position.post_id = hr_position.post_id) 
                WHERE sys_user.is_del = 0 AND sys_user.e_uid > 0 AND sys_user.agent_id <= 0 AND hr_employee.is_del = 0 $strWhere";
    
    	$iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
    
    	$sqlData = "SELECT sys_user.user_id, sys_user.user_name,sys_user.e_uid,sys_user.agent_id,
                 hr_employee.e_id, hr_employee.e_workno, hr_employee.e_name,
                 hr_employee.e_status, sys_user.is_lock, hr_department.dept_name,
                 hr_department.dept_fullname, hr_department.dept_id, hr_position.post_name ,
                 sys_user.last_login_time 
                FROM sys_user 
                  INNER JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id) 
                  LEFT JOIN hr_dept_position ON (hr_employee.dept_position_id = hr_dept_position.dept_position_id) 
                  LEFT JOIN hr_department ON (hr_dept_position.hr_dept_id = hr_department.dept_id) 
                  LEFT JOIN hr_position ON (hr_dept_position.post_id = hr_position.post_id) 
                WHERE 
                  sys_user.is_del = 0 AND sys_user.e_uid > 0 AND sys_user.agent_id <= 0 AND hr_employee.is_del = 0 
                $strWhere order by $strOrder LIMIT $offset,$iPageSize";

        //die($sqlData);
    	//print_r($sqlData);
    	return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

    /**
     * @functional 显示公司用户详细信息
     */
    public function GetUserDetailInfo($uid)
    {
	$sql = "SELECT sys_user.user_id, sys_user.user_name,
             hr_employee.e_id, hr_employee.e_workno, hr_employee.e_name,
             hr_employee.e_status, sys_user.is_lock, hr_department.dept_name,
             hr_department.dept_fullname, hr_department.dept_id, hr_position.post_name 
            FROM sys_user 
              INNER JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id) 
              LEFT JOIN hr_dept_position ON (hr_employee.dept_position_id = hr_dept_position.dept_position_id) 
              LEFT JOIN hr_department ON (hr_dept_position.hr_dept_id = hr_department.dept_id) 
              LEFT JOIN hr_position ON (hr_dept_position.post_id = hr_position.post_id) 
            WHERE 
              sys_user.is_del = 0 AND sys_user.e_uid > 0 AND hr_employee.is_del = 0 and sys_user.user_id=$uid";

	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 显示公司用户权限
     */
    public function UserRightList($rootModelGroupNo, $uid)
    {
	$strWhere = "";
	if ($rootModelGroupNo != "")
	    $strWhere = " and left(sys_model_group.`mgroup_no`,2) = '$rootModelGroupNo' ";

	$sql = "SELECT  sys_model_group.mgroup_no,  sys_model_group.mgroup_id,  sys_model_group.mgroup_code, 
            sys_model_group.mgroup_name, sys_model.model_id,sys_model.model_name,sys_model.model_code,
            sys_model_right.right_id,  sys_model_right.`right_value`, sys_model_right.`right_name`,
            if(user_right.right_id,1,0) as is_check,
            if(sys_model_group.`is_lock`+ sys_model.is_lock,1,0) as is_lock 
            FROM 
            sys_model_group 
            left JOIN sys_model ON (sys_model_group.mgroup_id = sys_model.mgroup_id) 
            left JOIN sys_model_right ON (sys_model.model_id = sys_model_right.model_id) 
            left join (
                        select right_id from(
                        select right_id,sum(is_forbid) as is_forbid 
                        FROM(
                        SELECT sys_post_right.right_id,0 as is_forbid FROM sys_user 
                        INNER JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id) 
                        INNER JOIN hr_dept_position ON (hr_employee.dept_position_id = hr_dept_position.dept_position_id) 
                        INNER JOIN sys_post_right ON (hr_dept_position.post_id = sys_post_right.post_id) 
                        where sys_user.user_id = $uid 
                        union all 
                        SELECT `sys_user_right`.`right_id`,sys_user_right.`is_forbid` FROM sys_user 
                        INNER JOIN sys_user_right on (sys_user.user_id = sys_user_right.user_id) 
                        where sys_user.user_id = $uid
                        ) t  group by t.right_id
                        )tt where tt.is_forbid=0 
             ) user_right           
             ON sys_model_right.`right_id` = user_right.right_id   
            where sys_model_group.is_del =0 and sys_model.is_del =0 and sys_model_right.is_del =0 
            and LENGTH(sys_model_group.`mgroup_no`)>2 and sys_model_group.`is_agent` <= 0 $strWhere        
            order by sys_model_group.`sort_index`,sys_model.`sort_index`,sys_model_right.`right_value`";
	//print_r($sql);
        
	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 用户权限
     * @return array
     */
    protected function ArrayUserRight($uid)
    {
	$sql = "SELECT sys_model.`model_code`,sum(sys_model_right.right_value) as right_value 
            FROM sys_model 
            INNER JOIN sys_model_right ON (sys_model.model_id = sys_model_right.model_id) 
            inner join (
                select right_id from (
                    select right_id, sum(is_forbid) as is_forbid FROM (                
                        SELECT sys_post_right.right_id, 0 as is_forbid FROM sys_user 
                        INNER JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id) 
                        INNER JOIN hr_dept_position ON (hr_employee.dept_position_id = hr_dept_position.dept_position_id) 
                        INNER JOIN sys_post_right ON (hr_dept_position.post_id = sys_post_right.post_id) where 
                        sys_user.user_id = $uid and sys_user.`is_del`=0 and sys_user.`is_lock`= 0                     
                        union all                     
                        SELECT `sys_user_right`.`right_id`,sys_user_right.`is_forbid` FROM sys_user INNER JOIN sys_user_right on 
                        (sys_user.user_id = sys_user_right.user_id) where sys_user.user_id = $uid 
                        and sys_user.`is_del`=0 and sys_user.`is_lock`= 0                         
                    ) t group by t.right_id 
                ) tt where tt.is_forbid = 0 
            ) ttt on ttt.right_id = sys_model_right.right_id 
            where  `sys_model`.`is_lock` = 0 and sys_model.`is_del`=0 and sys_model.`is_agent`=0 
             and sys_model_right.`is_del`=0 and sys_model_right.`is_lock`= 0 
            group by sys_model.`model_code` order by sys_model.`model_code`";

	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 代理商用户权限
     * @return array
     */
    public function GetAgentUserRight($uid)
    {
	$arrayUserRight = $this->ArrayAgentUserRight($uid);
	$arrayRight = Array();
	$iRightCount = count($arrayUserRight);
	for ($i = 0; $i < $iRightCount; $i++)
	{
	    $arrayRight[$arrayUserRight[$i]["model_code"]] = $arrayUserRight[$i]["right_value"];
	}

	return $arrayRight;
    }

    /**
     * @functional 公司用户权限
     * @return array
     */
    public function GetUserRight($uid)
    {
	$arrayUserRight = $this->ArrayUserRight($uid);
	$arrayRight = Array();
	$iRightCount = count($arrayUserRight);
	for ($i = 0; $i < $iRightCount; $i++)
	{
	    $arrayRight[$arrayUserRight[$i]["model_code"]] = $arrayUserRight[$i]["right_value"];
	}

	return $arrayRight;
    }

    /**
     * @functional 代理商用户权限
     * @return array
     */
    public function ArrayAgentUserRight($uid)
    {
    	$sql = "";
    	$objUserRoleBLL = new UserRoleBLL();
    	if ($objUserRoleBLL->UserIsAdmin($uid))//如果是Admin则具有全部权限
    	{
    	    $sql = "SELECT sys_model.`model_code`,sum(sys_model_right.right_value) as right_value 
                    FROM sys_model 
                    INNER JOIN sys_model_right ON (sys_model.model_id = sys_model_right.model_id) 
                    where  `sys_model`.`is_lock` = 0 and sys_model.`is_del`=0 and sys_model.`is_agent`=1 
                    and sys_model_right.`is_del`=0 and sys_model_right.`is_lock`= 0 
                    group by sys_model.`model_code` order by sys_model.`model_code`";
    	}
    	else
    	{
    	    $sql = "SELECT sys_model.`model_code`,sum(sys_model_right.right_value) as right_value 
                    FROM sys_model 
                    INNER JOIN sys_model_right ON (sys_model.model_id = sys_model_right.model_id) 
                    inner join (
                        select right_id from(                    
                            select right_id,sum(is_forbid) as is_forbid FROM(                    
                                SELECT sys_role_right.`right_id`,0 as is_forbid FROM  sys_user 
                                INNER JOIN sys_user_role ON (sys_user.user_id = sys_user_role.user_id) 
                                INNER JOIN sys_role_right ON (sys_user_role.role_id = sys_role_right.role_id)   
                                where sys_user.user_id= $uid and sys_user.`is_del`=0 and sys_user.`is_lock`= 0                         
                                union all   
                                SELECT `sys_user_right`.`right_id`,sys_user_right.`is_forbid` FROM  sys_user 
                                INNER JOIN sys_user_right on (sys_user.user_id = sys_user_right.user_id)   
                                where sys_user.user_id= $uid and sys_user.`is_del`=0 and sys_user.`is_lock`= 0                     
                            ) t group by t.right_id 
                        )tt where tt.is_forbid=0 
                    ) ttt on ttt.right_id = sys_model_right.right_id 
                    where  `sys_model`.`is_lock` = 0 and sys_model.`is_del`=0 and sys_model.`is_agent`=1 
                    and sys_model_right.`is_del`=0 and sys_model_right.`is_lock`= 0 
                    group by sys_model.`model_code` order by sys_model.`model_code`";
    	}
    	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 用户开通
     */
    public function AddUser($eID, $iIsLock, $updateUid)
    {
    	$sql = "update sys_user set is_del = 0,update_uid=$updateUid,is_lock=$iIsLock,update_time = now() where agent_id<=0 and e_uid = $eID and is_del = 1 ";
    	//exit($sql);
    	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 公司用户自动匹配 {value:[]}
     */
    public function AutoUserJson($strUserName,$iExceptUid)
    {
    	$sql = "select user_id,user_name,e_name from sys_user where is_del=0 and agent_id<=0 and user_id<>$iExceptUid 
            and (user_name like '%$strUserName%' or e_name like '%$strUserName%') order by user_name limit 0,100";
    
    	$arrayUser = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $userJson = "{value:[]}";
        if(isset($arrayUser) && count($arrayUser)>0)
        {
            $arrayLength = count($arrayUser);
            $userJson = "{value:[";
            for($i=0;$i<$arrayLength;$i++)
            {
                $userJson .= "{id:'".$arrayUser[$i]["user_id"]."',name:'".$arrayUser[$i]["user_name"]." ".$arrayUser[$i]["e_name"]."'},";
            }
            $userJson = substr($userJson,0,strlen($userJson)-1);
            $userJson .= "]}";
        }
        
        return $userJson;
    }
    
    /* -------------------------公司用户-----------end---------------- */
    /* -------------------------代理商用户-----------begin---------------- */

    /**
     * @functional 默认密码
     * @param $pwd 未加密密码
     * @return 加密后密码
     */
    public function getInitPwd($pwd)
    {
	   return strtoupper(md5($pwd));
    }

    /**
     * @functional 代理商用户列表 前台（分页）
     * @return 
     */
    public function getAgentUser($iPageIndex, $iPageSize, $sWhere, $sOrder, &$iRecordCount)
    {    	
        $strWhere = ' where sys_user.agent_id >0 and sys_user.is_del=0 and am_agent.is_del=0 and length(sys_user.user_no)>0 ';
    	if ($sWhere != "")
    	    $strWhere .= " and  $sWhere";
    	if ($sOrder == "")
    	    $sOrder = " order by sys_user.agent_id,sys_user.user_no,sys_user.user_name";
    	else
    	    $sOrder = " order by " . $sOrder;
    
        $offset = ($iPageIndex - 1) * $iPageSize;
    	$iRecordCount = 0;
        $sqlCount ="SELECT count(1) as `counts` 
            from  `sys_user` 
            inner join `am_agent` on (`am_agent`.agent_id=`sys_user`.agent_id) " . $strWhere;
            
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        $sLimit = " limit $offset, $iPageSize";
        //$sLimit = " limit $offset, $iRecordCount";
    	if (is_int($iRecordCount) && $iRecordCount > 0)
    	    $sLimit = " limit 0," . $iRecordCount;
    
    	$sql = "SELECT sys_user.`user_id`,
        sys_user.`agent_id`,
        sys_user.`e_uid`,
        sys_user.`e_name`,
        sys_user.`user_no`,
        sys_user.`user_name`,
        sys_user.`user_pwd`,
        sys_user.`dept_name`,
        sys_user.`tel`,
        sys_user.`phone`,
        sys_user.`user_remark`,
        sys_user.`sort_index`,
        sys_user.`is_lock`,
        sys_user.`is_del`,
        sys_user.`create_uid`,
        sys_user.`create_time`,
        sys_user.`update_uid`,
        sys_user.`update_time`,
        sys_user.`is_finance`,
        sys_user.`finance_no`,
        am_agent.agent_name, 
        ROUND(length(sys_user.user_no)/2,0) as account_level,
        (select concat(u.user_name,' ',u.e_name) from sys_user u where u.user_id = sys_user.finance_uid) as finance_user_name 
            FROM `sys_user` inner join `am_agent` on `sys_user`.agent_id=`am_agent`.agent_id " . $strWhere . $sOrder . $sLimit;
    	
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 代理商用户列表 后台 加分页
     * @param int $iPageIndex
     * @param int $iPageSize
     * @param string $strPageFields 
     * @param string $strWhere
     * @param string $strOrder 
     * @param int $iRecordCount
     * @desc $rtn = $obj->selectPaged(1,20,'*','WHERE','ORDER BY',$c));
     */
    public function AgentUserList($iPageIndex, $iPageSize, $sWhere, $sOrder, &$iRecordCount,$bExportExcel=false)
    {
        $iRecordCount = 0;
        if($bExportExcel == true)
        {
            $iPageIndex = 1;
            $iPageSize = DataToExcel::max_record_count;
        }
        
    	$strWhere = " and am_agent.is_del=0 ";
        
    	if (!empty($sWhere))
    	    $strWhere .= $sWhere;
    
    	if ($sOrder == "")
    	    $sOrder = " order by am_agent.`agent_no`,sys_user.user_name";
    	else
    	    $sOrder = " order by " . $sOrder;
    
    	$offset = ($iPageIndex - 1) * $iPageSize;
    	$iRecordCount = 0;
        if($bExportExcel == false)
        {
            $sqlCount = "SELECT count(1) as `counts` 
                from  am_agent
                left join `sys_user` on (`am_agent`.agent_id=`sys_user`.agent_id and sys_user.user_no='10' and sys_user.is_del=0)        
                where am_agent.agent_id<>am_agent.agent_no " . $strWhere;
        	$iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        }
        
    	//$sLimit = " limit $offset, $iRecordCount";
        $sLimit = " limit $offset, $iPageSize";
    	$sqlData = "SELECT       
            sys_user.`user_id`,
            sys_user.`user_name`,
            sys_user.`e_name`,
            sys_user.`dept_name`,
            sys_user.`tel`,
            sys_user.`phone`,
            if(sys_user.`user_id`,sys_user.`is_lock`,0) as is_lock,
            sys_user.`create_uid`,
            sys_user.create_time,
            sys_user.`update_uid`,
            sys_user.`update_time`,
            am_agent.`agent_id`,
            am_agent.`agent_no`,
            am_agent.`agent_name`,
            (select group_concat(`sys_product_type`.`product_type_name`) from `sys_product_type`
            where 
            INSTR (  CONCAT ( ',',
             (select group_concat(`am_agent_pact`.`product_id`) from `am_agent_pact` where `am_agent_pact`.agent_id=am_agent.`agent_id` and `am_agent_pact`.pact_status=2 and (`am_agent_pact`.pact_type=1 or `am_agent_pact`.pact_type=2)  group by `am_agent_pact`.agent_id),',' ),    
                  CONCAT (','  ,   `sys_product_type`.aid  , ',' ) ) > 0)
            as product_type_name,  
            (select min(`am_agent_pact`.pact_sdate) from `am_agent_pact` where `am_agent_pact`.agent_id = am_agent.`agent_id`) as pact_sdate,   
            (select max(`am_agent_pact`.pact_edate) from `am_agent_pact` where `am_agent_pact`.agent_id = am_agent.`agent_id`) as pact_edate        
            from  am_agent         
            left join `sys_user` on (`am_agent`.agent_id=`sys_user`.agent_id and sys_user.user_no='10'and sys_user.is_del=0) 
            where am_agent.agent_id<>am_agent.agent_no " . $strWhere . $sOrder . $sLimit;
            //echo($sqlData);exit();
    	return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

    /**
     * @functional 子账号列表
     * @return 
     */
    public function AgentChildUserList($id)
    {
    	$sqlData = "select 
            sys_user.user_id,
            sys_user.user_name,
            sys_user.user_no,
            sys_user.agent_id,
            sys_user.is_lock,        
            ROUND(length(sys_user.user_no)/2,0) as account_level 
            from `sys_user`
            where sys_user.is_del=0 and sys_user.agent_id=$id and sys_user.is_del=0 
            and length(sys_user.user_no)>2 order by sys_user.user_no ";
    	return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

    /**
     * @functional 重置用户密码
     * @param $pwd 已加密密码
     * @return 
     */
    public function resetPwd($id, $userID,$pwd)
    {        
        $objUserInfo = $this->getModelByID($id);
        if($objUserInfo == null)
            return 0;
            
        $objUserInfo->strUserPwd = $pwd;
        $objUserInfo->iUpdateUid = $userID;
        return $this->updateByID($objUserInfo);
    }

    /**
     * @functional 停用/启用 用户
     * @return 
     */
    public function LockUser($id, $userID)
    {
    	$sql = "update sys_user set is_lock = if(is_lock,0,1),update_uid=" . $userID . ",update_time=now() where user_id=" . $id;
    	$isSuccess = $this->objMysqlDB->executeNonQuery(false, $sql, null);
        
        $sql = "select 1 from sys_user where user_id=".$id." and `agent_id`<=0 and `is_lock`=1";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    	if (isset($arrayData) && count($arrayData) > 0)
        {
            //去掉审核人
            $sql = "update `om_order` set `audit_user_name`='',`allolt_user_name`='',`allolt_uid`=0,`allolt_audit_uid`=0 
            where `allolt_audit_uid`= $userID and `check_status`=".CheckStatus::auditting." and is_del=0";
            $this->objMysqlDB->executeNonQuery(false, $sql, null);
        }
        
        return $isSuccess;
    }

    /**
     * @functional 代理商用户能否删除用户
     * @return  true 可以删除 flase 不能删除
     */
    public function CanDelAgentUser($userID)
    {
    	$sql = "select 1 from sys_user u1 inner join sys_user u2 on (u2.agent_id = u1.agent_id and u2.user_no like CONCAT(u1.user_no,'%')) 
            where  u2.is_del = 0 and LENGTH(u2.user_no)>LENGTH(u1.user_no) and u1.user_id = $userID";//有下级用户
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    	if (isset($arrayData) && count($arrayData) > 0)
    	    return false;
            
    	$sql = "select `user_id` from `cm_customer_agent` where `user_id`=$userID;";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    	if (isset($arrayData) && count($arrayData) > 0)
    	    return false;
            
    	$sql = "select order_id from `om_order` where is_del = 0 and (`post_uid` = $userID or `update_uid` = $userID or `create_uid` = $userID)";//有提交订单
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    	if (isset($arrayData) && count($arrayData) > 0)
    	    return false;
                     
    	$sql = "select post_money_id from `fm_post_money` where is_del = 0 and (`update_uid` = $userID or `create_uid` = $userID)";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    	if (isset($arrayData) && count($arrayData) > 0)
    	    return false;
            
    	$sql = "select account_detail_id from `fm_agent_account_detail` where is_del = 0 and (`update_uid` = $userID or `create_uid` = $userID or finance_uid=$userID)";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    	if (isset($arrayData) && count($arrayData) > 0)
    	    return false;
            
        $objCRM_User_Service = new CRM_User_Service();
        return $objCRM_User_Service->DRPCanDelUser($userID);        
        
	    return true;
    }

    /**
     * @functional 停用代理商的主帐号
     * @param string $agentIDs 代理商ID
     * @param int $is_lock 1锁定 0解锁
     */
    public function LockAgentUser($agentIDs,$is_lock)
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
                    
            	$sql .= "update sys_user set is_lock=$is_lock where user_no = '10' agent_id=".$arrayAgentID[$i].";";
            }
            
            if(strlen($sql) > 0)
                return $this->objMysqlDB->executeNonQuery(false, $sql, null);
            else
                return 0;
        }
    }

    /**
     * @function 根据user_id查询某员工所属部门
     * @author liujunchen
     * 
    */
    public function getDeptNameByUserId($userId)
    {
        $sql = "SELECT A.dept_no,A.dept_name,A.dept_fullname,A.m_value FROM v_hr_employee A JOIN sys_user B ON A.e_id = B.e_uid AND B.user_id = ".$userId;
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
    /**
     * @functional 停用代理商及其子帐号
     * @param int $agentID 代理商ID
     */
    public function BatLockAgentUser($agentID)
    {
    	$sql = "update sys_user set is_lock=1 where agent_id=$agentID";
    	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    
    /* -------------------------代理商用户-----------end---------------- */
    
    /**
     * @functional 用户名
     * @param int $id 用户 ID
     */
    public function GetUserNameByUID($id)
    {
        $strName = "";
        $sql = "SELECT user_name,e_name FROM sys_user where user_id = $id";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $strName = $arrayData[0]["user_name"]." ".$arrayData[0]["e_name"];
        }
        
        return $strName;
    }
    
    /**
     * @functional 用户名
     * @param int $id 用户 ID
     */
    public function GetUserNameByID($id)
    {
        $strName = "";
        $sql = "SELECT user_name FROM sys_user where user_id = $id";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $strName = $arrayData[0]["user_name"];
        }
        
        return $strName;
    }
    
    /**
     * @functional 用户名
     * @param int $id 用户 ID
     */
    public function GetENameByUID($id)
    {
        $strName = "";
        $sql = "SELECT user_name,e_name FROM sys_user where user_id = $id";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $strName = $arrayData[0]["e_name"];
        }
        
        return $strName;
    }
   
   
    /**
     * @functional 
     * @param $iDeptID
     */
    public function getGroupId($iDeptID)
    {
        $sql = "SELECT dept_id,dept_no FROM hr_department where dept_id = $iDeptID";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
       	if (isset($arrayData)&& count($arrayData)>0)
            $str_dept_no = $arrayData[0]["dept_no"];
        
        $sql2 = "SELECT group_concat(`dept_id`) FROM hr_department where dept_no like '$str_dept_no%'";
        $str_dept_id = $this->objMysqlDB->executeAndReturn(false,$sql2,null);
        return $str_dept_id;
    }
    
    /**
     * @functional 通过ERP的用户ID取得用户用户名和DRP中的ID
     * @param $eID
     */
    public function GetUserNameAndIDByEID($eID,&$userID,&$userName)
    {
        $userID = 0;
        $userName = "";
        $sql = "SELECT `user_id`, `user_no`, `user_name`,e_name FROM `sys_user` where  `sys_user`.`e_uid` = $eID";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $userID = $arrayData[0]["user_id"];
            $userName = $arrayData[0]["user_name"]." ".$arrayData[0]["e_name"];
        }
    }
    
    /**
     * @functional 更新最后一次登录时间和登录次数
     * @param $userID
     */
    public function UpdateLoginInfo($userID)
    {
        $sql = "update `sys_user` set `last_login_time` = now(), `login_count` = `login_count`+1 where user_id=".$userID;

        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    public function getAccountGroupById($userID)
    {
        $sql = "SELECT sag.account_no,sag.account_name from sys_user as sys
                LEFT JOIN sys_account_group_user as sagu ON sagu.user_id =sys.user_id
                LEFT JOIN sys_account_group as sag ON sag.account_group_id=sagu.account_group_id
                WHERE sys.user_id = {$userID}";
               
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    public function GetAgentAdminUserID($agentId)
    {
        $uid = 0 ;
        $arrayData = $this->select("user_id","agent_id={$agentId} and user_no='10'");
        if(count($arrayData) > 0)
        {
            $uid = $arrayData[0]["user_id"];
        }
        return $uid;
    }
}

?>