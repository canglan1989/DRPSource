<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_user_area的类模型
 * 表描述：
 * 创建人：wdd
 * 添加时间：2011-8-31 16:52:20
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_user_area表名及字段名
 */
class T_UserArea
{
	/**
	* 表名
	*/
	const Name = "sys_user_area";
	/**
	* 
	*/
	const user_areagroup_id = "user_areagroup_id";
	/**
	* 
	*/
	const agroup_user_id = "agroup_user_id";
	/**
	* 
	*/
	const area_group_id = "area_group_id";
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
	const AllFields = "`user_areagroup_id`,`agroup_user_id`,`area_group_id`,`is_del`,`update_uid`,`create_uid`,`update_time`,`create_time`";
}

/**
 * sys_user_area数据实体
 */
class UserAreaInfo
{
	/**
	*
	*/
	public $iUserAreagroupId = 0;
	/**
	*
	*/
	public $iAgroupUserId = 0;
	/**
	*
	*/
	public $iAreaGroupId = 0;
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
