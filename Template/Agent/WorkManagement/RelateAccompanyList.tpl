  <div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>工作管理<span>&gt;</span>陪访小记列表</div>
<div class="list_table_head">
    <div class="list_table_head_right">
 	<div class="list_table_head_mid">
		<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>{$strTitle}</h4>
<!--  <a class="ui_button ui_link" onclick="pageList.reflash()" href="javascript:;"><span class="ui_icon ui_icon_fresh">&nbsp;</span>刷新</a>  -->   
    </div>
    </div>
    </div>
    
    <div class="list_table_main">
    	<div id="J_ui_table" class="ui_table">
        	<table width="100%" cellspacing="0" cellpadding="0" border="0">
            	<thead class="ui_table_hd">
                	<tr>
                        <th width="70" title="制定人">
                        	<div class="ui_table_thcntr" sort="sort_e_name">
                            	<div class="ui_table_thtext">制定人</div>
                            </div>
                        </th>
                        <th width="" title="制定时间">
                        	<div class="ui_table_thcntr" sort="sort_create_time">
                            	<div class="ui_table_thtext">制定时间</div>
                            </div>
                        </th>
                        <th title="拜访时间">
                        	<div class="ui_table_thcntr" sort="sort_visitor">
                            	<div class="ui_table_thtext">拜访时间</div>
                            </div>
                        </th>
                        <th title="被访人姓名">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">被访人姓名</div>
                            </div>
                        </th>
                        <th title="被访人联系电话">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">被访人联系电话</div>
                            </div>
                        </th>
                        <th title="陪访内容">
                        	<div class="ui_table_thcntr " sort="sort_title">
                            	<div class="ui_table_thtext">陪访内容</div>
                            </div>
                        </th>
                        <th title="审查状态">
                        	<div class="ui_table_thcntr " sort="sort_result">
                            	<div class="ui_table_thtext">审查状态</div>
                            </div>
                        </th>
                        <th title="回访状态/回访人">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">回访状态/回访人</div>
                            </div>
                        </th>
                        <th title="操作">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">操作</div>
                            </div>
                        </th>
                   </tr>
               </thead>
               <tbody class="ui_table_bd" >
               {foreach from=$arrayRelateAccompanyList item=data key=index}
                <tr class="{sdrclass rIndex=$index}">
                	<td title="{$data.e_name}" ><div class="ui_table_tdcntr"><a onclick="UserDetial({$data.user_id})" href="javascript:;">{$data.e_name}</a></div></td>
                	<td title="{$data.create_time}" ><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                    <td title="{$data.s_time}" ><div class="ui_table_tdcntr">{$data.s_time}/{$data.e_time}</div></td>
                    
                	<td title="{$data.visitor}" ><div class="ui_table_tdcntr">{$data.visitor}</div></td>
                    <td title="{$data.tel}" ><div class="ui_table_tdcntr">{$data.tel}</div></td>
                    <td title="{$data.content}" ><div class="ui_table_tdcntr">{$data.ac_content}</div></td>
                    <td title="{$data.check_statu}" ><div class="ui_table_tdcntr">
                    {if $data.check_statu == 0}
                    未审查
                    
                    {elseif $data.check_statu == 1}
                    <a m="AccompanyVisit" v="2" ispurview="true" href="javascript:;" 
                       onclick="ShowCheckDetial({$data.id})">审查通过</a>
                    
                    {elseif $data.check_statu == 2}
                    <a m="AccompanyVisit" v="2" ispurview="true" href="javascript:;" 
                       onclick="ShowCheckDetial({$data.id})">审查未通过</a>
                    
                    {/if}
                    </div></td>
                    <td title="" ><div class="ui_table_tdcntr">{if $data.rname != ''}已回访/{$data.rname}{else}未回访{/if}</div></td>
                    <td title="审查" >
                    <div class="ui_table_tdcntr">
                        <ul class="list_table_operation">
                            {if $data.check_statu == 0 || $data.check_statu == 2}
                            <li>
                                <!--
<a m="AccompanyVisit" v="2" ispurview="true" href="javascript:;" 
                       onclick="IM.Agent.addRecord('/?d=WorkM&c=AccompanyVisit&a=CheckAccompanyVisit&id={$data.id}',{literal}{{/literal}id:{$data.id}{literal}}{/literal},'审查陪访小记',700)">审查</a>
                            
