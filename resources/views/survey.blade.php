@extends('layouts.survey_main')

@section('extra-style')
    <style>
        #refreshButton{
            display: flex;
            align-items: center;
            position: absolute;
            top: 435px;
            right: 11px;
            width: 32px;
            height: 32px;
            background-color: white;
            border-radius: 3px;
            border-color: gray;
            border-style: solid;
            border-width: 1px 1px 1px 1px;
            opacity: 0.6;
            text-align: center;
            z-index: 500;
        }
        #refreshButton:hover{
            opacity: 0.8;
            cursor: pointer;
        }
    </style>
@endsection

@section('main')
    <section class="flex-column justify-content-center align-items-center">
        <div id="map">
            <button id="refreshButton" class="d-flex justify-content-center">
                <i class='fa fa-paper-plane'></i> 
            </button>
        </div>
    </section><!-- End Hero -->
@endsection

@section('extra-js')
    <script>
        $(document).ready(function(){

            L.DomEvent.on(document.getElementById('refreshButton'), 'click', function(){
                map.locate({setView: true, maxZoom: 18});
            })

            var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            });

            var googlestreet = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });

            var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });

            var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });

            var googleTerrain = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{
                maxZoom: 20,
                subdomains:['mt0','mt1','mt2','mt3']
            });

            var osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'});

            var map = L.map('map', {
                doubleClickZoom: false,
                layers: [googleSat]
            }).locate({setView: true, maxZoom: 18});

            var baseMaps = {
                "OpenStreetMap": osm,
                "OpenStreetMap.HOT": osmHOT,
                "Google Street": googlestreet,
                "Google Hybrud": googleHybrid,
                "Google Satelit": googleSat,
                "Google Terrain": googleTerrain
            };

            var layerControl = L.control.layers(baseMaps).addTo(map);

            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);
            var drawControl = new L.Control.Draw({
                position: 'bottomright'
            });
            map.addControl(drawControl);

            

            var myLayer = L.geoJSON().addTo(map);
            // myLayer.addData(geojsonFeature);

            map.on('draw:created', function (e) {
                // var type = e.layerType;
                var layer = e.layer;

                var shape = layer.toGeoJSON()
                var shape_for_db = JSON.stringify(shape);

                // console.log(shape_for_db); 

                var modal = document.getElementById("empModal");

                $.ajax({
                    url: "create.php",
                    type: "GET",
                    dataType: "html",
                    success: function(html) {
                        $("#modal-body").html(html);
                        $("#geojson").val(shape_for_db);
                        // document.getElementById('entity').value = shape_for_db;
                    }
                });

                // document.getElementById('modal-body').innerHTML = shape_for_db;

                $('#empModal').modal('show'); 
            });


            // var data = [
            //     <?php
            //         foreach($data as $item)
            //         {
            //             echo $item['geojson'];
            //             echo ",\n";
            //         }
            //     ?>
            // ];

            var myStyle = {
                "color": "#ff7800",
                "weight": 1,
                "opacity": 0.65
            };

            // L.geoJSON(data, {
            //     style: myStyle,
            //     onEachFeature: function(feature, layer){
            //         layer.on('click', function(e) {
            //             var featureId = feature.properties.id;
            //             //tampilkan data
            //             $.ajax({
            //                 url: "detail.php?id=" + featureId,
            //                 type: "GET",
            //                 dataType: "html",
            //                 success: function(html) {
            //                     $("#modal-body").html(html);
            //                     // $("#geojson").val(shape_for_db);
            //                     // document.getElementById('entity').value = shape_for_db;
            //                 }
            //             });
            //             $('#empModal').modal('show'); 
            //         });
            //     }
            // }).addTo(map);

            

            function whenClicked(e) {
                // e = event
                console.log(e);
                // You can make your ajax call declaration here
                //$.ajax(... 
            }

            function onEachFeature(feature, layer) {
                //bind click
                layer.on({
                    click: whenClicked
                });
            }
        });

        function edit(id) {
            $.ajax({
                url: "edit.php?id=" + id,
                type: "GET",
                dataType: "html",
                success: function(html) {
                    $("#modal-body").html(html);
                    // $("#geojson").val(shape_for_db);
                    // document.getElementById('entity').value = shape_for_db;
                }
            });
            $('#empModal').modal('show'); 
        }
    </script>
@endsection