{foreach from=$arrayData item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td title="">
        <div class="ui_table_tdcntr">
        {if $data.create_uid <= 0 && $data.invite_status != "1"}
            <input class="checkInp" type="checkbox" name="listid" value="{$data.recode_id}"/>
        {/if}
        </div>
    </td>
    <td><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowCustomerCard({$data.customer_id})">{$data.customer_name}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.invite_contact_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.invite_contact_tel}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.invite_contact_mobile}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.invite_time}</div></td>    
    <td title=""><div class="ui_table_tdcntr">
    {if $data.invite_status == -1}
    <span style="color:#EE5F00;">{$data.invite_status_text}</span>
    {elseif $data.invite_status == 1}
    <a href="javascript:void(0)" onclick="GetRecordDetail({$data.recode_id});"><span style="color:#028100;">{$data.invite_status_text}</span></a>
    {else}
    {$data.invite_status_text}
    {/if}
    </div></td>    
    <td title=""><div class="ui_table_tdcntr">{$data.invite_create_time}</div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.revisit_uid > 0}
    <a href="javascript:;" onclick="ShowRevisitCard({$data.recode_id})">{$data.revisit_status_text}</a>
    {else}
    {$data.revisit_status_text}
    {/if}
    </div></td>
    <td><div class="ui_table_tdcntr">        
            <ul class="list_table_operation">
                {if $data.create_uid <= 0 && $data.invite_status == 0}
                <li><a m="ContactRecordList" ispurview="true" v="4" href="javascript:;" 
                    onclick="JumpPage('/?d=CM&c=ContactRecord&a=ContactRecodeModify&inviteID={$data.recode_id}')">添加联系小记</a></li>                    
                <li><a m="ContactInviteList" ispurview="true" v="4" href="javascript:;" onclick="DropInvite({$data.recode_id})">作废</a></li>
                <li><a m="ContactInviteList" ispurview="true" v="4" href="javascript:;" onclick="EditInvite({$data.recode_id})">编辑预约</a></li>                
                {/if}
          </ul>
          
        </div>
      </td>
</tr>
{/foreach}