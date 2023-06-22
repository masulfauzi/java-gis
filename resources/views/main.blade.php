<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Lumia Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Lumia
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/lumia-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <h1><a href="index.html">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/06/Logo_of_the_Ministry_of_Environmental_Affairs_and_Forestry_of_the_Republic_of_Indonesia.svg" alt="">    
        </a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="" class="d-flex flex-column justify-content-center align-items-center">
    <div id="map">
    </div>
  </section><!-- End Hero -->

  <main id="main">

   

  </main><!-- End #main -->

 

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    $(document).ready(function(){

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


        var data = [
            <?php
                foreach($data as $item)
                {
                    echo $item['geojson'];
                    echo ",\n";
                }
            ?>
        ];

        var myStyle = {
            "color": "#ff7800",
            "weight": 1,
            "opacity": 0.65
        };

        L.geoJSON(data, {
            style: myStyle,
            onEachFeature: function(feature, layer){
                layer.on('click', function(e) {
                    var featureId = feature.properties.id;
                    //tampilkan data
                    $.ajax({
                        url: "detail.php?id=" + featureId,
                        type: "GET",
                        dataType: "html",
                        success: function(html) {
                            $("#modal-body").html(html);
                            // $("#geojson").val(shape_for_db);
                            // document.getElementById('entity').value = shape_for_db;
                        }
                    });
                    $('#empModal').modal('show'); 
                });
            }
        }).addTo(map);

        

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

</body>

</html>