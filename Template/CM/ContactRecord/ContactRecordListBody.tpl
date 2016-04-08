{foreach from=$arrayData item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowCustomerCard({$data.customer_id})">{$data.customer_name}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.intention_rating_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.create_user_name}</div></td>    
    <td title=""><div class="ui_table_tdcntr">{$data.contact_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.contact_tel}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.contact_mobile}</div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.not_valid_contact_id > 0}
    <span style="color:#EE5F00;">{$data.is_valid_text}</span>
    {else}
    {$data.is_valid_text}
    {/if}
    </div></td>    
    <td title="{$data.contact_recode}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="GetRecordDetail({$data.recode_id})">{$data.contact_recode|truncate:"60":"..."}</a></div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.contact_time}</div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.revisit_uid > 0}
    <a href="javascript:;" onclick="ShowRevisitCard({$data.recode_id})">{$data.revisit_status_text}</a>
    {else}
    {$data.revisit_status_text}
    {/if}
    </div></td>
</tr>
{/foreach}