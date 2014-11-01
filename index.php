<?php
    require_once("mysql.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
   		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Movie Club</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Oxygen:400,700' rel='stylesheet' type='text/css'>
		<!-- <link rel="stylesheet" href="css/font-awesome.min.css"> -->
		<link rel="icon" type="image/png" href="img/icon.jpg">

	</head>
	<body>

<!-- NAVBAR -->
	<div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav" id="main-menu">
            <li><a href="#page-welcome">Home</a></li>
            <li><a href="#page-map">Map</a></li>
            <li><a href="#page-movie">Movie</a></li>
            <li><a href="#page-about">About</a></li>
          </ul>
        </div>
      </div>
    </div>

<!-- TITLE -->
	<section id="page-welcome" class="page-welcome">
		<div>
		</div>
		<div class="container">
		    <div class="row">
		        <header class="centering">
		            <h1>Movie Night</h1>
		            <p>Your source for 看电影!</p>

		        </header>
		   </div>
		</div>
	</section>

<!-- MAP -->
	<section id="page-map" class"page-map"></section>
		<div cass="container"></div>
			<h1>Movie Night</h1>
            <p>Your source for 看电影!</p>
			<div id="map-canvas"></div>

<!-- Movie Data -->
	<section id="page-movie" class="page-movie darker">

    	<div class="movie-list" id="suggestions"></div>

    </section>

<!-- About -->
	<section id="page-about" class="page-about lighter">
		<div class="lighter margin"></div>
		</div>
		<div class="container">
			<header class="section-header">
	            <h2><span>About</span></h2>
	            <p>We made this</p>
	    	</header>
		    <div class="row">
	            <div class="col-md-9">
						<h2><strong>Who We Are</strong></h2>
						<p>Amherst College sophomores</p>
						<h2><strong>Why We Do Things</strong></h2>
						<p class="small-text">Why Not</p>
	            </div>
        	</div>
        </div>
  	</section>
    
    <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="js/jquery.ui.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuyBDatAQMaLRJ11BuSOc1OjFZHs6-U3U">
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

	<script>

	// maps.google.com
	  var map;
      var service;
      var infowindow;

      function initialize() {

        if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(success);
        } 
        else {
          error('Geo Location is not supported');
        }
      }

      function success(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
      
        var location = new google.maps.LatLng(lat,lng);

        map = new google.maps.Map(document.getElementById('map-canvas'), {
            center: location,
            zoom: 13
          });
        map.setOptions({'scrollwheel': false});
        var request = {
          location: location,
          radius: '500',
          query: 'movie theatre'
        };
        service = new google.maps.places.PlacesService(map);
        service.textSearch(request, callback);
      }

      function callback(results, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {
          for (var j=0; j<results.length; j++){
            createMarker(results[j]);
          }
        }
      }

      function createMarker(place){
        infowindow=new google.maps.InfoWindow({
          disableAutoPan: true,
          map: map,
          position: place.geometry.location,
        })
        var marker=new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });
          var request={placeId: place.place_id};
          service.getDetails(request, callback2);
          marker.setTitle(place.name);
          infowindow.close();
          google.maps.event.addListener(marker, 'click', function() {
            var printString="";
            infowindow.open(map, this);
            if (place.name!=null){
              printString=printString+place.name+"<br />";
            }
            if (place.formatted_address!=null){
              printString=printString+place.formatted_address+"<br />";
            }
            if (place.website!=null){
              printString=printString+place.website+"<br />";
            }
            if (place.rating!=null){
              printString=printString+place.rating+"<br />";
            }
            if (place.formatted_phone_number!=null){
              printString=printString+place.formatted_phone_number;
            }
            infowindow.setContent(printString);
          });
      }

      function callback2(place, status){
        if (status == google.maps.places.PlacesServiceStatus.OK){
          createMarker(place);
        }
      }
      //movie stuff

		var movieinit = function(){
	        <?php
				$host = 'localhost';
				$user = 'root';
			    $link = mysql_connect($host, $user, '');
				if (!$link) {
				    die('Could not connect: ' . mysql_error());
				}

				$db = mysql_select_db("test", $link);
				if (!$db) {
				    die('Could not connect to db: ' . mysql_error());
				}

				$sql = "SELECT `uid`, `title`, `year`, `image_url` FROM `movies`";
				$result = mysql_query($sql);

				if (mysql_num_rows($result) > 0) {
				    // output data of each row
				    while($row = mysql_fetch_assoc($result)) {
				        $uid = $row['uid'];
			            $title = $row['title'];
			            $year = $row['year'];
			            $image_url = $row['image_url'];
			            echo "generateMovieElement('".$uid."','".$title."','".$year."','".$image_url."');";
				    }
				} else {
				    echo "0 results";
				}

				// mysql_close($link);
			?>
	    };

	    var generateMovieElement = function(uid,title,year,image_url){
	    var wrapper;
	    // Create wrappers
	    wrapper = $("<div />", {
	        "class" : "movie-item",
	        "id" : "movie-" + uid,
	        "data" : uid
	    }).appendTo("#suggestions");

	    // Add movie title
	    $("<div />", {
	        "class" : "movie-title",
	        "text": title
	    }).appendTo(wrapper);

	    // Add movie year
	    $("<div />", {
	        "class" : "movie-year",
	        "text": year
	    }).appendTo(wrapper);

	    // Add movie picture
	    $('<div class="moviepic"><img src="' + image_url +'" width=100 height=100 />').load(function()
	    {}).appendTo(wrapper);
		};

		movieinit();
		generateMovieElement();
		google.maps.event.addDomListener(window, 'load', initialize);

	</script>

	<script type="text/javascript" src="js/jquery.scrollTo.js"></script>
	
	</body>
</html>