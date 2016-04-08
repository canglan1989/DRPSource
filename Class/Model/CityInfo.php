<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_city的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:28
 * 修改人：      修改时间：
 * 修改描述：
 **/

/**
 * sys_city表名及字段名
 */
class T_City
{
	/**
	* 表名
	*/
	const Name = "sys_city";
	/**
	* 
	*/
	const city_id = "city_id";
	/**
	* 
	*/
	const province_id = "province_id";
	/**
	* 
	*/
	const city_no = "city_no";
	/**
	* 
	*/
	const city_name = "city_name";
	/**
	* 
	*/
	const city_fullname = "city_fullname";
	/**
	* 
	*/
	const city_code = "city_code";
	/**
	* 
	*/
	const sort_index = "sort_index";
	
	/**
	* 所有字段
	*/
	const AllFields = "`city_id`,`province_id`,`city_no`,`city_name`,`city_fullname`,`city_code`,`sort_index`";
}

/**
 * sys_city数据实体
 */
class CityInfo
{
	/**
	*
	*/
	public $iCityId = 0;
	/**
	*
	*/
	public $iProvinceId = 0;
	/**
	*
	*/
	public $strCityNo = '';
	/**
	*
	*/
	public $strCityName = '';
	/**
	*
	*/
	public $strCityFullname = '';
	/**
	*
	*/
	public $strCityCode = '';
	/**
	*
	*/
	public $iSortIndex = 0;
}
?>
