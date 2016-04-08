<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs--> 
<!--S list_table_head-->
<div class="form_edit">
    <div class="form_hd">
        <div class="form_hd_left">
            <div class="form_hd_right">
                <div class="form_hd_mid">
                    <h2>{$strTitle}</h2>
                </div>
            </div>
        </div>
    </div>
    <!--E list_table_head--> 
    <!--S list_table_main-->
    <div class="form_bd">
        <div style="margin:0 10px 10px;" class="table_attention"><span class="ui_link">参数类型1：该类参数的作用是规定代理商进行相应参数设置的区间值</span></div>    
        <div class="form_block_hd">
            <a class="ui_button ui_link" onclick="setToSeaTimeParse(0)"><span class="ui_icon ui_icon_edit">&nbsp;</span>设置拉取区间</a>
            <h3 class="ui_title">拉取时间设置</h3></div>
        <div class="form_block_bd">
            <div class="list_table_main marginBottom10 agentInfoToggle">
                <div class="ui_table ui_table_nohead">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">                                        
                                <th  title="时间区间">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">时间区间</div>
                        </div>
                        </th>
                        <th style="width:90px;"title="操作">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">操作</div>
                        </div>
                        </th>
                        </tr>
                        </thead>
                        <tbody class="ui_table_bd" id="ToSeaTimeBody">
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>
        <div class="form_block_hd">
            <a class="ui_button ui_link" onclick="setToSeaOptionParse(0)"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加踢入公海选项</a>
            <h3 class="ui_title">踢入公海选项配置</h3></div>
        <div class="form_block_bd">
            <div class="list_table_main marginBottom10 agentInfoToggle">
                <div class="ui_table ui_table_nohead">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">                                        
                                <th style="width:100px;" title="选项描述">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">选项描述</div>
                        </div>
                        </th>
                        <th style="width:200px;" title="屏蔽天数区间值（单位为天）">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">屏蔽天数区间值（单位为天）</div>
                        </div>
                        </th>
                        <th style="width:130px;" title="操作">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">操作</div>
                        </div>
                        </th>
                        </tr>
                        </thead>
                        <tbody class="ui_table_bd" id="ToSeaOptionBody">
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>

        <div class="form_block_hd"><h3 class="ui_title">个人库中客户保护期限设置</h3></div>
        <div class="form_block_bd">
            <div class="list_table_main marginBottom10 agentInfoToggle">
                <div class="ui_table ui_table_nohead">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">                                        
                                <th style="width:100px;" title="保护对象">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">保护对象</div>
                        </div>
                        </th>
                        <th style="width:200px;" title="保护的天数区间值（单位为天">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">保护的天数区间值（单位为天）</div>
                        </div>
                        </th>
                        <th style="width:130px;" title="操作">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">操作</div>
                        </div>
                        </th>
                        </tr>
                        </thead>
                        <tbody class="ui_table_bd">
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$ProtectTime_Tel.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$ProtectTime_Tel.d_name}_value">{$ProtectTime_Tel.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setProtectDateParse({$ProtectTime_Tel.d_id},'{$ProtectTime_Tel.d_name}_value')">编辑</a></div></td>
                            </tr>
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$ProtectTime_Self_No_Record.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$ProtectTime_Self_No_Record.d_name}_value">{$ProtectTime_Self_No_Record.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setProtectDateParse({$ProtectTime_Self_No_Record.d_id},'{$ProtectTime_Self_No_Record.d_name}_value')">编辑</a></div></td>
                            </tr>
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$ProtectTime_Protect_No_Record.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$ProtectTime_Protect_No_Record.d_name}_value">{$ProtectTime_Protect_No_Record.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setProtectDateParse({$ProtectTime_Protect_No_Record.d_id},'{$ProtectTime_Protect_No_Record.d_name}_value')">编辑</a></div></td>
                            </tr>
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$ProtectTime_Self_Record.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$ProtectTime_Self_Record.d_name}_value">{$ProtectTime_Self_Record.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setProtectDateParse({$ProtectTime_Self_Record.d_id},'{$ProtectTime_Self_Record.d_name}_value')">编辑</a></div></td>
                            </tr>
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$ProtectTime_Protect_Record.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$ProtectTime_Protect_Record.d_name}_value">{$ProtectTime_Protect_Record.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setProtectDateParse({$ProtectTime_Protect_Record.d_id},'{$ProtectTime_Protect_Record.d_name}_value')">编辑</a></div></td>
                            </tr>
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$ProtectTime_Formal.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$ProtectTime_Formal.d_name}_value">{$ProtectTime_Formal.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setProtectDateParse({$ProtectTime_Formal.d_id},'{$ProtectTime_Formal.d_name}_value')">编辑</a></div></td>
                            </tr>
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>
        <div class="form_block_hd"><h3 class="ui_title">个人客户库容量设置</h3></div>
        <div class="form_block_bd">
            <div class="list_table_main marginBottom10 agentInfoToggle">
                <div class="ui_table ui_table_nohead">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">                                        
                                <th style="width:125px;" title="操作人">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">客户类型</div>
                        </div>
                        </th>
                        <th style="width:100px;" title="被联系人">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">保护的客户数量区间值（单位为个）</div>
                        </div>
                        </th>
                        <th style="width:200px;" title="手机固话">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">操作</div>
                        </div>
                        </th>
                        </tr>
                        </thead>
                        <tbody class="ui_table_bd">
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$Allow_Count_Self.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$Allow_Count_Self.d_name}_value">{$Allow_Count_Self.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setAllowCount({$Allow_Count_Self.d_id},'{$Allow_Count_Self.d_name}_value')">编辑</a></div></td>
                            </tr>
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$Allow_Count_Tel.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$Allow_Count_Tel.d_name}_value">{$Allow_Count_Tel.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setAllowCount({$Allow_Count_Tel.d_id},'{$Allow_Count_Tel.d_name}_value')">编辑</a></div></td>
                            </tr>
                            <tr class="">
                                <td title=""><div class="ui_table_tdcntr">{$Allow_Count_Protect.d_name}</div></td>
                                <td title=""><div class="ui_table_tdcntr" id="{$Allow_Count_Protect.d_name}_value">{$Allow_Count_Protect.d_value}</div></td>
                                <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="setAllowCount({$Allow_Count_Protect.d_id},'{$Allow_Count_Protect.d_name}_value')">编辑</a></div></td>
                            </tr>
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>
        <div style="margin:0 10px 10px;" class="table_attention"><span class="ui_link">参数类型2：该类参数的作用是规定代理商系统相应的参数值</span></div> 
        <div class="form_block_hd">
            <a class="ui_button ui_link" onclick="setInvalidContact(0);"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加无效联系选项</a>
            <h3 class="ui_title">无效联系选项配置</h3></div>
        <div class="form_block_bd">
            <div class="list_table_main marginBottom10 agentInfoToggle">
                <div class="ui_table ui_table_nohead">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">                                        
                                <th style="width:100px;" title="被联系人">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">选项描述</div>
                        </div>
                        </th>
                        <th style="width:200px;" title="手机固话">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">排序</div>
                        </div>
                        </th>
                        <th style="width:130px;" title="联系时间">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">操作</div>
                        </div>
                        </th>
                        </tr>
                        </thead>
                        <tbody class="ui_table_bd" id="InvalidContactBody">
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>
        <div class="form_block_hd">
            <a class="ui_button ui_link" onclick="setIntentionRating(0)"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加网盟意向等级选项</a>
            <h3 class="ui_title">网盟意向等级选项配置</h3></div>
        <div class="form_block_bd">
            <div class="list_table_main marginBottom10 agentInfoToggle">
                <div class="ui_table ui_table_nohead">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">                                        
                                <th style="width:100px;" title="等级名">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">等级名</div>
                        </div>
                        </th>
                        <th style="width:200px;" title="描述">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">描述</div>
                        </div>
                        </th>
                        <th style="width:200px;" title="排序">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">排序</div>
                        </div>
                        </th>
                        <th style="width:200px;" title="填写预计到账时间和金额">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">填写预计到账时间和金额</div>
                        </div>
                        </th>
                        <th style="width:200px;" title="纳入统计报表">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">纳入统计报表</div>
                        </div>
                        </th>
                        <th style="width:130px;" title="操作">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">操作</div>
                        </div>
                        </th>
                        </tr>
                        </thead>
                        <tbody class="ui_table_bd" id="IntentionRatingBody">
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>
    </div>     
