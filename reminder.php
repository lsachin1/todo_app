<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/DBConnection.php"; 
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/modals/reminder.php";

	$database 	= new DBconnection($dbConfig);
	$reminder 	= new Reminder($database);

	// set mode
	$reminder->setMode("add");

	// set reminder property values assignment
	$reminder->setTaskId($_POST['id']);
    $reminder->setTitle($_POST['title']);
    $reminder->setReminderTo($_POST['send_reminder_to']);
    $reminder->setReminderType("email");
    $reminder->setReminderTime($_POST['reminder_time']);

    // Validate if all the forms fields are filled and valid
    if($reminder->validate() === "false"){
    	echo "error";
    }else{

    	// Insert the data into reminder table
	    $numberOfRowsAffected 	= $reminder->create();

	    if($numberOfRowsAffected > 0 ){
			echo "success";
		}else{
			echo "fail";
		}
	}

?>