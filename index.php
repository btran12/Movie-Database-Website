<!doctype html>
<?php
	$page = $_GET["page"];
	$page_title = "";
	$releaseYear = "SUBSTRING(movie_released_date,1, 4)";
	$releaseMonth = "SUBSTRING(movie_released_date,6, 2)";
	$releaseDay = "SUBSTRING(movie_released_date,9, 2)";

	//Values to set link on navigation bar as active
	$one = $two = $three = $four = $five = $six = $seven = $eight = $nine = "";

	switch($page){ //Popluate different pages with different information
		
		case "main":
			$page_title = "Soon to be Released";
			$one = "active";
			//Newest movies to be released
			//(year > cYear) || (year = cYear && month > cMonth) || (year = cYear && month = cMonth && day >= cDay) 
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE ((".$releaseYear." > YEAR(CURDATE())) OR 
							(".$releaseYear." = YEAR(CURDATE()) AND ".$releaseMonth." > MONTH(CURDATE())) OR 
							(".$releaseYear." = YEAR(CURDATE()) AND ".$releaseMonth." = MONTH(CURDATE()) AND ".$releaseDay." >= DAY(CURDATE()))) 
						ORDER BY movie_released_date asc";
			break;
		case "current":
			$page_title = "Now Showing";
			$two = "active";
			//Newest movies released in 2016 only
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE (".$releaseYear." = YEAR(CURDATE()) AND ".$releaseMonth." <= MONTH(CURDATE()) AND ".$releaseDay." <= DAY(CURDATE())) 
						ORDER BY movie_released_date desc";
			break;
		case "topall":
			$page_title = "Best Movies of All Times";
			$three = "active";
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 8.5 
						ORDER BY movie_rating desc";
			break;
		case "top15":
			$page_title = "The Best Movies of 2015";
			$four = "active";
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7.5 && ".$releaseYear." = 2015 
						ORDER BY movie_rating desc";
			break;
		case "top14":
			$page_title = "The Best Movies of 2014";
			$five = "active";
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7.5 && ".$releaseYear." = 2014 
						ORDER BY movie_rating desc";
			break;
		case "top13":
			$page_title = "The Best Movies of 2013";
			$six = "active";
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7.5 && ".$releaseYear." = 2013 
						ORDER BY movie_rating desc";
			break;
		case "top12":
			$page_title = "The Best Movies of 2012";
			$seven = "active";
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7.5 && ".$releaseYear." = 2012 
						ORDER BY movie_rating desc";
			break;
		case "top11":
			$page_title = "The Best Movies of 2011";
			$eight = "active";
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7.5 && ".$releaseYear." = 2011 
						ORDER BY movie_rating desc";
			break;
		case "top10":
			$page_title = "The Best Movies of 2010";
			$nine = "active";
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE movie_rating > 7.5 && ".$releaseYear." = 2010 
						ORDER BY movie_rating desc";
			break;
		default: //Same as main
			$page_title = "New and Currently Showing Movies";
			$QUERY = "SELECT * 
						FROM btran6291_MOVIE 
						WHERE ".$releaseYear." = 2016 
						ORDER BY movie_released_date desc";
	}//end switch 

	include 'connect_server.php';

	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
?>
<html>

<head>
<title><?php echo $page_title . " - Bao Tran MovieDB"; ?></title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
<?php
	include "nav-bar.php";
?>

<div class="document">
	<br><h1><center><?php echo $page_title; ?></center></h1>
	<hr>
	<table width="100%">
		<?php
			
			while($r=$q->fetch()){
				//Generate Rows of Movies
				$movie_id= $r["ID"];
				$poster_url = $r["poster_url"];
				$movie_released_date= $r["movie_released_date"];
				$movie_title= $r["movie_title"];
				$movie_plot = $r["movie_plot"];
				$movie_rating= $r["movie_rating"];
				
				echo "
				<tr>
					<td width='20%'>
						<a href='movie_page.php?id=".$movie_id."'>
						<img src='". $poster_url ."' style='width:250px;height:350px;' class='imgBox'>
						</a>
					</td>
					<td width='65%' style='vertical-align:bottom;'>
						<div class='movie_title' style='display:inline'>
							". $movie_title ."
						</div>
						<p style='display:inline;margin-left:15px'>
							". formatDate($movie_released_date) ."
						</p>
						<p>
						". $movie_plot. "
						</p>
					</td>
					<td width='15%' align='center'>
						<div class='movie_rating'>
							". $movie_rating . "/10
						</div>
					</td>
				</tr>";
			}
			
			//Close connection
			$conn=null; 
			
		?>
		<?php
			function formatDate($date){
				$dateObject = date_create($date);
				return date_format($dateObject, "j F Y");
			}
		?>

	<table>
</div>

</body>

<footer>
	<p align="right">Sample Movies Data Obtained from IMDB</p>
</footer>
<div class="contact-button">
	<a href="http://baotran.xyz">Bao Tran</a>
</div>
</html>