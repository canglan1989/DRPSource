<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('/?d=Agent&c=Agent&a=showChannelPager')">我的渠道</a><span>&gt;</span>代理商信息</div>
<!--E crumbs--> 
<!--S form_edit-->
<div class="form_edit">
    <div class="form_hd">
        <ul>
            <li> <a href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentinfoAddContact'}&agentId={$agentId}');">
                    <div class="form_hd_left">
                        <div class="form_hd_right">
                            <div class="form_hd_mid">
                                <h2>代理商信息</h2>
                            </div>
                        </div>
                    </div>
                </a> </li>
            <li class="cur">
                <div class="form_hd_left">
                    <div class="form_hd_right">
                        <div class="form_hd_mid">
                            <h2>联系信息</h2>
                        </div>
                    </div>
                </div>
            </li>
            {if $agentId != $objAgentInfo->strAgentNo}
                <li> <a href="javascript:;" onclick="JumpPage('{au d='Agent' c='AgentDoc' a='Detail'}&id={$agentId}');">
                        <div class="form_hd_left">
                            <div class="form_hd_right">
                                <div class="form_hd_mid">
                                    <h2>附件信息</h2>
                                </div>
                            </div>
                        </div>
                    </a> </li>
                {/if}
        </ul>
    </div>
</div>
<!--S form_bd--> 
<div class="form_bd">
    <!--S form_block_bd-->
    <div class="form_block_bd">

        <!--E list_table_main-->

        <!--S list_table_main-->

        <!--E list_table_main-->
        <!--S list_table_head-->

        <!--E list_table_main-->                
        <!--S list_table_head-->
        <div class="list_table_head">
            <div class="list_table_head_right">
                <div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>最新电话联系小记</h4>                            
                    <a class="list_table_refresh" m="pactAgentContact" v="2" ispurview="true" onClick="JumpPage('/?d=Agent&c=Agent&a=phoneAgentContactList&agentId={$agentId}')" href="javascript:;">更多>></a>
                    <a class="ui_button ui_link" href="javascript:;" m="TelTaskManage" v="32" ispurview="true" onClick="JumpPage('{au d="WorkM" c="TelWork" a="showAddTelNote"}&agentid={$agentId}')"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加联系小记</a>
                </div>
            </div>
        </div>
        <!--E list_table_head--> 
        <!--S list_table_main-->
        <div class="list_table_main marginBottom10" id="ContactInfo">
            <div class="ui_table" id="J_ui_table">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead class="ui_table_hd">
                        <tr class="">
                            <th  title="编号"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">编号</div>
                    </div>
                    </th>
                    <th  title="意向等级或签约产品"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">意向等级或签约产品</div>
                    </div>
                    </th>
                    <th  title="被联系人"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">被联系人</div>
                    </div>
                    </th>
                    <th  title="联系电话"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">联系电话</div>
                    </div>
                    </th>
                    <th  title="联系时间"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">联系时间</div>
                    </div>
                    </th>
                    <th  title="操作人"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">操作人</div>
                    </div>
                    </th>
                    <th  title="添加时间"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">添加时间</div>
                    </div>
                    </th>
                    <th  title="联系小记"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">联系小记</div>
                    </div>
                    </th>
                    <th  title="质检结果"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">质检结果</div>
                    </div>
                    </th>
                    </tr>
                    </thead>
                    <tbody class="ui_table_bd">

                        {foreach from=$TelNoteList item=data}
                            <tr class="">
                                <td title="{$data.id}"><div class="ui_table_tdcntr">{$data.id}</div></td>
                                <td title="{if $data.contact_type == 0}{$data.afterlevel}({$data.product_name}){else}{$data.product_name}{/if}"><div class="ui_table_tdcntr">
                                        {if $data.contact_type == 0}
                                            {if $data.afterlevel <= 'B+'}
                                                <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote({$data.id})" >{$data.afterlevel}({$data.product_name})</a>
                                            {else}
                                                {$data.afterlevel}({$data.product_name})
                                            {/if}
                                        {else}
                                            <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote({$data.id})" >{$data.product_name}</a>
                                        {/if}
                                    </div></td>
                                <td title="{$data.visitor}"><div class="ui_table_tdcntr">{$data.visitor}</div></td>
                                <td title="{$data.mobile}/{$data.tel}"><div class="ui_table_tdcntr">{$data.mobile}/{$data.tel}</div></td>
                                <td title="{$data.visit_timestart|date_format:'%Y-%m-%d %H:%M'}"><div class="ui_table_tdcntr">{$data.visit_timestart|date_format:'%Y-%m-%d %H:%M'}</div></td>
                                <td title="{$data.user_name} {$data.e_name}"><div class="ui_table_tdcntr">{$data.user_name} {$data.e_name}</div></td>
                                <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                                <td title="{$data.result}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getTelNoteDetail({$data.id})" >{$data.result}</a></div></td>
                                <td title=""><div class="ui_table_tdcntr">
                                        {if $data.is_vertifyed == 0}
                                            未质检
                                        {else}
                                    {if $data.verfity_status == 0}
                                        <a href="javascript:void(0)" onclick="verfityDetail({$data.id})">不通过</a>
                                        {else}
                                            <a href="javascript:void(0)" onclick="verfityDetail({$data.id})">通过</a>
                                        {/if}
                                {/if}
                            </div></td>
                    </tr>
                {/foreach}
            </tbody>

        </table>
    </div>
    <!--E ui_table--> 
