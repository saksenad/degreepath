DROP DATABASE IF EXISTS degreepath;

CREATE DATABASE degreepath;
USE degreepath;

CREATE TABLE `courses` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `subject` varchar(255) NOT NULL,
 `course_number` varchar(255) NOT NULL,
 `name` varchar(255) NOT NULL,
 `GPA` float NOT NULL,
 `Temp_CRN` INT NOT NULL,
 `PreReqs` varchar(1023) NOT NULL,
 PRIMARY KEY (`id`)
);

CREATE TABLE term_availability (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  term_code int(10) NOT NULL,
  course_id varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

/* 
* We don't need to have a separate id specifically for this table.
* the user_id serves as the primary key for the table. 
* Also, it is on user_id since we will be making requests for queries based on user_id
* in other words, the WHERE statement will contain user_id = ???
*/
CREATE TABLE user_semesters (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user_id int(10) NOT NULL,
  term_code int(10) NOT NULL,
  PRIMARY KEY (id) 
);

CREATE TABLE user_subjects (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user_id int(10) NOT NULL,
  subject varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

CREATE TABLE users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  first_name varchar(255),
  last_name varchar(255),
  major varchar(255), 
  minor varchar(255),
  matriculation int(10),
  username varchar(255),
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE enrollments (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  course_id int(10) unsigned NOT NULL,
  user_id int(10) NOT NULL,
  term_code varchar(255) NOT NULL,
  PRIMARY KEY (id)
);
