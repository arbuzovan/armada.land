var Map = {};
Map.Point = function (data) {
    this.id = data.id;
    this.lat = data.lat;
    this.lng = data.lng;
    this.zoom = data.zoom;
    this.name = data.name;
    this.address = data.address;
    this.phones = data.phones;
    this.emails = data.emails;
    this.pos = data.pos;
    this.imageURL = data.imageURL;
    this.html = data.html;
    this.htmlOver = data.htmlOver;
    this.clusterId = data.clusterId;
    this.withLayer = data.withLayer;
    this.filter = data.filter;
    this.pointZoom = data.pointZoom;
    this.onDrag = data.onDrag;
    this.mapObject = null;
    this.mapLayer = null;
    this.icon = data.icon;
    this.iconSize = data.iconSize;
    this.iconOffset = data.iconOffset;
}
Map.Area = function (data) {
    this.id = data.id;
    this.stageId = data.stageId;
    this.name = data.name;
    this.coords = data.coords;
    this.htmlOver = data.htmlOver;
    this.html = data.html;
    this.htmlZoom = data.htmlZoom;
    this.htmlFull = data.htmlFull;
    this.fillColor = data.fillColor;
    this.strokeColor = data.strokeColor;
    this.opacity = data.opacity;
    this.opacityOver = data.opacityOver;
    this.url = data.url;
    this.params = data.params;
    this.onClick = data.onClick;
    this.mapObject = null;
    this.mapObject2 = null;
}

Map.DEFAULT_LNG = 30.34;
Map.DEFAULT_LAT = 59.93;
Map.DEFAULT_ZOOM = 9;

Map.lng = null;
Map.lat = null;
Map.zoom = null;
Map.minZoom = 0;
Map.maxZoom = 17;

Map.currentMapObject = null;
Map.map = null;
Map.points = null;
Map.filter = null;
Map.areas = {};
Map.globalLayer = null;
Map.globalLayer2 = null;
Map.onBoundsChange = null;
Map.withScrollZoom = false;
Map.noPointZoom = false;
Map.withGlobalLayer = true;
Map.withCluster = false;
Map.withStageId = null;

Map.init = function () {
    var mapEl = $("#map");
    if (!mapEl)return;

    mapEl.innerHTML = "";

    var countPoints = 0;
    if (Map.points != null) {
        for (var key in Map.points) {
            var item = Map.points[key];
            countPoints++;
        }
    }

    if (Map.map)Map.map.destroy();

    if (countPoints > 0) {
        Map.map = new ymaps.Map("map", {
                center: [Map.lat ? Map.lat : Map.DEFAULT_LAT, Map.lng ? Map.lng : Map.DEFAULT_LNG],
                zoom: Map.zoom ? Map.zoom : Map.DEFAULT_ZOOM
            },{
                minZoom: Map.minZoom,
				maxZoom: Map.maxZoom
            }
        );

        Map.addPoints(Map.zoom ? false : true);

        Map.map.events.add("boundschange", function (e) {
            if (Map.onBoundsChange != null)Map.onBoundsChange(e);
            Map.setPointsVisibilityByZoom();
        });
    }
    else {
        Map.map = new ymaps.Map("map", {
                center: [Map.DEFAULT_LAT, Map.DEFAULT_LNG],
                zoom: Map.DEFAULT_ZOOM
            }
        );
    }

    if(Map.withScrollZoom)Map.map.behaviors.enable('scrollZoom');
    Map.map.controls.add("zoomControl");

    for (var key in Map.areas) {
        var a = Map.areas[key];
        if(!a.coords)continue;
        if(Map.withStageId != null && a.stageId != Map.withStageId) continue;
        var p = new ymaps.Polygon([a.coords], {
            hintZIndex: 10,
            areaData: a,
			properties: {
				balloonContent: a.htmlFull
			}
        }, {
            fillColor: a.fillColor,
            strokeColor: a.strokeColor,
            strokeWidth: 0,
            opacity: a.opacity,
            strokeOpacity: 0
        });
        a.mapObject=p;

        p.events
            .add('mouseenter', function (e) {
                var p = e.get('target');
                var a = p.properties.get("areaData");
                p.options.set('opacity', a.opacityOver);
            })
            .add('mouseleave', function (e) {
                var p = e.get('target');
                var a=p.properties.get("areaData");
                p.options.set('opacity', a.opacity);
            });

        Map.map.geoObjects.add(p);

        var cc = Map.avgCoords(p);

        var pp = new ymaps.Placemark(cc,{
            prop1: a.id,
            iconContent: a.html,
            balloonContent: a.htmlFull,
			hintContent: a.htmlOver,
            areaData: a
        }, {
            hasHint : true,
            hasBaloon : false,
            iconImageHref: '/images/template/e.gif',
            iconImageSize: [30, 30],
            iconImageOffset: [-15, -15]
        });
        Map.map.geoObjects.add(pp);
        a.mapObject2 = pp;

        pp.events
            .add('mouseenter', function (e) {
                var pp = e.get('target');
                var a = pp.properties.get('areaData');
                var p = a.mapObject;
                p.options.set('opacity', a.opacityOver);
            })
            .add('mouseleave', function (e) {
                var pp = e.get('target');
                var a = pp.properties.get('areaData');
                var p = a.mapObject;
                p.options.set('opacity', a.opacity);
            }).
			add('balloonopen', function (e) {
				var pp = e.get('target');
                var number = pp.properties.get('prop1');
				$('#pp_orderplace #inp_place_number').val(number);
            });
    }

    if ( Map.withStageId ) {
        var cc = [0, 0];
        var l = 0;
        for (var key in Map.areas) {
            var a = Map.areas[key];
            if (!a.coords)continue;
            if (Map.withStageId && a.stageId != Map.withStageId) continue;
            var coords = a.coords;
            for (var i = 0; i < coords.length; i++) {
                cc[0] += coords[i][0];
                cc[1] += coords[i][1];
                l++;
            }
        }
        if (l > 0) {
            cc[0] = cc[0] / (l*1.0000);
            cc[1] = cc[1] / l;
            Map.map.setCenter(cc, 17);
        }
    }
}

