<?php

	class Reminder {

		// database connection and table name
	    private $conn;
	    private $table_name = "reminder";

	    // object properties
	    private $title;
	    private $description;
	    private $send_reminder_to;
	    private $remindar_type;
	    private $reminder_time;
	    private $taskId = 0;
	    private $reminderId = 0;
	    private $mode;
	    private $valid_email = false;

	    public function __construct($db){
        	$this->conn = $db;
    	}

    	// This function escapes sigle quote character, removes HTML tags and special characters from the user data
	    public function sanitizeInputData($data){
	    	return htmlspecialchars(strip_tags(addslashes($data))); 
	    }

    	//Set the mode 
	    // Add task or Edit task
	    public function setMode($mode){
	    	$this->mode = $mode;
	    }

	    //Get the mode 
	    // Add task or Edit task
	    public function getMode($mode){
	    	return $this->mode;
	    }

	    //set task id
	    public function setTaskId($id){
	    	$this->taskId = $id;
	    }

	    //get task id
	    public function getTaskId($id){
	    	return $this->taskId;
	    }

	    //set remider id
	    public function setReminderId($id){
	    	$this->reminderId = $id;
	    }

	    //get remider id
	    public function getReminderId($id){
	    	return $this->reminderId;
	    }

	    //Set the task title
	    public function setTitle($title){
	    	$this->title = $title;
	    }

	    //Get the task title
	    public function getTitle($title){
	    	return $this->title;
	    }

	    //Set the task set send reminder to
	    public function setReminderTo($send_reminder_to){
	    	$this->send_reminder_to = $send_reminder_to;
	    }

	    //Get the task set send reminder to
	    public function getReminderTo($send_reminder_to){
	    	return $this->send_reminder_to;
	    }

	    //Set the task set send reminder type
	    public function setReminderType($remindar_type){
	    	$this->remindar_type = $remindar_type;
	    }

	    //Get the task set send reminder type
	    public function getReminderType($remindar_type){
	    	return $this->remindar_type;
	    }

	    //Set the task set send reminder time
	    public function setReminderTime($reminder_time){
	    	$this->reminder_time = $reminder_time;
	    }

	    //validate the set reminder form
	    public function validate(){
	    	if($this->validateTitle() === false || 
	    	   $this->validateReminderTo() === false || 
	    	   $this->validateReminderTime() === false){
	    		return "false";
	    	}else{
	    		return "true";
	    	}
	    }

	    //validate title
	    public function validateTitle(){
	    	if($this->title === "") return false;
	    	return true;
	    }

	    //validate if email id valid or not
	    public function validateReminderTo(){
	    	if($this->validateEmail() === false) return false;
	    	return true;
	    }

	    //validate the reminderTime is in correct format or not.
	    public function validateReminderTime(){
	    	if($this->reminder_time === "") return false;
	    	else if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (?:[01]\d|2[0123]):(?:[012345]\d)$/",$this->reminder_time)) return false;
	    	
	    	return true;
	    }

	    //validate if email is in correct format or not
	    public function validateEmail(){

	    	if(!filter_var($this->send_reminder_to, FILTER_VALIDATE_EMAIL) && $this->remindar_type === 'email'){
	    		$this->valid_email = false;
	    		return false;
	    	}
	    	return true;
	    }

	    // function return the INSERT SQL
	    public function createSQL() {

	    	$sql = "
				INSERT INTO
				".$this->table_name." (
					title,
					task_id,
					send_reminder_to,
					type,
					rmd_time
				)
				VALUES (
					'".$this->sanitizeInputData($this->title)."',
					'".$this->sanitizeInputData(base64_decode($this->taskId))."',
					'".$this->sanitizeInputData($this->send_reminder_to)."',
					'".$this->sanitizeInputData($this->remindar_type)."',
					'".$this->sanitizeInputData($this->reminder_time)."'
				)
			";

			return $sql;
	    }

	    //function insert new task in tasks table
	    public function create(){

	    	$sql = $this->createSQL();

	    	$numberOfRowsAffected = $this->conn->runQuery($sql);
	 
	        return $numberOfRowsAffected;
	    }

	    //generate sql to fetch reminder detail to fetch set reminder by reminder ID
	    public function getRemiderSql(){
	    	return $sql = " SELECT id, title, rmd_time, send_reminder_to FROM ".$this->table_name." WHERE id=".$this->reminderId;
		}

	    // function return the array for the required reminder.
	    public function getReminderDetailById(){
	    	$sql = $this->getRemiderSql();
	    	$reminderArr = [];
			$rows = $this->conn->getQuery($sql);
			while ($row = $rows->fetch()) {
		    	array_push($reminderArr, $row);
			}
			return $reminderArr;
	    }

	    //generate sql to fetch all the reminder by taskId
	    function getAllRemiderSql(){
	    	return $sql = " SELECT id, title, rmd_time, send_reminder_to FROM ".$this->table_name." WHERE task_id=".$this->taskId." ORDER BY id DESC";
	    }

	    //get the all reminder list for particluar taskId
	    public function getAllReminder(){
	    	$sql = $this->getAllRemiderSql();
	    	$reminderArr = [];
			$rows = $this->conn->getQuery($sql);
			while ($row = $rows->fetch()) {
		    	array_push($reminderArr, $row);
			}
			return $reminderArr;
	    }


	}
?>