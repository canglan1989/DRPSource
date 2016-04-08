
{foreach from=$arrayData item=data key=index}
  <tr>
    <td title=""><div class="ui_table_tdcntr" name="oldValue">{$data.change_values}</div></td>
    <td title=""><div class="ui_table_tdcntr" name="newValue">{$data.change_values}</div></td>
    <td title=""><div class="ui_table_tdcntr">{$data.check_type_cn}</div></td>
    <td title=""><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showConatctCard({$data.contact_id})">{$data.contact_name}</a></div></td>
    <td title="{$data.customer_name}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="IM.agent.getTableList('/?d=CM&c=CMLogin&a=showCustomerBJ',{literal}{{/literal}id:{$data.customer_id}{literal}}{/literal},'客户基本信息',700)">{$data.customer_name}</a></div></td>
    <td title="{$data.agent_name}"><div class="ui_table_tdcntr">{$data.agent_name}</div></td>
    <td title="{$data.create_time}"><div class="ui_table_tdcntr">{$data.create_time}</div></td>
    <td title="{$data.create_user_name}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="UserDetial({$data.create_uid})">{$data.create_user_name}</a></div></td>
    <td title="{$data.check_state_cn}"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="showCheckPage('{$data.aid}')">{$data.check_state_cn}</a></div></td>
  </tr>
{/foreach}
<script type="text/javascript">
{literal}
function setModifyHTML(flag) {
    $("[name='" + flag + "']").each(function () {
        var jsonStr = this.innerHTML;
        try
        {
            this.innerHTML = transferModifyInfo($.parseJSON($.trim(jsonStr)),flag);
        }
        catch(e)
        {
        }
    });
}
//将返回的单条修改记录JSON字段数据 转换为线框图所示的文本格式
//valueName 修改值的键名 oldValue or newValue
function transferModifyInfo(jsonValue,valueName) {
    var rtn = "";
    if (jsonValue && jsonValue != "{}") {
        for (var key in jsonValue) {
            if (keyValue[key]) {
                jsonValue[key][valueName]=setKeyValue(key,jsonValue[key][valueName]);
                  if(jsonValue[key][valueName] == -1)
                {
                    jsonValue[key][valueName] = "";
                }
                rtn += "<div class='tf'><label>"+keyValue[key]+"：</label><div class='inp'>"+jsonValue[key][valueName]+"</div></div>";

            }
        }
        if (rtn != "") {
            rtn = rtn.slice(0, -6);
        }
    }
    else {
        rtn = "无数据修改";
    }
    return rtn;
}
//设置包括省市、男女等值为ID的数据
function setKeyValue(key,value)
{
    switch(key)
    {
        case "area_id":
            value=$.GetFullAreaName(value);
            break;
        case "reg_place":
            value=$.GetFullAreaNameJ(value);
            break;
        case "industry_id":
            value=$.GetFullIndustryName(value);
            break;
        case "contact_sex":
            value=value==1?"男":"女";
            break;
        case "isCharge":{
                value = value == 1?"负责人":"非负责人";
                    break;
            }
        default:break;
    }
    return value;
}
var keyValue = {
    customer_id: "客户ID",
    customer_no: "客户编号",
    customer_name: "客户名称",
    area_id: "所属地区",
    address: "客户地址",
    postcode: "邮政编码",
    industry_id: "所属行业",
    business_model: "经营模式",
    main_business: "主营业务",
    major_markets: "主要市场",
    company_profile: "公司简介",
    reg_date: "注册时间",
    business_scope: "经营范围",
    company_scope: "规模(人数)",
    annual_sales: "年销售额",
    reg_status: "注册状态",
    reg_capital: "注册资金",
    reg_place: "注册地址",
    contact_name: "联系人姓名",
    contact_sex: "联系人性别",
    contact_mobile: "联系人手机",
    contact_tel: "联系人电话",
    contact_fax: "联系人传真",
    contact_email: "联系人邮箱",
    contact_net_awareness: "网络意识",
    contact_importance: "重要程度",
    contact_position: "联系人职位",
    contact_remark: "联系人备注",
    check_status: "审核标识",
    check_remark: "审核备注",
    is_del: "是否删除",
    website: "公司网址",
    customer_from: "客户来源",
    net_extension_about: "网络推广情况",
    update_uid: "更新人",
    update_time: "更新时间",
    create_uid: "创建人",
    create_time: "创建时间",
    check_uid: "审核人",
    check_time: "审核时间",
    assign_check_id: "指派审核人",
    isCharge:"角色"
}
setModifyHTML("oldValue");
setModifyHTML("newValue");
{/literal}
</script>
