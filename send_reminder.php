<?php
	
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/DBConnection.php"; 
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/modals/reminder.php";

	//fetched the reminder id, time and send_to option
	$rmd_id 		= base64_decode($_POST["rmd_id"]);
	$currentDate 	= date("Y-m-d");
	$currentTime 	= date("H:i");

	//create reminder class object and get it's title, rmd_time and title which we will require to send an email
	$database 	= new DBconnection($dbConfig);
	$reminder 	= new Reminder($database);

	//set the reminder id
	$reminder->setReminderId($rmd_id);

	$reminderArr = $reminder->getReminderDetailById();

	// get the current timestamp
	$str_current_time 	= strtotime($currentDate . $currentTime);

	//get the beginning of reminder set time and ending of reminder set time
	$str_rmd_time_beg	= strtotime(explode(" ", $reminderArr[0]['rmd_time'])[0]." 00:00:00");
	$str_rmd_time_end	= strtotime(explode(" ", $reminderArr[0]['rmd_time'])[0]." 23:59:00");

	//will check if current date and time falls between the reminded date and time then will send reminder
	// otherwise will not send the reminder
	if(($str_rmd_time_beg <= $str_current_time) && ($str_current_time <= $str_rmd_time_end)){

		$subject = "Reminder Alert for the task ".$reminderArr[0]['title'];

		$body = "<html> <body>
			Please complete your Task <b>".$reminderArr[0]['title']."</b> by ".date_format(date_create($reminderArr[0]['rmd_time']), "M dS y g:i a"). "
			</body></html>";

		$to_email = $reminderArr[0]['send_reminder_to'];

		$from_email = "Noreply@company.com";

		// To send HTML mail, the Content-type header must be set
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';

		// Additional headers
		$headers[] = 'To: '.$to_email;
		$headers[] = 'From: Task Reminder <task@example.com>';
		$headers[] = 'Cc: taskarchive@example.com';
		$headers[] = 'Bcc: taskcheck@example.com';

		if(@mail($to_email, $subject, $body, implode("\r\n", $headers))){
			echo "Reminder Email Sent";
		}else{
			echo "Reminder Email didn't Sent. Please check to email address";
		}

		
	}else{
		echo "don't send reminder";
	}
?>