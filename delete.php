<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/helper.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/modals/tasks.php";
	
	//get the id of the task which we have to delete
	$id = base64_decode($_GET['id']);

	$database 	= new DBconnection($dbConfig);
	$task 		= new Task($database);

	//set the task id
	$task->setTaskId($id);

	// delete the task from the database
	$count = $task->deleteTask();

	if($count > 0) {
		Header("Location: index.php?del_success=1");
		exit;
	}



?>