
USE degreepath;


DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  first_name varchar(255),
  last_name varchar(255),
  major varchar(255), 
  minor varchar(255),
  matriculation varchar(255),
  username varchar(255),
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE user_semesters (
  user_id int(10) NOT NULL,
  term_code int(10) NOT NULL,
  PRIMARY KEY (user_id) 
);

CREATE TABLE user_subjects (
  user_id int(10) NOT NULL,
  subject varchar(255) NOT NULL,
  PRIMARY KEY (user_id)
)
