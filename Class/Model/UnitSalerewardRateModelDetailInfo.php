<?php
/**
 * @fnuctional: 表 sys_unit_salereward_rate_model_detail 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-09-17 14:15:41
 */ 
/** 
 * sys_unit_salereward_rate_model_detail 表名及字段名
 */
class T_UnitSalerewardRateModelDetail
{
    /**
	* 表名
	*/
	const Name = "sys_unit_salereward_rate_model_detail";
    /**
	* 所有字段
	*/
	const AllFields = "`sys_unit_salereward_rate_model_detail`.`model_detail_id`,`sys_unit_salereward_rate_model_detail`.`salereward_rate_model_id`,`sys_unit_salereward_rate_model_detail`.`data_index`,`sys_unit_salereward_rate_model_detail`.`range`,`sys_unit_salereward_rate_model_detail`.`money`,`sys_unit_salereward_rate_model_detail`.`rate`";
 }
 /**
 * sys_unit_salereward_rate_model_detail 数据实体
 */
class UnitSalerewardRateModelDetailInfo
{
    /**
    * 
    */
    public $iModelDetailId = 0;
    /**
    * 产品价格模板ID
    */
    public $iSalerewardRateModelId = 0;
    /**
    * 序
    */
    public $iDataIndex = 0;
    /**
    * 0< 1<=
    */
    public $iRange = 0;
    /**
    * 小于或小等于金额
    */
    public $iMoney = 0;
    /**
    * 返点比例
    */
    public $iRate = 0;
 }