<?php
	//Variables are in parent's files

	$json = file_get_contents($base_url."startDate=".$query_date."&zip=".$zipcode."&radius=".$radius."&api_key=".$ONCONNECT_KEY);

	$json = json_decode($json);
	$current_hour = date("H");	//Get the current hour
	$current_date = date("Y-m-d");
	
	foreach($json as $obj){
		$name = "";
		$theatre_name = "";

		$movie_title = $obj->title;
		$release_year = $obj->releaseYear;
		$duration = strtolower(substr($obj->runTime,3));

		//Only show movies in the current year
		//Smaller theaters often will show older movies
		if ($release_year == date("Y")){
			echo "<h4 style='display:inline'><b>". $movie_title . "</b></h4> 
					<h5 style='display:inline'> (".$duration.")</h5>";
			$showtimes = $obj->showtimes;	//Theater object

			foreach($showtimes as $showtime){
				$theatre_name = $showtime->theatre->name;

				if ($theatre_name != $name){
					echo "<br><br>". $theatre_name . "<br>";

					$name = $theatre_name;
				}

				$date_time = explode("T", $showtime->dateTime);

				$date = $date_time[0];
				$time = $date_time[1];
				$hr = substr($time,0,2);
				
				$timeHtmlString = "<a href='".$showtime->ticketURI."'><font color='blue'>" .$time."</font></a>" . str_repeat('&nbsp;', 5);

				//Only print current and future showing times
				//This only applies to today's date
				//Show all available times for future dates
				if ($hr >= $current_hour && $date == date("Y-m-d")){
					echo $timeHtmlString;
				}else if ($date != date("Y-m-d")){
					echo $timeHtmlString;
				}
			}

			echo "<hr>";
		}
	}
?>