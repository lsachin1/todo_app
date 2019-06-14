<?php

	class Task {
		// database connection and table name
	    private $conn;
	    private $table_name = "tasks";
	    private $reminder_table_name = "reminder";

	    // object properties
	    private $title;
	    private $description;
	    private $completion_date;
	    private $mode;
	    private $taskId = 0;

	    public function __construct($db){
        	$this->conn = $db;
    	}

    	//Set the mode 
	    // Add task or Edit task
	    public function setMode($mode){
	    	$this->mode = $mode;
	    }

	    // get mode
	    public function getMode(){
	    	return $this->mode;
	    }

	    // set task id
	    public function setTaskId($id){
	    	$this->taskId = $id;
	    }

	    // get task id
	    public function getTaskId($id){
	    	return $this->taskId;
	    }

	    //Set the task title
	    public function setTitle($title){
	    	$this->title = $title;
	    }

	    //Get the task title
	    public function getTitle($title){
	    	return $this->title;
	    }

	    //Set the task description
	    public function setDescription($description){
	    	$this->description = $description;
	    }

	    //Get the task description
	    public function getDescription($description){
	    	return $this->description;
	    }

	    //Set the task setCompleationDate
	    public function setCompleationDate($completion_date){
	    	$this->completion_date = $completion_date;
	    }

	    //Get the task setCompleationDate
	    public function getCompleationDate($completion_date){
	    	return $this->completion_date;
	    }

	    // This function escapes sigle quote character, removes HTML tags and special characters from the user data
	    public function sanitizeInputData($data){
	    	return htmlspecialchars(strip_tags(addslashes($data))); 
	    }

	    //check if title is blank or not
	    public function validateTitle() {
	    	if($this->title == "") return false;
	    	else return true;
	    }

	    // function to validate the tasks completion date
	    public function validateCompleationDate(){
	    	if($this->completion_date != ""){
	    		if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (?:[01]\d|2[0123]):(?:[012345]\d)$/", $this->completion_date)) return false;
	    		return true;
	    	}
	    	return true;
	    }

	    //get first tasks from the tasks table 
	    public function getFirstTask(){
	    	$query = " SELECT id, title, description, createdAt FROM " . $this->table_name . " ORDER by id DESC LIMIT 0, 1";
			return $query;
	    }

	    //get the query to fetch all tasks
	    public function getFetchAllTasksQuery(){

	    	$query = " SELECT id, title, description, createdAt FROM " . $this->table_name . " ORDER by id DESC ";

    		return $query;
	    }

    	// fetch all the tasks
    	function fetchAllTasks(){

    		$query = $this->getFetchAllTasksQuery();

    		$tasksArr = [];
			$rows = $this->conn->getQuery($query);
			while ($row = $rows->fetch()) {
		    	array_push($tasksArr, $row);
			}
			return $tasksArr;

    	}

    	//get query to fetch task detail which we want to edit
    	public function getTaskDetailsQuery() {
    		
    		$sql = "
    			SELECT
					title,
					description,
					completion_date
				FROM
					" . $this->table_name . "
				WHERE
					id=".$this->sanitizeInputData($this->taskId);

			return $sql;
    	}

    	//fetch editable task details
    	public function fetchTaskDetails(){

    		$sql = $this->getTaskDetailsQuery();

			$rows = $this->conn->getQuery($sql);

			return $rows->fetch();
		}

		// get update query
		function getUpdateQuery(){

			$updatedAt = date("Y-m-d H:i:s");

    		$sql = "
				UPDATE 
					" . $this->table_name . "
				SET 
					title 			='".$this->sanitizeInputData($this->title)."',
					description 	= '".$this->sanitizeInputData($this->description)."',
					completion_date = '".$this->sanitizeInputData($this->completion_date)."',
					updatedAt 		= '".$this->sanitizeInputData($updatedAt)."'
				WHERE
					id=".$this->taskId;

			return $sql;
		}

    	//edit task
    	public function edit(){

    		$sql = $this->getUpdateQuery();

			$numberOfRowsAffected = $this->conn->runQuery($sql);
	 
	        return $numberOfRowsAffected;
    	}

    	//write query
    	function getInsertQuery(){

    		if($this->completion_date != "") {
				$completion_date = $this->completion_date.":00";
				$column = ',completion_date';
				$columnValue = ",'".$this->sanitizeInputData($this->completion_date)."'";
			}

    		$query = "
	        	INSERT INTO
	               " . $this->table_name . "
	            (
                	title,
                	description
                	".$column."
	            )
                VALUES (
                	'".$this->sanitizeInputData($this->title)."',
                	'".$this->sanitizeInputData($this->description)."'
                	".$columnValue."
                )";

            return $query;
    	}

    	// create task
    	public function create(){
	 		
			$query = $this->getInsertQuery();
	        
	        $numberOfRowsAffected = $this->conn->runQuery($query);

	        return $numberOfRowsAffected;
 		}

 		//get the delete query for task
 		public function getDeleteTaskQuery(){
 			$sql = " DELETE FROM " . $this->table_name . " WHERE id=".$this->sanitizeInputData($this->taskId);
 			return $sql;
 		}

 		//get the delete query for task
 		public function getDeleteReminderTaskQuery(){
 			$sql_reminder = " DELETE FROM ".$this->reminder_table_name." WHERE task_id=".$this->sanitizeInputData($this->taskId);
 			return $sql_reminder;
 		}

 		//delete tasks
 		// first delete the task from tasks table
 		// if there are any reminder set for particlualr task
 		// then those reminder will also get deleted.
 		public function deleteTask(){

 			$sql = $this->getDeleteTaskQuery();

 			$sql_reminder = $this->getDeleteReminderTaskQuery(); 

 			$this->conn->runQuery($sql_reminder);

 			$count = $this->conn->runQuery($sql);

 			return $count;
 		}
	}	
?>