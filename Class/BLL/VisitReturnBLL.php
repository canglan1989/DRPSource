<?php

/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_visit_return 的类业务逻辑层
 * 表描述：
 * 创建人：许亮
 * 添加时间：2012-03-06 18:12:46
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/VisitReturnInfo.php';

class VisitReturnBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objVisitReturnInfo  VisitReturnInfo 实例
     * @return 
     */
    public function insert(VisitReturnInfo $objVisitReturnInfo)
    {
        $sql = "INSERT INTO `am_visit_return`(visitNoteID,content,return_time,add_time,add_user_id) 
        values(" . $objVisitReturnInfo->iVisitnoteid . ",'" . $objVisitReturnInfo->strContent . "','" . $objVisitReturnInfo->strReturnTime . "'," . $objVisitReturnInfo->strAddTime . "," . $objVisitReturnInfo->iAddUserId . ")";
        
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

    /**
     * @functional 根据ID更新一条记录
     * @param $objVisitReturnInfo  VisitReturnInfo 实例
     * @return
     */
    public function updateByID(VisitReturnInfo $objVisitReturnInfo)
    {
        $sql = "update `am_visit_return` set `visitNoteID`=" . $objVisitReturnInfo->iVisitnoteid . ",`content`='" . $objVisitReturnInfo->strContent . "',`return_time`='" . $objVisitReturnInfo->strReturnTime . "',`add_time`='" . $objVisitReturnInfo->strAddTime . "',`add_user_id`=" . $objVisitReturnInfo->iAddUserId . " where id=" . $objVisitReturnInfo->iId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
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
            $sField = T_VisitReturn::AllFields;

        if ($sWhere != "")
            $sWhere = " where " . $sWhere;

        if ($sOrder != "")
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `am_visit_return` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个 VisitReturnInfo 对象
     * @param int $id 
     * @return VisitReturnInfo 对象
     */
    public function getModelByID($id)
    {
        $objVisitReturnInfo = null;
        $arrayInfo = $this->select("*", "id=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $objVisitReturnInfo = new VisitReturnInfo();


            $objVisitReturnInfo->iId = $arrayInfo[0]['id'];
            $objVisitReturnInfo->iVisitnoteid = $arrayInfo[0]['visitNoteID'];
            $objVisitReturnInfo->strContent = $arrayInfo[0]['content'];
            $objVisitReturnInfo->strReturnTime = $arrayInfo[0]['return_time'];
            $objVisitReturnInfo->strAddTime = $arrayInfo[0]['add_time'];
            $objVisitReturnInfo->iAddUserId = $arrayInfo[0]['add_user_id'];
            settype($objVisitReturnInfo->iId, "integer");
            settype($objVisitReturnInfo->iVisitnoteid, "integer");
            settype($objVisitReturnInfo->iAddUserId, "integer");
        }
        return $objVisitReturnInfo;
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

        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `am_visit_return` WHERE 1=1 $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);
        if ($strOrder == "")
            $strOrder = " `am_visit_return`.`id` desc ";
        $sqlData = "SELECT am_visit_return.*,sys_user.e_name 
        FROM am_visit_return 
        left join sys_user on am_visit_return.add_user_id=sys_user.user_id
        where 1=1 $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }
    
    public function getLastReturn($visitNoteID){
        $sql = "select content,return_time from am_visit_return where visitNoteID = {$visitNoteID} ORDER BY add_time desc limit 1";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    

}

