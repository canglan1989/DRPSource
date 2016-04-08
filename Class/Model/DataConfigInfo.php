<?php
/**
 * @fnuctional: 表 cm_data_config 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-10-24 15:56:37
 */ 
/** 
 * cm_data_config 表名及字段名
 */
class T_DataConfig
{
    /**
	* 表名
	*/
	const Name = "cm_data_config";
    /**
	* 所有字段
	*/
	const AllFields = "`cm_data_config`.`d_id`,`cm_data_config`.`s_id`,`cm_data_config`.`agent_id`,`cm_data_config`.`d_value`,`cm_data_config`.`d_name`,`cm_data_config`.`data_type`,`cm_data_config`.`sort_index`,`cm_data_config`.`is_lock`,`cm_data_config`.`is_system`,`cm_data_config`.`is_def`,`cm_data_config`.`d_remark`,`cm_data_config`.`is_del`,`cm_data_config`.`create_uid`,`cm_data_config`.`create_time`,`cm_data_config`.`update_uid`,`cm_data_config`.`update_time`";
 }
 /**
 * cm_data_config 数据实体
 */
class DataConfigInfo
{
    /**
    * 
    */
    public $iDId = 0;
    /**
    * 对应盘石公司设置的ID
    */
    public $iSId = 0;
    /**
    * 代理商ID 0表示是盘石公司的数据设置
    */
    public $iAgentId = 0;
    /**
    * 值
    */
    public $strDValue = '';
    /**
    * 名称
    */
    public $strDName = '';
    /**
    * 数据类型
    */
    public $strDataType = '';
    /**
    * 显示顺序
    */
    public $iSortIndex = 0;
    /**
    * 停用
    */
    public $iIsLock = 0;
    /**
    * 系统数据
    */
    public $iIsSystem = 0;
    /**
    * 是否为默认值
    */
    public $iIsDef = 0;
    /**
    * 备注
    */
    public $strDRemark = '';
    /**
    * 是否删除 0-否 1-是
    */
    public $iIsDel = 0;
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 最后更新人用户ID
    */
    public $iUpdateUid = 0;
    /**
    * 最后更新时间
    */
    public $strUpdateTime = '2000-01-01';
 }