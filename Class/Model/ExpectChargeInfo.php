<?php
/**
 * @fnuctional: 表 am_expect_charge 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2012-11-27 15:15:37
 */ 
/** 
 * am_expect_charge 表名及字段名
 */
class T_ExpectCharge
{
    /**
	* 表名
	*/
	const Name = "am_expect_charge";
    /**
	* 所有字段
	*/
	const AllFields = "`am_expect_charge`.`id`,`am_expect_charge`.`agent_id`,`am_expect_charge`.`inten_level`,`am_expect_charge`.`expect_time`,`am_expect_charge`.`expect_money`,`am_expect_charge`.`expect_type`,`am_expect_charge`.`charge_percentage`,`am_expect_charge`.`create_time`,`am_expect_charge`.`create_uid`,`product_id`";
 }
 /**
 * am_expect_charge 数据实体
 */
class ExpectChargeInfo
{
    /**
    * 预计到账id
    */
    public $iId = 0;
    /**
    * 代理商id
    */
    public $iAgentId = 0;
    /**
    * 意向等级
    */
    public $strIntenLevel = '';
    /**
    * 预计到账时间
    */
    public $strExpectTime = '2000-01-01';
    /**
    * 预计到账金额
    */
    public $iExpectMoney = 0;
    /**
    * 预计到账类型 1：承诺 2：备份
    */
    public $iExpectType = 0;
    /**
    * 到账概率
    */
    public $iChargePercentage = 0;
    /**
    * 
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 
    */
    public $iCreateUid = 0;
    /**
     * 意向产品ID
     */
    public $iProductId = 0;
 }