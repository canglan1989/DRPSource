<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表am_agent_permit的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011/7/15 14:10:21
 * 修改人：修改时间：
 * 修改描述：
 * */

/**
 * am_agent_permit表名及字段名
 */
class T_AgentPermit
{
    /**
     * 表名
     */
    const Name = "am_agent_permit";
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
    const permit_name = "permit_name";
    /**
     * 
     */
    const permit_type = "permit_type";
    /**
     * 
     */
    const file_path = "file_path";
    /**
     * 
     */
    const file_ext = "file_ext";
    /**
     * 
     */
    const update_uid = "update_uid";
    /**
     * 
     */
    const update_time = "update_time";
    /**
     * 
     */
    const create_uid = "create_uid";
    /**
     * 
     */
    const create_time = "create_time";

    /**
     * 所有字段
     */
    const AllFields = "`aid`,`agent_id`,`permit_name`,`permit_type`,`file_path`,`file_ext`,`update_uid`,`update_time`,`create_uid`,`create_time`";
}

/**
 * am_agent_permit数据实体
 */
class AgentPermitInfo
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
    public $strPermitName = '';
    /**
     *
     */
    public $iPermitType = 0;
    /**
     *
     */
    public $strFilePath = '';
    /**
     *
     */
    public $strFileExt = '';
    /**
     *
     */
    public $iUpdateUid = 0;
    /**
     *
     */
    public $strUpdateTime = '';
    /**
     *
     */
    public $iCreateUid = 0;
    /**
     *
     */
    public $strCreateTime = '';
}

?>
