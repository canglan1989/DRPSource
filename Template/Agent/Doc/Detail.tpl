<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：代理商管理<span>&gt;</span>运营管理<span>&gt;</span>{$strTitle}</div>
<!--E crumbs--> 
<!--S form_edit-->
<div class="form_edit">
  <div class="form_hd">
    <ul>
      <li> <a href="javascript:;" onclick="JumpPage('/?d=Agent&c=Agent&a=showAgentinfoAddContact&agentId={$agentInfo->iAgentId}');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>代理商信息</h2>
            </div>
          </div>
        </div>
        </a> </li>
      <li> <a href="javascript:;" onclick="JumpPage('{au d='Agent' c='Agent' a='showAgentDetailInfo'}&agentId={$agentInfo->iAgentId}');">
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>联系信息</h2>
            </div>
          </div>
        </div>
        </a> </li>
      <li class="cur"> 
        <div class="form_hd_left">
          <div class="form_hd_right">
            <div class="form_hd_mid">
              <h2>{$strTitle}</h2>
            </div>
          </div>
        </div>
        </li>
    </ul>
    <div class="form_hd_oper"><a onclick="JumpPage('{au d="Agent" c="AgentDoc" a="DocList"}&agentNo={$agentInfo->strAgentNo}')" 
        class="ui_button ui_link"><span class=" ui_icon_edit">&nbsp;</span>查看更多 >></a> 
    <a v="4" m='AgentDocList' ispurview="true" onclick="JumpPage('{au d="Agent" c="AgentDoc" a="Upload"}&id={$agentInfo->iAgentId}')" 
        class="ui_button ui_link"><span class=" ui_icon_edit">&nbsp;</span>上传附件</a> </div>
  </div>
  <!--S form_bd-->
  <div class="form_bd">
    <div class="form_block_bd">
      <div class="form_bd">
        <div class="form_block_hd ">
          <h3 class="ui_title">代理商名称：{$agentInfo->strAgentName}</h3>
           </div>
            <div style="margin:0 10px 10px;" class="table_attention"><span class="ui_link">以下列表只显示最近五条记录。</span></div>
        <div class="list_table_head">          
        <div class="list_table_head_right">
        <div class="list_table_head_mid">
        	<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>资质</h4>       
        </div>
        </div>
        </div>
        <!--E list_table_head-->        
        <!--S list_table_main-->
        <div class="list_table_main marginBottom10">
        	<div id="J_ui_table" class="ui_table">
            	<table width="100%" cellspacing="0" cellpadding="0" border="0">
                	<thead class="ui_table_hd">
                	<tr>
                    	<th title="附件名称">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">附件名称</div>
                            </div>
                        </th>
                        <th style="width:140px;" title="添加人">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">添加人</div>
                            </div>
                        </th>
                        <th style="width:150px;" title="添加时间">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">添加时间</div>
                            </div>
                        </th>
                   </tr>
                   </thead>
                   <tbody class="ui_table_bd" >
                   {foreach from=$arrayQualification item=data key=index}                   
                      <tr class="{sdrclass rIndex=$index}">
                      {if $data.aid<=0}
                        <td title=""><div class="ui_table_tdcntr">{$data.permit_name}(未上传)</div></td>
                        <td title=""><div class="ui_table_tdcntr">--</div></td>
                        <td title=""><div class="ui_table_tdcntr">--</div></td>
                      {else}
                        <td title=""><div class="ui_table_tdcntr">                        
                        <a href="javascript:;" onclick="DownLoadPermit('{$data.file_path}.{$data.file_ext}','{$data.permit_name}.{$data.file_ext}')">{$data.permit_name}</a>                        
                        </div></td>
                        <td title=""><div class="ui_table_tdcntr">                        
                        <a onclick="UserDetial({$data.create_uid});" href="javascript:;">{$data.create_user_name}</a>                        
                        </div></td>
                        <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                        {/if}
                      </tr>
                   {/foreach}
                   </tbody>
               </table>   
            </div>
            <!--E ui_table-->
        </div>
        <!--E list_table_main-->
        <div class="list_table_head">          
        <div class="list_table_head_right">
        <div class="list_table_head_mid">
        	<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>培训课件</h4>       
        </div>
        </div>
        </div>
        <!--E list_table_head-->        
        <!--S list_table_main-->
        <div class="list_table_main marginBottom10">
        	<div id="J_ui_table" class="ui_table">
            	<table width="100%" cellspacing="0" cellpadding="0" border="0">
                	<thead class="ui_table_hd">
                	<tr>
                    	<th title="附件名称">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">附件名称</div>
                            </div>
                        </th>
                    	<th style="width:120px;" title="作者">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">作者</div>
                            </div>
                        </th>
                        <th style="width:140px;" title="添加人">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">添加人</div>
                            </div>
                        </th>
                        <th style="width:150px;" title="添加时间">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">添加时间</div>
                            </div>
                        </th>
                        <th style="width:100px;" title="操作">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">操作</div>
                            </div>
                        </th>
                   </tr>
                   </thead>
                   <tbody class="ui_table_bd" >
                   {foreach from=$arrayCourseware item=data key=index}
                      <tr class="{sdrclass rIndex=$index}">
                        <td  title=""><div class="ui_table_tdcntr">
                        <a href="javascript:;" onclick="DownLoad('{$data.file_path}','{$data.file_name}')">{$data.file_name}</a>
                        </div></td>
                        <td title=""><div class="ui_table_tdcntr">{$data.author}</div></td>
                        <td title=""><div class="ui_table_tdcntr">
                        <a onclick="UserDetial({$data.create_uid});" href="javascript:;">{$data.create_user_name}</a>
                        </div></td>
                        <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                        <td title=""><div class="ui_table_tdcntr">
                        <ul class="list_table_operation">
                        <li>
                        {literal}<a onclick="IM.account.delOper('/?d=Agent&c=AgentDoc&a=Delete',{{/literal}filePath:'{$data.file_path}'{literal}},'删除文件',this)" href="javascript:;" ispurview="true" m="AgentDocList" v="8">删除</a>{/literal}
                        </li>
                        </ul>
                        </div></td>
                      </tr>
                   {foreachelse}
                    <tr>
                      <td colspan="5"><div class="ui_table_tdcntr" style="text-align:center">无文件</div></td>
                    </tr>
                   {/foreach}
                   </tbody>
               </table>   
            </div>
            <!--E ui_table-->
        </div>
        <!--E list_table_main--> 
        <div class="list_table_head">          
        <div class="list_table_head_right">
        <div class="list_table_head_mid">
        	<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>促单工具</h4>       
        </div>
        </div>
        </div>
        <!--E list_table_head-->        
        <!--S list_table_main-->
        <div class="list_table_main marginBottom10">
        	<div id="J_ui_table" class="ui_table">
            	<table width="100%" cellspacing="0" cellpadding="0" border="0">
                	<thead class="ui_table_hd">
                	<tr>
                    	<th title="附件名称">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">附件名称</div>
                            </div>
                        </th>
                    	<th style="width:120px;" title="作者">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">作者</div>
                            </div>
                        </th>
                        <th style="width:140px;" title="添加人">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">添加人</div>
                            </div>
                        </th>
                        <th style="width:150px;" title="添加时间">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">添加时间</div>
                            </div>
                        </th>
                        <th style="width:100px;" title="操作">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">操作</div>
                            </div>
                        </th>
                   </tr>
                   </thead>
                   <tbody class="ui_table_bd" >
                   {foreach from=$arrayTool item=data key=index}
                      <tr class="{sdrclass rIndex=$index}">
                        <td  title=""><div class="ui_table_tdcntr">
                        <a href="javascript:;" onclick="DownLoad('{$data.file_path}','{$data.file_name}')">{$data.file_name}</a>
                        </div></td>
                        <td title=""><div class="ui_table_tdcntr">{$data.author}</div></td>
                        <td title=""><div class="ui_table_tdcntr">
                        <a onclick="UserDetial({$data.create_uid});" href="javascript:;">{$data.create_user_name}</a>
                        </div></td>
                        <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                        <td title=""><div class="ui_table_tdcntr">
                        <ul class="list_table_operation">
                        <li>
                        {literal}<a onclick="IM.account.delOper('/?d=Agent&c=AgentDoc&a=Delete',{{/literal}filePath:'{$data.file_path}'{literal}},'删除文件',this)" href="javascript:;"
                         ispurview="true" m="AgentDocList" v="8">删除</a>{/literal}
                        </li>
                        </ul>
                        </div></td>
                      </tr>
                   {foreachelse}
                    <tr>
                      <td colspan="5"><div class="ui_table_tdcntr" style="text-align:center">无文件</div></td>
                    </tr>
                   {/foreach}
                   </tbody>
               </table>   
            </div>
            <!--E ui_table-->
        </div>
        <!--E list_table_main-->
        <div class="list_table_head marginTop10 agentInfoToggle">          
        <div class="list_table_head_right">
        <div class="list_table_head_mid">
        	<h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>其它</h4>       
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
                    	<th title="附件名称">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">附件名称</div>
                            </div>
                        </th>
                    	<th style="width:120px;" title="作者">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">作者</div>
                            </div>
                        </th>
                        <th style="width:140px;" title="添加人">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">添加人</div>
                            </div>
                        </th>
                        <th style="width:150px;" title="添加时间">
                        	<div class="ui_table_thcntr">
                            	<div class="ui_table_thtext">添加时间</div>
                            </div>
                        </th>
                        <th style="width:100px;" title="操作">
                        	<div class="ui_table_thcntr ">
                            	<div class="ui_table_thtext">操作</div>
                            </div>
                        </th>
                   </tr>
                   </thead>
                   <tbody class="ui_table_bd" >
                   {foreach from=$arrayOther item=data key=index}
                      <tr class="{sdrclass rIndex=$index}">
                        <td  title=""><div class="ui_table_tdcntr">
                        <a href="javascript:;" onclick="DownLoad('{$data.file_path}','{$data.file_name}')">{$data.file_name}</a>
                        </div></td>
                        <td title=""><div class="ui_table_tdcntr">{$data.author}</div></td>
                        <td title=""><div class="ui_table_tdcntr">
                        <a onclick="UserDetial({$data.create_uid});" href="javascript:;">{$data.create_user_name}</a>
                        </div></td>
                        <td title=""><div class="ui_table_tdcntr">{$data.create_time}</div></td>
                        <td title=""><div class="ui_table_tdcntr">
                        <ul class="list_table_operation">
                        <li>
                        {literal}<a onclick="IM.account.delOper('/?d=Agent&c=AgentDoc&a=Delete',{{/literal}filePath:'{$data.file_path}'{literal}},'删除文件',this)" href="javascript:;" ispurview="true" m="AgentDocList" v="8">删除</a>{/literal}
                        </li>
                        </ul>
                        </div></td>
                      </tr>
                   {foreachelse}
                    <tr>
                      <td colspan="5"><div class="ui_table_tdcntr" style="text-align:center">无文件</div></td>
                    </tr>
                   {/foreach}
                   </tbody>
               </table>   
            </div>
            <!--E ui_table-->
        </div>
        <!--E list_table_main--> 
                    
      </div>
      <!--E form_bd--> 
      <!--S form_bd--> 
    </div>
  </div>
  <!--E form_bd--> 
</div>
{literal} 
<script language="javascript" type="text/javascript">
$.setPurview();
function QueryData()
{
    
}
function DownLoad(filepath,filename){
    window.open("/Action/Common/download.php?ft=agentdoc&fp="+filepath+"&pn="+encodeURIComponent(filename));
}

function DownLoadPermit(filepath,filename){
    window.open("/Action/Common/download.php?fp="+filepath+"&pn="+encodeURIComponent(filename));
}
</script> 
{/literal} 
<!--E form_edit-->