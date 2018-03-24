<!DOCTYPE html>
<html>
<head>
	<title>Place go</title>
</head>
<body>
<div id="demo"></div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
var x = document.getElementById("demo");
$(document).ready(function(){
	alert("DOM READY")
	getLocation();

	navigator.geolocation.getCurrentPosition(function(position){
		log(position)
	}, function(err){
		alert("error")
		console.log(err)
	})
})

function getLocation() {
	alert("get location called")
    if (navigator.geolocation) {
    	alert('supported')
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