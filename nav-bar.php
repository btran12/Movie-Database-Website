<?php
	/**
	*	Display a vertical navigation bar
	**/
	session_start();
	
	//The number variables are in the parent file that includes this file.
	echo "
	<div class='navigation-bar'>
		<ul>
			<li>
				<a href='index.php?page=main' class='".$one."'>
					Upcoming Movies
				</a>
			</li>
			<li>
				<a href='index.php?page=current' class='".$two."'> 
					Currently Showing Movies 
				</a>
			</li>
			<li>
				<a href='index.php?page=topall' class='".$three."'> 
					Best Movies of All Times 
				</a>
			</li>
			<li>
				<a href='index.php?page=top15' class='".$four."'> 
					Top Movies of 2015 
				</a>
			</li>
			<li>
				<a href='index.php?page=top14' class='".$five."'> 
					Top Movies of 2014 
				</a>
			</li>
			<li>
				<a href='index.php?page=top13' class='".$six."'> 
					Top Movies of 2013 
				</a>
			</li>
			<li>
				<a href='index.php?page=top12' class='".$seven."'>
					Top Movies of 2012 
				</a>
			</li>
			<li>
				<a href='index.php?page=top11' class='".$eight."'> 
					Top Movies of 2011 
				</a>
			</li>
			<li>
				<a href='index.php?page=top10' class='".$nine."'> 
					Top Movies of 2010 
				</a>
			</li>
			<li>
				<a href='showtimes.php' class='".$eleven."'> 
					Showtimes Near You
				</a>
			</li>

			<li>
				<a href='admin_page.php'> 
					Administration
				</a>
			</li>
			<li>
				<a href='dynamic.php'>
					Dynamic View
				</a>
			</li>
			<li>
				<a href='movie_lookup.php' class='".$ten."'> 
					Search <img src='https://cdn1.iconfinder.com/data/icons/free-98-icons/32/search-128.png' style='width:16px;height:16px;'>
				</a>
			</li>";
	//If the user is logged in display a new item with the username
	if ($_SESSION["valid"]){
		echo "
			<li>
				<a href='logout.php' id='user-session-label'>
					Log Out of ".$_SESSION["username"].
				"</a>
			</li>";
	}
	echo "
		<ul>
	</div>";
?>
