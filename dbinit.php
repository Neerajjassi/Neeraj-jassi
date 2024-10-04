<?php

define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'watch_store');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($dbc, 'utf8');

$query = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
mysqli_query($dbc, $query) OR die('Error creating database: ' . mysqli_error($dbc));

mysqli_select_db($dbc, DB_NAME) OR die('Could not select database: ' . mysqli_error($dbc));

$query = "CREATE TABLE IF NOT EXISTS watches (
    WatchID INT AUTO_INCREMENT PRIMARY KEY,
    WatchName VARCHAR(100),
    WatchDescription TEXT,
    WatchCategory VARCHAR(50),
    QuantityAvailable INT,
    Price DECIMAL(10,2),
    ProductAddedBy VARCHAR(100)
  );";

mysqli_query($dbc, $query) OR die('Error creating table: ' . mysqli_error($dbc));

?>
