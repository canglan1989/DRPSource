<?php /* Smarty version 2.6.26, created on 2012-12-31 18:00:11
         compiled from TM/NetOpe/SitePublishBack.tpl */ ?>
<div class="crumbs marginBottom10">
    <em class="icon_crumbs"></em>当前位置：首页<span>&gt;</span>任务管理<span>&gt;</span>网站发布</div>
<!--E crumbs-->
<div class="table_attention marginBottom10">
    <label>
        提醒信息：</label>
    <span class="ui_link"><a href="javascript:;">未发布：</a>(<em><?php echo $this->_tpl_vars['headData']['un_publish']; ?>
</em>)</span>
    <span class="ui_link"><a href="javascript:;">发布中：</a>(<em><?php echo $this->_tpl_vars['headData']['publishing']; ?>
</em>)</span>
    <span class="ui_link"><a href="javascript:;">发布成功：</a>(<em><?php echo $this->_tpl_vars['headData']['publish_succeed']; ?>
</em>)</span>
    <span class="ui_link"><a href="javascript:;">发布失败：</a>(<em><?php echo $this->_tpl_vars['headData']['publish_failed']; ?>
</em>)</span>
</div>
<!--S table_filter-->
<div class="table_filter marginBottom10">
	<form action="" method="post" id="tableFilterForm" name="tableFilterForm">    	
    <div id="J_table_filter_main" class="table_filter_main">
        <div class="table_filter_main_row">
            <div class="ui_title">
                订单号：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="order_no" style="vertical-align: top;" /></div>
            <div class="ui_title">
                所属代理商：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="agent_name" style="vertical-align: top;" /></div>
            <div class="ui_title">
                客户名称：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="cus_name" style="vertical-align: top;" /></div>
            <div class="ui_title">
                产品：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select name="pro_type1" id="pro_type1" style="display:none">
                </select>
                <select name="pro_type2" id="pro_type2">
                </select>
            </div>
            <div class="ui_title">
                备案状态：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select class="pri" name="i_backUp">
                    <option value="-1">全部</option>
                    <option value="-2">未备案</option>
                    <option value="2">备案完成</option>
                </select>
            </div>
        </div>
        <div class="table_filter_main_row">
            <div class="ui_title">
                域名：</div>
            <div class="ui_text">
                <input class="inpCommon" type="text" name="web_site" style="vertical-align: top;" /></div>
            <div class="ui_title">
                上线时间：</div>
            <div class="ui_text">
                <input type="text" onfocus="WdatePicker(<?php echo '{maxDate:\'#F{$dp.$D(\\\'J_editTimeE1\\\')}\'}'; ?>
)"
                    name="net_online_time_begin" class="inpCommon inpDate" id="J_editTimeS1">
                至
                <input type="text" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS1\\\')}\'}'; ?>
)"
                    name="net_online_time_end" class="inpCommon inpDate" id="J_editTimeE1">
            </div>
            <div class="ui_title">
                操作时间：</div>
            <div class="ui_text">
                <input type="text" onfocus="WdatePicker(<?php echo '{maxDate:\'#F{$dp.$D(\\\'J_editTimeE2\\\')}\'}'; ?>
)"
                    name="net_publish_time_begin" class="inpCommon inpDate" id="J_editTimeS2">
                至
                <input type="text" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_editTimeS2\\\')}\'}'; ?>
)"
                    name="net_publish_time_end" class="inpCommon inpDate" id="J_editTimeE2">
            </div>
            <div class="ui_title">
                发布状态：</div>
            <div class="ui_comboBox" style="margin-right: 5px;">
                <select class="pri" name="pub_state">
                    <option value="-1">全部</option>
                    <option value="0">未发布</option>
                    <option value="1">发布中</option>
                    <option value="2">发布成功</option>
                    <option value="3">发布失败</option>
                </select>
            </div>
            <div class="ui_button ui_button_search">
                </span>
                <button type="button" class="ui_button_inner" id="AgentSearch" name="AgentSearch"
                    onclick="QueryData()">搜 索</button></div>
        </div>
    </div>
    </form>
</div>
<!--E table_filter-->
<!--S list_link-->
<div id="div_publish_backUp" class="list_link marginBottom10" style="margin:0" m="SitePublish" v="512" ispurview="true">
    <a class="ui_button" href="javascript:;">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner" onclick="publish()">
	    <div class="ui_icon ui_icon_publish"></div>
            <div class="ui_text">网站发布(已备案)</div><!---->
        </div>
    </a>
</div>
<div id="div_publish_un_backUp" class="list_link marginBottom10" m="SitePublish" v="1024" ispurview="true">
    <a class="ui_button" href="javascript:;" style="margin:0">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner" onclick="publish()">
	    <div class="ui_icon ui_icon_publish"></div>
            <div class="ui_text">网站发布(未备案)</div><!---->
        </div>
    </a>
