 <!--S crumbs-->
  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：{$strPath}</div>
  <!--E crumbs--> 
  <!--S table_filter-->
  <div class="table_filter marginBottom10">
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
      <div id="J_table_filter_main" class="table_filter_main">
        <div class="table_filter_main_row">
            <div class="ui_title"> 公司： </div>
            <div class="ui_text">
              <select name="cbCompanyName" id="cbCompanyName">
              </select>
            </div>
            <div class="ui_title"> 部门： </div>
            <div class="ui_text">
              <select name="cbDeptName" id="cbDeptName">
              </select>
            </div>
            <div class="ui_title">员工状态：</div>
            <div class="ui_text">
              <select name="cbEmpStatus" id="cbEmpStatus">
              <option value="-100">全部</option>
              <option value="0">聘用</option>
              <option value="-11">已流失</option>
              <option value="-10">已辞退</option>
              <option value="-9">已离职</option>
              <option value="-1">离职中</option>
              <option value="1">实习</option>
              <option value="2">见习</option>
              <option value="3">外派</option>
              <option value="4">停薪留职</option>
              <option value="5">试用</option>
              </select>
            </div>
            <div class="ui_title">姓名：</div>
            <div class="ui_text">
              <input name="tbxEmpName" type="text" id="tbxEmpName" size="10" maxlength="10" />
            </div>            
		<div class="ui_title">工号：</div>
            <div class="ui_text">
              <input name="tbxWorkNo" type="text" id="tbxWorkNo" size="10" maxlength="10" />
            </div>
            <div class="ui_title">用户名：</div>
            <div class="ui_text">
              <input name="tbxUserName" type="text" id="tbxUserName" size="10" maxlength="10" />
            </div>
            <div class="ui_button ui_button_search"><button class="ui_button_inner" onclick="QueryData()" type="button">搜 索</button></div>
	</div>
      </div>
    </form>
  </div>
  <!--E table_filter--> 
  <!--S list_link-->
  <div class="list_link marginBottom10">
     <a class="ui_button" onclick="NewAccount()" href="javascript:;" m="UserList" v="4" ispurview="true" style="margin:0"><div class="ui_button_left"></div><div class="ui_button_inner"><div class="ui_icon ui_icon_add"></div><div class="ui_text">添加账号</div></div></a>
  </div>
  <!--E list_link-->
  <!--S list_table_head-->
  <div class="list_table_head">
  <div class="list_table_head_right">
 	<div class="list_table_head_mid">
        <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
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
            <th style="width:90px;"><div class="ui_table_thcntr" sort="sort_e_name">
                <div class="ui_table_thtext">员工姓名</div>
              </div></th>
            <th style="width:90px;"><div class="ui_table_thcntr" sort="sort_e_workno">
                <div class="ui_table_thtext">工号</div>
              </div></th>
            <th style=""><div class="ui_table_thcntr" sort="sort_dept_no">
                <div class="ui_table_thtext">部门</div>
              </div></th>
            <th style="width:150px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">最近一次登录时间</div>
              </div></th>
            <th style="width:150px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">职位</div>
              </div></th>
            <th style="width:80px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">员工状态</div>
              </div></th>
            <th style="width:60px;"><div class="ui_table_thcntr">
                <div class="ui_table_thtext">停用</div>
              </div></th>
            <th style="width:100px" > <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">操作</div>
              </div>
            </th>
          </tr>
        </thead>
        <tbody class="ui_table_bd" id="pageListContent"></tbody>
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
<script language="javascript" type="text/javascript">
$(document).ready(function () {
    var cbCompanyName = $DOM("cbCompanyName");
    var cbDeptName = $DOM("cbDeptName");
    $Dept.Init(cbCompanyName,cbDeptName,true);
    {/literal}
	pageList.strUrl="{$userListBody}"; 
	{literal}
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.init();
});

