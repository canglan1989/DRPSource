<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_role_right的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-15 9:07:26
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_role_right表名及字段名
 */
class T_RoleRight
{
	/**
	* 表名
	*/
	const Name = "sys_role_right";
	/**
	* 
	*/
	const aid = "aid";
	/**
	* 
	*/
	const role_id = "role_id";
	/**
	* 
	*/
	const right_id = "right_id";
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
	const AllFields = "`aid`,`role_id`,`right_id`,`create_uid`,`create_time`";
}

/**
 * sys_role_right数据实体
 */
class RoleRightInfo
{
	/**
	*
	*/
	public $iAid = 0;
	/**
	*
	*/
	public $iRoleId = 0;
	/**
	*
	*/
	public $iRightId = 0;
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
