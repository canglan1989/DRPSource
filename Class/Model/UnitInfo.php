<?PHP
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：表sys_unit的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-7-8 18:53:29
 * 修改人：      修改时间：
 * 修改描述：
 **/

/**
 * sys_unit表名及字段名 
 */
class T_Unit
{
	/**
     * 表名 
     */
	const Name = "sys_unit";
	/**
     * 
     */
	const unit_id = "unit_id";
	/**
     * 
     */
	const unit_name = "unit_name";
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
     * 所有字段 
     */
	const AllFields = "`unit_id`,`unit_name`,`sort_index`,`is_lock`,`is_del`,`update_uid`,`update_time`,`create_uid`,`create_time`";
}

/**
 * sys_unit数据实体
 */
class UnitInfo
{
	/**
     * 
     */
	public $iUnitId = 0;
	/**
     * 
     */
	public $strUnitName = '';
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

}

