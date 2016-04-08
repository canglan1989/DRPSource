<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表hr_department的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-3 17:43:09
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * hr_department表名及字段名
 */
class T_Department
{
	/**
	* 表名
	*/
	const Name = "hr_department";
	/**
	* 
	*/
	const dept_id = "dept_id";
	/**
	* 
	*/
	const dept_no = "dept_no";
	/**
	* 
	*/
	const dept_name = "dept_name";
	/**
	* 
	*/
	const dept_type = "dept_type";
	/**
	* 
	*/
	const dept_fullname = "dept_fullname";
	/**
	* 
	*/
	const data_type = "data_type";
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
	* 
	*/
	const hr_dept_fk = "hr_dept_fk";
	
	/**
	* 所有字段
	*/
	const AllFields = "`dept_id`,`dept_no`,`dept_name`,`dept_type`,`dept_fullname`,`data_type`,`is_lock`,`is_del`,`create_uid`,`create_time`,`hr_dept_fk`";
}

/**
 * hr_department数据实体
 */
class DepartmentInfo
{
	/**
	*
	*/
	public $iDeptId = 0;
	/**
	*
	*/
	public $strDeptNo = '';
	/**
	*
	*/
	public $strDeptName = '';
	/**
	*
	*/
	public $iDeptType = 0;
	/**
	*
	*/
	public $strDeptFullname = '';
	/**
	*
	*/
	public $iDataType = 0;
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
	/**
	*
	*/
	public $iHrDeptFk = 0;
}
?>
