<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：人员数据处理模块
 * 创建人：wzx
 * 添加时间：2011-8-8 
 * 修改人：      修改时间：
 * 修改描述：
 **/
class EmpAction extends ActionBase
{
    public function __construct()
    {
        //0聘用,1实习,2见习,3外派,4停薪留职,5试用,6隐藏,-1离职中,-9已离职,-10=已辞退,-11=已流失
    }
    
    /**
     * @functional
    */
    public function Index()
    {
    }
    
}
?>