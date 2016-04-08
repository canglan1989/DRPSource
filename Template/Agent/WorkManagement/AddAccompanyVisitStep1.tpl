<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>工作管理<span>&gt;</span>添加陪访小记</div>
<!--E crumbs--> 
<div class="form_edit">    	
<div class="form_hd">
    <div class="form_hd_left">
        <div class="form_hd_right">
            <div class="form_hd_mid">
                <h2>添加陪访小记</h2>
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
        	<label><em class="require">*</em>审核通过代理商：</label>
            <div class="inp">
            	<input name="agentId" id="agentId" type="hidden"/>            
            	<input name="tbxAgentName" type="text" id="tbxAgentName" style="width:280px;" size="30" maxlength="32" value="" autocomplete="off"  valid="required"/>
            </div>
            <span class="info">请输入审核通过的代理商</span>
            <span class="ok">&nbsp;</span><span class="err">请输入审核通过的代理商</span>
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
{literal} 
<script language="javascript" type="text/javascript">
new Reg.vf($('#J_addOrder'),{callback:function(data){
	MM.get('/?d=WorkM&c=AccompanyVisit&a=IsExistAgent',data,function(q){
	   if(q=="2"){
	       IM.tip.warn("该代理商不存在，或者还未审核通过！");           
	   }else if(q=="1"){
	       IM.tip.warn("请输入代理商名称");     
	   }else if(q=="0") {
	       JumpPage("/?d=WorkM&c=AccompanyVisit&a=AddAccompanyVisitStep2&"+$('#J_addOrder').serialize());
	   }
	})
}});

$('#tbxAgentName').autocomplete('/?d=WorkM&c=AccompanyVisit&a=CompleteAgentJson', {
    max: 15,
    width: 250,
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
        return "<div id='divUser" + item.id + "'>" + item.name + "</div>";
    }
    }).result(function (data, value) {
    _id = value.id;
    $("#agentId").val(_id);
    var val = $(this).val();
    });
</script>
{/literal}