</div>
<!--E list_table_main--> 
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 最新拜访小记</h4>
            <a class="list_table_refresh" m="VisitNote" v="2" ispurview="true" onClick="JumpPage('/?d=WorkM&c=VisitNote&a=NoteList&agent_id={$agentId}')" href="javascript:;">更多>></a> 
            <a class="ui_button ui_link" href="javascript:;" m="VisitAppoint" v="4" ispurview="true"  onClick="JumpPage('/?d=WorkM&c=VisitAppoint&a=showAddVisitInvite&agentid={$agentId}')"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加拜访预约</a> </div>
    </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                    <th width="50" title="编号"> <div class="ui_table_thcntr" sort="sort_visitnoteid">
                <div class="ui_table_thtext">编号</div>
            </div>
            </th>
            <th title="意向评级/签约产品"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">意向评级/签约产品</div>
            </div>
            </th>
            <th title="拜访类型"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">拜访类型</div>
            </div>
            </th>
            <th title="被访人"> <div class="ui_table_thcntr" sort="sort_visitor">
                <div class="ui_table_thtext">被访人</div>
            </div>
            </th>
            <th title="联系电话"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">联系电话</div>
            </div>
            </th>
            <th title="拜访时间"> <div class="ui_table_thcntr " sort="sort_visit_timestart">
                <div class="ui_table_thtext">拜访时间</div>
            </div>
            </th>
            <th width="70" title="操作人"> <div class="ui_table_thcntr" sort="sort_e_name">
                <div class="ui_table_thtext">操作人</div>
            </div>
            </th>
            <th width="" title="操作时间"> <div class="ui_table_thcntr" sort="sort_create_time">
                <div class="ui_table_thtext">操作时间</div>
            </div>
            </th>
            <th title="拜访计划"> <div class="ui_table_thcntr " sort="sort_title">
                <div class="ui_table_thtext">拜访计划</div>
            </div>
            </th>
            <th title="拜访结果"> <div class="ui_table_thcntr " sort="sort_result">
                <div class="ui_table_thtext">拜访结果</div>
            </div>
            </th>
            <th title="批示内容"> <div class="ui_table_thcntr " sort="sort_check_status" >
                <div class="ui_table_thtext">批示内容</div>
            </div>
            </th>
            <th width="100"  title="质检结果"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">质检结果</div>
            </div>
            </th>
            </tr>
            </thead>
            <tbody class="ui_table_bd" id="pageListContent">

                {foreach from=$VisitNoteList item=data key=index}
                    <tr class="">
                        <td title="{$data.id}"><div class="ui_table_tdcntr">{$data.id}</div></td>
                        <td title="{if $data.contact_type == 0}{$data.afterlevel}({$data.product_name}){else}{$data.product_name}{/if}"><div class="ui_table_tdcntr">
                                        {if $data.contact_type == 0}
                                            {if $data.afterlevel <= 'B+'}
                                                <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote({$data.id})" >{$data.afterlevel}({$data.product_name})</a>
                                            {else}
                                                {$data.afterlevel}({$data.product_name})
                                            {/if}
                                        {else}
                                            {if $data.visit_type == 2}
                                                {$data.product_name}
                                            {else}
                                                <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote({$data.id})" >{$data.product_name}</a>
                                            {/if}
                                        {/if}
                    </div></td>
                <td title="{if $data.visit_type == 2}培训{else}沟通{/if}"><div class="ui_table_tdcntr">
                {if $data.visit_type == 2}培训{else}沟通{/if}
        </div></td>
    <td title="{$data.visitor}"><div class="ui_table_tdcntr">{$data.visitor}</div></td>
    <td title="{$data.mobile}/{$data.tel}"><div class="ui_table_tdcntr">{$data.mobile}/{$data.tel}</div></td>
    <td title=""><div class="ui_table_tdcntr">
            {$data.visit_timestart|date_format:'%Y-%m-%d %H:%M'}~ {$data.visit_timeend|date_format:'%H:%M'}
        </div></td>
    <td title="{$data.user_name} {$data.e_name}"><div class="ui_table_tdcntr">{$data.user_name} {$data.e_name}</div></td>
    <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td title="{$data.visit_content}"><div class="ui_table_tdcntr">{$data.visit_content}</div></td>
    <td title="{$data.result}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getVisitNoteDetail({$data.id})">{$data.result}</a></div></td>
    <td title="{if $data.is_vertifyed == 3}{$data.instruction}
        {elseif $data.is_vertifyed == 4}已审阅{else}未批示{/if}}"><div class="ui_table_tdcntr">
                        {if $data.is_vertifyed == 3}<a href="javascript:void(0)" onclick="inDetail({$data.id})">{$data.instruction}</a>
                {elseif $data.is_vertifyed == 4}已审阅{else}未批示{/if}
            </div></td>
        <td title=""><div class="ui_table_tdcntr">
                {if $data.is_vertifyed == 0}
                    未质检
                {else}
            {if $data.verfity_status == 0}
                <a href="javascript:void(0)" onclick="verfityDetail({$data.id})">不通过</a>
                {else}
                    <a href="javascript:void(0)" onclick="verfityDetail({$data.id})">通过</a>
                {/if}
        {/if}
    </div></td>
