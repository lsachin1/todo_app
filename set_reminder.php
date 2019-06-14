<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/todo_app/templates/header.php";

	$task_id = $_GET['id'];

?>
<style>
	.setupReminder div {
		padding: 10px;
	}
	#errorMessage {
		display:none;
		color: red;
	}
	#successMessage {
		display:none;
		color: black;
	}

</style>
<script>
	//validate the set reminder form
	function validate(){
		var title 				= $("#remindar_title").val();
		var send_reminder_to 	= $("#send_remindar_to").val();
		var reminder_time		= $("#datepicker").val();
		var task_id				= $("#task_id").val();
		//var remindar_type		= $("input[name='remindar_type']:checked"). val();
		var remindar_type		= "email";

		if( title === "" ||  send_reminder_to === "" ||  reminder_time === ""){
			$("#errorMessage").text("Please fill title, set time and send remindar to");
			$("#errorMessage").show();
			return false;
		}else{
			$("#errorMessage").hide();
		}

		if(remindar_type == "email" && send_reminder_to != ""){
				let regularExp = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
				if(!regularExp.test(send_reminder_to)){
					$("#errorMessage").text("Please enter valid email address");
					$("#errorMessage").show();
					return false;
				}else{
				$("#errorMessage").hide();
			}
		}

		if(remindar_type == "phone" && send_reminder_to != ""){
			let regularExp = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
			if(!regularExp.test(send_reminder_to)){
					$("#errorMessage").text("Please enter valid phone number");
					$("#errorMessage").show();
					return false;
			}else{
				$("#errorMessage").hide();
			}
		}

		// makes an ajax call to set the reminder
		// send the data through the POST data
		$.ajax({
			url: "reminder.php",
			method: "POST",
			data:{
				id:task_id,
				title:title,
				send_reminder_to:send_reminder_to,
				reminder_time: reminder_time,
				remindar_type: remindar_type
			},
			success: function(data){
				if(data == "success" || data == "1success") {
					$("#successMessage").text("Reminder has been set successfully");
					$("#successMessage").show();
					$("#errorMessage").hide();
				}else if(data == "fail"){
					$("#successMessage").text("Reminder has not been set successfully");
					$("#successMessage").show();
					$("#errorMessage").hide();
				}else if(data == "error"){
					$("#errorMessage").text("Please fill title, set time and send remindar to");
					$("#errorMessage").show();
				}
			},
			error:function(error){
				$("#errorMessage").text(error);
				$("#errorMessage").show()
			}
		});
		return false;
	}
</script>
<div class="setupReminder">
	<div id="errorMessage"></div>
	<div id="successMessage"></div>
	<form action="set_reminder.php" method="POST" onsubmit="return validate();">
		<div>Remindar Title : <input type="text" namw="remindar_title" id="remindar_title"></div>
		<!--<div>
			Send Remindar By: 
				<input type="radio" name="remindar_type" value="email" checked> Email
				<input type="radio" name="remindar_type" value="phone"> Phone
		</div>-->
		<div>
			Send Remindar By: Email
		</div>
		<div>
			Send Reminder to: <input type="text" name="send_remindar_to" id="send_remindar_to"><br>
			e.g. (US phone number)

		</div>
		<div>Set Date and Time: <input type="text" id="datepicker" name="completion_date" /></div>
		<div>
			<input type="Submit" name="Submit" value="Send Remindar">
		</div>
		<input type="hidden" name="task_id" id="task_id" value="<?php echo $task_id ?>">
	</form>
</div>

<?php require_once("templates/footer.php"); ?>