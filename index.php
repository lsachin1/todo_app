<?php

	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/templates/header.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/common/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/controllers/gettasks.php";
?>

<div class="mainContainer">
	<div class="taskListContainer">
		<div class="addTaskTitle">
			<a href="/todo_app/create.php">Add Task</a>
		</div>

		<div class="statusMessage">
			<span>
				<?php
					// displays success message for add/edit/delete tasks
					if($_GET['ins_success'] == 1){
						echo "Task has been added successfully!!";
					}else if($_GET['upd_success'] == 1){
						echo "Task has been updated successfully!!";
					}else if($_GET['del_success'] == 1){
						echo "Task has been deleted successfully!!";
					}
				?>
			</span>
			<div class="taskList heading">
				<div class='clsTitle'>Title</div>
				<div class='clsDesc'>Description</div>
				<div class='clsDate'>Created At</div>
				<div class='clsEdit'>Edit</div>
				<div class='clsDelete'>Delete</div>
				<div class='clsDelete'>Set Reminder</div>
			</div>
		</div>
		<?php

			/** 
				Below code loops over the array (taskArr) and get the HTML from the external file and replace the identifier
				example: file_get_contents("templates/tasksList.html") i.e. fetches the template of the list tasks HTML
				and str_replace() function replace the identifier from the html into fetched values
				example %id% => 1
				%title% => 'test'
			 **/
			$tasksStr = "";
			if(count($tasksArr) > 0){
				foreach($tasksArr as $val){

					$id 			= $val['id'];
					$title 			= $val['title'];
					$description 	= $val['description'];
					$createdAt 		= date_create($val['createdAt']);

					// get the template of the HTML as string and store it in a $tasksListHtml variable
					$tasksListHtml = @file_get_contents($_SERVER['DOCUMENT_ROOT']."/todo_app/templates/tasksList.html");

					$tasksListHtml = str_replace("task_%id%", $id, $tasksListHtml);
					$tasksListHtml = str_replace("%title%", "<a href='view_reminder.php?id=".base64_encode($id)."'>".htmlspecialchars($title)."</a>", $tasksListHtml);
					$tasksListHtml = str_replace("%description%", htmlspecialchars($description), $tasksListHtml);
					$tasksListHtml = str_replace("%createdAt%", date_format($createdAt, "M dS y g:i a"), $tasksListHtml);
					$tasksListHtml = str_replace("%edit%", "<a href='/todo_app/create.php?id=".base64_encode($id)."'>Edit</a>", $tasksListHtml);
					$tasksListHtml = str_replace("%delete%", "<a href='/todo_app/delete.php?id=".base64_encode($id)."'>Delete</a>", $tasksListHtml);
					$tasksListHtml = str_replace("%send_reminder%", "<a class='various fancybox.ajax' href='set_reminder.php?id=".base64_encode($id)."'>Set Reminder</a>", $tasksListHtml);
					
					$tasksStr .= $tasksListHtml;

					
				}
			}else{
				$tasksStr .= "<div class='taskList heading'>No Tasks Found, please click <a href='/todo_app/create.php'>Add Task</a> to add new tasks</div>";
			}

			echo $tasksStr;
		?>
	</div>
	
</div>

<?php require_once("templates/footer.php"); ?>