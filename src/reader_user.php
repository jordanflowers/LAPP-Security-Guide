<?php
	session_start();
	$userSpecified = $_REQUEST["username"];
	$passwordSpecified = $_REQUEST["pass"];

	// Prevent from SQL injection
	$userSpecified = stripslashes($userSpecified);
	$passwordSpecified = stripslashes($passwordSpecified);

	$dbconn = pg_connect("dbname=userdb user=phpreader password=readerPW");
	$result = pg_query($dbconn, "select pass from userpass where uname='$userSpecified'");
	//print $result;
	if (!$result)
	{
		echo "An error ocurred.\n";
		exit;
	}

	$count = pg_num_rows($result);

	if ($count == 1)
	{
		$row = pg_fetch_row($result);
		$test = crypt($passwordSpecified, $row[0]);
  		
  		if($test == $row[0])
  		{
  			echo "authenticated\n";
  		}
  		else
  		{
  			echo "denied\n";
  		}
	}
?>