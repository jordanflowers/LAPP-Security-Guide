<?php
	session_start();
	$userSpecified = $_REQUEST["username"];
	$passwordSpecified = $_REQUEST["pass"];

	

	$dbconn = pg_connect("dbname=userdb user=postgres password=root");
	$result = pg_query($dbconn, "select * from userpass where uname='$userSpecified' and pass='$passwordSpecified'");
	//print $result;
	if (!$result)
	{
		echo "An error ocurred.\n";
		exit;
	}

	if(pg_num_rows($result) == 0)
		echo 'denied';
	else
		echo 'authenticated';
	
	
?>