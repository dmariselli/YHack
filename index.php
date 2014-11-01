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
            <li><a href="#page-about">About</a></li>
            <li><a href="#page-movie">Movie</a></li>
            <li><a href="#page-rating">Rating</a></li>
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

<!-- Movie Thing -->

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

<!-- Movie Data -->
	<section id="page-movie" class="page-movie darker">

    	<div class="movie-list" id="suggestions"></div>

    </section>

    
    <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="js/jquery.ui.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

	<script>

		var bookinit = function(){
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

		bookinit();
		generateMovieElement();

	</script>

	</body>
</html>