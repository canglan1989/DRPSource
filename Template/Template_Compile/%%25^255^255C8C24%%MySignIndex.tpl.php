<?php /* Smarty version 2.6.26, created on 2013-03-12 10:30:13
         compiled from Agent/MySignIndex.tpl */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<?php echo $this->_tpl_vars['strPath']; ?>
</div>
<!--E crumbs-->   
<div class="table_attention marginBottom10">
    <label>提醒信息：</label>
    <span class="ui_link"><a href="javascript:;" onclick="searchAgent(1)">新签：</a>(<em><?php echo $this->_tpl_vars['countRst']['0']['A']; ?>
</em>)</span>
    <span class="ui_link"><a href="javascript:;" onclick="searchAgent(2)">续签：</a>(<em><?php echo $this->_tpl_vars['countRst']['0']['B']; ?>
</em>)</span>
    <span class="ui_link"><a href="javascript:;" onclick="searchAgent(3)">失效：</a>(<em><?php echo $this->_tpl_vars['countRst']['0']['C']; ?>
</em>)</span>
    <span class="ui_link"><a href="javascript:;" onclick="searchAgent(4)">审核退回：</a>(<em><?php echo $this->_tpl_vars['countRst']['0']['D']; ?>
</em>)</span>
    <span class="ui_link"><a href="javascript:;" onclick="searchAgent(5)">解除签约：</a>(<em><?php echo $this->_tpl_vars['countRst']['0']['E']; ?>
</em>)</span>
    <br/>
        关于预存款金额以及状态的相关说明：
        1、未到账：预存款金额账户为0。
        2、部分到账：预存款金额账户大于零小于框架合同上预存款金额。
        3、全部到账：预存款金额账户大于等于框架合同上预存款金额。
</div> 
<!--S table_filter-->
<div class="table_filter marginBottom10">  
    <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
            <div class="table_filter_main_row">  
                <div class="ui_title">代理商名称：</div>
                <div class="ui_text"><input id="agent_name" style="width:200px" type="text" name="agent_name"/></div>
                <div class="ui_title">地区：</div>
                <div class="ui_comboBox" style="margin-right:5px;">
                    <select class="pri" name="pri" id="selProvince"></select>
                </div>
                <div class="ui_comboBox" style="margin-right:5px;">
                    <select class="city" name="city" id="selCity"></select>
                </div>
                <div class="ui_comboBox">
                    <select class="area" name="area" id="selArea"></select>
                </div>
                <div class="ui_title">代理产品：</div>
            <?php echo '<div style="width:100px;" id="ui_comboBox_agentPro" data='; ?>
'<?php echo $this->_tpl_vars['arrProductType']; ?>
'<?php echo ' value="" key="" control="agentPro" class="ui_comboBox ui_comboBox_def" onclick="IM.comboBox.init({\'control\':MM.A(this,\'control\'),data:MM.A(this,\'data\')},this)">'; ?>

                <div style="width:80px;" class="ui_comboBox_text">
                    <nobr>全部</nobr>
                </div>
                <div class="ui_icon ui_icon_comboBox"></div>                        
            </div> 
            <div class="ui_button ui_button_search"><button type="button" class="ui_button_inner" onclick="searchAgent('-1')">搜 索</button></div>
        </div>
    </div>
</form>
</div>
<!--E table_filter-->
<!--S list_table_head-->
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> <?php echo $this->_tpl_vars['strTitle']; ?>
</h4>
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
                <tr class="">
                    <th title="代理商代码" style="width:84px;">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理商代码</div>
            </div>
            </th>
            <th title="代理商名称" style="">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">代理商名称</div>
<!--                <div class="ui_table_thsort"></div>-->
            </div>
            </th>
            <th title="注册地区" style="">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">注册地区</div>
            </div>
            </th>
            <th title="代理产品" style="width:60px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理产品</div>
<!--                <div class="ui_table_thsort"></div>-->
            </div>
            </th>
            <th title="代理模式" style="width:60px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理模式</div>
            </div>
            </th>
            <th title="代理产品等级" style="width:50px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">代理产品等级</div>
            </div>
            </th>
            <th title="合同有效期" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">合同有效期</div>
<!--                <div class="ui_table_thsort"></div>-->
            </div>
            </th>
            <th title="虚拟合同号" style="width:60px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">虚拟合同号</div>
            </div>
            </th>                        
            <th title="签约类型" style="width:60px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">签约类型</div>
            </div>
            </th>
            <th title="签约状态" style="width:60px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">签约状态</div>
            </div>
            </th>
            <!--<th title="保证金金额及状态" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">保证金金额及状态</div>
            </div>
            </th>
            <th title="预存款金额及状态" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">预存款金额及状态</div>
            </div>
            </th>-->
            <th title="提交人" style="width:60px">
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">提交人</div>
            </div>
            </th>
            <th title="提交时间" >
            <div class="ui_table_thcntr">
                <div class="ui_table_thtext">提交时间</div>
            </div>
            </th>                        
            <th title="操作">
            <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">操作</div>
<!--                <div class="ui_table_thsort"></div>-->
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
<script language="javascript" type="text/javascript">
    <?php echo '
$(document).ready(function(){
    pageList.strUrl='; ?>
"<?php echo $this->_tpl_vars['strUrl']; ?>
"<?php echo ';
    pageList.init();
    $("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
});
    
 function searchAgent(type)
 {
    var productIds = $.trim(MM.A(MM.G(\'ui_comboBox_agentPro\'),\'key\'));
    var agentName = $.trim($(\'#agent_name\').val());
    var provinceId = $(\'#selProvince\').val();
    var cityId = $(\'#selCity\').val();
    var areaId = $(\'#selArea\').val();
    pageList.page = 1;
    pageList.param = \'&agentName=\'+encodeURIComponent(agentName)+\'&provinceId=\'+provinceId+\'&cityId=\'+cityId+\'&areaId=\'+areaId+\'&pid=\'+productIds+\'&type=\'+type;
    pageList.first();
 }

var _InDealWith = false;
 function RemoveSign(pactID,pactNo,agentName)
 {
    IM.dialog.show({
        width: 600,
	    height: null,
	    title: \'解除签约\',
	    html: IM.STATIC.LOADING,
        start:function(){
                MM.get("/?d=Agent&c=AgentPact&a=RemoveSignModify","pactID="+pactID+\'&pactNo=\'+encodeURIComponent(pactNo)+\'&agentName=\'+encodeURIComponent(agentName),function(q){
                $(\'.DCont\')[0].innerHTML= q;
                
                new Reg.vf($(\'#J_backForm\'),{callback:function(formData){
                    //数据已提交，正在处理标识
                	if (_InDealWith) 
                	{
                		IM.tip.warn("数据已提交，正在处理中！");
                		return false;
                	}
                    
                    if(!confirm("你确定要解除签约吗？"))
                		return false;
        
                    var postData = $("#J_backForm").serialize();
                    
                    _InDealWith = true;   
                    var backData = $PostData("/?d=Agent&c=AgentPact&a=RemoveSignModifySubmit",postData);
                    if(backData == 0)
                    {
    			        IM.dialog.hide();
                        _InDealWith = false;
                        IM.tip.show("解除签约成功！");
                        pageList.reflash();
                    }
                    else
                    {
                        IM.tip.warn(backData);
                        _InDealWith = false;
                    }
                }});
            })
        }
    });
 }
    '; ?>

</script>		    