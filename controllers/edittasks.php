<?php

require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/DBConnection.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/modals/tasks.php";


// Handles Edit task
if($_POST['edit_id'] != ''){ 

	$buttonValue = "Edit Task";
		
	if($_POST['title'] == "") $error_msg = "Title is missing";
	else{

		$database 	= new DBconnection($dbConfig);
		$task 		= new Task($database);

		// set mode
		$task->setMode("edit");

		// set product property values
		$task->setTaskId($_POST['edit_id']);
	    $task->setTitle($_POST['title']);
	    $task->setDescription($_POST['description']);
	    $task->setCompleationDate($_POST['completion_date']);

	    // edit the data and saves in the DB
	    $numberOfRowsAffected 	= $task->edit();

	    // redireact the user to index page
	    if($numberOfRowsUpdated > 0){
			Header("Location: index.php?upd_success=1");
			exit;
		}else{
			Header("Location: index.php?upd_success=0");
			exit;
		}
	}
}

//fetches the tasks details which we want to edit
if($_GET['id'] != ''){

		$buttonValue = "Edit Task";

		$database 	= new DBconnection($dbConfig);
		$task 		= new Task($database);

		// set mode
		$task->setMode("fetch");

		// set product property values
		$task->setTaskId(base64_decode($_GET['id']));

		// fetch edit task details
		$taskDeails = $task->fetchTaskDetails();

	}
?>