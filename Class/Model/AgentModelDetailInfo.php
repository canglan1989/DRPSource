<?php
/**
 * @fnuctional: 表 sys_agent_model_detail 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-09-14 16:15:51
 */ 
/** 
 * sys_agent_model_detail 表名及字段名
 */
class T_AgentModelDetail
{
    /**
	* 表名
	*/
	const Name = "sys_agent_model_detail";
    /**
	* 所有字段
	*/
	const AllFields = "`sys_agent_model_detail`.`agent_model_detail_id`,`sys_agent_model_detail`.`agent_model_id`,`sys_agent_model_detail`.`agent_id`,`sys_agent_model_detail`.`data_index`,`sys_agent_model_detail`.`range`,`sys_agent_model_detail`.`money`,`sys_agent_model_detail`.`rate`";
 }
 /**
 * sys_agent_model_detail 数据实体
 */
class AgentModelDetailInfo
{
    /**
    * 
    */
    public $iAgentModelDetailId = 0;
    /**
    * 代理商模板ID
    */
    public $iAgentModelId = 0;
    /**
    * 代理商Id
    */
    public $iAgentId = 0;
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