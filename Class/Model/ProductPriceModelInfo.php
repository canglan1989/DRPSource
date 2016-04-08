<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_product_price_model的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011/8/19 10:10:36
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_product_price_model表名及字段名
 */
class T_ProductPriceModel
{
	/**
	* 表名
	*/
	const Name = "sys_product_price_model";
	/**
	* 
	*/
	const price_model_id = "price_model_id";
	/**
	* 
	*/
	const model_name = "model_name";
	/**
	* 
	*/
	const product_id = "product_id";
	/**
	* 
	*/
	const price_or_rate = "price_or_rate";
	/**
	* 
	*/
	const model_type = "model_type";
	/**
	* 
	*/
    const model_remark = "model_remark";
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
	const update_uid = "update_uid";
	/**
	* 
	*/
	const update_time = "update_time";
	/**
	* 
	*/
	const sale_bonus_pes = "sale_bonus_pes";
	/**
	* 
	*/
	const sal_div_dedu = "sal_div_dedu";
	/**
	* 
	*/
	const deduction_pes = "deduction_pes";
	
	/**
	* 所有字段
	*/
	const AllFields = "`price_model_id`,`model_name`,`product_id`,`price_or_rate`,`model_type`,`model_remark`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`,`sale_bonus_pes`,`sal_div_dedu`,`deduction_pes`";
}

/**
 * sys_product_price_model数据实体
 */
class ProductPriceModelInfo
{
	/**
	*
	*/
	public $iPriceModelId = 0;
	/**
	*
	*/
	public $strModelName = '';
	/**
	*
	*/
	public $iProductId = 0;
	/**
	*
	*/
	public $iPriceOrRate = 0;
	/**
	*
	*/
	public $iModelType = 0;
	/**
	*
	*/
    public $iModelRemark = 0;
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
	public $iUpdateUid = 0;
	/**
	*
	*/
	public $strUpdateTime = '';
	/**
	*
	*/
	public $iSaleBonusPes = 0;
	/**
	*
	*/
	public $iSalDivDedu = 0;
	/**
	*
	*/
	public $iDeductionPes = 0;
}
?>
