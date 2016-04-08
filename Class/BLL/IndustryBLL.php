<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_industry的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-11 9:55:09
 * 修改人：      修改时间：
 * 修改描述：
 **/

require_once __DIR__.'/../Common/BLLBase.php';
require_once __DIR__.'/../Model/IndustryInfo.php';

class IndustryBLL extends BLLBase
{
    public function __construct()
    {
        parent::__construct();
    }
	
	/**
     * 新增一条记录
     * @param mixed $objIndustryInfo  Industry实例
     * @return 
     */
	public function insert(IndustryInfo $objIndustryInfo)
	{
		$sql = "INSERT INTO `sys_industry`(`industry_pid`,`industry_name`,`industry_full_name`,`industry_class`,`sort_index`)"
		." values(".$objIndustryInfo->iIndustryPid.",'".$objIndustryInfo->strIndustryName."','".$objIndustryInfo->strIndustryFullName."','".$objIndustryInfo->strIndustryClass."',".$objIndustryInfo->iSortIndex.")";
        return $this->objMysqlDB->executeNonQuery(false,$sql,null);
	}

	/**
     * 根据ID更新一条记录
     * @param mixed $objIndustryInfo  Industry实例
     * @return
     */
	public function updateByID(IndustryInfo $objIndustryInfo)
	{
		$sql = "update `sys_industry` set `industry_pid`=".$objIndustryInfo->iIndustryPid.",`industry_name`='".$objIndustryInfo->strIndustryName."',`industry_full_name`='".$objIndustryInfo->strIndustryFullName."',`industry_class`='".$objIndustryInfo->strIndustryClass."',`sort_index`=".$objIndustryInfo->iSortIndex." where industry_id=".$objIndustryInfo->iIndustryId;
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
			$sField = T_Industry::AllFields;
		if ($sWhere != "")
       		 $sWhere = " where ".$sWhere;
		
		if ($sOrder == "")
			$sOrder = " ";
		else
			$sOrder = " order by ".$sOrder;
			
		if ($sGroup != "")
			$sGroup = " group by ".$sGroup;
			
		$sLimit = "";
		if(is_int($iRecordCount)&& $iRecordCount>0)
			$sLimit = " limit 0,".$iRecordCount;
			
		$sql = "SELECT ".$sField." FROM `sys_industry` ".$sWhere.$sGroup.$sOrder.$sLimit ;
        return $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
    } 
		
	/**
     * 根据ID,返回一个sys_industry对象
	 * @param mixed $id 
     * @return sys_industry对象
     */
	public function getModelByID($id)
	{
		$objIndustryInfo = null;
		$arryInfo = self::select("*","industry_id=".$id,"");
		
		if (isset($arryInfo)&& count($arryInfo)>0)
        {
			$objIndustryInfo = new IndustryInfo();
			$objIndustryInfo->iIndustryId = $arryInfo[0]['industry_id'];
			$objIndustryInfo->iIndustryPid = $arryInfo[0]['industry_pid'];
			$objIndustryInfo->strIndustryName = $arryInfo[0]['industry_name'];
			$objIndustryInfo->strIndustryFullName = $arryInfo[0]['industry_fullname'];
			$objIndustryInfo->strIndustryClass = $arryInfo[0]['industry_class'];
			$objIndustryInfo->iSortIndex = $arryInfo[0]['sort_index'];
                        settype($objIndustryInfo->iIndustryId, 'integer');
                        settype($objIndustryInfo->iIndustryPid, 'integer');
                        settype($objIndustryInfo->iSortIndex, 'integer');
		}
		
		return $objIndustryInfo;
	}
	
	public function selectPage($sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,$iRecordCount, $iPageCount)
	{
		return $this->objMysqlDB->selectPage("`sys_industry`",$sField, $sWhere, $sOrder,$sGroup,$iCurrentPage,$iPerPageCount,$iRecordCount, $iPageCount);
	}    
    //获取行业信息到js对象 通过行业ID获取父行业等信息
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
    //获取行业JSON信息
    public function GetPIndustryJson()
    {
        $sql = "select `industry_id`,`industry_pid`,`industry_name`,`industry_fullname` from `sys_industry` where 
        `industry_pid`<>0 order by `industry_pid`,`industry_id`;
                select `industry_id`,`industry_name` from `sys_industry` where `industry_pid`=0 order by `industry_id`;";        
        $arrayIndustry = $this->objMysqlDB->fetchAllAssoc(false,$sql,null);
        $strJson="{";
        if(isset($arrayIndustry) && count($arrayIndustry)==2)
        {
            $table_p_ind = $arrayIndustry[1];
            $count_p_ind = count($table_p_ind);//父类别记录数
            
            $table_ind = $arrayIndustry[0];
            $count_ind = count($table_ind);
            $item_index=0;//子行业表 index
            for($item_p_index=0;$item_p_index<$count_p_ind;$item_p_index++)//父类别循环
            {
                $item_p_ind = $table_p_ind[$item_p_index];
                $strJson.="\"{$item_p_ind["industry_id"]}\":{\"name\":\"{$item_p_ind["industry_name"]}\",\"inds\":{";
                for(;$item_index<$count_ind;$item_index++)
                {
                    $item_ind=$table_ind[$item_index];
                    if($item_p_ind["industry_id"]==$item_ind["industry_pid"])
                    {
                        $strJson.="\"{$item_ind["industry_id"]}\":{\"name\":\"{$item_ind["industry_name"]}\",\"fullName\":\"{$item_ind["industry_fullname"]}\"}";
                    }
                    else
                    {
                        $strJson = substr($strJson,0,strlen($strJson)-1);
                        break;
                    }
                    if($item_index+1!=$count_ind)
                        $strJson.=",";
                }
                $strJson.="}},";
            }
            if(strlen($strJson)>1)
                $strJson = substr($strJson,0,strlen($strJson)-1);                
        }
        $strJson .= "}";
        return $strJson;
    }
}
?>