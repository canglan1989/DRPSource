{foreach from=$arrayProduct item=data key=index}
<tr class="{sdrclass rIndex=$index}">
	<td title="{$data.product_no}" ><div class="ui_table_tdcntr"><nobr>{$data.product_no}</nobr></div></td>
	<td title="{$data.product_name}" ><div class="ui_table_tdcntr">{$data.product_name}</div></td>
	<td title="{$data.product_series}" ><div class="ui_table_tdcntr">{$data.product_series}</div></td>
	<td  title="{$data.is_gift_text}"><div class="ui_table_tdcntr">{if $data.is_gift == 1 }<span style="color:#EE5F00;">是</span>{else}<span style="color:#028100;">否</span>{/if}</div></td>
	<td title="{$data.product_remark}"><div class="ui_table_tdcntr"><nobr>{$data.product_remark}</nobr></div></td>
	<td>
		<div class="ui_table_tdcntr">
			<ul class="list_table_operation">
				<li><a m="ProductList" v="4" ispurview="true" href="javascript:;" 
				onclick="addProduct({$data.product_id})" title="产品编辑">编辑</a></li>
				{if $data.cant_del == 1}
				<li>删除</li>
				{else}
				
				<li><a  m="ProductList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('/?d=PM&c=Product&a=DelProduct&id={$data.product_id}',{literal}{{/literal}id:{$data.product_id}{literal}}{/literal},'删除产品',this)">删除</a></li>
                {/if}
			</ul>
		</div>
	</td>
</tr>
{/foreach}