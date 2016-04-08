<?PHP

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表hr_employee的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 8:41:40
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/EmployeeInfo.php';

class EmployeeBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param EmployeeInfo $objEmployeeInfo  Employee实例
     * @return 
     */
	public function insert(EmployeeInfo $objEmployeeInfo)
	{
		$sql = "INSERT INTO `hr_employee`(`e_workno`,`e_name`,`e_sex`,`e_mobile`,`e_phone`,`e_tel_extension`,`e_email`,`e_status`,`dept_position_id`,`area_no`,`entry_date`,`try_date`,`formal_date`,`dimission_date`,`contract_bdate`,`contract_edate`,`sort_index`,`is_lock`,`is_del`,`create_uid`,`create_time`,`pl_id`)"
		." values('".$objEmployeeInfo->streWorkno."','".$objEmployeeInfo->streName."',".$objEmployeeInfo->ieSex.",'".$objEmployeeInfo->streMobile."','".$objEmployeeInfo->strePhone."','".$objEmployeeInfo->streTelExtension."','".$objEmployeeInfo->streEmail."',".$objEmployeeInfo->ieStatus.",".$objEmployeeInfo->iDeptPositionId.",'".$objEmployeeInfo->strAreaNo."','".$objEmployeeInfo->strEntryDate."','".$objEmployeeInfo->strTryDate."','".$objEmployeeInfo->strFormalDate."','".$objEmployeeInfo->strDimissionDate."','".$objEmployeeInfo->strContractBdate."','".$objEmployeeInfo->strContractEdate."',".$objEmployeeInfo->iSortIndex.",".$objEmployeeInfo->iIsLock.",".$objEmployeeInfo->iIsDel.",".$objEmployeeInfo->iCreateUid.",now(),".$objEmployeeInfo->iPlId.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param EmployeeInfo $objEmployeeInfo  Employee实例
     * @return
     */
	public function updateByID(EmployeeInfo $objEmployeeInfo)
	{
		$sql = "update `hr_employee` set `e_workno`='".$objEmployeeInfo->streWorkno."',`e_name`='".$objEmployeeInfo->streName."',`e_sex`=".$objEmployeeInfo->ieSex.",`e_mobile`='".$objEmployeeInfo->streMobile."',`e_phone`='".$objEmployeeInfo->strePhone."',`e_tel_extension`='".$objEmployeeInfo->streTelExtension."',`e_email`='".$objEmployeeInfo->streEmail."',`e_status`=".$objEmployeeInfo->ieStatus.",`dept_position_id`=".$objEmployeeInfo->iDeptPositionId.",`area_no`='".$objEmployeeInfo->strAreaNo."',`entry_date`='".$objEmployeeInfo->strEntryDate."',`try_date`='".$objEmployeeInfo->strTryDate."',`formal_date`='".$objEmployeeInfo->strFormalDate."',`dimission_date`='".$objEmployeeInfo->strDimissionDate."',`contract_bdate`='".$objEmployeeInfo->strContractBdate."',`contract_edate`='".$objEmployeeInfo->strContractEdate."',`sort_index`=".$objEmployeeInfo->iSortIndex.",`is_lock`=".$objEmployeeInfo->iIsLock.",`is_del`=".$objEmployeeInfo->iIsDel.",`pl_id`=".$objEmployeeInfo->iPlId." where e_id=".$objEmployeeInfo->ieId;
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
		$sql = "update `hr_employee` set is_del=1,update_uid=".$userID.",update_time=now() where e_id=".$id;
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
			$sField = T_Employee::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `hr_employee` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        //exit($sql);
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个hr_employee对象
	 * @param int $id 
     * @return hr_employee对象
     */
	public function getModelByID($id)
	{
		$objEmployeeInfo = null;
		$arrayInfo = $this->select("*","e_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objEmployeeInfo = new EmployeeInfo();
			$objEmployeeInfo->ieId = $arrayInfo[0]['e_id'];
			$objEmployeeInfo->streWorkno = $arrayInfo[0]['e_workno'];
			$objEmployeeInfo->streName = $arrayInfo[0]['e_name'];
			$objEmployeeInfo->ieSex = $arrayInfo[0]['e_sex'];
			$objEmployeeInfo->streMobile = $arrayInfo[0]['e_mobile'];
			$objEmployeeInfo->strePhone = $arrayInfo[0]['e_phone'];
			$objEmployeeInfo->streTelExtension = $arrayInfo[0]['e_tel_extension'];
			$objEmployeeInfo->streEmail = $arrayInfo[0]['e_email'];
			$objEmployeeInfo->ieStatus = $arrayInfo[0]['e_status'];
			$objEmployeeInfo->iDeptPositionId = $arrayInfo[0]['dept_position_id'];
			$objEmployeeInfo->strAreaNo = $arrayInfo[0]['area_no'];
			$objEmployeeInfo->strEntryDate = $arrayInfo[0]['entry_date'];
			$objEmployeeInfo->strTryDate = $arrayInfo[0]['try_date'];
			$objEmployeeInfo->strFormalDate = $arrayInfo[0]['formal_date'];
			$objEmployeeInfo->strDimissionDate = $arrayInfo[0]['dimission_date'];
			$objEmployeeInfo->strContractBdate = $arrayInfo[0]['contract_bdate'];
			$objEmployeeInfo->strContractEdate = $arrayInfo[0]['contract_edate'];
			$objEmployeeInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objEmployeeInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objEmployeeInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objEmployeeInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objEmployeeInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objEmployeeInfo->iPlId = $arrayInfo[0]['pl_id'];
			settype($objEmployeeInfo->ieId,"integer");
			settype($objEmployeeInfo->ieSex,"integer");
			settype($objEmployeeInfo->ieStatus,"integer");
			settype($objEmployeeInfo->iDeptPositionId,"integer");
			settype($objEmployeeInfo->iSortIndex,"integer");
			settype($objEmployeeInfo->iIsLock,"integer");
			settype($objEmployeeInfo->iIsDel,"integer");
			settype($objEmployeeInfo->iCreateUid,"integer");
			settype($objEmployeeInfo->iPlId,"integer");
		}
		
		return $objEmployeeInfo;
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `hr_employee` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `hr_employee` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
	}
    
    /**
     * @functional 用户开通时默认匹配未开通用户的员工
     */
    public function GetCompleteEmp($workNo)
    {
        $sql = "SELECT hr_employee.e_id as `id`, CONCAT(hr_employee.e_workno,' ',hr_employee.e_name) as `name` 
            FROM hr_employee inner join sys_user on  sys_user.`e_uid` = hr_employee.e_id 
              where sys_user.is_del = 1 and hr_employee.is_del=0 and hr_employee.e_status != 6 and hr_employee.e_status > -9 
              and (hr_employee.e_workno like '%$workNo%' or hr_employee.e_name like '%$workNo%')          
              order by hr_employee.e_workno  LIMIT 0,1000  ";
          
          return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    
    /**
     * @functional 取得员工明细信息
     */
    public function GetEmpDetailInfo($eid)
    {
        if($eid != "")
            $strWhere = " where `hr_employee`.e_id=$eid";
        
        $sql = "SELECT 
          hr_employee.e_id,
          hr_employee.e_workno,
          hr_employee.e_name,
          hr_employee.e_sex,
          hr_employee.e_mobile,
          hr_employee.e_phone,
          hr_employee.e_tel_extension,
          hr_employee.e_email,
          hr_employee.e_status,
          hr_employee.try_date,
          hr_employee.formal_date,
          hr_employee.dimission_date,
          hr_employee.contract_bdate,
          hr_employee.contract_edate,
          hr_department.dept_no,
          hr_department.dept_name,
          hr_department.dept_type,
          hr_department.dept_fullname,
          hr_department.data_type,
          hr_position.post_name,
          hr_level.level_name,
          hr_level.m_value,
          hr_position.post_id,
          hr_level.level_id 
        FROM 
          hr_employee 
          left JOIN hr_dept_position ON (hr_employee.dept_position_id = hr_dept_position.dept_position_id) 
          left JOIN hr_position ON (hr_dept_position.post_id = hr_position.post_id) 
          left JOIN hr_department ON (hr_dept_position.hr_dept_id = hr_department.dept_id) 
          left JOIN hr_level ON (hr_position.level_id = hr_level.level_id) $strWhere order by hr_department.dept_no,hr_employee.e_workno LIMIT 0,1000 ";
         //print_r($sql);
          return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
    /**
     * @functional 取得员工姓名
     */
    public function GetEmployeeNameByID($id)
    {
        $strName = "";
        $sql = "SELECT e_name FROM hr_employee where e_id = $id";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
       	if (isset($arrayData)&& count($arrayData)>0)
        {
            $strName = $arrayData[0]["e_name"];
        }
        
        return $strName;
    }
    
    /**
     * @functional 账号组区域绑定中取得未分配的员工信息(从sys_user表里读取)
     */
    public function GetAvailableUser($p,$id)//上级账号组ID
    {  
        $sqlNo = "SELECT account_no
                    FROM `sys_account_group` where `sys_account_group`.`account_group_id`=$id";
        $acc_group_no = $this->objMysqlDB->executeAndReturn(false,$sqlNo,null);
        $sup_group_no = substr($acc_group_no,0,strlen($acc_group_no)-2);//上级账号组编号
        $str = "";
        if(strlen($sup_group_no) >= 2)
        {
            $str = " and sys_user.user_id in (SELECT distinct `sys_account_group_user`.`user_id`
                FROM `sys_account_group` left JOIN
                `sys_account_group_user` ON `sys_account_group`.`account_group_id` = `sys_account_group_user`.`account_group_id` 
                where `sys_account_group`.`account_no`='$sup_group_no' and `sys_account_group`.`is_del`=0 and `sys_account_group_user`.is_del=0) ";
        
            $str .= " 
            and sys_user.user_id not in (SELECT distinct `sys_account_group_user`.`user_id`
                FROM `sys_account_group` left JOIN
                `sys_account_group_user` ON `sys_account_group`.`account_group_id` = `sys_account_group_user`.`account_group_id` 
                where (`sys_account_group`.`account_no` like '".$sup_group_no."_%' or `sys_account_group`.`account_no`='$acc_group_no') and `sys_account_group`.`is_del`=0 and `sys_account_group_user`.is_del=0)";
        }
        else if($acc_group_no == "10" || $acc_group_no == "11" ||$acc_group_no == "12")
        {
            $g1 = "11";
            $g2 = "12";
            if($acc_group_no == "11")
            {
                $g1 = "10";
                $g2 = "12";
            }
            else if($acc_group_no == "12")
            {
                $g1 = "10";
                $g2 = "11";
            }
            
            $str = " and sys_user.user_id not in (SELECT distinct `sys_account_group_user`.`user_id`
                FROM `sys_account_group` inner JOIN
                `sys_account_group_user` ON `sys_account_group`.`account_group_id` = `sys_account_group_user`.`account_group_id` 
                where (`sys_account_group`.`account_no` ='{$g1}' or `sys_account_group`.`account_no`='{$g2}' 
                or `sys_account_group`.`account_no` like '".$sup_group_no."_%'
                ) and `sys_account_group`.`is_del`=0 and `sys_account_group_user`.is_del=0)";
        }
        
        $sql = "SELECT sys_user.user_id as `id`, CONCAT(sys_user.user_name,' ',sys_user.e_name) as `name`  
                FROM sys_user INNER JOIN hr_employee ON (sys_user.e_uid = hr_employee.e_id)
                where
            ( sys_user.user_name like '%$p%' or sys_user.e_name like '%$p%')
                ".$str." and sys_user.is_del=0 and sys_user.agent_id<=0 and sys_user.is_lock=0 and sys_user.is_del=0 and sys_user.e_uid > 0
                order by sys_user.user_id  LIMIT 0,20";   

          return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
    
}

?>