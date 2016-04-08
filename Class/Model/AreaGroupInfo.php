<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_area_group的类模型
 * 表描述：
 * 创建人：xdd
 * 添加时间：2011-8-13 14:46:24
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_area_group表名及字段名
 */
class T_AreaGroup
{
	/**
	* 表名
	*/
	const Name = "sys_area_group";
	/**
	* 
	*/
	const agroup_id = "agroup_id";
	/**
	* 
	*/
	const agroup_name = "agroup_name";
	/**
	* 
	*/
	const group_no = "group_no";
	/**
	* 
	*/
	const agroup_remark = "agroup_remark";
	/**
	* 
	*/
	const sort_index = "sort_index";
	/**
	* 
	*/
	const is_lock = "is_lock";
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
	* 
	*/
	const is_group = "is_group";
	
	/**
	* 所有字段
	*/
	const AllFields = "`agroup_id`,`agroup_name`,`group_no`,`agroup_remark`,`sort_index`,`is_lock`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`,`is_group`";
}

/**
 * sys_area_group数据实体
 */
class AreaGroupInfo
{
	/**
	*
	*/
	public $iAgroupId = 0;
	/**
	*
	*/
	public $strAgroupName = '';
	/**
	*
	*/
	public $strGroupNo = '';
	/**
	*
	*/
	public $strAgroupRemark = '';
	/**
	*
	*/
	public $iSortIndex = 0;
	/**
	*
	*/
	public $iIsLock = 0;
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
	/**
	*
	*/
	public $iIsGroup = 0;
}
?>
