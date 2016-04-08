<?php
/**
 * Copyright (C) 2011 浙江盘石信息技术有限公司  版权所有。
 * 功能描述：审核模块
 * 创建人：wzx
 * 添加时间：2011-8-16 
 * 修改人：      修改时间：
 * 修改描述：
 **/
 
require_once __DIR__ . '/../Common/ActionBase.php';
require_once __DIR__.'/../../Class/BLL/AuditRecordBLL.php';

class AuditAction extends ActionBase
{
    public function __construct()
    {
    }
     
    public function Index()
    {
        
    }
     
    public static function ShowAudit()
    {
        return "<div class=\"form_block_bd\"><div class=\"tf\"><label>审核备注：</label><div class=\"inp\">
         <textarea name=\"tbxAuditRemark\" cols=\"50\" style=\"width:400px;height:80px;\" id=\"tbxAuditRemark\" onblur=\"ClearText(this,50)\"></textarea>
        </div><span class=\"info\" style=\"display: inline-block;\">50字以内</span><span class=\"ok\">&nbsp;</span><span class=\"err\">50字以内</span></div><div class=\"tf tf_submit\"><label>&nbsp;</label><div class=\"inp\">
        <div class=\"ui_button ui_button_confirm\"><button class=\"ui_button_inner\" tabindex=\"7\" type=\"button\" onclick=\"Auditting.Pass()\">通过</button></div>
		<div class=\"ui_button ui_button_confirm\"><button class=\"ui_button_inner\" tabindex=\"8\" type=\"button\" onclick=\"Auditting.NotPass()\">不通过</button></div>
        <div class=\"ui_button ui_button_cancel\"><a class=\"ui_button_inner\" onclick=\"PageBack()\" href=\"#\" tabindex=\"9\">返 回</a></div></div></div></div>";
    }
    
    
    public function ShowAuditInfo($tableName,$id)
    {
        $objAuditRecordBLL = new AuditRecordBLL();
        return $objAuditRecordBLL->AuditInfoHTML($tableName,$id);
    }
}
?>