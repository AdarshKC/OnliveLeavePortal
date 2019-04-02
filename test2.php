<?php
	
try {
			$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		} catch (PDOException $e) {
			exit("Error: " . $e->getMessage());
		}

?>