<!--S crumbs-->
	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('{au d="CM" c="CMLogin" a="showCustomerLoginInfoList"}')">注册客户管理</a><span>&gt;</span>客户资料转移</div>
    <!--E crumbs-->
    <div class="form_edit">
            <div class="form_hd">
                <div class="form_hd_left"><div class="form_hd_right"><div class="form_hd_mid"><h2>请选择需转入的代理商信息</h2></div></div></div>
                <span class="declare">"<em class="require">*</em>"为必填信息</span>
            </div>
            <!--S form_bd-->
            <div class="form_bd">
            	<div class="form_block_bd">
                    <div class="list_table_head">
                            <div class="list_table_head_right">
                                <div class="list_table_head_mid">
                                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 客户转移列表</h4>
                                    <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>
                                </div>
                            </div>
                    </div>
                    <!--E list_table_head-->
                    <!--S list_table_main-->
                    <div class="list_table_main">
                        <div id="J_ui_table" class="ui_table">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                        <thead class="ui_table_hd">
                                            <tr>
                                                <th title="全选/反选" style="width:30px">
                                                    <div class="ui_table_thcntr">
                                                        <div class="ui_table_thtext">
                                                            <input onClick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');" class="checkInp" type="checkbox" />
                                                        </div>
                                                    </div>
                                                </th>
                                                <th style="width:80px" title="客户ID">
                                                    <div class="ui_table_thcntr" sort="sort_customer_id">
                                                        <div class="ui_table_thtext">客户ID</div><div class="ui_table_thsort"></div>
                                                    </div>
                                                </th>
                                                <th style="" title="客户名称">
                                                    <div class="ui_table_thcntr" sort="sort_customer_name">
                                                        <div class="ui_table_thtext">客户名称</div>
                                                        <div class="ui_table_thsort"></div>
                                                    </div>
                                                </th>
                                                <th style="" title="代理商名称">
                                                    <div class="ui_table_thcntr" sort="sort_agent_name">
                                                        <div class="ui_table_thtext">代理商名称</div><div class="ui_table_thsort"></div>
                                                    </div>
                                                </th>
                                                <th style="width:130px" title="代理商主帐号">
                                                    <div class="ui_table_thcntr" sort="sort_user_name">
                                                        <div class="ui_table_thtext">代理商主帐号</div>
                                                        <div class="ui_table_thsort"></div>
                                                    </div>
                                                </th>
                                           </tr>
                                       </thead>
                                       <tbody class="ui_table_bd" id="pageListContent">
                                       </tbody>
                                   </table>
                        </div>
                        <!--E ui_table-->
                    </div> 
                    <!--S list_table_foot-->
                    <div class="list_table_foot"><div id="divPager" class="ui_pager"></div></div>
                </div>
                <!--S form_block_bd-->
                <div class="form_block_bd">
                <form id="tableFilterForm" action="" name="tableFilterForm" class="customerMoveForm">
                    <input id="customer_ids" name="customer_ids" type="hidden" value="{$customer_ids}"/>
                                        <div class="tf">
						<label>意向产品：</label>
						<div class="inp">
                                                    {literal}
                                                        <div id="ui_comboBox_intentionPro" onclick="IM.comboBox.init({'control':MM.A(this,'control'),data:MM.A(this,'data')},this)" class="ui_comboBox ui_comboBox_def" control="intentionPro" key="" value="" data={/literal}'{$arrJsonType}'{literal} style="width:120px;">
                                                    {/literal}
                                                    <div style="width:100px;" class="ui_comboBox_text">
                                                            <nobr>请选择</nobr>
                                                    </div>
                                                    <div class="ui_icon ui_icon_comboBox"></div>                        
                                                </div>
                                                </div>
						<span class="info">请输入意向产品</span>
						<span class="ok">&nbsp;</span><span class="err">请输入意向产品</span>
					</div>
					<div class="tf">
						<label>所属代理商：</label>
						<div class="inp">
                            <input type="text" id="J_subordinateAgent" autocomplete="off" name="to_anget_Name" class="subordinateAgent" valid="required"/>
							<input name="to_anget_id" id="to_anget_id" type="hidden" value="-1" />
                        </div>
						<span class="info">请输入所属代理商</span>
						<span class="ok">&nbsp;</span><span class="err">请输入所属代理商</span>
					</div>                        
					<div class="tf tf_submit" style="height:150px;">
						<label>&nbsp;</label>
						<div class="inp">
                                                    <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确  认</button></div>
                                                    <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="JumpPage('{au d="CM" c="CMLogin" a="showCustomerLoginInfoList"}')">取  消</a> </div>
                            	
						</div>
					</div>
                </form>
                </div>
	</div>               
</div>
<!--E sidenav_neighbour-->
    <script type="text/javascript" src="{$JS}pageCommon.js"></script>
	<script type="text/javascript"><!--
	{literal}
	$(function(){
        {/literal}
    	pageList.strUrl="{$strUrl}"; 
    	{literal}
    	pageList.param = "&"+$('#tableFilterForm').serialize();
    	pageList.init();
        $('#J_subordinateAgent').autocomplete('/?d=CM&c=CMTransfer&a=getAgentName_ID', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                        max: 5, //只显示5行
                        width: 150, //下拉列表的宽
                        parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
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
                                    result: value[i].no+"("+value[i].name+")"
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return "<div>" + item.no +"("+item.name +")"+ "</div>";
                        }
                    }).result(function (data,value) {//执行模糊匹配
                        var id = value.id;
                        $("#to_anget_id").val(id);
        		    });
        new Reg.vf($('#tableFilterForm'),{callback:function(data){
    	    //异步提交数据
            var listid = IM.table.getListID();
            if(listid.length == 0)
            {
                IM.tip.warn('请选择要转移的客户');
                return false;
            }
            if($("#to_anget_id").val()=="-1")
            {
                IM.tip.warn('请选择代理商');
                return false;
            }
                var inten_product = $.trim(MM.A(MM.G('ui_comboBox_intentionPro'),'key'));
        	$.ajax({
        			type:'POST',
        			data:$('#tableFilterForm').serialize()+'&inten_product='+inten_product+"&listid="+listid.join(","),
        			url:'/?d=CM&c=CMTransfer&a=transferZhuceBack',
        			success:function(data)
        			{
        			    if(data==1)
                        {
                            IM.tip.show('转移成功');
                            JumpPage('/?c=CMLogin&d=CM&a=showCustomerLoginInfoList');
                        }
                         else if(data == 2)
                                    {
                                        IM.dialog.hide();
                                        IM.tip.warn('转移失败,该客户已存在订单');
                                    }
                                    else
                        {
                            IM.tip.warn(data);   
                        }
                    }
        		});
            }});
        });
	{/literal}
	--></script>

