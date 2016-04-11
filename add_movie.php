
<?php
session_start();
if ($_SESSION['valid']){
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

<div class="document">
	<br><h1><center>Add Movie</center></h1>
	<hr>
	<form method="POST" action="add_movie.php">
		<table width="100%" style="table-layout:fixed">
			<tr>
				<td width="60%">
					<table style="table-layout:fixed">
						<tr>
							<td style="width:450px"><p>Title</p><input type="text" name="title" placeholder="Title" style="width: 400px" required></td>
							<td style="width:200px"><p>Director</p><input type="text" name="director" placeholder="Director" style="width: 150px" ></td>
							<td><p>Date Released in USA</p><input type="text" name="date" placeholder="Released date" style="width: 150px"></td>
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
</body>

<?php
}else{

	include 'connect_server.php';
	//TODO add rating back; include another ? : make sure is in correct order.
	$QUERY = "INSERT into btran6291_MOVIE(movie_title,movie_plot,movie_director,movie_duration,poster_url,movie_released_date) values (?,?,?,?,?,?)";

	$q = $conn->prepare($QUERY);

	$title=$_POST['title'];
	$plot=$_POST['plot'];
	$director=$_POST['director'];
	$rating=$_POST['rating'];
	$duration=$_POST['duration'];
	$link=$_POST['poster_link'];
	$date=$_POST['date'];

	if($q->execute(array($title,$plot,$director,$duration,$link,$date))){
		echo '<script>document.location = "add_movie.php";</script>'; 
	}else{
		echo $q->errorCode();
	}

	//Close connection
	$conn=null;
}
}else{
	echo "<h2>This Page is Restricted to the Admins only.</h2>";
	header('Refresh: 3; URL = index.php');
}
?>
