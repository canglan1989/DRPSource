<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表fm_agent_bank的类模型
 * 表描述：
 * 创建人：wdd
 * 添加时间：2011-8-20 11:45:40
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * fm_agent_bank表名及字段名
 */
class T_AgentBank
{
	/**
	* 表名
	*/
	const Name = "fm_agent_bank";
	/**
	* 
	*/
	const agent_bank_id = "agent_bank_id";
	/**
	* 
	*/
	const agent_id = "agent_id";
	/**
	* 
	*/
	const bank_name = "bank_name";
	/**
	* 
	*/
	const account_name = "account_name";
	/**
	* 
	*/
	const account_no = "account_no";
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
	* 
	*/
	const is_del = "is_del";
	
	/**
	* 所有字段
	*/
	const AllFields = "`agent_bank_id`,`agent_id`,`bank_name`,`account_name`,`account_no`,`update_uid`,`update_time`,`create_uid`,`create_time`,`is_del`";
}

/**
 * fm_agent_bank数据实体
 */
class AgentBankInfo
{
	/**
	*
	*/
	public $iAgentBankId = 0;
	/**
	*
	*/
	public $iAgentId = 0;
	/**
	*
	*/
	public $strBankName = '';
	/**
	*
	*/
	public $strAccountName = '';
	/**
	*
	*/
	public $strAccountNo = '';
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
	/**
	*
	*/
	public $iIsDel = 0;
}
?>
