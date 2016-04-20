 +<?php
 +//connection parameters
 +$dbtype = "mysql";
 +$dbhost = "host";
 +$dbname = "dbname";
 +$dbuser = "dbuser";
 +$dbpass = "dbpass";
 +
 +//set up connection
 +$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 +
 +?>
