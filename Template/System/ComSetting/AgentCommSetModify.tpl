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
    <div class="form_block_hd">
      <h3 class="ui_title">个人库数量限制</h3>(0表示不限制)
    </div>
    <div class="form_block_bd">
      <div class="list_table_main marginBottom10 agentInfoToggle">
        <div class="ui_table ui_table_nohead">
          <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead class="ui_table_hd">
              <tr class="">
                <th style="width:125px;" title="角色组"> <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">角色组</div>
                  </div>
                </th>
                <th style="width:100px;" title="数量"> <div class="ui_table_thcntr">
                    <div class="ui_table_thtext">数量</div>
                  </div>
                </th>
                <th style="width:200px;" title="操作"> <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">操作</div>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody class="ui_table_bd">            
            {foreach from=$arrayAgentCountLimit item=data key=index}
            <tr class="">
              <td title=""><div class="ui_table_tdcntr">{$data.remark}</div></td>
              <td title=""><div class="ui_table_tdcntr" id="divCount_{$data.data_type}">{$data.setting_value}</div></td>
              <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="AgentCountLimit('{$data.data_type}')">编辑</a></div></td>
            </tr>
            {/foreach}
              </tbody>            
          </table>
        </div>
      </div>
    </div>
    <div class="form_block_hd">
      <h3 class="ui_title">联系小记内容设置</h3>
      <a class="ui_button ui_link" onclick="AgentContactContent(0)"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加内容</a>
    </div>
    <div class="form_block_bd">
      <div class="list_table_main marginBottom10 agentInfoToggle">
        <div class="ui_table ui_table_nohead">
          <table border="0" cellpadding="0" id="t_ContactContent" cellspacing="0" width="100%">
            <thead class="ui_table_hd">
              <tr class="">
                <th style="" title="内容选项"> <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">内容选项</div>
                  </div>
                </th>
                <th style="" title="显示顺序"> <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">显示顺序</div>
                  </div>
                </th>
                <th style="width:200px;" title="操作"> <div class="ui_table_thcntr ">
                    <div class="ui_table_thtext">操作</div>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody class="ui_table_bd" id="tbody_ContactConten">            
            {foreach from=$arrayAgentContactContent item=data key=index}
            <tr id="tr_Content_{$data.c_id}" class="">
              <td title=""><div class="ui_table_tdcntr" id="divContent_{$data.c_id}">{$data.c_value}</div></td>
              <td title=""><div class="ui_table_tdcntr" id="divContent_s_{$data.c_id}">{$data.sort_index}</div></td>
              <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="AgentContactContent({$data.c_id})">编辑</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="AgentContactContentDel({$data.c_id})">删除</a></div></td>
            </tr>
            {/foreach}
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
<script language="javascript" type="text/javascript">
$(function(){
    
});   
    
_InDealWith = false;   
function AgentCountLimit(no)
{    
    var count = $("#divCount_"+no).html();
    IM.dialog.show({
        width: 400,
	    height: null,
	    title: '个人库数量限制',
	    html: IM.STATIC.LOADING,
        start:function(){
            $('.DCont')[0].innerHTML= '<div class="DContInner setPWDComfireCont"><form id="J_backForm_Count" name="J_backForm_Count">'
                +'<div class="bd"><div class="tf"><label>限制数：</label><div class="inp"><input type="text" id="tbxCount" name="tbxCount" onkeydown="return NumberOnly(event)" style="text-align:right;width:100px" maxlength="3" value="'+count+'" valid="required amount"/>'
                +'</div><span class="info">请输入数量</span><span class="ok">&nbsp;</span><span class="err">请输入数量</span></div></div><div class="ft"><div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>'
                +'<div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div></div></form></div>';
       
            new Reg.vf($('#J_backForm_Count'),{callback:function(formData){
            	if (_InDealWith) 
            	{
            		IM.tip.warn("数据已提交，正在处理中！");
            		return false;
            	}
                
                formData = "no="+no+"&"+$("#J_backForm_Count").serialize();
                _InDealWith = true;                    
                var backData = $PostData('/?d=System&c=AgentCommSet&a=AgentCountLimitSubmit',formData);       
			    _InDealWith = false;             
                if(parseInt(backData) == 0){
                    $("#divCount_"+no).html($("#tbxCount").val());
			        IM.dialog.hide();	
                    IM.tip.show("编辑成功！");                        
				}else{
                    IM.tip.warn(backData);
				}
            }}); 
        }
    });
}


