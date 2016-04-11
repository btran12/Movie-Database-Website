<?php
session_start();
if($_SESSION['valid']){
	include 'connect_server.php';

	$id=$_GET['id'];
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
	echo "<h2>This Page is Restricted to the Admins only.</h2>";
	header('Refresh: 3; URL = index.php');
}
?>