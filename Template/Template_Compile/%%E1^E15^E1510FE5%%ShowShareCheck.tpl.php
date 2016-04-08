<?php /* Smarty version 2.6.26, created on 2013-01-31 14:35:50
         compiled from Agent/ShowShareCheck.tpl */ ?>
<div class="DContInner">
<form id="J_shareCheck">
<div class="form_edit">
<div class="form_block_bd">
                <div class="tf">
                    <input type ="hidden" id="checkId" name="checkId" value="<?php echo $this->_tpl_vars['checkId']; ?>
" />
                    <label style="width:120px;"><em class="require">*</em>请选择审核结果：</label>
                    <div class="inp">
                    <select id="result" name="result">                       
                        <option value="1" selected="selected">通过</option>
                        <option value="2">不通过</option>
                    </select>
                    </div>                            
                </div>
                <div class="tf">
                    <label style="width:120px;">备注：</label>
                    <div class="inp"><textarea id="remark" name="remark" class="subordinateAgent" style="width:240px;height:80px;" ></textarea></div>             
                </div>
</div>
<div class="ft">
<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>
<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" >确 定</button></div>
</div></div>
</form>
</div>