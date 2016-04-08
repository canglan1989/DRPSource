   	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：渠道区域设置<span>&gt;</span>
        <a href="javascript:;" onclick="PageBack()">区域列表</a><span>&gt;</span>{$strTitle}</div>
        <!--E crumbs-->   
        <!--S form_edit-->
        <div class="form_edit">
            <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>{$strTitle}</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
            </div>
            <!--S form_bd-->
            <div class="form_bd">
              <!--S form_block_bd-->
              <div class="form_block_bd addGroupCont">        
                <form id="J_addGroup" action="" name="addGroupForm" class="addGroupForm">
                        <div class="tf">
                        	<label><em class="require">*</em>区域名称：</label>
                            <div class="inp"><input type="text" name="tbxGroupName" id="tbxGroupName" valid="required tbxGroupName" value="{$objAreaGroupInfo->strAgroupName}" maxlength="20" /></div>
                            <span class="info">请输入正确区域名称</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入正确区域名称</span>
                        </div> 
                        <div class="tf">
                           <label>备注：</label>
                           <div class="inp"><textarea name="tbxRemark" cols="50" id="tbxRemark">{$objAreaGroupInfo->strAgroupRemark}</textarea></div>
                        </div> 
                        <div class="tf">                        	
                        	<label><em class="require">*</em>地区范围：</label>
                            <div class="inp">
				
                            	<div id="agentAreaResult" class="agentAreaResult" {if $iAgroupID <= 0} style="display:none" {/if}></div>                            	
				<div class="ui_button areaTrigger_button" onclick="IM.area.toggle(this)"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">选择地区</div></div></div>
                                <!--S agentArea-->
                            	<div class="agentArea agentAreaBlock">
				<div class="hd_agentA"><h4>地区范围</h4><a href="javascript:;" onclick="IM.area.hide(this)">关闭</a></div>
                                    <div class="bd_agentA">
                                    	<div class="areaLeft">
                                        	<h4>可选地区</h4>
                                            <div class="AllArea">
                                            	<ul id="J_allArea" class="treeview">
                                                {$areaHTML}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="areaMid">                                            
			                   <div class="ui_button" onclick="IM.area.addArea('#J_allArea','.SelectArea')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">添加&gt;&gt;</div></div></div>
			                   <div class="ui_button ui_button_dis" onclick="IM.area.moveArea('.SelectArea','#J_allArea')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">&lt;&lt;移除</div></div></div>
                                        </div>
                                        <div class="areaRight">
                                        	<h4>已选择地区</h4>
                                            <select class="SelectArea" ondblclick="IM.area.moveArea('.SelectArea','#J_allArea')" size="15" name="SelectArea"></select>
                                        </div>
                                    </div>
                                    <div class="ft_agentA">                                    	
					<div class="ui_button" onclick="IM.area.okArea(this)" style="margin-right:10px;"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">确定</div></div></div>
		                        <div class="ui_button ui_button_dis" onclick="IM.area.hide(this)"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">取消</div></div></div>      
                                    </div>                                    
                                </div>
                                <!--E agentArea--> 
                                <input id="J_region" type="hidden" value="" name="region" valid="required"/>
                    		</div>
                            <span class="info">请选择地区范围</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择地区范围</span>
                        </div>
			<div class="tf tf_submit">
                        	<label>&nbsp;</label>
                            <div class="inp">
                                <div class="ui_button ui_button_confirm">
                                <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
                                </div>
                                <div class="ui_button ui_button_cancel">
                                <a class="ui_button_inner" onclick="JumpPage('/?d=System&c=AreaSet&a=GroupList')" href="javascript:;">返 回</a>
                                </div>
			</div>
                        </div>
                </form>
                </div>
 		</div>
        </div>
{literal} 
<script type="text/javascript">
(function(){
    {/literal}
    var strGroupAreaJson = "{$groupAreaJson}";    
    {literal}
    if(strGroupAreaJson.length > 1)
    {
        var areaJson = eval("("+strGroupAreaJson+")");
       	var strHtml = "";
        var jsonObjLength = areaJson.length;
        var areaIDs = "";
        var areaID = "";
        var selectAreaObj = $(".SelectArea")[0];
        
        for (var i = 0; i < jsonObjLength; i++) {
            strHtml += "<div class='agentAreaResultWrap'><div class='agentAreaResultItem'><em>"+areaJson[i].fullName+"</em>";
            strHtml += "<a class='resultClose' onclick='IM.area.hideAreaResult(this)' rel='";
            areaID = (areaJson[i].dataType == "province" ? "p_" :(areaJson[i].dataType == "city" ? "c_" : "a_"))+areaJson[i].id;
    
            strHtml += areaID+"' href='javascript:;'>关闭</a></div></div>";        
            areaIDs += ","+areaID;
            
            selectAreaObj[i] = new Option(areaJson[i].fullName,areaID);
        }
        areaIDs = areaIDs.substring(1);
    
        $("#J_region").val(areaIDs);
        $("#agentAreaResult").html(strHtml);
    }
    
    /*===========================================*/
		var J_allArea=$("#J_allArea");
		J_allArea.treeview();
		J_allArea.unbind('click').bind('click',function(e){
			var target=MM.E(e).target;
	        if(target.tagName=='A'){
	            $(target).parents(".treeview2").find('a').removeClass('cur');
				$(target).toggleClass('cur');
	        }
		}).unbind('dblclick').bind('dblclick',function(e){
			var target=MM.E(e).target;
			if(target.tagName=='A')
			IM.area.addArea('#J_allArea','.SelectArea')
		});
})();    
new Reg.vf($('#J_addGroup'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
    {/literal}
    var formdata = "id={$iAgroupID}&tbxGroupName="+$("#tbxGroupName").val()+"&tbxRemark="+$("#tbxRemark").val()+"&region="+$("#J_region").val();
    {literal}
    MM.Extend(formdata,{'r':MM.Random(1000)});
    //alert(formdata);
    MM.ajax({
	url:'/?d=System&c=AreaSet&a=GroupModifySubmit',
	data:formdata,
	success:function(q){
		if(q ==0){
	        JumpPage("/?d=System&c=AreaSet&a=GroupList");
	    }
	    else{
	        JumpPage("/?d=System&c=AreaSet&a=GroupList");
            IM.tip.warn(q);
	    }
	}
	});
    
}});
</script>
{/literal} 