Map.avgCoords=function(poly){
    var cc=[0,0];
    var coords = poly.geometry.getPixelGeometry().getBounds();
    for(var i=0;i<coords.length;i++){
        cc[0]+= coords[i][0];
        cc[1]+= coords[i][1];
    }
    cc[0]=cc[0]/coords.length;
    cc[1]=cc[1]/coords.length;
    var geoCenter = Map.map.options.get('projection').fromGlobalPixels(cc, Map.map.getZoom());
    return geoCenter;

    for(var i=0;i<coords.length;i++){
        cc[0]+= coords[i][0];
        cc[1]+= coords[i][1];
    }
    cc[0]=cc[0]/coords.length;
    cc[1]=cc[1]/coords.length;
    return cc;
}

Map.setPointsVisibilityByZoom = function () {
    if(Map.noPointZoom)return;
    var z = Map.map.getZoom();
    for (var key in Map.points) {
        var a = Map.points[key];

        if (a.withLayer && a.pointZoom) {
            if (z > a.pointZoom) {
                a.mapObject.options.set('visible', false);
            }
            else {
                a.mapObject.balloon.close();
                a.mapObject.options.set('visible', true);
            }
        }
    }

    for (var key in Map.areas) {
        var a = Map.areas[key];
        if (!a.coords)continue;

        if (a.htmlZoom&&a.mapObject) {
            if ( z < a.htmlZoom) {
                a.mapObject.options.set('visible', false);
                a.mapObject2.options.set('visible', false);
            }
            else {
                a.mapObject.options.set('visible', true);
                a.mapObject2.options.set('visible', true);
            }
        }
    }
}
Map.addPoints = function (withFit) {
    if ( Map.withCluster && !Map.filter ) {
        Map.clusters = {};
        for (var key in Map.points) {
            var a = Map.points[key];
            if(a.clusterId){
                if(typeof(Map.clusters['cluster'+a.clusterId])=="undefined"){
                    var layout = ymaps.templateLayoutFactory.createClass(
                        '<div></div>');

                    var cluster = new ymaps.Clusterer({
                        //preset: 'islands#invertedVioletClusterIcons',
                        groupByCoordinates: false,
                        //clusterDisableClickZoom: true,
                        //clusterHideIconOnBalloonOpen: false,
                        //geoObjectHideIconOnBalloonOpen: false,
                        gridSize: 405,
                        //hasBalloon:true,
                        //hasHint:false,
                        maxZoom:10,
                        margin:0,
                        zoomMargin:50,
                        //clusterNumbers: [100],
                        clusterIconContentLayout: layout,
                        //clusterOpenBalloonOnClick:true,
                        clusterIcons: [{
                            href: '/i/Map.cluster'+ a.clusterId+'.png',
                            size: [150, 150],
                            offset: [-75, -75]
                        }]
                    });
                    Map.clusters['cluster'+a.clusterId]= cluster;
                }
            }
        }
    }

    var i = 0;
    for (var key in Map.points) {
        var a = Map.points[key];

        var p=Map.addPoint(a);

        if ( Map.withCluster && !Map.filter ) {
            var cluster = Map.clusters["cluster"+a.clusterId];
            cluster.add(p);
        }

        i++;
    }

    if ( Map.withCluster && !Map.filter ) {
        for (var key in Map.clusters) {
            var cluster = Map.clusters[key];
            Map.map.geoObjects.add(cluster);
        }
    }

    Map.addGlobalLayer();

    if (i > 1 && withFit){
        Map.fit();
    }
    else {
        Map.zoomToPoint(a.id, a.zoom, true);
    }
    Map.setPointsVisibilityByZoom();
}

