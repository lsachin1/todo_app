<?php

require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/DBConnection.php"; 
require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/modals/tasks.php";

$buttonValue = "Add Task";

// Handles Add task
if($_POST['Submit'] === "Add Task" && $_POST['edit_id'] === ""){
	
	$database 	= new DBconnection($dbConfig);
	$task 		= new Task($database);

	// set mode
	$task->setMode("add");

	// set tasks property values
    $task->setTitle($_POST['title']);
    $task->setDescription($_POST['description']);
    $task->setCompleationDate($_POST['completion_date']);
    
    // validate the add task form and if no error
    // will call create() function to insert the data into DB
    if($task->validateTitle() == false){
    	$error_msg = "Title is missing";
    } else if($task->validateCompleationDate() == false){
    	$error_msg = "Please enter correct completion date";
    } else {
	    $numberOfRowsAffected 	= $task->create();

	    if($numberOfRowsAffected > 0 ){
			Header("Location: index.php?ins_success=1");
			exit;
        }else{
			Header("Location: index.php??ins_success=0");
			exit;
        }
    }

}

?>