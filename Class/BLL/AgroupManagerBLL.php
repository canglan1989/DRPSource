<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_agroup_manager的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-25 13:33:18
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AgroupManagerInfo.php';

class AgroupManagerBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AgroupManagerInfo $objAgroupManagerInfo  AgroupManager实例
     * @return 
     */
	public function insert(AgroupManagerInfo $objAgroupManagerInfo)
	{
		$sql = "INSERT INTO `sys_agroup_manager`(`user_id`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`)"
		." values(".$objAgroupManagerInfo->iUserId.",".$objAgroupManagerInfo->iIsDel.",".$objAgroupManagerInfo->iUpdateUid.",now(),".$objAgroupManagerInfo->iCreateUid.",now())";
        $iNewID = 0 ;
        if($this->objMysqlDB->executeNonQuery(false,$sql,null)>0)
            $iNewID = $this->objMysqlDB->lastInsertId();
        return $iNewID;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param AgroupManagerInfo $objAgroupManagerInfo  AgroupManager实例
     * @return
     */
	public function updateByID(AgroupManagerInfo $objAgroupManagerInfo)
	{
		$sql = "update `sys_agroup_manager` set `user_id`=".$objAgroupManagerInfo->iUserId.",`is_del`=".$objAgroupManagerInfo->iIsDel.",`update_uid`=".$objAgroupManagerInfo->iUpdateUid.",`update_time`= now() where agroup_manager_id=".$objAgroupManagerInfo->iAgroupManagerId;
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
		$sql = "update `sys_agroup_manager` set is_del=1,update_uid=".$userID.",update_time=now() where agroup_manager_id=".$id;
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
			$sField = T_AGroupManager::AllFields;
            
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
			
		$sql = "SELECT ".$sField." FROM `sys_agroup_manager` ".$sWhere.$sGroup.$sOrder.$sLimit ;

        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_agroup_manager对象
	 * @param int $id 
     * @return sys_agroup_manager对象
     */
	public function getModelByID($id)
	{
		$objAgroupManagerInfo = null;
		$arrayInfo = $this->select("*","agroup_manager_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAgroupManagerInfo = new AgroupManagerInfo();
			$objAgroupManagerInfo->iAgroupManagerId = $arrayInfo[0]['agroup_manager_id'];
			$objAgroupManagerInfo->iUserId = $arrayInfo[0]['user_id'];
			$objAgroupManagerInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objAgroupManagerInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objAgroupManagerInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objAgroupManagerInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAgroupManagerInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objAgroupManagerInfo->iAgroupManagerId,"integer");
			settype($objAgroupManagerInfo->iUserId,"integer");
			settype($objAgroupManagerInfo->iIsDel,"integer");
			settype($objAgroupManagerInfo->iUpdateUid,"integer");			
			settype($objAgroupManagerInfo->iCreateUid,"integer");			
		}
		
		return $objAgroupManagerInfo;
	}
	
    /**
     * @functional 取得区域绑定详细信息
     */
    public function GetAreaGroupManagerInfo($agroup_manager_id)
    {
        $sql = "SELECT sys_user.user_id, sys_user.e_name,  sys_user.user_name,  sys_user.dept_name,  sys_user.tel,  sys_user.phone,
          sys_agroup_manager.agroup_manager_id
        FROM
          sys_agroup_manager
          INNER JOIN sys_user ON (sys_agroup_manager.user_id = sys_user.user_id) where sys_agroup_manager.agroup_manager_id =$agroup_manager_id";
       
       return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
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
        if($strOrder == "")
            $strOrder = "sys_user.user_name";
        
		$sqlCount = "SELECT count(1) as `counts`
            from sys_agroup_manager  
            INNER JOIN sys_user ON (sys_agroup_manager.user_id = sys_user.user_id) 
            left join 
            (select 
            sys_agroup_manager_detail.agroup_manager_id,group_concat(sys_area_group.agroup_name) as agroup_name 
             FROM sys_agroup_manager_detail 
            inner join `sys_area_group` on `sys_area_group`.agroup_id = sys_agroup_manager_detail.agroup_id 
            left join ( 
                select agroup_id from (
                    SELECT sys_area_group_detail.`agroup_id`
                    FROM sys_area_group_detail 
                        where sys_area_group_detail.`is_del`=0 
                    ) t 
                ) tt on tt.agroup_id = sys_agroup_manager_detail.`agroup_id` 
            group by sys_agroup_manager_detail.agroup_manager_id
            )ttt on ttt.agroup_manager_id = sys_agroup_manager.agroup_manager_id 
            where sys_agroup_manager.`is_del`=0 and sys_user.`agent_id`<=0 $strWhere";
        
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		//print_r($iRecordCount);
        
        $sqlData  = "SELECT sys_agroup_manager.agroup_manager_id,sys_user.user_id, sys_user.e_name, sys_user.user_name, sys_user.dept_name, sys_user.tel, sys_user.phone, 
            ttt.agroup_name
            from sys_agroup_manager  
            INNER JOIN sys_user ON (sys_agroup_manager.user_id = sys_user.user_id) 
            left join 
            (select 
            sys_agroup_manager_detail.agroup_manager_id,group_concat(r.agroup_name) as agroup_name 
             FROM sys_agroup_manager_detail 
            inner join (select `sys_area_group`.agroup_id,`sys_area_group`.agroup_name
            from `sys_area_group`             
            where `sys_area_group`.is_del=0 and `sys_area_group`.is_group=1
            ) r on r.agroup_id = sys_agroup_manager_detail.agroup_id 
            left join ( 
                select agroup_id from (
                    SELECT sys_area_group_detail.`agroup_id`
                    FROM sys_area_group_detail                  
                        where sys_area_group_detail.`is_del`=0 
                    ) t 
                ) tt on tt.agroup_id = sys_agroup_manager_detail.`agroup_id` 
            group by sys_agroup_manager_detail.agroup_manager_id
            )ttt on ttt.agroup_manager_id = sys_agroup_manager.agroup_manager_id 
            where sys_agroup_manager.`is_del`=0 and sys_user.`agent_id`<=0  $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
      //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
	}
	public function selectPaged2($iPageIndex,$iPageSize,$strPageFields,$strWhere,$strOrder,&$iRecordCount)
	{
        $offset = ($iPageIndex-1)*$iPageSize;
        if($strOrder == "")
            $strOrder = "sys_user.user_name";
            
        $arrayAreaID = explode(",",$strPageFields);
        settype($arrayAreaID[0],"integer");
        settype($arrayAreaID[1],"integer");
        settype($arrayAreaID[2],"integer");
                
        if(($arrayAreaID[0]+$arrayAreaID[1] +$arrayAreaID[2]) > 0)        
        {
            $strWhere .= " and sys_agroup_manager.agroup_manager_id in 
            (
            select sys_agroup_manager_detail.agroup_manager_id from sys_agroup_manager_detail 
            inner join `sys_area_group` on `sys_area_group`.agroup_id = sys_agroup_manager_detail.agroup_id 
            inner join ( 
                select agroup_id from (
                    SELECT sys_area_group_detail.`agroup_id`, 
                    if(sys_area.`area_no`,sys_area.area_no,'') as area_no, 
                    if(sys_city.`city_no`,sys_city.city_no,'') as city_no, 
                    if(sys_province.`province_no`,sys_province.province_no,'') as province_no
                    FROM sys_area_group_detail 
                    left JOIN sys_area ON (sys_area_group_detail.area_id = sys_area.area_id ".
                        (($arrayAreaID[0] > 0)? " and sys_area.province_id=".$arrayAreaID[0] : "").
                        (($arrayAreaID[1] > 0)? " and sys_area.city_id=".$arrayAreaID[1] : "").
                        (($arrayAreaID[2] > 0)? " and sys_area.area_id=".$arrayAreaID[2] : "")
                        .") 
                        left JOIN sys_city ON (sys_area_group_detail.city_id = sys_city.city_id ".
                        (($arrayAreaID[0] > 0)? " and sys_city.province_id=".$arrayAreaID[0] : "").
                        (($arrayAreaID[1] > 0)? " and sys_city.city_id=".$arrayAreaID[1] : "")
                        .") 
                        left JOIN sys_province ON (sys_area_group_detail.province_id = sys_province.province_id ".
                        (($arrayAreaID[0] > 0)? " and sys_province.province_id=".$arrayAreaID[0] : "")
                        .")                                  
                        where sys_area_group_detail.`is_del`=0 
                    ) t 
                    where length(CONCAT(province_no,city_no,area_no)) >0 
                    group by agroup_id
                ) tt on tt.agroup_id = sys_agroup_manager_detail.`agroup_id` 
            group by sys_agroup_manager_detail.agroup_manager_id)";
        }
        
		$sqlCount = "SELECT count(1) as `counts`
            from sys_agroup_manager  
            INNER JOIN sys_user ON (sys_agroup_manager.user_id = sys_user.user_id) 
            left join 
            (select 
            sys_agroup_manager_detail.agroup_manager_id,group_concat(sys_area_group.agroup_name) as agroup_name 
             FROM sys_agroup_manager_detail 
            inner join `sys_area_group` on `sys_area_group`.agroup_id = sys_agroup_manager_detail.agroup_id 
            left join ( 
                select agroup_id,CONCAT(area_fullname,city_fullname,province_name) as area_name from (
                    SELECT sys_area_group_detail.`agroup_id`, if(sys_area.area_fullname,sys_area.area_fullname,'') as area_fullname,
                    if(sys_area.`area_no`,sys_area.area_no,'') as area_no, 
                    if(sys_city.city_fullname,sys_city.city_fullname,'') as city_fullname,
                    if(sys_city.`city_no`,sys_city.city_no,'') as city_no, 
                    if(sys_province.province_name,sys_province.province_name,'') as province_name, 
                    if(sys_province.`province_no`,sys_province.province_no,'') as province_no
                    FROM sys_area_group_detail 
                    left JOIN sys_area ON (sys_area_group_detail.area_id = sys_area.area_id) 
                        left JOIN sys_city ON (sys_area_group_detail.city_id = sys_city.city_id ) 
                        left JOIN sys_province ON (sys_area_group_detail.province_id = sys_province.province_id )                   
                        where sys_area_group_detail.`is_del`=0 
                    ) t 
                    where length(CONCAT(province_no,city_no,area_no)) >0 
                    group by agroup_id order by CONCAT(province_no,city_no,area_no) 
                ) tt on tt.agroup_id = sys_agroup_manager_detail.`agroup_id` 
            group by sys_agroup_manager_detail.agroup_manager_id
            )ttt on ttt.agroup_manager_id = sys_agroup_manager.agroup_manager_id 
            where sys_agroup_manager.`is_del`=0 and sys_user.`agent_id`<=0 $strWhere";
        
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		//print_r($iRecordCount);
        

        $sqlData  = "SELECT sys_agroup_manager.agroup_manager_id,sys_user.user_id, sys_user.e_name, sys_user.user_name, sys_user.dept_name, sys_user.tel, sys_user.phone, 
            ttt.agroup_name
            from sys_agroup_manager  
            INNER JOIN sys_user ON (sys_agroup_manager.user_id = sys_user.user_id) 
            left join 
            (select 
            sys_agroup_manager_detail.agroup_manager_id,group_concat(sys_area_group.agroup_name) as agroup_name 
             FROM sys_agroup_manager_detail 
            inner join `sys_area_group` on `sys_area_group`.agroup_id = sys_agroup_manager_detail.agroup_id 
            left join ( 
                select agroup_id,CONCAT(area_fullname,city_fullname,province_name) as area_name from (
                    SELECT sys_area_group_detail.`agroup_id`, if(sys_area.area_fullname,sys_area.area_fullname,'') as area_fullname,
                    if(sys_area.`area_no`,sys_area.area_no,'') as area_no, 
                    if(sys_city.city_fullname,sys_city.city_fullname,'') as city_fullname,
                    if(sys_city.`city_no`,sys_city.city_no,'') as city_no, 
                    if(sys_province.province_name,sys_province.province_name,'') as province_name, 
                    if(sys_province.`province_no`,sys_province.province_no,'') as province_no
                    FROM sys_area_group_detail 
                    left JOIN sys_area ON (sys_area_group_detail.area_id = sys_area.area_id) 
                        left JOIN sys_city ON (sys_area_group_detail.city_id = sys_city.city_id ) 
                        left JOIN sys_province ON (sys_area_group_detail.province_id = sys_province.province_id)                   
                        where sys_area_group_detail.`is_del`=0 
                    ) t 
                    where length(CONCAT(province_no,city_no,area_no)) >0 
                    group by agroup_id order by CONCAT(province_no,city_no,area_no) 
                ) tt on tt.agroup_id = sys_agroup_manager_detail.`agroup_id` 
            group by sys_agroup_manager_detail.agroup_manager_id
            )ttt on ttt.agroup_manager_id = sys_agroup_manager.agroup_manager_id 
            where sys_agroup_manager.`is_del`=0 and sys_user.`agent_id`<=0  $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
      //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
	}
    
   	/**
     * @functional 删除分组
     * @param int $agoup_manager_id
     */
    public function DelGroups($agoup_manager_id,$updateUid)
    {
        $sql = "delete from `sys_agroup_manager_detail` where `agroup_manager_id` = $agoup_manager_id";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
    
   	/**
     * @functional 添加分组
     * @param int $agoup_manager_id
     */
    public function AddGroups($agoup_manager_id,$strGroupIDs,$updateUid)
    {
        $iAddCount = 0;
        if(strlen($strGroupIDs)>0)
        {
            $sql = "INSERT INTO `sys_agroup_manager_detail`(`agroup_manager_id`,`agroup_id`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`) values ";
        
            $arrayGroupID = explode(",",$strGroupIDs);
            $arrayLength = count($arrayGroupID);
            for($i = 0;$i < $arrayLength; $i++)
            {                
               $sql .= "($agoup_manager_id,".$arrayGroupID[$i].",0,0,now(),$updateUid,now())";
               if($i != $arrayLength-1)
                $sql .= ",";
            }
            $iAddCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        } 
        
        return $iAddCount;
    }
    
    /**
     * @functional 获取可以绑定区域的用户
    */
    public function AutoUserForBindAreaJson($strUserName)
    {
        $sql = "select user_id,user_name,e_name from sys_user where is_del=0 and agent_id<=0 
            and (user_name like '%$strUserName%' or e_name like '%$strUserName%') and user_id not in(
            select concat(user_id) as user_id from `sys_agroup_manager` gm where gm.is_del=0
            ) order by user_name limit 0,100";
    
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
    
    /**
     * @functional 根据用户ID取得下属行政区域
    */
    public function getAreaById($userdId)
    {
        $sql = "select g.* from `sys_area_group` as g inner join(
                select `sys_area_group`.agroup_id,`sys_area_group`.group_no,`sys_area_group`.agroup_name from `sys_area_group` 
                inner join `sys_agroup_manager_detail` on (`sys_area_group`.`agroup_id`=`sys_agroup_manager_detail`.`agroup_id`) 
                inner join `sys_agroup_manager` on (`sys_agroup_manager_detail`.agroup_manager_id=`sys_agroup_manager`.`agroup_manager_id`)
                where `sys_agroup_manager`.user_id=$userdId  and `sys_area_group`.is_del=0 and sys_area_group.is_group = 1
                ) t
                on g.group_no like concat(t.group_no,'%')
                where g.is_group=0 and g.is_del=0 and LENGTH(g.group_no)>LENGTH(t.group_no)";
                
       $arrayArea = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
}
?>