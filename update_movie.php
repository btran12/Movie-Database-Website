<?php
session_start();
if ($_SESSION['valid'] && ($_SESSION['username'] == 'btran')){
	if (empty($_POST)){
		$id = 		$_GET['id'];
		$title = 	$_GET['title'];
		$plot= 		$_GET['plot'];
		$director= 	$_GET['director'];
		$rating = 	$_GET['rating'];
		$duration = $_GET['duration'];
		$link = 	$_GET['link'];
		$date = 	$_GET['date'];
		echo "<html>

			<head>
			<title>Update Movie</title>
			<link href='https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz|Ubuntu+Condensed|Fjalla+One' rel='stylesheet' type='text/css'>
			<link rel='stylesheet' type='text/css' href='styles.css'>
			</head>
			<body>";
			
		include 'nav-bar.php';	

		echo "<div class='document'>";
		echo "<br><center><h1>Update Movie</h1></center><hr>";
		echo "<form action='update_movie.php' method='POST'>
			<table width='100%'>
				<tr>
					<input type='hidden' name='id' value='".$id."'>
					<td style='width:450px'><p>Title</p><input type='text' name='title' value='". $title ."' style='width: 400px' required></td>
					<td style='width:200px'><p>Director</p><input type='text' name='director' value='". $director . "' style='width: 150px' ></td>
					<td><p>Date Released in USA</p><input type='text' name='date' value='". $date . "' style='width: 150px'></td>
				</tr>
				<tr>
					<td><p>IMDB Rating</p><input type='text' name='rating' value='". $rating ."' style='width: 50px'> <p style='display:inline'>/10</p></td>
					<td><p>Duration</p><input type='text' name='duration' value='". $duration ."' style='width: 50px'> <p style='display:inline'>min</p></td>
				</tr>
				<tr>
					<td><p>Plot</p><textarea name='plot' rows='8' cols='55'>". $plot ."</textarea></td>
				</tr>
				<tr>
					<td><p>Poster URL</p><input type='text' name='poster_link' value='". $link ."' style='width: 400px'></td>
				</tr>
				<tr>
					<td><input type='submit' value='O'></td>
					<td><a href='view_movies.php'>View All Movies</a></td>
				</tr>
			</table>
		</form>
		</div>
		</body>
		</html>";
	}else{

		include 'connect_server.php';
		//TODO ADD RATING
		$QUERY = "UPDATE btran6291_MOVIE set movie_title=?,movie_plot=?,movie_director=?,movie_duration=?,poster_url=?,movie_released_date=?, movie_rating=? where ID=?";

		$q = $conn->prepare($QUERY);
		
		//Form post
		if ($q->execute(array($_POST['title'],$_POST['plot'],$_POST['director'],$_POST['duration'],$_POST['poster_link'],$_POST['date'],$_POST['rating'], $_POST['id']))){
			//Redirect
			echo '<script>document.location = "view_movies.php";</script>';
		}else{
			echo "Unable to update movie";
			echo $q->errorCode();
		}
		$conn=null;
	}
}else{
	echo "<title>Error 401. Unauthorized</title>";
	echo "<h1>Error 401. Unauthorized</h1>";
	header('Refresh: 3; URL = index.php');
}
?>