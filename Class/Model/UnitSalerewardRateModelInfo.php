<?php
/**
 * @fnuctional: 表 sys_unit_salereward_rate_model 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-09-17 14:15:41
 */ 
/** 
 * sys_unit_salereward_rate_model 表名及字段名
 */
class T_UnitSalerewardRateModel
{
    /**
	* 表名
	*/
	const Name = "sys_unit_salereward_rate_model";
    /**
	* 所有字段
	*/
	const AllFields = "`sys_unit_salereward_rate_model`.`salereward_rate_model_id`,`sys_unit_salereward_rate_model`.`model_name`,`sys_unit_salereward_rate_model`.`product_id`,`sys_unit_salereward_rate_model`.`model_type`,`sys_unit_salereward_rate_model`.`model_remark`,`sys_unit_salereward_rate_model`.`is_del`,`sys_unit_salereward_rate_model`.`create_uid`,`sys_unit_salereward_rate_model`.`create_user_name`,`sys_unit_salereward_rate_model`.`create_time`,`sys_unit_salereward_rate_model`.`update_uid`,`sys_unit_salereward_rate_model`.`update_user_name`,`sys_unit_salereward_rate_model`.`update_time`";
 }
 /**
 * sys_unit_salereward_rate_model 数据实体
 */
class UnitSalerewardRateModelInfo
{
    /**
    * 
    */
    public $iSalerewardRateModelId = 0;
    /**
    * 模板名称
    */
    public $strModelName = '';
    /**
    * 产品ID
    */
    public $iProductId = 0;
    /**
    * 模板类型 0代理价模板、1促销价模板
    */
    public $iModelType = 0;
    /**
    * 备注
    */
    public $strModelRemark = '';
    /**
    * 删除
    */
    public $iIsDel = 0;
    /**
    * 创建人ID
    */
    public $iCreateUid = 0;
    /**
    * 创建人
    */
    public $strCreateUserName = '';
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 更改人ID
    */
    public $iUpdateUid = 0;
    /**
    * 更改人
    */
    public $strUpdateUserName = '';
    /**
    * 更改时间
    */
    public $strUpdateTime = '2000-01-01';
 }