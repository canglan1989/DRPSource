<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：{$strPath}</div>
<!--E crumbs-->
<!--S table_filter-->
<div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">    		
            <div class="table_filter_main_row">
                <div class="ui_title"> 订单号：</div>
                <div class="ui_text">
                    <input name="order_no" style="vertical-align: top;width:150px;" id="order_no"  type="text"></div>
                <div class="ui_title"> 所属代理商：</div>
                <div class="ui_text">
                    <input name="agent_name" style="vertical-align: top;width:150px;" id="agent_name" type="text"/></div>
                <div class="ui_title"> 客户名称：</div>
                <div class="ui_text">
                    <input name="cus_name" style="vertical-align: top;width:150px;" id="cus_name" type="text"></div>
                <div class="ui_title"> 订单类型：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="ord_type">
                        <option value="-100">全部</option>
                        <option value="1">新签</option>
                        <option value="2">续签</option>
                    </select>
                </div>
            </div>
            <div class="table_filter_main_row">
                <div class="ui_title"> 产品：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="pro_type1" id="pro_type1">
                    </select>
                    <select name="pro_type2" id="pro_type2">
                    </select>
                </div>
                <div class="ui_title"> 任务状态：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="trust_task_state">
                        <option value="-1">全部</option>
                        <option value="1">已添加</option>
                        <option value="0">未添加</option>
                    </select>
                </div>
                <div class="ui_title"> 诚信代码：</div>
                <div class="ui_text">
                    <input name="tCode" style="vertical-align: top;width:100px;" id="tCode" type="text"></div>
                <div class="ui_title"> 网址：</div>
                <div class="ui_text">
                    <input name="web_site" style="vertical-align: top;width:150px;" id="website" type="text"></div>
                <div class="ui_title"> 校验：</div>
                <div class="ui_comboBox" style="margin-right: 5px;">
                    <select name="trust_verify">
                        <option value="-1">全部</option>
                        <option value="1">已校验</option>
                        <option value="0">未校验</option>
                    </select>
                </div>
                <div class="ui_button ui_button_search">
                    <button type="button" class="ui_button_inner" id="AgentSearch" name="AgentSearch" onclick="QueryData()"> 搜 索</button></div>
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
                <span class="ui_icon list_table_title_icon"></span>认证任务管理</h4>
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
            <th title="客户名称" sort="sort_cus_name_id">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">
                    客户名称</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="产品" sort="sort_product_name">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    产品</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="代理商名称">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    代理商名称</div>
            </div>
            </th>
            <th title="订单类型" width="80" sort="sort_order_type">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单类型</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="订单状态" width="80" sort="sort_order_state">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单状态</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="诚信代码" width="80">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    诚信代码</div>
            </div>
            </th>
            <th title="网址" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    网址</div>
            </div>
            </th>
            <th width="80" title="订单时间"  sort="sort_order_date">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    订单时间</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th width="80" title="有效期" sort="sort_effect_date">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    有效期</div>
                <div class="ui_table_thsort">
                </div>
            </div>
            </th>
            <th title="校验" width="60">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">
                    校验</div>
            </div>
            </th>
            <th style="width:90px;" title="操作">
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
    $GetProduct.Select("pro_type1", "pro_type2",true);
    $("select[name=pro_type1] option").each(function(){
            var v = $(this).val();
        if(v>0&&v!=3&&v!=7){
            $(this).remove();
        }
    });

    {/literal}
    pageList.sortField = "order_date desc,order_date desc";
    pageList.strUrl="{$strUrl}";
    {literal}
    pageList.init();
    function QueryData()
    {
        pageList.param = '&'+$("#tableFilterForm").serialize();
        pageList.first();
    }
    
    function ViewComfirmCode(orderID)
    {
        var data = "id="+orderID;
        IM.dialog.show({
                    width: 400,
                    title:'查看认证代码',
                    html:IM.STATIC.LOADING,
                    start:function(){
                            MM.get('/?d=TM&c=Trustworthy&a=ViewComfirmCode',data,function(q){                            
                            $('.DCont')[0].innerHTML=q;                                                                                  
                            });			
                    }
        });	
    }
    
        /**
         *诚信任务列表 校验
         */
        IM.task.check=function(data){
                data=data||{};
                MM.ajax({
                        url:'/?d=TM&c=Trustworthy&a=checkTrustCode',
                        data:data,
                        success:function(q){
                                q=MM.json(q);
                                if(q.success){
                                        QueryData();					
                                        IM.tip.show(q.msg);
                                }else{
                                        IM.tip.warn(q.msg);
                                }                                
                        }
                })
        }
        /**
         *诚信任务列表 诚信代码
         */
    IM.task.CXCode=function(url,data,title){
            IM.dialog.show({
            width:550,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                MM.get(url, data, function (q) {
                    $('.DCont')[0].innerHTML = q;
                    new Reg.vf($('#J_CodeCardForm'),{callback:function(formData){
                        MM.ajax({
                            url:'/?d=TM&c=Trustworthy&a=SetTrustCode',
                            data:$('#J_CodeCardForm').serialize(),
                            success:function(q){
                                q=MM.json(q);
                                if(q.success){
                                    QueryData();
                                    IM.dialog.hide();
                                    IM.tip.show(q.msg);
                                }else{
                                    IM.tip.warn(q.msg);
                                }                                
                            }
                        })
                    }});
                });
            }
        });
    }

    {/literal}
</script>