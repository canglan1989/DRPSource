<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>代理商全国分布图</title>
        <link rel="stylesheet" href="/../FrontFile/CSS/map_base.css"/>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
        <script type="text/javascript" src="/../FrontFile/JS/map.base.js"></script>
    </head>
    <body>
        <div id="j_container" class="container"></div>
        {literal}
            <script type="text/javascript">
                IM.STATIC={
                    LOADING:'<div class="loading"></div>',
                CONTAINER:'j_container',
                FLAG:'/../FrontFile/img/flag.png',
                ZOOM:7,
                //CENTER:{/literal}'{$xy}'{literal}
                CENTER:'110.03018,37.391597'
            };
            IM.map={};
            /**
             * 战区区域绘制数据
             * @type {Array}
             */
            IM.map.area=[{/literal}{$groupStr}{literal}];
    /**
     * 代理商绘制数据
     * @type {Array}
     */
    IM.map.data=[{/literal}{$area}{literal}];
                IM.map.pop=function(id,t){
                IM.dialog.show({
                width:700,
                title:t,
                html:IM.STATIC.LOADING,
                start:function(){
                MM.get('/?d=Map&a=showDetailInfo',{'id':id},function(q){//获取"修改密码"代码片段
                                $('.DCont')[0].innerHTML=q;
                });
                    }
                });
            };
            IM.map.addMarker = function (data){
            map.clearOverlays();
            if(data.length<1)return;
            for(var i=0;i<data.length;i++){
            var json=data[i],
            p0=json.point.split(",")[0],
            p1=json.point.split(",")[1],
            point=new BMap.Point(p0,p1),
            iconImg=IM.map.createIcon(IM.map.icon),
            marker=new BMap.Marker(point,{icon:iconImg}),
            label=new BMap.Label(json.title,{"offset":new BMap.Size(3,-18)});
            marker.setLabel(label);
            map.addOverlay(marker);
            label.setStyle({borderColor:"#cfcfcf",color:"#333",cursor:"pointer"});
            (function(){var _j=json,_m=marker;_m.addEventListener("click",function(){IM.map.pop(_j.id,_j.title)});label.addEventListener("click",function(){IM.map.pop(_j.id,_j.title)});})();
    }
    };
    IM.map.areaRender=function(a){
    for(var i=0;i<a.length;i++){
    var b=[],c='';
    for(var j=0;j<a[i].pos.length;j++){
    c=a[i].pos[j].split(',');
    b.push(new BMap.Point(c[0],c[1]));
    }
    var area=new BMap.Polygon(b, {strokeColor:"blue", fillColor:'#ff4e00', strokeWeight:3,fillOpacity:0.2, strokeOpacity:0.3});
    var areaLabelCenter = new BMap.Point(a[i].center.split(',')[0],a[i].center.split(',')[1]);
    var areaLabel=new BMap.Label(a[i].area,{offset:new BMap.Size(10,-30),position:areaLabelCenter});
    areaLabel.setStyle({"border": "none", "padding": "2px","background": "#ff6666",'color':"#fff"});
    (function(){var _a=area,_b=areaLabel;_a.addEventListener("mouseover",function(){ _a.setStrokeColor("red");_b.setStyle({'background':'#ff0000'});});_a.addEventListener("mouseout",function(){ _a.setStrokeColor("blue");_b.setStyle({'background':'#ff6666'});});})();map.addOverlay(areaLabel);//map.addOverlay(area);
    }
    };
    IM.map.icon={w:32,h:32,t:0,l:0};
IM.map.setCenter=function(xy,zoom){if(xy.indexOf(',')<0||xy=='')return;map.centerAndZoom(new BMap.Point(xy.split(',')[0],xy.split(',')[1]),zoom);};
IM.map.initMap=function(){window.map = new BMap.Map(IM.STATIC.CONTAINER);var xy=MM.parseUrl().xy || IM.STATIC.CENTER;IM.map.setCenter(xy,IM.STATIC.ZOOM);map.enableKeyboard();map.enableScrollWheelZoom();map.enableInertialDragging();map.enableContinuousZoom();map.addControl(new BMap.NavigationControl());IM.map.addMarker(IM.map.data);IM.map.size();IM.map.areaRender(IM.map.area);};
IM.map.size=function(){var _c=MM.G(IM.STATIC.CONTAINER),_h;function _size(){setTimeout(function(){_h=MM.windowHeight()-2+'px';_c.style['height']=_h;},100);}MM.EA(window, "resize", _size);_size();};
IM.map.createIcon=function(a){var icon=new BMap.Icon(IM.STATIC.FLAG, new BMap.Size(a.w,a.h),{imageOffset: new BMap.Size(-a.l,-a.t),infoWindowAnchor:new BMap.Size(a.w,a.t),anchor:new BMap.Size(a.x,a.h)});return icon;};
IM.map.initMap();
            </script>
        {/literal}
    </body>
</html>