Map.addGlobalLayer=function(){
    if (Map.withGlobalLayer) {

        Map.globalLayer = new ymaps.Layer(
            '/images/maps/global/%z/tile-%x-%y.png', {
                tileTransparent: true
            });
        Map.map.layers.add(Map.globalLayer);
    }
}

Map.fit = function (maxZoom) {
    if ( Map.withCluster && !Map.filter ) {
        var bounds=[];
        for (var key in Map.clusters) {
            var cluster = Map.clusters[key];
            var b=cluster.getBounds();

            if ( !bounds[0]) {
                bounds[0]=b[0];
                bounds[1]=b[1];
            }
            bounds[0]=[Math.min(bounds[0][0],b[0][0]), Math.min(bounds[0][1],b[0][1])];
            bounds[1]=[Math.max(bounds[1][0],b[1][0]), Math.max(bounds[1][1],b[1][1])];
        }
    }
    else {
        bounds = Map.map.geoObjects.getBounds();
    }
    Map.map.setBounds(bounds);
    var zoom = Map.map.getZoom();
    if(!maxZoom)maxZoom=17;
    if (zoom > maxZoom){
        zoom = maxZoom;
        Map.map.setZoom(zoom);
    }
}

Map.addPoint = function (a) {
    if (!a.noPoint){
        if (a.mapObject) {
            Map.map.geoObjects.remove(a.mapObject);
        }

        if(a.icon){
            var icon = a.icon;
            var iconSize=a.iconSize;
            var iconOffset=a.iconOffset;
        }
        else if(Map.filter && a.filter && $.inArray(Map.filter, a.filter) == -1) {
            if (a.pos) var icon = "/i/Map.pointGray" + a.pos + ".png";
            else var icon = "/i/Map.pointSmall.png";
            var iconSize=[15, 20];
            var iconOffset=[-7, -20];
        }
        else {
            if (a.pos) var icon = "/i/Map.point2_" + a.pos + ".png";
            else var icon = "/i/Map.point2.png";
            var iconSize=[30, 39];
            var iconOffset=[-15, -39];
        }

        var p = new ymaps.Placemark([a.lat, a.lng], {
            balloonContent: a.html,
            pointData: a,
            hintContent: a.htmlOver,
            clusterCaption: a.name

        }, {
            iconImageHref: icon,
            iconImageSize: iconSize,
            iconImageOffset: iconOffset,
            draggable: a.onDrag ? true : false
        });
        a.mapObject = p;

        if (a.onDrag) {
            p.events.add("dragend", function (e) {
                var p = e.get('target');
                var a = p.properties.get('pointData');
                a.onDrag(a, p, e);
            });
        }
        else {
            p.events.add('click', function (e) {
                Map.currentMapObject = e.get('target');

                var b = e.get('target');
                var a = b.properties.get('pointData');
                Map.zoomToPoint(a.id, a.zoom, false);
            });
            p.events
                .add('mouseenter', function (e) {
                    var b = e.get('target');
                })
                .add('mouseleave', function (e) {
                    e.get('target').options.unset('preset');
                });
            p.events.add('balloonopen', function (e) {
                var b = e.get('target');
                var p = Map.currentMapObject;
                var pointId = p.properties.get("pointId");
                var point = Map.points["point" + pointId];
            });
            p.events.add('balloonclose', function (e) {
                var b = e.get('target');
                var p = Map.currentMapObject;
                var pointId = p.properties.get("pointId");
                var point = Map.points["point" + pointId];
            });
        }

        if ( !Map.withCluster || Map.filter ) Map.map.geoObjects.add(p);
    }

    if (a.withLayer&&!Map.withGlobalLayer) {
        if (!a.mapLayer)a.mapLayer = new ymaps.Layer(
            '/images/maps/' + a.id + (Map.withStageId?"."+Map.withStageId:"")+ '/%z/tile-%x-%y.png', {
                tileTransparent: true
            });
        Map.map.layers.add(a.mapLayer);
    }
    return p;
}

