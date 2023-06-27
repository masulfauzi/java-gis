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

      <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function(){

            L.CursorHandler = L.Handler.extend({

                addHooks: function () {
                    this._popup = new L.Popup();
                    this._map.on('mouseover', this._open, this);
                    this._map.on('mousemove', this._update, this);
                    this._map.on('mouseout', this._close, this);
                },

                removeHooks: function () {
                    this._map.off('mouseover', this._open, this);
                    this._map.off('mousemove', this._update, this);
                    this._map.off('mouseout', this._close, this);
                },

                _open: function (e) {
                    this._update(e);
                    this._popup.openOn(this._map);
                },

                _close: function () {
                    this._map.closePopup(this._popup);
                },

                _update: function (e) {
                    this._popup.setLatLng(e.latlng)
                        .setContent(e.latlng.toString());
                }


            });

            L.Map.addInitHook('addHandler', 'cursor', L.CursorHandler);

            L.DomEvent.on(document.getElementById('refreshButton'), 'click', function(){
                // map.locate({setView: true, maxZoom: 18});

                navigator.geolocation.getCurrentPosition(position => {
                        console.log(position);
                    const { coords: { latitude, longitude }} = position;
                    var marker = new L.marker([latitude, longitude], {
                        draggable: true,
                        autoPan: true
                    }).addTo(map);
                    marker.bounce();

                    map.setView([latitude, longitude], 13)

                    console.log(marker);
                    })
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
                layers: [googleSat],
                cursor: true
            }).locate({setView: true, maxZoom: 18});

            var baseMaps = {
                "OpenStreetMap": osm,
                "OpenStreetMap.HOT": osmHOT,
                "Google Street": googlestreet,
                "Google Hybrud": googleHybrid,
                "Google Satelit": googleSat,
                "Google Terrain": googleTerrain
            };

            <?php $no = 1; ?>
            @foreach($batas_adm as $item_batas_adm)

                var batas_adm_{{ $no }} = {!! $item_batas_adm->geojson !!}
                var layer_adm_{{ $no }} = L.geoJSON(batas_adm_{{ $no }}).addTo(map);

            @endforeach

            var batas_administrasi = {
                <?php $no = 1; ?>
                @foreach($batas_adm as $item_batas_adm)

                    "{{ $item_batas_adm->nama }}" : layer_adm_{{ $no }},
                    
                @endforeach
            }

            var layerControl = L.control.layers(baseMaps, batas_administrasi).addTo(map);

            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);
            var drawControl = new L.Control.Draw({
                position: 'bottomright'
            });
            map.addControl(drawControl);

            


            

            // var myLayer = L.geoJSON().addTo(map);
            // myLayer.addData(geojsonFeature);

            map.on('draw:created', function (e) {
                // var type = e.layerType;
                var layer = e.layer;

                var shape = layer.toGeoJSON()
                var shape_for_db = JSON.stringify(shape);

                // console.log(shape_for_db); 

                var modal = document.getElementById("exampleModal");

                $.ajax({
                    url: "{{ route('survey.surveyor.create') }}",
                    type: "GET",
                    dataType: "html",
                    success: function(html) {
                        $("#modal-body").html(html);
                        // $("#geojson").val(shape_for_db);
                        document.getElementById('koordinat').value = shape_for_db;
                        $('#exampleModal').modal('show'); 
                    }
                });
                // document.getElementById('koordinat').value = shape_for_db;
                // document.getElementById('modal-body').innerHTML = shape_for_db;

                
            });

            @foreach($jenis_lahan as $item)
                <?php
                $no = 1;
                    $data = $survey->where('id_jenis_lahan', $item->id);
                ?>
                var data{{ $no }} = [
                    <?php
                        foreach($data as $item_survey)
                        {
                            echo $item_survey['koordinat'];
                            echo ",\n";
                        }
                    ?>
                ];

                var myStyle{{ $no }} = {
                    "color": "{{ $item->warna }}",
                    "weight": 1,
                    "fillOpacity": {{ $item->opacity }}
                };

                L.geoJSON(data{{ $no }}, {
                    style: myStyle{{ $no }},
                    onEachFeature: function(feature, layer){
                        layer.on('click', function(e) {
                            var featureId = feature.properties.id;
                            //tampilkan data
                            $.ajax({
                                url: "{{ url('/surveyor') }}/" + featureId,
                                type: "GET",
                                dataType: "html",
                                success: function(html) {
                                    $("#modal-body").html(html);
                                    // $("#geojson").val(shape_for_db);
                                    // document.getElementById('entity').value = shape_for_db;
                                }
                            });
                            $('#exampleModal').modal('show'); 
                        });
                    }
                }).addTo(map);

            @endforeach


        

            

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