</tr>
{/foreach}
</tbody>

</table>
</div>
<!--E ui_table--> 
</div>
</div>
</div>
<script language="javascript" type="text/javascript">
    {literal}
        $.setPurview();
new Reg.vf($('#J_newLXXiaoJi'),{callback:function(data){
	if(IM.checkPhone()){IM.tip.warn('手机或固话必填一项');return false;}
	if(!IM.IsSending(true)){return false;};
		$.ajax({
			type:'POST',
			data:$('#J_newLXXiaoJi').serialize(),
    {/literal}
			url:'{au d="Agent" c="Agent" a="AddContactInfo"}',
    {literal}
			success:function(data){
			IM.IsSending(false);
				switch(data)
				{
					case '1':
						IM.tip.show('代理商联系小记添加成功！');
						window.location.reload();
						break;
					case '2':
						IM.tip.warn('非法参数，请检查！');
						break;
					case '3':
						IM.tip.warn('联系人信息不能为空！');
						break;
					case '4':
						IM.tip.warn('手机号码不能为空！');
						break;
					default:
						IM.tip.warn('代理商联系小记添加失败！');
						break;
				}
			}
		});
	}
});
function showAddContactInfo(agent_id,isPact){
    IM.dialog.show({
            width:650,
            height:null,
            title:'添加联系小记',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=Agent&c=Agent&a=showAddContactInfo&agent_id="+agent_id+"&isPact="+isPact));
            }
         })
}
    
    //质检结果卡片
function verfityDetail(noteId)
{
     IM.dialog.show({
            width:400,           
            title:'拜访小记质检信息',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=WorkM&c=VisitNote&a=showVerifyInfo&noteId="+noteId,""));
            }
         });
}
//批示内容卡片
function inDetail(noteId)
{
     IM.dialog.show({
            width:400,           
            title:'拜访小记领导批示信息',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont').html($PostData("/?d=WorkM&c=VisitNote&a=showInstructionInfo&noteId="+noteId,""));
            }
         });
}
    {/literal}
</script>