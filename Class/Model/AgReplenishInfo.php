<?php
/**
 * @fnuctional: 表 am_ag_replenish 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     刘君臣
 * @date:       2012-02-29 14:53:04
 */ 
/** 
 * am_ag_replenish 表名及字段名
 */
class T_AgReplenish
{
    /**
	* 表名
	*/
	const Name = "am_ag_replenish";
    /**
	* 所有字段
	*/
	const AllFields = "id,agent_id,pact_id,pro_id,rep_remark,create_time";
 }
 /**
 * am_ag_replenish 数据实体
 */
class AgReplenishInfo
{
    /**
    * 
    */
    public $iId = 0;
    /**
    * 
    */
    public $iAgentId = 0;
    /**
    * 主合同Id
    */
    public $iPactId = 0;
    /**
    * 补签产品Id
    */
    public $iProId = 0;
    /**
    * 补签备注
    */
    public $strRepRemark = '';
    /**
    * 
    */
    public $strCreateTime = '';
 }