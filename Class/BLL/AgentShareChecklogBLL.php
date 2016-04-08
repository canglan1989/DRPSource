<?php

/**
 * Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_agent_share_checklog 的类业务逻辑层
 * 表描述： 
 * 创建人：邱玉虹
 * 添加时间：2013-01-10 19:08:55
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgentShareChecklogInfo.php';

class AgentShareChecklogBLL extends BLLBase {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objAgentShareChecklogInfo  AgentShareChecklogInfo 实例
     * @return 
     */
    public function insert(AgentShareChecklogInfo $objAgentShareChecklogInfo) {
        $sql = "INSERT INTO `am_agent_share_checklog`(`agent_id`,`agent_name`,`old_owner`,`share_person`,`new_owner`,`share_remark`,`share_create_id`,`share_create_time`,`check_status`,`check_remark`,`check_uid`,`check_time`) 
        values(" . $objAgentShareChecklogInfo->iAgentId . ",'" . $objAgentShareChecklogInfo->strAgentName . "'," . $objAgentShareChecklogInfo->iOldOwner . "," . $objAgentShareChecklogInfo->iSharePerson . "," . $objAgentShareChecklogInfo->iNewOwner . ",'" . $objAgentShareChecklogInfo->strShareRemark . "'," . $objAgentShareChecklogInfo->iShareCreateId . ",'" . $objAgentShareChecklogInfo->strShareCreateTime . "'," . $objAgentShareChecklogInfo->iCheckStatus . ",'" . $objAgentShareChecklogInfo->strCheckRemark . "'," . $objAgentShareChecklogInfo->iCheckUid . ",'" . $objAgentShareChecklogInfo->strCheckTime . "')";
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

    /**
     * @functional 根据ID更新一条记录
     * @param $objAgentShareChecklogInfo  AgentShareChecklogInfo 实例
     * @return
     */
    public function updateByID(AgentShareChecklogInfo $objAgentShareChecklogInfo) {
        $sql = "update `am_agent_share_checklog` set `agent_id`=" . $objAgentShareChecklogInfo->iAgentId . ",`agent_name`='" . $objAgentShareChecklogInfo->strAgentName . "',`old_owner`=" . $objAgentShareChecklogInfo->iOldOwner . ",`share_person`=" . $objAgentShareChecklogInfo->iSharePerson . ",`new_owner`=" . $objAgentShareChecklogInfo->iNewOwner . ",`share_remark`='" . $objAgentShareChecklogInfo->strShareRemark . "',`share_create_id`=" . $objAgentShareChecklogInfo->iShareCreateId . ",`share_create_time`='" . $objAgentShareChecklogInfo->strShareCreateTime . "',`check_status`=" . $objAgentShareChecklogInfo->iCheckStatus . ",`check_remark`='" . $objAgentShareChecklogInfo->strCheckRemark . "',`check_uid`=" . $objAgentShareChecklogInfo->iCheckUid . ",`check_time`='" . $objAgentShareChecklogInfo->strCheckTime . "' where id=" . $objAgentShareChecklogInfo->iId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 返回数据
     * @param string $sField 字段
     * @param string $sWhere 不用加 where	
     * @param string $sOrder 无order  by 关键字的排序语句
     * @return 
     */
    public function select($sField, $sWhere, $sOrder = "") {
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
    public function selectTop($sField, $sWhere, $sOrder, $sGroup, $iRecordCount) {
        if ($sField == "*" || $sField == "")
            $sField = T_AgentShareChecklog::AllFields;

        if ($sWhere != "")
            $sWhere = " where " . $sWhere;

        if ($sOrder != "")
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `am_agent_share_checklog` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个 AgentShareChecklogInfo 对象
     * @param int $id 
     * @return AgentShareChecklogInfo 对象
     */
    public function getModelByID($id) {
        $objAgentShareChecklogInfo = null;
        $arrayInfo = $this->select("*", "id=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0) {
            $objAgentShareChecklogInfo = new AgentShareChecklogInfo();


            $objAgentShareChecklogInfo->iId = $arrayInfo[0]['id'];
            $objAgentShareChecklogInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentShareChecklogInfo->strAgentName = $arrayInfo[0]['agent_name'];
            $objAgentShareChecklogInfo->iOldOwner = $arrayInfo[0]['old_owner'];
            $objAgentShareChecklogInfo->iSharePerson = $arrayInfo[0]['share_person'];
            $objAgentShareChecklogInfo->iNewOwner = $arrayInfo[0]['new_owner'];
            $objAgentShareChecklogInfo->strShareRemark = $arrayInfo[0]['share_remark'];
            $objAgentShareChecklogInfo->iShareCreateId = $arrayInfo[0]['share_create_id'];
            $objAgentShareChecklogInfo->strShareCreateTime = $arrayInfo[0]['share_create_time'];
            $objAgentShareChecklogInfo->iCheckStatus = $arrayInfo[0]['check_status'];
            $objAgentShareChecklogInfo->strCheckRemark = $arrayInfo[0]['check_remark'];
            $objAgentShareChecklogInfo->iCheckUid = $arrayInfo[0]['check_uid'];
            $objAgentShareChecklogInfo->strCheckTime = $arrayInfo[0]['check_time'];
            settype($objAgentShareChecklogInfo->iId, "integer");
            settype($objAgentShareChecklogInfo->iAgentId, "integer");
            settype($objAgentShareChecklogInfo->iOldOwner, "integer");
            settype($objAgentShareChecklogInfo->iSharePerson, "integer");
            settype($objAgentShareChecklogInfo->iNewOwner, "integer");
            settype($objAgentShareChecklogInfo->iShareCreateId, "integer");
            settype($objAgentShareChecklogInfo->iCheckStatus, "integer");
            settype($objAgentShareChecklogInfo->iCheckUid, "integer");
        }
        return $objAgentShareChecklogInfo;
    }
    
    public function selectCheckList($iPageIndex, $iPageSize, $strPageFields, $strWhere, $strOrder, &$iRecordCount)
    {
        $offset = ($iPageIndex - 1) * $iPageSize;

        if ($strOrder == "")
            $strOrder = "am.id desc ";

        $sqlCount = "SELECT COUNT(1)
                    from am_agent_share_checklog as am
                    LEFT JOIN sys_user as a ON am.old_owner =a.user_id
                    LEFT JOIN sys_user as b ON am.new_owner =b.user_id
                    LEFT JOIN sys_user as c ON am.share_person = c.user_id
                    LEFT JOIN sys_user as d ON am.share_create_id = d.user_id where 1=1 " . $strWhere;
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);

        $sqlData = "SELECT
                    am.id,
                    am.agent_id,
                    am.agent_name,
                    am.old_owner,
                    am.share_person,
                    am.new_owner,
                    am.share_remark,
                    am.share_create_id,
                    am.share_create_time,
                    CASE am.check_status WHEN 0 THEN '未审核' WHEN 1 THEN '通过' WHEN 2 THEN '不通过' END as check_status,
                    CONCAT(a.user_name,a.e_name)  as oldOwnerName,
                    CONCAT(b.user_name,b.e_name) as newOwnerName,
                    CONCAT(c.user_name,c.e_name) as sharePerson,
                    CONCAT(d.user_name,d.e_name) as shareCreate
                    from am_agent_share_checklog as am
                    LEFT JOIN sys_user as a ON am.old_owner =a.user_id
                    LEFT JOIN sys_user as b ON am.new_owner =b.user_id
                    LEFT JOIN sys_user as c ON am.share_person = c.user_id
                    LEFT JOIN sys_user as d ON am.share_create_id = d.user_id where 1=1 $strWhere ORDER BY $strOrder LIMIT $offset,$iPageSize";
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }
    public function  getCheckInfoByID($checkId)
    {
        $sql ="SELECT check_status,check_remark,check_time,sys.e_name,sys.user_name  FROM am_agent_share_checklog as am 
               LEFT JOIN sys_user as sys ON sys.user_id =am.check_uid where am.id={$checkId} ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

}