</div>
<div id="div_publish_all" class="list_link marginBottom10" style="display:none;">
    <a class="ui_button" href="javascript:;" style="margin:0;">
        <div class="ui_button_left"></div>
        <div class="ui_button_inner" onclick="publish()">
	    <div class="ui_icon ui_icon_publish"></div>
            <div class="ui_text">网站发布(已备案与未备案)</div><!---->
        </div>
    </a>
</div>
<!--E list_link-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title">
                <span class="ui_icon list_table_title_icon"></span>网营任务列表</h4>
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
                    <th style="width: 30px" title="">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                &nbsp;
                            </div>
                        </div>
                    </th>
                    <th title="订单号">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单号</div>
                        </div>
                    </th>
                    <th title="客户名称/编号" sort="sort_cus_name_id">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                                客户名称/编号</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="代理商名称/编号">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                代理商名称/编号</div>
                        </div>
                    </th>
                    <th title="订单类型" style="width: 80px;">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                订单类型</div>
                        </div>
                    </th>
                    <th title="产品" style="width: 100px;" sort="sort_product_name">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                产品</div>
                            <div class="ui_table_thsort">
                            </div>
                        </div>
                    </th>
                    <th title="域名" style="width: 100px">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                域名</div>
                        </div>
                    </th>
                    <th title="发布状态" style="width: 80px">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                发布状态</div>
                        </div>
                    </th>
                    <th title="备案状态" style="width: 70px" sort="sort_i_backUp">
                    <div class="ui_table_thcntr">
                        <div class="ui_table_thtext">
                            备案状态</div>
                        <div class="ui_table_thsort">
                        </div>
                    </div>
                    </th>
                    <th title="上线时间" style="width: 90px">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                上线时间</div>
                        </div>
                    </th>
                    <th title="操作人" style="width: 120px">
                        <div class="ui_table_thcntr">
                            <div class="ui_table_thtext">
                                操作人</div>
                        </div>
                    </th>
                    <th title="操作时间" width="90px">
                        <div class="ui_table_thcntr ">
                            <div class="ui_table_thtext">
                                操作时间</div>
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
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>
<?php echo '
<script type="text/javascript">
$(function(){
    $GetProduct.Select("pro_type1", "pro_type2",true,2,-1);
    
    $.setPurview();    
    var i_backUp=false;//备案发布
    var un_backUp=false;//未备案发布
    var div_publish_backUp_dsp=document.getElementById("div_publish_backUp");
    if(null != div_publish_backUp_dsp && div_publish_backUp_dsp != undefined)
    {
        var div_publish_un_backUp_dsp=document.getElementById("div_publish_un_backUp");
        var div_publish_all_dsp=document.getElementById("div_publish_all");
        if(div_publish_backUp_dsp.style.display!="none")
        {
            i_backUp=true;
        }
        if(div_publish_un_backUp_dsp.style.display!="none")
        {
            un_backUp=true;
        }
        
        if(i_backUp && un_backUp)
        {
            div_publish_backUp_dsp.style.display="none";
            div_publish_un_backUp_dsp.style.display="none";
            div_publish_all_dsp.style.display="";
        }
    }    
    
    pageList.sortField = "publish_state desc";
'; ?>

    pageList.strUrl="<?php echo $this->_tpl_vars['strUrl']; ?>
";    
<?php echo '
    pageList.param = \'&\'+$("#tableFilterForm").serialize();
    pageList.init(); 
 });
 
 
function QueryData()
{
    pageList.param = \'&\'+$("#tableFilterForm").serialize();
    pageList.first();
}

var _InDealWith = false;
function publish(){
    
	if (_InDealWith) 
	{
		IM.tip.warn("数据已提交，正在处理中！");
		return false;
	}
    var oids=$("#pageListContent input:checked").map(function () {
                return this.value;
            }).get();
    if(oids=="")
    {
        IM.tip.warn("请选择订单");
        return false;   
    }
    
    var param="oids="+oids;
    //标识发布中
    _InDealWith = true;
    
    MM.ajax({
        url:\'/?d=TM&c=NetOpe&a=SitePublish\',
        data:param,
        success:function(q){
            //alert(q);return false;
            q=MM.json(q);
            if(q.success){
                //通知网营发布网站
                window.open("/WebService/NetCampsitePub.php?orderID="+oids+"",\'发布网站\',
                \'height=100, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no,resizable=no,location=no, status=no\');
                
                //IM.tip.show(q.msg);
                _InDealWith = false;
            }else{
                IM.tip.warn(q.msg);
                    _InDealWith = false;
            }
        }
    });
}
'; ?>

</script>