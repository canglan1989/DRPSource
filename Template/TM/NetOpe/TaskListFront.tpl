<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>网营门户任务查询</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
    <label>
        提示信息：</label>
    <span class="ui_link"><a href="javascript:;">已分配：</a>(<em>{$headData.assign}</em>)</span>
    <span class="ui_link"><a href="javascript:;">未分配：</a>(<em>{$headData.un_assign}</em>)</span>
    <span class="ui_link"><a href="javascript:;">制作完成：</a>(<em>{$headData.make}</em>)</span>
    <span class="ui_link"><a href="javascript:;">制作未完成：</a>(<em>{$headData.un_make}</em>)</span>
    <span class="ui_link"><a href="javascript:;">厂商评审通过：</a>(<em>{$headData.verify_pass}</em>)</span>
    <span class="ui_link"><a href="javascript:;">厂商评审未通过：</a>(<em>{$headData.verify_un_pass}</em>)</span>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
            <div class="ui_title">
                订单号：</div>
            <div class="ui_text">
                <input type="text" name="order_no" class="inputer"></div>
            <div class="ui_title">
                客户名称：</div>
            <div class="ui_text">
                <input type="text" name="cus_name" class="inputer"></div>
            <div class="ui_title">
                产品：</div>
            <div class="ui_comboBox">
                <select name="pro_type1" id="pro_type1" style="display:none">
                </select>
                <select name="pro_type2" id="pro_type2">
                </select>
            </div>
            <div class="ui_title">
                提交人：</div>
            <div class="ui_text">
                <input type="text" name="post_name" class="inpCommon inputer"></div>
        </div>
        <div class="table_filter_main_row">
            <div class="ui_title">
                任务状态：</div>
            <div class="ui_comboBox">
                <select name="net_assign_state">
                    <option value="-1">全部</option>
                    <option value="1">已分配</option>
                    <option value="0">未分配</option>
                </select>
            </div>
            <div class="ui_title">
                下单时间：</div>
            <div id="createTime" class="ui_text">
                <input type="text" onfocus="WdatePicker({literal}{maxDate:'#F{$dp.$D(\'J_editTimeE0\')}'}{/literal})"
                    name="order_time_begin" class="inpCommon inpDate" id="J_editTimeS0">
                至
                <input type="text" onfocus="WdatePicker({literal}{minDate:'#F{$dp.$D(\'J_editTimeS0\')}'}{/literal})"
                    name="order_time_end" class="inpCommon inpDate" id="J_editTimeE0">
            </div>
            <div class="ui_title">
                制作人：</div>
            <div class="ui_text">
                <input type="text" name="net_make_name" class="inpCommon inputer"></div>
            <div class="ui_button ui_button_search">
                </span>
                <button type="button" class="ui_button_inner" id="AgentSearch" name="AgentSearch"
                    onclick="QueryData()">
                    搜 索</button></div>
        </div>
    </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title">
                <span class="ui_icon list_table_title_icon"></span>网营门户任务列表</h4>
        </div>
    </div>
</div>
<!--E list_table_head-->
<!--S list_table_main-->
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr class="">
                    <th title="订单号">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单号</div>
                        </div>
                    </th>
                    <th title="客户名称" style="" sort="sort_cus_name_id">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                                客户名称</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="产品">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                产品</div>
                        </div>
                    </th>
                    <th title="订单类型" style="width: 80px;" sort="sort_order_type">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单类型</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="订单状态" style="width: 80px;" sort="sort_order_state">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单状态</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="提交人/公司" sort="sort_post_user_name_id">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                提交人/公司</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="提交时间" sort="sort_post_time">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                提交时间</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="下单时间" sort="sort_last_check_time">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                下单时间</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="任务状态" style="width: 80px;">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                任务状态</div>
                        </div>
                    </th>
                    <th title="制作人" style="width: 80px">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                                制作人</div>
                        </div>
                    </th>
                    <th title="分配人" style="width: 80px">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                                分配人</div>
                        </div>
                    </th>
                    <th title="分配时间" style="width: 90px">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                                分配时间</div>
                        </div>
                    </th>
                    <th title="操作" style="width: 60px">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                                操作</div>
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
<!--E list_table_main-->
<!--S list_table_foot-->
<div class="list_table_foot">
    <div id="divPager" class="ui_pager">
    </div>
</div>
<!--E list_table_foot-->
<script type="text/javascript" src="{$JS}pageCommon.js"></script>
{literal}
<script type="text/javascript">
$GetProduct.Select("pro_type1", "pro_type2",true,2,-1);
function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}
    
