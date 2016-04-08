<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表am_agentcheck_log的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011/8/24 8:24:01
 * 修改人：修改时间：
 * 修改描述：
 * */

/**
 * am_agentcheck_log表名及字段名
 */
class T_AgentcheckLog
{
    /**
     * 表名
     */
    const Name = "am_agentcheck_log";
    /**
     * 
     */
    const aid = "aid";
    /**
     * 
     */
    const agent_id = "agent_id";
    /**
     * 
     */
    const check_type = "check_type";
    /**
     * 
     */
    const check_status = "check_status";
    /**
     * 
     */
    const check_uid = "check_uid";
    /**
     * 
     */
    const check_time = "check_time";
    /**
     * 
     */
    const check_remark = "check_remark";

    /**
     * 所有字段
     */
    const AllFields = "`aid`,`agent_id`,`check_type`,`check_status`,`check_uid`,`check_time`,`check_remark`";
}

/**
 * am_agentcheck_log数据实体
 */
class AgentcheckLogInfo
{

    /**
     *
     */
    public $iAid = 0;

    /**
     *
     */
    public $iAgentId = 0;

    /**
     *
     */
    public $iCheckType = 0;

    /**
     *
     */
    public $iCheckStatus = 0;

    /**
     *
     */
    public $iCheckUid = 0;

    /**
     *
     */
    public $strCheckTime = '';

    /**
     *
     */
    public $strCheckRemark = '';

}

?>
