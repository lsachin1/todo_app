<?php
	
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/DBConnection.php"; 
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/modals/reminder.php";

	// set the Reminder class object
	$database 	= new DBconnection($dbConfig);
	$reminder 	= new Reminder($database);

	// get the task id for which we have to fetch reminder 
	$task_id 	= base64_decode($_GET['id']);

	//Below code will fetch all the reminder from the reminder table
	if($task_id > 0){
		$reminder->setTaskId($task_id);
		$reminderArr = $reminder->getAllReminder();
	}
?>