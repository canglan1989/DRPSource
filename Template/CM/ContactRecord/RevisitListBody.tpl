{foreach from=$arrayData item=data key=index}
  <tr class="{sdrclass rIndex=$index}">
    <td><div class="ui_table_tdcntr">{$data.customer_id}</div></td>
    <td title="{$data.customer_name}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="ShowCustomerCard({$data.customer_id})">{$data.customer_name}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.intention_rating_name}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.is_visit_text}</div></td>  
    <td title=""><div class="ui_table_tdcntr">{$data.contact_name}</div></td>   
    <td title=""><div class="ui_table_tdcntr">{$data.contact_tel}<br/>
    {$data.contact_mobile}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.contact_time}{if $data.is_visit == 1}/{$data.contact_e_time}{/if}
    </div></td>   
    
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.create_uid})">{$data.create_user_name}</a></div></td> 
    <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>  
    <td title="{$data.contact_recode}"><div class="ui_table_tdcntr">
    <a href="javascript:;" onclick="GetRecordDetail({$data.recode_id})">{$data.contact_recode|truncate:"60":"..."}</a>
    </div></td>
    <td title=""><div class="ui_table_tdcntr">
    {if $data.revisit_uid > 0}
    <a href="javascript:;" onclick="ShowRevisitCard({$data.recode_id})">{$data.revisit_status_text}</a>
    {else}
    {$data.revisit_status_text}
    {/if}
    </div></td> 
    <td title=""><div class="ui_table_tdcntr">{if $data.revisit_uid > 0}<a href="javascript:void(0)" onclick="UserDetial({$data.revisit_uid})">{$data.revisit_user_name}</a>{else}--{/if}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.revisit_time}</div></td>    
    <td><div class="ui_table_tdcntr">        
        <ul class="list_table_operation">
            {if $data.revisit_uid <= 0}                  
            <li><a m="RevisitList" ispurview="true" v="4" href="javascript:;" onclick="RevisitModify({$data.recode_id})">回访</a></li>  
                {if $data.can_edit_income_money == 1}
                <li><a m="RevisitList" ispurview="true" v="128" href="javascript:;" onclick="EditPredictIncome({$data.recode_id})">修改预计到帐</a></li>
                {/if}
            {/if}
      </ul>      
    </div>
  </td>
</tr>
{/foreach}