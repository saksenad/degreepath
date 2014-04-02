
USE degreepath;

ALTER TABLE enrollments
ADD PreReqSatisfied BOOL NOT NULL DEFAULT TRUE;

/*
DROP TABLE IF EXISTS user_semesters;

CREATE TABLE user_semesters (
  id int(10) NOT NULL AUTO_INCREMENT,
  user_id int(10) NOT NULL,
  term_code int(10) NOT NULL,
  PRIMARY KEY (user_id ASC, id ASC), 
  CONSTRAINT pk_constraint
  UNIQUE (id)
);

DROP TABLE IF EXISTS user_subjects;

CREATE TABLE user_subjects (
  id int(10) NOT NULL AUTO_INCREMENT,
  user_id int(10) NOT NULL,
  subject varchar(255) NOT NULL,
  PRIMARY KEY (user_id ASC, id ASC), 
  CONSTRAINT pk_constraint
  UNIQUE (id)
);

DROP TABLE IF EXISTS courses;

CREATE TABLE `courses` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `subject` varchar(255) NOT NULL,
 `course_number` varchar(255) NOT NULL,
 `name` varchar(255) NOT NULL,
 `GPA` float NOT NULL,
 `PreReqs` varchar(1023) NOT NULL,
 `Temp_CRN` int(11) NOT NULL,
 PRIMARY KEY (`id`)
);

*/

