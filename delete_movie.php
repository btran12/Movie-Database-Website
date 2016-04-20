<?php
session_start();
if($_SESSION['valid'] && ($_SESSION['username'] == 'btran')){
	function sanitize($data){
		$data=stripslashes($data); // Remove all slashses
		$data=strip_tags($data); //Remove all tags
		return $data;
	}
	include 'connect_server.php';

	$id=sanitize($_GET['id']);
	$QUERY = "DELETE from btran6291_MOVIE where id=?";

	$q = $conn->prepare($QUERY);

	if ($q->execute(array($id))){
		echo '<script>document.location = "view_movies.php";</script>';
	}else{
		echo "Unable to delete movie. <a href='view_movies.php'>Try Again</a>";
		echo $q->errorCode();
	}
	$conn=null;
}else{
	echo "<title>Error 401. Unauthorized</title>";
	echo "<h1>Error 401. Unauthorized</h1>";
	header('Refresh: 3; URL = index.php');
	die();
}
?>