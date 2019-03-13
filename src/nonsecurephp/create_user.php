<?php
    $userSpecified = $_REQUEST["username"];
    $passwordSpecified = $_REQUEST["pass"];
	//$userSpecified = "jflowers";
    //$passwordSpecified = "mynewpassword";
    
    $dbconn = pg_connect("dbname=userdb user=postgres password=root");
	if (!$dbconn)
    {
        echo "An error ocurred connecting to the database.";
        exit;
    }
	$query = "insert into userpass values ('".$userSpecified."', '".$passwordSpecified."')";
    $result = pg_query($dbconn, $query);
    if (!$result)
    {
        echo "An error ocurred in the Insert.\n";
        exit;
    }
	else
	{
		echo "Account was successfully created.";
		exit;
	}
	
?>