Map.clear = function () {
    for (var key in Map.clusters) {
        var a = Map.clusters[key];
        Map.map.geoObjects.remove(a);
    }
    for (var key in Map.points) {
        var a = Map.points[key];
        if (a.mapObject)Map.map.geoObjects.remove(a.mapObject);
        if (a.mapLayer) {
            Map.map.layers.remove(a.mapLayer);
            a.mapLayer=null;
        }
    }
    if(Map.globalLayer) Map.map.layers.remove(Map.globalLayer);
    if(Map.globalLayer2) Map.map.layers.remove(Map.globalLayer2);
}

Map.resetFilter = function () {
    Map.filter=null;
    Map.clear();
    Map.addPoints();
}

Map.applyFilter = function (filter) {
    Map.filter=filter;
    Map.clear();
    Map.addPoints(true);
}

Map.zoomToPoint = function (id, zoom, noBaloon) {
    var a = Map.points["point" + id];
    if(!a)return;
    if (!zoom)zoom = a.zoom;
    Map.map.setCenter([a.lat, a.lng], zoom);
    Map.currentMapObject = a.mapObject;
    if (!noBaloon){
        setTimeout(function(){
            a.mapObject.balloon.open();
        },250);
    }
}

Map.firstPoint = function () {
    for (var key in Map.points) {
        return Map.points[key];
    }
}

Map.movePointToAddress = function (a, address) {
    var geocoder = ymaps.geocode(address, {results: 1});
    geocoder.then(function (res) {
        if (!res.geoObjects.getLength()) {
            alert("К сожалению введенный адрес не распознан:\n" + address + "\nПожалуйста, укажите позицию на карте вручную.");
            return;
        }

        var point = res.geoObjects.get(0);
        var coords = point.geometry.getCoordinates();

        a.lat = coords[0];
        a.lng = coords[1];
        Map.addPoint(a);
        Map.zoomToPoint(a.id, 14, true);
        if (a.onDrag)a.onDrag(a, a.mapObject);
    }, function (error) {
        alert("К сожалению введенный адрес не распознан:\n" + address + "\nПожалуйста, укажите позицию на карте вручную.");
    });
}

Map.startEditingRegions = function () {
    var div = $("#map");
    div.animate({
        "left": 0,
        "top": 0,
        "position": "absolute",
        "width": "100%",
        "height": "100%",
        "z-index": 10
    });
}

Map.fullscreenParent=null;
Map.fullscreen=function(){
    var c=$('#mapContainer');
    c.addClass('fullscreen');
    Map.fullscreenParent = c.parent();
    $("body").append(c);
    Map.map.container.fitToViewport();
}
Map.smallscreen=function(){
    var c=$('#mapContainer');
    c.removeClass('fullscreen');
    Map.fullscreenParent.prepend(c);

    Map.map.container.fitToViewport();
}