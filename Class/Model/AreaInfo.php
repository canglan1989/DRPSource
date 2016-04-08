<?php

/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司版权所有。
 * 功能描述：表sys_area的类模型
 * 表描述：
 * 创建人：wzx
 * 添加时间：2011/7/14 15:01:10
 * 修改人：修改时间：
 * 修改描述：
 * */

/**
 * sys_area表名及字段名
 */
class T_Area
{
    /**
     * 表名
     */
    const Name = "sys_area";
    /**
     * 
     */
    const area_id = "area_id";
    /**
     * 
     */
    const city_id = "city_id";
    /**
     * 
     */
    const province_id = "province_id";
    /**
     * 
     */
    const area_no = "area_no";
    /**
     * 
     */
    const area_name = "area_name";
    /**
     * 
     */
    const area_fullname = "area_fullname";
    /**
     * 
     */
    const post_code = "post_code";
    /**
     * 
     */
    const sort_index = "sort_index";
    /**
     * 
     */
    const is_lock = "is_lock";

    /**
     * 所有字段
     */
    const AllFields = "`area_id`,`city_id`,`province_id`,`area_no`,`area_name`,`area_fullname`,`post_code`,`sort_index`,`is_lock`";
}

/**
 * sys_area数据实体
 */
class AreaInfo
{

    /**
     *
     */
    public $iAreaId = 0;
    /**
     *
     */
    public $iCityId = 0;
    /**
     *
     */
    public $iProvinceId = 0;
    /**
     *
     */
    public $strAreaNo = '';
    /**
     *
     */
    public $strAreaName = '';
    /**
     *
     */
    public $strAreaFullname = '';
    /**
     *
     */
    public $strPostCode = '';
    /**
     *
     */
    public $iSortIndex = 0;
    /**
     *
     */
    public $iIsLock = 0;
}

?>
