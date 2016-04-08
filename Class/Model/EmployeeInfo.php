<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表hr_employee的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-3 17:43:09
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * hr_employee表名及字段名
 */
class T_Employee
{
	/**
	* 表名
	*/
	const Name = "hr_employee";
	/**
	* 
	*/
	const e_id = "e_id";
	/**
	* 
	*/
	const e_workno = "e_workno";
	/**
	* 
	*/
	const e_name = "e_name";
	/**
	* 
	*/
	const e_sex = "e_sex";
	/**
	* 
	*/
	const e_mobile = "e_mobile";
	/**
	* 
	*/
	const e_phone = "e_phone";
	/**
	* 
	*/
	const e_tel_extension = "e_tel_extension";
	/**
	* 
	*/
	const e_email = "e_email";
	/**
	* 
	*/
	const e_status = "e_status";
	/**
	* 
	*/
	const dept_position_id = "dept_position_id";
	/**
	* 
	*/
	const area_no = "area_no";
	/**
	* 
	*/
	const entry_date = "entry_date";
	/**
	* 
	*/
	const try_date = "try_date";
	/**
	* 
	*/
	const formal_date = "formal_date";
	/**
	* 
	*/
	const dimission_date = "dimission_date";
	/**
	* 
	*/
	const contract_bdate = "contract_bdate";
	/**
	* 
	*/
	const contract_edate = "contract_edate";
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
	* 
	*/
	const pl_id = "pl_id";
	
	/**
	* 所有字段
	*/
	const AllFields = "`e_id`,`e_workno`,`e_name`,`e_sex`,`e_mobile`,`e_phone`,`e_tel_extension`,`e_email`,`e_status`,`dept_position_id`,`area_no`,`entry_date`,`try_date`,`formal_date`,`dimission_date`,`contract_bdate`,`contract_edate`,`sort_index`,`is_lock`,`is_del`,`create_uid`,`create_time`,`pl_id`";
}

/**
 * hr_employee数据实体
 */
class EmployeeInfo
{
	/**
	*
	*/
	public $ieId = 0;
	/**
	*
	*/
	public $streWorkno = '';
	/**
	*
	*/
	public $streName = '';
	/**
	*
	*/
	public $ieSex = 0;
	/**
	*
	*/
	public $streMobile = '';
	/**
	*
	*/
	public $strePhone = '';
	/**
	*
	*/
	public $streTelExtension = '';
	/**
	*
	*/
	public $streEmail = '';
	/**
	*
	*/
	public $ieStatus = 0;
	/**
	*
	*/
	public $iDeptPositionId = 0;
	/**
	*
	*/
	public $strAreaNo = '';
	/**
	*
	*/
	public $strEntryDate = '';
	/**
	*
	*/
	public $strTryDate = '';
	/**
	*
	*/
	public $strFormalDate = '';
	/**
	*
	*/
	public $strDimissionDate = '';
	/**
	*
	*/
	public $strContractBdate = '';
	/**
	*
	*/
	public $strContractEdate = '';
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
	/**
	*
	*/
	public $iPlId = 0;
}

?>