</div>
<!--E list_table_main--> 
<!--S Main--> 
{literal} 
    <script type="text/javascript">
$(function(){
    getBody('ToSeaTimeBody','/?d=System&c=ComSetting&a=getCMToSeaBody');
    getBody('ToSeaOptionBody','/?d=System&c=ComSetting&a=getCMToSeaOptionBody');
    getBody('InvalidContactBody','/?d=System&c=ComSetting&a=getCMInvalidContactBody');
    getBody('IntentionRatingBody','/?d=System&c=ComSetting&a=getCMIntentionRatingBody');
});   
    
function setToSeaTimeParse(id){
    setParam("设置拉取时间","/?d=System&c=ComSetting&a=showAddToSeaTime&id="+id,"/?d=System&c=ComSetting&a=AddToSeaTime&id="+id,'ToSeaTimeBody','/?d=System&c=ComSetting&a=getCMToSeaBody',1);
}
        
function setToSeaOptionParse(id){
    setParam("设置踢入公海选项","/?d=System&c=ComSetting&a=showAddToSeaOption&id="+id,"/?d=System&c=ComSetting&a=AddToSeaOption&id="+id,'ToSeaOptionBody','/?d=System&c=ComSetting&a=getCMToSeaOptionBody',1);
}
    
function setProtectDateParse(id,divid){
    setParam("设置参数","/?d=System&c=ComSetting&a=showEditProtectDate&id="+id,"/?d=System&c=ComSetting&a=EditProtectDate&id="+id,divid,'',0);
}
    
