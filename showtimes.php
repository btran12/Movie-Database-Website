<?php
	//Variables to be sent to onconnect_api.php to query data
	$ONCONNECT_KEY = "YOUR API KEY";

	$base_url = "http://data.tmsapi.com/v1.1/movies/showings?"; 
	$todays_date = date("Y-m-d");
	$tomorrow_date = date("Y-m-d", strtotime("+1 day"));
	$next_tomorrow_date = date("Y-m-d", strtotime("+2 days"));
	$current_time = date("H:i");

  $zipcode = $_GET["zip"];
  
  $radius = "15"; //15 miles radius; about 25-30 min drive
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Movies Showtimes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body style="position:relative">
<?php
	$eleven = "active";	//Set active tab
	include "nav-bar.php";
?>
<br>
<div id="showtimes-container" class="container">
  <h2 style="display:inline">Movies Showtimes</h2>
  <form action="showtimes.php" method="get" style="display:inline;margin-left:50px">
    <input type="text" name="zip" placeholder="Enter Zip Code" style="padding-bottom:0px">
    <input type="submit" value="" style="visibility: hidden; position: absolute;">
  </form>
  <ul class="nav nav-tabs" style="margin-top:50px">
    <li class="active">
      <a data-toggle="tab" href="#home">
        <?php echo "Today ".date('m/d') ?>
      </a>
    </li>
    <li>
      <a data-toggle="tab" href="#menu1">
        <?php echo "Tomorrow ".date('m/d', strtotime("+1 day")) ?>
      </a>
    </li>
    <li>
      <a data-toggle="tab" href="#menu2">
        <?php echo date('l m/d', strtotime("+2 day")) ?>
      </a>
    </li>
  </ul>
  <!-- TODO Fix Bad Code !! -->
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>Today</h3>
      <?php
        $query_date = $todays_date;

        if ($zipcode != "" ){
          include "onconnect_api.php";
        }
      ?>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Tomorrow</h3>
      <?php
        $query_date = $tomorrow_date;
        if ($zipcode != ""){
          include "onconnect_api.php";
        }
      ?>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3><?php echo date('l', strtotime("+2 day")) ?></h3>
      <?php
        $query_date = $next_tomorrow_date;
        if ($zipcode != ""){
          include "onconnect_api.php";
        }
      ?>
    </div>
  </div>
</div>

</body>
</html>