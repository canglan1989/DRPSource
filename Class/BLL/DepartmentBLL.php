<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表hr_department的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:28
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/DepartmentInfo.php';
require_once __DIR__.'/../../Config/PublicEnum.php';

class DepartmentBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param DepartmentInfo $objDepartmentInfo  Department实例
     * @return 
     */
	public function insert(DepartmentInfo $objDepartmentInfo)
	{
		$sql = "INSERT INTO `hr_department`(`dept_no`,`dept_name`,`dept_type`,`dept_fullname`,`data_type`,`is_lock`,`is_del`,`create_uid`,`create_time`,`hr_dept_fk`)"
		." values('".$objDepartmentInfo->strDeptNo."','".$objDepartmentInfo->strDeptName."',".$objDepartmentInfo->iDeptType.",'".$objDepartmentInfo->strDeptFullname."',".$objDepartmentInfo->iDataType.",".$objDepartmentInfo->iIsLock.",".$objDepartmentInfo->iIsDel.",".$objDepartmentInfo->iCreateUid.",now(),".$objDepartmentInfo->iHrDeptFk.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param DepartmentInfo $objDepartmentInfo  Department实例
     * @return
     */
	public function updateByID(DepartmentInfo $objDepartmentInfo)
	{
		$sql = "update `hr_department` set `dept_no`='".$objDepartmentInfo->strDeptNo."',`dept_name`='".$objDepartmentInfo->strDeptName."',`dept_type`=".$objDepartmentInfo->iDeptType.",`dept_fullname`='".$objDepartmentInfo->strDeptFullname."',`data_type`=".$objDepartmentInfo->iDataType.",`is_lock`=".$objDepartmentInfo->iIsLock.",`is_del`=".$objDepartmentInfo->iIsDel.",`hr_dept_fk`=".$objDepartmentInfo->iHrDeptFk." where dept_id=".$objDepartmentInfo->iDeptId;
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
		$sql = "update `hr_department` set is_del=1,update_uid=".$userID.",update_time=now() where dept_id=".$id;
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
			$sField = T_Department::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where is_del=0 and ".$sWhere;
		else
			$sWhere = " where is_del=0";
		
		if ($sOrder == "")
			$sOrder = " order by dept_no";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `hr_department` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个hr_department对象
	 * @param int $id 
     * @return hr_department对象
     */
	public function getModelByID($id)
	{
		$objDepartmentInfo = null;
		$arrayInfo = $this->select("*","dept_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objDepartmentInfo = new DepartmentInfo();
			$objDepartmentInfo->iDeptId = $arrayInfo[0]['dept_id'];
			$objDepartmentInfo->strDeptNo = $arrayInfo[0]['dept_no'];
			$objDepartmentInfo->strDeptName = $arrayInfo[0]['dept_name'];
			$objDepartmentInfo->iDeptType = $arrayInfo[0]['dept_type'];
			$objDepartmentInfo->strDeptFullname = $arrayInfo[0]['dept_fullname'];
			$objDepartmentInfo->iDataType = $arrayInfo[0]['data_type'];
			$objDepartmentInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objDepartmentInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objDepartmentInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objDepartmentInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objDepartmentInfo->iHrDeptFk = $arrayInfo[0]['hr_dept_fk'];
		
			settype($objDepartmentInfo->iDeptId,"integer");			
			settype($objDepartmentInfo->iDeptType,"integer");			
			settype($objDepartmentInfo->iDataType,"integer");
			settype($objDepartmentInfo->iIsLock,"integer");
			settype($objDepartmentInfo->iIsDel,"integer");
			settype($objDepartmentInfo->iCreateUid,"integer");			
			settype($objDepartmentInfo->iHrDeptFk,"integer");
		}
		
		return $objDepartmentInfo;
	}
    
    
	/**
     * @functional 返回当前个人上级领导的信息
	 * @param int $e_id 当前员工ID 
     */
    public function next_department_position($e_id)
    {
        $sql = "select `dept_no`,`post_sort_index`,`level_sort_index`,`dp_up` from `v_hr_employee` where e_id = $e_id";
       
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
        if (isset($arrayData)&& count($arrayData)>0)
        { 
            $dp_up = $arrayData[0]["dp_up"];///m
            settype($dp_up,"integer");
            if($dp_up > 0)//有特殊指定直接汇报上级
            {
                $sql = "select * from `v_hr_employee` where `dept_position_id` = $dp_up";
                
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
                if (isset($arrayData)&& count($arrayData)>0)
                    return $arrayData;
                    
                return "";
            }
            
            $p_dept_no = $arrayData[0]["dept_no"];////
            $strDeptNo = $p_dept_no;
            
            $post_sort_index = $arrayData[0]["post_sort_index"];
            $level_sort_index = $arrayData[0]["level_sort_index"];
            
            while(strlen($p_dept_no) >= 4)
            {                
                $sql = "select * from `v_hr_employee` 
                where dept_no = '$p_dept_no' and post_sort_index >= $post_sort_index and level_sort_index < $level_sort_index 
                and  v_hr_employee.e_status <> ".EmployeeStates::Hide." and v_hr_employee.e_status > ".EmployeeStates::Have_left."  
                order by `post_sort_index` desc,`level_sort_index` desc limit 0,5";
            
                $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);   
                if (isset($arrayData)&& count($arrayData)>0)
                {
                     return $arrayData;
                }
                
                $p_dept_no = substr($p_dept_no,0,strlen($p_dept_no)-2);         
            }
            
            $p_dept_no = substr($strDeptNo,0,strlen($strDeptNo)-2);
            //AB岗
            $sql = "select * from `v_hr_abpost`  
            where dept_no = '$p_dept_no' and post_sort_index >= $post_sort_index and level_sort_index < $level_sort_index 
            and  v_hr_abpost.e_status <> ".EmployeeStates::Hide." and v_hr_abpost.e_status > ".EmployeeStates::Have_left."  
            order by `post_sort_index` desc,`level_sort_index` desc";
            
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
            if (isset($arrayData)&& count($arrayData)>0)
                return $arrayData;
                    
        }
        
        return "";
        
    }
    
    
	/**
     * @functional 取得盘石公司ID
     */
    public function GetPanShiCompanyID()
    {
        $panShiCompanyID = 0;
        $sql = "select `dept_id` from `hr_department` where `dept_no`='10'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);        
            if (isset($arrayData)&& count($arrayData)>0)
                return $arrayData[0]["dept_id"];
                
        return $panShiCompanyID;
    }
    
    /**
     * 根据ID获取部门编号
     * @param type $iUserId
     * @return type 
     */
    public function getDeptNoByUserId($iUserId){
        $sql = "select agent_id,dept_no from sys_user 
                left join v_hr_employee on sys_user.e_uid = v_hr_employee.e_id
                where sys_user.user_id = {$iUserId}";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);  
    }
}
?>