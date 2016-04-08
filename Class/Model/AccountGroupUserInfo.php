<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_account_group_user的类模型
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-9-1 18:23:50
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_account_group_user表名及字段名
 */
class T_AccountGroupUser
{
	/**
	* 表名
	*/
	const Name = "sys_account_group_user";
	/**
	* 
	*/
	const account_group_user_id = "account_group_user_id";
	/**
	* 
	*/
	const accout_group_id = "account_group_id";
	/**
	* 
	*/
	const user_id = "user_id";
	/**
	* 
	*/
	const is_del = "is_del";
	/**
	* 
	*/
	const update_uid = "update_uid";
	/**
	* 
	*/
	const create_uid = "create_uid";
	/**
	* 
	*/
	const update_time = "update_time";
	/**
	* 
	*/
	const create_time = "create_time";
	
	/**
	* 所有字段
	*/
	const AllFields = "`account_group_user_id`,`account_group_id`,`user_id`,`is_del`,`update_uid`,`create_uid`,`update_time`,`create_time`";
}


/**
 * sys_account_group_user数据实体
 */
class AccountGroupUserInfo
{
	/**
	*
	*/
	public $iAccountGroupUserId = 0;
	/**
	*
	*/
	public $iAccountGroupId = 0;
	/**
	*
	*/
	public $iUserId = 0;
	/**
	*
	*/
	public $iIsDel = 0;
	/**
	*
	*/
	public $iUpdateUid = 0;
	/**
	*
	*/
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strUpdateTime = '';
	/**
	*
	*/
	public $strCreateTime = '';
}
?>
