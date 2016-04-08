<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_industry的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-11 9:55:09
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_industry表名及字段名
 */
class T_Industry
{
	/**
	* 表名
	*/
	const Name = "sys_industry";
	/**
	* 
	*/
	const industry_id = "industry_id";
	/**
	* 
	*/
	const industry_pid = "industry_pid";
	/**
	* 
	*/
	const industry_name = "industry_name";
	/**
	* 
	*/
	const industry_full_name = "industry_full_name";
	/**
	* 
	*/
	const industry_class = "industry_class";
	/**
	* 
	*/
	const sort_index = "sort_index";
	
	/**
	* 所有字段
	*/
	const AllFields = "`industry_id`,`industry_pid`,`industry_name`,`industry_fullname`,`industry_class`,`sort_index`";
}

/**
 * sys_industry数据实体
 */
class IndustryInfo
{
	/**
	*
	*/
	public $iIndustryId = 0;
	/**
	*
	*/
	public $iIndustryPid = 0;
	/**
	*
	*/
	public $strIndustryName = '';
	/**
	*
	*/
	public $strIndustryFullName = '';
	/**
	*
	*/
	public $strIndustryClass = '';
	/**
	*
	*/
	public $iSortIndex = 0;
}
?>
