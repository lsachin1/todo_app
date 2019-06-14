<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/templates/header.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/controllers/tasks.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/controllers/edittasks.php";

?>
<div class="mainContainer">
	<form method="POST">
			<div class="taskAddContainer">
					<?php
					
						// displays the error message
						if($error_msg){ ?>

							<div class="errorMessage">
								<?php echo $error_msg; ?>
							</div>
							
					<?php } ?>

					<div class="titleContainer">
						<input type="text" name="title" class="title" id="tskTitle" maxlength="100" placeholder="enter title here" value="<?php echo $taskDeails['title']?>">
					</div>
					<div class="descriptionContainer">
						<textarea rows="5" cols="90" name="description" class="description" id="tskDesc" placeholder="enter description here">
							<?php echo $taskDeails['description'] ?>
						</textarea>
					</div>
					<div class="DateContainer">
						<label for="datepicker">Completion Date:</label> <input type="text" id="datepicker" name="completion_date" value="<?php echo substr($taskDeails['completion_date'], 0, -3) ?>"/>
					</div>
					
					<div class="handler">
						<input type="hidden" name="edit_id" id="edit_id" value="<?php echo base64_decode($_GET['id']); ?>">
						<input type="Submit" name="Submit" value="<?php echo $buttonValue; ?>" class="addTask" id="tskSubmit">
					</div>
			</div>
	</form>
</div>

<?php require_once("templates/footer.php"); ?>