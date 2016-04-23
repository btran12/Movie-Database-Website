<?php
session_start();
if ($_SESSION['valid']){

	include 'connect_server.php';

	$order_by = "ID";

	if (isset($_GET['order'])){
		$order_by = $_GET['order'];
	}

	$QUERY = "SELECT COUNT(*) as rows 
				FROM btran6291_MOVIE";

	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
	$r=$q->fetch();

	$count=$r["rows"];

	$QUERY = "SELECT * 
				FROM btran6291_MOVIE 
				ORDER BY ". $order_by;

	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
?>
<head>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>

	<h1>Movies Database (<?php echo $count ?>)</h1>
	<p><a href='index.php'>Home</a></p>
	<p><a href='add_movie.php'>Add another movie</a></p>
	<hr>
	<table width='100%' border='1'>
		<th style='width:35px'>
			<a href='view_movies.php?order=ID'>ID</a>
		</th>
		<th style='width:150px'>
			<a href='view_movies.php?order=movie_title'>Title</a>
		</th>
		<th style='width:150px'>Director</th>
		<th>Plot</th>
		<th style='width:40px'>Duration</th>
		<th>Poster Link</th>
		<th style='width:35px'>
			<a href='view_movies.php?order=movie_rating'>Rating</a>
		</th>
		<th style='width:130px'>
			<a href='view_movies.php?order=movie_released_date'>Date (Y/M/D)</a>
		</th>
		<th style='width:60px'></th>
		<th style='width:25px'></th>
<?php
	while($r=$q->fetch()){
		$id = $r["ID"];
		$title = $r["movie_title"];

		echo "
		<tr>
			<td>". $id . "</td>
			<td>". $title ."</td>
			<td>". $r["movie_director"] ."</td>
			<td>". $r["movie_plot"] ."</td>
			<td>". $r["movie_duration"] ."</td>
			<td id='url'>". $r["poster_url"] ."</td>
			<td>". $r["movie_rating"] ."</td>
			<td>". $r["movie_released_date"] ."</td>
			<td>
				<a href='update_movie.php?
				id=". $id ."
				&title=". str_replace("'", "", $title) ."
				&director=". str_replace("'", "", $r["movie_director"]) ."
				&duration=". $r["movie_duration"]  ."
				&date=". $r["movie_released_date"]."
				&rating=". $r["movie_rating"]."
				&link=". $r["poster_url"] . "
				&plot=". str_replace("'", "", $r["movie_plot"]) ."'>[Update]</a>
			</td>
			<td>
				<a href='#' onclick='confirmDelete(".$id.")'>[X]</a>
			</td>
		</tr>";
	}
?>
	</table>

<script>
	function confirmDelete(id) {
		if (<?php echo "\"". $_SESSION["username"] . "\"" ?> !== "guest"){
		    if (confirm("Are you sure? ID: " + id) == true) {
		        document.location = "delete_movie.php?id="+id;
		    }
		}else{
			window.alert("Unauthorized");
		}
	  
	}
</script>

<?php
	//Close connection
	$conn=null;
}else{
	echo "<h2>This Page is Restricted to the Admins only.</h2>";
	header('Refresh: 3; URL = index.php');
}
?>