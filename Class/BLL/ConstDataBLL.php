<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_const_data的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-12 9:47:42
 * 修改人：      修改时间：
 * 修改描述：
 **/
require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/ConstDataInfo.php';

class ConstDataBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objConstDataInfo  ConstData实例
     * @return 
     */
	public function insert(ConstDataInfo $objConstDataInfo)
	{
		$sql = "INSERT INTO `sys_const_data`(`c_value`,`c_no`,`c_name`,`data_type`,`sort_index`,`is_lock`,`is_system`,`is_def`,`is_del`,`c_remark`,`create_uid`,`create_time`,`update_uid`,`update_time`)"
		." values('".$objConstDataInfo->strcValue."','".$objConstDataInfo->strcNo."','".$objConstDataInfo->strcName."','".$objConstDataInfo->strDataType."',".$objConstDataInfo->iSortIndex.",".$objConstDataInfo->iIsLock.",".$objConstDataInfo->iIsSystem.",".$objConstDataInfo->iIsDef.",".$objConstDataInfo->iIsDel.",'".$objConstDataInfo->strcRemark."',".$objConstDataInfo->iCreateUid.",now(),".$objConstDataInfo->iUpdateUid.",now())";
        if($this->objMysqlDB->executeNonQuery(false,$sql,null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objConstDataInfo  ConstData实例
     * @return
     */
	public function updateByID(ConstDataInfo $objConstDataInfo)
	{
		$sql = "update `sys_const_data` set `c_value`='".$objConstDataInfo->strcValue."',`c_no`='".$objConstDataInfo->strcNo."',`c_name`='".$objConstDataInfo->strcName."',`data_type`='".$objConstDataInfo->strDataType."',`sort_index`=".$objConstDataInfo->iSortIndex.",`is_lock`=".$objConstDataInfo->iIsLock.",`is_system`=".$objConstDataInfo->iIsSystem.",`is_def`=".$objConstDataInfo->iIsDef.",`is_del`=".$objConstDataInfo->iIsDel.",`c_remark`='".$objConstDataInfo->strcRemark."',`update_uid`=".$objConstDataInfo->iUpdateUid.",`update_time`='".$objConstDataInfo->strUpdateTime."' where c_id=".$objConstDataInfo->icId;
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}
	/**
     * 根据ID更新一条记录
	 * @param mixed $id 记录ID
     * @param mixed $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id,$userID)
    {
		$sql = "update `sys_const_data` set is_del=1,update_uid=".$userID.",update_time=now() where c_id=".$id;
		return $this->objMysqlDB->executeNonQuery(false,$sql,null);
    }
	
	
	/**
     * 返回数据
	 * @param mixed $sField 字段
	 * @param mixed $sWhere 不用加 where	
	 * @param mixed $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder)
    {
        return $this->selectTop($sField, $sWhere, $sOrder, "", -1);
    } 
				
	/**
     * 返回TOP数据
	 * @param mixed $sField 字段
	 * @param mixed $sWhere 不用加 where	
	 * @param mixed $sOrder 无order  by 关键字的排序语句
	 * @param mixed $sGroup group  by 关键字的分组
	 * @param mixed $iRecordCount 记录数 0表示全部
     * @return 
     */
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount)
    {
		if($sField == "*" || $sField == "")
			$sField = T_ConstData::AllFields;
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
			
		$sql = "SELECT ".$sField." FROM `sys_const_data` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个sys_const_data对象
	 * @param mixed $id 
     * @return sys_const_data对象
     */
	public function getModelByID($id,$data_type="")
	{
		$objConstDataInfo = null;
		$arryInfo = self::select("*","c_id=".$id.($data_type==""?"":" and data_type='{$data_type}'"),"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objConstDataInfo = new ConstDataInfo();
			$objConstDataInfo->icId = $arryInfo[0]['c_id'];
			$objConstDataInfo->strcValue = $arryInfo[0]['c_value'];
			$objConstDataInfo->strcNo = $arryInfo[0]['c_no'];
			$objConstDataInfo->strcName = $arryInfo[0]['c_name'];
			$objConstDataInfo->strDataType = $arryInfo[0]['data_type'];
			$objConstDataInfo->iSortIndex = $arryInfo[0]['sort_index'];
			$objConstDataInfo->iIsLock = $arryInfo[0]['is_lock'];
			$objConstDataInfo->iIsSystem = $arryInfo[0]['is_system'];
			$objConstDataInfo->iIsDef = $arryInfo[0]['is_def'];
			$objConstDataInfo->iIsDel = $arryInfo[0]['is_del'];
			$objConstDataInfo->strcRemark = $arryInfo[0]['c_remark'];
			$objConstDataInfo->iCreateUid = $arryInfo[0]['create_uid'];
			$objConstDataInfo->strCreateTime = $arryInfo[0]['create_time'];
			$objConstDataInfo->iUpdateUid = $arryInfo[0]['update_uid'];
			$objConstDataInfo->strUpdateTime = $arryInfo[0]['update_time'];
            settype($objConstDataInfo->icId,"integer");
            settype($objConstDataInfo->iSortIndex,"integer");
            settype($objConstDataInfo->iIsLock,"integer");
            settype($objConstDataInfo->iIsSystem,"integer");
            settype($objConstDataInfo->iIsDel,"integer");
            settype($objConstDataInfo->iIsDef,"integer");
            settype($objConstDataInfo->iCreateUid,"integer");
            settype($objConstDataInfo->iUpdateUid,"integer");
		}
		return $objConstDataInfo;
	}
	
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,$iRecordCount, $iPageCount)
	{
		return $this->objMysqlDB->selectPage("`sys_const_data`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,$iRecordCount, $iPageCount);
	}
    
    //获取常量信息到js对象
    public function GetIndustryJson()
    {
        $sql = "select `industry_id`,`industry_pid`,`industry_name`,`industry_fullname` from `sys_industry`;";
        
        $arrayInd = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        
        if(isset($arrayInd) && count($arrayInd)>0)
        {
            $strJson = "{";
            $count = count($arrayInd);
            for($item_index=0;$item_index<$count;$item_index++)
            {
                $item = $arrayInd[$item_index];
                $strJson.="\"{$item["industry_id"]}\":{\"name\":\"{$item["industry_name"]}\",\"fullname\":\"{$item["industry_fullname"]}\",\"industry_pid\":\"{$item["industry_pid"]}\"},";
            }
            if(strlen($strJson)>1)
                $strJson = substr($strJson,0,strlen($strJson)-1);
            $strJson.="}";
            return $strJson;
        }
        return "{}";
    }
//    public function selRegistrStatus()
//    {
//    	$sql = "select `c_id`,`data_type`,`c_name`,`c_value` from `sys_const_data` order by `data_type`";
//    	$arrayInd = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
//    	if (isset($arrayInd) && count($arrayInd) > 0)
//    	{
//    		$table_data_type = $arrayInd[1];
//    		$count_data_type = count($table_data_type);
//    		$table_c_id = $arrayInd[0];
//    		$count_c_id = count($table_c_id);
//    		$item_second_index = 0;
//    		$strJson = "{";
//    		for ($item_first_index = 0;$item_first_index < $count_data_type;$item_first_index++)
//    		{
//    			$item_index = $table_data_type[$item_first_index];
//    			$strJson .="\"{$item_index['data_type']}\":{";
//    			for (;$item_second_index < $count_c_id;$item_second_index++)
//    			{
//    				$item_indexs = $table_c_id[$item_second_index];
//    				if ($item_indexs["data_type"] == $item_index["data_type"])
//    				{
//    					$strJson.="\"{$item_indexs['c_value']}\":\"{$item_indexs['c_name']}\"}";
//    				}
//    				else 
//    				{
//    					$strJson = substr($strJson,0,strlen($strJson)-1);
//    					break;
//    				}
//    				if ($item_second_index+1!=$count_c_id)
//    				{
//    					$strJson .=",";
//    				}
//    			}
//    			$strJson.="}}";
//    		}
//    		if(strlen($strJson)>1)
//    		{
//    			$strJson = substr($strJson,0,strlen($strJson)-1);
//    		}
//    	}
//    	$strJson .= "}";
//    	return "{}";
//    }
    //获取常量信息到JS对象
    public function GetRegistrStatus()
    {
    	$sql = "SELECT `c_id`,`data_type`,`c_name`,`c_value`,`sort_index` FROM `sys_const_data` ORDER BY `data_type` ; 
SELECT `data_type` FROM `sys_const_data` GROUP BY `data_type` ORDER BY `data_type`";
    	$arrayInd = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    	$strJson = "{";
    	if (isset($arrayInd) && count($arrayInd) > 0)
    	{
    		$table_data_type = $arrayInd[1];
    		$count_data_type = count($table_data_type);
    		$table_c_id = $arrayInd[0];
    		$count_c_id = count($table_c_id);
    		$item_second_index = 0;
    		for ($item_first_index = 0;$item_first_index < $count_data_type;$item_first_index++)
    		{
    			$item_index = $table_data_type[$item_first_index];
    			$strJson .="\"{$item_index['data_type']}\":{";
    			for (;$item_second_index < $count_c_id;$item_second_index++)
    			{
    				$item_indexs = $table_c_id[$item_second_index];
    				if ($item_indexs["data_type"] == $item_index["data_type"])
    				{
    					$strJson.="\"{$item_indexs['c_value']}\":\"{$item_indexs['c_name']}\"";
    				}
    				else 
    				{
    					$strJson = substr($strJson,0,strlen($strJson)-1);
    					break;
    				}
    				if ($item_second_index+1!=$count_c_id)
    				{
    					$strJson .=",";
    				}
    			}
    			$strJson.="},";
    		}
    		if(strlen($strJson)>1)
    		{
    			$strJson = substr($strJson,0,strlen($strJson)-1);
    		}
    	}
    	
    	$strJson .= "}";
    	return $strJson;
    }
    
    /**
     * 获取无效选项新的值
     * @return type 
     */
    public function getNewInvaildContactValue(){
        $sql = "select c_value from sys_const_data where data_type = 'Invalid_Contact' ORDER BY c_value desc limit 1";
        $arrData = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        if($arrData){
            return $arrData[0]['c_value'] + 1;
        }else{
            return 1;
        }
    }

}