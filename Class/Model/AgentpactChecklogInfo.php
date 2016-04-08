<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表am_agentpact_checklog的类模型
 * 表描述：
 * 创建人: liujunchen
 * 添加时间：2011-8-30 11:09:11
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * am_agentpact_checklog表名及字段名
 */
class T_AgentpactChecklog
{
	/**
	* 表名
	*/
	const Name = "am_agentpact_checklog";
	/**
	* 
	*/
	const aid = "aid";
	/**
	* 
	*/
	const pact_id = "pact_id";
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
	const AllFields = "`aid`,`pact_id`,`agent_id`,`check_type`,`check_status`,`check_uid`,`check_time`,`check_remark`";
}

/**
 * am_agentpact_checklog数据实体
 */
class AgentpactChecklogInfo
{
	/**
	*
	*/
	public $iAid = 0;
	/**
	*
	*/
	public $iPactId = 0;
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
