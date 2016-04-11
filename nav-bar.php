[]<?php
	session_start();
	echo "<div class='navigation-bar'>
	<ul>
		<li><a href='index.php?page=main'> New and Currently Showing </a></li>
		<li><a href='index.php?page=topall'> 10 Best Movies of All Times </a></li>
		<li><a href='index.php?page=top15'> Top Movies of 2015 </a></li>
		<li><a href='index.php?page=top14'> Top Movies of 2014 </a></li>
		<li><a href='index.php?page=top13'> Top Movies of 2013 </a></li>
		<li><a href='index.php?page=top12'> Top Movies of 2012 </a></li>
		<li><a href='index.php?page=top11'> Top Movies of 2011 </a></li>
		<li><a href='index.php?page=top10'> Top Movies of 2010 </a></li>
		<li><a href='admin_page.php'> Administration </a></li>
		<li><a href='movie_lookup.php'> Search <img src='https://cdn1.iconfinder.com/data/icons/free-98-icons/32/search-128.png' style='width:16px;height:16px;'></a></li>";
	if ($_SESSION["valid"]){
		echo "<li><a href='logout.php' id='user-session-label'>Log Out of ". $_SESSION["username"]. "</a>";
	}
	echo "<ul></div>";
?>