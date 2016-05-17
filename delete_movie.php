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

// Check if the current session is valid, 
// and if the user is authorized to perform deletion
if($_SESSION['valid'] && ($_SESSION['username'] == 'btran')){

	include 'connect_server.php';

	$id=sanitize($_GET['id']);
	$QUERY = "DELETE from btran6291_MOVIE where id=?";

	$q = $conn->prepare($QUERY);

	//Execute the sql command and redirect to view movies page
	if ($q->execute(array($id))){
		echo '<script>document.location = "view_movies.php";</script>';
	}else{
		echo "Unable to delete movie. <a href='view_movies.php'>Try Again</a>";
		echo $q->errorCode();
	}
	//Close connection to database.
	$conn=null;

}else{
	//Error messages with the user is authorized to perform deletion
	echo "<title>Error 401. Unauthorized</title>";
	echo "<h1>Error 401. Unauthorized</h1>";
	header('Refresh: 3; URL = index.php');
	die();
}
?>