
USE degreepath;

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
