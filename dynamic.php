<?php
	include 'connect_server.php';

	$releaseYear = "SUBSTRING(movie_released_date,1, 4)";
	$releaseMonth = "SUBSTRING(movie_released_date,6, 2)";
	$releaseDay = "SUBSTRING(movie_released_date,9, 2)";

	$headers = array("Upcoming Releases", "Currently Showing", "The Best Movies of All Times", "Movies of 2015", "Movies of 2014", "Movies of 2013", "Movies of 2012", "Movies of 2011", "Movies of 2010", "All Movies");

	$queries = array("SELECT * 
						FROM btran6291_MOVIE 
						WHERE (($releaseYear > YEAR(CURDATE())) OR 
							($releaseYear = YEAR(CURDATE()) AND $releaseMonth > MONTH(CURDATE())) OR 
							($releaseYear = YEAR(CURDATE()) AND $releaseMonth = MONTH(CURDATE()) AND $releaseDay >= DAY(CURDATE()))) 
						ORDER BY movie_released_date asc",
					"SELECT * 
						FROM btran6291_MOVIE 
						WHERE ($releaseYear = YEAR(CURDATE()) AND $releaseMonth < MONTH(CURDATE())) OR
							($releaseYear = YEAR(CURDATE()) AND $releaseMonth = MONTH(CURDATE()) AND $releaseDay <= DAY(CURDATE())) 
						ORDER BY movie_released_date desc",
					"SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 8.5 
						ORDER BY movie_rating desc",
					"SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7 && $releaseYear = 2015 
						ORDER BY movie_rating desc",
					"SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7 && $releaseYear = 2014 
						ORDER BY movie_rating desc",
					"SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7 && $releaseYear = 2013 
						ORDER BY movie_rating desc",
					"SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7 && $releaseYear = 2012 
						ORDER BY movie_rating desc",
					"SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7 && $releaseYear = 2011 
						ORDER BY movie_rating desc",
					"SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7 && $releaseYear = 2010 
						ORDER BY movie_rating desc",
					"SELECT * 
						FROM btran6291_MOVIE 
						ORDER BY movie_title");
?>

<!doctype html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="assets/docs.theme.min.css">

		<link rel="stylesheet" href="assets/owl.carousel.css">
		<link rel="stylesheet" href="assets/owl.theme.default.min.css">
	</head>
	<style>
		.featurette-container{
			width:100%;
			height:600px;
			margin: auto;
		}
		.featurette-container .featurette-carousel .item img{
			height: 600px;
			width: 100%;
		}
		.carousel-container {
			width:90%;
			margin: auto;
		}
		.carousel-container .owl-carousel .item img{
			width:200px;
			height:285px;
			position: relative;
		}	
		.carousel-container .owl-carousel .item:hover span{
			top: 20%;
			opacity: .9;
		}
		.carousel-container .owl-carousel .item span{
			position: absolute;
			top: 100%;
			left: 0px;
			width: 100%;
			height: 100%;
			background-color: white;
			opacity: .5;
			transition: all .5s;
		}
		.carousel-container .owl-carousel .item span h4{
			text-align: center;
			margin-top: 15px;
			margin-bottom: 0px;
			padding-left: 3px;
			padding-right: 3px;
			font-size: 20px;
		}
		.carousel-container .owl-carousel .item span h5{
			font-size: 14px;
			margin-top: 5px;
			padding-left: 10px;
			padding-right: 10px;
		}
	</style>
	<body>
		<!-- Populate the featurette carousel with images from the images folder -->
		<div class="featurette-container">
			<div class="featurette-carousel">
				<?php
					//Get all the files names in the images/ directory
					$images_directory = new DirectoryIterator("images/");
					foreach ($images_directory as $fileinfo){
						if (!$fileinfo->isDot()){
							echo "<div class='item'>
									<img src='images/".$fileinfo->getFilename()."'>
								</div>";
						}
					}
				?>
			</div>
		</div>
		<div class="carousel-container">
			<?php
				for ($x=0; $x < count($headers); $x++){
					echo "<h3>".$headers[$x]."</h3>
					<div class='owl-carousel'>";
						$q = $conn->prepare($queries[$x]);
						$q->execute();
						$q->setFetchMode(PDO::FETCH_BOTH);
						while($r=$q->fetch()){
							echo "<div class='item'>
									<a href='movie_page.php?id=".$r["ID"]."'>
										<img src='".$r["poster_url"]."'>
										<span>
											<h4>".$r["movie_title"]."</h4>
											<h5>".$r["movie_plot"]."</h5>
										</span>
									</a>
								</div>";
						}
					echo "</div>";	
				}
			?>
		</div>
		
		<!-- JQuery Framework -->
		<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
		<!-- Owl Carousel Plugin -->
		<script src="js/owl.carousel.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script>
			$(document).ready(function(){
				$('.featurette-carousel').owlCarousel({
					loop:true,
					items: 1,
					dots: false,
					autoplay: true,
					autoplayHoverPause: true
				});
				$('.owl-carousel').owlCarousel({
				    loop:true,
				    margin:10,
				    nav:true,
				    dots:false,
				    responsive:{	//The number of items based on screen size
				        0:{
				            items:1
				        },
				        600:{
				            items:3
				        },
				        1000:{
				            items:5
				        },
				        1200:{
				        	items:6
				        },
				        1400:{
				        	items:7
				        },
				        1500:{
				        	items:8
				        }
				    }
				});
			});
		</script>
	</body>
	
</html>