
<?php
session_start();
if ($_SESSION['valid'] && ($_SESSION['username'] == 'btran')){
if (empty($_POST)){
?>
<html>

<head>
<title>Add Movie</title>
<link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<?php
	include "nav-bar.php";
?>
<?php 
	include 'connect_server.php';

	$QUERY = "SELECT movie_title FROM btran6291_MOVIE";
	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
	$titles = array();

	while($r=$q->fetch()){
		array_push($titles,$r["movie_title"]);
	}

?>
<div class="document">
	<h1><center>Add Movie</center></h1>
	<hr>
	<form name="movieForm" action="add_movie.php" method="POST">
		<table width="100%" style="table-layout:fixed">
			<tr>
				<td width="60%">
					<table style="table-layout:fixed">
						<tr>
							<td style="width:450px"><p>Title</p><input type="text" name="title" placeholder="Title" style="width: 400px" onkeyup="showSuggestion(this.value)" required></td>
							<td style="width:200px"><p>Director</p><input type="text" name="director" placeholder="Director" style="width: 150px" ></td>
							<td><p>Date Released in USA</p><input type="text" name="date" placeholder="YYYY/MM/DD" pattern="^\d{4}\/(0?[1-9]|1[012])\/(0?[1-9]|[12][0-9]|3[01])$" title="Format: 20YY/MM/DD" style="width: 150px"></td>
						</tr>
						<tr>
							<td><p>IMDB Rating</p><input type="number" name="rating" min="0" max="10" step="0.1" value="0" style="width: 50px"> <p style="display:inline">/10</p></td>
							<td><p>Duration</p><input type="number" name="duration" min="0" step="1" value="15" placeholder="Duration in minutes" style="width: 50px"> <p style="display:inline">min</p></td>
						</tr>
						<tr>
							<td><p>Plot</p><textarea name="plot" rows="10" cols="50"></textarea></td>
						</tr>
						<tr>
							<td><p>Poster URL</p><input type="text" name="poster_link" placeholder="Poster url" style="width: 400px"></td>
						</tr>
						<tr>
							<td><input type="submit" value="Add"></td>
						</tr>
					</table>
				</td>
				<td>
					<p><a href="view_movies.php">View Movies</a></p>
					<p><a href="view_reviews.php">View Reviews</a></p>
				</td>
			</tr>
		</table>

	</form>

</div>

<script>

	function showSuggestion(str){
		var matchedTitles = [];
		var title;
		for (title in titles){
			if (str == title){
				matchedTitles.push(title);
			}
		}

	}
</script>
</body>

<?php
}else{

	include 'connect_server.php';
	
	$QUERY = "INSERT into btran6291_MOVIE(movie_title,movie_plot,movie_director,movie_duration,poster_url,movie_released_date,movie_rating) values (?,?,?,?,?,?,?)";

	$q = $conn->prepare($QUERY);

	$title=$_POST['title'];
	$plot=$_POST['plot'];
	$director=$_POST['director'];
	$rating=$_POST['rating'];
	$duration=$_POST['duration'];
	$link=$_POST['poster_link'];
	$date=$_POST['date'];

	if($q->execute(array($title,$plot,$director,$duration,$link,$date,$rating))){
		echo '<script>document.location = "add_movie.php";</script>'; 
	}else{
		echo $q->errorCode();
	}

	//Close connection
	$conn=null;
}
}else{
	echo "<title>Error 401 Unauthorized</title>";
	echo "<h1>Error 401 Unauthorized</h1>";
	header('Refresh: 3; URL = index.php');
}
?>
