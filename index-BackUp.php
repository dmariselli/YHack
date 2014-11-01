<?php
    require_once("php/mysql.php");
    require_once("php/movies.php");
    require_once("php/comments.php");
    require_once("php/commentsandmovies.php");
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
		<link rel="stylesheet" type="text/css" href="css/form.css">
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
		<div class="lonebutton" id="clear">
            <input type="button" class="btn btn-info" value="Delete All Movies" />
        </div>

        <div class="lonebutton" id="addnew">
            <input type="button" class="btn btn-info" value="Add New Movie" />
        </div>

        <div class="lonebutton" id="refresh">
            <input type="button" class="btn btn-info" value="Show All Movies" />
        </div>

        <div class="movie-list" id="suggestions"></div>

		<div class="movie-list">
            <form id="movie-form" method="POST">
                <input type="text" name="title" id="title" placeholder="Film Title" value="" />
                <input type="text" name="year" id="year" placeholder="Year" value="" />
                <input type="text" name="image_url" id="image_url" placeholder="Image URL" value="" />
                <input type="button" class="btn btn-default" id="add" value="Add Film" />
            </form>
        </div>

        <div class="comment-list" id="commentspace"></div>

    </section>

	<script>
	var data = JSON.parse(localStorage.getItem("movieData"));
	data = data || {};

	var movieinit = function(){
	    <?php
	        while($row = mysql_fetch_array($result)){
	            $uid = $row['uid'];
	            $title = $row['title'];
	            $year = $row['year'];
	            $image_url = $row['image_url'];
	            echo "generatemovieElement('".$uid."','".$title."','".$year."','".$image_url."');";
	        }
	    ?>
	};

	var generatemovieElement = function(uid,title,year,image_url,comments){
	    var data = JSON.parse(localStorage.getItem("movieData"));
	    var wrapper;
	    var wrappercomments;

	    // Create wrappers
	    wrapper = $("<div />", {
	        "class" : "movie-item",
	        "id" : "movie-" + uid,
	        "data" : uid
	    }).appendTo("#suggestions");

	    wrappercomments = $("<div />", {
	        "class" : "comment-item",
	        "id" : "comment-" + uid
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

	    // Add delete movie button
	    $("<button />", {
	        "type": "button",
	        "id": "deletebtn",
	        "class" : "btn btn-danger",
	        "text": "x",
	        "onclick" : "removemovie(" + uid + ");"
	    }).appendTo(wrapper); 

	    // Add comment functionality
	    $("<button />", {
	        "text" : "Add a Comment",
	        "id" : "comment-" + uid,
	        "class" : "btn btn-default addcommentbutton",
	        "onclick": "commentsToggle(" + uid + ")"
	    }).appendTo(wrappercomments);

	    $("<div />", {
	        "id" : "comment-list-" + uid
	    }).appendTo(wrappercomments);
	    
	    for (var x in comments){
	        $("<p />", {
	            "text" : "\"" + comments[x] + "\"",
	            "class" : uid
	        }).appendTo("#comment-list-" + uid);    
	    }

	    $("<form id=\"comment-form-" + uid + "\" class=\"" + uid + "\"  > \
	        <input type=\"text\"/> \
	        <input class=\"" + uid + "\" type=\"button\" id=\"add_comment-" + uid + "\" value=\"Submit\" onClick=\"add_comments(" + uid + ")\"/> \
	        </form>"
	    ).appendTo(wrappercomments);

	    // Hide comment related items
	    $("p").hide();
	    $("form[id^='comment-form']").hide();
	    $("input[id^='add_comment']").hide();

	    // Trying to add comments after refreshing
	    //addingcomments(uid);
	};

	var movieadd = function(uid) {
	    var inputs = $("#movie-form :input"), uid, title, year, image_url;

	    uid = uid;
	    title = inputs[0].value;
	    year = inputs[1].value;
	    image_url = inputs[2].value;

	    // Check if the user input a title
	    if (!title) {
	        return;
	    }

	    // Store new movie into data variable
	    data[uid] = {
	        uid : uid,
	        title : title,
	        year : year,
	        image_url : image_url,
	    }

	    // Initialize comments array
	    var comments = new Array();

	    // Save movie to local storage
	    localStorage.setItem("movieData", JSON.stringify(data));

	    // Display on screen
	    generatemovieElement(uid,title,year,image_url,comments);

	    // Reset form
	    inputs[0].value = "";
	    inputs[1].value = "";
	    inputs[2].value = "";
	};

	// Delete all movies from local storage
	var movieclear = function() {
	    data = {};
	    localStorage.setItem("movieData", JSON.stringify(data));
	    $(".movie-item").remove();
	    $(".comment-item").remove();
	};

	// Delete one movie
	var removemovie = function(uid) {
	    $("#movie-" + uid).remove();
	    $("#comment-" + uid).remove();

	    $.ajax({
	        type: "POST",
	        url: "php/deletemovie.php",
	        data: { uid: uid }
	    })
	};

	// Hide or show comment items
	var commentsToggle = function(uid){
	    $("p[class^='" + uid + "']").toggle();
	    $("form[class^='" + uid + "']").toggle();
	    $("input[class^='" + uid + "']").toggle();
	};

	// Add comment per movie
	var add_comments = function(uid){
	    var inputs = $("#comment-form-" + uid + " :input"), appendedComment, comment;
	    
	    appendedComment = inputs[0].value;
	    comment = appendedComment.replace("'", "\'");
	    var movie_uid = uid;
	    
	    if (!comment){
	        return;
	    }

	    var number = 1 + Math.floor(Math.random() * 2000)
	    uid = number;
	    
	    $.ajax({
	            type: "POST",
	            url: "php/addcomments.php",
	            data: { uid: uid, movie_uid: movie_uid, comment: comment}
	    })
	    
	    $("#comment-list-" + movie_uid).append("<p class=\"" + movie_uid + "\">\"" + appendedComment + "\"</p>");
	    $("#comment-form-" + movie_uid)[0].reset();
	}

	movieinit();

	$("#movie-form").hide();

	// Delete all movies from database
	$(document).ready(function(){
	    $("#clear").on("click", function(){
	        $.ajax({
	            url: "php/delete.php",
	        })
	        .done(function(){
	            movieclear();
	        });
	    });
	});

	// Toggle visibility of movie form when pressing add new button
	$(document).ready(function(){
	   $("#addnew").on("click", function(){
	        $("#movie-form").toggle();
	    });
	});

	// Add new movie item user input to database
	$(document).ready(function(){
	    // When user clicks on save button
	    $("#add").on("click", function(){
	        var inputs = $("#movie-form :input"),
	        uid, title, year, image_url;

	        var number = 1 + Math.floor(Math.random() * 1000)
	        uid = number;
	        title = inputs[0].value;
	        year = inputs[1].value;
	        image_url = inputs[2].value;

	        $.ajax({
	            type: "POST",
	            url: "php/add.php",
	            data: { uid: uid, title: title, year: year, image_url: image_url }
	        })
	        
	        // Add new movie to local storage - subsequently to display
	        .done(function(){
	            movieadd(uid);
	        });

	        // Hide movie form after user inputs have been added and recorded
	        $("#movie-form").hide();
	    });
	});

	</script>

		<script src="js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</body>
</html>