<?php

/**
 * @fnuctional: 表 am_visit_return 的类模型
 * @copyright:  Copyright (C) 2012 浙江盘石信息技术有限公司  版权所有。
 * @author:     许亮
 * @date:       2012-03-06 18:12:46
 */

/**
 * am_visit_return 表名及字段名
 */
class T_VisitReturn
{
    /**
     * 表名
     */

    const Name = "am_visit_return";
    /**
     * 所有字段
     */
    const AllFields = "id,visitNoteID,content,return_time,add_time,add_user_id";

}

/**
 * am_visit_return 数据实体
 */
class VisitReturnInfo
{

    /**
     * 
     */
    public $iId = 0;

    /**
     * 
     */
    public $iVisitnoteid = 0;

    /**
     * 
     */
    public $strContent = '';

    /**
     * 
     */
    public $strReturnTime = '2000-01-01';

    /**
     * 
     */
    public $strAddTime = '2000-01-01';

    /**
     * 
     */
    public $iAddUserId = 0;

}