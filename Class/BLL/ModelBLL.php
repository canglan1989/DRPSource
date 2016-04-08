<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_model的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-11 16:16:21
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ModelInfo.php';
require_once __DIR__.'/../../Class/BLL/UserRoleBLL.php';
require_once __DIR__.'/../../Class/BLL/ModelRightBLL.php';

class ModelBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param $objModelInfo  ModelInfo 实例
     * @return 
     */
	public function insert(ModelInfo $objModelInfo)
	{
	    $modelPath = $this->getFullPath($objModelInfo->iMgroupId,$objModelInfo->strShowName);        
        $objModelInfo->strModelPath = $modelPath;
		$sql = "INSERT INTO `sys_model`(mgroup_id,model_code,model_name,model_page,model_remark,show_name,model_path,sort_index,is_agent,is_lock,is_menu,is_del,create_uid,create_time,update_uid,update_time,product_type_ids) 
        values(".$objModelInfo->iMgroupId.",'".$objModelInfo->strModelCode."','".$objModelInfo->strModelName."','".$objModelInfo->strModelPage."','".$objModelInfo->strModelRemark."','".$objModelInfo->strShowName."','".$objModelInfo->strModelPath."',".$objModelInfo->iSortIndex.",".$objModelInfo->iIsAgent.",".$objModelInfo->iIsLock.",".$objModelInfo->iIsMenu.",".$objModelInfo->iIsDel.",".$objModelInfo->iCreateUid.",now(),".$objModelInfo->iUpdateUid.",now(),'".$objModelInfo->strProductTypeIds."')";
        $iNewID = 0;
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {
            $iNewID = $this->objMysqlDB->lastInsertId();
            if($iNewID > 0)
            {                    
                $objModelRightInfo = new ModelRightInfo();
                $objModelRightInfo->iModelId = $iNewID;
                $objModelRightInfo->iRightValue = 2;
                $objModelRightInfo->strRightName = '查看';
                $objModelRightInfo->iCreateUid = $objModelInfo->iCreateUid;
                $objModelRightBLL = new ModelRightBLL();
                $objModelRightBLL->insert($objModelRightInfo);
                /*
                $objModelRightInfo->iRightValue = 4;
                $objModelRightInfo->strRightName = '添加';
                $objModelRightBLL->insert($objModelRightInfo);
                
                $objModelRightInfo->iRightValue = 8;
                $objModelRightInfo->strRightName = '删除';
                $objModelRightBLL->insert($objModelRightInfo);*/
            }
        }
        
        $objModelCachedBLL = new ModelCachedBLL();
        $objModelCachedBLL->ClearModelPath();//清除菜单的缓存
        return $iNewID;
	}

    public function UpdateFullPath()
    {
        $sql = "update sys_model,(
        SELECT
        sys_model.model_id,
        CONCAT(root_model.mgroup_name,'>',sys_model_group.mgroup_name,'>',sys_model.model_name) as full_name FROM
        sys_model_group AS root_model 
        INNER JOIN sys_model_group 
        ON sys_model_group.is_agent = root_model.is_agent 
        AND left(sys_model_group.mgroup_no,LENGTH(sys_model_group.mgroup_no)-2) = root_model.mgroup_no 
        inner join sys_model on sys_model.mgroup_id = sys_model_group.mgroup_id where LENGTH(root_model.mgroup_no)=2) t
        set sys_model.model_path = t.full_name where sys_model.model_id = t.model_id;";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {                
            $objModelCachedBLL = new ModelCachedBLL();
            $objModelCachedBLL->ClearModelPath();//清除菜单的缓存
        }        
    }

    protected function getFullPath($mgroupID,$showName)
    {
        $strPath = "";
        $sql = "SELECT  Concat(`root_group`.`mgroup_name`,'>', `sys_model_group`.`mgroup_name`) as path_name 
        FROM 
            `sys_model_group` INNER JOIN 
            `sys_model_group` AS `root_group` ON `sys_model_group`.`mgroup_no` LIKE 
            Concat(`root_group`.`mgroup_no`, '%') AND Length(`root_group`.`mgroup_no`) = 2 
            AND `root_group`.`is_agent` = `sys_model_group`.`is_agent` 
            where Length(`sys_model_group`.`mgroup_no`) > 2 and `sys_model_group`.`mgroup_id`=".$mgroupID;         
            
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayData) && count($arrayData))
        {
            $strPath = $arrayData[0]["path_name"];
            if(strlen($strPath) > 0)
                $strPath .= ">".$showName;
            else
                $strPath = $showName;
        }
        else
            $strPath = $showName;
        return $strPath;
    } 
    
	/**
     * @functional 根据ID更新一条记录
     * @param $objModelInfo  ModelInfo 实例
     * @return
     */
	public function updateByID(ModelInfo $objModelInfo)
	{	   
        $objModelCachedBLL = new ModelCachedBLL();
        $objModelCachedBLL->ClearModelPath();//清除菜单的缓存
        
	    $objModelInfo->strModelPath = $this->getFullPath($objModelInfo->iMgroupId,$objModelInfo->strShowName); 
	   $sql = "update `sys_model` set `mgroup_id`=".$objModelInfo->iMgroupId.",`model_code`='".$objModelInfo->strModelCode."',`model_name`='".$objModelInfo->strModelName."',`model_page`='".$objModelInfo->strModelPage."',`model_remark`='".$objModelInfo->strModelRemark."',`show_name`='".$objModelInfo->strShowName."',`model_path`='".$objModelInfo->strModelPath."',`sort_index`=".$objModelInfo->iSortIndex.",`is_agent`=".$objModelInfo->iIsAgent.",`is_lock`=".$objModelInfo->iIsLock.",`is_menu`=".$objModelInfo->iIsMenu.",`is_del`=".$objModelInfo->iIsDel.",`update_uid`=".$objModelInfo->iUpdateUid.",`update_time`= now(),`product_type_ids`='".$objModelInfo->strProductTypeIds."' where model_id=".$objModelInfo->iModelId;      
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
        $objModelCachedBLL = new ModelCachedBLL();
        $objModelCachedBLL->ClearModelPath();//清除菜单的缓存
		$sql = "update `sys_model` set is_del=1,update_uid=".$userID.",update_time=now() where model_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	
	/**
     * 登录人的菜单
     * @param int $userID 登录用户ID
     * @param int $iAgentID 代理商ID
     * @return 
     */
    public function getUserMenu($userID,$iAgentID)
    {        
        if($iAgentID <= 0)
        {
            $sql = "SELECT mgroup.mgroup_id as group_id,mgroup.mgroup_name as group_name,sys_model_group.mgroup_id, 
            sys_model_group.mgroup_no, sys_model_group.mgroup_name,sys_model.show_name, sys_model.model_page 
            FROM sys_model_group 
            INNER JOIN sys_model ON (sys_model_group.mgroup_id = sys_model.mgroup_id) 
            inner join sys_model_group as mgroup on (mgroup.mgroup_no = left(sys_model_group.mgroup_no,2))
            inner join 
            (
            SELECT sys_model_right.model_id from sys_model_right
                inner join (
                    select right_id from (
                        select right_id, sum(is_forbid) as is_forbid FROM (                
                            SELECT sys_post_right.right_id, 0 as is_forbid FROM sys_user 
                            INNER JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id) 
                            INNER JOIN hr_dept_position ON (hr_employee.dept_position_id = hr_dept_position.dept_position_id) 
                            INNER JOIN sys_post_right ON (hr_dept_position.post_id = sys_post_right.post_id) where 
                            sys_user.user_id = $userID and sys_user.`is_del`=0 and sys_user.`is_lock`= 0                     
                            union all                     
                            SELECT `sys_user_right`.`right_id`,sys_user_right.`is_forbid` FROM sys_user INNER JOIN sys_user_right on 
                            (sys_user.user_id = sys_user_right.user_id) where sys_user.user_id = $userID 
                            and sys_user.`is_del`=0 and sys_user.`is_lock`= 0                         
                        ) t group by t.right_id 
                    ) tt where tt.is_forbid = 0 
                ) ttt on ttt.right_id = sys_model_right.right_id 
                where  sys_model_right.`is_del`=0 and sys_model_right.`is_lock`= 0 
                group by sys_model_right.model_id
            )tttt on tttt.model_id = sys_model.model_id
            where sys_model_group.`is_del`=0 and sys_model.`is_del`=0 and sys_model.is_menu=1    
            and sys_model_group.`is_lock`=0 and sys_model.`is_lock`=0 and sys_model_group.is_agent=0
            and mgroup.is_agent=0
            ORDER BY mgroup.sort_index,sys_model_group.sort_index, sys_model.sort_index ";
            return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        }
        else
        { 
            $objUserRoleBLL = new UserRoleBLL();
            if($objUserRoleBLL->UserIsAdmin($userID))
            {                    
                $sql = "SELECT * from (
                select mgroup.mgroup_id as group_id,mgroup.mgroup_name as group_name,sys_model_group.mgroup_id, 
                sys_model_group.mgroup_no, sys_model_group.mgroup_name,sys_model.show_name, sys_model.model_page,
                mgroup.sort_index as mgroup_sort_index,sys_model_group.sort_index as sys_model_group_sort_index, sys_model.sort_index as sys_model_sort_index  
                FROM sys_model_group         
                inner join sys_model_group as mgroup on (mgroup.mgroup_no = left(sys_model_group.mgroup_no,2))
                INNER JOIN sys_model ON (sys_model_group.mgroup_id = sys_model.mgroup_id)  
                where sys_model_group.`is_del`=0 and sys_model.`is_del`=0 and sys_model.is_menu=1  
                and sys_model_group.`is_lock`=0 and sys_model.`is_lock`=0 and sys_model_group.is_agent=1 
                and mgroup.is_agent= 1 and sys_model.`product_type_ids` = '' 
                union all 
                select distinct mgroup.mgroup_id as group_id,mgroup.mgroup_name as group_name,sys_model_group.mgroup_id, 
                sys_model_group.mgroup_no, sys_model_group.mgroup_name,sys_model.show_name, sys_model.model_page,
                mgroup.sort_index as mgroup_sort_index,sys_model_group.sort_index as sys_model_group_sort_index, sys_model.sort_index as sys_model_sort_index  
                FROM sys_model_group         
                inner join sys_model_group as mgroup on (mgroup.mgroup_no = left(sys_model_group.mgroup_no,2))
                INNER JOIN sys_model ON (sys_model_group.mgroup_id = sys_model.mgroup_id) 
                inner join `v_am_agent_pact_product` as agent_pact on (agent_pact.agent_id = $iAgentID 
                and sys_model.`product_type_ids` like concat('%,',`agent_pact`.`product_type_id`,',%')) 
                where sys_model.`product_type_ids` <> '' and sys_model_group.`is_del`=0 and sys_model.`is_del`=0 and sys_model.is_menu=1  
                and sys_model_group.`is_lock`=0 and sys_model.`is_lock`=0 and sys_model_group.is_agent=1 
                and mgroup.is_agent= 1 
                )tt                
                ORDER BY mgroup_sort_index,sys_model_group_sort_index,sys_model_sort_index ";//这里显示全部菜单
            
                return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            }
            else
            {
                $arraryUserMenu = $this->GetAgentCommentUserMenu($userID,$iAgentID);
                /*if(count($arraryUserMenu) == 0)//一个权限也没
                    return $arraryUserMenu;
                
                $sql = "SELECT finance_uid,finance_no FROM sys_user where user_id = ".$userID;
                $arrayUserData  = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
                if($arrayUserData[0]["finance_no"] != "10" && $arrayUserData[0]["finance_uid"] != $userID)
                {
                    $arraryFinanceUserMenu = $this->GetAgentCommentUserMenu($arrayUserData[0]["finance_uid"],$iAgentID);
                    $ids = "0";
                    foreach($arraryFinanceUserMenu as $key => $value)
                    {
                        $ids .= ",".$value["model_id"];
                    }            
                    
                    $ids .= ",";
                    foreach($arraryUserMenu as $key => $value)
                    {
                        if(!(strpos($ids,$value["model_id"])>0))
                            unset($arraryUserMenu[$key]);
                    }
                }*/
                return $arraryUserMenu;
            }
        }
        //print_r($sql);
    }
	
    private function GetAgentCommentUserMenu($userID,$iAgentID)
    {        
        $sql = "SELECT * from (
            select mgroup.mgroup_id as group_id,mgroup.mgroup_name as group_name,sys_model_group.mgroup_id, 
            sys_model_group.mgroup_no, sys_model_group.mgroup_name,sys_model.show_name, sys_model.model_page,
            mgroup.sort_index as mgroup_sort_index,sys_model_group.sort_index as sys_model_group_sort_index, 
            sys_model.sort_index as sys_model_sort_index,sys_model.model_id  
            FROM sys_model_group         
            inner join sys_model_group as mgroup on (mgroup.mgroup_no = left(sys_model_group.mgroup_no,2))
            INNER JOIN sys_model ON (sys_model_group.mgroup_id = sys_model.mgroup_id)  
            where sys_model_group.`is_del`=0 and sys_model.`is_del`=0 and sys_model.is_menu=1  
            and sys_model_group.`is_lock`=0 and sys_model.`is_lock`=0 and sys_model_group.is_agent=1 
            and mgroup.is_agent= 1 and sys_model.`product_type_ids` = '' 
            union all 
            select distinct mgroup.mgroup_id as group_id,mgroup.mgroup_name as group_name,sys_model_group.mgroup_id, 
            sys_model_group.mgroup_no, sys_model_group.mgroup_name,sys_model.show_name, sys_model.model_page,
            mgroup.sort_index as mgroup_sort_index,sys_model_group.sort_index as sys_model_group_sort_index,
            sys_model.sort_index as sys_model_sort_index,sys_model.model_id    
            FROM sys_model_group         
            inner join sys_model_group as mgroup on (mgroup.mgroup_no = left(sys_model_group.mgroup_no,2))
            INNER JOIN sys_model ON (sys_model_group.mgroup_id = sys_model.mgroup_id) 
            inner join `v_am_agent_pact_product` as agent_pact on (agent_pact.agent_id = $iAgentID 
            and sys_model.`product_type_ids` like concat('%,',`agent_pact`.`product_type_id`,',%')) 
            where sys_model.`product_type_ids` <> '' and sys_model_group.`is_del`=0 and sys_model.`is_del`=0 and sys_model.is_menu=1  
            and sys_model_group.`is_lock`=0 and sys_model.`is_lock`=0 and sys_model_group.is_agent=1 
            and mgroup.is_agent= 1 
            )tt 
            inner join 
            (
                SELECT sys_model_right.model_id from  sys_model_right 
                inner join (
                    select right_id from(                    
                        select right_id,sum(is_forbid) as is_forbid FROM(                    
                            SELECT sys_role_right.`right_id`,0 as is_forbid FROM  sys_user 
                            INNER JOIN sys_user_role ON (sys_user.user_id = sys_user_role.user_id) 
                            INNER JOIN sys_role_right ON (sys_user_role.role_id = sys_role_right.role_id)   
                            where sys_user.user_id= $userID and sys_user.`is_del`=0 and sys_user.`is_lock`= 0                         
                            union all   
                            SELECT `sys_user_right`.`right_id`,sys_user_right.`is_forbid` FROM  sys_user 
                            INNER JOIN sys_user_right on (sys_user.user_id = sys_user_right.user_id)   
                            where sys_user.user_id= $userID and sys_user.`is_del`=0 and sys_user.`is_lock`= 0                     
                        ) t group by t.right_id 
                    )tt where tt.is_forbid=0 
                ) ttt on ttt.right_id = sys_model_right.right_id 
                where sys_model_right.`is_del`=0 and sys_model_right.`is_lock`= 0 
                group by sys_model_right.model_id 
            )tttt on tttt.model_id = tt.model_id
        ORDER BY mgroup_sort_index,sys_model_group_sort_index,sys_model_sort_index ";
        
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
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
			$sField = T_Model::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_model` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        //exit($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个 ModelInfo 对象
	 * @param int $id 
     * @return ModelInfo 对象
     */
	public function getModelByID($id)
	{
		$objModelInfo = null;
		$arrayInfo = $this->select("*","model_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objModelInfo = new ModelInfo();
            		
        
            $objModelInfo->iModelId = $arrayInfo[0]['model_id'];
            $objModelInfo->iMgroupId = $arrayInfo[0]['mgroup_id'];
            $objModelInfo->strModelCode = $arrayInfo[0]['model_code'];
            $objModelInfo->strModelName = $arrayInfo[0]['model_name'];
            $objModelInfo->strModelPage = $arrayInfo[0]['model_page'];
            $objModelInfo->strModelRemark = $arrayInfo[0]['model_remark'];
            $objModelInfo->strShowName = $arrayInfo[0]['show_name'];
            $objModelInfo->strModelPath = $arrayInfo[0]['model_path'];
            $objModelInfo->iSortIndex = $arrayInfo[0]['sort_index'];
            $objModelInfo->iIsAgent = $arrayInfo[0]['is_agent'];
            $objModelInfo->iIsLock = $arrayInfo[0]['is_lock'];
            $objModelInfo->iIsMenu = $arrayInfo[0]['is_menu'];
            $objModelInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objModelInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objModelInfo->strCreateTime = $arrayInfo[0]['create_time'];
            $objModelInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
            $objModelInfo->strUpdateTime = $arrayInfo[0]['update_time'];
            $objModelInfo->strProductTypeIds = $arrayInfo[0]['product_type_ids'];
            settype($objModelInfo->iModelId,"integer");
            settype($objModelInfo->iMgroupId,"integer");
            settype($objModelInfo->iSortIndex,"integer");
            settype($objModelInfo->iIsAgent,"integer");
            settype($objModelInfo->iIsLock,"integer");
            settype($objModelInfo->iIsMenu,"integer");
            settype($objModelInfo->iIsDel,"integer");
            settype($objModelInfo->iCreateUid,"integer");
            settype($objModelInfo->iUpdateUid,"integer");
		}
		
		return $objModelInfo;
	}
	
    
    public function LockModel($id,$updateUid)
    {
        $sql = "update `sys_model` set `is_lock` = if(`is_lock`=1,0,1),`update_uid`=".$updateUid
        .", `update_time`=now() where model_id=".$id;
        //print_r($sql);
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }    
    
    
    public function GetModelRightPositionList($modelID)
    {
        $sql = "SELECT v_hr_employee.e_name,v_hr_employee.dept_fullname,sys_user.user_id,sys_user.user_name,v_hr_employee.post_id,
        v_hr_employee.post_name,sys_model_right.right_id,sys_model_right.right_name,sys_model.model_id FROM 
        v_hr_employee INNER JOIN sys_user ON v_hr_employee.e_id = sys_user.e_uid 
        INNER JOIN sys_post_right ON sys_post_right.post_id = v_hr_employee.post_id 
        LEFT JOIN sys_model_right ON sys_model_right.right_id = sys_post_right.right_id 
        LEFT JOIN sys_model ON sys_model.model_id = sys_model_right.model_id 
        where sys_user.agent_id<=0 and sys_user.is_del =0 and sys_model.model_id={$modelID} 
        order by v_hr_employee.post_name,sys_user.user_name,v_hr_employee.e_name,v_hr_employee.dept_fullname,sys_model_right.right_name";
         return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    
    public function GetModelRightUserList($modelID)
    {
        $sql = "SELECT sys_user.e_name, v_hr_employee.dept_fullname,sys_user.user_id,sys_user.user_name,
        v_hr_employee.post_name,sys_model_right.right_id,sys_model_right.right_name,sys_model.model_id FROM 
        sys_user 
        INNER JOIN sys_user_right ON sys_user.user_id = sys_user_right.user_id 
        INNER JOIN sys_model_right ON sys_user_right.right_id = sys_model_right.right_id 
        INNER JOIN sys_model ON sys_model_right.model_id = sys_model.model_id 
        INNER JOIN v_hr_employee ON v_hr_employee.e_id = sys_user.e_uid 
        where sys_user.agent_id<=0 and sys_user.is_del =0 and sys_user.is_lock =0 
        and sys_model.model_id={$modelID} and sys_user_right.is_allow=1 
        order by sys_model_right.right_name,sys_user.user_name,v_hr_employee.e_name,v_hr_employee.post_name,v_hr_employee.dept_fullname";
        
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
}
?>