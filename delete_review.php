<?php
session_start();
/**
*	Clean data of slashes and tags
*	Prevent sql/html injections
*	$data - value to be stripped of tags and slashes
**/
function sanitize($data){
	$data=stripslashes($data);
	$data=strip_tags($data); 
	return $data;
}
// Check if the current session is valid 
// and if the user is authorized to perform action
if($_SESSION['valid'] && ($_SESSION['username'] == 'btran')){

	include 'connect_server.php';
	//Get the id of the review to delete
	$id=sanitize($_GET['id']);
	//Get the movie id to be able to redirect back to the movie page
	$movie_id=sanitize($_GET['movieid']);

	$QUERY = "DELETE from btran6291_REVIEW 
					where id=?";

	$q = $conn->prepare($QUERY);

	//Execute the deletion and redirect back to movie page
	if ($q->execute(array($id))){
		echo '<script>document.location = "movie_page.php?id='.$movie_id.'";</script>';
	}else{
		echo "Unable to delete review. <a href='movie_page.php?id=".$movie_id."'>Try Again</a>";
		echo $q->errorCode();
	}
	$conn=null;

}else{
	//Error messages when the user is unathorized to perform the deletion.
	echo "<title>Error 401. Unauthorized</title>";
	echo "<h1>Error 401. Unauthorized</h1>";
	header('Refresh: 3; URL = index.php');
	die();
}
?>