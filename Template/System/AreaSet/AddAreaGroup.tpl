   	<!--S crumbs-->
    	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：区域组管理<span>&gt;</span>
        <a href="javascript:;" onclick="PageBack()">区域组列表</a><span>&gt;</span>{$strTitle}</div>
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
                <form id="J_addGroup">
                        <div class="tf">
                        	<label><em class="require">*</em>区域名称：</label>
                            <div class="inp"><input type="text" name="tbxGroupName" id="tbxGroupName" valid="required tbxGroupName" value="{$objAreaGroup->strAgroupName}" maxlength="20" /></div>
                            <span class="info">请输入正确区域名称</span>
                            <span class="ok">&nbsp;</span><span class="err">请输入正确区域名称</span>
                        </div> 
                        <div class="tf">
                        <label>上级区域组：</label>
                        <div class="inp">
                        {if $id>0}
                        {if $SupGroupId!=""}
                        {$agroup_name}
                          {else}无
                        {/if}
                        {elseif $supid > 0}
                        {$self_name}
                        <input type="hidden" id="cbSupAreaGroup" name="cbSupAreaGroup" value="{$supid}"/>
                        {else}
                        无
                        {/if} 
                        </div>
                      </div>
                        <div class="tf">
                           <label>备注：</label>
                           <textarea name="tbxRemark" cols="50" id="tbxRemark">{$objAreaGroup->strAgroupRemark}</textarea>
                        </div> 
                        <div class="tf">
                        	<label><em class="require">*</em>地区范围：</label>
                            <div class="inp">
                                <!--S agentArea-->
                            	<div class="agentArea agentAreaBlock" style="display:block;">
                                	<div class="hd_agentA"><h4>地区范围</h4> <em style="color:#999">(双击可选取)</em></div>
                                    <div class="bd_agentA">
                                    	<div class="areaLeft">
                                        	<h4>可选地区</h4>
                                        	<div class="loading" style="display:none"></div>
                                            <div class="AllArea">
                                            	<ul id="J_allArea" class="treeview2">
                                                {if $supid > 0}
                                                {$haveSup_areaHTML}
                                                {else}
                                                {$areaHTML}
                                                {/if}
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="areaMid">                                            
					                   		<div class="ui_button" onclick="IM.setArea.add('.treeview2')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">添加&gt;&gt;</div></div></div>
					                   		<div class="ui_button ui_button_dis" onclick="IM.setArea.del('.treeview2')"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text">&lt;&lt;移除</div></div></div>
                                        </div>
                                        <div class="areaRight">
                                        	<h4>已选择地区</h4>
                                            <div class="AllArea">
	                                            <ul id="Selected" class="treeview2">
	                                                {$groupAreaHTML}
	                                            </ul>
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                                <!--E agentArea-->                                
                    		</div>
                            <span class="info">请选择地区范围</span>
                            <span class="ok">&nbsp;</span><span class="err">请选择地区范围</span>
                        </div>
            			<div class="tf tf_submit">
                        	<label>
                                <input id="J_region" type="hidden" value="{$areaIDs}" name="region" valid="required"/> &nbsp;</label>
                            <div class="inp">
                                <div class="ui_button ui_button_confirm">
                                <button id="butOk" class="ui_button_inner" type="submit">确 定</button>
                                </div>
                                <div class="ui_button ui_button_cancel">
                                <a class="ui_button_inner" onclick="JumpPage('/?d=System&c=AreaGroupSet&a=GroupList')" href="javascript:;">返 回</a>
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
    var strGroupAreaJson = "{$groupAreaJson}";  //区域组已关联区域的信息
    var supId = "{$SupGroupId}";
    
    {literal}
    //var agroup_id = $("#cbSupAreaGroup").val();
    //var areaHTML = $PostData("/?d=System&c=AreaGroupSet&a=GetSupGroupAreaHtml","agroup_id="+agroup_id);//显示在可选区域
    //$("#J_allArea").html(areaHTML);//可选地区范围J_allArea
  
})(); 
function addTreeEventHandler(){
	var J_allArea=$(".treeview2");
	J_allArea.treeview2();
	J_allArea.unbind('click').bind('click',function(e){
                        var target=MM.E(e).target;
                        if(target.tagName=='A'){
                            $(target).parents(".treeview2").find('a').removeClass('cur');
							$(target).toggleClass('cur');
                        }
	}).unbind('dblclick').bind('dblclick',function(e){
		var target=MM.E(e).target;
		if(target.tagName=='A') IM.setArea.add('.treeview2',target);
	});
}
addTreeEventHandler();


new Reg.vf($('#J_addGroup'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式	
    {/literal}
    var aroupid = "{$id}";
    var supid = "{$supid}";
    var cbSupAreaGroup = $("#cbSupAreaGroup").val();
   {literal}
   
    if(aroupid > 0&&supid <= 0)
        MM.Extend(formdata,{'id':aroupid});
    else if(supid > 0)
        MM.Extend(formdata,{'id':aroupid,'cbSupAreaGroup':cbSupAreaGroup});
    MM.ajax({
		url:'/?d=System&c=AreaGroupSet&a=AreaGroupModifySubmit',
		data:formdata,
		success:function(q){
			q=MM.json(q);			
			if(q.success){
				JumpPage("/?d=System&c=AreaGroupSet&a=GroupList");
				IM.tip.show(q.msg);
				IM.dialog.hide();
			}else{
				IM.tip.warn(q.msg);				
			}                                      
	    }	
	});    
}});

</script>
{/literal} 