--><a m="AccompanyVisit" v="32" ispurview="true" href="javascript:;" 
                       onclick="ShowCheckForm({$data.id})">审查</a></li>
     {if $uid == $data.user_id}
      <li><a m="AccompanyVisit" v="2" ispurview="true" href="javascript:;" 
                       onclick="ModifyAccompanyVisit({$data.id})">编辑</a>   </li> {/if}{/if} 
      {if $data.rname == ''}
      <li><a href="javascript:;" onclick="IM.Agent.addVisitRecord('/?d=WorkM&c=AccompanyVisit&a=ShowAddReturnVisit',{literal}{{/literal}id:{$data.id}{literal}}{/literal},'添加回访记录')">回访</a></li>
      {/if}
                                       
                            
                              
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
    
<script language="javascript" type="text/javascript">
{literal}

function ModifyAccompanyVisit(id)
{
    IM.dialog.show({
            width: 700,
    	    height: null,
    	    title: "编辑陪访小记",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=WorkM&c=AccompanyVisit&a=ModifyAccompanyVisit&id="+id, {}, function (backData) {
    		    $('.DCont')[0].innerHTML = backData;
                new Reg.vf($('#J_AccomModForm'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
                var formValues = $('#J_AccomModForm').serialize();
                
             $.ajax({
                    type: "POST",
                    dataType: "text", 
                    url: "/?d=WorkM&c=AccompanyVisit&a=AccompanyVisitSubmit&id="+id,
                    data: formValues,
                    success: function (q) {
                        q=MM.json(q);
                         if(q.success)
                    		{
				                IM.tip.show(q.msg);                                
                                IM.dialog.hide();
                                {/literal}
                                JumpPage("/?d=WorkM&c=AccompanyVisit&a=RelateAccompany&visitnoteid="+{$visitnoteid});
                                {literal}
                    		}
                    		else
                            {
                                IM.tip.warn(q.msg);
                            }    
                                        
                    }
                });
            }});
                });
          }
    });
}
function ShowCheckForm(id)
{  
    IM.dialog.show({
            width: 700,
    	    height: null,
    	    title: "审核陪访小记",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    		MM.get("/?d=WorkM&c=AccompanyVisit&a=CheckAccompanyVisit&id="+id, {}, function (backData) {
    		    $('.DCont')[0].innerHTML = backData;
                new Reg.vf($('#J_CheckForm'),{callback:function(formdata){////formdata 表单提交数据 对象数组格式
                var formValues = $('#J_CheckForm').serialize();
                
             $.ajax({
                    type: "POST",
                    dataType: "text", 
                    url: "/?d=WorkM&c=AccompanyVisit&a=CheckAccompanyVisitSubmit&id="+id,
                    data: formValues,
                    success: function (q) {
                        q=MM.json(q);
                         if(q.success)
                    		{
				                IM.tip.show(q.msg);                                
                                IM.dialog.hide();
                                {/literal}
                                JumpPage("/?d=WorkM&c=AccompanyVisit&a=RelateAccompany&visitnoteid="+{$visitnoteid});
                                {literal}
                    		}
                    		else
                            {
                                IM.tip.warn(q.msg);
                            }    
                                        
                    }
                });
            }});
                });
          }
    });
}

/**
     * @url 获取模板请求地址
     * @data 附带参数
     * @title 标题    
     */
    IM.Agent.addVisitRecord=function(url,data,title){
        IM.dialog.show({
            width:500,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
				MM.get(url,data,function(q){
                    $('.DCont')[0].innerHTML=q; 
                                        new Reg.vf($('#J_addVisitRecord'),{
                                                callback:function(formData){
                                                        MM.ajax({
                                                            {/literal}
                                                                url:'/?d=WorkM&c=AccompanyVisit&a=ReturnVisitSubmit&id',//提交地址{literal}
                                                                data:formData,
                                                                success:function(q){
                                                                        q=MM.json(q);
                                                                        IM.dialog.hide();
                                                                        if(q.success){										
                                                                                IM.tip.show(q.msg);
                                                                                {/literal}
                                                                                JumpPage("/?d=WorkM&c=AccompanyVisit&a=RelateAccompany&visitnoteid="+{$visitnoteid});
                                                                                {literal}
                                                                        }else{
                                                                                IM.tip.warn(q.msg);
                                                                        }
                                                                }
                                                        });
                                                }
                                        });
                });                                               
            }
            });	
    }
function ShowCheckDetial(id)
{
        IM.dialog.show({
            width: 600,
    	    height: null,
    	    title: "审查陪访小记",
    	    html: IM.STATIC.LOADING,
    	    start: function () {
    	       MM.get("/?d=WorkM&c=AccompanyVisit&a=CheckDetial&id="+id, {}, function (backData) {
    		    $('.DCont')[0].innerHTML = backData;
                })
    	    }
            })
            
}
    {/literal}
</script>