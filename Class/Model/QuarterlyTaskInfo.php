<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表am_quarterly_task的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-10-17 20:27:03
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * am_quarterly_task表名及字段名
 */
class T_QuarterlyTask
{
	/**
	* 表名
	*/
	const Name = "am_quarterly_task";
	/**
	* 
	*/
	const quarterly_task_id = "quarterly_task_id";
	/**
	* 
	*/
	const agent_id = "agent_id";
	/**
	* 
	*/
	const product_type_id = "product_type_id";
	/**
	* 
	*/
	const agent_pact_id = "agent_pact_id";
	/**
	* 
	*/
	const agent_pact_no = "agent_pact_no";
	/**
	* 
	*/
	const agent_level = "agent_level";
	/**
	* 
	*/
	const task_year = "task_year";
	/**
	* 
	*/
	const task_quarterly = "task_quarterly";
	/**
	* 
	*/
	const task_quarterly_text = "task_quarterly_text";
	/**
	* 
	*/
	const task_money = "task_money";
	/**
	* 
	*/
	const finish_money = "finish_money";
	/**
	* 
	*/
	const sale_award_money = "sale_award_money";
	/**
	* 
	*/
	const market_funds = "market_funds";
	/**
	* 
	*/
	const distribution_funds = "distribution_funds";
	/**
	* 
	*/
	const audit_status = "audit_status";
	/**
	* 
	*/
	const quarterly_task_remark = "quarterly_task_remark";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const create_user_name = "create_user_name";
	/**
	* 
	*/
	const create_time = "create_time";
	/**
	* 
	*/
	const update_uid = "update_uid";
	/**
	* 
	*/
	const update_user_name = "update_user_name";
	/**
	* 
	*/
	const update_time = "update_time";
	/**
	* 
	*/
	const is_del = "is_del";
	/**
	* 
	*/
	const account_group_id = "account_group_id";
	/**
	* 
	*/
	const award_money = "award_money";
	/**
	* 
	*/
	const award_uid = "award_uid";
	/**
	* 
	*/
	const award_user_name = "award_user_name";
	/**
	* 
	*/
	const award_time = "award_time";
	/**
	* 
	*/
	const award_remark = "award_remark";
	
	/**
	* 所有字段
	*/
	const AllFields = "`quarterly_task_id`,`agent_id`,`product_type_id`,`agent_pact_id`,`agent_pact_no`,`agent_level`,`task_year`,`task_quarterly`,`task_quarterly_text`,`task_money`,`finish_money`,`sale_award_money`,`market_funds`,`distribution_funds`,`audit_status`,`quarterly_task_remark`,`create_uid`,`create_user_name`,`create_time`,`update_uid`,`update_user_name`,`update_time`,`is_del`,`account_group_id`,`award_money`,`award_uid`,`award_user_name`,`award_time`,`award_remark`";
}

/**
 * am_quarterly_task数据实体
 */
class QuarterlyTaskInfo
{
	/**
	*
	*/
	public $iQuarterlyTaskId = 0;
	/**
	*
	*/
	public $iAgentId = 0;
	/**
	*
	*/
	public $iProductTypeId = 0;
	/**
	*
	*/
	public $iAgentPactId = 0;
	/**
	*
	*/
	public $strAgentPactNo = '';
	/**
	*
	*/
	public $iAgentLevel = 0;
	/**
	*
	*/
	public $iTaskYear = 0;
	/**
	*
	*/
	public $iTaskQuarterly = 0;
	/**
	*
	*/
	public $strTaskQuarterlyText = '';
	/**
	*
	*/
	public $iTaskMoney = 0;
	/**
	*
	*/
	public $iFinishMoney = 0;
	/**
	*
	*/
	public $iSaleAwardMoney = 0;
	/**
	*
	*/
	public $iMarketFunds = 0;
	/**
	*
	*/
	public $iDistributionFunds = 0;
	/**
	*
	*/
	public $iAuditStatus = 0;
	/**
	*
	*/
	public $strQuarterlyTaskRemark = '';
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strCreateUserName = '';
	/**
	*
	*/
	public $strCreateTime = '';
	/**
	*
	*/
	public $iUpdateUid = 0;
	/**
	*
	*/
	public $strUpdateUserName = '';
	/**
	*
	*/
	public $strUpdateTime = '';
	/**
	*
	*/
	public $iIsDel = 0;
	/**
	*
	*/
	public $iAccountGroupId = 0;
	/**
	*
	*/
	public $iAwardMoney = 0;
	/**
	*
	*/
	public $iAwardUid = 0;
	/**
	*
	*/
	public $strAwardUserName = '';
	/**
	*
	*/
	public $strAwardTime = '';
	/**
	*
	*/
	public $strAwardRemark = '';
}
?>
