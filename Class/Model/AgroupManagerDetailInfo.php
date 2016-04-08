<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_agroup_manager_detail的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-25 13:33:18
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_agroup_manager_detail表名及字段名
 */
class T_AgroupManagerDetail
{
	/**
	* 表名
	*/
	const Name = "sys_agroup_manager_detail";
	/**
	* 
	*/
	const agroup_manager_detail = "agroup_manager_detail";
	/**
	* 
	*/
	const agroup_manager_id = "agroup_manager_id";
	/**
	* 
	*/
	const agroup_id = "agroup_id";
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
	const AllFields = "`agroup_manager_detail`,`agroup_manager_id`,`agroup_id`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`";
}

/**
 * sys_agroup_manager_detail数据实体
 */
class AgroupManagerDetailInfo
{
	/**
	*
	*/
	public $iAgroupManagerDetail = 0;
	/**
	*
	*/
	public $iAgroupManagerId = 0;
	/**
	*
	*/
	public $iAgroupId = 0;
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
