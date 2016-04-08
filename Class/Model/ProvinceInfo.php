<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_province的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

/**
 * sys_province表名及字段名 
 */
class T_Province
{
	/**
     * 表名 
     */
	const Name = "sys_province";
	/**
     * 
     */
	const province_id = "province_id";
	/**
     * 
     */
	const province_no = "province_no";
	/**
     * 
     */
	const province_name = "province_name";
	/**
     * 
     */
	const province_place = "province_place";
	/**
     * 
     */
	const short_name = "short_name";
	/**
     * 
     */
	const sort_index = "sort_index";
		
	/**
     * 所有字段 
     */
	const AllFields = "`province_id`,`province_no`,`province_name`,`province_place`,`short_name`,`sort_index`";
}

/**
 * sys_province数据实体
 */
class ProvinceInfo
{
	/**
     * 
     */
	public $iProvinceId = 0;
	/**
     * 
     */
	public $strProvinceNo = '';
	/**
     * 
     */
	public $strProvinceName = '';
	/**
     * 
     */
	public $strProvincePlace = '';
	/**
     * 
     */
	public $strShortName = '';
	/**
     * 
     */
	public $iSortIndex = 0;

}