function AgentContactContent(id)
{
    var content = "";
    var rIndex = -1;
    
    if(id > 0)
    {
        content = $("#divContent_"+id).html();
        rIndex = $("#divContent_s_"+id).html();        
    }        
        
    if(rIndex < 0)
    {
        var tab = document.getElementById("t_ContactContent");
        rIndex = tab.rows.length ;
    }
    
    IM.dialog.show({
        width: 580,
	    height: null,
	    title: '联系小记内容设置',
	    html: IM.STATIC.LOADING,
        start:function(){
            $('.DCont')[0].innerHTML= '<div class="DContInner setPWDComfireCont"><form id="J_backForm_Content" name="J_backForm_Content">'
                +'<div class="bd"><div class="tf"><label>小记内容：</label><div class="inp"><input name="tbxContent" type="text" id="tbxContent" style="width:300px" value="'+content+'" size="50" maxlength="50" valid="required"/>'
                +'</div><span class="info">请输入内容</span><span class="ok">&nbsp;</span><span class="err">请输入内容</span></div>'
                +'<div class="tf"><label>显示顺序：</label><div class="inp"><input name="tbxSortIndex" type="text" id="tbxSortIndex" value="'+rIndex+'" size="10" maxlength="5" onkeydown="return NumberOnly(event)" style="text-align:right;width:100px" valid="required"/></div>'
                +'<span class="info">请输入显示顺序</span><span class="ok">&nbsp;</span><span class="err">请输入显示顺序</span></div>'
                +'</div><div class="ft"><div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>'
                +'<div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div></div></form></div>';
       
            new Reg.vf($('#J_backForm_Content'),{callback:function(formData){
            	if (_InDealWith) 
            	{
            		IM.tip.warn("数据已提交，正在处理中！");
            		return false;
            	}
                
                formData = "id="+id+"&"+$("#J_backForm_Content").serialize();
                _InDealWith = true;                    
                var backData = $PostData('/?d=System&c=AgentCommSet&a=AgentContactContentSubmit',formData);       
			    _InDealWith = false;             
                if(backData.indexOf("0,") == 0){
                    if(parseInt(id) == 0)
                    {
                        id = backData.split(",")[1];
                        IM.tip.show("添加成功！");
                        var insertHTML = '<tr id="tr_Content_'+id+'" class=""><td title=""><div class="ui_table_tdcntr" id="divContent_'+id+'">'+$("#tbxContent").val()+'</div></td>'
                            +'<td title=""><div class="ui_table_tdcntr" id="divContent_s_'+id+'">'+$("#tbxSortIndex").val()+'</div></td>'
                              +'<td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="AgentContactContent('+id+')">编辑</a>'
                              +'&nbsp;&nbsp;<a href="javascript:void(0)" onclick="AgentContactContentDel('+id+','+$("#tbxSortIndex").val()+')">删除</a></div></td></tr>';
                        $("#tbody_ContactConten").append(insertHTML);
                    }                        
                    else
                    {
                        $("#divContent_"+id).html($("#tbxContent").val());
                        $("#divContent_s_"+id).html($("#tbxSortIndex").val());
                        
                        IM.tip.show("编辑成功！");
                    }
			        IM.dialog.hide();
				}else{
                    IM.tip.warn(backData);
				}
            }}); 
        }
    });
    
}

function AgentContactContentDel(id)
{
    IM.dialog.show({
        width:300,
        title:'删除操作',
        html:'<div class="DContInner">' +
        '<div class="bd"><h4>您确定要删除所选项码？</h4></div>' +
        '<div class="ft">' +
        '<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>' +
        '<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" onclick="IM.dialog.ok()">确定</button></div>' +
        '</div></div>',
        ok:function(){
            var backData = $PostData('/?d=System&c=AgentCommSet&a=AgentContactContentDel',"id="+id);  
                if(parseInt(backData) == 0)
                {
                    $("#tr_Content_"+id).remove();
                    IM.tip.show("删除成功！");
			        IM.dialog.hide();
                }
                else
                {
                    IM.tip.show(backData);
                }
        }
    });
}
</script> 
{/literal}