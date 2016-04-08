<?php
/**
 * @fnuctional: 表 am_expect_charge_history 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2012-11-27 15:15:39
 */ 
/** 
 * am_expect_charge_history 表名及字段名
 */
class T_ExpectChargeHistory
{
    /**
	* 表名
	*/
	const Name = "am_expect_charge_history";
    /**
	* 所有字段
	*/
	const AllFields = "`am_expect_charge_history`.`id`,`am_expect_charge_history`.`agent_id`,`am_expect_charge_history`.`inten_level`,`am_expect_charge_history`.`expect_time`,`am_expect_charge_history`.`expect_money`,`am_expect_charge_history`.`expect_type`,`am_expect_charge_history`.`charge_percentage`,`am_expect_charge_history`.`create_time`,`am_expect_charge_history`.`create_uid`,`am_expect_charge_history`.`operate_time`,`am_expect_charge_history`.`operate_uid`,`product_id`";
 }
 /**
 * am_expect_charge_history 数据实体
 */
class ExpectChargeHistoryInfo
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
    * 操作时间
    */
    public $strOperateTime = '2000-01-01';
    /**
    * 操作人id
    */
    public $iOperateUid = 0;
    /**
     * 意向产品ID
     */
    public $iProductId = 0;
 }