<?php
/**
 * @fnuctional: 表 sys_product 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-04-17 14:34:13
 */ 
/** 
 * sys_product 表名及字段名
 */
class T_Product
{
    /**
	* 表名
	*/
	const Name = "sys_product";
    /**
	* 所有字段
	*/
	const AllFields = "`product_id`,`product_no`,`product_name`,`reference_price`,`product_type_id`,`product_group`,`product_series`,`product_specs`,`unit_name`,`sort_index`,`product_remark`,`create_uid`,`create_time`,`update_uid`,`update_time`,`is_lock`,`is_del`,`is_gift`";
 }
 /**
 * sys_product 数据实体
 */
class ProductInfo
{
    /**
    * 产品id
    */
    public $iProductId = 0;
    /**
    * 产品编号
    */
    public $strProductNo = '';
    /**
    * 产品名称
    */
    public $strProductName = '';
    /**
    * 参考价/基准价
    */
    public $iReferencePrice = 0;
    /**
    * 产品类型ID
    */
    public $iProductTypeId = 0;
    /**
    * 0增值产品 1网盟产品
    */
    public $iProductGroup = 0;
    /**
    * 系列
    */
    public $strProductSeries = '';
    /**
    * 规格
    */
    public $strProductSpecs = '';
    /**
    * 单位
    */
    public $strUnitName = '';
    /**
    * 排序
    */
    public $iSortIndex = 0;
    /**
    * 备注
    */
    public $strProductRemark = '';
    /**
    * 添加人
    */
    public $iCreateUid = 0;
    /**
    * 添加时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 更新人
    */
    public $iUpdateUid = 0;
    /**
    * 更新时间
    */
    public $strUpdateTime = '2000-01-01';
    /**
    * 停用标识
    */
    public $iIsLock = 0;
    /**
    * 删除标识
    */
    public $iIsDel = 0;
    /**
    * 是否为赠品
    */
    public $iIsGift = 0;
 }