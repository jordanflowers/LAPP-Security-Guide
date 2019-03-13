<?php
    //session_start();
    $userSpecified = $_REQUEST["username"];
    $passwordSpecified = $_REQUEST["pass"];
	
    // Prevent from SQL injection
    $userSpecified = stripslashes($userSpecified);
    $passwordSpecified = stripslashes($passwordSpecified);

    $dbconn = pg_connect("dbname=userdb user=phpinserter password=inserterPW");
	if (!$dbconn)
    {
        echo "An error ocurred connecting to the database.";
        exit;
    }
	$query = "insert into userpass values ('".$userSpecified."', crypt('".$passwordSpecified."', gen_salt('bf')))";
    $result = pg_query($dbconn, $query);
    if (!$result)
    {
        echo "An error ocurred in the Insert.\n";
        exit;
    }
	else
	{
		echo "Account $userSpcified was successfully created.";
		exit;
	}
	
?>