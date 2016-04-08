<?php
/**
 * @fnuctional: 表 am_pact_translog 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     邱玉虹
 * @date:       2012-11-02 15:23:36
 */ 
/** 
 * am_pact_translog 表名及字段名
 */
class T_PactTranslog
{
    /**
	* 表名
	*/
	const Name = "am_pact_translog";
    /**
	* 所有字段
	*/
	const AllFields = "`am_pact_translog`.`id`,`am_pact_translog`.`pact_id`,`am_pact_translog`.`old_userID`,`am_pact_translog`.`new_userID`,`am_pact_translog`.`pact_status`,`am_pact_translog`.`create_uid`,`am_pact_translog`.`create_time`";
 }
 /**
 * am_pact_translog 数据实体
 */
class PactTranslogInfo
{
    /**
    * 合同转移记录id
    */
    public $iId = 0;
    /**
    * 合同id
    */
    public $iPactId = 0;
    /**
    * 合同原所属账号
    */
    public $iOldUserid = 0;
    /**
    * 合同新所属账号
    */
    public $iNewUserid = 0;
    /**
    * 合同当前状态
    */
    public $iPactStatus = 0;
    /**
    * 操作时间
    */
    public $iCreateUid = 0;
    /**
    * 操作时间
    */
    public $strCreateTime = '2000-01-01';
 }