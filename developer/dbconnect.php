<?php

    $dbname = "webcourselesson";
    $dsn = "mysql:dbname=" . $dbname . "; host=localhost";
    $usr = 'root';
	$dbh = new PDO($dsn, $usr);
	$dbh->exec('SET NAMES utf8');
	//echo "接続できました"

?>