function setAllowCount(id,divid){
    setParam("设置参数","/?d=System&c=ComSetting&a=showEditAllowCount&id="+id,"/?d=System&c=ComSetting&a=EditAllowCount&id="+id,divid,'',0);
}
    
function setInvalidContact(id){
    setParam("设置参数","/?d=System&c=ComSetting&a=showAddInvaildContact&id="+id,"/?d=System&c=ComSetting&a=AddInvaildContact&id="+id,'InvalidContactBody','/?d=System&c=ComSetting&a=getCMInvalidContactBody',1);
}

function setIntentionRating(id){
    setParam("设置参数","/?d=System&c=ComSetting&a=showAddIntentionRating&id="+id,"/?d=System&c=ComSetting&a=AddIntentionRating&id="+id,'IntentionRatingBody','/?d=System&c=ComSetting&a=getCMIntentionRatingBody',1);
}       
        
     //显示标题，显示dialog的url，执行操作的url，列表中tbody标签的ID,若flag为0则是DIV的ID。获取列表数据的url,flag判断是加载列表还是直接更新
     function setParam(title,showurl,editurl,listbodyid,listbodyurl,flag){
         IM.dialog.show({
            width: 600,
            height: null,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                MM.get(showurl, {}, function (backData) {
                        $('.DCont')[0].innerHTML = backData;
                        new Reg.vf($('#J_newBankAccount'),{
                        callback:function(formdata){////formdata 表单提交数据 对象数组格式
                        var formValues = $('#J_newBankAccount').serialize();                
                        $.ajax({
                                type: "POST",
                                dataType: "text",
                                url: editurl,
                                data: formValues,
                                success: function (q) {
                                        q=MM.json(q);
                                        if(q.success){
                                                IM.tip.show(q.msg);
                                                IM.dialog.hide();
                                               if(flag > 0){
                                                    getBody(listbodyid,listbodyurl);
                                               }else{
                                                   $("#"+listbodyid).html(q.url);     
                                               }
                                        }else{
                                                IM.tip.warn(q.msg);
                                        }     
                                }                        
                            });
                    }});
            });
      
       }});
    }
        
function delItem(url,bodyid,bodyurl){
    var html='<div class="DContInner delAccountCont">' +
                    '<div class="bd"><h4>您确定要删除所选项码？</h4></div>' +
                    '<div class="ft">' +
                    '<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>' +
                    '<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" onclick="IM.dialog.ok()">确定</button></div>' +
                    '</div></div>';
                IM.dialog.show({
                    width:400,
                    title:'删除操作',
                    html:html,
                    ok:function(){
                        MM.ajax({
                            url: url,
                            success: function (q) {
                                IM.dialog.hide();
                                q=MM.json(q);				
                                if(q.success) {                                    
                                    IM.tip.show('删除成功');
                                    getBody(bodyid,bodyurl);
                                }else{IM.tip.show('删除失败');}
                            }
                        });
                    }
                });
}
        
function getBody(id,url){
    $.ajax({
        url:url,
        success:function(html){
            if(html.length > 0){
                $("#"+id).html(html);
            }
        }
    });        
}
        
    </script> 
{/literal}