<?php
session_start();

//Any user with a valid session can view all the available reviews, but cannot make any changes.
if ($_SESSION['valid']){

	include 'connect_server.php';
	
	//The default value to sort the reviews by
	$order_by = "ID"; 
	
	if (isset($_GET['order'])){
		$order_by = $_GET['order'];
	}
	// Return an extra column the movie title 
	// from the MOVIE table to be printed out with the reviews
	$QUERY = "SELECT btran6291_REVIEW.*, btran6291_MOVIE.movie_title 
				FROM btran6291_REVIEW,btran6291_MOVIE 
				WHERE btran6291_REVIEW.movie_id=btran6291_MOVIE.ID 
				ORDER BY ". $order_by;
	
	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
?>

<html>
	<head>
		<title>Reviews Database</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>
	<body>
		<h1>Reviews Database</h1>
		<p><a href='index.php'>Home</a></p>
		<table width="100%" border="1">
			<th><a href="view_reviews.php?order=ID">ID</a></th>
			<th>User Name</th>
			<th>Review</th>
			<th><a href="view_reviews.php?order=Review_date">Date</a></th>
			<th>Rating</th>
			<th><a href="view_reviews.php?order=movie_id">Movie ID</a></th>
			<th><a href="view_reviews.php?order=movie_title">Movie</a></th>
			<th></th>
			<th></th>

			<?php
				while($r=$q->fetch()){
					echo "
					<tr>
						<td>
							". $r["ID"] ."
						</td>
						<td>
							". $r["reviewer_name"] ."
						</td>
						<td>
							". $r["Reviewer_review"] ."
						</td>
						<td>	
							". $r["Review_date"] ."
						</td>
						<td>
							". $r["Review_rating"] ."
						</td>
						<td>
							". $r["movie_id"] ."
						</td>
						<td>
							". $r["movie_title"] ."
						</td>
						<td>
							<a href='update_review.php?id=".$r["ID"]."'>Update</a>
						</td>
						<td>
							<a href='delete_review.php?id=".$r["ID"]."&movieid=".$r["movie_id"]."'>Delete</a>
						</td>

					</tr>";
				}
			?>
		</table>
	</body>
</html>

<?php
}else{
	echo "<h2>Access Unauthorized</h2>";
	header('Refresh: 3; URL = index.php');
	die();
}

?>