function QueryData()
{
	pageList.param = "&"+$('#tableFilterForm').serialize();
	pageList.first();
}
function LockUser(obj,uid)
{
    var isLockFlag = (obj.innerHTML == "停用" ? 0 : 1);
    var url = "/?d=System&c=User&a=LockUser&id="+uid;    
    var retValue = $PostData(url,"lockFlag="+isLockFlag+"&id="+uid);

    if(parseInt(retValue) == 0)
    {
        if(parseInt(isLockFlag) == 1)
        {
            obj.innerHTML = "停用";
            $("#divStatu"+uid).html('<span style="color:#028100;">否</span>');
        }
        else
        {
            obj.innerHTML = "启用"; 
            $("#divStatu"+uid).html("<span style='color:#EE5F00;'>是</span>");            
        }           
    }
    else
    {
		IM.tip.warn(retValue);
    }
}
function NewAccount() {
var _id = '';
IM.dialog.show({
    width: 500,
    height: null,
    title: '添加账号',
    html: IM.STATIC.LOADING,
    start: function () {
        MM.get("/?d=System&c=User&a=AddUser", {}, function (pageHTML) {
            $('.DCont')[0].innerHTML = pageHTML;
            $('#accountName').autocomplete('/?d=System&c=User&a=CompleteUser', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                max: 5, //只显示5行
                width: 150, //下拉列表的宽
                parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
                    /*
                    {"value":[{"id":"100","name":"\u9a6c\u6b63\u6770"},
                    {"id":"200","name":"\u9ebb\u5409"},{"id":"300","name":"Marshane"}]}
                    */
                    var parsed = [];
                    if (backData == "" || backData.length == 0)
                        return parsed;

                    backData = MM.json(backData);
                    var value = backData.value;
                    if (value == undefined)
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
                    //_id=item.id;
                    return "<div id='divUser" + item.id + "'>" + item.name + "</div>";
                }
            }).result(function (data, value) {//执行模糊匹配
                _id = value.id;
                var val = $(this).val();
                if (val != '') 
                    searchByName(_id);
            });
            //注册表单验证事件
            new Reg.vf($('#J_newAccount'), {
                callback: function (pData) {//确定按钮的回调事件
                    var pData = "tbxEmpID=" + $("#tbxEmpID").val() + "&chkIsLock=" + ($("#chkIsLock")[0].checked ? 1 : 0);
                    //pData = pData; //表单序列化后的数据  格式：对象数据
                    MM.ajax({
                        url: '/?d=System&c=User&a=AddUserSubmit', //表单数据提交的地址
                        data: pData,
                        success: function (backData) {//执行成功后返回的数据
                            //backData = MM.json(backData);
                            if (parseInt(backData) == 0) {
                                pageList.first();
                                IM.dialog.hide();
                                IM.tip.show('添加成功');
                            }
                            else {
                                IM.tip.warn(backData);
                            }
                        }
                    })
                }
            });
        });
    }
});
}

function searchByName(eID) {
    var tbxEmpID = $("#tbxEmpID"), divEmpInfo = $('#divEmpInfo');
    (tbxEmpID[0]).value = "-100";
    divEmpInfo.addClass('loading').html(''); //在取数据前显示loading
    MM.get('/?d=System&c=User&a=GetEmpDetailInfo', //取数据地址
    {
    id: encodeURIComponent(eID),
    r: MM.Random(1000)
    }, //<==这里 是参数
    function (backData) {
        //alert(backData);
        backData = new String(backData);
        if (backData.length <= 10) {
            divEmpInfo[0].innerHTML = '信息获取失败';
            divEmpInfo.removeClass('loading');
            return;
        }
        tbxEmpID.val(eID);
        var tbxWorkNo = $("#accountName")[0];
        tbxWorkNo.value = tbxWorkNo.value.split(' ')[0];
        divEmpInfo[0].innerHTML = backData;
        divEmpInfo.removeClass('loading');
    });
}
</script>
{/literal} 