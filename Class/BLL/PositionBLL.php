<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表hr_position的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:28
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/PositionInfo.php';
require_once __DIR__.'/../../Class/BLL/PostRightBLL.php';

class PositionBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param PositionInfo $objPositionInfo  Position实例
     * @return 
     */
	public function insert(PositionInfo $objPositionInfo)
	{
		$sql = "INSERT INTO `hr_position`(`level_id`,`post_name`,`sort_index`,`is_lock`,`is_del`,`create_uid`,`create_time`)"
		." values(".$objPositionInfo->iLevelId.",'".$objPositionInfo->strPostName."',".$objPositionInfo->iSortIndex.",".$objPositionInfo->iIsLock.",".$objPositionInfo->iIsDel.",".$objPositionInfo->iCreateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param PositionInfo $objPositionInfo  Position实例
     * @return
     */
	public function updateByID(PositionInfo $objPositionInfo)
	{
		$sql = "update `hr_position` set `level_id`=".$objPositionInfo->iLevelId.",`post_name`='".$objPositionInfo->strPostName."',`sort_index`=".$objPositionInfo->iSortIndex.",`is_lock`=".$objPositionInfo->iIsLock.",`is_del`=".$objPositionInfo->iIsDel." where post_id=".$objPositionInfo->iPostId;
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
		$sql = "update `hr_position` set is_del=1,update_uid=".$userID.",update_time=now() where post_id=".$id;
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
			$sField = T_Position::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `hr_position` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个hr_position对象
	 * @param int $id 
     * @return hr_position对象
     */
	public function getModelByID($id)
	{
		$objPositionInfo = null;
		$arrayInfo = $this->select("*","post_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objPositionInfo = new PositionInfo();
			$objPositionInfo->iPostId = $arrayInfo[0]['post_id'];
			$objPositionInfo->iLevelId = $arrayInfo[0]['level_id'];
			$objPositionInfo->strPostName = $arrayInfo[0]['post_name'];
			$objPositionInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objPositionInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objPositionInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objPositionInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objPositionInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objPositionInfo->iPostId,"integer");
			settype($objPositionInfo->iLevelId,"integer");
			
			settype($objPositionInfo->iSortIndex,"integer");
			settype($objPositionInfo->iIsLock,"integer");
			settype($objPositionInfo->iIsDel,"integer");
			settype($objPositionInfo->iCreateUid,"integer");
			
		}
		
		return $objPositionInfo;
	}	
    
    /**
     * @functional 职位信息
     * @param int $post_id 职位ID
    */
    public function getPositionInfo($post_id)
    {        
        $sqlData  = "SELECT hr_company.company_name,  hr_department.dept_name,  hr_department.data_type,  
        hr_dept_position.position_state,  hr_position.post_id,  hr_department.dept_id,
        hr_position.post_name,  hr_position.sort_index,  hr_level.level_name,  hr_level.m_value,hr_position.`create_time`           
        FROM  hr_dept_position 
        INNER JOIN hr_position ON (hr_dept_position.post_id = hr_position.post_id)
        LEFT OUTER JOIN hr_department ON (hr_department.dept_id = hr_dept_position.hr_dept_id)
        LEFT OUTER JOIN hr_level ON (hr_position.level_id = hr_level.level_id) 
        left join (select company.dept_no,company.`dept_name` as company_name from  hr_department company 
        where company.`is_del`=0 and company.`data_type`='1' ) hr_company 
        ON (hr_company.dept_no = LEFT(hr_department.dept_no,2)) 
        WHERE
        hr_dept_position.is_del = 0 AND  hr_department.is_del = 0 AND  hr_position.is_del = 0 AND  hr_level.is_del = 0 
        and hr_position.post_id = $post_id order by hr_company.dept_no,hr_department.dept_no, hr_position.sort_index LIMIT 0,1";
        //print_r($sqlData);
        return $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
    }
    
    /**
     * @functional 分页组装数据
     * @author wzx 2011.07.16
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
	   return self::selectPaged2($iPageIndex,$iPageSize,$strWhere,$iRecordCount);
	}
    
    /**
     * @functional 职位列表分页数据
     * @author wzx 2011.07.16
     * @param int $iPageIndex
	 * @param int $iPageSize
	 * @param string $strCompanyNo 公司  
     * @param int $iDeptID 部门
     * @param string $strPostName 职位名称
	 * @param int &$iRecordCount
	 * @desc 
    */
	protected function selectPaged2($iPageIndex,$iPageSize,$sWhere,&$iRecordCount)
	{
	    $offset = ($iPageIndex-1)*$iPageSize;
        $iRecordCount = 0;
        $sqlCount = "SELECT count(1) as `counts`
        FROM (SELECT distinct hr_company.company_name,  hr_department.dept_name,  hr_department.data_type,  
        hr_dept_position.position_state,  hr_position.post_id,  hr_department.dept_id,
        hr_position.post_name,  hr_position.sort_index,  hr_level.level_name,  hr_level.m_value,hr_position.`create_time`           
        FROM hr_dept_position 
        inner join hr_employee on hr_employee.dept_position_id = hr_dept_position.dept_position_id
        inner join sys_user on sys_user.e_uid = hr_employee.e_id 
        INNER JOIN hr_position ON (hr_dept_position.post_id = hr_position.post_id) 
        INNER JOIN hr_department ON (hr_department.dept_id = hr_dept_position.hr_dept_id) 
        
        LEFT OUTER JOIN hr_level ON (hr_position.level_id = hr_level.level_id) 
        left join (
            select company.dept_no,company.`dept_name` as company_name 
            from hr_department company where company.`is_del`=0 and company.`data_type`='1' 
        ) hr_company ON (
        hr_company.dept_no = LEFT(hr_department.dept_no,2)
        
        ) WHERE hr_dept_position.is_del = 0 AND hr_department.is_del = 0 and sys_user.is_del=0 and sys_user.agent_id<=0 
        AND hr_position.is_del = 0 AND hr_level.is_del = 0 $sWhere)t";
        
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);

        $sqlData  = "SELECT distinct hr_company.company_name,  hr_department.dept_name,  hr_department.data_type,  
        hr_dept_position.position_state,  hr_position.post_id,  hr_department.dept_id,
        hr_position.post_name,  hr_position.sort_index,  hr_level.level_name,  hr_level.m_value,hr_position.`create_time`           
        FROM hr_dept_position 
        inner join hr_employee on hr_employee.dept_position_id = hr_dept_position.dept_position_id
        inner join sys_user on sys_user.e_uid = hr_employee.e_id 
        INNER JOIN hr_position ON (hr_dept_position.post_id = hr_position.post_id) 
        INNER JOIN hr_department ON (hr_department.dept_id = hr_dept_position.hr_dept_id) 
        
        LEFT OUTER JOIN hr_level ON (hr_position.level_id = hr_level.level_id) 
        left join (
            select company.dept_no,company.`dept_name` as company_name 
            from hr_department company where company.`is_del`=0 and company.`data_type`='1' 
        ) hr_company ON (
        hr_company.dept_no = LEFT(hr_department.dept_no,2)
        
        ) WHERE hr_dept_position.is_del = 0 AND hr_department.is_del = 0 and sys_user.is_del=0 and sys_user.agent_id<=0 
        AND hr_position.is_del = 0 AND hr_level.is_del = 0 $sWhere 
        order by hr_company.dept_no,hr_department.dept_no, hr_position.sort_index LIMIT $offset,$iPageSize";
        //print_r($sqlData);
        return $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);        
	}
    
    /**
     * @functional 取得职位权限 列出权限列表 具有的权限 is_check 标记为 1
     */
    public function selectPositionRight($rootModelGroupNo,$positionID)
    {
        $sql = "SELECT sys_model_group.`mgroup_name`,sys_model.`model_id`,sys_model.`model_name`,sys_model_right.`right_id`,
        sys_model_right.`right_value`,sys_model_right.`right_name`,sys_model_right.`right_remark`,        
        if(sys_model_group.`is_lock`,1,if(`sys_model`.`is_lock`,1,IF(sys_model_right.`is_lock`,1,0))) as is_lock, if(t.right_id,1,0) as is_check
        FROM sys_model_group INNER JOIN sys_model ON (sys_model_group.mgroup_id = sys_model.mgroup_id) 
        INNER JOIN sys_model_right ON (sys_model.model_id = sys_model_right.model_id) 
        left join (select sys_post_right.`right_id` from sys_post_right 
        INNER JOIN hr_position ON hr_position.post_id = sys_post_right.post_id 
        WHERE hr_position.`is_del`=0 and  hr_position.`post_id`= $positionID ) t on t.right_id = sys_model_right.`right_id` 
        where sys_model_group.`is_del` = 0 and sys_model_group.`is_agent`= 0 
        and sys_model_group.`mgroup_no` like '$rootModelGroupNo%' 
        and sys_model.`is_del` = 0 and sys_model_right.`is_del`=0 and LENGTH(sys_model_group.`mgroup_no`)>2  
        order by sys_model_group.`sort_index`,sys_model.`sort_index`,sys_model_right.`right_value`";
        //print_r($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
        
     /**
     * @functional 职位权限添加或删除
     */
    public function AddRight($positionID,$rightID,$bIsAdd,$updateUid)
    {
        $postRightBLL = new PostRightBLL();
        if($bIsAdd)
        {    
            if(count($postRightBLL->select("1","`post_id`=$positionID and `right_id`=$rightID")) > 0)//未找到权限才进行添加
                return 0;
                
            return $postRightBLL->insert($positionID,$rightID,$updateUid);
        }
        else
        {
            return $postRightBLL->delete($positionID,$rightID);
        }
    }
                 
     /**
     * @functional 职位权限批量添加
     */
    public function AddRights($positionID,$addRightIDs,$updateUid)
    {
        $iAddCount = 0;
        
        if(strlen($addRightIDs)>0)
        {
            $objPostRightBLL = new PostRightBLL();
            $bHaveAddData = false;
            $arrayRightID = explode(",",$addRightIDs);
            $arrayLength = count($arrayRightID);
            $sql = "INSERT INTO `sys_post_right`(`post_id`,`right_id`,`create_uid`,`create_time`) values ";
            for($i = 0;$i < $arrayLength; $i++)
            {
                if(count($objPostRightBLL->select("1","`post_id`=$positionID and `right_id`=$arrayRightID[$i]")) > 0)//未找到权限才进行添加
                    continue;
                    
                $sql .= "($positionID,$arrayRightID[$i],$updateUid,now()),";                
                $bHaveAddData = true;
            }
            
            if($bHaveAddData)
            {
                $sql = substr($sql,0,strlen($sql)-1);           
                $sql .= ";";
                $iAddCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
            }
        }
                
        return $iAddCount;
    }
     
     /**
     * @functional 职位权限批量删除
     */
    public function DelRights($positionID,$delRightIDs,$updateUid)
    {
        $iDelCount = 0;
        $sql = "";
        if(strlen($delRightIDs)>0)
        {
            $sql = "delete from sys_post_right where post_id = $positionID and right_id in({$delRightIDs})";
        } 
        else
        {
            $sql = "delete from sys_post_right where post_id = $positionID";
        }
        
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
}
?>