<?php

/**
 * Copyright (C) 2013 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表 am_agent_share 的类业务逻辑层
 * 表描述： 
 * 创建人：邱玉虹
 * 添加时间：2013-01-10 19:08:52
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgentShareInfo.php';

class AgentShareBLL extends BLLBase {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param $objAgentShareInfo  AgentShareInfo 实例
     * @return 
     */
    public function insert(AgentShareInfo $objAgentShareInfo) {
        $sql = "INSERT INTO `am_agent_share`(`agent_id`,`share_uid`,`share_time`,`old_owner`,`new_owner`,`is_del`,`remark`,`create_uid`,`create_time`) 
        values(" . $objAgentShareInfo->iAgentId . "," . $objAgentShareInfo->iShareUid . ",'" . $objAgentShareInfo->strShareTime . "'," . $objAgentShareInfo->iOldOwner . "," . $objAgentShareInfo->iNewOwner . "," . $objAgentShareInfo->iIsDel . ",'" . $objAgentShareInfo->strRemark . "'," . $objAgentShareInfo->iCreateUid . ",now())";
        if ($this->objMysqlDB->executeNonQuery(false, $sql, null) > 0)
            return $this->objMysqlDB->lastInsertId();
        else
            return 0;
    }

    /**
     * @functional 根据ID更新一条记录
     * @param $objAgentShareInfo  AgentShareInfo 实例
     * @return
     */
    public function updateByID(AgentShareInfo $objAgentShareInfo) {
        $sql = "update `am_agent_share` set `agent_id`=" . $objAgentShareInfo->iAgentId . ",`share_uid`=" . $objAgentShareInfo->iShareUid . ",`share_time`='" . $objAgentShareInfo->strShareTime . "',`old_owner`=" . $objAgentShareInfo->iOldOwner . ",`new_owner`=" . $objAgentShareInfo->iNewOwner . ",`is_del`=" . $objAgentShareInfo->iIsDel . ",`remark`='" . $objAgentShareInfo->strRemark . "', where id=" . $objAgentShareInfo->iId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }

    /**
     * @functional 根据ID更新一条记录
     * @param int $id 记录ID
     * @param int $userID 当前操作用户ID
     * @return 
     */
    public function deleteByID($id, $userID) {
        $sql = "update `am_agent_share` set is_del=1,update_uid=" . $userID . ",update_time=now() where id=" . $id;
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
            $sField = T_AgentShare::AllFields;

        if ($sWhere != "")
            $sWhere = " where is_del=0 and " . $sWhere;
        else
            $sWhere = " where is_del=0";

        if ($sOrder != "")
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `am_agent_share` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个 AgentShareInfo 对象
     * @param int $id 
     * @return AgentShareInfo 对象
     */
    public function getModelByID($id) {
        $objAgentShareInfo = null;
        $arrayInfo = $this->select("*", "id=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0) {
            $objAgentShareInfo = new AgentShareInfo();


            $objAgentShareInfo->iId = $arrayInfo[0]['id'];
            $objAgentShareInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentShareInfo->iShareUid = $arrayInfo[0]['share_uid'];
            $objAgentShareInfo->strShareTime = $arrayInfo[0]['share_time'];
            $objAgentShareInfo->iOldOwner = $arrayInfo[0]['old_owner'];
            $objAgentShareInfo->iNewOwner = $arrayInfo[0]['new_owner'];
            $objAgentShareInfo->iIsDel = $arrayInfo[0]['is_del'];
            $objAgentShareInfo->strRemark = $arrayInfo[0]['remark'];
            $objAgentShareInfo->iCreateUid = $arrayInfo[0]['create_uid'];
            $objAgentShareInfo->strCreateTime = $arrayInfo[0]['create_time'];
            settype($objAgentShareInfo->iId, "integer");
            settype($objAgentShareInfo->iAgentId, "integer");
            settype($objAgentShareInfo->iShareUid, "integer");
            settype($objAgentShareInfo->iOldOwner, "integer");
            settype($objAgentShareInfo->iNewOwner, "integer");
            settype($objAgentShareInfo->iIsDel, "integer");
            settype($objAgentShareInfo->iCreateUid, "integer");
        }
        return $objAgentShareInfo;
    }
    //取消共享
    public function cancelShare($agent_id,$share_id,$userID)
    {
        $sql = "update `am_agent_share` set is_del=1 where agent_id=" . $agent_id ." and share_uid =".$share_id;
        $rtn =$this->objMysqlDB->executeNonQuery(false, $sql, null);
        
        $sqlData = "update `am_agent_source` set is_share=0 where agent_id=" . $agent_id ;
        $rt = $this->objMysqlDB->executeNonQuery(false, $sqlData, null);
        
        return $rtn;      
    }
        
    public function getShareUserData($agent_id)
    {
        $sql = "SELECT sys_user.user_id,sys_user.user_name,sys_user.e_name FROM am_agent_share 
            INNER JOIN sys_user ON sys_user.user_id = am_agent_share.share_uid where 
            am_agent_share.is_del =0 and am_agent_share.agent_id=$agent_id order by am_agent_share.id desc";
            
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
}

