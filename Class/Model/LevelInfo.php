<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表hr_level的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-3 17:43:09
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * hr_level表名及字段名
 */
class T_Level
{
	/**
	* 表名
	*/
	const Name = "hr_level";
	/**
	* 
	*/
	const level_id = "level_id";
	/**
	* 
	*/
	const level_name = "level_name";
	/**
	* 
	*/
	const m_value = "m_value";
	/**
	* 
	*/
	const level_type = "level_type";
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
	const AllFields = "`level_id`,`level_name`,`m_value`,`level_type`,`sort_index`,`is_lock`,`is_del`,`create_uid`,`create_time`";
}

/**
 * hr_level数据实体
 */
class LevelInfo
{
	/**
	*
	*/
	public $iLevelId = 0;
	/**
	*
	*/
	public $strLevelName = '';
	/**
	*
	*/
	public $strmValue = '';
	/**
	*
	*/
	public $iLevelType = 0;
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