pageList.sortField = "task_state desc,last_check_time desc";
{/literal}
pageList.strUrl="{$strUrl}";
{literal}
pageList.init();

/**
 * 网营门户任务查询 转移
 * @param data
 */
IM.task.taskMove=function(data){
	data=data||{};
	IM.dialog.show({
		width: 600,
		title:'任务分配',
		html:IM.STATIC.LOADING,
		start:function(){
			MM.get('/?d=TM&c=NetOpe&a=getSourseInfo',data,function(q){
				$('.DCont')[0].innerHTML=q;
                                    
                                 var J_auditerName=$('#amount');
                        J_auditerName.autocomplete('/?d=TM&c=NetOpe&a=AutoComplete',{
                            max:5,
                            width:J_auditerName.width()+2,
                            parse:function(q){
                                var parsed=[];
                                q=MM.json(q);
                                q=q.value;
                                for(var i=0;i<q.length;i++){
                                    parsed[parsed.length]={
                                        data:q[i],
                                        value:q[i].user_id,
                                        result:q[i].user_name
                                    }
                                }
                                return parsed;
                            },
                            formatItem:function(item){
                                return '<em>'+item.user_name+'('+item.e_name+')'+'</em>';
                            }
                        });
				new Reg.vf($('#J_taskMoveForm'),{callback:function(formData){
					MM.Extend(formData,data);
					MM.ajax({
						url:'/?d=TM&c=NetOpe&a=WorkTransfer',
						data:formData,
						success:function(q){
							q=MM.json(q);
							if(q.success){
                                                            IM.dialog.hide();
                                                            QueryData();
								IM.tip.show(q.msg);
							}else{
								IM.tip.warn(q.msg);
							}
						}
					});
				}});
			});			
		}
    });
}
var _InDealWith = false;
/**
 * 网营门户任务查询 分配
 * @param data
 */
IM.task.taskDist=function(data){
	var tplMain='<div class="DContInner">\
                        <form id="J_taskDistForm">\
                            <div class="bd">                                       \
                                <div class="tf">                                    \
                                    <label><em class="require">*</em>账号：</label>                             \
                                    <div class="inp"><input type="text" id=accountName name="accountName" valid="required"></div>\
									<span class="info">请输入账号</span>\
									<span class="ok">&nbsp;</span>\
									<span class="err">请输入账号</span>\
                                </div>\
                                <div class="tf">                                    \
                                    <label>备注：</label>                             \
                                    <div class="inp"><textarea id=assign_remark name="assign_remark"></textarea></div>\
                                </div>\
                            </div>                                                                                      \
                            <div class="ft">                                                                             \
                                <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>\
                                <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确定</button></div>                      \
                            </div>                                                                                                                              \
                        </form>                                                                                                                                  \
                    </div>';	
	data=data||{};
	IM.dialog.show({
		width: 450,
		title:'任务分配',
		html:IM.STATIC.LOADING,
		start:function(){
			$('.DCont')[0].innerHTML=tplMain;
                        var J_auditerName=$('#accountName');
                        J_auditerName.autocomplete('/?d=TM&c=NetOpe&a=AutoComplete',{
                            max:5,
                            width:J_auditerName.width()+2,
                            parse:function(q){
                                var parsed=[];
                                q=MM.json(q);
                                q=q.value;
                                for(var i=0;i<q.length;i++){
                                    parsed[parsed.length]={
                                        data:q[i],
                                        value:q[i].user_id,
                                        result:q[i].user_name
                                    }
                                }
                                return parsed;
                            },
                            formatItem:function(item){
                                return '<em>'+item.user_name+'('+item.e_name+')'+'</em>';
                            }
                        });
			new Reg.vf($('#J_taskDistForm'),{callback:function(formData){
			    if (_InDealWith) 
        		{
        			IM.tip.warn("数据已提交，正在处理中！");
        			return false;
        		}
                
				MM.Extend(formData,data);
                
                _InDealWith = true;
				MM.ajax({
					url:'/?d=TM&c=NetOpe&a=WorkAssign',
					data:formData,
					success:function(q){
					    //alert(q);return false;
						q=MM.json(q);
						if(q.success){
                            IM.dialog.hide();
                            _InDealWith = false;
                            QueryData();
							IM.tip.show(q.msg);
						}else{
                            _InDealWith = false;
							IM.tip.warn(q.msg);
						}
					}
				});
			}});
		}
    });
}
{/literal}
</script>