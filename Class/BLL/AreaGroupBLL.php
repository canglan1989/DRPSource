<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_area_group的类业务逻辑层
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-8-13 14:45:39
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AreaGroupInfo.php';
require_once __DIR__.'/../../Class/BLL/AreaBLL.php';

class AreaGroupBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
    ///**
//     * @functional 未分配的区域
//     * @return
//     */
//	public function selectGetCanArea($group_no)
//    {    
//        $sql  = "select agroup_id,agroup_name,0 as is_check from `sys_area_group` where is_group=0 and group_no='' ";
//        if($group_no != "")//编辑，显示全部
//            $sql  .= " union all select agroup_id,agroup_name,1 as is_check from `sys_area_group` where is_group=0 and group_no like '$group_no%' and is_del=0 ";
//        
//        $arrayAreaGroup = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
//        
//        $strJson = "[]";
//        if(isset($arrayAreaGroup) && count($arrayAreaGroup))
//        {
//            $strJson = "[";
//            
//            $iRightCount = count($arrayAreaGroup);
//            for($i=0;$i<$iRightCount;$i++)
//            {
//                $strJson .= "{agroup_name:'".$arrayAreaGroup[$i]['agroup_name']."',agroup_id:'".$arrayAreaGroup[$i]['agroup_id']."',is_check:".$arrayAreaGroup[$i]["is_check"]."},";
//            }
//            
//            if($iRightCount>1)
//                $strJson = substr($strJson,0,strlen($strJson)-1);//去掉结尾逗号
//                
//            $strJson .= ']';
//        }
//        return $strJson;//json_encode($strJson);
//    }
    
    /**
     * @functional 添加区域组
     * @return
     */
    public function AddAreaGroup(AreaGroupInfo $objGroupInfo,$cbAreaGroup)
    {        
        
        $strNewNo = $this->getNewNo($cbAreaGroup);
        $lastInsertId = $this->insertGroupArea($objGroupInfo,$strNewNo);//添加区域组名
        
        return $lastInsertId;
    }
    /**
     * @functional 取得新的编号
     * @param $cbAreaGroup 为上级的区域组的group_no
     * @return 
    */
    public function getNewNo($cbAreaGroup)
    {
        $strNewNo = "";
        if($cbAreaGroup != "")
        {
            $strNewNo = $this->f_GetNewGroupNo($cbAreaGroup);
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
     * @functional 取得一级区域组最大编号group_no
     * @return 
    */
    public function f_GetMaxGroupNo()
    {
        $sql = "select max(group_no) as group_no from `sys_area_group` where length(group_no)<=2 and is_del=0";
        $arrayNewNo = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if(isset($arrayNewNo) && count($arrayNewNo)>0 )
            return $arrayNewNo[0]["group_no"];
            
        return "";
    }
    /**
     * @functional 取得新的区域组编号group_no
     * @return string 新的编号
    */
    public function f_GetNewGroupNo($cbAreaGroup_no)
    {
        $strNewNo = $cbAreaGroup_no.'01';
        
        $arrayAreaInfo = $this->select("distinct group_no",
        " group_no like '".$cbAreaGroup_no."%' and length(group_no)=".(strlen($cbAreaGroup_no)+2),"group_no");        
        
        if(isset($arrayAreaInfo) && count($arrayAreaInfo)>0)
        {
            $strTempNewNo = $arrayAreaInfo[0]['group_no'];
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
                        $strNo = $arrayAreaInfo[$i]['group_no'];
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
                        exit("{'success':false,'msg':'上级的子账号超过99，请重新选择上级！'}");  
                        
                    if($strTempNewNo < 10)
                        $strNewNo = $cbAreaGroup_no.'0'.$strTempNewNo;
                    else
                        $strNewNo = $cbAreaGroup_no.$strTempNewNo;   
                }            
            }            
        } 
        
        return $strNewNo;
    }
    /**
     * @functional 添加区域组
     * @return $lastInsertId
     */
     public function insertGroupArea(AreaGroupInfo $objGroupInfo,$strNewNo)
     {
            $groupname = $objGroupInfo->strAgroupName;
            $objGroupInfo->strGroupNo = $strNewNo;
            $objGroupInfo->iIsGroup = 1;
            $count = $this->select("agroup_name"," `agroup_name`='$groupname' ","");
            if(count($count)>0)
                exit("{'success':false,'msg':'该区域组名称已存在，请重新输入'}"); 
            
            $lastInsertId = $this->insert($objGroupInfo);  
            return $lastInsertId;  
     }
	/**
     * @functional 新增一条记录
     * @param AreaGroupInfo $objAreaGroupInfo  AreaGroup实例
     * @return 
     */
	public function insert(AreaGroupInfo $objAreaGroupInfo)
	{
		$sql = "INSERT INTO `sys_area_group`(`agroup_name`,`group_no`,`agroup_remark`,`sort_index`,`is_lock`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`,`is_group`)"
		." values('".$objAreaGroupInfo->strAgroupName."','".$objAreaGroupInfo->strGroupNo."','".$objAreaGroupInfo->strAgroupRemark."',".$objAreaGroupInfo->iSortIndex.",".$objAreaGroupInfo->iIsLock.",".$objAreaGroupInfo->iIsDel.",".$objAreaGroupInfo->iUpdateUid.",now(),".$objAreaGroupInfo->iCreateUid.",now(),".$objAreaGroupInfo->iIsGroup.")";

        $iNewID = 0;
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
        {
            $iNewID = $this->objMysqlDB->lastInsertId();
        }
        return $iNewID;
	}

	/**
     * @functional 根据ID更新一条记录
     * @param AreaGroupInfo $objAreaGroupInfo  AreaGroup实例
     * @return
     */
	public function updateByID(AreaGroupInfo $objAreaGroupInfo)
	{
		$sql = "update `sys_area_group` set `agroup_name`='".$objAreaGroupInfo->strAgroupName."',`group_no`='".$objAreaGroupInfo->strGroupNo."',`agroup_remark`='".$objAreaGroupInfo->strAgroupRemark."',`sort_index`=".$objAreaGroupInfo->iSortIndex.",`is_lock`=".$objAreaGroupInfo->iIsLock.",`is_del`=".$objAreaGroupInfo->iIsDel.",`update_uid`=".$objAreaGroupInfo->iUpdateUid.",`update_time`= now(),`is_group`=".$objAreaGroupInfo->iIsGroup." where agroup_id=".$objAreaGroupInfo->iAgroupId;
        
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
    /**
     * @functional 编辑区域组信息
     * @param 
     * @return
     */
    public function UpdateAreaGroup(AreaGroupInfo $objGroupInfo)
    {
        
        $agroup_id = $objGroupInfo->iAgroupId;
        
        $arrold = $this->select("","agroup_id=$agroup_id","");
        
        $group_no = $arrold[0]["group_no"];
         /* 
        $oldAreaGroup = substr($group_no,0,strlen($group_no)-2);//原上级
        $newGroupNo = ""; 
       
        //-----------------如果原上级有改变，改变现有编号,其下级的编号也相应改变--------------------//
        
        if($oldAreaGroup != $strSupNo&&($oldAreaGroup>0||$strSupNo>0))
        {
            $newGroupNo = $this->getNewNo($strSupNo);
            $this->UpdateLowLevelNo($group_no,$newGroupNo);
        }   
        else 
            $newGroupNo = $group_no;
        */
        $objGroupInfo->iIsGroup = 1;
        $objGroupInfo->strGroupNo = $group_no;
        $i  = $this->updateByID($objGroupInfo);           
       
        //删除原有区域
        //$sql2  = "update `sys_area_group` set `group_no`='' where is_group=0 and left(group_no,length(group_no)-2)='$group_no'";        
        //$f = $this->objMysqlDB->executeNonQuery(false,$sql2,null);
        //添加新区域
        
        return count($i);
    }
    /**
     * @functional 改变下级区域组的编号
	 * @param 
     */
    public function UpdateLowLevelNo($group_no,$newGroupNo)
    {
        $len_no = strlen($group_no);
        $len_no_new = strlen($newGroupNo);
        $arrayLowLevel = $this->select("agroup_id,group_no,length(group_no) as level"," group_no like '$group_no%' and length(group_no)>$len_no","level");
        if(isset($arrayLowLevel)&&count($arrayLowLevel)>0)
        {
            
            for($i=0;$i<count($arrayLowLevel);$i++)
            {
                $group_no = $arrayLowLevel[$i]["group_no"];
                $group_id = $arrayLowLevel[$i]["agroup_id"];
                if(strlen($group_no) == $len_no+2)
                {
                    $strNo = $this->getNewNo($newGroupNo);
                    $sql   = "update sys_area_group set `group_no`= '$strNo' where length(group_no)=$len_no+2 and agroup_id=$group_id"; 
                    $this->objMysqlDB->executeNonQuery(false,$sql,null);
                    $this->ChangeLowNo($group_no,$strNo);
                }
            }
        }
    }
    /**
     * @functional 改变下级group_no
	 * @param $oldNo 原上级group_no;$newNo现上级group_no
     * @return 
     */
    public function ChangeLowNo($oldNo,$newNo)
    {
        $noLength = strlen($oldNo);
        $sql = "SELECT agroup_id, group_no FROM sys_area_group where group_no like '{$oldNo}%'";
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $sql = "";
        $i= 0;
        $updateCount = 0;
    	foreach($arrayData as $key => $value)
    	{
    	   $sql .= "update sys_area_group set group_no = concat('{$newNo}',right(group_no,length(group_no)-{$noLength})) where agroup_id=".$value["agroup_id"].";";

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
     * @functional 根据ID判断是否可以删除该区域组
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function CanDelAreaGroup($id)
    {
        $arr  = $this->select("group_no"," agroup_id=$id ","");
        $no   = $arr[0]["group_no"];
        $i    = $this->select("group_no"," left(`group_no`,length(`group_no`)-2)='$no' and is_del=0","");
        
        return count($i);
    }
    public function HaveBind($id)
    {
        
        $sql = "select area_group_id from sys_user_area where area_group_id=$id and is_del=0";
        $arr = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        return count($arr);
    }
    
	/**
     * @functional 根据ID更新一条记录
	 * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `sys_area_group` set is_del=1,update_uid=".$userID.",update_time=now() where agroup_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	/**
     * @functional 删除区域组绑定的行政区域
	 * @param int $id ：agroup_id
     * @return 
     */
    public function delBindArea($id,$userID)
    {
		$sql = "update `sys_area_group_detail` set is_del=1,update_uid=".$userID.",update_time=now() where agroup_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	/**
     * @functional 删除下级区域组绑定的行政区域
	 * @param int $id ：agroup_id
     * @return 
     */
    public function delLowBindArea($self_group_no,$userID)
    {
        $sql_agroup_id = "select group_concat(agroup_id) from sys_area_group where group_no like '$self_group_no%' and group_no<>'$self_group_no' and is_del=0";
        $str_agroup_id = $this->objMysqlDB->executeAndReturn(false,$sql_agroup_id,null);
        if($str_agroup_id != "")
            $sql_update = "update `sys_area_group_detail` set is_del=1,update_uid=".$userID.",update_time=now() where agroup_id in($str_agroup_id) and is_del=0";
        else 
            return 1;
        return $this->objMysqlDB->executeNonQuery(false,$sql_update,null);
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
			$sField = T_AreaGroup::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_area_group` ".$sWhere.$sGroup.$sOrder.$sLimit ;
		
		        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_area_group对象
	 * @param int $id 
     * @return sys_area_group对象
     */
	public function getModelByID($id)
	{
		$objAreaGroupInfo = null;
		$arrayInfo = $this->select("*","agroup_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAreaGroupInfo = new AreaGroupInfo();
			$objAreaGroupInfo->iAgroupId = $arrayInfo[0]['agroup_id'];
			$objAreaGroupInfo->strAgroupName = $arrayInfo[0]['agroup_name'];
			$objAreaGroupInfo->strGroupNo = $arrayInfo[0]['group_no'];
			$objAreaGroupInfo->strAgroupRemark = $arrayInfo[0]['agroup_remark'];
			$objAreaGroupInfo->iSortIndex = $arrayInfo[0]['sort_index'];
			$objAreaGroupInfo->iIsLock = $arrayInfo[0]['is_lock'];
			$objAreaGroupInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objAreaGroupInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objAreaGroupInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objAreaGroupInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAreaGroupInfo->strCreateTime = $arrayInfo[0]['create_time'];
			$objAreaGroupInfo->iIsGroup = $arrayInfo[0]['is_group'];
		
			settype($objAreaGroupInfo->iAgroupId,"integer");		
			settype($objAreaGroupInfo->iSortIndex,"integer");
			settype($objAreaGroupInfo->iIsLock,"integer");
			settype($objAreaGroupInfo->iIsDel,"integer");
			settype($objAreaGroupInfo->iUpdateUid,"integer");			
			settype($objAreaGroupInfo->iCreateUid,"integer");			
			settype($objAreaGroupInfo->iIsGroup,"integer");
		}
		
		return $objAreaGroupInfo;
	}
	
	
	/**
     * @functional 分页数据 不能删除的can_del被标记为1
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
        if($strWhere != "")
            $strWhere = " $strWhere";
        
        $strOrder = " group by sys_area_group.group_no ORDER BY sys_area_group.group_no,sys_area_group.create_time desc";     
        
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_area_group` where is_del =0 $strWhere";        
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "select sys_area_group.*,length(sys_area_group.group_no) len_no,ttt.area_name,if(g.agroup_id,1,0) cant_del from sys_area_group 
        left join (select distinct sys_agroup_manager_detail.`agroup_id` from sys_agroup_manager_detail 
        where sys_agroup_manager_detail.is_del=0) g 
        on g.agroup_id= sys_area_group.agroup_id
        left join ( 
            select agroup_id ,GROUP_CONCAT(area_name) as area_name 
            from (
                select agroup_id, CONCAT(area_fullname,city_fullname,province_name) as area_name ,
                CONCAT(province_no,city_no,area_no) as area_no
                from( 
                    SELECT 
                      sys_area_group_detail.agroup_id,
                      if(sys_area.area_id, sys_area.area_fullname, '') AS area_fullname,
                      if(sys_area.area_id, sys_area.area_no, '') AS area_no,
                      if(sys_city.city_id, sys_city.city_fullname, '') AS city_fullname,
                      if(sys_city.city_id, sys_city.city_no, '') AS city_no,
                      if(sys_province.province_id, sys_province.province_name, '') AS province_name,
                      if(sys_province.province_id, sys_province.province_no, '') AS province_no
                    FROM
                      sys_area_group_detail
                      LEFT OUTER JOIN sys_area ON (sys_area_group_detail.area_id = sys_area.area_id)
                      LEFT OUTER JOIN sys_city ON (sys_area_group_detail.city_id = sys_city.city_id)
                      LEFT OUTER JOIN sys_province ON (sys_area_group_detail.province_id = sys_province.province_id)
                    WHERE
                      sys_area_group_detail.is_del = 0  
                )t  order by area_no desc
            )tt group by agroup_id 
        ) ttt on ttt.agroup_id = sys_area_group.agroup_id 
        where sys_area_group.`is_del`=0 $strWhere $strOrder LIMIT $offset,$iPageSize";
        //print_r($sqlData);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    
    /**
     * @functional 取得区域经理所分配的区域组 已经分配的 is_check 标记为1
     * @param int $managerID 区域经理Id
    */
    public function GetAreaGroup($agroup_manager_id)
    {
        /*
        $sql = "select sys_area_group.agroup_id,sys_area_group.agroup_name,
        if(sys_agroup_manager_detail.agroup_manager_id,1,0) as is_check  from `sys_area_group`
        left join `sys_agroup_manager_detail` on (sys_agroup_manager_detail.agroup_id = sys_area_group.agroup_id 
        and sys_agroup_manager_detail.agroup_manager_id = $agroup_manager_id)
        where sys_area_group.is_del = 0  order by sys_area_group.agroup_name";
        */
        $sql = "select sys_area_group.agroup_id,sys_area_group.agroup_name,
        if(sys_agroup_manager_detail.agroup_manager_id,1,0) as is_check  from `sys_area_group`
        left join `sys_agroup_manager_detail` on (sys_agroup_manager_detail.agroup_id = sys_area_group.agroup_id 
        and sys_agroup_manager_detail.agroup_manager_id = $agroup_manager_id)
        where sys_area_group.is_del = 0 order by sys_area_group.agroup_name";//AND sys_area_group.is_group=1 
        //print_r($sql);
        return  $this->objMysqlDB->fetchAllAssoc(false,$sql,null);		
    }
    
        
    /**
     * @functional 取得可分配的区域
    */
    public function GetCanAllotArea()//快，结果错误
    {
        $strWhere = "";
        /*province_id*/
        $sql = "select group_concat(`province_id`) as province_id from
        (
            select distinct province_id from `sys_area_group_detail` where `is_del`=0 and province_id > 0 order by province_id desc
        )t";
        
        $strProvinceIDs = $this->objMysqlDB->executeAndReturn(false,$sql,null);
        if($strProvinceIDs > 0)
        {
            $strWhere .="and sys_area.province_id not in($strProvinceIDs)";
        }
        /*city_id*/
        $sql = "select group_concat(`city_id`) as city_id from
        (
            select distinct city_id from `sys_area_group_detail` where `is_del`=0  and city_id > 0 order by city_id desc
        )t";
        
        $strCityIDs = $this->objMysqlDB->executeAndReturn(false,$sql,null);
        if($strCityIDs > 0)
        {
            $strWhere .="and sys_area.city_id not in($strCityIDs)";
        }
        
        /*area_id*/
        /*
        $sql = "select group_concat(`area_id`) as area_id from
        (
            select distinct area_id from `sys_area_group_detail` where `is_del`=0  and area_id > 0 order by area_id asc
        )t";
        */
        $slq_area_id = "select distinct area_id from `sys_area_group_detail` where `is_del`=0  and area_id > 0 order by area_id asc";
        $arr_a = $this->objMysqlDB->fetchAllAssoc(false,$slq_area_id,null);
        $strAreaIDs = "";
        if(isset($arr_a)&&count($arr_a)>0)
        {
            for($i=1;$i<count($arr_a);$i++)
            {
                if($arr_a[0]["area_id"] > 0)
                    $strAreaIDs = $arr_a[0]["area_id"];
                if($arr_a[$i]["area_id"] > 0)
                    $strAreaIDs .=  ",".$arr_a[$i]["area_id"];
            }
        }
        
        //$strAreaIDs = $this->objMysqlDB->executeAndReturn(false,$sql,null);
        
        if($strAreaIDs > 0)
        {
            $strWhere .="and sys_area.area_id not in($strAreaIDs)";
        }
        $objAreaBLL = new AreaBLL();
        
        return $objAreaBLL->GetAreaHTML($strWhere);
    }
    
    /**
     * @functional 根据上级的ID,取得可分配的区域(左边的可选区域)
    */
    public function GetSupCanAllotArea($id)//$id--上级ID慢
    {
        $objAreaBLL = new AreaBLL();
        $sql = "";
        if($id <= 0)
        {
            $sql = "select sys_province.province_name,sys_city.city_name,sys_city.city_fullname,`area`.`area_id`, 
            `area`.`city_id`,`area`.`province_id`,`area`.`area_name`,`area`.`area_fullname`         
            from (
                select `sys_area`.*,if(area_group_detail.area_id,1,0) as is_used 
                from `sys_area` left join                       
                (select `sys_area_group_detail`.area_id from `sys_area_group_detail` where `sys_area_group_detail`.`is_del`=0 
                group by `sys_area_group_detail`.area_id ) as area_group_detail on area_group_detail.area_id = `sys_area`.area_id
            ) as `area`
            inner join
                 `sys_province` on sys_province.province_id = `area`.province_id 
                inner join `sys_city` on sys_city.city_id = `area`.city_id             
            where `area`.is_used = 0 and `area`.is_lock = 0 order by `area`.area_no";
        }
        else        
        {
            $groupNo = "";
            $sql = "SELECT `sys_area_group`.`group_no` FROM `sys_area_group` where agroup_id= ".$id;            
            $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
            if(isset($arrayData)&&count($arrayData)>0)
            {
                $groupNo = $arrayData[0]["group_no"];
                $sql = "select sys_province.province_name,sys_city.city_name,sys_city.city_fullname,`sys_area`.`area_id`, 
                    `sys_area`.`city_id`,`sys_area`.`province_id`,`sys_area`.`area_name`,`sys_area`.`area_fullname`         
                    from (    
                            select `sys_area_group_detail`.`area_id`,if(sub_group_detail.`area_id`,1,0) as is_used from 
                            `sys_area_group_detail` 
                            left join (
                            SELECT
                              `sys_area_group_detail`.`area_id`
                            FROM
                              `sys_area_group` INNER JOIN
                              `sys_area_group_detail` ON `sys_area_group_detail`.`agroup_id` =
                                `sys_area_group`.`agroup_id` where `sys_area_group`.`group_no` like '".$groupNo."__' and `sys_area_group`.is_del=0
                            ) as sub_group_detail on sub_group_detail.`area_id` = `sys_area_group_detail`.`area_id`
                            where `sys_area_group_detail`.`agroup_id`= ".$id." and `sys_area_group_detail`.is_del=0                 
                        ) as `area`  
                        inner join `sys_area` on `sys_area`.`area_id` = `area`.`area_id` 
                        inner join 
                     `sys_province` on sys_province.province_id = `sys_area`.province_id 
                    inner join `sys_city` on sys_city.city_id = `sys_area`.city_id             
                    where `area`.is_used = 0 order by `sys_area`.area_no";
            }
            else
            {
                return "";
            }
        }
                
        $arrayArea = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $strHTML = "";
        if (isset($arrayArea) && count($arrayArea) > 0) {
            $strHTML = "";
            $oProv = "";
            $nProv = "";

            $oCity = "";
            $nCity = "";

            $tempCity = "";
            $tempArea = "";

            $iAreaCount = count($arrayArea);

            for ($i = 0; $i < $iAreaCount; $i++) {
                $nProv = $arrayArea[$i]['province_id'];
                if ($oProv != $nProv) {
                    $strHTML .= "<li class='folder'><div class='tag tagOpen'></div><a href='javascript:;' rel_id='p_" .
                        $arrayArea[$i]['province_id'] . "' rel='" . $arrayArea[$i]['province_name'] .
                        "'>" . $arrayArea[$i]['province_name'] . "</a><ul style='display:none'>";

                    $oProv = $nProv;
                    $tempCity = "";

                    while ($i < $iAreaCount && $oProv == $arrayArea[$i]['province_id']) {
                        $nCity = $arrayArea[$i]['city_id'];
                        if ($oCity != $nCity) {
                            $oCity = $nCity;
                            $tempCity .= "<li class='folder'><div class='tag tagOpen'></div><a href='javascript:;' rel_id='c_" .
                                $arrayArea[$i]['city_id'] . "' rel='" . $arrayArea[$i]['city_fullname'] . "'>" .
                                $arrayArea[$i]['city_name'] . "</a><ul style='display:none'>";

                            $tempArea = "";
                            while ($i < $iAreaCount && $oCity == $arrayArea[$i]['city_id']) {
                                $tempArea .= "<li><a href='javascript:;' rel_id='a_" . $arrayArea[$i]['area_id'] .
                                    "' rel='" . $arrayArea[$i]['area_fullname'] . "'>" . $arrayArea[$i]['area_name'] .
                                    "</a></li>";

                                $i++;
                            }

                            $tempCity .= $tempArea . "</ul></li>";
                            --$i;
                        }
                        $i++;
                    }

                    $strHTML .= $tempCity . "</ul></li>";
                    --$i;
                    
                }
            }
        }
        return $strHTML;
        
    }
    
    /**
     * @functional 简单判断该区域中是否已有被分配的区域
    */
    public function BeenDistr($strAreaId,$id)
    {
        $arr_group_no = $this->select("group_no","agroup_id=$id","");
        $group_no = $arr_group_no[0]["group_no"];
        $len = strlen($group_no);
        $sql = "select group_concat(`agroup_id`) as agroup_id from
        (
            select distinct agroup_id from `sys_area_group` where `is_del`=0  and group_no like '$group_no%' and length(group_no)>$len 
        )t";
        $str_agroup_id = $this->objMysqlDB->executeAndReturn(false,$sql,null);
        
        
        $dataType = substr($strAreaId,0,1);
        
        if($dataType == "p")
        {
            $area_id = substr($strAreaId,2);
            $sql_p = "select sys_area.area_id,sys_area.city_id from sys_area  inner join sys_area_group_detail on sys_area_group_detail.province_id=sys_area.province_id or sys_area_group_detail.city_id=sys_area.city_id or sys_area_group_detail.area_id=sys_area.area_id 
                      where sys_area.province_id = $area_id and sys_area_group_detail.is_del=0 and sys_area_group_detail.agroup_id in($str_agroup_id) ";
            //echo($sql_p);
            $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql_p,null);	
           
            if(count($arrData) > 0)
                return 1;
        }
        if($dataType == "c")
        {
            $area_id = substr($strAreaId,2);
            $sql_c = "select sys_area.area_id from sys_area  inner join sys_area_group_detail on sys_area_group_detail.area_id=sys_area.area_id or sys_area_group_detail.city_id=sys_area.city_id
                      where sys_area.city_id = $area_id and sys_area_group_detail.is_del=0 and sys_area_group_detail.agroup_id in($str_agroup_id) ";
            
            $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql_c,null);	
           
            if(count($arrData) > 0)
                return 1;
        }
        if($dataType == "a")
        {
            $area_id = substr($strAreaId,2);
            $sql_a = "select sys_area_group_detail.area_id from sys_area_group_detail 
                      where sys_area_group_detail.area_id = $area_id and sys_area_group_detail.is_del=0 and sys_area_group_detail.agroup_id<>$id and sys_area_group_detail.agroup_id in($str_agroup_id) ";
            
            $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql_a,null);	
            if(count($arrData) > 0)
                return 1;
        }
        return 0;
    }
   
    
     
   
}
?>