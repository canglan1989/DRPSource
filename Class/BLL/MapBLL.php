<?php

/**
 * Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 agent_map 的类业务逻辑层
 * 表描述：
 * 创建人：许亮
 * 添加时间：2012-03-23 14:24:28
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/MapInfo.php';

class MapBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objMapInfo  MapInfo 实例
     * @return 
     */
    public function insert(MapInfo $objMapInfo)
    {
        $sql = "INSERT INTO `agent_map`(agent_name,area,product_name,deadline,ensure_money,deposits,sign_name,status,visit_rate,visit_num,real_visit,adhai_online_num,signed_customer,new_customer,follow_customer,coordinate,group_center_coordinate,group_name,group_coordinate) 
        values('" . $objMapInfo->strAgentName . "','" . $objMapInfo->strArea . "','" . $objMapInfo->strProductName . "','" . $objMapInfo->strDeadline . "'," . $objMapInfo->iEnsureMoney . "," . $objMapInfo->iDeposits . ",'" . $objMapInfo->strSignName . "','" . $objMapInfo->strStatus . "','" . $objMapInfo->strVisitRate . "'," . $objMapInfo->iVisitNum . "," . $objMapInfo->iRealVisit . "," . $objMapInfo->iAdhaiOnlineNum . ",'" . $objMapInfo->strSignedCustomer . "','" . $objMapInfo->strNewCustomer . "','" . $objMapInfo->strFollowCustomer . "','" . $objMapInfo->strCoordinate . "','" . $objMapInfo->strGroupCenterCoordinate . "','" . $objMapInfo->strGroupName . "','" . $objMapInfo->strGroupCoordinate . "')";
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

    /**
     * @functional 根据ID更新一条记录
     * @param $objMapInfo  MapInfo 实例
     * @return
     */
    public function updateByID(MapInfo $objMapInfo)
    {
        $sql = "update `agent_map` set `agent_name`='" . $objMapInfo->strAgentName . "',`area`='" . $objMapInfo->strArea . "',`product_name`='" . $objMapInfo->strProductName . "',`deadline`='" . $objMapInfo->strDeadline . "',`ensure_money`=" . $objMapInfo->iEnsureMoney . ",`deposits`=" . $objMapInfo->iDeposits . ",`sign_name`='" . $objMapInfo->strSignName . "',`status`='" . $objMapInfo->strStatus . "',`visit_rate`='" . $objMapInfo->strVisitRate . "',`visit_num`=" . $objMapInfo->iVisitNum . ",`real_visit`=" . $objMapInfo->iRealVisit . ",`adhai_online_num`=" . $objMapInfo->iAdhaiOnlineNum . ",`signed_customer`='" . $objMapInfo->strSignedCustomer . "',`new_customer`='" . $objMapInfo->strNewCustomer . "',`follow_customer`='" . $objMapInfo->strFollowCustomer . "',`coordinate`='" . $objMapInfo->strCoordinate . "',`group_center_coordinate`='" . $objMapInfo->strGroupCenterCoordinate . "',`group_name`='" . $objMapInfo->strGroupName . "',`group_coordinate`='" . $objMapInfo->strGroupCoordinate . "' where id=" . $objMapInfo->iId;
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
            $sField = T_Map::AllFields;

        if ($sWhere != "")
            $sWhere = " where " . $sWhere;

        if ($sOrder != "")
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `agent_map` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个 MapInfo 对象
     * @param int $id 
     * @return MapInfo 对象
     */
    public function getModelByID($id)
    {
        $objMapInfo = null;
        $arrayInfo = $this->select("*", "id=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $objMapInfo = new MapInfo();


            $objMapInfo->iId = $arrayInfo[0]['id'];
            $objMapInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objMapInfo->strArea = $arrayInfo[0]['area'];
            $objMapInfo->strProductName = $arrayInfo[0]['product_name'];
            $objMapInfo->strDeadline = $arrayInfo[0]['deadline'];
            $objMapInfo->iEnsureMoney = $arrayInfo[0]['ensure_money'];
            $objMapInfo->iDeposits = $arrayInfo[0]['deposits'];
            $objMapInfo->strSignName = $arrayInfo[0]['sign_name'];
            $objMapInfo->strStatus = $arrayInfo[0]['status'];
            $objMapInfo->strVisitRate = $arrayInfo[0]['visit_rate'];
            $objMapInfo->iVisitNum = $arrayInfo[0]['visit_num'];
            $objMapInfo->iRealVisit = $arrayInfo[0]['real_visit'];
            $objMapInfo->iAdhaiOnlineNum = $arrayInfo[0]['adhai_online_num'];
            $objMapInfo->strSignedCustomer = $arrayInfo[0]['signed_customer'];
            $objMapInfo->strNewCustomer = $arrayInfo[0]['new_customer'];
            $objMapInfo->strFollowCustomer = $arrayInfo[0]['follow_customer'];
            $objMapInfo->strCoordinate = $arrayInfo[0]['coordinate'];
            $objMapInfo->strGroupCenterCoordinate = $arrayInfo[0]['group_center_coordinate'];
            $objMapInfo->strGroupName = $arrayInfo[0]['group_name'];
            $objMapInfo->strGroupCoordinate = $arrayInfo[0]['group_coordinate'];
            settype($objMapInfo->iId, "integer");
            settype($objMapInfo->iEnsureMoney, "integer");
            settype($objMapInfo->iDeposits, "integer");
            settype($objMapInfo->iVisitNum, "integer");
            settype($objMapInfo->iRealVisit, "integer");
            settype($objMapInfo->iAdhaiOnlineNum, "integer");
        }
        return $objMapInfo;
    }

    public function delete($id)
    {
        $sql = "delete from agent_map where id={$id}";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    public function selectAllData($pageIndex, $pageSize, &$pageCount)
    {
        $sql = "select * from agent_map";
        $rst = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
        $pageCount = ceil(count($rst) / $pageSize);

        $sql = "select * from agent_map limit $pageIndex,$pageSize";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    public function selectAllArea()
    {
        $sql = "select id,agent_name,coordinate,group_center_coordinate,group_coordinate,group_name from agent_map";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

}

