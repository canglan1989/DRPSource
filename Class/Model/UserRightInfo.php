<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_user_right的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-20 9:43:46
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_user_right表名及字段名
 */
class T_UserRight
{
	/**
	* 表名
	*/
	const Name = "sys_user_right";
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
	const right_id = "right_id";
	/**
	* 
	*/
	const is_forbid = "is_forbid";
	/**
	* 
	*/
	const is_allow = "is_allow";
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
	const AllFields = "`aid`,`user_id`,`right_id`,`is_forbid`,`is_allow`,`create_uid`,`create_time`";
}

/**
 * sys_user_right数据实体
 */
class UserRightInfo
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
	public $iRightId = 0;
	/**
	*
	*/
	public $iIsForbid = 0;
	/**
	*
	*/
	public $iIsAllow = 0;
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
