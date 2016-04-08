<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_user_role的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

/**
 * sys_user_role表名及字段名 
 */
class T_UserRole
{
	/**
	* 表名
	*/
	const Name = "sys_user_role";
	/**
	* 
	*/
	const aid = "aid";
	/**
	* 
	*/
	const user_id = "user_id";
	/**
	* 
	*/
	const role_id = "role_id";
	/**
	* 
	*/
	const agent_id = "agent_id";
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
	const AllFields = "`aid`,`user_id`,`role_id`,`agent_id`,`create_uid`,`create_time`";
}

/**
 * sys_user_role数据实体
 */
class UserRoleInfo
{
	/**
	*
	*/
	public $iAid = 0;
	/**
	*
	*/
	public $iUserId = 0;
	/**
	*
	*/
	public $iRoleId = 0;
	/**
	*
	*/
	public $iAgentId = 0;
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
