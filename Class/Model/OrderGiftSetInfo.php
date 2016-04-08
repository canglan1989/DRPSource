<?php
/**
 * @fnuctional: 表 om_order_gift_set 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     温智星
 * @date:       2012-04-17 16:16:26
 */ 
/** 
 * om_order_gift_set 表名及字段名
 */
class T_OrderGiftSet
{
    /**
	* 表名
	*/
	const Name = "om_order_gift_set";
    /**
	* 所有字段
	*/
	const AllFields = "`order_gift_set_id`,`agent_id`,`order_product_type_id`,`order_product_type_name`,`gift_product_type_id`,`gift_product_type_name`,`gift_product_id`,`gift_product_name`,`create_time`,`create_uid`,`create_user_name`";
 }
 /**
 * om_order_gift_set 数据实体
 */
class OrderGiftSetInfo
{
    /**
    * 
    */
    public $iOrderGiftSetId = 0;
    /**
    * 
    */
    public $iAgentId = 0;
    /**
    * 订单购买产品的类型
    */
    public $iOrderProductTypeId = 0;
    /**
    * 
    */
    public $strOrderProductTypeName = '';
    /**
    * 赠品类型ID
    */
    public $iGiftProductTypeId = 0;
    /**
    * 
    */
    public $strGiftProductTypeName = '';
    /**
    * 产品ID
    */
    public $iGiftProductId = 0;
    /**
    * 
    */
    public $strGiftProductName = '';
    /**
    * 创建时间
    */
    public $strCreateTime = '2000-01-01';
    /**
    * 创建人用户ID
    */
    public $iCreateUid = 0;
    /**
    * 
    */
    public $strCreateUserName = '';
 }