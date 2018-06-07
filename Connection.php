<?php

function dbConnect(){
	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "toni";
	$dbName = "library";
	$dbConnection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

	if(mysqli_connect_errno()){
		die("Database connection error ".mysqli_connect_error()." => ".mysqli_connect_errno());
	}else{
		return $dbConnection;
	}

}
function closeDbConnection($dbConnection){
	mysqli_close($dbConnection);
}