		<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;">客户管理</a><span>&gt;</span>添加订单</div>
        <!--E crumbs-->     
        <!--S form_edit-->                  
        <div class="form_edit">
            <div class="form_hd">
            	<div class="form_hd_left">
	            	<div class="form_hd_right">
	                	<div class="form_hd_mid">
	                    	<h2>添加订单</h2>
	                    </div>
	                </div>
                </div>
				<div class="ui_button ui_button_dis" style="float:right;" onclick="PageBack()">
					<div class="ui_button_left"></div>
					<div class="ui_button_inner">
						<div class="ui_icon ui_icon_return"></div>
						<div class="ui_text">返回</div>
					</div>
				</div>
            </div>
            <div class="form_bd">
            		{foreach from=$arrayOrder item=data key=index}
                	{if $arrayOrder neq ""}               		
                	<div class="form_block_bd" style="clear:both;overflow:hidden;">
                        <div class="list_table_head">
                            <div class="list_table_head_right">
                                <div class="list_table_head_mid">
                                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>已添加的订单</h4>
                                </div>
                            </div>
                        </div>
                        <div class="list_table_main">
                            <div id="J_ui_table" class="ui_table">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <thead class="ui_table_hd">
                                        <tr>
                                            <th>
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">订单编号</div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">客户名称</div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">产品</div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">代理商进货价</div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">款项状态/金额(元)</div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">订单类型</div>
                                                </div>
                                            </th>
                                            <th style="width:100px;">
                                                <div class="ui_table_thcntr">
                                                    <div class="ui_table_thtext">操作</div>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>{/if}
                                    <!-- 下面是表格内容-->
                                    <tbody id="ListContent" class="ui_table_bd">
                
                                        <tr class="{sdrclass rIndex=$index}">
                                        <!--订单编号 -->
                                        <td  title="{$data.order_no}"><div class="ui_table_tdcntr">
                                        <a href="javascript:;" onclick="JumpPage('/?d=OM&c=Order&a=OrderDetail&id={$data.order_id}')">{$data.order_no}</a>
                                        </div></td>
                                        <!--客户名称 -->
                                        <td  title="{$data.customer_name}"><div class="ui_table_tdcntr">
                                        <a onclick="ShowCustomerCard({$data.customer_id})" href="javascript:;">{$data.customer_name}</a>
                                        </div></td>
                                        <!--产品 -->
                                        <td  title="{$data.product_name}"><div class="ui_table_tdcntr">
                                        {$data.product_name}
                                        </div></td>
                                        <!--代理商进货价 -->
                                        <td class="TA_r" title="{$data.act_price}"><div class="ui_table_tdcntr" >{$data.act_price}</div></td>
                                        <!--款项状态/金额 -->
                                        <td class="TA_r" title=""><div class="ui_table_tdcntr" >
                                        {if $data.act_price != 0 &&  $data.check_status >= 0}
                                            {if $data.is_charge == 1}
                                            扣款/{$data.act_price}
                                            {else}
                                            冻结/{$data.act_price}
                                            {/if}
                                        {elseif $data.act_price != 0 &&  $data.check_status == -1}
                                        未扣款/{$data.act_price}
                                        {else}
                                        --
                                        {/if}    
                                        </div></td>
                                        <!--订单类型 -->
                                        <td><div class="ui_table_tdcntr">{$data.order_type}</div></td>
                                       
                                        <!--操作 -->
                                        <td><div class="ui_table_tdcntr">
                                            
                                                <ul class="list_table_operation">
                                                    {if $data.check_status < 0}
                                                    <li><a m="OrderModify" v="4" ispurview="true" href="javascript:;" onclick="JumpPage('{au d="OM" c="Order" a="OrderModify"}&id={$data.order_id}')">编辑</a></li>
                                                    <li><a m="ValueOrderList" v="8" ispurview="true" href="javascript:;" onclick="IM.account.delOper('{au d="OM" c="Order" a="DelOrder"}&id={$data.order_id}',{literal}{{/literal}id:{$data.order_id}{literal}}{/literal},'删除订单',this)">删除</a></li>
                                                    {/if}
                                                    
                                              </ul>
                                              
                                            </div>
                                          </td>
                                      </tr>                                    
                                    </tbody>
                                </table>         
                            </div>
                       </div>   
                   </div>
                 	{/foreach}
                    <div class="form_block_hd"><h3 class="ui_title">{$strTitle}产品信息</h3></div>
                    <div class="form_block_bd">
                    	<form id="J_addOrder" action="" name="newOrderModifyForm" class="newOrderModifyForm">                           
							<div class="tf">
                              <label>客户名称：</label>
                              <div class="inp">{$customer_name.0.customer_name}
                               <input value="{$customer_id}" type="hidden" class="tbxCustomerID" id="tbxCustomerID" name="tbxCustomerID"/>
                               <input value="{$customer_name.0.customer_name}" type="hidden" class="tbxCustomerName" id="tbxCustomerName" name="tbxCustomerName" />
                               </div>
                            </div>
                            <div class="tf" style="padding-top:0px;">
                            	<label><em class="require">*</em>产品：</label>
                                <div class="inp">
                                	<select id="cbProductType" name="cbProductType" style="width:120px"></select>
                                	<select id="cbProduct" name="cbProduct" style="width:160px"></select>
                                </div>
                            </div> 
                            <div class="tf">
                            	<label><input name="tbxProudctPrice" id="tbxProudctPrice" type="hidden" valid="" value="0" />产品价格：</label>
                                <div class="inp">
                                <div id="divProudctPrice">￥0.00</div>
                                </div>
                            </div>
                            <div class="tf tf_submit">
                               <label>&nbsp;</label>
                                <div class="inp">
                                <div class="ui_button ui_button_confirm">
                                    <button id="butOk" class="ui_button_inner" type="submit">确定</button>
                                </div>
                                <div class="ui_button ui_button_cancel">
                                    <a class="ui_button_inner" onclick="PageBack()" href="javascript:;">返 回</a>
                                </div>
                                </div>
                            </div>
                        </form>                             
                    </div> 
                    
			</div> 
		</div>
