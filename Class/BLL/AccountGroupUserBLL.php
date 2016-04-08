<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_account_group_user的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-9-1 18:23:50
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AccountGroupUserInfo.php';

class AccountGroupUserBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AccountGroupUserInfo $objAccountGroupUserInfo  AccountGroupUser实例
     * @return 
     */
	public function insert(AccountGroupUserInfo $objAccountGroupUserInfo)
	{
		$sql = "INSERT INTO `sys_account_group_user`(`account_group_id`,`user_id`,`is_del`,`update_uid`,`create_uid`,`update_time`,`create_time`)"
		." values(".$objAccountGroupUserInfo->iAccountGroupId.",".$objAccountGroupUserInfo->iUserId.",".$objAccountGroupUserInfo->iIsDel.",".$objAccountGroupUserInfo->iUpdateUid.",".$objAccountGroupUserInfo->iCreateUid.",now(),now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param AccountGroupUserInfo $objAccountGroupUserInfo  AccountGroupUser实例
     * @return
     */
	public function updateByID(AccountGroupUserInfo $objAccountGroupUserInfo)
	{
		$sql = "update `sys_account_group_user` set `account_group_id`=".$objAccountGroupUserInfo->iAccountGroupId.",`user_id`=".$objAccountGroupUserInfo->iUserId.",`is_del`=".$objAccountGroupUserInfo->iIsDel.",`update_uid`=".$objAccountGroupUserInfo->iUpdateUid.",`update_time`= now() where account_group_user_id=".$objAccountGroupUserInfo->iAccountGroupUserId;
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
		$sql = "update `sys_account_group_user` set is_del=1,update_uid=".$userID.",update_time=now() where account_group_user_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	/**
     * @functional 移除账号绑定的区域组
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteUArea($id,$userID)
    {
		$sql = "update `sys_user_area` set is_del=1,update_uid=".$userID.",update_time=now() where agroup_user_id=".$id;
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
			$sField = T_AccountGroupUser::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_account_group_user` ".$sWhere.$sOrder.$sGroup.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_account_group_user对象
	 * @param int $id 
     * @return sys_account_group_user对象
     */
	public function getModelByID($id)
	{
		$objAccountGroupUserInfo = null;
		$arrayInfo = $this->select("*","account_group_user_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAccountGroupUserInfo = new AccountGroupUserInfo();
			$objAccountGroupUserInfo->iAccountGroupUserId = $arrayInfo[0]['account_group_user_id'];
			$objAccountGroupUserInfo->iAccountGroupId = $arrayInfo[0]['account_group_id'];
			$objAccountGroupUserInfo->iUserId = $arrayInfo[0]['user_id'];
			$objAccountGroupUserInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objAccountGroupUserInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objAccountGroupUserInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAccountGroupUserInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objAccountGroupUserInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objAccountGroupUserInfo->iAccountGroupUserId,"integer");
			settype($objAccountGroupUserInfo->iAccountGroupId,"integer");
			settype($objAccountGroupUserInfo->iUserId,"integer");
			settype($objAccountGroupUserInfo->iIsDel,"integer");
			settype($objAccountGroupUserInfo->iUpdateUid,"integer");
			settype($objAccountGroupUserInfo->iCreateUid,"integer");
			
			
		}
		
		return $objAccountGroupUserInfo;
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_account_group_user` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `sys_account_group_user` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * @functional 转移账号
     * @param int 
    */
	public function Transfer($newid,$userID,$area)
    {
        $objAccountGroupUserInfo = new AccountGroupUserInfo();
        $updateCount = 0;
        if(strlen($area) > 0)
        {
            $area = explode(",",$area);
            
            $arrayLength = count($area); 
            for($i = 0;$i < $arrayLength; $i++)
            {  
                $sql  = "update sys_account_group_user set `account_group_id`= '$newid',`update_uid`=$userID where `account_group_user_id`=$area[$i]";
                
                $updateCount += $this->objMysqlDB->executeNonQuery(false,$sql,null);
            }
        }
        //$sql = "update `sys_account_group_user` set account_group_id=$newid,update_uid=".$userID.",update_time=now() where account_group_id=".$oldid;
        //return 
        return $updateCount;
    }
    /**
     * @functional 根据区域id获得渠道经理Id
     * @param int 
    */
	public function GetChannIdByAreaId($areaId)
    {
        $sql = "SELECT  `sys_user_area`.`agroup_user_id`
                FROM
                  `sys_user_area` INNER JOIN `sys_area_group_detail` ON `sys_user_area`.`area_group_id` = `sys_area_group_detail`.`agroup_id` 
                  INNER JOIN `sys_area_group` ON `sys_area_group_detail`.`agroup_id` = `sys_area_group`.`agroup_id`
                  where `sys_user_area`.`is_del` = 0 and `sys_area_group_detail`.`is_del` = 0 and `sys_area_group_detail`.`area_id` = ".$areaId." 
                  and `sys_area_group`.`group_no` like '10%' and `sys_area_group`.`is_del` = 0 
                  and `sys_area_group`.`is_lock` = 0 order by `sys_user_area`.`agroup_user_id` desc limit 0,1";
        return $this->objMysqlDB->executeAndReturn(false,$sql,null);
    }
    /**
     * @functional 官网上代理商注册的时候，如果该地区没有渠道经理，就随机获取一个渠道经理的ID
     * @param int 
    */
	public function GetChannIdRand()
    {
        $sql = "SELECT  `sys_user_area`.`agroup_user_id`
                FROM
                  `sys_user_area` INNER JOIN `sys_area_group_detail` ON `sys_user_area`.`area_group_id` = `sys_area_group_detail`.`agroup_id` 
                  INNER JOIN `sys_area_group` ON `sys_area_group_detail`.`agroup_id` = `sys_area_group`.`agroup_id`
                  where `sys_user_area`.`is_del` = 0 and `sys_area_group_detail`.`is_del` = 0 
                  and `sys_area_group`.`group_no` like '10%' and `sys_area_group`.`is_del` = 0 and `sys_area_group`.`is_lock` = 0 
                  order by `sys_user_area`.`agroup_user_id` desc limit 0,1";
        return $this->objMysqlDB->executeAndReturn(false,$sql,null);
    }
    
    /**
     * @functional 根据用户Id返回所在区域组Id
     * @author 刘君臣
    */
    public function getGroupIdByUserId($iUserId)
    {
        $sql = "SELECT A.area_group_id FROM sys_user_area A JOIN sys_account_group_user B ON A.agroup_user_id = B.account_group_user_id 
        AND B.user_id = ".$iUserId." AND B.is_del = 0 AND A.is_del = 0 
        JOIN sys_account_group C ON B.account_group_id = C.account_group_id AND C.account_no like '10%'";
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    /**
     * @functional 根据用户Id返回当前渠道经理所在账号组所属的区域组Id
     * @author 刘君臣
    */
    public function getChargeAreaId($iUserId)
    {
        $area_group_id = "";
        $arrayData = $this->GetGroupDataByUserId($iUserId);
        if(isset($arrayData) && count($arrayData) > 0)
            $area_group_id = $arrayData[0]["account_group_id"];
            
        return $area_group_id;
    }
    
    /**
     * @functional 根据代理商Id返回所在区域组Id
     * @author wzx
    */
    public function getGroupIdByAgentId($agentID)
    {
        $sql = "SELECT `sys_account_group_user`.`account_group_id` 
        FROM  am_agent_source 
        INNER JOIN sys_account_group_user ON sys_account_group_user.user_id = am_agent_source.channel_uid and sys_account_group_user.is_del=0
        INNER JOIN sys_account_group ON sys_account_group.account_group_id = sys_account_group_user.account_group_id AND sys_account_group.is_del = 0 
        AND sys_account_group.account_no like '10%' AND am_agent_source.agent_id = $agentID and sys_account_group.is_del=0 order by account_no desc;";
            
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData) > 0)
            return $arrayData[0]["account_group_id"];
            
        return 0;
    }
     
    
    /**
     * @functional 根据用户Id返回所在区域组信息 按区域组层级由低到高排序
     * @author wzx
    */
    public function GetGroupDataByUserId($userID)
    {
        $sql = "SELECT sys_account_group.account_group_id,sys_account_group.account_no,sys_account_group.account_name,
                    sys_account_group.acgroup_remark,sys_account_group.sort_index,sys_account_group.is_lock,sys_account_group.is_del,
                    sys_account_group.update_uid,sys_account_group.create_uid,sys_account_group.update_time,sys_account_group.create_time,
                    sys_account_group.account_group_type FROM sys_account_group 
                    INNER JOIN sys_account_group_user ON sys_account_group.account_group_id = sys_account_group_user.account_group_id 
                    where 
                    sys_account_group.is_del = 0  and sys_account_group_user.is_del = 0  and 
                    (sys_account_group.account_no like '10%' or sys_account_group.account_no like '11%' or sys_account_group.account_no like '12%') and sys_account_group_user.user_id = ".$userID."
                    order by length(sys_account_group.account_no) desc,sys_account_group.account_no desc";
                    
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    
    
    /**
     * @functional 根据用户Id返回所在 最低层级的区域组名称 
     * @author wzx
    */
    public function GetGroupNameByUserId($userID)
    {
        $arrayData = $this->GetGroupDataByUserId($userID);
        if(isset($arrayData) && count($arrayData) > 0)
            return $arrayData[0]["account_name"];
        
        return "";
    }
    
    
    /**
     * @functional 能否成为此代理商的战区经理
     * @param 战区经理ID 
     * @param 代理商注册地区ID
     * @author wzx
    */
    public function CanGetTheAgent($channelUserID,$agentRegAreaId)
    {
        $sql = "SELECT user_id, area_id FROM v_channel_manager_area where user_id=$channelUserID and area_id=$agentRegAreaId";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        if(isset($arrayData) && count($arrayData) > 0)
            return true;
            
        return false;        
    }
}
?>