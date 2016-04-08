<?php /* Smarty version 2.6.26, created on 2012-11-26 14:48:12
         compiled from Agent/WorkManagement/AppointModifyStep1.tpl */ ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>工作管理<span>&gt;</span>添加拜访预约</div>
<!--E crumbs--> 
<div class="form_edit">    	
<div class="form_hd">
    <div class="form_hd_left">
        <div class="form_hd_right">
            <div class="form_hd_mid">
                <h2>添加拜访预约</h2>
            </div>
        </div>
    </div>
    <span class="declare">
    “<em class="require">*</em>”为必填信息
    </span>
</div>
<div class="form_bd">
	<form id="J_addOrder">
        <div class="tf" style="padding-top:20px;">
        	<label><em class="require">*</em>关联代理商：</label>
            <div class="inp">
            	<input name="agentId" id="agentId" type="hidden"/>            
            	<input name="tbxAgentName" type="text" id="tbxAgentName" style="width:280px;" size="30" maxlength="32" value="" autocomplete="off"  valid="required"/>
            </div>
            <span class="info">请输入代理商名称</span>
            <span class="ok">&nbsp;</span><span class="err">请输入代理商名称</span>
        </div>  
        <div class="tf tf_submit" style="padding:20px 0;">
           <label>&nbsp;</label>
            <div class="inp">
	    <div class="ui_button"><div class="ui_button_left"></div><button class="ui_button_inner" type="submit">下一步</button></div>
            <div class="ui_button ui_button_cancel">
                <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a>
            </div>
            </div>
        </div>
    </form>                             
</div> 
</div>
<!--E sidenav_neighbour--> 
<?php echo ' 
<script language="javascript" type="text/javascript">
new Reg.vf($(\'#J_addOrder\'),{callback:function(data){
	MM.get(\'/?d=WorkM&c=VisitAppoint&a=CheckAgent\',data,function(q){
	   if(q=="2"){
	       IM.tip.warn("该代理商不属于您的保护对象，请仔细核对 ！");           
	   }else if(q=="1"){
	       IM.tip.warn("请输入代理商名称");     
	   }else if(q=="0") {
           MM.get("/?d=WorkM&c=VisitAppoint&a=AppointModifyStep2",data,function(q){
                $(\'#mainContent\').html(q);
           });
	   }
	})
}});
$(\'#tbxAgentName\').autocomplete(\'/?d=WorkM&c=VisitAppoint&a=CompleteAgentJson\', {
    max: 15,
    width: 280,
    parse: function (Data) {
        var parsed = [];
        if (Data == "" || Data.length == 0)
            return parsed;
        Data = MM.json(Data);
        var value = Data.value;
        if (value == undefined)
            return parsed;

        for (var i = 0; i < value.length; i++) {
            parsed[parsed.length] = {
                data: value[i],
                value: value[i].id,
                result: value[i].name
            }
        }
        return parsed;
    },
    formatItem: function (item){
        return "<div id=\'divUser" + item.id + "\'>" + item.name + "</div>";
    }
    }).result(function (data, value) {
    _id = value.id;
    $("#agentId").val(_id);
    var val = $(this).val();
    });
</script>
'; ?>