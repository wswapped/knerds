<!DOCTYPE html>
<html>
	<title>Place go</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <head>
  </head>
  <body>
  	<div class="container">
  		<div class="row">
			<div class="col-md-8">
				<div class="mapContainer">
					<h1>Map</h1>
					<div id="map"></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="sidebarContainer">
					<div id="content">
						<div class="row">
							<div class="col-xs-2">
								<img src="img/spinner.gif" class="waitLoad">
							</div>
							<div class="col-xs-10">
								<p class="display-4 loader-text">Getting location</p>
							</div>
						</div>
					</div>
				</div>
				<div id="demo"></div>
			</div>
		</div>
  	</div>
    
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script>
      function initMap() {
        var kigali = {lat: -1.9706, lng: 30.1044};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: kigali
        });
        var marker = new google.maps.Marker({
          position: kigali,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAa1K0Q8xIXswQC7uCMrbvwYi2CcSTTiU=&callback=initMap">
    </script>
    <script type="text/javascript">
    	var x = document.getElementById("demo");
		$(document).ready(function(){
			getLocation();

			navigator.geolocation.getCurrentPosition(function(position){
				log(position)
			}, function(err){
				alert("error")
				console.log(err)
			})
		})

		function getLocation() {
		    if (navigator.geolocation) {
		        navigator.geolocation.getCurrentPosition(showPosition);
		    } else {
		        x.innerHTML = "Geolocation is not supported by this browser.";
		    }
		}
		function showPosition(position) {
			alert("Show position")
		    x.innerHTML = "Latitude: " + position.coords.latitude + 
		    "<br>Longitude: " + position.coords.longitude; 
		}
</script>
  </body>
</html>
<?php die(); ?>