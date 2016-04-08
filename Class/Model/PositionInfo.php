<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表hr_position的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-3 17:43:09
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * hr_position表名及字段名
 */
class T_Position
{
	/**
	* 表名
	*/
	const Name = "hr_position";
	/**
	* 
	*/
	const post_id = "post_id";
	/**
	* 
	*/
	const level_id = "level_id";
	/**
	* 
	*/
	const post_name = "post_name";
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
	const create_uid = "create_uid";
	/**
	* 
	*/
	const create_time = "create_time";
	
	/**
	* 所有字段
	*/
	const AllFields = "`post_id`,`level_id`,`post_name`,`sort_index`,`is_lock`,`is_del`,`create_uid`,`create_time`";
}

/**
 * hr_position数据实体
 */
class PositionInfo
{
	/**
	*
	*/
	public $iPostId = 0;
	/**
	*
	*/
	public $iLevelId = 0;
	/**
	*
	*/
	public $strPostName = '';
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
	public $iCreateUid = 0;
	/**
	*
	*/
	public $strCreateTime = '';
}
?>
