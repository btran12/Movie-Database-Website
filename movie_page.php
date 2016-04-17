<?php
	if (empty($_POST)){
		
?>
<?php
	include "nav-bar.php";
?>
<?php
	$movie_id = $_GET["id"];

	include "connect_server.php";
	$QUERY = "SELECT * FROM btran6291_MOVIE WHERE ID = " . $movie_id;
	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);

	//Only 1 result should return
	$m=$q->fetch();

	//Get Reviews Information linked by movie id
	$QUERY = "SELECT * FROM btran6291_REVIEW WHERE movie_id = " . $movie_id ." ORDER BY Review_date desc"; 
	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<title><?php echo $m["movie_title"]; ?></title>
	</head>

<body>


<div class="document">


	<br><center><h1 style="display:inline"><?php echo $m["movie_title"]; ?></h1><h1 style="display:inline;margin-left:10px;font-size:16px"><?php echo " ".$m["movie_released_date"] ?></h1></center>
	<hr>
	<table style="table-layout:fixed">
		<tr>
			<td rowspan="3" style="width:250px"><img src=<?php echo "'".$m["poster_url"]."'"?>  height="350" width="250"></td>
			<td><p>Duration: <?php echo $m["movie_duration"] ?> min</p></td>
		</tr>
		<tr>
			<td colspan="2"><p style="font-size:24px;font-style:bold"><?php echo $m["movie_rating"] ?>/10</p></td>
		</tr>
		<tr>
			<td><p>Directed By: <?php echo $m["movie_director"] ?></p></td>
			
		</tr>
		<tr><td colspan="2"><p><?php echo $m["movie_plot"] ?></p></td></tr>
		
	</table>
	<hr>
	<h2><p>User Reviews</p></h2>
	<hr>
	<form action="movie_page.php" method="POST">
		<table style="table-layout:fixed">
			<?php echo "<input type='hidden' name='movie_id' value='".$movie_id."'>"; ?>
			<tr>
				<td colspan="2"><input type="text" placeholder="Your Name" name="user_name" pattern="^[a-zA-Z ]*$" required></td>
			</tr>
			<tr>
				<td colspan="2"><textarea placeholder="Your Review" name="user_review" rows="10" cols="70" pattern="^[a-zA-Z ]*$" required></textarea></td>
			</tr>
			<tr>
				<td width="50px"><input type="number" name="user_rating" min="0" max="10" step="0.1" value="0"></td><td><input type="submit" value="+" style="font-size:20px;font-weight:bold"></td>
			</tr>
		</table>
			
	</form>
	<div class="user-reviews">
		<table width="100%">
		<?php
			//Get all the available reviews; 
			while($r=$q->fetch()){
				echo "<tr><td colspan='2']>";
				echo "<p>". $r["Reviewer_review"]."</p>";
				echo "</td></tr>";
				echo "<tr>";
				echo "<td><p>". $r["reviewer_name"] ."</p></td><td><p>". $r["Review_rating"] ."</p></td><td><p>". $r["Review_date"] ."</p></td>";
				echo "</tr>";
			}
			
		?>
		</table>
	</div>
	
	
</div>

</body>
</html>
<?php
}else{
	$username = $_POST["user_name"];
	$userrating = $_POST["user_rating"];
	$userreview = $_POST["user_review"];
	$date = date("Y-m-d h:i:sa");
	$movieid = $_POST["movie_id"];

	include 'connect_server.php';

	$QUERY = "INSERT INTO btran6291_REVIEW(reviewer_name,Reviewer_review,Review_date,Review_rating,movie_id) VALUES(?,?,?,?,?)";

	$q = $conn->prepare($QUERY);

	if($q->execute(array($username,$userreview,$date,$userrating,$movieid))){
		//Refresh
		echo "<script>document.location ='movie_page.php?id=". $movieid. "';</script>"; 
	}else{
		echo $q->errorCode();
	}

	//Close connection
	$conn=null;
}
?>