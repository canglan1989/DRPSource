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
            <h3 class="ui_title">拉取时间设置</h3></div>
        <div class="form_block_bd">
            <div class="list_table_main marginBottom10 agentInfoToggle">
                <div class="ui_table ui_table_nohead">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">  
                                <th  title="默认时间区间范围">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">默认时间区间范围</div>
                        </div>
                        </th>
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
                        <tbody class="ui_table_bd" id="ProtectDateBody">

                        </tbody>
                    </table>        
                </div>
            </div>
        </div>

        <div class="form_block_hd">
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
                        <tbody class="ui_table_bd" id="AllowCountBody">
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
    getBody('ToSeaTimeBody','/?d=System&c=ComSetting&a=getFrontToSeaTimeBody');
    getBody('ProtectDateBody','/?d=System&c=ComSetting&a=getFrontProtectDateBody');
    getBody('AllowCountBody','/?d=System&c=ComSetting&a=getFrontAllowCountBody');
    getBody('ToSeaOptionBody','/?d=System&c=ComSetting&a=getFrontToSeaOptionBody');
});  
    
function setToSeaTime(did,sid){
    setParam("设置拉取时间段","/?d=System&c=ComSetting&a=showAddToSeaTimeFront&backid="+sid+"&frontid="+did,"/?d=System&c=ComSetting&a=AddToSeaTimeFront&backid="+sid+"&frontid="+did,"ToSeaTimeBody","/?d=System&c=ComSetting&a=getFrontToSeaTimeBody");
}

function setProtectDate(datatype){
    setParam("设置保护时间","/?d=System&c=ComSetting&a=showEditProtectDateFront&datatype="+datatype,"/?d=System&c=ComSetting&a=EditProtectDateFront&datatype="+datatype,'ProtectDateBody','/?d=System&c=ComSetting&a=getFrontProtectDateBody');
}
    
function setAllowCount(datatype){
    setParam("设置个人库容量","/?d=System&c=ComSetting&a=showEditAlowCountFront&datatype="+datatype,"/?d=System&c=ComSetting&a=EditAlowCountFront&datatype="+datatype,'AllowCountBody','/?d=System&c=ComSetting&a=getFrontAllowCountBody');
}
    
function setToSeaOption(did,sid,value){
    setParam("设置踢入公海选项","/?d=System&c=ComSetting&a=showToSeaOptionFront&oldvalue="+value+"&backid="+sid,"/?d=System&c=ComSetting&a=ToSeaOptionFront&backid="+sid+"&frontid="+did,"ToSeaOptionBody","/?d=System&c=ComSetting&a=getFrontToSeaOptionBody");
}
    
function delToSeaTime(did){
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
                            url: '/?d=System&c=ComSetting&a=DelToSeaTimeFront&frontid='+did,
                            success: function (q) {
                                IM.dialog.hide();
                                q=MM.json(q);				
                                if(q.success) {                                    
                                    IM.tip.show(q.msg);
                                    getBody('ToSeaTimeBody','/?d=System&c=ComSetting&a=getFrontToSeaTimeBody');
                                }else{IM.tip.show(q.msg);}
                            }
                        });
                    }
                });
}
         
        
     //显示标题，显示dialog的url，执行操作的url，列表中tbody标签的ID,若flag为0则是DIV的ID。获取列表数据的url,flag判断是加载列表还是直接更新
     function setParam(title,showurl,editurl,listbodyid,listbodyurl){
         IM.dialog.show({
            width: 600,
            height: null,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                MM.get(showurl, {}, function (backData) {
                        $('.DCont')[0].innerHTML = backData;
                        new Reg.vf($('#J_newBankAccount'),{isEncode:false,
                        extValid:{
                            inscope:function(){
                                var scope = $("#scope").attr('scope');
                                var value = $("#scope").val();
                                var arrscope = scope.split(' - ');
                                return (parseInt(arrscope[0]) <= parseInt(value)) && (parseInt(value) <= parseInt(arrscope[1]));
                            }
                        },
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
                                                getBody(listbodyid,listbodyurl);
                                        }else{
                                                IM.tip.warn(q.msg);
                                        }     
                                }                        
                            });
                    }});
            });
      
       }});
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
    
function delToSeaTime(div_id){
    $('#'+div_id).hide();
    var count = $('#addToSeaTimeBtn').attr('count');
    $('.'+div_id).each(function(){
        $(this).val('');
    });
    if(count == 3){
        $('#addToSeaTimeBtn').show();
    }
    $('#addToSeaTimeBtn').attr('count',count - 1);
}
    
function AddToSeaTime(){
    var count = parseInt($('#addToSeaTimeBtn').attr('count'));
    $('#addToSeaTimeBtn').attr('count', count + 1);
    if(count + 1  == 3){
        $('#addToSeaTimeBtn').hide();
    }
    
    if($('#value_div_1').css('display') == 'none'){
        $('#value_div_1').show();
        return false;
    }
    if($('#value_div_2').css('display') == 'none'){
        $('#value_div_2').show();
       return false;
    }
   if($('#value_div_3').css('display') == 'none'){
        $('#value_div_3').show();
        return false;
    }
}
        
    </script> 
{/literal}