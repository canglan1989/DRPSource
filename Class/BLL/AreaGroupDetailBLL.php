<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_agroup_detail的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-23 10:51:05
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/AreaGroupDetailInfo.php';

class AreaGroupDetailBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * @functional 新增一条记录
     * @param AreaGroupDetailInfo $objAreaGroupDetailInfo  AreaGroupDetail实例
     * @return 
     */
	public function insert(AreaGroupDetailInfo $objAreaGroupDetailInfo)
	{
		$sql = "INSERT INTO `sys_area_group_detail`(`agroup_id`,`province_id`,`city_id`,`area_id`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`)"
		." values(".$objAreaGroupDetailInfo->iAgroupId.",".$objAreaGroupDetailInfo->iProvinceId.",".$objAreaGroupDetailInfo->iCityId.",".$objAreaGroupDetailInfo->iAreaId.",".$objAreaGroupDetailInfo->iIsDel.",".$objAreaGroupDetailInfo->iUpdateUid.",now(),".$objAreaGroupDetailInfo->iCreateUid.",now())";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * @functional 根据ID更新一条记录
     * @param AreaGroupDetailInfo $objAreaGroupDetailInfo  AreaGroupDetail实例
     * @return
     */
	public function updateByID(AreaGroupDetailInfo $objAreaGroupDetailInfo)
	{
		$sql = "update `sys_area_group_detail` set `agroup_id`=".$objAreaGroupDetailInfo->iAgroupId.",`province_id`=".$objAreaGroupDetailInfo->iProvinceId.",`city_id`=".$objAreaGroupDetailInfo->iCityId.",`area_id`=".$objAreaGroupDetailInfo->iAreaId.",`is_del`=".$objAreaGroupDetailInfo->iIsDel.",`update_uid`=".$objAreaGroupDetailInfo->iUpdateUid.",`update_time`= now() where agroup_detail_id=".$objAreaGroupDetailInfo->iAgroupDetailId;
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
		$sql = "update `sys_area_group_detail` set is_del=1,update_uid=".$userID.",update_time=now() where agroup_detail_id=".$id;
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
			$sField = T_AreaGroupDetail::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_area_group_detail` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * @functional 根据ID,返回一个sys_area_group_detail对象
	 * @param int $id 
     * @return sys_area_group_detail对象
     */
	public function getModelByID($id)
	{
		$objAreaGroupDetailInfo = null;
		$arrayInfo = $this->select("*","agroup_detail_id=".$id,"");
		
		if (isset($arrayInfo)&& count($arrayInfo)>0)
        {
			$objAreaGroupDetailInfo = new AreaGroupDetailInfo();
			$objAreaGroupDetailInfo->iAgroupDetailId = $arrayInfo[0]['agroup_detail_id'];
			$objAreaGroupDetailInfo->iAgroupId = $arrayInfo[0]['agroup_id'];
			$objAreaGroupDetailInfo->iProvinceId = $arrayInfo[0]['province_id'];
			$objAreaGroupDetailInfo->iCityId = $arrayInfo[0]['city_id'];
			$objAreaGroupDetailInfo->iAreaId = $arrayInfo[0]['area_id'];
			$objAreaGroupDetailInfo->iIsDel = $arrayInfo[0]['is_del'];
			$objAreaGroupDetailInfo->iUpdateUid = $arrayInfo[0]['update_uid'];
			$objAreaGroupDetailInfo->strUpdateTime = $arrayInfo[0]['update_time'];
			$objAreaGroupDetailInfo->iCreateUid = $arrayInfo[0]['create_uid'];
			$objAreaGroupDetailInfo->strCreateTime = $arrayInfo[0]['create_time'];
		
			settype($objAreaGroupDetailInfo->iAgroupDetailId,"integer");
			settype($objAreaGroupDetailInfo->iAgroupId,"integer");
			settype($objAreaGroupDetailInfo->iProvinceId,"integer");
			settype($objAreaGroupDetailInfo->iCityId,"integer");
			settype($objAreaGroupDetailInfo->iAreaId,"integer");
			settype($objAreaGroupDetailInfo->iIsDel,"integer");
			settype($objAreaGroupDetailInfo->iUpdateUid,"integer");
			
			settype($objAreaGroupDetailInfo->iCreateUid,"integer");
			
		}
		
		return $objAreaGroupDetailInfo;
	}
	
	
    /**
     * @functional 取得某个区域组下的所有区域ID
     * @author liujunchen
    */
    public function getAreaByAreaGroupId($areaGroupId)
    {
        $sql = "SELECT area_id FROM sys_area_group_detail WHERE agroup_id IN ($areaGroupId) AND is_del = 0";
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
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
		$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_area_group_detail` WHERE $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false,$sqlCount,null);
		
        $sqlData  = "SELECT $strPageFields FROM `sys_area_group_detail` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return  $this->objMysqlDB->fetchAllAssoc(false,$sqlData,null);		
	}
    
    /**
     * @functional 删除区域
     * $iEdit = 1 编辑 $iEdit=0 添加
     */
    public function DelAreas($areaGroupID,$userID)
    {
        $sql = "update `sys_area_group_detail` set is_del=1,update_uid=$userID,update_time=now() where agroup_id=$areaGroupID and is_del=0";
        $icount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        return $icount;
    }
    
    /**
     * @functional 添加区域
     */
    public function AddAreas($areaGroupID,$strProvIDs,$strCityIDs,$strAreaIDs,$userID)
    {
        if($areaGroupID <= 0)
            return 0;
            
        if($strProvIDs.$strCityIDs.$strAreaIDs == "")
            return 0;
        
        $arrayLength = 0;
        
        $sql = "INSERT INTO `sys_area_group_detail`(`agroup_id`,`province_id`,`city_id`,`area_id`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`) values";
        if(strlen($strProvIDs)>0)
        {
            $arrayProvID = explode(",",$strProvIDs);
            $arrayLength = count($arrayProvID);
            for($i = 0;$i < $arrayLength; $i++)
            {
                $sql .="($areaGroupID,$arrayProvID[$i],0,0,0,0,now(),$userID,now()),";
            }
        }
        
        if(strlen($strCityIDs)>0)
        {
            $arrayCityID = explode(",",$strCityIDs);
            $arrayLength = count($arrayCityID);
            for($i = 0;$i < $arrayLength; $i++)
            {
                $sql .="($areaGroupID,0,$arrayCityID[$i],0,0,0,now(),$userID,now()),";
            }
        }
                
        if(strlen($strAreaIDs)>0)
        {
            $arrayAreaID = explode(",",$strAreaIDs);
            $arrayLength = count($arrayAreaID);
            for($i = 0;$i < $arrayLength; $i++)
            {
                $sql .="($areaGroupID,0,0,$arrayAreaID[$i],0,0,now(),$userID,now()),";
            }
        }
        
        $sql = substr($sql,0,strlen($sql)-1);
        $icount = $this->objMysqlDB->executeNonQuery(false,$sql,null);
        return $icount;
        
        
    }
    
    /**
     * @functional 区域组已经关联区域的信息
     */
    public function GetGroupAreaJson($areaGroupID,&$strAreaID)
    {
        if($areaGroupID <= 0)
            return "[]";
            
        $sql = "select agroup_detail_id,area_id,city_id,province_id,area_name,area_fullname,city_name,city_fullname,province_name
             from 
             (
                SELECT sys_area_group_detail.`agroup_detail_id`,
                  if(sys_area_group_detail.area_id,sys_area_group_detail.area_id,0) as area_id,
                  if(sys_area_group_detail.city_id,sys_area_group_detail.city_id,0) as city_id,
                  if(sys_area_group_detail.province_id,sys_area_group_detail.province_id,0) as province_id,
                  if(sys_area.area_id,sys_area.area_name,'') as area_name,
                  if(sys_area.area_id,sys_area.area_fullname,'') as area_fullname,
                  if(sys_area.`area_id`,sys_area.area_no,'') as area_no,
                  if(sys_city.city_id,sys_city.city_name,'') as city_name,
                  if(sys_city.city_id,sys_city.city_fullname,'') as city_fullname,
                  if(sys_city.`city_id`,sys_city.city_no,'') as city_no,
                  if(sys_province.province_id,sys_province.province_name,'') as province_name,
                  if(sys_province.`province_id`,sys_province.province_no,'') as province_no 
                FROM
                	sys_area_group_detail 
                  left JOIN sys_area ON (sys_area_group_detail.area_id = sys_area.area_id) 
                  left JOIN sys_city ON (sys_area_group_detail.city_id = sys_city.city_id) 
                  left JOIN sys_province ON (sys_area_group_detail.province_id = sys_province.province_id)                   
                  where sys_area_group_detail.`is_del`=0 and sys_area_group_detail.agroup_id = $areaGroupID 
              ) t order by CONCAT(province_no,city_no,area_no)  ";
              
        $arrayGroupArea = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        
        
        $strAreaID = "";
        if(isset($arrayGroupArea) && count($arrayGroupArea)>0)
        {            
            $iArrayLength = count($arrayGroupArea);	
            $strJson = "[";
            
            for($i=0;$i<$iArrayLength;$i++)
            {
                if($arrayGroupArea[$i]["area_id"]>0)
                {
                        
                    $strAreaID .= ","."a_".$arrayGroupArea[$i]["area_id"];
                    $strJson .= "{dataType:'area',id:'".$arrayGroupArea[$i]["area_id"]."',name:'".$arrayGroupArea[$i]["area_name"]."',fullName:'".$arrayGroupArea[$i]["area_fullname"]."',agroupAreaID:'".$arrayGroupArea[$i]["agroup_detail_id"]."'}";
                
                }
                else if($arrayGroupArea[$i]["city_id"]>0) 
                    $strJson .= "{dataType:'city',id:'".$arrayGroupArea[$i]["city_id"]."',name:'".$arrayGroupArea[$i]["city_name"]."',fullName:'".$arrayGroupArea[$i]["city_fullname"]."',agroupAreaID:'".$arrayGroupArea[$i]["agroup_detail_id"]."'}";
                else
                    $strJson .= "{dataType:'province',id:'".$arrayGroupArea[$i]["province_id"]."',name:'".$arrayGroupArea[$i]["province_name"]."',fullName:'".$arrayGroupArea[$i]["province_name"]."',agroupAreaID:'".$arrayGroupArea[$i]["agroup_detail_id"]."'}";
                
                if($i != $iArrayLength-1)
                    $strJson .= ",";
            }
            
            $strJson .= "]";
            $strAreaID = substr($strAreaID,1); 
            return $strJson;
        }
        
        return "[]";
    }
    /**
     * @functional 区域组已经关联区域信息的HTML格式 $areaGroupID 当前区域组ID
     */
    public function GetGroupAreaHtml($areaGroupID)
    {
        if($areaGroupID <= 0)
            return "[]";
        
        $groupNo = "";
        $sql = "SELECT `sys_area_group`.`group_no` FROM `sys_area_group` where agroup_id= ".$areaGroupID;            
        $arrayData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
       
        if(isset($arrayData)&&count($arrayData)>0)
        {
            $groupNo = $arrayData[0]["group_no"];
            $sql = "select sys_province.province_name,sys_city.city_name,sys_city.city_fullname,`sys_area`.`area_id`, 
                `sys_area`.`city_id`,`sys_area`.`province_id`,`sys_area`.`area_name`,`sys_area`.`area_fullname`,`area`.is_used         
                from (    
                        select `sys_area_group_detail`.`area_id`,if(sub_group_detail.`area_id` and sub_group_detail.is_del=0,1,0) as is_used from 
                        `sys_area_group_detail` 
                        left join (
                        SELECT
                          `sys_area_group_detail`.`area_id`,`sys_area_group_detail`.is_del
                        FROM
                          `sys_area_group` INNER JOIN
                          `sys_area_group_detail` ON `sys_area_group_detail`.`agroup_id` =
                            `sys_area_group`.`agroup_id` where `sys_area_group`.`group_no` like '".$groupNo."__' and `sys_area_group`.is_del=0 and `sys_area_group_detail`.is_del=0
                        ) as sub_group_detail on sub_group_detail.`area_id` = `sys_area_group_detail`.`area_id`
                        where `sys_area_group_detail`.`agroup_id`= ".$areaGroupID." and `sys_area_group_detail`.is_del=0                 
                    ) as `area`  
                    inner join `sys_area` on `sys_area`.`area_id` = `area`.`area_id` 
                    inner join 
                 `sys_province` on sys_province.province_id = `sys_area`.province_id 
                inner join `sys_city` on sys_city.city_id = `sys_area`.city_id order by `sys_area`.area_no";
             
            $arrayArea = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
            $strHTML = "";
            if (isset($arrayArea) && count($arrayArea) > 0) 
            {
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
                            
                        $oProv = $nProv;
                        $tempCity = " rel_id='p_" .
                            $arrayArea[$i]['province_id'] . "' rel='" . $arrayArea[$i]['province_name'] .
                            "'>" . $arrayArea[$i]['province_name'] . "</a><ul style='display:none'>";
                            
                        $bCityHaveUsed = false;
                        while ($i < $iAreaCount && $oProv == $arrayArea[$i]['province_id']) {
                            $nCity = $arrayArea[$i]['city_id'];
                            if ($oCity != $nCity) {
                                $oCity = $nCity;                                
                                
                                $tempArea = " rel_id='c_" .$arrayArea[$i]['city_id'] . "' rel='" . $arrayArea[$i]['city_fullname'] . "'>" .
                                    $arrayArea[$i]['city_name'] . "</a><ul style='display:none'>";
                                    
                                $bAreaHaveUsed = false;
                                while ($i < $iAreaCount && $oCity == $arrayArea[$i]['city_id']) {
                                    if($arrayArea[$i]['is_used']== 1)
                                        $bAreaHaveUsed = true;
                                        
                                    $tempArea .= "<li><a href='javascript:;' ".( $arrayArea[$i]['is_used']== 1? " class='dis'":"")." rel_id='a_" . $arrayArea[$i]['area_id'] .
                                        "' rel='" . $arrayArea[$i]['area_fullname'] . "'>" . $arrayArea[$i]['area_name'] .
                                        "</a></li>";
    
                                    $i++;
                                }
    
                                $tempCity .= "<li class='folder'><div class='tag tagOpen'></div><a href='javascript:;' ".
                                ($bAreaHaveUsed ? "class='dis'":"")." ";
                                if($bAreaHaveUsed == true)
                                    $bCityHaveUsed = true;
                                    
                                $tempCity .= $tempArea . "</ul></li>";
                                --$i;
                            }
                            $i++;
                        }
                        
                        $strHTML .= "<li class='folder'><div class='tag tagOpen'></div><a href='javascript:;' ".($bCityHaveUsed?"class='dis'":"")." ";
                        $strHTML .= $tempCity . "</ul></li>";
                        --$i;
                        
                    }
                }
            }
            
            return $strHTML;
        }
        
        
        return "";
        
        /*    
        $sql1 = "select agroup_detail_id,area_id,city_id,province_id,area_name,area_fullname,city_name,city_fullname,province_name
             from 
             (
                SELECT sys_area_group_detail.`agroup_detail_id`,
                  if(sys_area_group_detail.area_id,sys_area_group_detail.area_id,0) as area_id,
                  if(sys_area_group_detail.city_id,sys_area_group_detail.city_id,0) as city_id,
                  if(sys_area_group_detail.province_id,sys_area_group_detail.province_id,0) as province_id,
                  if(sys_area.area_id,sys_area.area_name,'') as area_name,
                  if(sys_area.area_id,sys_area.area_fullname,'') as area_fullname,
                  if(sys_area.`area_id`,sys_area.area_no,'') as area_no,
                  if(sys_city.city_id,sys_city.city_name,'') as city_name,
                  if(sys_city.city_id,sys_city.city_fullname,'') as city_fullname,
                  if(sys_city.`city_id`,sys_city.city_no,'') as city_no,
                  if(sys_province.province_id,sys_province.province_name,'') as province_name,
                  if(sys_province.`province_id`,sys_province.province_no,'') as province_no 
                FROM
                	sys_area_group_detail 
                  left JOIN sys_area ON (sys_area_group_detail.area_id = sys_area.area_id) 
                  left JOIN sys_city ON (sys_area_group_detail.city_id = sys_city.city_id) 
                  left JOIN sys_province ON (sys_area_group_detail.province_id = sys_province.province_id)                   
                  where sys_area_group_detail.`is_del`=0 and sys_area_group_detail.agroup_id = $areaGroupID 
              ) t order by CONCAT(province_no,city_no,area_no)  ";
        */
        /*
        $sql = "SELECT
                  `sys_area_group_detail`.`area_id`, 
                  `sys_area`.`city_id`,  
                  `sys_area`.`area_name`,
                  `sys_area`.`area_fullname`, 
                  `sys_city`.`city_name`,
                  `sys_city`.`city_fullname`, 
                  `sys_area`.`province_id`,
                  `sys_province`.`province_name`, 
                  `sys_area_group_detail`.`agroup_detail_id`  
                FROM
                  `sys_area_group_detail` 
                  inner JOIN `sys_area` ON `sys_area_group_detail`.`area_id` = `sys_area`.`area_id`
                  left JOIN `sys_city` ON `sys_city`.`city_id` = `sys_area`.`city_id` 
                  left JOIN `sys_province` ON `sys_area`.`province_id` = `sys_province`.`province_id`  
                where sys_area_group_detail.agroup_id=$areaGroupID and sys_area_group_detail.is_del=0
                             
             ";   
        $sql_group_no = "select group_no from  sys_area_group where agroup_id=$areaGroupID and is_del=0";
        $arr_group_no = $this->objMysqlDB->fetchAllAssoc(false,$sql_group_no,null);
        
        $group_no = $arr_group_no[0]["group_no"];
        $sup_group_no = substr($group_no,0,2);
        $sql_group_id = "select group_concat(agroup_id) from  sys_area_group where group_no like '$sup_group_no%' and length(group_no)<=length($group_no) and is_del=0";
        
        $str_group_id = $this->objMysqlDB->executeAndReturn(false,$sql_group_id,null);
        
        $arrayArea = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $strHTML = "";

    	if (isset($arrayArea) && count($arrayArea) > 0)
    	{
    	    $strHTML = "";
    	    $oProv = "";
    	    $nProv = "";
    
    	    $oCity = "";
    	    $nCity = "";
    
    	    $tempCity = "";
    	    $tempArea = "";
    
    	    $iAreaCount = count($arrayArea);
    
    	    for ($i = 0; $i < $iAreaCount; $i++)
    	    {
    		$nProv = $arrayArea[$i]['province_id'];
    		if ($oProv != $nProv)
    		{
    		    $sql_c = "select 1 from sys_area 
                    left join sys_area_group_detail 
                    on sys_area.area_id=sys_area_group_detail.area_id 
                    where sys_area.province_id=$nProv and sys_area_group_detail.is_del=0 and sys_area_group_detail.agroup_id not in($str_group_id) "; 
                    
                    $arrData_c = $this->objMysqlDB->fetchAllAssoc(false,$sql_c,null);
                    $strClass="";
                    if(count($arrData_c)>0)
                        $strClass = "dis";
                $strHTML .= "<li class='folder'><div class='tag tagOpen'></div><a href='javascript:;' class='$strClass' rel_id='p_" .
    			    $arrayArea[$i]['province_id'] . "' rel='" . $arrayArea[$i]['province_name'] . "' id='p_".$arrayArea[$i]['province_id']."'>" . $arrayArea[$i]['province_name'] . "</a><ul style='display:none'>";
    
    		    $oProv = $nProv;
    		    $tempCity = "";
    
    		    while ($i < $iAreaCount && $oProv == $arrayArea[$i]['province_id'])
    		    {
    			$nCity = $arrayArea[$i]['city_id'];
    			if ($oCity != $nCity)
    			{
    			    $oCity = $nCity;
                    $sql_c = "select 1 from sys_area 
                    left join sys_area_group_detail 
                    on sys_area.area_id=sys_area_group_detail.area_id 
                    where sys_area.city_id=$nCity and sys_area_group_detail.is_del=0 and sys_area_group_detail.agroup_id not in($str_group_id)"; 
                    
                    $arrData_c = $this->objMysqlDB->fetchAllAssoc(false,$sql_c,null);
                    $strClass="";
                    if(count($arrData_c)>0)
                        $strClass = "dis";
                    
    			    $tempCity .= "<li class='folder'><div class='tag tagOpen'></div><a href='javascript:;' class='$strClass' rel_id='c_" .
    				    $arrayArea[$i]['city_id'] . "' rel='" . $arrayArea[$i]['city_fullname'] . "' id='c_".$arrayArea[$i]['city_id']."'>" . $arrayArea[$i]['city_name'] . "</a><ul style='display:none'>";
    
    			    $tempArea = "";
    
    			    while ($i < $iAreaCount && $oCity == $arrayArea[$i]['city_id'])
    			    {
    				
                    $area_id = $arrayArea[$i]['area_id'];
                    
                    $arrData = $this->select("1","area_id=$area_id and agroup_id not in($str_group_id) and is_del=0",""); 
                    if(count($arrData) > 0)
                    $tempArea .= "<li><a href='javascript:;' class='dis' rel_id='a_" . $arrayArea[$i]['area_id'] . "' rel='"
    					. $arrayArea[$i]['area_fullname'] . "' id='a_".$arrayArea[$i]['area_id']."'>" . $arrayArea[$i]['area_name'] . "</a></li>";
                    else    
                    $tempArea .= "<li><a href='javascript:;' rel_id='a_" . $arrayArea[$i]['area_id'] . "' rel='"
    					. $arrayArea[$i]['area_fullname'] . "' id='a_".$arrayArea[$i]['area_id']."'>" . $arrayArea[$i]['area_name'] . "</a></li>";
    
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
        return $strHTML;*/
     }
}
?>