<html>
<head>
<title>Movie Search</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
<?php
	include "nav-bar.php";
?>
<?php
	if (empty($_POST)){
?>
<div class="document">
	
	<br><h1><center>Movie Search</center></h1>
	<hr>
	<form action="movie_lookup.php" method="POST">
		<input type="text" name="movie_title" placeholder="Search Title" style="width:300px">
		<input type="text" name="movie_year" placeholder="Movie Year (Optional)" style="width:200px">
		<input type="submit" value="?" style="font-weight:bold;font-size:18px">
	</form>
	<br>
</div>
</body>

</html>

<?php
}else{
	$search_title = $_POST["movie_title"];
	$search_year = $_POST["movie_year"];
?>
	<div class="document">
	
		<h1><center>Movie Search</center></h1>
		<hr>
		<form action="movie_lookup.php" method="POST">
		<input type="text" name="movie_title" placeholder="Search Title" style="width:300px">
		<input type="text" name="movie_year" placeholder="Movie Year (Optional)" style="width:200px">
		<input type="submit" value="?" style="font-weight:bold;font-size:18px">
		</form>
		<br>
		<p style="font-size: 18px">Movies with your query: <b><?php echo $search_title; ?></b></p>
		<table>
		<?php
			include 'connect_server.php';
			$QUERY = "SELECT * FROM btran6291_MOVIE WHERE movie_title LIKE '%" . $search_title . "%' ORDER BY movie_title";
			$q = $conn->prepare($QUERY);
			$q->execute();
			$q->setFetchMode(PDO::FETCH_BOTH);

			while($r=$q->fetch()){
				echo "<tr><td><a href='movie_page.php?id=". $r["ID"] ."'>". $r["movie_title"] ."</a></td></tr>";
			}
			
			$conn=null;
		?>
		</table>
	</div>

<?php
}

?>


