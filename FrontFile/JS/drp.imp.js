/**
 * User:Marshane
 */
IM = {
    STATIC:{
        LOADING:'<div class="loading">数据加载中..</div>'
    },
	console:function(a){
		try{
			console.log(a);
		}catch(e){}
	}
};
IM.Payment={
    tempTpl_1:'',//银行汇款|网银支付|其他 服务端动态获取	
    tempTpl_2:'<div class="tf">\
                          <label><em class="require">*</em>交易号：</label>\
                          <div class="inp"><input type="text" tabindex="1" valid="required" name="trans_code" value="{$arrCashDeposit.fr_rp_num}"/></div>\
                          <span class="info">请输入交易号</span>                                                            \
                          <span class="err">请输入交易号</span>                                                              \
                    </div>                                                                                              \
                    <div class="tf">                                                                                     \
                          <label><em class="require">*</em>打款账户名称：</label>                                                \
                          <div class="inp"><input type="text" tabindex="1" valid="required" name="payAccountName" value="{$arrCashDeposit.fr_peer_bank_name}"/></div> \
                          <span class="info">如果为签约代理商对公账户支付，请完整填写代理商企业名称，如果非签约代理商对公账户支付（即私人银行卡替公司支付），请填写私人卡卡主的姓名，并在备注里填写签约代理商的企业名称。</span>                                                               \
                          <span class="err">如果为签约代理商对公账户支付，请完整填写代理商企业名称，如果非签约代理商对公账户支付（即私人银行卡替公司支付），请填写私人卡卡主的姓名，并在备注里填写签约代理商的企业名称。</span>                                                                 \
                    </div>'//快钱
};
IM.Agent = function () { };
IM.Agent.prototype = {
    /**08-24 9:00
     * 代理商资料审核->审核任务分配
     * @param url
     * @param data
     * @param title
     */
    addAuditer:function(url,data,title){
        var html='<div class="DContInner setPWDComfireCont">' +
        '<form id="J_addAuditer"><div class="bd"><div class="tf">\
                        	<label>审核人：</label>\
                            <div class="inp"><input id="J_auditerName" type="text" name="auditerName" valid="required"/></div><span class="info">请输入姓名(或工号)</span><span class="err">请输入姓名(或工号)</span> \
                        </div></div>' +
        '<div class="ft">' +
        '<div class="ui_button ui_button_cancel"><a class="ui_button_inner" onclick="IM.dialog.hide()" href="javascript:;">取消</a></div>' +
        '<div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="submit">确 定</button></div>' +
        '</div></div></div></form></div>';
        var listID=IM.table.getListID();
        if(listID.length<1){
            IM.tip.warn('请选择审核人');
            return;
        }
        IM.dialog.show({
            width:500,
            title:'审核任务分配',
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont')[0].innerHTML=html;
                var J_auditerName=$('#J_auditerName');
                J_auditerName.autocomplete('/?d=Agent&c=TaskAssign&a=AutoComplete',{
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
                        return '<em>'+item.name+'</em>';
                    }
                });
                new Reg.vf($('#J_addAuditer'),{
                    callback:function(){
                        MM.ajax({
                            url:url,
                            data:'name='+$('#J_auditerName').val()+'&id='+listID,
                            success:function(q){
                                q=MM.json(q);
                                IM.dialog.hide();
                                if(q.success){
                                    pageList.reflash();
                                    IM.tip.show(q.msg);
                                }else{
                                    IM.tip.warn(q.msg);
                                }
                            }
                        });
                    }
                });
            }
        });
    },
    /** 08-15-11:00
     * 查看保证金
     * @param url
     * @param data
     * @param title
     */
    lookJiaoBaoZhengJin:function(url,data,title){
        data=data ||{};
        IM.dialog.show({
            width:550,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,data,function(q){
                    $('.DCont')[0].innerHTML=q;
                });
            }
        });
    },
    /**08-17 15:00改动
     * 提交保证金
     * @param url
     * @param data
     * @param title
     * @param width
     */
    TiJiaoBaoZhengJin:function(url,data,title,width){
		var tempTpl_1='',//银行汇款|网银支付|其他
			tempTpl_2='';//快钱
        data=data||{};
        width=width||900;
        IM.dialog.show({
            width:width,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,data,function(q){
                    $('.DCont')[0].innerHTML=q;
                    new IM.upload({id:'J_upload1',noticeId:'J_uploadImg',url:'/?d=Agent&c=Agent&a=FileUpload&uploadDir=HT_'+data.id});
                    /**
                     * 验证表单
                     */
                    var TiJiaoBaoZhengJinForm=$('#J_TiJiaoBaoZhengJinForm'),
                        J_payment=$('#J_payment')[0];
                    function cb(formData){
                        MM.ajax({
                            url:'/?d=Agent&c=AgentMove&a=GetCashDepositSure',//获取 提交保证金确认 片段
                            data:TiJiaoBaoZhengJinForm.serialize(),
                            success:function(q){
                                $('.DCont')[0].innerHTML=q;
                                /**
                                 * 提交保证金确认 提交 处理
                                 */
                                var TiJiaoBaoZhengJin_submitForm=$('#J_TiJiaoBaoZhengJin_submitForm');
                                new Reg.vf(TiJiaoBaoZhengJin_submitForm,{
                                    callback:function(formData){
                                        MM.ajax({
                                            url:'/?d=Agent&c=AgentMove&a=AddCashDeposit',//提交保证金确认 提交地址
                                            data:$('#J_TiJiaoBaoZhengJin_submitForm').serialize(),
                                            success:function(q){
                                                //responseText: {"success":true,"msg":"添加成功"}
                                                q=MM.json(q);
                                                if(q.success){
                                                    IM.dialog.hide();
                                                    IM.tip.show(q.msg);
													pageList.reflash();
                                                }else{
                                                    IM.tip.warn(q.msg);
                                                }
                                            }
                                        });
                                }});
                            }
                        });
                    }
                    function regForm(){
                        new Reg.vf(TiJiaoBaoZhengJinForm,{
                            extValid:{
                                        payAccount:function(e){return MM.getVal(MM.G('payAccount')).text!='请选择'}
                             },
                            callback:cb});
                    }
                    regForm();
                    /**
                     * 处理改变 支付方式
                     */
                    if(J_payment) {
                       var J_paymentResult=$('#J_paymentResult')[0];
                        /**
                         * 默认存贮 银行汇款|网银支付|其他
                         */
                        //IM.Payment.tempTpl_1='';
                        /**
                         * 监听 Select change 事件
                         */
						function getTpl(a){
							MM.get('/?d=Agent&c=AgentMove&a=ShowPayType&pactId='+data.id,{'pay_type':a},function(q){								
								setTpl(q);
								if(value=='8'||value=='7'||value=='15'){//暂存
									tempTpl_1=q;
								}else if(value=='11'){
									tempTpl_2=q;
								}
							});
						}
						function setTpl(a){
							J_paymentResult.innerHTML=a;
                            regForm();
						}
                        MM.EA(J_payment,'change',function(e){
                            var target=MM.E(e).target,
                                value=MM.getVal(target).value;
                            if(value=='8'||value=='7'||value=='15'){//银行汇款|网银支付|其他							
                                if(tempTpl_1=='')
                                    getTpl(value);
								else 
									setTpl(tempTpl_1);
                            }else if(value=='11'){//块钱
                                if(tempTpl_2=='') 
									getTpl(value);
								else 
									setTpl(tempTpl_2);
                            }else if(value=='1'){//现金
                                setTpl('');
                            }
                        });
                    }
                });
           }
        });
    },
    /** 08-15-11:00
    * 添加联系小记
    * @param url
    */
    newLXXiaoJi:function(url,agentId,isPact){
        IM.dialog.show({
            width:580,
            title:'添加联系小记',
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,{},function(q){
                    $('.DCont')[0].innerHTML=q;
                    new Reg.vf($('#J_newLXXiaoJi'),{
                        extValid:{},
                        callback:function(formData){
                            if(IM.checkPhone()){
                                IM.tip.warn('手机或固话必填一项');
                                return false;
                            }
							if($('#leval').val() == 0){
								IM.tip.warn('请选择意向评级');
                                return false;
							}
                            MM.ajax({
                                url:'/?d=Agent&c=Agent&a=AddContactInfo&agentId='+agentId+'&isPact='+isPact+'&event_type=1',//表单提交地址
                                data:formData,
                                success:function(q){
                                    //responseText: {"success":true,"msg":"添加成功"}
                                    q=MM.json(q);
                                    if(q.success){
                                        IM.dialog.hide();
                                        IM.tip.show(q.msg);
										$('#ContactInfo').load('/?d=Agent&c=Agent&a=LoadContactInfo',{"agentId":agentId});
                                    }else{
                                        IM.tip.show(q.msg);
                                    }
                                }
                            });
                        }
                    });
                });
            }
        });
    },
    /**08-15-11:00
    * 查看联系人信息
    * @param data
    */
    getContactInfo:function(data){
        data=data||{};//{'id':10}
        IM.dialog.show({
            width:450,
            title:'联系人信息',
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get('/?d=Agent&c=Agent&a=getContacterInfo',data,function(q){
                    $('.DCont')[0].innerHTML=q;
                });
            }
        });
    },
	/**08-15-11:00
    * 查看联系人信息
    * @param data
    */
    getAgentCheckInfo:function(data){
        data=data||{};//{'id':10}
        IM.dialog.show({
            width:450,
            title:'代理商审核信息',
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get('/?d=Agent&c=Agent&a=getAgentCheckInfo',data,function(q){
                    $('.DCont')[0].innerHTML=q;
                });
            }
        });
    },
	/**08-15-11:00
    * 查看联系人信息
    * @param data
    */
    getAgentInfoCard:function(data){
        IM.agent.getTableList('/?d=Agent&c=Agent&a=getAgentInfoCard',data,'代理商信息',800);
    },
    /**08-15-11:00
    * 添加联系人信息
    * @param url
    */
    addContactInfo:function(url,title,agentId,isPact){
        IM.dialog.show({
            width:600,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,{},function(q){
                    $('.DCont')[0].innerHTML=q;
                    new Reg.vf($('#J_addContactInfoForm'),{
                        callback:function(formData){
                            if(IM.checkPhone()){
                                IM.tip.warn('手机或固话必填一项');
                                return false;
                            }
                            MM.ajax({
                                url:'/?d=Agent&c=Agent&a=AddContacter&agentId='+agentId+'&isPact='+isPact+'&event_type=0',//表单提交地址
                                data:formData,
                                success:function(q){
                                    //responseText: {"success":true,"msg":"添加成功"}
                                    q=MM.json(q);
                                    if(q.success){
                                        IM.dialog.hide();
                                        IM.tip.show(q.msg);
					JumpPage('/?d=Agent&c=Agent&a=showAgentinfoAddContact&agentId='+agentId);
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
    },
    /**08-15-11:00
    * 编辑联系人信息
    * @param url
    */
    editContactInfo:function(url,title,agentId){
        IM.dialog.show({
            width:550,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,{},function(q){
                    $('.DCont')[0].innerHTML=q;
                    new Reg.vf($('#J_addContactInfoForm'),{
                        callback:function(formData){
                            if(IM.checkPhone()){
                                IM.tip.warn('手机或固话必填一项');
                                return false;
                            }
                            if(IM.officer()){
                                IM.tip.warn('请填写联系人职务');
                                return false;
                            }
                            MM.ajax({
                                url:'/?d=Agent&c=Agent&a=editContacter',//表单提交地址
                                data:formData,
                                success:function(q){
                                    //responseText: {"success":true,"msg":"编辑成功"}
                                    q=MM.json(q);
                                    if(q.success){
                                        IM.dialog.hide();
                                        IM.tip.show(q.msg);
					JumpPage('/?d=Agent&c=Agent&a=showAgentinfoAddContact&agentId='+agentId);
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
    },
	/**08-15-11:00
    * 代理商补签合同
    * @param url
    */
    addReplenish:function(url,title,agentId,pactId){
        IM.dialog.show({
            width:550,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,{},function(q){
                    $('.DCont')[0].innerHTML=q;
                    new Reg.vf($('#addReplenish'),{
                        callback:function(formData){
                            MM.ajax({
                                url:'/?d=Agent&c=AgentReplenish&a=addReplenish&agentId='+agentId+'&pactId='+pactId,//表单提交地址
                                data:formData,
                                success:function(q){
                                    q=MM.json(q);
                                    if(q.success){
                                        IM.dialog.hide();
                                        IM.tip.show(q.msg);
										//JumpPage('/?d=Agent&c=AgentMove&a=MySignIndex');
                                        pageList.reflash();
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
    },
    /**08-15-11:00
     ** 表格中--查看 提交人
     * @param url
     * @param data
     * @param title
     */
    getSubmittedBy:function(url,data,title,_width){
        IM.dialog.show({
            width:_width||800,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,data,function(q){
                    $('.DCont')[0].innerHTML=q;
                });
            }
        });
    },
    /**08-22
    * 添加审核人
    * @param url
    */
    addCheckUser:function(url,title){
        IM.dialog.show({
            width:550,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,{},function(q){
                    $('.DCont')[0].innerHTML=q;
                    new Reg.vf($('#J_addCheckUser'),{
                        callback:function(formData){
                            MM.ajax({
                                url:'/?d=Agent&c=Agent&a=AddCheckUser',//表单提交地址
                                data:formData,
                                success:function(q){
                                    //responseText: {"success":true,"msg":"添加成功"}
                                    q=MM.json(q);
                                    IM.dialog.hide();
                                    if(q.success){
                                        IM.tip.show(q.msg);
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
    },
    /**
     * 表格数据获取公共方法
     * @param url
     * @param data
     * @param title
     * @param w
     * @param h
     */
    getTableList:function(url,data,title,w){
        var htmlTemp='<div class="DContInner tableFormCont">{0}' +
            '<div class="ft">' +
            '<div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div></div></div>';
        w=w ||700;
        IM.dialog.show({
                    width:w,
                    title:title,
                    html:IM.STATIC.LOADING,
                    start:function(){
                            MM.get(url,data,function(q){
                                $('.DCont')[0].innerHTML=_(htmlTemp,q);
                            });
                    }
                });
    }, 
    /**
    * 设置代理商类型
    * @param url
    * @param data
    * @param title
    */
   setAgentType: function (url, data, title) {
        
        data=data||{};        
        IM.dialog.show({
            width: 300,
            height: 100,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                MM.get(url, data, function (q) {
                    $('.DCont')[0].innerHTML = q;
                });
            },
            ok: function () {                
                var backData = $PostData('/?d=Agent&c=Agent&a=submitAgentType',$("#J_agentType").serialize());                                    
                if (backData == 1) {        
                    pageList.reflash();
                    IM.dialog.hide();
                    IM.tip.show('设置成功');
                    
                }else{
                    IM.tip.warn('设置失败');
                }
                
            }
        });
    },
    /**
    * 代理商转移
    * @param url
    * @param data
    * @param title
    */
    agentMove: function (url, data, title) {
        data=data||{};
//        var listid = IM.table.getListID(), tr = IM.table.getSelectTr();
//        if (tr && tr.length < 1) {
//            IM.tip.warn('请选择代理商');
//            return
//        }
//        MM.Extend(data, {
//            'r': MM.Random(1000),
//            'listid': listid
//        });
        IM.dialog.show({
            width: 550,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                MM.get(url, data, function (q) {
                    $('.DCont')[0].innerHTML = q;
					var J_auditerName=$('#channelName');
					J_auditerName.autocomplete('/?d=Agent&c=TaskAssign&a=AutoComplete',{
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
							return '<em>'+item.name+'</em>';
						}
					}).result(function(item,value){						
                        $('#J_user_id').val(value.user_id);
					});
                });
            },
            ok: function () {
                MM.ajax({
                    url: '/?d=Agent&c=AgentMove&a=newMove',
                    data: $("#J_customerMove").serialize(),
                    success: function (q) {
                        IM.table.clearState();
                        if (q == 1) {
                            IM.tip.show('转移成功');
                            IM.dialog.hide();
                            pageList.reflash();
                        }
                        else if (q ==2 ) {
                        	IM.tip.warn('代理商仍有未解除签约客户，转移失败');
                        }
                        else {
                            IM.tip.warn('转移失败');
                        }
                    }
                })
            }
        });
    },
    /**
     * 合同转移
     * @param url
     * @param data
     * @param title
     */
     contractMove: function (url, data, title) {
         data=data||{};
         var listid = IM.table.getListID(), tr = IM.table.getSelectTr();
         if (tr && tr.length < 1) {
             IM.tip.warn('请选择签约合同');
             return
         }
        
         MM.Extend(data, {
             'r': MM.Random(1000),
             'listid': listid
         });
         IM.dialog.show({
             width: 550,
             title: title,
             html: IM.STATIC.LOADING,
             start: function () {
                 MM.get(url, data, function (q) {
                     $('.DCont')[0].innerHTML = q;
 					var J_auditerName=$('#channelName');
 					J_auditerName.autocomplete('/?d=Agent&c=TaskAssign&a=AutoComplete',{
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
 							return '<em>'+item.name+'</em>';
 						}
 					}).result(function(item,value){						
                         $('#J_user_id').val(value.user_id);
 					});
                 });
             },
             ok: function () {
                 MM.ajax({
                     url: '/?d=Agent&c=AgentMove&a=pactMove',
                     data: $("#J_customerMove").serialize(),
                     success: function (q) {                    	 
                         IM.table.clearState();
                         if (q == 1) {
                             IM.tip.show('转移成功');
                             IM.dialog.hide();
                             pageList.reflash();
                         }
                         else if (q == 2 ){
                        	 IM.tip.warn('请选中同一代理商下的合同，转移失败');
                         }
                         else if (q ==3 ) {
                         	IM.tip.warn('存在已解除签约合同，转移失败');
                         }
                         else if (q ==4)  {
                        	 IM.tip.warn('未选中该代理商的全部有效合同，转移失败');
                         }
                         else {
                             IM.tip.warn('转移失败');
                         }
                     }
                 })
             }
         });
     },
    /**
    * 回收库代理商转移
    * @param url
    * @param data
    * @param title
    * @param w
    * @param h
    */
    recyAgentMove: function (url, data, title, w, h) {
        w = w || 550;
        title = title;
        h = h || null;
        (data == null || data == '') ? data = {} : data = data;
        var listid = IM.table.getListID(), tr = IM.table.getSelectTr();
        if (tr && tr.length < 1) {
            IM.tip.warn('请选择代理商');
            return
        }
        MM.Extend(data, {
            'r': MM.Random(1000),
            'listid': listid
        });
        IM.dialog.show({
            width: w,
            height: h,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                MM.get(url, data, function (q) {
                    $('.DCont')[0].innerHTML = q;
                });
            },
            ok: function () {
                MM.ajax({
                    url: '/?d=Agent&c=AgentMove&a=recyMove',
                    data: $("#J_customerMove").serialize(),
                    success: function (q) {
                        IM.table.clearState();
                        IM.dialog.hide();
                        if (q == 1) {
                            IM.tip.show('转移成功');                            
                            pageList.reflash();
                        }else if(q == 2){
							IM.tip.warn('所选择的代理商没有完成审核流程！');
						}else{
                            IM.tip.warn('转移失败');
                        }
                    }
                })
            }
        });
    },
    /**
    * 代理商账号管理-->密码重置
    * @param title
    * @param width
    * @param height
    */
    setPWDComfirm: function (id) {
        var html = '<div class="DContInner tableFormCont">' +
        '<div class="bd">您确定要重置密码？</div>' +
        '<div class="ft">' +
        '<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>' +
        '<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" onclick="IM.dialog.ok()">确 定</button></div>' +
        '</div></div>';
        IM.dialog.show({
            width: 300,
            title: '密码重置确认',
            html: html,
            ok: function () {
                MM.ajax({
                    url: '/?d=System&c=AgentUser&a=ReSetAgentUserPwd&id=' + id,
                    data: {
                        r: MM.Random(1000)
                    },
                    success: function (retValue) {
                        IM.dialog.hide();
                        var jsonObj = eval("("+ retValue +")");
                        
                        if (jsonObj["success"] == true) {
                            IM.tip.show("密码重置成功！初始密码为："+jsonObj["msg"]);
                        }
                        else {
                            IM.tip.warn(jsonObj["msg"]);
                        }
                    }
                });
            }
        });
    }
};
IM.Customer = function () { };
IM.Customer.prototype = {
    showVerifyAssign: function () {
        var listid = IM.table.getListID();
        if (listid.length > 0) {
            IM.dialog.show({
                width: 500,
                height: null,
                title: '审核任务分配',
                html: IM.STATIC.LOADING,
                start: function () {
                    MM.get("/?d=CM&c=CMVerify&a=showVerifyAssign&customer_ids=" + listid.join(","), {}, function (pageHTML) {
                        $('.DCont')[0].innerHTML = pageHTML;
                        $('#assign_check_Name').autocomplete('/?d=CM&c=CMVerify&a=getUserName_ID', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
                            max: 5, //只显示5行
                            width: 150, //下拉列表的宽
                            parse: function (backData) {//q 返回的数据 JSON 格式，在这里解析成列表
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
                                        result: value[i].no + "(" + value[i].name + ")"
                                    }
                                }
                                return parsed;
                            },
                            formatItem: function (item) {//内部方法生成列表
                                return '<div onclick="setAssign_checkValue(\'' + item.id + '\')">' + item.no + "(" + item.name + ")" + '</div>';
                            }
                        });
                        window.setAssign_checkValue = function (eID) {
                            $("#assign_check_id").val(eID);
                        };
                        new Reg.vf($('#form2'), {
                            callback: function (data) {
                                if ($("#assign_check_id").val() == "-1") {
                                    IM.tip.warn('请选择审核人');
                                    return false;
                                }
                                $.ajax({
                                    type: 'POST',
                                    data: $('#form2').serialize(),
                                    url: "/?d=CM&c=CMVerify&a=verifyAssign",
                                    success: function (data) {
                                        if ($.trim(data) == 1) {
                                            IM.dialog.hide();
                                            IM.tip.show('分配成功');
                                            JumpPage('/?c=CMVerify&d=CM&a=showVerifyList');
                                        }
                                        else {
                                            IM.tip.warn(data);
                                        }
                                    }
                                });
                            }
                        });
                    });
                }
            });
        }
        else {
            IM.tip.warn('请选择要转移的客户');
        }
    },
    /**
    * 客户关闭管理 --> 客户转移
    * @param url
    * @param data
    * @param title
    * @param w
    * @param h
    */    
    customerMove2: function (url, data, title, w, h) {
        var htmlTemp = '<div class="tf"> \
                        	<label style="width:130px;">&nbsp;</label>    \
                            <div class="inp" style="color:#FF6600;">{0}</div>          \
                        </div>';
        w = w || 550;
        title = title || '客户转移';
        h = h || null;
        (data == null || data == '') ? data = {} : data = data;
        var listid = IM.table.getListID(),
        tr = IM.table.getSelectTr(),
        user_id = ''; //提交id
        if (tr && tr.length < 1) {
            IM.tip.warn('请选择要转移的客户');
            return;
        }
        MM.Extend(data, {
            'r': MM.Random(1000),
            'listid': listid
        });
        IM.dialog.show({
            width: w,
            height: h,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                MM.get("/?d=CM&c=CMInfo&a=frontTransfer", data, function (html) {
                    $('.DCont')[0].innerHTML = html;
                    $('#user_id').autocomplete('/?d=CM&c=CMInfo&a=CompleteUserId', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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
                                    value: value[i].user_id,
                                    result: value[i].user_name
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return '<div>' + item.user_name + '</div>';
                        }
                    }).result(function (data, value) {
                        user_id = value.user_id;
                    });
                    new Reg.vf($('#J_customerMove2'), {
                        callback: function (pData) {
                            MM.Extend(data, {
                                'r': MM.Random(1000),
                                'listid': IM.table.getListID()
                            });
                            MM.ajax({
                                url: '/?d=CM&c=CMInfo&a=frontTransferSubmit&userid=' + user_id,
                                data: data,
                                success: function (q) {
                                    IM.table.clearState();
                                    if (q == 0) {
                                        IM.dialog.hide();
                                        IM.tip.show('转移成功');
                                        pageList.reflash();//JumpPage('/?d=CM&c=CMInfo&a=showFrontInfoList');
                                        MM.each(tr, function (e) {
                                            MM.remove(e);
                                        });
                                    }else {
                                        IM.dialog.hide();
                                        IM.tip.warn('转移失败,请输入正确的转移账号');
                                    }
                                }
                            })
                        }
                    });
                });
            }
        });
    },
    customerMove3: function (url, data, title, w, h) {
        var htmlTemp = '<div class="tf"> \
                        	<label style="width:130px;">&nbsp;</label>    \
                            <div class="inp" style="color:#FF6600;">{0}</div>          \
                        </div>';
        w = w || 550;
        title = title || '客户转移';
        h = h || null;
        (data == null || data == '') ? data = {} : data = data;
        var listid = IM.table.getListID(),
        tr = IM.table.getSelectTr(),
        user_id = ''; //提交id
        if (tr && tr.length < 1) {
            IM.tip.warn('请选择要转移的客户');
            return;
        }
        MM.Extend(data, {
            'r': MM.Random(1000),
            'listid': listid
        });
        IM.dialog.show({
            width: w,
            height: h,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                MM.get("/?d=CM&c=CMInfo&a=frontTransfer", data, function (html) {
                    $('.DCont')[0].innerHTML = html;
                    $('#user_id').autocomplete('/?d=CM&c=CMInfo&a=CompleteUserId', {//页面加载完后执行初始化 自动用q作为地址栏参数，值为文件框输入内容，后台用GET获取
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
                                    value: value[i].user_id,
                                    result: value[i].user_name
                                }
                            }
                            return parsed;
                        },
                        formatItem: function (item) {//内部方法生成列表
                            return '<div>' + item.user_name + '</div>';
                        }
                    }).result(function (data, value) {
                        user_id = value.user_id;
                    });
                    new Reg.vf($('#J_customerMove2'), {
                        callback: function (pData) {
                            MM.Extend(data, {
                                'r': MM.Random(1000),
                                'listid': IM.table.getListID()
                            });
                            MM.ajax({
                                url: '/?d=CM&c=CMInfo&a=frontTransferSubmit&userid=' + user_id,
                                data: data,
                                success: function (q) {
                                    q = MM.json(q);
                                    if(q.success){
                                        IM.tip.show(q.msg);
                                        IM.dialog.hide();
                                        pageList.reflash();
                                    }else{
                                        IM.tip.warn(q.msg);
                                    }
//                                    IM.table.clearState();
//                                    if (q == 0) {
//                                        IM.dialog.hide();
//                                        IM.tip.show('转移成功');JumpPage('/?d=CM&c=CMInfo&a=showCustomerRecommend');
//                                        MM.each(tr, function (e) {
//                                            MM.remove(e);
//                                        });
//                                    }else {
//                                        IM.dialog.hide();
//                                        IM.tip.warn('转移失败,请输入正确的转移账号');
//                                    }
                                }
                            })
                        }
                    });
                });
            }
        });
    }
};
IM.Account = function () { };
IM.Account.prototype = {
    //前端 代理商账户层级
    AccountLevelDetail: function (id) {
        IM.dialog.show({
            width: 250,
            title: "账号层级信息",
            html:IM.STATIC.LOADING,
            start: function () {
                MM.get("/?d=System&c=AgentUser&a=AccountLevelDetail&id=" + id, {}, function (backData) {
                    $('.DCont')[0].innerHTML = backData;
                });
            }
        });
    },
    /**
    * 批量删除数据 或 删除单条
    * @param url
    * @param data {"xx":"xx","xx":"xx"}
    * @param title
    * @param context（删除单条时添加环境）
    * @param w
    * @param h
    */
    delOper: function (url, data, title, context, w, h, nodel) {
        var html = '<div class="DContInner setPWDComfireCont">' +
                   '<div class="bd"><h4>您确定要删除所选项吗？</h4></div>' +
                   '<div class="ft">' +
                   '<div class="ui_button ui_button_cancel"><a href="javascript:;" class="ui_button_inner" onclick="IM.dialog.hide()">取消</a></div>' +
                   '<div class="ui_button ui_button_confirm"><button type="submit" class="ui_button_inner" onclick="IM.dialog.ok()">确 定</button></div>' +
                   '</div></div>',
        listid = null, topTR = null, tr_inp = null, nodel = (typeof nodel == 'undefined') ? true : false;
        title = title;
        w = w || 250;
        h = h || null;
        (data == null || data == '') ? data = {} : data = data;
        if (context == 'undefined' || context == null || context == '') {
            listid = IM.table.getListID();
            topTR = IM.table.getSelectTr();
            if (topTR && topTR.length < 1) {
                IM.tip.warn('请选择要删除的数据');
                return
            }
        } else {
            topTR = $(context).parents('tr');
            tr_inp = topTR.find(':checkbox')[0];
            tr_inp && (listid = tr_inp.value);
        }
        IM.dialog.show({
            width: w,
            height: h,
            title: title,
            html: IM.STATIC.LOADING,
            start: function () {
                $('.DCont')[0].innerHTML = html;
            },
            ok: function () {
                !!listid&&MM.Extend(data, {
                    r: MM.Random(1000),
                    'listid': listid
                });
                MM.ajax({
                    url: url,
                    data: data,
                    success: function (q) {
                        backText = q;
                        q = MM.json(q);
						IM.dialog.hide();
                        if (q.success) {                            
                            if (topTR.length > 0 && nodel) {
                                MM.each(topTR, function (e) {
                                    MM.remove(e);
                                });
                            }							
			IM.tip.show('删除成功');
                            if (typeof QueryData == 'function')
                                QueryData();
                        } else if (q.msg) {
                            IM.tip.warn(q.msg);
                        }else {
                            IM.tip.warn(backText ||'删除失败');
                        }
                        IM.table.clearState();
                    }
                });
            }
        });
    },
    /**
     * 设置账号状态  "开启" 或 "关闭"
     * @param url
     * @param boolean
     */
    setAccountState:function(url,boolean){
        var listid=IM.table.getListID(),
        tr=IM.table.getSelectTr(),
        warnTemp="请选择要{0}的账号",
        text=boolean?'开启':'关闭';
        if((listid&&listid.length<1)||(tr&&tr.length<1)){
            IM.tip.warn(_(warnTemp,text));
            return
        }
        MM.get(url,{
            'r':MM.Random(100),
            'listid':listid
        },function(q){
            q=MM.json(q);
            if(q.success){
                IM.tip.show(text+'成功');
                MM.each(tr,function(e){
                    var target=$(e).find('.setState')[0];
                    if(!target)return;
                    target.innerHTML=text;
                    target.parentNode.title=text;
                });
                IM.table.clearState();
            }
        });
    }
};

/**09-20
 * 地区范围操作
 */
IM.SetArea=function(){
    this.splitSign='>';
    this.id='rel_id';
    this.delSign='dis';
    this.hiddenInput='#J_region';
};
IM.SetArea.prototype={
    render:function(area){
        var dataArr=area.split(this.splitSign);
        var tplLI='<li class="folder">{0}</li>',
            tplUL='<ul>{0}</ul>',
            tplA='<a href="javascript:;" rel="{0}" '+this.id+'="{2}">{1}</a>',
            tplTag='<div class="tag tagClose"></div>',
            html='',
            parNode=(this.curA).parent().clone(),
            relID=this.curA,
            aArr=(this.to)[0].getElementsByTagName('a'),
            self=this;
        /**
         * 比较目标是否包含该地区
         * @param rel
         * @return {Boolean}
         */
        function compare(rel){
            var b='';
            for(var i=0;i<aArr.length;i++){
                b=MM.A(aArr[i],'rel');
                if(b==rel) return true
            }
            return false
        }
        function contain(rel){
            var b='';
            for(var i=0;i<aArr.length;i++){
                b=MM.A(aArr[i],'rel');
                if(b.indexOf(rel)>=0) return true
            }
            return false
        }
        function findLevel2(dataArr){
            var b='';
            for(var i=0;i<aArr.length;i++){
                b=MM.A(aArr[i],'rel');
                if(b==dataArr[0]) return MM.next(aArr[i]);
            }
            var c =$(MM.DC("div")).html(parNode[0]);
            var d=MM.A((relID[0].parentNode.parentNode.parentNode).getElementsByTagName('a')[0],'rel_id');
            return MM.html(_(tplLI,tplTag+_(tplA,dataArr[0],dataArr[0],d)+_(tplUL,c.html())));
        }
        //处理目标不包含该地区
        if(!compare(this.rel)){
            if(dataArr.length==1){//省级
                html=parNode[0];
            }else if(dataArr.length==2){//地级
                var nodeUL=findLevel2(dataArr);//对比0
                if(nodeUL.nodeType==1){
                    $(nodeUL).append(parNode[0]);
                    this.opDel(this.curA);//删除节点
                    return;
                }else{
                    nodeUL=nodeUL||'';
                    html=nodeUL;
                }
            }else if(dataArr.length==3){//市/县/区级
                function a(index){
                    var b='';
                    for(var i=0;i<aArr.length;i++){
                        b=MM.A(aArr[i],'rel');
                        if(b.indexOf(dataArr[index])>=0) return MM.next(aArr[i]);
                    }
                }
                if(contain(dataArr[1])){//包含2级处理
                    var b=a(1);
                    if(b){
                        $(b).append(parNode[0]);
                    }
                }else if(contain(dataArr[0])){//包含1级处理
                    var p=a(0);//获得1级位置
                    var b =$(MM.DC("div")).html(parNode[0]);
                    var d=MM.A((relID.parents('li').find('a')[0]),'rel_id');
                    $(p).append(_(tplLI,tplTag+_(tplA,dataArr[0]+'>'+dataArr[1],dataArr[1],d)+_(tplUL,b.html())));
                }else{
                    var b =$(MM.DC("div")).html(parNode[0]);
                    var d=MM.A((relID[0].parentNode.parentNode.parentNode).getElementsByTagName('a')[0],'rel_id');
                    var e=MM.A(relID[0].parentNode.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('a')[0],'rel_id');
                    var c=_(tplLI,tplTag+_(tplA,dataArr[0]+'>'+dataArr[1],dataArr[1],d)+_(tplUL,b.html()));
                    html=_(tplLI,tplTag+_(tplA,dataArr[0],dataArr[0],e)+_(tplUL,c));
                    (this.to).append(html);
                }
                this.opDel(this.curA);//删除节点
                return;
            }
            this.opDel(this.curA);//删除节点
            (this.to).append(html);
        }
    },
    add:function(target,context){
        target=$(target);
        this.from=target.eq(0);
        this.to=target.eq(1);
        if(this.from){
            this.curA=(this.from).find('a.cur');
            this.rel = (this.curA).attr('rel') || '';
            this.rel_id = (this.curA).attr('rel_id') || '';
            this.repeat=true;
            this.curA.removeClass('cur');
            if(this.rel&&this.rel!=''){
                if(!this.isDel(this.curA[0]))this.render(this.rel);
                this.setVal();//设值
            }
        }
    },
    opDel:function(a){
        var _p_1=a[0].parentNode;
        var _p_2=_p_1.parentNode;
        var _p_3=_p_2.parentNode.parentNode;
        if(!this.isDel(a[0])) MM.remove(_p_1);
        if(!MM.hasClass(_p_2,'treeview2')){
            if(_p_2&&_p_2.getElementsByTagName('li').length<1) MM.remove(_p_2.parentNode);
        }
        if(!MM.hasClass(_p_2,'treeview2')&&!MM.hasClass(_p_3,'treeview2')){
            if(_p_2&&_p_2.getElementsByTagName('li').length<1) MM.remove(_p_2.parentNode);
            if(_p_3&&_p_3.getElementsByTagName('li').length<1) MM.remove(_p_3.parentNode);
        }
    },
    /**
     * 给隐藏预设置值
     */
    setVal:function(){
        var val=this.getVal(this.to);
        $(this.hiddenInput).val(val);
    },
    getVal:function(target){
        var arr=[],
            firstLI=target.find('> li'),
            id=this.id,
            val='';
        function f(v){
           MM.each($(v).find('a'),function(e){
               var v=MM.A(e,id);
               if(v&&v!='') arr.push(v);
           })
        }
        if(firstLI[0]){
            MM.each(firstLI,function(e){
                if(e.nodeType==1){
                    var secondLI=$(e).find('ul').eq(0).children();
                    if(secondLI[0]){
                        MM.each(secondLI,function(e){
                            if(e.nodeType==1){
                                var thirdLI=$(e).find('ul').eq(0).children();
                                if(thirdLI[0]){
                                    MM.each(thirdLI,function(e){
                                        if(e.nodeType==1){
                                           f(e)
                                        }
                                    });
                                }else{
                                   f(e)
                                }
                            }
                        });
                    }else{
                       f(e)
                    }
                }
            });
        }
        return arr.length>0?arr.join(','):'';
    },
    isDel:function(a){return a&&MM.hasClass(a,this.delSign)},
    del:function(target,context){
        var a;
        target=$(target);
        this.to=target.eq(0);//指定还原目标
        if(context){
            a=$(context);
        }else{
            a=(target.eq(1)).find('a.cur');
        }
        if(a[0]){
            this.curA=a;
            this.rel = a.attr('rel') || '';
            this.rel_id = a.attr('rel_id') || '';
            this.curA.removeClass('cur');
            if(!this.isDel(a[0]))this.render(MM.A(a[0],'rel'));
        }
        this.setVal(target.eq(1));//重设值
    }
};
/**09-20
 * 地区范围操作 代理商操作
 */
IM.SetAreaAgent=function(){
    this.splitSign='>';
    this.id='rel_id';
    this.delSign='dis';
    this.hiddenInput='#J_region';
};
IM.SetAreaAgent.prototype={
    render:function(area){
        var dataArr=area.split(this.splitSign);
        var tplLI='<li class="folder">{0}</li>',
            tplUL='<ul>{0}</ul>',
            tplA='<a href="javascript:;" rel="{0}" '+this.id+'="{2}">{1}</a>',
            tplTag='<div class="tag tagClose"></div>',
            html='',
            parNode=(this.curA).parent().clone(),
            relID=this.curA,
            aArr=(this.to)[0].getElementsByTagName('a'),
            self=this;
        function compare(rel){
            var b='';
            for(var i=0;i<aArr.length;i++){
                b=MM.A(aArr[i],'rel');
                if(b==rel) return false
            }
            return true
        }
        function contain(rel){
            var b='';
            for(var i=0;i<aArr.length;i++){
                b=MM.A(aArr[i],'rel');
                if(b.indexOf(rel)>=0) return true
            }
            return false
        }
        function findLevel2(dataArr){
            var b='';
            for(var i=0;i<aArr.length;i++){
                b=MM.A(aArr[i],'rel');
                if(b==dataArr[0]) return MM.next(aArr[i]);
            }
            var c =$(MM.DC("div")).html(parNode[0]);
            var d=MM.A((relID[0].parentNode.parentNode.parentNode).getElementsByTagName('a')[0],'rel_id');
            return MM.html(_(tplLI,tplTag+_(tplA,dataArr[0],dataArr[0],d)+_(tplUL,c.html())));
        }
        if(compare(this.rel)){
            if(dataArr.length==1){
                html=parNode[0];
            }else if(dataArr.length==2){
                var nodeUL=findLevel2(dataArr);//对比0
                if(nodeUL.nodeType==1){
                    $(nodeUL).append(parNode[0]);
                    return;
                }else{
                    nodeUL=nodeUL||'';
                    html=nodeUL;
                }
            }else if(dataArr.length==3){
                function a(index){
                    var b='';
                    for(var i=0;i<aArr.length;i++){
                        b=MM.A(aArr[i],'rel');
                        if(b.indexOf(dataArr[index])>=0) return MM.next(aArr[i]);
                    }
                }
                if(contain(dataArr[1])){//包含2级处理
                    var b=a(1);
                    if(b){
                        $(b).append(parNode[0]);
                    }
                }else if(contain(dataArr[0])){//包含1级处理
                    var p=a(0);//获得1级位置
                    var b =$(MM.DC("div")).html(parNode[0]);
                    var d=MM.A((relID.parents('li').find('a')[0]),'rel_id');
                    $(p).append(_(tplLI,tplTag+_(tplA,dataArr[0]+'>'+dataArr[1],dataArr[1],d)+_(tplUL,b.html())));
                }else{
                    var b =$(MM.DC("div")).html(parNode[0]);
                    var d=MM.A((relID[0].parentNode.parentNode.parentNode).getElementsByTagName('a')[0],'rel_id');
                    var e=MM.A(relID[0].parentNode.parentNode.parentNode.parentNode.parentNode.getElementsByTagName('a')[0],'rel_id');
                    var c=_(tplLI,tplTag+_(tplA,dataArr[0]+'>'+dataArr[1],dataArr[1],d)+_(tplUL,b.html()));
                    html=_(tplLI,tplTag+_(tplA,dataArr[0],dataArr[0],e)+_(tplUL,c));
                    (this.to).append(html);
                }
                return;
            }
            (this.to).append(html);
        }
    },
    add:function(target,context){
        target=$(target);
        this.from=target.eq(0);
        this.to=target.eq(1);
        if(this.from){
            this.curA=(this.from).find('a.cur'),
                this.rel = (this.curA).attr('rel') || '',
                this.rel_id = (this.curA).attr('rel_id') || '';
            this.repeat=true;
            this.curA.removeClass('cur');
            if(this.rel&&this.rel!=''){
                this.render(this.rel);
                this.setVal();//设值
            }else{
                //this.del(target,context)
            }
        }
    },
    /**
     * 给隐藏预设置值
     */
    setVal:function(){
        var val=this.getVal(this.to);
        $(this.hiddenInput).val(val);
    },
    getVal:function(target){
        var arr=[],
            firstLI=target.find('> li');
        id=this.id,
            val='';
        function f(v){
            MM.each($(v).find('a'),function(e){
                var v=MM.A(e,id);
                if(v&&v!='') arr.push(v);
            })
        }
        if(firstLI[0]){
            MM.each(firstLI,function(e){
                if(e.nodeType==1){
                    var secondLI=$(e).find('ul').eq(0).children();
                    if(secondLI[0]){
                        MM.each(secondLI,function(e){
                            if(e.nodeType==1){
                                var thirdLI=$(e).find('ul').eq(0).children();
                                if(thirdLI[0]){
                                    MM.each(thirdLI,function(e){
                                        if(e.nodeType==1){
                                            f(e)
                                        }
                                    });
                                }else{
                                    f(e)
                                }
                            }
                        });
                    }else{
                        f(e)
                    }
                }
            });
        }
        return arr.length>0?arr.join(','):'';
    },
    isDel:function(a){return a&&MM.hasClass(a,this.delSign)},
    del:function(target,context){
        if(context){
            if(!this.isDel(context)) MM.remove(context.parentNode);
        }else{
            target=$(target);
            this.to=target.eq(1);
            var a=(this.to).find('a.cur');
            if(a[0])
                if(!this.isDel(a[0])) MM.remove(a[0].parentNode);
        }
        this.setVal();//重设值
    }
};
IM.Table = function () {
    this.fix = 'ui_table';
    this.hover = 'ui_table_tr_hover';
    this.select = 'ui_table_tr_select';
    this.table_body = 'ui_table_bd';
    this.selectTR = [];
    this.ui_table = null;
};
IM.Table.prototype = {
    selectAll: function (checked) {
        MM.each(MM.GC('#J_ui_table input'), function (e) {
            if(!e.disabled)
            e.checked = checked;
        });
    },
    selectSub: function (checked, context, target) {
        var tbody = $(context).parents('tbody'),
        tr_arr = tbody.find('tr'),
        inp_arr = tr_arr.find('input'),
        inp_Arr = [],
        self = this;
        if (!!target) {
            tr_arr = $(tbody).find(target);
            tr_arr[0] && tr_arr.each(function (e) {
                inp_Arr.push($(this).find('input')[0]);
            });
            inp_arr = inp_Arr;
        }
        MM.each(inp_arr, function (e) {
            e.checked = checked
        });
        MM.each(tr_arr, function (e) {
            var _inp = e.getElementsByTagName('input')[0];
            if (MM.hasClass(e, self.select) && _inp.checked == false) {
                MM.removeClass(e, self.select);
                self.selectTR = [];
            } else {
                if (_inp.checked == true) MM.addClass(e, self.select);
            }
        });
    },
    checkAll: function (name) {
        var a = this;
        MM.each(MM.GC('#J_ui_table input'), function (e) {
            if (e.name == name) a.setListCheck(e);
        });
    },
    setListCheck: function (e, checked) {
        if (e.type != 'checkbox') return;
        (checked == null) ? checked = e.checked : e.checked = checked;
        var tr = e.parentNode.parentNode.parentNode;
        if (tr.tagName == 'TR') {
            if (MM.hasClass(tr, this.select) && e.checked == false) {
                MM.removeClass(tr, this.select);
                this.selectTR = [];
            } else {
                if (e.checked == true)
                    MM.addClass(tr, this.select);
            }
        }
    },
    getListID: function () {
        var a = this, id = [];
        this.selectTR = [];
        MM.each(MM.GC('.' + this.table_body + ' input'), function (e, i) {
            if (e.type == 'checkbox') {
                if (e.checked == true) {
                    id.push(e.value);
                    a.selectTR.push(e.parentNode.parentNode.parentNode);
                }
            }
        });
        return id;
    },
    clearState: function () {
        var table = this.getTable(),
        input = table[0].getElementsByTagName('input');
        if (input.length < 1) return;
        //清除选择状态
        MM.each(input, function (e) {
            if (e.checked == true) {
                e.checked = false;
            }
        });
        MM.each(this.selectTR, function (e) {
            $(e).removeClass('ui_table_tr_select');
        });
        this.setListid(); //重置listid
        this.setSelectTr(); //重置选中TR
    },
    setListid: function () {
        this.listid = []
    },
    setSelectTr: function () {
        this.selectTR = []
    },
    getSelectTr: function () {
        return this.selectTR;
    },
    getTable: function () {
        return this.ui_table;
    },
    init: function () {
        var a = this;
        this.ui_table = $('#J_ui_table');
        var ui_tableTR = $('#J_ui_table .ui_table_bd tr');
        if(ui_tableTR[0]){
            ui_tableTR.die('mouseover').live('mouseover',function(){
                $(this).addClass(a.hover);
            }).die('mouseout').live('mouseout',function(){
                $(this).removeClass(a.hover);
            });
        }
        $('body').live('click',function(e){
            var t=MM.E(e).target;
            if(t.tagName=='INPUT'&&t.type=='checkbox'&&t.name=='listid'){
                a.setListCheck(t);
            }
        });
        $("#J_ui_table tr:even").addClass("odd");
        $('#tableFilterForm').submit(function(){
            if(typeof search=='function'){
                search();
            }
            if(typeof QueryData=='function'){
                QueryData();
            }
            return false;
        });
    }
};
/**
 * toggle显示
 * @param target
 * @param context
 * @param s1
 * @param s2
 */
IM.Toggle=function(target,context,s1,s2){
    $(target).eq(0).css('display')=='block'?$(context).html(s1):$(context).html(s2);
    $(target).toggle();
};
/**
**检查手机或固化
*/
IM.checkPhone = function () {
    var mPhone = $('.mPhone').val(), fPhone = $('.fPhone').val();
    if (mPhone == '' && fPhone == '')
        return true;
};
/**
**检查联系人职务
*/
IM.officer = function () {
    var officer = $('.officer').val();
    if (officer == '')
        return true;
}
/**
 * 金额处理
 * @param context
 */
IM.AmountHandler=function(context){
    if(!context)return;
    MM.EA(context,'keyup',function(e){
        var target=MM.E(e).target;
        target.value=MM.d2c(target.value);
    });
    MM.EA(context,'keypress',function(e){
        var target=MM.E(e).target,
        charCode=MM.E(e).key;
        if(!/\d/.test(String.fromCharCode(charCode)) && charCode!=8 &&charCode !=110){
            MM.E(e).prevent();
            MM.E(e).stop();
        }
    });
};
/**08-25 12:00
 * 动态上传封装类
 * @param option
 * @param callback
 */
IM.upload=function(option,callback){
    this.id=option.id || null;
    this.noticeId=option.noticeId || null;
    this.url=option.url || '/?d=Agent&c=Agent&a=FileUpload';
    this.reg=option.reg || /\.(jpg|jpeg|gif|png|bmp)/i;
    this.callback=callback || null;
    this.init();
};
IM.upload.prototype={
    init:function(){
        var self=this;
        $('#'+this.id).bind('change',function(event){
            self.handler(event)
            });
    },
    handler:function(){
        var self=this
        id=$('#'+self.id),
        notice=$('#'+self.noticeId);
        if(!id[0] || !notice[0]) {
            alert('缺少id 或 错误提示块');
            return;
        }
        notice.addClass('loading').css('display','block');
        if(!self.format(id[0].value)){
            notice.html('文件格式不正确！');
            notice.addClass('err').removeClass('loading').css('display','block');
            return;
        }
        $.ajaxFileUpload({
            url: self.url,
            secureuri: false,
            fileElementId: self.id,
            dataType: 'text',
            success: function(data, status){
                notice.removeClass('loading');
                if(status&&status=='success'){
                    if(typeof self.callback=='function'){
                        self.callback(data);
                        return
                    }
                    var html='<img src="{0}" width="200"/>';
                    q=MM.json(data);
                    if(q.success){
                        notice[0].innerHTML=_(html,q.msg);
						MM.removeClass(notice[0],'err');
                        $('#permit'+self.id).val(q.msg).trigger('blur');
                    }else{
						MM.addClass(notice[0],'err');
                        notice[0].innerHTML=q.msg;
                    }
                }else if(status&&(status=='error'||status=='timeout')){
                    MM.addClass(notice[0],'err');
                    notice[0].innerHTML='服务器繁忙，请重试！';
                }
            }
        });
        self.init();
    },
    format:function(a){
        return this.reg.test(a)
        }
};

IM.Finance=function(){};
IM.Finance.prototype={
    /**
     *  预存款打款明细列表|保证金记录列表=----收据确认
     *  发票记录列表 --- 发票确认
     *  票据邮寄管理表 ---快递票据明细确认
     * @param url
     * @param data
     * @param title
     */
    ReceiptConfirm:function(url,pData,title){
        pData=pData||{};
        IM.dialog.show({
            width: 450,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                MM.get(url,pData,function(backHTML){
                    $('.DCont').html(backHTML);
                });
            },
            /**
             * 数据确认 是 | 否
             * @param boolean
             */
            ok:function(boolean){

                MM.Extend(pData,{'confirmResult':boolean});
                /**
                 * 获取相应提交地址
                 */
                if(title == '发票确认') url='/?d=FM&c=Invoice&a=InvoiceConfirmSubmit';
                else if(title == '收据确认') url="/?d=FM&c=Receipt&a=ReceiptConfirmSubmit";
                else
                {
                    IM.tip.warn("未找到对应信息");
                    return ;
                }
                MM.ajax({
                    url:url,
                    data:pData,
                    success:function(q){
                        //responseText: {"success":true,"msg":"确认成功"}
                        q = MM.json(q);
                        IM.dialog.hide();
                        if(q.success){
                            if(boolean)
                                IM.tip.show("收到确认成功！");
                            else
                                IM.tip.show("未收到确认成功！");                                                           
                            pageList.reflash();
                        }else{
                           IM.tip.warn(q.msg);
                        }
                    }
                });
            }
        });
    }
};
IM.Task=function(){};
IM.Task.prototype={
    /**
     * 任务管理 > 网营任务管理> 域名解析  完成/修改完成
     * @param url
     * @param data
     * @param title
     */
    addTag:function(url,data,title){
        var tplMain='<div class="DContInner tableFormCont">\
                            <form id="J_addTagForm">\
                                <div class="bd">                                       \
                                    <h4>{0}</h4>\
                                </div>                                                                                      \
                                <div class="ft">                                                                             \
                                    <div class="ui_button ui_button_cancel"><a onclick="IM.dialog.hide()" class="ui_button_inner" href="javascript:;">关闭</a></div>\
                                    <div class="ui_button ui_button_confirm"><button class="ui_button_inner" type="button" onclick="IM.dialog.ok()">确定</button></div>                      \
                                </div>                                                                                                                              \
                            </form>                                                                                                                                  \
                        </div>';
        data=data||{};
        var tips=(data.state==0)?'确定标记为任务已完成':'确定标记为任务已修改完成';//data.state  0完成  1修改完成
        IM.dialog.show({
            width: 350,
            title:title,
            html:IM.STATIC.LOADING,
            start:function(){
                $('.DCont')[0].innerHTML=_(tplMain,tips);
            },
            ok:function(){
                MM.ajax({
                    url:url,
                    data:data,
                    success:function(q){
                        //{"success":true,"msg":"标记成功"}
                        q=MM.json(q);
                        IM.dialog.hide();
                        if(q.success){
                            QueryData();
                            IM.tip.show(q.msg);
                        }else{
                            IM.tip.warn(q.msg);
                        }
                    }
                });
            }
        });
    }
};
/**
 *防止重复提交
 */
IM.IsSending=function(a){
    var t,
    inter=8000;
    clearTimeout(t);
    t=null;	
    if(!!a){		
        if (IM.IsSend) {
            IM.tip.warn("数据已提交，正在处理中！");
            return false;
        }
        IM.IsSend = true;
    }else IM.IsSend = false;	
    IM.console(IM.IsSend);
    t=setTimeout(function(){
        IM.IsSend = false;
    },inter);
    return true;
};
IM.dialog = IM.dialog || new MM.Dialog;
IM.agent = IM.agent || new IM.Agent;
IM.customer = IM.customer || new IM.Customer;
IM.account = IM.account || new IM.Account;
IM.tip = IM.tip || new MM.Tip;
IM.table = IM.table || new IM.Table;
IM.task = IM.task || new IM.Task;
IM.finance=IM.finance || new IM.Finance;
IM.comboBox=IM.comboBox || new MM.ComboBox;
IM.setArea=IM.setArea|| new IM.SetArea;
IM.setAreaAgent=IM.setAreaAgent|| new IM.SetAreaAgent;
MM.B.ie && document.execCommand("BackgroundImageCache", false, true);
$(function () {
    IM.table.init();
});