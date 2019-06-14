<?php

	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/DBConnection.php"; 
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/controllers/viewreminder.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/templates/header.php";
?>

	<div class="reminderListContainer">
			<h1>Reminder List </h1>
			<div class="reminderList heading">
				<div class='clsTitle'>Title</div>
				<div class='clsReminderBy'>Reminder By</div>
				<div class='clsTime'>Time</div>
				<div class='clsSendReminder'>Send Reminder</div>
			</div>
			<?php

				/** 
					Below code loops over the array (reminderArr) and get the HTML from the external file and replace the identifier
					example: file_get_contents("templates/reminderList.html") i.e. fetches the template of the list reminder HTML
					and str_replace() function replace the identifier from the html into fetched values
					example %id% => 1
					%title% => 'test'
			    **/
				$reminderStr = "";
				if(count($reminderArr) > 0){					
					foreach($reminderArr as $val){

						$id 				= $val['id'];
						$title 				= $val['title'];
						$rmd_time 			= date_create($val['rmd_time']);
						$send_reminder_to	= $val['send_reminder_to'];
						$createdAt 			= date_create($val['createdAt']);
						
						// get the template of the HTML as string and store it in a $reminderListHtml variable
						$reminderListHtml = @file_get_contents("templates/reminderList.html");

						$reminderListHtml = str_replace("%id%", base64_encode($id), $reminderListHtml);
						$reminderListHtml = str_replace("%title%", htmlspecialchars($title), $reminderListHtml);
						$reminderListHtml = str_replace("%reminder_by%", htmlspecialchars($send_reminder_to), $reminderListHtml);
						$reminderListHtml = str_replace("%time%", date_format($rmd_time, "M dS y g:i a"), $reminderListHtml);
						$reminderListHtml = str_replace("%send_reminder%", "<a class='rmd' data-rmd-id='%id%' href='javascript:void(0)'>Send Reminder</a>", $reminderListHtml);
						$reminderListHtml = str_replace("%id%", base64_encode($id), $reminderListHtml);
						
						
						$reminderStr .= $reminderListHtml;

						
					}
				}else{
					$reminderStr .= "<div class='reminderList heading'>No Reminder Found, please  <a class='various fancybox.ajax' href='set_reminder.php?id=".base64_encode($task_id)."'>Set Reminder</a></div>";
				}

				echo $reminderStr;
			?>
	</div>

<?php

	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/templates/footer.php";
	

?>