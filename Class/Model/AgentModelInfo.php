<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_agent_model的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011-8-20 13:53:28
 * 修改人：修改时间：
 * 修改描述：
 **/

/**
 * sys_agent_model表名及字段名
 */
class T_AgentModel
{
	/**
	* 表名
	*/
	const Name = "sys_agent_model";
	/**
	* 
	*/
	const agent_model_id = "agent_model_id";
	/**
	* 
	*/
	const agent_id = "agent_id";
	/**
	* 
	*/
	const product_id = "product_id";
	/**
	* 
	*/
	const agent_price_model_id = "agent_price_model_id";
	/**
	* 
	*/
	const agent_sdate = "agent_sdate";
	/**
	* 
	*/
	const agent_edate = "agent_edate";
	/**
	* 
	*/
	const agent_price = "agent_price";
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
	* 
	*/
	const prom_price_model_id = "prom_price_model_id";
	/**
	* 
	*/
	const prom_sdate = "prom_sdate";
	/**
	* 
	*/
	const prom_edate = "prom_edate";
	/**
	* 
	*/
	const prom_price = "prom_price";
	/**
	* 
	*/
	const model_remark = "model_remark";
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
	const is_del = "is_del";
	/**
	* 
	*/
	const pro_sale_bonus_pes = "pro_sale_bonus_pes";
	/**
	* 
	*/
	const pro_sale_div = "pro_sale_div";
	/**
	* 
	*/
	const pro_store_pes = "pro_store_pes";
	
	/**
	* 所有字段
	*/
	const AllFields = "`agent_model_id`,`agent_id`,`product_id`,`agent_price_model_id`,`agent_sdate`,`agent_edate`,`agent_price`,`sale_bonus_pes`,`sal_div_dedu`,`deduction_pes`,`prom_price_model_id`,`prom_sdate`,`prom_edate`,`prom_price`,`model_remark`,`create_uid`,`create_time`,`update_uid`,`update_time`,`is_del`,`pro_sale_bonus_pes`,`pro_sale_div`,`pro_store_pes`";

}



/**
 * sys_agent_model数据实体
 */
class AgentModelInfo
{
	/**
	*
	*/
	public $iAgentModelId = 0;
	/**
	*
	*/
	public $iAgentId = 0;
	/**
	*
	*/
	public $iProductId = 0;
	/**
	*
	*/
	public $iAgentPriceModelId = 0;
	/**
	*
	*/
	public $strAgentSdate = '';
	/**
	*
	*/
	public $strAgentEdate = '';
	/**
	*
	*/
	public $iAgentPrice = 0;
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
	/**
	*
	*/
	public $iPromPriceModelId = 0;
	/**
	*
	*/
	public $strPromSdate = '';
	/**
	*
	*/
	public $strPromEdate = '';
	/**
	*
	*/
	public $iPromPrice = 0;
	/**
	*
	*/
	public $strModelRemark = '';
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
	public $iIsDel = 0;
	/**
	*
	*/
	public $iProSaleBonusPes = 0;
	/**
	*
	*/
	public $iProSaleDiv = 0;
	/**
	*
	*/
	public $iProStorePes = 0;
}
?>
