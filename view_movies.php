<?php
session_start();
if ($_SESSION['valid']){
	include 'connect_server.php';

	$order_by = "ID";
	if (isset($_GET['order'])){
		$order_by = $_GET['order']; //Variable from html code
	}
	$QUERY = "SELECT COUNT(*) as rows FROM btran6291_MOVIE";

	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
	$r=$q->fetch();
	$count=$r["rows"];

	$QUERY = "SELECT * FROM btran6291_MOVIE ORDER BY ". $order_by;

	$q = $conn->prepare($QUERY);
	$q->execute();

	//Getting the data back
	$q->setFetchMode(PDO::FETCH_BOTH);

	echo "<h1>Movie Database (".$count.")</h1><p><p><a href='index.php'>Home</a></p><a href='add_movie.php'>Add another movie</a></p><hr>";
	echo "<table width='100%' border='1' style='border-collapse:collapse;table-layout:fixed'>
		<th style='width:35px'><a href='view_movies.php?order=ID'>Movie ID</a></th>
		<th style='width:150px'><a href='view_movies.php?order=movie_title'>Title</a></th>
		<th style='width:150px'>Director</th>
		<th>Plot</th>
		<th style='width:40px'>Duration</th>
		<th>Poster Link</th>
		<th style='width:35px'><a href='view_movies.php?order=movie_rating'>Rating</a></th>
		<th style='width:130px'><a href='view_movies.php?order=movie_released_date'>Date (Y/M/D)</a></th>
		<th style='width:60px'></th><th style='width:25px'></th>";

	while($r=$q->fetch()){
		$id = $r["ID"];
		$title = $r["movie_title"];

		echo "<tr><td>". $id . "</td>
		<td>". $title ."</td>
		<td>". $r["movie_director"] ."</td>
		<td>". $r["movie_plot"] ."</td>
		<td>". $r["movie_duration"] ."</td>
		<td style='word-wrap:break-word'>". $r["poster_url"] ."</td>
		<td>". $r["movie_rating"] ."</td>
		<td>". $r["movie_released_date"] ."</td>
		<td><a href='update_movie.php?id=". $id ."&title=". str_replace("'", "", $title) ."&director=". str_replace("'", "", $r["movie_director"]) ."&duration=". $r["movie_duration"]  ."&rating=". 0 ."&date=". $r["movie_released_date"]."&rating=". $r["movie_rating"]."&link=". $r["poster_url"] . "&plot=". str_replace("'", "", $r["movie_plot"]) ."'>[Update]</a></td>
		<td><a href='#' onclick='confirmDelete(".$id.")'>[X]</a></td></tr>";
	}
	echo "</table>";

	echo '<script>
	function confirmDelete(id) {
		var username = "'. $_SESSION["username"] .'";
		if (username !== "guest"){
		    if (confirm("Are you sure? ID: " + id) == true) {
		        document.location = "delete_movie.php?id="+id;
		    }
		}else{
			window.alert("Unauthorized");
		}
	  
	}
	</script>';

	//Close connection
	$conn=null;
}else{
	echo "<h2>This Page is Restricted to the Admins only.</h2>";
	header('Refresh: 3; URL = index.php');
}
?>