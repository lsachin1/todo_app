<?php

include '/Applications/MAMP/htdocs/todo_app/modals/tasks.php';

class testtasksTest extends PHPUnit_Framework_TestCase {

	/** Database handle **/
	private $dbConn;
	
	/** Database config properties **/
	private $dbConfig;

	/** Reminder class object **/
	private $tasks;

	public function __construct(){
		$this->dbConn = $this->getPDOConnection();
		$this->tasks = new Task($this->dbConn);
	}

	/** get PDO connection object **/
	private function getPDOConnection(){

		include '/Applications/MAMP/htdocs/todo_app/common/config.php';

		$this->dbConfig = $dbTestConfig;

		$dsn = $this->dbConfig['driver'].":host=".$this->dbConfig['newHost'].";dbname=".$this->dbConfig['dbname'];

		return new PDO( $dsn, $this->dbConfig['username'], $this->dbConfig['password'],  $this->_config[ 'options' ]);
	}

	/** Test the code with Non blank Title Value **/
	public function testvaliadateTitlewithNonBlank(){

		$this->tasks->setTitle("test");
		$expected = true;
		$this->assertEquals($expected, $this->tasks->validateTitle());
	}

	/** Test the code with Non blank Title Value **/
	public function testvaliadateTitlewithBlank(){

		$this->tasks->setTitle("");
		$expected = false;
		$this->assertEquals($expected, $this->tasks->validateTitle());
	}

	/** Test the code with Non blank Title Value **/
	public function testvaliadateCompleationDatewithNonBlank(){

		$this->tasks->setCompleationDate("2019-06-11 00:00");
		$expected = true;
		$this->assertEquals($expected, $this->tasks->validateCompleationDate());

		$this->tasks->setCompleationDate("2019-06-11 17:00");
		$expected = true;
		$this->assertEquals($expected, $this->tasks->validateCompleationDate());
	}

	/** Test the code with Non blank Title Value **/
	public function testvaliadateCompleationDatewithValidValue(){

		$this->tasks->setCompleationDate("2019-06-11 00:00");
		$expected = true;
		$this->assertEquals($expected, $this->tasks->validateCompleationDate());
	}

	/** Test the code with Non blank Title Value **/
	public function testvaliadateCompleationDatewithInvalidValue(){

		$this->tasks->setCompleationDate("2019-06-11 00");
		$expected = false;
		$this->assertEquals($expected, $this->tasks->validateCompleationDate());
	}

	/** Test the code with Non blank Title Value **/
	public function testvaliadateAddTaskWithAllInput(){

		$this->tasks->setCompleationDate("2019-06-11 00:00");
		$this->tasks->setTitle("XYZ".mt_rand());
		$this->tasks->setDescription("XYZZZ".mt_rand());

		$expected = 1;
		$affectedRows = 0;

		if($this->tasks->validateTitle() === true){
			$sql = $this->tasks->getInsertQuery();
			$affectedRows = $this->dbConn->exec($sql);
		}
		
		$this->assertEquals($expected, $affectedRows);
	}

	/** Test the code with Non blank Title Value **/
	public function testvaliadateAddTaskWithwithoutTitle(){

		$this->tasks->setCompleationDate("2019-06-11 00:00");
		$this->tasks->setDescription("XYZZZ".mt_rand());

		$expected = 0;
		$affectedRows = 0;

		if($this->tasks->validateTitle() === true){
			$sql = $this->tasks->getInsertQuery();
			$affectedRows = $this->dbConn->exec($sql);
		}
		
		$this->assertEquals($expected, $affectedRows);
	}

	/** Test the code with Non blank Title Value **/
	public function testvaliadateUpdateTaskWithAllInput(){

		// get the latest id from the database
		$query = $this->tasks->getFirstTask();
		$stmt  = $this->dbConn->query($query);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
		  $id 			= $row[0];
		  $title 		= $row[1];
		  $description 	= $row[2];
		  $createdAt	= $row[3];
		}
		
		// set the new title for the latest id 
		// update it in the DB for that id
		// if affected row is 1 then update is successfull.

		$this->tasks->setTaskId($id);
		$this->tasks->setTitle("update_".mt_rand());
		$this->tasks->setCompleationDate("2019-06-11 00:00");
		$this->tasks->setDescription("XYZZZ".mt_rand());
		$sql = $this->tasks->getUpdateQuery();

		$expected = 1;
		$affectedRows = $this->dbConn->exec($sql);
		$this->assertEquals($expected, $affectedRows);
	}

	/** Test the code to delete query **/
	public function testvaliadateDeleteTask(){

		// get the latest id from the database
		$query = $this->tasks->getFirstTask();
		$stmt  = $this->dbConn->query($query);
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
		  $id 			= $row[0];
		  $title 		= $row[1];
		  $description 	= $row[2];
		  $createdAt	= $row[3];
		}

		$this->tasks->setTaskId($id);
		$sql = $this->tasks->getDeleteTaskQuery();
		$expected = 1;
		$affectedRows = $this->dbConn->exec($sql);
		$this->assertEquals($expected, $affectedRows);

	}

	/** public function to test select query for tasks list **/
	public function testvalidateTasksList(){

		$sql = $this->tasks->getFetchAllTasksQuery();
		$tasksArr = [];
		$rows = $this->dbConn->query($sql);
		while ($row = $rows->fetch()) {
	    	array_push($tasksArr, $row);
		}

		$expected = true;
		$more_rows = false;
		
		if(count($tasksArr) > 0) $more_rows = true;

		$this->assertEquals($expected, $more_rows);

	}

}

?>