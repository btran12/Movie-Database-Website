<?php
	//Start the session to get the values
   session_start();
   //Clear all entered values
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["valid"]);

   //Redirect to main page
   header('Refresh: 0; URL = index.php');
?>