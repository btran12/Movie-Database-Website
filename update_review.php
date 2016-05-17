<?php
session_start();
if ($_SESSION['valid'] && ($_SESSION['username'] == 'btran')){
	if (empty($_POST)){
		$review_id = $_GET["id"];

		include "connect_server.php";

		$QUERY = "SELECT * FROM btran6291_REVIEW WHERE ID = " . $review_id;
		$q = $conn->prepare($QUERY);
		$q->execute();
		$q->setFetchMode(PDO::FETCH_BOTH);

		//Only one review should return based on the id
		$r=$q->fetch();

		$reviewer_name = $r["reviewer_name"];
		$reviewer_review = $r["Reviewer_review"];
		$review_rating = $r["Review_rating"];
		$movie_id = $r["movie_id"];
?>
<html>

	<head>
		<title>Update Review</title>
		<link rel='stylesheet' type='text/css' href='styles.css'>
	</head>
	<body>
<?php			
		include 'nav-bar.php';	
?>
		<div class='document'>
			<br>
			<center><h1>Update Review</h1></center>
			<hr>
			<form action='update_review.php' method='POST'>
				<table width='100%'>
					<tr>
						<input type='hidden' name='movie_id' value='<?php echo $movie_id ?>'>
						<input type='hidden' name='id' value='<?php echo $review_id ?>'>
						<td width="450">
							<p>User Name</p>
							<input type='text' name='name' value='<?php echo $reviewer_name ?>' width="150" pattern='^[a-zA-Z 0-9]*$' title='Text and Numbers Only' required>
						</td>
					</tr>
					<tr>
						<td>
							<p>Rating</p>
							<input type='number' name='rating' value='<?php echo $review_rating ?>' width='50' min='0' max='10'>
						</td>
					</tr>
					<tr>
						<td>
							<p>Review</p>
							<textarea name='review' rows='8' cols='55' pattern='^[a-zA-Z 0-9]*$' title='Text and or Numbers Only'><?php echo $reviewer_review ?></textarea>
						</td>
					</tr>

					<tr>
						<td>
							<input type='submit' value='O'>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
<?php		
	}else{
		/**
		*	Strips strings of invalid characters and or tags
		*	$data - the string to be cleaned
		**/
		function sanitize($data){
			$data=stripslashes($data);
			$data=strip_tags($data); 
			return $data;
		}

		include 'connect_server.php';

		$QUERY = "UPDATE btran6291_REVIEW 
					set reviewer_name=?,
						Reviewer_review=?,
						Review_rating=? 
					where ID=?";

		$q = $conn->prepare($QUERY);
		
		//Execute and clean the data to be added to the database.
		if ($q->execute(array(sanitize($_POST['name']),sanitize($_POST['review']),sanitize($_POST['rating']),sanitize($_POST['id'])))) {
			//Go back to the movie page where the review was
			echo '<script>document.location = "movie_page.php?id='.$_POST['movie_id'].'";</script>';
		}else{
			echo "Unable to update movie";
			echo $q->errorCode();
		}
		$conn=null;
	}
}else{
	//Error messages when the user is unauthorized to make any changes.
	echo "<title>Error 401. Unauthorized</title>";
	echo "<h1>Error 401. Unauthorized</h1>";
	header('Refresh: 3; URL = index.php');
	die();
}
?>