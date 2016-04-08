<?php /* Smarty version 2.6.26, created on 2013-01-07 14:30:16
         compiled from CM/TransferBack.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'CM/TransferBack.tpl', 2, false),)), $this); ?>
<!--S crumbs-->
	<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showBackInfoList'), $this);?>
')">客户查询</a><span>&gt;</span>客户资料转移</div>
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
<!--                                                        <div class="ui_table_thtext">
                                                            <input onClick="IM.table.selectAll(this.checked);IM.table.checkAll('listid');" class="checkInp" type="checkbox" />
                                                        </div>-->
                                                    </div>
                                                </th>
                                                <th style="width:70px" title="客户ID">
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
                    <input id="customer_ids" name="customer_ids" type="hidden" value="<?php echo $this->_tpl_vars['customer_ids']; ?>
"/>
                                        
<!--                                        <div class="tf">
						<label>意向产品：</label>
						<div class="inp">
                                                    <?php echo '
                                                        <div id="ui_comboBox_intentionPro" onclick="IM.comboBox.init({\'control\':MM.A(this,\'control\'),data:MM.A(this,\'data\')},this)" class="ui_comboBox ui_comboBox_def" control="intentionPro" key="" value="" data='; ?>
'<?php echo $this->_tpl_vars['arrJsonType']; ?>
'<?php echo ' style="width:120px;">
                                                    '; ?>

                                                    
                                                    <div style="width:100px;" class="ui_comboBox_text">
                                                            <nobr>请选择</nobr>
                                                    </div>
                                                    <div class="ui_icon ui_icon_comboBox"></div>                        
                                                </div>
                                                </div>
						<span class="info">请输入意向产品</span>
						<span class="ok">&nbsp;</span><span class="err">请输入意向产品</span>
					</div>-->
					<div class="tf">
						<label><em class="require">*</em>所属代理商：</label>
						<div class="inp">
                            <input type="text" id="J_subordinateAgent" autocomplete="off" name="to_anget_Name" class="subordinateAgent" valid="required"/>
							<input name="to_anget_id" id="to_anget_id" type="hidden" value="-1" />
                        </div>
						<span class="info">请输入代理名称或者主账号</span>
						<span class="ok">&nbsp;</span><span class="err">请输入代理名称或者主账号</span>
					</div>                        
					<div class="tf tf_submit" style="height:150px;">
						<label>&nbsp;</label>
						<div class="inp">
                                                    <div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner">确  认</button></div>
                                                    <div class="ui_button ui_button_cancel"><a class="ui_button_inner" href="javascript:;" onClick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'CM','c' => 'CMInfo','a' => 'showBackInfoList'), $this);?>
')">取  消</a> </div>
                            	
						</div>
					</div>
                </form>
                </div>
	</div>               
</div>
<!--E sidenav_neighbour-->
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script>
	<script type="text/javascript"><!--
	<?php echo '
	$(function(){
        '; ?>

    	pageList.strUrl="<?php echo $this->_tpl_vars['strUrl']; ?>
"; 
    	<?php echo '
    	pageList.param = "&"+$(\'#tableFilterForm\').serialize();
    	pageList.init();
        $(\'#J_subordinateAgent\').autocomplete(\'/?d=CM&c=CMTransfer&a=getAgentName_ID\', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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
                                    result: value[i].no +"("+ value[i].user_name +")("+value[i].name +")"
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return "<div>" + item.no +"("+ item.user_name +")("+item.name +")"+ "</div>";
                        }
                    }).result(function (data,value) {//执行模糊匹配
                        var id = value.id;
                        $("#to_anget_id").val(id);
        		    });
        new Reg.vf($(\'#tableFilterForm\'),{callback:function(data){
    	    //异步提交数据
//            var listid = IM.table.getListID();
//            if(listid.length == 0)
//            {
//                IM.tip.warn(\'请选择要转移的客户\');
//                return false;
//            }
            listid = $(".listid").val();
            if($("#to_anget_id").val()=="-1")
            {
                IM.tip.warn(\'请选择代理商\');
                return false;
            }
                //var inten_product = $.trim(MM.A(MM.G(\'ui_comboBox_intentionPro\'),\'key\'));+\'&inten_product=\'+inten_product
        	$.ajax({
        			type:\'POST\',
        			data:$(\'#tableFilterForm\').serialize()+"&listid="+listid,//+"&IntentionRating="+$("#ui_comboBox_IntentionRating").attr("key"), //.join(","),
        			url:\'/?d=CM&c=CMTransfer&a=goTransfetCustomer\',
                                dataType:"json",
        			success:function(data)
        			{
                                    if(data.success){
                                        IM.tip.show(data.msg);
                                        JumpPage(data.url);
                                    }else{
                                        IM.tip.warn(data.msg);
                                    }
//        			    if(data==1)
//                                    {
//                                        IM.tip.show(\'转移成功\');
//                                        JumpPage(\'/?c=CMInfo&d=CM&a=showBackInfoList\');
//                                    }
//                                    
//                                     else if(data == 2)
//                                    {
//                                       IM.dialog.hide();
//                                        IM.tip.warn(\'转移失败,该客户已存在订单\');
//                                    }
//                                      else if(data == 3)
//                                    {
//                                       IM.dialog.hide();
//                                        IM.tip.warn(\'转移失败,存在未审核通过的客户\');
//                                    }  
//                                    else
//                                    {
//                                        IM.tip.warn(data);   
//                                    }
                    }
        		});
            }});
        });
	'; ?>

	--></script>
