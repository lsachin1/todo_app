<?php

/*  Configuration for database connection  */

$dbConfig   = array(
	'driver' => 'mysql',
	'host' => 'localhost',
	'newHost' => '127.0.0.1',
	'dbname' => 'todo_app',
	'username' => 'root',
	'password' => 'root',
	'options'  => array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              )
);

$dbTestConfig   = array(
	'driver' => 'mysql',
	'host' => 'localhost',
	'newHost' => '127.0.0.1',
	'dbname' => 'test_todo_app',
	'username' => 'root',
	'password' => 'root',
	'options'  => array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              )
);
?>