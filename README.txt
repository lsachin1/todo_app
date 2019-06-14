
# ToDO List

1. ToDO List is a PHP mini web application used to ADD/EDIT/DELETE/VIEW tasks 
2. User can set the reminder for individual task from the task list
3. User can view the reminder list set for particular task by clicking on the task name
4. In that reminder list, user can click on "Send Reminder" link to send the email in his/her mailbox

Installation
-----------------------------------------------------------------------------------------------------------------------------------------

1. Install XAMPP or WAMP OR MAMP to install php, mysql, Apache/Nginx locally
2. This application has been developed using PHP 7.3.1
3. You can view the database at http://localhost/phpmyadmin
4. Install PHPUnit for unit testing, install using composer
	4.1 Visit https://getcomposer.org/download/ (follow the instruction)
	4.2 created composer.json file
	4.3 save the composer.json with following code
			{
			    "require": {
			        "php": ">=5.3.2"
			    },
			    "require-dev": {
			    	"phpunit/phpunit": "3.7.*"
			    }
			}
	 4.4 php composer.phar install

-----------------------------------------------------------------------------------------------------------------------------------------

Database Design:

This application has 2 tables and database name is todo_app

1. tasks table : This table stores the tasks details such as title (mandatory) , description (optional), completion_date (optional) and createdAt and updatedAt columns
2. reminder table: This table stores the remninder set for partcular task. It has title (mandatory), send_reminder_to field which will store the email address and type field bydefault set to 'email' and reminder time along with createdAt and updatedAt

CREATE DATABASE `todo_app` /*!40100 DEFAULT CHARACTER SET utf8 


CREATE TABLE `tasks` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(100) NOT NULL,
 `description` varchar(255) NOT NULL,
 `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `completion_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `createdAt` (`createdAt`),
 FULLTEXT KEY `title` (`title`,`description`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8

CREATE TABLE `reminder` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(100) NOT NULL,
 `task_id` int(11) NOT NULL,
 `send_reminder_to` varchar(30) NOT NULL,
 `type` enum('email','phone','fax','') NOT NULL DEFAULT 'email',
 `rmd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `task_id` (`task_id`),
 KEY `type` (`type`),
 KEY `createdAt` (`createdAt`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8

We have to also create test database

CREATE DATABASE `test_todo_app` /*!40100 DEFAULT CHARACTER SET utf8 


CREATE TABLE `tasks` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(100) NOT NULL,
 `description` varchar(255) NOT NULL,
 `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `completion_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `createdAt` (`createdAt`),
 FULLTEXT KEY `title` (`title`,`description`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8

CREATE TABLE `reminder` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(100) NOT NULL,
 `task_id` int(11) NOT NULL,
 `send_reminder_to` varchar(30) NOT NULL,
 `type` enum('email','phone','fax','') NOT NULL DEFAULT 'email',
 `rmd_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `task_id` (`task_id`),
 KEY `type` (`type`),
 KEY `createdAt` (`createdAt`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8

------------------------------------------------------------------------------------------------------------------------------------------

Unit Testing

This application uses the PHPUnit as tool to implement the unit test cases

please run the unit test cases by using following command

1. cd to /Applications/MAMP/htdocs/todo_app/vendor
2. run the command bin/phpunit <DOCUMENT_ROOT>/tests/todo_app/createTests.php
in my case it will be /Applications/MAMP/htdocs/todo_app

There are two files
bin/phpunit /Applications/MAMP/htdocs/todo_app/tests/todo_app/reminderTest.php
bin/phpunit /Applications/MAMP/htdocs/todo_app/tests/todo_app/tasksTest.php

-------------------------------------------------------------------------------------------------------------------------------------------

