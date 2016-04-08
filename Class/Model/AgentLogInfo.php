<?php
/**
 * @fnuctional: 表am_agent_log的业务逻辑
 * @copyright:  盘石
 * @author:     liujunchen junchen168@live.cn
 * @date:       2011-07-15
 */

/**
 * am_agent_log表名及字段名
 */
class T_AgentLog
{
	/**
	* 表名
	*/
	const Name = "am_agent_log";
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
	const old_values = "old_values";
	/**
	* 
	*/
	const new_values = "new_values";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const create_time = "create_time";
	/**
         * 
         */
        const check_id = 'check_id';
        
	/**
	* 所有字段
	*/
	const AllFields = "`aid`,`agent_id`,`old_values`,`new_values`,`create_uid`,`create_time`,`check_id`";
}

/**
 * am_agent_log数据实体
 */
class AgentLogInfo
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
	public $strOldValues = '';
	/**
	*
	*/
	public $strNewValues = '';
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strCreateTime = '';
        /**
         * 对应审核信息的ID
         */
        public $iCheckId = 0;
}