<?php

include '/Applications/MAMP/htdocs/todo_app/modals/reminder.php';

class testreminderTest extends PHPUnit_Framework_TestCase {

	/** Database handle **/
	private $dbConn;
	
	/** Database config properties **/
	private $dbConfig;

	/** Reminder class object **/
	private $reminder;

	public function __construct(){
		$this->dbConn = $this->getPDOConnection();
		$this->reminder = new Reminder($this->dbConn);
	}

	/** get PDO connection object **/
	private function getPDOConnection(){

		include '/Applications/MAMP/htdocs/todo_app/common/config.php';

		$this->dbConfig = $dbTestConfig;

		$dsn = $this->dbConfig['driver'].":host=".$this->dbConfig['newHost'].";dbname=".$this->dbConfig['dbname'];

		return new PDO( $dsn, $this->dbConfig['username'], $this->dbConfig['password'],  $this->_config[ 'options' ]);
	}

	public function testValidateEmailAddressWithCorrectAddress(){

		$expected = true;
		$this->reminder->setReminderTo("contactsachinl@gmail.com");
		$this->reminder->setReminderType("email");

		$this->assertEquals($expected, $this->reminder->validateEmail());
	}

	public function testValidateEmailAddresswithWrongAddress(){

		$expected = false;
		$this->reminder->setReminderTo("contactsachinl@gmail");
		$this->reminder->setReminderType("email");

		$this->assertEquals($expected, $this->reminder->validateEmail());
	}


	public function testValidateTitleforNonBlank(){

		$expected = true;
		$this->reminder->setTitle("test");

		$this->assertEquals($expected, $this->reminder->validateTitle());
	}

	public function testValidateTitleforBlank(){

		$reminder 	= new Reminder($this->dbConn);

		$expected = false;
		$this->reminder->setTitle("");

		$this->assertEquals($expected, $this->reminder->validateTitle());
	}

	public function testValidateReminderTimeforNonBlank(){

		$expected = true;
		$this->reminder->setReminderTime("2019-06-23 00:00");

		$this->assertEquals($expected, $this->reminder->validateReminderTime());

		$this->reminder->setReminderTime("2019-06-23 17:00");

		$this->assertEquals($expected, $this->reminder->validateReminderTime());
	}

	public function testValidateReminderTimeforBlank(){

		$expected = false;
		$this->reminder->setReminderTime("");

		$this->assertEquals($expected, $this->reminder->validateReminderTime());
	}
	
	public function testValidateInsertintoReminder() {

		$this->reminder->setTaskId(base64_encode(2));
	    $this->reminder->setTitle("testxxxYYYYYYYY");
	    $this->reminder->setDescription("test");
	    $this->reminder->setReminderTo("contactsachinl@gmail.com");
	    $this->reminder->setReminderType("email");
	    $this->reminder->setReminderTime("2019-10-11 00:00");

		$expected = 1;
		$sql = $this->reminder->createSQL();
		$affectedRows = $this->dbConn->exec($sql);

		$this->assertEquals($expected, $affectedRows);

	}
}

?>