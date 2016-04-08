<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_province的类业务逻辑层
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011/8/2 17:09:33
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/ProvinceInfo.php';

class ProvinceBLL extends BLLBase
{

    public function __construct()
    {
	parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param ProvinceInfo $objProvinceInfo  Province实例
     * @return 
     */
    public function insert(ProvinceInfo $objProvinceInfo)
    {
	$sql = "INSERT INTO `sys_province`(`province_no`,`province_name`,`province_place`,`short_name`,`sort_index`)"
		. " values('" . $objProvinceInfo->strProvinceNo . "','" . $objProvinceInfo->strProvinceName . "','" . $objProvinceInfo->strProvincePlace . "','" . $objProvinceInfo->strShortName . "'," . $objProvinceInfo->iSortIndex . ")";
	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据ID更新一条记录
     * @param ProvinceInfo $objProvinceInfo  Province实例
     * @return
     */
    public function updateByID(ProvinceInfo $objProvinceInfo)
    {
	$sql = "update `sys_province` set `province_no`='" . $objProvinceInfo->strProvinceNo . "',`province_name`='" . $objProvinceInfo->strProvinceName . "',`province_place`='" . $objProvinceInfo->strProvincePlace . "',`short_name`='" . $objProvinceInfo->strShortName . "',`sort_index`=" . $objProvinceInfo->iSortIndex . " where province_id=" . $objProvinceInfo->iProvinceId;
	return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    /**
     * @functional 根据省份Id查询身份名称
     * @author liujunchen
    */
    public function getProvinceName($pid)
    {
        $sql = "SELECT province_name FROM sys_province WHERE province_id = ".$pid;
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
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
	if ($sField == "*" || $sField == "")
	    $sField = T_Province::AllFields;
	if ($sWhere != "")
	    $sWhere = " where " . $sWhere;

	if ($sOrder == "")
	    $sOrder = " order by sort_index";
	else
	    $sOrder = " order by " . $sOrder;

	if ($sGroup != "")
	    $sGroup = " group by " . $sGroup;

	$sLimit = "";
	if (is_int($iRecordCount) && $iRecordCount > 0)
	    $sLimit = " limit 0," . $iRecordCount;

	$sql = "SELECT " . $sField . " FROM `sys_province` " . $sWhere .$sGroup.$sOrder. $sLimit;
	return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个sys_province对象
     * @param int $id 
     * @return sys_province对象
     */
    public function getModelByID($id)
    {
	$objProvinceInfo = null;
	$arrayInfo = $this->select("*", "province_id=" . $id, "");

	if (isset($arrayInfo) && count($arrayInfo) > 0)
	{
	    $objProvinceInfo = new ProvinceInfo();
	    $objProvinceInfo->iProvinceId = $arrayInfo[0]['province_id'];
	    $objProvinceInfo->strProvinceNo = $arrayInfo[0]['province_no'];
	    $objProvinceInfo->strProvinceName = $arrayInfo[0]['province_name'];
	    $objProvinceInfo->strProvincePlace = $arrayInfo[0]['province_place'];
	    $objProvinceInfo->strShortName = $arrayInfo[0]['short_name'];
	    $objProvinceInfo->iSortIndex = $arrayInfo[0]['sort_index'];

	    settype($objProvinceInfo->iProvinceId, "integer");




	    settype($objProvinceInfo->iSortIndex, "integer");
	}

	return $objProvinceInfo;
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
    public function selectPaged($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
	$offset = ($iPageIndex - 1) * $iPageSize;
	$sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `sys_province` WHERE $strWhere";
	$iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);

	$sqlData = "SELECT $strPageFields FROM `sys_province` WHERE $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
	return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

}

?>