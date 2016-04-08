<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表am_agentcheck_log的类业务逻辑层
 * 表描述：代理商资料审核表
 * 创建人：刘君臣
 * 添加时间：2011/8/24 8:22:14
 * 修改人：      修改时间：
 * 修改描述：
 * */
require_once __DIR__ . '/../Common/BLLBase.php';
require_once __DIR__ . '/../Model/AgentcheckLogInfo.php';

class AgentcheckLogBLL extends BLLBase
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @functional 新增一条记录
     * @param AgentcheckLogInfo $objAgentcheckLogInfo  AgentcheckLog实例
     * @return 
     */
    public function insert(AgentcheckLogInfo $objAgentcheckLogInfo)
    {
        $sql = "INSERT INTO `am_agentcheck_log`(`agent_id`,`check_type`,`check_status`,`check_uid`,`check_time`,`check_remark`)"
                . " values(" . $objAgentcheckLogInfo->iAgentId . "," . $objAgentcheckLogInfo->iCheckType . "," . $objAgentcheckLogInfo->iCheckStatus . "," . $objAgentcheckLogInfo->iCheckUid . ",'" . $objAgentcheckLogInfo->strCheckTime . "','" . $objAgentcheckLogInfo->strCheckRemark . "')";
        $this->objMysqlDB->executeNonQuery(false, $sql, null);
        return $this->objMysqlDB->lastInsertId();
    }

    /**
     * @functional 根据ID更新一条记录
     * @param AgentcheckLogInfo $objAgentcheckLogInfo  AgentcheckLog实例
     * @return
     */
    public function updateByID(AgentcheckLogInfo $objAgentcheckLogInfo)
    {
        $sql = "update `am_agentcheck_log` set `check_type`=" . $objAgentcheckLogInfo->iCheckType . ",`check_status`=" . $objAgentcheckLogInfo->iCheckStatus . ",`check_uid`=" . $objAgentcheckLogInfo->iCheckUid . ",`check_time`='" . $objAgentcheckLogInfo->strCheckTime . "',`check_remark`='" . $objAgentcheckLogInfo->strCheckRemark . "' where `agent_id`=" . $objAgentcheckLogInfo->iAgentId;
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
            $sField = T_AgentcheckLog::AllFields;
        if ($sWhere != "")
            $sWhere = " where " . $sWhere;

        if ($sOrder != "")
            $sOrder = " order by " . $sOrder;

        if ($sGroup != "")
            $sGroup = " group by " . $sGroup;

        $sLimit = "";
        if (is_int($iRecordCount) && $iRecordCount > 0)
            $sLimit = " limit 0," . $iRecordCount;

        $sql = "SELECT " . $sField . " FROM `am_agentcheck_log` " . $sWhere . $sGroup . $sOrder . $sLimit;
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }

    /**
     * @functional 根据ID,返回一个am_agentcheck_log对象
     * @param int $id 
     * @return am_agentcheck_log对象
     */
    public function getModelByID($id)
    {
        $objAgentcheckLogInfo = null;
        $arrayInfo = $this->select("*", "aid=" . $id, "");

        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            $objAgentcheckLogInfo = new AgentcheckLogInfo();
            $objAgentcheckLogInfo->iAid = $arrayInfo[0]['aid'];
            $objAgentcheckLogInfo->iAgentId = $arrayInfo[0]['agent_id'];
            $objAgentcheckLogInfo->iCheckType = $arrayInfo[0]['check_type'];
            $objAgentcheckLogInfo->iCheckStatus = $arrayInfo[0]['check_status'];
            $objAgentcheckLogInfo->iCheckUid = $arrayInfo[0]['check_uid'];
            $objAgentcheckLogInfo->strCheckTime = $arrayInfo[0]['check_time'];
            $objAgentcheckLogInfo->strCheckRemark = $arrayInfo[0]['check_remark'];

            settype($objAgentcheckLogInfo->iAid, "integer");
            settype($objAgentcheckLogInfo->iAgentId, "integer");
            settype($objAgentcheckLogInfo->iCheckType, "integer");
            settype($objAgentcheckLogInfo->iCheckStatus, "integer");
            settype($objAgentcheckLogInfo->iCheckUid, "integer");
        }

        return $objAgentcheckLogInfo;
    }

    /**
     * @functional 检查审核库中是否存在某个代理商
     * @author liujunchen
     */
    public function selectExistsAgent($agentId)
    {
        $sql = "SELECT COUNT(agent_id) as agent_id_count FROM am_agentcheck_log WHERE agent_id = " . $agentId . " and check_status = 0";
        $arrayInfo = $this->objMysqlDB->fetchAllAssoc(false, $sql, null);

        if (isset($arrayInfo) && count($arrayInfo) > 0)
        {
            return $arrayInfo[0]["agent_id_count"];
        }
        return 0;
    }
    
    /**
     * @functional 检查代理商是否在审核流程中并返回代理商名称
     * @aurhor liujunchen
    */
    public function selectExistsAgentName($agentId)
    {
        $sql = "SELECT B.agent_name FROM am_agentcheck_log A, am_agent_source B WHERE A.agent_id = B.agent_id AND A.check_status=0 AND A.agent_id = ".$agentId." limit 0,1";
        return $this->objMysqlDB->fetchAssoc(false,$sql,null);
    }
    
    /**
     * @functional 代理商审核之后相应更新审核库中状态
     * @author liujunchen
    */
    public function UpdateCheckStatus($aid,$agentId,$status,$checkUid,$remark)
    {
        $sql = "UPDATE am_agentcheck_log SET check_status = ".$status." ,check_remark = '".$remark."' ,check_uid = ".$checkUid." ,check_time = NOW() WHERE aid = ".$aid." AND agent_id = ".$agentId;
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    /**
     * @functional 查询没有被审核的代理商信息个数
     * @author liujunchen
     */
    public function UnCheckCount()
    {
        $sql = "SELECT COUNT(1) FROM `am_agentcheck_log` WHERE `check_status` = 0";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
    
    /**
     * @functional 查询出资料库中新增审核 修改审核 删除审核的数量
     * @author
     */
    public function getCheckNum()
    {
        $sql = "SELECT SUM(addNum) AS addNum,SUM(editNum) AS editNum,SUM(delNum) AS delNum FROM
                (
                SELECT CASE WHEN A.check_type = 0 THEN 1 ELSE 0 END AS 'addNum',
                CASE WHEN A.check_type = 1 THEN 1 ELSE 0 END AS 'editNum',
                CASE WHEN A.check_type = 2 THEN 1 ELSE 0 END AS 'delNum'
                FROM am_agentcheck_log AS A WHERE A.check_status = 0
                ) tb";
        return $this->objMysqlDB->fetchAssoc(false, $sql, null);
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
        if ($strWhere != "")
            $strWhere = " where " . $strWhere;

        if ($strOrder != "")
            $strOrder = " ORDER BY " . $strOrder;

        $sqlCount = "SELECT  COUNT(1) AS `recordCount` FROM `am_agentcheck_log` $strWhere";
        $iRecordCount = $this->objMysqlDB->executeAndReturn(false, $sqlCount, null);

        $sqlData = "SELECT $strPageFields FROM `am_agentcheck_log` $strWhere $strOrder LIMIT $offset,$iPageSize";
        return $this->objMysqlDB->fetchAllAssoc(false, $sqlData, null);
    }

    public function getAutoComplete($name)
    {
        $sql = "select sys_user.user_id,CONCAT(sys_user.user_name,'(',sys_user.e_name,')') as `name` from sys_user
        LEFT JOIN `hr_employee`  ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
         where (sys_user.e_name like '%$name%' or sys_user.user_name like '%$name%') and sys_user.is_lock=0 and sys_user.is_del=0 and sys_user.agent_id =0 and sys_user.e_uid>0 AND `hr_employee`.is_del=0";
        //$sql = "SELECT
//                   `sys_user`.`user_id` as id,
//                   CONCAT(`sys_user`.user_name,'(',`sys_user`.e_name,')') as `name`
//                FROM `sys_user` INNER JOIN `hr_employee`  ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
//                                left JOIN `hr_dept_position` ON `hr_employee`.`dept_position_id` =`hr_dept_position`.`dept_position_id` 
//                                left JOIN `hr_department` ON `hr_dept_position`.`hr_dept_id` =`hr_department`.`dept_id` 
//                where `hr_department`.`dept_no` like '1014%' and `sys_user`.`is_del`=0
//                  ";
        
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getAutoCompleteById($name,$accountNo)
    {
        $strWhere = " AND sys_account_group.account_no not like '$accountNo%' ";
        if($accountNo==11)
        {
            $strWhere .=" AND sys_account_group.account_no not like '12%'";
        }
        
        $sql = "SELECT DISTINCT sys_user.user_id, CONCAT( sys_user.user_name, '(', sys_user.e_name, ')' )AS `name` FROM sys_user
        Inner JOIN `hr_employee` ON `sys_user`.`e_uid` = `hr_employee`.`e_id` 
        Inner JOIN sys_account_group_user ON sys_account_group_user.user_id =sys_user.user_id 
        Inner JOIN sys_account_group ON sys_account_group.account_group_id =sys_account_group_user.account_group_id 
        WHERE 
        sys_user.e_uid > 0 AND sys_user.is_lock = 0 
        AND sys_user.is_del = 0 AND sys_user.agent_id = 0 
        AND `hr_employee`.is_del = 0 AND ( sys_user.e_name LIKE '%$name%' OR sys_user.user_name LIKE '%$name%' ) 
        ".$strWhere;
        //$sql = "SELECT
//                   `sys_user`.`user_id` as id,
//                   CONCAT(`sys_user`.user_name,'(',`sys_user`.e_name,')') as `name`
//                FROM `sys_user` INNER JOIN `hr_employee`  ON `sys_user`.`e_uid` = `hr_employee`.`e_id`
//                                left JOIN `hr_dept_position` ON `hr_employee`.`dept_position_id` =`hr_dept_position`.`dept_position_id` 
//                                left JOIN `hr_department` ON `hr_dept_position`.`hr_dept_id` =`hr_department`.`dept_id` 
//                where `hr_department`.`dept_no` like '1014%' and `sys_user`.`is_del`=0
//                  ";
        return $this->objMysqlDB->fetchAllAssoc(false, $sql, null);
    }
    public function getUserIDByName($name)
    {
        $sql = "select user_id from sys_user where user_name='$name'";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }

    public function setCheckUid($aid, $uid)
    {
        $sql = "update am_agentcheck_log set check_uid=$uid where aid in ($aid)";
        return $this->objMysqlDB->executeNonQuery(false, $sql, null);
    }
    
    public function getCheckInfoByAgentId($agentId)
    {
        $sql = "select COUNT(1) from am_agentcheck_log where agent_id={$agentId} and check_type=0";
        return $this->objMysqlDB->executeAndReturn(false, $sql, null);
    }
}
?>