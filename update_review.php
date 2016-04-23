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

		echo "<html>

			<head>
			<title>Update Review</title>
			<link rel='stylesheet' type='text/css' href='styles.css'>
			</head>
			<body>";
			
		include 'nav-bar.php';	

		echo "<div class='document'>";
		echo "<br><center><h1>Update Review</h1></center><hr>";
		echo "<form action='update_review.php' method='POST'>
			<table width='100%'>
				<tr>
					<input type='hidden' name='movie_id' value='".$movie_id."'>
					<input type='hidden' name='id' value='".$review_id."'>
					<td style='width:450px'><p>User Name</p><input type='text' name='name' value='". $reviewer_name ."' style='width: 150px' pattern='^[a-zA-Z 0-9]*$' title='Text and Numbers Only' required></td>
				</tr>
				<tr>
					<td><p>Rating</p><input type='number' name='rating' value='". $review_rating ."' style='width: 50px' min='0' max='10'> <p style='display:inline'></p></td>
				</tr>
				<tr>
					<td><p>Review</p><textarea name='review' rows='8' cols='55' pattern='^[a-zA-Z 0-9]*$' title='Text and or Numbers Only'>". $reviewer_review ."</textarea></td>
				</tr>

				<tr>
					<td><input type='submit' value='O'></td>
				</tr>
			</table>
		</form>
		</div>
		</body>
		</html>";
	}else{
		function sanitize($data){
			$data=stripslashes($data); // Remove all slashses
			$data=strip_tags($data); //Remove all tags
			return $data;
		}

		include 'connect_server.php';

		$QUERY = "UPDATE btran6291_REVIEW set reviewer_name=?,Reviewer_review=?,Review_rating=? where ID=?";

		$q = $conn->prepare($QUERY);
		
		//Form post
		if ($q->execute(array(sanitize($_POST['name']),sanitize($_POST['review']),sanitize($_POST['rating']),sanitize($_POST['id'])))) {
			//Redirect
			echo '<script>document.location = "movie_page.php?id='.$_POST['movie_id'].'";</script>';
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
	die();
}
?>