<?php /* Smarty version 2.6.26, created on 2013-01-24 17:05:35
         compiled from Agent/AgentDetailInfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'au', 'Agent/AgentDetailInfo.tpl', 8, false),array('modifier', 'date_format', 'Agent/AgentDetailInfo.tpl', 126, false),)), $this); ?>
<!--S crumbs-->
<div class="crumbs marginBottom10"><em class="icon_crumbs"></em>当前位置：<a href="javascript:;" onclick="JumpPage('/?d=Agent&c=Agent&a=showChannelPager')">我的渠道</a><span>&gt;</span>代理商信息</div>
<!--E crumbs--> 
<!--S form_edit-->
<div class="form_edit">
    <div class="form_hd">
        <ul>
            <li> <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'showAgentinfoAddContact'), $this);?>
&agentId=<?php echo $this->_tpl_vars['agentId']; ?>
');">
                    <div class="form_hd_left">
                        <div class="form_hd_right">
                            <div class="form_hd_mid">
                                <h2>代理商信息</h2>
                            </div>
                        </div>
                    </div>
                </a> </li>
            <li class="cur">
                <div class="form_hd_left">
                    <div class="form_hd_right">
                        <div class="form_hd_mid">
                            <h2>联系信息</h2>
                        </div>
                    </div>
                </div>
            </li>
            <?php if ($this->_tpl_vars['agentId'] != $this->_tpl_vars['objAgentInfo']->strAgentNo): ?>
                <li> <a href="javascript:;" onclick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'AgentDoc','a' => 'Detail'), $this);?>
&id=<?php echo $this->_tpl_vars['agentId']; ?>
');">
                        <div class="form_hd_left">
                            <div class="form_hd_right">
                                <div class="form_hd_mid">
                                    <h2>附件信息</h2>
                                </div>
                            </div>
                        </div>
                    </a> </li>
                <?php endif; ?>
        </ul>
    </div>
</div>
<!--S form_bd--> 
<div class="form_bd">
    <!--S form_block_bd-->
    <div class="form_block_bd">

        <!--E list_table_main-->

        <!--S list_table_main-->

        <!--E list_table_main-->
        <!--S list_table_head-->

        <!--E list_table_main-->                
        <!--S list_table_head-->
        <div class="list_table_head">
            <div class="list_table_head_right">
                <div class="list_table_head_mid">
                    <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span>最新电话联系小记</h4>                            
                    <a class="list_table_refresh" onClick="JumpPage('/?d=Agent&c=Agent&a=phoneAgentContactList')" href="javascript:;">更多>></a>
                    <a class="ui_button ui_link" href="javascript:;" m="TelTaskManage" v="32" ispurview="true" onClick="JumpPage('<?php echo getSmartyActionUrl(array('d' => 'WorkM','c' => 'TelWork','a' => 'showAddTelNote'), $this);?>
&agentid=<?php echo $this->_tpl_vars['agentId']; ?>
')"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加联系小记</a>
                </div>
            </div>
        </div>
        <!--E list_table_head--> 
        <!--S list_table_main-->
        <div class="list_table_main marginBottom10" id="ContactInfo">
            <div class="ui_table" id="J_ui_table">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead class="ui_table_hd">
                        <tr class="">
                            <th  title="编号"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">编号</div>
                    </div>
                    </th>
                    <th  title="意向等级或签约产品"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">意向等级或签约产品</div>
                    </div>
                    </th>
                    <th  title="被联系人"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">被联系人</div>
                    </div>
                    </th>
                    <th  title="联系电话"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">联系电话</div>
                    </div>
                    </th>
                    <th  title="联系时间"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">联系时间</div>
                    </div>
                    </th>
                    <th  title="操作人"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">操作人</div>
                    </div>
                    </th>
                    <th  title="添加时间"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">添加时间</div>
                    </div>
                    </th>
                    <th  title="联系小记"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">联系小记</div>
                    </div>
                    </th>
                    <th  title="质检结果"> <div class="ui_table_thcntr ">
                        <div class="ui_table_thtext">质检结果</div>
                    </div>
                    </th>
                    </tr>
                    </thead>
                    <tbody class="ui_table_bd">

                        <?php $_from = $this->_tpl_vars['TelNoteList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
                            <tr class="">
                                <td title="<?php echo $this->_tpl_vars['data']['id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['id']; ?>
</div></td>
                                <td title="<?php if ($this->_tpl_vars['data']['contact_type'] == 0): ?><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)<?php else: ?><?php echo $this->_tpl_vars['data']['product_name']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['data']['contact_type'] == 0): ?>
                                            <?php if ($this->_tpl_vars['data']['afterlevel'] <= 'B+'): ?>
                                                <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote(<?php echo $this->_tpl_vars['data']['id']; ?>
)" ><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)</a>
                                            <?php else: ?>
                                                <?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote(<?php echo $this->_tpl_vars['data']['id']; ?>
)" ><?php echo $this->_tpl_vars['data']['product_name']; ?>
</a>
                                        <?php endif; ?>
                                    </div></td>
                                <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>
                                <td title="<?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
</div></td>
                                <td title="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
"><div class="ui_table_tdcntr"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
</div></td>
                                <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
 <?php echo $this->_tpl_vars['data']['e_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_name']; ?>
 <?php echo $this->_tpl_vars['data']['e_name']; ?>
</div></td>
                                <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
                                <td title="<?php echo $this->_tpl_vars['data']['result']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getTelNoteDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)" ><?php echo $this->_tpl_vars['data']['result']; ?>
</a></div></td>
                                <td title=""><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['data']['is_vertifyed'] == 0): ?>
                                            未质检
                                        <?php else: ?>
                                    <?php if ($this->_tpl_vars['data']['verfity_status'] == 0): ?>
                                        <a href="javascript:void(0)" onclick="verfityDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)">不通过</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" onclick="verfityDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)">通过</a>
                                        <?php endif; ?>
                                <?php endif; ?>
                            </div></td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>

        </table>
    </div>
    <!--E ui_table--> 
</div>
<!--E list_table_main--> 
<div class="list_table_head">
    <div class="list_table_head_right">
        <div class="list_table_head_mid">
            <h4 class="list_table_title"><span class="ui_icon list_table_title_icon"></span> 最新拜访小记</h4>
            <a class="list_table_refresh" onClick="JumpPage('/?d=WorkM&c=VisitNote&a=NoteList')" href="javascript:;">更多>></a> <a class="ui_button ui_link" href="javascript:;"   onClick="JumpPage('/?d=WorkM&c=VisitAppoint&a=showAddVisitInvite&agentid=<?php echo $this->_tpl_vars['agentId']; ?>
')"><span class="ui_icon ui_icon_add2">&nbsp;</span>添加拜访预约</a> </div>
    </div>
</div>
<!--E list_table_head--> 
<!--S list_table_main-->
<div class="list_table_main">
    <div id="J_ui_table" class="ui_table">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead class="ui_table_hd">
                <tr>
                    <th width="50" title="编号"> <div class="ui_table_thcntr" sort="sort_visitnoteid">
                <div class="ui_table_thtext">编号</div>
            </div>
            </th>
            <th title="意向评级/签约产品"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">意向评级/签约产品</div>
            </div>
            </th>
            <th title="拜访类型"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">拜访类型</div>
            </div>
            </th>
            <th title="被访人"> <div class="ui_table_thcntr" sort="sort_visitor">
                <div class="ui_table_thtext">被访人</div>
            </div>
            </th>
            <th title="联系电话"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">联系电话</div>
            </div>
            </th>
            <th title="拜访时间"> <div class="ui_table_thcntr " sort="sort_visit_timestart">
                <div class="ui_table_thtext">拜访时间</div>
            </div>
            </th>
            <th width="70" title="操作人"> <div class="ui_table_thcntr" sort="sort_e_name">
                <div class="ui_table_thtext">操作人</div>
            </div>
            </th>
            <th width="" title="操作时间"> <div class="ui_table_thcntr" sort="sort_create_time">
                <div class="ui_table_thtext">操作时间</div>
            </div>
            </th>
            <th title="拜访计划"> <div class="ui_table_thcntr " sort="sort_title">
                <div class="ui_table_thtext">拜访计划</div>
            </div>
            </th>
            <th title="拜访结果"> <div class="ui_table_thcntr " sort="sort_result">
                <div class="ui_table_thtext">拜访结果</div>
            </div>
            </th>
            <th title="批示内容"> <div class="ui_table_thcntr " sort="sort_check_status" >
                <div class="ui_table_thtext">批示内容</div>
            </div>
            </th>
            <th width="100"  title="质检结果"> <div class="ui_table_thcntr ">
                <div class="ui_table_thtext">质检结果</div>
            </div>
            </th>
            </tr>
            </thead>
            <tbody class="ui_table_bd" id="pageListContent">

                <?php $_from = $this->_tpl_vars['VisitNoteList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['data']):
?>
                    <tr class="">
                        <td title="<?php echo $this->_tpl_vars['data']['id']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['id']; ?>
</div></td>
                        <td title="<?php if ($this->_tpl_vars['data']['contact_type'] == 0): ?><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)<?php else: ?><?php echo $this->_tpl_vars['data']['product_name']; ?>
<?php endif; ?>"><div class="ui_table_tdcntr">
                                        <?php if ($this->_tpl_vars['data']['contact_type'] == 0): ?>
                                            <?php if ($this->_tpl_vars['data']['afterlevel'] <= 'B+'): ?>
                                                <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote(<?php echo $this->_tpl_vars['data']['id']; ?>
)" ><?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)</a>
                                            <?php else: ?>
                                                <?php echo $this->_tpl_vars['data']['afterlevel']; ?>
(<?php echo $this->_tpl_vars['data']['product_name']; ?>
)
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ($this->_tpl_vars['data']['visit_type'] == 2): ?>
                                                <?php echo $this->_tpl_vars['data']['product_name']; ?>

                                            <?php else: ?>
                                                <a href="javascript:void(0)" onclick="getAgentIncomeInfoFromNote(<?php echo $this->_tpl_vars['data']['id']; ?>
)" ><?php echo $this->_tpl_vars['data']['product_name']; ?>
</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                    </div></td>
                <td title="<?php if ($this->_tpl_vars['data']['visit_type'] == 2): ?>培训<?php else: ?>沟通<?php endif; ?>"><div class="ui_table_tdcntr">
                <?php if ($this->_tpl_vars['data']['visit_type'] == 2): ?>培训<?php else: ?>沟通<?php endif; ?>
        </div></td>
    <td title="<?php echo $this->_tpl_vars['data']['visitor']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visitor']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['mobile']; ?>
/<?php echo $this->_tpl_vars['data']['tel']; ?>
</div></td>
    <td title=""><div class="ui_table_tdcntr">
            <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timestart'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
~ <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['visit_timeend'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>

        </div></td>
    <td title="<?php echo $this->_tpl_vars['data']['user_name']; ?>
 <?php echo $this->_tpl_vars['data']['e_name']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['user_name']; ?>
 <?php echo $this->_tpl_vars['data']['e_name']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['create_time']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['create_time']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['visit_content']; ?>
"><div class="ui_table_tdcntr"><?php echo $this->_tpl_vars['data']['visit_content']; ?>
</div></td>
    <td title="<?php echo $this->_tpl_vars['data']['result']; ?>
"><div class="ui_table_tdcntr"><a href="javascript:void(0)" onclick="getVisitNoteDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)"><?php echo $this->_tpl_vars['data']['result']; ?>
</a></div></td>
    <td title="<?php if ($this->_tpl_vars['data']['is_vertifyed'] == 3): ?><?php echo $this->_tpl_vars['data']['instruction']; ?>

        <?php elseif ($this->_tpl_vars['data']['is_vertifyed'] == 4): ?>已审阅<?php else: ?>未批示<?php endif; ?>}"><div class="ui_table_tdcntr">
                        <?php if ($this->_tpl_vars['data']['is_vertifyed'] == 3): ?><a href="javascript:void(0)" onclick="inDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)"><?php echo $this->_tpl_vars['data']['instruction']; ?>
</a>
                <?php elseif ($this->_tpl_vars['data']['is_vertifyed'] == 4): ?>已审阅<?php else: ?>未批示<?php endif; ?>
            </div></td>
        <td title=""><div class="ui_table_tdcntr">
                <?php if ($this->_tpl_vars['data']['is_vertifyed'] == 0): ?>
                    未质检
                <?php else: ?>
            <?php if ($this->_tpl_vars['data']['verfity_status'] == 0): ?>
                <a href="javascript:void(0)" onclick="verfityDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)">不通过</a>
                <?php else: ?>
                    <a href="javascript:void(0)" onclick="verfityDetail(<?php echo $this->_tpl_vars['data']['id']; ?>
)">通过</a>
                <?php endif; ?>
        <?php endif; ?>
    </div></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</tbody>

</table>
</div>
<!--E ui_table--> 
</div>
</div>
</div>
<script language="javascript" type="text/javascript">
    <?php echo '
new Reg.vf($(\'#J_newLXXiaoJi\'),{callback:function(data){
	if(IM.checkPhone()){IM.tip.warn(\'手机或固话必填一项\');return false;}
	if(!IM.IsSending(true)){return false;};
		$.ajax({
			type:\'POST\',
			data:$(\'#J_newLXXiaoJi\').serialize(),
    '; ?>

			url:'<?php echo getSmartyActionUrl(array('d' => 'Agent','c' => 'Agent','a' => 'AddContactInfo'), $this);?>
',
    <?php echo '
			success:function(data){
			IM.IsSending(false);
				switch(data)
				{
					case \'1\':
						IM.tip.show(\'代理商联系小记添加成功！\');
						window.location.reload();
						break;
					case \'2\':
						IM.tip.warn(\'非法参数，请检查！\');
						break;
					case \'3\':
						IM.tip.warn(\'联系人信息不能为空！\');
						break;
					case \'4\':
						IM.tip.warn(\'手机号码不能为空！\');
						break;
					default:
						IM.tip.warn(\'代理商联系小记添加失败！\');
						break;
				}
			}
		});
	}
});
function showAddContactInfo(agent_id,isPact){
    IM.dialog.show({
            width:650,
            height:null,
            title:\'添加联系小记\',
            html:IM.STATIC.LOADING,
            start:function(){
                $(\'.DCont\').html($PostData("/?d=Agent&c=Agent&a=showAddContactInfo&agent_id="+agent_id+"&isPact="+isPact));
            }
         })
}
    
    //质检结果卡片
function verfityDetail(noteId)
{
     IM.dialog.show({
            width:400,           
            title:\'拜访小记质检信息\',
            html:IM.STATIC.LOADING,
            start:function(){
                $(\'.DCont\').html($PostData("/?d=WorkM&c=VisitNote&a=showVerifyInfo&noteId="+noteId,""));
            }
         });
}
//批示内容卡片
function inDetail(noteId)
{
     IM.dialog.show({
            width:400,           
            title:\'拜访小记领导批示信息\',
            html:IM.STATIC.LOADING,
            start:function(){
                $(\'.DCont\').html($PostData("/?d=WorkM&c=VisitNote&a=showInstructionInfo&noteId="+noteId,""));
            }
         });
}
    '; ?>

</script>