<?php
/**
 * @fnuctional: 表 sys_model 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-02-09 14:15:11
 */ 
/** 
 * sys_model 表名及字段名
 */
class T_Model
{
    /**
	* 表名
	*/
	const Name = "sys_model";
    /**
	* 所有字段
	*/
	const AllFields = "model_id,mgroup_id,model_code,model_name,model_page,model_remark,show_name,model_path,sort_index,is_agent,is_lock,is_menu,is_del,create_uid,create_time,update_uid,update_time,product_type_ids";
 }
 /**
 * sys_model 数据实体
 */
class ModelInfo
{
    /**
    * 模块ID
    */
    public $iModelId = 0;
    /**
    * 模块组ID
    */
    public $iMgroupId = 0;
    /**
    * 提供系统内部代码使用
    */
    public $strModelCode = '';
    /**
    * 模块名
    */
    public $strModelName = '';
    /**
    * 树型结构字段
    */
    public $strModelPage = '';
    /**
    * 描述
    */
    public $strModelRemark = '';
    /**
    * 显示名称
    */
    public $strShowName = '';
    /**
    * 面包线(路径)
    */
    public $strModelPath = '';
    /**
    * 显示顺序
    */
    public $iSortIndex = 0;
    /**
    * 是否为代理商模块 0-否 1-是
    */
    public $iIsAgent = 0;
    /**
    * 是否显示 0-否 1-是
    */
    public $iIsLock = 0;
    /**
    * 
    */
    public $iIsMenu = 0;
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
    /**
    * 
    */
    public $strProductTypeIds = '';
 }