<?php
	session_start();

	if (empty($_POST)){

	$movie_id = $_GET["id"];

	include "connect_server.php";
	$QUERY = "SELECT * FROM btran6291_MOVIE WHERE ID = " . $movie_id;
	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);

	//Only 1 movie from the database based on the passed in movie id
	$m=$q->fetch();

	//Get Reviews Information linked by movie id
	$QUERY = "SELECT * FROM btran6291_REVIEW WHERE movie_id = " . $movie_id ." ORDER BY Review_date desc"; 
	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
	
?>
<?php
	//Get Youtube API data
	$DEVELOPER_KEY = "YOUR API KEY";

	$url_query = rawurlencode($m["movie_title"] . " movie trailer");

	$json = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=id&q=".$url_query."&key=".$DEVELOPER_KEY);
	$obj = json_decode($json);

	$youtube_video_id = $obj->items[0]->id->videoId;
?>

<?php
	include "nav-bar.php";
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<title><?php echo $m["movie_title"]; ?></title>
		
	</head>
	
<body>
<div class="document">


	<br>
	<center>
		<h1 style="display:inline">
			<?php echo $m["movie_title"]; ?>
		</h1>
		<h1 style="display:inline;margin-left:10px;font-size:16px">
			<?php echo " " . formatDate($m["movie_released_date"]); ?>
		</h1>
	</center>
	<hr>
	<table style="table-layout:fixed" width="100%">
		<tr>
			<td rowspan="3" style="width:300px">
				<img src=<?php echo "'".$m["poster_url"]."'"?>  height="400" width="275">
			</td>
			<td style="vertical-align:bottom;width:150px">
				<p><b>Duration:</b><br><?php echo $m["movie_duration"] ?> min</p>
			</td>
			<td rowspan="3" align="right">
				<iframe id="youtube-frame" src="" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
			</td>
		</tr>
		<tr>
			<td>
				<p style="font-size:28px;color:#0099ff">
					<?php echo $m["movie_rating"] ?>
				</p>
			</td>
		</tr>
		<tr>
			<td style="vertical-align:top;">
				<p><b>Director:</b><br><?php echo $m["movie_director"] ?></p>
			</td>
			
		</tr>
		<tr>
			<td colspan="3">
				<p><?php echo $m["movie_plot"] ?></p>
			</td>
		</tr>
		
	</table>
	<hr>
	<h2><p>User Reviews</p></h2>
	<hr>
	<form action="movie_page.php" method="POST">
		<table style="table-layout:fixed">
			<?php echo "<input type='hidden' name='movie_id' value='".$movie_id."'>"; ?>
			<tr>
				<td colspan="2">
					<input type="text" placeholder="Your Name" name="user_name" pattern="^[a-zA-Z 0-9]*$" title="Text and or Numbers only" required>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea placeholder="Your Review" name="user_review" rows="10" cols="70" pattern="^[a-zA-Z 0-9]*$" title="Text and or Numbers only" required></textarea>
				</td>
			</tr>
			<tr>
				<td width="50px">
					<input type="number" name="user_rating" min="0" max="10" step="0.1" value="0">
				</td>
				<td>
					<input type="submit" value="+" style="font-size:20px;font-weight:bold">
				</td>
			</tr>
		</table>
			
	</form>
	<div class="user-reviews">
		<table width="80%" style="table-layout:fixed">
		<?php
			//Get all the available reviews; 
			while($r=$q->fetch()){
				echo "<tr>
					<td colspan='3' height='10'>
					<hr style='background-image:none;'>";

				//Review Update and Delete options will only show up if it's the admin
				if ($_SESSION['valid'] && ($_SESSION['username'] == 'btran')){
					echo "<a href='update_review.php?id=".$r["ID"]."'>Edit</a>
					<a href='delete_review.php?id=".$r["ID"]."&movieid=".$movie_id."' style='margin-left:50px;color:red'>Remove</a>";
				}
				echo "</td>
					</tr>";
				echo "<tr>";
				echo "<td width='100px'>
						<p>By: <font color='#0099ff'>". $r["reviewer_name"]  ."</font></p>
					</td>";
				echo "<td width='100px'>
						<p>Rating: <font color='#ff8c1a'>". $r["Review_rating"] . "</font></p>
					</td>";
				echo "<td>
						<p><b>Posted on</b>: ". $r["Review_date"] ."</p>
					</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan='3']>
					<p>". $r["Reviewer_review"]."</p>";
				echo "</td>
					</tr>";
				
			}
		?>
		</table>
		<hr style='background-image: none;'>
	</div>
	
</div>
	<script>
		//Set video ID to the src link of youtube frame
		document.getElementById('youtube-frame').src = "https://www.youtube.com/embed/" + <?php echo '"'.$youtube_video_id.'"'; ?> + "?rel=0&iv_load_policy=3&amp;showinfo=0";
	</script>
</body>
</html>
<?php
}else{

	$username = sanitize($_POST["user_name"]);
	$userrating = sanitize($_POST["user_rating"]);
	$userreview = sanitize($_POST["user_review"]);
	$date = date("Y-m-d h:i:sa");
	$movieid = sanitize($_POST["movie_id"]);

	include 'connect_server.php';

	$QUERY = "INSERT INTO btran6291_REVIEW(
		reviewer_name,
		Reviewer_review,
		Review_date,
		Review_rating,
		movie_id) 
		VALUES(?,?,?,?,?)";

	$q = $conn->prepare($QUERY);

	//Refresh Page
	if($q->execute(array($username,$userreview,$date,$userrating,$movieid))){
		echo "<script>document.location ='movie_page.php?id=". $movieid. "';</script>"; 
	}else{
		echo $q->errorCode();
	}

	$conn=null;
}

	function sanitize($data){
		$data=stripslashes($data); // Remove all slashses
		$data=strip_tags($data); //Remove all tags
		return $data;
	}
	function formatDate($date){
		$dateObject = date_create($date);
		return date_format($dateObject, "j F Y");
	}
?>