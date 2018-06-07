<?php
	include("./Users.php");
	include("./Titles.php");
	include("./Authors.php");
	include("./Connection.php");
	$toni = new User("mate", "matic");

	$title = new Title("rat i mir", "toni", "1990", "novel");
	$title1 = new Title("ana karenjina", "antonio", "1995", "novel");

	$author = new Author("Miroslav Krleza");
	$author1 = new Author("A. B. Simic");

	$con = dbConnect();

	User::SelectUsers($con);
	$toni->InsertUser($con);
	$toni->UpdateUser($con, 4);
	User::DeleteUser($con, 1);
	echo "<br/>";
	Title::SelectTitle($con);
	$title->InsertTitle($con);
	$title1->UpdateTitle($con, 1);
	Title::DeleteTitle($con, 2);
	echo "<br/>";
	Author::SelectAuthor($con);
	$author->InsertAuthor($con);
	$author1->UpdateAuthor($con, 1);
	Author::DeleteAuthor($con, 5);
	echo "<br/>";

	$toni->login($con);
	
	User::logout();
	
	closeDbConnection($con);
?>