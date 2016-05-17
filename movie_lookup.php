<html>
	<head>
		<title>Movie Search</title>
		<link rel="stylesheet" type="text/css" href="styles.css">
	</head>

<body>
<?php
	//Set the search link on the navigation bar as active
	$ten = "active";
	include "nav-bar.php";

	//======Get All Movies Titles=============
	include 'connect_server.php';

	$QUERY = "SELECT ID,movie_title FROM btran6291_MOVIE";
	$q = $conn->prepare($QUERY);
	$q->execute();
	$q->setFetchMode(PDO::FETCH_BOTH);
	$titles = array();
	$ids = array();

	//Get all queried data into an array.
	while($r=$q->fetch()){
		array_push($titles,$r["movie_title"]);
		array_push($ids, $r["ID"]);
	}

	$titlesAsString = "";
	$idsAsString = "";

	//Get all the values from the array into a single string.
	foreach($titles as $str){
		$titlesAsString .= "\"$str\",";
	}

	foreach($ids as $id){
		$idsAsString .= "\"$id\",";
	}

	//========================================
?>
	<!--========== FORM ======================-->
	<div class="document">
	
		<h1><center>Movie Search</center></h1>
		<hr>
		<table>
			<tr><td>
				<form>
					<input type="text" name="movie_title" placeholder="Search Title" onkeydown="showSuggestions(this.value)" style="width:300px" required>
				</form>
			</td></tr>
			<tr><td>
				<ul id="movies-list"></ul>
			</td></tr>
		</table>
	</div>

	<script>

		//Get the movies titles from PHP into an Array
		var existingTitles = [<?php echo $titlesAsString ?>];
		//Get the ids
		var ids = [<?php echo $idsAsString ?>];

		function showSuggestions(searchStr){
			searchStr = searchStr.toLowerCase(); // For easy comparison
			var list = document.getElementById("movies-list");

			//Remove all list items if there are any
			while(list.hasChildNodes()){
				list.removeChild(list.firstChild);
			}

			for (i = 0; i < existingTitles.length; i++){
				//If a title contains a substring that matches with the search string
				if ((existingTitles[i].toLowerCase()).indexOf(searchStr) > -1 & searchStr.length >= 1){
					// Create list item element with link to the movie page based on the ID
					var li = document.createElement("LI");
					var textNode = document.createTextNode(existingTitles[i]);
					var a = document.createElement('a');
					a.href= "movie_page.php?id=" + ids[i];
					a.appendChild(textNode);
					li.appendChild(a);
					document.getElementById("movies-list").appendChild(li);
				}
			}
		}
	</script>
</body>

</html>



