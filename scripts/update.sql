
USE degreepath;


DROP TABLE IF EXISTS users;

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

DROP TABLE IF EXISTS user_semesters;

CREATE TABLE user_semesters (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user_id int(10) NOT NULL,
  term_code int(10) NOT NULL,
  PRIMARY KEY (id) 
);

DROP TABLE IF EXISTS user_subjects;

CREATE TABLE user_subjects (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user_id int(10) NOT NULL,
  subject varchar(255) NOT NULL,
  PRIMARY KEY (id)
);