<!--E sidenav_neighbour--> 

{literal}
<script language="javascript" type="text/javascript">
var _InDealWith = false;
$(function(){
    {/literal}
    var agentID = parseInt({$iAgentId});
    {literal}
  
    $GetProduct.Init("cbProductType", "cbProduct", true, "divProudctPrice",ProductGroups.ValueIncrease,ProductDataTypes.CurrentSignedProductType);

	function v_isNull(e){return $.trim(e)!='';}                                       
	new Reg.vf($('#J_addOrder'),{extValid:{isNull:v_isNull},callback:function(data){
		//数据已提交，正在处理标识
		if (_InDealWith) 
		{
			IM.tip.warn("数据已提交，正在处理中！");
			return false;
		}
        
        var cbProductType = $DOM("cbProductType");
        var cbProduct  = $DOM("cbProduct");
        $("#tbxProudctPrice").val($DOM("divProudctPrice").innerHTML);
        var productText = cbProductType.options[cbProductType.selectedIndex].text + ">" + cbProduct.options[cbProduct.selectedIndex].text;
        _InDealWith = true;
    	$.ajax({
    	    url:'/?d=CM&c=CMInfo&a=OrderPost1SubmitFront',
    	    data:$('#J_addOrder').serialize(),
    	    type:"post",
    	    success:function(backData){
    	    	if(backData.indexOf("0,") == 0)
                {
                    _InDealWith = false; 
                    var url = backData.substring(2)+"&"+$('#J_addOrder').serialize()+"&productText="+encodeURIComponent(productText);

                    JumpPage(url,false);
                }     
                else
                {
                    IM.tip.warn(backData);
                    _InDealWith = false;                    
                } 
    	    }					
    	});
    }});
    
});

$("#cbProduct").change(function () {//取得产品价格
    var price = $PostData("/?d=OM&c=Order&a=AgentProductPrice","productID="+$("#cbProduct").val())
    $("#divProudctPrice").html(price);
});

$('#tbxCustomerName').autocomplete('/?d=OM&c=Order&a=AutoCustomerJson', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
    max: 8, //只显示8
    width: 280, //下拉列表的宽
    parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
        $("#tbxCustomerID").val("-100");
        var parsed = [];
        if(backData == "" || backData.length == 0)
            return parsed;                                
        backData = MM.json(backData);
        var value = backData.value;
        if(value == undefined)
             return parsed;
        for (var i = 0; i < value.length; i++) {
            parsed[parsed.length] = {
                data: value[i],
                value: value[i].id,
                result: value[i].name
            }
        }
        return parsed;
    },
    formatItem: function (item) {//内部方法生成列表
        return "<div>" + item.no +" "+item.name +""+ "</div>";
    }
}).result(function (data,value) {//执行模糊匹配
    var id = value.id;
    $("#tbxCustomerID").val(id);    
});
</script>
{/literal}                        
          
    
