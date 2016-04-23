<?php
session_start();
if($_SESSION['valid'] && ($_SESSION['username'] == 'btran')){
	//Clean data
	function sanitize($data){
		$data=stripslashes($data);
		$data=strip_tags($data); 
		return $data;
	}
	include 'connect_server.php';

	$id=sanitize($_GET['id']);
	$movie_id=sanitize($_GET['movieid']);

	$QUERY = "DELETE from btran6291_REVIEW where id=?";

	$q = $conn->prepare($QUERY);

	if ($q->execute(array($id))){
		echo '<script>document.location = "movie_page.php?id='.$movie_id.'";</script>';
	}else{
		echo "Unable to delete review. <a href='movie_page.php?id=".$movie_id."'>Try Again</a>";
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