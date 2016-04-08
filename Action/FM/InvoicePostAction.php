<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：票据邮寄管理模块
 * 创建人：wzx
 * 添加时间：2011-8-25 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';

class InvoicePostAction extends ActionBase
{
    public function __construct()
    {
    }
     
     /**
     * @functional 票据邮寄管理列表
     */
    public function InvoicePostManager()
    {
        //$this->PageRightValidate("InvoicePostManager",Rightvalue::view);        
        $this->smarty->assign('strTitle','票据邮寄管理');
        
        $this->smarty->assign('InvoicePostManagerBody',"/?d=FM&c=InvoicePost&a=InvoicePostManagerBody");
        $this->smarty->display('FM/Front/InvoicePostManager.tpl');
    }


     /**
     * @functional 票据邮寄管理列表数据显示
     */
    public function InvoicePostManagerBody()
    {
        //$this->ExitWhenNoRight("InvoicePostManager",Rightvalue::view);
        
        //$this->smarty->display('FM/Front/InvoicePostManagerBody.tpl');
    }

}
?>