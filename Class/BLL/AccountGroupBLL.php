<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_account_group的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-8-31 16:52:20
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AccountGroupInfo.php';

class AccountGroupBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AccountGroupInfo $objAccountGroupInfo  AccountGroup实例
     * @return 
     */
	public function insert(AccountGroupInfo $objAccountGroupInfo)
	{
		$sql = "INSERT INTO `sys_account_group`(`account_no`,`account_name`,`acgroup_remark`,`sort_index`,`is_lock`,`is_del`,`update_uid`,`create_uid`,`update_time`,`create_time`,`account_group_type`)"
		." values('".$objAccountGroupInfo->strAccountNo."','".$objAccountGroupInfo->strAccountName."','".$objAccountGroupInfo->strAcgroupRemark."',".$objAccountGroupInfo->iSortIndex.",".$objAccountGroupInfo->iIsLock.",".$objAccountGroupInfo->iIsDel.",".$objAccountGroupInfo->iUpdateUid.",".$objAccountGroupInfo->iCreateUid.",now(),now(),".$objAccountGroupInfo->iAccountGroupType.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
    
    /**
     * @functional 取得新的编号
     * @param $new_account_no 为上级的账号组的account_no
     * @return 
    */
    public function getNewNo($new_account_no)
    {
        $strNewNo = "";
        if($new_account_no != "")
        {
            $strNewNo = $this->f_GetNewGroupNo($new_account_no);
        }
        else
        { 
            $sNewNo = $this->f_GetMaxGroupNo();
           
            if($sNewNo == "")
            {                
                $strNewNo = "10";
            }
            else
            {                    
                settype($sNewNo,'integer');
                $sNewNo += 1;
                if($sNewNo < 10)
                    $strNewNo = "0".$sNewNo;
                else
                    $strNewNo = $sNewNo;
            }
        }
        return   $strNewNo;
    }
    /**
     * @functional 取得一级账号组组最大编号group_no
     * @return 
    */
    public function f_GetMaxGroupNo()
    {
        $sql = "select max(account_no) as account_no from `sys_account_group` where length(account_no)<=2";
        $arrayNewNo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayNewNo) && count($arrayNewNo)>0 )
            return $arrayNewNo[0]["account_no"];
            
        return "";
    }
    /**
     * @functional 取得新的账号组编号group_no
     * @return string 新的编号
    */
    public function f_GetNewGroupNo($new_account_no)
    {
        $strNewNo = $new_account_no.'01';
        
        $arrayAreaInfo = $this->select("distinct account_no",
        " account_no like '".$new_account_no."%' and length(account_no)=".(strlen($new_account_no)+2),"account_no");        
        
        if(isset($arrayAreaInfo) && count($arrayAreaInfo)>0)
        {
            $strTempNewNo = $arrayAreaInfo[0]['account_no'];
            //exit($strTempNewNo);
            if(!empty($strTempNewNo))
            {
                $arrayLength = count($arrayAreaInfo);
                $strOldNo = substr($strTempNewNo,strlen($strTempNewNo)-2,2);
                settype($strOldNo,"integer");
                if($strOldNo == 1)
                {                    
                    $strNo = "";
                    for($i=1;$i<$arrayLength;$i++)
                    {
                        $strNo = $arrayAreaInfo[$i]['account_no'];
                        $strNo = substr($strNo,strlen($strNo)-2,2);
                        settype($strNo,"integer");
                        if($strOldNo+1 == $strNo)
                        {
                            $strOldNo = $strNo;
                        }
                        else
                        {
                            break;
                        }
                    }
                    
                    $strTempNewNo = $strOldNo + 1;
                    if($strTempNewNo > 99)
                        exit("上级的子账号超过99，请重新选择上级！");
                        
                    if($strTempNewNo < 10)
                        $strNewNo = $new_account_no.'0'.$strTempNewNo;
                    else
                        $strNewNo = $new_account_no.$strTempNewNo;   
                }            
            }            
        } 
        
        return $strNewNo;
    }
	/**
     * @functional 根据ID更新一条记录
     * @param AccountGroupInfo $objAccountGroupInfo  AccountGroup实例
     * @return
     */
	public function updateByID(AccountGroupInfo $objAccountGroupInfo)
	{
        $sql = "update `sys_account_group` set `account_name`='".$objAccountGroupInfo->strAccountName."',`acgroup_remark`='".$objAccountGroupInfo->strAcgroupRemark."',`sort_index`=".$objAccountGroupInfo->iSortIndex.",`is_lock`=".$objAccountGroupInfo->iIsLock.",`is_del`=".$objAccountGroupInfo->iIsDel.",`update_uid`=".$objAccountGroupInfo->iUpdateUid.",`update_time`= now(),`account_group_type`=".$objAccountGroupInfo->iAccountGroupType." where account_group_id=".$objAccountGroupInfo->iAccountGroupId;
        $updateCount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        if($updateCount >0)
        {
            if($objAccountGroupInfo->strAccountNo == "10" ||$objAccountGroupInfo->strAccountNo == "11" ||$objAccountGroupInfo->strAccountNo == "12" )
            {
                $sql="update sys_com_setting set remark ='".$objAccountGroupInfo->strAccountName."' where data_type='".$objAccountGroupInfo->strAccountNo
                    ."' and setting_name='".AgentCommSet::Agent_Count_Limit."'";
                $this->objMysqlDB->executeNonQuery(false,$sql,null);
            }
        }
        return $updateCount;
	}
    /**
     * @functional 更新下级账号组的account_no
	 * @param 
     * @return 
     */
    public function UpdateLowLevelNo($account_no,$new_account_no)
    {
        $len_no = strlen($account_no);
        $len_no_new = strlen($new_account_no);
        $arrayLowLevel = $this->select("account_group_id,account_no,length(account_no) as level"," account_no like '$account_no%' and length(account_no)>$len_no","level");
        if(isset($arrayLowLevel)&&count($arrayLowLevel)>0)
        {
            
            for($i=0;$i<count($arrayLowLevel);$i++)
            {
                $account_no = $arrayLowLevel[$i]["account_no"];
                $account_group_id = $arrayLowLevel[$i]["account_group_id"];
                if(strlen($account_no) == $len_no+2)
                {
                    $strNo = $this->getNewNo($new_account_no);
                    $sql   = "update sys_account_group set `account_no`= '$strNo' where length(account_no)=$len_no+2 and account_group_id=$account_group_id"; 
                    $this->objMysqlDB->executeNonQuery(false,$sql,null);
                    $this->ChangeLowNo($account_no,$strNo);
                }
            }
        }
    }
    /**
     * @functional 改变下级account_no
	 * @param $oldNo 原上级account_no;$newNo现上级account_no
     * @return 
     */
    public function ChangeLowNo($oldNo,$newNo)
    {
        $noLength = strlen($oldNo);
        $sql = "SELECT account_group_id, account_no FROM sys_account_group where account_no like '{$oldNo}%'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $sql = "";
        $i= 0;
        $updateCount = 0;
    	foreach($arrayData as $key => $value)
    	{
    	   $sql .= "update sys_account_group set account_no = concat('{$newNo}',right(account_no,length(account_no)-{$noLength})) where account_group_id=".$value["account_group_id"].";";

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
        
    }//
   
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `sys_account_group` set is_del=1,update_uid=".$userID.",update_time=now() where account_group_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	/**
     * @functional 判断账号组是否绑定了账户或者是否有下级账号组
	 * @param int $id 记录ID
     * @return 
     */
	public function CanDelAccountGroup($id)
    {
        $sql = "SELECT 1
              FROM
              `sys_account_group` INNER JOIN
              `sys_account_group_user` 
              ON `sys_account_group`.`account_group_id` = `sys_account_group_user`.`account_group_id` where `sys_account_group`.`account_group_id`=$id and `sys_account_group_user`.user_id >0
              and `sys_account_group_user`.is_del=0";
       
        $i = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        $arrayData = $this->select("account_no","account_group_id=$id","");
        $strNo     = $arrayData[0]["account_no"];
        $ii = $this->select("1","account_no like '$strNo%' and account_group_id<>$id and is_del=0","");
        
        if($i+count($ii)>0)
    	    return false;
        return true;
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
			$sField = T_AccountGroup::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_account_group` ".$sWhere.$sOrder.$sGroup.$sLimit ;
        
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
    /**
     * @functional 根据ID,返回上级包含的区域组
	 * @param int $id= agroup_user_id
     * @return 
     */
	public function selectGetAreaArray($id,$account_group_id)
    {
        /*
        $sqlSup = "SELECT `sys_account_group`.`account_no` FROM `sys_account_group` 
        where `sys_account_group`.`is_del`=0 and `sys_account_group`.`account_group_id` =".$account_group_id;
        $account_no = $this->objMysqlDB->executeAndReturn(false,$sqlSup,null);
        if(strlen($account_no)>=4)
        {
            $sup_no = substr($account_no,0,strlen($account_no)-2);
            $sqlData = "select agroup_id,agroup_name,if((select 1 from sys_user_area 
                where agroup_id in
                (SELECT `sys_area_group`.`agroup_id`
                FROM `sys_user_area` INNER JOIN
                `sys_area_group` ON `sys_area_group`.`agroup_id` = `sys_user_area`.`area_group_id` where `sys_user_area`.`agroup_user_id`=$id)  
                and is_del=0 limit 0,1),1,0)
         as is_check
        from `sys_area_group` where  is_del=0 and agroup_id in(SELECT  distinct  D.`agroup_id`
            FROM
              `sys_account_group` A left JOIN
              `sys_account_group_user` B ON A.`account_group_id` =B.`account_group_id` left JOIN
              `sys_user_area` C ON B.`account_group_user_id` =C.`agroup_user_id` left JOIN
              `sys_area_group_detail` D ON C.`area_group_id` =D.`agroup_id` where A.account_no='$sup_no' and
              B.`is_del`=0
               )";//D.`is_del`=0 and C.`is_del`=0 and 
            
        }
        else
        {
            $sqlData = "select agroup_id,agroup_name,if((select 1 from sys_user_area 
                where agroup_id in
                (SELECT `sys_area_group`.`agroup_id`
                FROM `sys_user_area` INNER JOIN
                `sys_area_group` ON `sys_area_group`.`agroup_id` = `sys_user_area`.`area_group_id` where `sys_user_area`.`agroup_user_id`=$id)  
                and is_del=0 limit 0,1),1,0)
         as is_check
        from `sys_area_group` where  is_del=0 ";
        }  
        */  
        $sqlData = "select agroup_id,agroup_name,if((select 1 from sys_user_area 
                where agroup_id in
                (SELECT `sys_area_group`.`agroup_id`
                FROM `sys_user_area` INNER JOIN
                `sys_area_group` ON `sys_area_group`.`agroup_id` = `sys_user_area`.`area_group_id` where `sys_user_area`.`agroup_user_id`=$id)  
                and is_del=0 limit 0,1),1,0)
         as is_check
        from `sys_area_group` where  is_del=0 ";
        return $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
    }
    /**
     * @functional 账号绑定区域组
	 * @param int $level 选择的层级（2：一级 4：二级 6：三级）
     * @param $acc_uid 账号组绑定的账户id
     * @param $account_group_id 账号组ID
     * @return 
     */
	public function getGroupAreaCbJson($acc_uid,$account_group_id,$level)
    {
        $sqlSup = "SELECT `sys_account_group`.`account_no` FROM `sys_account_group` 
        where `sys_account_group`.`is_del`=0 and `sys_account_group`.`account_group_id` =".$account_group_id;
        $account_no = $this->objMysqlDB->executeAndReturn(false,$sqlSup,null);
       /* if(strlen($level)>=4)
        {*/
            $sup_no = substr($account_no,0,strlen($account_no)-2);
        /*    $sqlData = "select agroup_id,agroup_name,if((select 1 from sys_user_area 
                where agroup_id in
                (SELECT `sys_area_group`.`agroup_id`
                FROM `sys_user_area` INNER JOIN
                `sys_area_group` ON `sys_area_group`.`agroup_id` = `sys_user_area`.`area_group_id` where `sys_user_area`.`agroup_user_id`=$acc_uid)  
                and is_del=0 limit 0,1),1,0)
         as is_check
        from `sys_area_group` where  is_del=0 and length(group_no)=$level  and agroup_id in(SELECT  distinct  D.`agroup_id`
            FROM
              `sys_account_group` A left JOIN
              `sys_account_group_user` B ON A.`account_group_id` =B.`account_group_id` left JOIN
              `sys_user_area` C ON B.`account_group_user_id` =C.`agroup_user_id` left JOIN
              `sys_area_group_detail` D ON C.`area_group_id` =D.`agroup_id` where A.account_no='$sup_no' and
              B.`is_del`=0
               )";//D.`is_del`=0 and C.`is_del`=0 and 
            
        }
        else
        {*/
            $sqlData = "select agroup_id,agroup_name,if((select 1 from sys_user_area 
                where agroup_id in
                (SELECT `sys_area_group`.`agroup_id`
                FROM `sys_user_area` INNER JOIN
                `sys_area_group` ON `sys_area_group`.`agroup_id` = `sys_user_area`.`area_group_id` where `sys_user_area`.`agroup_user_id`=$acc_uid)  
                and is_del=0 limit 0,1),1,0)
         as is_check
        from `sys_area_group` where  is_del=0 and length(group_no)=$level ";
        //} 
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);
        return $this->f_AreaGroupJson($arrayData);   
    }
    /**
     * @functional 数组转换为JSON格式
     * @param 
    */
    public function f_AreaGroupJson($arrayData)
    {
        $strJson = "[";
        
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength;$i++)
            {
                $strJson .= "{'id':'".$arrayData[$i]["agroup_id"]."','Name':'".$arrayData[$i]["agroup_name"]."','is_check':'".$arrayData[$i]["is_check"]."'},";
            }
            $strJson = substr($strJson, 0, strlen($strJson) - 1);             
        }
        $strJson .= "]";
        
        return $strJson;
    }	
	/**
     * @functional 根据ID,返回一个sys_account_group对象
	 * @param int $id 
     * @return sys_account_group对象
     */
	public function getModelByID($id)
	{
		$objAccountGroupInfo = null;
		$arrayInfo = $this->select("*","account_group_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAccountGroupInfo = new AccountGroupInfo();
			$objAccountGroupInfo->iAccountGroupId = $arrayInfo[0]['account_group_id'];
			$objAccountGroupInfo->strAccountNo = $arrayInfo[0]['account_no'];
			$objAccountGroupInfo->strAccountName = $arrayInfo[0]['account_name'];
			$objAccountGroupInfo->strAcgroupRemark = $arrayInfo[0]['acgroup_remark'];
			$objAccountGroupInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objAccountGroupInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objAccountGroupInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objAccountGroupInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objAccountGroupInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAccountGroupInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objAccountGroupInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objAccountGroupInfo->iAccountGroupType = $arrayInfo[0]['account_group_type'];
		
			settype($objAccountGroupInfo->iAccountGroupId,"integer");
			
			
			
			settype($objAccountGroupInfo->iSortIndex,"integer");
			settype($objAccountGroupInfo->iIsLock,"integer");
			settype($objAccountGroupInfo->iIsDel,"integer");
			settype($objAccountGroupInfo->iUpdateUid,"integer");
			settype($objAccountGroupInfo->iCreateUid,"integer");
			
			
			settype($objAccountGroupInfo->iAccountGroupType,"integer");
		}
		
		return $objAccountGroupInfo;
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
        $sWhere = " t.is_del=0";
        if($strWhere != "")
            $sWhere .= $strWhere;
        $offset = ($iPageIndex-1)*$iPageSize;
        $sqlCount = "SELECT  COUNT(1) AS `recordCount`
                    from ( SELECT *,ROUND(length(sys_account_group.account_no)/2,0) as account_group_level FROM `sys_account_group` where is_del=0 )t WHERE $sWhere
        ";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
        $sOrder = " t.account_no,t.account_group_id ";
		if($strOrder != "")
            $sOrder .= ",".$strOrder;
        $sqlData = "select t.*,
                        (SELECT
                  group_concat(`sys_user`.`user_name`, `sys_user`.`e_name`)
                FROM
                  `sys_account_group` tt inner JOIN
                  `sys_account_group_user` ON tt.`account_group_id` =
                  `sys_account_group_user`.`account_group_id` left JOIN
                  `sys_user` ON `sys_account_group_user`.`user_id` = `sys_user`.`user_id` 
                  where tt.account_group_id=t.account_group_id and tt.is_del=0 and `sys_account_group_user`.is_del=0) as user_name,
                        if(t.account_no='10',1,if((select 1 from sys_account_group g where left(g.account_no,length(g.account_no)-2) = t.account_no and g.is_del=0 limit 0,1),1,0)) as have_sub
                         from ( SELECT *,ROUND(length(sys_account_group.account_no)/2,0) as account_group_level FROM `sys_account_group` where is_del=0 )t 
                        WHERE $sWhere group by t.account_no ORDER BY $sOrder LIMIT $offset,$iPageSize
                        ";
                        
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    /**
     * @functional 取得新的编号
     * @param int id 上级的ID
    */
    public function getNewAccountNo($id)
    {
        $strNewNo = 0;
        
        if($id <= 0)//新添加的为一级账号组
        {
            $arrAccountNo = $this->select("max(account_no) as account_no"," is_del=0 and length(account_no)=2 ","");
            if(isset($arrAccountNo)&& $arrAccountNo[0]["account_no"] != "")
            {
                $strNo = $arrAccountNo[0]["account_no"];
                settype($strNo,"integer");
                $strNewNo = $strNo+1;
            }
            else
               $strNewNo = 10; 
        }
        else
        {
            $arr = $this->select("account_no","account_group_id=$id","");
            
            $strNo = $arr[0]["account_no"];
            $arrAccountNo = $this->select("max(account_no) as account_no"," is_del=0 and account_no like '".$strNo."__' ","");
        
            if(isset($arrAccountNo)&& $arrAccountNo[0]["account_no"] != "")
            {
                $strNo = $arrAccountNo[0]["account_no"];
                settype($strNo,"integer");
                $strNewNo = $strNo+1;
            }
            else
                $strNewNo = $strNo."01";
        }
        return $strNewNo;
    }
    /**
     * @functional 根据$level筛选上级(下拉列表中不包括已绑定账号的账号组)
     * @param 
    */
    public function getSup($level,$id)
    {
        if($level != 1 && $level != 2)
            return "[]"; 
        $sWhere = "";
        if($id != 0)
            $sWhere = " and account_group_id <> $id";  
        $i = $level*2;    
        $sql = "select account_group_id,account_name
                                    from `sys_account_group` where  is_del=0 and length(account_no)=$i".$sWhere."
                                    and account_group_id not in (select account_group_id
                                     from sys_account_group_user where is_del=0 )";
        //        
//        $sql1 = "select account_group_id,account_name
//                                    from `sys_account_group` where  is_del=0 and length(account_no)=$i".$sWhere."
//                                    and account_group_id not in (select account_group_id
//                                     from sys_account_group_user where is_del=0 )";
//                //have_low=0——没有下级
        //$arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        	return 	$this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        //return $this->f_AccountGroupJson($arrayData);
    }
    
    /**
     * @functional 取得第三级
     * @param 
    */
    public function getLowLevelJson($id,$nowid)
    {   
        if($id == 0)
            return "[]";
        $arrayData1 = $this->select("account_no","account_group_id=$id","");
        $strNo = $arrayData1[0]["account_no"];
        $sql = "select account_group_id,account_name from sys_account_group where  is_del=0 and account_group_id<>$nowid and account_no like '".$strNo."__'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);	
       
        return $this->f_AccountGroupJson($arrayData);
    }
    
   
    /**
     * @functional 数组转换为JSON格式
     * @param 
    */
    public function f_AccountGroupJson($arrayData)
    {
        $strJson = "[";
        
        if(isset($arrayData) && count($arrayData) > 0)
        {
            $arrayLength = count($arrayData);
            for($i=0;$i<$arrayLength;$i++)
            {
                $strJson .= "{'id':'".$arrayData[$i]["account_group_id"]."','Name':'".$arrayData[$i]["account_name"]."'},";
            }
            $strJson = substr($strJson, 0, strlen($strJson) - 1);             
        }
        
        $strJson .= "]";
        
        return $strJson;
    }
    /**
     * @functional 绑定账户列表数据,分页
     * @param 
    */
    public function getAccount($iPageIndex, $iPageSize, $sWhere, $sOrder, &$iRecordCount)
    {
       $strWhere = " where `sys_account_group`.is_del=0  and `sys_account_group_user`.is_del=0 ";
    	if (!empty($sWhere))
    	    $strWhere .= " and " . $sWhere;
        $strOrder = " order by `sys_account_group`.create_time desc";
    	if ($sOrder != "")
    	    $strOrder .= ",".$sOrder;
    
        $offset = ($iPageIndex - 1) * $iPageSize;
    	$iRecordCount = 0;
        $sqlCount ="SELECT count(1) as `counts` 
                    FROM
                `sys_account_group_user` 
                inner JOIN `sys_user` ON `sys_account_group_user`.`user_id` = `sys_user`.`user_id` and `sys_user`.is_del=0 and `sys_account_group_user`.is_del=0
                left JOIN `sys_account_group` ON `sys_account_group`.`account_group_id` = `sys_account_group_user`.`account_group_id`
                        ".$strWhere;
                      
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        
        $sLimit = " limit $offset, $iPageSize";        
               
        $sql = "SELECT `sys_account_group_user`.account_group_user_id,
                `sys_account_group_user`.account_group_id,
                `sys_account_group`.`account_no`, 
                `sys_user`.user_id,`sys_user`.`e_name`,
                `sys_user`.`user_name`,
                sys_account_group_user.area_group_name
                FROM
                `sys_account_group_user` 
                inner JOIN `sys_user` ON `sys_account_group_user`.`user_id` = `sys_user`.`user_id` and `sys_user`.is_del=0 and `sys_account_group_user`.is_del=0
                left JOIN `sys_account_group` ON `sys_account_group`.`account_group_id` = `sys_account_group_user`.`account_group_id`
               ".$strWhere.$strOrder.$sLimit;
   
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
                
    }
    
  /**
     * @functional 获取账号名称
     * @author
    */
    public function getUserName($account_group_user_id)//account_group_user_id
    {
        $sql = "SELECT
                  `sys_user`.`e_name`, `sys_user`.`user_name`,
                  `sys_account_group_user`.`account_group_user_id`,
                  `sys_account_group_user`.`is_del`, `sys_user`.`is_del`
                FROM
                  `sys_account_group_user` left JOIN
                  `sys_user` ON `sys_account_group_user`.`user_id` = `sys_user`.`user_id`
                where `sys_user`.`is_del`=0 and `sys_account_group_user`.`is_del`=0
                and `sys_account_group_user`.`account_group_user_id`=$account_group_user_id
                ";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    }
  
    
}
?>