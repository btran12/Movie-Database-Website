<?php
session_start();

//Any users with a valid session can view the movies database but cannot make any changes to it.
if ($_SESSION['valid']){

	include 'connect_server.php';
	
	//Options to sort the database
	$order_by = "ID";
	$order = "desc";
	if (isset($_GET['orderby'])){
		$order_by = $_GET['orderby'];
	}
	if (isset($_GET['order'])){
		$order = $_GET['order'];
	}
	//Alternate when the user click to sort again
	if ($order == "asc"){
		$order = "desc";
	}else{
		$order = "asc";
	}
	//Return the number of items in the movies database
	//Just to get a head count of how many movies are there
	$QUERY = "SELECT COUNT(*) as rows 
				FROM btran6291_MOVIE";

	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
	$r=$q->fetch();

	$count=$r["rows"];
	
	//Get all the movies and all columns
	$QUERY = "SELECT * 
				FROM btran6291_MOVIE 
				ORDER BY ". $order_by . " " . $order;

	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
?>
<head>
	<title>Movies Database</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<h1>Movies Database (<?php echo $count ?>)</h1>
	<p><a href='index.php'>Home</a></p>
	<p><a href='add_movie.php'>Add another movie</a></p>
	<hr>
	<table width='100%' border='1'>
		<th style='width:35px'>
			<a href=<?php echo "view_movies.php?orderby=ID&order=".$order; ?>>ID</a>
		</th>
		<th style='width:150px'>
			<a href=<?php echo "view_movies.php?orderby=movie_title&order=".$order; ?>>Title</a>
		</th>
		<th style='width:150px'>Director</th>
		<th>Plot</th>
		<th style='width:40px'>Duration</th>
		<th>Poster Link</th>
		<th style='width:35px'>
			<a href=<?php echo "view_movies.php?orderby=movie_rating&order=".$order; ?>>Rating</a>
		</th>
		<th style='width:130px'>
			<a href=<?php echo "view_movies.php?orderby=movie_released_date&order=".$order; ?>>Date (Y/M/D)</a>
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
		/** 
		*	Popup to confirm if the user wants to delete the entry
		*	This option is restricted to the admin only
		*	id - is the id of the movie, just to confirm with the user that, that is the movie they want to delete
		**/
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
</body>

<?php
	//Close connection
	$conn=null;
}else{
	echo "<title>Error 401. Unauthorized Access.";
	echo "<h4>Error 401. You are unauthorized to perform this action.</h4>";
	header('Refresh: 3; URL = index.php');
	die();
}
?>