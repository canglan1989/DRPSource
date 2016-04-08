<?php
/**
 * @fnuctional: 表 sys_product_type 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-04-17 14:34:12
 */ 
/** 
 * sys_product_type 表名及字段名
 */
class T_ProductType
{
    /**
	* 表名
	*/
	const Name = "sys_product_type";
    /**
	* 所有字段
	*/
	const AllFields = "`aid`,`product_type_no`,`product_type_name`,`type_remark`,`is_lock`,`sort_index`,`data_type`,`charge_rate`,`warning_money`,`is_del`,`create_uid`,`create_time`,`update_uid`,`update_time`";
 }
 /**
 * sys_product_type 数据实体
 */
class ProductTypeInfo
{
    /**
    * 型类ID(千万不能改，系统已这个作为类别判断)
    */
    public $iAid = 0;
    /**
    * 类别编号
    */
    public $strProductTypeNo = '';
    /**
    * 产品类型名称
    */
    public $strProductTypeName = '';
    /**
    * 备注
    */
    public $strTypeRemark = '';
    /**
    * 停用
    */
    public $iIsLock = 0;
    /**
    * 显示顺序
    */
    public $iSortIndex = 0;
    /**
    * 0增值产品 1网盟产品
    */
    public $iDataType = 0;
    /**
    * 扣预存的比例
    */
    public $iChargeRate = 0;
    /**
    * 产品预存款账户的预警金额 小等于0则不预警
    */
    public $iWarningMoney = 0;
    /**
    * 删除
    */
    public $iIsDel = 0;
    /**
    * 创建人
    */
    public $iCreateUid = 0;
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 更改人
    */
    public $iUpdateUid = 0;
    /**
    * 更改时间
    */
    public $strUpdateTime = '2000-01-01';
 }