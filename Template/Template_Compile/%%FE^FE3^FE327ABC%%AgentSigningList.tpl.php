<?php /* Smarty version 2.6.26, created on 2013-01-29 17:10:40
         compiled from Agent/AgentSigningList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/AgentSigningList.tpl', 16, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：我的渠道<span>&gt;</span>代理商列表</div>
<!--E crumbs-->
<div class="form_edit">
  <div class="form_hd">
    <ul>
      <li class="cur">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>签约代理商</h2>
            </div>
          </div>
        </div>
      </li>
      <li> <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'agentPotentialList'), $this);?>
');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>潜在代理商</h2>
            </div>
          </div>
        </div>
        </a> </li>
    </ul>
  </div>
</div>
<!--S form_bd-->
<div class="form_bd">
  <div class="form_block_bd"> 
<div class="table_attention marginBottom10">
    <label>温馨提示：培训次数和沟通次数的统计以合同部对该代理商的合同审核通过后开始计算，并且只针对拜访小记中进行统计</label>
</div> 
    <!--S table_filter-->
    <div class="table_filter marginBottom10">
      <form action="" method="post" name="tableFilterForm" id="tableFilterForm">
        <div class="table_filter_main" id="J_table_filter_main">
          <div class="table_filter_main_row">
            <div class="ui_title">代理商名称：</div>
            <div class="ui_text">
              <input style="width:200px" type="text" name="agent_name" id="agent_name"/>
            </div>
            <div class="ui_title">行业：</div>
            <?php echo '
            <div id="ui_comboBox_IntentionRating" onclick="IM.comboBox.init({\'control\':\'industry\',data:MM.A(this,\'data\')},this)" 
                            '; ?>

                             class="ui_comboBox ui_comboBox_def" key="" value="" control="industry" data="<?php echo $this->_tpl_vars['industry']; ?>
" style="width:120px;">
              <div class="ui_comboBox_text" style="width:110px;"> <nobr>全部</nobr> </div>
              <div class="ui_icon ui_icon_comboBox" style="margin:-16px 0 0;"></div>
            </div>
            <div class="ui_title">共享账号：</div>
                            <div class="ui_text"><input style="width:100px" type="text" name="share_no" id="share_no"/></div>
           
            <div class="ui_title">联系号码：</div>
            <div class="ui_text">
              <input style="width:100px" type="text" name="contact_no" id="contact_no"/>
            </div>
          </div>
          <div class="table_filter_main_row">
            <div class="ui_title">代理商代码：</div>
            <div class="ui_text">
              <input style="width:100px" type="text" name="agent_no" id="agent_no"/>
            </div>
            <div class="ui_title">代理商类型：</div>
            <div class="ui_comboBox">
              <select id="agent_type" name="agent_type">
                <option value="-100">全部</option>
                <option value="1">核心</option>
                <option value="2">非核心</option>
              </select>
            </div>
            <div class="ui_title">签约产品：</div>
            <div id="ui_comboBox_agentPro" onClick="IM.comboBox.init(<?php echo '{\'control\':\'agentPro\',data:MM.A(this,\'data\')}'; ?>
,this)" class="ui_comboBox ui_comboBox_def" key="" value="" data='<?php echo $this->_tpl_vars['arrProductType']; ?>
' style="width:100px;">
              <div class="ui_comboBox_text" style="width:80px;"> <nobr>全部</nobr> </div>
              <div class="ui_icon ui_icon_comboBox"></div>
            </div>
              <div class="ui_title">注册地区：</div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selProvince" class="pri" name="cbProvince"></select></div>
                        <div class="ui_comboBox" style="margin-right:5px;"><select id="selCity" class="city" name="cbCity"></select></div>
                        <div class="ui_comboBox"><select id="selArea" class="area" name="cbArea"></select></div>  
            
          </div>
          <div class="table_filter_main_row">
                <div class="ui_title">最后联系时间：</div>
            <div class="ui_text">
              <input id="J_contactTimeS2" type="text" class="inpCommon inpDate" name="J_contactTimeS" onfocus="WdatePicker(<?php echo '{onpicked:function(){($dp.$(\'J_contactTimeE2\')).focus()},maxDate:\'#F{$dp.$D(\\\'J_contactTimeE2\\\')}\'}'; ?>
)"/>
              至
              <input id="J_contactTimeE2" type="text" class="inpCommon inpDate" name="J_contactTimeE" onfocus="WdatePicker(<?php echo '{minDate:\'#F{$dp.$D(\\\'J_contactTimeS2\\\')}\'}'; ?>
)"/>
            </div>
            <div class="ui_button ui_button_search">
              <button type="button" class="ui_button_inner" onclick="searchChannel();">搜 索</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!--E table_filter--> 
    <!--S list_link--> 
    
    <!--E list_link--> 
    <!--S list_table_head-->
    <div class="list_table_head">
      <div class="list_table_head_right">
        <div class="list_table_head_mid">
          <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 代理商列表</h4>
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
              <th style="width:100px;" title="代理商代码"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">代理商代码</div>
                </div>
              </th>
              <th style="width:150px" title="代理商名称"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">代理商名称</div>
                  <div class="ui_table_thsort" sort="sort_agent_name"></div>
                </div>
              </th>
              <th  style="width:60px;" title="行业"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">行业</div>
                </div>
              </th>
              <th style="width:80px;" title="签约产品"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">签约产品</div>
                </div>
              </th>
              <th style="width:80px;" title="共享账号"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">共享账号</div>
                </div>
              </th>
              <th style="width:65px" title="代理类型"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">代理类型</div>
                </div>
              </th>
              <th style="width:80px;" title="培训次数"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">培训次数</div>
                  <div class="ui_table_thsort" sort="sort_train_number"></div>
                </div>
              </th>
              <th style="width:80px;" title="沟通次数"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">沟通次数</div>
                  <div class="ui_table_thsort" sort="sort_communicate_number"></div>
                </div>
              </th>
              <th style="width:100px" title="联系电话"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">联系电话</div>
                </div>
              </th>
              <th style="width:180px" title="最后联系时间和类型"> <div class="ui_table_thcntr">
                  <div class="ui_table_thtext">最后联系时间和类型</div>
                  <div class="ui_table_thsort" sort="sort_last_time"></div>
                </div>
              </th>
              <th style="width:150px" title="操作"> <div class="ui_table_thcntr ">
                  <div class="ui_table_thtext">操作</div>
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
      <div id="divPager" class="ui_pager"></div>
    </div>
    <!--E list_table_foot--> 
  </div>
</div>
<!--E form_bd--> 
<script type="text/javascript" src="<?php echo $this->_tpl_vars['JS']; ?>
pageCommon.js"></script> 
<script type="text/javascript">
        <?php echo '
 $(function(){
 	$("#selProvince").BindProvince({selCityID:"selCity",selAreaID:"selArea",iAddPleaseSelect:true});
        '; ?>

	pageList.strUrl = "<?php echo $this->_tpl_vars['strUrl']; ?>
"; 
        <?php echo '
        pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.init();
 });
 
 function searchChannel()
 {	
    var industry   = $("#ui_comboBox_IntentionRating").attr("key");
    var productType = $("#ui_comboBox_agentPro").attr("value");
	pageList.param = \'&\'+$("#tableFilterForm").serialize()+\'&industry=\'+industry+\'&productType=\'+encodeURIComponent(productType);
	pageList.first();
 }

 function QueryData()
 {
	pageList.param = \'&\'+$("#tableFilterForm").serialize();
	pageList.first();
 }
 
_InDealWith = false;
 function ToSea(agentID)
 {    
    if(agentID == 0)
    {
        var chkID = document.getElementsByName("listid");
        var ids = "";
    	for(var i = 0;i < chkID.length;i++)
    	{
    		if(chkID[i].checked && chkID[i].disabled == false)
            {
    			ids += "," + chkID[i].value;
            }
    	}
            
    	if(ids.length > 1)
            agentID = ids.substring(1, ids.length);
        else
        {
            IM.tip.warn("请选择代理商！");
            return ;
        }
    }

    if(!confirm("你确定要将代理商踢入公海吗？"))
		return false;
        
    if (_InDealWith) 
    {
    	IM.tip.warn("数据已提交，正在处理中！");
    	return false;
    }

    _InDealWith = true;
    var backData = $PostData(\'/?d=Agent&c=HighSeas&a=InSea&ids=\'+agentID); 
    if(parseInt(backData) == 0){
        pageList.reflash();
	    _InDealWith = false;
        IM.tip.show("操作成功！");
	}else{
        _InDealWith = false;
        IM.tip.warn(backData);
	}
 }
function setShare(agentId)
{      
     IM.dialog.show({
            width: 550,
            title: \'共享操作\',
            html: IM.STATIC.LOADING,
            start:function(){
                $(\'.DCont\')[0].innerHTML= $PostData("/?d=Agent&c=Agent&a=showShareAgent","agentId="+agentId);          
		var J_auditerName=$(\'#shareName\');
		J_auditerName.autocomplete(\'/?d=Agent&c=TaskAssign&a=AutoCompleteById\',{
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
									result:q[i].name
								}
							}
							return parsed;
						},
						formatItem:function(item){
							return \'<em>\'+item.name+\'</em>\';
						}
					}).result(function(item,value){						
                        $(\'#J_user_id\').val(value.user_id);
					});
                
            
           new Reg.vf($(\'#J_shareAgent\'),{callback:function(formData){                                              
                    var postData = $("#J_shareAgent").serialize();                                           
                    var backData = $PostData("/?d=Agent&c=Agent&a=setShareAgent",postData);
                    
                    if(backData == 0)
                    {
                        IM.dialog.hide();	
                	IM.tip.show("共享成功！");
                        
                        pageList.reflash();
                    }    
                    else
                    {
                        IM.tip.warn(backData);
                                           
                    } 
                }});
          }
            
        });
}
function cancelShare(agentId)
{
       IM.dialog.show({
            width: 400,
            title: \'取消共享\',
            html: IM.STATIC.LOADING,
            start:function(){
                $(\'.DCont\')[0].innerHTML= \'<div class="DContInner">\'+
                                           \'<form id="J_cancelShare">\'+
                                           \'<div class="form_edit">\'+        
                                           \'<div class="form_block_hd"><input type ="hidden" name="agentId" value="\'+agentId+\'" />您确定要取消共享吗？取消后该代理商信息将不在非所属人私库中显示</div>\'+          
                                            \'</div>\'+
                                                \'<div class="ft">\'+
                                                    \'<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">关闭</a></div>\'+
                                                    \'<div class="ui_button ui_button_confirm"><button type="submit"  id="moveSubmit" class="ui_button_inner">确 定</button></div>\'+
                                                \'</div>\'+
                                            \'</form>\'+
                                        \'</div>\';    		
                           
               new Reg.vf($(\'#J_cancelShare\'),{callback:function(formData){  
                    var postData = $("#J_cancelShare").serialize();                                                                                                         
                    var backData = $PostData("/?d=Agent&c=Agent&a=cancelShareAgent",postData);                    
                    if(backData == 0)
                    {
                        IM.dialog.hide();	
                	IM.tip.show("取消成功！");                        
                        pageList.reflash();
                    }    
                    else
                    {
                        IM.tip.warn(backData);
                                           
                    } 
                }});
          }
            
        });
}
        '; ?>

    </script> 