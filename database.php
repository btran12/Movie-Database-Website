<?php
	include "connect_server.php";

	$QUERY = "DESCRIBE btran6291_MOVIE";
	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);

	while($r=$q->fetch()){
		print_r($r);
		echo "<br>";
	}

?>