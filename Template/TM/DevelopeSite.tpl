<!--E sidenav-->
<!--S sidenav_neighbour-->	
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：任务管理<span>&gt;</span>网营门户任务管理<span>&gt;</span>建站模板管理</div>
<!--E crumbs-->     
<div class="table_filter marginBottom10">
        <form action="" method="post" id="tableFilterForm" name="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
        <div class="tf">
            <label>&nbsp;</label>
            <div class="inp">
                <a m='DevelopeSite' v="2" ispurview="true" class="ui_button" href="javascript:;" onclick="$('#J_searchBox').show();" style="margin-right: 10px;"><div class="ui_button_left"></div><div class="ui_button_inner"><div style="width:45px; text-align: center;margin:0;" class="ui_text">分配</div></div></a>
                {if $work_id == $boundUserArray.user_id}
                <a m='DevelopeSite' v="4" ispurview="true" class="ui_button" href="javascript:" onClick="showLinkUrltoWYHM('{au d='TM' c='DevelopeSite' a='getLinkUrlToWYMH'}&account={$boundUserArray.WY_uname}')"><div class="ui_button_left"></div><div class="ui_button_inner"><div style="margin:0;" class="ui_text">登录网营</div></div></a>
               {/if} 
            </div>
        </div>
        <div id="J_searchBox" class="tf" style="display: none">
            <label>账号/姓名：</label>
            <div class="inp" style="margin-right: 10px;">
                <input type="text" name="searchInp" id="J_searchInp"/>
            </div>
            <div class="inp">
                <div class="ui_button ui_button_search"><button class="ui_button_inner" type="button" onclick="IM.userAdd()">确定</button></div>
                <a href="javascript:;" onclick="$('#J_searchBox').hide();" class="ui_button ui_button_dis"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_text" style="margin:0; width:40px; text-align: center;">取消</div></div></a>
            </div>
        </div>
        <div class="tf" id="J_tf" style="display:none"></div>
    </div>
    </form>
</div>

<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>目前绑定的帐号信息</h4>
        </div>
    </div>
</div>
<div class="list_table_main marginBottom10">
    <div class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">账号名</div></div></th>
                    <th><div class="ui_table_thcntr "><div class="ui_table_thtext">账号状态</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">姓名</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">最近登录时间</div></div></th>
                    <!--<th><div class="ui_table_thcntr"><div class="ui_table_thtext">公司</div></div></th>-->                            
                    <!-- <th><div class="ui_table_thcntr"><div class="ui_table_thtext">联系电话</div></div></th>-->
                    <!--<th><div class="ui_table_thcntr"><div class="ui_table_thtext">角色</div></div></th>-->
                </tr>
            </thead>
            <tbody id="J_ui_table_bd" class="ui_table_bd">
                <tr>
                    <td><div class="ui_table_tdcntr"><a onclick="UserDetial({$boundUserArray.user_id})" href="javascript:;">{$boundUserArray.user_name}</a></div></td>
                    <td><div class="ui_table_tdcntr">{$boundUserArray.is_lock_name}</div></td>
                    <td><div class="ui_table_tdcntr">{$boundUserArray.user_name}</div></td>
                    <td><div class="ui_table_tdcntr">{if $boundUserArray.load_time != "" }{$boundUserArray.load_time}{else} 无登录记录{/if}</div></td>
                    <!-- <td><div class="ui_table_tdcntr">-</div></td>
                    <td><div class="ui_table_tdcntr">-</div></td>
                    <td><div class="ui_table_tdcntr">-</div></td>-->
                </tr>
            </tbody>
        </table>
    </div>
    <!--E ui_table-->
</div>
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>历史分配记录</h4>
        </div>
    </div>
</div>
<div class="list_table_main">
    <div class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">编号</div></div></th>
                    <th><div class="ui_table_thcntr "><div class="ui_table_thtext">账号</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">姓名</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">联系电话</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">分配时间</div></div></th>
                    <th><div class="ui_table_thcntr"><div class="ui_table_thtext">分配人</div></div></th>
                </tr>
            </thead>
            <tbody class="ui_table_bd">
                {foreach from=$historyBoundUserArray item=data key=index}
                <tr>
                    <td><div class="ui_table_tdcntr">{$data.Id}</div></td>
                    <td><div class="ui_table_tdcntr">{$data.user_name}</div></td>
                    <td><div class="ui_table_tdcntr">{$data.e_name}</div></td>
                    <td><div class="ui_table_tdcntr">{$data.tel}/{$data.phone}</div></td>
                    <td><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                    <td><div class="ui_table_tdcntr">{$data.create_name}</div></td>
                </tr>
                {/foreach} 
            </tbody>
        </table>
    </div>
    <!--E ui_table-->
</div>

<!--E sidenav_neighbour-->   
{literal} 
<script type="text/javascript">
$('#J_searchInp').autocomplete('/?d=CM&c=CMInfo&a=CompleteUserId', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 5, //只显示5行
                width: 160, //下拉列表的宽
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
                            value: value[i].user_id,
                            result: value[i].user_name
                        }
                    }
                    return parsed;
                },
                formatItem: function (item) {//内部方法生成列表
                    return '<div>' + item.user_id +"("+item.user_name+")"+ '</div>';
                }
            }).result(function (data,value) {//执行模糊匹配
                var eID = value.user_id;
                        IM.userAdd=function()
                     {
                          MM.ajax({
                        url: '/?d=TM&c=DevelopeSite&a=netModelManageUserSubmit&userid=' + eID,
                        data: data,
                        success: function (q) {
                            if (q == 0) {
                                $('#J_searchBox').hide();
                                IM.tip.show('绑定成功');JumpPage('/?d=TM&c=DevelopeSite&a=showDevelopeSite');
                            }else {
                                $('#J_searchBox').hide();
                                IM.tip.warn('绑定失败');
                            }
                        }
                    })
                     }
                  });
function showLinkUrltoWYHM(href,data)
{
var url="";
jQuery.ajax({
async: false,
type: "POST",
dataType: "text",
url: href,
data: data,
success: function (msg) {
         if(msg != 0){
                     window.open(msg);
                      }      
         else { 
               IM.tip.warn("您尚未绑定帐号到网营门户！");
              }      

   }
});
}
{/literal}
</script>