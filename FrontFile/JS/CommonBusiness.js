//配置参数
(function ($, undefined) {
    var ps_frame = {
    	ps_data: {
            "saveDOMID": "saveDOM", //用来保存搜索框内容 在main页面底部
            "isMax": false, //是否属于全屏状态下
            "headID": "Head", //页面头部ID
            "navID": "J_sidenav", //左侧导航栏ID
            "mainID": "mainContent", //主页面ID
            "mainMarginLeft": 190//主页面marginLeft
        },
        //添加全屏DOM事件
        addMax: function (id) {
            var maxDOM = document.getElementById(id);
            if(!maxDOM) return;
            //if ($.ps_data.isMax) {
            //    maxDOM.innerHTML = "<span class=\"ui_icon ui_icon_fullscreenNO\">&nbsp;</span>还原";
            $(maxDOM).unbind('click').bind('click',function(){
				var self=$(this);
				$.sizeHandler(self);
			});
            //}
            //else {
            //    maxDOM.innerHTML = "<span class=\"ui_icon ui_icon_fullscreen\">&nbsp;</span>全屏";
			//	$(maxDOM).unbind('click').bind('click',$.maxSize);
            //}
        },
		sizeHandler:function(self){			
			if(self.hasClass('hasMax')){
				$.regainSize(self);
			}else{
				$.maxSize(self);
			}
		},
        //全屏化DOM尺寸
        maxSize: function (srcDOM) {
            //ev = window.event || ev;
            //隐藏上左侧栏
            var head = document.getElementById($.ps_data.headID);
            head.style.display = "none";
            var nav = document.getElementById($.ps_data.navID);
            nav.style.display = "none";
            //左移主页面
            var dom = document.getElementById($.ps_data.mainID);
            if (dom) {
                dom.style.marginLeft = "";
                dom.style.marginLeft = "0px";
            }
            //设置文本
            $.ps_data.isMax = true;
            //srcDOM = ev.target || ev.srcElement
            srcDOM.html("<span class=\"ui_icon ui_icon_fullscreenNO\">&nbsp;</span>还原");
			srcDOM.addClass('hasMax');
            srcDOM.attr("title", "还原显示表格");
            //更改触发事件
            //srcDOM.onclick = $.regainSize;
        },
        //还原DOM尺寸
        regainSize: function (srcDOM) {
            //ev = window.event || ev;
            /**/
            //显示上左侧栏
            var head = document.getElementById($.ps_data.headID);
            head.style.display = "";
            var nav = document.getElementById($.ps_data.navID);
            nav.style.display = "";
            //还原主页面
            var dom = document.getElementById($.ps_data.mainID);
            if (dom) {
                dom.style.marginLeft = $.ps_data.mainMarginLeft + "px";
            }
            //设置文本
            $.ps_data.isMax = false;
            
            if(srcDOM == undefined || srcDOM == null)
                return ;
            //srcDOM = ev.target || ev.srcElement
            srcDOM.html("<span class=\"ui_icon ui_icon_fullscreen\">&nbsp;</span>全屏");
			srcDOM.removeClass('hasMax');
            srcDOM.attr("title", "全屏显示表格");
            //更改触发事件
            //srcDOM.onclick = $.maxSize;
        },
        //设置是否显示上次搜索DOM 参数
        //idFlag 保存的页面标识 防止被其他页面利用的情况
        set_iBackParam: function (idFlag) {
            if (!document.getElementById(idFlag)) {
                return "";
            }
            return idFlag;
        },
        //保存搜索HTML 与搜索事件
        //id 需要保存的搜索内容
        //idFlag 保存的页面标识 防止被其他页面利用的情况
        saveSearchHTML: function (id, idFlag) {
            //获取搜索DOM
            var searchDOM = document.getElementById(id);
            if (searchDOM) {//保存到main页面底部
                //生成保存搜索框div到main页面
                var saveDOM = document.getElementById($.ps_data.saveDOMID);
                if (!saveDOM) {
                    saveDOM = $.createDiv({ id: $.ps_data.saveDOMID, style: { display: "none"} });
                    document.body.appendChild(saveDOM);
                }
                $.removeAllChildNode(saveDOM);
                for (var node_i = 0; node_i < searchDOM.childNodes.length; node_i++) {
                    if (searchDOM.childNodes[node_i].nodeName == "DIV") {
                        searchDOM.childNodes[node_i].id = idFlag;
                        saveDOM.appendChild(searchDOM.childNodes[node_i]);
                    }
                }
            }
        },
        //返回替换搜索HTML 并执行搜索事件
        //id 需要覆盖的搜索内容
        //idFlag 保存的页面标识 防止被其他页面利用的情况
        getSearchHTML: function (id, idFlag) {
            var searchDOM = document.getElementById(id);
            if (searchDOM.childNodes.length < 2) {
                //将保存的searchDOM添加到该搜索位置
                var saveDOM = document.getElementById($.ps_data.saveDOMID);
                if (saveDOM && saveDOM.firstChild && saveDOM.firstChild.id == idFlag) {
                    searchDOM.appendChild(saveDOM.firstChild);
                }
            }
        },
        
        addSubmitData: function (key, value) { },
        //添加最后一次被修改的客户信息
        //change_values {"customer":{"reg_status":"\u5728\u518c","customer_resource":"0"}}
        addModifiedCustomerInfo: function (change_values) {
//            for (var key in change_values) {
//                div = $.createDiv({ className: "inp_add" });
//                div.appendChild($.createInput({ type: "checkbox", className: "checkInp", key: key, value: change_values[key].oldValue, id: "chk_changed_" + key }));
//                var em = document.createElement("em");
//                em.innerHTML = change_values[key];
//                div.appendChild(em);
//                switch (key) {
//                    case "area_id":
//                        em.innerHTML = $.GetFullAreaName(change_values[key].oldValue);
//                        break;
//                    case "industry_id":
//                        em.innerHTML = $.GetFullIndustryName(change_values[key].oldValue);
//                        break;
//                    case "address":
//                        key = "area_id";
//                        break;
//                    case "contact_sex":
//                        em.innerHTML = change_values[key].oldValue == "1" ? "男" : "女";
//                        break;
//                    default: break;
//                }
//                if (document.getElementById(key))
//                    document.getElementById(key).appendChild(div);
//            }
            for (var keys in change_values){
                var change_json = change_values[keys];
                for (var key in change_json){
                    div = $.createDiv({className: "inp_add"});
                    if(change_json[key] == -1)
                        name = '无';
                    else
                        name = $PostData("/?d=CM&c=CMVerify&a=GetAreaName&id="+change_json[key],"");
                        
                    div.appendChild($.createInput({type: "checkbox", className: "checkInp", key: key, value: name, id: "chk_changed_" + key}));
                    var em = document.createElement("em");
                                  
                    em.innerHTML = change_json[key];
                    div.appendChild(em);
//                    alert(change_values['contact_id']);
                    switch (key) {
                        case "area_id":
                            em.innerHTML = $.GetFullAreaName(change_json[key]);
                            break;
                        case "reg_place":
                            em.innerHTML = $.GetFullAreaName1(change_json[key]);
                            break;
                        case "industry_id":
                            em.innerHTML = $.GetFullIndustryName(change_json[key]);
                            break;
                        case "address":
                            key = "area_id";
                            break;
                        case "contact_sex":
                            em.innerHTML = change_values['contact_id'].contact_sex == "0" ? "男" : "女";
                            break;
                        default:break;
                    }
                    if (document.getElementById(key))
                        document.getElementById(key).appendChild(div);
                    if(keys == "customer"){
                        $("#is_contact").val(1);
                    }
                }
            }
        },
        AddAdhaiAccountToBasePlatform: function (orderID) {
            $.ajax({
                async: true, //true 异步 默认true
                type: "POST",
                dataType: "text",
                url: "/?d=OM&c=UnitOrder&a=AddAdhaiAccountToBasePlatform",
                data: "orderID="+orderID,
                success: function (data) {
                    strReturn = data + "";
                }
            });
        },
        //设置审核页面需要回发的必要信息
        setChangedPostData: function () {
            var data = {};
            $('input[id^="chk_changed_"]:checked').each(function () {
                data[this.key] = this.value;
                if (!data["recoverKeys"]) data["recoverKeys"] = "";
                data["recoverKeys"] += this.key + ","; //设置被复原的客户信息键
            });
            if (data["recoverKeys"])
                data["recoverKeys"] = data["recoverKeys"].slice(0, -1);
            //下面是审核信息
            data.is_del = $("#is_del").val();
            data.customer_id = $("#customer_id").val();
            data.check_status = $("#check_status").val();
            data.check_remark = $("#check_remark").val();
            data.aid = $("#aid").val();
            data.keyValue = $("#keyValue").val();
            data.is_contact = $("#is_contact").val();
            data.contact_id = $("#contact_id").val();
            return data;
        },
        //通过AreaID 获取 Area全名
        GetFullAreaName: function (areaID) {
            var areas = Config.GetArea();
            return areas[areaID].fullname;
        }, 
        GetFullAreaNameJ: function (areaID) {
            var areas = Config.GetArea();
            if(areaID == "-1"){return "无";}
           else{ return areas[areaID].fullname;}
        }, 
        GetFullAreaName1: function (areaID) {
            
            var areas = Config.GetArea();
            if(areaID > 0){
            return areas[areaID].fullname;}
            else {return "";}
        },
        //通过IndustryID 获取 Industry全名
        GetFullIndustryName: function (industryID) {
            var industry = Config.GetIndustry();
            return industry[industryID].fullname;
        },
        GetProvinceData: function (iAll) {
            var data = new Array();
            var provinces = Config.GetProvinces(iAll);
            for (var provinceID in provinces) {
                data.push({value: provinceID, innerHTML: provinces[provinceID].name});
            }
            return data;
        },
        GetCityData: function (provinceID,iAll) {
            var data = new Array();
            var provinces = Config.GetProvinces(iAll);
            var citys = provinces[provinceID];
            if (!citys) return data;
            for (var cityID in citys.citys) {
                data.push({value: cityID, innerHTML: citys.citys[cityID].name});
            }
            return data;
        },
        GetAreaData: function (provinceID, cityID ,iAll) {
            var data = new Array();
            var provinces = Config.GetProvinces(iAll)
            var citys = provinces[provinceID];
            if (!citys) return data;
            var areas = citys.citys[cityID];
            if (!areas) return data;
            for (var areaID in areas.areas) {
                data.push({value: areaID, innerHTML: areas.areas[areaID].name});
            }
            return data;
        },
        GetProvinceChannelData: function () {
            var data = new Array();
            var provinces = Config.GetProvincesChannel();
            for (var provinceID in provinces) {
                data.push({value: provinceID, innerHTML: provinces[provinceID].name});
            }
            return data;
        },
        GetCityChannelData: function (provinceID) {
            var data = new Array();
            var provinces = Config.GetProvincesChannel();
            var citys = provinces[provinceID];
            if (!citys) return data;
            for (var cityID in citys.citys) {
                data.push({value: cityID, innerHTML: citys.citys[cityID].name});
            }
            return data;
        },
        GetAreaChannelData: function (provinceID, cityID ) {
            var data = new Array();
            var provinces = Config.GetProvincesChannel();
            var citys = provinces[provinceID];
            if (!citys) return data;
            var areas = citys.citys[cityID];
            if (!areas) return data;
            for (var areaID in areas.areas) {
                data.push({value: areaID, innerHTML: areas.areas[areaID].name});
            }
            return data;
        },
        GetPIndustryData: function () {//获取父行业
            var data = new Array();
            var p_inds = Config.GetPIndustry();
            if (!p_inds) return data;
            for (var p_ind in p_inds) {
                data.push({value: p_ind, innerHTML: p_inds[p_ind].name});
            }
            return data;
        },
        GetIndustryData: function (p_industry_id) {//获取子行业
            var data = new Array();
            var pIndustry = Config.GetPIndustry();
            var inds = pIndustry[p_industry_id];
            if (!inds) return data;
            for (var ind in inds.inds) {
                data.push({value: ind, innerHTML: inds.inds[ind].name});
            }
            return data;
        },
        GetConstData: function (constTypeName) {
        	var data = new Array();
            var constData = Config.GetConstData();
        	var consts = constData[constTypeName];
        	if (!consts) return data;
        	for (var cons in consts){
        		data.push({value: cons, innerHTML: consts[cons]});
        	}
        	return data;
        }
    }
    var ps_frame_fn = {
        //select 常量表数据绑定
        //constName 常量名
        BindConstData: function (constTypeName, value) {
    		if(!this[0] || this[0].nodeName != "SELECT" || this.length !== 1) return this;
    		var select = this[0];
    		data = $.GetConstData(constTypeName);
    		var ths = $(select);
    		if (constTypeName) {
    			var newOption = new Array();
    			newOption.push({value: "",innerHTML: "请选择"});
    			data = newOption.concat(data);
    		}
    		ths.BindData(data);
    		if(value) {
    			ths.val(value);
    		}
    	return this;
        },
        //select 绑定
        //data [{key:value,value:value},{key:value1,value:value1}]
        BindData: function (data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            if (!data) {
                var data = new Array();
                data.push({value: -1, innerHTML: "请选择"});
            }
            var _select = this[0];
            $.removeAllChildNode(_select);
            MM.each(data, function (e, i) {
                _select[i] = new Option(e.innerHTML, e.value); //IE中不能用 createElement方式 创建 option 会造成一些奇怪的问题
            });
        },
        //绑定省下拉并联动 城市与县镇
        //var _data={
        //selCityID:"selCity",  联动时城市下拉ID
        //selAreaID:"area_id",  联动时县镇下拉ID
        //area_id:area_id,  县镇选中值
        //city_id:city_id,  城市选中值
        //province_id:province_id,  省选中值
        //iAddPleaseSelect:false    是否增加请选择选项 该默认value值为-1
        //};
        //下面两个函数参数说明相同
        BindProvince: function (_data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            var select = this[0];
            data = $.GetProvinceData(_data.iAll);
            var ths = $(select);
            if (_data.iAddPleaseSelect) {
                var newOption = new Array();
                newOption.push({value: -1, innerHTML: "省份"});
                data = newOption.concat(data);
            }
            ths.BindData(data);
            if (_data.province_id) {//编辑页面，载入数据库保存值
                ths.val(_data.province_id);
            }
            _data.province_id = ths.val();
            $("#" + _data.selCityID).BindCity(_data);
            ths.change(function () {
                _data.province_id = ths.val();
                $("#" + _data.selCityID).BindCity(_data);
            });
            return this;
        },
        //绑定城市下拉并联动 县镇
        //_data.province_id 选中的省code
        //_data.selAreaID 联动时县镇下拉ID
        BindCity: function (_data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            var select = this[0];
            var data = $.GetCityData(_data.province_id,_data.iAll);
            var ths = $(select);
            if (_data.iAddPleaseSelect) {
                var newOption = new Array();
                newOption.push({value: -1, innerHTML: "市"});
                data = newOption.concat(data);
            }
            ths.BindData(data);
            if (_data.city_id) {//编辑页面，载入数据库保存值
                ths.val(_data.city_id);
            }
            _data.city_id = ths.val();
            $("#" + _data.selAreaID).BindArea(_data);
            ths.change(function () {
                _data.city_id = ths.val();
                $("#" + _data.selAreaID).BindArea(_data);
            });
            return this;
        },
        //绑定县镇下拉
        //_data.city_id 选中的城市code
        BindArea: function (_data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            var select = this[0];
            var data = $.GetAreaData(_data.province_id, _data.city_id,_data.iAll);
            var ths = $(select);
            if (_data.iAddPleaseSelect) {
                var newOption = new Array();
                newOption.push({value: -1, innerHTML: "区/县"});
                data = newOption.concat(data);
            }
            ths.BindData(data);
            if (_data.area_id) {//编辑页面，载入数据库保存值
                ths.val(_data.area_id);
            }
            return this;
        },
        //绑定 渠道经理 省下拉并联动 城市与县镇 
        //var _data={
        //selCityID:"selCity",  联动时城市下拉ID
        //selAreaID:"area_id",  联动时县镇下拉ID
        //area_id:area_id,  县镇选中值
        //city_id:city_id,  城市选中值
        //province_id:province_id,  省选中值
        //iAddPleaseSelect:false    是否增加请选择选项 该默认value值为-1
        //};
        //下面两个函数参数说明相同
        BindProvinceChannel: function (_data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            var select = this[0];
            data = $.GetProvinceChannelData();
            var ths = $(select);
            if (_data.iAddPleaseSelect) {
                var newOption = new Array();
                newOption.push({value: -1, innerHTML: "省份"});
                data = newOption.concat(data);
            }
            ths.BindData(data);
            if (_data.province_id) {//编辑页面，载入数据库保存值
                ths.val(_data.province_id);
            }
            _data.province_id = ths.val();
            $("#" + _data.selCityID).BindCityChannel(_data);
            ths.change(function () {
                _data.province_id = ths.val();
                $("#" + _data.selCityID).BindCityChannel(_data);
            });
            return this;
        },
        //绑定城市下拉并联动 县镇
        //_data.province_id 选中的省code
        //_data.selAreaID 联动时县镇下拉ID
        BindCityChannel: function (_data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            var select = this[0];
            var data = $.GetCityChannelData(_data.province_id);
            var ths = $(select);
            if (_data.iAddPleaseSelect) {
                var newOption = new Array();
                newOption.push({value: -1, innerHTML: "市"});
                data = newOption.concat(data);
            }
            ths.BindData(data);
            if (_data.city_id) {//编辑页面，载入数据库保存值
                ths.val(_data.city_id);
            }
            _data.city_id = ths.val();
            $("#" + _data.selAreaID).BindAreaChannel(_data);
            ths.change(function () {
                _data.city_id = ths.val();
                $("#" + _data.selAreaID).BindAreaChannel(_data);
            });
            return this;
        },
        //绑定县镇下拉
        //_data.city_id 选中的城市code
        BindAreaChannel: function (_data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            var select = this[0];
            var data = $.GetAreaChannelData(_data.province_id, _data.city_id);
            var ths = $(select);
            if (_data.iAddPleaseSelect) {
                var newOption = new Array();
                newOption.push({value: -1, innerHTML: "区/县"});
                data = newOption.concat(data);
            }
            ths.BindData(data);
            if (_data.area_id) {//编辑页面，载入数据库保存值
                ths.val(_data.area_id);
            }
            return this;
        },
        //绑定第一级别行业下拉
        //var _data={
        //secondLevelID:"industry_id",  联动时行业第二级别下拉ID
        //industry_pid:industry_pid,  行业第一级别选中值
        //industry_id:industry_id,  行业第二级别选中值
        //iAddPleaseSelect:false    是否增加请选择选项 该默认value值为-1
        //};
        BindIndustryFirstLevelGet: function (_data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            var select = this[0];
            var data = $.GetPIndustryData();
            var ths = $(select);
            if (_data.iAddPleaseSelect) {
                var newOption = new Array();
                newOption.push({value: -1, innerHTML: "一级分类"});
                data = newOption.concat(data);
            }
            ths.BindData(data);
            if (_data.industry_pid) {//编辑页面，载入数据库保存值
                ths.val(_data.industry_pid);
            }
            _data.industry_pid = ths.val();
            $("#" + _data.secondLevelID).IndustrySecondLevelGet(_data);
            ths.change(function () {
                _data.industry_pid = ths.val();
                $("#" + _data.secondLevelID).IndustrySecondLevelGet(_data);
            });
            return this;
        },
        //绑定第二级别行业下拉
        //var _data={
        //industry_pid:industry_pid,  行业第一级别选中值
        //industry_id:industry_id,  行业第二级别选中值
        //iAddPleaseSelect:false    是否增加请选择选项 该默认value值为-1
        //};
        IndustrySecondLevelGet: function (_data) {
            if (!this[0] || this[0].nodeName !== "SELECT" || this.length !== 1) return this;
            var select = this[0];
            var data = $.GetIndustryData(_data.industry_pid);
            var ths = $(select);
            if (_data.iAddPleaseSelect) {
                var newOption = new Array();
                newOption.push({value: -1, innerHTML: "二级分类"});
                data = newOption.concat(data);
            }
            ths.BindData(data);
            if (_data.industry_id) {//编辑页面，载入数据库保存值
                ths.val(_data.industry_id);
            }
            return this;
        }
    };
    $.extend(ps_frame);
    $.fn.extend(ps_frame_fn);
})(jQuery)