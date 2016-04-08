{foreach from=$arrayData item=data key=index}
    <tr>
        <td title="{$data.user_name}"><div class="ui_table_tdcntr">{$data.user_name}</div></td>
        <td title="{$data.contact_name}"><div class="ui_table_tdcntr">{$data.contact_name}</div></td>                                 
        <td title="{$data.contact_mobile}/{$data.contact_tel}"><div class="ui_table_tdcntr">{if $data.contact_mobile eq ''}
                                                                                                    {$data.contact_tel}
                                                                                                {elseif $data.contact_tel eq ''}
                                                                                                    {$data.contact_mobile}
                                                                                                {else}
                                                                                                    {$data.contact_mobile}/{$data.contact_tel}
                                                                                                {/if}</div></td>                                    
        <td title="{$data.contact_time}"><div class="ui_table_tdcntr">{$data.contact_time}</div></td>
                                    <td title="{$data.contact_recode}"><div class="ui_table_tdcntr">{$data.contact_recode|truncate:"15":"..."}</div></td> 
                                    <td title="{$data.intention_rating_name}"><div class="ui_table_tdcntr">{$data.intention_rating_name}</div></td>                                    
    </tr>
   
{/foreach}