<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>代理商全国分布图</title>
        <link rel="stylesheet" href="/../FrontFile/CSS/map_base.css"/>
        <link href="/../FrontFile/JS/calendar/skin/WdatePicker.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="/../FrontFile/JS/map.base.js"></script>
        <script type="text/javascript" src="/../FrontFile/JS/calendar/WdatePicker.js" ></script>
        <script type="text/javascript" src="/../FrontFile/JS/pageCommon.js"></script>  
    </head>
    <body style="padding:10px 15px">
        <div class="ui_button ui_button_submit ui_button_center"><a href="/?d=Map&a=showadd"  class="ui_button_inner">添加代理商</a></div>
        <div id="j_side" class="side" style="width:auto; min-width: 1000px; padding: 0 0 10px 0;">
            <div class="list_table_head">
                <div class="list_table_head_right">
                    <div class="list_table_head_mid">
                        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>代理商列表</h4>
                    </div>
                </div>
            </div>
            <div class="list_table_main">
                <div class="ui_table" id="J_ui_table">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <thead class="ui_table_hd">
                            <tr class="">
                                <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">公司名称</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">代理区域</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">代理产品</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">代理截止时间</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">保证金</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">预存款</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">签单人员</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">到账情况</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">外访达标率</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">应访数</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">实防数</div>
                        </div>
                        </th>
                        <th>
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">盘盟上线家数</div>
                        </div>
                        </th>
                        <th style="width: 120px;">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">操作</div>
                        </div>
                        </th>
                        </tr>
                        </thead>
                        <tbody class="ui_table_bd" id="pageListContent">
                            {foreach from=$data item=row}
                                <tr>
                                    <td title=""><div class="ui_table_tdcntr">{$row.agent_name}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.area}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.product_name}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.deadline}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.ensure_money}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.deposits}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.sign_name}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.status}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.visit_rate}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.visit_num}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.real_visit}</div></td>
                                    <td title=""><div class="ui_table_tdcntr">{$row.adhai_online_num}</div></td>
                                    <td>
                                        <div class="ui_table_tdcntr">
                                            <ul class="list_table_operation">
                                                <li><a href="/?d=Map&a=showEdit&id={$row.id}">编辑</a></li>
                                                <li><a href="/?d=Map&a=showMap&xy={$row.coordinate}" target="_blank" title="查看地图">查看</a></li>
                                                <li><a href="javascript:;" onclick="delOper({literal}{{/literal}'id':'{$row.id}'{literal}}{/literal})">删除</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
                <!--E ui_table-->
            </div>
            <div class="list_table_foot">
                <div class="ui_pager" id="divPager"><div class="ui_pager_cont"><a href="/?d=Map&a=showList&page=1" id="firstPage" class="ui_link disabled">首页</a><a href="/?d=Map&a=showList&page={$page-1}" id="previewPage" class="ui_link disabled">上一页</a><a {if $pageCount>$page}href="/?d=Map&a=showList&page={$page+1}"{else}href="#"{/if} id="nextPage" class="ui_link disabled">下一页</a><a href="/?d=Map&a=showList&page={$pageCount}" id="lastPage" style="margin-right:10px;" class="ui_link disabled">尾页</a></div></div>
            </div>
        </div>
        {literal}
            <script type="text/javascript">

            var delOper=function(data){
                var html='<div class="DContInner delAccountCont">' +
                    '<div class="bd"><h4>您确定要删除所选项码？</h4></div>' +
                    '<div class="ft">' +
                    '<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>' +
                    '<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" onclick="IM.dialog.ok()">确定</button></div>' +
                    '</div></div>';
                IM.dialog.show({
                    width:400,
                    title:'删除代理商',
                    html:html,
                    ok:function(){
                        MM.ajax({
                            url: '/?d=map&a=delinfo',
                            data:data,
                            success: function (q) {
                                IM.dialog.hide();
                                q=MM.json(q);				
                                if(q.success) {                                    
                                    IM.tip.show('删除成功');
                                }else{IM.tip.show('删除失败');}
                            }
                        });
                    }
                });
            }

            </script>
        {/literal}
    </body>
</html>