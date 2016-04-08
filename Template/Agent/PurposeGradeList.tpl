<tr class="first">
    <td class="first"><div class="ui_table_tdcntr">代理商个数</div></td> 
    <td><div class="ui_table_tdcntr">{$rstA.0.A}</div></td>
    <td><div class="ui_table_tdcntr">{$rstA.0.B}</div></td>
    <td><div class="ui_table_tdcntr">{$rstA.0.C}</div></td>
    <td><div class="ui_table_tdcntr">{$rstA.0.D}</div></td>
    <td><div class="ui_table_tdcntr">{$rstA.0.E}</div></td>
    <td><div class="ui_table_tdcntr">{$rstA.0.qianyue}</div></td>
</tr>
{assign var="step" value=0}
{foreach from=$arrayData item=key}
{if ($step++)%2 == 0}<tr class="odd">{else} <tr class="even">{/if}
    <td class="first"><div class="ui_table_tdcntr">代理商名称</div></td>
    <td  title="{if $key.leval_a eq '0'}{else}{$key.leval_a}{/if}"><div class="ui_table_tdcntr">{if $key.leval_a eq '0'}{else}{$key.leval_a}{/if}</div></td>
    <td  title="{if $key.leval_b eq '0'}{else}{$key.leval_b}{/if}"><div class="ui_table_tdcntr">{if $key.leval_b eq '0'}{else}{$key.leval_b}{/if}</div></td>
    <td  title="{if $key.leval_c eq '0'}{else}{$key.leval_c}{/if}"><div class="ui_table_tdcntr">{if $key.leval_c eq '0'}{else}{$key.leval_c}{/if}</div></td>
    <td  title="{if $key.leval_d eq '0'}{else}{$key.leval_d}{/if}"><div class="ui_table_tdcntr">{if $key.leval_d eq '0'}{else}{$key.leval_d}{/if}</div></td>
    <td  title="{if $key.leval_e eq '0'}{else}{$key.leval_e}{/if}"><div class="ui_table_tdcntr">{if $key.leval_e eq '0'}{else}{$key.leval_e}{/if}</div></td>
    <td  title="{if $key.qianyue eq '0'}{else}{$key.qianyue}{/if}"><div class="ui_table_tdcntr">{if $key.qianyue eq '0'}{else}{$key.qianyue}{/if}</div></td>
</tr>
{/foreach}