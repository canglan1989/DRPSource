{foreach from=$arrayData item=arrcheckList}
<tr>
    <td title=""><div class="ui_table_tdcntr">{if $arrcheckList.channel_uid neq $userID and $arrcheckList.share_uid eq $userID}
    {else}
    <input class="checkInp" type="checkbox" name="listid" value="{$arrcheckList.agent_id}"/>{/if}
    </div></td>
    <td title="{$arrcheckList.agent_no}"><div class="ui_table_tdcntr">{$arrcheckList.agent_no}</div></td>
    <td title="{$arrcheckList.agent_name}"><div class="ui_table_tdcntr"><a onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentinfoAddContact'}&agentId={$arrcheckList.agent_id}&checkStatus={$arrcheckList.is_check}&needCheck=yes&isPact=no');" href="javascript:;">{$arrcheckList.agent_name}</a>
    {if $arrcheckList.share_uid neq '' }<span style="color:red;">(享)</span>{/if}
    </div></td>   
    <td title="{$arrcheckList.agent_reg_area_full_name}"><div class="ui_table_tdcntr">{$arrcheckList.agent_reg_area_full_name}</div></td>   
    <td title="{$arrcheckList.industry}"><div class="ui_table_tdcntr">{$arrcheckList.industry}</div></td>   
    <td title="{if $arrcheckList.agent_from eq 0}自录{elseif $arrcheckList.agent_from eq 1}拉取{elseif $arrcheckList.agent_from eq 2}共享{else}被转入{/if}"><div class="ui_table_tdcntr">
        {if $arrcheckList.agent_from eq 0}自录{elseif $arrcheckList.agent_from eq 1}拉取{elseif $arrcheckList.agent_from eq 2}共享{else}被转入{/if}
    </div></td>                            
    <td title="{$arrcheckList.inten_level}"><div class="ui_table_tdcntr">
     {if $arrcheckList.inten_level <= 'B+'}
            <a href="javascript:void(0)" onclick="getExpectInfo({$arrcheckList.agent_id})" >{$arrcheckList.inten_level}</a>
        {else}
            {$arrcheckList.inten_level}
        {/if}
      
      
     </div></td>   
    <td title="{$arrcheckList.share_ename}"><div class="ui_table_tdcntr">{$arrcheckList.share_ename}{$arrcheckList.share_username}</div></td>                                      
    <td title="{$arrcheckList.expect_type}"><div class="ui_table_tdcntr">{if $arrcheckList.expect_type eq 1}承诺{elseif $arrcheckList.expect_type eq 2}备份{/if}</div></td>
    <td title="{$arrcheckList.contactOldNum}"><div class="ui_table_tdcntr">
           {if $arrcheckList.contactOldNum>= 40}
           <span style="color:red;">{$arrcheckList.contactOldNum}</span>
           {else}{$arrcheckList.contactOldNum}{/if}
    </div></td>
    <td title="{$arrcheckList.bAddOldNum}"><div class="ui_table_tdcntr">{$arrcheckList.bAddOldNum}</div></td>
    <td title="{$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}"><div class="ui_table_tdcntr">{$arrcheckList.charge_phone}/{$arrcheckList.charge_tel}</div></td>
    <td><div class="ui_table_tdcntr">{$arrcheckList.last_time}{if $arrcheckList.last_type neq '' }({if $arrcheckList.last_type eq 0 }拜访{else}电话{/if}){/if}</td>
    <td ><div class="ui_table_tdcntr">
         {if $arrcheckList.last_type eq 0}
         <a href="javascript:void(0)" onclick="getVisitNoteDetail({$arrcheckList.note_id})">{$arrcheckList.last_content}</a>
         {else}
         <a href="javascript:void(0)" onclick="getTelNoteDetail({$arrcheckList.note_id})" >{$arrcheckList.last_content}</a>
         {/if}
    </div></td>

    
    <td>
        <div class="ui_table_tdcntr">
            <ul class="list_table_operation">
               
                <li><a m="TelTaskManage" v="4" ispurview="true" href="javascript:void(0);" onclick="JumpPage('{au d="WorkM" c="TelWork" a="showAddTelInvite"}&agentid={$arrcheckList.agent_id}')">设置电话任务</a></li>
                <li><a onclick="JumpPage('/?d=WorkM&c=TelWork&a=showAddTelNote&agentid={$arrcheckList.agent_id}')" ispurview="true" v="32" m="TelTaskManage" href="javascript:;">添加联系小记</a></li>
                <li><a onclick="JumpPage('/?d=WorkM&c=VisitAppoint&a=showAddVisitInvite&agentid={$arrcheckList.agent_id}')" m="VisitAppoint" v="32" ispurview="true" href="javascript:;">添加拜访预约</a></li>
                {if $arrcheckList.channel_uid eq $userID and $arrcheckList.share_uid eq '' and ($arrcheckList.inten_level eq 'B+' or $arrcheckList.inten_level eq 'A') and ($arrcheckList.check_status eq ''or $arrcheckList.check_status>0) and $arrcheckList.passVerify eq 1}
                <li><a  href="javascript:;" onClick="setShare({$arrcheckList.agent_id})">共享</a></li>              
                {/if}
                
                {if $arrcheckList.channel_uid neq $userID and $arrcheckList.share_uid eq $userID}
                <li><a  href="javascript:;" onClick="cancelShare({$arrcheckList.agent_id})">取消共享</a></li>
                {/if}
            </ul>
        </div>
    </td>
</tr>
{/foreach}