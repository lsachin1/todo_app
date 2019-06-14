<?php

require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/DBConnection.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/modals/tasks.php";

// created Task class object
$database 	= new DBconnection($dbConfig);
$task 		= new Task($database);

//below code fetches all tasks
$tasksArr 	= $task->fetchAllTasks();

?>