<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>邮箱任务管理</div>
<!--E crumbs-->
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
                信息状态：</div>
            <div class="ui_comboBox">
                <select name="mail_info_state">
                    <option selected="selected" value="-1">全部</option>
                    <option value="1">已确认</option>
                    <option value="0">未确认</option>
                </select>
            </div>
            <div class="ui_title">
                邮箱状态：</div>
            <div class="ui_comboBox">
                <select name="mail_state">
                    <option selected="selected" value="-1">全部</option>
                    <option value="1">已开通</option>
                    <option value="0">未开通</option>
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
            <div class="ui_button ui_button_search">
                </span>
                <button type="button" class="ui_button_inner" onclick="QueryData()">
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
                <span class="ui_icon list_table_title_icon"></span>邮箱任务列表</h4>
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
                    <th title="订单号" >
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单号</div>
                        </div>
                    </th>
                    <th title="客户名称/ID" style="">
                        <div class="ui_table_thcntr " sort="sort_cus_name_id">
                            <div class="ui_table_thtext">
                                客户名称/ID</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="产品" >
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
                    <th title="提交人" style="width: 110px" sort="sort_user_name">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                提交人</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="提交时间" style="width: 80px;" sort="sort_create_time">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                提交时间</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="联系人" style="width: 80px;" sort="sort_contact_name">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                联系人</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="联系方式">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                联系方式</div>
                        </div>
                    </th>
                    <th title="下单时间" style="width: 80px;" sort="sort_last_check_time">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                下单时间</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="信息状态" style="width: 70px;">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                信息状态</div>
                        </div>
                    </th>
                    <th title="邮箱状态" style="width: 70px;">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                邮箱状态</div>
                        </div>
                    </th>
                    <th title="用户数" style="width: 50px;">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                用户数</div>
                        </div>
                    </th>
                    <th title="操作" style="width: 70px">
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
$GetProduct.Select("pro_type1", "pro_type2",true,1,-1);
function QueryData()
{
    pageList.param = '&'+$("#tableFilterForm").serialize();
    pageList.first();
}
{/literal}
pageList.sortField = "last_check_time desc";
pageList.strUrl="{$strUrl}";
{literal}
pageList.init();

IM.task.midifyInfo=function(data){
    var tplMain='<div class="tf">\
                <label>{0}域名提供方：</label> \
                <div class="inp">                                \
                    <select name="pid1">                          \
                        <option value="2">代理商提供</option>            \
                        <option value="3">客户提供</option>              \
                    </select>                                         \
                </div>                                                 \
                <label style="width:70px">企业域名：</label>                 \
                <div class="inp"><input type="text" valid="{1} url" name="domain"></div>\
                <div class="inp">\
                    <a style="margin:0 5px 0 0; float:left;" href="javascript:;" class="ui_button ui_link" control="add"><div class="ui_icon ui_icon_add2">&nbsp;</div></a> \
                    <a style="margin:0 5px 0 0; float:left;" href="javascript:;" class="ui_button ui_link" control="del"><div class="ui_icon ui_icon_del2">&nbsp;</div></a>\
                </div>\
        		<span class="info">请输入企业域名</span>\
                <span class="ok">&nbsp;</span><span class="err">请正确输入企业域名</span>\
            </div>';
	data=data||{};
	IM.dialog.show({
		width:700,
		title:'信息状态',
		html:IM.STATIC.LOADING,
		start:function(){
			MM.get('/?d=TM&c=EMail&a=ShowInfoState',data,function(q){
                var DCont=$('.DCont');
				DCont[0].innerHTML=q;
                function addHandler(event){
                    var a=(MM.E(event).target).parentNode;
                    if(a.tagName=='A'){
                        var b=MM.A(a,'control');
                        if(b=='add'){
                            $('.DCont .bd').append(_(tplMain,'',''));
                        }else if(b=='del'){
                            MM.remove(a.parentNode.parentNode);
                        }
                        b&&addFormEvent();
                    }
                };
                $('.DWrap').unbind('click').bind('click',addHandler);
                function cb(formData){
                    var input=DCont[0].getElementsByTagName('input'),
                            select=DCont[0].getElementsByTagName('select'),
                            input_val=[],
                            select_val=[];
                    for(var i=0;i<input.length;i++){
                        if($.trim(input[i].value)=='') continue;
                        input_val.push(input[i].value);
                        select_val.push(MM.getVal(select[i]).value);
                    };
                    MM.Extend(data,{'origin':select_val.join(','),'domain':input_val.join(',')});
					MM.ajax({
						url:'/?d=TM&c=EMail&a=SaveInfoState',
						data:data,
						success:function(q){
                            //alert(q);return false;
							q=MM.json(q);
							if(q.success){
                                 QueryData();
								 IM.tip.show(q.msg);
			                     IM.dialog.hide();
							}else{
								 IM.tip.warn(q.msg);
							}
						}
					});
                }
                function addFormEvent(){
                    new Reg.vf($('#J_midifyInfoForm'),{callback:cb});
                }
                addFormEvent();
			});
		}
    });
}
{/literal}
</script>
